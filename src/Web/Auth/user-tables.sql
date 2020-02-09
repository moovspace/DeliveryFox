-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 09 Lut 2020, 13:02
-- Wersja serwera: 10.3.22-MariaDB-0+deb10u1
-- Wersja PHP: 7.3.11-1~deb10u1

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `ukey1` (`email`),
  UNIQUE KEY `ukey` (`username`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabela Truncate przed wstawieniem `user`
--

TRUNCATE TABLE `user`;
--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `pass`, `mobile`, `role`, `time`, `ip`, `code`, `active`) VALUES
(58, 'a71442d6-4b31-11ea-8817-0016d48a4846', 'usero@drive.xx', '8ca8d666a30e2f981b119c9d77fdff9e', '', 'user', '2020-02-09 11:45:21', '127.0.0.1', '', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_info`
--

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE IF NOT EXISTS `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rf_user` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `user_info`
--

TRUNCATE TABLE `user_info`;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
