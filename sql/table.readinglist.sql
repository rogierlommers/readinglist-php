--
-- Table structure for table `readinglist`
--

CREATE TABLE IF NOT EXISTS `readinglist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `url` varchar(4000) CHARACTER SET latin1 NOT NULL,
  `host` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1236 ;
