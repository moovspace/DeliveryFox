-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 20 Lut 2020, 12:57
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
