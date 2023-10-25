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
    function executeQuery($sql) {
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
                                //Поставщики
    function displayDataPostavshiki() {
        $table = 'postavshiki';
        $sql = "SELECT * FROM $table";
        global $conn;
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<table class='table'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name Firma</th>";
            echo "<th>Phone</th>";
            echo "<th>Email</th>";
            echo "<th>Website</th>";
            echo "<th>City</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
    
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["name_firma"]."</td>";
                echo "<td>".$row["phone"]."</td>";
                echo "<td>".$row["email"]."</td>";
                echo "<td>".$row["website"]."</td>";
                echo "<td>".$row["city"]."</td>";
                echo "<td><a href='edit.php?table=$table&id=".$row["id"]."'>Edit</a> | <a href='delete.php?table=$table&id=".$row["id"]."'>Delete</a> | <a href='create.php?table=$table'>Create</a></td>";
                echo "</tr>";
            }
    
            echo "</table>";
        } else {
            echo "No data to display.";
        }
    }
    
    // Отображение данных таблицы 'postavshiki'
    echo "<h2>Postavshiki</h2>";
    displayDataPostavshiki('postavshiki');


                                //Модели
    function displayDataModels() {
        $table = 'Models';
        $sql = "SELECT * FROM $table";
        global $conn;
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<table class='table'>";

            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Model Name</th>";
            echo "<th>Color</th>";
            echo "<th>Obivka</th>";
            echo "<th>Engine Power</th>";
            echo "<th>Door Number</th>";
            echo "<th>Korobka Peredach</th>";
            echo "<th>Id Postavshika</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
    
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["model_name"]."</td>";
                echo "<td>".$row["color"]."</td>";
                echo "<td>".$row["obivka"]."</td>";
                echo "<td>".$row["engine_power"]."</td>";
                echo "<td>".$row["door_number"]."</td>";
                echo "<td>".$row["korobka_peredach"]."</td>";
                echo "<td>".$row["id_postavshika"]."</td>";
                echo "<td><a href='edit.php?table=$table&id=".$row["id"]."'>Edit</a> | <a href='delete.php?table=$table&id=".$row["id"]."'>Delete</a> | <a href='create.php?table=$table'>Create</a></td>";
                echo "</tr>";
            }
    
            echo "</table>";
        } else {
            echo "No data to display.";
        }
    }

    // Отображение данных таблицы 'models'
    echo "<h2>Models</h2>";
    displayDataModels('models');

                                //Клиенты
    function displayDataClients() {
        $table = 'Clients';
        $sql = "SELECT * FROM $table";
        global $conn;
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<table class='table'>";

            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>FIO</th>";
            echo "<th>Dogovor number</th>";
            echo "<th>Buy Date</th>";
            echo "<th>Phone</th>";
            echo "<th>Address</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
    
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["FIO"]."</td>";
                echo "<td>".$row["dogovor_number"]."</td>";
                echo "<td>".$row["buy_date"]."</td>";
                echo "<td>".$row["phone"]."</td>";
                echo "<td>".$row["address"]."</td>";
                echo "<td><a href='edit.php?table=$table&id=".$row["id"]."'>Edit</a> | <a href='delete.php?table=$table&id=".$row["id"]."'>Delete</a> | <a href='create.php?table=$table'>Create</a></td>" ;
                echo "</tr>";
            }
    
            echo "</table>";
        } else {
            echo "No data to display.";
        }
    }

    // Отображение данных таблицы 'clients'
    echo "<h2>Clients</h2>";
    displayDataClients('clients');

                                //Прайс лист
    function displayDataPriceList() {
        $table = 'price_list';
        $sql = "SELECT * FROM $table";
        global $conn;
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<table class='table'>";

            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>year start</th>";
            echo "<th>coast</th>";
            echo "<th>podgotovka</th>";
            echo "<th>Transport coast</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
    
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["year_start"]."</td>";
                echo "<td>".$row["coast"]."</td>";
                echo "<td>".$row["podgotovka"]."</td>";
                echo "<td>".$row["transport_coast"]."</td>";
                echo "<td><a href='edit.php?table=$table&id=".$row["id"]."'>Edit</a> | <a href='delete.php?table=$table&id=".$row["id"]."'>Delete</a> | <a href='create.php?table=$table'>Create</a></td>";
                echo "</tr>";
            }
    
            echo "</table>";
        } else {
            echo "No data to display.";
        }
    }

    // Отображение данных таблицы 'price_list'
    echo "<h2>Price List</h2>";
    displayDataPriceList('price_list');

                                //Посредник
    function displayDataPosrednik() {
        $table = 'Posrednik';
        $sql = "SELECT * FROM $table";
        global $conn;
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<table class='table'>";

            echo "<tr>";
            echo "<th>ID model</th>";
            echo "<th>ID client</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
    
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id_model"]."</td>";
                echo "<td>".$row["id_client"]."</td>";
                echo "<td><a href='edit.php?table=$table&id=".$row["id_model"]."'>Edit</a> | <a href='delete.php?table=$table&id=".$row["id_model"]."'>Delete</a> | <a href='create.php?table=$table'>Create</a></td>";
                echo "</tr>";
            }
    
            echo "</table>";
        } else {
            echo "No data to display.";
        }
    }

    // Отображение данных таблицы 'posrednik'
    echo "<h2>Posrednik</h2>";
    displayDataPosrednik('posrednik');





    
    $conn->close();
    ?>
    <h2>Add New Record</h2>
    <form action="create.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>
        <!-- Add other fields for the form based on the table structure -->
        <input type="submit" value="Add">
    </form>
</body>
</html>
