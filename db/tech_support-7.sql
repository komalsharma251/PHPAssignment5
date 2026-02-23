-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 23, 2026 at 06:07 PM
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
-- Database: `tech_support`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `adminID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `passwordHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`adminID`, `username`, `passwordHash`) VALUES
(1, 'admin', '$2y$10$exampleexampleexampleexampleexampleexampleexampleex');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `countryCode` char(2) NOT NULL,
  `countryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countryCode`, `countryName`) VALUES
('CA', 'Canada'),
('US', 'United States');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postalCode` varchar(20) DEFAULT NULL,
  `countryCode` char(2) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `passwordHash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `firstName`, `lastName`, `address`, `city`, `state`, `postalCode`, `countryCode`, `phone`, `email`, `passwordHash`) VALUES
(1, 'Alex', 'Morgan', '10 King St', 'Toronto', 'ON', 'M5H 1A1', 'CA', '416-111-2222', 'alex@example.com', NULL),
(2, 'Jamie', 'Lee', '200 Main Ave Toronto', 'Buffalo', 'NY', '14201', 'CA', '716-333-2332', 'jamie@example.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `incidentID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `productCode` varchar(10) NOT NULL,
  `techID` int(11) DEFAULT NULL,
  `dateOpened` datetime NOT NULL DEFAULT current_timestamp(),
  `dateClosed` datetime DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`incidentID`, `customerID`, `productCode`, `techID`, `dateOpened`, `dateClosed`, `title`, `description`) VALUES
