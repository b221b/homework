<?php
session_start();

// Проверяем существование переменной сессии для хранения количества неудачных попыток
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

// Проверяем, были ли переданы данные из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем логин и пароль в базе данных (замените на вашу логику проверки)
    $login = strip_tags($_POST['login']);
    $password = strip_tags($_POST['password']);

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






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>



</head>

<body>

    <script>
        function onClick(e) {
            e.preventDefault();
            grecaptcha.ready(function() {
                grecaptcha.execute('6Ld-TeMoAAAAAEcJdqsEto3sxvOv1Nn-m5aF1mZT', {
                    action: 'LOGIN'
                }).then(function(token) {
                    // Отправьте полученный токен на ваш сервер для проверки
                    <?php
                    // Секретный ключ reCAPTCHA, который вы получили при регистрации вашего сайта
                    $secretKey = '6Ld-TeMoAAAAAEcJdqsEto3sxvOv1Nn-m5aF1mZT';

                    // Получаем токен из POST-запроса
                    $token = $_POST['g-recaptcha-response'];

                    // Формируем URL для проверки токена
                    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$token}";

                    // Отправляем запрос к API Google
                    $response = file_get_contents($verifyUrl);
                    $responseKeys = json_decode($response, true);

                    // Проверяем результат
                    if (intval($responseKeys["success"]) !== 1) {
                        // Токен не прошел проверку, обработайте это соответственно
                        echo "reCAPTCHA verification failed";
                    } else {
                        // Токен прошел проверку, продолжайте выполнение вашего кода
                        echo "reCAPTCHA verification successful";
                    }
                    ?>
                });
            });
        }
    </script>

    <div class="boxx">
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
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" />
            <div class="text-danger" id="recaptchaError"></div>
        </form>
        <!-- Капча-->
        <script>
            document.getElementById("feedbackform").addEventListener("submit", function(event) {
                var response = grecaptcha.getResponse();
                if (response.length === 0) {
                    document.getElementById("recaptchaError").textContent = "Пожалуйста, пройдите проверку reCAPTCHA.";
                    event.preventDefault(); // Предотвращает отправку формы, если проверка не пройдена.
                } else {
                    document.getElementById("g-recaptcha-response").value = response;
                }
            });
        </script>


    </div>
</body>

</html>