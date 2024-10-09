<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
    header("Location: index.php"); // Redirect to login if not logged in or not admin
    exit;
}

// Fetch all rides
$stmt = $pdo->query("SELECT * FROM rides");
$ridedata = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require 'navbar.php' ?>
<div class="container mt-5">
    <h2>Ride Management</h2>
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Passenger ID</th>
                <th>Driver ID</th>
                <th>Pickup Location</th>
                <th>Drop-off Location</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ridedata as $ride): ?>
                <tr>
                    <td><?php echo $ride['id']; ?></td>
                    <td><?php echo $ride['passenger_id']; ?></td>
                    <td><?php echo $ride['driver_id']; ?></td>
                    <td><?php echo htmlspecialchars($ride['pickup_location']); ?></td>
                    <td><?php echo htmlspecialchars($ride['dropoff_location']); ?></td>
                    <td><?php echo htmlspecialchars($ride['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
