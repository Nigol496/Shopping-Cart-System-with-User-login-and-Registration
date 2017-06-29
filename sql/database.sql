
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
CREATE DATABASE `accounts`;
-- Database: `accounts`
--
USE `accounts`;
-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_no` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `invoice_amount` decimal(6,2) NOT NULL,
  `invoice_freight` decimal(6,2) NOT NULL,
  `invoice_total` decimal(6,2) NOT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_id` int(16) NOT NULL,
  `prod_title` varchar(64) NOT NULL,
  `prod_seller` varchar(32) NOT NULL,
  `prod_image` varchar(255) NOT NULL,
  `prod_descr` varchar(1028) NOT NULL,
  `prod_price` decimal(6,2) NOT NULL,
  `prod_quantity` int(5) NOT NULL,
  `prod_discount` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_title`, `prod_seller`, `prod_image`, `prod_descr`, `prod_price`, `prod_quantity`, `prod_discount`) VALUES
(1, '15" Macbook Pro Touch bar 2.8 Ghz 2016', 'Apple', 'img/mbp16grey2_8ghz.jpg', '2.8GHz quad-core Intel Core i7 processor\r\nTurbo Boost up to 3.8GHz\r\n16GB 2133MHz LPDDR3 memory\r\n256GB SSD storage1\r\nRadeon Pro 555 with 2GB memory\r\nFour Thunderbolt 3 ports\r\nTouch Bar and Touch ID', '2399.00', 0, '0.00'),
(2, '15" Macbook Pro Touch Bar 2.9 Ghz 2016', 'Apple', 'img/mbp16silver2_9.jpg', '2.9GHz quad-core Intel Core i7 processor\r\nTurbo Boost up to 3.9GHz\r\n16GB 2133MHz LPDDR3 memory\r\n512GB SSD storage1\r\nRadeon Pro 560 with 4GB memory\r\nFour Thunderbolt 3 ports\r\nTouch Bar and Touch ID', '2799.00', 1, '0.00'),
(3, '	 Refurbished 12-inch MacBook 1.1GHz', 'Apple', 'img/mbp13gray1_1ghz.jpg', 'Originally released April 2016\r\n12-inch (diagonal) LED-backlit display; 2304-by-1440 resolution at 226 pixels per inch\r\n8GB of 1866MHz LPDDR3 onboard memory\r\n256GB PCIe-based onboard flash storage\r\n480p FaceTime Camera\r\nIntel HD Graphics 515', '1019.00', 5, '0.00'),
(4, 'Apple iPhone 7 Unlocked Phone 128 GB - US Version (Black)', 'Apple', 'img/iphone7_us_version.jpg', 'Multi-Touch display with IPS technology.\r\nWith just a single press, 3D Touch lets you do more than ever before.\r\nThe 12-megapixel iSight camera captures sharp, detailed photos. It takes 4K video, up to four times the resolution of 1080p HD video.', '808.95', 1, '0.00'),
(5, 'Apple iPhone 7 Plus Unlocked 128 GB - International  (Black)', 'Apple', 'img/iphone7_international.jpg', 'Multi-Touch display with IPS technology.\r\nWith just a single press, 3D Touch lets you do more than ever before.\r\nThe 12-megapixel iSight camera captures sharp, detailed photos. It takes 4K video, up to four times the resolution of 1080p HD video.', '919.95', 0, '0.00'),
(6, 'iPhone 7, TORRAS, Liquid Silicone Gel Rubber Shockproof Case', 'Torras', 'img/ultra_thin_case.jpg', 'Material: made with liquid silicone rubber, provide smooth skin texture, scratch-resistant performance. almost any stain that gets on the case wipes off easily with a damp rag\r\nThe inner material made with microfiber cushion.', '15.99', 4, '0.00'),
(7, 'iPhone 7, Ultra Thin Light Weight Soft Touch Flexible Case ', 'HZ BIGTREE', 'img/flexible_case.jpg', 'Ultra-Thin-Only 0.5mm slim than you expected, giving you bare-like experience.\r\nFull Matte Finish TPU Case Helps Prevent Fingerprints & Easy to Clean.', '8.53', 12, '0.10'),
(8, 'Stillhouse Lake (Stillhouse Lake Series Book 1) ', 'Rachel Caine (Author)', 'img/stillhouse_lake.jpg', 'Gina Royal is the definition of average, a shy Midwestern housewife with a happy marriage and two adorable children. But when a car accident reveals her husbands secret life as a serial killer. She must remake herself as Gwen Proctor', '4.99', 6, '0.25'),
(9, 'The Rise and Fall Of A Poor Man: (Inspired by Real Cases)', 'John Rose(Author)', 'img/rise_and_fall.jpg', 'The Rise and Fall Of A Poor Man is inspired by real cases. It tells the story of a poor boy who grew up in a street where crime and poverty went hand in hand and who one day, thanks to football, became a multimillionaire hero of the masses. ', '4.99', 11, '0.20'),
(10, 'Beats Solo3 Wireless On-Ear Headphones - Gloss Black', 'Beats', 'img/beats_solo.jpg', 'Connect via Class 1 Bluetooth with your device for wireless listening\r\nUp to 40 hours of battery life for multi-day use\r\nAdjustable fit with comfort-cushioned ear cups made for everyday use', '158.90', 4, '0.25');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(16) NOT NULL,
  `invoice_no` int(16) DEFAULT NULL,
  `prod_id` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `sales_amount` decimal(6,2) NOT NULL,
  `sales_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sales_quantity` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(16) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `hash` varchar(64) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_no`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD UNIQUE KEY `prod_id` (`prod_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;