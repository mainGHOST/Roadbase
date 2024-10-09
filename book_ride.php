<?php
session_start();
require 'config/database.php';

// Check if passenger is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'passenger') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$passenger_id = $_SESSION['user_id'];

// Get driver ID from AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['driver_id'])) {
    $driver_id = $_POST['driver_id'];

    // Check if the driver is still available
    $sql = "SELECT status FROM drivers WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$driver_id]);
    $driver = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($driver && $driver['status'] === 'available') {
        // Update driver's status to 'on_ride'
        $update_sql = "UPDATE drivers SET status = 'on_ride' WHERE id = ?";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->execute([$driver_id]);

        // Create a new ride request
        $insert_sql = "INSERT INTO ride_requests (passenger_id, driver_id, status) VALUES (?, ?, 'pending')";
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->execute([$passenger_id, $driver_id]);

        echo json_encode(['success' => 'Ride booked successfully']);
    } else {
        echo json_encode(['error' => 'Driver is no longer available']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
