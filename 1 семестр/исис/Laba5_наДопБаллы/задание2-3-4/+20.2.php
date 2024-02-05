<?php

class DatabaseWrapper
{
    private $db_host;
    private $db_user;
    private $db_password;
    private $db_name;
    private $mysql;

    public function __construct($host, $user, $password, $db)
    {
        $this->db_host = $host;
        $this->db_user = $user;
        $this->db_password = $password;
        $this->db_name = $db;

        $this->connect();
    }

    private function connect()
    {
        $this->mysql = @new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);

        if ($this->mysql->connect_error) {
            echo 'Errno: ' . $this->mysql->connect_errno;
            echo '<br>';
            echo 'Error: ' . $this->mysql->connect_error;
            exit();
        }
    }

    public function query($sql)
    {
        return $this->mysql->query($sql);
    }

    public function select($table, $columns = '*', $where = '')
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
}

$database = new DatabaseWrapper('localhost', 'root', '', 'komercheskaya_firma5');

if ($_POST['action'] == 'select') {
    $result = $database->select('postavshiki', '*', 'id=10');
    $data = $database->fetchAssoc($result);

} elseif ($_POST['action'] == 'insert') {
    $insertData = array(
        'name_firma' => 'newuser',
        'phone' => '123',
        'email' => 'newuser@example.com',
        'website' => 'newwebsite.com',
        'city' => 'newcity',
        'flag' => '1'
    );

    $database->insert('postavshiki', $insertData);
    echo '<h1>Добавлен поставщик newuser </h1>';

} elseif ($_POST['action'] == 'update') {
    $updateData = array('phone' => '896123');
    $database->update('postavshiki', $updateData, "name_firma='newuser'");
    echo '<h1>у поставщика newuser обновлен телефон</h1>';
    
} elseif ($_POST['action'] == 'delete') {
    $database->delete("postavshiki", "name_firma='newuser'");
    echo '<h1>Поставщик newuser удален</h1>';
}
