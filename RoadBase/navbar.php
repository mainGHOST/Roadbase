<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

$user_role = $_SESSION['user_type'] ?? 'guest'; // Get the user role from the session
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary px-5 py-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">RoadBase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if ($user_role == 'passenger'): ?>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item px-1">
                        <a class="nav-link" href="ride_history.php">Book</a>
                    </li>
                    <li class="nav-item px-1">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item px-1">
                        <a class="nav-link" href="view_available_drivers.php">Drivers</a>
                    </li>
                </ul>
                <a href="notification.php"><i class="fa-regular fa-bell text-info fs-5 px-3"></i></a>
                <a href="logout.php" class="d-flex btn btn-outline-danger mx-2">Logout</a>

        </div>
    <?php elseif ($user_role == 'driver'): ?>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item px-1">
                <a class="nav-link" href="view_ride_requests.php">Requests</a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" href="view_ride_history.php">History</a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" href="profile.php">Profile</a>
            </li>
        </ul>
        <a href="logout.php" class="d-flex btn btn-outline-danger">Logout</a>

    <?php elseif ($user_role == 2): // Admin Features 
    ?>
        <ul class="navbar-nav me-auto d-flex gap-2 mb-2 mb-lg-0">
            <li class="nav-item px-1">
                <a class="nav-link" href="user_management.php">Users</a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" href="ride_management.php">Rides</a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" href="profile.php">Profile</a>
            </li>
        </ul>
        <a href="logout.php" class="d-flex btn btn-outline-danger">Logout</a>
    <?php endif; ?>
    </div>
    </div>
</nav>