-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2026 at 08:33 AM
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
(1, 'Electronics', 'electronics', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2026-02-07 07:18:22', '2026-02-07 07:18:22'),
(2, 'Fashion', 'fashion', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2026-02-07 07:18:22', '2026-02-07 07:18:22'),
(3, 'Home & Kitchen', 'home-kitchen', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2026-02-07 07:18:22', '2026-02-07 07:18:22'),
(4, 'Beauty & Personal Care', 'beauty-personal-care', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2026-02-07 07:18:22', '2026-02-07 07:18:22'),
(5, 'Sports & Fitness', 'sports-fitness', 'category_1769231503_iVP18Yzu9B.jpg', 'active', '2026-02-07 07:18:22', '2026-02-07 07:18:22');

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
(1, 'WELCOME10', 'Welcome Discount', '10% off for new customers', 'percentage', 10.00, 1000.00, 500.00, '2026-02-07', '2027-02-07', 1000, 1, 'all', 'all', 'all', 'active', '2026-02-07 07:21:32', '2026-02-07 07:21:32'),
(2, 'FLAT500', 'Flat ₹500 Off', 'Get ₹500 off on orders above ₹3000', 'fixed_amount', 500.00, 3000.00, 500.00, '2026-02-07', '2027-02-07', 500, 1, 'all', 'all', 'all', 'active', '2026-02-07 07:21:32', '2026-02-07 07:21:32'),
(3, 'SUMMER20', 'Summer Sale', '20% off on all summer items', 'percentage', 20.00, 1500.00, 1000.00, '2026-02-07', '2026-05-07', NULL, 3, 'all', 'all', 'all', 'active', '2026-02-07 07:21:32', '2026-02-07 07:21:32');

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
(1, 2, 103, 1, 500.00, 47497.00, 55456.46, '2026-02-09 05:34:15');

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
(4, '2026_01_27_060556_add_google_id_to_users_table', 2),
(5, '2026_02_07_104521_create_product_images_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `razorpay_signature` varchar(255) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `payment_method` enum('cod','card','upi','razorpay') NOT NULL,
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
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_captured` tinyint(1) DEFAULT 0,
  `payment_captured_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`, `user_id`, `subtotal`, `shipping`, `tax`, `total`, `status`, `payment_method`, `payment_gateway`, `payment_status`, `shipping_name`, `shipping_email`, `shipping_phone`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_zip`, `shipping_country`, `shipping_method`, `created_at`, `updated_at`, `delivered_at`, `cancelled_at`, `transaction_id`, `gateway_response`, `coupon_id`, `coupon_code`, `discount_amount`, `payment_captured`, `payment_captured_at`) VALUES
(1, 'ORD-260209-053329-1035756', NULL, NULL, NULL, 103, 47497.00, 0.00, 8459.46, 55456.46, 'processing', 'razorpay', NULL, 'paid', 'LAXMAN PRADHAN', 'laxmanpradhan784@gmail.com', '9913817411', '531 apexa nagar bamroli road surat', 'surat', 'guurat', '394221', 'India', 'standard', '2026-02-09 00:03:29', '2026-02-09 00:04:15', NULL, NULL, NULL, NULL, 2, 'FLAT500', 500.00, 0, NULL);

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
(1, 1, 1, 'Smartphone X', 1, 29999.00, 29999.00, 1, 'Electronics', '2026-02-09 00:04:15', '2026-02-09 00:04:15'),
(2, 1, 2, 'Wireless Earbuds Pro', 1, 4499.00, 4499.00, 1, 'Electronics', '2026-02-09 00:04:15', '2026-02-09 00:04:15'),
(3, 1, 3, 'Smart Watch Series 6', 1, 12999.00, 12999.00, 1, 'Electronics', '2026-02-09 00:04:15', '2026-02-09 00:04:15');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `razorpay_signature` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) DEFAULT 'INR',
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_gateway` varchar(50) DEFAULT 'razorpay',
  `bank` varchar(100) DEFAULT NULL,
  `card_type` varchar(50) DEFAULT NULL,
  `wallet` varchar(50) DEFAULT NULL,
  `vpa` varchar(100) DEFAULT NULL,
  `status` enum('created','authorized','captured','failed','refunded','partially_refunded') DEFAULT 'created',
  `gateway_response` text DEFAULT NULL,
  `error_code` varchar(100) DEFAULT NULL,
  `error_description` text DEFAULT NULL,
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `refund_id` varchar(255) DEFAULT NULL,
  `refund_status` varchar(50) DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `user_id`, `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`, `amount`, `currency`, `payment_method`, `payment_gateway`, `bank`, `card_type`, `wallet`, `vpa`, `status`, `gateway_response`, `error_code`, `error_description`, `refund_amount`, `refund_id`, `refund_status`, `refunded_at`, `created_at`, `updated_at`) VALUES
(2, 1, 103, 'order_SDvurfJhvBwFUF', 'pay_SDvvKkPVeMCfJk', '344ca66e780478b30a2ed3f3701342266a55f9542640d862e96a1738e9f4f364', 55456.46, 'INR', 'card', 'razorpay', NULL, NULL, NULL, NULL, 'captured', '\"{}\"', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-09 00:04:15', '2026-02-09 00:04:15');

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
(1, 1, 'Smartphone X', 'smartphone-x', 'product_1770451330_7ZmQ501nEx.jpg', 'Latest smartphone with 128GB storage, 48MP camera', 29999.00, 48, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-09 00:04:15'),
(2, 1, 'Wireless Earbuds Pro', 'wireless-earbuds-pro', 'product_1770451279_oItdOJ3KZz.jpg', 'Noise cancelling wireless earbuds with 30hr battery', 4499.00, 98, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-09 00:04:15'),
(3, 1, 'Smart Watch Series 6', 'smart-watch-series-6', 'product_1770451243_a6imvra10y.jpg', 'Health tracking smartwatch with GPS and heart monitor', 12999.00, 28, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-09 00:04:15'),
(4, 2, 'Men\'s Casual Shirt', 'mens-casual-shirt', 'product_1770451182_01K2R69cqH.jpg', 'Cotton casual shirt for men, available in multiple colors', 1299.00, 80, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 02:29:42'),
(5, 2, 'Women\'s Summer Dress', 'womens-summer-dress', 'product_1770449706_XeHm76elEt.jpg', 'Floral print cotton summer dress, perfect for summer', 2499.00, 60, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 02:05:06'),
(6, 2, 'Leather Formal Shoes', 'leather-formal-shoes', 'product_1770449664_R49W7yWNo5.jpg', 'Premium leather formal shoes for men, comfortable fit', 3899.00, 40, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 02:04:24'),
(7, 3, 'Non-Stick Cookware Set', 'non-stick-cookware-set', 'product_1770449632_xaQPZ9iHU3.jpg', '5-piece non-stick cookware set with glass lids', 3499.00, 25, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 02:03:52'),
(8, 3, 'Air Fryer 5.5L', 'air-fryer-55l', 'product_1770449559_kRGSQ1rp0w.jpg', 'Digital air fryer with 8 preset cooking modes', 5999.00, 35, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 02:02:39'),
(9, 3, 'Queen Size Bed Sheet Set', 'queen-size-bed-sheet-set', 'product_1770449523_frKXjzNaMU.jpg', 'Premium cotton bed sheet set with 2 pillow covers', 1999.00, 70, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 02:02:03'),
(10, 4, 'Vitamin C Face Serum', 'vitamin-c-face-serum', 'product_1770449475_4ubDXpvLfK.jpg', 'Anti-aging vitamin C serum with hyaluronic acid, 30ml', 899.00, 120, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 02:01:15'),
(11, 4, 'Charcoal Face Wash', 'charcoal-face-wash', 'product_1770449442_28CfnZRwpk.jpg', 'Deep cleansing charcoal face wash for all skin types', 349.00, 200, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 02:00:42'),
(12, 4, 'Sunscreen Lotion SPF 50', 'sunscreen-lotion-spf-50', 'product_1770449394_WNErKCiwrP.jpg', 'Water resistant broad spectrum sunscreen, 100ml', 499.00, 150, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 01:59:54'),
(13, 5, 'Premium Yoga Mat', 'premium-yoga-mat', 'product_1770449351_JkMMcRD0iz.jpg', '6mm thick non-slip yoga mat with carrying strap', 1499.00, 90, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 01:59:11'),
(14, 5, 'Dumbbell Set 20kg', 'dumbbell-set-20kg', 'product_1770449259_ekKLg7Cdkq.jpg', 'Adjustable dumbbell set with storage rack', 2999.00, 45, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 01:57:39'),
(15, 5, 'Running Shoes Pro', 'running-shoes-pro', 'product_1770449182_nSS4SvWBbR.jpg', 'Lightweight running shoes with advanced cushioning', 4499.00, 55, 0.00, 0, 'active', '2026-02-07 07:20:13', '2026-02-07 01:56:22');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `thumbnail`, `alt_text`, `is_primary`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, '1770614015_69896cff41403.png', NULL, 'Smartphone X Front View', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(2, 1, '1770614015_69896cff41403.png', NULL, 'Smartphone X Back View', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(3, 1, '1770614015_69896cff41403.png', NULL, 'Smartphone X Side View', 0, 3, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(4, 2, '1770614015_69896cff41403.png', NULL, 'Earbuds Pro with Case', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(5, 2, '1770614015_69896cff41403.png', NULL, 'Earbuds Pro in Ear', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(6, 2, '1770614015_69896cff41403.png', NULL, 'Earbuds Pro Charging', 0, 3, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(7, 3, '1770614015_69896cff41403.png', NULL, 'Smart Watch Face', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(8, 3, '1770614015_69896cff41403.png', NULL, 'Smart Watch Band', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(9, 3, '1770614015_69896cff41403.png', NULL, 'Smart Watch Display', 0, 3, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(10, 3, '1770614015_69896cff41403.png', NULL, 'Smart Watch Charger', 0, 4, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(11, 3, '1770614015_69896cff41403.png', NULL, 'Smart Watch Box', 0, 5, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(12, 4, '1770614015_69896cff41403.png', NULL, 'Shirt Front View', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(13, 4, '1770614015_69896cff41403.png', NULL, 'Shirt Back View', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(14, 5, '1770614015_69896cff41403.png', NULL, 'Dress Front View', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(15, 6, '1770614015_69896cff41403.png', NULL, 'Shoes Front View', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(16, 6, '1770614015_69896cff41403.png', NULL, 'Shoes Side View', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(17, 6, '1770614015_69896cff41403.png', NULL, 'Shoes Bottom View', 0, 3, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(18, 7, '1770614015_69896cff41403.png', NULL, 'Cookware Set', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(19, 7, '1770614015_69896cff41403.png', NULL, 'Pan Closeup', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(20, 7, '1770614015_69896cff41403.png', NULL, 'Pot Closeup', 0, 3, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(21, 7, '1770614015_69896cff41403.png', NULL, 'Lid Closeup', 0, 4, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(22, 8, '1770614015_69896cff41403.png', NULL, 'Air Fryer Front', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(23, 8, '1770614015_69896cff41403.png', NULL, 'Air Fryer Controls', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(24, 9, '1770614015_69896cff41403.png', NULL, 'Bed Sheet Full Set', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(25, 9, '1770614015_69896cff41403.png', NULL, 'Sheet Pattern Closeup', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(26, 9, '1770614015_69896cff41403.png', NULL, 'Pillow Cover Closeup', 0, 3, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(27, 10, '1770614015_69896cff41403.png', NULL, 'Serum Bottle', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(28, 11, '1770614015_69896cff41403.png', NULL, 'Face Wash Tube', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(29, 11, '1770614015_69896cff41403.png', NULL, 'Face Wash Lather', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(30, 12, '1770614015_69896cff41403.png', NULL, 'Sunscreen Bottle', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(31, 12, '1770614015_69896cff41403.png', NULL, 'Sunscreen Texture', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(32, 12, '1770614015_69896cff41403.png', NULL, 'Sunscreen Application', 0, 3, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(33, 13, '1770614015_69896cff41403.png', NULL, 'Yoga Mat Rolled', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(34, 13, '1770614015_69896cff41403.png', NULL, 'Yoga Mat Unrolled', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(35, 13, '1770614015_69896cff41403.png', NULL, 'Yoga Mat Texture', 0, 3, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(36, 13, '1770614015_69896cff41403.png', NULL, 'Yoga Mat Strap', 0, 4, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(37, 14, '1770614015_69896cff41403.png', NULL, 'Dumbbell Set Full', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(38, 14, '1770614015_69896cff41403.png', NULL, 'Single Dumbbell', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(39, 14, '1770614015_69896cff41403.png', NULL, 'Weight Plates', 0, 3, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(40, 15, '1770614015_69896cff41403.png', NULL, 'Running Shoes Front', 1, 1, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(41, 15, '1770614015_69896cff41403.png', NULL, 'Running Shoes Side', 0, 2, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(42, 15, '1770614015_69896cff41403.png', NULL, 'Running Shoes Back', 0, 3, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(43, 15, '1770614015_69896cff41403.png', NULL, 'Running Shoes Sole', 0, 4, '2026-02-09 05:21:33', '2026-02-09 05:21:33'),
(44, 15, '1770614015_69896cff41403.png', NULL, 'Running Shoes Box', 0, 5, '2026-02-09 05:21:33', '2026-02-09 05:21:33');

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
(1, 1, 103, NULL, 5, 'good product', 'this is very  about this products', 'approved', 0, 0, 0, 0, NULL, NULL, '2026-02-07 03:36:51', '2026-02-09 00:11:27');

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
('bTFQEMpKpOuoNkRDJfzLr5IaYWpH0TFDJzYrYFlu', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOGF5QUZhOE1OMmFWS2h6UnpFRFhTdEhqc2hFaHdTT2xCVnQzS1RydyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9sb2NhbGhvc3QvZS1jb21tbWVyY2UvcHVibGljL2FkbWluL3BheW1lbnRzL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoyNDoiYWRtaW4ucGF5bWVudHMuZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMToiZ3Vlc3RfdG9rZW4iO3M6MzI6ImlqRlZaQjkxNVgzYzFvSlVnYTBtNm9pSWhObXNPak9lIjtzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1770622419),
('sZk0GXs1f4xp6BuMHg9eakZwsRCHKjbCpMzMvdRb', 103, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiek51dmFqTW5sSW5wNkZNMGFHVTYwOWNoaEZibWJEUzMzTGFPdnJwcyI7czoxMToiZ3Vlc3RfdG9rZW4iO3M6MzI6Ims5cnh4T092cEVidVRRdjFHQmpHY2hYaUtPNkNWYjZzIjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNToiaHR0cDovL2xvY2FsaG9zdC9lLWNvbW1tZXJjZS9wdWJsaWMiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6NDQ6Imh0dHA6Ly9sb2NhbGhvc3QvZS1jb21tbWVyY2UvcHVibGljL3dpc2hsaXN0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAzO30=', 1770622402);

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
(2, '9913817411', '7735105645', '123 Commerce Street, San Francisco, CA 94107, USA', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.240088208355!2d72.8044065!3d21.142841600000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e4b45d3ca2b%3A0xaf9ae5ffda2095d3!2sWebmasters%20InfoTech!5e0!3m2!1sen!2sin!4v1737200381429!5m2!1sen!2sin', 'https://facebook.com/yourpage', 'https://twitter.com/yourpage', 'https://instagram.com/yourpage', 'https://linkedin.com/company/yourpage', 'https://youtube.com/yourchannel', 'https://pinterest.com/yourpage', 'support@eshop.com', 'business@eshop.com', 'active', '2026-02-07 07:20:55', NULL);

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
(1, 'Free Shipping', 'On All Orders Above ₹999', 'slider_1769843141_MjO2RDXK7k.jpg', 'Learn More', 'http://localhost/e-commmerce/public/products', 'active', '2024-01-17 00:15:00', '2026-02-07 07:16:19'),
(2, 'Fitness Essentials', 'Get Fit with Premium Equipment', 'slider_1769843334_b8rmT1xo9Y.jpg', 'Shop Fitness', 'http://localhost/e-commmerce/public/products', 'active', '2024-01-19 05:45:00', '2026-02-07 07:16:19'),
(3, 'Mobile Mania', 'Best Deals on Smartphones', 'slider_1769843219_NRwmPw5Ko4.jpg', 'Buy Now', 'http://localhost/e-commmerce/public/products', 'active', '2024-01-20 01:10:00', '2026-02-07 07:16:19'),
(4, 'Book Fair', 'Thousands of Books at Discounted Prices', 'slider_1769843094_UJfQWTOgB7.jpg', 'View Books', 'http://localhost/e-commmerce/public/products', 'active', '2024-01-21 04:30:00', '2026-02-07 07:16:19'),
(5, 'Weekend Special', 'Extra 20% Off on Selected Items', 'slider_1769842994_Jwh2Vrpm1Q.jpg', 'Grab Deal', 'http://localhost/e-commmerce/public/products', 'active', '2024-01-24 07:00:00', '2026-02-07 07:16:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `profile_image`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `google_id`) VALUES
(1, 'Admin User', 'admin@example.com', '1234567890', NULL, NULL, '$2y$12$aGSDTCEDK7do1Rk5lxH74uL6B7auOqExL.anLNbXvzxwD8k3jqAC2', 'admin', NULL, '2026-01-22 10:56:12', '2026-01-24 03:31:44', NULL),
(100, 'John Doe', 'john@example.com', '9876543210', NULL, NULL, '$2y$12$hashedpassword', 'user', NULL, '2026-02-07 07:21:47', '2026-02-07 07:21:47', NULL),
(101, 'Jane Smith', 'jane@example.com', '9876543211', NULL, NULL, '$2y$12$hashedpassword', 'user', NULL, '2026-02-07 07:21:47', '2026-02-07 07:21:47', NULL),
(102, 'Test Customer', 'customer@example.com', '9876543212', NULL, NULL, '$2y$12$hashedpassword', 'user', NULL, '2026-02-07 07:21:47', '2026-02-07 07:21:47', NULL),
(103, 'LAXMAN PRADHAN', 'laxmanpradhan784@gmail.com', '9913817411', 'profile_103_1770622226.jpg', NULL, '$2y$12$h48zIlQqzEREuTaoq9avk.bo2XVQjE8KL0DDsYZXLGHwDubyS/rCi', 'user', NULL, '2026-02-07 01:53:46', '2026-02-09 02:00:26', NULL);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_index` (`order_id`),
  ADD KEY `payments_user_id_index` (`user_id`),
  ADD KEY `payments_razorpay_payment_id_index` (`razorpay_payment_id`),
  ADD KEY `payments_status_index` (`status`),
  ADD KEY `payments_created_at_index` (`created_at`);

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
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupon_categories`
--
ALTER TABLE `coupon_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_products`
--
ALTER TABLE `coupon_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_users`
--
ALTER TABLE `coupon_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `product_return_history`
--
ALTER TABLE `product_return_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_workflows`
--
ALTER TABLE `return_workflows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `user_wallets`
--
ALTER TABLE `user_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
