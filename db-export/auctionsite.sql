-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 23, 2018 at 05:23 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auctionsite`
--
CREATE DATABASE IF NOT EXISTS `auctionsite` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `auctionsite`;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Street` varchar(100) COLLATE utf8_bin NOT NULL,
  `Number` int(11) NOT NULL,
  `Code` varchar(10) COLLATE utf8_bin NOT NULL,
  `City` varchar(100) COLLATE utf8_bin NOT NULL,
  `Country` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`Id`, `Street`, `Number`, `Code`, `City`, `Country`) VALUES
(5, 'Polna', 24, '55-003', 'Wojnowice', 'Polska'),
(7, 'test', 1, '11-111', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `Text` varchar(2000) COLLATE utf8_bin NOT NULL,
  `Date` date NOT NULL,
  `authorId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`Id`, `UserId`, `Text`, `Date`, `authorId`) VALUES
(6, 6, 'sdafgsdfagasdg', '2018-01-23', 1),
(7, 8, 'Zaufany sprzedajacy. Polecam!', '2018-01-23', 6),
(8, 6, 'Testowy komentarz', '2018-01-23', 8);

-- --------------------------------------------------------

--
-- Table structure for table `desiredproduct`
--

DROP TABLE IF EXISTS `desiredproduct`;
CREATE TABLE IF NOT EXISTS `desiredproduct` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ProductId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `isHidden` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `desiredproduct`
--

INSERT INTO `desiredproduct` (`Id`, `ProductId`, `UserId`, `isHidden`) VALUES
(10, 12, 6, 0),
(9, 8, 9, 0),
(8, 9, 8, 0),
(7, 11, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderedproduct`
--

DROP TABLE IF EXISTS `orderedproduct`;
CREATE TABLE IF NOT EXISTS `orderedproduct` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ProductId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `dateOfOrder` date NOT NULL,
  `isPaid` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `orderedproduct`
--

INSERT INTO `orderedproduct` (`Id`, `ProductId`, `UserId`, `dateOfOrder`, `isPaid`) VALUES
(14, 12, 6, '2018-01-23', 0),
(13, 9, 9, '2018-01-23', 0),
(12, 10, 8, '2018-01-23', 0),
(11, 7, 8, '2018-01-23', 1),
(15, 14, 8, '2018-01-23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(69) COLLATE utf8_bin NOT NULL,
  `Photo` varchar(420) COLLATE utf8_bin DEFAULT NULL,
  `Description` varchar(2137) COLLATE utf8_bin DEFAULT NULL,
  `Date` date NOT NULL,
  `Value` double NOT NULL,
  `Rating` int(11) NOT NULL,
  `SellerId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Id`, `Name`, `Photo`, `Description`, `Date`, `Value`, `Rating`, `SellerId`) VALUES
(7, 'test1', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris euismod ex et magna varius, quis commodo mauris tristique. Donec vel egestas nulla, tincidunt rhoncus nibh. Cras non rutrum ipsum. Suspendisse at nisl et purus gravida lobortis. Donec non consectetur justo, aliquet commodo quam. Curabitur ac interdum turpis. Suspendisse potenti. Nam rutrum felis id ornare cursus. Aenean eget neque magna. Phasellus a scelerisque dui, sed luctus purus. Nullam sed lectus vel elit viverra vehicula. Nunc ac euismod lacus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque at neque blandit, fringilla tellus ac, placerat lectus. Donec in elit tellus. Praesent volutpat lorem nec quam suscipit, eu tincidunt ipsum accumsan. ', '2018-01-23', 222.33, 5, 6),
(8, 'test2', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris euismod ex et magna varius, quis commodo mauris tristique. Donec vel egestas nulla, tincidunt rhoncus nibh. Cras non rutrum ipsum. Suspendisse at nisl et purus gravida lobortis. Donec non consectetur justo, aliquet commodo quam. Curabitur ac interdum turpis. Suspendisse potenti. Nam rutrum felis id ornare cursus. Aenean eget neque magna. Phasellus a scelerisque dui, sed luctus purus. Nullam sed lectus vel elit viverra vehicula. Nunc ac euismod lacus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque at neque blandit, fringilla tellus ac, placerat lectus. Donec in elit tellus. Praesent volutpat lorem nec quam suscipit, eu tincidunt ipsum accumsan. ', '2018-01-23', 111, 3, 6),
(9, 'test3', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris euismod ex et magna varius, quis commodo mauris tristique. Donec vel egestas nulla, tincidunt rhoncus nibh. Cras non rutrum ipsum. Suspendisse at nisl et purus gravida lobortis. Donec non consectetur justo, aliquet commodo quam. Curabitur ac interdum turpis. Suspendisse potenti. Nam rutrum felis id ornare cursus. Aenean eget neque magna. Phasellus a scelerisque dui, sed luctus purus. Nullam sed lectus vel elit viverra vehicula. Nunc ac euismod lacus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque at neque blandit, fringilla tellus ac, placerat lectus. Donec in elit tellus. Praesent volutpat lorem nec quam suscipit, eu tincidunt ipsum accumsan. ', '2018-01-23', 222, 4, 6),
(10, 'test4', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris euismod ex et magna varius, quis commodo mauris tristique. Donec vel egestas nulla, tincidunt rhoncus nibh. Cras non rutrum ipsum. Suspendisse at nisl et purus gravida lobortis. Donec non consectetur justo, aliquet commodo quam. Curabitur ac interdum turpis. Suspendisse potenti. Nam rutrum felis id ornare cursus. Aenean eget neque magna. Phasellus a scelerisque dui, sed luctus purus. Nullam sed lectus vel elit viverra vehicula. Nunc ac euismod lacus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque at neque blandit, fringilla tellus ac, placerat lectus. Donec in elit tellus. Praesent volutpat lorem nec quam suscipit, eu tincidunt ipsum accumsan. ', '2018-01-23', 123.33, 2, 6),
(11, 'test5', 'https://i.pinimg.com/564x/60/4b/74/604b740adb143b8fb0a0e97bcbfdf017--mlp-twilight-twilight-sparkle.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris euismod ex et magna varius, quis commodo mauris tristique. Donec vel egestas nulla, tincidunt rhoncus nibh. Cras non rutrum ipsum. Suspendisse at nisl et purus gravida lobortis. Donec non consectetur justo, aliquet commodo quam. Curabitur ac interdum turpis. Suspendisse potenti. Nam rutrum felis id ornare cursus. Aenean eget neque magna. Phasellus a scelerisque dui, sed luctus purus. Nullam sed lectus vel elit viverra vehicula. Nunc ac euismod lacus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque at neque blandit, fringilla tellus ac, placerat lectus. Donec in elit tellus. Praesent volutpat lorem nec quam suscipit, eu tincidunt ipsum accumsan. ', '2018-01-23', 22.45, 5, 6),
(12, 'test6', '', '', '2018-01-23', 333.44, 2, 8),
(13, 'test8', '', 'kirmkfgklt,gl kt,golfl,gl; kgdokfl', '2018-01-23', -50, 0, 11),
(14, 'fgfgfg', 'http://', 'dwdfwfr', '2018-01-23', 5.454646, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `AddressId` int(11) NOT NULL,
  `FirstName` varchar(50) COLLATE utf8_bin NOT NULL,
  `LastName` varchar(50) COLLATE utf8_bin NOT NULL,
  `Username` varchar(50) COLLATE utf8_bin NOT NULL,
  `Email` varchar(100) COLLATE utf8_bin NOT NULL,
  `SaltyPassword` varchar(100) COLLATE utf8_bin NOT NULL,
  `Salt` varchar(6) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Id`, `AddressId`, `FirstName`, `LastName`, `Username`, `Email`, `SaltyPassword`, `Salt`) VALUES
(9, 7, 'test', 'test', 'yyy', 'yyy@test.pl', 'b3e0086c40c00b27bfb13610b833fafe', '656254'),
(6, 5, 'Bartosz', 'Rodziewicz', 'baatochan', 'baatochan@test.pl', 'ea74800e9f333adc83914704385ec0fe', '3998d7'),
(8, 7, 'Test', 'test', 'xxx', 'xxx@test.pl', 'abf5244351167128fdd67eeb494f7f98', '2abcc2'),
(10, 7, 'Test', 'Test', 'zzz', 'zzz@test.pl', '11bffdbeccfa13fcb6909d4ec30502c6', 'e68973'),
(11, 7, 'test', 'test', 'aaa', 'xxx@www.pl', '4f841624b54d743606b3a977ae3a35e7', '07b9e8');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
