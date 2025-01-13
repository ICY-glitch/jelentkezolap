<?php
require "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nev'])) {
    $nev = $_POST['nev'];

    $stmt = $conn->prepare("DELETE FROM jelentkezok WHERE nev = ?");
    $stmt->bind_param('s', $nev);

    if ($stmt->execute()) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: ./index.php");
    exit();
}
?>
<?php
