-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.3.2-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_apl_bps.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.migrations: ~12 rows (approximately)
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(25, '2025-04-20-140135', 'App\\Database\\Migrations\\UserGroups', 'default', 'App', 1745677300, 1),
	(26, '2025-04-20-140148', 'App\\Database\\Migrations\\Users', 'default', 'App', 1745677300, 1),
	(27, '2025-04-20-140203', 'App\\Database\\Migrations\\BackendMenus', 'default', 'App', 1745677300, 1),
	(28, '2025-04-20-142347', 'App\\Database\\Migrations\\SiteSettings', 'default', 'App', 1745677300, 1),
	(29, '2025-04-20-142356', 'App\\Database\\Migrations\\OrgSettings', 'default', 'App', 1745677300, 1),
	(30, '2025-04-20-142411', 'App\\Database\\Migrations\\Navigations', 'default', 'App', 1745677300, 1),
	(31, '2025-04-20-142426', 'App\\Database\\Migrations\\Categories', 'default', 'App', 1745677300, 1),
	(32, '2025-04-20-142443', 'App\\Database\\Migrations\\LoginHistory', 'default', 'App', 1745677300, 1),
	(33, '2025-04-20-142449', 'App\\Database\\Migrations\\Visitors', 'default', 'App', 1745677300, 1),
	(34, '2025-04-20-142517', 'App\\Database\\Migrations\\Logs', 'default', 'App', 1745677300, 1),
	(35, '2025-04-25-145558', 'App\\Database\\Migrations\\DocumentModel', 'default', 'App', 1745677300, 1),
	(36, '2025-04-25-150710', 'App\\Database\\Migrations\\FileModel', 'default', 'App', 1745677300, 1);

-- Dumping structure for table db_apl_bps.tb_categories
CREATE TABLE IF NOT EXISTS `tb_categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_code` char(50) NOT NULL,
  `category_slug` char(100) NOT NULL,
  `category_name` char(255) NOT NULL,
  `category_viewers` int(10) unsigned DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_code` (`category_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_categories: ~1 rows (approximately)
INSERT INTO `tb_categories` (`category_id`, `category_code`, `category_slug`, `category_name`, `category_viewers`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, '2886.EBA.956', 'layanan-bmn', 'Layanan BMN', 0, '2025-04-27 23:10:56', NULL, NULL);

-- Dumping structure for table db_apl_bps.tb_documents
CREATE TABLE IF NOT EXISTS `tb_documents` (
  `document_id` char(128) NOT NULL,
  `user_id` char(128) NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `document_classification` enum('subbagumum','statsos','statprod','statdist','nerwilis','ipds') NOT NULL,
  `document_details` varchar(2000) NOT NULL,
  `spj_date` date NOT NULL,
  `document_viewers` int(10) unsigned DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`document_id`),
  KEY `tb_documents_user_id_foreign` (`user_id`),
  KEY `tb_documents_category_id_foreign` (`category_id`),
  CONSTRAINT `tb_documents_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tb_categories` (`category_id`),
  CONSTRAINT `tb_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_documents: ~3 rows (approximately)
INSERT INTO `tb_documents` (`document_id`, `user_id`, `category_id`, `document_classification`, `document_details`, `spj_date`, `document_viewers`, `created_at`, `updated_at`, `deleted_at`) VALUES
	('01969c4f-17c4-7cc4-8f74-f1641450279f', '63f21de1-a6db-48fc-a06d-90b1efdfd55c', 1, 'subbagumum', 'Testing 12345', '2025-05-05', 0, '2025-05-04 23:33:14', '2025-05-07 21:47:18', NULL),
	('0196ab3b-6c92-72ac-ad7f-08eb9b36f9b6', '63f21de1-a6db-48fc-a06d-90b1efdfd55c', 1, 'subbagumum', 'Testing Baru', '2025-05-07', 0, '2025-05-07 21:52:00', NULL, '2025-05-07 21:58:03'),
	('0196ab41-7c61-73a1-973a-3578a2f7a81a', '63f21de1-a6db-48fc-a06d-90b1efdfd55c', 1, 'subbagumum', 'Testing Baru', '2025-05-07', 0, '2025-05-07 21:58:37', NULL, '2025-05-07 22:10:43'),
	('0196ab4c-b72b-705c-a9fc-cd4ae91fdba0', '63f21de1-a6db-48fc-a06d-90b1efdfd55c', 1, 'subbagumum', 'Testing Baru', '2025-05-07', 0, '2025-05-07 22:10:53', '2025-05-07 22:11:51', NULL),
	('23beff51-938f-4717-822a-8d8881d0b4c8', '63f21de1-a6db-48fc-a06d-90b1efdfd55c', 1, 'subbagumum', 'Testing', '2025-05-01', 0, '2025-05-01 16:29:38', '2025-05-04 22:29:30', '2025-05-06 22:38:09');

-- Dumping structure for table db_apl_bps.tb_files
CREATE TABLE IF NOT EXISTS `tb_files` (
  `file_id` char(128) NOT NULL DEFAULT uuid(),
  `document_id` char(128) NOT NULL,
  `file_name` char(255) NOT NULL,
  `file_mime` char(100) NOT NULL,
  `file_classification` enum('kak','form_permintaan','sk_kpa','surat_tugas','mon_kegiatan','dok_kegiatan','adm_kegiatan') NOT NULL,
  `file_type` enum('jpg','jpeg','png','webp','pdf','docx','doc','xlsx','xls','pptx','ppt') NOT NULL,
  `file_size` float NOT NULL,
  `file_viewers` int(10) unsigned DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`file_id`),
  KEY `FK_tb_files_tb_documents` (`document_id`),
  CONSTRAINT `FK_tb_files_tb_documents` FOREIGN KEY (`document_id`) REFERENCES `tb_documents` (`document_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_files: ~8 rows (approximately)
