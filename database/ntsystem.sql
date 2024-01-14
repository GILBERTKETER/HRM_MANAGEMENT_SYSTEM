-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2024 at 06:38 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ntsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `a_id` int(11) NOT NULL,
  `allowance_name` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `a_percentage` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allowances`
--

INSERT INTO `allowances` (`a_id`, `allowance_name`, `a_percentage`) VALUES
(1, 'medical', 5),
(2, 'house', 2);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `sno` int(11) NOT NULL,
  `e_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL DEFAULT current_timestamp(),
  `time_out` time NOT NULL DEFAULT current_timestamp(),
  `hours` float(5,2) NOT NULL,
  `time_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `d_id` int(11) NOT NULL,
  `deduction_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `d_percentage` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`d_id`, `deduction_name`, `d_percentage`) VALUES
(1, 'tax', 16),
(2, 'services', 3);

-- --------------------------------------------------------

--
-- Table structure for table `emp_allowances`
--

CREATE TABLE `emp_allowances` (
  `sno` int(11) NOT NULL,
  `a_id` int(20) NOT NULL,
  `e_id` int(20) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emp_allowances`
--

INSERT INTO `emp_allowances` (`sno`, `a_id`, `e_id`, `amount`, `date_created`) VALUES
(31, 2, 17, 46.88, '2024-01-14 05:39:10'),
(33, 1, 17, 117.20, '2024-01-14 05:39:51');

-- --------------------------------------------------------

--
-- Table structure for table `emp_deductions`
--

CREATE TABLE `emp_deductions` (
  `sno` int(11) NOT NULL,
  `d_id` int(20) NOT NULL,
  `e_id` int(20) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `sno` int(15) NOT NULL,
  `date_of_leave` date NOT NULL,
  `from_id` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_replied` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`sno`, `date_of_leave`, `from_id`, `message`, `status`, `date_created`, `date_replied`) VALUES
(13, '2024-01-14', '9a9afca2a6cf2f5d1aee4717b1382946', 'I am sick', 2, '2024-01-14 05:33:30', '2024-01-14 05:34:04'),
(14, '2024-01-14', '9a9afca2a6cf2f5d1aee4717b1382946', 'i am sick', 1, '2024-01-14 05:34:26', '2024-01-14 05:34:37');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `sno` int(15) NOT NULL,
  `ref_no` varchar(255) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=New,\r\n1=Calculated',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`sno`, `ref_no`, `date_from`, `date_to`, `status`, `date_created`) VALUES
(56, '240114-0517', '2024-01-14', '2024-02-01', 1, '2024-01-14 05:35:17');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_items`
--

CREATE TABLE `payroll_items` (
  `sno` int(20) NOT NULL,
  `ref_no` varchar(255) NOT NULL,
  `e_id` int(15) NOT NULL,
  `present` int(11) NOT NULL,
  `absent` int(11) NOT NULL,
  `hrs_worked` float(5,2) NOT NULL,
  `salary` double(10,2) NOT NULL,
  `allowance_amt` double(10,2) NOT NULL,
  `allowances` text NOT NULL,
  `deduction_amt` double(10,2) NOT NULL,
  `deductions` text NOT NULL,
  `net_salary` double(10,2) NOT NULL,
  `income_tax` double(10,2) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `secondName` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `token` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_of_joining` date NOT NULL,
  `phone` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `profile` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `gender` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `designation` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `salary` double(10,2) NOT NULL,
  `account_no` text NOT NULL,
  `otp` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `secondName`, `email`, `password`, `token`, `status`, `date_of_birth`, `date_of_joining`, `phone`, `profile`, `gender`, `designation`, `salary`, `account_no`, `otp`) VALUES
(16, 'Gilbert', 'Keter', 'gilbertketer759@gmail.com', '$2y$10$XNYEiwEYSiqQlO1TW3sH4O2xaIEdL72P0SOqbgY99sjgFsykeJEyu', '21213343ghdgsd767sddshhdg', 1, '2024-01-10', '2024-01-03', '0759104865', NULL, 'male', 'Admin', 0.00, 'shdgsd', '0'),
(17, 'zachariah', 'Ngugi', 'zachariahngugu03@gmail.com', '$2y$10$V2..j9W5H94BGLRzjV0iZub1dZwhTs.8NCEJNqx5hpWAKyGEcU4oa', '9a9afca2a6cf2f5d1aee4717b1382946', 2, '2024-01-19', '2024-01-14', '9937473792', '', 'Male', 'master', 2344.00, 'QWERTY', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `emp_allowances`
--
ALTER TABLE `emp_allowances`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `emp_deductions`
--
ALTER TABLE `emp_deductions`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `payroll_items`
--
ALTER TABLE `payroll_items`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `emp_allowances`
--
ALTER TABLE `emp_allowances`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `emp_deductions`
--
ALTER TABLE `emp_deductions`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `sno` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `sno` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `payroll_items`
--
ALTER TABLE `payroll_items`
  MODIFY `sno` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
