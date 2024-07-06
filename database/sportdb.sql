-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2024 at 02:20 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `addon`
--

CREATE TABLE `addon` (
  `ADDONID` int NOT NULL,
  `ADDONNAME` varchar(255) NOT NULL,
  `ADDONPRICE` decimal(10,2) DEFAULT NULL,
  `ADDONQUANTITY` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `addon`
--

INSERT INTO `addon` (`ADDONID`, `ADDONNAME`, `ADDONPRICE`, `ADDONQUANTITY`) VALUES
(301, '100 PLUS', 3.00, 395),
(302, 'EXTRAJOSS', 2.00, 196),
(303, 'ENERGY GEl', 5.00, 197),
(304, 'MINERAL WATER', 1.00, 197);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ADMINID` int NOT NULL,
  `ADMINNAME` varchar(255) NOT NULL,
  `ADMINPHONE` varchar(255) DEFAULT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ADMINID`, `ADMINNAME`, `ADMINPHONE`, `USERNAME`, `PASSWORD`) VALUES
(20241, 'IQMAL', '01838256783', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `BOOKINGID` int NOT NULL,
  `BOOKINGDATE` date NOT NULL,
  `TIMESLOT` varchar(11) NOT NULL,
  `HOURSBOOKED` varchar(11) NOT NULL,
  `ADMINID` int DEFAULT NULL,
  `FACID` varchar(30) DEFAULT NULL,
  `CUSTID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`BOOKINGID`, `BOOKINGDATE`, `TIMESLOT`, `HOURSBOOKED`, `ADMINID`, `FACID`, `CUSTID`) VALUES
(100100, '2024-06-01', '1400H-500H', '1', 20241, 'F1', 101),
(100101, '2024-06-01', '1800H-1900H', '1', 20241, 'F3', 101),
(100102, '2024-06-01', '1800H-1900H', '1', 20241, 'F3', 101),
(100103, '2024-06-01', '1800H-1900H', '1', 20241, 'F3', 101),
(100104, '2024-07-13', '1900H-2000H', '1', 20241, 'F1', 101);

-- --------------------------------------------------------

--
-- Table structure for table `booking_addon`
--

CREATE TABLE `booking_addon` (
  `BOOKINGID` int NOT NULL,
  `ADDONID` int NOT NULL,
  `PRICE` decimal(10,2) NOT NULL,
  `QUANTITY` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booking_addon`
--

INSERT INTO `booking_addon` (`BOOKINGID`, `ADDONID`, `PRICE`, `QUANTITY`) VALUES
(100100, 301, 2.40, 3),
(100100, 302, 2.00, 10),
(100101, 301, 2.40, 1),
(100101, 302, 2.00, 1),
(100101, 303, 5.00, 1),
(100101, 304, 1.00, 1),
(100102, 301, 2.40, 1),
(100102, 302, 2.00, 1),
(100102, 303, 5.00, 1),
(100102, 304, 1.00, 1),
(100103, 301, 2.40, 1),
(100103, 302, 2.00, 1),
(100103, 303, 5.00, 1),
(100103, 304, 1.00, 1),
(100104, 301, 3.00, 2),
(100104, 302, 2.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CUSTID` int NOT NULL,
  `CUSTNAME` varchar(255) NOT NULL,
  `CUSTADDRESS` varchar(255) DEFAULT NULL,
  `CUSTPHONE` varchar(255) DEFAULT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CUSTID`, `CUSTNAME`, `CUSTADDRESS`, `CUSTPHONE`, `USERNAME`, `PASSWORD`) VALUES
(101, 'IQMAL', 'UITMKT, 21080 KUALA TERENGGANU, TERENGGANU', '0134567373', 'iqmal', 'kemah01');

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `FACID` varchar(30) NOT NULL,
  `FACNAME` varchar(255) NOT NULL,
  `FACPRICEPERHOUR` decimal(10,2) DEFAULT NULL,
  `FACSTATUS` varchar(30) DEFAULT NULL,
  `SPORTID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`FACID`, `FACNAME`, `FACPRICEPERHOUR`, `FACSTATUS`, `SPORTID`) VALUES
('F1', 'FUTSAL', 100.00, 'RUNNING', 501),
('F2', 'FUTSAL', 100.00, 'SUSPENDED', 501),
('F3', 'FUTSAL', 100.00, 'RUNNING', 501);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PAYMENTID` int NOT NULL,
  `PAYMENTTOTAL` decimal(10,2) DEFAULT NULL,
  `PAYMENTSTATUS` varchar(20) DEFAULT NULL,
  `PAYMENTDATE` date DEFAULT NULL,
  `BOOKINGID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PAYMENTID`, `PAYMENTTOTAL`, `PAYMENTSTATUS`, `PAYMENTDATE`, `BOOKINGID`) VALUES
(300300, 129.60, 'PAID', '2024-06-01', 100100),
(300301, 110.40, 'PENDING', '2024-06-01', 100103),
(300302, 108.00, 'PENDING', '2024-07-13', 100104);

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE `sport` (
  `SPORTID` int NOT NULL,
  `SPORTNAME` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sport`
--

INSERT INTO `sport` (`SPORTID`, `SPORTNAME`) VALUES
(500, 'BADMINTON'),
(501, 'FUTSAL'),
(502, 'SNOOKER'),
(503, 'PING-PONG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addon`
--
ALTER TABLE `addon`
  ADD PRIMARY KEY (`ADDONID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ADMINID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`BOOKINGID`),
  ADD KEY `ADMINID` (`ADMINID`),
  ADD KEY `FACID` (`FACID`),
  ADD KEY `CUSTID` (`CUSTID`);

--
-- Indexes for table `booking_addon`
--
ALTER TABLE `booking_addon`
  ADD PRIMARY KEY (`BOOKINGID`,`ADDONID`),
  ADD KEY `ADDONID` (`ADDONID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CUSTID`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`FACID`),
  ADD KEY `SPORTID` (`SPORTID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PAYMENTID`),
  ADD KEY `BOOKINGID` (`BOOKINGID`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
  ADD PRIMARY KEY (`SPORTID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addon`
--
ALTER TABLE `addon`
  MODIFY `ADDONID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `BOOKINGID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100105;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CUSTID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PAYMENTID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300303;

--
-- AUTO_INCREMENT for table `sport`
--
ALTER TABLE `sport`
  MODIFY `SPORTID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=504;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`ADMINID`) REFERENCES `admin` (`ADMINID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`FACID`) REFERENCES `facility` (`FACID`),
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`CUSTID`) REFERENCES `customer` (`CUSTID`);

--
-- Constraints for table `booking_addon`
--
ALTER TABLE `booking_addon`
  ADD CONSTRAINT `booking_addon_ibfk_1` FOREIGN KEY (`BOOKINGID`) REFERENCES `booking` (`BOOKINGID`),
  ADD CONSTRAINT `booking_addon_ibfk_2` FOREIGN KEY (`ADDONID`) REFERENCES `addon` (`ADDONID`);

--
-- Constraints for table `facility`
--
ALTER TABLE `facility`
  ADD CONSTRAINT `facility_ibfk_1` FOREIGN KEY (`SPORTID`) REFERENCES `sport` (`SPORTID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`BOOKINGID`) REFERENCES `booking` (`BOOKINGID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
