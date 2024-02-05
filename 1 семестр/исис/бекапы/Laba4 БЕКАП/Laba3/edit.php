<?php
    // Проверка наличия параметров
    if (!isset($_GET['table']) || !isset($_GET['id'])) {
        header("Location: index.php");
        exit();
    }

    $table = $_GET['table'];
    $id = $_GET['id'];

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
        // Обновление записи таблицы (update)
        $updateQuery = "UPDATE $table SET ";
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $value = $_POST[$field];
                $updateQuery .= "$field = '$value', ";
            }
        }
        $updateQuery = rtrim($updateQuery, ", ");
        $updateQuery .= " WHERE id = $id";
        $conn->query($updateQuery);

        // Перенаправление на главную страницу
        header("Location: Laba3.php");
        exit();
    }

    // Получение данных записи для редактирования
    $selectQuery = "SELECT * FROM $table WHERE id = $id";
    $result = $conn->query($selectQuery);
    if ($result->num_rows != 1) {
        header("Location: index.php");
        exit();
    }

    $row = $result->fetch_assoc();

    // Форма редактирования записи таблицы (update)
    echo "<h2>Редактировать запись</h2>";
    echo "<form action='' method='POST'>";
    foreach ($fields as $field) {
        $value = $row[$field];
        echo "<label>{$field}:</label><br>";
        echo "<input type='text' name='{$field}' value='{$value}'><br>";
    }
    echo "<input type='submit' value='Сохранить'>";
    echo "</form>";

    $conn->close();
?>
