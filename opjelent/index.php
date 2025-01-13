<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Jelentkezőlap</title>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-expand-md navbar-expand-sm bg-primary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../login/">Bejelentkezés</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../jelentkezolap">Jelentkezőlap</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../jelentkezok">Jelentkezők</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <h1 class="text-center mb-4">Jelentkezők</h1>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Név</th>
                <th>Évjárat</th>
                <th>Lakcím</th>
                <th>Telefonszám</th>
                <th>Email</th>
                <th>Nem</th>
                <th>Állások</th>
                <th>Iskola</th>
                <th>Nyelvtudás</th>
                <th>Tapasztalat</th>
                <th>Nyelvek</th>
                <th>Módosítás</th>
            </tr>
            </thead>
            <tbody>
            <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            require "../connect.php";

            if (isset($_COOKIE['user_session']) && !empty($_COOKIE['user_session'])) {
                $cookieValue = $_COOKIE['user_session'];


                if ($conn->connect_error) {
                    die("Database connection failed: " . $conn->connect_error);
                }


                $stmt = $conn->prepare("SELECT cookie FROM felhasznalok WHERE cookie = ?");
                if ($stmt === false) {
                    die("Failed to prepare statement: " . $conn->error);
                }

                $stmt->bind_param('s', $cookieValue);

                if (!$stmt->execute()) {
                    die("Failed to execute statement: " . $stmt->error);
                }

                $result = $stmt->get_result();
                if ($result === false) {
                    die("Failed to retrieve result: " . $stmt->error);
                }


                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();

                    if ($user['cookie'] !== $cookieValue) {
                        header('Location: ../jelentkezok/');
                        exit();
                    }
                } else {
                    header('Location: ../jelentkezok/');
                    exit();
                }
            } else {
                header('Location: ../jelentkezok/');
                exit();
            }


            $sql = "SELECT nev, ev, lakcim, telefon, email, nem, allasok, iskola, nyelvtudas, tapasztalat, nyelvek FROM jelentkezok";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nev']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ev']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lakcim']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['telefon']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nem']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['allasok']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['iskola']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nyelvtudas']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tapasztalat']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nyelvek']) . "</td>";

                    echo "<td><form action='delete.php' method='post' class='d-inline'>
                            <input type='hidden' name='nev' value='" . htmlspecialchars($row['nev']) . "'>
                            <button type='submit' class='btn btn-danger btn-sm'>Töröl</button>
                        </form></td>";
                    echo "</tr>";

                }
            } else {
                echo "<tr><td colspan='12' class='text-center'>No data available</td></tr>";
            }

            $conn->close();
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>
