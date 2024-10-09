<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
    header("Location: index.php"); // Redirect to login if not logged in or not admin
    exit;
}

// Fetch feedback
$stmt = $pdo->query("SELECT * FROM feedback");
$feedbacks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require 'navbar.php' ?>
<div class="container mt-5">
    <h2>Feedback Management</h2>
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
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
