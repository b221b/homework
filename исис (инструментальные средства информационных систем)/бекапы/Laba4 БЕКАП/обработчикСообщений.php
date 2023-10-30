<link rel="stylesheet" href="assets/css/main.css">
<br><br><br><br><br><br>
<br><br><br><br><br><br>
<br><br>
<?php
// Подключение к базе данных
$servername = "localhost"; // Имя сервера базы данных
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль пользователя базы данных
$dbname = "komercheskaya firma2"; // Имя вашей базы данных

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка наличия ошибок при подключении
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Обработка отправленного комментария
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = $_POST["comment"];

    // Защита от SQL-инъекций
    $comment = mysqli_real_escape_string($conn, $comment);

    // SQL-запрос для обновления комментария в таблице "users"
    $sql = "UPDATE users SET comment = '$comment' WHERE id = 44"; // Здесь предполагается, что вы обновляете комментарий для пользователя с user_id = 1

    if ($conn->query($sql) === TRUE) {
        echo "Комментарий успешно сохранен.";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

// Закрытие соединения с базой данных
$conn->close();
?>
<br><br><br>
<a href="profile.php">Обратно на страницу профиля?</a>