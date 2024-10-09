<?php
session_start();
require 'config/database.php'; // Connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type']; // passenger or driver
    

    if ($user_type === 'passenger') {
        // Query passengers table
        $sql = "SELECT * FROM passengers WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

    } elseif ($user_type === 'driver') {
        // Query drivers table
        $sql = "SELECT * FROM drivers WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Check if user exists and verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Store user info in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $user_type;  // Either 'passenger' or 'driver'
        $_SESSION['name'] = $user['name'];
    
        // Redirect based on user type
            header("Location: profile.php");
        exit;
    }
}
?>
