//  document.body.innerHTML += '<h1>Сервер запущен</h1><img src="images/js.png" width="150px"><p>↑ вот картинка</p>';

const express = require('express');
const app = express();
const mysql = require('mysql');
const fs = require('fs');

app.use(express.static(__dirname + '/public'));

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'javascript'
});

connection.connect((err) => {
  if (err) {
    console.error('Ошибка подключения:', err);
    return;
  }
  console.log('Подключение к базе данных успешно установлено!');
});

app.get('/', (req, res) => {
  const sqlQuery = 'SELECT * FROM models';

  connection.query(sqlQuery, (err, results) => {
    if (err) {
      console.error('Ошибка выполнения запроса:', err);
      return;
    }
    // Читаем файл index.html
    fs.readFile(__dirname + '/index.html', 'utf8', (err, data) => {
      if (err) {
        console.error('Ошибка чтения файла:', err);
        return;
      }

      // Заменяем метку {{models}} результатами из базы данных
      const result = data.replace('{{models}}', JSON.stringify(results));

      // Отправляем результат
      res.send(result);
    });
  });
});

app.listen(3000, function() {
  console.log('Сервер работает на порту 3000');
});