<?php

// Include autoload file and config
require 'vendor/autoload.php';
$config = require 'config.php';

use Web3\Web3;
use Web3\Utils;
use Web3p\EthereumTx\Transaction;
use GuzzleHttp\Client; // Import Guzzle HTTP Client

// Create a custom HTTP client with timeout options
$httpClient = new Client([
    'timeout' => 20,  // 10 seconds timeout
]);
// Initialize Web3 instance
$web3 = new Web3($config['blockchain_api_url']);
$eth = $web3->eth;

// Create payment transaction (Passenger to Platform)
function createPayment($amount, $passengerPrivateKey) {
    global $eth, $config;

    // Convert amount to Wei
    $amountInWei = Utils::toWei($amount, 'ether'); 

    // Create the transaction array
    $transaction = [
        'from' => '0xPassengerWalletAddress',  // Use passenger's address
        'to' => $config['wallet_address'],     // Your platform's wallet address
        'value' => $amountInWei,
        'gas' => '0x5208',  // Gas limit (21000)
        'gasPrice' => Utils::toWei('1', 'gwei'),  // Gas price (1 Gwei)
        'chainId' => 11155111  // Sepolia Testnet chain ID
    ];

    // Sign the transaction with passenger's private key
    $tx = new Transaction($transaction);
    $signedTx = $tx->sign($passengerPrivateKey);

    // Send the signed transaction
    $eth->sendRawTransaction('0x' . $signedTx, function ($err, $txHash) {
        if ($err !== null) {
            throw new Exception('Transaction failed: ' . $err->getMessage());
        }
        return $txHash;
    });
}

// Example usage: Passenger sends 0.1 ETH to the platform
try {
    $txHash = createPayment(0.1, 'PassengerPrivateKeyHere');
    echo 'Payment Successful. Transaction Hash: ' . $txHash;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>
