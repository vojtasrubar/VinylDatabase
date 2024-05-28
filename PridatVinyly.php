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


$genre = '';
$genre_err = '';


$sql = "SELECT zanrID, NazevZanru FROM zanr";
$result = $conn->query($sql);

$genres = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $genres[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty(trim($_POST["genre"]))) {
        $genre_err = "Please select the genre.";
    } else {
        $genre = trim($_POST["genre"]);
    }

   
    if (empty($genre_err)) {
       
        $sql = "INSERT INTO vinyl (nazev, umelec, DatumVydani, zanr_zanrID) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            
            $stmt->bind_param("sssi", $param_nazev, $param_umelec, $param_DatumVydani, $param_genre);

          
            $param_nazev = $_POST["nazev"];
            $param_umelec = $_POST["umelec"];
            $param_DatumVydani = $_POST["DatumVydani"];
            $param_genre = $genre;

            
            if ($stmt->execute()) {
                
                header("location: AdminDashboard.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Přidat vinyl</title>
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
                        <h2 class="card-title">Přidat Vinyl</h2>
                        <form id="addVinylForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="nazev">Název:</label>
                                <input type="text" name="nazev" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="umelec">Umělec:</label>
                                <input type="text" name="umelec" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="DatumVydani">Datum vydání:</label>
                                <input type="date" name="DatumVydani" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="genre">Žánr:</label>
                                <select name="genre" class="form-control <?php echo (!empty($genre_err)) ? 'is-invalid' : ''; ?>">
                                    <option value="">Vyberte žánr</option>
                                    <?php foreach ($genres as $genre_item): ?>
                                        <option value="<?php echo $genre_item['zanrID']; ?>"><?php echo $genre_item['NazevZanru']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="invalid-feedback"><?php echo $genre_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="image">Obrázek vinylu:</label>
                                <input type="file" name="image" class="form-control-file">
                            </div>
                            <button type="submit" class="btn btn-primary">Přidat Vinyl</button>
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