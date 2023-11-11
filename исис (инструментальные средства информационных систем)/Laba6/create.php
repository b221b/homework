<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Получаем данные из формы
	$modelName = $_POST['model_name'];
	$color = $_POST['color'];
	$obivka = $_POST['obivka'];
	$enginePower = $_POST['engine_power'];
	$doorNumber = $_POST['door_number'];
	$korobkaPeredach = $_POST['korobka_peredach'];
	$idPostavshika = $_POST['id_postavshika'];
	$flag = $_POST['flag'];

	// Создаем новую модель
	$model = R::dispense('models');
	$model->model_name = $modelName;
	$model->color = $color;
	$model->obivka = $obivka;
	$model->engine_power = $enginePower;
	$model->door_number = $doorNumber;
	$model->korobka_peredach = $korobkaPeredach;
	$model->id_postavshika = $idPostavshika;
	$model->flag = $flag;
	
	// Сохраняем модель в базе данных
	$id = R::store($model);

	// Перенаправляем на страницу с таблицей
	header('Location: index.php');
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Создать новую модель</title>
</head>
<body>
	<h1>Создать новую модель</h1>

	<form method="POST">
		<label>Название модели:</label>
		<input type="text" name="model_name" required><br>

		<label>Цвет:</label>
		<input type="text" name="color" required><br>

		<label>Обивка:</label>
		<input type="text" name="obivka" required><br>

		<label>Мощность двигателя:</label>
		<input type="text" name="engine_power" required><br>

		<label>Количество дверей:</label>
		<input type="number" name="door_number" required><br>

		<label>Коробка передач:</label>
		<input type="text" name="korobka_peredach" required><br>

		<label>ID поставщика:</label>
		<input type="number" name="id_postavshika" required><br>

		<label>Флаг:</label>
		<input type="text" name="flag" required><br>

		<button type="submit">Создать</button>
	</form>
</body>
</html>