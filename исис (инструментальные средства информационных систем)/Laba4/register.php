<html>

<head>
    <title>Регистрация</title>
    <script>
        function validateForm() {
            var login = document.forms["registrationForm"]["login"].value;
            var password = document.forms["registrationForm"]["password"].value;

            // Проведите необходимую валидацию для полей логина и пароля
            // Например, проверка на длину, наличие обязательных символов и т.д.

            if (login === "") {
                alert("Пожалуйста, введите логин.");
                return false;
            }

            if (password === "") {
                alert("Пожалуйста, введите пароль.");
                return false;
            }
        }
    </script>
</head>

<body>
    <?php
    // вся процедура работает на сессиях. Именно в ней хранятся данные пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    session_start();
    include("bd.php");
    ?>
    <h2>Регистрация</h2>
    <form name="registrationForm" action="save_user.php" method="post" onsubmit="return validateForm()">
        <!--**** save_user.php - это адрес обработчика.  То есть, после нажатия на кнопку "Зарегистрироваться", данные из полей  отправятся на страничку save_user.php методом "post" ***** -->
        <p>
            <label>Ваш логин:<br></label>
            <input name="login" type="text" size="20" maxlength="150">
        </p>
        <!--**** В текстовое поле (name="login" type="text") пользователь вводит свой логин ***** -->
        <p>
            <label>Ваш пароль:<br></label>
            <input name="password" type="password" size="20" maxlength="150">
        </p>
        <!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** -->
        <p>
            <label>
                <input type="checkbox" name="remember"> Запомнить меня
            </label>
        </p>
        <p>
            <input type="submit" name="submit" value="Зарегистрироваться">
            <!--**** Кнопочка (type="submit") отправляет данные на страничку save_user.php ***** -->
        </p>
        

    </form>
</body>

</html>