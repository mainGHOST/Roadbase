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

        a {
            text-decoration: none;
            color: #333;
        }

        body {
            width: 100%;
            height: 100vh;
            background-color: #070707;
            background-image: url(image/body-background.png);
            background-size: cover;
        }

        .logo {
            font-size: 36px;
            font-weight: 400;
            line-height: 47.3px;
            color: #F1F2FF;

        }

        .flex-center {
            display: flex;
            justify-content: center;
            align-items: start;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .padding {
            padding-left: 40px;
        }

        .hero-h2 {
            font-size: 62px;
            color: #F1F2FF;
            font-weight: 600;
            line-height: 87.4px;
            letter-spacing: -0.02em;
            text-align: left;
        }

        .hero-text {
            font-family: Inter;
            font-size: 20px;
            font-weight: 400;
            line-height: 29.05px;
            color: #E0E3FF;
            text-align: left;
            max-width: 600px;
        }

        .car-image {
            width: 600px;
        }

        img {
            width: 100%;
        }
    </style>
</head>

<body>
    <nav class="container-fluid px-5 py-4">
        <div class="flex-between">
            <div class="">
                <p class="logo">RoadBase</a>
            </div>
            <div class="flex-between gap-2">
                <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Book Ride</div>
                <div class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#registerBackdrop">Create Account</div>
            </div>
        </div>
    </nav>
    <div class="flex-between">
        <div class="col-6 flex-center gap-3 flex-column padding">
            <h2 class="hero-h2">
                Ride Freely
                Pay Seamlessly with <span style="color:#0537FF;">Crypto.</span>
            </h2>
            <p class="hero-text">
                Set your fare, choose your ride, and pay with cryptocurrency. Simple, transparent, and secure
            </p>
            <div class="btn btn-primary fs-4 mb-5">Book Ride</div>
            <div class="mt-2">
                <p class="fs-5 text-white">Available on</p>
                <div class="flex-center gap-2 text-white">
                    <img src="image/apple_store.png" style="width: 150px;" alt="">
                    <img src="image/play_store.png" style="width: 150px;" alt="">
                </div>
            </div>
        </div>
        <div class="col-6 p-0">
            <img src="image/Car 1.png" alt="car">
        </div>
    </div>

    <!-- modal Begins -->

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card" style="width: 500px;">
                        <div class="card-body d-flex flex-column gap-4 justify-content-center align-items-center">
                            <div class="d-flex justify-content-end" style="width: 100%;">
                                <p type="button" class="text-danger" data-bs-dismiss="modal" aria-label="Close" style="float: right;">close &times;</p>
                            </div>
                            <h2 class="">Sign in</h2>
                            <form class="d-flex flex-column justify-content-center align-items-center gap-4 flex-column" action="login.php" method="POST">

                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <div>
                                        <label for="email">Email Address:</label>
                                        <input type="emai" class="form-control my-1" id="email" name="email" required>
                                    </div>
                                    <div>
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control my-1" id="password" name="password" required>
                                    </div>
                                    <div>
                                        <label for="user_type">Login as:</label>
                                        <select class="form-control my-1" id="user_type" name="user_type" required>
                                            <option value="passenger">Passenger</option>
                                            <option value="driver">Driver</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary">Sign In</button>
                                </div>
                                <div class="flex-between flex-column gap-2 my-3">
                                    <a href="" class="text-primary">Already have an account?</a>
                                    <a href="" class="text-danger">Forget Password</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- modal Ends -->
    <!-- Register modal begins -->

    <div class="modal fade" id="registerBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card" style="width: 500px;">
                        <div class="card-body d-flex flex-column gap-4 justify-content-center align-items-center">
                            <div class="d-flex justify-content-end" style="width: 100%;">
                                <p type="button" class="text-danger" data-bs-dismiss="modal" aria-label="Close" style="float: right;">close &times;</p>
                            </div>
                            <h2 class="">Sign Up</h2>
                            <form class="d-flex flex-column justify-content-center align-items-center gap-4 flex-column" action="register.php" method="POST">

                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <div>
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control my-1" id="name" name="name" required>
                                    </div>
                                    <div>
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control my-1" id="email" name="email" required>
                                    </div>
                                    <div>
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control my-1" id="phone" name="phone" required>
                                    </div>
                                    <div>
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control my-1" id="phone" name="phone" required>
                                    </div>
                                    <div>
                                        <label for="address">Address (For Passengers)</label>
                                        <input type="text" class="form-control my-1" id="address" name="address">
                                    </div>
                                    <div>
                                        <label for="vehicle_info">Vehicle Info (For Drivers)</label>
                                        <input type="text" class="form-control my-1" id="vehicle_info" name="vehicle_info">
                                    </div>
                                    <div>
                                    <div>
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div>
                                    <label for="user_type">Register as:</label>
                            <select class="form-control" id="user_type" name="user_type" required>
                                <option value="passenger">Passenger</option>
                                <option value="driver">Driver</option>
                            </select>
                                    </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary">Sign In</button>
                                    </div>
                                    <div class="flex-between flex-column gap-2 my-3">
                                        <a href="" class="text-primary">Already have an account?</a>
                                        <a href="" class="text-danger">Forget Password</a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- modal Ends -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>