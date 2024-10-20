<?php
session_start(); // Start the session
require 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tricycle Booking Platform</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="row">
        <div class="d-flex justify-content-center mt-5">
            <div class="card"  style="width: 600px;">
                <div class="card-header">
                    <h2>Login</h2>
                </div>
                <div class="card-body">
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="user_type">Login as:</label>
                            <select class="form-control" id="user_type" name="user_type" required>
                                <option value="passenger">Passenger</option>
                                <option value="driver">Driver</option>
                            </select>
                        </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <p class="d-flex justify-content-center">Don't have an account? <a href="newuser.php">Register</a></p>
    </div>
</body>

</html>