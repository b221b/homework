<!DOCTYPE html>
<html>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Расписание</title>
    <style>
        /*задний фон*/
        body {
            background: linear-gradient(to bottom right, #1a2a6c, #b21f1f, #ed760e, #13772C, #011627);
            color: #512da8;
            font-family: Arial, sans-serif;
        }

        h1,
        h2 {
            color: #7e57c2;
            /* Medium purple headers */
            text-align: center;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Viewport Height */
            text-align: center;
        }

        .box {
            border: 1px solid #512da8;
            /* Dark purple border */
            border-radius: 15px;
            padding: 30px;
            background-color: #ffffff;
            /* White background */
            width: 40%;
            word-wrap: break-word;
        }







        .blubtn {
            width: 155px;
            text-align: center;
            display: block;
            font-family: arial;
            text-decoration: none;
            font-weight: 300;
            font-size: 25px;
            border: #1071FF 3px solid;
            color: #1071FF;
            padding: 3px;
            padding-left: 5px;
            padding-right: 5px;
            margin: 25px auto;
            transition: .5s;
            border-radius: 0px;
        }

        .blubtn:hover {
            top: 5px;
            transition: .5s;
            color: #10FF58;
            border: #10FF58 1px solid;
            border-radius: 10px;
        }

        .blubtn:active {
            color: #000;
            border: #1A1A1A 1px solid;
            transition: .07s;
            background-color: #FFF;
        }



        .button-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="center">
        <div class="box">
            <h2>Выберите таблицу:</h2>
            <div class="button-container">
                <button class="blubtn" onclick="location.href='models.php'">Модели</button>
                <button class="blubtn" onclick="location.href='Clients.php'">Клиенты</button>
            </div>
            <div class="button-container">
                <button class="blubtn" onclick="location.href='Postavshiki.php'">Поставщики</button>
                <button class="blubtn" onclick="location.href='price_list.php'">Прайс лист</button>
            </div>
        </div>
    </div>
</body>

</html>