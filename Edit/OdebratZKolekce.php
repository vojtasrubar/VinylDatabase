<?php
session_start();
require_once '../components/DBPropojeni.php';

if (!isset($_SESSION['userid'])) {
    header("Location: ../Auth/Autentikace.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vinyl_id'])) {
    $user_id = $_SESSION['userid'];
    $vinyl_id = intval($_POST['vinyl_id']);

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("DELETE FROM vinyluzivatele WHERE user_id = ? AND vinyl_idvinyl = ?");
    $stmt->bind_param("ii", $user_id, $vinyl_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

header("Location: ../Dashboard/MojeSbirka.php");
exit();