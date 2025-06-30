-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 10:40 AM
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
-- Database: `rides_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `estate_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `estate_id`) VALUES
(1, 'buser', 'buser@gmail.com', '$2y$10$93kP94wBEFfXhgHe8TbPlO7YscKsWk5RjPLa/1htGMWfCaukZGzii', '2025-06-23 22:56:05', 1),
(3, 'fuler', 'fuler@gmail.com', '$2y$10$D3qh9G58pauaz3H5HQTCgeaIdz7jh4.1og7w0krtKVKK9Gf4BY9fu', '2025-06-24 08:24:33', 2),
(4, 'tony', 'chopper@gmail.c1om', '$2y$10$5876xRiAG0xV2l1JlcgCAu1S94nhD2Lhj5EAEe0gfYJms/VihNB0e', '2025-06-24 08:29:06', 3);

-- --------------------------------------------------------

--
-- Table structure for table `estates`
--

CREATE TABLE `estates` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estates`
--

INSERT INTO `estates` (`id`, `name`) VALUES
(1, 'Greenfield Estate'),
(2, 'Sunset Villas'),
(3, 'hornet estate');

-- --------------------------------------------------------

--
-- Table structure for table `ride_bookings`
--

CREATE TABLE `ride_bookings` (
  `id` int(11) NOT NULL,
  `ride_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ride_bookings`
--

INSERT INTO `ride_bookings` (`id`, `ride_id`, `user_id`, `status`, `requested_at`) VALUES
(1, 1, 2, 'pending', '2025-06-22 11:51:18'),
(2, 12, 2, 'accepted', '2025-06-22 11:54:06'),
(3, 14, 2, 'rejected', '2025-06-22 16:00:54'),
(4, 12, 4, 'pending', '2025-06-23 18:23:43'),
(5, 12, 10, 'accepted', '2025-06-24 10:09:25'),
(6, 16, 5, 'accepted', '2025-06-24 10:16:48'),
(7, 17, 10, 'accepted', '2025-06-24 10:43:35'),
(8, 17, 10, 'accepted', '2025-06-30 06:30:44'),
(9, 18, 5, 'pending', '2025-06-30 06:56:11'),
(10, 19, 11, 'accepted', '2025-06-30 07:47:55'),
(11, 19, 11, 'rejected', '2025-06-30 08:06:27'),
(12, 19, 11, 'rejected', '2025-06-30 08:06:27'),
(13, 19, 5, 'rejected', '2025-06-30 08:09:03'),
(14, 19, 5, 'rejected', '2025-06-30 08:09:03'),
(15, 19, 10, 'rejected', '2025-06-30 08:11:17'),
(16, 19, 10, 'rejected', '2025-06-30 08:11:17'),
(17, 19, 5, 'accepted', '2025-06-30 08:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `ride_offers`
--

CREATE TABLE `ride_offers` (
  `id` int(11) NOT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `return_time` time DEFAULT NULL,
  `seats` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating` float DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating_by_driver` tinyint(3) UNSIGNED DEFAULT NULL,
  `feedback_by_driver` text DEFAULT NULL,
  `rating_by_passenger` tinyint(3) UNSIGNED DEFAULT NULL,
  `feedback_by_passenger` text DEFAULT NULL,
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ride_offers`
--

