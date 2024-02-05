<!doctype html>
<html lang="en">

<head>
    <title>Car Purchase Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F8F8F8;
        }

        h1 {
            color: #007BFF;
        }

        form {
            background-color: #FFFFFF;
            border: 1px solid #CCCCCC;
            padding: 20px;
            border-radius: 8px;
            width: 20%;
            /* margin: 0 auto; */
        }

        label {
            font-weight: bold;
            color: #666666;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #BBBBBB;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0069D9;
        }

        div {
            margin-top: 20px;
            font-size: 17px;
            color: darkblue;
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

        table {
            width: 35%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #BBBBBB;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #F2F2F2;
        }

    </style>
</head>

<body>
    <br>
    <a href="index.php" class="button">Главная</a>
    <br><br>

    <?php require 'db.php'; ?>

    <form action="" method="POST">
        <label for="clientId">Select a client:</label>
        <select name="clientId" id="clientId">

            <?php
            $clients = R::getAll("SELECT id, FIO FROM clients");
            foreach ($clients as $client) {
                echo "<option value=" . $client['id'] . ">" . $client['FIO'] . " (" . $client['id'] . ")</option>";
            }
            ?>

        </select>
        <input type="submit" value="Выполнить">
    </form>

    <?php

    if (!empty($_POST["clientId"])) {

        $clientId = $_POST["clientId"];

        $queryResult = R::getAll(
            "SELECT c.FIO, m.model_name, pl.coast 
            FROM clients AS c
            JOIN posrednik AS p ON c.id = p.id_client
            JOIN models AS m ON p.id_model = m.id
            JOIN price_list AS pl ON m.id = pl.id
            WHERE c.id = :clientId;",
            [':clientId' => $clientId]
        );

        if (!empty($queryResult)) {

            // Start of table
            echo '<table>';
            echo '<thead><tr><th>ФИО</th><th>Название модели</th><th>Цена</th></tr></thead>';
            echo '<tbody>';

            foreach ($queryResult as $row) {
                echo '<tr>';
                echo "<td>" . $row["FIO"] . "</td>";
                echo "<td>" . $row["model_name"] . "</td>";
                echo "<td>" . $row["coast"] . "</td>";
                echo '</tr>';
            }

            // End of table
            echo '</tbody></table>';
        } else {
            echo "No purchase transactions found for this client.";
        }
    }

    ?>
</body>

</html>