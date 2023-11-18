//  document.body.innerHTML += '<h1>Сервер запущен</h1><img src="images/js.png" width="150px"><p>↑ вот картинка</p>';

const express = require('express');
const app = express();
const mysql = require('mysql');
const routes = require('./routes');

routes(app, mysql);

const bodyParser = require('body-parser');
const formidable = require('express-formidable');

// Это позволит вам служить файлам из папки "public"
app.use(express.static(__dirname + '/public'));

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(formidable());

app.use(function (err, req, res, next) {
  console.error(err.stack);
  res.status(500).send('Something broke!');
});

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

app.get('../views/create-model', (req, res) => {
  res.render('create-model');
});

app.post('/models', (req, res) => {
  const sqlQuery = 'INSERT INTO models SET ?';
  const data = {
    model_name: req.body.model_name,
    color: req.body.color,
    obivka: req.body.obivka,
    engine_power: req.body.engine_power,
    door_number: req.body.door_number,
    korobka_peredach: req.body.korobka_peredach,
    id_postavshika: req.body.id_postavshika
  };
  connection.query(sqlQuery, data, (err, results) => {
    if (err) {
      console.error('Ошибка выполнения запроса:', err);
      return;
    }
    res.redirect('/');
  });
});

app.get('/edit-model/:id', (req, res) => {
  const sqlQuery = 'SELECT * FROM models WHERE id = ?';
  connection.query(sqlQuery, req.params.id, (err, results) => {
    if (err) {
      console.error('Ошибка выполнения запроса:', err);
      return;
    }
    res.render('edit-model', { data: results[0] });
  });
});

app.put('/models/:id', (req, res) => {
  const sqlQuery = 'UPDATE models SET ? WHERE id = ?';
  const data = {
    model_name: req.body.model_name,
    color: req.body.color,
    obivka: req.body.obivka,
    engine_power: req.body.engine_power,
    door_number: req.body.door_number,
    korobka_peredach: req.body.korobka_peredach,
    id_postavshika: req.body.id_postavshika
  };
  connection.query(sqlQuery, [data, req.params.id], (err, results) => {
    if (err) {
      console.error('Ошибка выполнения запроса:', err);
      return;
    }
    res.redirect('/');
  });
});

app.delete('/models/:id', (req, res) => {
  const sqlQuery = 'DELETE FROM models WHERE id = ?';
  connection.query(sqlQuery, req.params.id, (err, results) => {
    if (err) {
      console.error('Ошибка выполнения запроса:', err);
      return;
    }
    res.redirect('/');
  });
});

app.listen(3000, function () {
  console.log('Сервер работает на порту 3000');
});