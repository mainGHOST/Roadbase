<?php
session_start();
require 'config/database.php';

// Check if user is logged in as a passenger
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'passenger') {
    header("Location: index.php");
    exit;
}

// Fetch available drivers
$sql = "SELECT * FROM drivers WHERE status = 'available'";
$stmt = $pdo->query($sql);
$drivers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Drivers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php require 'navbar.php' ?>
    <div class="container mt-5">
        <h2>Available Drivers</h2>
        <?php if (empty($drivers)): ?>
            <p>No drivers are currently available. Please check back later.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Driver Name</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($drivers as $driver): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($driver['name']); ?></td>
                            <td><?php echo htmlspecialchars($driver['phone']); ?></td>
                            <td>
                                <button class="btn btn-primary book-ride" data-driver-id="<?php echo $driver['id']; ?>">Book Ride</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Book ride
            $('.book-ride').click(function() {
                var driverId = $(this).data('driver-id');
                $.ajax({
                    url: 'book_ride.php', // Create this file to handle ride booking
                    method: 'POST',
                    data: {
                        driver_id: driverId
                    },
                    success: function(response) {
                        alert('Ride booked successfully!');
                    },
                    error: function() {
                        alert('Error booking the ride. Please try again.');
                    }
                });
            });
        });
    </script>
</body>

</html>