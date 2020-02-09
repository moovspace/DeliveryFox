-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 17, 2020 at 02:04 PM
-- Server version: 10.3.18-MariaDB-0+deb10u1
-- PHP Version: 7.3.11-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpapix`
--
CREATE DATABASE IF NOT EXISTS `phpapix` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `phpapix`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pass` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `role` int(3) NOT NULL DEFAULT 1,
  `active` int(3) NOT NULL DEFAULT 0,
  `ban` int(3) NOT NULL DEFAULT 0,
  `ip` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'abc321',
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Poland',
  `district` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `zipcode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mail` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `www` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `social` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `about` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sex` enum('men','woman') COLLATE utf8mb4_unicode_ci DEFAULT 'men',
  `lng` decimal(10,6) NOT NULL DEFAULT 0.000000,
  `lat` decimal(10,6) NOT NULL DEFAULT 0.000000,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ukey1` (`email`),
  UNIQUE KEY `ukey` (`username`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `pass`, `language`, `role`, `active`, `ban`, `ip`, `code`, `time`, `firstname`, `lastname`, `country`, `district`, `city`, `address`, `zipcode`, `mobile`, `mail`, `www`, `social`, `about`, `sex`, `lng`, `lat`) VALUES
(15, 'Admin', 'admin@local.host', '5f4dcc3b5aa765d61d8327deb882cf99', 'en', 1, 1, 0, '', 'bbbb53f8adbd500b97010eec333128f7', '2019-12-07 09:13:54', '', '', 'Poland', '', '', '', '', '', '', '', '', '', 'men', '0.000000', '0.000000');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
