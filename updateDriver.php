<?php

// Function to update driver's wallet balance
function updateDriverBalance($driverId, $amount) {
    // Assuming you have a database connection set up
    $conn = new mysqli('localhost', 'username', 'password', 'database');
    
    // Check the connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Update driver's wallet balance
    $stmt = $conn->prepare("UPDATE drivers SET wallet_balance = wallet_balance + ? WHERE id = ?");
    $stmt->bind_param('di', $amount, $driverId);
    $stmt->execute();

    // Close the connection
    $stmt->close();
    $conn->close();
}

// Example usage: Add 0.1 ETH to the driver's wallet after payment is successful
updateDriverBalance(1, 0.1);  // Assuming Driver ID is 1 and 0.1 ETH payment

function verifyPayment($txHash) {
    global $eth;
    
    // Get the transaction receipt
    $eth->getTransactionReceipt($txHash, function ($err, $receipt) {
        if ($err !== null) {
            echo 'Error: ' . $err->getMessage();
            return;
        }
        
        if ($receipt !== null && $receipt->status === '0x1') {
            // Payment successful
            echo 'Payment confirmed!';
            updateDriverBalance(1, 0.1);  // Update driver's wallet
        } else {
            echo 'Payment verification failed.';
        }
    });
}
?>
