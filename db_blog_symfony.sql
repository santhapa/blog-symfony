-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.27 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table db_blog_symfony.acl_classes
CREATE TABLE IF NOT EXISTS `acl_classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_69DD750638A36066` (`class_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.acl_classes: ~3 rows (approximately)
/*!40000 ALTER TABLE `acl_classes` DISABLE KEYS */;
INSERT INTO `acl_classes` (`id`, `class_type`) VALUES
	(2, 'SpBar\\Bundle\\BlogBundle\\Entity\\Comment'),
	(3, 'SpBar\\Bundle\\BlogBundle\\Entity\\Page'),
	(1, 'SpBar\\Bundle\\BlogBundle\\Entity\\Post');
/*!40000 ALTER TABLE `acl_classes` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.acl_entries
CREATE TABLE IF NOT EXISTS `acl_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(10) unsigned NOT NULL,
  `object_identity_id` int(10) unsigned DEFAULT NULL,
  `security_identity_id` int(10) unsigned NOT NULL,
  `field_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ace_order` smallint(5) unsigned NOT NULL,
  `mask` int(11) NOT NULL,
  `granting` tinyint(1) NOT NULL,
  `granting_strategy` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `audit_success` tinyint(1) NOT NULL,
  `audit_failure` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4` (`class_id`,`object_identity_id`,`field_name`,`ace_order`),
  KEY `IDX_46C8B806EA000B103D9AB4A6DF9183C9` (`class_id`,`object_identity_id`,`security_identity_id`),
  KEY `IDX_46C8B806EA000B10` (`class_id`),
  KEY `IDX_46C8B8063D9AB4A6` (`object_identity_id`),
  KEY `IDX_46C8B806DF9183C9` (`security_identity_id`),
  CONSTRAINT `FK_46C8B8063D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_46C8B806DF9183C9` FOREIGN KEY (`security_identity_id`) REFERENCES `acl_security_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_46C8B806EA000B10` FOREIGN KEY (`class_id`) REFERENCES `acl_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.acl_entries: ~50 rows (approximately)
/*!40000 ALTER TABLE `acl_entries` DISABLE KEYS */;
INSERT INTO `acl_entries` (`id`, `class_id`, `object_identity_id`, `security_identity_id`, `field_name`, `ace_order`, `mask`, `granting`, `granting_strategy`, `audit_success`, `audit_failure`) VALUES
	(1, 1, 1, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(2, 1, 1, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(3, 1, 2, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(4, 1, 2, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(5, 1, 3, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(6, 1, 3, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(7, 2, 4, 1, NULL, 2, 13, 1, 'all', 0, 0),
	(8, 2, 4, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(9, 2, 4, 2, NULL, 0, 64, 1, 'all', 0, 0),
	(10, 2, 5, 1, NULL, 2, 13, 1, 'all', 0, 0),
	(11, 2, 5, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(12, 2, 5, 2, NULL, 0, 64, 1, 'all', 0, 0),
	(13, 2, 6, 1, NULL, 2, 13, 1, 'all', 0, 0),
	(14, 2, 6, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(15, 2, 6, 2, NULL, 0, 64, 1, 'all', 0, 0),
	(16, 2, 7, 1, NULL, 2, 13, 1, 'all', 0, 0),
	(17, 2, 7, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(18, 2, 7, 2, NULL, 0, 64, 1, 'all', 0, 0),
	(19, 1, 8, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(20, 1, 8, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(21, 1, 9, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(22, 1, 9, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(23, 1, 10, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(24, 1, 10, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(25, 1, 11, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(26, 1, 11, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(27, 1, 12, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(28, 1, 12, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(29, 1, 13, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(30, 1, 13, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(31, 1, 14, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(32, 1, 14, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(33, 2, 15, 1, NULL, 2, 13, 1, 'all', 0, 0),
	(34, 2, 15, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(35, 2, 15, 2, NULL, 0, 64, 1, 'all', 0, 0),
	(36, 2, 16, 1, NULL, 2, 13, 1, 'all', 0, 0),
	(37, 2, 16, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(38, 2, 16, 2, NULL, 0, 64, 1, 'all', 0, 0),
	(39, 1, 17, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(40, 1, 17, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(41, 3, 18, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(42, 3, 19, 2, NULL, 0, 128, 1, 'all', 0, 0),
	(43, 2, 20, 1, NULL, 2, 13, 1, 'all', 0, 0),
	(44, 2, 20, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(45, 2, 20, 2, NULL, 0, 64, 1, 'all', 0, 0),
	(46, 2, 21, 1, NULL, 2, 13, 1, 'all', 0, 0),
	(47, 2, 21, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(48, 2, 21, 2, NULL, 0, 64, 1, 'all', 0, 0),
	(49, 1, 22, 1, NULL, 1, 32, 1, 'all', 0, 0),
	(50, 1, 22, 2, NULL, 0, 128, 1, 'all', 0, 0);
/*!40000 ALTER TABLE `acl_entries` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.acl_object_identities
CREATE TABLE IF NOT EXISTS `acl_object_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_object_identity_id` int(10) unsigned DEFAULT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `object_identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entries_inheriting` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9407E5494B12AD6EA000B10` (`object_identifier`,`class_id`),
  KEY `IDX_9407E54977FA751A` (`parent_object_identity_id`),
  CONSTRAINT `FK_9407E54977FA751A` FOREIGN KEY (`parent_object_identity_id`) REFERENCES `acl_object_identities` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.acl_object_identities: ~22 rows (approximately)
/*!40000 ALTER TABLE `acl_object_identities` DISABLE KEYS */;
INSERT INTO `acl_object_identities` (`id`, `parent_object_identity_id`, `class_id`, `object_identifier`, `entries_inheriting`) VALUES
	(1, NULL, 1, '1', 1),
	(2, NULL, 1, '2', 1),
	(3, NULL, 1, '3', 1),
	(4, NULL, 2, '1', 1),
	(5, NULL, 2, '2', 1),
	(6, NULL, 2, '3', 1),
	(7, NULL, 2, '4', 1),
	(8, NULL, 1, '4', 1),
	(9, NULL, 1, '5', 1),
	(10, NULL, 1, '6', 1),
	(11, NULL, 1, '7', 1),
	(12, NULL, 1, '8', 1),
	(13, NULL, 1, '9', 1),
	(14, NULL, 1, '10', 1),
	(15, NULL, 2, '5', 1),
	(16, NULL, 2, '6', 1),
	(17, NULL, 1, '11', 1),
	(18, NULL, 3, '1', 1),
	(19, NULL, 3, '2', 1),
	(20, NULL, 2, '7', 1),
	(21, NULL, 2, '8', 1),
	(22, NULL, 1, '12', 1);
/*!40000 ALTER TABLE `acl_object_identities` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.acl_object_identity_ancestors
CREATE TABLE IF NOT EXISTS `acl_object_identity_ancestors` (
  `object_identity_id` int(10) unsigned NOT NULL,
  `ancestor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`object_identity_id`,`ancestor_id`),
  KEY `IDX_825DE2993D9AB4A6` (`object_identity_id`),
  KEY `IDX_825DE299C671CEA1` (`ancestor_id`),
  CONSTRAINT `FK_825DE2993D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_825DE299C671CEA1` FOREIGN KEY (`ancestor_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.acl_object_identity_ancestors: ~22 rows (approximately)
/*!40000 ALTER TABLE `acl_object_identity_ancestors` DISABLE KEYS */;
INSERT INTO `acl_object_identity_ancestors` (`object_identity_id`, `ancestor_id`) VALUES
	(1, 1),
	(2, 2),
	(3, 3),
	(4, 4),
	(5, 5),
	(6, 6),
	(7, 7),
	(8, 8),
	(9, 9),
	(10, 10),
	(11, 11),
	(12, 12),
	(13, 13),
	(14, 14),
	(15, 15),
	(16, 16),
	(17, 17),
	(18, 18),
	(19, 19),
	(20, 20),
	(21, 21),
	(22, 22);
/*!40000 ALTER TABLE `acl_object_identity_ancestors` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.acl_security_identities
CREATE TABLE IF NOT EXISTS `acl_security_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `username` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8835EE78772E836AF85E0677` (`identifier`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.acl_security_identities: ~2 rows (approximately)
/*!40000 ALTER TABLE `acl_security_identities` DISABLE KEYS */;
INSERT INTO `acl_security_identities` (`id`, `identifier`, `username`) VALUES
	(2, 'ROLE_BLOG_ADMIN', 0),
	(1, 'SpBar\\Bundle\\UserBundle\\Entity\\User-superadmin', 1);
/*!40000 ALTER TABLE `acl_security_identities` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.elfinder_file
CREATE TABLE IF NOT EXISTS `elfinder_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longblob NOT NULL,
  `size` int(11) NOT NULL,
  `mtime` int(11) NOT NULL,
  `mime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `read` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `write` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locked` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hidden` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_name` (`parent_id`,`name`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.elfinder_file: ~1 rows (approximately)
/*!40000 ALTER TABLE `elfinder_file` DISABLE KEYS */;
INSERT INTO `elfinder_file` (`id`, `parent_id`, `name`, `content`, `size`, `mtime`, `mime`, `read`, `write`, `locked`, `hidden`, `width`, `height`) VALUES
	(1, 0, 'DATABASE', _binary '', 0, 0, 'directory', '1', '1', '0', '0', 0, 0);
/*!40000 ALTER TABLE `elfinder_file` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_blog_category
CREATE TABLE IF NOT EXISTS `spbar_blog_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5A28CE55989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_blog_category: ~5 rows (approximately)
/*!40000 ALTER TABLE `spbar_blog_category` DISABLE KEYS */;
INSERT INTO `spbar_blog_category` (`id`, `name`, `slug`) VALUES
	(1, 'Uncategorized', 'uncategorized'),
	(2, 'Audio', 'audio'),
	(3, 'Video', 'video'),
	(4, 'Blog', 'blog'),
	(5, 'Gallery', 'gallery');
/*!40000 ALTER TABLE `spbar_blog_category` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_blog_config
CREATE TABLE IF NOT EXISTS `spbar_blog_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_64C87A9D989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_blog_config: ~2 rows (approximately)
/*!40000 ALTER TABLE `spbar_blog_config` DISABLE KEYS */;
INSERT INTO `spbar_blog_config` (`id`, `name`, `content`, `slug`, `default_status`) VALUES
	(1, 'Post per page', '3', 'post_per_page', 1),
	(2, 'Blog Index Template', 'with_rightsidebar.html.twig', 'blog_index_template', 1);
/*!40000 ALTER TABLE `spbar_blog_config` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_blog_page
CREATE TABLE IF NOT EXISTS `spbar_blog_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `template` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B4757EC989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_blog_page: ~2 rows (approximately)
/*!40000 ALTER TABLE `spbar_blog_page` DISABLE KEYS */;
INSERT INTO `spbar_blog_page` (`id`, `title`, `content`, `template`, `created_at`, `status`, `slug`, `featured_image`) VALUES
	(1, 'About', '<h2>General Introduction</h2>\r\n\r\n<p>This is testing about and I am happy to tell you that you are awesome.</p>', 'rightsidebar', '2015-06-05 22:09:51', 1, 'about', 'http://localhost/blog/web/uploads/meta/image/img.jpg'),
	(2, 'Contacts', '<div class="row">\r\n<div class="col-sm-8">\r\n<h2>Contact Form</h2>\r\n\r\n<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit ani m id est laborum.</p>\r\n\r\n<div class="space20">&nbsp;</div>\r\n\r\n<form action="http://webredox.com/demo/html/betadesign/contact-form-handler.php" method="post">\r\n<div class="form-block"><input name="name" type="text" /></div>\r\n\r\n<div class="form-block"><input name="email" type="email" /></div>\r\n\r\n<div class="form-block"><input name="your-subject" type="text" /></div>\r\n\r\n<div class="form-block"><textarea name="message"></textarea></div>\r\n\r\n<div class="form-block">Send Message</div>\r\n</form>\r\n</div>\r\n\r\n<div class="col-sm-4">\r\n<h2>Contact Information</h2>\r\n\r\n<div class="space20">&nbsp;</div>\r\n\r\n<h6>Address</h6>\r\n\r\n<p>Suite 127 / 267 &ndash; 277 Brussel St,<br />\r\n62 Croydon, NYC<br />\r\nNewyork</p>\r\n\r\n<div class="space20">&nbsp;</div>\r\n\r\n<h6>Business Enquiries</h6>\r\n\r\n<p>Doloremque laudantium, totam rem aperiam,<br />\r\ninventore veritatio beatae.<br />\r\n<a href="mailto:biz@betadesign.com">biz@betadesign.com</a></p>\r\n\r\n<div class="space20">&nbsp;</div>\r\n\r\n<h6>Employment</h6>\r\n\r\n<p>We&rsquo;re always looking for talented persons to<br />\r\njoin our team.<br />\r\n<a href="http://www.webredox.com/demo/html/betadesign/hrbetadesign.com">hr@betadesign.com</a></p>\r\n</div>\r\n</div>', 'fullwidth', '2015-06-05 22:17:22', 1, 'contacts', 'http://localhost/blog/web/uploads/meta/image/img1.jpg');
/*!40000 ALTER TABLE `spbar_blog_page` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_blog_posts
CREATE TABLE IF NOT EXISTS `spbar_blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postType_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1A907980989D9B62` (`slug`),
  KEY `IDX_1A907980C3E0B6E9` (`postType_id`),
  KEY `IDX_1A907980F675F31B` (`author_id`),
  KEY `author_id` (`author_id`),
  KEY `author_id_2` (`author_id`),
  CONSTRAINT `FK_1A907980C3E0B6E9` FOREIGN KEY (`postType_id`) REFERENCES `spbar_blog_template` (`id`),
  CONSTRAINT `FK_1A907980F675F31B` FOREIGN KEY (`author_id`) REFERENCES `spbar_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_blog_posts: ~8 rows (approximately)
/*!40000 ALTER TABLE `spbar_blog_posts` DISABLE KEYS */;
INSERT INTO `spbar_blog_posts` (`id`, `author_id`, `title`, `content`, `created_at`, `status`, `slug`, `postType_id`) VALUES
	(2, 1, 'A ‘Fireplace’ for Private Jets', '<p>It&rsquo;s hard up there for a private jet owner.</p>\r\n\r\n<p>Sure, having your own airplane means you&rsquo;ve got cash to burn, can skip over those horrible TSA security checkpoints, and don&rsquo;t need to deal with a layover in Atlanta to get anywhere. And no one&rsquo;s going to lose or rifle through your baggage.</p>\r\n\r\n<p>Having a private jet is largely about having it all, so limitations are not welcome. That makes the safety regulations that ban working fireplaces on aircraft a real problem. Thankfully, Lufthansa Technik&mdash;the aircraft services division of the German airline&mdash;has created a &ldquo;Fireless Fireplace&rdquo; to make business jets feel as cozy as a living room on the ground.</p>\r\n\r\n<p>It combines an illuminated water mist with an illuminated imitation of burning wood to create what Lufthansa calls a &ldquo;very realistic 3-D impression of a real fire.&rdquo; The faux flame is cold, but heat and sound are real and adjustable by remote control. Naturally, the design can be adapted to fit the customer&rsquo;s taste. It weighs 66 pounds, consumes up to 1,300 watts, and meets all relevant regulations.</p>\r\n\r\n<p>So as you watch the outside temperature plunge well below freezing, listen to the crackling logs, feel the heat, and let yourself believe.</p>', '2015-05-20 13:36:25', 1, 'a_fireplace_for_private_jets', 7),
	(3, 1, 'Self-Published E-Book Review: Frolic in Conservative Utopia', '<p>Some books come to us when they&rsquo;re needed most. For reasons which are probably (if not profoundly) wrong, I&rsquo;d like to suggest Crisis on Terra-Bravo is one of them.</p>\r\n\r\n<p>Technically, it actually came to us a bit too soon. Back in August 2013, the father-son writing team of Jeffrey and K. M. Fortney self-published what appears to be their first e-book, Foothold on Terra-Bravo. &ldquo;One of the first things I learned,&rdquo; the elder Fortney later wrote, &ldquo;is that we&rsquo;d better have something ready for the readers if it turned out to be a hit.&rdquo; It&rsquo;s unclear whether Fortney believed this ever actually happened. The bar for &ldquo;hit&rdquo; status being considerably lower in self-publishing&mdash;let&rsquo;s call it nearish ground level&mdash;it&rsquo;s perfectly plausible that Foothold&rsquo;s four exceptionally so-so customer reviews on Amazon (&ldquo;not bad,&rdquo; &ldquo;reminds me a bit of a canceled TV series&rdquo;) qualified it as an instant classic. In any case, the Fortneys immediately got to work on a sequel, and Crisis on Terra-Bravo came out in December that same year.</p>\r\n\r\n<p>The sequel didn&rsquo;t fare as well in the reviews. Or review, singular, as there&rsquo;s only one on Amazon. But it is the superior title&mdash;and not just because I find the word &ldquo;foothold&rdquo; repulsive. No, Crisis on Terra-Bravo is the better book because it speaks to our present fears and failings in a very particular and unique way.</p>\r\n\r\n<p>Perhaps sensing its moment, Crisis resurfaced earlier this year on Kindle Cover Disasters, the Tumblr from which I select the e-books to review for this column. In need of some pure, relevant sci-fi after enduring genocidal lizard-men and Russian werewolves with tender lips, I knew the time for Crisis was now.</p>\r\n\r\n<p>I wasn&rsquo;t wrong. Two pages of prologue in, the authors give us this: &ldquo;By 2018, the growing Islamist Global Caliphate movement consumed the Middle East, Africa, Southeast Asia, and toppled many Western European nations.&rdquo; In other words, a month before President Obama referred to ISIS as the &ldquo;J.V. team,&rdquo; Jeffrey and K. M. Fortney self-published an e-book predicting the takeover of the planet by a worldwide caliphate. Yes, this was going to be a work of sci-fi that, in the genre&rsquo;s grand (some say largely abandoned) tradition, would engage with the present moment.</p>\r\n\r\n<p>But it&rsquo;s not the Islamists the Fortneys blame for the end of the world. Or not just the Islamists. It&rsquo;s&mdash;well, let&rsquo;s visit Terra-Bravo first.</p>', '2015-05-20 13:37:24', 1, 'self_published_e_book_review_frolic_in_conservative_utopia', 7),
	(4, 1, 'Bipul Chettri - Asar', '<p>Enjoy thte song by <em>Bipul Chettri</em> from <strong><em>Sketches of Darjeling</em></strong>.</p>', '2015-06-01 13:16:30', 1, 'bipul_chettri_asar', 8),
	(5, 1, 'Christmas Short Film', '<p>This was filmed by the team Youth Circle for the Christmas.</p>', '2015-06-01 13:18:27', 1, 'christmas_short_film', 9),
	(8, 1, 'Change post', '<p>Hello gallery</p>', '2015-06-03 22:48:36', 1, 'gallery_post', 7),
	(10, 1, 'Happy Fun', '<p>I am happy fun</p>', '2015-06-03 23:59:58', 1, 'happy_fun', 7),
	(11, 4, 'Testing 101', '<p>Hello testing 101</p>', '2015-06-05 16:13:20', 1, 'testing_101', 7),
	(12, 1, 'Testing slug', '<p>dsasdgds</p>', '2015-07-14 10:58:26', 1, 'testing_slug_1', 7);
/*!40000 ALTER TABLE `spbar_blog_posts` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_blog_posts_meta
CREATE TABLE IF NOT EXISTS `spbar_blog_posts_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_blog_posts_meta: ~8 rows (approximately)
/*!40000 ALTER TABLE `spbar_blog_posts_meta` DISABLE KEYS */;
INSERT INTO `spbar_blog_posts_meta` (`id`, `source`) VALUES
	(1, 'http://localhost/blog/web/uploads/meta/image/image.jpeg'),
	(2, 'http://localhost/blog/web/uploads/meta/image/Hotel_Exterior_at_Dusk_-_EXT_03_high_res.jpg'),
	(3, 'http://localhost/blog/web/uploads/meta/image/images.jpeg'),
	(4, 'http://localhost/blog/web/uploads/meta/audio/03%20Assar.mp3'),
	(5, 'http://localhost/blog/web/uploads/meta/video/Yeshulai%20Upahar%20-%20720p.mp4'),
	(6, 'http://localhost/blog/web/uploads/meta/image/image.jpeg,http://localhost/blog/web/uploads/meta/image/images.jpeg,http://localhost/blog/web/uploads/meta/image/img.jpg'),
	(7, 'http://localhost/blog/web/uploads/meta/image/img.jpg'),
	(8, 'http://localhost/blog/web/uploads/meta/image/img1.jpg');
/*!40000 ALTER TABLE `spbar_blog_posts_meta` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_blog_post_comments
CREATE TABLE IF NOT EXISTS `spbar_blog_post_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `comment_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_26A66EDF727ACA70` (`parent_id`),
  KEY `IDX_26A66EDF4B89032C` (`post_id`),
  KEY `IDX_26A66EDFA76ED395` (`user_id`),
  CONSTRAINT `FK_26A66EDF4B89032C` FOREIGN KEY (`post_id`) REFERENCES `spbar_blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_26A66EDF727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `spbar_blog_post_comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_26A66EDFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `spbar_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_blog_post_comments: ~7 rows (approximately)
/*!40000 ALTER TABLE `spbar_blog_post_comments` DISABLE KEYS */;
INSERT INTO `spbar_blog_post_comments` (`id`, `parent_id`, `post_id`, `user_id`, `content`, `comment_at`) VALUES
	(1, NULL, 3, 1, 'test', '2015-05-25 10:19:06'),
	(2, NULL, 3, 1, 'hello', '2015-06-01 12:37:08'),
	(3, 1, 3, 1, 'whats up', '2015-06-01 12:37:26'),
	(5, NULL, 10, 1, 'hi', '2015-06-04 00:21:18'),
	(6, 5, 10, 1, 'thanks man', '2015-06-04 00:21:37'),
	(7, 8, 11, 1, 'hello hi good', '2015-06-08 12:09:49'),
	(8, 7, 11, 1, 'good job', '2015-06-08 12:10:35');
/*!40000 ALTER TABLE `spbar_blog_post_comments` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_blog_post_tag
CREATE TABLE IF NOT EXISTS `spbar_blog_post_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_blog_post_tag: ~5 rows (approximately)
/*!40000 ALTER TABLE `spbar_blog_post_tag` DISABLE KEYS */;
INSERT INTO `spbar_blog_post_tag` (`id`, `name`) VALUES
	(1, 'yahoo'),
	(2, 'netflix'),
	(3, 'resistance'),
	(4, 'jets'),
	(5, 'private');
/*!40000 ALTER TABLE `spbar_blog_post_tag` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_blog_template
CREATE TABLE IF NOT EXISTS `spbar_blog_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_file` longtext COLLATE utf8_unicode_ci NOT NULL,
  `type` longtext COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5B82472989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_blog_template: ~9 rows (approximately)
/*!40000 ALTER TABLE `spbar_blog_template` DISABLE KEYS */;
INSERT INTO `spbar_blog_template` (`id`, `name`, `template_file`, `type`, `slug`) VALUES
	(1, 'Fullwidth Single Column', 'fullwidth_1col.html.twig', 'index', 'fullwidth_single_column'),
	(2, 'Fullwidth Two Column', 'fullwidth_2col.html.twig', 'index', 'fullwidth_two_column'),
	(3, 'Fullwidth Three Column', 'fullwidth_3col.html.twig', 'index', 'fullwidth_three_column'),
	(5, 'With Left Sidebar', 'with_leftsidebar.html.twig', 'index', 'with_left_sidebar'),
	(6, 'With Right Sidebar', 'with_rightsidebar.html.twig', 'index', 'with_right_sidebar'),
	(7, 'General', 'post-general.html.twig', 'postType', 'general'),
	(8, 'Audio', 'post-audio.html.twig', 'postType', 'audio'),
	(9, 'Video', 'post-video.html.twig', 'postType', 'video'),
	(10, 'Gallery', 'post-gallery.html.twig', 'postType', 'gallery');
/*!40000 ALTER TABLE `spbar_blog_template` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_groups
CREATE TABLE IF NOT EXISTS `spbar_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_326E11525E237E06` (`name`),
  UNIQUE KEY `UNIQ_326E1152989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_groups: ~5 rows (approximately)
/*!40000 ALTER TABLE `spbar_groups` DISABLE KEYS */;
INSERT INTO `spbar_groups` (`id`, `name`, `roles`, `slug`) VALUES
	(1, 'Super Admin', 'a:0:{}', 'super_admin'),
	(2, 'Blog Admin', 'a:0:{}', 'blog_admin'),
	(3, 'Blog User', 'a:0:{}', 'blog_user'),
	(4, 'Blog Author', 'a:0:{}', 'blog_author'),
	(5, 'General User', 'a:0:{}', 'general_user');
/*!40000 ALTER TABLE `spbar_groups` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_menu
CREATE TABLE IF NOT EXISTS `spbar_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `menu_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `menu_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6248DB5F727ACA70` (`parent_id`),
  CONSTRAINT `FK_6248DB5F727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `spbar_menu` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_menu: ~4 rows (approximately)
/*!40000 ALTER TABLE `spbar_menu` DISABLE KEYS */;
INSERT INTO `spbar_menu` (`id`, `name`, `url`, `parent_id`, `menu_type`, `menu_order`) VALUES
	(1, 'Home', '/homea', NULL, 'custom', NULL),
	(2, 'Contact', '/contact', 4, 'custom', NULL),
	(3, 'Page', '/page', NULL, 'page', NULL),
	(4, 'Single', '/page/single', 3, 'single', NULL);
/*!40000 ALTER TABLE `spbar_menu` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_posts_meta
CREATE TABLE IF NOT EXISTS `spbar_posts_meta` (
  `post_id` int(11) NOT NULL,
  `postmeta_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`postmeta_id`),
  KEY `IDX_F80AD3E4B89032C` (`post_id`),
  KEY `IDX_F80AD3EF0EDA51F` (`postmeta_id`),
  CONSTRAINT `FK_F80AD3E4B89032C` FOREIGN KEY (`post_id`) REFERENCES `spbar_blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_F80AD3EF0EDA51F` FOREIGN KEY (`postmeta_id`) REFERENCES `spbar_blog_posts_meta` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_posts_meta: ~7 rows (approximately)
/*!40000 ALTER TABLE `spbar_posts_meta` DISABLE KEYS */;
INSERT INTO `spbar_posts_meta` (`post_id`, `postmeta_id`) VALUES
	(2, 2),
	(3, 3),
	(4, 4),
	(5, 5),
	(8, 3),
	(10, 7),
	(11, 2);
/*!40000 ALTER TABLE `spbar_posts_meta` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_posts_tag
CREATE TABLE IF NOT EXISTS `spbar_posts_tag` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `IDX_7C1B662B4B89032C` (`post_id`),
  KEY `IDX_7C1B662BBAD26311` (`tag_id`),
  CONSTRAINT `FK_7C1B662B4B89032C` FOREIGN KEY (`post_id`) REFERENCES `spbar_blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_7C1B662BBAD26311` FOREIGN KEY (`tag_id`) REFERENCES `spbar_blog_post_tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_posts_tag: ~2 rows (approximately)
/*!40000 ALTER TABLE `spbar_posts_tag` DISABLE KEYS */;
INSERT INTO `spbar_posts_tag` (`post_id`, `tag_id`) VALUES
	(2, 4),
	(2, 5);
/*!40000 ALTER TABLE `spbar_posts_tag` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_post_category
CREATE TABLE IF NOT EXISTS `spbar_post_category` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`),
  KEY `IDX_919863D34B89032C` (`post_id`),
  KEY `IDX_919863D312469DE2` (`category_id`),
  CONSTRAINT `FK_919863D312469DE2` FOREIGN KEY (`category_id`) REFERENCES `spbar_blog_category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_919863D34B89032C` FOREIGN KEY (`post_id`) REFERENCES `spbar_blog_posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_post_category: ~8 rows (approximately)
/*!40000 ALTER TABLE `spbar_post_category` DISABLE KEYS */;
INSERT INTO `spbar_post_category` (`post_id`, `category_id`) VALUES
	(2, 4),
	(3, 4),
	(4, 2),
	(5, 3),
	(8, 5),
	(10, 4),
	(11, 4),
	(12, 1);
/*!40000 ALTER TABLE `spbar_post_category` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_users
CREATE TABLE IF NOT EXISTS `spbar_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `firstname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `biography` tinytext COLLATE utf8_unicode_ci,
  `website` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gplus_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C054205592FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_C0542055A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_users: ~2 rows (approximately)
/*!40000 ALTER TABLE `spbar_users` DISABLE KEYS */;
INSERT INTO `spbar_users` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `created_at`, `firstname`, `lastname`, `date_of_birth`, `gender`, `phone_number`, `mobile_number`, `address`, `biography`, `website`, `facebook_id`, `gplus_id`, `twitter_id`, `image`) VALUES
	(1, 'superadmin', 'superadmin', 'superadmin@gmail.com', 'superadmin@gmail.com', 1, 'ohyime1gxpw80k08ogg08wssgk84wsc', 'NYmlcenoCgqaIyNR37OGs0g5QXfQVyI7lh1gRzToCsPTWRPCWlvBqP6GbnVzY3pt3cxe1MFP0mJPtIaR+Hi4bg==', '2015-08-03 08:45:21', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, '2015-05-19 11:31:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd86b80974041f6db84f076ceb6eb80008af2523c.jpeg'),
	(4, 'san', 'san', 'san@gmail.com', 'san@gmail.com', 1, 'sh5h4amyac0cc440sssgwg0c84gwc8o', 'GQeLvHF5SsgRLGM1gZOW0pypOhphLqWXBgXtsGeelpRDpYVEBzispaCIF3HhcrUW8pVtqQs4J20pmhwv0RP0BQ==', '2015-06-01 17:03:54', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:17:"ROLE_GENERAL_USER";}', 0, NULL, '2015-06-01 17:03:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `spbar_users` ENABLE KEYS */;


-- Dumping structure for table db_blog_symfony.spbar_user_group
CREATE TABLE IF NOT EXISTS `spbar_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `IDX_ED203F2FA76ED395` (`user_id`),
  KEY `IDX_ED203F2FFE54D947` (`group_id`),
  CONSTRAINT `FK_ED203F2FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `spbar_users` (`id`),
  CONSTRAINT `FK_ED203F2FFE54D947` FOREIGN KEY (`group_id`) REFERENCES `spbar_groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_blog_symfony.spbar_user_group: ~1 rows (approximately)
/*!40000 ALTER TABLE `spbar_user_group` DISABLE KEYS */;
INSERT INTO `spbar_user_group` (`user_id`, `group_id`) VALUES
	(1, 1);
/*!40000 ALTER TABLE `spbar_user_group` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
