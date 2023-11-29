const express = require('express');
const mysql = require('mysql');
const path = require('path');
const app = express();

app.use(express.json()); 
app.use(express.static(path.join(__dirname, 'public')));

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});


const dbConnection = mysql.createConnection({
    host: "localhost",         
    user: "root",              
    password: "",              
    database: "javascript"     
});

dbConnection.connect(error => {
    if (error) throw error;
    console.log("Successfully connected to the database.");
});

app.post('/addEmployee', (req, res) => {
    const newEmployee = req.body;
    const query = "INSERT INTO postavshiki SET ?";
    dbConnection.query(query, newEmployee, (err, result) => {
        if (err) {
            res.status(500).send(err);
            return;
        }
        res.json({ message: 'Поставщик добавлен!', id: result.insertId });
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


app.post('/updateEmployee/:id', (req, res) => {
    const { id } = req.params;
    const updatedEmployee = req.body;
    const query = "UPDATE postavshiki SET ? WHERE id = ?";
    dbConnection.query(query, [updatedEmployee, id], (err, result) => {
        if (err) {
            res.status(500).send(err);
            return;
        }
        res.json({ message: "Поставщик обновлен!", affectedRows: result.affectedRows });
    });
});


app.post('/deleteEmployee/:id', (req, res) => {
    const { id } = req.params;
    const query = "DELETE FROM postavshiki WHERE id = ?";
    dbConnection.query(query, [id], (err, result) => {
        if (err) {
            res.status(500).send(err);
            return;
        }
        res.json({ message: "Поставщик удален!", affectedRows: result.affectedRows });
    });
});

app.listen(3000, () => {
    console.log('Server is running on port 3000');
});