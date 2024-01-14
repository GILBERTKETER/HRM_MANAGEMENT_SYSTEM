-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2024 at 01:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
(1, 'House Rent', 8),
(2, 'Transport Allowance', 7);

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

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`sno`, `e_id`, `date`, `time_in`, `time_out`, `hours`, `time_updated`) VALUES
(1, 3, '2023-03-01', '09:00:23', '18:04:21', 9.05, '2023-03-01 18:04:27'),
(4, 4, '2023-03-02', '10:24:52', '19:00:00', 8.58, '2023-03-02 10:34:36'),
(5, 2, '2023-03-03', '17:45:13', '18:00:00', 0.23, '2023-03-03 17:46:10'),
(6, 3, '2023-03-04', '09:20:40', '18:00:00', 8.65, '2023-03-04 21:21:20'),
(9, 2, '2023-03-05', '05:05:16', '00:00:00', 5.08, '2023-03-05 05:05:25'),
(10, 2, '2023-03-06', '05:05:16', '00:00:00', 5.08, '2023-03-06 05:05:32'),
(11, 3, '2023-03-07', '05:05:16', '00:00:00', 5.08, '2023-03-07 05:05:37'),
(12, 2, '2023-03-08', '05:05:16', '00:00:00', 5.08, '2023-03-08 05:05:45'),
(13, 3, '2023-03-09', '05:05:16', '00:00:00', 5.08, '2023-03-09 05:05:53'),
(14, 8, '2023-03-10', '09:17:09', '00:00:00', 9.28, '2023-03-10 05:17:22'),
(15, 8, '2023-03-11', '09:17:09', '16:00:00', 6.70, '2023-03-11 05:17:37'),
(16, 8, '2023-03-12', '03:39:47', '00:00:00', 3.65, '2023-03-12 03:39:58'),
(19, 2, '2023-03-13', '09:00:37', '17:00:37', 8.00, '2023-03-13 03:55:20'),
(21, 4, '2023-03-14', '03:57:00', '03:57:00', 0.00, '2023-03-14 03:57:41'),
(22, 2, '2023-03-15', '09:08:15', '17:08:15', 8.00, '2023-03-15 20:08:49'),
(24, 4, '2023-03-16', '09:08:15', '17:08:15', 8.00, '2023-03-16 20:09:10'),
(25, 8, '2023-03-17', '09:08:15', '17:08:15', 8.00, '2023-03-17 20:09:18'),
(26, 2, '2023-03-18', '09:08:15', '17:08:15', 8.00, '2023-03-18 20:09:34'),
(27, 3, '2023-03-19', '20:09:45', '20:09:45', 0.00, '2023-03-19 20:09:54'),
(28, 3, '2023-03-20', '10:10:48', '17:10:48', 7.00, '2023-03-20 20:11:10'),
(30, 3, '2023-03-21', '09:17:14', '17:17:14', 8.00, '2023-03-21 21:17:54'),
(31, 8, '2023-03-22', '10:00:09', '18:00:09', 8.00, '2023-03-22 15:13:51'),
(32, 4, '2023-03-23', '09:59:23', '17:59:23', 8.00, '2023-03-23 17:59:46'),
(33, 3, '2023-03-24', '10:00:01', '18:00:01', 8.00, '2023-03-24 19:46:30'),
(34, 2, '2023-03-25', '10:54:00', '06:54:00', 4.00, '2023-03-25 22:54:40');

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
(1, 'Provident Fund', 15),
(2, 'Medical Insurance', 12);

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
(20, 2, 3, 2550.00, '2023-02-16 14:13:32'),
(21, 2, 8, 3000.00, '2023-02-17 22:26:08'),
(22, 2, 2, 2500.00, '2023-02-18 15:27:53'),
(23, 3, 4, 1040.00, '2023-02-20 05:11:07'),
(24, 3, 2, 3500.00, '2023-02-24 22:53:31'),
(25, 1, 8, 4596.48, '2023-03-14 10:41:13'),
(26, 1, 3, 4080.00, '2023-03-14 10:42:19'),
(28, 2, 4, 3640.00, '2023-03-15 05:17:07'),
(29, 1, 4, 4160.00, '2023-03-15 05:17:16'),
(30, 2, 2, 3500.00, '2024-01-13 09:26:01');

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

--
-- Dumping data for table `emp_deductions`
--

