<?php
/*подключение к серверу и проверка подключения*/
$conn = new mysqli("localhost", "root", "", "komercheskaya firma");
$conn->query("SET NAMES 'utf8'");

if ($conn->connect_error) {
    die('Error number: ' . $conn->connect_errno . '<br>Error: ' . $conn->connect_error);
}
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
    </style>
</head>

<body>
    <form method="post" action="">
        <label for="date">Выберите дату:</label>
        <select id="date" name="date" required>
            <?php
            $sql_dates = "SELECT DISTINCT buy_date FROM clients ORDER BY buy_date";
            $dates_result = $conn->query($sql_dates);

            if ($dates_result->num_rows > 0) {
                while ($date_row = $dates_result->fetch_assoc()) {
                    $formatted_date = date('Y-m-d', strtotime($date_row["buy_date"]));
                    echo "<option value='" . $formatted_date . "'>" . $formatted_date . "</option>";
                }
            } else {
                echo "<option>Нет данных</option>";
            }
            ?>
        </select>
        <input type="submit" class="btn" value="Отправить">
    </form>

    <?php
    /*подключение к серверу и проверка подключения*/
    $conn = new mysqli("localhost", "root", "", "komercheskaya firma");
    $conn->query("SET NAMES 'utf8'");

    if ($conn->connect_error) {
        echo 'Error number: ' . $conn->connect_errno . '<br>';
        echo 'Error: ' . $conn->connect_error;
    }
    /*подключение к серверу и проверка подключения*/

    echo '<h3 style="text-align:left; font-weight:bold;">Отчет о реализации автомобилей</h3>';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST["date"])) {

            $date = $_POST["date"];
            // convert date to 'Y-m-d' format if it's not already
            $date = date('Y-m-d', strtotime($date));

            /*Первый запрос*/
            $sql = "SELECT DISTINCT 
        m.model_name, 
        p.coast, 
        p.podgotovka, 
        p.transport_coast, 
        ps.name_firma, 
        p.coast + p.podgotovka + p.transport_coast AS Стоимость
    FROM 
        models AS m
    JOIN 
        price_list AS p ON m.id = p.id 
    JOIN 
        posrednik AS po ON m.id = po.id_model
    JOIN 
        clients AS c ON po.id_client = c.id 
    JOIN 
        postavshiki AS ps ON m.id_postavshika = ps.id
    WHERE 
        c.buy_date = '$date'";

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
                echo "<th>Название фирмы</th>";
                echo "</tr></thead><tbody>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["model_name"] . "</td>";
                    echo "<td>" . $row["coast"] . "</td>";
                    echo "<td>" . $row["podgotovka"] . "</td>";
                    echo "<td>" . $row["transport_coast"] . "</td>";
                    echo "<td>" . $row["Стоимость"] . "</td>";
                    echo "<td>" . $row["name_firma"] . "</td>";
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
      WHERE name_firma='Firma1' AND buy_date = '$date') AS total_coast
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
        } else {
            echo "Дата не передана.";
        }
    }


    $conn->close();
    ?>
</body>

</html>