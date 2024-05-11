-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2024 at 10:21 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `localmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `seller_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `seller_id`) VALUES
(10, 'Helios Watch', 'Stay on trend with the GW0491G4, a 45mm round chronograph watch designed for men. The blue stainless steel dial is paired with a black silicone strap with a width of 19mm, secured by a strap buckle. With 5 ATM water resistance and mineral glass, this USA-made quartz watch weighing 110 grams ensures both durability and style. The GW0491G4, with a case thickness of 11mm, comes with a 2-year warranty, making it a reliable choice for your casual outings.', '15995.00', 'uploads/gw0491g4_1_1.jpg', 9),
(11, 'Samsung Galaxy S23', 'Epic moments are now accessible to all. Galaxy S23 FE opens the door for more people to experience the extraordinary. With its long-lasting power and stunning night shots, the phone becomes your gateway to lasting epic memories.', '39999.00', 'uploads/Samsung Mobile Galaxy S23 8GB RAM 256GB.jpg', 11),
(12, 'ROG Strix G15', 'The latest AMD Ryzen™ 9 6900HX CPU paired with up to a NVIDIA® 3070Ti Laptop GPU with 150W max TGP and MUX Switch form the backbone of the brand new 2022 Strix G. Cutting-edge DDR5 memory keeps your CPU fed with information at all times, ensuring a responsive experience. PCIe® 4.0 SSD support means that you’ll never need to wait for file transfers or game loading screens again.', '77990.00', 'uploads/w250.png', 11),
(13, 'Apple Watch Series 9', 'Fully customizable; however you want.', '41900.00', 'uploads/s9-case-unselect-gallery-1-202403_GEO_IN_FMT_WHH.jpeg', 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Seller','Buyer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `firstname`, `lastname`, `email`, `password`, `role`) VALUES
(6, 'Yash', 'Malhotra', 'yash@gmail.com', '$2y$10$dyiWQQ3cdFaJhWBabOXfS.xj4pT3FWmlWcE3KJQW.pBDkojd0L1OG', 'Seller'),
(8, 'Akash', 'mittal', 'akash@gmail.com', '$2y$10$haH1thIXGcMcFcLnPUa9tOU1AK9livevjlA3fGBy62k.jKGyGBFhy', 'Buyer'),
(9, 'John', 'Mayer', 'john@gmail.com', '$2y$10$52pxiO45ltCWY0QfeoQ8yeda3/6Msw4D/lL14pLU.A6nFluCo5p.2', 'Seller'),
(10, 'Karim', 'Khan', 'karim@gmail.com', '$2y$10$4CwW8d/GW8hptuTDIlKeG.Dx.Av/AnWPy666Vor1kqq/L9OiilQ.2', 'Buyer'),
(11, 'Harsh', 'Meheta', 'harsh@gmail.com', '$2y$10$VLMjtDcGLBQP6pnpArryJe2VxAOQSNCr4/ynZ/74EhEJiIRA8QPHu', 'Seller');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_8`
--

CREATE TABLE `wishlist_8` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_9`
--

CREATE TABLE `wishlist_9` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_10`
--

CREATE TABLE `wishlist_10` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wishlist_10`
--

INSERT INTO `wishlist_10` (`id`, `product_id`) VALUES
(50, 10),
(52, 12),
(51, 13);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_11`
--

CREATE TABLE `wishlist_11` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `wishlist_8`
--
ALTER TABLE `wishlist_8`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `wishlist_9`
--
ALTER TABLE `wishlist_9`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `wishlist_10`
--
ALTER TABLE `wishlist_10`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `wishlist_11`
--
ALTER TABLE `wishlist_11`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `wishlist_8`
--
ALTER TABLE `wishlist_8`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlist_9`
--
ALTER TABLE `wishlist_9`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist_10`
--
ALTER TABLE `wishlist_10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `wishlist_11`
--
ALTER TABLE `wishlist_11`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`userid`);

--
-- Constraints for table `wishlist_8`
--
ALTER TABLE `wishlist_8`
  ADD CONSTRAINT `wishlist_8_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `wishlist_9`
--
ALTER TABLE `wishlist_9`
  ADD CONSTRAINT `wishlist_9_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `wishlist_10`
--
ALTER TABLE `wishlist_10`
  ADD CONSTRAINT `wishlist_10_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `wishlist_11`
--
ALTER TABLE `wishlist_11`
  ADD CONSTRAINT `wishlist_11_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
