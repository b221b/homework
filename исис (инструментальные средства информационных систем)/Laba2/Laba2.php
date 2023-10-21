<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Laba 2</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 15px;
            text-align: left;
        }
    </style>
</head>

<body>
    <?php
    /*подключение к серверу и проверка подключения*/
    $conn = new mysqli("localhost", "root", "", "komercheskaya firma");
    $conn->query("SET NAMES 'utf8'");

    if ($conn->connect_error) {
        echo 'Error number: ' . $conn->connect_errno . '<br>';
        echo 'Error: ' . $conn->connect_error;
    }
    /*подключение к серверу и проверка подключения*/

    echo '<h3 style="text-align:center; font-weight:bold;">Отчет о реализации автомобилей за Январь месяц 2023 года</h3>';

    /*Первый запрос*/
    $sql = "SELECT DISTINCT m.model_name, p.coast, p.podgotovka, p.transport_coast, p2.name_firma, p.coast + p.podgotovka + p.transport_coast AS Стоимость
    FROM models as M
    JOIN price_list P ON M.id = P.id 
    JOIN clients C ON M.id = C.id 
    JOIN postavshiki P2 ON M.id = P2.id
    WHERE C.buy_date = '2023-01-09'";

    $result = $conn->query($sql);
    /*Первый запрос*/

    /*Таблица*/
    if ($result->num_rows > 0) {
        echo "<table><thead>";
        echo "<tr>";
        echo "<th>Название модели</th>";
        echo "<th>Цена</th>";
        echo "<th>Предпродажная подготовка</th>";
        echo "<th>Транспортные издержки</th>";
        echo "<th>Стоимость</th>";
        echo "</tr></thead><tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["model_name"] . "</td>";
            echo "<td>" . $row["coast"] . "</td>";
            echo "<td>" . $row["podgotovka"] . "</td>";
            echo "<td>" . $row["transport_coast"] . "</td>";
            echo "<td>" . $row["Стоимость"] . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "Нет данных.";
        echo 'Error number: ' . $conn->connect_errno . '<br>';
        echo 'Error: ' . $conn->connect_error;
    }
    /*Таблица*/

    /*Второй запрос*/
    $sql_firm = "SELECT name_firma FROM postavshiki Where name_firma='Firma1'";
    $result_firm = $conn->query($sql_firm);

    if ($result_firm->num_rows > 0) {
        while ($row_firm = $result_firm->fetch_assoc()) {
            echo "<h4>Фирма: " . $row_firm['name_firma'] . "</h4>";
        }
    }
    /*Второй запрос*/

    /*Третий запрос*/
    $sql_firm = "SELECT phone, email, website, city, 
(SELECT SUM(coast + podgotovka + transport_coast) 
 FROM price_list
 JOIN models ON price_list.id = models.id
 JOIN clients ON models.id = clients.id
 WHERE name_firma='Firma1' AND buy_date = '2023-01-09') AS total_coast
FROM postavshiki 
Where name_firma='Firma1'";
    $result_firm = $conn->query($sql_firm);

    if ($result_firm->num_rows > 0) {
        while ($row_firm = $result_firm->fetch_assoc()) {
            echo "<h4>Итого по фирме: " . $row_firm['total_coast'] . "</h4>";
        }
    }
    /*Третий запрос*/


    /*Четвертый запрос*/
    $sql = "SELECT 
SUM(p.coast + p.podgotovka + p.transport_coast) AS TotalCost
FROM clients c
JOIN posrednik po ON po.id_client = c.id
JOIN models m ON m.id = po.id_model
JOIN price_list p ON m.id = p.id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<h4>Общая стоимость всех проданных автомобилей: " . $row['TotalCost'] . "<h4>";

        }
    } else {
        echo "Нет данных.";
        echo 'Error number: ' . $conn->connect_errno . '<br>';
        echo 'Error: ' . $conn->connect_error;
    }
    /*Четвертый запрос*/




    $conn->close();
    ?>
</body>

</html>