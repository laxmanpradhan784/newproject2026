-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2026 at 07:49 AM
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
(161, 9, NULL, NULL, 0, 7, 1, 999.00, '2026-02-02 01:06:47', '2026-02-02 01:06:47'),
(163, 11, NULL, NULL, 0, 9, 1, 349.00, '2026-02-02 01:18:47', '2026-02-02 01:18:47');

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
(8, 'fbhfd', 'sdvgsdvg', 'vsegfrbh er 4', 'percentage', 22.00, 22.00, 22.00, '2026-01-31', '2026-02-27', 22, 12, 'all', 'all', 'all', 'active', '2026-01-31 04:56:52', '2026-01-31 04:56:52');

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
(2, 3, 6, '2026-01-31 08:48:42');

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
(8, 2, 11, 24, 500.00, 3646.00, 3862.28, '2026-02-02 06:48:24');

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
(2, 4, 2, '2026-01-31 08:48:42');

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
(4, 'ORD-260126-115122-0044', 2, 314.99, 50.00, 56.70, 421.69, 'delivered', 'upi', NULL, 'paid', 'Regular Users', 'user@example.com', '0987654321', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-26 06:21:22', '2026-01-29 06:05:44', '2026-01-29 06:05:44', NULL, NULL, NULL, NULL, NULL, 0.00),
(5, 'ORD-260126-120445-0095975', 9, 314.99, 50.00, 56.70, 421.69, 'delivered', 'upi', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-26 06:34:45', '2026-01-29 06:03:32', '2026-01-29 06:03:32', NULL, NULL, NULL, NULL, NULL, 0.00),
(6, 'ORD-260126-123355-0093725', 9, 2498.00, 150.00, 449.64, 3097.64, 'cancelled', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-26 07:03:55', '2026-01-28 07:28:49', NULL, '2026-01-28 07:28:49', NULL, NULL, NULL, NULL, 0.00),
(7, 'ORD-260126-123504-0096403', 9, 1999.00, 0.00, 359.82, 2358.82, 'processing', 'upi', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-26 07:05:04', '2026-01-28 07:13:09', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(8, 'ORD-260126-123954-0096586', 9, 899.00, 50.00, 161.82, 1110.82, 'processing', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-26 07:09:54', '2026-01-28 07:13:05', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(9, 'ORD-260126-124349-0099760', 9, 2662.99, 150.00, 479.34, 3292.33, 'shipped', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-26 07:13:49', '2026-01-29 06:03:21', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(10, 'ORD-260126-125013-0099295', 9, 2847.00, 150.00, 512.46, 3509.46, 'pending', 'upi', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-26 07:20:13', '2026-01-28 07:28:21', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(11, 'ORD-260126-130557-0095327', 9, 648.00, 150.00, 116.64, 914.64, 'processing', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-26 07:35:57', '2026-01-28 06:18:05', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(13, 'ORD-260127-094000-0094389', 9, 999.00, 50.00, 179.82, 1228.82, 'shipped', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-27 04:10:00', '2026-01-28 07:21:05', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(14, 'ORD-260128-062903-0098880', 9, 3798.00, 0.00, 683.64, 4481.64, 'delivered', 'cod', NULL, 'pending', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-28 00:59:03', '2026-01-29 05:00:45', '2026-01-29 05:00:45', NULL, NULL, NULL, NULL, NULL, 0.00),
(15, 'ORD-260130-100006-0099821', 9, 999.00, 150.00, 179.82, 1328.82, 'processing', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-30 04:30:06', '2026-01-30 06:07:31', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(16, 'ORD-260131-123433-0092218', 9, 5997.00, 150.00, 989.46, 6636.46, 'pending', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', 'svfsdx', 'grdgb', 'sgbfr', '394221', 'India', 'express', '2026-01-31 07:04:33', '2026-01-31 07:04:33', NULL, NULL, NULL, NULL, 2, 'FLAT500', 500.00),
(17, 'ORD-260131-123436-0098307', 9, 5997.00, 150.00, 989.46, 6636.46, 'pending', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', 'svfsdx', 'grdgb', 'sgbfr', '394221', 'India', 'express', '2026-01-31 07:04:36', '2026-01-31 07:04:36', NULL, NULL, NULL, NULL, 2, 'FLAT500', 500.00),
(18, 'ORD-260131-132054-0096832', 9, 3998.00, 150.00, 710.64, 4808.64, 'pending', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-31 07:50:54', '2026-01-31 07:50:54', NULL, NULL, NULL, NULL, 5, 'FREESHIP', 50.00),
(19, 'ORD-260131-132432-0099989', 9, 3998.00, 150.00, 647.68, 4395.88, 'pending', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-31 07:54:32', '2026-01-31 07:54:32', NULL, NULL, NULL, NULL, 1, 'WELCOME10', 399.80),
(20, 'ORD-260131-132610-0091100', 9, 4497.00, 150.00, 805.50, 5430.50, 'pending', 'upi', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-31 07:56:10', '2026-01-31 07:56:10', NULL, NULL, NULL, NULL, 8, 'fbhfd', 22.00),
(21, 'ORD-260131-132614-0099182', 9, 4497.00, 150.00, 805.50, 5430.50, 'pending', 'upi', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-31 07:56:14', '2026-01-31 07:56:14', NULL, NULL, NULL, NULL, 8, 'fbhfd', 22.00),
(22, 'ORD-260202-051850-0091495', 9, 648.00, 150.00, 112.68, 888.68, 'pending', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-02-01 23:48:50', '2026-02-01 23:48:50', NULL, NULL, NULL, NULL, 8, 'fbhfd', 22.00),
(23, 'ORD-260202-052549-0095799', 9, 598.00, 50.00, 107.64, 755.64, 'pending', 'cod', NULL, 'pending', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-02-01 23:55:49', '2026-02-01 23:55:49', NULL, NULL, NULL, NULL, NULL, NULL, 0.00),
(24, 'ORD-260202-064824-0116334', 11, 3646.00, 150.00, 566.28, 3862.28, 'pending', 'cod', NULL, 'pending', 'Litu Nayak', 'Litu123@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-02-02 01:18:24', '2026-02-02 01:18:24', NULL, NULL, NULL, NULL, 2, 'FLAT500', 500.00);

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
(3, 1, 8, 'Car Air Purifier', 1, 1999.00, 1999.00, 8, 'Automotive', '2026-01-26 03:55:42', '2026-01-26 03:55:42'),
(11, 4, 62, 'Operations', 1, 15.99, 15.99, 9, 'Groceries', '2026-01-26 06:21:22', '2026-01-26 06:21:22'),
(12, 4, 10, 'Digital Thermometer', 1, 299.00, 299.00, 10, 'Healthcare', '2026-01-26 06:21:22', '2026-01-26 06:21:22'),
(13, 5, 62, 'Operations', 1, 15.99, 15.99, 9, 'Groceries', '2026-01-26 06:34:45', '2026-01-26 06:34:45'),
(14, 5, 10, 'Digital Thermometer', 1, 299.00, 299.00, 10, 'Healthcare', '2026-01-26 06:34:45', '2026-01-26 06:34:45'),
(15, 6, 7, 'Educational Building Blocks', 1, 999.00, 999.00, 7, 'Toys & Games', '2026-01-26 07:03:55', '2026-01-26 07:03:55'),
(16, 6, 6, 'Yoga Mat Premium', 1, 1499.00, 1499.00, 6, 'Sports & Fitness', '2026-01-26 07:03:55', '2026-01-26 07:03:55'),
(17, 7, 8, 'Car Air Purifier', 1, 1999.00, 1999.00, 8, 'Automotive', '2026-01-26 07:05:04', '2026-01-26 07:05:04'),
(18, 8, 4, 'Vitamin C Face Serum', 1, 899.00, 899.00, 4, 'Beauty & Personal Care', '2026-01-26 07:09:54', '2026-01-26 07:09:54'),
(19, 9, 62, 'Operations', 1, 15.99, 15.99, 9, 'Groceries', '2026-01-26 07:13:49', '2026-01-26 07:13:49'),
(20, 9, 10, 'Digital Thermometer', 1, 299.00, 299.00, 10, 'Healthcare', '2026-01-26 07:13:49', '2026-01-26 07:13:49'),
(21, 9, 9, 'Organic Green Tea', 1, 349.00, 349.00, 9, 'Groceries', '2026-01-26 07:13:49', '2026-01-26 07:13:49'),
(22, 9, 8, 'Car Air Purifier', 1, 1999.00, 1999.00, 8, 'Automotive', '2026-01-26 07:13:49', '2026-01-26 07:13:49'),
(23, 10, 7, 'Educational Building Blocks', 1, 999.00, 999.00, 7, 'Toys & Games', '2026-01-26 07:20:13', '2026-01-26 07:20:13'),
(24, 10, 6, 'Yoga Mat Premium', 1, 1499.00, 1499.00, 6, 'Sports & Fitness', '2026-01-26 07:20:13', '2026-01-26 07:20:13'),
(25, 10, 9, 'Organic Green Tea', 1, 349.00, 349.00, 9, 'Groceries', '2026-01-26 07:20:13', '2026-01-26 07:20:13'),
(26, 11, 10, 'Digital Thermometer', 1, 299.00, 299.00, 10, 'Healthcare', '2026-01-26 07:35:57', '2026-01-26 07:35:57'),
(27, 11, 9, 'Organic Green Tea', 1, 349.00, 349.00, 9, 'Groceries', '2026-01-26 07:35:57', '2026-01-26 07:35:57'),
(31, 13, 7, 'Educational Building Blocks', 1, 999.00, 999.00, 7, 'Toys & Games', '2026-01-27 04:10:00', '2026-01-27 04:10:00'),
(32, 14, 3, 'Non-Stick Cookware Set', 1, 2499.00, 2499.00, 3, 'Home & Kitchen', '2026-01-28 00:59:03', '2026-01-28 00:59:03'),
(33, 14, 2, 'Men\'s Casual Shirt', 1, 1299.00, 1299.00, 2, 'Fashion', '2026-01-28 00:59:03', '2026-01-28 00:59:03'),
(34, 15, 7, 'Educational Building Blocks', 1, 999.00, 999.00, 7, 'Toys & Games', '2026-01-30 04:30:06', '2026-01-30 04:30:06'),
(35, 16, 8, 'Car Air Purifier', 3, 1999.00, 5997.00, 8, 'Automotive', '2026-01-31 07:04:33', '2026-01-31 07:04:33'),
(36, 17, 8, 'Car Air Purifier', 3, 1999.00, 5997.00, 8, 'Automotive', '2026-01-31 07:04:36', '2026-01-31 07:04:36'),
(37, 18, 8, 'Car Air Purifier', 2, 1999.00, 3998.00, 8, 'Automotive', '2026-01-31 07:50:54', '2026-01-31 07:50:54'),
(38, 19, 8, 'Car Air Purifier', 2, 1999.00, 3998.00, 8, 'Automotive', '2026-01-31 07:54:32', '2026-01-31 07:54:32'),
(39, 20, 6, 'Yoga Mat Premium', 3, 1499.00, 4497.00, 6, 'Sports & Fitness', '2026-01-31 07:56:10', '2026-01-31 07:56:10'),
(40, 21, 6, 'Yoga Mat Premium', 3, 1499.00, 4497.00, 6, 'Sports & Fitness', '2026-01-31 07:56:14', '2026-01-31 07:56:14'),
(41, 22, 9, 'Organic Green Tea', 1, 349.00, 349.00, 9, 'Groceries', '2026-02-01 23:48:50', '2026-02-01 23:48:50'),
(42, 22, 10, 'Digital Thermometer', 1, 299.00, 299.00, 10, 'Healthcare', '2026-02-01 23:48:50', '2026-02-01 23:48:50'),
(43, 23, 10, 'Digital Thermometer', 2, 299.00, 598.00, 10, 'Healthcare', '2026-02-01 23:55:49', '2026-02-01 23:55:49'),
(44, 24, 10, 'Digital Thermometer', 1, 299.00, 299.00, 10, 'Healthcare', '2026-02-02 01:18:24', '2026-02-02 01:18:24'),
(45, 24, 9, 'Organic Green Tea', 1, 349.00, 349.00, 9, 'Groceries', '2026-02-02 01:18:24', '2026-02-02 01:18:24'),
(46, 24, 6, 'Yoga Mat Premium', 2, 1499.00, 2998.00, 6, 'Sports & Fitness', '2026-02-02 01:18:24', '2026-02-02 01:18:24');

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
(3, 3, 'Non-Stick Cookware Set', 'non-stick-cookware-set', 'product_1769234603_Nb4pjAqd9m.jpg', '5-piece non-stick cookware set including frying pan, saucepan, and kadai with glass lids.', 2499.00, 35, 0.00, 0, 'active', '2024-01-17 07:15:00', '2026-01-30 02:48:55'),
(4, 4, 'Vitamin C Face Serum', 'vitamin-c-face-serum', 'product_1769234603_Nb4pjAqd9m.jpg', 'Anti-aging vitamin C serum with hyaluronic acid for brightening and reducing dark spots. 30ml bottle.', 899.00, 78, 0.00, 0, 'active', '2024-01-18 08:50:00', '2026-01-26 07:09:54'),
(5, 5, 'The Psychology of Money', 'psychology-of-money', 'product_1769234603_Nb4pjAqd9m.jpg', 'Bestselling book on personal finance and investment psychology by Morgan Housel. Hardcover edition.', 499.00, 200, 0.00, 0, 'active', '2024-01-19 09:40:00', '2026-01-29 06:56:24'),
(6, 6, 'Yoga Mat Premium', 'yoga-mat-premium', 'product_1769234603_Nb4pjAqd9m.jpg', '6mm thick non-slip yoga mat with carrying strap. Eco-friendly TPE material in multiple colors.', 1499.00, 44, 0.00, 0, 'active', '2024-01-20 11:00:00', '2026-02-02 01:18:24'),
(7, 7, 'Educational Building Blocks', 'educational-building-blocks', 'product_1769234603_Nb4pjAqd9m.jpg', '500-piece building blocks set for kids ages 5+. Promotes creativity and motor skills development.', 999.00, 67, 0.00, 0, 'active', '2024-01-21 12:15:00', '2026-02-02 01:06:47'),
(8, 8, 'Car Air Purifier', 'car-air-purifier', 'product_1769234603_Nb4pjAqd9m.jpg', 'Compact HEPA filter car air purifier with ionizer. USB powered with adjustable fan speed.', 1999.00, 15, 0.00, 0, 'active', '2024-01-22 03:45:00', '2026-02-02 00:01:31'),
(9, 9, 'Organic Green Tea', 'organic-green-tea', 'product_1769234603_Nb4pjAqd9m.jpg', '100% organic green tea leaves packed in airtight container. 250g pack with antioxidant benefits.', 349.00, 130, 0.00, 0, 'active', '2024-01-23 07:55:00', '2026-02-02 01:18:47'),
(10, 10, 'Digital Thermometer', 'digital-thermometer', 'product_1769234603_Nb4pjAqd9m.jpg', 'Fast and accurate digital thermometer with beep alert and fever indicator. Battery included.', 299.00, 275, 0.00, 0, 'active', '2024-01-24 12:30:00', '2026-02-02 01:18:24'),
(62, 1, 'Operations', 'operations', 'product_1769258578_rWP0gdhIvh.jpg', 'testing', 10.00, 67, 0.00, 0, 'active', '2026-01-24 07:12:58', '2026-02-01 23:57:49');

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
('xFtINAdqi72dcpS96Xia0BhkKY5o6T2YtN0MGvll', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiazFTQnQ2cWJIN3FLRVBWSkR3TEpJNUk4VmFkdUNyeXZ4MXgxc3RWQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMToiZ3Vlc3RfdG9rZW4iO3M6MzI6IlFkTzdiNVdnTFlTMVJQbkIxb2ZhTjAwdENwWDc2U3cwIjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovL2xvY2FsaG9zdC9lLWNvbW1tZXJjZS9wdWJsaWMvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1770014959);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `coupon_categories`
--
ALTER TABLE `coupon_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupon_products`
--
ALTER TABLE `coupon_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `coupon_users`
--
ALTER TABLE `coupon_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

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
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
