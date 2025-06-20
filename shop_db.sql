-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 05:22 PM
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
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`) VALUES
(1, 'Điện thoại', '', 'Các loại điện thoại di động'),
(2, 'Máy tính', 'may-tinh', 'Các loại máy tính xách tay và máy tính để bàn');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT 'cod',
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `shipping_address`, `phone`, `created_at`, `payment_method`, `note`) VALUES
(1, 4, 34990000.00, 'processing', '123', '0987654321', '2025-06-17 06:34:57', 'cod', ''),
(2, 4, 39990000.00, 'processing', '123', '0987654321', '2025-06-17 06:43:26', 'cod', ''),
(3, 4, 19990000.00, 'processing', '123', '0987654321', '2025-06-17 07:06:32', 'cod', 'có cc'),
(4, 2, 32980000.00, 'processing', '123', 'admin', '2025-06-18 15:38:30', 'cod', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 5, 1, 34990000.00),
(2, 2, 8, 1, 39990000.00),
(3, 3, 2, 1, 19990000.00),
(4, 4, 2, 1, 19990000.00),
(5, 4, 11, 1, 12990000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `image`, `stock`, `featured`, `created_at`) VALUES
(1, 1, 'iPhone 13 Pro', 'iphone-13-pro', 'iPhone 13 Pro 256GB', 29990000.00, 'https://cdn.tgdd.vn/Files/2020/10/29/1303018/thongsoiphone13promax_2000x2000-800-resize.jpg', 10, 1, '2025-06-17 01:47:35'),
(2, 1, 'Samsung Galaxy S21', 'samsung-galaxy-s21', 'Samsung Galaxy S21 128GB', 19990000.00, 'https://bachlongstore.vn/vnt_upload/product/04_2024/Untitled_2.png', 13, 1, '2025-06-17 01:47:35'),
(3, 2, 'MacBook Pro M1', 'macbook-pro-m1', 'MacBook Pro M1 13 inch', 32990000.00, 'https://ttcenter.com.vn/uploads/product/r3x2m0zr-143-macbook-pro-13-m1-8gb-256gb-like-new.jpg', 8, 1, '2025-06-17 01:47:35'),
(5, 1, 'iPhone 14 Pro Max', 'iphone-14-pro-max', 'iPhone 14 Pro Max 256GB, màn hình Super Retina XDR, camera 48MP', 34990000.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJdsmz5R8adpuSm3JUfvVILNL2crE4XnqW6A&s', 11, 1, '2025-06-17 05:32:37'),
(6, 1, 'Samsung Galaxy S23 Ultra', 'samsung-galaxy-s23-ultra', 'Samsung Galaxy S23 Ultra 256GB, camera 200MP, pin 5000mAh', 29990000.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIgnHYClz1KXeeeuKnEvE9xXpAuvbE9FYcTQ&s', 10, 1, '2025-06-17 05:32:37'),
(7, 1, 'Xiaomi 13 Pro', 'xiaomi-13-pro', 'Xiaomi 13 Pro 256GB, Snapdragon 8 Gen 2, camera Leica', 18990000.00, 'https://demobile.vn/wp-content/uploads/2023/11/xiaomi-13-pro-2.jpg', 15, 0, '2025-06-17 05:32:37'),
(8, 2, 'Asus ROG Zephyrus G14', 'asus-rog-zephyrus-g14', 'Laptop gaming Asus ROG Zephyrus G14, Ryzen 9, RTX 4060', 39990000.00, 'https://bizweb.dktcdn.net/100/512/769/products/s-l1600-7.jpg?v=1712638904103', 4, 1, '2025-06-17 05:32:37'),
(9, 2, 'HP Spectre x360', 'hp-spectre-x360', 'HP Spectre x360, Intel Core i7, màn hình cảm ứng xoay gập', 28990000.00, 'https://cdn.tgdd.vn/News/0/cbv-1280x720-1.jpg', 7, 0, '2025-06-17 05:32:37'),
(10, 2, 'Lenovo ThinkPad X1 Carbon', 'lenovo-thinkpad-x1-carbon', 'Lenovo ThinkPad X1 Carbon Gen 10, siêu nhẹ, pin lâu', 32990000.00, 'https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcSBkaNIshlzSkoF16DMfzBeW5cxeR7QH5kKsc8J1SJVVt28_6PMOB8NWQg6RJNkiVHEqaz_gEcIF0r1c0aPWFHkbiHI4ZqzndDk6UOQQ0JezDXpHRi8kXeoYlA', 8, 1, '2025-06-17 05:32:37'),
(11, 1, 'Oppo Reno8 Pro', 'oppo-reno8-pro', 'Oppo Reno8 Pro 5G, camera AI, sạc siêu nhanh', 12990000.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-i4LSZtFKsrXDsepbbIjZcVUsL_6s-nDMYQ&s', 19, 0, '2025-06-17 05:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `address`, `phone`, `role`, `created_at`, `status`) VALUES
(2, 'admin', '$2y$10$KezSWy066LrtMHBp7AE.bu3crUAk4A5LWGPX7vX4L7CkrBPoxqtSS', 'viekhuong865@gmail.com', 'admin', '123', 'admin', 'admin', '2025-06-17 03:31:49', 'active'),
(4, 'viet123', '$2y$10$v4uvOD8dk8ssEEoJpUvpzeSEKDIjL3gen68UtvwzBv2s9f5iONJY6', 'vietkhuongtrang@gmail.com', 'viet', '123', '0987654321', 'customer', '2025-06-17 03:37:32', 'blocked');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
