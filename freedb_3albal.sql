-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2026 at 08:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freedb_3albal`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `neighborhood` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `label`, `city`, `area`, `neighborhood`, `address`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 4, 'Default', '.', '.', '.', '.', 1, '2025-06-28 20:09:40', '2025-06-28 20:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `target_type` enum('product','store','category','url') NOT NULL,
  `target_value` varchar(255) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_campaign` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image`, `target_type`, `target_value`, `start_date`, `end_date`, `is_active`, `is_campaign`, `created_at`, `updated_at`, `position`) VALUES
(1, 'first banner', 'banners/SNqfLIEcyCEx9jO04UeWVmOrdFUj6oSLOSVgdxdd.png', 'category', 'flowers', NULL, NULL, 1, 0, '2025-06-20 16:41:02', '2025-06-20 16:41:02', 0),
(2, 'don\'t make him sad', 'banners/ne1EHmIJAwSoBENOWgkYDZGUtKFHaoZ0bhGrCpAn.jpg', 'product', 'flowers', '2025-12-12 23:51:00', '2025-12-26 23:51:00', 1, 1, '2025-06-27 12:36:26', '2025-12-27 20:51:24', 0),
(3, 'hello', 'banners/ADPEMDOta9lZtz954b72RjXVKZKvpLykfX0mj83s.jpg', 'store', '122', NULL, NULL, 1, 0, '2025-12-27 20:55:40', '2025-12-27 20:55:40', 0),
(5, 'test', 'banners/qimniP7eei6E6iU9VeOqzA45Sn4USn4yRt6TSVix.jpg', 'store', '1', NULL, NULL, 1, 0, '2025-12-28 00:17:57', '2025-12-28 00:17:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `store_id`, `name`, `created_at`, `updated_at`, `image`) VALUES
(1, NULL, 'flowers', '2025-06-20 16:42:16', '2025-06-25 21:17:40', 'categories/izYEXAO7NQe22rUJto1nxSMG0MNWJc14HtsQTBtG.png'),
(2, NULL, 'Cake', '2025-08-19 09:37:16', '2025-08-19 09:37:16', NULL),
(3, NULL, 'IT', '2025-12-27 20:40:14', '2025-12-27 20:40:40', 'categories/dsEfWHnPF1fyvWEjF63CIw3gAGlFlEQxXPL8KvBo.jpg'),
(5, NULL, 'test', '2025-12-27 20:44:19', '2025-12-27 21:04:33', 'categories/WQ23W1MU2seICDWcP5qGuRgxf0o8nrL36OTxHukb.jpg'),
(6, NULL, 'Computers', '2025-12-27 21:05:01', '2025-12-27 21:05:01', NULL),
(8, NULL, 'test wafaa', '2025-12-28 00:14:45', '2025-12-28 00:14:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Amman', 'amman', '2025-08-08 19:08:56', '2025-08-08 19:33:07'),
(2, 'Irbid', 'irbid', '2025-08-08 19:08:56', '2025-08-08 19:33:07'),
(3, 'Aqaba', 'aqaba', '2025-08-08 19:08:56', '2025-08-08 19:33:07');

-- --------------------------------------------------------

--
-- Table structure for table `city_store`
--

CREATE TABLE `city_store` (
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `city_store`
--

INSERT INTO `city_store` (`store_id`, `city_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('percent','fixed') NOT NULL DEFAULT 'percent',
  `min_order_amount` decimal(8,2) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount`, `is_active`, `created_at`, `updated_at`, `type`, `min_order_amount`, `expires_at`, `usage_limit`) VALUES
(1, 'test1', 1.00, 1, '2025-06-29 14:59:36', '2025-06-29 14:59:36', 'fixed', 1.00, '2025-07-31 17:59:00', NULL),
(2, 'test', 10.00, 1, '2025-07-10 17:28:01', '2025-07-10 17:28:01', 'percent', NULL, '2029-12-12 10:10:00', NULL),
(3, '123', 10.00, 1, '2025-07-27 18:08:09', '2025-07-27 18:08:09', 'percent', NULL, NULL, NULL),
(4, 'nev', 50.00, 1, '2025-12-27 21:24:05', '2025-12-27 21:24:05', 'percent', NULL, '2026-01-25 01:25:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_user`
--

CREATE TABLE `coupon_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupon_user`
--

INSERT INTO `coupon_user` (`id`, `user_id`, `coupon_id`, `created_at`, `updated_at`) VALUES
(1, 5, 2, '2025-07-10 18:36:21', '2025-07-10 18:36:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `global_settings`
--

CREATE TABLE `global_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `support_email` varchar(255) DEFAULT NULL,
  `delivery_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`delivery_days`)),
  `delivery_times` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`delivery_times`)),
  `theme_color` varchar(255) DEFAULT NULL,
  `default_language` varchar(255) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `default_fcm_image` varchar(255) DEFAULT NULL,
  `site_favicon` varchar(255) DEFAULT NULL,
  `enable_reviews` tinyint(1) NOT NULL DEFAULT 1,
  `enable_campaigns` tinyint(1) NOT NULL DEFAULT 0,
  `enable_wallet` tinyint(1) NOT NULL DEFAULT 0,
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `enable_cliq` tinyint(1) NOT NULL DEFAULT 0,
  `enable_credit` tinyint(1) NOT NULL DEFAULT 0,
  `enable_apple` tinyint(1) NOT NULL DEFAULT 0,
  `bank_name` varchar(255) DEFAULT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `cliq_name` varchar(255) DEFAULT NULL,
  `cliq_alias` varchar(255) DEFAULT NULL,
  `credit_fee` decimal(5,2) DEFAULT NULL,
  `apple_note` varchar(255) DEFAULT NULL,
  `apple_merchant_id` varchar(255) DEFAULT NULL,
  `google_merchant_id` varchar(255) DEFAULT NULL,
  `google_note` text DEFAULT NULL,
  `enable_google` tinyint(1) NOT NULL DEFAULT 0,
  `mid` varchar(255) DEFAULT NULL,
  `tid` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `enable_3d` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `global_settings`
--

