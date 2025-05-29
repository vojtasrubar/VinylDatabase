<?php
session_start();
require_once '../components/DBPropojeni.php';
require_once 'VinylController.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../Auth/Autentikace.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../Dashboard/OblibeneVinyly.php");
    exit();
}

$controller = new VinylController();
$controller->handleRequest();
$controller->renderForm();
