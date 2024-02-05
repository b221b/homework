<?php
require_once 'db.php';

$id = $_GET['id'];

// Получаем модель по id
$model = R::load('models', $id);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Просмотр модели</title>
</head>
<body>
	<h1>Просмотр модели</h1>

	<table>
		<tr>
			<th>ID</th>
			<th>Название модели</th>
			<th>Цвет</th>
			<th>Обивка</th>
			<th>Мощность двигателя</th>
			<th>Количество дверей</th>
			<th>Коробка передач</th>
			<th>ID поставщика</th>
			<th>Флаг</th>
		</tr>
		<tr>
			<td><?= $model->id ?></td>
			<td><?= $model->model_name ?></td>
			<td><?= $model->color ?></td>
			<td><?= $model->obivka ?></td>
			<td><?= $model->engine_power ?></td>
			<td><?= $model->door_number ?></td>
			<td><?= $model->korobka_peredach ?></td>
			<td><?= $model->id_postavshika ?></td>
			<td><?= $model->flag ?></td>
		</tr>
	</table>

	<a href="index.php">Назад к списку</a>
</body>
</html>