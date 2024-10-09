<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone = ?, address = ?, status = ? WHERE id = ?");
    if ($stmt->execute([$name, $email, $phone, $address, $status, $user_id])) {
        header("Location: profile.php"); // Redirect to profile page
        exit;
    } else {
        echo "Profile update failed.";
    }
}
