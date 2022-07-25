-- phpMyAdmin SQL Dump
-- version 4.0.10.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Mag 05, 2022 alle 17:53
-- Versione del server: 5.1.73
-- Versione PHP: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `s2i`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `destination` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dump dei dati per la tabella `orders`
--

INSERT INTO `orders` (`id`, `date`, `destination`) VALUES
(1, '2021-05-04', 'italy'),
(2, '2021-01-04', 'italy'),
(7, '2022-05-09', 'spain'),
(6, '2022-05-05', 'italy');

-- --------------------------------------------------------

--
-- Struttura della tabella `orders_rows`
--

CREATE TABLE IF NOT EXISTS `orders_rows` (
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `orders_rows`
--

INSERT INTO `orders_rows` (`id_order`, `id_product`, `quantity`) VALUES
(1, 1, 5),
(1, 4, 3),
(2, 3, 10),
(2, 5, 2),
(2, 2, 5),
(1, 2, 7),
(6, 1, 5),
(6, 4, 2),
(7, 1, 7),
(7, 4, 1),
(7, 2, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `co2` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`id`, `name`, `co2`) VALUES
(1, 'Beef', 10.5),
(2, 'Chicken', 2.3),
(3, 'Pork', 1.1),
(4, 'Steak', 5.6),
(5, 'Hamburger', 2.1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
