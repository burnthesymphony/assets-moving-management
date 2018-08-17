-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2014 at 01:01 AM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inventory_pickup`
--

-- --------------------------------------------------------

--
-- Table structure for table `mst_inventory`
--

CREATE TABLE IF NOT EXISTS `mst_inventory` (
  `id_inventory` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id_inventory`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mst_inventory`
--

INSERT INTO `mst_inventory` (`id_inventory`, `inventory_name`, `address`, `aktif`) VALUES
(1, 'GUDANG A', 'JALAN BAKSO no 123', 'Y'),
(2, 'GUDANG B', 'JALAN SIOMAY NO 456', 'Y'),
(3, 'GUDANG C', 'JALAN ASINAN NO 8888', 'Y'),
(4, 'GUDANG D', 'JALAN RUJAK ULEG NO 9999', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `mst_item`
--

CREATE TABLE IF NOT EXISTS `mst_item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  `barcode` char(50) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mst_item`
--

INSERT INTO `mst_item` (`id_item`, `item_name`, `description`, `aktif`, `barcode`) VALUES
(1, 'BOX 1', 'BOX NUMBER 1 (EXAMPLE ONLY)', 'Y', '111'),
(2, 'BOX 2', 'BOX NUMBER 2 (EXAMPLE ONLY)', 'Y', '222'),
(3, 'BOX 3', 'BOX NUMBER 3 (EXAMPLE ONLY)', 'Y', '333'),
(4, 'BOX 4', 'BOX NUMBER 4 (EXAMPLE ONLY)', 'Y', '444'),
(5, 'BOX 5', 'BOX NUMBER 5 (EXAMPLE ONLY)', 'Y', '555');

-- --------------------------------------------------------

--
-- Table structure for table `mst_menu`
--

CREATE TABLE IF NOT EXISTS `mst_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `parent` int(11) NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mst_menu`
--


-- --------------------------------------------------------

--
-- Table structure for table `mst_otoritas`
--

CREATE TABLE IF NOT EXISTS `mst_otoritas` (
  `id_otoritas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_otoritas` varchar(100) NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_otoritas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mst_otoritas`
--

INSERT INTO `mst_otoritas` (`id_otoritas`, `nama_otoritas`, `aktif`) VALUES
(1, 'root', ''),
(2, 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `mst_process`
--

CREATE TABLE IF NOT EXISTS `mst_process` (
  `id_process` int(11) NOT NULL AUTO_INCREMENT,
  `process_name` varchar(200) NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_process`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `mst_process`
--

INSERT INTO `mst_process` (`id_process`, `process_name`, `aktif`) VALUES
(1, 'NO PROCESS', 'Y'),
(2, 'ITEM ON DELIVERING', 'Y'),
(3, 'ITEM DELIVERED', 'Y'),
(4, '1ST VERIFICATION', 'Y'),
(5, '2ND VERIFICAION', 'Y'),
(6, 'RETUR', 'Y'),
(7, 'FINISH\r\n', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `mst_user`
--

CREATE TABLE IF NOT EXISTS `mst_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `id_otoritas` int(11) NOT NULL,
  `nama_lengkap` varchar(200) NOT NULL,
  `status_login` tinyint(1) NOT NULL DEFAULT '0',
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_user`),
  KEY `id_otoritas` (`id_otoritas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mst_user`
--

INSERT INTO `mst_user` (`id_user`, `username`, `password`, `id_otoritas`, `nama_lengkap`, `status_login`, `aktif`) VALUES
(1, 'root', '63a9f0ea7bb98050796b649e85481845', 1, 'Nandra Maulana Irawan', 0, ''),
(2, 'nandra', '1ee85f6c60017a7f0646ba8dc5824de6', 2, 'nandra maulana irawan', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `trs_log_item_process`
--

CREATE TABLE IF NOT EXISTS `trs_log_item_process` (
  `id_log_item_process` int(11) NOT NULL AUTO_INCREMENT,
  `id_process` int(11) NOT NULL,
  `id_pickup_detail` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_inventory` int(11) NOT NULL,
  `user_create` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  PRIMARY KEY (`id_log_item_process`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `trs_log_item_process`
--

INSERT INTO `trs_log_item_process` (`id_log_item_process`, `id_process`, `id_pickup_detail`, `id_item`, `qty`, `id_inventory`, `user_create`, `date_create`) VALUES
(1, 2, 1, 3, 2, 1, 1, '2014-08-25 00:48:13'),
(2, 2, 2, 2, 5, 1, 1, '2014-08-25 00:48:13'),
(3, 2, 3, 1, 2, 1, 1, '2014-08-25 00:48:13'),
(4, 3, 3, 1, 1, 2, 1, '2014-08-25 00:49:07'),
(5, 3, 1, 3, 1, 2, 1, '2014-08-25 00:50:20');

-- --------------------------------------------------------

--
-- Table structure for table `trs_pickup`
--

CREATE TABLE IF NOT EXISTS `trs_pickup` (
  `id_pickup` int(11) NOT NULL AUTO_INCREMENT,
  `permit_number` varchar(100) NOT NULL COMMENT 'no_surat_jalan',
  `user_create` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `id_inventory_from` int(11) DEFAULT NULL COMMENT 'diisi  jika proses d lakukan d gudang',
  `id_inventory_to` int(11) NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  `car_number` char(15) NOT NULL,
  `drivername` varchar(200) NOT NULL,
  PRIMARY KEY (`id_pickup`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='mencatat surat jalan' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `trs_pickup`
--

INSERT INTO `trs_pickup` (`id_pickup`, `permit_number`, `user_create`, `date_create`, `id_inventory_from`, `id_inventory_to`, `aktif`, `car_number`, `drivername`) VALUES
(1, 'DEMO-22630', 1, '2014-08-25 00:48:13', 1, 2, 'Y', 'F213ND', 'NURMAN');

-- --------------------------------------------------------

--
-- Table structure for table `trs_pickup_detail`
--

CREATE TABLE IF NOT EXISTS `trs_pickup_detail` (
  `id_pickup_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_pickup` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  PRIMARY KEY (`id_pickup_detail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `trs_pickup_detail`
--

INSERT INTO `trs_pickup_detail` (`id_pickup_detail`, `id_pickup`, `qty`, `id_item`) VALUES
(1, 1, 3, 3),
(2, 1, 5, 2),
(3, 1, 5, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mst_user`
--
ALTER TABLE `mst_user`
  ADD CONSTRAINT `mst_user_ibfk_1` FOREIGN KEY (`id_otoritas`) REFERENCES `mst_otoritas` (`id_otoritas`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
