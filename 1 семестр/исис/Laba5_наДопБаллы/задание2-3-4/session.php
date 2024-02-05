<?php
class Session
{
    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['users'])) {
            $_SESSION['users'] = [];
        }
    }

    public function setSessionVariable($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function getSessionVariable($name)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function deleteSessionVariable($name)
    {
        if (isset($_SESSION['users'][$name])) {
            $_SESSION['users'] = array_filter($_SESSION['users'], function ($key) use ($name) {
                return $key !== $name;
            }, ARRAY_FILTER_USE_KEY);
        }
    }

    public function checkSessionVariable($name)
    {
        return isset($_SESSION[$name]);
    }

    public function setMultipleSessionVariables(array $data)
    {
        $_SESSION['users'] = array_merge($_SESSION['users'], $data);
    }
}

$session = new Session();
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $session->setMultipleSessionVariables([$username => ['username' => $username, 'password' => $password]]);
}

if (isset($_POST['delete_user'])) {
    $username = $_POST['username'];
    $session->deleteSessionVariable($username);
}

$users = $session->getSessionVariable('users'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1,
        h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 10%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        table {
            width: 30%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Users</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" />
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" />
        <br><br>

        <button type="submit" name="add_user">Add User</button>
    </form>

    <h2>List of Users</h2>

    <table border="1">
        <tr>
            <th>Username</th>
            <th>Password</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $username => $userData) : ?>
            <tr>
                <td><?php echo $username; ?></td>
                <td><?php echo $userData['password']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="username" value="<?php echo $username; ?>" />
                        <button type="submit" name="delete_user">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>