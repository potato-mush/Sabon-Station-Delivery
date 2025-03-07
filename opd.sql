-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2025 at 04:19 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opd`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `image` text NOT NULL,
  `categorieId` int(12) NOT NULL,
  `categorieName` varchar(255) NOT NULL,
  `categorieDesc` text NOT NULL,
  `categorieCreateDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`image`, `categorieId`, `categorieName`, `categorieDesc`, `categorieCreateDate`) VALUES
('category/category_67af7519005b0.jpg', 50, 'Fabric Conditioner', 'Sample Description', '2025-02-15 00:53:13'),
('category/category_67af7573edb1c.jpg', 51, 'Car Shampoo', 'Sample Description', '2025-02-15 00:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contactId` int(21) NOT NULL,
  `userId` int(21) NOT NULL,
  `email` varchar(35) NOT NULL,
  `phoneNo` bigint(21) NOT NULL,
  `orderId` int(21) NOT NULL DEFAULT 0 COMMENT 'If problem is not related to the order then order id = 0',
  `message` text NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contactId`, `userId`, `email`, `phoneNo`, `orderId`, `message`, `time`) VALUES
(1, 1, 'admin@gmail.com', 1111111111, 0, 'asdasdasdasd', '2024-10-12 01:13:54'),
(2, 1, 'admin@gmail.com', 1111111111, 0, 'asdasdasdasd', '2024-10-12 01:14:29');

-- --------------------------------------------------------

--
-- Table structure for table `contactreply`
--

CREATE TABLE `contactreply` (
  `id` int(21) NOT NULL,
  `contactId` int(21) NOT NULL,
  `userId` int(23) NOT NULL,
  `message` text NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactreply`
--

INSERT INTO `contactreply` (`id`, `contactId`, `userId`, `message`, `datetime`) VALUES
(1, 1, 1, 'hahahahaha', '2024-10-12 01:38:13');

-- --------------------------------------------------------

--
-- Table structure for table `deliverydetails`
--

CREATE TABLE `deliverydetails` (
  `id` int(21) NOT NULL,
  `orderId` int(21) NOT NULL,
  `deliveryBoyName` varchar(35) NOT NULL,
  `deliveryBoyPhoneNo` bigint(25) NOT NULL,
  `deliveryTime` int(200) NOT NULL COMMENT 'Time in minutes',
  `dateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliverydetails`
--

INSERT INTO `deliverydetails` (`id`, `orderId`, `deliveryBoyName`, `deliveryBoyPhoneNo`, `deliveryTime`, `dateTime`) VALUES
(4, 7, 'Manong Driver', 919671459, 24, '2025-02-15 15:14:27'),
(5, 19, 'Tite', 912345678, 30, '2025-02-25 17:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `userId`, `orderId`, `message`, `status`, `timestamp`) VALUES
(1, 9, 19, 'Your order #19 has been updated: Order Confirmed', 1, '2025-02-25 17:58:51'),
(2, 9, 19, 'Your order #19 has been updated: Preparing your Order', 1, '2025-02-25 17:59:03'),
(3, 9, 20, 'Your order #20 has been updated: Your order is on the way!', 1, '2025-02-25 17:59:38'),
(4, 9, 21, 'Your order #21 has been updated: Order Confirmed', 1, '2025-02-25 18:00:52'),
(5, 9, 21, 'Your order #21 has been updated: Preparing your Order', 1, '2025-02-25 18:00:57'),
(6, 9, 20, 'Your order #20 has been updated: Your order is on the way!', 1, '2025-02-25 18:01:06'),
(7, 9, 20, 'Your order #20 has been updated: Order Placed', 1, '2025-02-25 18:01:29'),
(8, 9, 20, 'Your order #20 has been updated: Order Confirmed', 1, '2025-02-25 18:01:35'),
(9, 9, 20, 'Your order #20 has been updated: Order Confirmed', 1, '2025-02-25 18:02:03'),
(10, 9, 20, 'Your order #20 has been updated: Preparing your Order', 1, '2025-02-25 18:02:16'),
(11, 9, 20, 'Your order #20 has been updated: Order Delivered', 1, '2025-02-25 18:02:35'),
(12, 9, 20, 'Your order #20 has been updated: Order Confirmed', 1, '2025-02-25 18:02:46'),
(13, 9, 20, 'Your order #20 has been updated: Preparing your Order', 1, '2025-02-25 18:03:17'),
(14, 9, 21, 'Your order #21 has been updated: Preparing your Order', 1, '2025-02-25 18:05:37'),
(15, 9, 21, 'Your order #21 has been updated: Preparing your Order', 1, '2025-02-25 18:06:12'),
(16, 9, 21, 'Your order #21 has been updated: Your order is on the way!', 1, '2025-02-25 18:06:29');

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(21) NOT NULL,
  `orderId` int(21) NOT NULL,
  `productId` int(21) NOT NULL,
  `itemQuantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `orderId`, `productId`, `itemQuantity`) VALUES
(1, 1, 23, 1),
(2, 1, 22, 1),
(3, 2, 32, 1),
(7, 4, 69, 1),
(8, 5, 69, 1),
(10, 7, 75, 1),
(11, 8, 75, 6),
(12, 9, 75, 1),
(13, 10, 75, 4),
(14, 11, 75, 1),
(15, 12, 75, 12),
(16, 13, 75, 1),
(17, 14, 75, 1),
(18, 15, 76, 9),
(19, 15, 75, 1),
(20, 16, 75, 4),
(21, 17, 76, 3),
(22, 18, 76, 1),
(23, 19, 75, 1),
(24, 20, 75, 1),
(25, 21, 75, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(21) NOT NULL,
  `userId` int(21) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipCode` int(21) NOT NULL,
  `phoneNo` bigint(21) NOT NULL,
  `amount` int(200) NOT NULL,
  `paymentMode` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=cash on delivery, \r\n1=online ',
  `orderStatus` enum('0','1','2','3','4','5','6') NOT NULL DEFAULT '0' COMMENT '0=Order Placed.\r\n1=Order Confirmed.\r\n2=Preparing your Order.\r\n3=Your order is on the way!\r\n4=Order Delivered.\r\n5=Order Denied.\r\n6=Order Cancelled.',
  `orderDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `userId`, `address`, `zipCode`, `phoneNo`, `amount`, `paymentMode`, `orderStatus`, `orderDate`) VALUES
(7, 7, '123 asd, asda 123 asd', 123123, 912345678, 123, '0', '2', '2025-02-15 01:44:29'),
(8, 1, '123 asd, asda 123 asd', 123123, 912345678, 738, '0', '1', '2025-02-15 01:47:56'),
(9, 7, '123 asd, asda 123 asd', 123123, 1234567899, 123, '0', '0', '2025-02-15 01:51:37'),
(10, 7, '123 asd, asda 123 asd', 123123, 1231231231, 492, '0', '0', '2025-02-15 01:52:33'),
(11, 7, '123 asd, asda 123 asd', 123123, 912345678, 123, '0', '0', '2025-02-15 02:00:34'),
(12, 7, '123 asd, asda 123 asd', 123123, 1234567890, 1476, '0', '0', '2025-02-15 02:09:50'),
(13, 1, '123 asd, asda 123 asd', 123123, 1231231231, 123, '0', '0', '2025-02-15 03:20:20'),
(14, 1, '123 asd, asda 123 asd', 123123, 912345678, 123, '0', '0', '2025-02-15 13:46:47'),
(15, 1, '123 asd, asda 123 asd', 123123, 1231231231, 927, '0', '0', '2025-02-25 17:21:12'),
(16, 1, '123 asd, asda 123 asd', 123123, 1231231231, 467, '0', '0', '2025-02-25 17:23:02'),
(17, 1, '123 asd, asda 123 asd', 123123, 1231231231, 270, '0', '0', '2025-02-25 17:23:19'),
(18, 1, '123 asd, asda 123 asd', 123123, 1231231231, 90, '0', '0', '2025-02-25 17:23:44'),
(19, 9, '123 asd, asda 123 asd', 123123, 9196714595, 117, '0', '1', '2025-02-25 17:37:13'),
(20, 9, '123 asd, asda 123 asd', 123123, 1231231231, 117, '0', '1', '2025-02-25 17:45:36'),
(21, 9, '123 asd, asda 123 asd', 123123, 1231231231, 117, '0', '2', '2025-02-25 17:52:54');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `image` text NOT NULL,
  `productId` int(12) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productPrice` int(12) NOT NULL,
  `productDesc` text NOT NULL,
  `productCategorieId` int(12) NOT NULL,
  `productPubDate` datetime NOT NULL DEFAULT current_timestamp(),
  `stock` int(11) NOT NULL DEFAULT 0,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`image`, `productId`, `productName`, `productPrice`, `productDesc`, `productCategorieId`, `productPubDate`, `stock`, `discount`) VALUES
('products/67af7648481cf.jpg', 75, 'Downy', 123, 'Sample Description', 50, '2025-02-15 00:58:48', 3, '5.00'),
('products/67bd85127f1a1.jpg', 76, 'Lenor', 100, 'Sample Description', 50, '2025-02-25 16:53:38', 9, '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `sitedetail`
--

CREATE TABLE `sitedetail` (
  `tempId` int(11) NOT NULL,
  `systemName` varchar(21) NOT NULL,
  `email` varchar(35) NOT NULL,
  `contact1` bigint(21) NOT NULL,
  `contact2` bigint(21) DEFAULT NULL COMMENT 'Optional',
  `address` text NOT NULL,
  `dateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sitedetail`
--

INSERT INTO `sitedetail` (`tempId`, `systemName`, `email`, `contact1`, `contact2`, `address`, `dateTime`) VALUES
(1, 'Sabon Station', 'admin123@gmail.com', 2515469442, 6304468851, '601 Sherwood Ave.<br> San Bernandino', '2021-03-23 19:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(21) NOT NULL,
  `username` varchar(21) NOT NULL,
  `firstName` varchar(21) NOT NULL,
  `lastName` varchar(21) NOT NULL,
  `email` varchar(35) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zipcode` varchar(4) DEFAULT NULL,
  `userType` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=user\r\n1=admin',
  `password` varchar(255) NOT NULL,
  `joinDate` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL DEFAULT 'img/profile/profilePic.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstName`, `lastName`, `email`, `phone`, `address`, `city`, `zipcode`, `userType`, `password`, `joinDate`, `image`) VALUES
(1, 'admin', 'Ate', 'Nicole', 'sample@sample.com', 1234567890, '123 asd', 'Pangasinan', '2421', '1', '$2y$10$AAfxRFOYbl7FdN17rN3fgeiPu/xQrx6MnvRGzqjVHlGqHAM4d9T1i', '2021-04-11 11:40:58', 'profile/profile_67b03d9772387.jpg'),
(7, 'potato-mush', 'Potato', 'Mush', 'potato.mush123@example.com', 912345678, NULL, NULL, NULL, '1', '$2y$10$k8mFLlG9mmt9n6yFfUsbE.a0ruovep9F4BCLjzGp3LcSrUudjxFNe', '2025-02-15 01:05:14', 'profile/profile_67af77ca13800.jpg'),
(8, 'sample-user', 'Sample', 'User', 'sample-user@sample.com', 4564654564, NULL, NULL, NULL, '0', '$2y$10$rySIR7KB57oRXV.P976f8O11pgGwiCLuOyZ0PCJrarjdR6etxpoD2', '2025-02-15 01:09:34', 'profile/profile_67af78ce8e855.jpg'),
(9, 'baotin', 'Ate', 'User', 'asd@asd.asd', 2342342342, '123 asd', 'Malasiqui', '1231', '0', '$2y$10$.ZsX6p9MlbUvsuPoHNOk7.xuVtlYPni9WPhXqPcVZ0jL1XMTLHZEe', '2025-02-25 17:29:04', 'profile/profile_67bd8d7ac22fc.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `viewcart`
--

CREATE TABLE `viewcart` (
  `cartItemId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `itemQuantity` int(100) NOT NULL,
  `userId` int(11) NOT NULL,
  `addedDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categorieId`);
ALTER TABLE `categories` ADD FULLTEXT KEY `categorieName` (`categorieName`,`categorieDesc`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contactId`);

--
-- Indexes for table `contactreply`
--
ALTER TABLE `contactreply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliverydetails`
--
ALTER TABLE `deliverydetails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orderId` (`orderId`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);
ALTER TABLE `products` ADD FULLTEXT KEY `productName` (`productName`,`productDesc`);

--
-- Indexes for table `sitedetail`
--
ALTER TABLE `sitedetail`
  ADD PRIMARY KEY (`tempId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `viewcart`
--
ALTER TABLE `viewcart`
  ADD PRIMARY KEY (`cartItemId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categorieId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contactId` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contactreply`
--
ALTER TABLE `contactreply`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deliverydetails`
--
ALTER TABLE `deliverydetails`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `sitedetail`
--
ALTER TABLE `sitedetail`
  MODIFY `tempId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `viewcart`
--
ALTER TABLE `viewcart`
  MODIFY `cartItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
