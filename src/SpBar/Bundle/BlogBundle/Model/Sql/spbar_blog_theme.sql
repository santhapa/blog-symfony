--
-- Table structure for table `spbar_blog_theme`
--

CREATE TABLE IF NOT EXISTS `spbar_blog_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template` longtext COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5B82472989D9B62` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `spbar_blog_theme`
--

INSERT INTO `spbar_blog_theme` (`id`, `name`, `template`, `slug`, `type`) VALUES
(1, 'Fullwidth Single Column', 'fullwidth_1col.html.twig', 'fullwidth_single_column', 'index'),
(2, 'Fullwidth Two Column', 'fullwidth_2col.html.twig', 'fullwidth_two_column', 'index'),
(3, 'Fullwidth Three Column', 'fullwidth_3col.html.twig', 'fullwidth_three_column', 'index'),
(4, 'Fullwidth Four Column', 'fullwidth_4col.html.twig', 'fullwidth_four_column', 'index'),
(5, 'With Left Sidebar', 'with_leftsidebar.html.twig', 'with_left_sidebar', 'index'),
(6, 'With Right Sidebar', 'with_rightsidebar.html.twig', 'with_right_sidebar', 'index'),
(7, 'Audio Posts', 'audio_type.html.twig', 'audio_posts', 'single'),
(8, 'Gallery Post', 'gallery_type.html.twig', 'gallery_post', 'single'),
(9, 'Quote Post', 'quote_type.html.twig', 'quote_post', 'single'),
(10, 'Slideshow Post', 'slideshow_type.html.twig', 'slideshow_post', 'single'),
(11, 'Video Post', 'video_type.html.twig', 'video_post', 'single'),
(12, 'General Post', 'general.html.twig', 'general_post', 'single');