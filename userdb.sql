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
-- Database: `userdb`
--

-- --------------------------------------------------------

--
-- 
--



-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`) VALUES
(2, 'aarchi patel', 'abc@gmail.com', '$2y$10$yX6.HYb61PfSAqYs94tnMu8WYwqd5ds6qOtB.r8EEk6FnloXyZI1y'),
(15, 'Ayush Vyas', 'ayush@gmail.com', '$2y$10$7CTi1VXz9/Z.ZOdt4OGuUu1IkGnTO23RdRhXG8.iVlOtuxkVVnM3C'),
(19, 'Ayush Vyas', 'ayushvyas172@gmail.com', '$2y$10$dn.GoHee9EJgD8rgP6urzO8y5jnx9gwHoPRLugEKBoChR1KCEfFX.'),
(20, 'Niraj Vyas', 'nirajvyas.sw@gmail.com', '$2y$10$mR/Xp0iJuaGYXYc6PiDaCeONTYNKTBJWtlKUi3ZJFOOrmcns7BUOO'),
(21, 'Dhara Vyas', 'dharu.1906@gmail.com', '$2y$10$V97MBAmjMda9Gvp2h6Iw/.a3Mc1k6CHlh.lnFzsNhqTP4USc.8ocS'),
(22, 'Aarchi Patel', 'aarchipatel2602@gmail.com', '$2y$10$NhCC/b26ju7ev6eCt4lj7ODlmQWFwWYnzF/j4jr9/MrOrhHPyW3Bu'),
(23, 'Daksh Acharya', 'dakshacharya33@gmail.com', '$2y$10$MSvD4Yga1N1rSNNRWv0ZiOF8a.TR6ieWtgzdk0LM141LXZ0ANGE2S'),
(30, 'Ayush Vyas', 'ayushvyas1726@gmail.com', '$2y$10$I9BAIWBko/XD0cySLaNTf.JPr5.bV8S7h3Olo85q95sIdzSdoaOWe');

-- --------------------------------------------------------

--
-- Table structure for table `user_ratings`
--

CREATE TABLE IF NOT EXISTS `user_ratings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rating` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ;

--
-- Dumping data for table `user_ratings`
--

INSERT INTO `user_ratings` (`id`, `user_id`, `username`, `email`, `rating`, `created_at`, `updated_at`) VALUES
(1, 11, 'aarchi patel', 'aarchipatel2602@gmail.com', 2, '2025-03-28 13:03:11', '2025-03-28 13:14:18'),
(2, 19, 'ayush vyas', 'ayushvyas172@gmail.com', 5, '2025-03-28 15:23:22', '2025-03-28 15:34:25'),
(3, 30, 'Ayush Vyas', 'ayushvyas1726@gmail.com', 5, '2025-03-29 10:11:15', '2025-03-29 10:11:15');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
