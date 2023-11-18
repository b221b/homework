module.exports = function(app, connection) {
    app.get("/edit-model/:id", (req, res) => {
        // отображение формы редактирования модели
        const id = req.params.id;
        const sqlQuery = 'SELECT * FROM models WHERE id = ?';
        connection.query(sqlQuery, id, (err, result) => {
            if (err) {
                console.error('Ошибка загрузки модели:', err);
                return;
            }
            res.render("edit-model", { data: result[0] });
        });
    });

    app.post("/edit-model/:id", (req, res) => {
        // обновление модели в базе данных
        const id = req.params.id;
        const updatedModel = req.body;
        const sqlQuery = 'UPDATE models SET ? WHERE id = ?';
        connection.query(sqlQuery, [updatedModel, id], (err, result) => {
            if (err) {
                console.error('Ошибка изменения модели:', err);
                return;
            }
            res.redirect('/');
        });
    });
};