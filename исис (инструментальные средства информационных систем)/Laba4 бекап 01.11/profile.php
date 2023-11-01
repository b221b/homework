<?php
session_start();
require_once 'vendor/connect.php';
if (!$_SESSION['user']) {
    header('Location: index.php');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
    <link rel="stylesheet" href="assets/css/main.css">

    <style>
        .knopka {
            border: 2px solid #000;
            padding: 10px 20px;
            background-color: #fff;
            color: #000;
            border-radius: 5px;
            transition: background-color 1s, color 1s;
            /* Добавляем плавное изменение цвета в течение 2 секунд */
        }

        .knopka:hover {
            background-color: #000;
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- Профиль -->
    <div class="box">
        <form>
            <img src="uploads/ava.jpg" width="250" height="250"> <br>
            Логин:<h2 style="margin: 10px 0;"><?= $_SESSION['user']['login'] ?></h2>
            ID Вашей Роли: <br> <a href="role.html"><?= $_SESSION['user']['role_id'] ?></a>

            ↑ <br>
            Нажми сюда и узнаешь <br> значение роли
            <br><br>
            <a href="vendor/logout.php" class="logout">Выйти из аккаунта</a>
        </form>
    </div>


    <br><br>
    <!-- Информация о веб-приложении -->
    <h2>Информация о веб-приложении:</h2>
    <p>Название проекта: Коммерческая фирма</p>
    <p>Версия: 1.0</p>

    <!-- Информация о разработчике -->
    <h2>Информация о разработчике:</h2>
    <p>Разработчик: Титаренко Мирослав, ДГТУ группа ВИС33</p>
    <p>Email: titarenkomiroslav61@gmail.com</p>
    <br>
    <!-- кнопка ведомости для оперов и админов-->


    <?php
    // Проверяем, является ли текущий пользователь оператором или администратором
    $userRoleID = $_SESSION['user']['role_id'];
    $allowedRoles = [2, 3]; // Роли оператора и администратора

    if (in_array($userRoleID, $allowedRoles)) {
        // Пользователь имеет разрешение на создание ведомости
        echo '<a href="Laba2/laba2_extended.php" class="button">Ведомость</a>';
    }
    ?>


    <br><br>
    <!-- кнопка проверки пользователей админов-->


    <?php
    // Проверяем, является ли текущий пользователь оператором или администратором
    $userRoleID = $_SESSION['user']['role_id'];
    $allowedRoles = [3]; // Роли администратора

    if (in_array($userRoleID, $allowedRoles)) {
        // Пользователь имеет разрешение на создание ведомости
        echo '<a href="users.php" class="button">Пользователи сайта</a>';
        echo '<a href="laba3/laba3.php" class="button"><br><br>CRUD</a>';
    }
    ?>



    <?php
    // Проверяем, является ли текущий пользователь оператором или администратором
    $userRoleID = $_SESSION['user']['role_id'];
    $allowedRoles = [1];
    ?>

    <form method="POST" action="обработчикСообщений.php">
        <?php if (in_array($userRoleID, $allowedRoles)) : ?>
            <textarea name="comment" rows="4" cols="50"></textarea>
            <br>
            <input type="submit" class='knopka' value="Сохранить комментарий">
        <?php endif; ?>
    </form>

    <br><br><br>






    <?php
    if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 2) {
        // Устанавливаем параметры подключения к базе данных
        $dbHost = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'komercheskaya firma2';

        // Создаем подключение к базе данных
        $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        // Проверяем подключение
        if ($conn->connect_error) {
            die("Ошибка подключения к базе данных: " . $conn->connect_error);
        }

        // Получаем логин текущего пользователя
        $login = $_SESSION['user']['login'];

        // Обновляем last_visit и visit_count
        $currentDate = date('Y-m-d H:i:s');
        $updateQuery = "UPDATE users SET last_visit = '$currentDate', visit_count = visit_count + 1 WHERE login = '$login'";

        if ($conn->query($updateQuery) === TRUE) {
            // Выполните дополнительный запрос для извлечения значений last_visit и visit_count
            $selectQuery = "SELECT last_visit, visit_count FROM users WHERE login = '$login'";
            $result = $conn->query($selectQuery);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "Последнее посещение: " . $row['last_visit'] . "<br>";
                echo "Вы зашли в " . $row['visit_count'] . " раз";
            } else {
                echo "Ошибка при извлечении данных: " . $conn->error;
            }
        } else {
            echo "Ошибка при обновлении данных: " . $conn->error;
        }

        // Закрываем подключение
        $conn->close();
    } else {
        echo "Функция записи посещений только для операторов";
    }
    ?>


<br><br><br><br><br><br>






</html>