-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2026 at 10:07 AM
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
(6, 'Sports & Fitness', 'sports-fitness', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-20 06:40:00', '2024-01-20 06:40:00'),
(7, 'Toys & Games', 'toys-games', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-21 10:00:00', '2024-01-21 10:00:00'),
(8, 'Automotive', 'automotive', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2024-01-22 04:30:00', '2024-01-22 04:30:00'),
(9, 'Groceries', 'groceries', 'category_1769231503_iVP18Yzu9B.jpg', 'inactive', '2024-01-23 07:55:00', '2026-01-26 23:38:50'),
(10, 'Healthcare', 'healthcare', 'category_1769231503_iVP18Yzu9B.jpg', 'inactive', '2024-01-24 12:30:00', '2026-01-26 23:42:15');

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
(4, 'Meera Iyer', 'meera.iyer@example.com', 'Job Application', 'I am writing to apply for the Marketing Manager position advertised on your website. I have attached my resume for your consideration.', '2024-01-18 05:50:00', '2024-01-18 05:50:00'),
(5, 'Vikram Singh', 'vikram.singh@example.com', 'Technical Issue', 'I am unable to reset my password on your portal. The reset link in the email is not working. Please help.', '2024-01-19 11:00:00', '2024-01-19 11:00:00'),
(6, 'Ananya Reddy', 'ananya.reddy@example.com', 'Partnership Proposal', 'I represent a startup in the ed-tech space and would like to explore collaboration opportunities with your platform.', '2024-01-20 07:40:00', '2024-01-20 07:40:00'),
(7, 'Suresh Menon', 'suresh.menon@example.com', 'Complaint', 'The product I received is damaged and different from what was shown on the website. I would like a refund or replacement.', '2024-01-21 10:15:00', '2024-01-21 10:15:00'),
(8, 'Neha Gupta', 'neha.gupta@example.com', 'Service Inquiry', 'Do you offer custom software development services for healthcare businesses? If yes, please share your portfolio.', '2024-01-22 04:35:00', '2024-01-22 04:35:00'),
(9, 'Karthik Nair', 'karthik.nair@example.com', 'Feature Request', 'Could you add UPI payment option to your checkout process? It would make payments much easier for Indian customers.', '2024-01-23 06:55:00', '2024-01-23 06:55:00'),
(10, 'Divya Joshi', 'divya.joshi@example.com', 'Account Deletion', 'I would like to delete my account from your platform. Please confirm the process and let me know if any data will be retained.', '2024-01-24 12:20:00', '2024-01-24 12:20:00'),
(11, 'Litu Nayak', 'laxmanpradhan784@gmail.com', 'Other', 'hi', '2026-01-26 06:32:45', '2026-01-26 06:32:45'),
(12, 'Litu Nayak', 'laxmanpradhan784@gmail.com', 'Product Support', 'asdvfr', '2026-01-26 06:38:19', '2026-01-26 06:38:19'),
(13, 'Litu Nayak', 'laxmanpradhan784@gmail.com', 'Order Issues', 'FRBGHTF', '2026-01-26 06:45:21', '2026-01-26 06:45:21'),
(14, 'Litu Nayak', 'laxmanpradhan784@gmail.com', 'Order Issues', 'FRBGHTF', '2026-01-26 06:46:22', '2026-01-26 06:46:22'),
(15, 'Litu Nayak', 'laxmanpradhan784@gmail.com', 'Returns & Refunds', 'ASCFSDE', '2026-01-26 06:57:28', '2026-01-26 06:57:28');

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
  `transaction_id` varchar(255) DEFAULT NULL,
  `gateway_response` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `subtotal`, `shipping`, `tax`, `total`, `status`, `payment_method`, `payment_gateway`, `payment_status`, `shipping_name`, `shipping_email`, `shipping_phone`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_zip`, `shipping_country`, `shipping_method`, `created_at`, `updated_at`, `transaction_id`, `gateway_response`) VALUES
(1, 'ORD-20260126-697733164FB57', 2, 2647.00, 0.00, 476.46, 3123.46, 'pending', 'cod', NULL, 'pending', 'Regular Users', 'user@example.com', '0987654321', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-26 03:55:42', '2026-01-26 03:55:42', NULL, NULL),
(2, 'ORD-20260126-69773D37C153B', 6, 1327.98, 150.00, 239.04, 1717.02, 'pending', 'card', NULL, 'paid', 'pradhan Nayak', 'pradhan@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-26 04:38:55', '2026-01-26 04:38:55', NULL, NULL),
(3, 'ORD-260126-104808-0069902', 6, 2662.99, 150.00, 479.34, 3292.33, 'pending', 'upi', NULL, 'paid', 'pradhan Nayak', 'pradhan@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-26 05:18:08', '2026-01-26 05:18:08', NULL, NULL),
(4, 'ORD-260126-115122-0044', 2, 314.99, 50.00, 56.70, 421.69, 'pending', 'upi', NULL, 'paid', 'Regular Users', 'user@example.com', '0987654321', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-26 06:21:22', '2026-01-26 06:21:22', NULL, NULL),
(5, 'ORD-260126-120445-0095975', 9, 314.99, 50.00, 56.70, 421.69, 'pending', 'upi', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-26 06:34:45', '2026-01-26 06:34:45', NULL, NULL),
(6, 'ORD-260126-123355-0093725', 9, 2498.00, 150.00, 449.64, 3097.64, 'pending', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-26 07:03:55', '2026-01-26 07:03:55', NULL, NULL),
(7, 'ORD-260126-123504-0096403', 9, 1999.00, 0.00, 359.82, 2358.82, 'pending', 'upi', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-26 07:05:04', '2026-01-26 07:05:04', NULL, NULL),
(8, 'ORD-260126-123954-0096586', 9, 899.00, 50.00, 161.82, 1110.82, 'pending', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'standard', '2026-01-26 07:09:54', '2026-01-26 07:09:54', NULL, NULL),
(9, 'ORD-260126-124349-0099760', 9, 2662.99, 150.00, 479.34, 3292.33, 'pending', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-26 07:13:49', '2026-01-26 07:13:49', NULL, NULL),
(10, 'ORD-260126-125013-0099295', 9, 2847.00, 150.00, 512.46, 3509.46, 'pending', 'upi', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-26 07:20:13', '2026-01-26 07:20:13', NULL, NULL),
(11, 'ORD-260126-130557-0095327', 9, 648.00, 150.00, 116.64, 914.64, 'pending', 'card', NULL, 'paid', 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-26 07:35:57', '2026-01-26 07:35:57', NULL, NULL),
(12, 'ORD-260126-130837-0109806', 10, 663.99, 150.00, 119.52, 933.51, 'pending', 'upi', NULL, 'paid', 'jayesh bhai', 'jayeshshahane786@gmail.com', '09978767202', '1st Floor, 451, 9th A Main, 2nd Block, Jayanagar, Bengaluru, Karnataka 560011', 'Bengaluru', 'Karnataka', '560011', 'India', 'express', '2026-01-26 07:38:37', '2026-01-26 07:38:37', NULL, NULL);

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
(4, 2, 62, 'Operations', 2, 15.99, 31.98, 9, 'Groceries', '2026-01-26 04:38:55', '2026-01-26 04:38:55'),
(5, 2, 10, 'Digital Thermometer', 2, 299.00, 598.00, 10, 'Healthcare', '2026-01-26 04:38:55', '2026-01-26 04:38:55'),
(6, 2, 9, 'Organic Green Tea', 2, 349.00, 698.00, 9, 'Groceries', '2026-01-26 04:38:55', '2026-01-26 04:38:55'),
(7, 3, 62, 'Operations', 1, 15.99, 15.99, 9, 'Groceries', '2026-01-26 05:18:08', '2026-01-26 05:18:08'),
(8, 3, 10, 'Digital Thermometer', 1, 299.00, 299.00, 10, 'Healthcare', '2026-01-26 05:18:08', '2026-01-26 05:18:08'),
(9, 3, 9, 'Organic Green Tea', 1, 349.00, 349.00, 9, 'Groceries', '2026-01-26 05:18:08', '2026-01-26 05:18:08'),
(10, 3, 8, 'Car Air Purifier', 1, 1999.00, 1999.00, 8, 'Automotive', '2026-01-26 05:18:08', '2026-01-26 05:18:08'),
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
(28, 12, 62, 'Operations', 1, 15.99, 15.99, 9, 'Groceries', '2026-01-26 07:38:37', '2026-01-26 07:38:37'),
(29, 12, 10, 'Digital Thermometer', 1, 299.00, 299.00, 10, 'Healthcare', '2026-01-26 07:38:37', '2026-01-26 07:38:37'),
(30, 12, 9, 'Organic Green Tea', 1, 349.00, 349.00, 9, 'Groceries', '2026-01-26 07:38:37', '2026-01-26 07:38:37');

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
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `image`, `description`, `price`, `stock`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Smartphone X Pro', 'smartphone-x-pro', 'product_1769234603_Nb4pjAqd9m.jpg', 'Latest smartphone with 128GB storage, 8GB RAM, 6.7-inch AMOLED display, and 48MP triple camera system.', 29999.00, 50, 'active', '2024-01-15 04:30:00', '2024-01-15 04:30:00'),
(2, 2, 'Men\'s Casual Shirt', 'mens-casual-shirt', 'product_1769234603_Nb4pjAqd9m.jpg', 'Premium cotton casual shirt available in multiple colors and sizes. Perfect for office and casual wear.', 1299.00, 120, 'active', '2024-01-16 06:00:00', '2024-01-16 06:00:00'),
(3, 3, 'Non-Stick Cookware Set', 'non-stick-cookware-set', 'product_1769234603_Nb4pjAqd9m.jpg', '5-piece non-stick cookware set including frying pan, saucepan, and kadai with glass lids.', 2499.00, 35, 'active', '2024-01-17 07:15:00', '2024-01-17 07:15:00'),
(4, 4, 'Vitamin C Face Serum', 'vitamin-c-face-serum', 'product_1769234603_Nb4pjAqd9m.jpg', 'Anti-aging vitamin C serum with hyaluronic acid for brightening and reducing dark spots. 30ml bottle.', 899.00, 78, 'active', '2024-01-18 08:50:00', '2026-01-26 07:09:54'),
(5, 5, 'The Psychology of Money', 'psychology-of-money', 'product_1769234603_Nb4pjAqd9m.jpg', 'Bestselling book on personal finance and investment psychology by Morgan Housel. Hardcover edition.', 499.00, 200, 'active', '2024-01-19 09:40:00', '2024-01-19 09:40:00'),
(6, 6, 'Yoga Mat Premium', 'yoga-mat-premium', 'product_1769234603_Nb4pjAqd9m.jpg', '6mm thick non-slip yoga mat with carrying strap. Eco-friendly TPE material in multiple colors.', 1499.00, 56, 'active', '2024-01-20 11:00:00', '2026-01-26 07:20:13'),
(7, 7, 'Educational Building Blocks', 'educational-building-blocks', 'product_1769234603_Nb4pjAqd9m.jpg', '500-piece building blocks set for kids ages 5+. Promotes creativity and motor skills development.', 999.00, 71, 'active', '2024-01-21 12:15:00', '2026-01-26 07:20:13'),
(8, 8, 'Car Air Purifier', 'car-air-purifier', 'product_1769234603_Nb4pjAqd9m.jpg', 'Compact HEPA filter car air purifier with ionizer. USB powered with adjustable fan speed.', 1999.00, 32, 'active', '2024-01-22 03:45:00', '2026-01-27 00:59:55'),
(9, 9, 'Organic Green Tea', 'organic-green-tea', 'product_1769234603_Nb4pjAqd9m.jpg', '100% organic green tea leaves packed in airtight container. 250g pack with antioxidant benefits.', 349.00, 134, 'active', '2024-01-23 07:55:00', '2026-01-26 07:38:37'),
(10, 10, 'Digital Thermometer', 'digital-thermometer', 'product_1769234603_Nb4pjAqd9m.jpg', 'Fast and accurate digital thermometer with beep alert and fever indicator. Battery included.', 299.00, 283, 'active', '2024-01-24 12:30:00', '2026-01-26 07:38:37'),
(62, 9, 'Operations', 'operations', 'product_1769258578_rWP0gdhIvh.jpg', 'testing', 15.99, 68, 'active', '2026-01-24 07:12:58', '2026-01-26 23:39:26');

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
('0zU6EjQFji9K4RA6mlfSI5jCNowPsxGatc9EYBrN', 9, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiR25BWlI2V2VYWUFyQW1hRjF6a3oxSm1mSGFPakhzalBxd0ZBeHBRMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMToiZ3Vlc3RfdG9rZW4iO3M6MzI6IjhxWllxWTNqQ0tYNVZXOXdLblN6VmgxdjRGMWZ3emlzIjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNToiaHR0cDovL2xvY2FsaG9zdC9lLWNvbW1tZXJjZS9wdWJsaWMiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjk7fQ==', 1769495684),
('HZwQvPdxmiPoaJYumsa2H1l1rPxIzo12Mlwmu9Lu', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRVNkQWxFMmpUMGZHRmlFS0pRdGVabWFtZE1ZaGtxTjFqbnRtaG1GNCI7czoxMToiZ3Vlc3RfdG9rZW4iO3M6MzI6InlycGdtSXFteHRWa2puSUZ6Z1IzeGNaaE1CN1lrdUk0IjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNToiaHR0cDovL2xvY2FsaG9zdC9lLWNvbW1tZXJjZS9wdWJsaWMiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769503762),
('WjTgG8l2w0MfwMxYTG5pdYmTX4o3X8X80lz1M0zm', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSFBycHJBWURYN0xiV0kwMDNTTFkwUzMxUUZOUkFrYVpnVW1kamFIUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMToiZ3Vlc3RfdG9rZW4iO3M6MzI6InJ2R2VNY3M3NXRnVTRrV081MWZjYnF0YmxxTFo1ZXJSIjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovL2xvY2FsaG9zdC9lLWNvbW1tZXJjZS9wdWJsaWMvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1769490465);

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
(1, 'Summer Sale 2024', 'Up to 70% Off on Fashion Collection', 'slider_1769490411_UdHjilZig1.png', 'Shop Now', NULL, 'active', '2024-01-15 03:30:00', '2026-01-26 23:36:51'),
(2, 'New Arrivals', 'Discover the Latest Trends in Electronics', 'slider_1769490420_57wRHIuClq.png', 'Explore', NULL, 'active', '2024-01-16 05:00:00', '2026-01-26 23:37:00'),
(3, 'Free Shipping', 'On All Orders Above ₹999', 'slider_1769490433_jn1mMYUDBz.png', 'Learn More', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2024-01-17 05:45:00', '2026-01-26 23:37:13'),
(4, 'Home Decor Festival', 'Transform Your Living Space', 'slider_1769490403_n6fF3wfk60.png', 'Browse Collection', NULL, 'active', '2024-01-18 08:50:00', '2026-01-26 23:36:43'),
(5, 'Fitness Essentials', 'Get Fit with Premium Equipment', 'slider_1769490384_idu3lik8ye.png', 'Shop Fitness', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2024-01-19 11:15:00', '2026-01-26 23:36:24'),
(6, 'Mobile Mania', 'Best Deals on Smartphones', 'slider_1769490375_8DAI1xBYU4.png', 'Buy Now', NULL, 'inactive', '2024-01-20 06:40:00', '2026-01-26 23:38:12'),
(7, 'Book Fair', 'Thousands of Books at Discounted Prices', 'slider_1769490365_r3q1e0vTSB.png', 'View Books', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'inactive', '2024-01-21 10:00:00', '2026-01-26 23:36:05'),
(8, 'Beauty Bonanza', 'Premium Cosmetics & Skincare', 'slider_1769490357_59OFV1pqxb.png', 'Shop Beauty', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2024-01-22 04:30:00', '2026-01-26 23:35:57'),
(9, 'Kitchen Appliances', 'Modern Kitchen Solutions', 'slider_1769490348_ksusZEY4MH.png', 'Discover', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'inactive', '2024-01-23 07:55:00', '2026-01-26 23:38:07'),
(10, 'Weekend Special', 'Extra 20% Off on Selected Items', 'slider_1769490337_ABTWU37Dzu.png', 'Grab Deal', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'inactive', '2024-01-24 12:30:00', '2026-01-26 23:38:01');

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
(6, 'pradhan', 'pradhan@gmail.com', '09978767202', NULL, '$2y$12$Mz2M/wJGrefnTTyKeZa5sePEP4zZ4OQsPncQLpfYx4znXGN7Hdei2', 'user', NULL, '2026-01-24 01:58:12', '2026-01-24 05:03:22', NULL),
(7, 'Laxman Pradhan', 'Laxman784@gmail.com', '9913817411', NULL, '$2y$12$CBHMk4fbfQ8DSTGiNYcdt.GDzzY5ZQEjC9vJ9nfU0ES/uRNJSMjQy', 'admin', NULL, '2026-01-24 04:56:17', '2026-01-24 04:56:33', NULL),
(8, 'Litu Nayak', 'dbg@gmail.com', '09978767202', NULL, '$2y$12$1Rkl9KgtDGpH9h1Sfzg9jeqtT5/FGEINALYZCh1FsyePhsxfiVWau', 'user', NULL, '2026-01-26 02:01:50', '2026-01-26 02:01:50', NULL),
(9, 'laxman pradhan', 'laxmanpradhan784@gmail.com', '09978767202', NULL, '$2y$12$Of5BvP9xEQFq9tNMNwwjjems1ya9WK7Z6Ec8R4uPmR98exIq6UULa', 'user', NULL, '2026-01-26 06:34:07', '2026-01-26 06:34:07', NULL),
(10, 'jayesh bhai', 'jayeshshahane786@gmail.com', '09978767202', NULL, '$2y$12$KUN52Wu9qdglPZNAZ5tPKuB/Sr5FCuAaMoMnhECY5kq6PQIyhj6Dy', 'user', NULL, '2026-01-26 07:38:06', '2026-01-26 07:38:06', NULL);

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
  ADD KEY `orders_status_index` (`status`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
