-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 18, 2025 at 06:07 PM
-- Server version: 10.11.11-MariaDB-0+deb12u1
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goldManagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `target_table` varchar(100) DEFAULT NULL,
  `target_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bareme_designation_carats`
--

CREATE TABLE `bareme_designation_carats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `carat` decimal(5,2) UNSIGNED NOT NULL,
  `density_min` decimal(5,2) NOT NULL,
  `density_max` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bareme_designation_carats`
--

INSERT INTO `bareme_designation_carats` (`id`, `carat`, `density_min`, `density_max`, `created_at`, `updated_at`) VALUES
(3, 24.00, 19.30, 19.40, '2025-07-10 19:32:06', '2025-07-10 19:32:06'),
(4, 23.75, 19.20, 19.20, '2025-07-10 19:32:28', '2025-07-10 19:32:28'),
(5, 23.60, 19.10, 19.10, '2025-07-10 19:32:56', '2025-07-10 19:32:56'),
(6, 23.40, 18.97, 19.00, '2025-07-10 19:33:23', '2025-07-10 19:33:23'),
(7, 23.30, 18.91, 18.96, '2025-07-10 19:34:36', '2025-07-10 19:34:36'),
(8, 23.20, 18.84, 18.90, '2025-07-10 19:35:07', '2025-07-10 19:35:07'),
(9, 23.10, 18.78, 18.83, '2025-07-10 19:35:31', '2025-07-10 19:35:31'),
(10, 23.00, 18.72, 18.77, '2025-07-10 19:36:16', '2025-07-10 19:36:16'),
(11, 22.90, 18.65, 18.71, '2025-07-10 19:36:44', '2025-07-10 19:36:44'),
(12, 22.80, 18.59, 18.64, '2025-07-10 19:37:22', '2025-07-10 19:37:22'),
(13, 22.70, 18.53, 18.58, '2025-07-10 19:37:53', '2025-07-10 19:37:53'),
(14, 22.60, 18.47, 18.52, '2025-07-10 19:38:45', '2025-07-10 19:45:46'),
(15, 22.50, 18.41, 18.46, '2025-07-10 19:47:01', '2025-07-10 19:47:01'),
(16, 22.40, 18.34, 18.40, '2025-07-10 19:47:46', '2025-07-10 19:47:46'),
(17, 22.30, 18.28, 18.33, '2025-07-10 19:49:02', '2025-07-10 19:49:02'),
(18, 22.20, 18.27, 18.22, '2025-07-10 19:50:14', '2025-07-10 19:50:14'),
(19, 22.10, 18.16, 18.21, '2025-07-10 19:50:43', '2025-07-10 19:50:43'),
(20, 22.00, 18.10, 18.15, '2025-07-10 19:51:00', '2025-07-10 19:51:00');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_admin@example.com|127.0.0.1', 'i:1;', 1752600622),
('laravel_cache_admin@example.com|127.0.0.1:timer', 'i:1752600622;', 1752600622),
('laravel_cache_admin1@gmail.com|127.0.0.1', 'i:1;', 1752600389),
('laravel_cache_admin1@gmail.com|127.0.0.1:timer', 'i:1752600389;', 1752600389),
('laravel_cache_kizzamagassa@gmail.com|127.0.0.1', 'i:1;', 1752600019),
('laravel_cache_kizzamagassa@gmail.com|127.0.0.1:timer', 'i:1752600019;', 1752600019),
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:98:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:30:\"viewAny exchange_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:27:\"view exchange_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:29:\"create exchange_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:29:\"update exchange_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:29:\"delete exchange_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:30:\"restore exchange_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:34:\"forceDelete exchange_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:31:\"viewAny gold_inventory_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:28:\"view gold_inventory_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:30:\"create gold_inventory_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:30:\"update gold_inventory_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:30:\"delete gold_inventory_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:31:\"restore gold_inventory_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:35:\"forceDelete gold_inventory_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:34:\"viewAny gold_market_price_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:31:\"view gold_market_price_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:33:\"create gold_market_price_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:33:\"update gold_market_price_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:33:\"delete gold_market_price_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:34:\"restore gold_market_price_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:38:\"forceDelete gold_market_price_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:26:\"viewAny gold_sale_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:23:\"view gold_sale_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:25:\"create gold_sale_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:25:\"update gold_sale_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:25:\"delete gold_sale_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:26:\"restore gold_sale_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:30:\"forceDelete gold_sale_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:30:\"viewAny gold_shipment_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:27:\"view gold_shipment_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:29:\"create gold_shipment_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:29:\"update gold_shipment_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:29:\"delete gold_shipment_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:30:\"restore gold_shipment_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:34:\"forceDelete gold_shipment_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:36:\"viewAny local_gold_purchase_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:33:\"view local_gold_purchase_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:35:\"create local_gold_purchase_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:35:\"update local_gold_purchase_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:35:\"delete local_gold_purchase_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:36:\"restore local_gold_purchase_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:40:\"forceDelete local_gold_purchase_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:27:\"viewAny local_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:24:\"view local_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:26:\"create local_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:26:\"update local_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:26:\"delete local_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:27:\"restore local_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:31:\"forceDelete local_rate_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:32:\"viewAny refining_batche_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:29:\"view refining_batche_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:31:\"create refining_batche_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:31:\"update refining_batche_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:31:\"delete refining_batche_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:32:\"restore refining_batche_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:36:\"forceDelete refining_batche_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:30:\"viewAny shipment_item_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:27:\"view shipment_item_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:29:\"create shipment_item_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:29:\"update shipment_item_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:29:\"delete shipment_item_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:30:\"restore shipment_item_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:34:\"forceDelete shipment_item_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:25:\"viewAny supplier_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:22:\"view supplier_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:24:\"create supplier_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:24:\"update supplier_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:24:\"delete supplier_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:25:\"restore supplier_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:29:\"forceDelete supplier_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:28:\"viewAny transaction_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:25:\"view transaction_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:27:\"create transaction_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:27:\"update transaction_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:27:\"delete transaction_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:28:\"restore transaction_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:32:\"forceDelete transaction_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:21:\"viewAny role_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:18:\"view role_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:20:\"create role_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:20:\"update role_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:20:\"delete role_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:21:\"restore role_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:25:\"forceDelete role_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:41:\"viewAny bareme_designation_carat_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:38:\"view bareme_designation_carat_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:40:\"create bareme_designation_carat_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:40:\"update bareme_designation_carat_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:40:\"delete bareme_designation_carat_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:41:\"restore bareme_designation_carat_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:45:\"forceDelete bareme_designation_carat_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:27:\"viewAny fonte_gold_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:24:\"view fonte_gold_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:26:\"create fonte_gold_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:26:\"update fonte_gold_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:26:\"delete fonte_gold_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:27:\"restore fonte_gold_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:97;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:31:\"forceDelete fonte_gold_resource\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}}}', 1752923187);

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
-- Table structure for table `exchange_rates`
--

