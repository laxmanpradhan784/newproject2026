-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2026 at 05:29 AM
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
-- Database: `e-database`
--

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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `guest_token` varchar(255) DEFAULT NULL,
  `is_guest` tinyint(1) DEFAULT 0,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `guest_token`, `is_guest`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(141, NULL, 'IzILGB0hZDdNeocj2l52dtKpPYTLgnkrLZRmbx0x', 'ngj0Kiym8WJMruGpxUdec0zu8p6GkonQ', 1, 62, 1, 10.00, '2026-01-31 02:01:11', '2026-01-31 02:01:11'),
(163, 11, NULL, NULL, 0, 9, 1, 349.00, '2026-02-02 01:18:47', '2026-02-02 01:18:47'),
(166, 11, NULL, NULL, 0, 65, 1, 7999.00, '2026-02-02 04:00:36', '2026-02-02 04:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'electronics', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-15 03:30:00', '2024-01-15 03:30:00'),
(2, 'Fashion', 'fashion', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-16 05:00:00', '2024-01-16 05:00:00'),
(3, 'Home & Kitchen', 'home-kitchen', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-17 05:45:00', '2024-01-17 05:45:00'),
(4, 'Beauty & Personal Care', 'beauty-personal-care', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-18 08:50:00', '2024-01-18 08:50:00'),
(5, 'Books & Stationery', 'books-stationery', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-19 11:15:00', '2024-01-19 11:15:00'),
(6, 'Sports & Fitness', 'sports-fitness', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-20 06:40:00', '2026-01-31 02:02:12'),
(7, 'Toys & Games', 'toys-games', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-21 10:00:00', '2026-01-28 04:19:51'),
(8, 'Automotive', 'automotive', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-22 04:30:00', '2026-01-31 02:02:11'),
(9, 'Groceries', 'groceries', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-23 07:55:00', '2026-01-30 06:07:03'),
(10, 'Healthcare', 'healthcare', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-24 12:30:00', '2026-01-28 04:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Rajesh Kumar', 'rajesh.kumar@example.com', 'Product Inquiry', 'Hello, I would like to know more about your premium subscription plans and the features included.', '2024-01-15 05:00:00', '2024-01-15 05:00:00'),
(2, 'Priya Sharma', 'priya.sharma22@example.com', 'Customer Support', 'My order #45678 has not been delivered yet. It was supposed to arrive last Monday. Can you please check the status?', '2024-01-16 09:15:00', '2024-01-16 09:15:00'),
(3, 'Arun Patel', 'arun.patel@example.com', 'Feedback', 'I recently used your mobile app and found it very user-friendly. However, I think the dark mode option would be a great addition.', '2024-01-17 03:45:00', '2024-01-17 03:45:00'),
(5, 'Vikram Singh', 'vikram.singh@example.com', 'Technical Issue', 'I am unable to reset my password on your portal. The reset link in the email is not working. Please help.', '2024-01-19 11:00:00', '2024-01-19 11:00:00'),
(6, 'Ananya Reddy', 'ananya.reddy@example.com', 'Partnership Proposal', 'I represent a startup in the ed-tech space and would like to explore collaboration opportunities with your platform.', '2024-01-20 07:40:00', '2024-01-20 07:40:00'),
(7, 'Suresh Menon', 'suresh.menon@example.com', 'Complaint', 'The product I received is damaged and different from what was shown on the website. I would like a refund or replacement.', '2024-01-21 10:15:00', '2024-01-21 10:15:00'),
(8, 'Neha Gupta', 'neha.gupta@example.com', 'Service Inquiry', 'Do you offer custom software development services for healthcare businesses? If yes, please share your portfolio.', '2024-01-22 04:35:00', '2024-01-22 04:35:00'),
(9, 'Karthik Nair', 'karthik.nair@example.com', 'Feature Request', 'Could you add UPI payment option to your checkout process? It would make payments much easier for Indian customers.', '2024-01-23 06:55:00', '2024-01-23 06:55:00'),
(10, 'Divya Joshi', 'divya.joshi@example.com', 'Account Deletion', 'I would like to delete my account from your platform. Please confirm the process and let me know if any data will be retained.', '2024-01-24 12:20:00', '2024-01-24 12:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_type` enum('percentage','fixed_amount') NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) DEFAULT 0.00,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `usage_limit_per_user` int(11) DEFAULT 1,
  `user_scope` enum('all','specific') DEFAULT 'all',
  `category_scope` enum('all','specific') DEFAULT 'all',
  `product_scope` enum('all','specific') DEFAULT 'all',
  `status` enum('active','inactive','expired') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `name`, `description`, `discount_type`, `discount_value`, `min_order_amount`, `max_discount_amount`, `start_date`, `end_date`, `usage_limit`, `usage_limit_per_user`, `user_scope`, `category_scope`, `product_scope`, `status`, `created_at`, `updated_at`) VALUES
(1, 'WELCOME10', 'Welcome Discount', '10% off for new customers', 'percentage', 10.00, 1000.00, 500.00, '2026-01-01', '2026-12-31', 1000, 1, 'all', 'all', 'all', 'active', '2026-01-31 08:48:42', '2026-01-31 08:48:42'),
(2, 'FLAT500', 'Flat ₹500 Off', 'Get ₹500 off on orders above ₹3000', 'fixed_amount', 500.00, 3000.00, 500.00, '2026-01-01', '2026-12-31', 500, 1, 'all', 'all', 'all', 'active', '2026-01-31 08:48:42', '2026-01-31 08:48:42'),
(3, 'SUMMER20', 'Summer Sale', '20% off on all summer items', 'percentage', 20.00, 1500.00, 1000.00, '2026-06-01', '2026-08-31', NULL, 3, 'all', 'specific', 'all', 'active', '2026-01-31 08:48:42', '2026-01-31 08:48:42'),
(4, 'VIP25', 'VIP Customer Discount', '25% off exclusive for VIP customers', 'percentage', 25.00, 2000.00, 1500.00, '2026-01-01', '2026-12-31', NULL, 1, 'specific', 'all', 'all', 'active', '2026-01-31 08:48:42', '2026-01-31 08:48:42'),
(5, 'FREESHIP', 'Free Shipping', 'Free shipping on all orders', 'fixed_amount', 50.00, 0.00, 50.00, '2026-01-01', '2026-12-31', 10000, 1, 'all', 'all', 'all', 'active', '2026-01-31 08:48:42', '2026-01-31 05:11:36'),
(8, 'fbhfd', 'sdvgsdvg', 'vsegfrbh er 4', 'percentage', 22.00, 22.00, 22.00, '2026-01-31', '2026-02-27', 22, 12, 'all', 'all', 'all', 'active', '2026-01-31 04:56:52', '2026-01-31 04:56:52'),
(9, 'FEB25', 'February Special', '25% off on all electronics items', 'percentage', 25.00, 2000.00, 1000.00, '2026-02-01', '2026-02-28', 500, 2, 'all', 'specific', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(10, 'NEWUSER100', 'New User Discount', '₹100 off for first-time users', 'fixed_amount', 100.00, 500.00, 100.00, '2026-02-01', '2026-12-31', 1000, 1, 'specific', 'all', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(11, 'FLAT200', 'Weekend Offer', 'Flat ₹200 off on orders above ₹1500', 'fixed_amount', 200.00, 1500.00, 200.00, '2026-02-01', '2026-12-31', NULL, 3, 'all', 'all', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(12, 'BEAUTY15', 'Beauty Discount', '15% off on beauty products', 'percentage', 15.00, 1000.00, 500.00, '2026-02-01', '2026-02-15', 200, 1, 'all', 'specific', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(13, 'SPORTS20', 'Sports Gear Sale', '20% off on sports equipment', 'percentage', 20.00, 2500.00, 800.00, '2026-02-01', '2026-03-31', NULL, 2, 'all', 'specific', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(14, 'HOMEDECOR', 'Home Decor Sale', 'Flat ₹300 off on home decor items', 'fixed_amount', 300.00, 2000.00, 300.00, '2026-02-01', '2026-02-20', 300, 1, 'all', 'specific', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(15, 'FIRSTORDER', 'First Order Special', '10% off on your first order', 'percentage', 10.00, 0.00, 500.00, '2026-02-01', '2026-12-31', NULL, 1, 'specific', 'all', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(16, 'WINTER30', 'Winter Collection', '30% off on winter fashion', 'percentage', 30.00, 3000.00, 1500.00, '2026-02-01', '0000-00-00', 400, 2, 'all', 'specific', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(17, 'BOOKLOVER', 'Book Lovers Special', 'Flat ₹150 off on books & stationery', 'fixed_amount', 150.00, 800.00, 150.00, '2026-02-01', '2026-02-28', 600, 2, 'all', 'specific', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(18, 'HEALTH10', 'Health & Wellness', '10% off on healthcare products', 'percentage', 10.00, 1500.00, 300.00, '2026-02-01', '2026-02-20', 250, 1, 'all', 'specific', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(19, 'GROCERY5', 'Grocery Saver', '5% off on all grocery items', 'percentage', 5.00, 1000.00, 200.00, '2026-02-01', '2026-02-25', NULL, 5, 'all', 'specific', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(20, 'TOYS50', 'Kids Zone', 'Flat ₹50 off on toys', 'fixed_amount', 50.00, 500.00, 50.00, '2026-02-01', '2026-02-15', 800, 3, 'all', 'specific', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(21, 'AUTO100', 'Auto Accessories', '₹100 off on automotive products', 'fixed_amount', 100.00, 1000.00, 100.00, '2026-02-01', '2026-02-28', 400, 1, 'all', 'specific', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(22, 'VIP50', 'VIP Exclusive', '50% off for VIP members', 'percentage', 50.00, 5000.00, 2500.00, '2026-02-01', '2026-12-31', NULL, 1, 'specific', 'all', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(23, 'FREEDEL', 'Free Delivery', 'Free delivery on all orders', 'fixed_amount', 99.00, 0.00, 99.00, '2026-02-01', '2026-12-31', 5000, 5, 'all', 'all', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(24, 'HOLIDAY25', 'Holiday Season', '25% off on all products', 'percentage', 25.00, 4000.00, 2000.00, '2026-02-01', '2026-02-10', 1000, 1, 'all', 'all', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00'),
(25, 'QUICK500', 'Express Deal', '₹500 off on express shipping orders', 'fixed_amount', 500.00, 3000.00, 500.00, '2026-02-01', '2026-02-20', 300, 1, 'all', 'all', 'all', 'active', '2026-02-02 02:19:00', '2026-02-02 02:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_categories`
--

CREATE TABLE `coupon_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon_categories`
--

INSERT INTO `coupon_categories` (`id`, `coupon_id`, `category_id`, `created_at`) VALUES
(1, 3, 2, '2026-01-31 08:48:42'),
(2, 3, 6, '2026-01-31 08:48:42'),
(3, 9, 1, '2026-02-02 02:19:00'),
(4, 12, 4, '2026-02-02 02:19:00'),
(5, 13, 6, '2026-02-02 02:19:00'),
(6, 14, 3, '2026-02-02 02:19:00'),
(7, 16, 2, '2026-02-02 02:19:00'),
(8, 17, 5, '2026-02-02 02:19:00'),
(9, 18, 10, '2026-02-02 02:19:00'),
(10, 19, 9, '2026-02-02 02:19:00'),
(11, 20, 7, '2026-02-02 02:19:00'),
(12, 21, 8, '2026-02-02 02:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_products`
--

CREATE TABLE `coupon_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `original_total` decimal(10,2) NOT NULL,
  `final_total` decimal(10,2) NOT NULL,
  `used_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon_usages`
--

INSERT INTO `coupon_usages` (`id`, `coupon_id`, `user_id`, `order_id`, `discount_amount`, `original_total`, `final_total`, `used_at`) VALUES
(1, 2, 9, 16, 500.00, 5997.00, 6636.46, '2026-01-31 12:34:33'),
(2, 2, 9, 17, 500.00, 5997.00, 6636.46, '2026-01-31 12:34:36'),
(3, 5, 9, 18, 50.00, 3998.00, 4808.64, '2026-01-31 13:20:54'),
(4, 1, 9, 19, 399.80, 3998.00, 4395.88, '2026-01-31 13:24:32'),
(5, 8, 9, 20, 22.00, 4497.00, 5430.50, '2026-01-31 13:26:10'),
(6, 8, 9, 21, 22.00, 4497.00, 5430.50, '2026-01-31 13:26:14'),
(7, 8, 9, 22, 22.00, 648.00, 888.68, '2026-02-02 05:18:50'),
(8, 2, 11, 24, 500.00, 3646.00, 3862.28, '2026-02-02 06:48:24'),
(9, 25, 9, 25, 500.00, 134486.00, 158253.48, '2026-02-03 09:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_users`
--

CREATE TABLE `coupon_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon_users`
--

INSERT INTO `coupon_users` (`id`, `coupon_id`, `user_id`, `created_at`) VALUES
(1, 4, 1, '2026-01-31 08:48:42'),
(2, 4, 2, '2026-01-31 08:48:42'),
(3, 10, 9, '2026-02-02 02:19:00'),
(4, 10, 11, '2026-02-02 02:19:00'),
(5, 15, 2, '2026-02-02 02:19:00'),
(6, 22, 1, '2026-02-02 02:19:00'),
(7, 22, 9, '2026-02-02 02:19:00');

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
(4, '2026_01_27_060556_add_google_id_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `payment_method` enum('cod','card','upi') NOT NULL,
  `payment_gateway` varchar(50) DEFAULT NULL,
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `shipping_name` varchar(255) NOT NULL,
  `shipping_email` varchar(255) NOT NULL,
  `shipping_phone` varchar(20) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_city` varchar(100) NOT NULL,
  `shipping_state` varchar(100) NOT NULL,
  `shipping_zip` varchar(20) NOT NULL,
  `shipping_country` varchar(100) DEFAULT 'India',
  `shipping_method` varchar(50) DEFAULT 'standard',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `delivered_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `gateway_response` text DEFAULT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `subtotal`, `shipping`, `tax`, `total`, `status`, `payment_method`, `payment_gateway`, `payment_status`, `shipping_name`, `shipping_email`, `shipping_phone`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_zip`, `shipping_country`, `shipping_method`, `created_at`, `updated_at`, `delivered_at`, `cancelled_at`, `transaction_id`, `gateway_response`, `coupon_id`, `coupon_code`, `discount_amount`) VALUES
(1, 'ORD-20260126-697733164FB57', 2, 2647.00, 0.00, 476.46, 3123.46, 'processing', 'cod', NULL, 'pending', 'Regular Users', 'user@example.com', '0987654321', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-26 03:55:42', '2026-01-28 07:13:19', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(4, 'ORD-260126-115122-0044', 2, 314.99, 50.00, 56.70, 421.69, 'delivered', 'upi', NULL, 'paid', 'Regular Users', 'user@example.com', '0987654321', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-26 06:21:22', '2026-01-29 06:05:44', '2026-01-29 06:05:44', NULL, NULL, NULL, NULL, NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `total`, `category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 'Organic Green Tea', 1, 349.00, 349.00, 9, 'Groceries', '2026-01-26 03:55:42', '2026-01-26 03:55:42'),
(2, 1, 10, 'Digital Thermometer', 1, 299.00, 299.00, 10, 'Healthcare', '2026-01-26 03:55:42', '2026-01-26 03:55:42'),
(3, 1, 8, 'Car Air Purifier', 1, 1999.00, 1999.00, 8, 'Automotive', '2026-01-26 03:55:42', '2026-01-26 03:55:42');

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
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `gateway` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('initiated','success','failed','refunded') DEFAULT 'initiated',
  `gateway_response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `rating` decimal(3,2) DEFAULT 0.00,
  `review_count` int(11) DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `image`, `description`, `price`, `stock`, `rating`, `review_count`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Smartphone X Pro', 'smartphone-x-pro', 'product_1769234603_Nb4pjAqd9m.jpg', 'Latest smartphone with 128GB storage, 8GB RAM, 6.7-inch AMOLED display, and 48MP triple camera system.', 29999.00, 50, 4.00, 1, 'active', '2024-01-15 04:30:00', '2026-01-30 03:28:33'),
(2, 2, 'Men\'s Casual Shirt', 'mens-casual-shirt', 'product_1769234603_Nb4pjAqd9m.jpg', 'Premium cotton casual shirt available in multiple colors and sizes. Perfect for office and casual wear.', 1299.00, 120, 0.00, 0, 'active', '2024-01-16 06:00:00', '2026-01-30 02:48:35'),
(3, 3, 'Non-Stick Cookware Set', 'non-stick-cookware-set', 'product_1769234603_Nb4pjAqd9m.jpg', '5-piece non-stick cookware set including frying pan, saucepan, and kadai with glass lids.', 2499.00, 35, 0.00, 0, 'active', '2024-01-17 07:15:00', '2026-01-30 02:48:55');


-- --------------------------------------------------------

--
-- Table structure for table `product_return_history`
--

CREATE TABLE `product_return_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `month_year` varchar(7) NOT NULL,
  `total_sold` int(11) DEFAULT 0,
  `total_returned` int(11) DEFAULT 0,
  `return_rate` decimal(5,2) DEFAULT 0.00,
  `common_reasons` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_number` varchar(50) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `return_type` enum('refund','replacement','store_credit') DEFAULT 'refund',
  `reason` enum('defective','wrong_item','size_issue','not_as_described','damaged','quality_issue','changed_mind','late_delivery','other') NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','approved','rejected','pickup_scheduled','picked_up','processing','refunded','replaced','completed','cancelled') DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `refund_method` enum('original','wallet','bank_transfer','credit_card') DEFAULT NULL,
  `refund_status` enum('pending','processing','completed','failed') DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `pickup_address` text DEFAULT NULL,
  `pickup_scheduled_date` date DEFAULT NULL,
  `pickup_date` date DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `user_notes` text DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `return_number`, `order_id`, `order_item_id`, `user_id`, `product_id`, `quantity`, `return_type`, `reason`, `description`, `status`, `amount`, `refund_amount`, `refund_method`, `refund_status`, `refunded_at`, `pickup_address`, `pickup_scheduled_date`, `pickup_date`, `admin_notes`, `user_notes`, `image1`, `image2`, `image3`, `created_at`, `updated_at`) VALUES
(1, 'RET-20250203-0001', 14, 32, 9, 3, 1, 'refund', 'defective', 'Non-stick coating peeling off after first use', 'approved', 2499.00, 2499.00, 'original', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 03:45:00', '2026-02-03 07:31:10'),
(2, 'RET-20250203-0002', 21, 40, 9, 6, 1, 'refund', 'wrong_item', 'Received blue yoga mat instead of purple as ordered', 'approved', 1499.00, 1499.00, 'original', NULL, NULL, NULL, '2026-02-05', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 05:00:00', '2026-02-03 11:28:02'),
(3, 'RET-20250202-0001', 20, 39, 9, 6, 1, 'refund', 'damaged', 'Yoga mat arrived with visible scratches and tears', 'pickup_scheduled', 1499.00, 1499.00, 'wallet', NULL, NULL, NULL, '2026-02-04', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-02 08:50:00', '2026-02-03 11:28:02');
-- --------------------------------------------------------

--
-- Table structure for table `return_analytics`
--

CREATE TABLE `return_analytics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `total_returns` int(11) DEFAULT 0,
  `pending_returns` int(11) DEFAULT 0,
  `approved_returns` int(11) DEFAULT 0,
  `rejected_returns` int(11) DEFAULT 0,
  `completed_returns` int(11) DEFAULT 0,
  `total_refund_amount` decimal(12,2) DEFAULT 0.00,
  `avg_processing_days` decimal(5,2) DEFAULT 0.00,
  `most_common_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_attachments`
--

CREATE TABLE `return_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `uploaded_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_audit_logs`
--

CREATE TABLE `return_audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(100) NOT NULL,
  `old_values` text DEFAULT NULL,
  `new_values` text DEFAULT NULL,
  `changed_by` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_categories`
--

CREATE TABLE `return_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_categories`
--

INSERT INTO `return_categories` (`id`, `name`, `slug`, `description`, `icon`, `color`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Quality Issues', 'quality-issues', 'Returns due to product quality problems', 'fa-star-half-alt', '#FF6B6B', 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(2, 'Wrong Items', 'wrong-items', 'Received incorrect products', 'fa-exchange-alt', '#4ECDC4', 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(3, 'Damaged Goods', 'damaged-goods', 'Products damaged during shipping', 'fa-box-open', '#FFD166', 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(4, 'Size Problems', 'size-problems', 'Clothing or shoes that don\'t fit', 'fa-tshirt', '#06D6A0', 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(5, 'Change of Mind', 'change-of-mind', 'Customer changed their mind', 'fa-heart', '#118AB2', 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(6, 'Late Delivery', 'late-delivery', 'Delivered after promised date', 'fa-clock', '#073B4C', 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `return_notifications`
--

CREATE TABLE `return_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` enum('status_update','refund_processed','pickup_scheduled','admin_message','system') NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `data` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `sent_via` enum('email','sms','in_app','all') DEFAULT 'in_app',
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_notifications`
--

INSERT INTO `return_notifications` (`id`, `return_id`, `user_id`, `type`, `title`, `message`, `data`, `is_read`, `read_at`, `sent_via`, `sent_at`, `created_at`) VALUES
(1, 2, 9, 'status_update', 'Return Approved', 'Your return request #RET-20250203-0002 has been approved. We will schedule pickup soon.', '{\"return_number\":\"RET-20250203-0002\",\"status\":\"approved\"}', 1, NULL, 'in_app', NULL, '2026-02-03 06:15:00'),
(2, 6, 9, 'status_update', 'Return Rejected', 'Your return request #RET-20250130-0001 has been rejected. Product was used - not eligible for change of mind.', '{\"return_number\":\"RET-20250130-0001\",\"status\":\"rejected\"}', 1, NULL, 'email', NULL, '2026-01-30 09:50:00'),
(3, 5, 9, 'refund_processed', 'Refund Processed', 'Refund of ₹899.00 has been processed for return #RET-20250131-0001 and added to your wallet.', '{\"return_number\":\"RET-20250131-0001\",\"amount\":899.00,\"method\":\"wallet\"}', 1, NULL, 'in_app', NULL, '2026-02-01 09:00:00'),
(4, 9, 2, 'status_update', 'Return Processing', 'Your return request #RET-20250127-0001 is being processed. Refund will be initiated soon.', '{\"return_number\":\"RET-20250127-0001\",\"status\":\"processing\"}', 0, NULL, 'in_app', NULL, '2026-01-28 04:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `return_policies`
--

CREATE TABLE `return_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `return_window_days` int(11) NOT NULL DEFAULT 7,
  `refund_methods` text DEFAULT NULL,
  `restocking_fee_percentage` decimal(5,2) DEFAULT 0.00,
  `return_shipping_paid_by` enum('customer','seller') DEFAULT 'customer',
  `conditions` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_policies`
--

INSERT INTO `return_policies` (`id`, `name`, `description`, `return_window_days`, `refund_methods`, `restocking_fee_percentage`, `return_shipping_paid_by`, `conditions`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Standard Return Policy', 'Our standard return policy for all products', 30, '[\"original\",\"wallet\"]', 0.00, 'seller', '{\"items_must_be_unused\": true, \"original_packaging\": true, \"tags_attached\": true, \"invoice_required\": true}', 'active', NULL, '2026-02-03 11:22:55', '2026-02-03 11:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `return_reasons`
--

CREATE TABLE `return_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `requires_image` tinyint(1) DEFAULT 0,
  `requires_description` tinyint(1) DEFAULT 1,
  `refund_type` enum('full','partial','none') DEFAULT 'full',
  `priority` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_reasons`
--

INSERT INTO `return_reasons` (`id`, `reason`, `description`, `requires_image`, `requires_description`, `refund_type`, `priority`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Defective Product', 'Product is defective or not working properly', 1, 1, 'full', 1, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(2, 'Wrong Item Received', 'Received wrong item or wrong size/color', 1, 0, 'full', 2, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(3, 'Damaged in Transit', 'Product arrived damaged during shipping', 1, 1, 'full', 3, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(4, 'Not as Described', 'Product does not match the description or images', 1, 1, 'full', 4, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(5, 'Quality Issues', 'Poor quality or manufacturing defects', 1, 1, 'full', 5, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(6, 'Size Issue', 'Does not fit properly (clothing, shoes)', 0, 0, 'full', 6, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(7, 'Changed Mind', 'No longer want or need the product', 0, 0, 'partial', 7, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(8, 'Late Delivery', 'Order delivered after promised delivery date', 0, 0, 'partial', 8, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(9, 'Duplicate Order', 'Accidentally ordered the same item twice', 0, 1, 'full', 9, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(10, 'Other', 'Other reasons not listed above', 1, 1, 'full', 10, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `return_replacements`
--

CREATE TABLE `return_replacements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_id` bigint(20) UNSIGNED NOT NULL,
  `original_product_id` bigint(20) UNSIGNED NOT NULL,
  `replacement_product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `replacement_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_rules`
--

CREATE TABLE `return_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `condition_type` enum('product','category','price','customer','days_since_purchase') NOT NULL,
  `condition_value` text NOT NULL,
  `action_type` enum('auto_approve','auto_reject','require_approval','require_images','partial_refund') NOT NULL,
  `action_value` text DEFAULT NULL,
  `priority` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_rules`
--

INSERT INTO `return_rules` (`id`, `name`, `condition_type`, `condition_value`, `action_type`, `action_value`, `priority`, `status`, `created_at`, `updated_at`) VALUES
(1, 'High Value Auto Approval', 'price', '{\"operator\": \"<\", \"value\": 1000}', 'auto_approve', '{\"refund_percentage\": 100}', 1, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(2, 'Electronics Require Images', 'category', '{\"category_id\": 1}', 'require_images', '{\"min_images\": 2}', 2, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(3, 'Late Returns Partial Refund', 'days_since_purchase', '{\"operator\": \">\", \"value\": 15}', 'partial_refund', '{\"refund_percentage\": 50}', 3, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `return_shipping_methods`
--

CREATE TABLE `return_shipping_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `carrier` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT 0.00,
  `estimated_days` varchar(50) DEFAULT NULL,
  `tracking_url_template` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_shipping_methods`
--

INSERT INTO `return_shipping_methods` (`id`, `name`, `carrier`, `description`, `cost`, `estimated_days`, `tracking_url_template`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pickup by Courier', 'Local Courier', 'We will arrange pickup from your address', 0.00, '1-2 days', NULL, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(2, 'Self Ship', 'Any Carrier', 'Ship the item yourself and provide tracking', 0.00, '2-5 days', NULL, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55'),
(3, 'Drop at Store', 'In-Store', 'Drop off at our nearest store', 0.00, 'Same day', NULL, 'active', '2026-02-03 11:22:55', '2026-02-03 11:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `return_slas`
--

CREATE TABLE `return_slas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `priority_level` enum('low','medium','high','urgent') NOT NULL,
  `resolution_days` int(11) NOT NULL,
  `auto_approve_hours` int(11) DEFAULT NULL,
  `conditions` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_slas`
--

INSERT INTO `return_slas` (`id`, `name`, `priority_level`, `resolution_days`, `auto_approve_hours`, `conditions`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Standard Return', 'medium', 7, 48, '{\"max_amount\": 5000}', 'active', '2026-02-03 11:22:56', '2026-02-03 11:22:56'),
(2, 'Express Return', 'high', 3, 24, '{\"vip_customer\": true}', 'active', '2026-02-03 11:22:56', '2026-02-03 11:22:56'),
(3, 'Premium Return', 'urgent', 1, 12, '{\"amount_greater_than\": 10000}', 'active', '2026-02-03 11:22:56', '2026-02-03 11:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `return_status_logs`
--

CREATE TABLE `return_status_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_id` bigint(20) UNSIGNED NOT NULL,
  `from_status` varchar(50) DEFAULT NULL,
  `to_status` varchar(50) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_status_logs`
--

INSERT INTO `return_status_logs` (`id`, `return_id`, `from_status`, `to_status`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 'pending', 'Return request created by customer', 9, '2026-02-03 05:00:00', NULL),
(2, 2, 'pending', 'approved', 'Approved by admin - wrong item confirmed', 1, '2026-02-03 06:15:00', NULL),
(3, 3, NULL, 'pending', 'Return request submitted', 9, '2026-02-02 08:50:00', NULL),
(4, 3, 'pending', 'approved', 'Damage confirmed from images', 1, '2026-02-02 10:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `return_tags`
--

CREATE TABLE `return_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `color` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_tag_assignments`
--

CREATE TABLE `return_tag_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_templates`
--

CREATE TABLE `return_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('email','sms','notification') NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `variables` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_templates`
--

INSERT INTO `return_templates` (`id`, `name`, `type`, `subject`, `content`, `variables`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Return Request Received', 'email', 'Your Return Request #{{return_number}} Has Been Received', '<p>Dear {{customer_name}},</p><p>We have received your return request for order #{{order_number}}. Our team will review it and get back to you within 24-48 hours.</p><p><strong>Return Details:</strong></p><ul><li>Return Number: {{return_number}}</li><li>Product: {{product_name}}</li><li>Reason: {{reason}}</li><li>Requested Amount: {{amount}}</li></ul><p>Thank you for your patience.</p>', '[\"return_number\",\"order_number\",\"customer_name\",\"product_name\",\"reason\",\"amount\"]', 'active', '2026-02-03 11:22:56', '2026-02-03 11:22:56'),
(2, 'Return Status Update', 'notification', 'Return Status Updated', 'Your return request #{{return_number}} status has been updated to {{status}}.', '[\"return_number\",\"status\"]', 'active', '2026-02-03 11:22:56', '2026-02-03 11:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `return_tracking`
--

CREATE TABLE `return_tracking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_id` bigint(20) UNSIGNED NOT NULL,
  `tracking_number` varchar(100) NOT NULL,
  `carrier` varchar(100) DEFAULT NULL,
  `shipping_method` varchar(100) DEFAULT NULL,
  `status` enum('label_created','picked_up','in_transit','out_for_delivery','delivered','exception','lost') DEFAULT 'label_created',
  `estimated_delivery` date DEFAULT NULL,
  `actual_delivery` date DEFAULT NULL,
  `tracking_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_tracking`
--

INSERT INTO `return_tracking` (`id`, `return_id`, `tracking_number`, `carrier`, `shipping_method`, `status`, `estimated_delivery`, `actual_delivery`, `tracking_url`, `created_at`, `updated_at`) VALUES
(1, 3, 'TRK789012345', 'Blue Dart', 'Pickup by Courier', 'in_transit', '2026-02-05', NULL, 'https://www.bluedart.com/tracking?tracking=TRK789012345', '2026-02-02 10:30:00', '2026-02-03 11:28:57'),
(2, 4, 'TRK123456789', 'Delhivery', 'Pickup by Courier', 'delivered', '2026-02-03', NULL, 'https://www.delhivery.com/track/TRK123456789', '2026-02-01 09:00:00', '2026-02-03 11:28:57');

-- --------------------------------------------------------

--
-- Table structure for table `return_workflows`
--

CREATE TABLE `return_workflows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `steps` text NOT NULL,
  `conditions` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(1) UNSIGNED NOT NULL CHECK (`rating` between 1 and 5),
  `title` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('pending','approved','rejected','spam') NOT NULL DEFAULT 'pending',
  `is_verified_purchase` tinyint(1) NOT NULL DEFAULT 0,
  `helpful_yes` int(11) NOT NULL DEFAULT 0,
  `helpful_no` int(11) NOT NULL DEFAULT 0,
  `report_count` int(11) NOT NULL DEFAULT 0,
  `admin_response` text DEFAULT NULL,
  `response_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `order_id`, `rating`, `title`, `comment`, `status`, `is_verified_purchase`, `helpful_yes`, `helpful_no`, `report_count`, `admin_response`, `response_date`, `created_at`, `updated_at`) VALUES
(2, 1, 9, 5, 4, 'Good but has issues', 'Overall good phone but the charging speed could be better. Camera is excellent though.', 'approved', 1, 5, 1, 0, 'ok we will do our best to in out time', '2026-01-30 03:52:10', '2026-01-29 13:16:32', '2026-01-30 03:52:10'),
(9, 4, 9, NULL, 4, 'rbgfrbgh', 'frbhfrebh  rfhbgfrtgh', 'approved', 0, 0, 0, 0, NULL, NULL, '2026-01-30 06:56:25', '2026-01-30 07:44:19');

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
('6v7rTeM9hNv1GWZVXqcEiBQ4065dpCTJ6LbQ9rkR', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSUxtNGptZVVNUmdrWmdMWjFxUkJWUmRvdWQyd2I2VWxQSXluWTdtYyI7czoxMToiZ3Vlc3RfdG9rZW4iO3M6MzI6IkxJNVVVNVlpUVlBb3VNNXFKRlFUMWRkNWVoWjVXeTdPIjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovL2xvY2FsaG9zdC9lLWNvbW1tZXJjZS9wdWJsaWMvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770265783),
('DEJY411wvxEpYtydQ2JkaIsyMRcwK9HlvQzChAmB', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR2hVVVZhSXphV2ZtSnBybU5BUXpDVjF5aFdnanRSMWw0dTZVakxyTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMToiZ3Vlc3RfdG9rZW4iO3M6MzI6Ino0SEl0WXpHRkUyZEoxeTRTa3o2WmNDbjVKRnFSVUttIjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovL2xvY2FsaG9zdC9lLWNvbW1tZXJjZS9wdWJsaWMvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1770211886),
('in1aeWVxp66Mefjxtd5ZwBiuY2Tzq9MGo4HQ9Hmg', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ2o1QlVuN3lOWmFZRm8xOXV1Z082QTNmbW0yYkdGcXlWRDhlS3RFVyI7czoxMToiZ3Vlc3RfdG9rZW4iO3M6MzI6IjRLVjZHQXFjRElibnZCeE1pWnpSSU9IamprcFdtaFYyIjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovL2xvY2FsaG9zdC9lLWNvbW1tZXJjZS9wdWJsaWMvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770265781);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `phone_1` varchar(20) DEFAULT NULL,
  `phone_2` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `map_location` text DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `pinterest` varchar(255) DEFAULT NULL,
  `email_support` varchar(100) DEFAULT NULL,
  `email_business` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `phone_1`, `phone_2`, `address`, `map_location`, `facebook`, `twitter`, `instagram`, `linkedin`, `youtube`, `pinterest`, `email_support`, `email_business`, `status`, `created_at`, `updated_at`) VALUES
(1, '9913817411', '7735105645', '123 Commerce Street, San Francisco, CA 94107, USA', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.240088208355!2d72.8044065!3d21.142841600000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e4b45d3ca2b%3A0xaf9ae5ffda2095d3!2sWebmasters%20InfoTech!5e0!3m2!1sen!2sin!4v1737200381429!5m2!1sen!2sin', 'https://facebook.com/yourpage', 'https://twitter.com/yourpage', 'https://instagram.com/yourpage', 'https://linkedin.com/company/yourpage', 'https://youtube.com/yourchannel', 'https://pinterest.com/yourpage', 'support@eshop.com', 'business@eshop.com', 'active', '2026-01-24 09:31:54', '2026-01-24 05:28:39');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `subtitle`, `image`, `button_text`, `button_link`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Free Shipping', 'On All Orders Above ₹999', 'slider_1769843141_MjO2RDXK7k.jpg', 'Learn More', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2024-01-17 05:45:00', '2026-01-31 01:35:41'),
(5, 'Fitness Essentials', 'Get Fit with Premium Equipment', 'slider_1769843334_b8rmT1xo9Y.jpg', 'Shop Fitness', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2024-01-19 11:15:00', '2026-01-31 01:38:54'),
(6, 'Mobile Mania', 'Best Deals on Smartphones', 'slider_1769843219_NRwmPw5Ko4.jpg', 'Buy Now', NULL, 'active', '2024-01-20 06:40:00', '2026-01-31 01:36:59'),
(7, 'Book Fair', 'Thousands of Books at Discounted Prices', 'slider_1769843094_UJfQWTOgB7.jpg', 'View Books', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2024-01-21 10:00:00', '2026-01-31 01:34:54'),
(8, 'Beauty Bonanza', 'Premium Cosmetics & Skincare', 'slider_1769843047_Mg4rPp2XCq.jpg', 'Shop Beauty', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2024-01-22 04:30:00', '2026-01-31 01:34:07'),
(10, 'Weekend Special', 'Extra 20% Off on Selected Items', 'slider_1769842994_Jwh2Vrpm1Q.jpg', 'Grab Deal', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2024-01-24 12:30:00', '2026-01-31 01:33:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `google_id`) VALUES
(1, 'Admin User', 'admin@example.com', '1234567890', NULL, '$2y$12$aGSDTCEDK7do1Rk5lxH74uL6B7auOqExL.anLNbXvzxwD8k3jqAC2', 'admin', NULL, '2026-01-22 10:56:12', '2026-01-24 03:31:44', NULL),
(2, 'Regular Users', 'user@example.com', '0987654321', NULL, '$2y$12$r4EOdHojsEaSS4y6EYqtBu3QYRk2BBoV6S0i.rGriYNxJx8kYQqQW', 'user', NULL, '2026-01-22 10:56:12', '2026-01-23 03:51:41', NULL),
(9, 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', NULL, '$2y$12$Of5BvP9xEQFq9tNMNwwjjems1ya9WK7Z6Ec8R4uPmR98exIq6UULa', 'user', NULL, '2026-01-26 06:34:07', '2026-01-26 06:34:07', NULL),
(11, 'Litu Nayak', 'Litu123@gmail.com', '09978767202', NULL, '$2y$12$SBgByioIYBFlrZqV9zeWWu3foMXksu1TrYz1wZ6Gek9Y81Y2e1Sda', 'user', NULL, '2026-02-02 00:02:09', '2026-02-02 00:02:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_wallets`
--

CREATE TABLE `user_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_wallets`
--

INSERT INTO `user_wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES
(1, 9, 914.99, '2026-02-01 09:00:00', '2026-02-01 09:00:00'),
(2, 2, 15.99, '2026-01-28 10:30:00', '2026-01-28 10:30:00'),
(3, 11, 0.00, '2026-02-01 18:32:09', '2026-02-01 18:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `balance_before` decimal(10,2) NOT NULL,
  `balance_after` decimal(10,2) NOT NULL,
  `reference_type` enum('order_refund','cashback','manual_adjustment','referral_bonus','order_payment','return_refund') NOT NULL,
  `reference_id` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('pending','completed','failed','cancelled') DEFAULT 'completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_transactions`
--

INSERT INTO `wallet_transactions` (`id`, `user_id`, `type`, `amount`, `balance_before`, `balance_after`, `reference_type`, `reference_id`, `description`, `status`, `created_at`) VALUES
(1, 9, 'credit', 899.00, 0.00, 899.00, 'return_refund', 'RET-20250131-0001', 'Refund for return #RET-20250131-0001', 'completed', '2026-02-01 09:00:00'),
(2, 2, 'credit', 15.99, 0.00, 15.99, 'return_refund', 'RET-20250128-0001', 'Refund for return #RET-20250128-0001', 'completed', '2026-01-28 10:30:00'),
(3, 9, 'credit', 15.99, 899.00, 914.99, 'cashback', 'ORDER-456', 'Cashback on order #ORDER-456', 'completed', '2026-02-02 04:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(8, 11, 2, '2026-02-02 03:35:42', '2026-02-02 03:35:42'),
(9, 11, 4, '2026-02-02 04:15:30', '2026-02-02 04:15:30'),
(10, 11, 7, '2026-02-02 05:00:15', '2026-02-02 05:00:15'),
(11, 11, 9, '2026-02-02 05:45:28', '2026-02-02 05:45:28'),
(12, 11, 66, '2026-02-02 07:10:33', '2026-02-02 07:10:33'),
(13, 11, 70, '2026-02-02 07:55:19', '2026-02-02 07:55:19'),
(14, 11, 76, '2026-02-02 08:40:47', '2026-02-02 08:40:47'),
(15, 11, 85, '2026-02-02 10:25:22', '2026-02-02 10:25:22'),
(16, 2, 3, '2026-02-01 06:45:30', '2026-02-01 06:45:30'),
(17, 2, 5, '2026-02-01 08:10:25', '2026-02-01 08:10:25'),
(18, 2, 10, '2026-02-01 09:25:10', '2026-02-01 09:25:10'),
(19, 2, 64, '2026-02-02 02:50:15', '2026-02-02 02:50:15'),
(20, 2, 72, '2026-02-02 04:15:33', '2026-02-02 04:15:33'),
(21, 2, 78, '2026-02-02 05:00:28', '2026-02-02 05:00:28'),
(22, 2, 81, '2026-02-02 05:45:42', '2026-02-02 05:45:42'),
(23, 2, 89, '2026-02-02 06:55:19', '2026-02-02 06:55:19'),
(24, 2, 94, '2026-02-02 08:10:55', '2026-02-02 08:10:55'),
(25, 2, 96, '2026-02-02 08:50:30', '2026-02-02 08:50:30'),
(30, 11, 1, '2026-02-02 03:00:15', '2026-02-02 03:00:15'),
(31, 11, 62, '2026-02-02 04:15:30', '2026-02-02 04:15:30'),
(32, 11, 75, '2026-02-02 05:25:18', '2026-02-02 05:25:18'),
(33, 11, 83, '2026-02-02 06:40:42', '2026-02-02 06:40:42'),
(34, 2, 8, '2026-02-02 09:40:25', '2026-02-02 09:40:25'),
(35, 2, 67, '2026-02-02 10:55:40', '2026-02-02 10:55:40'),
(36, 2, 73, '2026-02-02 11:45:55', '2026-02-02 11:45:55'),
(37, 2, 80, '2026-02-02 13:00:10', '2026-02-02 13:00:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_product_unique` (`user_id`,`product_id`),
  ADD UNIQUE KEY `session_product_unique` (`session_id`,`product_id`),
  ADD UNIQUE KEY `guest_product_unique` (`guest_token`,`product_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `session_guest_idx` (`session_id`,`is_guest`),
  ADD KEY `guest_token_idx` (`guest_token`,`is_guest`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`),
  ADD KEY `coupons_status_index` (`status`),
  ADD KEY `coupons_date_range` (`start_date`,`end_date`);

--
-- Indexes for table `coupon_categories`
--
ALTER TABLE `coupon_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_category_unique` (`coupon_id`,`category_id`),
  ADD KEY `coupon_categories_coupon_id_foreign` (`coupon_id`),
  ADD KEY `coupon_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `coupon_products`
--
ALTER TABLE `coupon_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_product_unique` (`coupon_id`,`product_id`),
  ADD KEY `coupon_products_coupon_id_foreign` (`coupon_id`),
  ADD KEY `coupon_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_usages_coupon_id_foreign` (`coupon_id`),
  ADD KEY `coupon_usages_user_id_foreign` (`user_id`),
  ADD KEY `coupon_usages_order_id_foreign` (`order_id`),
  ADD KEY `coupon_user_unique` (`coupon_id`,`user_id`);

--
-- Indexes for table `coupon_users`
--
ALTER TABLE `coupon_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_user_unique` (`coupon_id`,`user_id`),
  ADD KEY `coupon_users_coupon_id_foreign` (`coupon_id`),
  ADD KEY `coupon_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD UNIQUE KEY `order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_status_index` (`status`),
  ADD KEY `orders_coupon_id_index` (`coupon_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_category_id_foreign` (`category_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_logs_order_id_foreign` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `products_category_fk` (`category_id`);

--
-- Indexes for table `product_return_history`
--
ALTER TABLE `product_return_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_month_unique` (`product_id`,`month_year`),
  ADD KEY `history_product_index` (`product_id`),
  ADD KEY `history_month_index` (`month_year`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `return_number` (`return_number`),
  ADD KEY `order_item_id` (`order_item_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `return_user_index` (`user_id`),
  ADD KEY `return_status_index` (`status`),
  ADD KEY `return_order_index` (`order_id`),
  ADD KEY `return_number_index` (`return_number`);

--
-- Indexes for table `return_analytics`
--
ALTER TABLE `return_analytics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `analytics_date_unique` (`date`),
  ADD KEY `analytics_date_index` (`date`);

--
-- Indexes for table `return_attachments`
--
ALTER TABLE `return_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`),
  ADD KEY `attachment_return_index` (`return_id`);

--
-- Indexes for table `return_audit_logs`
--
ALTER TABLE `return_audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `changed_by` (`changed_by`),
  ADD KEY `audit_return_index` (`return_id`),
  ADD KEY `audit_action_index` (`action`),
  ADD KEY `audit_created_at_index` (`created_at`);

--
-- Indexes for table `return_categories`
--
ALTER TABLE `return_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_status_index` (`status`);

--
-- Indexes for table `return_notifications`
--
ALTER TABLE `return_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notification_user_index` (`user_id`,`is_read`),
  ADD KEY `notification_return_index` (`return_id`),
  ADD KEY `notification_type_index` (`type`);

--
-- Indexes for table `return_policies`
--
ALTER TABLE `return_policies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `policy_status_index` (`status`);

--
-- Indexes for table `return_reasons`
--
ALTER TABLE `return_reasons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reason` (`reason`),
  ADD KEY `reason_status_index` (`status`),
  ADD KEY `reason_priority_index` (`priority`);

--
-- Indexes for table `return_replacements`
--
ALTER TABLE `return_replacements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `return_replacement_unique` (`return_id`),
  ADD KEY `original_product_id` (`original_product_id`),
  ADD KEY `replacement_product_id` (`replacement_product_id`),
  ADD KEY `replacement_order_id` (`replacement_order_id`),
  ADD KEY `replacement_status_index` (`status`);

--
-- Indexes for table `return_rules`
--
ALTER TABLE `return_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rule_status_index` (`status`),
  ADD KEY `rule_priority_index` (`priority`);

--
-- Indexes for table `return_shipping_methods`
--
ALTER TABLE `return_shipping_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_status_index` (`status`);

--
-- Indexes for table `return_slas`
--
ALTER TABLE `return_slas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sla_priority_index` (`priority_level`),
  ADD KEY `sla_status_index` (`status`);

--
-- Indexes for table `return_status_logs`
--
ALTER TABLE `return_status_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `log_return_index` (`return_id`),
  ADD KEY `log_created_at_index` (`created_at`);

--
-- Indexes for table `return_tags`
--
ALTER TABLE `return_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `tag_slug_index` (`slug`);

--
-- Indexes for table `return_tag_assignments`
--
ALTER TABLE `return_tag_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `return_tag_unique` (`return_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `assignment_return_index` (`return_id`);

--
-- Indexes for table `return_templates`
--
ALTER TABLE `return_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_type_index` (`type`,`status`);

--
-- Indexes for table `return_tracking`
--
ALTER TABLE `return_tracking`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tracking_number_unique` (`tracking_number`),
  ADD KEY `tracking_return_index` (`return_id`),
  ADD KEY `tracking_status_index` (`status`);

--
-- Indexes for table `return_workflows`
--
ALTER TABLE `return_workflows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workflow_status_index` (`status`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_product_unique` (`user_id`,`product_id`) COMMENT 'One review per product per user',
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_order_id_foreign` (`order_id`),
  ADD KEY `reviews_status_index` (`status`),
  ADD KEY `reviews_rating_index` (`rating`),
  ADD KEY `reviews_verified_index` (`is_verified_purchase`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_wallets`
--
ALTER TABLE `user_wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `wallet_user_index` (`user_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_user_index` (`user_id`),
  ADD KEY `transaction_reference_index` (`reference_type`,`reference_id`),
  ADD KEY `transaction_created_at_index` (`created_at`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_product_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `coupon_categories`
--
ALTER TABLE `coupon_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `coupon_products`
--
ALTER TABLE `coupon_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `coupon_users`
--
ALTER TABLE `coupon_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `product_return_history`
--
ALTER TABLE `product_return_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `return_analytics`
--
ALTER TABLE `return_analytics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_attachments`
--
ALTER TABLE `return_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_audit_logs`
--
ALTER TABLE `return_audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_categories`
--
ALTER TABLE `return_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `return_notifications`
--
ALTER TABLE `return_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `return_policies`
--
ALTER TABLE `return_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `return_reasons`
--
ALTER TABLE `return_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `return_replacements`
--
ALTER TABLE `return_replacements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_rules`
--
ALTER TABLE `return_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `return_shipping_methods`
--
ALTER TABLE `return_shipping_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `return_slas`
--
ALTER TABLE `return_slas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `return_status_logs`
--
ALTER TABLE `return_status_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `return_tags`
--
ALTER TABLE `return_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_tag_assignments`
--
ALTER TABLE `return_tag_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_templates`
--
ALTER TABLE `return_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `return_tracking`
--
ALTER TABLE `return_tracking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `return_workflows`
--
ALTER TABLE `return_workflows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_wallets`
--
ALTER TABLE `user_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `coupon_categories`
--
ALTER TABLE `coupon_categories`
  ADD CONSTRAINT `coupon_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_categories_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_products`
--
ALTER TABLE `coupon_products`
  ADD CONSTRAINT `coupon_products_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_users`
--
ALTER TABLE `coupon_users`
  ADD CONSTRAINT `coupon_users_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD CONSTRAINT `payment_logs_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_return_history`
--
ALTER TABLE `product_return_history`
  ADD CONSTRAINT `product_return_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `returns_ibfk_2` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`),
  ADD CONSTRAINT `returns_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `returns_ibfk_4` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `return_attachments`
--
ALTER TABLE `return_attachments`
  ADD CONSTRAINT `return_attachments_ibfk_1` FOREIGN KEY (`return_id`) REFERENCES `returns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_attachments_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `return_audit_logs`
--
ALTER TABLE `return_audit_logs`
  ADD CONSTRAINT `return_audit_logs_ibfk_1` FOREIGN KEY (`return_id`) REFERENCES `returns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_audit_logs_ibfk_2` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `return_notifications`
--
ALTER TABLE `return_notifications`
  ADD CONSTRAINT `return_notifications_ibfk_1` FOREIGN KEY (`return_id`) REFERENCES `returns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_notifications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `return_policies`
--
ALTER TABLE `return_policies`
  ADD CONSTRAINT `return_policies_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `return_replacements`
--
ALTER TABLE `return_replacements`
  ADD CONSTRAINT `return_replacements_ibfk_1` FOREIGN KEY (`return_id`) REFERENCES `returns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_replacements_ibfk_2` FOREIGN KEY (`original_product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `return_replacements_ibfk_3` FOREIGN KEY (`replacement_product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `return_replacements_ibfk_4` FOREIGN KEY (`replacement_order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `return_status_logs`
--
ALTER TABLE `return_status_logs`
  ADD CONSTRAINT `return_status_logs_ibfk_1` FOREIGN KEY (`return_id`) REFERENCES `returns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_status_logs_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `return_tag_assignments`
--
ALTER TABLE `return_tag_assignments`
  ADD CONSTRAINT `return_tag_assignments_ibfk_1` FOREIGN KEY (`return_id`) REFERENCES `returns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_tag_assignments_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `return_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `return_tracking`
--
ALTER TABLE `return_tracking`
  ADD CONSTRAINT `return_tracking_ibfk_1` FOREIGN KEY (`return_id`) REFERENCES `returns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_wallets`
--
ALTER TABLE `user_wallets`
  ADD CONSTRAINT `user_wallets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
