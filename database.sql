-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: rdbms
-- Erstellungszeit: 05. Jun 2014 um 12:37
-- Server Version: 5.5.31-log
-- PHP-Version: 5.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `DB1635915`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `accomodations`
--

CREATE TABLE IF NOT EXISTS `accomodations` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `ort` varchar(100) NOT NULL,
  `zip` int(10) NOT NULL,
  `street` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `pic` varchar(200) NOT NULL,
  `url` varchar(300) NOT NULL,
  `priceFrom` decimal(15,2) NOT NULL,
  `priceTo` decimal(15,2) NOT NULL,
  `breakfast` varchar(200) NOT NULL,
  `active` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='hzWebsite   id title desc pic shop url price active' AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `accomodation_locations`
--

CREATE TABLE IF NOT EXISTS `accomodation_locations` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `zip` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='hzWebsite' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='hzWebsite' AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `anrede` varchar(100) NOT NULL,
  `vorname` varchar(100) NOT NULL,
  `nachname` varchar(100) NOT NULL,
  `telefon` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `wann` varchar(200) NOT NULL,
  `wo` varchar(200) NOT NULL,
  `was` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='vorname, nachname, telefon, email, wann, wo, was' AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gifts`
--

CREATE TABLE IF NOT EXISTS `gifts` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `itemID` int(50) NOT NULL,
  `userID` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `guestlist`
--

CREATE TABLE IF NOT EXISTS `guestlist` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `userID` int(8) NOT NULL,
  `date` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `amount` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userIDfromLogin` (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `hochzeitstisch`
--

CREATE TABLE IF NOT EXISTS `hochzeitstisch` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `cat` varchar(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `pic` varchar(200) NOT NULL,
  `shop` varchar(200) NOT NULL,
  `url` varchar(300) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `active` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='hzWebsite   id title desc pic shop url price active' AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `userID` int(8) NOT NULL,
  `usergroup` varchar(20) NOT NULL,
  `emailMd5` varchar(200) NOT NULL,
  `eMail` varchar(200) NOT NULL,
  `firstname` varchar(300) NOT NULL,
  `lastname` varchar(300) NOT NULL,
  `password` varchar(200) NOT NULL,
  `firstLog` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='login' AUTO_INCREMENT=87 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `userID` int(8) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `registered` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usergroups`
--

CREATE TABLE IF NOT EXISTS `usergroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
