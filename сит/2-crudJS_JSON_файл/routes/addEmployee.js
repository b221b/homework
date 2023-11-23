const fs = require('fs');
const path = require('path');

let rawdata = fs.readFileSync('data/database.json');
let data = JSON.parse(rawdata);

router.post('/addEmployee', function(req, res) {
    let employee = req.body;
    let maxId = Math.max(...data.map(e => e && e.id));
    employee.id = maxId + 1;
    data.push(employee);

    let json = JSON.stringify(data);
    fs.writeFileSync('data/database.json', json, 'utf8');

    res.json(employee);
});