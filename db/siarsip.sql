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

INSERT INTO `boxes` (`id`, `name`, `shelf_id`, `created_at`, `updated_at`) VALUES
(1,	'Box 1',	1,	'2017-08-07 03:38:26',	'2017-08-07 03:38:26'),
(2,	'Box 2',	1,	'2017-08-07 03:38:39',	'2017-08-07 03:38:39'),
(3,	'Box 1.1.1',	2,	'2017-08-07 03:38:49',	'2017-08-18 00:57:05'),
(4,	'Box 3',	3,	'2017-08-07 03:38:59',	'2017-08-18 00:56:49'),
(5,	'Box 6.1.1',	8,	'2017-08-15 19:31:43',	'2017-08-15 19:31:43');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6,	'2014_10_12_000000_create_users_table',	1),
(7,	'2014_10_12_100000_create_password_resets_table',	1),
(8,	'2017_08_05_052551_create_rooms_table',	1),
(10,	'2017_08_06_131718_create_boxes_table',	2),
(11,	'2017_08_07_031142_create_sections_table',	3),
(12,	'2017_08_07_031501_add_name_and_shelf_id_to_boxes_table',	4),
(13,	'2017_08_07_031904_add_name_and_shelf_id_to_sections_table',	4),
(14,	'2017_08_08_113449_create_item_categories_table',	5),
(15,	'2017_08_08_114101_create_shelves_table',	5),
(16,	'2017_08_16_024742_create_records_table',	6);

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
  `period` year(4) NOT NULL,
  `quantity` tinyint(4) NOT NULL,
  `progress` text COLLATE utf8mb4_unicode_ci,
  `descriptions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `records` (`id`, `name`, `section_id`, `category_id`, `period`, `quantity`, `progress`, `descriptions`, `created_at`, `updated_at`) VALUES
(1,	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ut mi tellus. Nullam eu euismod eros, nec fringilla augue. Aenean sit amet arcu accumsan, facilisis augue nec, maximus ante.',	6,	0,	'1996',	1,	'Bla bla bla',	'Ini Deskripsi',	'2017-08-18 05:35:53',	'2017-08-18 06:32:44'),
(2,	'Donec rutrum tortor urna, eu egestas turpis ornare vel. Sed sed lectus nec odio placerat tincidunt a at diam. Integer in turpis eu diam accumsan posuere vitae vel dui.',	3,	1,	'2018',	3,	'tortor urna',	'Sed finibus',	'2017-08-18 06:35:07',	'2017-08-21 19:26:07'),
(3,	'vhbjk',	6,	1,	'2016',	2,	NULL,	NULL,	'2017-08-21 20:16:19',	'2017-08-21 20:16:19'),
(4,	'asd',	3,	1,	'2014',	1,	NULL,	NULL,	'2017-08-21 20:46:53',	'2017-08-21 20:46:53');

DROP TABLE IF EXISTS `record_categories`;
CREATE TABLE `record_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `record_categories` (`id`, `code`, `name`, `parent_id`, `created_at`, `updated_at`) VALUES
(1,	'KK',	'Keprotokolan dan Kerumahtanggan Presiden dan wakil Presiden',	0,	'2017-08-09 21:20:09',	'2017-08-09 21:59:23'),
(2,	'KK-00',	'djsvjks',	1,	'2017-08-21 09:00:53',	'2017-08-21 09:00:53');

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rooms` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1,	'Ruangan 1',	'2017-08-06 06:42:50',	'2017-08-06 06:42:50'),
(2,	'Ruangan 2',	'2017-08-06 06:42:58',	'2017-08-06 06:42:58'),
(3,	'Ruangan 3',	'2017-08-06 06:43:04',	'2017-08-06 06:43:26'),
(4,	'Ruangan 4',	'2017-08-06 06:43:11',	'2017-08-06 06:43:11'),
(5,	'Ruangan 5',	'2017-08-06 06:43:16',	'2017-08-06 06:43:16'),
(6,	'Ruangan 6',	'2017-08-15 19:30:57',	'2017-08-15 19:30:57'),
(7,	'Ruangan baru',	'2017-08-15 22:06:17',	'2017-08-15 22:06:17');

DROP TABLE IF EXISTS `sections`;
CREATE TABLE `sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `box_id` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sections` (`id`, `name`, `box_id`, `created_at`, `updated_at`) VALUES
(1,	'Section 1',	1,	NULL,	NULL),
(2,	'section 2',	1,	'2017-08-07 03:39:37',	'2017-08-07 03:39:37'),
(3,	'Section 3',	3,	'2017-08-07 03:39:49',	'2017-08-07 03:39:49'),
(6,	'Section 4',	4,	'2017-08-18 00:57:22',	'2017-08-18 06:24:28');

DROP TABLE IF EXISTS `shelves`;
CREATE TABLE `shelves` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `shelves` (`id`, `name`, `room_id`, `created_at`, `updated_at`) VALUES
(1,	'Lemari 3.1',	3,	'2017-08-08 05:08:40',	'2017-08-15 10:52:04'),
(2,	'Lemari 1',	1,	'2017-08-08 21:09:30',	'2017-08-08 21:09:30'),
(3,	'Lemari 2',	1,	'2017-08-08 21:09:37',	'2017-08-08 21:09:37'),
(4,	'Lemari 2.1',	2,	'2017-08-08 21:09:45',	'2017-08-08 21:09:45'),
(5,	'Lemari 2.2',	2,	'2017-08-08 21:09:57',	'2017-08-08 21:09:57'),
(6,	'lemari 5.1',	5,	'2017-08-15 10:46:37',	'2017-08-15 10:46:37'),
(7,	'Lemari 5.2',	5,	'2017-08-15 10:51:36',	'2017-08-15 10:51:36'),
(8,	'Lemari 6.1',	6,	'2017-08-15 19:31:22',	'2017-08-15 19:31:22'),
(9,	'Lemari 5.3',	5,	'2017-08-15 19:34:58',	'2017-08-15 19:34:58');

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
(1,	'Admin',	'admin',	'admin',	'admin@siarsip.com',	'$2y$10$9iaQGJfUbluCyds5Gi.khOHdAyzoiVV7pbpSP6xKJSBMcUl/vrFui',	'RQ9BDDqO2AWn2jet273VijvjGg40fVXS9JeXYBRwH8YazQszZUlqrfd7DpVA',	'2017-08-06 06:41:15',	'2017-08-06 06:41:15');

-- 2017-08-22 03:50:11
