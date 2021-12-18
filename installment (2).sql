-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 18, 2021 at 08:06 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `installment`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(2, 'laptops'),
(1, 'mobiles');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(14) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `mobile`, `password`) VALUES
(1, 'omar', 'omar@gmail.com', '0795496663', 'omr'),
(3, 'omar nafea', 'onafeajknjknjknj08@gmail.com', '0794966667', '2aacd646f0e6ae4438858985a9260cc71d56b183'),
(5, 'ahamd', 'omadfr@gmasd.com', '0799548663', '60169fac724e938050c9282a63bcf24ae3c8b7ff'),
(6, 'ashd', 'omadfr@gm47ail.com', '0795496668', 'fecde534a1fb2618f416e50c2638462cbfea19dc');

-- --------------------------------------------------------

--
-- Table structure for table `installments`
--

DROP TABLE IF EXISTS `installments`;
CREATE TABLE IF NOT EXISTS `installments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `cachier_id` int(11) DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL,
  `creation_name` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `installments`
--

INSERT INTO `installments` (`id`, `order_id`, `cachier_id`, `amount`, `creation_name`) VALUES
(3, 1, 1, '30.00', '2021-12-09 18:05:27'),
(4, 1, 1, '30.00', '2021-12-09 18:05:51'),
(5, 5, 1, '60.00', '2021-12-10 10:19:32'),
(6, 5, 12, '60.00', '2021-12-10 15:05:27'),
(10, 5, 12, '60.00', '2021-12-10 15:15:24');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `pay_interval` decimal(4,2) NOT NULL,
  `pay_value` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `status` enum('ACTIVE','FINISHED','CANCELED','') NOT NULL DEFAULT 'ACTIVE',
  `notes` text NOT NULL,
  `promissory_note` varchar(300) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `creator_id`, `customer_id`, `pay_interval`, `pay_value`, `price`, `status`, `notes`, `promissory_note`, `creation_date`) VALUES
(1, 1, 5, '8.00', '30.00', '220.00', 'ACTIVE', 'notes', '', '2021-11-05 09:04:55'),
(5, 1, 1, '6.00', '60.00', '330.00', 'ACTIVE', '', '', '2020-10-04 00:00:00'),
(6, 1, 1, '2.00', '30.00', '57.50', 'CANCELED', '', '', '2021-12-10 13:56:42'),
(7, 12, 1, '2.00', '50.00', '115.00', 'CANCELED', '', '', '2021-12-10 15:20:47'),
(10, 12, 1, '2.20', '100.00', '220.00', 'ACTIVE', '', '', '2021-12-10 21:58:21'),
(11, 1, 3, '1.50', '500.00', '750.00', 'ACTIVE', '101', '109087_13292815_2065759186983016_867428052_n.jpg', '2021-12-16 18:23:36'),
(12, 1, 3, '1.50', '500.00', '750.00', 'ACTIVE', '101', '2080_13292815_2065759186983016_867428052_n.jpg', '2021-12-16 18:25:31'),
(13, 1, 1, '5.50', '100.00', '550.00', 'ACTIVE', '110', '787727_صور-ورسائل-عيد-الاضحي-14-4-590x528.jpg', '2021-12-16 18:36:12'),
(14, 1, 1, '5.50', '100.00', '550.00', 'ACTIVE', '1001', '615835_160767_silver_and_golden_christmas_balls_wallpaper.jpg', '2021-12-17 11:09:32'),
(15, 1, 1, '15.00', '500.00', '7500.00', 'ACTIVE', 'jjklj', '213141_160767_silver_and_golden_christmas_balls_wallpaper.jpg', '2021-12-18 09:33:23');

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

DROP TABLE IF EXISTS `orders_products`;
CREATE TABLE IF NOT EXISTS `orders_products` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL,
  `sub_price` decimal(8,2) NOT NULL,
  PRIMARY KEY (`product_id`,`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`order_id`, `product_id`, `quantity`, `sub_price`) VALUES
