/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.6-MariaDB : Database - elearninglab
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`elearninglab` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `elearninglab`;

/*Table structure for table `tbl_aslab` */

DROP TABLE IF EXISTS `tbl_aslab`;

CREATE TABLE `tbl_aslab` (
  `idAslab` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `namaLengkap` varchar(100) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`idAslab`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_aslab` */

insert  into `tbl_aslab`(`idAslab`,`username`,`namaLengkap`,`password`) values 
(1,'chimemoo','Christ Memory Sitorus','memory543'),
(2,'chimchim','CHIMCHIM','b82ca95598fedd850a4e6b5d1195b6cc');

/*Table structure for table `tbl_hasiltugas` */

DROP TABLE IF EXISTS `tbl_hasiltugas`;

CREATE TABLE `tbl_hasiltugas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idKelas` int(11) NOT NULL,
  `idTugas` int(11) NOT NULL,
  `npm` varchar(14) NOT NULL,
  `tanggalKirim` datetime NOT NULL,
  `namaFile` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idKelasF` (`idKelas`),
  KEY `idTugasF` (`idTugas`),
  KEY `npmF` (`npm`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_hasiltugas` */

/*Table structure for table `tbl_kelas` */

DROP TABLE IF EXISTS `tbl_kelas`;

CREATE TABLE `tbl_kelas` (
  `idKelas` int(11) NOT NULL AUTO_INCREMENT,
  `idMataKuliah` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `hurufKelas` varchar(45) NOT NULL,
  `idAslab` int(11) NOT NULL,
  PRIMARY KEY (`idKelas`),
  KEY `idMataKuliahF` (`idMataKuliah`),
  KEY `idAslabF` (`idAslab`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_kelas` */

/*Table structure for table `tbl_mahasiswa` */

DROP TABLE IF EXISTS `tbl_mahasiswa`;

CREATE TABLE `tbl_mahasiswa` (
  `npm` varchar(14) NOT NULL,
  `namaLengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`npm`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_mahasiswa` */

insert  into `tbl_mahasiswa`(`npm`,`namaLengkap`,`email`,`password`) values 
('1610630042','Annisa','annisa@gmail.com','c9d2cce909ea37234be8af1a1f958805'),
('1610631170062','Christ Memory','christmemory5@gmail.com','b82ca95598fedd850a4e6b5d1195b6cc'),
('1610631170090','Janny Eka Prayogo','janny@gmail.com','b82ca95598fedd850a4e6b5d1195b6cc');

/*Table structure for table `tbl_matakuliah` */

DROP TABLE IF EXISTS `tbl_matakuliah`;

CREATE TABLE `tbl_matakuliah` (
  `idMKuliah` int(11) NOT NULL AUTO_INCREMENT,
  `namaMKuliah` varchar(45) NOT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idMKuliah`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_matakuliah` */

insert  into `tbl_matakuliah`(`idMKuliah`,`namaMKuliah`,`jurusan`) values 
(1,'Struktur Data','Teknik Informatika'),
(2,'Algoritma dan Pemrograman','Teknik Informatika'),
(3,'Elektronika dan Instrumentasi','Teknik Informatika'),
(4,'Pemrograman Berbasis Web','Teknik Informatika'),
(5,'Pemrograman Berbasis Mobile','Teknik Informatika'),
(6,'Pengolahan Citra Digital','Teknik Informatika');

/*Table structure for table `tbl_materi` */

DROP TABLE IF EXISTS `tbl_materi`;

CREATE TABLE `tbl_materi` (
  `idMateri` int(11) NOT NULL AUTO_INCREMENT,
  `idMkuliah` int(11) NOT NULL,
  `dosen` varchar(200) NOT NULL,
  `namaFile` varchar(255) NOT NULL,
  PRIMARY KEY (`idMateri`),
  KEY `mkuliah` (`idMkuliah`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_materi` */

/*Table structure for table `tbl_tugas` */

DROP TABLE IF EXISTS `tbl_tugas`;

CREATE TABLE `tbl_tugas` (
  `idTugas` int(11) NOT NULL AUTO_INCREMENT,
  `idKelas` varchar(45) NOT NULL,
  `kodeTugas` varchar(100) NOT NULL,
  `pertemuan` int(11) NOT NULL,
  `deadLine` datetime NOT NULL,
  `dibuat` datetime NOT NULL,
  PRIMARY KEY (`idTugas`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_tugas` */

insert  into `tbl_tugas`(`idTugas`,`idKelas`,`kodeTugas`,`pertemuan`,`deadLine`,`dibuat`) values 
(4,'7','07TUGAS05201905UH',1,'2019-05-09 00:00:00','2019-05-05 12:13:47');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
