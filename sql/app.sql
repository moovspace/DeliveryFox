-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 28 Lut 2020, 14:10
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
  `email` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rf_newsletter_html` varchar(32) NOT NULL,
  `sender` varchar(32) NOT NULL DEFAULT '',
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `error` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `newsletter`
--

TRUNCATE TABLE `newsletter`;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `newsletter_html`
--

DROP TABLE IF EXISTS `newsletter_html`;
CREATE TABLE IF NOT EXISTS `newsletter_html` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `subject` varchar(250) NOT NULL,
  `html` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `newsletter_html`
--

TRUNCATE TABLE `newsletter_html`;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','failed','completed','refunded','canceled','onhold','processing','delivery') NOT NULL DEFAULT 'pending',
  `name` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `coupon` varchar(50) NOT NULL DEFAULT '',
  `delivery_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pick_up_time` varchar(10) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL,
  `info` varchar(250) NOT NULL DEFAULT '',
  `payment` int(11) NOT NULL DEFAULT 1,
  `worker` bigint(22) NOT NULL DEFAULT 0,
  `rf_user` bigint(22) NOT NULL DEFAULT 0,
  `ip` varchar(100) NOT NULL DEFAULT '',
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `orders`
--

TRUNCATE TABLE `orders`;
--
-- Zrzut danych tabeli `orders`
--

INSERT INTO `orders` (`id`, `price`, `status`, `name`, `address`, `time`, `coupon`, `delivery_cost`, `pick_up_time`, `mobile`, `info`, `payment`, `worker`, `rf_user`, `ip`, `visible`) VALUES
(30, '120.89', 'completed', 'Kaśka Czałuśna', 'Przasnysz Dębowa 4', '2020-02-24 17:03:42', '', '5.66', '1 hour', '+48 111 222 333', '', 2, 0, 0, '127.0.0.1', 1),
(31, '183.67', 'completed', 'Beny Paluch', 'New York Trumpowa 13', '2020-02-24 17:05:08', '', '5.66', '15:00', '+48 000 222 000', '', 3, 0, 0, '127.0.0.1', 1),
(32, '292.16', 'completed', 'Marek Garek', 'Pszczynka Pikowa 4', '2020-02-24 17:07:10', 'BURGER-TIME', '5.66', '1 hour', '000 000 123', '', 2, 0, 0, '127.0.0.1', 1),
(33, '241.78', 'canceled', 'Monka Mmonka', 'Psz Kulkowa 1', '2020-02-25 08:46:36', '', '5.66', '1 hour', '123123123', '', 2, 0, 0, '127.0.0.1', 1),
(34, '120.89', 'failed', 'Fiku Myku', 'Przasnysz Dębowa 4', '2020-02-24 17:03:42', '', '5.66', '1 hour', '+48 111 222 333', '', 2, 0, 0, '127.0.0.1', 1),
(35, '75.74', 'delivery', 'Piku Maki', 'sdffsd sdfsdf', '2020-02-25 12:25:32', '', '5.66', '1 hour', '23523523', 'sdfsd', 2, 0, 0, '127.0.0.1', 0),
(36, '23.66', 'processing', 'Max kolanko', 'Poznań Kluczowa 88/13', '2020-02-25 18:45:07', '', '5.66', '1 hour', '+15 123 123 123', 'Bez cebulki poproszę.', 1, 0, 0, '127.0.0.1', 1),
(37, '300.33', 'pending', 'Max', 'Warszawa Kacza 1', '2020-02-26 13:44:46', 'WINTER-DOM', '5.66', '1 hour', '123 123 123', 'komentarz do zamówienia', 1, 0, 58, '127.0.0.1', 1),
(38, '651.04', 'delivery', 'Maxiu', 'Przasnysz klicza 9', '2020-02-26 14:10:08', 'HOT WINTER', '0.00', '1 hour', '123123123', 'Super comment', 2, 0, 58, '127.0.0.1', 1),
(39, '24.66', 'canceled', 'Kasiu', 'Poznań Kószkowa 987', '2020-02-26 14:13:01', '', '5.66', '1 hour', '222333444', '', 2, 0, 58, '127.0.0.1', 1),
(40, '23.66', 'pending', 'asdasd', 'sdfsdf sdfsdfsd', '2020-02-26 17:13:18', 'Boom', '5.66', '1 hour', '2342342', 'sdfsdfsd', 1, 0, 0, '127.0.0.1', 1),
(41, '23.66', 'pending', 'sdfsdf', 'dfsdf sdfsdfs', '2020-02-26 17:47:47', '', '5.66', '1 hour', '435345s', '', 1, 0, 0, '127.0.0.1', 1),
(42, '100.93', 'completed', 'sdfasdf', 'sdfsdf dsfsdf', '2020-02-26 17:53:32', '', '0.00', '1 hour', '345345', '', 1, 0, 0, '127.0.0.1', 1),
(43, '120.89', 'failed', 'Maxymila', 'Kraków Smokowa 9/1', '2020-02-27 10:13:13', 'HOT_CUP', '0.00', '1 hour', '+48 123 123 123', 'Bez cebuli poproszę.', 1, 0, 63, '127.0.0.1', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4;

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
(37, 27, 2, '16.00', 1, 0, 0),
(38, 28, 2, '16.32', 2, 0, 2),
(39, 28, 26, '41.51', 1, 0, 17),
(40, 28, 17, '18.00', 1, 1, 0),
(41, 29, 2, '16.32', 2, 0, 2),
(42, 29, 26, '41.51', 1, 0, 17),
(43, 29, 17, '18.00', 1, 1, 0),
(44, 30, 2, '16.32', 1, 0, 15),
(45, 31, 26, '41.51', 2, 0, 16),
(46, 31, 27, '21.55', 1, 1, 17),
(47, 31, 17, '18.00', 2, 1, 0),
(48, 32, 26, '41.51', 2, 0, 17),
(49, 33, 2, '16.32', 2, 0, 1),
(50, 35, 2, '16.32', 2, 0, 1),
(51, 36, 17, '18.00', 1, 1, 0),
(52, 37, 17, '18.00', 1, 1, 0),
(53, 37, 2, '16.32', 2, 0, 1),
(54, 37, 32, '19.00', 1, 1, 16),
(55, 38, 17, '18.00', 2, 1, 0),
(56, 38, 2, '16.32', 2, 0, 1),
(57, 38, 32, '19.00', 2, 1, 16),
(58, 39, 32, '19.00', 1, 1, 18),
(59, 40, 17, '18.00', 1, 1, 0),
(60, 41, 17, '18.00', 1, 1, 0),
(61, 42, 2, '16.32', 1, 0, 15),
(62, 43, 2, '16.32', 1, 0, 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;

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
(31, 27, 37, 26, '40.01', 2, 1),
(32, 28, 38, 26, '41.51', 2, 0),
(33, 28, 38, 27, '21.55', 1, 1),
(34, 28, 39, 27, '21.55', 1, 1),
(35, 29, 41, 26, '41.51', 2, 0),
(36, 29, 41, 27, '21.55', 1, 1),
(37, 29, 42, 27, '21.55', 1, 1),
(38, 30, 44, 26, '41.51', 2, 0),
(39, 30, 44, 27, '21.55', 1, 1),
(40, 31, 45, 27, '21.55', 1, 1),
(41, 32, 48, 26, '41.51', 2, 0),
(42, 32, 48, 27, '21.55', 1, 1),
(43, 33, 49, 26, '41.51', 2, 0),
(44, 33, 49, 27, '21.55', 1, 1),
(45, 35, 50, 27, '21.55', 1, 1),
(46, 37, 53, 26, '41.51', 2, 0),
(47, 37, 53, 27, '21.55', 1, 1),
(48, 37, 54, 27, '21.55', 1, 1),
(49, 38, 56, 26, '41.51', 2, 0),
(50, 38, 56, 27, '21.55', 1, 1),
(51, 38, 57, 26, '41.51', 3, 0),
(52, 38, 57, 27, '21.55', 2, 1),
(53, 42, 61, 26, '41.51', 1, 0),
(54, 42, 61, 27, '21.55', 2, 1),
(55, 43, 62, 26, '41.51', 2, 0),
(56, 43, 62, 27, '21.55', 1, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `product`
--

TRUNCATE TABLE `product`;
--
-- Zrzut danych tabeli `product`
--

INSERT INTO `product` (`id`, `parent`, `size`, `rf_attr`, `category`, `name`, `about`, `price`, `price_sale`, `on_sale`, `addon_category`, `addon_quantity`, `time`, `visible`, `stock_status`, `stock_quantity`, `rating_count`, `rating_average`) VALUES
(2, 0, 'Mała 20 cm', 1, 1, 'Pizza hawajska', 'Pizza hawajska z ananasem.', '16.32', '0.00', 0, 6, 5, '2020-02-13 19:01:16', 1, 'instock', 0, 0, '5.00'),
(17, 0, 'Średnia 25cm', 0, 1, 'Pizza wiejska', 'Wspaniała pizza wiejska na cienkim cieście.', '19.15', '18.00', 1, 0, 5, '2020-02-15 21:25:54', 1, 'instock', 0, 0, '5.00'),
(26, 2, 'Wielka 60cm', 2, 6, 'Pizza hawajska', 'Wielka pizza hawajska.', '41.51', '40.01', 0, 6, 4, '2020-02-16 11:09:07', 1, 'instock', 0, 0, '5.00'),
(27, 2, 'Duża 50cm', 2, 6, 'Pizza hawajska', 'Duża pizza hawajska.', '32.66', '21.55', 1, 6, 2, '2020-02-16 11:09:07', 1, 'instock', 0, 0, '5.00'),
(28, 0, 'Olbrzymia 50cm', 2, 1, 'Quasadilla', 'Wspaniały opis produktu tutaj!', '20.50', '0.00', 0, 6, 5, '2020-02-25 12:44:57', 1, 'instock', 0, 0, '5.00'),
(32, 0, 'Duże 40cm', 2, 5, 'Kuleczki', 'Wspaniały opis produktu tutaj!', '20.50', '19.00', 1, 6, 5, '2020-02-25 12:51:53', 1, 'instock', 0, 0, '5.00');

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
  `send_news` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ukey1` (`email`),
  UNIQUE KEY `ukey` (`username`),
  UNIQUE KEY `apikey` (`apikey`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabela Truncate przed wstawieniem `user`
--

TRUNCATE TABLE `user`;
--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `pass`, `mobile`, `role`, `time`, `ip`, `code`, `active`, `apikey`, `send_news`) VALUES
(58, 'Marcys', 'usero@drive.xx', '5f4dcc3b5aa765d61d8327deb882cf99', '+48 321 321 321', 'admin', '2020-02-09 11:45:21', '127.0.0.1', '', 1, 'f3c18f6f-53df-11ea-bc1b-0016d48a4846', 1),
(63, 'Max', 'root@drive.xx', '5f4dcc3b5aa765d61d8327deb882cf99', '', 'user', '2020-02-09 11:45:21', '127.0.0.1', '', 1, '6d566eb3-53e0-11ea-bc1b-0016d48a4846', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `user_info`
--

TRUNCATE TABLE `user_info`;
--
-- Zrzut danych tabeli `user_info`
--

INSERT INTO `user_info` (`id`, `rf_user`, `firstname`, `lastname`, `country`, `city`, `zip`, `address`, `mobile`, `mail`, `lat`, `lng`, `about`, `orders`) VALUES
(1, 58, 'Max', 'Maxioski', 'Polska', 'Warszawa', '06-300', 'Moczymordowska 199/23', '+48 111 222 333', 'emai@email.xx', '50.000000', '20.000000', 'To ja Maxiu!', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
