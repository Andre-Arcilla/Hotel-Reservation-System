-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2026 at 07:42 PM
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
-- Database: `hotelsogo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `ref_no` varchar(20) NOT NULL DEFAULT '000000',
  `name` varchar(255) NOT NULL DEFAULT 'John Smith',
  `contact` varchar(50) NOT NULL DEFAULT '987-654-3210',
  `email` varchar(100) NOT NULL DEFAULT 'johm.smith@gmail.com',
  `room_capacity` enum('Single','Double','Family') NOT NULL DEFAULT 'Single',
  `room_type` enum('Regency','Deluxe','Premium') NOT NULL DEFAULT 'Regency',
  `checkin_date` date NOT NULL DEFAULT current_timestamp(),
  `checkout_date` date NOT NULL DEFAULT current_timestamp(),
  `total_bill` decimal(10,2) NOT NULL DEFAULT 1000.00,
  `mop` enum('Cash','Check','Credit Card') NOT NULL DEFAULT 'Cash'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `ref_no`, `name`, `contact`, `email`, `room_capacity`, `room_type`, `checkin_date`, `checkout_date`, `total_bill`, `mop`) VALUES
(30, 'SOGO-69C95EB7D89BE', 'aaa aaa', '123', 'aaa@aaa.com', 'Single', 'Regency', '2026-03-30', '2026-04-01', 200.00, 'Cash'),
(31, 'SOGO-69C95F052D8B0', 'bbb bbb', '09671231234', 'aaa@aaa.com', 'Double', 'Deluxe', '2026-03-30', '2026-04-02', 1575.00, 'Check'),
(32, 'SOGO-69C95FAEDA110', 'ccc ccc', '123', 'aaa@aaa.com', 'Family', 'Premium', '2026-03-30', '2026-03-31', 1100.00, 'Credit Card');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
