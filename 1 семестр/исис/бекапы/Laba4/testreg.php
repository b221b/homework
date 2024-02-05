<?php
session_start();

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

$login = trim($login);
$password = trim($password);

if (empty($login) || empty($password)) {
    exit("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
}

include("bd.php");

$stmt = $conn->prepare("SELECT * FROM users WHERE login=?");
$stmt->bind_param("s", $login);
$stmt->execute();

$result = $stmt->get_result();
$myrow = $result->fetch_assoc();

if (!$myrow) {
    exit("Извините, введённый вами логин или пароль неверный.");
} else {
    if (password_verify($password, $myrow['password'])) { // метод password_verify сравнивает хэши паролей
        $_SESSION['login'] = $myrow['login'];
        $_SESSION['id'] = $myrow['id'];
        echo "Вы успешно вошли на сайт! <a href='index.php'>Главная страница</a>";
    } else {
        exit("Извините, введённый вами логин или пароль неверный.");
    }
}
?>

<?php

// Проверяем, если пользователь не авторизован, перенаправляем на страницу авторизации
if (empty($_SESSION['login']) || empty($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}



// Закрываем соединение с базой данных
mysqli_close($conn);
?>
