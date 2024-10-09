<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

// Fetch rides for the logged-in user
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM rides WHERE user_id = ?");
$stmt->execute([$user_id]);
$rides = $stmt->fetchAll();

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tricycle Booking Platform</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
<?php require 'navbar.php' ?>
<a href="logout.php" class="btn btn-danger">Logout</a>

    <div class="container">
    <h2 class="mt-5">Book a Ride</h2>
    <form method="POST" action="book_ride.php">
        <div class="form-group">
            <label for="pickup_location">Pickup Location:</label>
            <input type="text" class="form-control" name="pickup_location" id="pickup_location" required>
        </div>

        <div class="form-group">
            <label for="dropoff_location">Dropoff Location:</label>
            <input type="text" class="form-control" name="dropoff_location" id="dropoff_location" required>
        </div>

        <div class="form-group">
            <label for="ride_date">Ride Date & Time:</label>
            <input type="datetime-local" class="form-control" name="ride_date" id="ride_date" required>
        </div>

        <button type="submit" class="btn btn-primary">Book Ride</button>
    </form>
    </div>
    <div class="container">
    <h2 class="mt-5">Your Rides</h2>
    <a href="view_rides.php" class="btn btn-info">View Booked Rides</a>
    <!-- <h2 class="mt-5">Manage Drivers</h2>
    <a href="add_driver.php" class="btn btn-primary">Add Driver</a>
    <a href="view_drivers.php" class="btn btn-info">View Drivers</a> -->
    <!-- <h2 class="mt-5">User Profile</h2>
    <a href="profile.php" class="btn btn-primary">View Profile</a> -->
    <!-- <h2 class="mt-5">Your Rides</h2>
    <a href="trip_history.php" class="btn btn-info">View Trip History</a> -->
    

</body>