<?php
session_start();
require 'config/database.php';

// Check if the passenger is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$passenger_id = $_SESSION['user_id'];

// Fetch booking history for this passenger
$sql = "SELECT rr.*, d.name AS driver_name 
        FROM ride_requests rr
        LEFT JOIN drivers d ON rr.driver_id = d.id
        WHERE rr.passenger_id = :passenger_id
        ORDER BY rr.date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['passenger_id' => $passenger_id]);
$rides = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Booking History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #connect-wallet-btn {
            padding: 10px 20px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #connect-wallet-btn:hover {
            background-color: #005f6b;
        }

        #wallet-address {
            margin-top: 15px;
            font-size: 16px;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <?php require 'navbar.php' ?>
    <div id="wallet-connection">
        <button id="connect-wallet-btn">Connect Wallet</button>
        <p id="wallet-address"></p>
    </div>
    <div class="container mt-5">
        <h2>Your Booking History</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ride ID</th>
                    <th>Driver Name</th>
                    <th>Pickup Location</th>
                    <th>Drop-off Location</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Pay Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rides)): ?>
                    <tr>
                        <td colspan="7" class="text-center">No booking history found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($rides as $ride): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ride['id']); ?></td>
                            <td><?php echo htmlspecialchars($ride['driver_name']); ?></td>
                            <td><?php echo htmlspecialchars($ride['pickup_location']); ?></td>
                            <td><?php echo htmlspecialchars($ride['dropoff_location']); ?></td>
                            <td><?php echo htmlspecialchars($ride['status']); ?></td>
                            <td><?php echo htmlspecialchars($ride['date']); ?></td>
                            <td>
                                <?php
                                // Use payment_status from the $ride array, no need to query again

                                $payment_status = $ride['payment_status'];
                                $booking_id = $ride['id'];

                                // If the payment is pending, show the "Pay Now" button
                                if ($payment_status == 'pending') : ?>
                                    <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#payModal-<?php echo $booking_id; ?>'>Pay Now</button>
                                <?php else: ?>
                                    <p>Completed</p>
                                <?php endif; ?>

                                <!-- Modal for payment (dynamically generated for each ride) -->
                                <div class="modal fade" id="payModal-<?php echo $booking_id; ?>" tabindex="-1" aria-labelledby="payModalLabel-<?php echo $booking_id; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="payModalLabel-<?php echo $booking_id; ?>">Payment for Ride #<?php echo $booking_id; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="payment-form" style="display: none;">
                                                    <input type="number" id="amount" placeholder="Enter amount in Ether">
                                                    <button type="button" id="send-payment-btn">Send Payment</button>
                                                    <p id="transaction-status"></p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        <?php endforeach; ?>
                    <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://js.paystack.co/v2/inline.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        const connectWalletBtn = document.getElementById("connect-wallet-btn");
        const walletAddressDisplay = document.getElementById("wallet-address");
        const paymentForm = document.getElementById("payment-form");
        const sendPaymentBtn = document.getElementById("send-payment-btn");
        const transactionStatus = document.getElementById("transaction-status");

        let passengerAddress = '';

        // Connect MetaMask Wallet
        async function connectWallet() {
            if (typeof window.ethereum !== 'undefined') {
                try {
                    const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
                    passengerAddress = accounts[0];
                    walletAddressDisplay.textContent = `Wallet Address: ${passengerAddress}`;
                    connectWalletBtn.style.display = "none"; // Hide the connect button
                    paymentForm.style.display = "block";  // Show payment form
                } catch (error) {
                    console.error("User denied account access", error);
                }
            } else {
                walletAddressDisplay.textContent = "MetaMask is not installed!";
            }
        }

        // Function to send payment using Web3
        async function sendPayment() {
            const amount = document.getElementById('amount').value; // Get the input amount

            if (amount === '' || isNaN(amount)) {
                transactionStatus.textContent = 'Please enter a valid amount.';
                return;
            }

            // Convert Ether to Wei
            const amountInWei = window.web3.utils.toWei(amount, 'ether');
            const receiverAddress = '0x699D4d39acAF76fA961cf91d88187679Eb2EEeD5';  // Replace with your platform's wallet address

            try {
                const transactionParameters = {
                    to: receiverAddress, // The address of your platform that will receive the payment
                    from: passengerAddress, // The connected passenger's wallet address
                    value: amountInWei.toString(16), // Convert the amount to hex
                };

                // Sending the transaction
                const txHash = await ethereum.request({
                    method: 'eth_sendTransaction',
                    params: [transactionParameters],
                });

                transactionStatus.textContent = `Transaction successful: ${txHash}`;
                console.log('Transaction Hash:', txHash);

                // After sending payment, redirect to profile page
                setTimeout(() => {
                    window.location.href = 'profile.html'; // Redirect to the profile page
                }, 3000);

            } catch (error) {
                console.error(error);
                transactionStatus.textContent = `Error: ${error.message}`;
            }
        }

        // Add event listener to the connect button
        connectWalletBtn.addEventListener("click", connectWallet);

        // Add event listener to the send payment button
        sendPaymentBtn.addEventListener("click", sendPayment);

    </script>

    <!-- Web3 Library -->
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>


</body>

</html>