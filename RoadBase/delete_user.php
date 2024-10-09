<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
    header("Location: index.php"); // Redirect to login if not logged in or not admin
    exit;
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$user_id])) {
        header("Location: user_management.php"); // Redirect to user management page
        exit;
    } else {
        echo "Deletion failed.";
    }
} else {
    echo "Invalid user ID.";
}
?>
