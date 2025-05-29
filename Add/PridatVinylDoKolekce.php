<?php
session_start();
require_once '../components/DBPropojeni.php';

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT * FROM user";
$result = $conn->query($sql);
$sql = "SELECT * FROM vinyl";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $vinyls = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $vinyls = [];
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_collection"])) {
    $user_id = $_SESSION['userid'];
    $vinyl_id = $_POST["vinyl_id"];

    // Zkontroluj, jestli už vinyl není v kolekci
    $check_sql = "SELECT * FROM vinyluzivatele WHERE vinyl_idvinyl = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $vinyl_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        // Není tam, přidáme
        $sql = "INSERT INTO vinyluzivatele (vinyl_idvinyl, user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $vinyl_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
    $check_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zobrazit Vinyly</title>
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
        <h2 class="text-center">Vinyly</h2>
        <div class="row">
            <?php foreach ($vinyls as $vinyl): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $vinyl['nazev']; ?></h5>
                        <p class="card-text"><?php echo $vinyl['umelec']; ?></p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" name="vinyl_id" value="<?php echo $vinyl['idvinyl']; ?>">
                            <button type="submit" name="add_to_collection" class="btn btn-primary btn-sm">Pridat Do Kolekce</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center">
            <a href="../Dashboard/UserDashboard.php" class="btn btn-secondary">Return</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>