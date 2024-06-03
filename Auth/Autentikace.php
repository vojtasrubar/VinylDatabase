<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: ../Dashboard/OblibeneVinyly.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "vinyldatabase";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['heslo'];

    $sql = "SELECT * FROM user WHERE username='$username' AND heslo='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $row['userid'];
        $_SESSION['role'] = $row['role'];
        if ($row['role'] == 'admin') {
            header("Location: ../Dashboard/AdminDashboard.php");
        } else {
            header("Location: ../Dashboard/UserDashboard.php");
        }
        exit();
    } else {
        $error = "Invalid username or password.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Přihlášení</h2>
                        <?php if(isset($error)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                        <?php } ?>
                        <form action="../Auth/Autentikace.php" method="post">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="heslo">Heslo:</label>
                                <input type="password" name="heslo" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Přihlásit se</button>
                            <a href="../VstupniStranka.php" class="btn btn-secondary">Vrátit se</a>
                        </form>
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