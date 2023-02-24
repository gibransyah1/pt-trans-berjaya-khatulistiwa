-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2023 at 03:50 AM
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
(6, 'Chevrolet', 'Amerika'),
(7, 'Wuling', 'Cina');

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
  `status` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`mobil_id`, `gambar`, `nama_mobil`, `jenis`, `kapasitas_mesin`, `harga_sewa`, `merek_id`, `status`) VALUES
(1, 'avanza.jpg', 'Avanza', 'Minibus', 1500, 100000, 1, 'disewa'),
(2, 'Mobilio.jpg', 'Mobilio', 'Minibus', 1500, 120000, 2, 'disewa'),
(5, 'Ertiga.jpg', 'Ertiga', 'Minibus', 1500, 100000, 5, 'disewa'),
(7, '1675923843_73eced3a0af3bb747738.jpg', 'Jimny', 'Suv', 1300, 100000, 5, 'tersedia'),
(8, '1675936383_0be1493126063ce1dd99.jpg', 'Spark', 'City Car', 1000, 50000, 6, 'tersedia'),
(9, '1676253896_3e5ba6a77168fe4ee9a9.jpg', 'Almaz', 'Suv', 1500, 100000, 7, 'tersedia'),
(10, '1676275846_37e653fc9b523d448ef1.jpg', 'Civic', 'CityCar', 1500, 100000, 2, 'tersedia');

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
(2, 'Petrin Pereum', 'Gg. Kulged', '086296211234'),
(3, 'Ucup Sikit', 'Jl. Separo', '085727817581'),
(4, 'Ujang Naon', 'Jl. Cukamandi', '086729123851'),
(5, 'Sugeng', 'Jl.Cipanday', '08575895012');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `mobil_id` int(11) NOT NULL,
  `supir_id` int(11) NOT NULL,
  `penyewa` varchar(225) NOT NULL,
  `tgl_keluar` date DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `islunas` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0,
  `status_pinjam` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`transaksi_id`, `mobil_id`, `supir_id`, `penyewa`, `tgl_keluar`, `tgl_masuk`, `islunas`, `nominal`, `total`, `status_pinjam`) VALUES
(45, 1, 1, 'Nenden', '2023-02-16', '2023-02-25', 1, 0, 900000, 'dikembalikan'),
(46, 2, 3, 'Juwita', '2023-02-16', '2023-02-25', 1, 0, 1080000, 'dikembalikan'),
(47, 5, 1, 'Junai', '2023-02-16', '2023-02-25', 1, 0, 900000, 'dikembalikan'),
(75, 1, 1, 'Sigit', '2023-02-18', '2023-03-01', 1, 0, 500000, 'dikembalikan'),
(104, 1, 1, 'Hani', '2023-02-20', '2023-02-21', 1, 0, 200000, 'dikembalikan'),
(107, 2, 1, 'Utami', '2023-02-21', '2023-02-22', 1, 0, 240000, 'dipinjam'),
(112, 5, 1, 'Hani', '2023-02-21', '2023-02-22', 1, 0, 200000, 'dipinjam'),
(113, 1, 1, 'Rani', '2023-02-21', '2023-02-22', 1, 0, 200000, 'dipinjam'),
(114, 7, 1, 'Lina', '2023-02-21', '2023-02-22', 3, 0, 0, 'dibatalkan');

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
(7, 'gibransyah', '$2y$10$PXCrMXAdz1WyNKmoe6HoturTRR0hc1K0wB/gm5dzKwrKbzMNVT296'),
(8, 'kevin', '$2y$10$AcMbfRKP48MZLzmnkIvTTebIkVb7oxeS4ZWn/WOwh2LhhUceWbu.y');

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
  MODIFY `merek_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `mobil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supir`
--
ALTER TABLE `supir`
  MODIFY `supir_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
