-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2024 at 02:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roadbase`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `vehicle_info` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` enum('available','on_ride','offline') DEFAULT 'available',
  `is_available` tinyint(1) DEFAULT 1,
  `wallet_balance` decimal(10,2) DEFAULT 0.00,
  `bank_account_number` varchar(20) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `email`, `phone`, `vehicle_info`, `password`, `status`, `is_available`, `wallet_balance`, `bank_account_number`, `bank_name`) VALUES
(1, 'Oluwadamilola David Ogunnaike', 'bola@gmail.com', '08108845182', '12199010002', '$2y$10$2aXjHTvA113eKSafEPpKi.uk0VpfSfZZCI4kGCP82KpvPRe4N/UOy', 'on_ride', 1, 0.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ride_id` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating` int(11) NOT NULL,
  `comments` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `ride_id`, `feedback`, `created_at`, `rating`, `comments`, `date`) VALUES
(2, 1, 3, '', '2024-10-06 18:36:46', 4, 'nice', '2024-10-06 18:37:31'),
(3, 2, 4, '', '2024-10-06 22:35:47', 2, 'dds', '2024-10-06 22:35:47'),
(4, 2, 4, '', '2024-10-06 22:36:14', 3, 'ss', '2024-10-06 22:36:14');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 'Your ride has been booked successfully!', 1, '2024-10-06 14:31:14'),
(2, 1, 'Your ride has been booked successfully!', 1, '2024-10-06 14:39:33'),
(3, 1, 'Your ride has been booked successfully!', 1, '2024-10-06 15:59:28'),
(4, 1, 'Your ride has been booked successfully!', 1, '2024-10-06 18:33:26'),
(5, 2, 'Your ride has been booked successfully!', 1, '2024-10-06 19:00:39'),
(6, 2, 'Your ride has been booked successfully!', 1, '2024-10-06 19:19:49'),
(7, 2, 'Your ride has been booked successfully!', 1, '2024-10-06 19:22:41'),
(8, 2, 'Your ride has been booked successfully!', 1, '2024-10-06 19:23:37'),
(9, 2, 'Your ride has been booked successfully!', 1, '2024-10-06 19:23:41'),
(10, 2, 'Your ride has been booked successfully!', 1, '2024-10-06 19:24:39'),
(11, 2, 'Your ride has been booked successfully!', 1, '2024-10-06 19:49:54'),
(12, 2, 'Your ride has been booked successfully!', 1, '2024-10-06 19:51:26'),
(13, 2, 'Your ride has been booked successfully!', 1, '2024-10-06 19:51:27'),
(14, 2, 'Your ride has been booked successfully!', 1, '2024-10-06 19:51:50'),
(15, 2, 'Your ride has been booked successfully!', 1, '2024-10-06 19:52:24');

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `payment_status` enum('pending','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`id`, `name`, `email`, `phone`, `address`, `password`, `payment_status`) VALUES
(1, 'Ogunnaike Oluwadamilola', 'kemi@gmail.com', '08108845182', '21, Onalaga Street, Off degun', '$2y$10$rvUX07HOdABBIkYbUAMgEejYgpUdryo/TfGZR3128e/utVzJxOf.S', 'pending'),
(2, 'Oluwadamilola David Ogunnaike', 'tolu@gmail.com', '08108845182', '9, Adebisi street, onirigba, ijebu ode', '$2y$10$voQ9Zft7WKqOwFrDqznqu.ouoR/0RD6IwNfhTfFW4WKtZ7fiGlfD.', 'pending'),
(3, 'Oluwadamilola David', 'doluwadamilola68@gmail.com', '09138838212', '9, Adebisi street, onirigba, ijebu ode', '$2y$10$JFAwi4p90Lo3OWZLhHw8Q.QBi0JCY0AP32m81BB.Y5DMtKmTA48Pq', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `ride_request_id` int(11) NOT NULL,
  `passenger_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rides`
--

CREATE TABLE `rides` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pickup_location` varchar(255) DEFAULT NULL,
  `dropoff_location` varchar(255) DEFAULT NULL,
  `ride_date` datetime DEFAULT NULL,
  `status` enum('booked','in_progress','completed','cancelled') DEFAULT 'booked',
  `driver_id` int(11) DEFAULT NULL,
  `estimated_arrival` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `passenger_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rides`
--

INSERT INTO `rides` (`id`, `user_id`, `pickup_location`, `dropoff_location`, `ride_date`, `status`, `driver_id`, `estimated_arrival`, `passenger_id`) VALUES
(3, 1, 'aass', 'aaa', '2024-10-06 15:31:00', 'booked', NULL, '2024-10-06 18:36:29', 1),
(4, 1, 'aass', 'aaa', '2024-10-06 15:31:00', 'booked', NULL, '2024-10-06 22:34:09', 2),
(5, 1, 'aass', 'aaa', '2024-10-06 15:39:00', 'booked', NULL, '2024-10-06 15:54:33', 0),
(6, 1, 'aass', 'aaa', '2024-10-06 15:39:00', 'booked', NULL, '2024-10-06 15:54:33', 0),
(7, 1, 'aass', 'aaa', '2024-10-06 16:59:00', 'booked', NULL, '2024-10-06 17:14:28', 0),
(8, 1, 'aass', 'aaa', '2024-10-06 16:59:00', 'booked', NULL, '2024-10-06 17:14:28', 0),
(9, 1, 'aass', 'aaa', '2024-10-06 19:33:00', 'booked', NULL, '2024-10-06 19:48:26', 0),
(10, 1, 'aass', 'aaa', '2024-10-06 19:33:00', 'booked', NULL, '2024-10-06 19:48:26', 0),
(12, 2, 'aass', 'aaa', '2024-10-06 20:00:00', 'booked', NULL, '2024-10-06 20:15:39', 0),
(14, 2, 'aass', 'aaa', '2024-10-06 20:19:00', 'booked', NULL, '2024-10-06 20:34:49', 0),
(18, 2, NULL, NULL, NULL, 'booked', NULL, '2024-10-06 20:38:37', 0),
(20, 2, NULL, NULL, NULL, 'booked', NULL, '2024-10-06 20:38:41', 0),
(27, 2, NULL, NULL, NULL, 'booked', NULL, '2024-10-06 21:06:27', 0),
(29, 2, NULL, NULL, NULL, 'booked', NULL, '2024-10-06 21:06:50', 0),
(31, 2, NULL, NULL, NULL, 'booked', NULL, '2024-10-06 21:07:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ride_history`
--

CREATE TABLE `ride_history` (
  `id` int(11) NOT NULL,
  `ride_id` int(11) NOT NULL,
  `passenger_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `dropoff_location` varchar(255) NOT NULL,
  `status` enum('completed','canceled') NOT NULL DEFAULT 'completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ride_requests`
--

CREATE TABLE `ride_requests` (
  `id` int(11) NOT NULL,
  `passenger_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `pickup_location` varchar(255) DEFAULT NULL,
  `dropoff_location` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','completed','canceled') DEFAULT 'pending',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('pending','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ride_requests`
--

INSERT INTO `ride_requests` (`id`, `passenger_id`, `driver_id`, `pickup_location`, `dropoff_location`, `status`, `date`, `payment_status`) VALUES
(1, 1, 1, NULL, NULL, 'completed', '2024-10-07 17:16:38', 'pending'),
(2, 1, 1, NULL, NULL, 'completed', '2024-10-08 19:54:14', 'pending'),
(3, 1, 1, NULL, NULL, 'completed', '2024-10-09 08:49:49', 'pending'),
(4, 1, 1, NULL, NULL, 'completed', '2024-10-09 16:44:37', 'pending'),
(5, 1, 1, NULL, NULL, 'accepted', '2024-10-11 14:07:10', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `type` enum('credit','debit') DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `status`) VALUES
(1, 'Cristobal Bode', 'toby20557@gmail.com', '$2y$10$0eB3m9g74k4oLLHQ8UQe0.z4W1.NTewDqIsRXE0RzJysI138.flcm', '4099168663', '1113 E 34th St', 1),
(2, 'Oluwadamilola Ogunnaike', 'doluwadamilola68@gmail.com', '$2y$10$s0VJ7.ndvWmK9pFPMkuRVeQo5VmyYHtipixDSe4h7zSbAzUthY2qG', '08108845182', '21, Onalaga Street, Off degun', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ride_id` (`ride_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ride_request_id` (`ride_request_id`),
  ADD KEY `passenger_id` (`passenger_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `rides`
--
ALTER TABLE `rides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ride_history`
--
ALTER TABLE `ride_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ride_id` (`ride_id`),
  ADD KEY `passenger_id` (`passenger_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `ride_requests`
--
ALTER TABLE `ride_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passenger_id` (`passenger_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rides`
--
ALTER TABLE `rides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ride_history`
--
ALTER TABLE `ride_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ride_requests`
--
ALTER TABLE `ride_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`ride_request_id`) REFERENCES `ride_requests` (`id`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`passenger_id`) REFERENCES `passengers` (`id`),
  ADD CONSTRAINT `ratings_ibfk_3` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`);

--
-- Constraints for table `rides`
--
ALTER TABLE `rides`
  ADD CONSTRAINT `rides_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ride_history`
--
ALTER TABLE `ride_history`
  ADD CONSTRAINT `ride_history_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `ride_requests` (`id`),
  ADD CONSTRAINT `ride_history_ibfk_2` FOREIGN KEY (`passenger_id`) REFERENCES `passengers` (`id`),
  ADD CONSTRAINT `ride_history_ibfk_3` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`);

--
-- Constraints for table `ride_requests`
--
ALTER TABLE `ride_requests`
  ADD CONSTRAINT `ride_requests_ibfk_1` FOREIGN KEY (`passenger_id`) REFERENCES `passengers` (`id`),
  ADD CONSTRAINT `ride_requests_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
