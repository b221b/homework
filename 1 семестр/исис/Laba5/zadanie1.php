<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        .user-info {
            margin-bottom: 20px;
        }

        .user-info h2,
        .user-info p {
            margin: 0 0 5px;
        }

        .user-info h2 {
            color: #333;
        }

        .user-info p {
            color: #666;
        }
    </style>

</head>

<body>


    <div php>
        <?php

        abstract class AUser
        {
            abstract public function showInfo();
        }

        class User extends AUser
        {
            private $name;
            private $login;
            private $password;
            private $email;

            public function __construct($name = "Guest", $login = "guest", $password = "qwerty", $email = "")
            {
                if (empty($name) || empty($login) || empty($password) || empty($email)) {
                    throw new Exception("Заполнены не все данные");
                }

                $this->name = $name;
                $this->login = $login;
                $this->password = $password;
                $this->email = $email;
            }

            public function __clone()
            {
                $this->name = "Cloned User";
                $this->login = "cloned_user";
                $this->password = "password";
                $this->email = "";
            }

            public function showInfo()
            {
                echo "<p>Name: " . $this->name . "</p>";
                echo "<p>Login: " . $this->login . "</p>";
                echo "<p>Password: " . $this->password . "</p>";
                echo "<p>Email: " . $this->email . "</p>";
            }

            public function getName()
            {
                return $this->name;
            }

            public function getLogin()
            {
                return $this->login;
            }

            public function getPassword()
            {
                return $this->password;
            }

            public function getEmail()
            {
                return $this->email;
            }
        }

        class SuperUser extends User
        {
            private $role;

            public function __construct($name = "Guest", $login = "guest", $password = "qwerty", $email = "", $role = "")
            {
                parent::__construct($name, $login, $password, $email);
                $this->role = $role;
            }

            public function showInfo()
            {
                parent::showInfo();
                echo "Role: " . $this->role . "<br>";
            }
        }

        try {
            echo "<html><head><style>
            body { font-family: Arial, sans-serif; }
            .user-info { margin-bottom: 20px; }
            .user-info h2, .user-info p { margin: 0 0 5px; }
            .user-info h2 { color: #333; }
            .user-info p { color: #666; }
                    </style></head><body>";

            echo "<div class='box'>";

            $user = new User("Miroslav", "shinji", "password", "titarenkomiroslav61@gmail.com");
            echo "<div class='user-info'>";
            echo "<h2>User Info:</h2>";
            $user->showInfo();
            echo "</div>";

            $clonedUser = clone $user;
            echo "<div class='user-info'>";
            echo "<h2>Cloned User Info:</h2>";
            $clonedUser->showInfo();
            echo "</div>";

            $superUser = new SuperUser("Admin", "admin", "password", "admin@example.com", "admin");
            echo "<div class='user-info'>";
            echo "<h2>SuperUser Info:</h2>";
            $superUser->showInfo();
            echo "</div>";

            $userWithoutData = new User("", "", "", ""); //пользователь с не заполненными полями

            echo "</div>";

            echo "</body></html>";
        } catch (Exception $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
</body>

</html>