CREATE TABLE `exchange_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_currency` varchar(10) NOT NULL,
  `to_currency` varchar(10) NOT NULL,
  `rate` decimal(10,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `fonte_gold`
--

CREATE TABLE `fonte_gold` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `weight_total_after_fonte` decimal(8,2) NOT NULL,
  `weight_total_before_fonte` decimal(8,2) NOT NULL,
  `court_fonte` decimal(8,2) NOT NULL,
  `purity_estimated` decimal(5,2) DEFAULT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `fonte_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fonte_gold_items`
--

CREATE TABLE `fonte_gold_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `court` varchar(255) NOT NULL,
  `poids` varchar(255) NOT NULL,
  `date_fonte` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gold_inventorys`
--

CREATE TABLE `gold_inventorys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `court` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gold_inventory_items`
--

CREATE TABLE `gold_inventory_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `court` decimal(10,2) NOT NULL,
  `weight_available` decimal(10,2) NOT NULL,
  `gold_inventory_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gold_market_prices`
--

CREATE TABLE `gold_market_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `price_per_gram_usd` decimal(10,2) NOT NULL,
  `source` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gold_sales`
--

CREATE TABLE `gold_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED NOT NULL,
  `buyer_name` varchar(100) NOT NULL,
  `weight_sold` decimal(10,2) NOT NULL,
  `price_per_gram` decimal(10,2) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `sale_date` date NOT NULL,
  `payment_status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `invoice_number` varchar(100) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gold_shipments`
--

CREATE TABLE `gold_shipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_code` varchar(255) NOT NULL,
  `total_weight` decimal(10,2) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `status` enum('prepare','en_transit','livre') NOT NULL DEFAULT 'prepare',
  `tracking_number` varchar(255) DEFAULT NULL,
  `carrier_name` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `local_gold_purchases`
--

CREATE TABLE `local_gold_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `payment_status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `receipt_reference` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `local_gold_purchases`
--

INSERT INTO `local_gold_purchases` (`id`, `supplier_id`, `purchase_date`, `payment_status`, `agent_id`, `receipt_reference`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-07-16', 'paid', 1, '12345', '2025-07-16 17:04:47', '2025-07-16 20:18:37'),
(2, 1, '2025-07-18', 'paid', 1, '123456789', '2025-07-18 11:17:47', '2025-07-18 11:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `local_gold_purchase_items`
--

CREATE TABLE `local_gold_purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `weight_grams_min` decimal(8,2) NOT NULL,
  `weight_grams_max` decimal(8,2) NOT NULL,
  `densite` decimal(8,2) NOT NULL,
  `purity_estimated` decimal(5,2) DEFAULT NULL,
  `price_per_gram_local` decimal(10,2) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `bareme_designation_carat_id` bigint(20) UNSIGNED NOT NULL,
  `local_rate` decimal(20,0) UNSIGNED NOT NULL,
  `local_gold_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `local_gold_purchase_items`
--

INSERT INTO `local_gold_purchase_items` (`id`, `weight_grams_min`, `weight_grams_max`, `densite`, `purity_estimated`, `price_per_gram_local`, `total_price`, `bareme_designation_carat_id`, `local_rate`, `local_gold_purchase_id`, `created_at`, `updated_at`) VALUES
(13, 11.47, 12.14, 18.12, 91.67, 56283.33, 745396.00, 20, 61400, 1, '2025-07-16 20:18:37', '2025-07-16 20:18:37'),
(14, 11.50, 12.14, 18.97, 97.50, 60157.50, 749038.00, 6, 61700, 1, '2025-07-16 20:18:37', '2025-07-16 20:18:37'),
(15, 11.48, 12.14, 18.39, 93.33, 57306.67, 745396.00, 16, 61400, 1, '2025-07-16 20:18:37', '2025-07-16 20:18:37'),
(16, 11.47, 12.11, 18.92, 97.08, 59609.17, 743554.00, 7, 61400, 1, '2025-07-16 20:18:37', '2025-07-16 20:18:37'),
(17, 11.47, 12.14, 18.12, 91.67, 56375.00, 746610.00, 20, 61500, 2, '2025-07-18 11:17:47', '2025-07-18 11:17:47'),
(18, 11.50, 12.14, 18.97, 97.50, 59865.00, 745396.00, 6, 61400, 2, '2025-07-18 11:17:47', '2025-07-18 11:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `local_rates`
--

CREATE TABLE `local_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rate_per_gram` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `effective_date` date NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `local_rates`
--

INSERT INTO `local_rates` (`id`, `rate_per_gram`, `currency`, `effective_date`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 61400.00, 'XOF', '2025-07-16', 1, '2025-07-16 15:54:53', '2025-07-16 15:54:53');

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
(4, '2025_07_09_155350_create_suppliers_table', 1),
(5, '2025_07_09_155539_create_local_rates_table', 1),
(6, '2025_07_09_155629_create_local_gold_purchases_table', 1),
(7, '2025_07_09_155859_create_gold_inventories_table', 1),
(8, '2025_07_09_160022_create_gold_shipments_table', 1),
(9, '2025_07_09_160204_create_shipment_items_table', 1),
(10, '2025_07_09_160242_create_gold_market_prices_table', 1),
(11, '2025_07_09_160327_create_gold_sales_table', 1),
(12, '2025_07_09_160358_create_exchange_rates_table', 1),
(13, '2025_07_09_160435_create_transactions_table', 1),
(14, '2025_07_09_160510_create_audit_logs_table', 1),
(15, '2025_07_09_161611_create_permission_tables', 1),
(16, '2025_07_10_204042_create_fonte_gold_table', 1),
(17, '2025_07_15_160152_create_fonte_gold_items_table', 1),
(18, '2025_07_15_164252_create_gold_inventory_items_table', 1),
(19, '2025_07_9_155518_create_bareme_designation_carats_table', 1),
(20, '2025_07_15_150937_create_local_gold_purchase_items_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'viewAny exchange_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(2, 'view exchange_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(3, 'create exchange_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(4, 'update exchange_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(5, 'delete exchange_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(6, 'restore exchange_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(7, 'forceDelete exchange_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(8, 'viewAny gold_inventory_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(9, 'view gold_inventory_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(10, 'create gold_inventory_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(11, 'update gold_inventory_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(12, 'delete gold_inventory_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(13, 'restore gold_inventory_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(14, 'forceDelete gold_inventory_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(15, 'viewAny gold_market_price_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(16, 'view gold_market_price_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(17, 'create gold_market_price_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(18, 'update gold_market_price_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(19, 'delete gold_market_price_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(20, 'restore gold_market_price_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(21, 'forceDelete gold_market_price_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(22, 'viewAny gold_sale_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(23, 'view gold_sale_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(24, 'create gold_sale_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(25, 'update gold_sale_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(26, 'delete gold_sale_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(27, 'restore gold_sale_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(28, 'forceDelete gold_sale_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(29, 'viewAny gold_shipment_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(30, 'view gold_shipment_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(31, 'create gold_shipment_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(32, 'update gold_shipment_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(33, 'delete gold_shipment_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(34, 'restore gold_shipment_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(35, 'forceDelete gold_shipment_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(36, 'viewAny local_gold_purchase_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(37, 'view local_gold_purchase_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(38, 'create local_gold_purchase_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(39, 'update local_gold_purchase_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(40, 'delete local_gold_purchase_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(41, 'restore local_gold_purchase_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(42, 'forceDelete local_gold_purchase_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(43, 'viewAny local_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(44, 'view local_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(45, 'create local_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(46, 'update local_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(47, 'delete local_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(48, 'restore local_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(49, 'forceDelete local_rate_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(50, 'viewAny refining_batche_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(51, 'view refining_batche_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(52, 'create refining_batche_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(53, 'update refining_batche_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(54, 'delete refining_batche_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(55, 'restore refining_batche_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(56, 'forceDelete refining_batche_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(57, 'viewAny shipment_item_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(58, 'view shipment_item_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(59, 'create shipment_item_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(60, 'update shipment_item_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(61, 'delete shipment_item_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(62, 'restore shipment_item_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(63, 'forceDelete shipment_item_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(64, 'viewAny supplier_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(65, 'view supplier_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(66, 'create supplier_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(67, 'update supplier_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(68, 'delete supplier_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(69, 'restore supplier_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(70, 'forceDelete supplier_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(71, 'viewAny transaction_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(72, 'view transaction_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(73, 'create transaction_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(74, 'update transaction_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(75, 'delete transaction_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(76, 'restore transaction_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(77, 'forceDelete transaction_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(78, 'viewAny role_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(79, 'view role_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(80, 'create role_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(81, 'update role_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(82, 'delete role_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(83, 'restore role_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(84, 'forceDelete role_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(85, 'viewAny bareme_designation_carat_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(86, 'view bareme_designation_carat_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(87, 'create bareme_designation_carat_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(88, 'update bareme_designation_carat_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(89, 'delete bareme_designation_carat_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(90, 'restore bareme_designation_carat_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(91, 'forceDelete bareme_designation_carat_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(92, 'viewAny fonte_gold_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(93, 'view fonte_gold_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(94, 'create fonte_gold_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(95, 'update fonte_gold_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(96, 'delete fonte_gold_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(97, 'restore fonte_gold_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55'),
(98, 'forceDelete fonte_gold_resource', 'web', '2025-07-16 13:46:55', '2025-07-16 13:46:55');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-07-15 17:37:03', '2025-07-15 17:37:03');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1);

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
('245IHMG5y6Luq4SCNaZn5Ci1qD8UI1qsdpFhq39E', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVWFKbW9KRGdBNnRxVXVja1F2aEZvbDB1TWxUc2c4WXZ3UkVJQm9wOCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2MzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2xvY2FsLWdvbGQtcHVyY2hhc2UtcmVzb3VyY2UvZWRpdC8xIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2NhbC1nb2xkLXB1cmNoYXNlLXJlc291cmNlL2VkaXQvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752691455),
('64DkWyvJcCQNbQQXnBaZtII89S4Pp6uRfR09kfUJ', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXl4RU03VEFtUWJuTHJoRlA2YTJQRXp0STBQZExBSGtDZDkyeE9qbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752691455),
('e25LjG1GihYF3DluNTceY7vRAva2eRdvN2WrsW7a', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMFFBenQzZGhmYVJORVcwRzRGY2E5eTB5S2hhSGxycUlucW5uUTFpbSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2MzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2xvY2FsLWdvbGQtcHVyY2hhc2UtcmVzb3VyY2UvZWRpdC8xIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2NhbC1nb2xkLXB1cmNoYXNlLXJlc291cmNlL2VkaXQvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752692115),
('Gz5R4RYUkNWdepAGq8Kycxft3UMsYD3401gzG1gE', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic01vR3FTd1QxYnNHSmZ4dFcwcUwwc050UENzWXA1THZSUGJKYVJrbyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2xvY2FsLWdvbGQtcHVyY2hhc2UtcmVzb3VyY2UvMiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752837872),
('qlKjVahnxpZFQftlBb2kBEnPzHv6y8sL4RMkkvWh', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoia0tBNFM1RTRWUWd0Smt3S3Y3UHFaRHpkb2drdm5lbHhyZVZWYkI2NyI7czozOiJ1cmwiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2NhbC1nb2xkLXB1cmNoYXNlLXJlc291cmNlLzEiO319', 1752699665),
('zhuHpvIE2qHka9l7uJm1BMiMlXRx0G7OWNh0xyyf', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMlV6RnJ2a3d6ekQ3OUxYRTFIT0gyRmFiWFVoQTJNOHg3WkhuZ0NJdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752692115);

-- --------------------------------------------------------

--
-- Table structure for table `shipment_items`
--

CREATE TABLE `shipment_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('orpailleur_individuel','cooperative','intermediaire') NOT NULL,
  `contact_info` text DEFAULT NULL,
  `identification_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `type`, `contact_info`, `identification_number`, `created_at`, `updated_at`) VALUES
(1, 'Malle Magassa', 'orpailleur_individuel', '92693269', '12345', '2025-07-16 16:45:19', '2025-07-16 16:45:19');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('achat_local','traitement','transport','vente') NOT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `exchange_rate_used` decimal(10,4) DEFAULT NULL,
  `date` date NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Malle Magassa', 'magassamalle82@gmail.com', NULL, '$2y$12$3xiqYVUBMi/JlWe0jxw8M.4mpRlXVBRqR1cfwypiaftAJyHozUgPK', 'u9uAmGm5rprJstYqKwuh2Z3QddUHuUUQLlY0RNNKVHBo1J1WfPPRlVtFUOIc', '2025-07-15 17:40:25', '2025-07-15 17:40:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `bareme_designation_carats`
--
ALTER TABLE `bareme_designation_carats`
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
-- Indexes for table `exchange_rates`
--
ALTER TABLE `exchange_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fonte_gold`
--
ALTER TABLE `fonte_gold`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fonte_gold_items`
--
ALTER TABLE `fonte_gold_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gold_inventorys`
--
ALTER TABLE `gold_inventorys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gold_inventory_items`
--
ALTER TABLE `gold_inventory_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gold_market_prices`
--
ALTER TABLE `gold_market_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gold_sales`
--
ALTER TABLE `gold_sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gold_sales_invoice_number_unique` (`invoice_number`),
  ADD KEY `gold_sales_shipment_id_foreign` (`shipment_id`),
  ADD KEY `gold_sales_created_by_foreign` (`created_by`);

--
-- Indexes for table `gold_shipments`
--
ALTER TABLE `gold_shipments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gold_shipments_shipment_code_unique` (`shipment_code`),
  ADD KEY `gold_shipments_created_by_foreign` (`created_by`);

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
-- Indexes for table `local_gold_purchases`
--
ALTER TABLE `local_gold_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `local_gold_purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `local_gold_purchases_agent_id_foreign` (`agent_id`);

--
-- Indexes for table `local_gold_purchase_items`
--
ALTER TABLE `local_gold_purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `local_gold_purchase_items_bareme_designation_carat_id_foreign` (`bareme_designation_carat_id`),
  ADD KEY `local_gold_purchase_items_local_rate_id_foreign` (`local_rate`),
  ADD KEY `local_gold_purchase_items_local_gold_purchase_id_foreign` (`local_gold_purchase_id`);

--
-- Indexes for table `local_rates`
--
ALTER TABLE `local_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `local_rates_created_by_foreign` (`created_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shipment_items`
--
ALTER TABLE `shipment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipment_items_shipment_id_foreign` (`shipment_id`),
  ADD KEY `shipment_items_inventory_id_foreign` (`inventory_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_identification_number_unique` (`identification_number`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_created_by_foreign` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bareme_designation_carats`
--
ALTER TABLE `bareme_designation_carats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `exchange_rates`
--
ALTER TABLE `exchange_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fonte_gold`
--
ALTER TABLE `fonte_gold`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fonte_gold_items`
--
ALTER TABLE `fonte_gold_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gold_inventorys`
--
ALTER TABLE `gold_inventorys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gold_inventory_items`
--
ALTER TABLE `gold_inventory_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gold_market_prices`
--
ALTER TABLE `gold_market_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gold_sales`
--
ALTER TABLE `gold_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gold_shipments`
--
ALTER TABLE `gold_shipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `local_gold_purchases`
--
ALTER TABLE `local_gold_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `local_gold_purchase_items`
--
ALTER TABLE `local_gold_purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `local_rates`
--
ALTER TABLE `local_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipment_items`
--
ALTER TABLE `shipment_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `gold_sales`
--
ALTER TABLE `gold_sales`
  ADD CONSTRAINT `gold_sales_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `gold_sales_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `gold_shipments` (`id`);

--
-- Constraints for table `gold_shipments`
--
ALTER TABLE `gold_shipments`
  ADD CONSTRAINT `gold_shipments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `local_gold_purchases`
--
ALTER TABLE `local_gold_purchases`
  ADD CONSTRAINT `local_gold_purchases_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `local_gold_purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `local_gold_purchase_items`
--
ALTER TABLE `local_gold_purchase_items`
  ADD CONSTRAINT `local_gold_purchase_items_bareme_designation_carat_id_foreign` FOREIGN KEY (`bareme_designation_carat_id`) REFERENCES `bareme_designation_carats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `local_gold_purchase_items_local_gold_purchase_id_foreign` FOREIGN KEY (`local_gold_purchase_id`) REFERENCES `local_gold_purchases` (`id`);

--
-- Constraints for table `local_rates`
--
ALTER TABLE `local_rates`
  ADD CONSTRAINT `local_rates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipment_items`
--
ALTER TABLE `shipment_items`
  ADD CONSTRAINT `shipment_items_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `gold_inventorys` (`id`),
  ADD CONSTRAINT `shipment_items_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `gold_shipments` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
