<?php
session_start();
require 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
    } else {
        echo "Неверное имя пользователя или пароль";
    }
}
?>

<form action="login.php" method="post">
    <label>Имя пользователя:</label>
    <input type="text" name="username" required><br>

    <label>Пароль:</label>
    <input type="password" name="password" required><br>

    <input type="submit" name="login" value="Войти">
</form>
