async function connectWallet() {
    if (typeof window.ethereum !== 'undefined') {
        try {
            const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
            const userAddress = accounts[0]; // Get the first account
            console.log('Connected:', userAddress);
            return userAddress;
        } catch (error) {
            console.error('Error connecting to wallet:', error);
        }
    } else {
        alert('Please install MetaMask or another wallet to use this feature.');
    }
}

async function processPayment(amount) {
    const userAddress = await connectWallet(); // Connect wallet and get address

    if (userAddress) {
        // Call your PHP endpoint to process the payment
        fetch('process_payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                amount: amount,
                from: userAddress, // Use the connected address
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Payment response:', data);
            // Handle payment response
        })
        .catch(error => {
            console.error('Error processing payment:', error);
        });
    }
}

// Add an event listener for the connect wallet button
document.getElementById('connectWalletButton').addEventListener('click', () => {
    // Replace 0.1 with the actual amount you want to process
    processPayment(0.1);
});
