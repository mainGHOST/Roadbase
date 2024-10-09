<?php
require_once '../config/database.php';
require_once '../classes/Ride.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passengerId = $_POST['passenger_id']; // assume user authentication is handled
    $destination = $_POST['destination'];
    $fare = $_POST['fare'];

    $ride = new Ride($pdo);
    if ($ride->bookRide($passengerId, $destination, $fare)) {
        echo json_encode(['status' => 'success', 'message' => 'Ride booked successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to book ride.']);
    }
}
?>
