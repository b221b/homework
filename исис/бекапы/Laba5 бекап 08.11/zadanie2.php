<!DOCTYPE html>
<html>

<head>
    <title>Список поставщиков</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        h1 {
            color: #444;
            text-align: center;
            padding: 20px 0;
        }

        #data-table {
            margin: 0 auto;
            width: 80%;
            border-collapse: collapse;
        }

        #data-table th,
        #data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #data-table th {
            background-color: #4CAF50;
            color: white;
        }

        p {
            text-align: center;
            padding: 20px 0;
        }

        .success,
        .error {
            color: white;
            text-align: center;
            padding: 20px;
            margin: 0;
        }

        .success {
            background-color: #4CAF50;
        }

        .error {
            background-color: #f44336;
        }




        .button-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
            margin-bottom: 20px;
        }

        .butt {
            /* text-align: center; */
            /* font-size: 13px; */
            /* text-decoration: none; */
            font-weight: 700;
            padding: 5px 6px;
            background: #eaeef1;
            /* display: block; */
            width: 100px;
            /* margin: 20px auto; */
            background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, .1));
            border-radius: 3px;
            color: rgba(0, 0, 0, .6);
            text-shadow: 0 1px 1px rgba(255, 255, 255, .7);
            box-shadow: 0 0 0 1px rgba(0, 0, 0, .2), 0 1px 2px rgba(0, 0, 0, .2), inset 0 1px 2px rgba(255, 255, 255, .7);
        }

        .butt:hover,
        .butt.hover {
            background: #fff;
        }

        .butt:active,
        .butt.active {
            background: #d0d3d6;
            background-image: linear-gradient(rgba(0, 0, 0, .1), rgba(0, 0, 0, 0));
            box-shadow: inset 0 0 2px rgba(0, 0, 0, .2), inset 0 2px 5px rgba(0, 0, 0, .2), 0 1px rgba(255, 255, 255, .2);
        }
    </style>
</head>

