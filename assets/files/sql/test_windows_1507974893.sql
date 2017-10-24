-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 14, 2017 at 12:09 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adbms-ETL`
--

-- --------------------------------------------------------

--
-- Table structure for table `test_windows_1507974893`
--

CREATE TABLE `test_sql` (
  `COL_1` text,
  `COL_2` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_windows_1507974893`
--

INSERT INTO `test_sql` (`COL_1`, `COL_2`) VALUES
('1', 'A\r'),
('2', 'B\r'),
('3', 'C\r'),
('4', 'D\r'),
('5', 'E\r');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
