-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
<<<<<<< HEAD
-- Generation Time: Jun 24, 2025 at 07:22 PM
=======
-- Generation Time: Jun 23, 2025 at 12:50 PM
>>>>>>> a64a08a361f29c88c275a78a1cd4b00e3b292f1b
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
<<<<<<< HEAD
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
=======
>>>>>>> a64a08a361f29c88c275a78a1cd4b00e3b292f1b
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
<<<<<<< HEAD
(3, 14, 2, 'rejected', '2025-06-22 16:00:54'),
(4, 12, 4, 'pending', '2025-06-23 18:23:43'),
(5, 12, 10, 'pending', '2025-06-24 10:09:25'),
(6, 16, 5, 'accepted', '2025-06-24 10:16:48'),
(7, 17, 10, 'accepted', '2025-06-24 10:43:35');
=======
(3, 14, 2, 'rejected', '2025-06-22 16:00:54');
>>>>>>> a64a08a361f29c88c275a78a1cd4b00e3b292f1b

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
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ride_offers`
--

INSERT INTO `ride_offers` (`id`, `origin`, `destination`, `departure_date`, `departure_time`, `return_time`, `seats`, `comments`, `created_at`, `rating`, `feedback`, `user_id`) VALUES
(1, 'chicken inn', 'strathmore', '4444-04-04', '04:02:00', '06:03:00', 2, 'no music', '2025-06-15 16:07:51', NULL, NULL, NULL),
(2, 'jojos', 'fia', '2024-04-04', '04:02:00', '05:02:00', 3, 'no drinks please', '2025-06-15 16:13:43', NULL, NULL, NULL),
(3, 'theseus', 'campbell', '2033-05-04', '05:07:00', '12:02:00', 4, 'be funny', '2025-06-15 16:17:41', NULL, NULL, NULL),
(4, 'startmore', 'kafoca', '2025-05-03', '04:05:00', '06:02:00', 3, 'no mohas', '2025-06-16 08:29:42', NULL, NULL, NULL),
(5, 'naivas', 'strathmore', '2025-06-11', '06:04:00', '04:03:00', 1, 'rr', '2025-06-16 10:23:38', NULL, NULL, NULL),
(6, 'karafuke', 'john station', '2025-04-03', '04:05:00', '07:02:00', 3, 'no songs', '2025-06-16 21:55:30', NULL, NULL, NULL),
(7, 'vvvvvvv', 'hhhhhhh', '2025-03-02', '05:06:00', '02:04:00', 3, 'fff', '2025-06-16 21:57:05', NULL, NULL, NULL),
(8, 'vvvvvvv', 'hhhhhhh', '2025-03-02', '05:06:00', '02:04:00', 3, 'fff', '2025-06-16 22:01:12', NULL, NULL, NULL),
(9, 'ggggggg', 'xxxxx', '2026-04-02', '02:04:00', '04:05:00', 2, 'ddd', '2025-06-16 22:02:52', NULL, NULL, NULL),
(10, 'ggggggg', 'xxxxx', '2026-04-02', '02:04:00', '04:05:00', 2, 'ddd', '2025-06-16 22:10:05', NULL, NULL, 1),
(11, 'karaf', 'ddddd', '2027-04-03', '04:04:00', '05:06:00', 1, 'no perfume', '2025-06-16 22:11:07', NULL, NULL, 1),
(12, 'freestreet', 'moi avenue', '2025-05-04', '05:07:00', '09:08:00', 3, 'no comment', '2025-06-16 22:15:43', NULL, NULL, 2),
(13, 'freestreet', 'moi avenue', '2025-05-04', '05:07:00', '06:07:00', 3, 'no music\r\n', '2025-06-19 15:47:19', NULL, NULL, 2),
<<<<<<< HEAD
(14, 'sangale', 'tmall', '2025-06-05', '08:09:00', '10:04:00', 2, 'no singing', '2025-06-22 16:00:00', NULL, NULL, 3),
(15, 'Strathmore Business School, Nairobi, Kenya', 'University of Nairobi - Main Campus, Nairobi, Kenya', '2025-07-06', '07:08:00', '10:09:00', 4, 'be funny', '2025-06-23 18:22:33', NULL, NULL, 4),
(16, 'kisumu', 'Longleat Safari Park, Warminster, United Kingdom', '2025-06-27', '03:54:00', '00:00:00', 4, '', '2025-06-24 10:10:41', NULL, NULL, 10),
(17, 'Strathmore University, Nairobi, Kenya', 'Safaricom, Nairobi, Kenya', '2025-06-27', '03:45:00', '06:08:00', 3, 'no music', '2025-06-24 10:39:56', NULL, NULL, 11);
=======
(14, 'sangale', 'tmall', '2025-06-05', '08:09:00', '10:04:00', 2, 'no singing', '2025-06-22 16:00:00', NULL, NULL, 3);
>>>>>>> a64a08a361f29c88c275a78a1cd4b00e3b292f1b

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
<<<<<<< HEAD
  `car_capacity` int(11) DEFAULT NULL,
  `house_number` varchar(50) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified_at` timestamp NULL DEFAULT NULL,
  `estate_id` int(11) DEFAULT NULL
=======
  `car_capacity` int(11) DEFAULT NULL
>>>>>>> a64a08a361f29c88c275a78a1cd4b00e3b292f1b
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

