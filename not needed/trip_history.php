<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

// Fetch past rides for the user
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM rides WHERE user_id = ? ORDER BY ride_date DESC");
$stmt->execute([$user_id]);
$rides = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
<?php require 'navbar.php' ?>
    <div class="container mt-5">
        <h2>Your Trip History</h2>
        <?php if ($rides): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Pickup Location</th>
                        <th>Dropoff Location</th>
                        <th>Ride Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rides as $ride): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ride['pickup_location']); ?></td>
                            <td><?php echo htmlspecialchars($ride['dropoff_location']); ?></td>
                            <td><?php echo htmlspecialchars($ride['ride_date']); ?></td>
                            <td><?php echo htmlspecialchars($ride['status']); ?></td>
                            <td>
                                <a href="feedback.php?ride_id=<?php echo $ride['id']; ?>" class="btn btn-warning btn-sm">Give Feedback</a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No trips found.</p>
        <?php endif; ?>
        <a href="Ride.php" class="btn btn-secondary">Back to Home</a>

    </div>
</body>

</html>