INSERT INTO `ride_offers` (`id`, `origin`, `destination`, `departure_date`, `departure_time`, `return_time`, `seats`, `comments`, `created_at`, `rating`, `feedback`, `user_id`, `rating_by_driver`, `feedback_by_driver`, `rating_by_passenger`, `feedback_by_passenger`, `status`) VALUES
(1, 'chicken inn', 'strathmore', '4444-04-04', '04:02:00', '06:03:00', 2, 'no music', '2025-06-15 16:07:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending'),
(2, 'jojos', 'fia', '2024-04-04', '04:02:00', '05:02:00', 3, 'no drinks please', '2025-06-15 16:13:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending'),
(3, 'theseus', 'campbell', '2033-05-04', '05:07:00', '12:02:00', 4, 'be funny', '2025-06-15 16:17:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending'),
(4, 'startmore', 'kafoca', '2025-05-03', '04:05:00', '06:02:00', 3, 'no mohas', '2025-06-16 08:29:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending'),
(5, 'naivas', 'strathmore', '2025-06-11', '06:04:00', '04:03:00', 1, 'rr', '2025-06-16 10:23:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending'),
(6, 'karafuke', 'john station', '2025-04-03', '04:05:00', '07:02:00', 3, 'no songs', '2025-06-16 21:55:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending'),
(7, 'vvvvvvv', 'hhhhhhh', '2025-03-02', '05:06:00', '02:04:00', 3, 'fff', '2025-06-16 21:57:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending'),
(8, 'vvvvvvv', 'hhhhhhh', '2025-03-02', '05:06:00', '02:04:00', 3, 'fff', '2025-06-16 22:01:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending'),
(9, 'ggggggg', 'xxxxx', '2026-04-02', '02:04:00', '04:05:00', 2, 'ddd', '2025-06-16 22:02:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending'),
(10, 'ggggggg', 'xxxxx', '2026-04-02', '02:04:00', '04:05:00', 2, 'ddd', '2025-06-16 22:10:05', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'pending'),
(11, 'karaf', 'ddddd', '2027-04-03', '04:04:00', '05:06:00', 1, 'no perfume', '2025-06-16 22:11:07', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'pending'),
(12, 'freestreet', 'moi avenue', '2025-05-04', '05:07:00', '09:08:00', 3, 'no comment', '2025-06-16 22:15:43', NULL, NULL, 2, NULL, NULL, 2, '', 'completed'),
(14, 'sangale', 'tmall', '2025-06-05', '08:09:00', '10:04:00', 2, 'no singing', '2025-06-22 16:00:00', NULL, NULL, 3, NULL, NULL, NULL, NULL, 'pending'),
(15, 'Strathmore Business School, Nairobi, Kenya', 'University of Nairobi - Main Campus, Nairobi, Kenya', '2025-07-06', '07:08:00', '10:09:00', 4, 'be funny', '2025-06-23 18:22:33', NULL, NULL, 4, NULL, NULL, NULL, NULL, 'pending'),
(16, 'kisumu', 'Longleat Safari Park, Warminster, United Kingdom', '2025-06-27', '03:54:00', '00:00:00', 4, '', '2025-06-24 10:10:41', NULL, NULL, 10, NULL, NULL, 3, 'decent driver', 'completed'),
(17, 'Strathmore University, Nairobi, Kenya', 'Safaricom, Nairobi, Kenya', '2025-06-27', '03:45:00', '06:08:00', 3, 'no music', '2025-06-24 10:39:56', NULL, NULL, 11, NULL, NULL, 3, 'horrible chewer', 'completed'),
(18, 'University of Nairobi - Main Campus, Nairobi, Kenya', 'T-Mall, Nairobi, Kenya', '2025-07-03', '00:00:00', '00:00:00', 3, '', '2025-06-30 06:54:14', NULL, NULL, 2, NULL, NULL, 5, 'good taste in music', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `ride_ratings`
--

CREATE TABLE `ride_ratings` (
  `id` int(11) NOT NULL,
  `ride_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` float NOT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL,
  `is_driver` tinyint(1) DEFAULT 0,
  `car_model` varchar(100) DEFAULT NULL,
  `license_plate` varchar(50) DEFAULT NULL,
  `car_capacity` int(11) DEFAULT NULL,
  `house_number` varchar(50) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified_at` timestamp NULL DEFAULT NULL,
  `estate_id` int(11) DEFAULT NULL,
  `rating` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `gender`, `age`, `created_at`, `profile_image`, `is_driver`, `car_model`, `license_plate`, `car_capacity`, `house_number`, `is_verified`, `verification_requested_at`, `verified_at`, `estate_id`, `rating`) VALUES
(2, 'keiran', 'keiran@gmail.com', '$2y$10$t.gogAYP0r3rhBqq6F/tkeYJtwj5oFwYnd0cMVsNYR63dKRPDofL6', 'F', 40, '2025-06-16 22:14:27', '1750329473_MyImage.jpeg', 1, 'mark x', 'kba 234f', NULL, '', 1, '2025-06-23 20:08:46', '2025-06-23 20:24:06', 2, 0),
(3, 'cato112', 'catolicious@gmail.com', '$2y$10$LXyt0glpzzvrA99/7f2dr.Gzvy8IrWMqL6MsvYqsKHoD0h69aKNNW', 'M', 89, '2025-06-19 09:23:03', NULL, 1, 'toyota corolla', 'kAA 234T', 4, '', 1, '2025-06-23 20:08:46', '2025-06-23 20:35:45', 3, 0),
(5, 'manesh', 'mash23@gmail.com', '$2y$10$dWWHHhVxZJgkYT7OhU2W/ONf/kbG8GbS9BV8cVplGe40zD2lqCaqq', 'M', 24, '2025-06-23 20:21:55', NULL, 0, NULL, NULL, NULL, '', 1, '2025-06-23 20:21:55', '2025-06-24 09:04:46', 1, 0),
(6, 'jp45', 'jp45@gmail.com', '$2y$10$1t.JkXqEWm/0OkZBixOv.e9F3rykgATipOJeTLu8iAOVnQzjSet9K', 'M', 23, '2025-06-23 20:38:38', NULL, 0, NULL, NULL, NULL, '2345', 1, '2025-06-23 20:38:38', '2025-06-23 20:39:39', 2, 0),
(7, 'jp', 'jp@gmail.com', '$2y$10$lVs.GDEmiKcRVYxmhYb78e926vATPDdgaeICVTkK00XYDMdu.rV6C', 'M', 56, '2025-06-23 20:41:40', NULL, 0, NULL, NULL, NULL, '2798', 0, '2025-06-23 20:41:40', NULL, 3, 0),
(8, 'moasha', 'moasha@gmail.com', '$2y$10$4wKHISAvFRKNdRck.Sp4qeQY7Gvr7cHLzG4KJge0.t6PnPca3IGMW', 'F', 27, '2025-06-24 08:18:09', NULL, 0, NULL, NULL, NULL, '1125', 0, '2025-06-24 08:18:09', NULL, 1, 0),
(9, 'jojos', 'jojo@gmail.com', '$2y$10$tWuOf8HItYoCNaX4nN7mRulhFYWA56FsfTkPFR/3Khqm8irKndA.K', 'M', 24, '2025-06-24 08:34:04', NULL, 0, NULL, NULL, NULL, '4567', 0, '2025-06-24 08:34:04', NULL, 3, 0),
(10, 'Dickson', 'dickson@gmail.com', '$2y$10$MNcgnGDVE45UkHgxliY5UOdGTJ2RbmQhBUi0zM5yjOg7Bx.Y2jpPy', 'Male', 34, '2025-06-24 09:59:46', '1751264785_old man.png', 1, 'tesla', 'KDB 234D', 4, '3B', 1, '2025-06-24 09:59:46', '2025-06-24 10:01:24', 2, 0),
(11, 'tom', 'tom@gmail.com', '$2y$10$FbX7rTAhLXNt6MGqa80OUeHzSx/M6a3ghMHgNB9cIH74Lek700M4K', 'M', 25, '2025-06-24 10:35:38', NULL, 1, 'toyota corolla', 'kba 456B', 3, '1342', 1, '2025-06-24 10:35:38', '2025-06-24 10:36:56', 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_admin_estate` (`estate_id`);

--
-- Indexes for table `estates`
--
ALTER TABLE `estates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ride_bookings`
--
ALTER TABLE `ride_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ride_offers`
--
ALTER TABLE `ride_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ride_ratings`
--
ALTER TABLE `ride_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ride_id` (`ride_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_estate` (`estate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `estates`
--
ALTER TABLE `estates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ride_bookings`
--
ALTER TABLE `ride_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ride_offers`
--
ALTER TABLE `ride_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ride_ratings`
--
ALTER TABLE `ride_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `fk_admin_estate` FOREIGN KEY (`estate_id`) REFERENCES `estates` (`id`);

--
-- Constraints for table `ride_ratings`
--
ALTER TABLE `ride_ratings`
  ADD CONSTRAINT `ride_ratings_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `ride_offers` (`id`),
  ADD CONSTRAINT `ride_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_estate` FOREIGN KEY (`estate_id`) REFERENCES `estates` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
