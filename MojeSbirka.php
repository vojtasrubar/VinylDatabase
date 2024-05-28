<?php
session_start();

include 'DBPropojeni.php';

$user_id = $_SESSION['userid'];
$sql = "SELECT vinyl.nazev, vinyl.umelec FROM vinyluzivatele JOIN vinyl ON vinyluzivatele.vinyl_idvinyl = vinyl.idvinyl WHERE vinyluzivatele.user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $collection = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $collection = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje Sbírka</title>
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
        <h2 class="text-center">Moje Sbírka</h2>
        <ul class="list-group">
            <?php foreach ($collection as $vinyl): ?>
                <li class="list-group-item"><?php echo $vinyl['nazev'] . ' - ' . $vinyl['umelec']; ?></li>
            <?php endforeach; ?>
        </ul>
        <div class="text-center">
            <a href="UserDashboard.php" class="btn btn-secondary">Return</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>