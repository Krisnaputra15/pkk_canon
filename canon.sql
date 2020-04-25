-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2020 at 05:03 PM
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
-- Database: `canon`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `qty_item` int(11) NOT NULL,
  `harga_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `id_transaksi`, `id_item`, `qty_item`, `harga_total`) VALUES
(4, 1, 6, 2, 6000),
(5, 1, 7, 1, 3000),
(6, 6, 1, 1, 4000),
(7, 6, 2, 1, 4000),
(8, 7, 4, 1, 3000),
(9, 7, 6, 1, 3000),
(10, 7, 7, 1, 3000),
(11, 8, 4, 1, 3000),
(12, 8, 7, 1, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `id_kantin` int(11) NOT NULL,
  `nama_item` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `id_jenis`, `id_kantin`, `nama_item`, `harga`, `status`) VALUES
(1, 1, 1, 'Nasi pecel', 4000, 'tersedia'),
(2, 2, 1, 'Es jeruk', 2000, 'tersedia'),
(3, 1, 1, 'Ayam Goreng', 7000, 'tersedia'),
(4, 1, 2, 'Nasi Pecel', 3000, 'tersedia'),
(5, 1, 2, 'Nasi Only', 2000, 'tersedia'),
(6, 1, 2, 'Jamur Crispy', 3000, 'tersedia'),
(7, 2, 2, 'Es Teh', 2000, 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_item`
--

CREATE TABLE `jenis_item` (
  `id` int(11) NOT NULL,
  `nama_jenis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_item`
--

INSERT INTO `jenis_item` (`id`, `nama_jenis`) VALUES
(1, 'makanan'),
(2, 'minuman');

-- --------------------------------------------------------

--
-- Table structure for table `kantin`
--

CREATE TABLE `kantin` (
  `id` int(11) NOT NULL,
  `nama_kantin` varchar(255) NOT NULL,
  `id_penjual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kantin`
--

INSERT INTO `kantin` (`id`, `nama_kantin`, `id_penjual`) VALUES
(1, 'kantin mister tukul', 4),
(2, 'Kantin Bu Inul', 5),
(6, 'Kantin Bu Bari 5', 9);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `nis` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `username` varchar(1000) DEFAULT NULL,
  `password` varchar(10000) DEFAULT NULL,
  `level` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama_pelanggan`, `nis`, `kelas`, `jenis_kelamin`, `username`, `password`, `level`) VALUES
(1, 'Daffa Khalfani', '123456789', 'XI RPL 5', 'L', 'daffa_k', '$2y$10$mQOC6OFvv9xcKwya7lw8.uR3MnIL9KTXhui2f8SqiTksj.RqUyzee', 3),
(5, 'Krisna Putra Mariyanto', '987654321', 'XI RPL 5', 'L', 'krisnapm', '$2y$10$Fn629h6q/p0zrMHSNVkoVOlBgqzz.VbCs5ug7H7UNPB6Syll7Cthy', 3);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `nama_petugas` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `nama_petugas`, `username`, `password`, `level`) VALUES
(1, 'Krisna Putra', 'iamkpm', '$2y$10$ux/Zy//j6ra/ov6tNHawV.S4C5vAO21SLlp8hE64J6LDjADt7h10y', 1),
(4, 'Bu Patmi', 'patmi', '$2y$10$WhjOhwkTfqq5X0QrA29CmOFRmbheBSZ7zvfPfUpIO6dAt/2QmTuZG', 2),
(5, 'bu inul', 'ibuinul', '$2y$10$qNkpbaNXgjnJGE.YPsy5du2aU2yzB7g7ehddybdKb1t.GIIazXRba', 2),
(9, 'Bu Bari', 'barii', '$2y$10$WSdGm2Ru02ncYcu2ahcU2uMCanKiJjhazn7iyJTyNN.x.AUfnato2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_kantin` int(11) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_pelanggan`, `id_kantin`, `tgl_transaksi`, `status`) VALUES
(1, 1, 2, '2020-04-25 06:29:19', 'confirmed, paid'),
(6, 1, 1, '2020-04-25 08:09:09', 'confirmed, Paid'),
(7, 1, 2, '2020-04-25 12:53:08', 'Unconfirmed, Paid'),
(8, 5, 2, '2020-04-25 14:24:38', 'confirmed, paid');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_item` (`id_item`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jenis` (`id_jenis`),
  ADD KEY `id_kantin` (`id_kantin`);

--
-- Indexes for table `jenis_item`
--
ALTER TABLE `jenis_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kantin`
--
ALTER TABLE `kantin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_penjual` (`id_penjual`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_kantin` (`id_kantin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jenis_item`
--
ALTER TABLE `jenis_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kantin`
--
ALTER TABLE `kantin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_item`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_item` (`id`),
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`id_kantin`) REFERENCES `kantin` (`id`);

--
-- Constraints for table `kantin`
--
ALTER TABLE `kantin`
  ADD CONSTRAINT `kantin_ibfk_1` FOREIGN KEY (`id_penjual`) REFERENCES `petugas` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_kantin`) REFERENCES `kantin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
