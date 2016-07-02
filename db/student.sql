-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: May 02, 2014 at 06:19 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `student`
--

-- --------------------------------------------------------

--
-- Table structure for table `autonumber`
--

CREATE TABLE `autonumber` (
  `year` int(4) unsigned zerofill NOT NULL,
  `month` int(2) unsigned zerofill NOT NULL,
  `day` int(2) unsigned zerofill NOT NULL,
  `member_number` int(6) unsigned zerofill NOT NULL,
  PRIMARY KEY (`year`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `autonumber`
--

INSERT INTO `autonumber` (`year`, `month`, `day`, `member_number`) VALUES
(2014, 03, 08, 000001);

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `card_key` varchar(32) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `card_type` tinyint(1) NOT NULL COMMENT '1=paid,2=month',
  `use_date` date NOT NULL,
  `exp_date` date NOT NULL,
  `aqua_count` double NOT NULL,
  `member_key` varchar(32) NOT NULL,
  `user_key` varchar(32) NOT NULL,
  `card_status` tinyint(1) NOT NULL COMMENT '0=disable,1=enable',
  `regis_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`card_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE `list` (
  `cases` varchar(64) NOT NULL,
  `menu` varchar(64) NOT NULL,
  `pages` varchar(128) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`cases`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `list`
--

INSERT INTO `list` (`cases`, `menu`, `pages`, `status`) VALUES
('main', 'main', '../modules/main/main.php', 1),
('payaqua', 'payaqua', '../modules/payaqua/main.php', 1),
('money', 'money', '../modules/finance/main.php', 1),
('members', 'members', '../modules/members/main.php', 1),
('report', 'report', '../modules/report/main.php', 1),
('settings', 'settings', '../modules/settings/main.php', 1),
('settings_user_info', 'settings', '../modules/settings/settings_user_info.php', 1),
('settings_users', 'settings', '../modules/settings/settings_users.php', 1),
('member_detail', 'members', '../modules/members/member_detail.php', 1),
('payaqua_agent', 'payaqua', '../modules/payaqua/agent.php', 1),
('report_aquain', 'report', '../modules/report/report_aquain.php', 1),
('report_aquaout', 'report', '../modules/report/report_aquaout.php', 1),
('report_cardtype', 'report', '../modules/report/report_cardtype.php', 1),
('report_members', 'report', '../modules/report/report_members.php', 1),
('report_users', 'report', '../modules/report/report_users.php', 1),
('report_history', 'report', '../modules/report/report_history.php', 1),
('user_detail', 'settings', '../modules/settings/user_detail.php', 1),
('card_detail', 'cards', '../modules/cards/card_detail.php', 1),
('subjects', 'subjects', '../modules/subjects/main.php', 1),
('register_subjects', 'members', '../modules/members/register.php', 1),
('subject_use', 'payaqua', '../modules/payaqua/subject_use.php', 1),
('subject_detail', 'subjects', '../modules/subjects/subject_detail.php', 1),
('money_pay', 'money', '../modules/finance/money_pay.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_key` varchar(16) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_ipaddress` varchar(32) NOT NULL,
  `log_text` varchar(256) NOT NULL,
  `log_user` varchar(32) NOT NULL,
  PRIMARY KEY (`log_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_key`, `log_date`, `log_ipaddress`, `log_text`, `log_user`) VALUES
('ced03307ed544cad', '2014-05-02 04:19:36', '::1', 'user ออกจากระบบ.', 'ee11cbb19052e40b07aac0ca060c23ee'),
('fafae06f4afca5ff', '2014-05-02 04:19:32', '::1', 'user เข้าสู่ระบบ.', 'ee11cbb19052e40b07aac0ca060c23ee'),
('a3a8e05a45edab62', '2014-05-02 04:19:25', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_key` varchar(32) NOT NULL,
  `member_code` varchar(16) NOT NULL,
  `member_prefix` varchar(32) NOT NULL,
  `member_name` varchar(64) NOT NULL,
  `member_lastname` varchar(64) NOT NULL,
  `member_address` varchar(128) NOT NULL,
  `member_subdistrict` varchar(64) NOT NULL,
  `member_district` varchar(64) NOT NULL,
  `member_province` varchar(64) NOT NULL,
  `member_tel` varchar(16) NOT NULL,
  `pr_member_name` varchar(64) NOT NULL,
  `pr_member_tel` varchar(64) NOT NULL,
  `member_photo` varchar(128) NOT NULL DEFAULT 'noimg.jpg',
  `member_status` tinyint(1) NOT NULL COMMENT '0=deactivate,1=activate',
  `regis_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`member_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_key` varchar(32) NOT NULL,
  `regis_key` varchar(32) NOT NULL,
  `pay_amount` double NOT NULL,
  `user_key` varchar(32) NOT NULL,
  `pay_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pay_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_key` varchar(32) NOT NULL,
  `subject_name` varchar(64) NOT NULL,
  `subject_code` varchar(16) NOT NULL,
  `subject_description` text NOT NULL,
  `subject_tutor` varchar(128) NOT NULL,
  `subject_start` date NOT NULL,
  `subject_end` date NOT NULL,
  `subject_total_hour` int(11) NOT NULL,
  `subject_price` double NOT NULL,
  `learn_mon` tinyint(1) NOT NULL DEFAULT '0',
  `learn_tue` tinyint(1) NOT NULL DEFAULT '0',
  `learn_wed` tinyint(1) NOT NULL DEFAULT '0',
  `learn_thu` tinyint(1) NOT NULL DEFAULT '0',
  `learn_fri` tinyint(1) NOT NULL DEFAULT '0',
  `learn_sat` tinyint(1) NOT NULL DEFAULT '0',
  `learn_sun` tinyint(1) NOT NULL DEFAULT '0',
  `subject_time_learn` varchar(64) NOT NULL,
  `subject_status` tinyint(1) NOT NULL,
  `regis_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`subject_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subject_register`
--

CREATE TABLE `subject_register` (
  `regis_key` varchar(32) NOT NULL,
  `subject_key` varchar(32) NOT NULL,
  `member_key` varchar(32) NOT NULL,
  `regis_hour` int(11) NOT NULL,
  `regis_price` double NOT NULL,
  `payment_status` tinyint(1) NOT NULL COMMENT '0=No Pay,1=Pay Done,2=Pay Helf',
  `regis_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`regis_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subject_use`
--

CREATE TABLE `subject_use` (
  `use_key` varchar(32) NOT NULL,
  `regis_key` varchar(32) NOT NULL,
  `use_hour` int(11) NOT NULL,
  `user_key` varchar(32) NOT NULL,
  `use_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`use_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_key` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `tel` varchar(16) NOT NULL,
  `photo` varchar(128) NOT NULL DEFAULT 'noimg.jpg',
  `user_class` tinyint(1) NOT NULL COMMENT '1=user,2=admin',
  `user_status` tinyint(1) NOT NULL COMMENT '0=deactivate,1=activate',
  `regis_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_key`, `name`, `lastname`, `username`, `password`, `email`, `tel`, `photo`, `user_class`, `user_status`, `regis_date`) VALUES
('21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@clear.in.th', '0811111111', 'noimg.jpg', 2, 1, '2014-01-30 02:20:17'),
('ee11cbb19052e40b07aac0ca060c23ee', 'user', 'user', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@clear.in.th', '0800000000', 'noimg.jpg', 1, 1, '2014-01-30 02:20:17');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
