const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const path = require('path');

const sqlQuery = (query) => {
    return new Promise((resolve, reject) => {
        db.query(query, (err, result) => {
            if (err) reject(err);
            else resolve(result);
        });
    });
};

const app = express();

const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'javascript'
});

db.connect((err) => {
    if (err) throw err;
    console.log('Connected to the database');
});

app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});

app.get('/', async function (req, res) {
    try {
        let data = await loadData();
        let html = '<h1>Список статей</h1><ul>';

        data.forEach(item => {
            html += `<li>${item.title}</li>`;
        });

        html += '</ul>';
        res.send(html);
    } catch (err) {
        res.status(500).json({ message: 'Error loading data' });
    }
});

app.post('/addEmployee', async (req, res) => {
    try {
        await loadData();
        dataFromDatabase.push(req.body);
        await saveData();
        res.json({ message: 'Employee added successfully' });
    } catch (err) {
        res.status(500).json({ message: 'Error saving data' });
    }
});

app.put('/updateEmployee/:id', async (req, res) => {
    try {
        await loadData();
        const id = parseInt(req.params.id);
        const employeeIndex = dataFromDatabase.findIndex(e => e.id === id);
        if (employeeIndex === -1) {
            return res.status(404).json({ message: 'Employee not found' });
        }
        dataFromDatabase[employeeIndex] = req.body;
        await saveData();
        res.json({ message: 'Employee updated successfully' });
    } catch (err) {
        res.status(500).json({ message: 'Error saving data' });
    }
});

app.delete('/deleteEmployee/:id', async (req, res) => {
    try {
        await loadData();
        const id = parseInt(req.params.id);
        const employeeIndex = dataFromDatabase.findIndex(e => e.id === id);
        if (employeeIndex === -1) {
            return res.status(404).json({ message: 'Employee not found' });
        }
        dataFromDatabase.splice(employeeIndex, 1);
        await saveData().catch(err => {
            console.error(err);
            res.status(500).json({ message: 'Error saving data' });
        });
        res.json({ message: 'Employee deleted successfully' });
    } catch (err) {
        res.status(500).json({ message: 'Error deleting data' });
    }
});

const loadData = async () => {
    try {
        dataFromDatabase = await sqlQuery('SELECT * FROM postavshiki');
        return dataFromDatabase;
    } catch (err) {
        console.error(err);
        throw err;
    }
};

const saveData = async () => {
    try {
        dataFromDatabase.forEach(async employee => {
            let sql = 'INSERT INTO postavshiki (id, name_firma, phone, email, website, city, flag) VALUES (NULL, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE name_firma = ?, phone = ?, email = ?, website = ?, city = ?, flag = ?';
            let query = db.query(sql, [userObject.name_firma, userObject.phone, userObject.email, userObject.website, userObject.city, userObject.flag, userObject.name_firma, userObject.phone, userObject.email, userObject.website, userObject.city, userObject.flag], (error, results, fields) => {
                if (error) {
                    console.log('Ошибка записи: ', error);
                    return;
                }
                console.log('Данные записаны успешно');
            });
        });
    } catch (error) {
        console.log('Ошибка в saveData: ', error);
    }
};

app.listen(3000, () => {
    console.log('Server is running on port 3000');
});