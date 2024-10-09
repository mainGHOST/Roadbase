<?php
session_start();
require 'config/database.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$passenger_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ride_request_id = $_POST['ride_request_id'];
    $rating = $_POST['rating'];

    // Check if the rating already exists
    $check_sql = $db->query("SELECT * FROM ratings WHERE ride_request_id='$ride_request_id' AND passenger_id='$passenger_id'");
    
    if (mysqli_num_rows($check_sql) > 0) {
        echo "You have already rated this driver.";
        exit;
    }

    // Insert the new rating
    $sql = "INSERT INTO ratings (ride_request_id, passenger_id, driver_id, rating) VALUES ('$ride_request_id', '$passenger_id', (SELECT driver_id FROM ride_requests WHERE id='$ride_request_id'), '$rating')";
    
    if ($db->query($sql) === TRUE) {
        echo "Rating submitted successfully!";
    } else {
        echo "Error: " . $db->error;
    }
    
    // Redirect back to the ride history page
    header("Location: view_ride_history.php");
    exit;
}
?>
