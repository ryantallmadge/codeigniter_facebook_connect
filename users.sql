--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_fullname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_image` text COLLATE utf8_unicode_ci NOT NULL,
  `user_displayname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_login_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_date` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

