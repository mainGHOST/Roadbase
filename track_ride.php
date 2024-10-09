<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

// Fetch the last booked ride for the user
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM rides WHERE user_id = ? ORDER BY ride_date DESC LIMIT 1");
$stmt->execute([$user_id]);
$ride = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Ride</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require 'navbar.php' ?>
<div class="container mt-5">
    <h2>Track Your Ride</h2>
    <?php if ($ride): ?>
        <p><strong>Pickup Location:</strong> <?php echo htmlspecialchars($ride['pickup_location']); ?></p>
        <p><strong>Dropoff Location:</strong> <?php echo htmlspecialchars($ride['dropoff_location']); ?></p>
        <p><strong>Ride Date:</strong> <?php echo htmlspecialchars($ride['ride_date']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($ride['status']); ?></p>
        <p><strong>Estimated Arrival:</strong> <?php echo htmlspecialchars($ride['estimated_arrival']); ?></p>
    <?php else: ?>
        <p>No ride booked yet.</p>
    <?php endif; ?>
    <a href="Ride.php" class="btn btn-secondary">Back to Home</a>
</div>
</body>
</html>