INSERT INTO `tb_files` (`file_id`, `document_id`, `file_name`, `file_mime`, `file_classification`, `file_type`, `file_size`, `file_viewers`, `created_at`, `updated_at`, `deleted_at`) VALUES
	('0196ab1c-e7ab-72ee-a0b9-04dbc8a18042', '01969c4f-17c4-7cc4-8f74-f1641450279f', '1746627520_6898bb438d384b6d8428.pdf', 'application/pdf', 'kak', 'pdf', 513352, 0, '2025-05-07 21:18:40', NULL, NULL),
	('0196ab2b-9af7-73b3-aaed-b3eaec50d432', '01969c4f-17c4-7cc4-8f74-f1641450279f', '1746628483_1b29b81960a96dd06aa0.pdf', 'application/pdf', 'sk_kpa', 'pdf', 513352, 0, '2025-05-07 21:34:43', NULL, NULL),
	('0196ab2d-08d8-70ea-8110-77acf269d949', '01969c4f-17c4-7cc4-8f74-f1641450279f', '1746628577_b5f97cd1befc8abb7523.pdf', 'application/pdf', 'form_permintaan', 'pdf', 199700, 0, '2025-05-07 21:36:17', NULL, NULL),
	('0196ab2d-335c-722b-9bd5-ad6897f8f0bc', '01969c4f-17c4-7cc4-8f74-f1641450279f', '1746628588_0009e757c66e39a150f2.pdf', 'application/pdf', 'surat_tugas', 'pdf', 167080, 0, '2025-05-07 21:36:28', NULL, NULL),
	('0196ab2d-550f-7369-ab8e-01e6f30797e9', '01969c4f-17c4-7cc4-8f74-f1641450279f', '1746628596_0e19351bbb14957c523c.pdf', 'application/pdf', 'mon_kegiatan', 'pdf', 5684380, 0, '2025-05-07 21:36:37', NULL, NULL),
	('0196ab2d-6ed1-7024-81ee-05a398b3f7b6', '01969c4f-17c4-7cc4-8f74-f1641450279f', '1746628603_8e7428a0f929a3c8e5b3.pdf', 'application/pdf', 'dok_kegiatan', 'pdf', 218533, 0, '2025-05-07 21:36:43', NULL, NULL),
	('0196ab2d-96a6-718a-8b03-8f6d80ef1898', '01969c4f-17c4-7cc4-8f74-f1641450279f', '1746628613_eb54b191fe08dd76b45a.pdf', 'application/pdf', 'adm_kegiatan', 'pdf', 314985, 0, '2025-05-07 21:36:53', NULL, '2025-05-07 21:43:26'),
	('0196ab37-6704-71eb-9054-d4e93aaa6d06', '01969c4f-17c4-7cc4-8f74-f1641450279f', '1746629256_4c93d6da28d89162687e.pdf', 'application/pdf', 'adm_kegiatan', 'pdf', 3574110, 0, '2025-05-07 21:47:36', NULL, NULL),
	('0196ab4c-cb95-73f7-86ff-8063786331f5', '0196ab4c-b72b-705c-a9fc-cd4ae91fdba0', '1746630658_fb2a94712e62e3f84df4.pdf', 'application/pdf', 'kak', 'pdf', 179695, 0, '2025-05-07 22:10:58', NULL, NULL),
	('0196ab4d-5a74-7301-be35-0aa624b0d3a8', '0196ab4c-b72b-705c-a9fc-cd4ae91fdba0', '1746630695_4d526bd753987c740a02.pdf', 'application/pdf', 'form_permintaan', 'pdf', 179695, 0, '2025-05-07 22:11:35', NULL, NULL);

