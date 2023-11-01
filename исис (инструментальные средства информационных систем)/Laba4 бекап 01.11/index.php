<?php
session_start();

// Проверяем существование переменной сессии для хранения количества неудачных попыток
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

// Проверяем, были ли переданы данные из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем логин и пароль в базе данных (замените на вашу логику проверки)
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Подключение к базе данных
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "komercheskaya_firma2";

    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        $_SESSION['attempts']++; // Увеличиваем счетчик неудачных попыток

        if ($_SESSION['attempts'] >= 3) {
            echo "Вы ввели пароль неверно 3 раза!!!!";
            // Дополнительные действия, например, блокировка аккаунта или другие меры безопасности
        }
    }
}

?>

<br><br><br><br><br><br><br>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="assets/css/main.css">

    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LdMRuEoAAAAABe7o6aupla7JA8uxmL5SteySFOS" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>

    <script>
        function onClick(e) {
            e.preventDefault();
            grecaptcha.enterprise.ready(async () => {
                const token = await grecaptcha.enterprise.execute('6LdMRuEoAAAAABe7o6aupla7JA8uxmL5SteySFOS', {
                    action: 'LOGIN'
                });
            });
        }
    </script>


    <!-- Форма авторизации -->

    <form action="vendor/signin.php" method="post">
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">

        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <br><br>
        <label for="remember_me">Запомнить меня:</label>
        <input type="checkbox" name="remember_me" id="remember_me">
        <!-- Другие поля для ввода имени пользователя и пароля -->
        <input type="submit" value="Войти">

        <p>
            У вас нет аккаунта? - <a href="register.php">зарегистрируйтесь</a>!
        </p>

        <p>
            Забыли пароль? - <a href="reset/reset_password_form.php">восстановить</a>
        </p>

        <?php
        if (isset($_SESSION['message'])) {
            echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
            unset($_SESSION['message']); // Очищаем сообщение после того как оно было отображено
        }

        ?>
        <!-- Капча-->
    </form>
    <br><br>
    <form id="feedbackform" action="">
        <div class="g-recaptcha" data-sitekey="6Ld-TeMoAAAAAEcJdqsEto3sxvOv1Nn-m5aF1mZT"></div>
        <div class="text-danger" id="recaptchaError"></div>
    </form>
    <!-- Капча-->


</body>

</html>