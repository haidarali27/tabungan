/*
MySQL Data Transfer
Source Host: localhost
Source Database: db_jamaah
Target Host: localhost
Target Database: db_jamaah
Date: 11/03/2017 12.28.36
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for as_bp
-- ----------------------------
DROP TABLE IF EXISTS `as_bp`;
CREATE TABLE `as_bp` (
  `trx_id` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id` int(11) DEFAULT NULL,
  `jabatan_id` int(11) DEFAULT NULL,
  `unit_kerja_id` int(11) DEFAULT NULL,
  `temuan` text,
  `tgl_kejadian` date DEFAULT NULL,
  `jenis_temuan` varchar(255) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `komitmen` text,
  `sanksi` text,
  `petugas_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_userid` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_userid` int(11) DEFAULT NULL,
  PRIMARY KEY (`trx_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for as_kode_perguruan_tinggi
-- ----------------------------
DROP TABLE IF EXISTS `as_kode_perguruan_tinggi`;
CREATE TABLE `as_kode_perguruan_tinggi` (
  `kode_perguruan_tinggi` char(6) NOT NULL,
  `nama_perguruan_tinggi` varchar(100) NOT NULL,
  `kota` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for as_kode_program_studi
-- ----------------------------
DROP TABLE IF EXISTS `as_kode_program_studi`;
CREATE TABLE `as_kode_program_studi` (
  `kode_program_studi` char(5) NOT NULL,
  `nama_program_studi` varchar(100) NOT NULL,
  `jenjang_studi` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for as_master_jabatan
-- ----------------------------
DROP TABLE IF EXISTS `as_master_jabatan`;
CREATE TABLE `as_master_jabatan` (
  `id_jabatan` int(50) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(100) NOT NULL,
  `level` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 DELAY_KEY_WRITE=1;

-- ----------------------------
-- Table structure for as_master_pelatihan
-- ----------------------------
DROP TABLE IF EXISTS `as_master_pelatihan`;
CREATE TABLE `as_master_pelatihan` (
  `id_pelatihan` int(50) NOT NULL AUTO_INCREMENT,
  `nama_pelatihan` varchar(150) NOT NULL,
  `level` varchar(50) NOT NULL,
  PRIMARY KEY (`id_pelatihan`)
) ENGINE=MyISAM AUTO_INCREMENT=395 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for as_master_unit_kerja
-- ----------------------------
DROP TABLE IF EXISTS `as_master_unit_kerja`;
CREATE TABLE `as_master_unit_kerja` (
  `id_unit_kerja` int(50) NOT NULL AUTO_INCREMENT,
  `nama_unit_kerja` varchar(150) NOT NULL,
  `kode_unit` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `kode_produk` varchar(50) NOT NULL,
  PRIMARY KEY (`id_unit_kerja`),
  UNIQUE KEY `set_kode_unit` (`kode_unit`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for as_riwayat_jabatan_karyawan
-- ----------------------------
DROP TABLE IF EXISTS `as_riwayat_jabatan_karyawan`;
CREATE TABLE `as_riwayat_jabatan_karyawan` (
  `trx_id` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id` int(11) NOT NULL,
  `status_transaksi` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `jabatan_id` int(11) NOT NULL,
  `unit_kerja_id` int(11) NOT NULL,
  `periode_awal` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`trx_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for as_riwayat_jaminan_karyawan
-- ----------------------------
DROP TABLE IF EXISTS `as_riwayat_jaminan_karyawan`;
CREATE TABLE `as_riwayat_jaminan_karyawan` (
  `jaminan_id` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id` varchar(20) NOT NULL,
  `no_jaminan` varchar(20) NOT NULL,
  `tempat_jaminan` varchar(100) NOT NULL,
  `status` char(1) NOT NULL,
  `kode_jenis_jaminan` varchar(20) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `keterangan` text NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`jaminan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for as_riwayat_pendidikan_karyawan
-- ----------------------------
DROP TABLE IF EXISTS `as_riwayat_pendidikan_karyawan`;
CREATE TABLE `as_riwayat_pendidikan_karyawan` (
  `riwayat_id` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id` int(11) NOT NULL,
  `kode_perguruan_tinggi` char(6) NOT NULL,
  `kode_program_studi` char(5) NOT NULL,
  `kode_jenjang_studi` char(1) NOT NULL,
  `gelar_akademik` char(30) NOT NULL,
  `tanggal_ijazah` date NOT NULL,
  `sks_lulus` int(11) NOT NULL,
  `ipk_akhir` char(5) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`riwayat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for master_data
-- ----------------------------
DROP TABLE IF EXISTS `master_data`;
CREATE TABLE `master_data` (
  `id_identitas` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Karyawan',
  `nik` varchar(255) DEFAULT NULL COMMENT 'No Induk Karyawan',
  `nik_lama` varchar(255) DEFAULT NULL COMMENT 'Nomor Induk Karyawan Lama',
  `tgl_masuk` date DEFAULT NULL COMMENT 'tanggal pendaftaran',
  `tempat_daftar` varchar(255) DEFAULT NULL COMMENT 'Tempat Daftar(Jatim, Jateng atau Jabar)',
  `no_ktp` varchar(25) NOT NULL COMMENT 'No KTP',
  `nama` varchar(30) NOT NULL COMMENT 'Nama Karyawan',
  `gelar_akademik` varchar(10) NOT NULL COMMENT 'Gelar Akademik/Profesional tertinggi',
  `pendidikan_tertinggi` varchar(1) DEFAULT NULL COMMENT 'Kode Jenjang Studi',
  `tempat_lhr` varchar(20) NOT NULL COMMENT 'Tempat Lahir',
  `tgl_lahir` date NOT NULL COMMENT 'Tanggal Lahir',
  `kode_jk` varchar(1) NOT NULL COMMENT 'Kode Jenis Kelamin',
  `status` varchar(255) DEFAULT NULL COMMENT 'status karyawan',
  `status_ikatan_kerja` varchar(255) DEFAULT NULL COMMENT 'Status Ikatan Kerja',
  `status_aktifitas` varchar(255) DEFAULT NULL COMMENT 'status Aktifitas karyawan',
  `cabang` varchar(255) NOT NULL,
  `ranting` varchar(255) NOT NULL,
  `koja` varchar(255) NOT NULL,
  `alamat_ktp` text NOT NULL COMMENT 'alamat sesuai KTP',
  `jalan` varchar(255) DEFAULT NULL,
  `no_rumah` varchar(255) DEFAULT NULL,
  `rt` varchar(255) DEFAULT NULL,
  `rw` varchar(255) DEFAULT NULL,
  `dukuh` varchar(255) DEFAULT NULL,
  `desa` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `kabupaten` varchar(20) NOT NULL COMMENT 'Kota Dosen',
  `propinsi` varchar(20) NOT NULL COMMENT 'Propinsi Dosen',
  `kode_pos` varchar(5) NOT NULL COMMENT 'Kode Pos',
  `negara` varchar(20) NOT NULL COMMENT 'Negara',
  `telepon` varchar(20) NOT NULL COMMENT 'Telepon',
  `hp` varchar(20) NOT NULL COMMENT 'Handphone',
  `email` varchar(40) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `password` varchar(32) NOT NULL,
  `level_login` varchar(1) DEFAULT '5' COMMENT 'level login karyawan',
  `last_login` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_userid` int(11) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  `lahan` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_identitas`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for master_ref_cabang
-- ----------------------------
DROP TABLE IF EXISTS `master_ref_cabang`;
CREATE TABLE `master_ref_cabang` (
  `id_unit_cabang` int(50) NOT NULL AUTO_INCREMENT,
  `nama_unit_cabang` varchar(150) NOT NULL,
  `kode_unit_cabang` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `kode_produk` varchar(50) NOT NULL,
  PRIMARY KEY (`id_unit_cabang`),
  UNIQUE KEY `set_kode_unit` (`kode_unit_cabang`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for master_ref_desa
-- ----------------------------
DROP TABLE IF EXISTS `master_ref_desa`;
CREATE TABLE `master_ref_desa` (
  `id` varchar(20) NOT NULL,
  `id_kecamatan` varchar(20) DEFAULT NULL,
  `nama` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for master_ref_kabkota
-- ----------------------------
DROP TABLE IF EXISTS `master_ref_kabkota`;
CREATE TABLE `master_ref_kabkota` (
  `id` varchar(20) NOT NULL,
  `id_prov` varchar(20) DEFAULT NULL,
  `nama` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for master_ref_kecamatan
-- ----------------------------
DROP TABLE IF EXISTS `master_ref_kecamatan`;
CREATE TABLE `master_ref_kecamatan` (
  `id` varchar(20) NOT NULL,
  `id_kabkota` varchar(20) DEFAULT NULL,
  `nama` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for master_ref_koja
-- ----------------------------
DROP TABLE IF EXISTS `master_ref_koja`;
CREATE TABLE `master_ref_koja` (
  `id_unit_koja` int(50) NOT NULL AUTO_INCREMENT,
  `nama_unit_koja` varchar(150) NOT NULL,
  `kode_unit_koja` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `kode_produk` varchar(50) NOT NULL,
  PRIMARY KEY (`id_unit_koja`),
  UNIQUE KEY `set_kode_unit` (`kode_unit_koja`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for master_ref_provinsi
-- ----------------------------
DROP TABLE IF EXISTS `master_ref_provinsi`;
CREATE TABLE `master_ref_provinsi` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for master_ref_ranting
-- ----------------------------
DROP TABLE IF EXISTS `master_ref_ranting`;
CREATE TABLE `master_ref_ranting` (
  `id_unit_ranting` int(50) NOT NULL AUTO_INCREMENT,
  `nama_unit_ranting` varchar(150) NOT NULL,
  `kode_unit_ranting` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `kode_produk` varchar(50) NOT NULL,
  PRIMARY KEY (`id_unit_ranting`),
  UNIQUE KEY `set_kode_unit` (`kode_unit_ranting`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for msyys
-- ----------------------------
DROP TABLE IF EXISTS `msyys`;
CREATE TABLE `msyys` (
  `IDYYSMSYYS` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Kode Badan Hukum Perguruan Tinggi',
  `KDYYSMSYYS` varchar(7) NOT NULL COMMENT 'Kode Badan Hukum Perguruan Tinggi',
  `NMYYSMSYYS` varchar(50) NOT NULL COMMENT 'Nama Badan Hukum Perguruan Tinggi',
  `ALMT1MSYYS` varchar(30) NOT NULL COMMENT 'Alamat',
  `ALMT2MSYYS` varchar(30) NOT NULL COMMENT 'Alamat',
  `KOTAAMSYYS` varchar(20) NOT NULL COMMENT 'Kota',
  `KDPOSMSYYS` varchar(5) NOT NULL COMMENT 'Kode Pos',
  `TELPOMSYYS` varchar(20) NOT NULL COMMENT 'Telepon',
  `FAKSIMSYYS` varchar(20) NOT NULL COMMENT 'Faksimil',
  `TGYYSMSYYS` date NOT NULL COMMENT 'Tanggal Akta/SK yang Terakhir',
  `NOMSKMSYYS` varchar(30) NOT NULL COMMENT 'Nama Akta/SK Yayasan yang Terakhir',
  `TGLBNMSYYS` date NOT NULL COMMENT 'Tanggal Pengesahan Pengadilan Negeri/Lembar Berita Negara (Yang Terakhir, Bila Ada)',
  `NOMBNMSYYS` varchar(30) NOT NULL COMMENT 'Nomor Pengesahan Pengadilan Negeri/Lembar Berita Negara (Yang Terakhir, Bila Ada)',
  `EMAILMSYYS` varchar(40) NOT NULL COMMENT 'Alamat e-mail',
  `HPAGEMSYYS` varchar(40) NOT NULL COMMENT 'Alamat website',
  `TGLAWLMSYYS` date NOT NULL COMMENT 'Tanggal Awal Pendirian Badan Hukum',
  `modified_date` datetime NOT NULL,
  `modified_userid` int(11) NOT NULL,
  PRIMARY KEY (`IDYYSMSYYS`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- View structure for testinnerjoin
-- ----------------------------
DROP VIEW IF EXISTS `testinnerjoin`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `testinnerjoin` AS select `master_data`.`nama` AS `nama`,`master_data`.`nik` AS `nik`,`master_ref_koja`.`nama_unit_koja` AS `nama_unit_koja`,`master_ref_koja`.`keterangan` AS `keterangan` from (`master_data` join `master_ref_koja` on((`master_ref_koja`.`id_unit_koja` = `master_data`.`koja`)));

-- ----------------------------
-- View structure for vwer
-- ----------------------------
DROP VIEW IF EXISTS `vwer`;