(1, 1, 2, '100.00'),
(5, 1, 4, '200.00'),
(6, 1, 1, '50.00'),
(12, 1, 10, '500.00'),
(13, 1, 10, '500.00'),
(14, 1, 10, '500.00'),
(15, 1, 100, '5000.00'),
(1, 2, 1, '100.00'),
(5, 2, 1, '100.00'),
(7, 2, 1, '100.00'),
(10, 2, 2, '200.00');

-- --------------------------------------------------------

--
-- Table structure for table `pricing_model`
--

DROP TABLE IF EXISTS `pricing_model`;
CREATE TABLE IF NOT EXISTS `pricing_model` (
  `pricing_id` int(11) NOT NULL AUTO_INCREMENT,
  `min_pay_value` int(5) NOT NULL,
  `max_pay_value` int(5) NOT NULL,
  `pricing_value` decimal(2,2) NOT NULL,
  PRIMARY KEY (`pricing_id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pricing_model`
--

INSERT INTO `pricing_model` (`pricing_id`, `min_pay_value`, `max_pay_value`, `pricing_value`) VALUES
(67, 0, 0, '0.02'),
(68, 1, 20, '0.20'),
(69, 25, 100, '0.10'),
(70, 101, 1001, '0.50'),
(71, 1200, 1400, '0.01');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

DROP TABLE IF EXISTS `privileges`;
CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `privilege` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `privilege`) VALUES
(1, 'admin'),
(2, 'cachier');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(5) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_name` (`product_name`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `quantity`, `cat_id`, `image`, `price`) VALUES
(1, 'pro47', 15, 2, '753421_csgo-image_hud3c572ca46463b7314b38aa612b1af3b_51172_1920x1080_resize_q75_lanczos.jpg', '50.00'),
(2, 'pro4745', 40, 2, '527_csgo-image_hud3c572ca46463b7314b38aa612b1af3b_51172_1920x1080_resize_q75_lanczos.jpg', '100.00'),
(4, 'pro44654654', 10, 1, '540546_690787_logoarabicenglish.jpg', '200.00'),
(5, 'pro 15', 10, 2, '152560_164931_beetleicon.jpg', '10.00'),
(6, 'pro 11', 10, 2, '370404_400-600copy.jpg', '100.00');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

DROP TABLE IF EXISTS `sponsors`;
CREATE TABLE IF NOT EXISTS `sponsors` (
  `order_id` int(11) NOT NULL,
  `sponsor_id_image` varchar(300) NOT NULL,
  `sponsor_name` varchar(255) NOT NULL,
  `sponsor_mobile` varchar(15) NOT NULL,
  `sponsor_contract` varchar(300) NOT NULL,
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`order_id`, `sponsor_id_image`, `sponsor_name`, `sponsor_mobile`, `sponsor_contract`) VALUES
(14, '655142_107491_ax330_box-a.jpg', '114', '114', '861115_107491_ax330_box-a.jpg'),
(14, '990957_download(1).png', '114', '114', '740152_مضاعفات-5-825x510.png'),
(15, '907338_160767_silver_and_golden_christmas_balls_wallpaper.jpg', 'omar', '0795496663', '855105_160767_silver_and_golden_christmas_balls_wallpaper.jpg'),
(15, '321137_160767_silver_and_golden_christmas_balls_wallpaper.jpg', '114', '114', '475733_160767_silver_and_golden_christmas_balls_wallpaper.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privilege_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `privilege_id` (`privilege_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_name`, `email`, `password`, `privilege_id`, `is_active`) VALUES
(1, 'omar', 'omar', 'onafea08@gmail.com', '4a6db2314c199446c0e2d3e48e30295622c96639', 1, 1),
(10, 'ghufran', 'ghufran', 'ghufran@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 1),
(11, 'rahmeh', 'rahmeh', 'rahmeh@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 1),
(12, 'ahmad', 'ahmad', 'ahdm@gmail.cpom', '4a6db2314c199446c0e2d3e48e30295622c96639', 2, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD CONSTRAINT `sponsors_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`privilege_id`) REFERENCES `privileges` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
