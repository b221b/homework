<?php
require_once 'db.php';
// use \RedBeanPHP\R as R;

// Получаем все записи из таблицы "Модель"
$models = R::findAll('models');

?>
<!DOCTYPE html>
<html>
<head>
	<title>CRUD-интерфейс для таблицы "Модель"</title>
</head>
<body>
	<h1>Таблица "Модель"</h1>

	<!-- Кнопка для создания новой модели -->
	<a href="create.php">Создать</a>

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
			<th>Действие</th>
		</tr>
		<?php foreach ($models as $model): ?>
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
				<td>
					<!-- Кнопки для обновления и удаления модели -->
					<a href="update.php?id=<?= $model->id ?>">Редактировать</a>
					<a href="delete.php?id=<?= $model->id ?>">Удалить</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</body>
</html>