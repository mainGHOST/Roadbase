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
</head>

<body>

    <?php require 'navbar.php' ?>
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
                                                <div class="container mt-3">
                                                    <h2>Pay for your ride</h2>
                                                    <form id="paymentForm-<?php echo $booking_id; ?>">
                                                        <div class="form-group">
                                                            <label for="email-<?php echo $booking_id; ?>">Email</label>
                                                            <input type="email" id="email" class="form-control" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="amount-<?php echo $booking_id; ?>">Amount</label>
                                                            <input type="number" id="amount" class="form-control" required />
                                                        </div>
                                                        <button class='btn btn-primary' onclick="payWithPaystack('<?php echo $booking_id; ?>')">Pay Now</button>

                                                    </form>
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
        document.querySelectorAll('.pay-btn').forEach(button => {
            button.addEventListener('click', function() {
                const bookingId = this.dataset.bookingId;
                const email = document.getElementById(`email`).value;
                const amount = document.getElementById(`amount`).value;

                // Initiate payment with Paystack
                let handler = PaystackPop.setup({
                    key: 'pk_test_7c54585414ae082b62780f84360cf52cbc5245b7', // Replace with your Paystack public key
                    email: email, // Replace with the passenger's email
                    amount: amount * 100, // Paystack processes payments in kobo
                    currency: "NGN",
                    callback: function(response) {
                        // Payment succeeded, update the backend
                        fetch(`/update-payment.php?booking_id=${bookingId}&reference=${response.reference}`)
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Payment successful!');
                                    // Change the button to "Completed"
                                    button.textContent = 'Completed';
                                    button.classList.remove('pay-btn');
                                    button.classList.add('completed-btn');
                                    button.disabled = true;
                                }
                            });
                    },
                    onClose: function() {
                        alert('Transaction was not completed.');
                    }
                });

                handler.openIframe();
            });
        });
    </script>


    <script>
        function payWithPaystack(booking_id) {
            const email = document.getElementById(`email`).value;
            const amount = document.getElementById(`amount`).value;
            var handler = PaystackPop.setup({
                key: 'pk_test_7c54585414ae082b62780f84360cf52cbc5245b7', // Replace with your Paystack public key
                email: email, // Customer's email
                amount: amount * 100, // Amount in Kobo (1 Naira = 100 Kobo)
                currency: 'NGN', // Set currency to Naira
                ref: 'booking_' + booking_id + '_' + Math.floor((Math.random() * 1000000000) + 1), // Unique transaction reference
                callback: function(response) {
                    // This function is called when payment is successful
                    alert('Payment successful. Transaction ref is ' + response.reference);
                    // You can now send the transaction reference to your backend to verify the payment
                    verifyPayment(response.reference, booking_id);
                },
                onClose: function() {
                    // This function is called when the user closes the payment modal
                    alert('Transaction was not completed, window closed.');
                }
            });
            handler.openIframe(); // Open the Paystack modal
        }

        function verifyPayment($reference) {
            $url = 'https://api.paystack.co/transaction/verify/'.$reference;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer sk_test_6d66b36e51c86a795cfabb3f949efadbea418d6d', // Replace with your Paystack secret key
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);

            if ($result['status'] && $result['data']['status'] === 'success') {
                // Payment successful
                return $result;
            } else {
                // Payment failed
                return false;
            }
        }
    </script>



</body>

</html>