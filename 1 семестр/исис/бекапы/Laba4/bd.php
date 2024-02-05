
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Komercheskaya firma2";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

?>