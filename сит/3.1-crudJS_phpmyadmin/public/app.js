const express = require('express');
const mysql = require('mysql');
const path = require('path');
const app = express();

app.use(express.json()); // Это позволит приложению понимать JSON-запросы
app.use(express.static(path.join(__dirname, 'public')));

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});

// Создайте соединение с базой данных
const dbConnection = mysql.createConnection({
    host: "localhost",         // или другой адрес, где хостится ваша БД
    user: "root",              // ваш пользователь БД
    password: "",              // ваш пароль
    database: "javascript"     // имя вашей базы данных
});

dbConnection.connect(error => {
    if (error) throw error;
    console.log("Successfully connected to the database.");
});

app.post('/addEmployee', (req, res) => {
    const newEmployee = req.body;
    const query = "INSERT INTO employees SET ?";
    dbConnection.query(query, newEmployee, (err, result) => {
        if (err) {
            res.status(500).send(err);
            return;
        }
        res.json({ message: 'Employee added!', id: result.insertId });
    });
});

// Получаем список поставщиков
app.get('/getSuppliers', (req, res) => {
    const query = "SELECT * FROM postavshiki";
    dbConnection.query(query, (err, results) => {
      if (err) {
        res.status(500).send(err);
        return;
      }
      res.json(results);
    });
});

app.listen(3000, () => {
    console.log('Server is running on port 3000');
});