<body>
    <h1>Список поставщиков</h1>

    <div php>
        <?php
        if (isset($_POST['action'])) {
            $databaseManager = new DatabaseManager("localhost", "root", "", "komercheskaya firma3");
            $databaseManager->connect();

            switch ($_POST['action']) {
                case 'get_data':
                    // Получение данных из таблицы
                    $data = $databaseManager->getData("postavshiki");
                    //var_dump($data);
                    break;

                case 'insert_data':
                    // Добавление данных в таблицу
                    $newData = array(
                        "name_firma" => "Новая фирма",
                        "phone" => "123456789",
                        "email" => "test@example.com",
                        "website" => "example.com",
                        "city" => "Новый город",
                        "flag" => 1
                    );
                    $result = $databaseManager->insertData("postavshiki", $newData);
                    if ($result) {
                        echo "Данные успешно добавлены";
                    } else {
                        echo "Ошибка при добавлении данных";
                    }
                    break;

                case 'delete_data':
                    $condition = "flag = 1";
                    $newData = array(
                        'flag' => 0
                    );
                    $result = $databaseManager->updateData('postavshiki', $newData, $condition);
                    if ($result) {
                        echo "Данные успешно обновлены";
                    } else {
                        echo "Ошибка при обновлении данных";
                    }
                    break;

                case 'create_data':
                    $condition = "flag = 0";
                    $newData = array(
                        'flag' => 1
                    );
                    $result = $databaseManager->updateData('postavshiki', $newData, $condition);
                    if ($result) {
                        echo "Данные успешно обновлены";
                    } else {
                        echo "Ошибка при обновлении данных";
                    }
                    break;

                case 'update_data':
                    // Редактирование данных в таблице
                    $updateData = array(
                        "name_firma" => "Измененная фирма",
                        "phone" => "987654321",
                        "email" => "updated@example.com",
                        "website" => "updated.com",
                    );
                    $condition = "id = 24";
                    $result = $databaseManager->updateData("postavshiki", $updateData, $condition);
                    if ($result) {
                        echo "Данные успешно обновлены";
                    } else {
                        echo "Ошибка при обновлении данных";
                    }
                    break;

                case 'truncate_table':
                    // Очистка таблицы
                    $result = $databaseManager->truncateTable("postavshiki");
                    if ($result) {
                        echo "Таблица успешно очищена";
                    } else {
                        echo "Ошибка при очистке таблицы";
                    }
                    break;

                case 'select_data':
                    // Выборка данных с условием
                    $condition = "name_firma LIKE 'Д%'";
                    $data = $databaseManager->selectData("postavshiki", "*", $condition);
                    //var_dump($data);
                    break;
            }
        }



        class DatabaseManager
        {
            private $host;
            private $username;
            private $password;
            private $database;
            private $connection;

            public function __construct($host, $username, $password, $database)
            {
                $this->host = $host;
                $this->username = $username;
                $this->password = $password;
                $this->database = $database;
            }

            public function connect()
            {
                $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
                if (!$this->connection) {
                    die("Connection failed: " . mysqli_connect_error());
                }
            }

            public function executeQuery($query)
            {
                return mysqli_query($this->connection, $query);
            }

            public function getData($table)
            {
                $query = "SELECT * FROM $table";
                $result = $this->executeQuery($query);
                $data = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
                return $data;
            }

            public function insertData($table, $data)
            {
                $columns = implode(", ", array_keys($data));
                $values = "'" . implode("', '", array_values($data)) . "'";
                $query = "INSERT INTO $table ($columns) VALUES ($values)";
                return $this->executeQuery($query);
            }

            public function deleteData($table, $condition)
            {
                $query = "DELETE FROM $table WHERE $condition";
                return $this->executeQuery($query);
            }

            public function updateData($table, $data, $condition)
            {
                $setValues = [];
                foreach ($data as $key => $value) {
                    $setValues[] = "$key='$value'";
                }
                $setValues = implode(", ", $setValues);
                $query = "UPDATE $table SET $setValues WHERE $condition";
                return $this->executeQuery($query);
            }

            public function truncateTable($table)
            {
                $query = "UPDATE $table SET flag = 0 WHERE flag = 1";
                return $this->executeQuery($query);
            }

            public function selectData($table, $columns = "*", $condition = "")
            {
                $query = "SELECT $columns FROM $table";
                if (!empty($condition)) {
                    $query .= " WHERE $condition";
                }
                $result = $this->executeQuery($query);
                $data = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
                return $data;
            }
        }

        ?>
    </div>

    <?php if (!empty($data)) : ?>
        <table id="data-table">
            <tr>
                <th>Название фирмы</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Вебсайт</th>
                <th>Город</th>
                <th>флаг</th>
            </tr>
            <?php foreach ($data as $row) : ?>
                <tr>
                    <td><?php echo (isset($row['name_firma']) ? $row['name_firma'] : ''); ?></td>
                    <td><?php echo (isset($row['phone']) ? $row['phone'] : ''); ?></td>
                    <td><?php echo (isset($row['email']) ? $row['email'] : ''); ?></td>
                    <td><?php echo (isset($row['website']) ? $row['website'] : ''); ?></td>
                    <td><?php echo (isset($row['city']) ? $row['city'] : ''); ?></td>
                    <td><?php echo (isset($row['flag']) ? $row['flag'] : ''); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No data found.</p>
    <?php endif; ?>

    <form method="POST">
        <div class="button-container">
            <button type="submit" class="butt" name="action" value="get_data">Получить данные</button>
            <button type="submit" class="butt" name="action" value="insert_data">Добавить данные</button>
            <button type="submit" class="butt" name="action" value="delete_data">Удаление данных</button>
            <button type="submit" class="butt" name="action" value="create_data">Вернуть обратно единички</button>
            <button type="submit" class="butt" name="action" value="update_data">Обновление данных</button>
            <button type="submit" class="butt" name="action" value="truncate_table">Очистка таблицы</button>
            <button type="submit" class="butt" name="action" value="select_data">Выборка данных</button>
        </div>
    </form>
</body>

</html>