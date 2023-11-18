//  document.body.innerHTML += '<h1>Сервер запущен</h1><img src="images/js.png" width="150px"><p>↑ вот картинка</p>';

const express = require('express');
const app = express();
const mysql = require('mysql');

// Это позволит вам служить файлам из папки "public"
app.use(express.static(__dirname + '/public'));

// Установите EJS в качестве шаблонизатора
app.set('view engine', 'ejs');

const path = require('path');
app.set('views', path.join(__dirname, '../views'));

// Создание подключения
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'js'
});

// Установка соединения
connection.connect((err) => {
  if (err) {
    console.error('Ошибка подключения:', err);
    return;
  }
  console.log('Подключение к базе данных успешно установлено!');
});

app.get('/', (req, res) => {
  // Выполнение запроса
  const sqlQuery = 'SELECT * FROM models';
  connection.query(sqlQuery, (err, results) => {
    if (err) {
      console.error('Ошибка выполнения запроса:', err);
      return;
    }
    // отправка данных в виде ответа
    res.render('models', { data: results });
  });
});

app.listen(3000, function() {
  console.log('Сервер работает на порту 3000');
});