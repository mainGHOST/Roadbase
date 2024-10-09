<?php
require 'config/database.php'; // Database connection

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $user_type = $_POST['user_type']; // passenger or driver

    if ($user_type === 'passenger') {
        $address = $_POST['address'];
        // Insert into passengers table
        $sql = "INSERT INTO passengers (name, email, phone, address, password) 
                VALUES (:name, :email, :phone, :address, :password)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([':name' => $name, ':email' => $email, ':phone' => $phone, ':address' => $address, ':password' => $password])) {
            header("Location: profile.php"); // Redirect to login page
            exit;
        } else {
            echo "Error: Could not register passenger.";
        }
    } elseif ($user_type === 'driver') {
        $vehicle_info = $_POST['vehicle_info'];
        // Insert into drivers table
        $sql = "INSERT INTO drivers (name, email, phone, vehicle_info, password) 
                VALUES (:name, :email, :phone, :vehicle_info, :password)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([':name' => $name, ':email' => $email, ':phone' => $phone, ':vehicle_info' => $vehicle_info, ':password' => $password])) {
            header("Location: profile.php"); // Redirect to login page
            exit;
        } else {
            echo "Error: Could not register driver.";
        }
    } else {
        echo "Invalid user type.";
    }
}
?>
