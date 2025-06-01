<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: ../VstupniStranka.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uživatelský dashboard</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <?php include '../components/Header.php'; ?>

    <div class="container">
        <h2>Uživatelský dashboard</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Přidat nový vinyl do kolekce</h5>
                        <p class="card-text">Přidat nový vinyl do kolekce.</p>
                        <a href="../Add/PridatVinylDoKolekce.php" class="btn btn-primary">Přidat vinyl</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Zobrazit kolekci</h5>
                        <p class="card-text">Zobrazit všechny vinyly z kolekce.</p>
                        <a href="../Dashboard/MojeSbirka.php" class="btn btn-primary">Zobrazit kolekci</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
