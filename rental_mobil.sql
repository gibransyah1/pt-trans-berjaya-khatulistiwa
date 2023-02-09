-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2023 at 02:17 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_mobil`
--

-- --------------------------------------------------------

--
-- Table structure for table `merek`
--

CREATE TABLE `merek` (
  `merek_id` int(11) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `negara` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `merek`
--

INSERT INTO `merek` (`merek_id`, `nama`, `negara`) VALUES
(1, 'Toyota', 'Jepang'),
(2, 'Honda', 'Jepang'),
(5, 'Suzuki', 'Jepang'),
(6, 'Chevrolet', 'Amerika');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `mobil_id` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `nama_mobil` varchar(225) NOT NULL,
  `jenis` varchar(225) NOT NULL,
  `kapasitas_mesin` int(11) NOT NULL,
  `harga_sewa` int(11) NOT NULL,
  `merek_id` int(11) NOT NULL,
  `unit` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`mobil_id`, `gambar`, `nama_mobil`, `jenis`, `kapasitas_mesin`, `harga_sewa`, `merek_id`, `unit`) VALUES
(1, 'avanza.jpg', 'Avanza', 'Minibus', 1500, 100000, 1, 5),
(2, 'Mobilio.jpg', 'Mobilio', 'Minibus', 1500, 120000, 2, 3),
(5, 'Ertiga.jpg', 'Ertiga', 'Minibus', 1500, 100000, 5, 20),
(7, '1675923843_73eced3a0af3bb747738.jpg', 'Jimny', 'Suv', 1300, 100000, 5, 50),
(8, '1675936383_0be1493126063ce1dd99.jpg', 'Spark', 'City Car', 1000, 50000, 6, 20);

-- --------------------------------------------------------

--
-- Table structure for table `supir`
--

CREATE TABLE `supir` (
  `supir_id` int(11) NOT NULL,
  `nama_supir` varchar(225) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `no_telp` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supir`
--

INSERT INTO `supir` (`supir_id`, `nama_supir`, `alamat`, `no_telp`) VALUES
(1, 'Sugianto Permadi', 'Kp. Babakan Hilir', '085278912821'),
(2, 'Petrin Beunta', 'Gg. Kulged', '086296211234'),
(3, 'Ucup Sikit', 'Jl. Separo', '085727817581');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `mobil_id` int(11) NOT NULL,
  `supir_id` int(11) NOT NULL,
  `tgl_keluar` date DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `unit_total` int(11) NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`transaksi_id`, `mobil_id`, `supir_id`, `tgl_keluar`, `tgl_masuk`, `jam_keluar`, `jam_masuk`, `unit_total`, `total`) VALUES
(22, 1, 1, '2023-02-09', NULL, '11:13:53', NULL, 5, 0),
(23, 5, 1, '2023-02-09', '2023-02-09', '11:14:05', '12:41:10', 3, 301000),
(24, 2, 2, '2023-02-09', '2023-02-09', '11:15:11', '13:24:36', 5, 602000),
(25, 1, 2, '2023-02-08', '2023-02-09', '10:33:11', '11:34:38', 1, 200000),
(26, 2, 1, '2023-02-09', NULL, '13:25:04', NULL, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `username`, `password`) VALUES
(1, 'silwa', '$2y$10$RTJwxLSHu1JTf2d2K65qAOzg5LY2baIs3A1IxKXo7iOHP8Fa59.P.'),
(2, 'gibran', '$2y$10$TkQshDSuWGOLiwvIM5xBpuC4wcHpPb9aSEa8zXtLQ4kzZQu569fce'),
(3, 'rani', '$2y$10$BIDAoEPgd07Cc47WbnWeTuFLRGk.ucgp9qb56HvEjDAeUgBnTYXx6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `merek`
--
ALTER TABLE `merek`
  ADD PRIMARY KEY (`merek_id`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`mobil_id`),
  ADD KEY `merek_id` (`merek_id`);

--
-- Indexes for table `supir`
--
ALTER TABLE `supir`
  ADD PRIMARY KEY (`supir_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD KEY `mobil_id` (`mobil_id`),
  ADD KEY `supir_id` (`supir_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `merek`
--
ALTER TABLE `merek`
  MODIFY `merek_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `mobil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `supir`
--
ALTER TABLE `supir`
  MODIFY `supir_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mobil`
--
ALTER TABLE `mobil`
  ADD CONSTRAINT `mobil_ibfk_1` FOREIGN KEY (`merek_id`) REFERENCES `merek` (`merek_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`mobil_id`) REFERENCES `mobil` (`mobil_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`supir_id`) REFERENCES `supir` (`supir_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
