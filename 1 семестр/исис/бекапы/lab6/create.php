<?php

// The data table is now hardcoded
$table = "models";

// Connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "miroslav";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

// Fields are now hardcoded
$fields = array(
    "model_name", 
    "color", 
    "obivka", 
    "engine_power", 
    "door_number", 
    "korobka_peredach", 
    "id_postavshika", 
    "flag"
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the max id value
    $max_id = $conn->query("SELECT MAX(id) FROM $table")->fetch_row()[0];
    $max_id = is_null($max_id) ? 1 : $max_id + 1;  // If the table is empty, we set id = 1

    // Creating a new record (insert)
    $insertQuery = "INSERT INTO $table (id, ";
    $values = "VALUES ($max_id, ";

    foreach ($fields as $field) {
        if (isset($_POST[$field])) { 
            $value = $conn->real_escape_string($_POST[$field]);
            $insertQuery .= "$field, ";
            $values .= "'$value', ";
        }
    }

    $insertQuery = rtrim($insertQuery, ", ") . ") ";
    $values = rtrim($values, ", ") . ");";
    $insertQuery .= $values;

    $conn->query($insertQuery);

    // Redirect to the main page
    header("Location: index.php");
    exit();
}

// Form to add a new entry
echo "<h2>Add new record</h2>";
echo "<form action='' method='POST'>";

foreach ($fields as $field) {
    echo "<label>{$field}:</label><br>";
    echo "<input type='text' name='{$field}'><br>";
}

echo "<input type='submit' value='Add'>";
echo "</form>";

$conn->close();
?>