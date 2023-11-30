<?php
session_start();
include("bd.php");

// Проверяем, существуют ли переменные логина и id пользователя в сессии
if (empty($_SESSION['login']) or empty($_SESSION['id'])) {
    // Если не существуют, перенаправляем на страницу регистрации
    header("Location: register.php");
    exit();
}

   
   
// Если существуют, выводим информацию о пользователе
echo "Добро пожаловать, " . $_SESSION['login'] . "! Вы находитесь на странице профиля.";



// Получаем роль пользователя из базы данных
$userId = mysqli_real_escape_string($conn, $_SESSION['id']);

// Выполняем запрос для получения роли пользователя
$query = "SELECT roles.role_name FROM users 
          INNER JOIN roles ON users.role_id = roles.id 
          WHERE users.id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $userId);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $roleName = $row['role_name'];
    echo " Ваша роль: " . $roleName;
} else {
    echo "Не удалось получить информацию о роли пользователя.";
} 

mysqli_free_result($result);
?>

<form action="logout.php" method="POST">
    <button type="submit" name="logout">Выйти из системы</button>
</form>