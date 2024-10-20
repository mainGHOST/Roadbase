<?php
require 'vendor/autoload.php';
$config = require 'config.php';

use Thirdweb\ThirdwebSDK;

// Initialize Thirdweb SDK
$sdk = new ThirdwebSDK('YOUR_WALLET_PRIVATE_KEY', $config['thirdweb_api_key']);

function sendPayment($amount, $toAddress) {
    global $sdk;

    // Sending the payment
    try {
        $tx = $sdk->getContract($config['thirdweb_contract_address'])
            ->call('transfer', [$toAddress, $amount]);

        return $tx;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return null;
    }
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount']; // Amount in wei
    $toAddress = $_POST['toAddress']; // Address to send payment

    $transaction = sendPayment($amount, $toAddress);
    if ($transaction) {
        echo 'Payment sent! Transaction: ' . $transaction;
        // Redirect to profile or confirmation page
        header('Location: profile.php');
        exit;
    } else {
        echo 'Payment failed.';
    }
}
