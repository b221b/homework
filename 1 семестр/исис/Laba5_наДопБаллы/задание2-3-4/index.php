<!DOCTYPE html>
<html>
<head>
    <title>Коммерческая фирма</title>
</head>
<body>
    <h1>Коммерческая фирма</h1>
    <form action="process.php" method="post">
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" required><br>
        <label for="name_firma">Name Firma:</label>
        <input type="text" name="name_firma" id="name_firma" required><br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required><br>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required><br>
        <label for="website">Website:</label>
        <input type="text" name="website" id="website" required><br>
        <label for="city">City:</label>
        <input type="text" name="city" id="city" required><br>
        <label for="flag">Flag:</label>
        <input type="text" name="flag" id="flag" required><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>