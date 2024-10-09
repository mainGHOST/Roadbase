<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

// Fetch notifications for the user
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$notifications = $stmt->fetchAll();

// Mark notifications as read
$update_stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0");
$update_stmt->execute([$user_id]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php require 'navbar.php' ?>
    <div class="container mt-5">
        <h2>Your Notifications</h2>
        <?php if ($notifications): ?>
            <ul class="list-group">
                <?php foreach ($notifications as $notification): ?>
                    <li class="list-group-item <?php echo $notification['is_read'] ? 'list-group-item-light' : 'list-group-item-info'; ?>">
                        <?php echo htmlspecialchars($notification['message']); ?>
                        <small class="text-muted float-right"><?php echo htmlspecialchars($notification['created_at']); ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No notifications.</p>
        <?php endif; ?>
        <a href="Ride.php" class="btn btn-secondary">Back to Home</a>
    </div>
</body>

</html>