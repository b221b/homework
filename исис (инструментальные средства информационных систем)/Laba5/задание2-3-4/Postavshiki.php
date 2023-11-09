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

        .table1 {
            /* margin: 0 auto; */
            width: 80%;
            border-collapse: collapse;
        }

        .table1 th,
        .table1 td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table1 th {
            background-color: #4CAF50;
            color: white;
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
    <a href="index.php" style='display: inline-block; width: 80px; height: 45px; background-color: #ccc; text-align: center; line-height: 45px; border-radius: 5px;'>Главная</a><br><br>

    <?php require_once('session.php'); ?>

    <?php

    class Postavshiki
    {
        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "Komercheskaya firma3";

        private $conn;

        function __construct()
        {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

            if ($this->conn->connect_error) {
                die("Ошибка подключения к базе данных: " . $this->conn->connect_error);
            }
        }

        function __destruct()
        {
            $this->conn->close();
        }

        function executeQuery($sql)
        {
            $result = $this->conn->query($sql);

            if ($result === TRUE) {
                return true;
            } elseif ($result === FALSE) {
                echo "Ошибка выполнения запроса: " . $this->conn->error;
                return false;
            } else {
                return $result;
            }
        }

        function displayData($table, $fields, $headers)
        {
            $sql = "SELECT * FROM $table";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table1'>";
                echo "<tr>";
                foreach ($headers as $header) {
                    echo "<th>$header</th>";
                }
                echo "<th>Действия</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($fields as $field) {
                        echo "<td>" . $row[$field] . "</td>";
                    }
                    echo "<td><a href='edit.php?table=$table&id=" . $row["id"] . "'>Изменить</a> | <a href='delete.php?table=$table&id=" . $row["id"] . "'>Удалить</a> </td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "No data to display.";
            }
        }
    }

    $Postavshiki = new Postavshiki();
    echo "<h2>Поставщики</h2>";
    $Postavshiki->displayData('postavshiki', ['name_firma', 'phone', 'email', 'website', 'city'], ['Название фирмы', 'Телефон', 'Почта', 'Сайт', 'Город']);
    $table = 'Postavshiki';
    echo "<a href='create.php?table=$table' style='display: inline-block; width: 150px; height: 50px; background-color: #ccc; text-align: center; line-height: 50px; border-radius: 5px;'>Добавить запись</a>";
    ?>

</body>

</html>