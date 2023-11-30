        <?php
        session_start();
        //  if ($_SESSION['user']) {
        //      header('Location: profile.php');
        //  }
        ?>

        <br><br><br><br><br><br><br>

        <!doctype html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <title>Авторизация и регистрация</title>
            <link rel="stylesheet" href="assets/css/main.css">
        </head>

        <body>

            <!-- Форма регистрации -->

            <form action="vendor/signup.php" method="post">

                <label>Логин</label>
                <input type="text" name="login" placeholder="Введите свой логин">

                <label>Почта</label>
                <input type="text" name="email" placeholder="Введите свою почту">

                <label>Пароль</label>
                <input type="password" name="password" placeholder="Введите пароль">

                <label>Подтверждение пароля</label>
                <input type="password" name="password_confirm" placeholder="Подтвердите пароль">

                <button type="submit">Войти</button>
                <p>
                    У вас уже есть аккаунт? - <a href="index.php">авторизируйтесь</a>!
                </p>
                <?php

                if (isset($_SESSION['message'])) {
                    echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
                    unset($_SESSION['message']); // Очищаем сообщение после того как оно было отображено
                }

                ?>
            </form>

        </body>

        </html>