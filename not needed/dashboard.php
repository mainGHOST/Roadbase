<?php
session_start();
require 'config/database.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

$user_role = $_SESSION['user_role']; // Get the user role from the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require 'navbar.php' ?>
<div class="container mt-5">
    <h2>User Dashboard</h2>
    <a href="logout.php" class="btn btn-danger">Logout</a>

    <div class="mt-4">
        <?php if ($user_role == 0): // Passenger Features ?>
            <h3>Passenger Features</h3>
            <ul>
                <li><a href="Ride.php">Book a Ride</a></li>
                <li><a href="ride_history.php">View Booking History</a></li>
                <li><a href="profile.php">Edit Profile</a></li>
                <li><a href="view_available_drivers.php">View Available Drivers</a></li>
                <li><a href="feedback.php">Rate Driver</a></li>
            </ul>
        <?php elseif ($user_role == 1): // Driver Features ?>
            <h3>Driver Features</h3>
            <ul>
                <li><a href="view_ride_requests.php">View and Accept Ride Requests</a></li>
                <li><a href="view_ride_history.php">View Ride History</a></li>
                <li><a href="profile.php">Edit Profile</a></li>
            </ul>
        <?php elseif ($user_role == 2): // Admin Features ?>
            <h3>Admin Features</h3>
            <ul>
                <li><a href="user_management.php">Manage Users</a></li>
                <li><a href="ride_management.php">Manage Rides</a></li>
                <li><a href="reports.php">Generate Reports</a></li>
                <li><a href="profile.php">Edit Profile</a></li>
            </ul>
        <?php else: ?>
            <p>Invalid user role.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
