/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.17-MariaDB : Database - evote
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `evoteci`;

/*Table structure for table `admin` */

CREATE TABLE IF NOT EXISTS `admin` (
  `kode_admin` varchar(7) NOT NULL,
  `username_admin` varchar(25) NOT NULL,
  `email_admin` varchar(255) NOT NULL,
  `password_admin` binary(60) DEFAULT NULL,
  PRIMARY KEY (`kode_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin` (`kode_admin`,`username_admin`,`email_admin`,`password_admin`) VALUES("ADM0001","evoteci","muhammadeko.if@gmail.com","evoteci123");

/*Table structure for table `calon` */

CREATE TABLE IF NOT EXISTS `calon` (
  `kode_calon` varchar(7) NOT NULL,
  `npm_ketua` varchar(11) NOT NULL,
  `npm_wakil` varchar(11) DEFAULT NULL,
  `foto_calon` varchar(255) NOT NULL,
  `pesan` text DEFAULT NULL,
  `panitia` varchar(7) NOT NULL,
  `pem` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT 0,
  PRIMARY KEY (`kode_calon`),
  KEY `calon_ibfk_2` (`npm_ketua`),
  KEY `calon_ibfk_3` (`npm_wakil`),
  KEY `calon_ibfk_4` (`panitia`),
  CONSTRAINT `calon_ibfk_2` FOREIGN KEY (`npm_ketua`) REFERENCES `user` (`npm`) ON DELETE CASCADE,
  CONSTRAINT `calon_ibfk_4` FOREIGN KEY (`panitia`) REFERENCES `panitia` (`kode_panitia`) ON DELETE CASCADE,
  CONSTRAINT `calon_ibfk_5` FOREIGN KEY (`npm_wakil`) REFERENCES `user` (`npm`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `event` */

CREATE TABLE IF NOT EXISTS `event` (
  `kode_event` varchar(7) NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto_event` varchar(255) NOT NULL,
  `admin` varchar(7) NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_selesai` datetime NOT NULL,
  PRIMARY KEY (`kode_event`),
  KEY `event_ibfk_1` (`admin`),
  CONSTRAINT `event_ibfk_1` FOREIGN KEY (`admin`) REFERENCES `admin` (`kode_admin`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `panitia` */

CREATE TABLE IF NOT EXISTS `panitia` (
  `kode_panitia` varchar(7) NOT NULL,
  `npm_panitia` varchar(11) NOT NULL,
  `event` varchar(7) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  PRIMARY KEY (`kode_panitia`),
  UNIQUE KEY `jabatan_event` (`event`,`jabatan`),
  UNIQUE KEY `npm_event` (`npm_panitia`,`event`),
  KEY `panitia_ibfk_1` (`event`),
  KEY `panitia_ibfk_3` (`npm_panitia`),
  CONSTRAINT `panitia_ibfk_1` FOREIGN KEY (`event`) REFERENCES `event` (`kode_event`) ON DELETE CASCADE,
  CONSTRAINT `panitia_ibfk_3` FOREIGN KEY (`npm_panitia`) REFERENCES `user` (`npm`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `rekap` */

CREATE TABLE IF NOT EXISTS `rekap` (
  `kode_rekap` varchar(10) NOT NULL,
  `npm_pemilih` varchar(11) NOT NULL,
  `event` varchar(7) NOT NULL,
  `foto_ktm` varchar(255) DEFAULT NULL,
  `foto_rekap` varchar(255) DEFAULT NULL,
  `tanggal_pilih` datetime DEFAULT current_timestamp(),
  `valid` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`kode_rekap`),
  KEY `rekap_ibfk_1` (`npm_pemilih`),
  KEY `rekap_ibfk_2` (`event`),
  CONSTRAINT `rekap_ibfk_1` FOREIGN KEY (`npm_pemilih`) REFERENCES `user` (`npm`) ON DELETE CASCADE,
  CONSTRAINT `rekap_ibfk_2` FOREIGN KEY (`event`) REFERENCES `event` (`kode_event`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `user` */

CREATE TABLE IF NOT EXISTS `user` (
  `npm` varchar(11) NOT NULL,
  `nama_user` varchar(50) DEFAULT NULL,
  `email_user` varchar(255) DEFAULT NULL,
  `password_user` binary(60) DEFAULT NULL,
  `type` binary(1) DEFAULT NULL,
  PRIMARY KEY (`npm`),
  UNIQUE KEY `UNIQUE` (`email_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
