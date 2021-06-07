-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2021 at 07:56 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `st`
--

-- --------------------------------------------------------

--
-- Table structure for table `catcode`
--

CREATE TABLE `catcode` (
  `catcode` int(10) NOT NULL,
  `catname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `catcode`
--

INSERT INTO `catcode` (`catcode`, `catname`) VALUES
(1, 'ملابس'),
(2, 'اجهزة'),
(3, 'حديد'),
(5, 'خشب');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemcode` int(10) NOT NULL,
  `itemid` int(10) NOT NULL,
  `itemname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemcode`, `itemid`, `itemname`) VALUES
(1, 1, 'طعام'),
(1, 2, 'سيارة'),
(1, 3, 'كاب'),
(2, 4, 'لابتوب'),
(2, 5, 'حديد'),
(2, 6, 'تليفون');

-- --------------------------------------------------------

--
-- Table structure for table `res`
--

CREATE TABLE `res` (
  `catcode` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `res`
--

INSERT INTO `res` (`catcode`, `itemid`, `num`) VALUES
(1, 1, 10),
(2, 4, 50);

-- --------------------------------------------------------

--
-- Table structure for table `rtstock`
--

CREATE TABLE `rtstock` (
  `catcode` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `num` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rtstock`
--

INSERT INTO `rtstock` (`catcode`, `itemid`, `num`) VALUES
(1, 1, 142),
(1, 2, 93),
(2, 4, 234);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `catcode` int(10) NOT NULL,
  `itemid` int(10) NOT NULL,
  `num` int(50) NOT NULL,
  `entdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`catcode`, `itemid`, `num`, `entdate`) VALUES
(1, 1, 20, '0000-00-00'),
(1, 1, 20, '2020-04-02'),
(1, 1, 50, '2020-04-03'),
(1, 1, 20, '2020-04-05'),
(1, 1, 20, '2020-04-06'),
(1, 1, 100, '2020-04-10'),
(1, 1, 33, '2020-04-17'),
(1, 1, 20, '2020-04-21'),
(1, 2, 20, '2020-03-30'),
(1, 2, 30, '2020-03-31'),
(1, 2, 12, '2020-04-08'),
(1, 2, 33, '2020-04-18'),
(2, 4, 50, '0000-00-00'),
(2, 4, 254, '2020-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `stockout`
--

CREATE TABLE `stockout` (
  `catcode` int(10) NOT NULL,
  `itemid` int(10) NOT NULL,
  `num` int(50) NOT NULL,
  `outdate` date NOT NULL,
  `unitcode` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stockout`
--

INSERT INTO `stockout` (`catcode`, `itemid`, `num`, `outdate`, `unitcode`) VALUES
(1, 1, 20, '2020-03-29', 1),
(1, 1, 20, '2020-03-30', 1),
(1, 1, 90, '2020-04-03', 1),
(1, 1, 11, '2020-04-29', 1),
(1, 2, 2, '2020-03-31', 2),
(2, 4, 20, '2020-04-01', 11);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unitcode` int(10) NOT NULL,
  `unitname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unitcode`, `unitname`) VALUES
(1, 'وحده واحد'),
(2, 'وحده اتنين'),
(11, 'وحدة 11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catcode`
--
ALTER TABLE `catcode`
  ADD PRIMARY KEY (`catcode`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemcode`,`itemid`);

--
-- Indexes for table `res`
--
ALTER TABLE `res`
  ADD PRIMARY KEY (`catcode`,`itemid`);

--
-- Indexes for table `rtstock`
--
ALTER TABLE `rtstock`
  ADD PRIMARY KEY (`catcode`,`itemid`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`catcode`,`itemid`,`entdate`);

--
-- Indexes for table `stockout`
--
ALTER TABLE `stockout`
  ADD PRIMARY KEY (`catcode`,`itemid`,`outdate`,`unitcode`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unitcode`,`unitname`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
