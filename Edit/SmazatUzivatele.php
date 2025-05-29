<?php
session_start();


require_once '../components/DBPropojeni.php';

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

if (!isset($_SESSION['username'])) {
    header("Location: ../Auth/Autentikace.php");
    exit();
}

if ($_SESSION['role'] != 'admin') {
    header("Location: ../Dashboard/OblibeneVinyly.php");
    exit();
}



if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request";
    exit();
}

$id = $_GET['id'];


$sql_delete = "DELETE FROM user WHERE userid = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $id);
$stmt_delete->execute();

if ($stmt_delete->affected_rows > 0) {
    header("Location: ../Dashboard/ZobrazitUzivatele.php");
    exit();
} else {
    echo "Error deleting user";
}


$stmt_delete->close();
$conn->close();
?>