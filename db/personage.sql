-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jul 02, 2016 at 07:29 AM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `personage`
--

-- --------------------------------------------------------

--
-- Table structure for table `autonumber`
--

CREATE TABLE `autonumber` (
  `year` int(4) UNSIGNED ZEROFILL NOT NULL,
  `month` int(2) UNSIGNED ZEROFILL NOT NULL,
  `day` int(2) UNSIGNED ZEROFILL NOT NULL,
  `member_number` int(6) UNSIGNED ZEROFILL NOT NULL
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
  `regis_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE `list` (
  `cases` varchar(64) NOT NULL,
  `menu` varchar(64) NOT NULL,
  `pages` varchar(128) NOT NULL,
  `status` tinyint(1) NOT NULL
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
('user_detail', 'users', '../modules/users/user_detail.php', 1),
('card_detail', 'cards', '../modules/cards/card_detail.php', 1),
('subjects', 'subjects', '../modules/subjects/main.php', 1),
('register_subjects', 'members', '../modules/members/register.php', 1),
('subject_use', 'payaqua', '../modules/payaqua/subject_use.php', 1),
('subject_detail', 'subjects', '../modules/subjects/subject_detail.php', 1),
('money_pay', 'money', '../modules/finance/money_pay.php', 1),
('users', 'users', '../modules/users/main.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_key` varchar(16) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_ipaddress` varchar(32) NOT NULL,
  `log_text` varchar(256) NOT NULL,
  `log_user` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_key`, `log_date`, `log_ipaddress`, `log_text`, `log_user`) VALUES
('ced03307ed544cad', '2014-05-02 04:19:36', '::1', 'user ออกจากระบบ.', 'ee11cbb19052e40b07aac0ca060c23ee'),
('fafae06f4afca5ff', '2014-05-02 04:19:32', '::1', 'user เข้าสู่ระบบ.', 'ee11cbb19052e40b07aac0ca060c23ee'),
('a3a8e05a45edab62', '2014-05-02 04:19:25', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('dcab4c2709bb3d55', '2016-06-30 15:04:30', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('dc8dc109b8a9113f', '2016-06-30 15:22:57', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('55cb2009d8cf64d6', '2016-06-30 15:23:58', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('fc11728ae8255312', '2016-06-30 15:24:18', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('61f77069b42e3a99', '2016-06-30 15:35:02', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('f4616c1f70ba1471', '2016-06-30 15:41:00', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('0a04e14da2e83773', '2016-06-30 15:41:15', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('cef817f5e84e7a3d', '2016-06-30 15:42:33', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('890feb6b28a5e109', '2016-06-30 15:44:13', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('d02ccf136b575a4f', '2016-06-30 16:36:38', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('e748a44478085959', '2016-06-30 16:36:47', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('9a53d5b0f073c2d0', '2016-06-30 16:59:07', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('d9f0b72dcb5c9fc3', '2016-06-30 16:59:16', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('8524f9eaf4e314e8', '2016-06-30 17:15:31', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('707afb472b17249c', '2016-06-30 17:15:42', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('5d5771ee1d9ccac2', '2016-06-30 17:15:47', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('bda798057c80343f', '2016-06-30 17:16:00', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('1291dd27a89c794f', '2016-07-01 04:37:11', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('4de07d44c3ec59f2', '2016-07-01 04:37:19', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('01a751f6fd66fad9', '2016-07-01 10:55:52', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('51f422a0ee9f5e95', '2016-07-01 10:56:01', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('bc643074d2338aa3', '2016-07-01 15:39:13', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('117f49380bee11f4', '2016-07-01 15:39:21', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('cb01895fe87b58ae', '2016-07-01 15:55:24', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('c70280a2be2449dd', '2016-07-01 15:55:34', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('150b28b980f3c3a1', '2016-07-01 16:05:27', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('e2a4e8f5b8d68329', '2016-07-01 16:06:08', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('8470052611b15172', '2016-07-01 16:18:24', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('46ab0054f9873181', '2016-07-01 16:18:35', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('adc7ad0a6514f4c6', '2016-07-01 16:58:56', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('cf2c04a0e0235877', '2016-07-01 17:10:52', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('6cb26f9fe7ef021d', '2016-07-01 17:10:59', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('d109768e8a45e92a', '2016-07-02 04:42:26', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('2e0f127d23574192', '2016-07-02 04:42:45', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('8f8238f2035a138a', '2016-07-02 04:43:00', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('6d0f8e0b469ef4db', '2016-07-02 04:53:11', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('12e14ae1984d48d3', '2016-07-02 05:13:42', '::1', 'admin ออกจากระบบ.', '21232f297a57a5a743894a0e4a801fc3'),
('e61b0a8c3c449632', '2016-07-02 05:14:15', '::1', 'barack เข้าสู่ระบบ.', '98e05ab0155cdfe5961fc926b66fbd29'),
('c1f8648081e1f4bf', '2016-07-02 05:14:34', '::1', 'barack ออกจากระบบ.', '98e05ab0155cdfe5961fc926b66fbd29'),
('98d4319573725031', '2016-07-02 05:14:41', '::1', 'admin เข้าสู่ระบบ.', '21232f297a57a5a743894a0e4a801fc3');

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
  `regis_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  `pay_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  `regis_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
  `regis_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  `use_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  `position` varchar(256) NOT NULL,
  `department` varchar(256) NOT NULL,
  `photo` varchar(128) NOT NULL DEFAULT 'noimg.jpg',
  `user_class` tinyint(1) NOT NULL COMMENT '0=ผู้บริหาร,1=บุคลากร,2=ผู้ดูแลระบบ',
  `user_status` tinyint(1) NOT NULL COMMENT '0=deactivate,1=activate',
  `regis_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_key`, `name`, `lastname`, `username`, `password`, `email`, `tel`, `position`, `department`, `photo`, `user_class`, `user_status`, `regis_date`) VALUES
('21232f297a57a5a743894a0e4a801fc3', 'แอดมิน', 'ใจดี', 'admin', 'deaad792606928825c0bf85cd46e9edf', 'admin@personage.com', '0812345678', 'ผู้ดูแลเว็บไซต์', 'Development', '9fabf055c73d8987397af09a5f636fd4.jpg', 2, 1, '2014-01-30 02:20:17'),
('3fc82da1cfb49dd9534d8986a8caf529', 'สมชาย', 'เหมาะมั่น', 'somchai', 'deaad792606928825c0bf85cd46e9edf', 'somchai@email.com', '0812345678', 'พนักงานส่งเอกสาร', 'ฝ่ายพัสดุ', '36813d04fd34d169ca8b0ac2c2fe84ee.jpg', 1, 1, '2016-07-01 17:14:49'),
('98e05ab0155cdfe5961fc926b66fbd29', 'บารัค', 'โอบามา', 'barack', 'deaad792606928825c0bf85cd46e9edf', 'barack@usa.com', '0812345678', 'ประธานาธิบดี', 'บริหาร', '182cecae4873ea681ed7ac77b8c5fe2c.jpg', 0, 1, '2016-07-02 05:12:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autonumber`
--
ALTER TABLE `autonumber`
  ADD PRIMARY KEY (`year`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`card_key`);

--
-- Indexes for table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`cases`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_key`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_key`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_key`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_key`);

--
-- Indexes for table `subject_register`
--
ALTER TABLE `subject_register`
  ADD PRIMARY KEY (`regis_key`);

--
-- Indexes for table `subject_use`
--
ALTER TABLE `subject_use`
  ADD PRIMARY KEY (`use_key`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_key`);
