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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        input,
        select,
        button {
            min-width: 250px;
        }
    </style>
</head>

<body>
    <div class="row m-5 gx-5">
        <div class="col-6">
            <h2 class="fs-3 mb-4">Register</h2>
            <div class="card p-5 ">
                <form action="register.php" class="row-gap-3" method="POST">
                    <div class="d-flex justify-content-start gap-5">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control my-1" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control my-1" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start gap-5">
                        <div class="form-group">
                            <label for="phone">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control my-1" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control my-1" id="address" name="address">
                        </div>
                    </div>
                    <div class="d-flex justify-content-start gap-5">
                        <div class="form-group">
                            <label for="vehicle_info">Vehicle Info</label>
                            <input type="text" class="form-control my-1" id="vehicle_info" name="vehicle_info">
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control my-1" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start items-center align-items-end gap-5">
                        <div class="form-group">
                            <label for="user_type">Register as<span class="text-danger">*</span>:</label>
                            <select class="form-control my-1" id="user_type" name="user_type" required>
                                <option value="passenger">Passenger</option>
                                <option value="driver">Driver</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-6 ">
            <h2 class="fs-3 mb-4">Login</h2>
            <div class="card" style="max-width: 500px;">
                <form action="login.php" class="p-3" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control my-1" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control my-1" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="user_type">Login as:</label>
                        <select class="form-control my-1" id="user_type" name="user_type" required>
                            <option value="passenger">Passenger</option>
                            <option value="driver">Driver</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary px-3 mt-3">Login</button>
                </form>
            </div>
        </div>
</body>

</html>