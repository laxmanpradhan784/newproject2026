-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2026 at 11:18 AM
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
(1, 'Electronics', 'electronics', 'category_1769234541_jPDJlo1bcx.jpg', 'active', '2026-01-23 07:03:33', '2026-01-24 00:32:21'),
(2, 'Fashion', 'fashion', 'category_1769234549_0ZrptCkUWx.jpg', 'active', '2026-01-23 07:03:33', '2026-01-24 00:32:29'),
(3, 'Home & Kitchen', 'home-kitchen', 'category_1769234556_arJUdvFV8a.jpg', 'active', '2026-01-23 07:03:33', '2026-01-24 00:32:36'),
(4, 'Sports & Outdoors', 'sports-outdoors', 'category_1769234565_o9XSHkawm7.jpg', 'active', '2026-01-23 07:03:33', '2026-01-24 00:32:45'),
(5, 'Books', 'books', 'category_1769234572_9qrTHCoVJB.jpg', 'active', '2026-01-23 07:03:33', '2026-01-24 00:32:52'),
(6, 'Beauty & Personal Care', 'beauty-personal-care', 'category_1769234579_gW7wDm1xRd.jpg', 'active', '2026-01-23 07:03:33', '2026-01-24 00:32:59'),
(7, 'Toys & Games', 'toys-games', 'category_1769234586_hLs4iriGUO.jpg', 'active', '2026-01-23 07:03:33', '2026-01-24 00:33:06'),
(8, 'Automotive', 'automotive', 'category_1769234531_tTr2qrKfxi.jpg', 'active', '2026-01-23 07:03:33', '2026-01-24 00:32:11'),
(9, 'Health & Fitness', 'health-fitness', 'category_1769231545_RfyN6xVrcJ.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 23:42:25'),
(10, 'Groceries', 'groceries', 'category_1769231536_i8WoZxF4dL.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 23:42:16');

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
(2, 'Litu Nayak', 'Litu@gmail.com', 'General Inquiry', 'hello bro', '2026-01-23 03:07:14', '2026-01-23 03:07:14');

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
(3, '0001_01_01_000002_create_jobs_table', 1);

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
(1, 1, 'Smartphone X1', 'smartphone-x1', 'image-1.jpg', 'Latest smartphone with high-resolution camera.', 299.99, 50, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(2, 1, 'Wireless Headphones', 'wireless-headphones', 'image-1.jpg', 'Noise-cancelling over-ear headphones.', 89.99, 100, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(3, 2, 'Men T-Shirt', 'men-tshirt', 'image-1.jpg', '100% cotton casual t-shirt for men.', 19.99, 200, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(4, 2, 'Women Dress', 'women-dress', 'image-1.jpg', 'Elegant summer dress for women.', 49.99, 150, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(5, 3, 'Blender 3000', 'blender-3000', 'image-1.jpg', 'High-speed kitchen blender.', 59.99, 80, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(6, 3, 'Non-stick Pan', 'non-stick-pan', 'image-1.jpg', 'Durable non-stick frying pan.', 24.99, 120, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(7, 4, 'Football', 'football', 'image-1.jpg', 'Professional quality football.', 29.99, 70, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(8, 4, 'Yoga Mat', 'yoga-mat', 'image-1.jpg', 'Eco-friendly yoga mat.', 25.99, 90, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(9, 5, 'Novel: The Great Adventure', 'novel-great-adventure', 'image-1.jpg', 'Exciting adventure novel for readers.', 14.99, 120, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(10, 5, 'Science Encyclopedia', 'science-encyclopedia', 'image-1.jpg', 'Comprehensive encyclopedia for students.', 39.99, 60, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(11, 6, 'Lipstick Set', 'lipstick-set', 'image-1.jpg', 'Long-lasting matte lipstick set.', 29.99, 200, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(12, 6, 'Face Cream', 'face-cream', 'image-1.jpg', 'Hydrating and nourishing face cream.', 19.99, 150, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(13, 7, 'Puzzle Game', 'puzzle-game', 'image-1.jpg', 'Fun and challenging puzzle for kids.', 9.99, 100, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(14, 7, 'Action Figure', 'action-figure', 'image-1.jpg', 'Collectible superhero action figure.', 14.99, 80, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(15, 8, 'Car Vacuum Cleaner', 'car-vacuum-cleaner', 'image-1.jpg', 'Portable vacuum cleaner for cars.', 49.99, 60, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(16, 8, 'Car Seat Cover', 'car-seat-cover', 'image-1.jpg', 'Durable seat cover for comfort.', 35.99, 70, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(17, 9, 'Treadmill', 'treadmill', 'image-1.jpg', 'Electric treadmill for home workouts.', 499.99, 30, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(18, 9, 'Dumbbell Set', 'dumbbell-set', 'product_1769234627_rkscOMJLxr.jpg', 'Adjustable dumbbells for strength training.', 89.99, 50, 'active', '2026-01-23 07:04:47', '2026-01-24 00:33:47'),
(19, 10, 'Organic Rice', 'organic-rice', 'product_1769234611_NB9xN6cELW.jpg', 'Premium quality organic rice 5kg.', 25.99, 100, 'active', '2026-01-23 07:04:47', '2026-01-24 00:33:31'),
(20, 10, 'Olive Oil', 'olive-oil', 'product_1769234603_Nb4pjAqd9m.jpg', 'Extra virgin olive oil 1L.', 15.99, 80, 'active', '2026-01-23 07:04:47', '2026-01-24 00:33:23');

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
('MPTLGjw8GBgJsyXLoNbhaS4wf9OZ6fX7GNpxKMv7', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZHhBdW9QbTlFdjdyb0RsY05PZERqNkpsS3RGTkFqN3o0QlFzT2tueCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly9sb2NhbGhvc3QvZS1jb21tbWVyY2UvcHVibGljL2FkbWluL2NvbnRhY3RzIjtzOjU6InJvdXRlIjtzOjE0OiJhZG1pbi5jb250YWN0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1769249841);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `phone_1` varchar(20) DEFAULT NULL,
  `phone_2` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `map_location` varchar(255) DEFAULT NULL,
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
(1, '9913817411', '7735105645', '123 Commerce Street, San Francisco, CA 94107, USA', 'https://maps.google.com/?q=123+Commerce+Street+San+Francisco', 'https://facebook.com/yourpage', 'https://twitter.com/yourpage', 'https://instagram.com/yourpage', 'https://linkedin.com/company/yourpage', 'https://youtube.com/yourchannel', 'https://pinterest.com/yourpage', 'support@eshop.com', 'business@eshop.com', 'active', '2026-01-24 09:31:54', '2026-01-24 04:46:21');

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
(4, 'Books Collection', 'Knowledge is power', 'slider_1769230409_QXNwapLerg.jpg', 'Read More', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2026-01-23 08:27:42', '2026-01-23 23:23:29'),
(5, 'Sports & Fitness', 'Stay healthy', 'slider_1769230395_TaJrxzBJNq.jpg', 'Shop Nowdv', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2026-01-23 08:27:42', '2026-01-23 23:23:46'),
(7, 'Wireless Headphones', 'Stay healthy and fit', 'slider_1769230375_a9kB8wNbn1.jpg', 'Shop Now', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2026-01-23 23:22:55', '2026-01-23 23:24:19'),
(9, 'ffb', 'Stay healthy and fit', 'slider_1769241902_ovrCiYLEKw.jpg', 'Shop Now', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2026-01-24 02:35:02', '2026-01-24 02:35:02'),
(10, 'dfbb', 'fd', 'slider_1769241915_G4KwChS8L4.jpg', 'Shop Nowdv', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2026-01-24 02:35:15', '2026-01-24 02:35:15'),
(11, 'dfbfg', 'Stay healthy and fit', 'slider_1769241932_53rJTi2TP1.jpg', 'Shop Now', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2026-01-24 02:35:32', '2026-01-24 02:35:32'),
(12, 'bhdfbg', 'Stay healthy and fit', 'slider_1769241957_tTzQ6Tfihp.jpg', 'sgvd', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2026-01-24 02:35:57', '2026-01-24 02:35:57'),
(13, 'efedr', 'Stay healthy and fit', 'slider_1769242063_7HZ3U16oKS.jpg', 'Shop Now', 'http://localhost/phpmyadmin/index.php?route=/database/export&db=e-database', 'active', '2026-01-24 02:37:43', '2026-01-24 02:37:43');

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
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', '1234567890', NULL, '$2y$12$aGSDTCEDK7do1Rk5lxH74uL6B7auOqExL.anLNbXvzxwD8k3jqAC2', 'admin', NULL, '2026-01-22 10:56:12', '2026-01-24 03:31:44'),
(2, 'Regular Users', 'user@example.com', '0987654321', NULL, '$2y$12$r4EOdHojsEaSS4y6EYqtBu3QYRk2BBoV6S0i.rGriYNxJx8kYQqQW', 'user', NULL, '2026-01-22 10:56:12', '2026-01-23 03:51:41'),
(6, 'laxman pradhan', 'pradhan@gmail.com', '09978767202', NULL, '$2y$12$7G.OQM.Pys5zubz0iEoFeuFXK2DNj4smQcilqdyqJLT8.jSOGK.xm', 'user', NULL, '2026-01-24 01:58:12', '2026-01-24 01:58:12');

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
