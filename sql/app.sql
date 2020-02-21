-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 21 Lut 2020, 09:06
-- Wersja serwera: 10.3.22-MariaDB-0+deb10u1
-- Wersja PHP: 7.3.14-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `app`
--
CREATE DATABASE IF NOT EXISTS `app` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `app`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `attr`
--

DROP TABLE IF EXISTS `attr`;
CREATE TABLE IF NOT EXISTS `attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `attr`
--

TRUNCATE TABLE `attr`;
--
-- Zrzut danych tabeli `attr`
--

INSERT INTO `attr` (`id`, `name`) VALUES
(1, 'Napoje'),
(2, 'Sos');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `attr_name`
--

DROP TABLE IF EXISTS `attr_name`;
CREATE TABLE IF NOT EXISTS `attr_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rf_attr` int(11) NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attrKey` (`rf_attr`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `attr_name`
--

TRUNCATE TABLE `attr_name`;
--
-- Zrzut danych tabeli `attr_name`
--

INSERT INTO `attr_name` (`id`, `rf_attr`, `name`) VALUES
(6, 0, 'None'),
(14, 1, 'Coca Cola'),
(15, 1, 'Oranżada'),
(1, 1, 'Pepsi'),
(2, 1, 'Sprite'),
(18, 2, 'Czosnkowy'),
(17, 2, 'Pikantny'),
(16, 2, 'Łagodny');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `on_addon` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `category`
--

TRUNCATE TABLE `category`;
--
-- Zrzut danych tabeli `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `visible`, `on_addon`) VALUES
(1, 'Pizza', 'pizza', 1, 0),
(5, 'Kebab', 'kebab', 1, 0),
(6, 'Dodatki', 'addons', 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rf_user` int(11) NOT NULL,
  `text` varchar(250) NOT NULL,
  `type` enum('post','review') NOT NULL DEFAULT 'post',
  `likes` int(11) NOT NULL DEFAULT 0,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `comment`
--

TRUNCATE TABLE `comment`;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `company`
--

TRUNCATE TABLE `company`;
--
-- Zrzut danych tabeli `company`
--

INSERT INTO `company` (`id`, `name`, `value`) VALUES
(1, 'name', 'Nazwa Firmy Sp.z.o.o'),
(2, 'city', 'Warszawa'),
(3, 'address', 'Platynowa 123'),
(4, 'mobile', '+48 000 000 000'),
(5, 'email', 'your@email.address'),
(6, 'social_fb', 'https://domain.xx/username'),
(7, 'logo_image', 'https://domain.xx/logo.png'),
(8, 'about', 'Opis firmy'),
(9, 'lat', '52.000000'),
(10, 'lng', '21.000000'),
(11, 'social_tw', 'https://domain.xx/username');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `email_theme`
--

DROP TABLE IF EXISTS `email_theme`;
CREATE TABLE IF NOT EXISTS `email_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `html` text NOT NULL,
  `params` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `email_theme`
--

TRUNCATE TABLE `email_theme`;
--
-- Zrzut danych tabeli `email_theme`
--

INSERT INTO `email_theme` (`id`, `name`, `html`, `params`) VALUES
(1, 'activation', '<h1>Hello!</h1><p>Activate your new account:</p><a target=\"__blank\" href=\"{URL}\" style=\"color: #09f\"> Activate now! </a><h4>Regards</h4>', '{URL}'),
(2, 'reset-password', '<h1>Hello!</h1><p>Hello, it is new password: {PASSWORD} </p><h4>Regards</h4>', '{PASSWORD}');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `gallery`
--

DROP TABLE IF EXISTS `gallery`;
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(250) NOT NULL,
  `alt` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `order_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `gallery`
--

TRUNCATE TABLE `gallery`;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `rf_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `image`
--

TRUNCATE TABLE `image`;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(190) NOT NULL,
  `name` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `code` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `newsletter`
--

TRUNCATE TABLE `newsletter`;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','failed','completed','refunded','canceled','onhold','processing','delivery') NOT NULL DEFAULT 'pending',
  `address` varchar(250) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `coupon` varchar(50) NOT NULL DEFAULT '',
  `delivery_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `orders`
--

TRUNCATE TABLE `orders`;
--
-- Zrzut danych tabeli `orders`
--

INSERT INTO `orders` (`id`, `price`, `status`, `address`, `time`, `coupon`, `delivery_cost`) VALUES
(24, '60.66', 'pending', 'Złota 13/9', '2020-02-16 19:22:12', '', '0.00'),
(26, '171.68', 'pending', 'Kucza 1', '2020-02-18 11:31:36', '', '0.00'),
(27, '171.68', 'pending', 'Kucza 1', '2020-02-18 11:38:23', '', '5.66');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_product`
--

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `rf_orders` bigint(22) NOT NULL,
  `product` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `sale` tinyint(1) NOT NULL DEFAULT 0,
  `attr` bigint(22) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `order_product`
--

TRUNCATE TABLE `order_product`;
--
-- Zrzut danych tabeli `order_product`
--

INSERT INTO `order_product` (`id`, `rf_orders`, `product`, `price`, `quantity`, `sale`, `attr`) VALUES
(32, 24, 1, '13.50', 2, 0, 0),
(33, 24, 2, '15.50', 1, 0, 0),
(34, 26, 17, '19.00', 1, 0, 0),
(35, 26, 2, '16.00', 1, 0, 0),
(36, 27, 17, '19.00', 1, 0, 0),
(37, 27, 2, '16.00', 1, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_product_addon`
--

DROP TABLE IF EXISTS `order_product_addon`;
CREATE TABLE IF NOT EXISTS `order_product_addon` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `rf_orders` bigint(22) NOT NULL,
  `rf_order_product` bigint(22) NOT NULL,
  `product` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `sale` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `order_product_addon`
--

TRUNCATE TABLE `order_product_addon`;
--
-- Zrzut danych tabeli `order_product_addon`
--

INSERT INTO `order_product_addon` (`id`, `rf_orders`, `rf_order_product`, `product`, `price`, `quantity`, `sale`) VALUES
(23, 24, 32, 16, '2.54', 2, 0),
(24, 24, 33, 17, '3.00', 2, 0),
(25, 24, 33, 7, '2.00', 1, 0),
(26, 26, 34, 2, '16.00', 2, 0),
(27, 26, 34, 17, '19.00', 1, 0),
(28, 26, 35, 26, '40.01', 2, 1),
(29, 27, 36, 2, '16.00', 2, 0),
(30, 27, 36, 17, '19.00', 1, 0),
(31, 27, 37, 26, '40.01', 2, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rf_user` int(11) NOT NULL,
  `title` varchar(190) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `images` text NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `likes` int(11) NOT NULL DEFAULT 0,
  `comments` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `post`
--

TRUNCATE TABLE `post`;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT 0,
  `size` varchar(50) NOT NULL,
  `rf_attr` int(11) NOT NULL DEFAULT 0,
  `category` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `about` text NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `price_sale` decimal(15,2) NOT NULL DEFAULT 0.00,
  `on_sale` tinyint(1) NOT NULL DEFAULT 0,
  `addon_category` int(11) NOT NULL DEFAULT 0,
  `addon_quantity` int(11) NOT NULL DEFAULT 5,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `stock_status` enum('instock','outofstock','leftinstock','backdored') NOT NULL DEFAULT 'instock',
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `rating_count` int(11) NOT NULL DEFAULT 0,
  `rating_average` decimal(3,2) NOT NULL DEFAULT 5.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pKey` (`parent`,`size`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `product`
--

TRUNCATE TABLE `product`;
--
-- Zrzut danych tabeli `product`
--

INSERT INTO `product` (`id`, `parent`, `size`, `rf_attr`, `category`, `name`, `about`, `price`, `price_sale`, `on_sale`, `addon_category`, `addon_quantity`, `time`, `visible`, `stock_status`, `stock_quantity`, `rating_count`, `rating_average`) VALUES
(2, 0, 'Mała 20 cm', 1, 1, 'Pizza hawajska', 'Pizza hawajska z ananasem.', '16.32', '0.00', 0, 6, 5, '2020-02-13 19:01:16', 1, 'instock', 0, 0, '5.00'),
(17, 2, 'Średnia 25cm', 0, 6, 'Pizza hawajska', 'Wspaniała pizza hawajska na cienkim cieście.', '19.15', '0.00', 0, 0, 5, '2020-02-15 21:25:54', 1, 'instock', 0, 0, '5.00'),
(26, 2, 'Wielka 60cm', 2, 6, 'Pizza hawajska', 'Wielka pizza hawajska.', '41.51', '40.01', 1, 6, 2, '2020-02-16 11:09:07', 1, 'instock', 0, 0, '5.00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_featured`
--

DROP TABLE IF EXISTS `product_featured`;
CREATE TABLE IF NOT EXISTS `product_featured` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `featured_product` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniKey` (`product`,`featured_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `product_featured`
--

TRUNCATE TABLE `product_featured`;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `image_url` int(11) NOT NULL,
  `rf_product` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `promotion`
--

TRUNCATE TABLE `promotion`;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `role` enum('admin','user','worker','driver') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `apikey` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ukey1` (`email`),
  UNIQUE KEY `ukey` (`username`),
  UNIQUE KEY `apikey` (`apikey`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabela Truncate przed wstawieniem `user`
--

TRUNCATE TABLE `user`;
--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `pass`, `mobile`, `role`, `time`, `ip`, `code`, `active`, `apikey`) VALUES
(58, 'Marcys', 'usero@drive.xx', '5f4dcc3b5aa765d61d8327deb882cf99', '+48 321 321 321', 'admin', '2020-02-09 11:45:21', '127.0.0.1', '', 1, 'f3c18f6f-53df-11ea-bc1b-0016d48a4846'),
(63, 'Max', 'root@drive.xx', '5f4dcc3b5aa765d61d8327deb882cf99', '', 'admin', '2020-02-09 11:45:21', '127.0.0.1', '', 1, '6d566eb3-53e0-11ea-bc1b-0016d48a4846');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_info`
--

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE IF NOT EXISTS `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rf_user` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `lastname` varchar(100) NOT NULL DEFAULT '',
  `country` varchar(100) NOT NULL DEFAULT '',
  `city` varchar(100) NOT NULL DEFAULT '',
  `zip` varchar(10) NOT NULL DEFAULT '',
  `address` varchar(100) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `mail` varchar(250) NOT NULL DEFAULT '',
  `lat` decimal(10,6) NOT NULL DEFAULT 0.000000,
  `lng` decimal(10,6) NOT NULL DEFAULT 0.000000,
  `about` varchar(250) NOT NULL DEFAULT '',
  `orders` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UserKey` (`rf_user`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `user_info`
--

TRUNCATE TABLE `user_info`;
--
-- Zrzut danych tabeli `user_info`
--

INSERT INTO `user_info` (`id`, `rf_user`, `firstname`, `lastname`, `country`, `city`, `zip`, `address`, `mobile`, `mail`, `lat`, `lng`, `about`, `orders`) VALUES
(1, 58, 'Max', 'Maxioski', 'Polska', 'Przasnysz', '06-300', 'Moczymordowska 199/23', '+48 111 222 333', 'emai@email.xx', '50.000000', '20.000000', 'To ja Maxiu!', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
