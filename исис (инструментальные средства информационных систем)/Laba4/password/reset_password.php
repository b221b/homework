<?php
// reset_password.php
require_once('db_connection.php'); // Подключение к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($connect, $_POST['email']);

    // Проверяем, существует ли пользователь с указанным email в базе данных
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        // Генерируем временный токен
        $token = bin2hex(random_bytes(8));

        // Обновляем токен в базе данных
        $updateQuery = "UPDATE users SET reset_token = '$token' WHERE email = '$email'";
        mysqli_query($connect, $updateQuery);

         ini_set("SMTP", "smtp.google.com");
         ini_set("smtp_port", 587);

        // Отправляем электронное письмо с ссылкой для сброса пароля
        $resetLink = "reset_password_form.php?token=$token";
        $subject = "Сброс пароля";
        $message = "Для сброса пароля перейдите по следующей ссылке: $resetLink";
        mail($email, $subject, $message);

        echo "Проверьте свою электронную почту для инструкций по сбросу пароля.";
    } else {
        echo "Пользователь с таким email не найден.";
    }
}
