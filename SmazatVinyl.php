<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: Autentikace.php");
    exit();
}

include 'DBPropojeni.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request";
    exit();
}

$id = $_GET['id'];

$sql_delete = "DELETE FROM vinyl WHERE idvinyl = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $id);
$stmt_delete->execute();

if ($stmt_delete->affected_rows > 0) {
    header("Location: EditovatSmazatVinyly.php");
    exit();
} else {
    echo "Error deleting vinyl";
}

$stmt_delete->close();
$conn->close();
?>