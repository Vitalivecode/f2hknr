#
# TABLE STRUCTURE FOR: admin
#

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT '300x300.png',
  `forgot_key` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`sno`, `fullname`, `email`, `pass`, `phone`, `gender`, `img`, `forgot_key`, `role`, `status`) VALUES ('1', 'Pranay Rudra', 'rudra.pranay@gmail.com', 'JgGW6/+7ZP1/EiROTTtTtpLEZZTO1uRNgx3+eCdCVG0/FpeXGKOFu0V7mRAAjihaQsxhPJza57OpJwKXWIFjiQ==', '', '', '300x300.png', 'NjI1NQ==', 'superadmin', 'active');


#
# TABLE STRUCTURE FOR: admin_sessions
#

DROP TABLE IF EXISTS `admin_sessions`;

CREATE TABLE `admin_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `last_activity` int(11) NOT NULL,
  `user_data` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO `admin_sessions` (`id`, `session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES ('10', 'c88f453bf9bf47c551ecb8e4e3869f57', '183.82.96.158', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:64.0) Gecko/20100101 Firefox/64.0', '1548943549', 'a:1:{s:9:\"logged_in\";a:3:{s:5:\"email\";s:22:\"rudra.pranay@gmail.com\";s:2:\"id\";s:1:\"1\";s:4:\"role\";s:10:\"superadmin\";}}');
INSERT INTO `admin_sessions` (`id`, `session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES ('11', '6c779a8f1103b3932bfa055e4bc22954', '183.82.118.63', 'Mozilla/5.0 (Linux; U; Android 9; en-US; ONEPLUS A5010 Build/PKQ1.180716.001) AppleWebKit/537.36 (KHTML, like Gecko) Ver', '1548942516', 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"logged_in\";a:3:{s:5:\"email\";s:22:\"rudra.pranay@gmail.com\";s:2:\"id\";s:1:\"1\";s:4:\"role\";s:10:\"superadmin\";}}');
INSERT INTO `admin_sessions` (`id`, `session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES ('13', '9b53ff7b628762929f7928d6597dc68a', '183.82.118.63', 'Mozilla/5.0 (Linux; U; Android 9; en-US; ONEPLUS A5010 Build/PKQ1.180716.001) AppleWebKit/537.36 (KHTML, like Gecko) Ver', '1548943397', 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"logged_in\";a:3:{s:5:\"email\";s:22:\"rudra.pranay@gmail.com\";s:2:\"id\";s:1:\"1\";s:4:\"role\";s:10:\"superadmin\";}}');


#
# TABLE STRUCTURE FOR: change_type
#

DROP TABLE IF EXISTS `change_type`;

CREATE TABLE `change_type` (
  `ctid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `colname` varchar(255) NOT NULL,
  `changetype` longtext NOT NULL,
  PRIMARY KEY (`ctid`)
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=latin1;

INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('128', '59', 'color', '{\"col_name\":\"color\",\"type\":\"select\",\"stype\":\"select\",\"s_selected\":\"Please Select\",\"s_options\":\"Please Select,danger,success,purple,primary,pink,info,warning\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('129', '60', 'event', '{\"col_name\":\"event\",\"type\":\"relation\",\"tablename\":\"event_sub_cat\",\"valuename\":\"sno\",\"displayname\":\"sub_event_name\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('130', '60', 'from_date', '{\"col_name\":\"from_date\",\"type\":\"datetime\",\"dtype\":\"datetime\",\"d_any\":\"\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('131', '60', 'end_date', '{\"col_name\":\"end_date\",\"type\":\"datetime\",\"dtype\":\"datetime\",\"d_any\":\"\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('132', '60', 'location', '{\"col_name\":\"location\",\"type\":\"textarea\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('133', '65', 'event_name', '{\"col_name\":\"event_name\",\"type\":\"relation\",\"tablename\":\"event_cat\",\"valuename\":\"sno\",\"displayname\":\"event_cat\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('135', '67', 'emp_img', '{\"col_name\":\"emp_img\",\"type\":\"image\",\"any\":\"\",\"width\":\"120\",\"height\":\"150\",\"crop\":\"manual_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('136', '67', 'role', '{\"col_name\":\"role\",\"type\":\"none\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('137', '62', 'img', '{\"col_name\":\"img\",\"type\":\"image\",\"any\":\"\",\"width\":\"150\",\"height\":\"120\",\"crop\":\"manual_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('139', '66', 'category', '{\"col_name\":\"category\",\"type\":\"relation\",\"tablename\":\"equip_cat\",\"valuename\":\"id\",\"displayname\":\"cat_name\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('140', '66', 'brand', '{\"col_name\":\"brand\",\"type\":\"relation\",\"tablename\":\"euip_brands\",\"valuename\":\"id\",\"displayname\":\"company_name\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('141', '66', 'img', '{\"col_name\":\"img\",\"type\":\"image\",\"any\":\"\",\"width\":\"600\",\"height\":\"400\",\"crop\":\"manual_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('142', '67', 'img', '{\"col_name\":\"img\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"ratio_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('143', '67', 'joining_date', '{\"col_name\":\"joining_date\",\"type\":\"datetime\",\"dtype\":\"date\",\"d_any\":\"\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('144', '67', 'pass', '{\"col_name\":\"pass\",\"type\":\"password\",\"pencrypt\":\"md5\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('145', '62', 'equip_cat', '{\"col_name\":\"equip_cat\",\"type\":\"select\",\"stype\":\"multiselect\",\"s_selected\":\"brand\",\"s_options\":\"category1,category2\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('148', '63', 'brands_list', '{\"col_name\":\"brands_list\",\"type\":\"relation\",\"tablename\":\"euip_brands\",\"valuename\":\"id\",\"displayname\":\"company_name\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('149', '78', 'cat', '{\"col_name\":\"cat\",\"type\":\"relation\",\"tablename\":\"exp_cat\",\"valuename\":\"sno\",\"displayname\":\"cat\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('150', '78', 'added_by', '{\"col_name\":\"added_by\",\"type\":\"relation\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"active\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('151', '80', 'emp_id', '{\"col_name\":\"emp_id\",\"type\":\"relation\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"type\",\"typevalue\":\"Inhouse\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('152', '81', 'emp_id', '{\"col_name\":\"emp_id\",\"type\":\"relation\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"type\",\"typevalue\":\"Inhouse\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('153', '78', 'bill', '{\"col_name\":\"bill\",\"type\":\"file\",\"any\":\"\",\"frename\":\"rename\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('155', '81', 'from_date', '{\"col_name\":\"from_date\",\"type\":\"datetime\",\"dtype\":\"date\",\"d_any\":\"\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('156', '81', 'to_date', '{\"col_name\":\"to_date\",\"type\":\"datetime\",\"dtype\":\"date\",\"d_any\":\"\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('157', '72', 'emp_id', '{\"col_name\":\"emp_id\",\"type\":\"relation\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"type\",\"typevalue\":\"Inhouse\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('158', '72', 'date_of_payment', '{\"col_name\":\"date_of_payment\",\"type\":\"datetime\",\"dtype\":\"datetime\",\"d_any\":\"\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('159', '73', 'emp_id', '{\"col_name\":\"emp_id\",\"type\":\"relation\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"type\",\"typevalue\":\"Inhouse\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('160', '73', 'previous_salary', '{\"col_name\":\"previous_salary\",\"type\":\"relation_depend\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"salary\",\"typename\":\"status\",\"typevalue\":\"active\",\"dependvaluename\":\"sno\",\"dependcolname\":\"emp_id\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('161', '80', 'salary', '{\"col_name\":\"salary\",\"type\":\"relation_depend\",\"tablename\":\"emp_inhouse\",\"valuename\":\"sno\",\"displayname\":\"salary\",\"typename\":\"status\",\"typevalue\":\"active\",\"dependvaluename\":\"sno\",\"dependcolname\":\"emp_id\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('162', '80', 'updated_sal', '{\"col_name\":\"updated_sal\",\"type\":\"none\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('164', '83', 'event_id', '{\"col_name\":\"event_id\",\"type\":\"relation\",\"tablename\":\"events_mrg\",\"valuename\":\"sno\",\"displayname\":\"event_title\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('165', '83', 'amount_by', '{\"col_name\":\"amount_by\",\"type\":\"relation\",\"tablename\":\"admin\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"active\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('166', '81', 'leave_status', '{\"col_name\":\"leave_status\",\"type\":\"highlight_row\",\"condition\":\"=\",\"valuename\":\"Declined\",\"color\":\"#ff9a9a\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('167', '80', 'loan_status', '{\"col_name\":\"loan_status\",\"type\":\"highlight_row\",\"condition\":\"=\",\"valuename\":\"Declined\",\"color\":\"#ff9f9f\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('168', '89', 'date', '{\"col_name\":\"date\",\"type\":\"datetime\",\"dtype\":\"date\",\"d_any\":\"\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('169', '89', 'emp_id', '{\"col_name\":\"emp_id\",\"type\":\"relation_depend\",\"tablename\":\"employees\",\"valuename\":\"sno\",\"displayname\":\"name\",\"typename\":\"status\",\"typevalue\":\"1\",\"dependvaluename\":\"quarry\",\"dependcolname\":\"quarry\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('170', '90', 'address', '{\"col_name\":\"address\",\"type\":\"textarea\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('172', '91', 'manger_id', '{\"col_name\":\"manger_id\",\"type\":\"relation\",\"tablename\":\"admin\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('173', '93', 'img', '{\"col_name\":\"img\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"ratio_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('174', '93', 'pass', '{\"col_name\":\"pass\",\"type\":\"none\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('175', '94', 'vendor', '{\"col_name\":\"vendor\",\"type\":\"relation\",\"tablename\":\"vendors\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('176', '94', 'photo1', '{\"col_name\":\"photo1\",\"type\":\"image\",\"any\":\"\",\"width\":\"400\",\"height\":\"600\",\"crop\":\"manual_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('177', '94', 'photo2', '{\"col_name\":\"photo2\",\"type\":\"image\",\"any\":\"\",\"width\":\"400\",\"height\":\"600\",\"crop\":\"manual_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('178', '94', 'photo3', '{\"col_name\":\"photo3\",\"type\":\"image\",\"any\":\"\",\"width\":\"400\",\"height\":\"600\",\"crop\":\"manual_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('179', '95', 'photo', '{\"col_name\":\"photo\",\"type\":\"image\",\"any\":\"\",\"width\":\"520\",\"height\":\"316\",\"crop\":\"manual_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('180', '96', 'vendor', '{\"col_name\":\"vendor\",\"type\":\"relation\",\"tablename\":\"vendors\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('181', '96', 'status', '{\"col_name\":\"status\",\"type\":\"highlight_row\",\"condition\":\"=\",\"valuename\":\"0\",\"color\":\"rgba(250, 194, 194, 0.75)\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('182', '97', 'address', '{\"col_name\":\"address\",\"type\":\"textarea\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('183', '98', 'bunk', '{\"col_name\":\"bunk\",\"type\":\"relation_depend\",\"tablename\":\"petrol_bunks\",\"valuename\":\"sno\",\"displayname\":\"fullname\",\"typename\":\"status\",\"typevalue\":\"1\",\"dependvaluename\":\"quarry\",\"dependcolname\":\"quarry\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('184', '98', 'status', '{\"col_name\":\"status\",\"type\":\"highlight_row\",\"condition\":\"=\",\"valuename\":\"0\",\"color\":\"rgba(250, 194, 194, 0.75)\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('186', '100', 'company', '{\"col_name\":\"company\",\"type\":\"relation\",\"tablename\":\"machine_companies\",\"valuename\":\"sno\",\"displayname\":\"company\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('187', '90', 'photo', '{\"col_name\":\"photo\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"ratio_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('188', '90', 'id_card', '{\"col_name\":\"id_card\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"ratio_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('189', '90', 'any_policies', '{\"col_name\":\"any_policies\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"manual_crop\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('190', '90', 'quarry', '{\"col_name\":\"quarry\",\"type\":\"none\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('191', '102', 'quarry', '{\"col_name\":\"quarry\",\"type\":\"none\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('192', '102', 'make', '{\"col_name\":\"make\",\"type\":\"relation\",\"tablename\":\"machine_companies\",\"valuename\":\"sno\",\"displayname\":\"company\",\"typename\":\"status\",\"typevalue\":\"1\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('193', '102', 'type', '{\"col_name\":\"type\",\"type\":\"select\",\"stype\":\"select\",\"s_selected\":\"Own\",\"s_options\":\"Own,Rent\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('194', '100', 'quarry', '{\"col_name\":\"quarry\",\"type\":\"none\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('195', '93', 'quarry', '{\"col_name\":\"quarry\",\"type\":\"relation\",\"tablename\":\"admin\",\"valuename\":\"sno\",\"displayname\":\"quarry_name\",\"typename\":\"status\",\"typevalue\":\"active\"}');
INSERT INTO `change_type` (`ctid`, `tid`, `colname`, `changetype`) VALUES ('196', '97', 'img', '{\"col_name\":\"img\",\"type\":\"image\",\"any\":\"\",\"width\":\"300\",\"height\":\"300\",\"crop\":\"ratio_crop\"}');


#
# TABLE STRUCTURE FOR: contact_details
#

DROP TABLE IF EXISTS `contact_details`;

CREATE TABLE `contact_details` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
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
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`sno`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `contact_details` (`sno`, `site_name`, `phone`, `alt_phone`, `email`, `address`, `facebook`, `instagram`, `youtube`, `googleplus`, `twitter`, `status`) VALUES ('2', '', '9949796507', '', 'info@gayatri.com', 'H.No:11-10-701/1c,\r\nBurhanpuram, Khammam, Telangana', 'https://www.facebook.com/', '', '', '', '', '1');


#
# TABLE STRUCTURE FOR: create_table
#

DROP TABLE IF EXISTS `create_table`;

CREATE TABLE `create_table` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
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
  `menu_order` int(11) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: css
#

DROP TABLE IF EXISTS `css`;

CREATE TABLE `css` (
  `c_links` longtext NOT NULL,
  `css` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `css` (`c_links`, `css`) VALUES ('', '@media print {\r\n    #print {\r\n        display:none;\r\n    }\r\n}\r\n.bootstrap-datetimepicker-widget{\r\n     z-index: 2048 !important;\r\n}');


#
# TABLE STRUCTURE FOR: js
#

DROP TABLE IF EXISTS `js`;

CREATE TABLE `js` (
  `j_links` longtext NOT NULL,
  `js` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `js` (`j_links`, `js`) VALUES ('', '');


#
# TABLE STRUCTURE FOR: menu
#

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `parent_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `table_name` varchar(255) NOT NULL DEFAULT '#',
  `icon` varchar(100) NOT NULL DEFAULT 'glyphicon glyphicon-folder-close',
  `child_id` int(11) NOT NULL,
  `menu_order` int(11) NOT NULL,
  PRIMARY KEY (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: settings
#

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `display` enum('show','hidden') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`id`, `theme`, `button`, `title`, `logo`, `favicon`, `loginbg`, `menu`, `sentmail`, `footer_left`, `footer_right`, `maintenance`, `ipaddress`, `display_errors`, `display`) VALUES ('1', 'default-dark', 'btn-info', 'Autorox', 'infotors-logo.png', 'infotors-favicon.png', 'istockphoto-1024037050-1024x1024.jpg', 'fix-header fix-sidebar content-wrapper', 'sashi@infotors.com', '<p>2018 &copy; <a href=\"http://infotors.in/\" rel=\"nofollow\" target=\"_blank\">Infotors</a>. All rights reserved.</p>\r\n', '<p>Developed by <a href=\"http://infotors.in/\" rel=\"nofollow\" target=\"_blank\">INFOTORS</a></p>\r\n', '0', '183.82.96.158,183.82.118.63', '1', 'show');


#
# TABLE STRUCTURE FOR: type
#

DROP TABLE IF EXISTS `type`;

CREATE TABLE `type` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `tcondition` longtext NOT NULL,
  `tformat` longtext NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `type` (`tid`, `type`, `tcondition`, `tformat`) VALUES ('1', 'image', '<div class=\'col-md-3 mb\'><select name=\"icrop\" class=\"form-control\" id=\"gpsImage\" required>\r\n   <option value=\"\" selected>Select Type</option>\r\n   <option value=\"manual_crop\">Manual Crop</option>\r\n <option value=\"ratio_crop\">Ratio Crop</option>\r\n  <option value=\"crop\">Crop</option>\r\n</select></div>', '<div class=\"col-sm-3 mb\"><input class=\"form-control\" name=\"ct_width\" placeholder=\"Width\" required ></div><div class=\"col-sm-2 mb\"><input class=\"form-control\" name=\"ct_height\" placeholder=\"Height\" required ></div>');
INSERT INTO `type` (`tid`, `type`, `tcondition`, `tformat`) VALUES ('2', 'file', '<div class=\'col-md-3 mb\'><select name=\"frename\" class=\"form-control\" id=\"gpsFile\" required>    <option value=\"\" selected>Select Type</option>    <option value=\"not_rename\">Not Rename</option>    <option value=\"rename\">Rename</option> </select></div>', '');
INSERT INTO `type` (`tid`, `type`, `tcondition`, `tformat`) VALUES ('3', 'password', '<div class=\'col-md-3 mb\'><select name=\"pencrypt\" class=\"form-control\" >    <option value=\"\" selected>None</option>    <option value=\"md5\">MD5</option>    <option value=\"sha1\">SHA1</option> </select></div>', '');
INSERT INTO `type` (`tid`, `type`, `tcondition`, `tformat`) VALUES ('4', 'select', '<div class=\'col-md-3 mb\'><select name=\"stype\" class=\"form-control\" required>    <option value=\"\" selected>Select Type</option>    <option value=\"select\">Select</option>    <option value=\"multiselect\">Multiselect</option> </select></div>', '<div class=\"col-sm-3 mb\"><input class=\"form-control\" name=\"s_selected\" placeholder=\"example\"></div><div class=\"col-sm-4 mb\"><input class=\"form-control\" name=\"s_options\" placeholder=\"example1,example2\" required ></div>');
INSERT INTO `type` (`tid`, `type`, `tcondition`, `tformat`) VALUES ('5', 'datetime', '<div class=\'col-md-3 mb\'><select name=\"dtype\" class=\"form-control\" required ><option value=\"\" selected>Select Type</option><option value=\"datetime\">Date Time</option><option value=\"date\">Date</option></select></div>', '');
INSERT INTO `type` (`tid`, `type`, `tcondition`, `tformat`) VALUES ('6', 'textarea', '', '');
INSERT INTO `type` (`tid`, `type`, `tcondition`, `tformat`) VALUES ('7', 'int', '', '');
INSERT INTO `type` (`tid`, `type`, `tcondition`, `tformat`) VALUES ('8', 'remote_image', '<div class=\"col-sm-6 mb\"><input class=\"form-control\" name=\"links\" placeholder=\"http://www.example.com/uploads/\" required ></div>', '');
INSERT INTO `type` (`tid`, `type`, `tcondition`, `tformat`) VALUES ('9', 'thumbs', '<div class=\"col-sm-3 mb\"><input class=\"form-control\" name=\"small\" placeholder=\"small:width\" required ></div><div class=\"col-sm-2 mb\"><input class=\"form-control\" name=\"middle\" placeholder=\"middle:width\" required ></div><div class=\"col-sm-2 mb\"><input class=\"form-control\" name=\"big\" placeholder=\"big:width\" required ></div>', '');


