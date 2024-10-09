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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Booked Rides</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
<?php require 'navbar.php' ?>
    <div class="container mt-5">
        <h2>Your Booked Rides</h2>
        <?php if ($rides): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Pickup Location</th>
                        <th>Dropoff Location</th>
                        <th>Ride Date</th>
                        <th>Actions</th> <!-- New column for actions -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rides as $ride): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ride['pickup_location']); ?></td>
                            <td><?php echo htmlspecialchars($ride['dropoff_location']); ?></td>
                            <td><?php echo htmlspecialchars($ride['ride_date']); ?></td>
                            <td>
                                <form method="POST" action="cancel_ride.php" style="display:inline;">
                                    <input type="hidden" name="ride_id" value="<?php echo $ride['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                </form>
                                <a href="track_ride.php" class="btn btn-info btn-sm">Track Ride</a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No rides booked yet.</p>
        <?php endif; ?>

        <a href="Ride.php" class="btn btn-primary">Back to Home</a>
    </div>
</body>

</html>