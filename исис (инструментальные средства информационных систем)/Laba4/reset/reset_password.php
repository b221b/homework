<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php
    // reset_password.php
    require_once('db_connection.php'); // Подключение к базе данных

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = mysqli_real_escape_string($connect, $_POST['login']);
        $email = mysqli_real_escape_string($connect, $_POST['email']);
        $newPassword = md5($_POST['new_password']); // Хеширование нового пароля

        // Проверяем, существует ли пользователь с указанным логином в базе данных
        $query = "SELECT * FROM users WHERE login = '$login' AND email = '$email'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) > 0) {
            // Обновляем пароль пользователя в базе данных
            $updateQuery = "UPDATE users SET password = '$newPassword' WHERE login = '$login'";
            mysqli_query($connect, $updateQuery);

            echo "Пароль успешно изменен.";
        } else {
            echo "Пользователь с таким логином и почтой не найден.<br><br> Проверьте, правильно ли вы написали логин и почту<br>";
        }
    }
    ?>
<br>
    <?php
    echo "<a href='../index.php?=' style='display: inline-block; width: 150px; height: 50px; background-color: #ccc; text-align: center; line-height: 50px; border-radius: 5px;'>Обратно</a>";
    ?>

</body>

</html>