INSERT INTO `emp_deductions` (`sno`, `d_id`, `e_id`, `amount`, `date_created`) VALUES
(14, 2, 2, 5000.00, '2023-02-16 14:13:11'),
(15, 2, 3, 5100.00, '2023-02-16 14:13:36'),
(17, 2, 4, 7800.00, '2023-03-14 10:42:55'),
(18, 1, 2, 7500.00, '2023-03-15 04:45:48'),
(20, 2, 2, 7500.00, '2024-01-13 09:25:51');

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
(2, '2023-02-23', '3f18aaa11d30e078503341d85b09c575', 'asdhjk', 1, '2023-02-23 06:59:44', '2023-02-23 07:09:35'),
(3, '2023-02-24', '3f18aaa11d30e078503341d85b09c575', 'rtghnnm', 2, '2023-02-23 07:10:25', '2023-02-23 07:10:57'),
(4, '2023-02-24', 'bc0c151d97d312364ce9ab49b4fd15e4', 'asdfghjknbv', 2, '2023-02-23 14:24:16', '2023-02-23 14:25:13'),
(5, '2023-02-26', 'bc0c151d97d312364ce9ab49b4fd15e4', 'asdfgfngbuyvg', 1, '2023-02-23 14:38:54', '2023-02-23 14:39:31'),
(6, '2023-02-28', '3f18aaa11d30e078503341d85b09c575', 'ycjghbkjn', 1, '2023-02-23 14:42:22', '2023-02-23 18:57:04'),
(7, '2023-02-22', 'bc0c151d97d312364ce9ab49b4fd15e4', 'dxfcghvjnbmnm,', 0, '2023-02-23 18:56:39', NULL),
(8, '2023-02-24', '3f18aaa11d30e078503341d85b09c575', 'fever', 1, '2023-02-24 18:53:03', '2023-02-24 18:53:26'),
(9, '2023-03-12', '3f18aaa11d30e078503341d85b09c575', 'Not Well', 0, '2023-03-12 21:23:18', NULL),
(10, '2023-03-16', '3f18aaa11d30e078503341d85b09c575', 'Not well', 0, '2023-03-17 08:28:19', NULL),
(11, '2024-01-18', '21672aa93b0a22e61acac2ce90969af6', 'hey', 0, '2024-01-12 12:41:45', NULL),
(12, '2024-01-18', '21672aa93b0a22e61acac2ce90969af6', 'hey', 0, '2024-01-12 12:41:50', NULL);

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
(55, '210315-0536', '2023-02-01', '2023-02-28', 1, '2023-03-15 05:42:36');

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

--
-- Dumping data for table `payroll_items`
--

