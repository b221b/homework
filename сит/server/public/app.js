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

app.post('/create', (req, res) => {
  let sqlQuery = `INSERT INTO models (model_name, color, obivka, engine_power, door_number, korobka_peredach, id_postavshika) VALUES ('${req.fields.model_name}', '${req.fields.color}', '${req.fields.obivka}', '${req.fields.engine_power}', '${req.fields.door_number}', '${req.fields.korobka_peredach}', '${req.fields.id_postavshika}')`;

  connection.query(sqlQuery, (err) => {
    if (err) {
      console.error('Ошибка выполнения запроса:', err);
      return;
    }
    res.redirect('/');
  });
});

app.get('/update/:id', (req, res) => {
  const sqlQuery = `SELECT * FROM models WHERE id='${req.params.id}'`;
  connection.query(sqlQuery, (err, results) => {
    if (err) {
      console.error('Ошибка выполнения запроса:', err);
      return;
    }
    res.render('edit-model', { data: results[0] });
  });
});

app.post('/delete', (req, res) => {
  let sqlQuery = `DELETE FROM models WHERE id='${req.fields.id}'`;

  connection.query(sqlQuery, (err) => {
    if (err) {
      console.error('Ошибка выполнения запроса:', err);
      return;
    }
    res.redirect('/');
  });
});

app.listen(3001, function () {
  console.log('Сервер работает на порту 3000');
});