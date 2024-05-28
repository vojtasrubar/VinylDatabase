<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: Autentikace.php");
    exit();
}

if ($_SESSION['role'] != 'admin') {
    header("Location: OblibeneVinyly.php");
    exit();
}

include 'Header.php';
include 'DBPropojeni.php';

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zobrazit Uživatele</title>
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
        <h2 class="my-4">Zobrazit Uživatele</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Uživatelské jméno</th>
                    <th>Jméno</th>
                    <th>Příjmení</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["jmeno"] . "</td>";
                        echo "<td>" . $row["prijmeni"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["role"] . "</td>";
                        echo "<td><a href='EditovatUzivatele.php?id=" . $row['userid'] . "' class='btn btn-primary btn-sm'>Editovat</a> 
                                <a href='SmazatUzivatele.php?id=" . $row['userid'] . "' class='btn btn-danger btn-sm'>Smazat</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Žádní uživatelé nenalezeni</td></tr>";
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
// Close connection
$conn->close();
?>