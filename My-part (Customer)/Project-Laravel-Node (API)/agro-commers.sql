-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2021 at 07:09 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agro-commers`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `cid` int(10) NOT NULL,
  `sender_email` varchar(50) NOT NULL,
  `receiver_email` varchar(50) NOT NULL,
  `message` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`cid`, `sender_email`, `receiver_email`, `message`) VALUES
(6, 'muntasiralam9993@gmail.com', 'a@gmail.com', 'hi'),
(7, 'muntasiralam9993@gmail.com', 'a@gmail.com', 'ok'),
(8, 'a@gmail.com', 'muntasiralam9993@gmail.com', 'ok');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `iid` int(10) NOT NULL,
  `oid` int(10) NOT NULL,
  `sellerid` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`iid`, `oid`, `sellerid`, `quantity`, `price`) VALUES
(28, 21, 7, 1, 10),
(29, 21, 9, 1, 50),
(30, 22, 10, 1, 50000),
(31, 22, 7, 1, 10),
(32, 23, 9, 1, 50),
(33, 23, 10, 1, 50000),
(34, 24, 7, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `newsid` int(10) NOT NULL,
  `date` varchar(50) NOT NULL,
  `headline` varchar(50) NOT NULL,
  `detail` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`newsid`, `date`, `headline`, `detail`) VALUES
(1, '2021-01-04 14:21:50', 'Job Announcement', 'Please apply for job');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `nid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `notice` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`nid`, `uid`, `notice`) VALUES
(2, 20, 'this is notice');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `oid` int(10) NOT NULL,
  `customerid` int(10) NOT NULL,
  `date` varchar(50) NOT NULL,
  `subtotal` float NOT NULL,
  `shipping_method` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`oid`, `customerid`, `date`, `subtotal`, `shipping_method`, `status`) VALUES
(21, 52, '2021-01-03 17:15:43', 60, 'Parcel shipping', 'pending'),
(22, 52, '2021-01-03 17:29:12', 50010, 'Will take from office', 'pending'),
(23, 52, '2021-01-03 17:30:09', 50050, 'Parcel shipping', 'pending'),
(24, 52, '2021-01-04 08:04:40', 10, 'Parcel shipping', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `ohid` int(10) NOT NULL,
  `oid` int(10) NOT NULL,
  `delivered_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_history`
--

INSERT INTO `order_history` (`ohid`, `oid`, `delivered_date`) VALUES
(1, 11, '2021-01-02 01:39:40');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` int(10) NOT NULL,
  `sellerid` int(10) NOT NULL,
  `shop_name` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `sellerid`, `shop_name`, `title`, `price`, `description`, `image`, `status`) VALUES
(6, 6, 'Cocunut Shop', 'Cocunut', 50, 'All fresh coconuts available', 'Cocunut.jpg', 'not available'),
(7, 7, 'Seeds Shop', 'Seeds', 10, 'All type of seeds available', 'Seeds.jpg', 'available'),
(8, 8, 'Fertilizer Shop', 'Fertilizer', 100, 'You will get all type of fertilizer here', 'Fertilizer.jpg', 'available'),
(9, 9, 'Soybeans Shop', 'Soybeans', 50, 'Good quality of soybeans', 'Soybeans.jpg', 'available'),
(10, 10, 'Agro Machine', 'Equipment Machine', 50000, 'All type of agricultural machines available', 'Equipment Machine.jpg', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `rid` int(10) NOT NULL,
  `customerid` int(10) NOT NULL,
  `sellerid` int(10) NOT NULL,
  `productid` int(10) NOT NULL,
  `review` text NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`rid`, `customerid`, `sellerid`, `productid`, `review`, `date`) VALUES
(8, 52, 7, 7, 'good', '2021-01-03 17:17:46'),
(9, 52, 7, 7, 'bad', '2021-01-03 17:22:19'),
(10, 52, 7, 7, 'bad', '2021-01-03 17:25:27'),
(11, 52, 7, 7, 'bad', '2021-01-03 22:02:16'),
(12, 52, 9, 9, 'good', '2021-01-03 22:02:48'),
(13, 52, 10, 10, 'very bad', '2021-01-03 22:03:16'),
(14, 52, 9, 9, 'best', '2021-01-03 22:03:38'),
(15, 52, 10, 10, 'nice', '2021-01-04 08:04:20'),
(16, 52, 7, 7, 'slow delivery', '2021-01-04 08:05:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `salary` float NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `role`, `salary`, `phone`, `email`, `address`, `password`) VALUES
(51, 'a', 'admin', 0, '', 'a@gmail.com', 'Dhaka, Bangladesh', '1234'),
(52, 'Muntasir Alam', 'customer', 0, '880+123456789', 'muntasiralam9993@gmail.com', 'Dhaka, Bangladesh', '1234'),
(53, 'b', 'manager', 0, '11111111111', 'b@gmail.com', 'Dhaka, Bangladesh', '1234'),
(54, 'c', 'seller', 0, '11111111111', 'c@gmail.com', 'Dhaka, Bangladesh', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`iid`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`newsid`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`ohid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `cid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `iid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `newsid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `nid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `oid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `ohid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `rid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
