<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

// Fetch all drivers
$stmt = $pdo->prepare("SELECT * FROM drivers");
$stmt->execute();
$drivers = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Drivers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require 'navbar.php' ?>
<div class="container mt-5">
    <h2>All Drivers</h2>
    <?php if ($drivers): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Vehicle Info</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($drivers as $driver): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($driver['name']); ?></td>
                        <td><?php echo htmlspecialchars($driver['email']); ?></td>
                        <td><?php echo htmlspecialchars($driver['phone']); ?></td>
                        <td><?php echo htmlspecialchars($driver['vehicle_info']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No drivers found.</p>
    <?php endif; ?>
    <a href="add_driver.php" class="btn btn-primary">Add New Driver</a>
    <a href="ride.php" class="btn btn-secondary">Back to Home</a>
</div>
</body>
</html>
