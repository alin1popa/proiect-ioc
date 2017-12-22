-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2017 at 12:00 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iocdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `sender`, `receiver`, `accepted`) VALUES
(4, 'alin', 'ioana', 0),
(5, 'alin', 'anca', 0);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `multimediaid` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `multimediaid`, `type`) VALUES
(2, 'robert', 4, 0),
(3, 'alin', 1, 0),
(20, 'alin', 2, 0),
(21, 'anca', 2, 0),
(26, 'anca', 5, 0),
(31, 'anca', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `multimedia`
--

CREATE TABLE IF NOT EXISTS `multimedia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `releasedate` date NOT NULL,
  `posterurl` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `multimedia`
--

INSERT INTO `multimedia` (`id`, `type`, `name`, `description`, `releasedate`, `posterurl`) VALUES
(1, 'movie', 'Matrix', NULL, '2017-11-02', 'http://i0.kym-cdn.com/photos/images/original/001/292/053/813.jpg'),
(2, 'movie', 'La la land', 'this is a cool movie asdlasdlaskh lsdfh jskdhf slfkds nsdjfl skjflsd slf jslj ojooej oisdfjhds jsdf ', '2017-11-28', 'https://www.vintagemovieposters.co.uk/wp-content/uploads/2017/06/IMG_6573-482x643.jpg'),
(3, 'game', 'Witcher 3', NULL, '2017-04-05', 'https://images-na.ssl-images-amazon.com/images/I/81sn7JnHz4L._SL1500_.jpg'),
(4, 'series', 'Game of Thrones', NULL, '2016-09-07', 'https://i.imgur.com/JMvd597.jpg'),
(5, 'game', 'Hearthstone', 'patches patches patches', '2017-07-25', 'https://cdn.shopify.com/s/files/1/0942/1228/products/P7AhOxg.jpeg?v=1439758056'),
(6, 'game', 'csgo', NULL, '2018-02-08', 'https://vignette.wikia.nocookie.net/cswikia/images/d/d2/Csgo_poster.png/revision/latest?cb=20160104195851'),
(7, 'movie', 'avengers', NULL, '2017-09-06', 'https://a.scpr.org/i/7df081a513661df98fb5c15227e0cf69/37942-full.jpg'),
(8, 'movie', 'antman', NULL, '2018-05-18', 'http://cdn.collider.com/wp-content/uploads/2015/05/ant-man-poster-1.jpg'),
(9, 'series', 'the office', NULL, '2018-06-14', 'http://img.moviepostershop.com/the-office-tv-movie-poster-2005-1020481159.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `intro` varchar(50) NOT NULL,
  `website` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'alin', '1234'),
(2, 'anca', '1234'),
(3, 'robert', '1234'),
(4, 'ioana', '1234');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
