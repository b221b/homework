const express = require('express');
const app = express();
const mysql = require('mysql');
const formidable = require('express-formidable');
const methodOverride = require('method-override');
const path = require('path');

app.use(express.static(__dirname + '/public'));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(methodOverride('_method'));

app.use(formidable({
  encoding: 'utf-8',
  uploadDir: './uploads',
  multiples: true,
  keepExtensions: true,
}));

app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, '../views'));

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
    res.render('models', { data: results });
  });
});

app.get('/create-model', (req, res) => {
  res.render('create-model');
});

app.post('/models', (req, res) => {
  const sqlQuery = 'INSERT INTO models SET ?';
  const data = {
    model_name: req.fields.model_name,
    color: req.fields.color,
    obivka: req.fields.obivka,
    engine_power: req.fields.engine_power,
    door_number: req.fields.door_number,
    korobka_peredach: req.fields.korobka_peredach,
    id_postavshika: req.fields.id_postavshika
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
    model_name: req.fields.model_name,
    color: req.fields.color,
    obivka: req.fields.obivka,
    engine_power: req.fields.engine_power,
    door_number: req.fields.door_number,
    korobka_peredach: req.fields.korobka_peredach,
    id_postavshika: req.fields.id_postavshika
  };
  connection.query(sqlQuery, [data, req.params.id], (err, results) => {
    if (err) {
      console.error('Ошибка выполнения запроса:', err);
      return res.status(500).send('Ошибка на сервере!');
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