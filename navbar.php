<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

$user_role = $_SESSION['user_type'] ?? 'guest'; // Get the user role from the session
?>

<nav class="navbar navbar-expand-lg bg-dark px-5 py-2" style="background-image: url(image/bgnav.png); background-size:cover;">

    <div class="container-fluid py-2">
        <a class="navbar-brand text-white fs-3" href="#">RoadBase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon btn-outline-light"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if ($user_role == 'passenger'): ?>
                <div class=" d-flex justify-content-between ms-auto" style="width:800px;">
                    <ul class="navbar-nav ms-start mb-2 mb-lg-0">
                        <li class="nav-item px-1">
                            <a class="nav-link text-white" href="ride_history.php">Book</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link text-white" href="profile.php">Profile</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link text-white" href="view_available_drivers.php">Drivers</a>
                        </li>
                    </ul>

                    <div class="btn-group">
                        <a href="notification.php"><i class="fa-regular fa-bell text-info fs-5 px-3 pt-2"></i></a>
                        <a href="logout.php" class="d-flex btn btn-outline-light mx-2">Logout</a>

                    </div>
                </div>

            <?php elseif ($user_role == 'driver'): ?>
                <div class=" d-flex justify-content-between ms-auto" style="width:800px;">
                    <ul class="navbar-nav ms-start mb-2 mb-lg-0">
                        <li class="nav-item px-1">
                            <a class="nav-link text-white" href="view_ride_requests.php">Requests</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link text-white" href="view_ride_history.php">History</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link text-white" href="profile.php">Profile</a>
                        </li>
                    </ul>
                    <a href="logout.php" class="btn btn-outline-light">Logout</a>
                </div>
            <?php elseif ($user_role == 2): // Admin Features 
            ?>
                <div class=" d-flex justify-content-between ms-auto" style="width:800px;">
                    <ul class="navbar-nav me-auto d-flex gap-2 mb-2 mb-lg-0">
                        <li class="nav-item px-1">
                            <a class="nav-link text-white" href="user_management.php">Users</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link text-white" href="ride_management.php">Rides</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link text-white" href="profile.php">Profile</a>
                        </li>
                    </ul>
                    <a href="logout.php" class="btn btn-outline-light">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/ethers@5.7.2/dist/ethers.umd.min.js"></script>
    <script src="js/wallet.js" defer></script>
</nav>


