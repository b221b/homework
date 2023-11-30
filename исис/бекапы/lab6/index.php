<?php
require_once 'db.php';

// Получаем все записи из таблицы "Модель"
$models = R::findAll('models');

?>
<!DOCTYPE html>
<html>

<head>
  <title>CRUD-интерфейс для таблицы "Модели"</title>
  <style>
    body {
      font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
    }

    table {
      width: 85%;
      border-collapse: collapse;
      background-color: #fff;
      box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 15px;
      text-align: left;
      /* width: 9%; */
    }

    th {
      background-color: #3465A4;
      color: white;
    }

    th:last-child {
      width: 20%;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #E5E5E5;
    }

    .button {
      border: none;
      padding: 5px 10px;
      cursor: pointer;
      text-decoration: none;
      /* margin: 0px; */
      transition-duration: 0.4s;
      background-color: #3465A4;
      color: white;
      font-weight: bold;
    }

    .button:hover {
      background-color: #204a87;
    }

    .button-container {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .button-container2 {
      display: flex;
      justify-content: space-between;
      /* изменено */
      align-items: center;
      /* добавлено */
      direction: row;
      /* добавлено */
    }

    .button2 {
      border: none;
      padding: 0px 5px;
      cursor: pointer;
      text-decoration: none;
      margin-right: 5px;
      transition-duration: 0.4s;
      background-color: #3465A4;
      color: white;
      font-weight: bold;
    }

    .button:hover2 {
      background-color: #204a87;
    }
  </style>
</head>

<body>
  <div class="button-container">

    <a class="button" href="2zadanie.php" style="margin-right: 40px; margin-left: 40px;">2 задание</a>
    <a class="button" href="3zadanie.php" style="margin-right: 40px; margin-left: 40px;">3 задание</a>
    <a class="button" href="4zadanie.php" style="margin-right: 40px; margin-left: 40px;">4 задание</a>
  </div>
  <br>

  <h1>Таблица "Модель"</h1>

  <table>
    <tr>
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
    <?php foreach ($models as $model) : ?>
      <tr>
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
          <div class="button-container"> <!-- добавлено -->
            <a class="button2" href="edit.php?id=<?= $model->id ?>">Редактировать</a>
            <a class="button2" href="delete.php?id=<?= $model->id ?>">Удалить</a>
          </div> <!-- добавлено -->
        </td>
      </tr>
    <?php endforeach; ?>

  </table>
  <br>
  <!-- Кнопка для создания новой модели -->
  <br>
  <a class="button" href="create.php">Создать</a><br><br><br>
</body>

</html>