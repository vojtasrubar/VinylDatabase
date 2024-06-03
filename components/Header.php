<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Vinylová kolekce</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php if(isset($_SESSION['username'])) { ?>
            <li class="nav-item">
                <a class="nav-link" href="../Dashboard/MojeSbirka.php">Moje vinyly</a>
            </li>
            <?php if($_SESSION['role'] == 'admin') { ?>
            <li class="nav-item">
                <a class="nav-link" href="../Dashboard/AdminDashboard.php">Admin Dashboard</a>
            </li>
            <?php } else { ?>
            <li class="nav-item">
                <a class="nav-link" href="../Dashboard/UserDashboard.php">Uživatelský Dashboard</a>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link btn btn-danger text-light" href="../Auth/LogOut.php">Logout</a>
            </li>
            <?php } else { ?>
            <li class="nav-item">
                <a class="nav-link" href="../Auth/Autentikace.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Auth/Registrace.php">Registrovat</a>
            </li>
            <?php } ?>
        </ul>
    </div>
</nav>