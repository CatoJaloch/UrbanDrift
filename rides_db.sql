-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2025 at 01:29 PM
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
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ride_offers`
--

INSERT INTO `ride_offers` (`id`, `origin`, `destination`, `departure_date`, `departure_time`, `return_time`, `seats`, `comments`, `created_at`, `rating`, `feedback`) VALUES
(1, 'chicken inn', 'strathmore', '4444-04-04', '04:02:00', '06:03:00', 2, 'no music', '2025-06-15 16:07:51', NULL, NULL),
(2, 'jojos', 'fia', '2024-04-04', '04:02:00', '05:02:00', 3, 'no drinks please', '2025-06-15 16:13:43', NULL, NULL),
(3, 'theseus', 'campbell', '2033-05-04', '05:07:00', '12:02:00', 4, 'be funny', '2025-06-15 16:17:41', NULL, NULL),
(4, 'startmore', 'kafoca', '2025-05-03', '04:05:00', '06:02:00', 3, 'no mohas', '2025-06-16 08:29:42', NULL, NULL),
(5, 'naivas', 'strathmore', '2025-06-11', '06:04:00', '04:03:00', 1, 'rr', '2025-06-16 10:23:38', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ride_offers`
--
ALTER TABLE `ride_offers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ride_offers`
--
ALTER TABLE `ride_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
