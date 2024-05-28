<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../Auth/Autentikace.php");
    exit();
}

include '../components/Header.php';

include '../components/DBPropojeni.php';


$sql = "SELECT vinyl.idvinyl, vinyl.nazev, vinyl.umelec, vinyl.DatumVydani, zanr.NazevZanru FROM vinyl
        INNER JOIN zanr ON vinyl.zanr_zanrID = zanr.zanrID";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editovat/Smazat Vinyly</title>
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
        <h2 class="my-4">Editovat/Smazat Vinyly</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Název</th>
                    <th>Umělec</th>
                    <th>Datum vydání</th>
                    <th>Žánr</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nazev"] . "</td>";
                        echo "<td>" . $row["umelec"] . "</td>";
                        echo "<td>" . $row["DatumVydani"] . "</td>";
                        echo "<td>" . $row["NazevZanru"] . "</td>";
                        echo "<td><a href='../Edit/EditovatVinyl.php?id=" . $row['idvinyl'] . "' class='btn btn-primary btn-sm'>Editovat</a> 
                                <a href='../Edit/SmazatVinyl.php?id=" . $row['idvinyl'] . "' class='btn btn-danger btn-sm'>Smazat</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php

$conn->close();
?>