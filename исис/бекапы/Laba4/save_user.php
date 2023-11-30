<html>

<head>
    <title>Регистрация</title>
    <script>
        function validateForm() {
            var login = document.forms["registrationForm"]["login"].value.trim();
            var password = document.forms["registrationForm"]["password"].value.trim();

            if (!login || login.length > 150) {
                alert("Пожалуйста, введите корректный логин (до 150 символов).");
                return false;
            }

            var emailRegExp = /\S+@\S+\.\S+/; // Basic email format
            if (!emailRegExp.test(login)) {
                alert("Введите корректный адрес электронной почты.");
                return false;
            }

            if (!password || password.length < 6 || password.length > 150) { // Let's say a minimum password length of 6 characters
                alert("Введите корректный пароль (от 6 до 150 символов).");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <?php
    session_start();
    include("bd.php");

    // Получаем значение флажка "Запомнить меня"
    $remember = isset($_POST['remember']) ? true : false;


    // Если флажок установлен, сохраняем данные пользователя
    if ($remember) {
        // Сохранение в сессии
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['password'] = $_POST['password'];

        // Или сохранение в cookie (настроить срок годности, например, на 30 дней)
        setcookie('login', $_POST['login'], time() + (30 * 24 * 60 * 60));
        setcookie('password', $_POST['password'], time() + (30 * 24 * 60 * 60));
    }

    ?>

    <?php
    if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
        // ... код проверки логина и пароля ...

        // Если проверка успешна, авторизуем пользователя
        $_SESSION['authenticated'] = true;
    } elseif (isset($_COOKIE['login']) && isset($_COOKIE['password'])) {
        // ... код проверки логина и пароля ...

        // Если проверка успешна, авторизуем пользователя
        $_SESSION['authenticated'] = true;
    }
    ?>

    <?php
    if (isset($_POST['login'])) {
        $login = $_POST['login'];
        if ($login == '') {
            unset($login);
        }
    }

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        if ($password == '') {
            unset($password);
        }
    }

    if (empty($login) or empty($password)) {
        exit("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
    }

    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);
    $login = trim($login);
    $password = trim($password);

    // Подключение к базе данных
    include("bd.php");

    // Проверка на существование пользователя с таким же логином
    $stmt = $conn->prepare("SELECT id FROM users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        exit("Извините, введённый вами логин уже зарегистрирован. Введите другой логин.");
    }

    $stmt->close();

    $password = password_hash($password, PASSWORD_DEFAULT); // Hash the password before storing it

    // Если такого пользователя нет, то сохраняем данные
    $stmt = $conn->prepare("INSERT INTO users (login, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $login, $password);
    $result = $stmt->execute();

    if ($result) {
        echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт. <a href='index.php'>Главная страница</a>";
    } else {
        echo "Ошибка! Вы не зарегистрированы.";
    }

    
    $stmt->close();
    $conn->close();
    ?>



</body>

</html>