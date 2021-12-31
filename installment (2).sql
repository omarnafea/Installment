-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2021 at 04:35 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(155) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(14) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `mobile`, `password`) VALUES
(1, 'ghufran', 'ghufran@gmail.com', '0786713023', 'omr'),
(3, 'rahma', 'rahma@gmail.com', '0785402596', '2aacd646f0e6ae4438858985a9260cc71d56b183'),
(5, 'ahmad', 'ahmad@gmail.com', '0799548663', '60169fac724e938050c9282a63bcf24ae3c8b7ff'),
(6, 'anwar', 'anwar@gmail.com', '0795496668', 'fecde534a1fb2618f416e50c2638462cbfea19dc');

-- --------------------------------------------------------

--
-- Table structure for table `installments`
--

CREATE TABLE `installments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `cachier_id` int(11) DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `pay_interval` decimal(4,2) NOT NULL,
  `pay_value` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `status` enum('ACTIVE','FINISHED','CANCELED','') NOT NULL DEFAULT 'ACTIVE',
  `notes` text NOT NULL,
  `promissory_note` varchar(300) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `creator_id`, `customer_id`, `pay_interval`, `pay_value`, `price`, `status`, `notes`, `promissory_note`, `creation_date`) VALUES
(1, 11, 1, '10.82', '200.00', '2163.00', 'CANCELED', '', '381049_huawei-y8s.jpg', '2021-12-30 17:15:28');

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL,
  `sub_price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`order_id`, `product_id`, `quantity`, `sub_price`) VALUES
(1, 8, 1, '290.00'),
(1, 11, 2, '1770.00');

-- --------------------------------------------------------

--
-- Table structure for table `pricing_model`
--

CREATE TABLE `pricing_model` (
  `pricing_id` int(11) NOT NULL,
  `min_pay_value` int(5) NOT NULL,
  `max_pay_value` int(5) NOT NULL,
  `pricing_value` decimal(2,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pricing_model`
--

INSERT INTO `pricing_model` (`pricing_id`, `min_pay_value`, `max_pay_value`, `pricing_value`) VALUES
(72, 0, 0, '0.02'),
(73, 1, 20, '0.20'),
(74, 25, 100, '0.10'),
(75, 101, 1001, '0.05'),
(76, 1200, 1400, '0.01');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `id` int(11) NOT NULL,
  `privilege` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(5) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `quantity`, `cat_id`, `image`, `price`) VALUES
(1, ' Huawei Nova 7i', 20, 1, '212332_huawei-nova-7i.jpg', '166.00'),
(2, 'Huawei Y9a', 25, 1, '32371_huawei-y9a-1.jpg', '170.00'),
(3, 'Huawei P30 Lite', 15, 1, '367082_huawei-p30-lite.jpg', '165.00'),
(4, ' Huawei Nova 9 pro', 20, 1, '402246_huawei-nova-9.jpg', '410.00'),
(5, 'Huawei P40 Pro', 15, 1, '540010_huawei-p40-pro.jpg', '635.00'),
(6, 'Huawei Y7a', 25, 1, '650313_huaweiy7a.jpg', '140.00'),
(7, 'Huawei y8s', 15, 1, '573697_huawei-y8s.jpg', '155.00'),
(8, 'Samsung Galaxy A51', 10, 1, '13371_samsunggalaxya51.jpg', '290.00'),
(9, 'Laptop Lenovo G5070', 10, 2, '769948_lenovog5070.jpg', '180.00'),
(10, 'Laptop Lenovo G5080', 15, 2, '167664_lenovog580.jpg', '315.00'),
(11, 'Laptop Lenovo Yoga 3-Pro', 10, 2, '180208_lenovoyoga3-pro.jpg', '885.00'),
(12, 'Laptop-lenovo-yoga-920', 9, 2, '137988_laptop-lenovo-yoga-920.jpg', '500.00'),
(13, 'Laptop Samsung-NoteBook-9', 5, 2, '242076_samsung-notebook-9.jpg', '880.00'),
(14, 'Laptop Acer Aspire ES1-522', 11, 2, '829762_acer-aspire-es1-522_84ca.jpg', '270.00'),
(15, 'Laptop Acer Aspire 3 A315-53G-58C7', 6, 2, '849876_aceraspire3a315-53g-58c7.jpg', '310.00'),
(16, 'Laptop Acer Aspire 3 A315-53G', 5, 2, '120178_acer-aspire-3-a315-53g.png', '330.00'),
(17, 'Laptop Acer Aspire E5-576G-57ZT', 5, 2, '650252_aceraspiree5-576g-57zt.jpg', '415.00');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `order_id` int(11) NOT NULL,
  `sponsor_id_image` varchar(300) NOT NULL,
  `sponsor_name` varchar(255) NOT NULL,
  `sponsor_mobile` varchar(15) NOT NULL,
  `sponsor_contract` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`order_id`, `sponsor_id_image`, `sponsor_name`, `sponsor_mobile`, `sponsor_contract`) VALUES
(1, '794389_aceraspire3a315-53g-58c7.jpg', 'Rahma', '0782524322', '846983_acer-aspire-es1-522_84ca.jpg'),
(1, '463065_aceraspiree5-576g-57zt.jpg', 'ali', '077854210', '920366_acer-aspire-3-a315-53g.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privilege_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_name`, `email`, `password`, `privilege_id`, `is_active`) VALUES
(1, 'anwar', 'anwar', 'anwar@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2, 1),
(10, 'ghufran', 'ghufran', 'ghufran@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 1),
(11, 'rahmeh', 'rahmeh', 'rahmeh@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 1),
(12, 'ahmad', 'ahmad', 'ahmad@gmail.cpom', '4a6db2314c199446c0e2d3e48e30295622c96639', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `installments`
--
ALTER TABLE `installments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`product_id`,`order_id`);

--
-- Indexes for table `pricing_model`
--
ALTER TABLE `pricing_model`
  ADD PRIMARY KEY (`pricing_id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_name` (`product_name`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `privilege_id` (`privilege_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `installments`
--
ALTER TABLE `installments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pricing_model`
--
ALTER TABLE `pricing_model`
  MODIFY `pricing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
