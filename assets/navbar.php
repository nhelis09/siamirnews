<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not started already
}

include 'assets/konektor.php';

// Function to check if user is logged in
function isUserLoggedIn()
{
    return isset($_SESSION['user_id']);
}
?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark"
    style="background-image: url(assets/navbar.jpg); background-size: cover;">
    <div class="container-fluid">
        <a class="navbar-brand ms-3">
            <img src="assets/logo.png" width="50px" alt="" style="pointer-events: none;">
        </a>
        Buana Uyelindo
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link me-3" href="index.php"><i class="bi bi-house-door"></i>Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-3" href="forum.php">Diskusi <i class="bi bi-chat-left"></i></a>
                </li>
                <?php if (isUserLoggedIn()) { ?>
                <li class="nav-item">
                    <a class="nav-link me-3" href="profile/profile.php">
                        <i class="bi bi-person"></i> Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-3" href="loginuser/logout.php" onclick="return confirmLogout()">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>

                <script>
                function confirmLogout() {
                    return confirm("Apakah anda yakin ingin keluar?");
                }
                </script>
                <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link me-3" href="loginuser/login1.php">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                </li>
                <?php } ?>

            </ul>
        </div>
    </div>
</nav>