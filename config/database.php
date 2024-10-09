<?php
// Database connection settings
$host = 'localhost';
$dbname = 'roadbase';
$user = 'root'; // replace with your DB username
$pass = ''; // replace with your DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
