<?php
session_start();

require_once '../components/DBPropojeni.php';

$db = new Database();
$conn = $db->getConnection();

include '../components/Header.php';

$user_id = $_SESSION['userid'];
$sql = "SELECT vinyl.idvinyl, vinyl.nazev, vinyl.umelec 
        FROM vinyluzivatele 
        JOIN vinyl ON vinyluzivatele.vinyl_idvinyl = vinyl.idvinyl 
        WHERE vinyluzivatele.user_id = $user_id";
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
        <h2 class="text-center mb-4">Moje Sbírka</h2>
        <ul class="list-group">
            <?php foreach ($collection as $vinyl): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo $vinyl['nazev'] . ' - ' . $vinyl['umelec']; ?>
                    <form action="../Edit/OdebratZKolekce.php" method="POST" class="mb-0">
                        <input type="hidden" name="vinyl_id" value="<?php echo $vinyl['idvinyl']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Opravdu chcete odebrat tento vinyl?')">Odebrat</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>