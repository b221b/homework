<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content='width=device-width, user-scaleble=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Laba 2</title>
</head>

<body>
    <?php
    echo 'новый текст 2';

    $conn = new mysqli("localhost", "root", "", "komercheskaya firma");
    $conn->query("SET NAMES 'utf8'");

    /* Проверка на подключение к базе*/
    if ($conn->connect_error) {
        echo 'Error number: ' . $conn->connect_errno . '<br>';
        echo 'Error: ' . $conn->connect_error;
    }
    /* Проверка на подключение к базе*/



    /*
    $sql = "SELECT * FROM clients";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Имя: " . $row["FIO"] . ", ID: " . $row["id"];
        }
    } else {
        echo "Нет данных.";
    }
*/

    $sql = "SELECT DISTINCT m.model_name, p.coast, p.podgotovka, p.transport_coast, p.coast + p.podgotovka + p.transport_coast AS Стоимость
    FROM models M
    JOIN price_list P ON M.id = P.id 
    JOIN clients C ON M.id = C.id 
    WHERE C.buy_date = '2023-01-09'";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "Название модели: " . $row["model_name"] . ", Цена: " . $row["coast"] . ", Предпродажная подготовка: " . $row["podgotovka"] . ", Транспортные издержки: " . $row["transport_coast"] . ", Стоимость: " . $row["Стоимость"] . "<br>";
        }
    } else {
        echo "Нет данных.";
        echo 'Error number: ' . $conn->connect_errno . '<br>';
        echo 'Error: ' . $conn->connect_error;
    }






    $conn->close();
    ?>
</body>

</html>