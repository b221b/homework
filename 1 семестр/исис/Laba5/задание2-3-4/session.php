<div php>
    <?php
    class Session
    {
        public function __construct()
        {
            session_start();
        }

        public function setSessionVariable($name, $value)
        {
            $_SESSION[$name] = $value;
        }

        public function getSessionVariable($name)
        {
            if ($this->isSessionVariableExists($name)) {
                return $_SESSION[$name];
            }
            return null;
        }

        public function deleteSessionVariable($name)
        {
            if ($this->isSessionVariableExists($name)) {
                unset($_SESSION[$name]);
            }
        }

        public function isSessionVariableExists($name)
        {
            return isset($_SESSION[$name]);
        }
    }

    class Flash
    {
        private $session;
        private $flashKey = 'flash_messages'; // используется в качестве ключа в сессии для хранения flash сообщений

        public function __construct(Session $session)
        {
            $this->session = $session;

            // инициализирует flash сообщения в сессии, если они еще не были инициализированы
            if (!$this->session->isSessionVariableExists($this->flashKey)) {
                $this->session->setSessionVariable($this->flashKey, []);
            }
        }

        // сохраняет flash сообщение в сессию
        public function set($name, $value)
        {
            $flash_messages = $this->session->getSessionVariable($this->flashKey);
            $flash_messages[$name] = $value;
            $this->session->setSessionVariable($this->flashKey, $flash_messages);
        }

        // выводит сообщение из сессии, после чего удаляет его
        public function get($name)
        {
            $flash_messages = $this->session->getSessionVariable($this->flashKey);

            if (array_key_exists($name, $flash_messages)) {
                $message = $flash_messages[$name];
                unset($flash_messages[$name]);
                $this->session->setSessionVariable($this->flashKey, $flash_messages);
                return $message;
            }

            return null;
        }
    }

    $session = new Session();
    $flash = new Flash($session);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Если была отправлена форма с username
        if (isset($_POST['username']) && !empty($_POST['username'])) {
            $session->setSessionVariable('username', $_POST['username']);
        }

        // Если была нажата кнопка для проверки наличия переменной сессии
        if (isset($_POST['check'])) {
            if ($session->isSessionVariableExists('username')) {
                echo "<h2>Переменная username присутствует в сессии.<br></h2>";
            } else {
                echo "<h2>Переменная username не присутствует в сессии.<br>/<h2>";
            }
        }

        // Если была нажата кнопка для удаления переменной сессии
        if (isset($_POST['delete'])) {
            $session->deleteSessionVariable('username');
        }

        // если была отправлена форма с сообщением
        if (isset($_POST['message']) && !empty($_POST['message'])) {
            if ($session->isSessionVariableExists('username')) {
                // attach username to the message
                $message = $session->getSessionVariable('username') . ": " . $_POST['message'];
                $flash->set('message', $message);
            } else {
                echo "Сначала введите свой username перед отправкой сообщения.";
            }
        }
    }

    // проверяет и выводит сообщение, если оно есть в сессии
    $message = $flash->get('message');
    if (!is_null($message)) {
        echo "<h2>Flash сообщение: <br><br>" . $message . "<br><h2>";
    } else {
        echo "<h2>Flash сообщение не заполнено<br><h2>";
    }
    ?>
</div>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Demo</title>
    <style>
        .fooprefix_body {
            font-family: Arial, sans-serif;
            background-color: #fafafa;
            padding: 10px;
        }

        .fooprefix_box1 {
            display: none;
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 10px;
            width: 350px;
        }

        .fooprefix_form-group {
            margin-bottom: 15px;
        }

        .fooprefix_form-group label {
            display: block;
            font-weight: bold;
        }

        .fooprefix_form-group input,
        .fooprefix_form-group button {
            padding: 10px;
            font-size: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .fooprefix_form-group button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .fooprefix_form-group button:hover {
            background-color: #0056b3;
        }

        .fooprefix_showHideBtn {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            margin-bottom: 15px;
            cursor: pointer;
        }

        #fooprefix_showHideBtn {
            padding: 10px;
            font-size: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin-bottom: 15px;
        }

        #fooprefix_showHideBtn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body class="fooprefix_body">
    <div php>

    </div>

    <button class="fooprefix_form-group button" id="fooprefix_showHideBtn">Показать/Скрыть форму</button>

    <div class="fooprefix_box1" id="formContainer">
        <?php if ($session->isSessionVariableExists('username')) : ?>
            <p>Hello, <?php echo $session->getSessionVariable('username'); ?>!</p>
        <?php endif; ?>

        <form class="fooprefix_form-group" method="post">
            <fooprefix_form-group label for="username">Введите имя:</fooprefix_form-group label>
            <input type="text" id="username" name="username">
            <input type="submit" value="Выполнить">
        </form>

        <form class="fooprefix_form-group" method="post">
            <button class="fooprefix_form-group button" type="submit" name="check">Проверить username на наличие</button>
        </form>

        <form class="fooprefix_form-group" method="post">
            <button class="fooprefix_form-group button" type="submit" name="delete">Удалить username</button>
        </form>

        <div class="fooprefix_form-group">
            <form method="post">
                <fooprefix_form-group label for="message">Введите сообщение:</fooprefix_form-group label>
                <input type="text" id="message" name="message">

                <input type="submit" value="Отправить сообщение" <?php echo (!$session->isSessionVariableExists('username')) ? 'disabled' : '' ?>>
            </form>
        </div>
    </div>

    <script>
        var btn = document.getElementById("fooprefix_showHideBtn");
        var form = document.getElementById("formContainer");

        form.style.display = "none";

        btn.onclick = function() {
            if (form.style.display === "none") {
                form.style.display = "block";
                btn.innerHTML = "Скрыть форму";
            } else {
                form.style.display = "none";
                btn.innerHTML = "Показать форму";
            }
        }
    </script>
</body>

</html>