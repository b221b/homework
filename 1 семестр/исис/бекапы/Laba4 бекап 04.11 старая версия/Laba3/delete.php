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

    // Удаление записи из таблицы (delete)
    $deleteQuery = "DELETE FROM $table WHERE id = $id";
    $conn->query($deleteQuery);

    // Перенаправление на главную страницу
    header("Location: Laba3.php");
    exit();

    $conn->close();
?>
