<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Auth/Autentikace.php");
    exit();
}

include '../components/Header.php';
include '../components/DBPropojeni.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $akce = $_POST["akce"];

    if ($akce == "pridat") {
        $sql = "ALTER TABLE vinyl ADD pocetKusu INT DEFAULT 1";
    } elseif ($akce == "odebrat") {
        $sql = "ALTER TABLE vinyl DROP COLUMN pocetKusu";
    } elseif ($akce == "zmenit") {
        $sql = "ALTER TABLE user MODIFY COLUMN email VARCHAR(150) NOT NULL";
    } else {
        $message = "Neplatná akce.";
    }

    if (!empty($sql)) {
        if ($conn->query($sql) === TRUE) {
            $message = "Struktura databáze byla upravena.";
        } else {
            $message = "Chyba při úpravě: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Úprava Struktury Databáze</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Úprava struktury databáze</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="akce">Vyber akci:</label>
            <select class="form-control" name="akce" id="akce">
                <option value="pridat">Přidat sloupec <code>pocetKusu</code> do tabulky <code>vinyl</code></option>
                <option value="odebrat">Odebrat sloupec <code>pocetKusu</code> z tabulky <code>vinyl</code></option>
                <option value="zmenit">Změnit délku <code>email</code> na 150 znaků</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Provést úpravu</button>
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>