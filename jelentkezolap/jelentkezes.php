<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nev = $_POST['nev'];
    $ev = ($_POST['szuletesiev']); // Reformat date input
    echo $ev;
    $ev = date('Y-m-d', strtotime($ev));
    echo $ev;
    $lakcim = $_POST['lakcim'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $nem = $_POST['nem'];
    $tapasztalat = $_POST['tapasztalat'];
    $iskola = $_POST['iskola'];
    $nyelvtudas = $_POST['nyelvtudas'];


    $allasok_array = [];
    if (isset($_POST['gyakornok'])) $allasok_array[] = $_POST['gyakornok'];
    if (isset($_POST['adminisztrator'])) $allasok_array[] = $_POST['adminisztrator'];
    if (isset($_POST['alkfejleszto'])) $allasok_array[] = $_POST['alkfejleszto'];
    if (isset($_POST['hkarbantarto'])) $allasok_array[] = $_POST['hkarbantarto'];
    if (isset($_POST['tanito'])) $allasok_array[] = $_POST['tanito'];
    $allasok = implode(', ', $allasok_array);


    $nyelvek = $_POST['nyelvek'];


    require '../connect.php';

    $sql = "INSERT INTO jelentkezok (
        nev, ev, lakcim, telefon, email, nem, tapasztalat, iskola, nyelvtudas, allasok, nyelvek
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssssssssss",
        $nev, $ev, $lakcim, $telefon, $email, $nem, $tapasztalat, $iskola, $nyelvtudas, $allasok, $nyelvek
    );

    if ($stmt->execute()) {
        echo "Data submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
