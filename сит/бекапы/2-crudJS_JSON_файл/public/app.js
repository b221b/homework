const express = require('express');
const fs = require('fs').promises;
const path = require('path');
const router = express.Router();

let dataFromDatabase = [];

async function loadData() {
    if (dataFromDatabase.length === 0) {
        try {
            const data = await fs.readFile(path.join(__dirname, 'database.json'), 'utf8');
            dataFromDatabase = JSON.parse(data);
        } catch (err) {
            console.error(err);
            throw err;
        }
    }
}

async function saveData() {
    try {
        await fs.writeFile(path.join(__dirname, 'database.json'), JSON.stringify(dataFromDatabase));
    } catch (err) {
        console.error(err);
        throw err;
    }
}

const app = express();

app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});

app.get('/getEmployees', async (req, res) => {
    try {
        await loadData();
        res.json(dataFromDatabase);
    } catch (err) {
        res.status(500).json({ message: 'Error loading data' });
    }
});

app.post('/addEmployee', async (req, res) => {
    try {
        await loadData();
        const employeeData = req.body;
        const maxId = dataFromDatabase.reduce((max, item) => item.id > max ? item.id : max, 0);
        employeeData.id = maxId + 1;
        dataFromDatabase.push(employeeData);
        await saveData();
        res.json({ message: 'Employee added successfully', employee: employeeData });
    } catch (err) {
        res.status(500).json({ message: 'Error saving data' });
    }
});

$("#updateBtn").click(function () {
    let formData = readFormData();
    fetch('/updateEmployee/' + formData.id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        updateRecord(formData); // Обновляем запись в UI
        fetchEmployees(); // Перезагружаем данные из базы чтобы синхронизировать UI и базу
        resetForm();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});

function onDelete(td) {
    if (confirm('Are you sure to delete this record ?')) {
        row = td.parentElement.parentElement;
        let id = row.cells[0].innerHTML;
        fetch('/deleteEmployee/' + id, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("employeeList").deleteRow(row.rowIndex);
            fetchEmployees(); // перезагружаем данные из базы
            resetForm();
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
}

app.listen(3000, () => {
    console.log('Server is running on port 3000');
});