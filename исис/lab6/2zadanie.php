<!DOCTYPE html>
<html>

<head>
    <title>Car Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F8F8F8;
        }

        h1 {
            color: #007BFF;
        }

        form {
            background-color: #FFFFFF;
            border: 1px solid #CCCCCC;
            padding: 20px;
            border-radius: 8px;
            width: 20%;
            /* margin: 0 auto; */
        }

        label {
            font-weight: bold;
            color: #666666;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #BBBBBB;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0069D9;
        }

        div {
            margin-top: 20px;
            font-size: 17px;
            color: darkblue;
        }

        .button {
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            text-decoration: none;
            margin: 2px 2px;
            transition-duration: 0.4s;
            background-color: #4169e1;
            color: white;
            font-weight: bold;
        }

        .button:hover {
            background-color: #696969;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <a href="index.php" class="button">Главная</a>

    <?php require 'db.php'; ?>

    <h1>Введите данные</h1>
    <form action="" method="POST">
        <label for="model">Название машины:</label><br>
        <select id="model" name="model" required>
            <?php
            $models = R::findAll('models');
            foreach ($models as $model) {
                echo "<option value='" . $model->model_name . "'>" . $model->model_name . "</option>";
            }
            ?>
        </select><br>

        <label for="korobka_peredach">Тип трансмиссии:</label><br>
        <input type="text" id="korobka_peredach" name="korobka_peredach" required><br>
        <input type="submit" value="Выполнить">
    </form>

    <div>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $model = $_POST['model'];
            $korobka_peredach = $_POST['korobka_peredach'];

            $model = R::findOne('models', 'model_name = ? AND korobka_peredach = ?', [$model, $korobka_peredach]);

            // If the model exists, print its price details
            if ($model) {
                $prices = R::find('price_list', 'id = ?', [$model->id]);

                foreach ($prices as $price) {
                    echo 'Year start: ' . $price->year_start . '</br>';
                    echo 'Coast: ' . $price->coast . '</br>';
                    echo 'Podgotovka: ' . $price->podgotovka . '</br>';
                    echo 'Transport coast: ' . $price->transport_coast . '</br></br>';
                }
            } else {
                echo 'No car model found for your request';
            }
        }
        ?>
    </div>
</body>

</html>