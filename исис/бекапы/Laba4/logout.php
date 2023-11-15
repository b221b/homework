<?php
    session_start();

    // Удаляем все данные о пользователе из сессии
    session_unset();
    session_destroy();

    // Перенаправляем пользователя на главную страницу
    header("Location: index.php");
    exit;
?>
