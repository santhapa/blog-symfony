-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2015 at 11:50 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE IF NOT EXISTS `tbl_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8AD70074B89032C` (`post_id`),
  KEY `IDX_8AD7007A76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tbl_comments`
--

INSERT INTO `tbl_comments` (`id`, `post_id`, `user_id`, `comment`, `date_time`) VALUES
(1, 2, 3, 'Testing comment 1 for Post 2', '2015-01-14 13:10:11'),
(2, 2, 3, 'Testing comment 2 for Post 2', '2015-01-14 13:12:11'),
(6, 5, 4, 'Hello Testing', '2015-01-14 10:22:31'),
(7, 5, 4, '', '2015-01-14 10:22:44'),
(8, 4, NULL, 'hello', '2015-01-14 10:26:53'),
(9, 4, NULL, 'Testing for post 4 hello', '2015-01-14 10:29:07'),
(10, 4, NULL, 'Comment testing', '2015-01-14 10:30:30'),
(13, NULL, 3, 'hello', '2015-01-14 12:09:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_posts`
--

CREATE TABLE IF NOT EXISTS `tbl_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2639F0E5F675F31B` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_posts`
--

INSERT INTO `tbl_posts` (`id`, `title`, `content`, `date_time`, `active`, `author_id`) VALUES
(2, ' Testing 2 ', 'This is the testing 2 post content. Hello testing 23', '2015-01-13 07:17:07', 1, 4),
(3, 'Testing 3', 'This is the testing 3 post content. Hello testing', '2015-01-13 07:17:47', 1, 3),
(4, ' Testing 4 ', 'This is the testing 4 post content. Hello testing', '2015-01-13 07:18:05', 0, 3),
(5, 'Testing 5', 'This is the testing 5 post content. Hello testing', '2015-01-13 07:18:24', 1, 3),
(6, 'Testing 6', 'This is the testing 6 post content. Hello testing', '2015-01-13 07:18:45', 1, 4),
(7, 'Testing 7', 'This is the testing 6 post content. Hello testing', '2015-01-13 07:18:54', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BAE7EFF6F85E0677` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `password`, `user_type`) VALUES
(3, 'Admin User', 'admin', '21232f297a57a5a743894a0e4a801fc3', '1'),
(4, 'Author User', 'author', '02bd92faa38aaa6cc0ea75e59937a1ef', '2'),
(7, 'Sushil Shrestha', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', '3');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD CONSTRAINT `FK_8AD70074B89032C` FOREIGN KEY (`post_id`) REFERENCES `tbl_posts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_8AD7007A76ED395` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  ADD CONSTRAINT `FK_2639F0E5F675F31B` FOREIGN KEY (`author_id`) REFERENCES `tbl_users` (`id`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
