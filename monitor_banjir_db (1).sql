-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 29, 2019 at 09:23 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitor_banjir_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_status` ()  BEGIN
declare tinggi_max decimal(5,2);
declare waktu_on_max datetime;
declare tinggi_min decimal(5,2);
declare waktu_on_min datetime;

 SELECT max(ketinggian_air) from log_sensor into tinggi_max;
 select waktu from log_sensor where ketinggian_air = tinggi_max limit 1 into waktu_on_max;
 
 SELECT min(ketinggian_air) from log_sensor into tinggi_min;
 select waktu from log_sensor where ketinggian_air = tinggi_min limit 1 into waktu_on_min;
 
 select id_lokasi,
		tinggi_max,
        waktu_on_max,
        tinggi_min,
        waktu_on_min,
        cast(avg(ketinggian_air) as decimal(5,2)) as tinggi_avg
        from log_sensor;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `log_sensor`
--

CREATE TABLE `log_sensor` (
  `id` int(11) NOT NULL,
  `id_lokasi` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `ketinggian_air` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `log_sensor`
--

INSERT INTO `log_sensor` (`id`, `id_lokasi`, `id_status`, `waktu`, `ketinggian_air`) VALUES
(1, 1, 1, '2019-05-29 00:08:01', '20.00'),
(2, 1, 3, '2019-05-29 10:08:27', '60.00'),
(3, 1, 2, '2019-05-23 02:08:59', '25.00'),
(4, 2, 1, '2019-05-29 00:08:01', '20.00'),
(5, 2, 1, '2019-05-29 10:08:27', '19.00'),
(6, 2, 2, '2019-05-23 02:08:59', '25.00'),
(7, 1, 2, '2019-05-23 02:24:59', '25.00'),
(8, 1, 1, '2019-05-23 00:08:01', '20.00'),
(9, 1, 3, '2019-05-23 10:08:27', '60.00'),
(10, 1, 2, '2019-05-23 02:08:59', '25.00'),
(11, 2, 1, '2019-05-23 00:08:01', '20.00'),
(12, 2, 1, '2019-05-23 10:08:27', '19.00'),
(13, 2, 2, '2019-05-23 02:08:59', '25.00'),
(14, 1, 2, '2019-05-23 02:24:59', '25.00'),
(15, 1, 1, '2019-05-23 16:08:01', '20.00'),
(16, 1, 3, '2019-05-23 07:08:27', '60.00'),
(17, 1, 2, '2019-05-23 13:08:59', '25.00'),
(18, 2, 1, '2019-05-23 01:08:01', '20.00'),
(19, 2, 1, '2019-05-23 02:00:00', '19.00'),
(20, 2, 2, '2019-05-23 06:08:59', '25.00'),
(21, 1, 2, '2019-05-23 17:24:59', '100.00'),
(22, 1, 1, '2019-05-23 13:08:01', '20.00'),
(23, 1, 3, '2019-05-23 15:08:27', '60.00'),
(24, 1, 2, '2019-05-23 05:08:59', '25.00'),
(25, 2, 1, '2019-05-23 06:08:01', '20.00'),
(26, 2, 1, '2019-05-23 10:08:27', '19.00'),
(27, 2, 2, '2019-05-23 02:08:59', '25.00'),
(28, 1, 2, '2019-05-23 02:24:59', '25.00');

-- --------------------------------------------------------

--
-- Table structure for table `tm_lokasi`
--

CREATE TABLE `tm_lokasi` (
  `id` int(11) NOT NULL,
  `nama_lokasi` varchar(100) NOT NULL,
  `altitude` varchar(100) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `speed` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tm_lokasi`
--

INSERT INTO `tm_lokasi` (`id`, `nama_lokasi`, `altitude`, `latitude`, `longitude`, `speed`, `heading`) VALUES
(1, 'Lokasi A', NULL, -7.800729, 110.439426, NULL, NULL),
(2, 'Lokasi B', NULL, -7.817056, 110.374588, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tm_status`
--

CREATE TABLE `tm_status` (
  `id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `min_level` decimal(5,2) NOT NULL,
  `max_level` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tm_status`
--

INSERT INTO `tm_status` (`id`, `status`, `description`, `min_level`, `max_level`) VALUES
(1, 'Normal', NULL, '0.00', '20.00'),
(2, 'Waspada', NULL, '21.00', '50.00'),
(3, 'Siaga', NULL, '51.00', '80.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_sensor`
--
ALTER TABLE `log_sensor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tm_lokasi`
--
ALTER TABLE `tm_lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tm_status`
--
ALTER TABLE `tm_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_sensor`
--
ALTER TABLE `log_sensor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tm_lokasi`
--
ALTER TABLE `tm_lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tm_status`
--
ALTER TABLE `tm_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
