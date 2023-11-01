<!-- reset_password_form.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Восстановление пароля</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    
</head>

<body>
<br><br><br><br><br><br> 
    <h2>Восстановление пароля</h2>
    <br>
    <form action="reset_password.php" method="post">
        <label for="login">Логин:</label>
        <input type="text" name="login" required>
        <label for="email">Почта:</label>
        <input type="text" name="email" required>
        <br>
        <label for="new_password">Новый пароль:</label>
        <input type="password" name="new_password" required>
        <br>
        <input type="submit" value="Сбросить пароль">
    </form>

<br>
<p>
            Вспомнили пароль? - <a href="../index.php">Авторизоваться</a>
        </p>

</body>

</html>