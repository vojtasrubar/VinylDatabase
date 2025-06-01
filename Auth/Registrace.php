<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: ../Dashboard/UserDashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $servername = "sql112.infinityfree.com";
    $username = "if0_39112415";
    $password = "tqMybSA7gTBC5s";
    $database = "if0_39112415_vinyldatabase";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $passworduser = $_POST['password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $role = $_POST['role']; 

    $check_sql = "SELECT * FROM user WHERE username='$username'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $error = "Username already exists.";
    } else {
        $sql = "INSERT INTO user (username, heslo, jmeno, prijmeni, email, role) 
                VALUES ('$username', '$passworduser', '$name', '$surname', '$email', '$role')";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role; 
            $_SESSION['userid'] = $conn->insert_id;  

            header("Location: ../Dashboard/UserDashboard.php");
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrace</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
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
                        <h2 class="card-title text-center">Registrace</h2>
                        <?php if(isset($error)) { ?>
                        <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                        <?php } ?>
                        <form action="Registrace.php" method="post">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" required />
                            </div>
                            <div class="form-group">
                                <label for="password">Heslo:</label>
                                <input type="password" class="form-control" name="password" required />
                            </div>
                            <div class="form-group">
                                <label for="name">Jméno:</label>
                                <input type="text" class="form-control" name="name" required />
                            </div>
                            <div class="form-group">
                                <label for="surname">Příjmení:</label>
                                <input type="text" class="form-control" name="surname" required />
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" required />
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select class="form-control" name="role">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Registrovat se</button>
                            <a href="../index.php" class="btn btn-secondary btn-block mt-2">Vrátit se</a>
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
