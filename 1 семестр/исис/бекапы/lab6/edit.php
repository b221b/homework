<?php
require_once 'db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Updating the record
	$model = R::load('models', $id);
	$model->model_name = $_POST['model_name'];
	$model->color = $_POST['color'];
	$model->obivka = $_POST['obivka'];
	$model->engine_power = $_POST['engine_power'];
	$model->door_number = $_POST['door_number'];
	$model->korobka_peredach = $_POST['korobka_peredach'];
	$model->id_postavshika = $_POST['id_postavshika'];
	$model->flag = $_POST['flag'];
	R::store($model);

	header('Location: index.php');
} else {
	// Loading the record to be updated
	$model = R::load('models', $id);
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Редактировать модель</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<style>
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			background-color: #f6f6f6;
			font-family: Arial, sans-serif;
		}

		form {
			box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
			padding: 2em;
			border-radius: 4px;
			background-color: #fff;
			width: 100%;
			max-width: 500px;
		}

		form label {
			display: block;
			margin-bottom: .5em;
			font-weight: bold;
		}

		form input {
			width: 100%;
			padding: .5em;
			margin-bottom: 1em;
			border-radius: 4px;
			border: 1px solid #ccc;
		}

		form button {
			background-color: #009578;
			color: #fff;
			border: none;
			border-radius: 4px;
			padding: 1em 2em;
			cursor: pointer;
			font-size: 1em;
		}

		@media only screen and (max-width: 600px) {
			form {
				padding: 1em;
			}
		}
	</style>
</head>

<body>
	

	<form method="POST">
	<h1>Редактировать модель</h1>
	<br>
		<label>Название модели:</label>
		<input type="text" name="model_name" value="<?= $model->model_name ?>" required><br>

		<label>Цвет:</label>
		<input type="text" name="color" value="<?= $model->color ?>" required><br>

		<label>Обивка:</label>
		<input type="text" name="obivka" value="<?= $model->obivka ?>" required><br>

		<label>Мощность двигателя:</label>
		<input type="text" name="engine_power" value="<?= $model->engine_power ?>" required><br>

		<label>Количество дверей:</label>
		<input type="number" name="door_number" value="<?= $model->door_number ?>" required><br>

		<label>Коробка передач:</label>
		<input type="text" name="korobka_peredach" value="<?= $model->korobka_peredach ?>" required><br>

		<label>ID поставщика:</label>
		<input type="number" name="id_postavshika" value="<?= $model->id_postavshika ?>" required><br>

		<label>Флаг:</label>
		<input type="text" name="flag" value="<?= $model->flag ?>" required><br>

		<button type="submit">Обновить</button>
	</form>
</body>

</html>