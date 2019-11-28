-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2017 at 10:08 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `requillo_rucomnv`
--

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_intake`
--

CREATE TABLE `rucom54_intake` (
  `id` int(14) NOT NULL,
  `intake_number` int(14) NOT NULL,
  `intake_type` int(5) NOT NULL,
  `intake_brand` int(5) NOT NULL,
  `intake_model` varchar(150) NOT NULL,
  `intake_model_charger` varchar(250) NOT NULL,
  `intake_model_charger_doc` int(250) NOT NULL,
  `client_id` int(14) NOT NULL,
  `problem_text` text,
  `work_solving` text,
  `pub_date` datetime DEFAULT NULL,
  `user_id` int(14) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_intake_brands`
--

CREATE TABLE `rucom54_intake_brands` (
  `id` int(14) NOT NULL,
  `product_brand` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_intake_registered_clients`
--

CREATE TABLE `rucom54_intake_registered_clients` (
  `id` int(14) NOT NULL,
  `f_name` varchar(250) NOT NULL,
  `l_name` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `telephone` varchar(25) NOT NULL,
  `email` varchar(250) NOT NULL,
  `pub_date` datetime DEFAULT NULL,
  `user_id` int(14) NOT NULL,
  `edit_date` datetime DEFAULT NULL,
  `user_id_edit` int(14) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_intake_settings`
--

CREATE TABLE `rucom54_intake_settings` (
  `id` int(14) NOT NULL,
  `meta` varchar(150) NOT NULL,
  `value` text,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rucom54_intake_settings`
--

INSERT INTO `rucom54_intake_settings` (`id`, `meta`, `value`, `status`) VALUES
(11, 'intake_header_text', NULL, 1),
(12, 'start_intake_number', '1500', 1),
(13, 'intake_footer_text', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_intake_test`
--

CREATE TABLE `rucom54_intake_test` (
  `id` int(14) NOT NULL,
  `meta` varchar(150) NOT NULL,
  `value` text,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_intake_types`
--

CREATE TABLE `rucom54_intake_types` (
  `id` int(14) NOT NULL,
  `product_type` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_meta_options`
--

CREATE TABLE `rucom54_meta_options` (
  `id` int(14) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `meta_str` varchar(250) NOT NULL,
  `meta_int` int(14) NOT NULL,
  `meta_text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rucom54_meta_options`
--

INSERT INTO `rucom54_meta_options` (`id`, `name`, `value`, `meta_str`, `meta_int`, `meta_text`) VALUES
(1, 'settings', 'multilang', '0', 1, ''),
(2, 'settings', 'languages', '', 0, '{\"en\":\"en_EN\",\"nl\":\"nl_NL\",\"es\":\"es_ES\"}'),
(3, 'settings', 'default_lang', '{\"en\":\"en_EN\"}', 0, ''),
(4, 'themes', 'admin_theme', 'gents', 0, ''),
(5, 'themes', 'web_theme', 'default', 0, ''),
(7, 'settings', 'app_name', 'Intake Products', 0, ''),
(9, 'admin_pages', '8.0', '', 0, ''),
(10, 'admin_pages', '5.0', '', 0, ''),
(11, 'admin_pages', '1.0', '', 0, ''),
(12, 'settings', 'lang_name', '', 0, '{\"en\":\"English\",\"nl\":\"Nederlands\",\"es\":\"Espanol\"}'),
(13, 'settings', 'timezone', 'America/Argentina/Buenos_Aires', 0, ''),
(14, 'page', 'index', 'welkom-op-onze-website', 8, ''),
(15, 'settings', 'app_logo', '', 0, 'app-logo-1qo2xvp8GdL4lC6kKuwa1505911728.png'),
(16, 'settings', 'app_icon', '', 0, 'app-logo-HcyMtNjFB30J1bdh7L4C1506953355.png');

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_pages`
--

CREATE TABLE `rucom54_pages` (
  `id` int(9) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `parent` int(14) DEFAULT NULL,
  `level` tinyint(3) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `created_user` int(14) NOT NULL,
  `updated_user` int(14) NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rucom54_pages`
--

INSERT INTO `rucom54_pages` (`id`, `title`, `slug`, `content`, `parent`, `level`, `created`, `updated`, `created_user`, `updated_user`, `type`, `status`) VALUES
(5, 'Another test page', 'another-test-page', '<p>dad asdsad sdaadf sdf sdfsdf g d f sgdfweafsd szdf zsdfawef ZSdfzsdfa&nbsp; awfawefzsdf zs zsd dfzgsadfsdfz z sdzfzsdffef sfzsd dfgszfsdfzs sdzfzsdfweaf sdfzg zsdfzsdfza fszdfzsd fwefwaefzsdzsdfwafawefszdfzs fgdfzgz zsdf wezafzsd fzsdfgzwefzsef awef zsdf zaWe fgzsgzsdcfsdfa ssdzfz</p>', NULL, 0, '2017-06-13 10:22:00', '2017-06-13 10:22:00', 1, 1, 'page', 1),
(6, 'Without a Slug', 'without-a-slug', '<p>ad asdasdasfasdf afwefawf awfasdfawefawefsadfasdfa wefawef awdf</p>', NULL, 0, '2017-06-13 10:26:54', '2017-06-13 10:26:54', 1, 1, 'page', 1),
(7, 'With a special slug', 'with-special-slug', '<p>&egrave;&eacute;&Eacute;&Egrave;&Euml;&iuml;</p>', NULL, 0, '2017-06-13 10:27:42', '2017-06-13 10:46:39', 1, 1, 'page', 1),
(8, 'Welkom op onze website', 'welkom-op-onze-website', '<p>Shoeket biedt u het actueel overzicht van Suriname. We halen berichten van bekende nieuws sites zoals Starniews, Suriname Herald, De Ware Tijd, Dagblad Suriname etc.</p>\r\n<p>Voor het volledig lezen van de niews artiekelen wordt u gebracht naar de desbetreffende nieuws site.</p>', NULL, 0, '2017-06-13 14:33:43', '2017-06-13 14:33:43', 1, 1, 'page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_plugins`
--

CREATE TABLE `rucom54_plugins` (
  `id` int(9) NOT NULL,
  `plugin` varchar(150) NOT NULL,
  `level` varchar(255) NOT NULL,
  `relations` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `version` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rucom54_plugins`
--

INSERT INTO `rucom54_plugins` (`id`, `plugin`, `level`, `relations`, `active`, `version`) VALUES
(21, 'intake_clients', '', 'intake_registered_clients,intake,intake_types,intake_brands,intake_settings,intake_test', 1, '1.34');

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_users`
--

CREATE TABLE `rucom54_users` (
  `id` int(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fname` varchar(150) NOT NULL,
  `lname` varchar(150) NOT NULL,
  `salt` varchar(14) NOT NULL,
  `password` varchar(95) NOT NULL,
  `sid` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created` datetime NOT NULL,
  `exp_token` datetime NOT NULL,
  `updated_user` int(14) NOT NULL,
  `updated_date` datetime NOT NULL,
  `keep` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rucom54_users`
--

INSERT INTO `rucom54_users` (`id`, `email`, `fname`, `lname`, `salt`, `password`, `sid`, `username`, `gender`, `status`, `created`, `exp_token`, `updated_user`, `updated_date`, `keep`) VALUES
(1, 'requillo@live.com', 'Requillo', 'Kertoredjo', 'mbyvsitDd0', 'MQSuLGpMGZ3MJL0MTDkBGD_MwHmBJIzLJAxAwqyLGqxZzL0A_L_LmV/ZQxmZwSyZ_R/ZzR0LGOvAGtmAwR3AN', '', 'requillo', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '2017-09-20 11:39:51', 'bfde92518d02d91655fbfaf77957a6c4dacf009701f34d43282cd2162d407f8803551887839d0dad689edca6f711f2d5a7ed371a2166b0bb0b2afdbe'),
(2, 'user@requillo.com', 'Test fsdfdf', 'Users', 'QD*e]iCe91', 'MGAvZGOvZGIvMTD0AmAzZJV1LzSwZGHkAGIyA_SzZJIxLGDlLmqwMGtkLmOvLwp2A_Z_LwOwMJMuZmMvLwMvZ', '', 'user', 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '2017-08-21 10:12:46', 'ad404bb74cef1c63d40f4ba320944aa50fe4e83caba40c541f1a1ecfed0771048b0506b28d042007c4293fab41dea031290b40da85212d4ca9b08749'),
(5, 'email@test.com', 'Test asdasdsa', 'Administrator', 'RCanhi8y9', 'AzLlMzZkZwIxAJDkLmZlZzRlAmyxMQt3MGAyLwZ/Awp_MGHkL_AvLzMvMQD1ZGHlMwV1MwWxLmLkLmZkLGVmLt', '', 'administrator', 1, 1, '2017-04-13 14:28:46', '0000-00-00 00:00:00', 1, '2017-08-17 09:37:39', '499569b958bfef07929d12445678cce082f6369f043f8cce3693a04318b9476087cd04ec9e5dcb2e8f8ba470addcf4728dd71cc207bafe2e9186c4a9'),
(17, 'testmanager@test.com', 'Test', 'Manager', 'xKmJPiKvs6', 'AQpZmOzMTEuZmDkZTD_ZGNMTAxATHmAJIuMTAxZJR2MzD3ZwZ3A_H3ZQEwMwLlZ_ZlAmH_AGN0AGEwZzSyMN', '', 'manager', 1, 1, '2017-04-19 10:06:11', '0000-00-00 00:00:00', 1, '2017-08-08 15:05:59', 'b3331322f91cb198e3f7251bc76f21ee00aff2ecdf49c7e445b847bc40d49cabae06a44bff524577d6115b8731ce50f54c043b68b198b438da046e4e');

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_user_groups`
--

CREATE TABLE `rucom54_user_groups` (
  `id` int(14) NOT NULL,
  `group_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rucom54_user_groups`
--

INSERT INTO `rucom54_user_groups` (`id`, `group_name`) VALUES
(1, 'Rudisa Travel'),
(2, 'Rucom Rudisa'),
(3, 'Rudisa test'),
(4, 'Rudisa back');

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_user_relations`
--

CREATE TABLE `rucom54_user_relations` (
  `id` int(11) NOT NULL,
  `user_id` int(14) NOT NULL,
  `role_level` decimal(3,1) NOT NULL,
  `user_group` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rucom54_user_relations`
--

INSERT INTO `rucom54_user_relations` (`id`, `user_id`, `role_level`, `user_group`) VALUES
(1, 1, '10.0', 2),
(2, 2, '1.0', 0),
(4, 5, '8.0', 0),
(18, 17, '8.0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rucom54_user_roles`
--

CREATE TABLE `rucom54_user_roles` (
  `id` int(11) NOT NULL,
  `role_name` text NOT NULL,
  `role_level` decimal(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rucom54_user_roles`
--

INSERT INTO `rucom54_user_roles` (`id`, `role_name`, `role_level`) VALUES
(1, '[:en]Superhero[:nl]Superheld[:]', '10.0'),
(2, '[:en]Manager[:nl]Manager[:]', '5.0'),
(3, '[:en]User[:nl]Gebruiker[:]', '1.0'),
(4, '[:en]Administrator[:nl]Beheerder[:]', '8.0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rucom54_intake`
--
ALTER TABLE `rucom54_intake`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rucom54_intake_brands`
--
ALTER TABLE `rucom54_intake_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rucom54_intake_registered_clients`
--
ALTER TABLE `rucom54_intake_registered_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rucom54_intake_settings`
--
ALTER TABLE `rucom54_intake_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rucom54_intake_test`
--
ALTER TABLE `rucom54_intake_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rucom54_intake_types`
--
ALTER TABLE `rucom54_intake_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rucom54_meta_options`
--
ALTER TABLE `rucom54_meta_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rucom54_pages`
--
ALTER TABLE `rucom54_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rucom54_plugins`
--
ALTER TABLE `rucom54_plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rucom54_users`
--
ALTER TABLE `rucom54_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `rucom54_user_groups`
--
ALTER TABLE `rucom54_user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rucom54_user_relations`
--
ALTER TABLE `rucom54_user_relations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rucom54_user_roles`
--
ALTER TABLE `rucom54_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_level` (`role_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rucom54_intake`
--
ALTER TABLE `rucom54_intake`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rucom54_intake_brands`
--
ALTER TABLE `rucom54_intake_brands`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rucom54_intake_registered_clients`
--
ALTER TABLE `rucom54_intake_registered_clients`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rucom54_intake_settings`
--
ALTER TABLE `rucom54_intake_settings`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `rucom54_intake_test`
--
ALTER TABLE `rucom54_intake_test`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rucom54_intake_types`
--
ALTER TABLE `rucom54_intake_types`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rucom54_meta_options`
--
ALTER TABLE `rucom54_meta_options`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `rucom54_pages`
--
ALTER TABLE `rucom54_pages`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `rucom54_plugins`
--
ALTER TABLE `rucom54_plugins`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `rucom54_users`
--
ALTER TABLE `rucom54_users`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `rucom54_user_groups`
--
ALTER TABLE `rucom54_user_groups`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rucom54_user_relations`
--
ALTER TABLE `rucom54_user_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `rucom54_user_roles`
--
ALTER TABLE `rucom54_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
