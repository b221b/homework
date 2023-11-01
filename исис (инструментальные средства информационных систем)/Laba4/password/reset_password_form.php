<!-- reset_password_form.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <h2>Сброс пароля</h2>
    <form action="update_password.php" method="post">
        <label for="password">Новый пароль:</label>
        <input type="password" id="password" name="password" required>
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <button type="submit">Обновить пароль</button>
    </form>
</body>

</html>