<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ride_id = $_POST['ride_id'];

    // Delete the ride from the database
    $stmt = $pdo->prepare("DELETE FROM rides WHERE id = ? AND user_id = ?");
    if ($stmt->execute([$ride_id, $_SESSION['user_id']])) {
        // Redirect back to view rides after successful cancellation
        header("Location: view_rides.php");
        exit;
    } else {
        echo '<div class="alert alert-danger">Failed to cancel ride. Please try again.</div>';
    }
}
?>