(8, 1, 'BB10', 1, '2026-01-31 20:59:24', NULL, 'Cannot save league', 'Error appears when saving.'),
(9, 2, 'SC15', 16, '2026-01-31 20:59:24', NULL, 'Install issue', 'Setup fails at step 2.'),
(10, 1, 'AA14', 2, '2026-02-12 12:00:35', '2026-02-23 12:02:10', 'could not install', 'The file downloaded by the customer appears to be corrupted.'),
(11, 1, 'AA14', NULL, '2026-02-12 12:02:15', NULL, 'could not install', 'The file downloaded by the customer appears to be corrupted.'),
(12, 1, 'AA14', 6, '2026-02-15 21:52:48', '2026-02-23 11:31:57', 'website is not updated', 'all the matches files are currently corrupted.'),
(13, 1, 'AA17', NULL, '2026-02-15 22:09:59', NULL, 'Window installation problem', 'customers getting window intallation prpblem so need ASAP Servive.'),
(14, 1, 'BB10', NULL, '2026-02-15 23:18:15', NULL, 'Website Issue', 'All files are corrupted.'),
(15, 1, 'T222', 16, '2026-02-15 23:23:03', '2026-02-22 18:13:05', 'Internet Failure', 'Internet is not Connecting'),
(16, 2, 'AA142', 14, '2026-02-22 17:18:48', NULL, 'file corrupt', 'all files are corrupted'),
(17, 2, 'AA16', 13, '2026-02-22 17:43:06', NULL, 'Website not working', 'My website is not working from yesterday'),
(18, 2, 'AA14', 14, '2026-02-23 11:31:28', NULL, 'website not working', 'my website is not working since last week'),
(19, 2, 'SC15', 6, '2026-02-23 11:33:28', NULL, 'files corrupted', 'all files are corrupted'),
(20, 2, 'AA16', 9, '2026-02-23 12:00:16', NULL, 'Files issue', 'files are not working properly');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productCode` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `version` varchar(20) DEFAULT NULL,
  `releaseDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productCode`, `name`, `version`, `releaseDate`) VALUES
('AA14', 'Basketball', '1.0', '2026-01-29'),
('AA142', 'drum_style2', '4.5', '2026-02-04'),
('AA15', 'cricket', '4.5', '2026-01-12'),
('AA16', 'Cricket', '3.7', '2025-09-29'),
('AA17', 'Laptop', '5.0', '2024-04-09'),
('AA18', 'drum_style', '4.5', '2026-02-20'),
('AA186', 'TV', '4.5', '2025-10-09'),
('AA19', 'Skating', '3.7', '2025-12-10'),
('BB10', 'Baseball Pro', '1.0', '2025-09-01'),
('SC15', 'Soccer', '5.0', '2026-01-27'),
('T222', 'Television', '4.5', '2025-10-09');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `registrationID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `productCode` varchar(10) NOT NULL,
  `registrationDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`registrationID`, `customerID`, `productCode`, `registrationDate`) VALUES
(1, 1, 'BB10', '2026-01-30 17:34:33'),
(3, 1, 'AA15', '2026-02-12 11:17:53'),
(4, 1, 'AA18', '2026-02-12 11:18:01'),
(5, 1, 'AA17', '2026-02-12 11:23:00'),
(6, 1, 'AA14', '2026-02-12 11:23:52'),
(7, 2, 'AA16', '2026-02-12 12:24:48'),
(8, 2, 'SC15', '2026-02-12 12:24:51'),
(10, 2, 'AA142', '2026-02-12 12:25:16'),
(11, 2, 'AA19', '2026-02-12 19:06:18'),
(12, 2, 'BB10', '2026-02-12 19:09:04'),
(13, 2, 'AA14', '2026-02-12 19:15:51'),
(14, 1, 'AA16', '2026-02-12 19:35:39'),
(16, 1, 'AA19', '2026-02-15 22:10:53'),
(17, 1, 'SC15', '2026-02-15 22:12:52'),
(18, 1, 'T222', '2026-02-15 23:19:57'),
(19, 1, 'AA186', '2026-02-15 23:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `techID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `passwordHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`techID`, `firstName`, `lastName`, `email`, `phone`, `passwordHash`) VALUES
(1, 'Taylor', 'Ng', 'tng@sportspro.com', '416-555-9876', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f'),
(2, 'Chris', 'Patel', 'cpatel@sportspro.com', '416-555-4567', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f'),
(5, 'reema', 'bagga', 'reema221093@gmail.com', '4379877028', '$2y$10$iZz3fVAcP0wpXmoZ1VCvYeKQPBOEQW99lDkOXHZFKuNkXFDF0GrLO'),
(6, 'komal', 'sharma', 'komalsharma251@gmail.com', '234-876-0099', '$2y$10$jbjRpy2quTUg.mSP6wZDCuuG4Qv.XRotSgKpu5DGOcPEjhQL30HN6'),
(9, 'karan', 'kumar', 'karan@gmail.com', '232-123-2222', '$2y$10$Lsz/46s/kRSqPkQHAw9JqeHjLvAz0I0TQxGs3eIl1po.wV8wmuKn2'),
(13, 'Harish', 'kumar', 'harish@gmail.com', '123-322-1212', '$2y$10$DPB2gGMghuqwR0ImG2sz/uW9DpaYn29PEENLZjpiMWV9ZfoF4BTBy'),
(14, 'samaira', 'sharma', 'samairaz@gmail.com', '321-123-2323', '$2y$10$dz40KrxD0WoeZgVamhVZs.xniAHUEtB77utWFyOCjEWkHKd0ne9Oi'),
(16, 'Yuvraj', 'singh', 'yuvraj@gmail.com', '123-321-1212', '$2y$10$rFdlUVtnhkK9l0kAXL.t7OjebsNQPeMSQWAb4fq22OChP9H7rN4US');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password_hash`, `role`, `first_name`, `last_name`, `created_at`) VALUES
(1, 'komalsharma251@gmail.com', '$2y$10$r/2mmeVawVCn92T4d3zL7eEkbX/vU0DYupAXbJVfSV.Td70or16b6', 'user', 'Komal', 'Sharma', '2026-02-06 01:41:52'),
(2, 'navjotshori@yahoo.com', '$2y$10$Ved9uII/QGQizOSJPmZsAOg/v/zxmAelgt.zwMDx4ZOb6ra.pUNh6', 'admin', 'Admin', 'User', '2026-02-06 01:53:43'),
(3, 'ekjot@yahoo.com', '$2y$10$EUYuK1mk.Rk8z8lZ/eZT0uJJuz8Y.qJvNuyhgwxhOG1wSiaLVKCV6', 'user', 'ekjot', 'shori', '2026-02-06 12:46:07'),
(4, 'renu@gmail.com', '$2y$10$8t6woVCtch.3kJNo5BG.C.OzfRzNhdpacPpyPhjd518c0tQg2NRl6', 'user', 'renu', 'sharma', '2026-02-06 13:00:56'),
(5, 'rahul@gmail.com', '$2y$10$YnHa78Ek15zIZKK/uc5ZBez4iPY0xR8qFmSn8x/5YA1qQwb48LlLq', 'user', 'rahul', 'rahul', '2026-02-12 02:56:30'),
(6, 'kamal@gmail.com', '$2y$10$vBp1heF0K47cdZVAToWumecxXVSPvCogXX6Aj9UuPUve2vNBXFkoO', 'user', 'kamal', 'sharma', '2026-02-16 04:19:03'),
(7, 'yuvi@yahoo.com', '$2y$10$4Dax6.SMRnXbhrAF/1yufuMmB7qeudgNSjVm11sBFTWxHa0L1iFZa', 'user', 'yuvi', 'singh', '2026-02-16 04:24:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`adminID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`countryCode`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_customers_country` (`countryCode`);

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`incidentID`),
  ADD KEY `fk_incident_customer` (`customerID`),
  ADD KEY `fk_incident_product` (`productCode`),
  ADD KEY `fk_incident_tech` (`techID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productCode`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registrationID`),
  ADD UNIQUE KEY `uq_customer_product` (`customerID`,`productCode`),
  ADD KEY `fk_reg_product` (`productCode`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`techID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `incidentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registrationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `techID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customers_country` FOREIGN KEY (`countryCode`) REFERENCES `countries` (`countryCode`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `incidents`
--
ALTER TABLE `incidents`
  ADD CONSTRAINT `fk_incident_customer` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_incident_product` FOREIGN KEY (`productCode`) REFERENCES `products` (`productCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_incident_tech` FOREIGN KEY (`techID`) REFERENCES `technicians` (`techID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `fk_reg_customer` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reg_product` FOREIGN KEY (`productCode`) REFERENCES `products` (`productCode`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
