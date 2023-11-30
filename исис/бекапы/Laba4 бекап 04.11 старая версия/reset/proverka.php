<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получите логин и email из формы
    $login = $_POST['login'];
    $email = $_POST['email'];

    // Подключитесь к базе данных (используйте свои данные для подключения)
    require_once 'db_connection.php';

    // Подготовьте SQL-запрос для поиска пользователя по логину и email
    $query = "SELECT * FROM users WHERE login = ? AND email = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $login, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Пользователь найден, перенаправляем на страницу сброса пароля
        header("Location: reset_password_form.php");
        exit();
    } else {
        // Пользователь не найден, выводим сообщение
        $_SESSION['message'] = "Такого пользователя не существует. Проверьте логин и email.";
        header("Location: proverka.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Проверка пользователя</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <h2>Проверка пользователя</h2>
    <form action="proverka.php" method="post">
        <label>Логин:</label>
        <input type="text" name="login" required>
        <br>
        <label>Email:</label>
        <input type="text" name="email" required>
        <br>
        <input type="submit" value="Проверить">
    </form>

    <?php
    if (isset($_SESSION['message'])) {
        echo '<p class="msg">' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }
    ?>
</body>
</html>