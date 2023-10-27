<?php
//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
session_start();
include("bd.php");
?>



<html>

<head>
    <style>
        .center {
            display: flex;
            /*justify-content: flex-end;
            /* align-items: flex-start; /* Выравнивание по правому краю */
            /*height: 100vh; /*Выравнивание по верхнему краю */
            text-align: center;
        }

        .box {
            border: 1px solid #512da8;
            border-radius: 15px;
            padding: 30px;
            background-color: #ffffff;
            width: 200px;
            /* Здесь устанавливаем фиксированную ширину и высоту */
            height: 40px;
            /* Вы можете изменить значения по своему усмотрению */
            word-wrap: break-word;
        }
    </style>

    <title>Главная страница</title>
</head>

<body>
    <h2>Главная страница</h2>

    <div class="center">
        <div class="box">
            <a href="auth.php">Авторизоваться</a>

            <a href="register.php">Зарегистрироваться</a>
            </p>
            </form>
        </div>
    </div>
    <br>

    <?php
    // Проверяем, пусты ли переменные логина и id пользователя
    if (!empty($_SESSION['login']) && !empty($_SESSION['role_id'])) {
        echo "Вы вошли на сайт, как " . $_SESSION['login'];
    } else {
        //echo "Вы вошли на сайт, как гость";
        echo "Вы вошли на сайт, как " . $_SESSION['login'];
    }

    /* тут возникла проблема с отображением имени пользователя на галвной и в личном кабинете
    // После успешной аутентификации
    $_SESSION['login'] = 'ваш_логин';
    $_SESSION['role_id'] = 'ваш_роль_id';
    */
    echo "<br><a href='profile.php'>Личный кабинет</a>";

    ?>

    <?php
    if (isset($_POST['submit'])) {
        // Получаем введенные пользователем логин и пароль из формы
        $login = $_POST['login'];
        $password = $_POST['password'];

        // Защищаем от SQL-инъекций
        $login = stripslashes($login);
        $login = htmlspecialchars($login);
        $password = stripslashes($password);
        $password = htmlspecialchars($password);

        // Проверяем, введены ли логин и пароль
        if (empty($login) || empty($password)) {
            echo "Заполните все поля";
        } else {
            // Хэшируем пароль
            $password = md5($password);

            // Проверяем, существует ли пользователь с указанным логином и паролем в базе данных
            $query = "SELECT * FROM users WHERE login='$login' AND password='$password'";
            $result = mysqli_query($db, $query);
            $count = mysqli_num_rows($result);

            if ($count == 1) { // Если найдена запись пользователя
                // Получаем информацию о пользователе из базы данных
                $row = mysqli_fetch_assoc($result);
                $_SESSION['id'] = $row['id'];
                $_SESSION['login'] = $row['login'];

                // Перенаправляем на страницу profile.php
                header("Location: profile.php");
                exit();
            } else {
                // Перенаправляем на страницу регистрации
                header("Location: register.php");
                exit();
            }
        }
    }
    ?>

    <br>
    <br>
    <br>
    
    <?php
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $query = "SELECT users.role_id, roles.role_name 
              FROM users 
              INNER JOIN roles ON users.role_id = roles.id 
              WHERE users.id = $userId";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $role = $row['role_id'];

            if ($role == "1" || $role == "2" || $role == "3") {
                echo '<div>Системная информация о веб-приложении</div>';
                echo '<div>Информация о разработчике</div>';
                echo '<div>Название проекта</div>';
                echo '<button>Настроить</button>';
            }
        }
    }
    ?>


<?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT users.login, roles.role_name
            FROM users
            INNER JOIN roles ON users.role_id = roles.id
            WHERE users.id = $user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $login = $row['login'];
        $role_name = $row['role_name'];

        if ($role_name == "guest" || $role_name == "operator" || $role_name == "admin") {

            echo "Системная информация: ваш текст здесь\n";
            echo "Информация о разработчике: ваш текст здесь\n";
            echo "Название проекта: ваш текст здесь\n";
        } else {
            echo "Вы авторизованы как $role_name $login, но у вас нет доступа к этой информации.";
        }
    }
} else {
    // Если пользователь не авторизован
    echo "Авторизуйтесь";
}


// Закрытие соединения с базой данных
$conn->close();
?>



</body>

</html>