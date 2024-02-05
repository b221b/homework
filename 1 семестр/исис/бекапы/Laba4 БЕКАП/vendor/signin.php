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
