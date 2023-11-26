<?php
require 'db.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Laba 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* стили для таблицы*/
        table {
            width: 55%;
            margin-bottom: 20px;
            border: 15px solid #F2F8F8;
            border-top: 5px solid #F2F8F8;
            border-collapse: collapse;
        }

        th {
            font-weight: bold;
            padding: 5px;
            background: #F2F8F8;
            border: none;
            border-bottom: 5px solid #F2F8F8;
        }

        td {
            padding: 5px;
            border: none;
            border-bottom: 5px solid #F2F8F8;
        }





        /* стили для выпадающего*/

        /* Основные стили для select box */
        select {
            width: 200px;
            padding: 10px;
            margin: 6px 15px 15px 0px;
            border-radius: 5px;
            border: 2px solid #ccc;
            font-size: 15px;
            outline: none;
            color: #4a4a4a;
        }

        /* Дизайн при наведении */
        select:hover {
            border-color: #888;
        }

        /* Дизайн при выборе элемента select */
        select:focus {
            border-color: #1155cc;
            box-shadow: 0 0 5px rgba(0, 0, 255, .5);
        }




        /* стили для кнопки*/
        .btn {
            display: inline-block;
            box-sizing: border-box;
            padding: 0 20px;
            margin: 13px 15px 15px 0px;
            outline: none;
            border: none;
            border-radius: 4px;
            height: 32px;
            line-height: 32px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            color: #fff;
            background-color: #3775dd;
            box-shadow: 0 2px #21487f;
            cursor: pointer;
            user-select: none;
            appearance: none;
            touch-action: manipulation;
            vertical-align: top;
        }

        .btn:hover {
            background-color: #002fed;
        }

        .btn:active {
            background-color: #2f599e;
        }

        .btn:focus-visible {
            box-shadow: 0 0 0 3px lightskyblue;
        }

        .btn:disabled {
            background-color: #6c87b5;
            pointer-events: none;
        }

        .button {
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            text-decoration: none;
            margin: 2px 2px;
            transition-duration: 0.4s;
            background-color: #4169e1;
            color: white;
            font-weight: bold;
        }

        .button:hover {
            background-color: #696969;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <a href="index.php" class="button">Главная</a>


    <form method="post" action="">
        <label for="start_date">Начальная дата:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">Конечная дата:</label>
        <input type="date" id="end_date" name="end_date" required>

        <input type="submit" class="btn" value="Отправить">
    </form>

    <?php
    /*подключение к серверу и проверка подключения пока что будет отсутствовать, так как мы используем RedBeanPHP*/

    echo '<h3 style="text-align:left; font-weight:bold;">Отчет о реализации автомобилей</h3>';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["start_date"]) && !empty($_POST["end_date"])) {
            $start_date = $_POST["start_date"];
            $end_date = $_POST["end_date"];

            echo "<br><h4>Отчет с " . htmlspecialchars($start_date) . " по " . htmlspecialchars($end_date) . "</h4><br>";

            // Форматируем даты для БД
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));

            // Ваш SQL запрос теперь должен быть обновлён, чтобы учесть диапазон дат
            // Например:
            $sql_firms = "SELECT DISTINCT postavshiki.name_firma 
            FROM postavshiki 
            JOIN models ON postavshiki.id = models.id_postavshika 
            JOIN posrednik ON models.id = posrednik.id_model 
            JOIN clients ON posrednik.id_client = clients.id 
            WHERE clients.buy_date BETWEEN ? AND ?";

            $firms_result = R::getAll($sql_firms, [$start_date, $end_date]);

            foreach ($firms_result as $firm_row) {
                $firm_name = $firm_row["name_firma"];

                echo "<h3>Фирма: " . $firm_name . "</h3>";

                $sql = "SELECT DISTINCT 
    m.model_name, 
    p.coast,
    p.podgotovka, 
    p.transport_coast, 
    p.coast + p.podgotovka + p.transport_coast AS 'Стоимость'
FROM 
    models AS m
JOIN 
    price_list AS p ON m.id = p.id 
JOIN 
    posrednik AS po ON m.id = po.id_model
JOIN 
    clients AS c ON po.id_client = c.id 
JOIN 
    postavshiki AS p2 ON m.id_postavshika = p2.id 
WHERE 
    p2.name_firma = ? AND
    c.buy_date BETWEEN ? AND ?";

                /*Первый запрос*/

                $result = R::getAll($sql, [$firm_name, $start_date, $end_date]);

                $sql_firm = "SELECT 
    phone, 
    email, 
    website, 
    city, 
    (SELECT SUM(coast + podgotovka + transport_coast) 
    FROM price_list
    JOIN models ON price_list.id = models.id
    WHERE models.name_firma = ? AND buy_date BETWEEN ? AND ?) AS total_coast
FROM postavshiki 
WHERE name_firma = ?";

                $result_firm = R::getAll($sql_firm, [$firm_name, $start_date, $end_date, $firm_name]);


                /*Таблица*/
                if (!empty($result)) {
                    echo "<table><thead>";
                    echo "<tr>";
                    echo "<th>Название модели</th>";
                    echo "<th>Цена</th>";
                    echo "<th>Предпродажная подготовка</th>";
                    echo "<th>Транспортные издержки</th>";
                    echo "<th>Стоимость</th>";
                    echo "</tr></thead><tbody>";

                    foreach ($result as $row) {
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
                }
                /*Таблица*/



                /*Третий запрос*/
                $sql_firm = "SELECT phone, email, website, city, (SELECT SUM(coast + podgotovka + transport_coast)
FROM price_list
JOIN models ON price_list.id = models.id
WHERE models.id IN (SELECT m.id FROM models m 
JOIN posrednik po ON m.id = po.id_model
JOIN clients c ON po.id_client = c.id 
WHERE c.buy_date BETWEEN ? AND ? AND m.id_postavshika = p2.id)
) AS total_coast
FROM postavshiki p2
WHERE name_firma = ?";

                try {
                    $result_firm = R::getAll($sql_firm, [$start_date, $end_date, $firm_name]);
                } catch (Exception $e) {
                    echo 'Error: ' . $e->getMessage();
                }

                if (!empty($result_firm)) {
                    foreach ($result_firm as $row_firm) {
                        echo "<h4>Итого по фирме: " . $row_firm['total_coast'] . "</h4>";
                    }
                } else {
                    echo "Нет данных.";
                }
                /*Третий запрос*/
            }

            /* Четвертый запрос */
            $sql = "SELECT 
    SUM(p.coast + p.podgotovka + p.transport_coast) AS TotalCost
    FROM clients c
    JOIN posrednik po ON po.id_client = c.id
    JOIN models m ON m.id = po.id_model
    JOIN price_list p ON m.id = p.id
    WHERE c.buy_date BETWEEN ? AND ?";

            $result = R::getAll($sql, [$start_date, $end_date]);

            if (!empty($result) && isset($result[0]['TotalCost'])) {
                echo "<h4>Общая стоимость всех проданных автомобилей: " . $result[0]['TotalCost'] . "<h4>";
            }
        } else {
            echo "<h3>Нет данных о фирмах.</h3>";
        }
    }

    R::close();
    ?>
</body>

</html>