INSERT INTO `payroll_items` (`sno`, `ref_no`, `e_id`, `present`, `absent`, `hrs_worked`, `salary`, `allowance_amt`, `allowances`, `deduction_amt`, `deductions`, `net_salary`, `income_tax`, `date_created`) VALUES
(364, '', 2, 3, 18, 24.00, 7142.86, 8500.00, '[{\"amount\":\"6000.00\",\"aname\":\"House Rent\"},{\"amount\":\"2500.00\",\"aname\":\"Transport Allowance\"}]', 12500.00, '[{\"amount\":\"5000.00\",\"dname\":\"Medical Insurance\"},{\"amount\":\"7500.00\",\"dname\":\"Provident Fund\"}]', 3142.86, 0.00, '2023-03-15 05:06:04'),
(365, '', 3, 2, 19, 16.00, 4857.14, 6630.00, '[{\"amount\":\"2550.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4080.00\",\"aname\":\"House Rent\"}]', 5100.00, '[{\"amount\":\"5100.00\",\"dname\":\"Medical Insurance\"}]', 6387.14, 0.00, '2023-03-15 05:06:04'),
(366, '', 4, 2, 19, 8.00, 4952.38, 3640.00, '[{\"amount\":\"3640.00\",\"aname\":\"Transport Allowance\"}]', 7800.00, '[{\"amount\":\"7800.00\",\"dname\":\"Medical Insurance\"}]', 792.38, 0.00, '2023-03-15 05:06:04'),
(367, '', 8, 3, 18, 19.65, 8208.00, 7596.48, '[{\"amount\":\"3000.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4596.48\",\"aname\":\"House Rent\"}]', 0.00, '[]', 15804.48, 0.00, '2023-03-15 05:06:04'),
(368, '', 2, 3, 18, 24.00, 7142.86, 8500.00, '[{\"amount\":\"6000.00\",\"aname\":\"House Rent\"},{\"amount\":\"2500.00\",\"aname\":\"Transport Allowance\"}]', 12500.00, '[{\"amount\":\"5000.00\",\"dname\":\"Medical Insurance\"},{\"amount\":\"7500.00\",\"dname\":\"Provident Fund\"}]', 3142.86, 0.00, '2023-03-15 05:07:42'),
(369, '', 3, 2, 19, 16.00, 4857.14, 6630.00, '[{\"amount\":\"2550.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4080.00\",\"aname\":\"House Rent\"}]', 5100.00, '[{\"amount\":\"5100.00\",\"dname\":\"Medical Insurance\"}]', 6387.14, 0.00, '2021-03-15 05:07:42'),
(370, '', 4, 2, 19, 8.00, 4952.38, 3640.00, '[{\"amount\":\"3640.00\",\"aname\":\"Transport Allowance\"}]', 7800.00, '[{\"amount\":\"7800.00\",\"dname\":\"Medical Insurance\"}]', 792.38, 0.00, '2023-03-15 05:07:42'),
(371, '', 8, 3, 18, 19.65, 8208.00, 7596.48, '[{\"amount\":\"3000.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4596.48\",\"aname\":\"House Rent\"}]', 0.00, '[]', 15804.48, 0.00, '2023-03-15 05:07:42'),
(372, '', 2, 3, 18, 24.00, 7142.86, 8500.00, '[{\"amount\":\"6000.00\",\"aname\":\"House Rent\"},{\"amount\":\"2500.00\",\"aname\":\"Transport Allowance\"}]', 12500.00, '[{\"amount\":\"5000.00\",\"dname\":\"Medical Insurance\"},{\"amount\":\"7500.00\",\"dname\":\"Provident Fund\"}]', 3142.86, 0.00, '2023-03-15 05:08:30'),
(373, '', 3, 2, 19, 16.00, 4857.14, 6630.00, '[{\"amount\":\"2550.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4080.00\",\"aname\":\"House Rent\"}]', 5100.00, '[{\"amount\":\"5100.00\",\"dname\":\"Medical Insurance\"}]', 6387.14, 0.00, '2023-03-15 05:08:30'),
(374, '', 4, 2, 19, 8.00, 4952.38, 3640.00, '[{\"amount\":\"3640.00\",\"aname\":\"Transport Allowance\"}]', 7800.00, '[{\"amount\":\"7800.00\",\"dname\":\"Medical Insurance\"}]', 792.38, 0.00, '2023-03-15 05:08:30'),
(375, '', 8, 3, 18, 19.65, 8208.00, 7596.48, '[{\"amount\":\"3000.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4596.48\",\"aname\":\"House Rent\"}]', 0.00, '[]', 15804.48, 0.00, '2023-03-15 05:08:30'),
(376, '', 2, 3, 18, 24.00, 7142.86, 8500.00, '[{\"amount\":\"6000.00\",\"aname\":\"House Rent\"},{\"amount\":\"2500.00\",\"aname\":\"Transport Allowance\"}]', 12500.00, '[{\"amount\":\"5000.00\",\"dname\":\"Medical Insurance\"},{\"amount\":\"7500.00\",\"dname\":\"Provident Fund\"}]', 3142.86, 0.00, '2023-03-15 05:08:58'),
(377, '', 3, 2, 19, 16.00, 4857.14, 6630.00, '[{\"amount\":\"2550.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4080.00\",\"aname\":\"House Rent\"}]', 5100.00, '[{\"amount\":\"5100.00\",\"dname\":\"Medical Insurance\"}]', 6387.14, 0.00, '2023-03-15 05:08:58'),
(378, '', 4, 2, 19, 8.00, 4952.38, 3640.00, '[{\"amount\":\"3640.00\",\"aname\":\"Transport Allowance\"}]', 7800.00, '[{\"amount\":\"7800.00\",\"dname\":\"Medical Insurance\"}]', 792.38, 0.00, '2023-03-15 05:08:58'),
(379, '', 8, 3, 18, 19.65, 8208.00, 7596.48, '[{\"amount\":\"3000.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4596.48\",\"aname\":\"House Rent\"}]', 0.00, '[]', 15804.48, 0.00, '2023-03-15 05:08:58'),
(380, '', 2, 3, 18, 24.00, 7142.86, 8500.00, '[{\"amount\":\"6000.00\",\"aname\":\"House Rent\"},{\"amount\":\"2500.00\",\"aname\":\"Transport Allowance\"}]', 12500.00, '[{\"amount\":\"5000.00\",\"dname\":\"Medical Insurance\"},{\"amount\":\"7500.00\",\"dname\":\"Provident Fund\"}]', 3142.86, 0.00, '2023-03-15 05:09:26'),
(381, '', 3, 2, 19, 16.00, 4857.14, 6630.00, '[{\"amount\":\"2550.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4080.00\",\"aname\":\"House Rent\"}]', 5100.00, '[{\"amount\":\"5100.00\",\"dname\":\"Medical Insurance\"}]', 6387.14, 0.00, '2023-03-15 05:09:26'),
(382, '', 4, 2, 19, 8.00, 4952.38, 3640.00, '[{\"amount\":\"3640.00\",\"aname\":\"Transport Allowance\"}]', 7800.00, '[{\"amount\":\"7800.00\",\"dname\":\"Medical Insurance\"}]', 792.38, 0.00, '2023-03-15 05:09:26'),
(383, '', 8, 3, 18, 19.65, 8208.00, 7596.48, '[{\"amount\":\"3000.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4596.48\",\"aname\":\"House Rent\"}]', 0.00, '[]', 15804.48, 0.00, '2023-03-15 05:09:26'),
(384, '', 2, 3, 18, 24.00, 7142.86, 8500.00, '[{\"amount\":\"6000.00\",\"aname\":\"House Rent\"},{\"amount\":\"2500.00\",\"aname\":\"Transport Allowance\"}]', 12500.00, '[{\"amount\":\"5000.00\",\"dname\":\"Medical Insurance\"},{\"amount\":\"7500.00\",\"dname\":\"Provident Fund\"}]', 3142.86, 0.00, '2023-03-15 05:09:37'),
(385, '', 3, 2, 19, 16.00, 4857.14, 6630.00, '[{\"amount\":\"2550.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4080.00\",\"aname\":\"House Rent\"}]', 5100.00, '[{\"amount\":\"5100.00\",\"dname\":\"Medical Insurance\"}]', 6387.14, 0.00, '2023-03-15 05:09:37'),
(386, '', 4, 2, 19, 8.00, 4952.38, 3640.00, '[{\"amount\":\"3640.00\",\"aname\":\"Transport Allowance\"}]', 7800.00, '[{\"amount\":\"7800.00\",\"dname\":\"Medical Insurance\"}]', 792.38, 0.00, '2023-03-15 05:09:37'),
(387, '', 8, 3, 18, 19.65, 8208.00, 7596.48, '[{\"amount\":\"3000.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4596.48\",\"aname\":\"House Rent\"}]', 0.00, '[]', 15804.48, 0.00, '2023-03-15 05:09:37'),
(400, '210315-0536', 2, 6, 14, 27.47, 15000.00, 8500.00, '[{\"amount\":\"6000.00\",\"aname\":\"House Rent\"},{\"amount\":\"2500.00\",\"aname\":\"Transport Allowance\"}]', 12500.00, '[{\"amount\":\"5000.00\",\"dname\":\"Medical Insurance\"},{\"amount\":\"7500.00\",\"dname\":\"Provident Fund\"}]', 11000.00, 0.00, '2023-03-15 05:42:47'),
(401, '210315-0536', 3, 6, 14, 34.86, 15300.00, 6630.00, '[{\"amount\":\"2550.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4080.00\",\"aname\":\"House Rent\"}]', 5100.00, '[{\"amount\":\"5100.00\",\"dname\":\"Medical Insurance\"}]', 16830.00, 0.00, '2023-03-15 05:42:47'),
(402, '210315-0536', 4, 3, 17, 16.58, 7800.00, 7800.00, '[{\"amount\":\"3640.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4160.00\",\"aname\":\"House Rent\"}]', 7800.00, '[{\"amount\":\"7800.00\",\"dname\":\"Medical Insurance\"}]', 7800.00, 0.00, '2023-03-15 05:42:47'),
(403, '210315-0536', 8, 4, 16, 27.63, 11491.20, 7596.48, '[{\"amount\":\"3000.00\",\"aname\":\"Transport Allowance\"},{\"amount\":\"4596.48\",\"aname\":\"House Rent\"}]', 0.00, '[]', 19087.68, 0.00, '2023-03-15 05:42:47');

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
(16, 'Gilbert', 'Keter', 'gilbertketer759@gmail.com', '$2y$10$XNYEiwEYSiqQlO1TW3sH4O2xaIEdL72P0SOqbgY99sjgFsykeJEyu', '21213343ghdgsd767sddshhdg', 1, '2024-01-10', '2024-01-03', '0759104865', NULL, 'male', 'Admin', 0.00, 'shdgsd', '0');

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
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `emp_deductions`
--
ALTER TABLE `emp_deductions`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `sno` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `sno` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `payroll_items`
--
ALTER TABLE `payroll_items`
  MODIFY `sno` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
