-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 03:03 AM
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
-- Database: `cosmetic_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `session_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `province` varchar(100) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `shipping_method` varchar(50) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `shipping_cost` decimal(10,2) DEFAULT 0.00,
  `payment_slip` varchar(255) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'pending',
  `tracking_no` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `payment_status` varchar(50) DEFAULT 'pending',
  `status` varchar(50) DEFAULT 'รอดำเนินการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `fullname`, `address`, `province`, `zipcode`, `shipping_method`, `payment_method`, `shipping_cost`, `payment_slip`, `phone`, `total_price`, `order_status`, `tracking_no`, `created_at`, `payment_status`, `status`) VALUES
(34, NULL, 'wanwisa', 'บ้านทุ่งสวรรค์ ตำบลท่าศิลา อำเภอ ส่องดาว จ จ.สกลนคร 47190', '', '', 'EMS', 'cod', 60.00, NULL, '0923261043', 660.00, 'pending', NULL, '2026-01-15 14:25:29', 'pending', 'รอดำเนินการ');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `price`, `qty`, `created_at`) VALUES
(1, 34, 10, 600.00, 1, '2026-01-15 07:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_slips`
--

CREATE TABLE `payment_slips` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `slip_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `stock`) VALUES
(1, 'ลิปสติกแมทต์', 350.00, 'ลิปสติกเนื้อแมทต์ สีสด ติดทนนาน', 'lipstick_mat.jpg', 4),
(2, 'อายแชโดว์พาเลท', 750.00, 'พาเลทอายแชโดว์ 12 สี ระดับมืออาชีพ', 'eyeshadow_palette.jpg', 5),
(3, 'มาสคาร่ากันน้ำ', 420.00, 'มาสคาร่ากันน้ำ เพิ่มความหนาให้ขนตา', 'Waterproof_mascara.jpg', 8),
(4, 'ครีมบำรุงผิวหน้า', 280.00, 'ครีมบำรุงผิวหน้าให้ชุ่มชื้น ไม่เหนียวเหนอะหนะ', 'face_cream.jpg', 3),
(5, 'เซรั่มบำรุงผิว', 520.00, 'เซรั่มเข้มข้น ลดริ้วรอย เพิ่มความกระจ่างใส', 'serum_skin.jpg', 5),
(6, 'แป้งพัฟผสมรองพื้น', 300.00, 'แป้งพัฟเนื้อเนียน ปกปิดเรียบเนียน', 'powder_puff.jpg', 5),
(7, 'รองพื้นสูตรน้ำ', 450.00, 'รองพื้นเนื้อน้ำ เกลี่ยง่าย ควบคุมความมัน', 'liquid_foundation.jpg', 5),
(8, 'คอนซีลเลอร์', 220.00, 'คอนซีลเลอร์ ปกปิดรอยดำใต้ตา', 'concealer.jpg', 5),
(9, 'บลัชออน', 280.00, 'บลัชออนสีสวย ช่วยให้แก้มระเรื่อเป็นธรรมชาติ', 'blush_on.jpg', 4),
(10, 'น้ำหอมกลิ่นดอกไม้', 600.00, 'น้ำหอมกลิ่นดอกไม้ หอมสดชื่นตลอดวัน', 'perfume_flower.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','staff','admin') NOT NULL DEFAULT 'customer',
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_token` varchar(64) DEFAULT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `role`, `is_verified`, `verification_token`, `reset_token`, `phone`, `address`, `profile_image`, `created_at`, `updated_at`) VALUES
(1, 'Pud', '', '67319010033@swdtcmail.com', '$2y$10$e7gUmMjpUS6vZKcEFKoVMOVK.rB47AVyRo5L7gEOcqEvj6TXyN2MO', 'admin', 0, NULL, NULL, NULL, NULL, NULL, '2025-11-25 03:24:35', '2025-11-25 03:36:09'),
(2, 'wanwisa', '', '67319010068@swdtcmail.com', '$2y$10$EibvYh6eAM41Hbtb2YPQceb5xuSk0uEDYMipzFNtLsmZyN.4NoYtW', 'customer', 0, NULL, NULL, NULL, NULL, NULL, '2025-11-25 06:11:44', '2025-11-25 06:11:44'),
(3, 'baiyok', '', 'supanya@gmail.com', '$2y$10$6y2xdBmbi1Ib4QCcW4OQTuJgDwbQzXsXPtW/PG4EJT.XHG20JbZMS', 'admin', 0, NULL, NULL, NULL, NULL, NULL, '2025-12-09 02:53:05', '2026-01-13 07:35:39'),
(4, 'pink', '', '67319010015@swdtcmail.com', '$2y$10$L1cWweZwzCvVdESrwP7nceovqOCXTXIW9uOC22ngXRWhkDOELWQgy', '', 0, NULL, NULL, NULL, NULL, NULL, '2026-01-15 08:26:41', '2026-01-15 08:26:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payment_slips`
--
ALTER TABLE `payment_slips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payment_slips`
--
ALTER TABLE `payment_slips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
