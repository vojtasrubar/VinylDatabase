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


$genre = '';
$genre_err = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    if (empty(trim($_POST["genre"]))) {
        $genre_err = "Please enter the genre.";
    } else {
        $genre = trim($_POST["genre"]);
    }

    
    if (empty($genre_err)) {
        
        $sql = "INSERT INTO zanr (NazevZanru) VALUES (?)";

        if ($stmt = $conn->prepare($sql)) {
            
            $stmt->bind_param("s", $param_genre);

          
            $param_genre = $genre;

            
            if ($stmt->execute()) {
                
                header("location: ../Dashboard/AdminDashboard.php");
                exit();
            } else {
                echo "Ups! Něco se pokazilo. Zkuste to prosím později.";
            }


            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat žánr</title>
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Přidat žánr</h2>
                        <form id="addGenreForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="genre">Žánr:</label>
                                <input type="text" name="genre" class="form-control <?php echo (!empty($genre_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $genre_err; ?></span>
                            </div>
                            <button type="submit" class="btn btn-primary">Přidat žánr</button>
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