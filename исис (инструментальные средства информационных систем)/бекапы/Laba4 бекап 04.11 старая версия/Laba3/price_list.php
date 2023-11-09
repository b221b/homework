<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>PHP Database CRUD Interface</title>
    <style>
        /* Adding a smooth font and a bit margin for the body */
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
        }

        /* Styling the table */
        .table {
            border-collapse: collapse;
            width: 70%;
            margin-bottom: 20px;
            font-size: 0.9em;
            color: #333;
        }

        /* Making the borders a bit thinner and a lighter color */
        .table,
        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        /* Changing the background color of the table headings, and making the text a bit larger and bold */
        .table th {
            background-color: #f2f2f2;
            color: #111;
            text-transform: uppercase;
            font-weight: bold;
        }

        /* Adding a hover effect to rows */
        .table tr:hover {
            background-color: #f2f2f2;
        }

        /* Styling the links */
        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Adding a bit of margin to the form, and aligning text to the right (looks better with the form inputs) */
        form {
            margin-top: 20px;
            text-align: right;
        }

        /* Styling the labels */
        label {
            padding: 10px;
            display: inline-block;
            width: 100px;
        }

        /* Styling the inputs */
        input[type="text"] {
            padding: 5px;
            width: 200px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 5px 10px;
            background-color: #0066cc;
            border: none;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #004d99;
        }
    </style>
</head>

<body>
    <?php
    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "Komercheskaya firma";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    // Функция для выполнения запросов к базе данных
    function executeQuery($sql)
    {
        global $conn;
        $result = $conn->query($sql);

        if ($result === TRUE) {
            return true;
        } elseif ($result === FALSE) {
            echo "Ошибка выполнения запроса: " . $conn->error;
            return false;
        } else {
            return $result;
        }
    }

    // Функция для отображения данных из таблицы
    //Прайс лист
    function displayDataPriceList()
    {
        $table = 'price_list';
        $sql = "SELECT * FROM $table";
        global $conn;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table'>";

            echo "<tr>";
            echo "<th>Год выпуска</th>";
            echo "<th>Цена</th>";
            echo "<th>Предпродажная подготовка</th>";
            echo "<th>Транспортные издержки</th>";
            echo "<th>Действия</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["year_start"] . "</td>";
                echo "<td>" . $row["coast"] . "</td>";
                echo "<td>" . $row["podgotovka"] . "</td>";
                echo "<td>" . $row["transport_coast"] . "</td>";
                echo "<td><a href='edit.php?table=$table&id=" . $row["id"] . "'>Изменить</a> | <a href='delete.php?table=$table&id=" . $row["id"] . "'>Удалить</a> </td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No data to display.";
        }
    }

    // Отображение данных таблицы 'price_list'
    echo "<h2>Прайс лист</h2>";
    displayDataPriceList('price_list');

    $table = 'price_list';
    echo "<a href='create.php?table=$table' style='display: inline-block; width: 150px; height: 50px; background-color: #ccc; text-align: center; line-height: 50px; border-radius: 5px;'>Добавить запись</a>";






    $conn->close();
    ?>

</body>

</html>