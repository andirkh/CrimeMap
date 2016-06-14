-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2016 at 02:13 AM
-- Server version: 5.7.9
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ah-crimereport`
--
CREATE DATABASE IF NOT EXISTS `ah-crimereport` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ah-crimereport`;

-- --------------------------------------------------------

--
-- Table structure for table `crimes`
--

DROP TABLE IF EXISTS `crimes`;
CREATE TABLE IF NOT EXISTS `crimes` (
  `crime_id` int(11) NOT NULL AUTO_INCREMENT,
  `crime_name` varchar(50) NOT NULL,
  PRIMARY KEY (`crime_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crimes`
--

INSERT INTO `crimes` (`crime_id`, `crime_name`) VALUES
(1, 'Perampokan'),
(2, 'Pembunuhan'),
(3, 'Begal');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `crime_id` int(11) NOT NULL,
  `report_time` varchar(50) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `crime_id`, `report_time`, `longitude`, `latitude`) VALUES
(1, 1, '2016-05-29 12:05:59', '-7.258184399999999', '112.74834570000007'),
(2, 2, '2016-05-29 12:05:68', '-7.263466999999999', '112.74038900000005'),
(3, 3, '2016-05-18 12:05:20', '-7.264065200000001', '112.75179969999999'),
(4, 1, '2016-05-29 12:05:78', '-6.204213286361534', '106.83603286743164'),
(5, 1, '2016-05-29 12:05:97', '-7.262521203071929', '112.75938034057617'),
(6, 1, '2016-06-14 09:06:60', '-7.28467179327773', '112.67483711242676');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
