-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Nov 12, 2019 at 08:35 PM
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
(1, '20001', 'Dr. Raju', 2147483647, 'd@gmail.comf', 'therapy'),
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
-- Table structure for table `technician_details`
--

CREATE TABLE `technician_details` (
  `ID` int(10) NOT NULL,
  `TECHNICIAN_NAME` varchar(50) NOT NULL,
  `CONTACT_NUMBER` int(11) NOT NULL,
  `DETAILS` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `technician_details`
--

INSERT INTO `technician_details` (`ID`, `TECHNICIAN_NAME`, `CONTACT_NUMBER`, `DETAILS`) VALUES
(1, 'technician1', 789546130, 'test'),
(2, 'dfgdsfg', 0, 'dsfgdfg'),
(3, 'dsfgdsfg', 234234, '2344234'),
(5, 'dfgdf', 1, 'sdfgdsfg');

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
(2, '10002', 'user2', 'F', 'O+', 789456123, 'user2@gmail.com', 'Delhi'),
(3, '10003', 'test', 'M', 'O-', 132345678, 't@gmail.com', 'ooty'),
(45, '10004', 'xfgdfg', '', '', 0, '', ''),
(46, '10005', 'xfgdfg', '', '', 0, '', ''),
(47, '10006', 'xfgdfg', '', '', 0, '', ''),
(48, '10007', 'kishore', 'Male', 'B+', 123456789, 'g@hjd.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_doctor_appointments`
--

CREATE TABLE `user_doctor_appointments` (
  `ID` int(11) NOT NULL,
  `USER_ID` varchar(50) NOT NULL,
  `USER_NAME` varchar(50) NOT NULL,
  `DOCTOR_ID` varchar(50) NOT NULL,
  `TECHNICIAN_NAME` varchar(50) NOT NULL,
  `APPOINTMENT_DATE` date DEFAULT current_timestamp(),
  `DOCTOR_COMMENTS` varchar(1000) DEFAULT NULL,
  `FEES` decimal(10,0) NOT NULL,
  `REPORTS_DETAILS` varchar(5) NOT NULL,
  `REPORT_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_doctor_appointments`
--

INSERT INTO `user_doctor_appointments` (`ID`, `USER_ID`, `USER_NAME`, `DOCTOR_ID`, `TECHNICIAN_NAME`, `APPOINTMENT_DATE`, `DOCTOR_COMMENTS`, `FEES`, `REPORTS_DETAILS`, `REPORT_ID`) VALUES
(1, '10001', 'user1', '20001', '', '2019-10-01', 'test', '0', 'N', NULL),
(2, '10002', 'user2', '20001', '', '2019-10-02', 'test', '0', 'Y', NULL),
(48, '10001', 'test', '20002', '', '2019-10-18', 'testdhgchgchgv h f hfhf h', '0', '', 4000),
(49, '10002', 'test', '20001', '', '2019-10-18', 'akfg', '0', 'Y', 4001),
(50, '10001', 'grfgbe`edd', '20001', '', '2019-10-18', 'dswcwc', '0', 'Y', 4002),
(51, '12313', 'ewlo', '20001', '', '2019-10-19', 'HGhhjdb', '0', 'N', 4003),
(52, 'jssd', 'jhon', '20001', '', '2019-10-19', 'miis', '0', '', 4004),
(53, '10001', 'user1dd', '20001', 'technician1', '2019-10-31', 'test', '0', 'Y', 4005),
(54, '10004', 'xfgdfg', '20001', 'technician1', '2019-11-01', '', '0', '', 4006),
(55, '10001', 'kbygn', '20001', 'technician1', '2019-11-09', 'bnjug', '0', 'Y', 4007),
(56, '10007', 'kishore', '20001', 'technician1', '2019-11-12', 'asdfasf', '4000', 'Y', 4008),
(57, '10007', 'kishore', '20001', 'dfgdf', '2019-11-13', 'sdgsdfg', '500000', 'Y', 4009);

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
(2, '10002', 't@123', 't@h.com'),
(3, '10003', 'test', 't@gmail.com'),
(45, '10004', 'xfgdfg', ''),
(46, '10005', 'xfgdfg', ''),
(47, '10006', 'xfgdfg', ''),
(48, '10007', 'kishore', 'g@hjd.com');

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
-- Indexes for table `technician_details`
--
ALTER TABLE `technician_details`
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
-- AUTO_INCREMENT for table `technician_details`
--
ALTER TABLE `technician_details`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `user_doctor_appointments`
--
ALTER TABLE `user_doctor_appointments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `user_doctor_reports`
--
ALTER TABLE `user_doctor_reports`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login_details`
--
ALTER TABLE `user_login_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
