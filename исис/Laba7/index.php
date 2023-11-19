<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="number"] {
            margin-bottom: 20px;
            padding: 5px;
        }

        input[type="submit"],
        .clear-btn {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .clear-btn {
            margin-left: 10px;
            background-color: #dc3545;
        }

        .clear-btn:active {
            background-color: #c82333;
        }

        input[type="submit"]:active {
            background-color: #0069D9;
        }

        table {
            width: 70%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>

<body>
    <div php>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "komercheskaya firma4";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        echo '<form method="POST">';
        echo '<label for="minPrice">Минимальная цена:</label>';
        echo '<input type="number" id="minPrice" name="minPrice" value="' . $_POST["minPrice"] . '"><br>';
        echo '<label for="maxPrice">Максимальная цена:</label>';
        echo '<input type="number" id="maxPrice" name="maxPrice" value="' . $_POST["maxPrice"] . '"><br>';
        echo '<input type="submit" value="Search">';
        echo '<input type="button" class="clear-btn" value="Clear" onclick="clearForm()">';
        echo '</form>';

        echo '<script type="text/javascript">
function clearForm(){
    document.getElementById("minPrice").value = "";
    document.getElementById("maxPrice").value = "";
    var resultTable = document.getElementById("resultTable");
    if (resultTable) {
        resultTable.style.display = "none";
    }
}
</script>';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $minPrice = $_POST["minPrice"];
            $maxPrice = $_POST["maxPrice"];

            $sql = "SELECT models.model_name, models.color, models.obivka, models.engine_power, models.door_number, models.korobka_peredach, price_list.coast FROM models 
    INNER JOIN price_list ON models.id = price_list.id 
    WHERE price_list.coast BETWEEN " . $minPrice . " AND " . $maxPrice;

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table id="resultTable">';
                echo '<tr>
                    <th>Модель</th>
                    <th>Цвет</th>
                    <th>Обивка</th>
                    <th>Мошность</th>
                    <th>Кол-во дверей</th>
                    <th>Коробка передач</th>
                    <th>Цена</th>
                    </tr>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr><td>' . $row["model_name"] . '</td><td>' . $row["color"] . '</td><td>' . $row["obivka"] . '</td><td>' . $row["engine_power"] . '</td><td>' . $row["door_number"] . '</td><td>' . $row["korobka_peredach"] . '</td><td>' . $row["coast"] . '</td></tr>';
                }
                echo '</table>';
            } else {
                echo "No results";
            }
        }
        $conn->close();
        ?>
    </div>
</body>

</html>