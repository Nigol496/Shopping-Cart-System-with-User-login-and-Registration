<?php

//connection variables
$host = 'localhost';
$user = 'root';
$password = 'root';

//create mysql connection
$mysqli = new mysqli($host,$user,$password);
if ($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    die();
}

//create the database
if ( !$mysqli->query('CREATE DATABASE accounts') ) {
    printf("Errormessage: %s\n", $mysqli->error);
}

//create users table with all the fields
$mysqli->query('USE accounts;');
$mysqli->query('
CREATE TABLE `users` 
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50) NOT NULL,
     `last_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `hash` VARCHAR(32) NOT NULL,
    `active` BOOL NOT NULL DEFAULT 0,
PRIMARY KEY (`id`) 
);') or die($mysqli->error);


$mysqli->query ('
CREATE TABLE `invoice` 
(
    `invoice_no` int(11) NOT NULL,
    `email` varchar(60) NOT NULL,
    `invoice_amount` decimal(6,2) NOT NULL,
    `invoice_freight` decimal(6,2) NOT NULL,
    `invoice_total` decimal(6,2) NOT NULL,
    `invoice_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
') or die($mysqli->error);

$mysqli->query('
CREATE TABLE `product` (
        `prod_id` INT NOT NULL AUTO_INCREMENT,
        `prod_title` varchar(64) NOT NULL,
        `prod_seller` varchar(32) NOT NULL,
        `prod_image` varchar(255) NOT NULL,
        `prod_descr` varchar(1028) NOT NULL,
        `prod_price` decimal(6,2) NOT NULL,
        `prod_quantity` int(5) NOT NULL,
        `prod_discount` decimal(6,2) DEFAULT NULL,
        PRIMARY KEY (`prod_id`) 
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 ') or die ($mysqli->error);

$mysqli->query("
INSERT INTO `product` (`prod_title`, `prod_seller`, `prod_image`, `prod_descr`, `prod_price`, `prod_quantity`, `prod_discount`) VALUES
('Macbook Pro 15 Touch bar 2.8 Ghz 2016', 'Apple', 'img/mbp16grey2_8ghz.jpg', '2.8GHz quad-core Intel Core i7 processor\r\nTurbo Boost up to 3.8GHz\r\n16GB 2133MHz LPDDR3 memory\r\n256GB SSD storage1\r\nRadeon Pro 555 with 2GB memory\r\nFour Thunderbolt 3 ports\r\nTouch Bar and Touch ID', '2399.00', 0, '0.00'),
('Macbook Pro 15 Touch Bar 2.9 Ghz 2016', 'Apple', 'img/mbp16silver2_9.jpg', '2.9GHz quad-core Intel Core i7 processor\r\nTurbo Boost up to 3.9GHz\r\n16GB 2133MHz LPDDR3 memory\r\n512GB SSD storage1\r\nRadeon Pro 560 with 4GB memory\r\nFour Thunderbolt 3 ports\r\nTouch Bar and Touch ID', '2799.00', 1, '0.00'),
('Refurbished 12-inch MacBook 1.1GHz', 'Apple', 'img/mbp13gray1_1ghz.jpg', 'Originally released April 2016\r\n12-inch (diagonal) LED-backlit display; 2304-by-1440 resolution at 226 pixels per inch\r\n8GB of 1866MHz LPDDR3 onboard memory\r\n256GB PCIe-based onboard flash storage\r\n480p FaceTime Camera\r\nIntel HD Graphics 515', '1019.00', 5, '0.00'),
('Apple iPhone 7 Unlocked Phone 128 GB - US Version (Black)', 'Apple', 'img/iphone7_us_version.jpg', 'Multi-Touch display with IPS technology.\r\nWith just a single press, 3D Touch lets you do more than ever before.\r\nThe 12-megapixel iSight camera captures sharp, detailed photos. It takes 4K video, up to four times the resolution of 1080p HD video.', '808.95', 1, '0.00'),
('Apple iPhone 7 Plus Unlocked 128 GB - International  (Black)', 'Apple', 'img/iphone7_international.jpg', 'Multi-Touch display with IPS technology.\r\nWith just a single press, 3D Touch lets you do more than ever before.\r\nThe 12-megapixel iSight camera captures sharp, detailed photos. It takes 4K video, up to four times the resolution of 1080p HD video.', '919.95', 0, '0.00'),
('iPhone 7, TORRAS, Liquid Silicone Gel Rubber Shockproof Case', 'Torras', 'img/ultra_thin_case.jpg', 'Material: made with liquid silicone rubber, provide smooth skin texture, scratch-resistant performance. almost any stain that gets on the case wipes off easily with a damp rag\r\nThe inner material made with microfiber cushion.', '15.99', 4, '0.00'),
('iPhone 7, Ultra Thin Light Weight Soft Touch Flexible Case ', 'HZ BIGTREE', 'img/flexible_case.jpg', 'Ultra-Thin-Only 0.5mm slim than you expected, giving you bare-like experience.\r\nFull Matte Finish TPU Case Helps Prevent Fingerprints & Easy to Clean.', '8.53', 12, '0.10'),
('Stillhouse Lake (Stillhouse Lake Series Book 1) ', 'Rachel Caine (Author)', 'img/stillhouse_lake.jpg', 'Gina Royal is the definition of average, a shy Midwestern housewife with a happy marriage and two adorable children. But when a car accident reveals her husbands secret life as a serial killer. She must remake herself as Gwen Proctor', '4.99', 6, '0.25'),
('The Rise and Fall Of A Poor Man: (Inspired by Real Cases)', 'John Rose(Author)', 'img/rise_and_fall.jpg', 'The Rise and Fall Of A Poor Man is inspired by real cases. It tells the story of a poor boy who grew up in a street where crime and poverty went hand in hand and who one day, thanks to football, became a multimillionaire hero of the masses. ', '4.99', 11, '0.20'),
('Beats Solo3 Wireless On-Ear Headphones - Gloss Black', 'Beats', 'img/beats_solo.jpg', 'Connect via Class 1 Bluetooth with your device for wireless listening\r\nUp to 40 hours of battery life for multi-day use\r\nAdjustable fit with comfort-cushioned ear cups made for everyday use', '158.90', 4, '0.25');
 ") or die ($mysqli->error);

$mysqli->query('
CREATE TABLE `sales` (
  `sales_id` INT NOT NULL AUTO_INCREMENT,
  `invoice_no` int(16) DEFAULT NULL,
  `prod_id` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `sales_amount` decimal(6,2) NOT NULL,
  `sales_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sales_quantity` int(4) NOT NULL,
   PRIMARY KEY (`sales_id`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 ') or die ($mysqli->error);

echo "Database Created Successfully";




?>