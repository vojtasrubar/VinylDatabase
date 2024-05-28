<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: Autentikace.php");
    exit();
}
include 'Header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

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
    <div class="container">
        <h2 class="mt-4">Admin Dashboard</h2>
        <?php echo "Vítejte, " . $_SESSION['username'] . "! Jste přihlášený jako admin."; ?>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Zobrazit/Editovat/Smazat uživatele</h5>
                        <p class="card-text">Zobrazit, Editovat a smazat existující uživatele.</p>
                        <a href="ZobrazitUzivatele.php" class="btn btn-primary">Zobrazit</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Zobrazit/Editovat/Smazat Vinyl</h5>
                        <p class="card-text">Zobrazit, Editovat a smazat existující vinyl.</p>
                        <a href="EditovatSmazatVinyly.php" class="btn btn-primary">Zobrazit</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Přidat žánr</h5>
                        <p class="card-text">Přidejte nový žánr.</p>
                        <a href="PridatZanr.php" class="btn btn-primary mb-3">Přidat žánr</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Přidat vinyl</h5>
                        <p class="card-text">Přidat nový vinyl do databáze.</p>
                        <a href="PridatVinyly.php" class="btn btn-primary">Přidat vinyl</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>