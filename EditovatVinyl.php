<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: Autentikace.php");
    exit();
}

include 'Header.php';
include 'DBPropojeni.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request";
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM vinyl WHERE idvinyl = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Vinyl record not found";
    exit();
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazev = $_POST["nazev"];
    $umelec = $_POST["umelec"];
    $DatumVydani = $_POST["DatumVydani"];
    $zanr_zanrID = $_POST["zanr_zanrID"];

    $sql_update = "UPDATE vinyl SET nazev=?, umelec=?, DatumVydani=?, zanr_zanrID=? WHERE idvinyl=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssii", $nazev, $umelec, $DatumVydani, $zanr_zanrID, $id);
    $stmt_update->execute();

    if ($stmt_update->affected_rows > 0) {
        header("Location: EditovatSmazatVinyly.php");
        exit();
    } else {
        echo "Error updating vinyl";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editovat Vinyl</title>
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
        <h2 class="my-4">Editovat Vinyl</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="nazev">Název:</label>
                <input type="text" name="nazev" class="form-control" value="<?php echo $row['nazev']; ?>">
            </div>
            <div class="form-group">
                <label for="umelec">Umělec:</label>
                <input type="text" name="umelec" class="form-control" value="<?php echo $row['umelec']; ?>">
            </div>
            <div class="form-group">
                <label for="DatumVydani">Datum vydání:</label>
                <input type="date" name="DatumVydani" class="form-control" value="<?php echo $row['DatumVydani']; ?>">
            </div>
            <div class="form-group">
                <label for="zanr_zanrID">Žánr:</label>
                <input type="text" name="zanr_zanrID" class="form-control" value="<?php echo $row['zanr_zanrID']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Uložit změny</button>
        </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>