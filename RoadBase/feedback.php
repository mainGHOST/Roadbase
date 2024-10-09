<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit;
}

// Fetch the ride ID from the URL (assuming it's passed as a GET parameter)
$ride_id = $_GET['ride_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ride_id = $_POST['ride_id'];
    $user_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    // Insert feedback into the database
    $stmt = $pdo->prepare("INSERT INTO feedback (ride_id, user_id, rating, comments) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$ride_id, $user_id, $rating, $comments])) {
        echo "Feedback submitted successfully!";
        header("Location: ride_history.php"); // Redirect to ride history or another page
        exit;
    } else {
        echo "Failed to submit feedback.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require 'navbar.php' ?>
<div class="container mt-5">
    <h2>Submit Feedback</h2>
    <form method="POST">
        <input type="hidden" name="ride_id" value="<?php echo htmlspecialchars($ride_id); ?>">
        <div class="form-group">
            <label for="rating">Rating (1-5):</label>
            <input type="number" class="form-control" name="rating" min="1" max="5" required>
        </div>
        <div class="form-group">
            <label for="comments">Comments:</label>
            <textarea class="form-control" name="comments" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Feedback</button>
        <a href="ride_history.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
