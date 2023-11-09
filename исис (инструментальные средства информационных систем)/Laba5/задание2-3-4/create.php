<?php
// Проверка наличия параметра
if (!isset($_GET['table'])) {
    header("Location: index.php");
    exit();
}

$table = $_GET['table'];

class DBWrapper {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "komercheskaya firma3";
    private $conn;

    public function __construct() {
        // Подключение к базе данных
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Ошибка подключения: " . $this->conn->connect_error);
        }
    }

    public function get_fields($table) {
        // Получение информации о таблице
        $result = $this->conn->query("DESCRIBE $table");
        $fields = array();

        while ($row = $result->fetch_assoc()) {
            $fields[] = $row['Field'];
        }
        return $fields;
    }

    public function insert_record($table, $data) {
        // получаем максимальное значение id
        $max_id = $this->conn->query("SELECT MAX(id) FROM $table")->fetch_row()[0];
        $max_id = is_null($max_id) ? 1 : $max_id + 1;  

        // Создание новой записи (insert)
        $insertQuery = "INSERT INTO $table (id, ";
        $values = "VALUES ($max_id, ";

        foreach ($data as $field => $value) {
            if (array_key_exists($field, $data)) { 
                $value = $this->conn->real_escape_string($value);
                $insertQuery .= "$field, ";
                $values .= "'$value', ";
            }
        }

        $insertQuery = rtrim($insertQuery, ", ") . ") ";
        $values = rtrim($values, ", ") . ");";
        $insertQuery .= $values;

        $this->conn->query($insertQuery);
    }

    public function close() {
        $this->conn->close();
    }
}

$database = new DBWrapper();

$fields = $database->get_fields($table);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = array();

    foreach ($fields as $field) {
        if (isset($_POST[$field]) && $field != "id") { 
            $data[$field] = $_POST[$field];
        }
    }

    $database->insert_record($table, $data);

    // Перенаправление на главную страницу
    header("Location: index.php");
    exit();
}

// Форма для добавления новой записи
echo "<h2>Добавить новую запись</h2>";
echo "<form action='' method='POST'>";

foreach ($fields as $field) {
    if ($field != "id") { 
        echo "<label>{$field}:</label><br>";
        echo "<input type='text' name='{$field}'><br>";
    }
}

echo "<input type='submit' value='Добавить'>";
echo "</form>";

$database->close();

?>
