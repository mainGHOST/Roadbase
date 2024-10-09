<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

// Fetch feedback for a specific ride
$ride_id = $_GET['ride_id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM feedback WHERE ride_id = ?");
$stmt->execute([$ride_id]);
$feedbacks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback for Ride <?php echo htmlspecialchars($ride_id); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require 'navbar.php' ?>
<div class="container mt-5">
    <h2>Feedback for Ride ID: <?php echo htmlspecialchars($ride_id); ?></h2>
    <a href="ride_history.php" class="btn btn-secondary">Back to Ride History</a>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Feedback ID</th>
                <th>User ID</th>
                <th>Rating</th>
                <th>Comments</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($feedbacks as $feedback): ?>
                <tr>
                    <td><?php echo $feedback['id']; ?></td>
                    <td><?php echo $feedback['user_id']; ?></td>
                    <td><?php echo $feedback['rating']; ?></td>
                    <td><?php echo htmlspecialchars($feedback['comments']); ?></td>
                    <td><?php echo $feedback['date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
