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
            height: 240px;
            /* Вы можете изменить значения по своему усмотрению */
            word-wrap: break-word;
        }
    </style>
    
    <title>Страница авторизации</title>
</head>

<body>
    <h2>Авторизация</h2>

    <div class="center">
        <div class="box">
            <form action="testreg.php" method="post">

                <!--****  testreg.php - это адрес обработчика. То есть, после нажатия на кнопку  "Войти", данные из полей отправятся на страничку testreg.php методом  "post" ***** -->
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
                    <input type="submit" name="submit" value="Войти">

                    <!--**** Кнопочка (type="submit") отправляет данные на страничку testreg.php ***** -->
                    <br>
                    <!--**** ссылка на регистрацию, ведь как-то же должны гости туда попадать ***** -->
                    <br><br>Если вы на сайте впервые то предлагаем 
                    <a href="register.php">Зарегистрироваться</a>
                </p>
            </form>
        </div>
    </div>
    <br>

    

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

</body>

</html>