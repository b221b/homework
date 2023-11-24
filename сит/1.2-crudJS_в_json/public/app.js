const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const app = express();
const port = 3000; // Вы можете выбрать любой порт

// Middleware для парсинга JSON
app.use(bodyParser.json());

// Статический хостинг для вашего HTML и JS
app.use(express.static('public'));

app.get('/', (req, res) => {
    res.sendFile('qwe.html', { root: __dirname });
});

// GET-запрос для загрузки всех сотрудников
app.get('/getEmployees', (req, res) => {
    fs.readFile('database.json', (err, data) => {
        if (err) {
            res.status(500).send(err);
        } else {
            res.json(JSON.parse(data));
        }
    });
});

// POST-запрос для добавления сотрудника
app.post('/addEmployee', (req, res) => {
    const newEmployee = req.body;

    fs.readFile('database.json', (err, data) => { // Здесь изменён путь
        if (err) {
            res.status(500).send(err);
            return; // Остановить выполнение чтобы не продолжать если прочесть файл не удалось
        }
        const database = JSON.parse(data);
        database.push(newEmployee);
        fs.writeFile('database.json', JSON.stringify(database, null, 2), (err) => { // Добавляем отступы для читаемости файла
            if (err) {
                res.status(500).send(err);
                return; // Добавляем return, чтобы корректно обработать ошибку и не пытаться дальше что-то отправлять.
            }
            res.json({ message: 'Employee added!' });
        });
    });
});

// Другие маршруты для обновления и удаления

app.listen(3000, () => {
    console.log('Server is running on port 3000');
});