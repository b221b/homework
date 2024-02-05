<?php
// update_password.php
require_once('db_connection.php'); // Подключение к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $token = mysqli_real_escape_string($connection, $_POST['token']);

    // Хешируем пароль (рекомендуется использовать более безопасные методы хеширования)
    $hashedPassword = md5($password);

    // Обновляем пароль в базе данных для пользователя с указанным токеном
    $query = "UPDATE users SET password = '$hashedPassword', reset_token = NULL WHERE reset_token = '$token'";
    mysqli_query($connection, $query);

    echo "Пароль успешно обновлен. Теперь вы можете войти с новым паролем.";
}
