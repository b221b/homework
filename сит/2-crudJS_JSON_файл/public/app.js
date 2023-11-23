const express = require('express');
const fs = require('fs').promises;
const path = require('path');

let dataFromDatabase = [];

async function loadData() {
    if (dataFromDatabase.length === 0) {
        try {
            const data = await fs.readFile('сит/123/public/database.json');
            dataFromDatabase = JSON.parse(data);
        } catch (err) {
            console.error(err);
            throw err;
        }
    }
}

async function saveData() {
    try {
        await fs.writeFile('сит/123/public/database.json', JSON.stringify(dataFromDatabase));
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
        res.status(500).json({ message: 'Error loading data' });
    }
});

app.listen(3000, () => {
    console.log('Server is running on port 3000');
});