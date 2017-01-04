-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2017 at 03:45 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pupuk`
--
CREATE DATABASE IF NOT EXISTS `db_pupuk` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_pupuk`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `keterangan` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `keterangan`) VALUES
('admin', 'admin', 'admin adalah pengelola sistem ini'),
('admin_siang', 'siang', 'admin yang mengelola transaksi pada shift 1');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `nama_anggota` varchar(50) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_pupuk` int(11) NOT NULL,
  `kuantitas` smallint(6) NOT NULL,
  `sub_total` mediumint(9) NOT NULL,
  `harga_per_kg` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penyediaan`
--

CREATE TABLE `detail_penyediaan` (
  `id_penyediaan` int(11) NOT NULL,
  `id_pupuk` int(11) NOT NULL,
  `kuantitas` smallint(6) NOT NULL,
  `harga_per_kg` mediumint(9) NOT NULL,
  `sub_total` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE `distributor` (
  `id_distributor` int(11) NOT NULL,
  `nama_distributor` varchar(50) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_anggota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penyediaan`
--

CREATE TABLE `penyediaan` (
  `id_penyediaan` int(11) NOT NULL,
  `id_distributor` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pupuk`
--

CREATE TABLE `pupuk` (
  `id_pupuk` int(11) NOT NULL,
  `nama_pupuk` varchar(50) NOT NULL,
  `stock_pupuk` mediumint(9) NOT NULL,
  `harga_per_kg` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penjualan`
--

CREATE TABLE `tmp_penjualan` (
  `id_pupuk` int(11) NOT NULL,
  `nama_pupuk` varchar(50) NOT NULL,
  `stock_pupuk` mediumint(9) NOT NULL,
  `kuantitas` mediumint(9) NOT NULL,
  `harga_per_kg` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penyediaan`
--

CREATE TABLE `tmp_penyediaan` (
  `id_pupuk` int(11) NOT NULL,
  `nama_pupuk` varchar(50) NOT NULL,
  `kuantitas` mediumint(9) NOT NULL,
  `harga_per_kg` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_penjualan`,`id_pupuk`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_pupuk` (`id_pupuk`);

--
-- Indexes for table `detail_penyediaan`
--
ALTER TABLE `detail_penyediaan`
  ADD PRIMARY KEY (`id_penyediaan`,`id_pupuk`),
  ADD KEY `id_penyediaan` (`id_penyediaan`),
  ADD KEY `id_pupuk` (`id_pupuk`);

--
-- Indexes for table `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`id_distributor`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `jual_id_anggota` (`id_anggota`);

--
-- Indexes for table `penyediaan`
--
ALTER TABLE `penyediaan`
  ADD PRIMARY KEY (`id_penyediaan`),
  ADD KEY `id_distributor` (`id_distributor`);

--
-- Indexes for table `pupuk`
--
ALTER TABLE `pupuk`
  ADD PRIMARY KEY (`id_pupuk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `distributor`
--
ALTER TABLE `distributor`
  MODIFY `id_distributor` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `penyediaan`
--
ALTER TABLE `penyediaan`
  MODIFY `id_penyediaan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pupuk`
--
ALTER TABLE `pupuk`
  MODIFY `id_pupuk` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `fkidPupuk` FOREIGN KEY (`id_pupuk`) REFERENCES `pupuk` (`id_pupuk`),
  ADD CONSTRAINT `fkidpenjualan` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`);

--
-- Constraints for table `detail_penyediaan`
--
ALTER TABLE `detail_penyediaan`
  ADD CONSTRAINT `fkidPupuuk` FOREIGN KEY (`id_pupuk`) REFERENCES `pupuk` (`id_pupuk`),
  ADD CONSTRAINT `fkidpenye` FOREIGN KEY (`id_penyediaan`) REFERENCES `penyediaan` (`id_penyediaan`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `jual_id_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`);

--
-- Constraints for table `penyediaan`
--
ALTER TABLE `penyediaan`
  ADD CONSTRAINT `fkIdidstributor` FOREIGN KEY (`id_distributor`) REFERENCES `distributor` (`id_distributor`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
