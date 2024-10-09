<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $vehicle_info = $_POST['vehicle_info'];

    // Insert the driver into the database
    $stmt = $pdo->prepare("INSERT INTO drivers (name, email, phone, vehicle_info) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $email, $phone, $vehicle_info])) {
        echo '<div class="alert alert-success">Driver added successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to add driver. Please try again.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Driver</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require 'navbar.php' ?>
<div class="container mt-5">
    <h2>Add New Driver</h2>
    <form method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" id="phone" required>
        </div>
        <div class="form-group">
            <label for="vehicle_info">Vehicle Info:</label>
            <input type="text" class="form-control" name="vehicle_info" id="vehicle_info" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Driver</button>
        <a href="ride.php" class="btn btn-secondary">Back to Home</a>
    </form>
</div>
</body>
</html>
