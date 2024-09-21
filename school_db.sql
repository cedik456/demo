-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 21, 2024 at 01:06 PM
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
-- Database: `school_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE `Students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `school_id` varchar(20) NOT NULL,
  `bday` date NOT NULL,
  `age` int(11) NOT NULL,
  `course` varchar(50) NOT NULL,
  `year_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`student_id`, `name`, `school_id`, `bday`, `age`, `course`, `year_level`) VALUES
(46, 'Christian Dacillo', '07212239', '2024-03-29', 22, 'BSIT', 3),
(47, 'Cedric Nano', '0721816', '2024-04-27', 22, 'BSIT', 3),
(49, 'Mark Joseph Ante', '07218543', '2024-12-18', 20, 'BSIT', 3),
(50, 'Charles Alamares', '07219876', '2018-12-04', 23, 'BSIT', 3),
(51, 'James Ricarte', '0724568', '2024-03-28', 22, 'BSIT', 3),
(52, 'Jasper Canon', '07218765', '2024-12-25', 21, 'BSIT', 3),
(53, 'John Basquinas', '072883212', '2024-03-16', 23, 'BSIT', 3);

-- --------------------------------------------------------

--
-- Table structure for table `UserLogins`
--

CREATE TABLE `UserLogins` (
  `login_id` int(11) NOT NULL,
  `reg_id` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `UserLogins`
--

INSERT INTO `UserLogins` (`login_id`, `reg_id`, `username`, `email`, `password`) VALUES
(1, 1, 'man', 'eman@gmail.com', '$2y$10$cNN9izutRsq/v0ko0VkEE.138GuDAEHIPN8/WDC7gPMqkOQV5ypF2'),
(2, 2, 'dav', 'davish@gmail.com', '$2y$10$RMnVnz5ckDKrl40E0LfHDeGa4G/17T56B/x3E3Z9P91IUVdpZzEvO'),
(3, 3, 'kath', 'kat@gmail.com', '$2y$10$LSNyfv7RDEiz25XLxy7dguN.lUfWzcF4x1QN5spVJlot9o847ckxi'),
(4, 4, 'mark', 'mark@gmail.com', '$2y$10$LBi8Lg0nDqboEj2GhBCIoOxv62Dw2FWizLjAi5hu73JeMc92/6mv2'),
(5, 5, 'tina', 'tina@gmail.com', '$2y$10$ggLQcaqFKJGBLziaELp.COlup6HsEcLNgEkUZJ08anIWv2PAgn9km'),
(6, 6, 'shan', 'shan@gmail.com', '$2y$10$Wu29haJN20O9qCAdPpDd/.IPELG2p1/UICqOOLGaaypgMYH0cUJK.'),
(7, 7, 'charles', 'charles1@gmail.com', '$2y$10$Oo0jHtrh07tU3FSEkKtb7.tuPNNAqeW2YDhYra2YBvRsJ1v32ijXG'),
(8, 8, 'n4no', 'nano@gmail.com', '$2y$10$/M7GmJKL4Ey4Ymh9nuUQpOYAkyhzEzY2IkYdr559qXW5HpFzkPBb2'),
(9, 9, 'davishpogi', 'pogi@gmail.com', '$2y$10$S4tcoycIlFWr6c5pkgQ7i.MeQPUNKRo1YBN6UEhl7UUiNwR8pGSry'),
(10, 10, 'quin', 'quin@gmail.com', '$2y$10$oYRJsDyyqxTYAHT40GPWTO3h8RDrrtVEuwcEm6r7mJmbE7pvNWOLe');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `reg_id` int(11) NOT NULL,
  `faculty_id` varchar(12) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `mid_name` varchar(50) DEFAULT NULL,
  `dob` date NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`reg_id`, `faculty_id`, `first_name`, `last_name`, `mid_name`, `dob`, `age`) VALUES
(1, '95C144DD', 'Emman', 'Espena', 'Emanuel', '2002-03-28', 22),
(2, 'B9F41C1D', 'Davsh', 'Alamo', 'Hey', '2010-02-24', 14),
(3, '6694A7D3', 'Kath', 'Amaranto', 'Nano', '2024-02-06', 0),
(4, '4DC29C5E', 'Mark', 'Ante', 'Joseph', '2024-03-14', 0),
(5, 'E5F56085', 'Christina', 'Rodrigueza', 'Gonzaga', '2026-09-30', 3),
(6, '966F827D', 'Sean', 'Dana', 'Nani', '2006-05-18', 18),
(7, '42B999F8', 'Charles', 'Alamares', 'Alcantara', '2000-03-22', 24),
(8, 'DC2754BE', 'Cedrick', 'Nano', 'Dino', '2002-03-28', 22),
(9, '2EBF2B9D', 'Davish', 'Alamo', 'Pogi', '1997-11-03', 26),
(10, '69ABD581', 'Joaquin', 'Michael', 'James', '2024-09-27', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `school_id` (`school_id`);

--
-- Indexes for table `UserLogins`
--
ALTER TABLE `UserLogins`
  ADD PRIMARY KEY (`login_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `reg_id` (`reg_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`reg_id`),
  ADD UNIQUE KEY `faculty_id` (`faculty_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Students`
--
ALTER TABLE `Students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `UserLogins`
--
ALTER TABLE `UserLogins`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `UserLogins`
--
ALTER TABLE `UserLogins`
  ADD CONSTRAINT `userlogins_ibfk_1` FOREIGN KEY (`reg_id`) REFERENCES `Users` (`reg_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
