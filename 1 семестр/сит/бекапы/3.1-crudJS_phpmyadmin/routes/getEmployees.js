const fs = require('fs');
const path = require('path');

router.get('/getEmployees', function(req, res) {
    let sql = 'SELECT * FROM postavshiki';
    db.query(sql, function(err, result) {
        if (err) throw err;
        res.json(result);
    });
});