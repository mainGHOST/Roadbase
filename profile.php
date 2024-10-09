<?php
session_start();
require 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Get user type and ID from the session
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

// Fetch user profile based on user type
if ($user_type === 'driver') {
    $sql = "SELECT * FROM drivers WHERE id = ?";
} else {
    $sql = "SELECT * FROM passengers WHERE id = ?";
}

$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user is found
if (!$user) {
    echo "User not found.";
    exit;
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update profile based on user type
    if ($user_type === 'driver') {
        $update_sql = "UPDATE drivers SET name = ?, phone = ?, address = ? WHERE id = ?";
    } else {
        $update_sql = "UPDATE passengers SET name = ?, phone = ?, address = ? WHERE id = ?";
    }

    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->execute([$name, $phone, $address, $user_id]);

    // Redirect to the same page to see updated info
    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php require 'navbar.php' ?>
    <div class="container mt-5">
        <h2>Edit Profile</h2>
        <div class="card p-4" style="max-width: 700px;">
            <form method="POST" action="update_profile.php">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                <div class="form-group my-2">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="form-group my-2">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required readonly>
                </div>
                <div class="form-group my-2">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>
                <!-- <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
        </div> -->
                <!-- <div class="form-group">
            <label for="status">Role:</label>
            <select class="form-control" name="status" required disabled>
              <option value="0" <?php echo $user['status'] == 0 ? 'selected' : ''; ?>>Passenger</option>
                <option value="1" <?php echo $user['status'] == 1 ? 'selected' : ''; ?>>Driver</option>
            </select>
        </div> -->
                <div class=" gap-3 mt-3">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    <a href="Ride.php" class="btn btn-secondary">Back to Home</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>