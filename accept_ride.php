<?php
session_start();
require 'config/database.php';

// Ensure the user is logged in and is a driver
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'driver') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$driver_id = $_SESSION['user_id'];

// Check if ride_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ride_id'])) {
    $ride_id = $_POST['ride_id'];

    // Update the ride status to 'accepted'
    $sql = "UPDATE ride_requests SET status = 'accepted' WHERE id = ? AND driver_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ride_id, $driver_id]);

    // Update driver status to 'on_ride'
    $update_driver_status = "UPDATE drivers SE T status = 'on_ride' WHERE id = ?";
    $stmt = $pdo->prepare($update_driver_status);
    $stmt->execute([$driver_id]);

    echo json_encode(['success' => 'Ride accepted successfully']);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
