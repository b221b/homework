<?php
require_once 'db.php';

$id = $_GET['id'];

// Получаем модель по id
$model = R::load('models', $id);

// Удаляем модель из базы данных
R::trash($model);

// Перенаправляем на страницу с таблицей
header('Location: index.php');
exit();
?>