<?php
    session_start();
    require_once 'connect.php';

    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password === $password_confirm) {
        
        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($connect, "INSERT INTO `users` (`login`, `password`, `email`) VALUES (?, ?, ?)");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $login, $password, $email);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = 'Регистрация прошла успешно!';
                header('Location: ../index.php');
            } else {
                $_SESSION['message'] = 'Ошибка при выполнении запроса: ' . mysqli_error($connect);
                header('Location: ../register.php');
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['message'] = 'Ошибка при подготовке запроса: ' . mysqli_error($connect);
            header('Location: ../register.php');
        }
    } else {
        $_SESSION['message'] = 'Пароли не совпадают';
        header('Location: ../register.php');
    }
?>