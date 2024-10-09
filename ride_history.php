<?php
session_start();
require 'config/database.php';

// Check if the passenger is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$passenger_id = $_SESSION['user_id'];

// Fetch booking history for this passenger
$sql = "SELECT rr.*, d.name AS driver_name 
        FROM ride_requests rr
        LEFT JOIN drivers d ON rr.driver_id = d.id
        WHERE rr.passenger_id = :passenger_id
        ORDER BY rr.date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['passenger_id' => $passenger_id]);
$rides = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Booking History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <?php require 'navbar.php' ?>
    <div class="container mt-5">
        <h2>Your Booking History</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ride ID</th>
                    <th>Driver Name</th>
                    <th>Pickup Location</th>
                    <th>Drop-off Location</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rides)): ?>
                    <tr>
                        <td colspan="6" class="text-center">No booking history found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($rides as $ride): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ride['id']); ?></td>
                            <td><?php echo htmlspecialchars($ride['driver_name']); ?></td>
                            <td><?php echo htmlspecialchars($ride['pickup_location']); ?></td>
                            <td><?php echo htmlspecialchars($ride['dropoff_location']); ?></td>
                            <td><?php echo htmlspecialchars($ride['status']); ?></td>
                            <td><?php echo htmlspecialchars($ride['date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>