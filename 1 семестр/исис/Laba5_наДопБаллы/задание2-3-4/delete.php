<?php
    class Database {
        private $conn;
        private $servername;
        private $username;
        private $password;
        private $dbname;
    
        public function __construct($servername = "localhost", $username = "root", $password = "", $dbname = "komercheskaya firma3") {
            $this->servername = $servername;
            $this->username = $username;
            $this->password = $password;
            $this->dbname = $dbname;
            
            $this->connect();
        }
    
        private function connect() {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            
            if ($this->conn->connect_error) {
                die("Ошибка подключения: " . $this->conn->connect_error);
            }
        }
        
        public function deleteRow($table, $id) {
            if (!isset($table) || !isset($id)) {
                header("Location: index.php");
                exit();
            }
            
            $deleteQuery = "DELETE FROM $table WHERE id = $id";
            if ($this->conn->query($deleteQuery) === TRUE) {
                header("Location: index.php");
                exit();
            } 
            else {
                echo "Ошибка удаления записи: " . $this->conn->error;
            }
        }
    
        public function closeConnection() {
            $this->conn->close();
        }
    }
    
    // Пример использования:
    $db = new Database();
    $db->deleteRow($_GET['table'], $_GET['id']);
    $db->closeConnection();
?>
