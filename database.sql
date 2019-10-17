-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Oct 17, 2019 at 10:54 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medical`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctor_details`
--

CREATE TABLE `doctor_details` (
  `ID` int(11) NOT NULL,
  `DOCTOR_ID` varchar(50) NOT NULL,
  `DOCTOR_NAME` varchar(50) NOT NULL,
  `DOCTOR_MOBILE` int(10) NOT NULL,
  `DOCTOR_EMAIL` varchar(50) NOT NULL,
  `SPECIALIST` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor_details`
--

INSERT INTO `doctor_details` (`ID`, `DOCTOR_ID`, `DOCTOR_NAME`, `DOCTOR_MOBILE`, `DOCTOR_EMAIL`, `SPECIALIST`) VALUES
(1, '20001', 'doctor1_e', 2147483647, 'd@gmail.comf', 'therapy'),
(2, '20002', 'doctor2', 12345678, 'd2@gmila.com', 'bone');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_login_details`
--

CREATE TABLE `doctor_login_details` (
  `ID` int(11) NOT NULL,
  `DOCTOR_ID` varchar(50) NOT NULL,
  `DOCTOR_PASSWORD` varchar(50) NOT NULL,
  `DOCTOR_EMAIL` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor_login_details`
--

INSERT INTO `doctor_login_details` (`ID`, `DOCTOR_ID`, `DOCTOR_PASSWORD`, `DOCTOR_EMAIL`) VALUES
(1, '20001', 'd@123', 'd@gmail.com'),
(2, '20002', 'd@123', 'd@q.biom');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `ID` int(11) NOT NULL,
  `USER_ID` varchar(50) NOT NULL,
  `USER_NAME` varchar(50) NOT NULL,
  `USER_GENDER` varchar(10) NOT NULL,
  `USER_BLOOD_GROUP` varchar(10) NOT NULL,
  `USER_MOBILE` int(11) DEFAULT NULL,
  `USER_EMAIL` varchar(50) DEFAULT NULL,
  `USER_ADDRESS` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`ID`, `USER_ID`, `USER_NAME`, `USER_GENDER`, `USER_BLOOD_GROUP`, `USER_MOBILE`, `USER_EMAIL`, `USER_ADDRESS`) VALUES
(1, '10001', 'user1dd', 'm', 'b+', 1234567890, 'u@g.com', 'teste'),
(2, '10002', 'user2', 'F', 'O+', 789456123, 'user2@gmail.com', 'Delhi');

-- --------------------------------------------------------

--
-- Table structure for table `user_doctor_appointments`
--

CREATE TABLE `user_doctor_appointments` (
  `ID` int(11) NOT NULL,
  `USER_ID` varchar(50) NOT NULL,
  `USER_NAME` varchar(50) NOT NULL,
  `DOCTOR_ID` varchar(50) NOT NULL,
  `APPOINTMENT_DATE` date DEFAULT current_timestamp(),
  `DOCTOR_COMMENTS` varchar(1000) DEFAULT NULL,
  `REPORTS_DETAILS` varchar(5) NOT NULL,
  `REPORT_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_doctor_appointments`
--

INSERT INTO `user_doctor_appointments` (`ID`, `USER_ID`, `USER_NAME`, `DOCTOR_ID`, `APPOINTMENT_DATE`, `DOCTOR_COMMENTS`, `REPORTS_DETAILS`, `REPORT_ID`) VALUES
(1, '10001', 'user1', '20001', '2019-10-01', 'test', 'N', NULL),
(2, '10002', 'user2', '20001', '2019-10-02', 'test', 'Y', NULL),
(48, '10001', 'test', '20002', '2019-10-18', 'testdhgchgchgv h f hfhf h', '', 4000),
(49, '10002', 'test', '20001', '2019-10-18', 'akfg', 'Y', 4001);

-- --------------------------------------------------------

--
-- Table structure for table `user_doctor_reports`
--

CREATE TABLE `user_doctor_reports` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `DOCTOR_ID` int(11) NOT NULL,
  `REPORT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_login_details`
--

CREATE TABLE `user_login_details` (
  `ID` int(11) NOT NULL,
  `USER_ID` varchar(50) NOT NULL,
  `USER_PASSWORD` varchar(50) NOT NULL,
  `USER_EMAIL` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_login_details`
--

INSERT INTO `user_login_details` (`ID`, `USER_ID`, `USER_PASSWORD`, `USER_EMAIL`) VALUES
(1, '10001', 't@123', 'TEST@GMAIL.COM'),
(2, '10002', 't@123', 't@h.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctor_details`
--
ALTER TABLE `doctor_details`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `doctor_login_details`
--
ALTER TABLE `doctor_login_details`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_doctor_appointments`
--
ALTER TABLE `user_doctor_appointments`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_doctor_reports`
--
ALTER TABLE `user_doctor_reports`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_login_details`
--
ALTER TABLE `user_login_details`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctor_details`
--
ALTER TABLE `doctor_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctor_login_details`
--
ALTER TABLE `doctor_login_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_doctor_appointments`
--
ALTER TABLE `user_doctor_appointments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `user_doctor_reports`
--
ALTER TABLE `user_doctor_reports`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login_details`
--
ALTER TABLE `user_login_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
