<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Jelentkezőlap</title>
</head>
<body>
<form class="radio-inline" action="jelentkezes.php" method="post">
    <!-- navbar  -->
    <nav class="navbar navbar-expand-lg navbar-expand-md navbar-expand-sm bg-primary">

        <div class="container-fluid">

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../login/">Bejelentkezes</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../jelentkezolap">Jelentkezolap</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="../jelentkezok">Jelentkezok</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <h1 class="text-center mb-4">Jelentkezok</h1>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Nev</th>
                <th>Evjarat</th>
                <th>lakcim</th>
                <th>telefonszam</th>
                <th>email</th>
                <th>nem</th>
                <th>allasok</th>
                <th>iskola</th>
                <th>nyelvtudas</th>
                <th>tapasztalat</th>
                <th>nyelvek</th>
            </tr>
            </thead>
            <tbody>
            <?php
                require "../connect.php";

            // Fetch data from the database
            $sql = "SELECT nev, ev, lakcim, telefon, email, nem, allasok, iskola, nyelvtudas, tapasztalat, nyelvek FROM jelentkezok";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
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



                echo "</tr>";
            }
            } else {
            echo "<tr><td colspan='3' class='text-center'>No data available</td></tr>";
            }

            $conn->close();
            ?>
            </tbody>
        </table>
    </div>


</form>
</body>
</html>