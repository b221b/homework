const fs = require('fs');
const path = require('path');

let rawdata = fs.readFileSync('data/database.json');
let data = JSON.parse(rawdata);

router.post('/addEmployee', function(req, res) {
    let employee = req.body;
    let sql = 'INSERT INTO postavshiki SET ?';
    db.query(sql, employee, function(err, result) {
        if (err) throw err;
        res.json(employee);
    });
});