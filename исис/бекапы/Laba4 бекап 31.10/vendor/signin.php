<?php

    session_start();
    require_once 'connect.php';

    $login = $_POST['login'];
    $password = md5($_POST['password']);

    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
    if (mysqli_num_rows($check_user) > 0) {

        $user = mysqli_fetch_assoc($check_user);

        $_SESSION['user'] = [
            "id" => $user['id'],
            "login" => $user['login'],
            "role_id" => $user['role_id'],
            "role_name" => $user['role_name'],
        ];

        header('Location: ../profile.php');

    } else {
        $_SESSION['message'] = 'Не верный логин или пароль';
        header('Location: ../index.php');
    } 




    
// Проверяем, есть ли счетчик неправильных попыток в сессии, и, если нет, устанавливаем его в 0
if (!isset($_SESSION['incorrect_password_attempts'])) {
    $_SESSION['incorrect_password_attempts'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = md5($_POST['password']);

    // Проверка наличия пользователя в базе данных
    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");

    if (mysqli_num_rows($check_user) > 0) {
        $user = mysqli_fetch_assoc($check_user);

        $_SESSION['user'] = [
            "id" => $user['id'],
            "login" => $user['login'],
            "role_id" => $user['role_id'],
            "role_name" => $user['role_name'],
        ];

        // Сбрасываем счетчик неправильных попыток
        $_SESSION['incorrect_password_attempts'] = 0;

        header('Location: ../profile.php');
    } else {
        $_SESSION['incorrect_password_attempts']++; // Увеличиваем счетчик неправильных попыток

        if ($_SESSION['incorrect_password_attempts'] >= 3) {
            // Если количество неправильных попыток больше или равно 3, выводим сообщение и блокируем вход
            $_SESSION['message'] = 'Вы ввели пароль неверно 3 раза!!!';
            header('Location: ../index.php');
            exit();
        } 
    }
}




    
    ?>

<pre>
    <?php
    print_r($check_user);
    print_r($user);
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
        header('Location: ../profile.php');
            exit();
        }
    ?>
</pre>
