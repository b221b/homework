<?php

abstract class AUser {
    abstract public function showInfo();
}

class User extends AUser {
    private $name;
    private $login;
    private $password;
    private $email;

    public function __construct($name = "Guest", $login = "guest", $password = "qwerty", $email = "") {
        if (empty($name) || empty($login) || empty($password) || empty($email)) {
            throw new Exception("Заполнены не все данные");
        }

        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
    }

    public function __clone() {
        $this->name = "Cloned User";
        $this->login = "cloned_user";
        $this->password = "password";
        $this->email = "";
    }

    public function showInfo() {
        echo "Name: " . $this->name . "<br>";
        echo "Login: " . $this->login . "<br>";
        echo "Password: " . $this->password . "<br>";
        echo "Email: " . $this->email . "<br>";
    }
    
    public function getName() {
        return $this->name;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }
}

class SuperUser extends User {
    private $role;

    public function __construct($name = "Guest", $login = "guest", $password = "qwerty", $email = "", $role = "") {
        parent::__construct($name, $login, $password, $email);
        $this->role = $role;
    }

    public function showInfo() {
        parent::showInfo();
        echo "Role: " . $this->role . "<br>";
    }
}

try {
    $user = new User("Miroslav", "shinji", "password", "titarenkomiroslav61@gmail.com");
    echo "User Info:<br>";
    $user->showInfo();
    echo "<br>";

    $clonedUser = clone $user;
    echo "Cloned User Info:<br>";
    $clonedUser->showInfo();
    echo "<br>";

    $superUser = new SuperUser("Admin", "admin", "password", "admin@example.com", "admin");
    echo "SuperUser Info:<br>";
    $superUser->showInfo();
    echo "<br>";

    $userWithoutData = new User("Elena Nikolaevna", "qwe", "password", "pochta@gmail.com"); // Попытка создать объект с недостаточными данными
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
