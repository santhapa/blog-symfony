--
-- Table structure for table `spbar_blog_config`
--

CREATE TABLE IF NOT EXISTS `spbar_blog_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_64C87A9D989D9B62` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `spbar_blog_config`
--

INSERT INTO `spbar_blog_config` (`id`, `name`, `content`, `slug`, `default_status`) VALUES
(1, 'Post per page', '10', 'post_per_page', 1),
(2, 'Blog theme', 'fullwidth_2col.html.twig', 'blog_theme', 1);