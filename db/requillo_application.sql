-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2018 at 04:57 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `requillo_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `m9c_donations`
--

CREATE TABLE IF NOT EXISTS `m9c_donations` (
  `id` int(14) NOT NULL,
  `person_id` varchar(250) NOT NULL,
  `foundation_id` varchar(250) NOT NULL,
  `title` varchar(350) NOT NULL,
  `description` text NOT NULL,
  `extra_description` text NOT NULL,
  `cash_description` text NOT NULL,
  `cash_amount` varchar(25) NOT NULL,
  `currency` tinyint(1) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `approval` tinyint(1) NOT NULL,
  `reason` text NOT NULL,
  `donation_within` tinyint(2) NOT NULL,
  `donated_company` int(14) NOT NULL,
  `donation_type` tinyint(2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_user` int(14) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_user` int(14) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_donations`
--

INSERT INTO `m9c_donations` (`id`, `person_id`, `foundation_id`, `title`, `description`, `extra_description`, `cash_description`, `cash_amount`, `currency`, `amount`, `approval`, `reason`, `donation_within`, `donated_company`, `donation_type`, `created`, `created_user`, `updated`, `updated_user`, `status`) VALUES
(1, '1', '1', 'Test Donation title', 'sdgs dfgsdfg sdfgsdfg sdfg', '', 'sdfg sdfgsdfgdfgsdfgsdfg', '4500', 0, '4500', 1, '', 0, 0, 0, '2018-01-25 23:55:52', 1, NULL, 0, 1),
(2, '1', '1', 'Test Donation title', 'sdgs dfgsdfg sdfgsdfg sdfg', '', 'sdfg sdfgsdfgdfgsdfgsdfg', '4500', 0, '4500', 1, '', 0, 0, 0, '2018-01-25 23:55:53', 1, NULL, 0, 1),
(3, '1', '1', 'Test Donation title', 'sdgs dfgsdfg sdfgsdfg sdfg', '', 'sdfg sdfgsdfgdfgsdfgsdfg', '4500', 0, '4500', 1, '', 0, 0, 0, '2018-01-25 23:55:54', 1, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m9c_donation_assets`
--

CREATE TABLE IF NOT EXISTS `m9c_donation_assets` (
  `id` int(14) NOT NULL,
  `type` int(5) NOT NULL,
  `company_id` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `price` varchar(300) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_user` int(14) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_user` int(14) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_donation_assets`
--

INSERT INTO `m9c_donation_assets` (`id`, `type`, `company_id`, `description`, `price`, `created`, `created_user`, `updated`, `updated_user`, `status`) VALUES
(1, 2, '1', 'Windows install', '120', '2018-01-25 21:24:43', 1, NULL, 0, 1),
(2, 2, '1', 'Microsoft office', '80', '2018-01-25 21:25:08', 1, NULL, 0, 1),
(3, 3, '1', 'Pc service per uur', '50', '2018-01-25 21:25:31', 1, NULL, 0, 1),
(4, 3, '1', 'Web update per uur', '80', '2018-01-25 21:25:47', 1, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m9c_donation_documents`
--

CREATE TABLE IF NOT EXISTS `m9c_donation_documents` (
  `id` int(14) NOT NULL,
  `donation_id` varchar(250) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_user` int(14) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_user` int(14) NOT NULL,
  `document` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m9c_donation_foundation`
--

CREATE TABLE IF NOT EXISTS `m9c_donation_foundation` (
  `id` int(14) NOT NULL,
  `foundation_name` varchar(250) NOT NULL,
  `foundation_address` varchar(250) NOT NULL,
  `foundation_telephone` varchar(300) NOT NULL,
  `foundation_email` varchar(250) NOT NULL,
  `same` varchar(300) NOT NULL,
  `overwrite_same` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_user` int(14) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_user` int(14) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_donation_foundation`
--

INSERT INTO `m9c_donation_foundation` (`id`, `foundation_name`, `foundation_address`, `foundation_telephone`, `foundation_email`, `same`, `overwrite_same`, `created`, `created_user`, `updated`, `updated_user`, `status`) VALUES
(1, 'REQUILLO FOUNDATION', 'Test Adres 254', '8793226', 'info@requillo.com', '', 0, '2018-01-25 21:26:56', 1, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m9c_donation_history`
--

CREATE TABLE IF NOT EXISTS `m9c_donation_history` (
  `id` int(14) NOT NULL,
  `donation_table` varchar(250) NOT NULL,
  `donation_old_data` text NOT NULL,
  `donation_new_data` text NOT NULL,
  `donation_info` varchar(250) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_user` int(14) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m9c_donation_persons`
--

CREATE TABLE IF NOT EXISTS `m9c_donation_persons` (
  `id` int(14) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `person_address` varchar(300) NOT NULL,
  `person_telephone` varchar(250) NOT NULL,
  `person_email` varchar(250) NOT NULL,
  `id_number` varchar(250) NOT NULL,
  `same` varchar(300) NOT NULL,
  `overwrite_same` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_user` int(14) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_user` int(14) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_donation_persons`
--

INSERT INTO `m9c_donation_persons` (`id`, `first_name`, `last_name`, `person_address`, `person_telephone`, `person_email`, `id_number`, `same`, `overwrite_same`, `created`, `created_user`, `updated`, `updated_user`, `status`) VALUES
(1, 'Requillo', 'Kertoredjo', 'Fajalobilaan 13', '8793226', '', 'ez42159m', '', 0, '2018-01-25 21:26:55', 1, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m9c_donation_person_foundation_relations`
--

CREATE TABLE IF NOT EXISTS `m9c_donation_person_foundation_relations` (
  `id` int(14) NOT NULL,
  `person_id` int(14) NOT NULL,
  `foundation_id` int(14) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_user` int(14) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_user` int(14) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_donation_person_foundation_relations`
--

INSERT INTO `m9c_donation_person_foundation_relations` (`id`, `person_id`, `foundation_id`, `created`, `created_user`, `updated`, `updated_user`, `status`) VALUES
(1, 1, 1, '2018-01-25 21:39:05', 1, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m9c_donation_settings`
--

CREATE TABLE IF NOT EXISTS `m9c_donation_settings` (
  `id` int(14) NOT NULL,
  `meta` varchar(250) NOT NULL,
  `value` varchar(250) NOT NULL,
  `description` varchar(450) NOT NULL,
  `type` varchar(300) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_user` int(14) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_user` int(14) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_donation_settings`
--

INSERT INTO `m9c_donation_settings` (`id`, `meta`, `value`, `description`, `type`, `created`, `created_user`, `updated`, `updated_user`, `status`) VALUES
(1, 'max_amount', '5000', 'Max amount for standard approval in SRD', 'number', NULL, 0, NULL, 0, 1),
(2, 'donation_types', 'Cash = 1, Products = 2, Services = 3', 'Add types like: Cash = 1, Products = 2, Services = 3', 'text', NULL, 0, NULL, 0, 1),
(3, 'sent_mail', 'noreply@thisapp.com', 'E-mail address to sent mail from', 'text', NULL, 0, NULL, 0, 1),
(4, 'sent_mail_password', 'P@$w0orD', 'E-mail address password for sent mail', 'text', NULL, 0, NULL, 0, 1),
(5, 'approval email account', '', 'HI approval e-mail accounts like: ceo@thisapp.com;manager@thisapp.com;finance@thisapp.com', 'text', NULL, 0, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m9c_meta_options`
--

CREATE TABLE IF NOT EXISTS `m9c_meta_options` (
  `id` int(14) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `meta_str` varchar(250) NOT NULL,
  `meta_int` int(14) NOT NULL,
  `meta_text` text
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_meta_options`
--

INSERT INTO `m9c_meta_options` (`id`, `name`, `value`, `meta_str`, `meta_int`, `meta_text`) VALUES
(1, 'settings', 'multilang', '', 1, ''),
(2, 'settings', 'languages', '', 0, '{"en":"en_EN","nl":"nl_NL","es":"es_ES"}'),
(3, 'settings', 'default_lang', '{"en":"en_EN"}', 0, ''),
(4, 'settings', 'app_name', 'Requillo Application', 0, ''),
(5, 'settings', 'lang_name', '', 0, '{"en":"English","nl":"Nederlands","es":"Espanol"}'),
(6, 'settings', 'timezone', 'America/Argentina/Buenos_Aires', 0, ''),
(7, 'settings', 'app_logo', '', 0, 'app-logo-hEjLJFOkuAqBPMtIx2ya1516922473.png'),
(8, 'settings', 'app_icon', '', 0, 'app-logo-nsvgqpP09cAja1Mdb8Ol1516922473.png'),
(9, 'themes', 'admin_theme', 'gents', 0, ''),
(10, 'themes', 'web_theme', 'default', 0, ''),
(11, 'page', 'index', '', 0, ''),
(12, 'admin_pages', '8.0', '', 0, ''),
(13, 'admin_pages', '5.0', '', 0, ''),
(14, 'admin_pages', '1.0', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `m9c_pages`
--

CREATE TABLE IF NOT EXISTS `m9c_pages` (
  `id` int(14) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text,
  `parent` int(8) NOT NULL,
  `level` tinyint(3) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_user` int(14) NOT NULL,
  `updated_user` int(14) NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m9c_plugins`
--

CREATE TABLE IF NOT EXISTS `m9c_plugins` (
  `id` int(14) NOT NULL,
  `plugin` varchar(150) NOT NULL,
  `level` varchar(255) NOT NULL,
  `relations` varchar(255) NOT NULL,
  `active` tinyint(150) NOT NULL,
  `version` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_plugins`
--

INSERT INTO `m9c_plugins` (`id`, `plugin`, `level`, `relations`, `active`, `version`) VALUES
(3, 'donations', '', 'donations,donation_persons,donation_foundation,donation_person_foundation_relations,donation_assets,donation_documents,donation_history,donation_settings', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `m9c_users`
--

CREATE TABLE IF NOT EXISTS `m9c_users` (
  `id` int(14) NOT NULL,
  `email` varchar(150) NOT NULL,
  `fname` varchar(150) NOT NULL,
  `lname` varchar(150) NOT NULL,
  `salt` varchar(14) NOT NULL,
  `password` varchar(95) NOT NULL,
  `sid` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `exp_token` datetime DEFAULT NULL,
  `updated_user` int(14) NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `keep` varchar(120) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_users`
--

INSERT INTO `m9c_users` (`id`, `email`, `fname`, `lname`, `salt`, `password`, `sid`, `username`, `gender`, `status`, `created`, `exp_token`, `updated_user`, `updated_date`, `keep`) VALUES
(1, '', 'Requillo', 'Kertoredjo', 'R8rWhiGY7&', 'ZGqzZwD0MzSwZwH0Z_Z_LwOuMQZZwx_L_WzMGH2AmOuAQRlZmZ3AGHmMGqyZTZAmRmZzZ_MJHkLGWvBGDmZt', '', 'requillo', 0, 1, '2018-01-25 20:06:49', NULL, 1, '2018-01-25 20:28:58', '');

-- --------------------------------------------------------

--
-- Table structure for table `m9c_user_company`
--

CREATE TABLE IF NOT EXISTS `m9c_user_company` (
  `id` int(14) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_telephone` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_user_company`
--

INSERT INTO `m9c_user_company` (`id`, `company_name`, `company_address`, `company_telephone`) VALUES
(1, 'Rucom IT Solustions N.V.', 'Tweekinderenweg', '88578959'),
(2, 'Times of Suriname', 'Tweekinderenweg 54', '75487521'),
(3, 'Rudisa Motors Company N.V.', 'Hofstede Crull''laan', '458978');

-- --------------------------------------------------------

--
-- Table structure for table `m9c_user_groups`
--

CREATE TABLE IF NOT EXISTS `m9c_user_groups` (
  `id` int(14) NOT NULL,
  `group_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m9c_user_relations`
--

CREATE TABLE IF NOT EXISTS `m9c_user_relations` (
  `id` int(14) NOT NULL,
  `user_id` int(14) NOT NULL,
  `role_level` decimal(3,1) NOT NULL,
  `user_group` int(14) NOT NULL,
  `user_company` int(14) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_user_relations`
--

INSERT INTO `m9c_user_relations` (`id`, `user_id`, `role_level`, `user_group`, `user_company`) VALUES
(1, 1, '10.0', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m9c_user_roles`
--

CREATE TABLE IF NOT EXISTS `m9c_user_roles` (
  `id` int(14) NOT NULL,
  `role_name` text,
  `role_level` decimal(3,1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m9c_user_roles`
--

INSERT INTO `m9c_user_roles` (`id`, `role_name`, `role_level`) VALUES
(1, '[:en]Superhero[:nl]Superheld[:]', '10.0'),
(2, '[:en]Administrator[:nl]Beheerder[:]', '8.0'),
(3, '[:en]Manager[:nl]Manager[:]', '5.0'),
(4, '[:en]User[:nl]Gebruiker[:]', '1.0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m9c_donations`
--
ALTER TABLE `m9c_donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_donation_assets`
--
ALTER TABLE `m9c_donation_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_donation_documents`
--
ALTER TABLE `m9c_donation_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_donation_foundation`
--
ALTER TABLE `m9c_donation_foundation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_donation_history`
--
ALTER TABLE `m9c_donation_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_donation_persons`
--
ALTER TABLE `m9c_donation_persons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_donation_person_foundation_relations`
--
ALTER TABLE `m9c_donation_person_foundation_relations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_donation_settings`
--
ALTER TABLE `m9c_donation_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_meta_options`
--
ALTER TABLE `m9c_meta_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_pages`
--
ALTER TABLE `m9c_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_plugins`
--
ALTER TABLE `m9c_plugins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plugin` (`plugin`);

--
-- Indexes for table `m9c_users`
--
ALTER TABLE `m9c_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `m9c_user_company`
--
ALTER TABLE `m9c_user_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_user_groups`
--
ALTER TABLE `m9c_user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_user_relations`
--
ALTER TABLE `m9c_user_relations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m9c_user_roles`
--
ALTER TABLE `m9c_user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m9c_donations`
--
ALTER TABLE `m9c_donations`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `m9c_donation_assets`
--
ALTER TABLE `m9c_donation_assets`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `m9c_donation_documents`
--
ALTER TABLE `m9c_donation_documents`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m9c_donation_foundation`
--
ALTER TABLE `m9c_donation_foundation`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `m9c_donation_history`
--
ALTER TABLE `m9c_donation_history`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m9c_donation_persons`
--
ALTER TABLE `m9c_donation_persons`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `m9c_donation_person_foundation_relations`
--
ALTER TABLE `m9c_donation_person_foundation_relations`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `m9c_donation_settings`
--
ALTER TABLE `m9c_donation_settings`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `m9c_meta_options`
--
ALTER TABLE `m9c_meta_options`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `m9c_pages`
--
ALTER TABLE `m9c_pages`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m9c_plugins`
--
ALTER TABLE `m9c_plugins`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `m9c_users`
--
ALTER TABLE `m9c_users`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `m9c_user_company`
--
ALTER TABLE `m9c_user_company`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `m9c_user_groups`
--
ALTER TABLE `m9c_user_groups`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m9c_user_relations`
--
ALTER TABLE `m9c_user_relations`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `m9c_user_roles`
--
ALTER TABLE `m9c_user_roles`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
