-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2026 at 12:48 PM
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
(1, 'Electronics', 'electronics', 'image-1.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 07:03:33'),
(2, 'Fashion', 'fashion', 'image-1.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 07:03:33'),
(3, 'Home & Kitchen', 'home-kitchen', 'image-1.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 07:03:33'),
(4, 'Sports & Outdoors', 'sports-outdoors', 'image-1.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 07:03:33'),
(5, 'Books', 'books', 'image-1.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 07:03:33'),
(6, 'Beauty & Personal Care', 'beauty-personal-care', 'image-1.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 07:03:33'),
(7, 'Toys & Games', 'toys-games', 'image-1.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 07:03:33'),
(8, 'Automotive', 'automotive', 'image-1.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 07:03:33'),
(9, 'Health & Fitness', 'health-fitness', 'image-1.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 07:03:33'),
(10, 'Groceries', 'groceries', 'image-1.jpg', 'active', '2026-01-23 07:03:33', '2026-01-23 07:03:33');

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
(1, 'Litu Nayak', 'Litu@gmail.com', 'General Inquiry', 'hi bro', '2026-01-22 06:20:34', '2026-01-22 06:20:34'),
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
(18, 9, 'Dumbbell Set', 'dumbbell-set', 'image-1.jpg', 'Adjustable dumbbells for strength training.', 89.99, 50, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(19, 10, 'Organic Rice', 'organic-rice', 'image-1.jpg', 'Premium quality organic rice 5kg.', 25.99, 100, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47'),
(20, 10, 'Olive Oil', 'olive-oil', 'image-1.jpg', 'Extra virgin olive oil 1L.', 15.99, 80, 'active', '2026-01-23 07:04:47', '2026-01-23 07:04:47');

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
('JVv5mY3JlPlfFkKvOmMngElAH7QU9cKaugsm503N', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM0FBU1JLMzlOZVFBZ1AzQVZhRHhwOWVRbnpRMXg5RkFoOTNoYmlncCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly9sb2NhbGhvc3QvZS1jb21tbWVyY2UvcHVibGljL2FkbWluL3Byb2R1Y3RzIjtzOjU6InJvdXRlIjtzOjE0OiJhZG1pbi5wcm9kdWN0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1769168822);

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
(1, 'Big Sale 50% Off', 'Best deals on electronics', 'image-1.jpg', 'Shop Now', '/products', 'active', '2026-01-23 08:27:42', '2026-01-23 08:27:42'),
(2, 'New Fashion Arrivals', 'Latest trends available now', 'image-1.jpg', 'Explore', '/category/fashion', 'active', '2026-01-23 08:27:42', '2026-01-23 08:27:42'),
(3, 'Home & Kitchen', 'Make your home beautiful', 'image-1.jpg', 'Buy Now', '/category/home-kitchen', 'active', '2026-01-23 08:27:42', '2026-01-23 08:27:42'),
(4, 'Books Collection', 'Knowledge is power', 'image-1.jpg', 'Read More', '/category/books', 'active', '2026-01-23 08:27:42', '2026-01-23 08:27:42'),
(5, 'Sports & Fitness', 'Stay healthy and fit', 'image-1.jpg', 'Shop Now', '/category/sports', 'active', '2026-01-23 08:27:42', '2026-01-23 08:27:42');

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
(1, 'Admin User', 'admin@example.com', '1234567890', NULL, '$2y$12$r4EOdHojsEaSS4y6EYqtBu3QYRk2BBoV6S0i.rGriYNxJx8kYQqQW', 'admin', NULL, '2026-01-22 10:56:12', '2026-01-22 10:57:31'),
(2, 'Regular Users', 'user@example.com', '0987654321', NULL, '$2y$12$r4EOdHojsEaSS4y6EYqtBu3QYRk2BBoV6S0i.rGriYNxJx8kYQqQW', 'user', NULL, '2026-01-22 10:56:12', '2026-01-23 03:51:41'),
(5, 'Litu Nayak', 'Litu@gmail.com', '09978767202', NULL, '$2y$12$4R0GWU7cWbOClyYc6ENKGeFk9F3YUsap1nD9jUSRjmaEaMIq3NW1G', 'user', NULL, '2026-01-22 05:47:42', '2026-01-22 05:47:42');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
