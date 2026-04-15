-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 05, 2025 at 03:42 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dairy_products`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', 'admin123', 'ayushvyas172@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Anonymous',
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reply` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `customer_name`, `email`, `feedback`, `created_at`, `updated_at`, `reply`) VALUES
(2, 'Dhara Vyas', 'dharu.1906@gmail.com', 'Very well-designed website..', '2025-03-28 09:13:00', '2025-03-28 09:13:00', NULL),
(3, 'Ayush Vyas', 'ayushvyas172@gmail.com', 'hi', '2025-03-28 09:35:43', '2025-03-29 10:30:47', 'nn'),
(4, 'Niraj Vyas', 'nirajvyas.sw@gmail.com', 'Best Website...', '2025-03-28 10:05:43', '2025-03-28 10:09:39', 'Thank you for your wonderful feedback! 🌟 We\'re thrilled to hear that you\'re enjoying our services. Your support means the world to us! 💙  <br />\r\n<br />\r\nIf you ever need assistance or have any suggestions, feel free to reach out at **📧 dairydelights2602@gmail.com** or call us at **📞 +91 8469434870**.  <br />\r\n<br />\r\nLooking forward to serving you again! 🥛🧀🍦  <br />\r\n**- Team Dairy Delights**'),
(5, 'Niraj Vyas', 'nirajvyas.sw@gmail.com', 'Hi', '2025-03-28 10:06:51', '2025-03-28 10:06:51', NULL),
(6, 'Aarchi Patel', 'aarchipatel2602@gmail.com', 'Best website everrrr....', '2025-03-28 11:26:48', '2025-04-03 10:44:41', 'Tu mara jode vaat kr ne properly please..<br />\r\ntane su thayu che?<br />\r\ngusso cancel');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_name`, `price`, `quantity`, `total_price`, `payment_method`, `order_date`) VALUES
(40, 'Organic Cheese', 250.00, 1, 250.00, 'UPI', '2025-03-24 04:20:39'),
(41, 'Homemade Butter', 150.00, 3, 450.00, 'UPI', '2025-03-24 04:20:39'),
(42, 'Pure Khoya', 400.00, 3, 1200.00, 'UPI', '2025-03-24 04:20:39'),
(43, 'Fresh Curd', 70.00, 4, 280.00, 'UPI', '2025-03-24 04:20:39'),
(44, 'Pure Desi Ghee', 500.00, 3, 1500.00, 'UPI', '2025-03-24 04:20:39'),
(50, 'Organic Cheese', 250.00, 1, 250.00, 'Cash on Delivery', '2025-03-27 17:46:57'),
(51, 'Fresh Yogurt', 60.00, 6, 360.00, 'Cash on Delivery', '2025-03-28 06:00:25'),
(52, 'Organic Cheese', 250.00, 1, 250.00, 'Cash on Delivery', '2025-03-28 15:14:28'),
(53, 'Homemade Butter', 150.00, 1, 150.00, 'Cash on Delivery', '2025-03-28 15:30:20'),
(54, 'Organic Cheese', 250.00, 2, 500.00, 'UPI', '2025-03-28 15:34:16'),
(55, 'Organic Cheese', 250.00, 1, 250.00, 'Cash on Delivery', '2025-03-28 16:36:18'),
(56, 'Homemade Butter', 150.00, 1, 150.00, 'UPI', '2025-03-28 16:40:25'),
(57, 'Homemade Butter', 150.00, 1, 150.00, 'Cash on Delivery', '2025-03-29 09:50:13'),
(58, 'Organic Cheese', 250.00, 1, 250.00, 'Cash on Delivery', '2025-03-29 09:51:29'),
(59, 'Fresh Cow Milk', 30.00, 1, 30.00, 'Cash on Delivery', '2025-03-29 09:56:14'),
(60, 'Homemade Butter', 150.00, 2, 300.00, 'Cash on Delivery', '2025-03-29 10:16:11'),
(61, 'Organic Cheese', 250.00, 1, 250.00, 'Cash on Delivery', '2025-03-29 10:16:11'),
(62, 'Fresh Curd', 70.00, 1, 70.00, 'Cash on Delivery', '2025-03-29 10:16:11'),
(63, 'Gulab Jamun', 50.00, 2, 100.00, 'Cash on Delivery', '2025-03-29 10:16:11'),
(64, 'Fresh Cow Milk', 30.00, 1, 30.00, 'UPI', '2025-04-02 17:20:55'),
(65, 'Fresh Curd', 70.00, 1, 70.00, 'Cash', '2025-04-02 17:24:53'),
(66, 'Fresh Lemonade', 60.00, 1, 60.00, 'Cash', '2025-04-02 17:24:53'),
(67, 'Cheese Chili Nugget', 450.00, 1, 450.00, 'Cash', '2025-04-02 17:24:53'),
(68, 'Frozen Mozzarella Stick', 410.00, 1, 410.00, 'Cash', '2025-04-02 17:24:53'),
(69, 'Fresh Yogurt', 60.00, 1, 60.00, 'Cash', '2025-04-02 17:24:53'),
(70, 'Organic Cheese', 250.00, 1, 250.00, 'Cash', '2025-04-02 17:47:41'),
(71, 'Sour Cream', 110.00, 1, 110.00, 'Cash', '2025-04-03 09:13:19'),
(72, 'Pure Desi Ghee', 500.00, 4, 2000.00, 'Cash', '2025-04-03 09:18:02'),
(73, 'Fresh Curd', 70.00, 4, 280.00, 'Cash', '2025-04-03 09:18:02'),
(74, 'Fresh Curd', 70.00, 2, 140.00, 'Cash', '2025-04-03 09:49:43'),
(75, 'Pure Desi Ghee', 500.00, 3, 1500.00, 'Cash', '2025-04-03 09:49:43'),
(76, 'Soft Paneer', 200.00, 2, 400.00, 'Cash', '2025-04-03 09:49:43'),
(77, 'Fresh Yogurt', 60.00, 2, 120.00, 'Cash', '2025-04-03 09:49:43'),
(78, 'Homemade Butter', 150.00, 2, 300.00, 'Cash', '2025-04-03 09:49:43'),
(79, 'Organic Cheese', 250.00, 1, 250.00, 'UPI', '2025-04-03 10:41:16'),
(80, 'White Chocolate', 110.00, 5, 550.00, 'UPI', '2025-04-03 10:41:48'),
(81, 'Milk Chocolate', 149.00, 3, 447.00, 'UPI', '2025-04-03 10:41:48'),
(82, 'Feta Cheese', 400.00, 1, 400.00, 'UPI', '2025-04-03 10:43:20'),
(83, 'Organic Cheese', 250.00, 1, 250.00, 'Cash', '2025-04-05 04:39:24'),
(84, 'Homemade Butter', 150.00, 1, 150.00, 'Cash', '2025-04-05 04:39:24'),
(85, 'Fresh Yogurt', 60.00, 1, 60.00, 'Cash', '2025-04-05 04:39:24'),
(86, 'Organic Cheese', 250.00, 1, 250.00, 'UPI', '2025-04-05 04:40:58'),
(87, 'Feta Cheese', 400.00, 3, 1200.00, 'UPI', '2025-04-05 05:28:25'),
(88, 'Protein Shake', 250.00, 1, 250.00, 'UPI', '2025-04-05 12:33:59'),
(89, 'Parmesan Cheese', 300.00, 1, 300.00, 'UPI', '2025-04-05 15:02:54'),
(90, 'Homemade Butter', 150.00, 1, 150.00, 'UPI', '2025-04-05 15:02:54'),
(91, 'White Chocolate', 110.00, 1, 110.00, 'UPI', '2025-04-05 15:27:33'),
(92, 'Fresh Lemonade', 60.00, 1, 60.00, 'UPI', '2025-04-05 15:36:30'),
(93, 'Frozen Pizza', 149.00, 2, 298.00, 'UPI', '2025-04-05 15:41:22'),
(94, 'Garlic Bread Loaf', 110.00, 1, 110.00, 'UPI', '2025-04-05 15:41:22'),
(95, 'Frozen Mozzarella Stick', 410.00, 2, 820.00, 'UPI', '2025-04-05 15:41:22'),
(96, 'Cheese Balls', 399.00, 1, 399.00, 'UPI', '2025-04-05 15:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` enum('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
);

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(23, 'Fresh Cow Milk', 30.00, 'http://localhost/img/m.jpg'),
(24, 'Organic Cheese', 250.00, 'http://localhost/img/cheese.jpg'),
(25, 'Homemade Butter', 150.00, 'http://localhost/img/b.jpg'),
(26, 'Fresh Yogurt', 60.00, 'http://localhost/img/y.jpg'),
(27, 'Soft Paneer', 200.00, 'http://localhost/img/p.jpg'),
(28, 'Pure Desi Ghee', 500.00, 'http://localhost/img/ghee.jpg'),
(29, 'Fresh Curd', 70.00, 'http://localhost/img/c.jpg'),
(30, 'Pure Khoya', 400.00, 'http://localhost/img/khoya.jpg'),
(31, 'Flavored Milk', 80.00, 'http://localhost/img/FM.jpg'),
(32, 'Sweet Lassi', 50.00, 'http://localhost/img/lassi.jpg'),
(33, 'Gulab Jamun', 50.00, 'http://localhost/img/j.jpg'),
(34, 'Bread', 45.00, 'http://localhost/img/bread.jpg'),
(35, 'Ice Cream', 35.00, 'http://localhost/img/ic1.jpg'),
(36, 'Buttermilk', 18.00, 'http://localhost/img/bm.jpg'),
(37, 'Fresh Lemonade', 60.00, 'http://localhost/img/lem.jpg'),
(38, 'Guava Shots', 85.00, 'http://localhost/img/gj.jpg'),
(39, 'Vanilla Custard Desert', 65.00, 'http://localhost/img/cd.jpg'),
(40, 'Sour Cream', 110.00, 'http://localhost/img/sc.jpg'),
(41, 'Protein Shake', 250.00, 'http://localhost/img/ps.jpg'),
(42, 'Dark Chocolate', 99.00, 'http://localhost/img/dc.jpg'),
(43, 'Milk Chocolate', 149.00, 'http://localhost/img/mc.jpg'),
(44, 'White Chocolate', 110.00, 'http://localhost/img/wc.jpg'),
(45, 'Feta Cheese', 400.00, 'http://localhost/img/fc.jpg'),
(46, 'Blue Cheese', 215.00, 'http://localhost/img/bc.jpg'),
(47, 'Mozzarella Cheese', 270.00, 'http://localhost/img/mmc.jpg'),
(48, 'Parmesan Cheese', 300.00, 'http://localhost/img/pc.jpg'),
(49, 'Mascarpone', 249.00, 'http://localhost/img/mp.jpg'),
(50, 'Cheese Chili Nugget', 450.00, 'http://localhost/img/ccn.jpg'),
(51, 'Cheese Balls', 399.00, 'http://localhost/img/cbs.jpg'),
(52, 'Frozen Pizza', 149.00, 'http://localhost/img/fp.jpg'),
(53, 'Garlic Bread Loaf', 110.00, 'http://localhost/img/gbl.jpg'),
(54, 'Frozen Mozzarella Stick', 410.00, 'http://localhost/img/fms.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
