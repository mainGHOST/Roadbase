<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
    header("Location: index.php"); // Redirect to login if not logged in or not admin
    exit;
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "User not found.";
        exit;
    }
} else {
    echo "Invalid user ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone = ?, status = ? WHERE id = ?");
    if ($stmt->execute([$name, $email, $phone, $status, $user_id])) {
        header("Location: user_management.php"); // Redirect to user management page
        exit;
    } else {
        echo "Update failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php require 'navbar.php' ?>
<div class="container mt-5">
    <h2>Edit User</h2>
    <form method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Role:</label>
            <select class="form-control" name="status" required>
                <option value="0" <?php echo $user['status'] == 0 ? 'selected' : ''; ?>>Passenger</option>
                <option value="1" <?php echo $user['status'] == 1 ? 'selected' : ''; ?>>Driver</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="user_management.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
