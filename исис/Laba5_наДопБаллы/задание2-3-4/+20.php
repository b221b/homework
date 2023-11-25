<?php

class DatabaseWrapper
{
    private $mysql;

    public function __construct($host, $user, $password, $database)
    {
        $this->mysql = new mysqli($host, $user, $password, $database);

        if ($this->mysql->connect_error) {
            die('Connect Error (' . $this->mysql->connect_errno . ') ' . $this->mysql->connect_error);
        }
    }

    public function query($sql)
    {
        $result = $this->mysql->query($sql);

        if (!$result) {
            die('Query Error (' . $this->mysql->errno . ') ' . $this->mysql->error);
        }

        return $result;
    }

    public function select($table, $columns, $where = '')
    {
        $sql = "SELECT $columns FROM $table";

        if ($where != '') {
            $sql .= " WHERE $where";
        }

        return $this->query($sql);
    }

    public function insert($table, $data)
    {
        $columns = implode(',', array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this->query($sql);
    }

    public function update($table, $data, $where)
    {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key='$value',";
        }
        $set = rtrim($set, ',');
        $sql = "UPDATE $table SET $set WHERE $where";
        return $this->query($sql);
    }

    public function delete($table, $where)
    {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->query($sql);
    }

    public function truncate($table)
    {
        $sql = "TRUNCATE TABLE $table";
        return $this->query($sql);
    }

    public function fetchAssoc($result)
    {
        return $result->fetch_assoc();
    }

    public function fetchAll($result)
    {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function escapeString($value)
    {
        return $this->mysql->real_escape_string($value);
    }

    public function fetchDataFromTable($table)
    {
        $sql = "SELECT * FROM $table";
        $result = $this->query($sql);
        $data = $this->fetchAll($result);
        return $data;
    }
}

$database = new DatabaseWrapper('localhost', 'root', '', 'komercheskaya_firma5');

// Получение списка таблиц
$tables = $database->query('SHOW TABLES');

// Преобразование списка таблиц в виде выпадающего списка
echo '<select name="table" id="table">';
while ($row = $database->fetchAssoc($tables)) {
    echo '<option value="' . $row['Tables_in_komercheskaya_firma5'] . '">' . $row['Tables_in_komercheskaya_firma5'] . '</option>';
}
echo '</select>';

$table = $_POST['table']; // This assumes you're using a POST request to send the selected table
$data = $database->fetchDataFromTable($table);

if ($data) {
    echo "Information:<br>";
    foreach ($data as $row) {
        foreach ($row as $key => $value) {
            echo "$key: $value<br>";
        }
        echo "<hr>";
    }
} else {
    echo "Data not found.";
}

?>