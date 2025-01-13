<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <form action="index.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Felhasznalonev</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Jelszo</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <a href="https://github.com/ICY-glitch/jelentkezolap">Github repository</a>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../connect.php';

if (!$conn) {
    die("Database connection failed.");
}

if (isset($_COOKIE['user_session']) && !empty($_COOKIE['user_session'])) {
    $cookieValue = $_COOKIE['user_session'];
    $stmt = $conn->prepare("SELECT felhnev FROM felhasznalok WHERE cookie = ?");
    $stmt->bind_param('s', $cookieValue);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>window.location.href = '../opjelent/';</script>";
        exit;
    } else {
        setcookie('user_session', '', time() - 3600, "/");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM felhasznalok WHERE felhnev = ?");
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userRecord = $result->fetch_assoc();

        if (password_verify($pass, $userRecord['jelszo'])) {
            $cookieValue = bin2hex(random_bytes(16));
            setcookie('user_session', $cookieValue, time() + (86400 * 30), "/");

            $updateStmt = $conn->prepare("UPDATE felhasznalok SET cookie = ? WHERE felhnev = ?");
            $updateStmt->bind_param('ss', $cookieValue, $user);
            $updateStmt->execute();

            echo "<script>alert('Sikeres bejelentkezes'); window.location.href = '../opjelent/';</script>";
        } else {
            echo "<script>alert('Sikertelen bejelentkezes'); window.location.href = 'index.html';</script>";
        }
    } else {
        echo "<script>alert('Sikertelen bejelentkezes'); window.location.href = 'index.html';</script>";
    }
}
?>