INSERT INTO `global_settings` (`id`, `site_name`, `support_email`, `delivery_days`, `delivery_times`, `theme_color`, `default_language`, `footer_text`, `copyright`, `site_logo`, `default_fcm_image`, `site_favicon`, `enable_reviews`, `enable_campaigns`, `enable_wallet`, `maintenance_mode`, `created_at`, `updated_at`, `enable_cliq`, `enable_credit`, `enable_apple`, `bank_name`, `iban`, `payment_note`, `cliq_name`, `cliq_alias`, `credit_fee`, `apple_note`, `apple_merchant_id`, `google_merchant_id`, `google_note`, `enable_google`, `mid`, `tid`, `ip_address`, `enable_3d`) VALUES
(1, 'Admin Panel', 'asdff@abc.com', '[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29]', '[\"aasdf\",\"asd\",\"asdf11\"]', 'light', 'en', 'test1', 'asdasfd11', 'uploads/logos/dFWDwveJSbSP87E1cNSkweoJFh4q6bXE2FtNTWYV.jpg', 'https://3albalapp.com/storage/uploads/logos/dFWDwveJSbSP87E1cNSkweoJFh4q6bXE2FtNTWYV.jpg', 'uploads/favicons/D2qwQ0vcU0CPpRcZRTMKvo7I4iWaAp6AOzhWm4aH.jpg', 0, 0, 0, 1, '2025-06-21 11:54:52', '2025-12-28 07:15:56', 1, 1, 1, 'bank x', '123123', NULL, 'name', 'alias', 3.30, NULL, NULL, NULL, NULL, 1, NULL, 'name', 'Moeadmin@codeela.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"41745f05-51ee-41c2-8ced-97b728a04e47\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1750358200, 1750358200),
(2, 'default', '{\"uuid\":\"e7429ad5-ddd5-422e-ac3c-59204de96349\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1751028556, 1751028556),
(3, 'default', '{\"uuid\":\"8051639d-39fa-4866-8507-2300d50533f5\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1752086318, 1752086318),
(4, 'default', '{\"uuid\":\"624e1194-ed1f-418e-8a54-55b9d42f8058\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1752086328, 1752086328),
(5, 'default', '{\"uuid\":\"9554ae71-738c-4ef0-b319-e7ee36f84321\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1752159754, 1752159754),
(6, 'default', '{\"uuid\":\"91aebffc-8145-4cfe-a105-7d8f9bf6861e\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:12;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1752159768, 1752159768),
(7, 'default', '{\"uuid\":\"e59cb625-7259-44a2-be0c-781cf5bda813\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:15;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1752171140, 1752171140),
(8, 'default', '{\"uuid\":\"a12a35cc-9042-4f62-a88a-689346512c43\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:20;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1752171530, 1752171530),
(9, 'default', '{\"uuid\":\"449d5ece-9fa4-47a6-8637-356b60f3a4d0\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753699194, 1753699194),
(10, 'default', '{\"uuid\":\"cdef9475-821a-463f-a75d-e94c883dfdcf\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:24;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753699249, 1753699249),
(11, 'default', '{\"uuid\":\"57629da8-6d1a-436f-b36c-61f2ad184d75\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:25;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753699783, 1753699783),
(12, 'default', '{\"uuid\":\"0522f279-8500-4937-b6bc-c469211fc0e3\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:28;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753699809, 1753699809),
(13, 'default', '{\"uuid\":\"a4a20bbd-6430-4e2d-ab42-069b96b87b9f\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753700161, 1753700161),
(14, 'default', '{\"uuid\":\"25a59639-5a78-4466-8310-f39208c0ec55\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:34;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753704000, 1753704000),
(15, 'default', '{\"uuid\":\"6a36212d-9a9b-4296-b254-eb1066ab0912\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:36;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753704022, 1753704022),
(16, 'default', '{\"uuid\":\"e5b9f725-f1b9-49a6-a697-e362c52fa00a\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:37;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753705473, 1753705473),
(17, 'default', '{\"uuid\":\"e2ef3746-05e4-4549-86f9-6ead4d217ce2\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:39;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753705992, 1753705992),
(18, 'default', '{\"uuid\":\"8566c8fc-1dfd-4f97-9d9b-1078d1c51c40\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753807539, 1753807539),
(19, 'default', '{\"uuid\":\"78607040-0f56-4ca6-a1bc-69eb212b2d02\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:43;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753807671, 1753807671),
(20, 'default', '{\"uuid\":\"2669d95c-6dfa-4b6b-89eb-c947f92d6e65\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:51;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753808752, 1753808752),
(21, 'default', '{\"uuid\":\"0e9d58d6-6497-4369-9159-58217237e9e8\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:54;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753809186, 1753809186),
(22, 'default', '{\"uuid\":\"3f1cc8df-c434-4571-a0fb-3c4a3944fc3e\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:56;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753811292, 1753811292),
(23, 'default', '{\"uuid\":\"1ac91e4c-934a-4785-af24-fb4d6f6e39fe\",\"displayName\":\"App\\\\Events\\\\NewChatMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\NewChatMessage\\\":1:{s:4:\\\"chat\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\LiveChat\\\";s:2:\\\"id\\\";i:58;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1753811891, 1753811891);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `live_chats`
--

CREATE TABLE `live_chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `chat_session_id` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `from_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `ended_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `live_chats`
--

INSERT INTO `live_chats` (`id`, `user_id`, `chat_session_id`, `content`, `file`, `from_admin`, `created_at`, `ended_at`, `updated_at`, `message`) VALUES
(1, 1, NULL, NULL, NULL, 1, '2025-06-19 14:10:23', '2025-06-29 14:57:15', '2025-06-29 14:57:15', 'Test message from admin'),
(2, 1, NULL, NULL, NULL, 1, '2025-06-19 18:36:40', '2025-06-29 14:57:15', '2025-06-29 14:57:15', 'ok'),
(3, 4, 'chat_685e9327dd475', NULL, NULL, 0, '2025-06-27 12:48:39', '2025-06-27 12:49:39', '2025-06-27 12:49:39', '🆘 User has requested support'),
(4, 4, 'chat_685e9327dd475', NULL, NULL, 1, '2025-06-27 12:49:16', '2025-06-27 12:49:39', '2025-06-27 12:49:39', 'hello how can I help you'),
(5, 4, 'chat_685e9327dd475', NULL, NULL, 0, '2025-06-27 12:49:27', '2025-06-27 12:49:39', '2025-06-27 12:49:39', 'hello'),
(6, 4, 'chat_686eb717ced8e', NULL, NULL, 0, '2025-07-09 18:38:15', '2025-07-09 18:41:20', '2025-07-09 18:41:20', '🆘 User has requested support'),
(7, 4, 'chat_686eb717ced8e', NULL, NULL, 0, '2025-07-09 18:38:20', '2025-07-09 18:41:20', '2025-07-09 18:41:20', 'hi'),
(8, 4, 'chat_686eb717ced8e', NULL, NULL, 1, '2025-07-09 18:38:38', '2025-07-09 18:41:20', '2025-07-09 18:41:20', 'hi'),
(9, 4, 'chat_686eb717ced8e', NULL, NULL, 1, '2025-07-09 18:38:48', '2025-07-09 18:41:20', '2025-07-09 18:41:20', 'hi'),
(10, 5, 'chat_686fd600a60f9', NULL, NULL, 0, '2025-07-10 15:02:24', '2025-07-10 15:26:37', '2025-07-10 15:26:37', '🆘 User has requested support'),
(11, 5, 'chat_686fd600a60f9', NULL, NULL, 1, '2025-07-10 15:02:34', '2025-07-10 15:26:37', '2025-07-10 15:26:37', '....'),
(12, 5, 'chat_686fd600a60f9', NULL, NULL, 1, '2025-07-10 15:02:48', '2025-07-10 15:26:37', '2025-07-10 15:26:37', 'hi from live support'),
(13, 5, 'chat_686fd600a60f9', NULL, NULL, 0, '2025-07-10 15:03:08', '2025-07-10 15:26:37', '2025-07-10 15:26:37', 'hi from end user'),
(14, 5, 'chat_6870026cf2ca1', NULL, NULL, 0, '2025-07-10 18:11:56', '2025-07-10 18:23:35', '2025-07-10 18:23:35', '🆘 User has requested support'),
(15, 5, 'chat_6870026cf2ca1', NULL, NULL, 1, '2025-07-10 18:12:20', '2025-07-10 18:23:35', '2025-07-10 18:23:35', 'hihihi'),
(16, 5, 'chat_6870026cf2ca1', NULL, NULL, 0, '2025-07-10 18:12:35', '2025-07-10 18:16:54', '2025-07-10 18:16:54', 'hihi'),
(17, 5, 'chat_687003964529f', NULL, NULL, 0, '2025-07-10 18:16:54', '2025-07-10 18:23:35', '2025-07-10 18:23:35', '🆘 User has requested support'),
(18, 5, 'chat_687003964529f', NULL, NULL, 0, '2025-07-10 18:17:07', '2025-07-10 18:18:16', '2025-07-10 18:18:16', 'asdfasdf'),
(19, 5, 'chat_687003e8a475d', NULL, NULL, 0, '2025-07-10 18:18:16', '2025-07-10 18:23:35', '2025-07-10 18:23:35', '🆘 User has requested support'),
(20, 5, 'chat_687003e8a475d', NULL, NULL, 1, '2025-07-10 18:18:50', '2025-07-10 18:23:35', '2025-07-10 18:23:35', 'asdfasdf'),
(21, 5, 'chat_688753665749f', NULL, NULL, 0, '2025-07-28 10:39:34', '2025-07-29 17:56:47', '2025-07-29 17:56:47', '🆘 User has requested support'),
(22, 5, 'chat_688753665749f', NULL, NULL, 1, '2025-07-28 10:39:54', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'hi'),
(23, 5, 'chat_688753665749f', NULL, NULL, 0, '2025-07-28 10:40:21', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'a message from application user'),
(24, 5, 'chat_688753665749f', NULL, NULL, 1, '2025-07-28 10:40:49', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'a message from the admin panel'),
(25, 5, 'chat_688753665749f', NULL, NULL, 1, '2025-07-28 10:49:43', '2025-07-28 10:49:59', '2025-07-28 10:49:59', 'kjkj'),
(26, 5, 'chat_688755d7bcc11', NULL, NULL, 0, '2025-07-28 10:49:59', '2025-07-29 17:56:47', '2025-07-29 17:56:47', '🆘 User has requested support'),
(27, 5, 'chat_688755d7bcc11', NULL, NULL, 0, '2025-07-28 10:50:06', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'lfkjsdf'),
(28, 5, 'chat_688755d7bcc11', NULL, NULL, 1, '2025-07-28 10:50:09', '2025-07-28 10:51:48', '2025-07-28 10:51:48', 'asdfasdf'),
(29, 5, 'chat_6887564409d5a', NULL, NULL, 0, '2025-07-28 10:51:48', '2025-07-29 17:56:47', '2025-07-29 17:56:47', '🆘 User has requested support'),
(30, 5, 'chat_6887564409d5a', NULL, NULL, 0, '2025-07-28 10:52:03', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'asdf'),
(31, 5, 'chat_6887564409d5a', NULL, NULL, 1, '2025-07-28 10:56:01', '2025-07-28 11:59:31', '2025-07-28 11:59:31', 'asdfaf'),
(32, 5, 'chat_688766235872e', NULL, NULL, 0, '2025-07-28 11:59:31', '2025-07-29 17:56:47', '2025-07-29 17:56:47', '🆘 User has requested support'),
(33, 5, 'chat_688766235872e', NULL, NULL, 0, '2025-07-28 11:59:49', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'hello'),
(34, 5, 'chat_688766235872e', NULL, NULL, 1, '2025-07-28 12:00:00', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'hello'),
(35, 5, 'chat_688766235872e', NULL, NULL, 0, '2025-07-28 12:00:18', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'application'),
(36, 5, 'chat_688766235872e', NULL, NULL, 1, '2025-07-28 12:00:22', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'admin'),
(37, 5, 'chat_688766235872e', NULL, NULL, 1, '2025-07-28 12:24:33', '2025-07-28 12:32:35', '2025-07-28 12:32:35', 'test test'),
(38, 5, 'chat_68876de3a7999', NULL, NULL, 0, '2025-07-28 12:32:35', '2025-07-29 17:56:47', '2025-07-29 17:56:47', '🆘 User has requested support'),
(39, 5, 'chat_68876de3a7999', NULL, NULL, 1, '2025-07-28 12:33:12', '2025-07-29 16:45:08', '2025-07-29 16:45:08', 'hello from admin panel'),
(40, 5, 'chat_6888fa942ca68', NULL, NULL, 0, '2025-07-29 16:45:08', '2025-07-29 17:56:47', '2025-07-29 17:56:47', '🆘 User has requested support'),
(41, 5, 'chat_6888fa942ca68', NULL, NULL, 1, '2025-07-29 16:45:39', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'hello from admin panel'),
(42, 5, 'chat_6888fa942ca68', NULL, NULL, 0, '2025-07-29 16:47:06', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'Hello from application user'),
(43, 5, 'chat_6888fa942ca68', NULL, NULL, 1, '2025-07-29 16:47:51', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'hello from admin panel'),
(44, 5, 'chat_6888fa942ca68', NULL, NULL, 0, '2025-07-29 16:48:05', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'hello from application user'),
(45, 5, 'chat_6888fa942ca68', NULL, NULL, 0, '2025-07-29 16:50:22', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'hi'),
(46, 5, 'chat_6888fa942ca68', NULL, NULL, 0, '2025-07-29 16:58:52', '2025-07-29 16:59:30', '2025-07-29 16:59:30', 'test'),
(47, 5, 'chat_6888fdf226a20', NULL, NULL, 0, '2025-07-29 16:59:30', '2025-07-29 17:56:47', '2025-07-29 17:56:47', '🆘 User has requested support'),
(48, 5, 'chat_6888fdf226a20', NULL, NULL, 0, '2025-07-29 16:59:40', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'hello'),
(49, 5, 'chat_6888fdf226a20', NULL, NULL, 0, '2025-07-29 17:01:12', '2025-07-29 17:05:41', '2025-07-29 17:05:41', 'hello'),
(50, 5, 'chat_6888ff653fe86', NULL, NULL, 0, '2025-07-29 17:05:41', '2025-07-29 17:56:47', '2025-07-29 17:56:47', '🆘 User has requested support'),
(51, 5, 'chat_6888ff653fe86', NULL, NULL, 1, '2025-07-29 17:05:52', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'a message from the admin panel'),
(52, 5, 'chat_6888ff653fe86', NULL, NULL, 0, '2025-07-29 17:06:13', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'a message from application user'),
(53, 5, 'chat_6888ff653fe86', NULL, NULL, 0, '2025-07-29 17:12:54', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'hello'),
(54, 5, 'chat_6888ff653fe86', NULL, NULL, 1, '2025-07-29 17:13:06', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'hello'),
(55, 5, 'chat_6888ff653fe86', NULL, NULL, 0, '2025-07-29 17:47:59', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'a message from user'),
(56, 5, 'chat_6888ff653fe86', NULL, NULL, 1, '2025-07-29 17:48:12', '2025-07-29 17:56:47', '2025-07-29 17:56:47', 'a message from admin'),
(57, 5, 'chat_68890ba0c86d9', NULL, NULL, 0, '2025-07-29 17:57:52', '2025-07-30 09:35:50', '2025-07-30 09:35:50', '🆘 User has requested support'),
(58, 5, 'chat_68890ba0c86d9', NULL, NULL, 1, '2025-07-29 17:58:11', '2025-07-30 09:35:50', '2025-07-30 09:35:50', 'hello from admin panel'),
(59, 5, 'chat_68890ba0c86d9', NULL, NULL, 0, '2025-07-29 17:59:13', '2025-07-30 09:35:50', '2025-07-30 09:35:50', 'hello from application user');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `sender` enum('user','store') NOT NULL,
  `message` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `order_id`, `sender`, `message`, `image`, `created_at`, `updated_at`) VALUES
(4, 13, 'user', 'hello hello', NULL, '2025-08-01 18:09:58', '2025-08-01 18:09:58'),
(5, 13, 'user', 'order 13 message from user', NULL, '2025-08-01 18:12:19', '2025-08-01 18:12:19'),
(6, 13, 'store', 'hello', NULL, '2025-08-01 18:25:38', '2025-08-01 18:25:38'),
(7, 13, 'store', 'how are you', NULL, '2025-08-01 18:28:32', '2025-08-01 18:28:32'),
(8, 13, 'store', 'asdf', NULL, '2025-08-01 18:34:00', '2025-08-01 18:34:00'),
(9, 13, 'store', 'hello', NULL, '2025-08-02 18:15:40', '2025-08-02 18:15:40'),
(10, 13, 'store', 'hiii', NULL, '2025-08-03 10:44:08', '2025-08-03 10:44:08'),
(11, 13, 'store', 'hiii', NULL, '2025-08-03 10:44:08', '2025-08-03 10:44:08'),
(12, 13, 'store', 'hello', NULL, '2025-08-03 10:54:54', '2025-08-03 10:54:54'),
(13, 13, 'store', 'image', NULL, '2025-08-03 11:02:41', '2025-08-03 11:02:41'),
(14, 13, 'store', '.', NULL, '2025-08-03 11:03:30', '2025-08-03 11:03:30'),
(15, 13, 'store', '.', 'chat_images/yWzD4rAAyNP13HeM4AfvfHOBpfmMRbXMdhtzkBL3.jpg', '2025-08-03 18:01:29', '2025-08-03 18:01:29'),
(16, 13, 'store', ',', NULL, '2025-08-03 18:02:00', '2025-08-03 18:02:00'),
(17, 13, 'store', 'jijij', 'chat_images/GiJUvFV5axnqKJuT3pS1gc23y6FvF6bWBqUmHLNd.jpg', '2025-08-03 19:01:21', '2025-08-03 19:01:21'),
(18, 13, 'store', 'l', NULL, '2025-08-03 19:01:33', '2025-08-03 19:01:33'),
(19, 13, 'store', 'f', 'chat_images/TkwRJEv517RAlA7thtYSj6zNtyml997VUHBX4vGH.jpg', '2025-08-03 19:06:53', '2025-08-03 19:06:53'),
(20, 13, 'store', 'asdf', 'chat_images/kYOs316xbv9EDEeCvrqaL39yfYo9JYv7rEkBlErT.jpg', '2025-08-03 19:10:43', '2025-08-03 19:10:43'),
(21, 13, 'user', '...', NULL, '2025-08-03 19:49:04', '2025-08-03 19:49:04'),
(22, 13, 'user', 'ddd', NULL, '2025-08-03 19:52:53', '2025-08-03 19:52:53'),
(24, 15, 'store', 'hello', NULL, '2025-08-22 12:13:52', '2025-08-22 12:13:52'),
(25, 15, 'user', 'hello', NULL, '2025-08-22 12:14:16', '2025-08-22 12:14:16'),
(26, 16, 'store', 'Hello', NULL, '2025-08-22 12:43:26', '2025-08-22 12:43:26'),
(27, 16, 'user', 'hello', NULL, '2025-08-22 12:43:36', '2025-08-22 12:43:36'),
(28, 17, 'store', 'hello we are preparing', NULL, '2025-08-24 11:31:01', '2025-08-24 11:31:01'),
(29, 17, 'user', 'ok thank you', NULL, '2025-08-24 11:31:30', '2025-08-24 11:31:30'),
(30, 18, 'store', 'hello', NULL, '2025-12-27 19:48:30', '2025-12-27 19:48:30'),
(31, 18, 'store', '.', 'chat_images/PhYwAtGHLTcaAbcvNDoZ1YucIF2cEv2MtLsm3mCH.jpg', '2025-12-27 19:49:33', '2025-12-27 19:49:33'),
(32, 13, 'store', 'hi', NULL, '2025-12-27 20:00:12', '2025-12-27 20:00:12'),
(33, 13, 'store', 'hi', NULL, '2025-12-27 20:00:14', '2025-12-27 20:00:14'),
(34, 13, 'store', '...', 'chat_images/N4i6OWOU0KZohfvkQprc0K0rkVtaAeXi0z185vM7.jpg', '2025-12-27 20:02:21', '2025-12-27 20:02:21'),
(35, 9, 'store', 'hi', NULL, '2025-12-27 20:06:59', '2025-12-27 20:06:59'),
(36, 9, 'store', '..', 'chat_images/g9unJjdiZMkJfeXWXLgppB5jZme09ckQ6Z25DKWb.jpg', '2025-12-27 20:07:14', '2025-12-27 20:07:14'),
(37, 9, 'store', '..', 'chat_images/gpQu6gDSx0lYY1L1B6lZSrQLsfLimbUNlB3gkrcy.jpg', '2025-12-27 20:07:14', '2025-12-27 20:07:14'),
(38, 17, 'store', 'hello', NULL, '2025-12-27 23:59:23', '2025-12-27 23:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_27_143207_create_personal_access_tokens_table', 1),
(5, '2025_03_27_143404_update_users_table_add_roles', 1),
(6, '2025_03_27_144352_create_tenants_table', 1),
(7, '2025_03_31_115346_create_stores_table', 1),
(8, '2025_03_31_155654_create_products_table', 1),
(9, '2025_04_01_132439_add_tenant_id_to_products_table', 1),
(10, '2025_04_01_144744_fix_products_foreign_key_for_tenant_id', 1),
(11, '2025_04_01_150759_create_orders_table', 1),
(12, '2025_04_01_181725_create_categories_table', 1),
(13, '2025_04_01_185455_add_category_id_to_products_table', 1),
(14, '2025_04_01_214008_add_phone_and_logo_to_stores_table', 1),
(15, '2025_04_03_010718_add_social_and_theme_fields_to_stores_table', 1),
(16, '2025_04_03_010854_add_address_to_stores_table', 1),
(17, '2025_04_07_142754_add_image_to_categories_table', 1),
(18, '2025_04_07_184720_create_order_product_table', 1),
(19, '2025_04_07_202049_add_delivery_fields_to_orders_table', 1),
(20, '2025_04_09_133918_recreate_order_product_table', 1),
(21, '2025_04_09_231801_add_coupon_fields_to_orders_table', 1),
(22, '2025_04_09_232411_create_coupons_table', 1),
(23, '2025_04_10_001619_add_user_id_to_orders_table', 1),
(24, '2025_04_10_172332_add_gift_message_to_orders_table', 1),
(25, '2025_04_10_175820_create_reviews_table', 1),
(26, '2025_04_10_220504_create_addresses_table', 1),
(27, '2025_04_10_234952_create_faqs_table', 1),
(28, '2025_04_11_010131_create_messages_table', 1),
(29, '2025_04_11_014814_add_image_to_messages_table', 1),
(30, '2025_04_14_134322_make_store_id_nullable_in_categories_table', 1),
(31, '2025_04_14_174839_create_banners_table', 1),
(32, '2025_04_14_180457_add_position_to_banners_table', 1),
(33, '2025_04_16_140537_create_global_settings_table', 1),
(34, '2025_04_16_150600_add_fields_to_global_settings_table', 1),
(35, '2025_04_16_211102_add_payment_fields_to_orders_table', 1),
(36, '2025_04_16_223525_create_pages_table', 1),
(37, '2025_04_17_145058_add_payment_fields_to_global_settings_table', 1),
(38, '2025_04_19_160056_add_google_pay_fields_to_global_settings_table', 1),
(39, '2025_04_19_163702_add_enable_google_to_global_settings', 1),
(40, '2025_04_21_114932_add_commission_paid_to_stores_table', 1),
(41, '2025_04_21_120003_add_fields_to_coupons_table', 1),
(42, '2025_04_21_121221_fix_coupons_table_columns', 1),
(43, '2025_04_21_122544_create_coupon_user_table', 1),
(44, '2025_04_21_123535_add_campaign_fields_to_banners_table', 1),
(45, '2025_04_21_124839_add_is_campaign_to_banners_table', 1),
(46, '2025_04_24_174129_add_status_to_stores_table', 1),
(47, '2025_04_24_180252_create_store_payouts_table', 1),
(48, '2025_04_24_181817_add_is_active_to_users_table', 1),
(49, '2025_04_24_200750_create_live_chats_table', 1),
(50, '2025_04_24_204253_add_user_id_to_live_chats_table', 1),
(51, '2025_04_24_204539_add_columns_to_live_chats_table', 1),
(52, '2025_04_24_223638_add_from_admin_to_live_chats_table', 1),
(53, '2025_04_26_142017_add_ended_at_to_live_chats_table', 1),
(54, '2025_04_26_144113_add_chat_session_id_to_live_chats_table', 1),
(55, '2025_04_27_125011_add_phone_to_users_table', 1),
(56, '2025_04_30_122423_add_default_fcm_image_to_global_settings_table', 1),
(57, '2025_04_30_132636_create_notifications_table', 1),
(58, '2025_05_04_141538_create_user_messages_table', 1),
(59, '2025_05_06_104826_add_credit_card_fields_to_global_settings', 1),
(60, '2025_08_08_182758_create_cities_table', 2),
(61, '2025_08_08_182903_create_city_store_table', 2),
(62, '2025_08_08_184214_add_city_id_to_orders_table', 2),
(63, '2025_08_08_184223_add_default_city_id_to_users_table', 2),
(64, '2025_08_19_184119_drop_tenant_id_from_products', 3),
(65, '2025_08_20_183333_create_product_images_table', 4),
(66, '2025_08_20_184543_remove_sort_order_from_product_images_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `body`, `type`, `user_id`, `order_id`, `image`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 'Order Approved', 'Your order #2 has been updated to approved.', 'order', 5, 2, NULL, NULL, '2025-07-10 19:48:25', '2025-07-10 19:48:25'),
(2, 'Order Pending', 'Your order #2 has been updated to pending.', 'order', 5, 2, NULL, NULL, '2025-07-10 19:48:36', '2025-07-10 19:48:36'),
(3, 'Order Approved', 'Your order #2 has been updated to approved.', 'order', 5, 2, NULL, NULL, '2025-07-10 19:48:48', '2025-07-10 19:48:48'),
(4, 'Order Approved', 'Your order #3 has been updated to approved.', 'order', 5, 3, NULL, NULL, '2025-07-10 19:54:51', '2025-07-10 19:54:51'),
(5, 'Order Delivered', 'Your order #3 has been updated to delivered.', 'order', 5, 3, NULL, NULL, '2025-07-10 19:55:04', '2025-07-10 19:55:04'),
(6, 'Order Pending', 'Your order #3 has been updated to pending.', 'order', 5, 3, NULL, NULL, '2025-07-10 19:55:07', '2025-07-10 19:55:07'),
(7, 'Order Approved', 'Your order #3 has been updated to approved.', 'order', 5, 3, NULL, NULL, '2025-07-10 19:55:09', '2025-07-10 19:55:09'),
(8, 'Order Approved', 'Your order #3 has been updated to approved.', 'order', 5, 3, NULL, NULL, '2025-07-10 19:55:16', '2025-07-10 19:55:16'),
(9, 'Order Delivered', 'Your order #3 has been updated to delivered.', 'order', 5, 3, NULL, NULL, '2025-07-10 19:55:30', '2025-07-10 19:55:30'),
(10, 'Order Approved', 'Your order #3 has been updated to approved.', 'order', 5, 3, NULL, NULL, '2025-07-10 19:55:38', '2025-07-10 19:55:38'),
(11, 'Order Approved', 'Your order #4 has been updated to approved.', 'order', 5, 4, NULL, NULL, '2025-07-10 20:02:26', '2025-07-10 20:02:26'),
(12, 'Order Approved', 'Your order #1 has been updated to approved.', 'order', 5, 1, NULL, NULL, '2025-07-10 20:02:28', '2025-07-10 20:02:28'),
(13, 'Order Approved', 'Your order #6 has been updated to approved.', 'order', 5, 6, NULL, NULL, '2025-07-10 21:10:04', '2025-07-10 21:10:04'),
(14, 'Order Approved', 'Your order #7 has been updated to approved.', 'order', 5, 7, NULL, NULL, '2025-07-11 12:13:11', '2025-07-11 12:13:11'),
(15, 'Order Approved', 'Your order #8 has been updated to approved.', 'order', 5, 8, NULL, NULL, '2025-07-11 12:15:06', '2025-07-11 12:15:06'),
(16, 'Order Pending', 'Your order #8 has been updated to pending.', 'order', 5, 8, NULL, NULL, '2025-07-11 20:19:17', '2025-07-11 20:19:17'),
(17, 'Order Approved', 'Your order #8 has been updated to approved.', 'order', 5, 8, NULL, NULL, '2025-07-11 20:19:48', '2025-07-11 20:19:48'),
(18, 'Order Pending', 'Your order #8 has been updated to pending.', 'order', 5, 8, NULL, NULL, '2025-07-11 20:20:33', '2025-07-11 20:20:33'),
(19, 'Order Approved', 'Your order #8 has been updated to approved.', 'order', 5, 8, NULL, NULL, '2025-07-11 22:42:18', '2025-07-11 22:42:18'),
(20, 'Order Pending', 'Your order #8 has been updated to pending.', 'order', 5, 8, NULL, NULL, '2025-07-11 22:56:19', '2025-07-11 22:56:19'),
(21, 'Order Approved', 'Your order #8 has been updated to approved.', 'order', 5, 8, NULL, NULL, '2025-07-11 22:57:04', '2025-07-11 22:57:04'),
(22, 'Order Pending', 'Your order #9 has been updated to pending.', 'order', 5, 9, NULL, NULL, '2025-07-11 23:15:24', '2025-07-11 23:15:24'),
(23, 'Order Approved', 'Your order #9 has been updated to approved.', 'order', 5, 9, NULL, NULL, '2025-07-11 23:15:42', '2025-07-11 23:15:42'),
(24, 'Order Delivered', 'Your order #9 has been updated to delivered.', 'order', 5, 9, NULL, NULL, '2025-07-11 23:17:22', '2025-07-11 23:17:22'),
(25, 'Order Pending', 'Your order #9 has been updated to pending.', 'order', 5, 9, NULL, NULL, '2025-07-11 23:17:29', '2025-07-11 23:17:29'),
(26, 'Order Approved', 'Your order #9 has been updated to approved.', 'order', 5, 9, NULL, NULL, '2025-07-11 23:17:38', '2025-07-11 23:17:38'),
(27, 'Order Delivered', 'Your order #9 has been updated to delivered.', 'order', 5, 9, NULL, NULL, '2025-07-11 23:17:49', '2025-07-11 23:17:49'),
(28, 'Order Rejected', 'Your order #9 has been rejected by admin.', 'order', 5, 9, NULL, NULL, '2025-07-11 23:21:52', '2025-07-11 23:21:52'),
(29, 'Order Approved', 'Your order #9 has been updated to approved.', 'order', 5, 9, NULL, NULL, '2025-07-11 23:42:29', '2025-07-11 23:42:29'),
(30, 'Order Rejected', 'Your order #9 has been rejected by admin.', 'order', 5, 9, NULL, NULL, '2025-07-12 11:07:24', '2025-07-12 11:07:24'),
(31, 'Order Order_packed', 'Your order #9 has been updated to order_packed.', 'order', 5, 9, NULL, NULL, '2025-07-12 11:12:42', '2025-07-12 11:12:42'),
(32, 'Order On_the_way', 'Your order #9 has been updated to on_the_way.', 'order', 5, 9, NULL, NULL, '2025-07-12 11:13:45', '2025-07-12 11:13:45'),
(33, 'Order Pending', 'Your order #9 has been updated to pending.', 'order', 5, 9, NULL, NULL, '2025-07-12 12:10:54', '2025-07-12 12:10:54'),
(34, 'Order Order_packed', 'Your order #9 has been updated to order_packed.', 'order', 5, 9, NULL, NULL, '2025-07-12 12:11:34', '2025-07-12 12:11:34'),
(35, 'Order On_the_way', 'Your order #9 has been updated to on_the_way.', 'order', 5, 9, NULL, NULL, '2025-07-12 12:11:46', '2025-07-12 12:11:46'),
(36, 'Order Delivered', 'Your order #9 has been updated to delivered.', 'order', 5, 9, NULL, NULL, '2025-07-12 12:11:57', '2025-07-12 12:11:57'),
(37, 'Order Rejected', 'Your order #9 has been rejected by admin.', 'order', 5, 9, NULL, NULL, '2025-07-12 12:12:07', '2025-07-12 12:12:07'),
(38, 'Order Approved', 'Your order #9 has been updated to approved.', 'order', 5, 9, NULL, NULL, '2025-07-12 15:28:20', '2025-07-12 15:28:20'),
(39, 'Order On_the_way', 'Your order #9 has been updated to on_the_way.', 'order', 5, 9, NULL, NULL, '2025-07-12 15:28:27', '2025-07-12 15:28:27'),
(40, 'Order Update: Order placed', 'Your order #9 is now order placed', 'order', 5, 9, NULL, NULL, '2025-07-12 15:28:34', '2025-07-12 15:28:34'),
(41, 'Order Update: Order packed', 'Your order #9 is now order packed', 'order', 5, 9, NULL, NULL, '2025-07-12 15:28:42', '2025-07-12 15:28:42'),
(42, 'Order Update: Delivered', 'Your order #9 is now delivered', 'order', 5, 9, NULL, NULL, '2025-07-12 15:28:50', '2025-07-12 15:28:50'),
(43, 'Order Pending', 'Your order #9 has been updated to pending.', 'order', 5, 9, NULL, NULL, '2025-07-12 15:29:28', '2025-07-12 15:29:28'),
(44, 'adfsasdf', 'asdfasdfasdf', 'order', 1, NULL, NULL, NULL, '2025-07-21 22:52:05', '2025-07-21 22:52:05'),
(45, 'adfsasdf', 'asdfasdfasdf', 'order', 2, NULL, NULL, NULL, '2025-07-21 22:52:05', '2025-07-21 22:52:05'),
(46, 'adfsasdf', 'asdfasdfasdf', 'order', 4, NULL, NULL, NULL, '2025-07-21 22:52:05', '2025-07-21 22:52:05'),
(47, 'adfsasdf', 'asdfasdfasdf', 'order', 5, NULL, NULL, NULL, '2025-07-21 22:52:05', '2025-07-21 22:52:05'),
(48, 'fdfdfd', 'sdfsdfsdf', 'order', 1, NULL, NULL, NULL, '2025-07-21 22:52:29', '2025-07-21 22:52:29'),
(49, 'fdfdfd', 'sdfsdfsdf', 'order', 2, NULL, NULL, NULL, '2025-07-21 22:52:29', '2025-07-21 22:52:29'),
(50, 'fdfdfd', 'sdfsdfsdf', 'order', 4, NULL, NULL, NULL, '2025-07-21 22:52:29', '2025-07-21 22:52:29'),
(51, 'fdfdfd', 'sdfsdfsdf', 'order', 5, NULL, NULL, NULL, '2025-07-21 22:52:29', '2025-07-21 22:52:29'),
(52, 'Order Approved', 'Your order #11 has been updated to approved.', 'order', 5, 11, NULL, NULL, '2025-07-27 17:58:44', '2025-07-27 17:58:44'),
(53, 'Order Order_packed', 'Your order #11 has been updated to order_packed.', 'order', 5, 11, NULL, NULL, '2025-07-27 17:59:06', '2025-07-27 17:59:06'),
(54, 'Order Update: Delivered', 'Your order #11 is now delivered', 'order', 5, 11, NULL, NULL, '2025-07-27 17:59:12', '2025-07-27 17:59:12'),
(55, 'Order Order_packed', 'Your order #10 has been updated to order_packed.', 'order', 5, 10, NULL, NULL, '2025-07-27 18:00:11', '2025-07-27 18:00:11'),
(56, 'Order Update: On the way', 'Your order #10 is now on the way', 'order', 5, 10, NULL, NULL, '2025-07-27 18:00:17', '2025-07-27 18:00:17'),
(57, 'Order Update: Delivered', 'Your order #10 is now delivered', 'order', 5, 10, NULL, NULL, '2025-08-08 14:04:25', '2025-08-08 14:04:25'),
(58, 'Order Approved', 'Your order #14 has been updated to approved.', 'order', 5, 14, NULL, NULL, '2025-08-20 14:36:09', '2025-08-20 14:36:09'),
(59, 'Order Pending', 'Your order #14 has been updated to pending.', 'order', 5, 14, NULL, NULL, '2025-08-20 14:36:20', '2025-08-20 14:36:20'),
(60, 'Order Order_packed', 'Your order #14 has been updated to order_packed.', 'order', 5, 14, NULL, NULL, '2025-08-20 14:36:28', '2025-08-20 14:36:28'),
(61, 'Order Update: Order placed', 'Your order #14 is now order placed', 'order', 5, 14, NULL, NULL, '2025-08-20 14:36:35', '2025-08-20 14:36:35'),
(62, 'Order Update: Delivered', 'Your order #14 is now delivered', 'order', 5, 14, NULL, NULL, '2025-08-20 14:36:49', '2025-08-20 14:36:49'),
(63, 'Order Approved', 'Your order #17 has been updated to approved.', 'order', 6, 17, NULL, NULL, '2025-08-24 11:28:18', '2025-08-24 11:28:18'),
(64, 'Order Order_packed', 'Your order #17 has been updated to order_packed.', 'order', 6, 17, NULL, NULL, '2025-08-24 11:28:38', '2025-08-24 11:28:38'),
(65, 'Order On_the_way', 'Your order #17 has been updated to on_the_way.', 'order', 6, 17, NULL, NULL, '2025-08-24 11:29:43', '2025-08-24 11:29:43'),
(66, 'Order Update: Delivered', 'Your order #17 is now delivered', 'order', 6, 17, NULL, NULL, '2025-08-24 11:32:15', '2025-08-24 11:32:15'),
(67, 'Order Approved', 'Your order #18 has been updated to approved.', 'order', 6, 18, NULL, NULL, '2025-08-28 19:48:46', '2025-08-28 19:48:46'),
(68, 'Order Pending', 'Your order #18 has been updated to pending.', 'order', 6, 18, NULL, NULL, '2025-12-27 20:53:15', '2025-12-27 20:53:15'),
(69, 'Order Delivered', 'Your order #18 has been updated to delivered.', 'order', 6, 18, NULL, NULL, '2025-12-29 11:19:17', '2025-12-29 11:19:17');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `buyer_name` varchar(255) DEFAULT NULL,
  `buyer_phone` varchar(255) DEFAULT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `recipient_phone` varchar(255) NOT NULL,
  `recipient_address` text NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_time` varchar(255) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` longblob NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `discount_amount` decimal(8,2) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gift_message` text DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_proof` varchar(255) DEFAULT NULL,
  `admin_commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `store_earnings` decimal(10,2) NOT NULL DEFAULT 0.00,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `store_id`, `buyer_name`, `buyer_phone`, `recipient_name`, `recipient_phone`, `recipient_address`, `delivery_date`, `delivery_time`, `total_price`, `status`, `created_at`, `updated_at`, `coupon_code`, `discount_amount`, `user_id`, `gift_message`, `payment_method`, `payment_status`, `payment_proof`, `admin_commission`, `store_earnings`, `city_id`) VALUES
(9, 1, NULL, NULL, '..', '..', '., ., ., .', '2025-07-13', '09:00 - 11:00 AM', 100.00, 0x70656e64696e67, '2025-07-11 23:00:09', '2025-07-12 15:29:28', NULL, NULL, 5, NULL, 'cliq', 'approved', 'uploads/payment_proofs/7TOo9u8joZUNLSTkGhTacBeHPsqwqw3KsSOKIQxa.jpg', 10.00, 90.00, NULL),
(13, 1, NULL, NULL, '.', '.', '., ., ., .', '2025-07-28', '09:00 - 11:00 AM', 300.00, 0x70656e64696e67, '2025-07-27 18:06:59', '2025-12-28 06:05:10', NULL, NULL, 5, NULL, 'cliq', 'rejected', 'uploads/payment_proofs/J2MXY9Swo8Ilwf1wV5mUjCYRZW9zBTVfFYTssVkL.jpg', 30.00, 270.00, NULL),
(15, 7, NULL, NULL, 'name', '079', 'irbid, x, x, x', '2025-08-23', '09:00 - 11:00 AM', 12.00, 0x70656e64696e67, '2025-08-22 12:13:35', '2025-08-22 12:13:35', NULL, NULL, 5, NULL, 'cliq', 'pending', NULL, 1.20, 10.80, 2),
(16, 7, NULL, NULL, 'name', '079', 'irbid, x, x, x', '2025-08-23', '09:00 - 11:00 AM', 24.00, 0x70656e64696e67, '2025-08-22 12:43:04', '2025-08-22 12:43:04', NULL, NULL, 5, NULL, 'cliq', 'pending', NULL, 2.40, 21.60, 2),
(17, 1, NULL, NULL, 'me', '0000000000', 'Aqaba, aqaba, aqaba, aqaba aqa', '2025-08-27', '01:00 - 03:00 PM', 1.00, 0x64656c697665726564, '2025-08-24 11:28:00', '2025-08-24 11:32:15', NULL, NULL, 6, 'just testing', 'cliq', 'pending', NULL, 0.10, 0.90, 3),
(18, 1, NULL, NULL, 'ana', '2222222222', 'Aqaba, لواء قصبة العقبة, aa, العقبة, قضاء العقبة, لواء قصبة العقبة, العقبة, 77100, الأردن', '2025-08-25', '09:00 - 11:00 AM', 200.00, 0x64656c697665726564, '2025-08-24 14:36:49', '2025-12-29 11:19:17', NULL, NULL, 6, 'test location', 'cliq', 'pending', NULL, 20.00, 180.00, 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(9, 9, 15, 1, '2025-07-11 23:00:09', '2025-07-11 23:00:09'),
(13, 13, 15, 3, '2025-07-27 18:06:59', '2025-07-27 18:06:59'),
(15, 15, 22, 1, '2025-08-22 12:13:35', '2025-08-22 12:13:35'),
(16, 16, 22, 2, '2025-08-22 12:43:04', '2025-08-22 12:43:04'),
(17, 17, 14, 1, '2025-08-24 11:28:00', '2025-08-24 11:28:00'),
(18, 18, 15, 2, '2025-08-24 14:36:49', '2025-08-24 14:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `created_at`, `updated_at`) VALUES
(1, 'About Us', 'about-us', 'Welcome to 3albal — Jordan’s premium destination for thoughtful gifting.\r\n\r\nAt 3albal, we believe in the power of thoughtful moments. Whether it\'s flowers, cakes, or a surprise gift, we help you deliver happiness straight to your loved ones\' doorstep.\r\n\r\nOur Vision: To become Jordan’s most trusted gift delivery platform.\r\nOur Mission: Empower local stores, simplify gifting, and bring joy to every delivery.123', '2025-06-25 21:22:58', '2025-12-28 06:08:20'),
(2, 'Terms of use', 'terms-of-use', 'By using the 3albal platform, you agree to these Terms of Use.\r\n\r\nOrders cannot be canceled once confirmed. Payments must be made in advance. We reserve the right to suspend any account for misuse.\r\n\r\nDelays can happen due to holidays or store capacity.\r\n\r\nAll content © 3albal. All rights reserved.', '2025-06-25 21:23:05', '2025-06-26 10:29:21'),
(3, 'Help & Support', 'help-support', 'Need help? We\'re here for you.\r\n\r\nContact us:\r\n- Live Chat in App\r\n- Email: support@3albalapp.com\r\n- Phone: +962-XXXX-XXXXXX\r\n\r\nVisit FAQ for quick answers .', '2025-06-25 21:23:38', '2025-12-27 21:21:34'),
(4, 'FAQ', 'faq', 'Q: Where is my order?\r\nA: Track it in the \'My Orders\' section.\r\n\r\nQ: How to use a coupon?\r\nA: Enter it during checkout.\r\n\r\nQ: Can I choose delivery time?\r\nA: Yes, choose from available slots.', '2025-06-25 21:23:44', '2025-12-27 21:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('abuainf2@gmail.com', '$2y$12$SK1.QRFoj4mB.ECV6cdawu5F5QVe3MEepgF2ahE2gYWOrrmvcWJWO', '2025-07-10 15:27:14'),
('y.abuain@gmail.com', '$2y$12$CynXcZ9y4yHNXy.biUHUUuhhpPPO6FTBPK0wdvJURT28LVjkbRgNO', '2025-07-09 15:57:01');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 4, 'auth_token', '4b5a024af7d81a44180d4b33c3e6801ea59c67abafb03ce65264a7763d7695f1', '[\"*\"]', '2025-10-20 20:39:00', NULL, '2025-06-27 12:47:51', '2025-10-20 20:39:00'),
(2, 'App\\Models\\User', 5, 'auth_token', 'dd4883423690c686e005fc7059c069430c604b91355e3c93ddd4afa5b007080a', '[\"*\"]', '2025-07-10 15:26:55', NULL, '2025-07-09 15:57:55', '2025-07-10 15:26:55'),
(3, 'App\\Models\\User', 5, 'auth_token', 'ef33cd3fd33729447dd64a63116403028ec4b355f0f20250e9d7a4be8464cd43', '[\"*\"]', '2025-08-08 14:06:39', NULL, '2025-07-10 15:28:02', '2025-08-08 14:06:39'),
(4, 'App\\Models\\User', 5, 'auth_token', 'bfd04f98beee4ca9529d9fe4142d4bef046422497e6f928252331c558fe0cbab', '[\"*\"]', '2025-08-23 17:45:37', NULL, '2025-08-20 13:43:49', '2025-08-23 17:45:37'),
(5, 'App\\Models\\User', 6, 'auth_token', 'c7510d4c1028353f0f0f7e82550b9058fa775517d596cac164bdccff33e9455c', '[\"*\"]', '2025-08-27 12:24:29', NULL, '2025-08-24 11:27:35', '2025-08-27 12:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `store_id`, `name`, `description`, `price`, `stock`, `status`, `image`, `created_at`, `updated_at`) VALUES
(13, 1, 1, 'saa1', 'sa', -0.05, -12, 'approved', 'products/fAHt9YJDxWpj4qaoBI7dsYP81Jb832vbmrsrlI3H.jpg', '2025-06-28 15:41:35', '2025-12-27 19:58:33'),
(14, 1, 1, 'Test 2', 'Testing flower', 1.00, 10, 'approved', 'products/HdiDjTqXDIyLs4uip6cC7kAbQVgmw7XDx3Ilj9b9.jpg', '2025-06-28 19:58:31', '2025-06-28 19:59:18'),
(15, 1, 1, 'testProduct', 'a test product', 100.00, 100, 'approved', 'products/Wm3tt8zII6CM5UTENHsAgeicZhKRleDOd6xsFfOh.jpg', '2025-07-09 16:18:46', '2025-07-09 16:19:19'),
(19, 2, 1, 'cake 1', 'asdf', 1.00, 100, 'approved', 'products/8E5auszT9V8zunYawEihjsP06h263yODOSUewrgn.jpg', '2025-08-19 09:38:32', '2025-08-19 09:39:14'),
(22, 1, 7, 'flowerx', 'asdfasdf', 12.00, 122, 'rejected', 'products/70510DnZMcjpYJWpSgs6SzmMnexOJhHrLALPGmgM.jpg', '2025-08-19 23:15:24', '2025-12-27 20:26:18'),
(23, 1, 1, 'product', 'this is new product', 1025.00, 4, 'rejected', 'products/70u1BRw4pEvqsH1l0lYWfrmMMWsthDlDrNkNRyKV.jpg', '2025-12-27 18:19:47', '2025-12-27 20:25:12'),
(24, 2, 1, 'product', 'th', 10.00, 5, 'approved', 'products/v5XhQ48rmlxlhLmEhiV6GUjcgByZ8p2v4nQG9Ejq.jpg', '2025-12-27 18:28:05', '2025-12-27 20:43:20'),
(25, 2, 1, 'sadsad', 'test', 0.09, 5, 'approved', 'products/6FASp5cKbrM0clJxQaibgvSXG1Ol713Od68ar7vE.png', '2025-12-27 18:28:08', '2025-12-27 23:46:53'),
(26, 1, 1, 'ntest', 'test', 15.00, -9, 'rejected', 'products/HLJah6BcwEeIUhkHHpi4acOzYnFrPq1aVpMVyCtO.jpg', '2025-12-27 18:30:05', '2025-12-27 20:43:07'),
(27, 1, 1, 'ntest', 'test', 15.00, 20, 'approved', 'products/0vPe8WL7vvMPyVJ5R0Kfw48DJ3qW17mNUNK1wMMA.jpg', '2025-12-27 18:30:56', '2025-12-27 20:23:06'),
(28, 3, 1, 'test Wafaa', 'test test test 1', 10.00, 4, 'approved', 'products/2jT9s3XJsVGNdqWYyQZncY2OTgnaUbjx4Wjv3zAL.jpg', '2025-12-27 23:52:47', '2025-12-27 23:54:36');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `path`, `created_at`, `updated_at`) VALUES
(8, 22, 'products/B2MyGbYnhKLPBKCURqrn8Qz997K34h8HDZZPCVvI.png', '2025-08-22 11:48:53', '2025-08-22 11:48:53'),
(9, 22, 'products/qtDrhLVnhC8wU8VB695vTlb9Q7gxIFPzxtolMXi5.jpg', '2025-08-22 11:48:57', '2025-08-22 11:48:57'),
(10, 23, 'products/oG3JvdR56ZmnRqUeI7AMnNTbQD6HdlASLqhJAQuD.png', '2025-12-27 18:19:47', '2025-12-27 18:19:47'),
(11, 24, 'products/juTMmYorndlPO1tCk2G0ZmoK7UFTJ1tr7Kbs7fNP.jpg', '2025-12-27 18:28:05', '2025-12-27 18:28:05'),
(12, 24, 'products/z6QvG8PtHYj32N7bFaOSPapmMXEUXew4s1qzkwa5.png', '2025-12-27 18:28:05', '2025-12-27 18:28:05'),
(13, 24, 'products/mqHLKiiF0UOC3TmNJqLto8Qxm169nAYNB4Uqpw3I.jpg', '2025-12-27 18:28:05', '2025-12-27 18:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(2, 5, 15, 5, NULL, '2025-07-10 17:31:31', '2025-07-10 17:31:31'),
(3, 5, 14, 5, 'perfect', '2025-07-27 18:08:47', '2025-12-27 21:22:19'),
(4, 5, 14, 5, 'asdfasf', '2025-07-27 18:09:02', '2025-07-27 18:09:02');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ZmiJUDnxknVOAsqDERClsDwFxuMMPwroNrPrNkmp', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVEFhNDBVTG1MMGt6TDlZUVRkWWpza0VEbjl5TFRnTXU0V0hZYVNXOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6MTA4MC9zdG9yZS1zYWxlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToidGVuYW50X2lkIjtpOjE7czo2OiJsb2NhbGUiO3M6MjoiYXIiO30=', 1770400986);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `theme` varchar(255) NOT NULL DEFAULT 'auto',
  `commission_paid` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `store_name`, `email`, `logo`, `password`, `created_at`, `updated_at`, `phone`, `address`, `instagram`, `facebook`, `whatsapp`, `theme`, `commission_paid`, `status`) VALUES
(1, 'testing store', '3albalistesting@codeela.com', 'stores/bbBJiLxAk1Uzy5L3qk6CWXpY2oBtY5zeTHXxNk5Z.jpg', '$2y$12$lFSXjOrsy6ibdNqQ0LxpiO8rwhZ4j469YXAKfzmttOrAJUg7MkV9a', '2025-06-19 14:35:35', '2025-12-28 06:52:21', '1231322222', 'no adress mr', NULL, NULL, '+963258741', 'light', 0, 'active'),
(7, 'store 2', 'store2@codeela.com', NULL, '$2y$12$Q3mB8NIwtr1lL/LgtOV12O.5ErcIzmIBaB9PPlY/m1a40dWak6bxy', '2025-08-19 17:11:27', '2025-08-19 17:11:27', '0780340300', 'Irbid, st123', NULL, NULL, NULL, 'light', 0, 'active'),
(10, 'Nevin store', 'nevin@gmail', NULL, '$2y$12$G3buTXIQxjY0bVV7kk5P3OoVoMXyNi4bcO7.1F1ggBSmySxm5AmY6', '2025-12-27 20:40:05', '2025-12-27 20:40:05', '0952222225', NULL, NULL, NULL, NULL, 'light', 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `store_payouts`
--

CREATE TABLE `store_payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `note` varchar(255) DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_payouts`
--

INSERT INTO `store_payouts` (`id`, `store_id`, `amount`, `commission`, `note`, `admin_id`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 1, 300.00, 30.00, 'Auto payout for remaining balance', 1, '2025-07-10 19:49:19', '2025-07-10 19:49:19', '2025-07-10 19:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `name`, `email`, `phone`, `logo_url`, `cover_image`, `type`, `is_active`, `approved_at`, `created_at`, `updated_at`) VALUES
('1', 'Salman', 'Salman@codeela.com', '1234567890', NULL, NULL, 'store', 1, NULL, '2025-06-28 15:39:22', '2025-06-28 15:39:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tenant_id` char(36) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','shop_owner','customer') NOT NULL DEFAULT 'customer',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `default_city_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `tenant_id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `is_active`, `default_city_id`) VALUES
(1, NULL, 'Admin User', 'moeadmin@codeela.com', NULL, NULL, '$2y$12$2dNgn8TGCmTWGJ4H0.OkLu5ooNuZdtS9fau7lLKKoPFrLm7YIKtD2', NULL, '2025-06-19 13:37:12', '2025-12-27 21:19:32', 'admin', 1, NULL),
(2, NULL, 'Store Owner', 'store@example.com', NULL, NULL, '$2y$12$5..IuBVWyQF/6U0du/f9wuJadriPZ73vmGfb0uWLCWas0m0GxsHoi', NULL, '2025-06-19 13:38:50', '2025-06-19 13:38:50', 'shop_owner', 1, NULL),
(4, NULL, 'Yazan Abuain', 'y.abuain@gmail.com', '0798928008', NULL, '$2y$12$GGdk01JbCHYs/P6afamJ2.JNaeeRJwinGuqdqDbuSRVqQC0oZESgy', NULL, '2025-06-27 12:47:51', '2025-12-27 21:16:53', 'customer', 1, NULL),
(5, NULL, 'Yazan Abuain', 'abuainf2@gmail.com', '123123123', NULL, '$2y$12$OP0kA6uYbqzRx/psIsl0JOmOc0sVUmXmAgvhPyF/20etKQhv0KSVi', NULL, '2025-07-09 15:57:55', '2025-12-28 06:21:31', 'shop_owner', 1, NULL),
(6, NULL, 'moe', 'moe@testing.com', '00000000000', NULL, '$2y$12$p3bNf80A2vS2txHrxV45tuSpQTAn0KXE5A6Xl4gLw8.CBpOUTKc02', NULL, '2025-08-24 11:27:35', '2025-12-29 11:13:16', 'admin', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

CREATE TABLE `user_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'system',
  `related_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `sent_by` varchar(255) NOT NULL DEFAULT 'system',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_messages`
--

INSERT INTO `user_messages` (`id`, `user_id`, `title`, `body`, `type`, `related_order_id`, `is_read`, `sent_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Support Replied', 'ok', 'support', NULL, 0, 'support_agent', '2025-06-19 18:36:40', '2025-06-19 18:36:40'),
(2, 4, 'Support Replied', 'hello how can I help you', 'support', NULL, 1, 'support_agent', '2025-06-27 12:49:16', '2025-07-27 18:16:48'),
(3, 4, 'Support Replied', 'hi', 'support', NULL, 1, 'support_agent', '2025-07-09 18:38:38', '2025-07-27 18:16:58'),
(4, 4, 'Support Replied', 'hi', 'support', NULL, 1, 'support_agent', '2025-07-09 18:38:48', '2025-07-27 18:16:59'),
(5, 5, 'Support Replied', '....', 'support', NULL, 1, 'support_agent', '2025-07-10 15:02:34', '2025-07-10 17:17:43'),
(6, 5, 'Support Replied', 'hi from live support', 'support', NULL, 1, 'support_agent', '2025-07-10 15:02:48', '2025-07-10 17:17:40'),
(7, 5, 'Support Replied', 'hihihi', 'support', NULL, 1, 'support_agent', '2025-07-10 18:12:20', '2025-07-21 22:33:39'),
(8, 5, 'Support Replied', 'asdfasdf', 'support', NULL, 1, 'support_agent', '2025-07-10 18:18:50', '2025-07-21 22:33:51'),
(9, 5, 'Order Order_placed', 'Your order #9 status is now: order_placed.', 'order', 9, 1, 'system', '2025-07-12 15:28:34', '2025-07-21 22:33:54'),
(10, 5, 'Order Order_packed', 'Your order #9 status is now: order_packed.', 'order', 9, 1, 'system', '2025-07-12 15:28:42', '2025-07-21 22:33:57'),
(11, 5, 'Order Delivered', 'Your order #9 status is now: delivered.', 'order', 9, 1, 'system', '2025-07-12 15:28:50', '2025-07-21 22:34:01'),
(12, 5, 'Order Delivered', 'Your order #11 status is now: delivered.', 'order', NULL, 1, 'system', '2025-07-27 17:59:12', '2025-07-27 17:59:38'),
(13, 5, 'Order On_the_way', 'Your order #10 status is now: on_the_way.', 'order', NULL, 1, 'system', '2025-07-27 18:00:17', '2025-07-27 18:00:58'),
(14, 5, 'Support Replied', 'hi', 'support', NULL, 1, 'support_agent', '2025-07-28 10:39:54', '2025-07-28 11:56:48'),
(15, 5, 'Support Replied', 'a message from the admin panel', 'support', NULL, 1, 'support_agent', '2025-07-28 10:40:49', '2025-07-28 11:56:45'),
(16, 5, 'Support Replied', 'kjkj', 'support', NULL, 1, 'support_agent', '2025-07-28 10:49:43', '2025-07-28 10:49:50'),
(17, 5, 'Support Replied', 'asdfasdf', 'support', NULL, 1, 'support_agent', '2025-07-28 10:50:09', '2025-07-28 11:56:40'),
(18, 5, 'Support Replied', 'asdfaf', 'support', NULL, 1, 'support_agent', '2025-07-28 10:56:01', '2025-07-28 11:56:36'),
(19, 5, 'Support Replied', 'hello', 'support', NULL, 1, 'support_agent', '2025-07-28 12:00:00', '2025-07-28 12:32:20'),
(20, 5, 'Support Replied', 'admin', 'support', NULL, 1, 'support_agent', '2025-07-28 12:00:22', '2025-07-28 12:32:17'),
(21, 5, 'Support Replied', 'test test', 'support', NULL, 1, 'support_agent', '2025-07-28 12:24:33', '2025-07-28 12:32:13'),
(22, 5, 'Support Replied', 'hello from admin panel', 'support', NULL, 1, 'support_agent', '2025-07-28 12:33:12', '2025-07-29 16:45:01'),
(23, 5, 'Support Replied', 'hello from admin panel', 'support', NULL, 1, 'support_agent', '2025-07-29 16:45:39', '2025-07-29 16:59:14'),
(24, 5, 'Support Replied', 'hello from admin panel', 'support', NULL, 1, 'support_agent', '2025-07-29 16:47:51', '2025-07-29 16:59:12'),
(25, 5, 'Support Replied', 'a message from the admin panel', 'support', NULL, 1, 'support_agent', '2025-07-29 17:05:52', '2025-08-03 19:34:55'),
(26, 5, 'Support Replied', 'hello', 'support', NULL, 1, 'support_agent', '2025-07-29 17:13:06', '2025-08-03 19:34:53'),
(27, 5, 'Support Replied', 'a message from admin', 'support', NULL, 1, 'support_agent', '2025-07-29 17:48:12', '2025-08-03 19:34:50'),
(28, 5, 'Support Replied', 'hello from admin panel', 'support', NULL, 1, 'support_agent', '2025-07-29 17:58:11', '2025-08-03 19:34:48'),
(29, 5, 'Order Delivered', 'Your order #10 status is now: delivered.', 'order', NULL, 1, 'system', '2025-08-08 14:04:25', '2025-08-20 13:44:00'),
(30, 5, 'Order Order_placed', 'Your order #14 status is now: order_placed.', 'order', NULL, 1, 'system', '2025-08-20 14:36:35', '2025-08-20 14:56:58'),
(31, 5, 'Order Delivered', 'Your order #14 status is now: delivered.', 'order', NULL, 1, 'system', '2025-08-20 14:36:49', '2025-08-20 14:56:56'),
(32, 6, 'Order Delivered', 'Your order #17 status is now: delivered.', 'order', 17, 0, 'system', '2025-08-24 11:32:15', '2025-08-24 11:32:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_name_unique` (`name`),
  ADD UNIQUE KEY `cities_slug_unique` (`slug`);

--
-- Indexes for table `city_store`
--
ALTER TABLE `city_store`
  ADD PRIMARY KEY (`store_id`,`city_id`),
  ADD KEY `city_store_city_id_foreign` (`city_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `coupon_user`
--
ALTER TABLE `coupon_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_user_user_id_foreign` (`user_id`),
  ADD KEY `coupon_user_coupon_id_foreign` (`coupon_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_settings`
--
ALTER TABLE `global_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_chats`
--
ALTER TABLE `live_chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `live_chats_user_id_foreign` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_order_id_foreign` (`order_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_store_id_foreign` (`store_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_city_id_index` (`city_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_order_id_foreign` (`order_id`),
  ADD KEY `order_product_product_id_foreign` (`product_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_store_id_foreign` (`store_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_sort_order_index` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stores_email_unique` (`email`);

--
-- Indexes for table `store_payouts`
--
ALTER TABLE `store_payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_payouts_store_id_foreign` (`store_id`),
  ADD KEY `store_payouts_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenants_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_default_city_id_index` (`default_city_id`);

--
-- Indexes for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_messages_user_id_foreign` (`user_id`),
  ADD KEY `user_messages_related_order_id_foreign` (`related_order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coupon_user`
--
ALTER TABLE `coupon_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `global_settings`
--
ALTER TABLE `global_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `live_chats`
--
ALTER TABLE `live_chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `store_payouts`
--
ALTER TABLE `store_payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_messages`
--
ALTER TABLE `user_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `city_store`
--
ALTER TABLE `city_store`
  ADD CONSTRAINT `city_store_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `city_store_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_user`
--
ALTER TABLE `coupon_user`
  ADD CONSTRAINT `coupon_user_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `live_chats`
--
ALTER TABLE `live_chats`
  ADD CONSTRAINT `live_chats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `store_payouts`
--
ALTER TABLE `store_payouts`
  ADD CONSTRAINT `store_payouts_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `store_payouts_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_default_city_id_foreign` FOREIGN KEY (`default_city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD CONSTRAINT `user_messages_related_order_id_foreign` FOREIGN KEY (`related_order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
