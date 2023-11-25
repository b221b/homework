<?php
if (!isset($_GET['table']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$table = $_GET['table'];
$id = $_GET['id'];

$editor = new TableEditor("localhost", "root", "", "komercheskaya firma3");
$editor->setTable($table);
$editor->setId($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $editor->updateRecord($_POST);
    $editor->closeConnection();
    header("Location: index.php");
    exit();
}

$data = $editor->fetchRecord();

echo "<h2>Редактировать запись</h2>";
echo "<form action='' method='POST'>";
$fields = $editor->getFields();
foreach ($fields as $field) {
    $value = $data[$field];
    echo "<label>{$field}:</label><br>";
    echo "<input type='text' name='{$field}' value='{$value}'><br>";
}
echo "<input type='submit' value='Сохранить'>";
echo "</form>";


class TableEditor {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "komercheskaya firma3";
    private $conn;
    private $table;
    private $id;
    private $fields = array();

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        $this->connect();
    }

    private function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Ошибка подключения: " . $this->conn->connect_error);
        }
    }

    public function setTable($table) {
        $this->table = $table;
        $this->fetchFields();
    }

    public function setId($id) {
        $this->id = $id;
    }

    private function fetchFields() {
        $result = $this->conn->query("DESCRIBE $this->table");
        while ($row = $result->fetch_assoc()) {
            $this->fields[] = $row['Field'];
        }
    }

    public function updateRecord($postData) {
        $updateQuery = "UPDATE $this->table SET ";
        foreach ($this->fields as $field) {
            if (isset($postData[$field])) {
                $value = mysqli_real_escape_string($this->conn, $postData[$field]);
                $updateQuery .= "$field = '$value', ";
            }
        }
        $updateQuery = rtrim($updateQuery, ", ");
        $updateQuery .= " WHERE id = $this->id";
        $this->conn->query($updateQuery);
    }

    public function fetchRecord() {
        $selectQuery = "SELECT * FROM $this->table WHERE id = $this->id";
        $result = $this->conn->query($selectQuery);

        if ($result->num_rows != 1) {
            header("Location: index.php");
            exit();
        }

        return $result->fetch_assoc();
    }

    public function closeConnection() {
        $this->conn->close();
    }

    public function getFields() {
        return $this->fields;
    }
}

$editor->closeConnection();


?>