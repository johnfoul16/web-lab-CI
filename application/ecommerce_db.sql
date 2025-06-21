-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2025 at 03:42 PM
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
-- Database: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_data` text NOT NULL,
  `shipping_status` varchar(50) NOT NULL DEFAULT 'Processing',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `address`, `payment_method`, `total_amount`, `order_data`, `shipping_status`, `created_at`) VALUES
(1, 'admin', 'qweqw123123123123123', 'cod', 0.00, '{\"1\":{\"id\":\"1\",\"name\":\"Gaming Mouse\",\"price\":\"500.00\",\"qty\":1}}', 'Processing', '2025-06-12 14:12:23'),
(2, 'ntc_8214189', '12312312312312312312', 'cod', 0.00, '{\"1\":{\"id\":\"1\",\"name\":\"Gaming Mouse\",\"price\":\"500.00\",\"qty\":1}}', 'Processing', '2025-06-12 14:16:41'),
(3, 'ntc_8214189', 'NTC Quiapo, Manila', 'cod', 0.00, '{\"5\":{\"id\":\"5\",\"name\":\"ASUS ROG Swift PG27AQDM 27\\\" OLED Gaming Monitor\",\"price\":\"59950.00\",\"qty\":1}}', 'Processing', '2025-06-14 09:12:12'),
(4, 'admin', '123 ABS Sampaloc', 'cod', 2000.00, '{\"1\":{\"id\":\"1\",\"name\":\"Sample Product\",\"price\":\"1000.00\",\"qty\":2}}', 'Processing', '2025-06-17 15:27:28');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image_path`, `price`, `stock`) VALUES
(1, 'Sample Product', 'This is a sample product.', 'assets/uploads/56d5cea810337939e1d2142a64dd529d.jpg', 1000.00, 3),
(2, 'MAD 60HE Keyboard', 'MAD 60HE is a premium 60% mechanical keyboard featuring ultra-responsive Hall Effect magnetic switches with adjustable actuation and rapid trigger for competitive gaming. Compact, customizable, and built for speed, it delivers pro-level performance in a minimalist form.', 'assets/uploads/845d2e24d6f658a63e321ec62ea1b623.jpg', 4788.00, 60),
(4, 'Razer BlackShark V2 Pro Wireless Gaming Headset', 'Dominate in every game with the Razer BlackShark V2 Pro—a wireless esports headset designed for ultimate clarity and comfort. Featuring THX 7.1 Spatial Audio, titanium-coated drivers, and a detachable noise-cancelling mic, this headset ensures you\'re heard loud and clear. With ultra-soft memory foam ear cushions and over 24 hours of battery life, it\'s built for serious, marathon gaming.', 'assets/uploads/77f106a067256d785159aa53009cd289.jpeg', 6650.00, 45),
(5, 'ASUS ROG Swift PG27AQDM 27\" OLED Gaming Monitor', 'Experience flawless visuals with the ASUS ROG Swift OLED monitor, boasting a 1440p resolution and a blazing 240Hz refresh rate. Designed for fast-paced gameplay, this 27-inch display offers ultra-low response times and HDR10 support. Its sleek design with RGB accents and customizable lighting makes it the centerpiece of any gaming setup.', 'assets/uploads/372941cec0b8e6fbb66495766735d1ef.png', 59950.00, 29),
(9, 'sdadasd', 'asda', 'assets/uploads/75ed1342df1eeec84f8022dc3d3feb5d.jpg', 121.00, 122),
(10, 'GeForce RTX 5060 Ti 16GB', '12312312asasdasd', 'assets/uploads/3354602ece4d1aff0fb6c7eba8d499e2.jpg', 15.00, 15),
(11, 'GeForce RTX 5060 Ti 16GB', 'asaasd', 'assets/uploads/93bcde6f8cc15a9050b9e102e6645501.png', 15.00, 15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$.Sb3N9gFnTRg7zWp64X5I.P/ODcQhVaBeZNdJONFhIk9yRW.pti/W', 'admin', '2025-06-11 21:53:42'),
(2, 'john123', 'joyce@gmail.com', '$2y$10$nYm.1cktiO20J0RA5xUEeej2umPPZ1hlSCJG/po1RFzjqUjj8sK3G', 'user', '2025-06-11 17:15:34'),
(3, 'ntc_8214189', '123@gmail.com', '$2y$10$Up/Q6UETRCL00tN/5/Rb2uXa7OHCXND16IURDtR.bx8euf2P/Aysy', 'user', '2025-06-12 14:09:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
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
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
