<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oblibene vinyly</title>
    
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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Oblíbené vinyly nebo vinyly které vlastníte:</h2>
                        <div class="table-responsive">
                            <table id="vinylsTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Název</th>
                                        <th>Umělec</th>
                                        <th>Rok vydání</th>
                                        <th>Žánr</th>
                                    </tr>
                                </thead>
                                <tbody id="vinylsBody">
                                    <!-- Vinyls data will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Example data, replace with actual data from PHP
        var vinylsData = [
            { title: "Vinyl 1", artist: "Artist 1", release_year: 2021, genre_name: "Rock" },
            { title: "Vinyl 2", artist: "Artist 2", release_year: 2020, genre_name: "Pop" },
            { title: "Vinyl 3", artist: "Artist 3", release_year: 2019, genre_name: "Jazz" }
        ];

        // Function to display vinyls data
        function displayVinyls() {
            var vinylsBody = document.getElementById('vinylsBody');
            vinylsBody.innerHTML = '';

            vinylsData.forEach(function(vinyl) {
                var row = "<tr>" +
                            "<td>" + vinyl.title + "</td>" +
                            "<td>" + vinyl.artist + "</td>" +
                            "<td>" + vinyl.release_year + "</td>" +
                            "<td>" + vinyl.genre_name + "</td>" +
                          "</tr>";
                vinylsBody.innerHTML += row;
            });
        }

        // Load vinyls data when the page is ready
        window.onload = function() {
            displayVinyls();
        };
    </script>
</body>
</html>