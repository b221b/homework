<?php

session_start();
include("db_connect.php");
$login = $_POST['login'];
$password = $_POST['password'];
$md5_password = md5($password);
$query = mysqli_query($db, "SELECT * FROM `users` WHERE `login`='{$login}' AND `password`='{$md5_password}'");
if (mysqli_num_rows($query) == 1) {
    $_SESSION['user'] = ['nick' => $login];
    header("Location: user.php");
} else {
    echo ("Ошибка: Данный логин или пароль неправильны.");
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($_POST['remember_me'])) {
        // Если чекбокс "Запомнить меня" был выбран, создаем куку, которая будет хранить данные авторизации
        $cookie_name = 'remember_me_cookie';
        $cookie_value = base64_encode($username . ':' . $password);
        $expiration = time() + 30 * 24 * 60 * 60; // Например, 30 дней

        setcookie($cookie_name, $cookie_value, $expiration, "/");
    }
    header('Location: user.php');
        exit();
    }
    ?>