-- Dumping structure for table db_apl_bps.tb_login_history
CREATE TABLE IF NOT EXISTS `tb_login_history` (
  `_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(128) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `browser` char(100) NOT NULL,
  `platform` char(100) NOT NULL,
  `ip_address` char(100) NOT NULL,
  PRIMARY KEY (`_id`),
  KEY `tb_login_history_user_id_foreign` (`user_id`),
  CONSTRAINT `tb_login_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_login_history: ~29 rows (approximately)
INSERT INTO `tb_login_history` (`_id`, `user_id`, `timestamp`, `browser`, `platform`, `ip_address`) VALUES
	(1, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-26 22:19:02', 'Firefox 137.0', 'Windows 10', '::1'),
	(2, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 11:34:21', 'Firefox 137.0', 'Windows 10', '::1'),
	(3, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 11:57:27', 'Firefox 137.0', 'Windows 10', '::1'),
	(4, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 14:18:06', 'Firefox 137.0', 'Windows 10', '::1'),
	(5, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 14:19:42', 'Firefox 137.0', 'Windows 10', '::1'),
	(6, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 14:30:52', 'Firefox 137.0', 'Windows 10', '::1'),
	(7, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 14:31:10', 'Firefox 137.0', 'Windows 10', '::1'),
	(8, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 15:52:35', 'Firefox 137.0', 'Windows 10', '::1'),
	(9, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 15:52:52', 'Firefox 137.0', 'Windows 10', '::1'),
	(10, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 16:08:58', 'Firefox 137.0', 'Windows 10', '::1'),
	(11, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 16:18:29', 'Firefox 137.0', 'Windows 10', '::1'),
	(12, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 16:18:44', 'Firefox 137.0', 'Windows 10', '::1'),
	(13, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 16:19:33', 'Firefox 137.0', 'Windows 10', '::1'),
	(14, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 16:19:48', 'Firefox 137.0', 'Windows 10', '::1'),
	(15, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-27 22:00:14', 'Firefox 137.0', 'Windows 10', '::1'),
	(16, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-28 21:20:44', 'Firefox 137.0', 'Windows 10', '::1'),
	(17, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-29 21:26:59', 'Firefox 137.0', 'Windows 10', '::1'),
	(18, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-04-29 23:36:11', 'Firefox 137.0', 'Windows 10', '::1'),
	(19, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-05-01 08:37:47', 'Firefox 138.0', 'Windows 10', '::1'),
	(20, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-05-01 15:20:12', 'Firefox 138.0', 'Windows 10', '::1'),
	(21, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-05-01 15:21:49', 'Firefox 138.0', 'Windows 10', '::1'),
	(22, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-05-04 09:08:10', 'Firefox 138.0', 'Windows 10', '::1'),
	(23, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-05-04 11:28:57', 'Firefox 138.0', 'Windows 10', '::1'),
	(24, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-05-04 11:30:01', 'Firefox 138.0', 'Windows 10', '::1'),
	(25, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-05-04 13:53:30', 'Firefox 138.0', 'Windows 10', '::1'),
	(26, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-05-05 09:07:42', 'Firefox 138.0', 'Windows 10', '::1'),
	(27, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-05-06 22:25:22', 'Firefox 138.0', 'Windows 10', '::1'),
	(28, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-05-07 21:07:59', 'Firefox 138.0', 'Windows 10', '::1'),
	(29, '63f21de1-a6db-48fc-a06d-90b1efdfd55c', '2025-05-07 21:47:08', 'Firefox 138.0', 'Windows 10', '::1');

-- Dumping structure for table db_apl_bps.tb_logs
CREATE TABLE IF NOT EXISTS `tb_logs` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_type` char(100) NOT NULL,
  `log_content` char(255) NOT NULL,
  `datetime` datetime DEFAULT current_timestamp(),
  `log_level` tinyint(4) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_logs: ~69 rows (approximately)
INSERT INTO `tb_logs` (`log_id`, `log_type`, `log_content`, `datetime`, `log_level`) VALUES
	(1, 'access', 'User administrator logged from IP ::1', '2025-04-26 22:19:02', 1),
	(2, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 11:33:47', 1),
	(3, 'access', 'User administrator logged from IP ::1', '2025-04-27 11:34:21', 1),
	(4, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 11:34:26', 1),
	(5, 'access', 'User administrator logged from IP ::1', '2025-04-27 11:57:28', 1),
	(6, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 14:17:59', 1),
	(7, 'access', 'User administrator logged from IP ::1', '2025-04-27 14:18:06', 1),
	(8, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 14:19:35', 1),
	(9, 'access', 'User administrator logged from IP ::1', '2025-04-27 14:19:42', 1),
	(10, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 14:23:10', 1),
	(11, 'access', 'User administrator logged from IP ::1', '2025-04-27 14:30:52', 1),
	(12, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 14:31:00', 1),
	(13, 'access', 'User administrator logged from IP ::1', '2025-04-27 14:31:10', 1),
	(14, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 15:52:24', 1),
	(15, 'access', 'User administrator logged from IP ::1', '2025-04-27 15:52:35', 1),
	(16, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 15:52:40', 1),
	(17, 'access', 'User administrator logged from IP ::1', '2025-04-27 15:52:52', 1),
	(18, 'access', 'User administrator logged from IP ::1', '2025-04-27 16:08:58', 1),
	(19, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 16:18:21', 1),
	(20, 'access', 'User administrator logged from IP ::1', '2025-04-27 16:18:29', 1),
	(21, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 16:18:39', 1),
	(22, 'access', 'User administrator logged from IP ::1', '2025-04-27 16:18:44', 1),
	(23, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 16:19:27', 1),
	(24, 'access', 'User administrator logged from IP ::1', '2025-04-27 16:19:33', 1),
	(25, 'access', 'User Administrator was logout from IP ::1', '2025-04-27 16:19:42', 1),
	(26, 'access', 'User administrator logged from IP ::1', '2025-04-27 16:19:48', 1),
	(27, 'account', 'User account administrator was modified by administrator', '2025-04-27 16:53:22', 3),
	(28, 'account', 'User account username was created by administrator', '2025-04-27 16:53:51', 3),
	(29, 'account', 'Account username was deleted by administrator', '2025-04-27 16:53:55', 3),
	(30, 'user_group', 'User group Testing was added by administrator', '2025-04-27 17:19:13', 3),
	(31, 'user_group', 'User group Testing was added by administrator', '2025-04-27 17:21:42', 3),
	(32, 'user_group', 'User group tes was added by administrator', '2025-04-27 17:23:55', 3),
	(33, 'user_group', 'User group asasas was added by administrator', '2025-04-27 17:26:27', 3),
	(34, 'user_group', 'User group asdasd was added by administrator', '2025-04-27 17:27:41', 3),
	(35, 'user_group', 'User group user was added by administrator', '2025-04-27 17:32:48', 3),
	(36, 'user_group', 'User group user1 was added by administrator', '2025-04-27 17:35:17', 3),
	(37, 'user_group', 'User group user was deleted by administrator', '2025-04-27 17:35:23', 3),
	(38, 'user_group', 'User group user1 was deleted by administrator', '2025-04-27 17:35:26', 3),
	(39, 'access', 'User administrator logged from IP ::1', '2025-04-27 22:00:14', 1),
	(40, 'access', 'User administrator logged from IP ::1', '2025-04-28 21:20:44', 1),
	(41, 'account', 'User account administrator was modified by administrator', '2025-04-28 21:26:39', 3),
	(42, 'account', 'User account administrator was modified by administrator', '2025-04-28 21:33:17', 3),
	(43, 'account', 'User account tes was created by administrator', '2025-04-28 22:00:30', 3),
	(44, 'account', 'User account tes was modified by administrator', '2025-04-28 22:00:51', 3),
	(45, 'account', 'Account tes was deleted by administrator', '2025-04-28 22:05:29', 3),
	(46, 'settings', 'Organization settings has been change by administrator', '2025-04-28 22:21:49', 1),
	(47, 'settings', 'Site settings has been change by administrator', '2025-04-28 22:44:48', 1),
	(48, 'access', 'User administrator logged from IP ::1', '2025-04-29 21:26:59', 1),
	(49, 'user_group', 'User group administrator was changed by administrator', '2025-04-29 23:24:14', 3),
	(50, 'user_group', 'User group administrator was changed by administrator', '2025-04-29 23:25:06', 3),
	(51, 'access', 'User ADMINISTRATOR was logout from IP ::1', '2025-04-29 23:36:06', 1),
	(52, 'access', 'User administrator logged from IP ::1', '2025-04-29 23:36:11', 1),
	(53, 'access', 'User administrator logged from IP ::1', '2025-05-01 08:37:47', 1),
	(54, 'access', 'User ADMINISTRATOR was logout from IP ::1', '2025-05-01 15:20:03', 1),
	(55, 'access', 'User administrator logged from IP ::1', '2025-05-01 15:20:12', 1),
	(56, 'user_group', 'User group administrator was changed by administrator', '2025-05-01 15:20:58', 3),
	(57, 'access', 'User ADMINISTRATOR was logout from IP ::1', '2025-05-01 15:21:03', 1),
	(58, 'access', 'User administrator logged from IP ::1', '2025-05-01 15:21:49', 1),
	(59, 'access', 'User administrator logged from IP ::1', '2025-05-04 09:08:10', 1),
	(60, 'access', 'User administrator logged from IP ::1', '2025-05-04 11:28:57', 1),
	(61, 'access', 'User administrator logged from IP ::1', '2025-05-04 11:30:01', 1),
	(62, 'access', 'User administrator logged from IP ::1', '2025-05-04 13:53:30', 1),
	(63, 'access', 'User administrator logged from IP ::1', '2025-05-05 09:07:42', 1),
	(64, 'access', 'User administrator logged from IP ::1', '2025-05-06 22:25:22', 1),
	(65, 'dokumen', 'Dokumen 23beff51-938f-4717-822a-8d8881d0b4c8 dihapus oleh administrator', '2025-05-06 22:38:09', 1),
	(66, 'file', 'File 01969e41-de05-709d-8533-b8083e3a0761 dihapus oleh administrator', '2025-05-06 22:57:52', 1),
	(67, 'file', 'File 01969e41-9218-725a-a889-da33da202636 dihapus oleh administrator', '2025-05-06 22:58:45', 1),
	(68, 'file', 'File 01969c60-74a7-70a9-92a7-5d0e6f085555 dihapus oleh administrator', '2025-05-06 23:01:16', 1),
	(69, 'access', 'User administrator logged from IP ::1', '2025-05-07 21:07:59', 1),
	(70, 'user_group', 'User group administrator was changed by administrator', '2025-05-07 21:46:53', 3),
	(71, 'access', 'User ADMINISTRATOR was logout from IP ::1', '2025-05-07 21:47:05', 1),
	(72, 'access', 'User administrator logged from IP ::1', '2025-05-07 21:47:08', 1),
	(73, 'dokumen', 'Dokumen 0196ab3b-6c92-72ac-ad7f-08eb9b36f9b6 dihapus oleh administrator', '2025-05-07 21:58:03', 1),
	(74, 'dokumen', 'Dokumen 0196ab41-7c61-73a1-973a-3578a2f7a81a dihapus oleh administrator', '2025-05-07 22:10:43', 1);

-- Dumping structure for table db_apl_bps.tb_menus
CREATE TABLE IF NOT EXISTS `tb_menus` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_label` char(100) NOT NULL,
  `menu_slug` char(255) NOT NULL,
  `menu_icon` char(100) NOT NULL,
  `menu_group` char(50) NOT NULL,
  `menu_mode` enum('r','w') NOT NULL,
  `menu_sequence` tinyint(4) DEFAULT NULL,
  `menu_location` enum('mainmenu','submenu','btnmenu') NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_menus: ~27 rows (approximately)
INSERT INTO `tb_menus` (`menu_id`, `menu_label`, `menu_slug`, `menu_icon`, `menu_group`, `menu_mode`, `menu_sequence`, `menu_location`) VALUES
	(1, 'Dasbor', 'dasbor', 'fas fa-home', 'dasbor', 'r', 1, 'mainmenu'),
	(2, 'Data Master', '#', 'fas fa-database', 'data-master', 'r', 2, 'mainmenu'),
	(3, 'Kelola Kategori', 'kategori', 'fas fa-folder', 'data-master', 'r', 1, 'submenu'),
	(4, 'Simpan Kategori', 'kategori/simpan', 'fas fa-save', 'data-master', 'w', NULL, 'btnmenu'),
	(5, 'Hapus Kategori', 'kategori/hapus', 'fas fa-trash-alt', 'data-master', 'w', NULL, 'btnmenu'),
	(6, 'Kelola Akun', 'akun', 'fas fa-users-cog', 'data-master', 'r', 2, 'submenu'),
	(7, 'Hapus Akun', 'akun/hapus', 'fas fa-trash-alt', 'data-master', 'w', NULL, 'btnmenu'),
	(8, 'Simpan Akun', 'akun/simpan', 'fas fa-save', 'data-master', 'w', NULL, 'btnmenu'),
	(10, 'Kelola Grup', 'grup', 'fas fa-layer-group', 'data-master', 'r', 3, 'submenu'),
	(11, 'Simpan Grup', 'grup/simpan', 'fas fa-save', 'data-master', 'w', NULL, 'btnmenu'),
	(12, 'Hapus Grup', 'grup/hapus', 'fas fa-trash-alt', 'data-master', 'w', NULL, 'btnmenu'),
	(13, 'App Logs', 'logs', 'fas fa-scroll', 'logs', 'r', 3, 'mainmenu'),
	(14, 'Sub Bagian Umum', 'dokumen/subbagumum', 'fas fa-file-alt', 'content', 'r', 4, 'mainmenu'),
	(15, 'Statistik Sosial', 'dokumen/statsos', 'fas fa-file-alt', 'content', 'r', 5, 'mainmenu'),
	(16, 'Statistik Produksi', 'dokumen/statprod', 'fas fa-file-alt', 'content', 'r', 6, 'mainmenu'),
	(17, 'Statistik Distribusi', 'dokumen/statdist', 'fas fa-file-alt', 'content', 'r', 7, 'mainmenu'),
	(18, 'Nerwilis', 'dokumen/nerwilis', 'fas fa-file-alt', 'content', 'r', 8, 'mainmenu'),
	(19, 'IPDS', 'dokumen/ipds', 'fas fa-file-alt', 'content', 'r', 9, 'mainmenu'),
	(20, 'Simpan Rincian Dokumen', 'simpan-dokumen', 'fas fa-file-upload', 'content', 'w', NULL, 'btnmenu'),
	(21, 'Hapus Dokumen', 'hapus-dokumen', 'fas fa-trash-alt', 'content', 'w', NULL, 'btnmenu'),
	(22, 'Pengaturan', '#', 'fas fa-cogs', 'settings', 'r', 10, 'mainmenu'),
	(23, 'Pengaturan Organisasi', 'pengaturan-organisasi', 'fas fa-sitemap', 'settings', 'r', 1, 'submenu'),
	(24, 'Pengaturan Aplikasi', 'pengaturan-aplikasi', 'fas fa-globe', 'settings', 'r', 2, 'submenu'),
	(25, 'Simpan Pengaturan Organisasi', 'pengaturan-organisasi/simpan', 'fas fa-save', 'settings', 'w', NULL, 'btnmenu'),
	(26, 'Simpan Pengaturan Aplikasi', 'pengaturan-aplikasi/simpan', 'fas fa-save', 'settings', 'w', NULL, 'btnmenu'),
	(28, 'Unggah File', 'file/simpan', 'fas fa-file-upload', 'content', 'w', NULL, 'btnmenu'),
	(29, 'Hapus File', 'file/hapus', 'fas fa-trash-alt', 'content', 'w', NULL, 'btnmenu');

-- Dumping structure for table db_apl_bps.tb_navigations
CREATE TABLE IF NOT EXISTS `tb_navigations` (
  `nav_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(128) NOT NULL,
  `nav_name` char(150) NOT NULL,
  `nav_slug` char(150) NOT NULL,
  `nav_sequence` tinyint(3) unsigned NOT NULL,
  `nav_parent` smallint(5) unsigned NOT NULL,
  `custom_link` char(150) DEFAULT NULL,
  `open_newtab` tinyint(1) NOT NULL,
  `nav_position` enum('top','bottom') NOT NULL,
  `nav_description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`nav_id`),
  KEY `tb_navigations_user_id_foreign` (`user_id`),
  CONSTRAINT `tb_navigations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_navigations: ~0 rows (approximately)

-- Dumping structure for table db_apl_bps.tb_org_settings
CREATE TABLE IF NOT EXISTS `tb_org_settings` (
  `org_id` char(128) NOT NULL,
  `org_name` char(255) NOT NULL,
  `org_profile` text DEFAULT NULL,
  `org_slogan` text DEFAULT NULL,
  `org_vision` varchar(300) DEFAULT NULL,
  `org_missions` text DEFAULT NULL,
  `org_phone` char(16) DEFAULT NULL,
  `org_address` char(255) DEFAULT NULL,
  `org_social_media` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`org_social_media`)),
  `org_map` text DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`org_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_org_settings: ~0 rows (approximately)
INSERT INTO `tb_org_settings` (`org_id`, `org_name`, `org_profile`, `org_slogan`, `org_vision`, `org_missions`, `org_phone`, `org_address`, `org_social_media`, `org_map`, `updated_at`) VALUES
	('4df0b820-5eb8-4d04-9eb4-ee17250f449c', 'Badan Pusat Statistik', '<p>Badan Pusat Statistik adalah Lembaga Pemerintah Nonkementerian yang bertanggung jawab langsung kepada Presiden. Sebelumnya, BPS merupakan Biro Pusat Statistik, yang dibentuk berdasarkan UU Nomor 6 Tahun 1960 tentang Sensus dan UU Nomor 7 Tahun 1960 tentang Statistik.</p>\r\n', '-', '<p>Penyedia Data Statistik Berkualitas untuk Indonesia Maju</p>\r\n', '<p>Menyediakan statistik berkualitas yang berstandar nasional dan internasional</p>\r\n\r\n<p>Membina K/L/D/I melalui Sistem Statistik Nasional yang berkesinambungan</p>\r\n\r\n<p>Mewujudkan pelayanan prima di bidang statistik untuk terwujudnya Sistem Statistik Nasional</p>\r\n\r\n<p>Membangun SDM yang unggul dan adaptif berlandaskan nilai profesionalisme, integritas dan amanah</p>\r\n', '0213857046', 'Gedung 2 Lantai 1 (Kepala Biro Humas dan Hukum Badan Pusat Statistik) Jln. Dr. Sutomo 6-8, Jakarta Pusat 10710', '{"instagram":"https:\\/\\/www.instagram.com\\/bps_statistics\\/","facebook":"https:\\/\\/www.facebook.com\\/bpsstatistics","linkedin":"","twitter":"https:\\/\\/twitter.com\\/bps_statistic","email":"ppid@bps.go.id"}', '', '2025-04-28 22:21:49');

-- Dumping structure for table db_apl_bps.tb_site_settings
CREATE TABLE IF NOT EXISTS `tb_site_settings` (
  `site_id` char(128) NOT NULL,
  `site_name` char(255) NOT NULL,
  `site_name_alt` char(100) NOT NULL,
  `site_keywords` varchar(255) DEFAULT NULL,
  `site_description` varchar(500) NOT NULL,
  `site_author` char(100) NOT NULL,
  `site_logo` char(255) NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_site_settings: ~0 rows (approximately)
INSERT INTO `tb_site_settings` (`site_id`, `site_name`, `site_name_alt`, `site_keywords`, `site_description`, `site_author`, `site_logo`, `updated_at`) VALUES
	('bbbe94bc-b54a-4e40-881b-9a027db10c65', 'Big Data BPS', 'BPS', 'bps,repositori,file', 'Repositori Big Data Badan Pusat Statistik', 'Muhammad Ridwan Na\'im', 'logo.png', '2025-04-28 22:44:48');

-- Dumping structure for table db_apl_bps.tb_users
CREATE TABLE IF NOT EXISTS `tb_users` (
  `user_id` char(128) NOT NULL,
  `group_id` char(128) NOT NULL,
  `user_realname` char(100) NOT NULL,
  `user_name` char(100) NOT NULL,
  `user_password` varchar(512) NOT NULL,
  `user_email` char(100) NOT NULL,
  `user_picture` varchar(512) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`),
  KEY `tb_users_group_id_foreign` (`group_id`),
  CONSTRAINT `tb_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `tb_user_groups` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_users: ~2 rows (approximately)
INSERT INTO `tb_users` (`user_id`, `group_id`, `user_realname`, `user_name`, `user_password`, `user_email`, `user_picture`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
	('85ba43e2-234d-11f0-abea-00ff2947cc94', '4cfb12f4-fb34-435b-b198-e56ac0bf5c81', 'USER', 'username', '$argon2id$v=19$m=65536,t=8,p=10$UGgvbE5lamVpRmcwL3R0Yg$LLRKs7ISEmnh9hi+e7wq891hmQaawwrm4LVtylFdRKg', 'user@bps.go.id', 'user.png', 0, '2025-04-27 16:53:51', NULL, '2025-04-27 16:53:55'),
	('63f21de1-a6db-48fc-a06d-90b1efdfd55c', '4cfb12f4-fb34-435b-b198-e56ac0bf5c81', 'ADMINISTRATOR', 'administrator', '$argon2id$v=19$m=65536,t=8,p=10$T0lIcmdld1NnY01DQWlyLw$t48Kv2N5oZV/r/EeeccK7dhyid6Obbe2Nbo5CpFuCtY', 'admin@bps.go.id', '1745936857_b5dd5a14e76791450437.jpg', 1, '2025-04-26 21:22:02', NULL, NULL);

-- Dumping structure for table db_apl_bps.tb_user_groups
CREATE TABLE IF NOT EXISTS `tb_user_groups` (
  `group_id` char(128) NOT NULL,
  `group_name` char(255) NOT NULL,
  `index_page` char(80) DEFAULT NULL,
  `read_mode` enum('r','rw') NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '0',
  `fm_create` tinyint(1) DEFAULT 0,
  `fm_rename` tinyint(1) DEFAULT 0,
  `fm_delete` tinyint(1) DEFAULT 0,
  `post_publish` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_user_groups: ~1 rows (approximately)
INSERT INTO `tb_user_groups` (`group_id`, `group_name`, `index_page`, `read_mode`, `roles`, `fm_create`, `fm_rename`, `fm_delete`, `post_publish`) VALUES
	('4cfb12f4-fb34-435b-b198-e56ac0bf5c81', 'administrator', 'akun', 'rw', '{"mainmenu":[{"menu_id":"13","menu_label":"App Logs","menu_slug":"logs","menu_icon":"fas fa-scroll","menu_group":"logs","menu_mode":"r","menu_sequence":"3","menu_location":"mainmenu"},{"menu_id":"1","menu_label":"Dasbor","menu_slug":"dasbor","menu_icon":"fas fa-home","menu_group":"dasbor","menu_mode":"r","menu_sequence":"1","menu_location":"mainmenu"},{"menu_id":"2","menu_label":"Data Master","menu_slug":"#","menu_icon":"fas fa-database","menu_group":"data-master","menu_mode":"r","menu_sequence":"2","menu_location":"mainmenu"},{"menu_id":"22","menu_label":"Pengaturan","menu_slug":"#","menu_icon":"fas fa-cogs","menu_group":"settings","menu_mode":"r","menu_sequence":"10","menu_location":"mainmenu"},{"menu_id":"14","menu_label":"Sub Bagian Umum","menu_slug":"dokumen\\/subbagumum","menu_icon":"fas fa-file-alt","menu_group":"content","menu_mode":"r","menu_sequence":"4","menu_location":"mainmenu"},{"menu_id":"15","menu_label":"Statistik Sosial","menu_slug":"dokumen\\/statsos","menu_icon":"fas fa-file-alt","menu_group":"content","menu_mode":"r","menu_sequence":"5","menu_location":"mainmenu"},{"menu_id":"16","menu_label":"Statistik Produksi","menu_slug":"dokumen\\/statprod","menu_icon":"fas fa-file-alt","menu_group":"content","menu_mode":"r","menu_sequence":"6","menu_location":"mainmenu"},{"menu_id":"17","menu_label":"Statistik Distribusi","menu_slug":"dokumen\\/statdist","menu_icon":"fas fa-file-alt","menu_group":"content","menu_mode":"r","menu_sequence":"7","menu_location":"mainmenu"},{"menu_id":"18","menu_label":"Nerwilis","menu_slug":"dokumen\\/nerwilis","menu_icon":"fas fa-file-alt","menu_group":"content","menu_mode":"r","menu_sequence":"8","menu_location":"mainmenu"},{"menu_id":"19","menu_label":"IPDS","menu_slug":"dokumen\\/ipds","menu_icon":"fas fa-file-alt","menu_group":"content","menu_mode":"r","menu_sequence":"9","menu_location":"mainmenu"}],"submenu":[{"menu_id":"3","menu_label":"Kelola Kategori","menu_slug":"kategori","menu_icon":"fas fa-folder","menu_group":"data-master","menu_mode":"r","menu_sequence":"1","menu_location":"submenu"},{"menu_id":"6","menu_label":"Kelola Akun","menu_slug":"akun","menu_icon":"fas fa-users-cog","menu_group":"data-master","menu_mode":"r","menu_sequence":"2","menu_location":"submenu"},{"menu_id":"10","menu_label":"Kelola Grup","menu_slug":"grup","menu_icon":"fas fa-layer-group","menu_group":"data-master","menu_mode":"r","menu_sequence":"3","menu_location":"submenu"},{"menu_id":"23","menu_label":"Pengaturan Organisasi","menu_slug":"pengaturan-organisasi","menu_icon":"fas fa-sitemap","menu_group":"settings","menu_mode":"r","menu_sequence":"1","menu_location":"submenu"},{"menu_id":"24","menu_label":"Pengaturan Aplikasi","menu_slug":"pengaturan-aplikasi","menu_icon":"fas fa-globe","menu_group":"settings","menu_mode":"r","menu_sequence":"2","menu_location":"submenu"}],"btnmenu":[{"menu_id":"4","menu_label":"Simpan Kategori","menu_slug":"kategori\\/simpan","menu_icon":"fas fa-save","menu_group":"data-master","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"},{"menu_id":"5","menu_label":"Hapus Kategori","menu_slug":"kategori\\/hapus","menu_icon":"fas fa-trash-alt","menu_group":"data-master","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"},{"menu_id":"7","menu_label":"Hapus Akun","menu_slug":"akun\\/hapus","menu_icon":"fas fa-trash-alt","menu_group":"data-master","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"},{"menu_id":"8","menu_label":"Simpan Akun","menu_slug":"akun\\/simpan","menu_icon":"fas fa-save","menu_group":"data-master","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"},{"menu_id":"11","menu_label":"Simpan Grup","menu_slug":"grup\\/simpan","menu_icon":"fas fa-save","menu_group":"data-master","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"},{"menu_id":"12","menu_label":"Hapus Grup","menu_slug":"grup\\/hapus","menu_icon":"fas fa-trash-alt","menu_group":"data-master","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"},{"menu_id":"25","menu_label":"Simpan Pengaturan Organisasi","menu_slug":"pengaturan-organisasi\\/simpan","menu_icon":"fas fa-save","menu_group":"settings","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"},{"menu_id":"26","menu_label":"Simpan Pengaturan Aplikasi","menu_slug":"pengaturan-aplikasi\\/simpan","menu_icon":"fas fa-save","menu_group":"settings","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"},{"menu_id":"20","menu_label":"Simpan Rincian Dokumen","menu_slug":"simpan-dokumen","menu_icon":"fas fa-file-upload","menu_group":"content","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"},{"menu_id":"21","menu_label":"Hapus Dokumen","menu_slug":"hapus-dokumen","menu_icon":"fas fa-trash-alt","menu_group":"content","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"},{"menu_id":"28","menu_label":"Unggah File","menu_slug":"file\\/simpan","menu_icon":"fas fa-file-upload","menu_group":"content","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"},{"menu_id":"29","menu_label":"Hapus File","menu_slug":"file\\/hapus","menu_icon":"fas fa-trash-alt","menu_group":"content","menu_mode":"w","menu_sequence":null,"menu_location":"btnmenu"}]}', 1, 1, 1, 1);

-- Dumping structure for table db_apl_bps.tb_visitors
CREATE TABLE IF NOT EXISTS `tb_visitors` (
  `_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `last_counter` date DEFAULT curdate(),
  `referred` text DEFAULT NULL,
  `agent` varchar(255) NOT NULL,
  `platform` varchar(255) NOT NULL,
  `UAString` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `location` char(10) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_apl_bps.tb_visitors: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
