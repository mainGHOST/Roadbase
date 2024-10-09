<?php
session_start();
require 'config/database.php';

// Check if the driver is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'driver') {
    header("Location: index.php");
    exit;
}

$driver_id = $_SESSION['user_id'];

// Fetch pending ride requests for this driver
$sql = "SELECT * FROM ride_requests WHERE driver_id = ? AND status = 'requested'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$driver_id]);
$ride_requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Requests</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require 'navbar.php' ?>
<div class="container mt-5">
    <h2>Your Ride Requests</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ride ID</th>
                <th>Pickup Location</th>
                <th>Drop-off Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ride_requests as $request): ?>
            <tr>
                <td><?php echo $request['id']; ?></td>
                <td><?php echo $request['pickup_location']; ?></td>
                <td><?php echo $request['dropoff_location']; ?></td>
                <td>
                    <button class="btn btn-success accept-ride" data-ride-id="<?php echo $request['id']; ?>">Accept</button>
                    <button class="btn btn-danger reject-ride" data-ride-id="<?php echo $request['id']; ?>">Reject</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // Accept ride
        $('.accept-ride').click(function(){
            var rideId = $(this).data('ride-id');

            $.ajax({
                url: 'accept_ride.php',
                method: 'POST',
                data: { ride_id: rideId },
                success: function(response) {
                    alert('Ride accepted successfully!');
                    location.reload();  // Reload the page to update the ride requests
                }
            });
        });

        // Reject ride
        $('.reject-ride').click(function(){
            var rideId = $(this).data('ride-id');

            $.ajax({
                url: 'reject_ride.php',
                method: 'POST',
                data: { ride_id: rideId },
                success: function(response) {
                    alert('Ride rejected successfully!');
                    location.reload();  // Reload the page to update the ride requests
                }
            });
        });
    });
</script>
</body>
</html>
