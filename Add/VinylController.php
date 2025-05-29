<?php

class VinylController {
    private $conn;
    private $genres = [];
    private $genreErr = '';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
        $this->loadGenres();
    }

    private function loadGenres() {
        $sql = "SELECT zanrID, NazevZanru FROM zanr";
        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->genres[] = $row;
            }
        }
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nazev = trim($_POST["nazev"] ?? '');
            $umelec = trim($_POST["umelec"] ?? '');
            $datumVydani = trim($_POST["DatumVydani"] ?? '');
            $genre = trim($_POST["genre"] ?? '');

            if (empty($genre)) {
                $this->genreErr = "Prosím vyberte žánr.";
                return;
            }

            $sql = "INSERT INTO vinyl (nazev, umelec, DatumVydani, zanr_zanrID) VALUES (?, ?, ?, ?)";
            if ($stmt = $this->conn->prepare($sql)) {
                $stmt->bind_param("sssi", $nazev, $umelec, $datumVydani, $genre);
                if ($stmt->execute()) {
                    header("Location: ../Dashboard/AdminDashboard.php");
                    exit();
                } else {
                    echo "Nastala chyba při ukládání.";
                }
                $stmt->close();
            }
        }
    }

    public function renderForm() {
        ?>
        <!DOCTYPE html>
        <html lang="cs">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Přidat Vinyl</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <style>
                body { background-color: #f8f9fa; }
                .container { margin-top: 50px; }
            </style>
        </head>
        <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Přidat Vinyl</h2>
                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="nazev">Název:</label>
                                    <input type="text" name="nazev" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="umelec">Umělec:</label>
                                    <input type="text" name="umelec" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="DatumVydani">Datum vydání:</label>
                                    <input type="date" name="DatumVydani" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="genre">Žánr:</label>
                                    <select name="genre" class="form-control <?= !empty($this->genreErr) ? 'is-invalid' : '' ?>" required>
                                        <option value="">Vyberte žánr</option>
                                        <?php foreach ($this->genres as $item): ?>
                                            <option value="<?= $item['zanrID'] ?>"><?= htmlspecialchars($item['NazevZanru']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="invalid-feedback"><?= $this->genreErr ?></span>
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
        <?php
    }
}
