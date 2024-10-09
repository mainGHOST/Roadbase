<?php
session_start();
require 'config/database.php';

// Check if the driver is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'driver') {
    header("Location: index.php");
    exit;
}

$driver_id = $_SESSION['user_id'];

// Fetch ride requests for this driver
$sql = "SELECT rr.*, p.name AS passenger_name, p.phone AS passenger_phone
        FROM ride_requests rr
        JOIN passengers p ON rr.passenger_id = p.id
        WHERE rr.driver_id = ? AND rr.status = 'pending'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$driver_id]);
$ride_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Ride Requests</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require 'navbar.php' ?>
<div class="container mt-5">
    <h2>Your Ride Requests</h2>
    <?php if (empty($ride_requests)): ?>
        <p>No new ride requests.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ride ID</th>
                    <th>Passenger Name</th>
                    <th>Passenger Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ride_requests as $request): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['id']); ?></td>
                        <td><?php echo htmlspecialchars($request['passenger_name']); ?></td>
                        <td><?php echo htmlspecialchars($request['passenger_phone']); ?></td>
                        <td>
                            <button class="btn btn-success accept-ride" data-ride-id="<?php echo $request['id']; ?>">Accept</button>
                            <button class="btn btn-danger reject-ride" data-ride-id="<?php echo $request['id']; ?>">Reject</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
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
                    location.reload(); // Reload page to reflect changes
                },
                error: function() {
                    alert('Error accepting the ride.');
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
                    alert('Ride rejected.');
                    location.reload(); // Reload page to reflect changes
                },
                error: function() {
                    alert('Error rejecting the ride.');
                }
            });
        });
    });
</script>
</body>
</html>
