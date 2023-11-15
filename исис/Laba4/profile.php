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

<body class="body2">
    <div class="container">
        <div class="profile-box">
            <img src="uploads/ava.jpg" alt="Аватар" class="avatar">
            <h2 class="username"><?= strip_tags($_SESSION['user']['login']) ?></h2>
            <p class="role-id">ID Вашей Роли: <a href="role.html"><?= strip_tags($_SESSION['user']['role_id']) ?></a></p>
            <a href="vendor/logout.php" class="logout">Выйти из аккаунта</a>
        </div>

        <div class="info">
            <h2>Информация о веб-приложении:</h2>
            <ul>
                <li>Название проекта: Коммерческая фирма</li>
                <li>Версия: 1.0</li>
            </ul>
        </div>

        <div class="info">
            <h2>Информация о разработчике:</h2>
            <p>Разработчик: Титаренко Мирослав, ДГТУ группа ВИС33</p>
            <p>Email: titarenkomiroslav61@gmail.com</p>
        </div><br>
    <!-- кнопка ведомости для оперов и админов-->


    <?php
    // Проверяем, является ли текущий пользователь оператором или администратором
    $userRoleID = $_SESSION['user']['role_id'];
    $allowedRoles = [2, 3]; // Роли оператора и администратора

    if (in_array($userRoleID, $allowedRoles)) {
        // Пользователь имеет разрешение на создание ведомости
        echo '<a href="Laba2/laba2_extended.php" class="button"><h2>Ведомость</h2></a>';
    }
    ?>


    <br>
    <!-- кнопка проверки пользователей админов-->


    <?php
    // Проверяем, является ли текущий пользователь оператором или администратором
    $userRoleID = $_SESSION['user']['role_id'];
    $allowedRoles = [3]; // Роли администратора

    if (in_array($userRoleID, $allowedRoles)) {
        // Пользователь имеет разрешение на создание ведомости
        echo '<a href="users.php" class="button"><h2>Пользователи сайта</h2></a>';
        echo '<a href="laba3/laba3.php" class="button"><br><h2>CRUD</h2><br></a>';
    }
    ?>



    <?php
    // Проверяем, является ли текущий пользователь оператором или администратором
    $userRoleID = $_SESSION['user']['role_id'];
    $allowedRoles = [1, 2, 3];
    ?>

    <form method="POST" action="обработчикСообщений.php">
        <?php if (in_array($userRoleID, $allowedRoles)) : ?>
            <textarea name="comment" id="comment" rows="4" cols="50" oninput="countCharacters()"></textarea>
            <p id="charCount">Количество символов: 500</p>
            <br>
            <input type="submit" class='knopka' value="Сохранить комментарий">
        <?php endif; ?>
    </form>

    <script>
        function countCharacters() {
            var textarea = document.getElementById("comment");
            var charCount = document.getElementById("charCount");
            var maxLength = 500;
            var currentLength = textarea.value.length;
            var charactersLeft = maxLength - currentLength;
            charCount.textContent = "Characters left: " + charactersLeft;
        }
    </script>

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
        $login = strip_tags($_SESSION['user']['login']);

        // Обновляем last_visit и visit_count
        $currentDate = date('Y-m-d H:i:s');
        $updateQuery = "UPDATE users SET last_visit = ?, visit_count = visit_count + 1 WHERE login = ?";

        if ($stmt = $conn->prepare($updateQuery)) {
            $stmt->bind_param("ss", $currentDate, $login); // "ss" указывает, что параметры - это строки
            if ($stmt->execute()) {
                // Выполните дополнительный запрос для извлечения значений last_visit и visit_count
                $selectQuery = "SELECT last_visit, visit_count FROM users WHERE login = ?";

                // Используем подготовленный запрос
                if ($stmt = $conn->prepare($selectQuery)) {
                    $stmt->bind_param("s", $login); // "s" указывает, что параметр - это строка
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo "Последнее посещение: " . $row['last_visit'] . "<br>";
                            echo "Вы зашли в " . $row['visit_count'] . " раз";
                        } else {
                            echo "Ошибка при извлечении данных: " . $conn->error;
                        }
                        $stmt->close(); // Закрываем подготовленный запрос
                    } else {
                        echo "Ошибка при выполнении запроса: " . $stmt->error;
                    }
                } else {
                    echo "Ошибка при подготовке запроса: " . $conn->error;
                }
            } else {
                echo "Ошибка при обновлении данных: " . $stmt->error;
            }
        } else {
            echo "Ошибка при подготовке запроса: " . $conn->error;
        }

        // Закрываем подключение
        $conn->close();
    } else {
        echo "Функция записи посещений только для операторов";
    }
    ?>

    <br><br><br><br><br><br>

</html>