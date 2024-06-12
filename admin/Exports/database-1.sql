-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 31, 2019 at 04:08 PM
-- Server version: 10.2.21-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `infocpanel_autorox`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `sno` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT '300x300.png',
  `forgot_key` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`sno`, `fullname`, `email`, `pass`, `phone`, `gender`, `img`, `forgot_key`, `role`, `status`) VALUES
(1, 'Pranay Rudra', 'rudra.pranay@gmail.com', 'JgGW6/+7ZP1/EiROTTtTtpLEZZTO1uRNgx3+eCdCVG0/FpeXGKOFu0V7mRAAjihaQsxhPJza57OpJwKXWIFjiQ==', '', '', '300x300.png', 'NjI1NQ==', 'superadmin', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `admin_sessions`
--

CREATE TABLE `admin_sessions` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `last_activity` int(11) NOT NULL,
  `user_data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_sessions`
--

INSERT INTO `admin_sessions` (`id`, `session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
(10, 'c88f453bf9bf47c551ecb8e4e3869f57', '183.82.96.158', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:64.0) Gecko/20100101 Firefox/64.0', 1548943549, 'a:1:{s:9:\"logged_in\";a:3:{s:5:\"email\";s:22:\"rudra.pranay@gmail.com\";s:2:\"id\";s:1:\"1\";s:4:\"role\";s:10:\"superadmin\";}}'),
(11, '6c779a8f1103b3932bfa055e4bc22954', '183.82.118.63', 'Mozilla/5.0 (Linux; U; Android 9; en-US; ONEPLUS A5010 Build/PKQ1.180716.001) AppleWebKit/537.36 (KHTML, like Gecko) Ver', 1548942516, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"logged_in\";a:3:{s:5:\"email\";s:22:\"rudra.pranay@gmail.com\";s:2:\"id\";s:1:\"1\";s:4:\"role\";s:10:\"superadmin\";}}'),
(13, '9b53ff7b628762929f7928d6597dc68a', '183.82.118.63', 'Mozilla/5.0 (Linux; U; Android 9; en-US; ONEPLUS A5010 Build/PKQ1.180716.001) AppleWebKit/537.36 (KHTML, like Gecko) Ver', 1548943397, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"logged_in\";a:3:{s:5:\"email\";s:22:\"rudra.pranay@gmail.com\";s:2:\"id\";s:1:\"1\";s:4:\"role\";s:10:\"superadmin\";}}');

-- --------------------------------------------------------

--
-- Table structure for table `change_type`
--

CREATE TABLE `change_type` (
  `ctid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `colname` varchar(255) NOT NULL,
  `changetype` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `change_type`
--

INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES
(128, 59, 'color', '{\"col_name\":\"color\",\"type\":\"select\",\"stype\":\"select\",\"s_selected\":\"Please Select\",\"s_options\":\"Please Select,danger,success,purple,primary,pink,info,warning\"}'),
(129, 60, 'event', '{\"col_name\":\"event\",\"type\":\"relation\",\"tablename\":\"event_sub_cat\",\"valuename\":\"sno\",\"displayname\":\"sub_event_name\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(130, 60, 'from_date', '{\"col_name\":\"from_date\",\"type\":\"datetime\",\"dtype\":\"datetime\",\"d_any\":\"\"}'),
(131, 60, 'end_date', '{\"col_name\":\"end_date\",\"type\":\"datetime\",\"dtype\":\"datetime\",\"d_any\":\"\"}'),
(132, 60, 'location', '{\"col_name\":\"location\",\"type\":\"textarea\"}'),
(133, 65, 'event_name', '{\"col_name\":\"event_name\",\"type\":\"relation\",\"tablename\":\"event_cat\",\"valuename\":\"sno\",\"displayname\":\"event_cat\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(135, 67, 'emp_img', '{\"col_name\":\"emp_img\",\"type\":\"image\",\"any\":\"\",\"width\":\"120\",\"height\":\"150\",\"crop\":\"manual_crop\"}'),
(136, 67, 'role', '{\"col_name\":\"role\",\"type\":\"none\"}'),
(137, 62, 'img', '{\"col_name\":\"img\",\"type\":\"image\",\"any\":\"\",\"width\":\"150\",\"height\":\"120\",\"crop\":\"manual_crop\"}'),
(139, 66, 'category', '{\"col_name\":\"category\",\"type\":\"relation\",\"tablename\":\"equip_cat\",\"valuename\":\"id\",\"displayname\":\"cat_name\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(140, 66, 'brand', '{\"col_name\":\"brand\",\"type\":\"relation\",\"tablename\":\"euip_brands\",\"valuename\":\"id\",\"displayname\":\"company_name\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(141, 66, 'img', '{\"col_name\":\"img\",\"type\":\"image\",\"any\":\"\",\"width\":\"600\",\"height\":\"400\",\"crop\":\"manual_crop\"}'),
(142, 67, 'img', '{\"col_name\":\"img\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"ratio_crop\"}'),
(143, 67, 'joining_date', '{\"col_name\":\"joining_date\",\"type\":\"datetime\",\"dtype\":\"date\",\"d_any\":\"\"}'),
(144, 67, 'pass', '{\"col_name\":\"pass\",\"type\":\"password\",\"pencrypt\":\"md5\"}'),
(145, 62, 'equip_cat', '{\"col_name\":\"equip_cat\",\"type\":\"select\",\"stype\":\"multiselect\",\"s_selected\":\"brand\",\"s_options\":\"category1,category2\"}'),
(148, 63, 'brands_list', '{\"col_name\":\"brands_list\",\"type\":\"relation\",\"tablename\":\"euip_brands\",\"valuename\":\"id\",\"displayname\":\"company_name\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(149, 78, 'cat', '{\"col_name\":\"cat\",\"type\":\"relation\",\"tablename\":\"exp_cat\",\"valuename\":\"sno\",\"displayname\":\"cat\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(150, 78, 'added_by', '{\"col_name\":\"added_by\",\"type\":\"relation\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"active\"}'),
(151, 80, 'emp_id', '{\"col_name\":\"emp_id\",\"type\":\"relation\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"type\",\"typevalue\":\"Inhouse\"}'),
(152, 81, 'emp_id', '{\"col_name\":\"emp_id\",\"type\":\"relation\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"type\",\"typevalue\":\"Inhouse\"}'),
(153, 78, 'bill', '{\"col_name\":\"bill\",\"type\":\"file\",\"any\":\"\",\"frename\":\"rename\"}'),
(155, 81, 'from_date', '{\"col_name\":\"from_date\",\"type\":\"datetime\",\"dtype\":\"date\",\"d_any\":\"\"}'),
(156, 81, 'to_date', '{\"col_name\":\"to_date\",\"type\":\"datetime\",\"dtype\":\"date\",\"d_any\":\"\"}'),
(157, 72, 'emp_id', '{\"col_name\":\"emp_id\",\"type\":\"relation\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"type\",\"typevalue\":\"Inhouse\"}'),
(158, 72, 'date_of_payment', '{\"col_name\":\"date_of_payment\",\"type\":\"datetime\",\"dtype\":\"datetime\",\"d_any\":\"\"}'),
(159, 73, 'emp_id', '{\"col_name\":\"emp_id\",\"type\":\"relation\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"type\",\"typevalue\":\"Inhouse\"}'),
(160, 73, 'previous_salary', '{\"col_name\":\"previous_salary\",\"type\":\"relation_depend\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"salary\",\"typename\":\"status\",\"typevalue\":\"active\",\"dependvaluename\":\"sno\",\"dependcolname\":\"emp_id\"}'),
(161, 80, 'salary', '{\"col_name\":\"salary\",\"type\":\"relation_depend\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"salary\",\"typename\":\"status\",\"typevalue\":\"active\",\"dependvaluename\":\"sno\",\"dependcolname\":\"emp_id\"}'),
(162, 80, 'updated_sal', '{\"col_name\":\"updated_sal\",\"type\":\"none\"}'),
(164, 83, 'event_id', '{\"col_name\":\"event_id\",\"type\":\"relation\",\"tablename\":\"events_mrg\",\"valuename\":\"sno\",\"displayname\":\"event_title\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(165, 83, 'amount_by', '{\"col_name\":\"amount_by\",\"type\":\"relation\",\"tablename\":\"admin\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"active\"}'),
(166, 81, 'leave_status', '{\"col_name\":\"leave_status\",\"type\":\"highlight_row\",\"condition\":\"=\",\"valuename\":\"Declined\",\"color\":\"#ff9a9a\"}'),
(167, 80, 'loan_status', '{\"col_name\":\"loan_status\",\"type\":\"highlight_row\",\"condition\":\"=\",\"valuename\":\"Declined\",\"color\":\"#ff9f9f\"}'),
(168, 89, 'date', '{\"col_name\":\"date\",\"type\":\"datetime\",\"dtype\":\"date\",\"d_any\":\"\"}'),
(169, 89, 'emp_id', '{\"col_name\":\"emp_id\",\"type\":\"relation_depend\",\"tablename\":\"employees\",\"valuename\":\"sno\",\"displayname\":\"name\",\"typename\":\"status\",\"typevalue\":\"1\",\"dependvaluename\":\"quarry\",\"dependcolname\":\"quarry\"}'),
(170, 90, 'address', '{\"col_name\":\"address\",\"type\":\"textarea\"}'),
(172, 91, 'manger_id', '{\"col_name\":\"manger_id\",\"type\":\"relation\",\"tablename\":\"admin\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(173, 93, 'img', '{\"col_name\":\"img\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"ratio_crop\"}'),
(174, 93, 'pass', '{\"col_name\":\"pass\",\"type\":\"none\"}'),
(175, 94, 'vendor', '{\"col_name\":\"vendor\",\"type\":\"relation\",\"tablename\":\"vendors\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(176, 94, 'photo1', '{\"col_name\":\"photo1\",\"type\":\"image\",\"any\":\"\",\"width\":\"400\",\"height\":\"600\",\"crop\":\"manual_crop\"}'),
(177, 94, 'photo2', '{\"col_name\":\"photo2\",\"type\":\"image\",\"any\":\"\",\"width\":\"400\",\"height\":\"600\",\"crop\":\"manual_crop\"}'),
(178, 94, 'photo3', '{\"col_name\":\"photo3\",\"type\":\"image\",\"any\":\"\",\"width\":\"400\",\"height\":\"600\",\"crop\":\"manual_crop\"}'),
(179, 95, 'photo', '{\"col_name\":\"photo\",\"type\":\"image\",\"any\":\"\",\"width\":\"520\",\"height\":\"316\",\"crop\":\"manual_crop\"}'),
(180, 96, 'vendor', '{\"col_name\":\"vendor\",\"type\":\"relation\",\"tablename\":\"vendors\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(181, 96, 'status', '{\"col_name\":\"status\",\"type\":\"highlight_row\",\"condition\":\"=\",\"valuename\":\"0\",\"color\":\"rgba(250, 194, 194, 0.75)\"}'),
(182, 97, 'address', '{\"col_name\":\"address\",\"type\":\"textarea\"}'),
(183, 98, 'bunk', '{\"col_name\":\"bunk\",\"type\":\"relation_depend\",\"tablename\":\"petrol_bunks\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"1\",\"dependvaluename\":\"quarry\",\"dependcolname\":\"quarry\"}'),
(184, 98, 'status', '{\"col_name\":\"status\",\"type\":\"highlight_row\",\"condition\":\"=\",\"valuename\":\"0\",\"color\":\"rgba(250, 194, 194, 0.75)\"}'),
(186, 100, 'company', '{\"col_name\":\"company\",\"type\":\"relation\",\"tablename\":\"machine_companies\",\"valuename\":\"sno\",\"displayname\":\"company\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(187, 90, 'photo', '{\"col_name\":\"photo\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"ratio_crop\"}'),
(188, 90, 'id_card', '{\"col_name\":\"id_card\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"ratio_crop\"}'),
(189, 90, 'any_policies', '{\"col_name\":\"any_policies\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"manual_crop\"}'),
(190, 90, 'quarry', '{\"col_name\":\"quarry\",\"type\":\"none\"}'),
(191, 102, 'quarry', '{\"col_name\":\"quarry\",\"type\":\"none\"}'),
(192, 102, 'make', '{\"col_name\":\"make\",\"type\":\"relation\",\"tablename\":\"machine_companies\",\"valuename\":\"sno\",\"displayname\":\"company\",\"typename\":\"status\",\"typevalue\":\"1\"}'),
(193, 102, 'type', '{\"col_name\":\"type\",\"type\":\"select\",\"stype\":\"select\",\"s_selected\":\"Own\",\"s_options\":\"Own,Rent\"}'),
(194, 100, 'quarry', '{\"col_name\":\"quarry\",\"type\":\"none\"}'),
(195, 93, 'quarry', '{\"col_name\":\"quarry\",\"type\":\"relation\",\"tablename\":\"admin\",\"valuename\":\"sno\",\"displayname\":\"quarry_name\",\"typename\":\"status\",\"typevalue\":\"active\"}'),
(196, 97, 'img', '{\"col_name\":\"img\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"ratio_crop\"}');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `sno` int(11) NOT NULL,
  `site_name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `alt_phone` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL,
  `googleplus` varchar(255) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`sno`, `site_name`, `phone`, `alt_phone`, `email`, `address`, `facebook`, `instagram`, `youtube`, `googleplus`, `twitter`, `status`) VALUES
(2, '', '9949796507', '', 'info@gayatri.com', 'H.No:11-10-701/1c,\r\nBurhanpuram, Khammam, Telangana', 'https://www.facebook.com/', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `create_table`
--

CREATE TABLE `create_table` (
  `cid` int(11) NOT NULL,
  `cttitle` varchar(255) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `bg_color` varchar(50) NOT NULL,
  `permissions` text NOT NULL,
  `rename_column` longtext NOT NULL,
  `pattern` longtext NOT NULL,
  `required_fields` longtext NOT NULL,
  `hidden` longtext NOT NULL,
  `order_by` varchar(255) NOT NULL,
  `menu_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `css`
--

CREATE TABLE `css` (
  `c_links` longtext NOT NULL,
  `css` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `css`
--

INSERT INTO `css` (`c_links`, `css`) VALUES
('', '@media print {\r\n    #print {\r\n        display:none;\r\n    }\r\n}\r\n.bootstrap-datetimepicker-widget{\r\n     z-index: 2048 !important;\r\n}');

-- --------------------------------------------------------

--
-- Table structure for table `js`
--

CREATE TABLE `js` (
  `j_links` longtext NOT NULL,
  `js` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `js`
--

INSERT INTO `js` (`j_links`, `js`) VALUES
('', '');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `table_name` varchar(255) NOT NULL DEFAULT '#',
  `icon` varchar(100) NOT NULL DEFAULT 'glyphicon glyphicon-folder-close',
  `child_id` int(11) NOT NULL,
  `menu_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `theme` varchar(50) NOT NULL,
  `button` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `loginbg` varchar(255) NOT NULL,
  `menu` varchar(255) NOT NULL,
  `sentmail` varchar(255) NOT NULL,
  `footer_left` longtext NOT NULL,
  `footer_right` longtext NOT NULL,
  `maintenance` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 is No, 1 is Yes',
  `ipaddress` text NOT NULL,
  `display_errors` tinyint(1) NOT NULL DEFAULT 1,
  `display` enum('show','hidden') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `theme`, `button`, `title`, `logo`, `favicon`, `loginbg`, `menu`, `sentmail`, `footer_left`, `footer_right`, `maintenance`, `ipaddress`, `display_errors`, `display`) VALUES
(1, 'default-dark', 'btn-info', 'Autorox', 'infotors-logo.png', 'infotors-favicon.png', 'istockphoto-1024037050-1024x1024.jpg', 'fix-header fix-sidebar content-wrapper', 'sashi@infotors.com', '<p>2018 &copy; <a href=\"http://infotors.in/\" rel=\"nofollow\" target=\"_blank\">Infotors</a>. All rights reserved.</p>\r\n', '<p>Developed by <a href=\"http://infotors.in/\" rel=\"nofollow\" target=\"_blank\">INFOTORS</a></p>\r\n', 0, '183.82.96.158,183.82.118.63', 1, 'show');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `tid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `tcondition` longtext NOT NULL,
  `tformat` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`tid`, `type`, `tcondition`, `tformat`) VALUES
(1, 'image', '<div class=\'col-md-3 mb\'><select name=\"icrop\" class=\"form-control\" id=\"gpsImage\" required>\r\n   <option value=\"\" selected>Select Type</option>\r\n   <option value=\"manual_crop\">Manual Crop</option>\r\n <option value=\"ratio_crop\">Ratio Crop</option>\r\n  <option value=\"crop\">Crop</option>\r\n</select></div>', '<div class=\"col-sm-3 mb\"><input class=\"form-control\" name=\"ct_width\" placeholder=\"Width\" required ></div><div class=\"col-sm-2 mb\"><input class=\"form-control\" name=\"ct_height\" placeholder=\"Height\" required ></div>'),
(2, 'file', '<div class=\'col-md-3 mb\'><select name=\"frename\" class=\"form-control\" id=\"gpsFile\" required>    <option value=\"\" selected>Select Type</option>    <option value=\"not_rename\">Not Rename</option>    <option value=\"rename\">Rename</option> </select></div>', ''),
(3, 'password', '<div class=\'col-md-3 mb\'><select name=\"pencrypt\" class=\"form-control\" >    <option value=\"\" selected>None</option>    <option value=\"md5\">MD5</option>    <option value=\"sha1\">SHA1</option> </select></div>', ''),
(4, 'select', '<div class=\'col-md-3 mb\'><select name=\"stype\" class=\"form-control\" required>    <option value=\"\" selected>Select Type</option>    <option value=\"select\">Select</option>    <option value=\"multiselect\">Multiselect</option> </select></div>', '<div class=\"col-sm-3 mb\"><input class=\"form-control\" name=\"s_selected\" placeholder=\"example\"></div><div class=\"col-sm-4 mb\"><input class=\"form-control\" name=\"s_options\" placeholder=\"example1,example2\" required ></div>'),
(5, 'datetime', '<div class=\'col-md-3 mb\'><select name=\"dtype\" class=\"form-control\" required ><option value=\"\" selected>Select Type</option><option value=\"datetime\">Date Time</option><option value=\"date\">Date</option></select></div>', ''),
(6, 'textarea', '', ''),
(7, 'int', '', ''),
(8, 'remote_image', '<div class=\"col-sm-6 mb\"><input class=\"form-control\" name=\"links\" placeholder=\"http://www.example.com/uploads/\" required ></div>', ''),
(9, 'thumbs', '<div class=\"col-sm-3 mb\"><input class=\"form-control\" name=\"small\" placeholder=\"small:width\" required ></div><div class=\"col-sm-2 mb\"><input class=\"form-control\" name=\"middle\" placeholder=\"middle:width\" required ></div><div class=\"col-sm-2 mb\"><input class=\"form-control\" name=\"big\" placeholder=\"big:width\" required ></div>', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `admin_sessions`
--
ALTER TABLE `admin_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `change_type`
--
ALTER TABLE `change_type`
  ADD PRIMARY KEY (`ctid`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `create_table`
--
ALTER TABLE `create_table`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`parent_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`tid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_sessions`
--
ALTER TABLE `admin_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `change_type`
--
ALTER TABLE `change_type`
  MODIFY `ctid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `create_table`
--
ALTER TABLE `create_table`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
