/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : db_tuahsakti

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2020-03-12 07:15:02
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `groups`
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO groups VALUES ('1', 'Administrator', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO groups VALUES ('2', 'User', '0000-00-00 00:00:00', '2017-05-24 09:40:23');

-- ----------------------------
-- Table structure for `hutang`
-- ----------------------------
DROP TABLE IF EXISTS `hutang`;
CREATE TABLE `hutang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_nota` varchar(30) NOT NULL,
  `vendor_id` int(30) NOT NULL,
  `debit` varchar(30) NOT NULL,
  `kredit` varchar(30) NOT NULL,
  `saldo` varchar(30) NOT NULL,
  `created_at` varchar(30) NOT NULL,
  `update_at` varchar(30) NOT NULL,
  `created_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of hutang
-- ----------------------------
INSERT INTO hutang VALUES ('36', 'PE-1583970096', '1', '', '1000000', '1000000', '2020-03-12 07:07:21', '', '2');

-- ----------------------------
-- Table structure for `item_pengajuan`
-- ----------------------------
DROP TABLE IF EXISTS `item_pengajuan`;
CREATE TABLE `item_pengajuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_pengajuan
-- ----------------------------
INSERT INTO item_pengajuan VALUES ('1', 'Bensin Transportasi lautan', '2020-03-10 17:20:05', '2020-03-10 17:22:35');
INSERT INTO item_pengajuan VALUES ('2', 'Uang Pelabuhan', '2020-03-11 12:52:49', null);
INSERT INTO item_pengajuan VALUES ('3', 'Lainya', '2020-03-11 12:52:58', null);

-- ----------------------------
-- Table structure for `material`
-- ----------------------------
DROP TABLE IF EXISTS `material`;
CREATE TABLE `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(62) COLLATE utf8_bin DEFAULT NULL,
  `satuan` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `harga_jual` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_at` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `update_at` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of material
-- ----------------------------
INSERT INTO material VALUES ('8', 'Semen Padang 50 Kg', 'Sak', '70000', 'test', '2020-03-09 16:05:48', null, '2');
INSERT INTO material VALUES ('9', 'Besi 6 mm', 'Batang', '10000', 'Besi Bangunan', '2020-03-11 22:28:12', null, '2');
INSERT INTO material VALUES ('23', 'Pasir Darat ', 'Kubik', '250000', 'Pasir darat', '2020-03-11 22:58:47', null, '2');

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `link` varchar(150) NOT NULL,
  `icon` varchar(45) NOT NULL,
  `order_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO menus VALUES ('1', '0', 'Dashboard', '#', 'fa-tachometer-alt', null);
INSERT INTO menus VALUES ('22', '1', 'Home', 'home', 'fa-circle', null);
INSERT INTO menus VALUES ('23', '1', 'List', 'home/list', 'fa-circle', null);
INSERT INTO menus VALUES ('24', '0', 'Material', '#', 'fa-clipboard-list', null);
INSERT INTO menus VALUES ('25', '24', 'Stock', 'material', 'fa-circle', null);
INSERT INTO menus VALUES ('26', '24', 'Pengadaan', 'pengadaan', 'fa-circle', null);
INSERT INTO menus VALUES ('27', '24', 'Pengeluaran', 'stock/pengeluaran', 'fa-circle', null);
INSERT INTO menus VALUES ('28', '1', 'Detail', 'home/detail', 'fa-circle', null);
INSERT INTO menus VALUES ('29', '24', 'Report', 'stock/report', 'fa-circle', null);
INSERT INTO menus VALUES ('30', '0', 'Setting', '#', 'fa-cog', null);
INSERT INTO menus VALUES ('31', '30', 'Menu', 'setting/menu', 'fa-circle', null);
INSERT INTO menus VALUES ('32', '30', 'Privelage', 'setting/privelage', 'fa-circle', null);
INSERT INTO menus VALUES ('33', '0', 'Vendor', 'vendor', 'fa-parachute-box', null);
INSERT INTO menus VALUES ('34', '30', 'Users', 'setting/users', 'fa-circle', null);
INSERT INTO menus VALUES ('35', '0', 'Acounting', '#', 'fa-box', null);
INSERT INTO menus VALUES ('36', '35', 'Pengajuan Dana', 'accounting/pengajuan', 'fa-circle', null);
INSERT INTO menus VALUES ('37', '35', 'Item Pengajuan', 'accounting/item', 'fa-circle', null);

-- ----------------------------
-- Table structure for `outlet`
-- ----------------------------
DROP TABLE IF EXISTS `outlet`;
CREATE TABLE `outlet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of outlet
-- ----------------------------

-- ----------------------------
-- Table structure for `pengadaan`
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan`;
CREATE TABLE `pengadaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surat_jalan` varchar(30) COLLATE utf8_bin NOT NULL,
  `no_nota` varchar(11) COLLATE utf8_bin DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `tanggal` varchar(12) COLLATE utf8_bin DEFAULT NULL,
  `qty` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `harga_beli` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `satuan` varchar(30) COLLATE utf8_bin NOT NULL,
  `keterangan` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `stock_updated` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` varchar(23) COLLATE utf8_bin DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `material_id` (`material_id`) USING BTREE,
  KEY `vendor_id` (`vendor_id`) USING BTREE,
  CONSTRAINT `pengadaan_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`),
  CONSTRAINT `pengadaan_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of pengadaan
-- ----------------------------
INSERT INTO pengadaan VALUES ('51', '1583932025', '0', '8', '1', '2020-03-12', '100', '50000', 'Sak', null, '100', '2020-03-12 07:07:21', '2');
INSERT INTO pengadaan VALUES ('52', '1583932025', '0', '23', '1', '2020-03-12', '5', '200000', 'Kubik', null, '5', '2020-03-12 07:07:21', '2');
INSERT INTO pengadaan VALUES ('53', '1583932025', '0', '9', '1', '2020-03-12', '500', '30000', 'Batang', null, '500', '2020-03-12 07:07:21', '2');

-- ----------------------------
-- Table structure for `pengajuan_dana`
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_dana`;
CREATE TABLE `pengajuan_dana` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` varchar(255) DEFAULT NULL,
  `item_id` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `gudang_id` varchar(255) DEFAULT NULL,
  `datetime` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pengajuan_dana
-- ----------------------------
INSERT INTO pengajuan_dana VALUES ('1', '2020-03-11', '1', '100000', 'Untuk ambil barang di suang Pak mat', '1', '1583932025', null);
INSERT INTO pengajuan_dana VALUES ('2', '2020-03-11', '2', '90000', 'Untuk ambil barang di suang Pak mat', '1', '1583932025', null);
INSERT INTO pengajuan_dana VALUES ('3', '2020-03-11', '3', '100000', 'Untuk ambil barang di suang Pak mat', '1', '1583932025', null);

-- ----------------------------
-- Table structure for `saldo_hutang`
-- ----------------------------
DROP TABLE IF EXISTS `saldo_hutang`;
CREATE TABLE `saldo_hutang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_nota` varchar(30) NOT NULL,
  `saldo` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of saldo_hutang
-- ----------------------------
INSERT INTO saldo_hutang VALUES ('36', 'PE-1583970096', '1000000', '2020');

-- ----------------------------
-- Table structure for `stock`
-- ----------------------------
DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `stock` varchar(11) NOT NULL,
  `updated_at` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of stock
-- ----------------------------
INSERT INTO stock VALUES ('1', '8', '0', '2020-03-12 04:04:04');
INSERT INTO stock VALUES ('2', '9', '0', '2020-03-12 05:05:05');
INSERT INTO stock VALUES ('3', '23', '0', '2020-03-11 22:58:47');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `outlet_id` int(11) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_active` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO users VALUES ('2', '1', '0', 'Admin', 'admin@tuahsakti.com', '$2y$10$ekSgfgIEPOjEIdFbmPys0Oy9BJ8noJqrKMQSvKf5KTBe4K4rHBlQK', 'default.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1');

-- ----------------------------
-- Table structure for `vendor`
-- ----------------------------
DROP TABLE IF EXISTS `vendor`;
CREATE TABLE `vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `no_telp` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of vendor
-- ----------------------------
INSERT INTO vendor VALUES ('1', 'PT Angin Ribut', '085374131481', 'Tiban Masyeba Permai', '1');
INSERT INTO vendor VALUES ('2', 'PT Setengah Hati', '000000', 'Sekupang', '1');
DELIMITER ;;
CREATE TRIGGER `triger_insert_new_stock` AFTER INSERT ON `material` FOR EACH ROW INSERT INTO stock (material_id, stock, updated_at) VALUES (new.id, 0, new.created_at)
;;
DELIMITER ;
DELIMITER ;;
CREATE TRIGGER `delete_stock` AFTER DELETE ON `material` FOR EACH ROW DELETE FROM stock WHERE material_id = old.id
;;
DELIMITER ;
