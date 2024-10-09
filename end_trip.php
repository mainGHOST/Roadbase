<?php
session_start();
require 'config/database.php';

// Check if the user is logged in as a driver
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Get the ride ID from the AJAX request
$ride_id = $_POST['ride_id'];
$driver_id = $_SESSION['user_id']; // Get the driver ID from the session

try {
    // Start a transaction
    $pdo->beginTransaction();

    // Update the ride status to 'completed'
    $updateRideSQL = "UPDATE ride_requests SET status = 'completed' WHERE id = :ride_id AND driver_id = :driver_id";
    $updateRideStmt = $pdo->prepare($updateRideSQL);
    $updateRideStmt->execute(['ride_id' => $ride_id, 'driver_id' => $driver_id]);

    // Update the driver's status to 'available'
    $updateDriverSQL = "UPDATE drivers SET status = 'available' WHERE id = :driver_id";
    $updateDriverStmt = $pdo->prepare($updateDriverSQL);
    $updateDriverStmt->execute(['driver_id' => $driver_id]);

    // Commit the transaction
    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Roll back the transaction if something fails
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
