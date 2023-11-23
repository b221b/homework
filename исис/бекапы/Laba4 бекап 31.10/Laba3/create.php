<?php
// Проверка наличия параметра
if (!isset($_GET['table'])) {
    header("Location: index.php");
    exit();
}

$table = $_GET['table'];

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "komercheskaya firma";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение информации о таблице
$result = $conn->query("DESCRIBE $table");
$fields = array();

while ($row = $result->fetch_assoc()) {
    $fields[] = $row['Field'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // получаем максимальное значение id
    $max_id = $conn->query("SELECT MAX(id) FROM $table")->fetch_row()[0];
    $max_id = is_null($max_id) ? 1 : $max_id + 1;  // Если таблица пустая, устанавливаем id = 1

    // Создание новой записи (insert)
    $insertQuery = "INSERT INTO $table (id, ";
    $values = "VALUES ($max_id, ";

    foreach ($fields as $field) {
        if (isset($_POST[$field]) && $field != "id") { // We should exclude id in insertion, as it's typically auto incremented
            $value = $conn->real_escape_string($_POST[$field]);
            $insertQuery .= "$field, ";
            $values .= "'$value', ";
        }
    }

    $insertQuery = rtrim($insertQuery, ", ") . ") ";
    $values = rtrim($values, ", ") . ");";
    $insertQuery .= $values;

    $conn->query($insertQuery);

    // Перенаправление на главную страницу
    header("Location: Laba3.php");
    exit();
}

// Форма добавления новой записи
echo "<h2>Добавить новую запись</h2>";
echo "<form action='' method='POST'>";

foreach ($fields as $field) {
    if ($field != "id") { // We should also exclude id from the form, as it's typically auto incremented
        echo "<label>{$field}:</label><br>";
        echo "<input type='text' name='{$field}'><br>";
    }
}

echo "<input type='submit' value='Добавить'>";
echo "</form>";

$conn->close();
?>
