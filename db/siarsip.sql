-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `siarsip`;
CREATE DATABASE `siarsip` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `siarsip`;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `boxes`;
CREATE TABLE `boxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shelf_id` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `records`;
CREATE TABLE `records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_id` tinyint(4) NOT NULL,
  `category_id` tinyint(4) NOT NULL,
  `date` date DEFAULT NULL,
  `period` year(4) NOT NULL,
  `quantity` tinyint(4) NOT NULL,
  `progress` text COLLATE utf8mb4_unicode_ci,
  `descriptions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `record_categories`;
CREATE TABLE `record_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(4) NOT NULL,
  `code` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `record_categories` (`id`, `parent_id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 0,  'KK', 'Keprotokolan dan Kerumahtanggan Presiden dan wakil Presiden',  '2017-08-10 04:20:09',  '2017-08-10 04:59:23'),
(2, 1,  'KK-00',  'Audiensi', '2017-08-21 16:00:53',  '2017-08-24 12:25:06'),
(3, 2,  'KK-00-00', 'Presiden', '2017-08-24 12:25:23',  '2017-08-24 12:25:23'),
(4, 2,  'KK-00-01', 'Wakil Presiden', '2017-08-24 12:25:38',  '2017-08-24 12:25:38'),
(5, 2,  'KK-00-02', 'Istri/Suami Presiden dan Wakil Presiden',  '2017-08-24 12:26:11',  '2017-08-24 12:26:11'),
(6, 1,  'KK-01',  'Kunjungan Dalam Negeri', '2017-08-24 12:26:39',  '2017-08-24 12:26:39'),
(7, 6,  'KK-01-00', 'Presiden', '2017-08-24 12:26:53',  '2017-08-24 12:26:53'),
(8, 6,  'KK-01-01', 'Wakil Presiden', '2017-08-24 12:27:13',  '2017-08-24 12:27:13'),
(9, 6,  'KK-01-02', 'Istri/Suami Presiden dan Wakil Presiden',  '2017-08-24 12:56:51',  '2017-08-24 12:56:51'),
(10,  1,  'KK-02',  'Kunjungan Luar Negeri',  '2017-08-24 12:57:12',  '2017-08-24 12:57:12'),
(11,  10, 'KK-02-00', 'Presiden', '2017-08-24 12:57:25',  '2017-08-24 12:57:25'),
(12,  10, 'KK-02-01', 'Wakil Presiden', '2017-08-24 12:57:45',  '2017-08-24 12:57:45'),
(13,  10, 'KK-02-02', 'Istri/Suami Presiden dan Wakil Presiden',  '2017-08-24 12:58:20',  '2017-08-24 12:58:20'),
(14,  1,  'KK-03',  'Kunjungan Tamu Negara',  '2017-08-24 13:04:26',  '2017-08-24 13:04:26'),
(15,  1,  'KK-04',  'Peresmian/Penutupan Sidang/Rapat Kerja/Pertemuan dan Proyek',  '2017-08-24 13:05:13',  '2017-08-24 13:05:13'),
(16,  1,  'KK-05',  'Pelantikan', '2017-08-24 13:05:28',  '2017-08-24 13:05:28'),
(17,  15, 'KK-04-00', 'Presiden', '2017-08-24 13:05:58',  '2017-08-24 13:05:58'),
(18,  0,  'PI', 'Pengelolaan Istana - Istana Kepresidenan', '2017-08-24 13:07:35',  '2017-08-24 14:23:55'),
(19,  0,  'MI', 'Pelayanan Pers, Media, dan Informasi Presiden dan Wakli Presiden', '2017-08-24 13:08:25',  '2017-08-24 13:08:25'),
(20,  0,  'KI', 'Kebijakan Keuangan, Investasi, dan Badan Usaha', '2017-08-24 13:08:57',  '2017-08-24 13:08:57'),
(21,  0,  'IE', 'Infrastruktur, Energi, dan Tata Ruang',  '2017-08-24 13:09:30',  '2017-08-24 13:09:30'),
(22,  0,  'KH', 'Ketahanan Pangan dan Sumber Daya Hayati',  '2017-08-24 13:09:54',  '2017-08-24 13:09:54'),
(23,  0,  'IP', 'Industri, Perdagangan, Pariwisata, dan Ekonomi Kreatif', '2017-08-24 13:10:20',  '2017-08-24 13:10:20'),
(24,  0,  'SM', 'Pembangunan Sumber Daya Manusia',  '2017-08-24 13:10:40',  '2017-08-24 13:10:40'),
(25,  0,  'SB', 'Perlindungan Sosial dan Pengembangan Kesejahteraan', '2017-08-24 13:11:11',  '2017-08-24 13:11:11'),
(26,  0,  'PH', 'Politik, Hukum, dan Keamanan', '2017-08-24 13:11:29',  '2017-08-24 13:11:29'),
(27,  0,  'HI', 'Hubungan Luar Negeri', '2017-08-24 13:15:21',  '2017-08-24 13:15:21'),
(28,  0,  'RF', 'Reformasi Birokrasi dan Pelayanan Publik', '2017-08-24 13:15:45',  '2017-08-24 13:15:45'),
(29,  0,  'PP', 'Pengawasan Penyelenggaraan Pemerintah',  '2017-08-24 13:16:11',  '2017-08-24 13:16:11'),
(30,  0,  'AM', 'Administrasi Militer', '2017-08-24 13:16:23',  '2017-08-24 13:17:31'),
(31,  0,  'PM', 'Pengamanan', '2017-08-24 13:17:39',  '2017-08-24 13:17:39'),
(32,  0,  'GT', 'Gelar, Tanda Jasa, dan Tanda Kehormatan',  '2017-08-24 13:17:59',  '2017-08-24 13:17:59'),
(33,  0,  'HK', 'Hukum dan Peraturan Perundang - Undangan', '2017-08-24 13:18:22',  '2017-08-24 13:18:22'),
(34,  0,  'HL', 'Hubungan Kelembagaan', '2017-08-24 13:18:38',  '2017-08-24 13:18:38'),
(35,  0,  'HM', 'Kehumasan',  '2017-08-24 13:18:45',  '2017-08-24 13:18:45'),
(36,  0,  'SR', 'Sambung Rasa', '2017-08-24 13:18:57',  '2017-08-24 13:18:57'),
(37,  0,  'DM', 'Pengaduan Masyarakat', '2017-08-24 13:19:08',  '2017-08-24 13:19:08'),
(38,  0,  'AN', 'Administrasi Pejabat Negara',  '2017-08-24 13:19:23',  '2017-08-24 13:19:23'),
(39,  0,  'AP', 'Administrasi Pejabat Pemerintah',  '2017-08-24 13:19:39',  '2017-08-24 13:19:39'),
(40,  0,  'LN', 'Kerjasama Teknik Luar Negeri', '2017-08-24 13:20:02',  '2017-08-24 13:20:02'),
(41,  0,  'PR', 'Perencanaan',  '2017-08-24 13:20:12',  '2017-08-24 13:20:12'),
(42,  0,  'KU', 'Keuangan', '2017-08-24 13:20:21',  '2017-08-24 13:20:21'),
(43,  0,  'TU', 'Ketatausahaan',  '2017-08-24 13:20:30',  '2017-08-24 13:20:30'),
(44,  0,  'KA', 'Kearsipan',  '2017-08-24 13:20:38',  '2017-08-24 13:20:38'),
(45,  0,  'PS', 'Kepustakaan',  '2017-08-24 13:20:49',  '2017-08-24 13:20:49'),
(46,  0,  'IT', 'Informasi dan teknologi',  '2017-08-24 13:20:59',  '2017-08-24 13:20:59'),
(47,  0,  'PL', 'Perlengkapan', '2017-08-24 13:21:09',  '2017-08-24 13:21:09'),
(48,  0,  'PK', 'Pengelolaan Kendaraan (Menteri, Ketua/Wakil Ketua Lembaga Negara, dan Pejabat Setingkat Menteri)', '2017-08-24 13:22:16',  '2017-08-24 13:22:16'),
(49,  0,  'PB', 'Pengelolaan Barang Milik Negara',  '2017-08-24 13:22:43',  '2017-08-24 13:22:43'),
(50,  0,  'KP', 'Kepegawaian',  '2017-08-24 13:22:54',  '2017-08-24 13:22:54'),
(51,  0,  'OT', 'Organisasi dan Tata Laksana',  '2017-08-24 13:23:14',  '2017-08-24 13:23:14'),
(52,  0,  'AK', 'Akuntabilitas Kinerja',  '2017-08-24 13:23:26',  '2017-08-24 13:23:26'),
(53,  0,  'PW', 'Pengawasan', '2017-08-24 13:23:38',  '2017-08-24 13:23:38'),
(54,  0,  'PD', 'Pendidikan dan Pelatihan', '2017-08-24 13:23:53',  '2017-08-24 13:23:53'),
(55,  1,  'KK-06',  'Penyerahan Surat -Surat Kepercayaan',  '2017-08-24 13:25:09',  '2017-08-24 13:25:09'),
(56,  1,  'KK-07',  'Upacara',  '2017-08-24 13:25:26',  '2017-08-24 13:25:26'),
(57,  1,  'KK-08',  'Kegiatan Penting Lainnya', '2017-08-24 13:28:31',  '2017-08-24 13:28:31'),
(58,  1,  'KK-09',  'Penggunaan VVIP/VIP Room Bandar Udara Soekarno-Hatta dan Halim Perdana Kusuma',  '2017-08-24 13:29:19',  '2017-08-24 13:29:19'),
(59,  1,  'KK-10',  'Pelayanan Upacara dan Rumah Tangga', '2017-08-24 13:29:41',  '2017-08-24 13:30:25'),
(60,  1,  'KK-11',  'Pelayanan Kendaraan Presiden, Wakil Presiden, dan Tamu Negara',  '2017-08-24 13:30:09',  '2017-08-24 13:30:39'),
(61,  1,  'KK-12',  'Pelayanan Sekretaris Pribadi/Ajudan/Keluarga', '2017-08-24 13:33:17',  '2017-08-24 13:33:17'),
(62,  1,  'KK-13',  'Pelayanan Dokter Kepresidenan',  '2017-08-24 13:33:44',  '2017-08-24 13:33:44'),
(63,  1,  'KK-14',  'Pengelolaan Dana Operasional, Bantuan, dan Dana Bantuan Kemasyarakatan', '2017-08-24 13:35:02',  '2017-08-24 13:35:02'),
(64,  15, 'KK-04-01', 'Wakil Presiden', '2017-08-24 13:36:01',  '2017-08-24 13:36:01'),
(65,  15, 'KK-04-02', 'Istri/Suami Presiden dan Wakil Presiden',  '2017-08-24 13:36:51',  '2017-08-24 13:36:51'),
(66,  56, 'KK-07-00', 'Upacara Kenegaraan', '2017-08-24 13:37:11',  '2017-08-24 13:37:11'),
(67,  56, 'KK-07-01', 'Upacara Resmi',  '2017-08-24 13:37:35',  '2017-08-24 13:37:35'),
(68,  58, 'KK-09-00', 'Presiden', '2017-08-24 13:38:05',  '2017-08-24 13:38:05'),
(69,  58, 'KK-09-01', 'Wakil Presiden', '2017-08-24 13:47:33',  '2017-08-24 13:47:33'),
(70,  58, 'KK-09-02', 'Pimpinan Lembaga Negara',  '2017-08-24 13:48:24',  '2017-08-24 13:48:24'),
(71,  58, 'KK-09-03', 'Tamu Negara',  '2017-08-24 13:50:05',  '2017-08-24 13:50:05'),
(72,  58, 'KK-09-05', 'Menteri/Pejabat Negara Setingkat Menteri/Kepala Lembaga Pemerintahan Nonkementerian',  '2017-08-24 13:50:56',  '2017-08-24 13:59:29'),
(73,  58, 'KK-09-04', 'Istri/Suami Presiden dan Wakil Presiden',  '2017-08-24 13:57:49',  '2017-08-24 13:57:49'),
(74,  58, 'KK-09-06', 'Duta Besar Negara Sahabat/Pejabat Diplomatik Setingkat Menteri', '2017-08-24 14:00:18',  '2017-08-24 14:00:18'),
(75,  58, 'KK-09-07', 'Gubernur DKI Jakarta dan Banten',  '2017-08-24 14:00:50',  '2017-08-24 14:00:58'),
(76,  58, 'KK-09-08', 'Mantan Presiden dan Wakil Presiden', '2017-08-24 14:01:26',  '2017-08-24 14:01:26'),
(77,  59, 'KK-10-00', 'Pelatihan Upacara',  '2017-08-24 14:01:57',  '2017-08-24 14:01:57'),
(78,  59, 'KK-10-01', 'Peralatan Rumah Tangga', '2017-08-24 14:02:37',  '2017-08-24 14:02:37'),
(79,  60, 'KK-11-00', 'Pengadaan',  '2017-08-24 14:05:37',  '2017-08-24 14:07:15'),
(80,  60, 'KK-11-01', 'Operasional',  '2017-08-24 14:08:06',  '2017-08-24 14:08:06'),
(81,  60, 'KK-11-02', 'Penarikan/Serah Terima Kendaraan', '2017-08-24 14:08:31',  '2017-08-24 14:08:31'),
(82,  60, 'KK-11-03', 'Perawatan/Pemeliharaan', '2017-08-24 14:08:53',  '2017-08-24 14:08:53'),
(83,  60, 'KK-11-04', 'Penghapusan',  '2017-08-24 14:09:03',  '2017-08-24 14:09:03'),
(84,  61, 'KK-12-00', 'Presiden', '2017-08-24 14:12:44',  '2017-08-24 14:12:44'),
(85,  61, 'KK-12-01', 'Wakil Presiden', '2017-08-24 14:13:33',  '2017-08-24 14:13:33'),
(86,  61, 'KK-12-02', 'Istri/Suami Presiden dan Wakil Presiden',  '2017-08-24 14:20:07',  '2017-08-24 14:20:07'),
(87,  61, 'KK-12-03', 'Keluarga Presiden dan Wakil Presiden', '2017-08-24 14:20:30',  '2017-08-24 14:20:30'),
(88,  62, 'KK-13-00', 'Presiden', '2017-08-24 14:20:53',  '2017-08-24 14:20:53'),
(89,  62, 'KK-13-01', 'Wakil Presiden', '2017-08-24 14:21:05',  '2017-08-24 14:21:05'),
(90,  62, 'KK-13-02', 'Istri/Suami Presiden dan Wakil Presiden',  '2017-08-24 14:21:22',  '2017-08-24 14:21:22'),
(91,  62, 'KK-13-03', 'Keluarga Presiden dan Wakil Presiden', '2017-08-24 14:21:38',  '2017-08-24 14:21:38'),
(92,  62, 'KK-13-04', 'Mantan Presiden dan Wakil Presiden', '2017-08-24 14:21:58',  '2017-08-24 14:21:58'),
(93,  62, 'KK-13-05', 'Tamu Negara yang Setingkat Kepala Negara/Kepala Pemerintahan', '2017-08-24 14:22:20',  '2017-08-24 14:22:20'),
(94,  63, 'KK-14-00', 'Presiden', '2017-08-24 14:22:46',  '2017-08-24 14:22:46'),
(95,  63, 'KK-14-01', 'Wakil Presiden', '2017-08-24 14:22:55',  '2017-08-24 14:22:55'),
(96,  18, 'PI-00',  'Pelayanan Kerumahtanggaan',  '2017-08-24 14:24:25',  '2017-08-24 14:24:25'),
(97,  18, 'PI-01',  'Kunjungan ke Istana - Istana Kepresidenan',  '2017-08-24 14:24:48',  '2017-08-24 14:24:48'),
(98,  18, 'PI-02',  'Dekorasi dan Benda Seni',  '2017-08-24 14:25:02',  '2017-08-24 14:25:02'),
(99,  18, 'PI-03',  'Monitoring Perkembangan Fisik Istana - Istana',  '2017-08-24 14:25:29',  '2017-08-24 14:25:29'),
(100, 18, 'PI-04',  'Pengelolaan Hewan Koleksi Istana', '2017-08-24 14:25:50',  '2017-08-24 14:25:50'),
(101, 18, 'PI-06',  'Pengelolaan Tanaman/Taman Istana', '2017-08-24 14:26:23',  '2017-08-24 14:26:23'),
(102, 18, 'PI-07',  'Pengelolaan Gudang, Wisma, dan Paviliun',  '2017-08-24 14:26:51',  '2017-08-24 14:26:51'),
(103, 18, 'PI-08',  'Pengelolaan Museum, Seni Budaya, dan Tata Graha',  '2017-08-24 14:27:15',  '2017-08-24 14:27:15'),
(104, 96, 'PI-00-00', 'Jamuan', '2017-08-24 14:27:36',  '2017-08-24 14:27:36'),
(105, 96, 'PI-00-01', 'Perbekalan', '2017-08-24 14:27:48',  '2017-08-24 14:27:48'),
(106, 96, 'PI-00-02', 'Linen',  '2017-08-24 14:28:00',  '2017-08-24 14:28:00'),
(107, 97, 'PI-01-00', 'Administrasi Kunjungan', '2017-08-24 14:28:38',  '2017-08-24 14:28:38'),
(108, 97, 'PI-01-01', 'Pelayanan Kunjungan',  '2017-08-24 14:28:55',  '2017-08-24 14:28:55'),
(109, 100,  'PI-04-00', 'Kelahiran',  '2017-08-24 14:29:41',  '2017-08-24 14:29:41'),
(110, 100,  'PI-04-01', 'Kematian', '2017-08-24 14:29:49',  '2017-08-24 14:29:49'),
(111, 100,  'PI-04-02', 'Distribusi', '2017-08-24 14:30:00',  '2017-08-24 14:30:00'),
(112, 100,  'PI-04-03', 'Penambahan', '2017-08-24 14:30:09',  '2017-08-24 14:30:09'),
(113, 100,  'PI-04-04', 'Pemeliharaan', '2017-08-24 14:30:17',  '2017-08-24 14:30:17'),
(114, 101,  'PI-06-00', 'Daftar Inventaris Tanaman',  '2017-08-24 14:31:22',  '2017-08-24 14:31:22'),
(115, 101,  'PI-06-01', 'Pemeliharaan Tanaman/Taman', '2017-08-24 14:31:36',  '2017-08-24 14:31:36'),
(116, 101,  'PI-06-02', 'Pengendalian Hama dan Nyamuk', '2017-08-24 14:31:59',  '2017-08-24 14:31:59');

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `sections`;
CREATE TABLE `sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `box_id` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `shelves`;
CREATE TABLE `shelves` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `username`, `role`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin',  'admin',  'admin',  'admin@siarsip.com',  '$2y$10$9iaQGJfUbluCyds5Gi.khOHdAyzoiVV7pbpSP6xKJSBMcUl/vrFui', 'gQtsthzgfXdtEksrCtJx0Fjks5h57ghFpHBiUp4zR7nAi8aMEpAsEl3Ws0sh', '2017-08-06 13:41:15',  '2017-08-06 13:41:15');


-- 2017-09-07 12:20:20