<<<<<<< HEAD
INSERT INTO `users` (`id`, `name`, `email`, `password`, `gender`, `age`, `created_at`, `profile_image`, `is_driver`, `car_model`, `license_plate`, `car_capacity`, `house_number`, `is_verified`, `verification_requested_at`, `verified_at`, `estate_id`) VALUES
(2, 'keiran', 'keiran@gmail.com', '$2y$10$t.gogAYP0r3rhBqq6F/tkeYJtwj5oFwYnd0cMVsNYR63dKRPDofL6', 'F', 40, '2025-06-16 22:14:27', '1750329473_MyImage.jpeg', 1, 'mark x', 'kba 234f', NULL, '', 1, '2025-06-23 20:08:46', '2025-06-23 20:24:06', 2),
(3, 'cato112', 'catolicious@gmail.com', '$2y$10$LXyt0glpzzvrA99/7f2dr.Gzvy8IrWMqL6MsvYqsKHoD0h69aKNNW', 'M', 89, '2025-06-19 09:23:03', NULL, 1, 'toyota corolla', 'kAA 234T', 4, '', 1, '2025-06-23 20:08:46', '2025-06-23 20:35:45', 3),
(5, 'manesh', 'mash23@gmail.com', '$2y$10$dWWHHhVxZJgkYT7OhU2W/ONf/kbG8GbS9BV8cVplGe40zD2lqCaqq', 'M', 24, '2025-06-23 20:21:55', NULL, 0, NULL, NULL, NULL, '', 1, '2025-06-23 20:21:55', '2025-06-24 09:04:46', 1),
(6, 'jp45', 'jp45@gmail.com', '$2y$10$1t.JkXqEWm/0OkZBixOv.e9F3rykgATipOJeTLu8iAOVnQzjSet9K', 'M', 23, '2025-06-23 20:38:38', NULL, 0, NULL, NULL, NULL, '2345', 1, '2025-06-23 20:38:38', '2025-06-23 20:39:39', 2),
(7, 'jp', 'jp@gmail.com', '$2y$10$lVs.GDEmiKcRVYxmhYb78e926vATPDdgaeICVTkK00XYDMdu.rV6C', 'M', 56, '2025-06-23 20:41:40', NULL, 0, NULL, NULL, NULL, '2798', 0, '2025-06-23 20:41:40', NULL, 3),
(8, 'moasha', 'moasha@gmail.com', '$2y$10$4wKHISAvFRKNdRck.Sp4qeQY7Gvr7cHLzG4KJge0.t6PnPca3IGMW', 'F', 27, '2025-06-24 08:18:09', NULL, 0, NULL, NULL, NULL, '1125', 0, '2025-06-24 08:18:09', NULL, 1),
(9, 'jojos', 'jojo@gmail.com', '$2y$10$tWuOf8HItYoCNaX4nN7mRulhFYWA56FsfTkPFR/3Khqm8irKndA.K', 'M', 24, '2025-06-24 08:34:04', NULL, 0, NULL, NULL, NULL, '4567', 0, '2025-06-24 08:34:04', NULL, 3),
(10, 'Dickson', 'dickson@gmail.com', '$2y$10$MNcgnGDVE45UkHgxliY5UOdGTJ2RbmQhBUi0zM5yjOg7Bx.Y2jpPy', 'Male', 34, '2025-06-24 09:59:46', NULL, 1, 'tesla', 'KDB 234D', 4, '3B', 1, '2025-06-24 09:59:46', '2025-06-24 10:01:24', 2),
(11, 'tom', 'tom@gmail.com', '$2y$10$FbX7rTAhLXNt6MGqa80OUeHzSx/M6a3ghMHgNB9cIH74Lek700M4K', 'M', 25, '2025-06-24 10:35:38', NULL, 1, 'toyota corolla', 'kba 456B', 3, '1342', 1, '2025-06-24 10:35:38', '2025-06-24 10:36:56', 2);
=======
INSERT INTO `users` (`id`, `name`, `email`, `password`, `gender`, `age`, `created_at`, `profile_image`, `is_driver`, `car_model`, `license_plate`, `car_capacity`) VALUES
(2, 'keiran', 'keiran@gmail.com', '$2y$10$t.gogAYP0r3rhBqq6F/tkeYJtwj5oFwYnd0cMVsNYR63dKRPDofL6', 'F', 40, '2025-06-16 22:14:27', '1750329473_MyImage.jpeg', 1, 'mark x', 'kba 234f', NULL),
(3, 'cato112', 'catolicious@gmail.com', '$2y$10$LXyt0glpzzvrA99/7f2dr.Gzvy8IrWMqL6MsvYqsKHoD0h69aKNNW', 'M', 89, '2025-06-19 09:23:03', NULL, 1, 'toyota corolla', 'kAA 234T', 4),
(4, 'ELVIS1123', 'cato1123@gmail.com', '$2y$10$R4Vm3rclou.fuYS4PYvm/u8eNtpJJDdi3hRPYwXefCyhz8mtMf9X.', 'M', 59, '2025-06-23 07:44:48', '1750664876_Rap Legends - Hiphop Legends 2k _ OpenSea.jpeg', 1, 'probox', 'KAE 2PAT', 4);
>>>>>>> a64a08a361f29c88c275a78a1cd4b00e3b292f1b

--
-- Indexes for dumped tables
--

--
<<<<<<< HEAD
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
=======
>>>>>>> a64a08a361f29c88c275a78a1cd4b00e3b292f1b
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
<<<<<<< HEAD
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
=======
-- AUTO_INCREMENT for table `ride_bookings`
--
ALTER TABLE `ride_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
>>>>>>> a64a08a361f29c88c275a78a1cd4b00e3b292f1b

--
-- AUTO_INCREMENT for table `ride_offers`
--
ALTER TABLE `ride_offers`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
>>>>>>> a64a08a361f29c88c275a78a1cd4b00e3b292f1b

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
<<<<<<< HEAD
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
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_estate` FOREIGN KEY (`estate_id`) REFERENCES `estates` (`id`) ON DELETE SET NULL;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
>>>>>>> a64a08a361f29c88c275a78a1cd4b00e3b292f1b
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
