-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2022 at 06:39 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cie`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `B_Id` int(11) NOT NULL,
  `Batch` varchar(9) NOT NULL,
  `Created_On` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_On` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cie`
--

CREATE TABLE `cie` (
  `ID` int(11) NOT NULL,
  `Batch` varchar(9) NOT NULL,
  `USN` varchar(15) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Semester` varchar(5) NOT NULL,
  `SubCode` varchar(15) NOT NULL,
  `CIE1` int(2) NOT NULL DEFAULT 0,
  `CIE2` int(2) NOT NULL DEFAULT 0,
  `CIE3` int(2) NOT NULL DEFAULT 0,
  `Assignment` int(2) NOT NULL DEFAULT 0,
  `Created_On` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_On` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `C_Id` int(11) NOT NULL,
  `C_Sem` varchar(4) NOT NULL,
  `C_Code` varchar(10) NOT NULL,
  `C_Name` varchar(255) NOT NULL,
  `C_Emp` varchar(5) NOT NULL,
  `Created_On` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_On` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `E_Id` varchar(5) NOT NULL,
  `E_Name` varchar(255) NOT NULL,
  `Created_On` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_On` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`E_Id`, `E_Name`, `Created_On`, `Updated_On`) VALUES
('FAC01', 'Prof. Shrikant Patil', '2022-10-06 16:10:46', '2022-10-06 16:10:46');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `S_USN` varchar(10) NOT NULL,
  `S_Batch` varchar(10) NOT NULL,
  `S_Name` varchar(255) NOT NULL,
  `Created_On` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_On` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Role` varchar(10) NOT NULL,
  `Hint` varchar(250) NOT NULL,
  `Ans` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Created_On` datetime DEFAULT current_timestamp(),
  `Updated_On` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Username`, `Role`, `Hint`, `Ans`, `Password`, `Created_On`, `Updated_On`) VALUES
(1, 'FAC01', 'admin', 'What is your favorite colour?', 'red', '$2y$10$Sj8bA63WU5Stmrvyz97G2uPa4av7.ENoBEkQ1LKqNoN4uqy3YiXHq', '2022-10-04 19:29:31', '2022-11-02 17:33:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`B_Id`);

--
-- Indexes for table `cie`
--
ALTER TABLE `cie`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`C_Id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD UNIQUE KEY `E_Id` (`E_Id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD UNIQUE KEY `S_USN` (`S_USN`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `B_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cie`
--
ALTER TABLE `cie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `C_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
