/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.19-MariaDB : Database - dbneigh_admin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbneigh_admin` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `dbneigh_admin`;

/*Table structure for table `taccesslog` */

DROP TABLE IF EXISTS `taccesslog`;

CREATE TABLE `taccesslog` (
  `idacclog` bigint(20) NOT NULL AUTO_INCREMENT,
  `idusr` bigint(20) NOT NULL,
  `issucc` int(11) NOT NULL,
  `dreg` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idacclog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tcomplaints` */

DROP TABLE IF EXISTS `tcomplaints`;

CREATE TABLE `tcomplaints` (
  `idcomplaint` bigint(20) NOT NULL AUTO_INCREMENT,
  `idusr` bigint(20) NOT NULL,
  `tycomplaint` int(11) NOT NULL,
  `desc` text DEFAULT NULL,
  `dtcomplaint` date NOT NULL,
  `idusrchk` bigint(20) DEFAULT NULL,
  `isvalid` int(3) DEFAULT 0,
  `isresolved` int(3) DEFAULT 0,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`idcomplaint`,`idusr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tcomplaints_type` */

DROP TABLE IF EXISTS `tcomplaints_type`;

CREATE TABLE `tcomplaints_type` (
  `tycomplaint` int(11) NOT NULL,
  `complaint` varchar(255) NOT NULL,
  `isact` int(3) NOT NULL,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`tycomplaint`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `thomes` */

DROP TABLE IF EXISTS `thomes`;

CREATE TABLE `thomes` (
  `idhome` bigint(20) NOT NULL,
  `idusr` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` varchar(255) DEFAULT '-',
  `strt` varchar(255) NOT NULL,
  `numext` varchar(10) NOT NULL,
  `numint` varchar(10) DEFAULT NULL,
  `zipc` varchar(10) NOT NULL,
  `suburb` varchar(255) NOT NULL,
  `entity` varchar(50) NOT NULL,
  `phne` varchar(20) DEFAULT NULL,
  `tyhome` int(11) NOT NULL,
  `isact` int(3) NOT NULL DEFAULT 1,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`idhome`,`idusr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `thomes_type` */

DROP TABLE IF EXISTS `thomes_type`;

CREATE TABLE `thomes_type` (
  `tyhome` int(11) NOT NULL,
  `typehome` varchar(255) NOT NULL,
  `isact` int(3) NOT NULL DEFAULT 1,
  `dreg` datetime DEFAULT current_timestamp(),
  `dmod` datetime DEFAULT NULL,
  PRIMARY KEY (`tyhome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tpayments` */

DROP TABLE IF EXISTS `tpayments`;

CREATE TABLE `tpayments` (
  `idpayment` bigint(20) NOT NULL,
  `idusr` bigint(20) NOT NULL,
  `typaymnt` int(11) NOT NULL,
  `idlapse` int(11) DEFAULT 0,
  `desc` varchar(255) NOT NULL,
  `dtpaymnt` date NOT NULL,
  `amntpaymnt` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `tax2` decimal(10,4) DEFAULT 0.0000,
  `tax1` decimal(10,4) DEFAULT 0.0000,
  `totalamntpaymnt` decimal(10,4) DEFAULT 0.0000,
  `iscmplt` int(3) DEFAULT 1,
  `pymntinvoice` varchar(20) NOT NULL,
  `pymntseries` varchar(10) NOT NULL,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`idpayment`,`idusr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tpayments_lapse` */

DROP TABLE IF EXISTS `tpayments_lapse`;

CREATE TABLE `tpayments_lapse` (
  `idlapse` int(11) NOT NULL,
  `lapse` varchar(255) NOT NULL,
  `lapseinyear` int(11) NOT NULL DEFAULT 12,
  `isact` int(3) NOT NULL,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`idlapse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tpayments_types` */

DROP TABLE IF EXISTS `tpayments_types`;

CREATE TABLE `tpayments_types` (
  `typaymnt` int(11) NOT NULL,
  `typepayment` varchar(255) NOT NULL,
  `amount` decimal(10,4) DEFAULT 0.0000,
  `idlapse` int(11) NOT NULL DEFAULT 1,
  `ismndty` int(3) NOT NULL DEFAULT 0,
  `tax1` decimal(10,4) DEFAULT 0.0000,
  `tax2` decimal(10,4) DEFAULT 0.0000,
  `totalamount` decimal(10,4) DEFAULT 0.0000,
  `isact` int(3) NOT NULL DEFAULT 1,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`typaymnt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tusers` */

DROP TABLE IF EXISTS `tusers`;

CREATE TABLE `tusers` (
  `idusr` bigint(20) NOT NULL,
  `user` varchar(255) NOT NULL,
  `psswd` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phne` varchar(20) DEFAULT NULL,
  `fsname` varchar(70) NOT NULL,
  `lsname` varchar(70) NOT NULL,
  `dobth` date DEFAULT NULL,
  `tyusr` int(5) NOT NULL,
  `isact` int(3) NOT NULL DEFAULT 1,
  `dldtlog` datetime DEFAULT NULL,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`idusr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tusers_type` */

DROP TABLE IF EXISTS `tusers_type`;

CREATE TABLE `tusers_type` (
  `tyusr` int(5) NOT NULL,
  `typeuser` varchar(255) NOT NULL,
  `isadmin` int(3) NOT NULL DEFAULT 0,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`tyusr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tvisitors` */

DROP TABLE IF EXISTS `tvisitors`;

CREATE TABLE `tvisitors` (
  `idvisitor` bigint(20) NOT NULL,
  `idusr` bigint(20) NOT NULL,
  `fsname` varchar(70) DEFAULT NULL,
  `lsname` varchar(70) DEFAULT NULL,
  `dtviststart` date NOT NULL,
  `dtvistend` date NOT NULL,
  `tyvisit` int(5) NOT NULL,
  `reasonvisit` text DEFAULT NULL,
  `qrcode` varchar(255) DEFAULT NULL,
  `dtqrstarts` datetime DEFAULT NULL,
  `dtqrends` datetime DEFAULT NULL,
  `stsvisitor` int(5) NOT NULL DEFAULT 1,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`idvisitor`,`idusr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tvisitors_state` */

DROP TABLE IF EXISTS `tvisitors_state`;

CREATE TABLE `tvisitors_state` (
  `stsvisitor` int(5) NOT NULL,
  `statevisitor` varchar(50) NOT NULL,
  `isact` int(3) NOT NULL DEFAULT 1,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`stsvisitor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tvisitors_statechange` */

DROP TABLE IF EXISTS `tvisitors_statechange`;

CREATE TABLE `tvisitors_statechange` (
  `idvisitor` bigint(20) NOT NULL,
  `idusr` bigint(20) NOT NULL,
  `idlog` bigint(20) NOT NULL,
  `prevsts` int(5) NOT NULL,
  `actsts` int(5) NOT NULL,
  `comment` text DEFAULT NULL,
  `isact` int(3) NOT NULL DEFAULT 1,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`idvisitor`,`idusr`,`idlog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tvisitors_type` */

DROP TABLE IF EXISTS `tvisitors_type`;

CREATE TABLE `tvisitors_type` (
  `tyvisit` int(5) NOT NULL,
  `typevisit` varchar(255) NOT NULL,
  `isact` int(3) NOT NULL DEFAULT 1,
  `dreg` datetime DEFAULT current_timestamp(),
  `dupd` datetime DEFAULT NULL,
  PRIMARY KEY (`tyvisit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
