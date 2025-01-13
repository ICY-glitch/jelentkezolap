<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hasher</title>
</head>
<body>
<h1>Password Hasher</h1>
<form method="POST" action="">
    <label for="password">Enter a Password:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Hash Password</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    // Hash the password using PHP's password_hash function
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Display the hashed password
    echo "<h2>Hashed Password:</h2>";
    echo "<p><code>$hashedPassword</code></p>";
}
?>
</body>
</html>
