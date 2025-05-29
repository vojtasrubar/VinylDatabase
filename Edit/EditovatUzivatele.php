<?php
session_start();


require_once '../components/DBPropojeni.php';

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

if (!isset($_SESSION['username'])) {
    header("Location: ../Auth/Autentikace.php");
    exit();
}

if ($_SESSION['role'] != 'admin') {
    header("Location: ../Dashboard/OblibeneVinyly.php");
    exit();
}

include '../components/Header.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request";
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM user WHERE userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "User not found";
    exit();
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $jmeno = $_POST["jmeno"];
    $prijmeni = $_POST["prijmeni"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    $sql_update = "UPDATE user SET username=?, jmeno=?, prijmeni=?, email=?, role=? WHERE userid=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssi", $username, $jmeno, $prijmeni, $email, $role, $id);
    $stmt_update->execute();

    if ($stmt_update->affected_rows > 0) {
        header("Location: ../Dashboard/ZobrazitUzivatele.php");
        exit();
    } else {
        echo "Error updating user";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editovat Uživatele</title>
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
        <h2 class="my-4">Editovat Uživatele</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>">
            </div>
            <div class="form-group">
                <label for="jmeno">Jméno:</label>
                <input type="text" name="jmeno" class="form-control" value="<?php echo $row['jmeno']; ?>">
            </div>
            <div class="form-group">
                <label for="prijmeni">Příjmení:</label>
                <input type="text" name="prijmeni" class="form-control" value="<?php echo $row['prijmeni']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>">
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select name="role" class="form-control">
                    <option value="user" <?php if ($row['role'] == 'user') echo 'selected'; ?>>User</option>
                    <option value="admin" <?php if ($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                </select>
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