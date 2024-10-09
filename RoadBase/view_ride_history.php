<?php
session_start();
require 'config/database.php';

// Check if the driver is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$driver_id = $_SESSION['user_id'];

// Fetch the rides that are still active (status is 'accepted')
$sql = "SELECT rr.*, p.name AS passenger_name 
        FROM ride_requests rr
        JOIN passengers p ON rr.passenger_id = p.id
        WHERE rr.driver_id = :driver_id AND (rr.status = 'accepted' OR rr.status = 'completed')";
$stmt = $pdo->prepare($sql);
$stmt->execute(['driver_id' => $driver_id]);
$rides = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Ride History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2>Your Ride History</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ride ID</th>
                    <th>Passenger Name</th>
                    <th>Pickup Location</th>
                    <th>Drop-off Location</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($rides): ?>
                    <?php foreach ($rides as $ride): ?>
                        <tr>
                            <td><?php echo $ride['id']; ?></td>
                            <td><?php echo $ride['passenger_name']; ?></td>
                            <td><?php echo $ride['pickup_location']; ?></td>
                            <td><?php echo $ride['dropoff_location']; ?></td>
                            <td><?php echo ucfirst($ride['status']); ?></td>
                            <td>
                                <?php if ($ride['status'] == 'accepted'): ?>
                                    <button class="btn btn-success end-trip" data-ride-id="<?php echo $ride['id']; ?>">End Trip</button>
                                <?php else: ?>
                                    <span class="text-muted">Completed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No rides found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // End trip
            $('.end-trip').click(function() {
                var rideId = $(this).data('ride-id');

                $.ajax({
                    url: 'end_trip.php',
                    method: 'POST',
                    data: {
                        ride_id: rideId
                    },
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.success) {
                            alert('Trip ended successfully!');
                            location.reload(); // Reload the page to update the ride history
                        } else {
                            alert('Error: ' + res.message);
                        }
                    }

                });
            });
        });
    </script>
</body>

</html>