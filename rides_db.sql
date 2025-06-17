-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2025 at 10:04 AM
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
(12, 'freestreet', 'moi avenue', '2025-05-04', '05:07:00', '09:08:00', 3, 'no comment', '2025-06-16 22:15:43', NULL, NULL, 2);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `gender`, `age`, `created_at`) VALUES
(1, 'john', 'moka@gmail.com', '$2y$10$yT1HJZXwzUSCla8PsmdCZeUIxv85K3Tf5ZDQ3cqga6pWjvPzpbygS', 'M', 25, '2025-06-16 21:42:42'),
(2, 'keiran', 'keiran@gmail.com', '$2y$10$t.gogAYP0r3rhBqq6F/tkeYJtwj5oFwYnd0cMVsNYR63dKRPDofL6', 'F', 40, '2025-06-16 22:14:27');

--
-- Indexes for dumped tables
--

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
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ride_offers`
--
ALTER TABLE `ride_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
