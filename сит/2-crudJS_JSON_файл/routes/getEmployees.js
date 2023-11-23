const fs = require('fs');
const path = require('path');

router.get('/getEmployees', function(req, res) {
    let rawdata = fs.readFileSync('data/database.json');
    let data = JSON.parse(rawdata);

    let employeeList = [];
    for (let employee of data) {
        if (employee) {
            employeeList.push(employee);
        }
    }

    res.json(employeeList);
});