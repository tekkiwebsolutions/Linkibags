-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2020 at 08:30 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linkibag`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_users_attachment`
--

CREATE TABLE `additional_users_attachment` (
  `attach_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `attach_file` varchar(255) NOT NULL,
  `file_matter` text NOT NULL,
  `emails_invited` text NOT NULL,
  `emails_cancelled` text NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `uid` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `decrypt_pass` varchar(100) NOT NULL,
  `updated` int(11) NOT NULL,
  `lastlogin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`uid`, `username`, `password`, `decrypt_pass`, `updated`, `lastlogin`) VALUES
(1, 'admin', 'AdminP123', 'd11075ba35e9761b159f6b3cf9abca4e', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_ads`
--

CREATE TABLE `admin_ads` (
  `aid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `photo_path` varchar(100) NOT NULL,
  `img_url` varchar(100) NOT NULL,
  `num_of_clicks` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `expiration_date` date NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_ads`
--

INSERT INTO `admin_ads` (`aid`, `uid`, `photo_path`, `img_url`, `num_of_clicks`, `status`, `expiration_date`, `created`, `updated`) VALUES
(2, 0, 'files/commercial_ads/howitworks3.jpg', 'http://linkibag.com', 11, 1, '2017-12-12', 1492499977, 1492499977),
(3, 0, 'files/commercial_ads/3rd-request.png', 'http://www.google.com', 1, 1, '2018-10-30', 1492500002, 1492500002);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT 'created-by',
  `cname` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=no,1=yes',
  `in_list` int(11) NOT NULL,
  `trending_cat` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL,
  `image` varchar(500) NOT NULL,
  `image_thumbnails` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cid`, `uid`, `cname`, `status`, `in_list`, `trending_cat`, `created_time`, `updated_time`, `image`, `image_thumbnails`) VALUES
(-2, 0, 'inbag', 1, 0, 0, 1458566668, 1522325425, 'files/default_folder/thumbnail/inbox.jpg', 'a:4:{s:8:\"original\";s:39:\"files/default_folder/original/inbox.jpg\";s:9:\"thumbnail\";s:40:\"files/default_folder/thumbnail/inbox.jpg\";s:6:\"medium\";s:37:\"files/default_folder/medium/inbox.jpg\";s:13:\"premium_image\";s:44:\"files/default_folder/premium_image/inbox.jpg\";}'),
(15, 0, 'Indox', 1, 1, 0, 1470400021, 1522316709, 'files/default_folder/thumbnail/computer-4.png', 'a:4:{s:8:\"original\";s:44:\"files/default_folder/original/computer-4.png\";s:9:\"thumbnail\";s:45:\"files/default_folder/thumbnail/computer-4.png\";s:6:\"medium\";s:42:\"files/default_folder/medium/computer-4.png\";s:13:\"premium_image\";s:49:\"files/default_folder/premium_image/computer-4.png\";}'),
(30, 0, 'Sent', 1, 1, 0, 1473166264, 1522325412, 'files/default_folder/thumbnail/sent.jpg', 'a:4:{s:8:\"original\";s:38:\"files/default_folder/original/sent.jpg\";s:9:\"thumbnail\";s:39:\"files/default_folder/thumbnail/sent.jpg\";s:6:\"medium\";s:36:\"files/default_folder/medium/sent.jpg\";s:13:\"premium_image\";s:43:\"files/default_folder/premium_image/sent.jpg\";}'),
(73, 0, 'Trash', 1, 1, 0, 1476881547, 1522325372, 'files/default_folder/thumbnail/trash.png', 'a:4:{s:8:\"original\";s:39:\"files/default_folder/original/trash.png\";s:9:\"thumbnail\";s:40:\"files/default_folder/thumbnail/trash.png\";s:6:\"medium\";s:37:\"files/default_folder/medium/trash.png\";s:13:\"premium_image\";s:44:\"files/default_folder/premium_image/trash.png\";}'),
(74, 0, 'Junk', 1, 1, 1, 1476881561, 1522325399, 'files/default_folder/thumbnail/junk.jpg', 'a:4:{s:8:\"original\";s:38:\"files/default_folder/original/junk.jpg\";s:9:\"thumbnail\";s:39:\"files/default_folder/thumbnail/junk.jpg\";s:6:\"medium\";s:36:\"files/default_folder/medium/junk.jpg\";s:13:\"premium_image\";s:43:\"files/default_folder/premium_image/junk.jpg\";}'),
(184, 0, 'Business', 1, 1, 1, 1536043670, 0, 'files/default_folder/thumbnail/images (1).jpg', 'a:4:{s:8:\"original\";s:44:\"files/default_folder/original/images (1).jpg\";s:9:\"thumbnail\";s:45:\"files/default_folder/thumbnail/images (1).jpg\";s:6:\"medium\";s:42:\"files/default_folder/medium/images (1).jpg\";s:13:\"premium_image\";s:49:\"files/default_folder/premium_image/images (1).jpg\";}'),
(185, 0, 'Travel', 1, 1, 1, 1536043733, 1536043817, 'files/default_folder/thumbnail/images (3).jpg', 'a:4:{s:8:\"original\";s:44:\"files/default_folder/original/images (3).jpg\";s:9:\"thumbnail\";s:45:\"files/default_folder/thumbnail/images (3).jpg\";s:6:\"medium\";s:42:\"files/default_folder/medium/images (3).jpg\";s:13:\"premium_image\";s:49:\"files/default_folder/premium_image/images (3).jpg\";}');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `url_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `contact_info_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `phone` int(11) NOT NULL,
  `company_name` text NOT NULL,
  `inquiry_about` varchar(100) NOT NULL,
  `existing_acc_type` varchar(100) NOT NULL,
  `exitsting_acc_no` varchar(100) NOT NULL,
  `general_inquiry_type` varchar(100) NOT NULL,
  `product_listing_type` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`contact_info_id`, `first_name`, `last_name`, `email_id`, `phone`, `company_name`, `inquiry_about`, `existing_acc_type`, `exitsting_acc_no`, `general_inquiry_type`, `product_listing_type`, `message`, `created`, `updated`, `status`) VALUES
(1, 'jasvinder', 'rana', 'jimmyrana786@gmail.com', 2147483647, '', 'Existing Account', 'Billing', '1458978', '', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1481181549, 1481181549, 1),
(2, 'sadfsda', 'sdfsd', 'sdfsdf45jimmyrana786@gmails.com', 2147483647, 'sdfsdf', 'Information Security Product Listing', '', '', '', 'Products with free trial versions', 'sadfsadf', 1481201408, 1481201408, 1),
(3, 'thisis', 'feliks', 'user2525@gmail.com', 23523525, 'none', 'New Account', '', '', '', '', 'message goes here message goes here message goes here message goes here message goes here message goes here message goes here message goes here message goes here message goes here message goes here', 1552715964, 1552715964, 1),
(4, '1234', '265', '99sukh@gmail.com', 2147483647, 'sdfsdf', 'New Account', '', '', '', '', 'dfsdvf', 1568843853, 1568843853, 1),
(5, 'Vikash', 'Singh', '99singh.vikash@gmail.com', 2147483647, 'TWS', 'New Account', '', '', '', '', 'your work is good', 1569597650, 1569597650, 1),
(6, 'vikash', 'Singh', '99singh.vikash@gmail.com', 2147483647, '', 'New Account', '', '', '', '', 'sdfsfsdfsdfsdfdsfs', 1569598092, 1569598092, 1),
(7, 'Dalvir', 'singh', 'dalvir4u@gmail.com', 2147483647, '', 'New Account', '', '', '', '', 'sdasdsa', 1569598302, 1569598302, 1),
(8, 'Dalvir', 'Singh', 'dalvir4u@gmail.com', 2147483647, '', 'New Account', '', '', '', '', 'dfsfsdfsdf', 1569598336, 1569598336, 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`) VALUES
(1, 'US', 'United States'),
(2, 'CA', 'Canada'),
(3, 'DZ', 'Algeria'),
(4, 'DS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua and Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'BN', 'Brunei Darussalam'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'AL', 'Albania'),
(39, 'CV', 'Cape Verde'),
(40, 'KY', 'Cayman Islands'),
(41, 'CF', 'Central African Republic'),
(42, 'TD', 'Chad'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (Keeling) Islands'),
(47, 'CO', 'Colombia'),
(48, 'KM', 'Comoros'),
(49, 'CG', 'Congo'),
(50, 'CK', 'Cook Islands'),
(51, 'CR', 'Costa Rica'),
(52, 'HR', 'Croatia (Hrvatska)'),
(53, 'CU', 'Cuba'),
(54, 'CY', 'Cyprus'),
(55, 'CZ', 'Czech Republic'),
(56, 'DK', 'Denmark'),
(57, 'DJ', 'Djibouti'),
(58, 'DM', 'Dominica'),
(59, 'DO', 'Dominican Republic'),
(60, 'TP', 'East Timor'),
(61, 'EC', 'Ecuador'),
(62, 'EG', 'Egypt'),
(63, 'SV', 'El Salvador'),
(64, 'GQ', 'Equatorial Guinea'),
(65, 'ER', 'Eritrea'),
(66, 'EE', 'Estonia'),
(67, 'ET', 'Ethiopia'),
(68, 'FK', 'Falkland Islands (Malvinas)'),
(69, 'FO', 'Faroe Islands'),
(70, 'FJ', 'Fiji'),
(71, 'FI', 'Finland'),
(72, 'FR', 'France'),
(73, 'FX', 'France, Metropolitan'),
(74, 'GF', 'French Guiana'),
(75, 'PF', 'French Polynesia'),
(76, 'TF', 'French Southern Territories'),
(77, 'GA', 'Gabon'),
(78, 'GM', 'Gambia'),
(79, 'GE', 'Georgia'),
(80, 'DE', 'Germany'),
(81, 'GH', 'Ghana'),
(82, 'GI', 'Gibraltar'),
(83, 'GK', 'Guernsey'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard and Mc Donald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HK', 'Hong Kong'),
(97, 'HU', 'Hungary'),
(98, 'IS', 'Iceland'),
(99, 'IN', 'India'),
(100, 'IM', 'Isle of Man'),
(101, 'ID', 'Indonesia'),
(102, 'IR', 'Iran (Islamic Republic of)'),
(103, 'IQ', 'Iraq'),
(104, 'IE', 'Ireland'),
(105, 'IL', 'Israel'),
(106, 'IT', 'Italy'),
(107, 'CI', 'Ivory Coast'),
(108, 'JE', 'Jersey'),
(109, 'JM', 'Jamaica'),
(110, 'JP', 'Japan'),
(111, 'JO', 'Jordan'),
(112, 'KZ', 'Kazakhstan'),
(113, 'KE', 'Kenya'),
(114, 'KI', 'Kiribati'),
(115, 'KP', 'Korea, Democratic People\'s Republic of'),
(116, 'KR', 'Korea, Republic of'),
(117, 'XK', 'Kosovo'),
(118, 'KW', 'Kuwait'),
(119, 'KG', 'Kyrgyzstan'),
(120, 'LA', 'Lao People\'s Democratic Republic'),
(121, 'LV', 'Latvia'),
(122, 'LB', 'Lebanon'),
(123, 'LS', 'Lesotho'),
(124, 'LR', 'Liberia'),
(125, 'LY', 'Libyan Arab Jamahiriya'),
(126, 'LI', 'Liechtenstein'),
(127, 'LT', 'Lithuania'),
(128, 'LU', 'Luxembourg'),
(129, 'MO', 'Macau'),
(130, 'MK', 'Macedonia'),
(131, 'MG', 'Madagascar'),
(132, 'MW', 'Malawi'),
(133, 'MY', 'Malaysia'),
(134, 'MV', 'Maldives'),
(135, 'ML', 'Mali'),
(136, 'MT', 'Malta'),
(137, 'MH', 'Marshall Islands'),
(138, 'MQ', 'Martinique'),
(139, 'MR', 'Mauritania'),
(140, 'MU', 'Mauritius'),
(141, 'TY', 'Mayotte'),
(142, 'MX', 'Mexico'),
(143, 'FM', 'Micronesia, Federated States of'),
(144, 'MD', 'Moldova, Republic of'),
(145, 'MC', 'Monaco'),
(146, 'MN', 'Mongolia'),
(147, 'ME', 'Montenegro'),
(148, 'MS', 'Montserrat'),
(149, 'MA', 'Morocco'),
(150, 'MZ', 'Mozambique'),
(151, 'MM', 'Myanmar'),
(152, 'NA', 'Namibia'),
(153, 'NR', 'Nauru'),
(154, 'NP', 'Nepal'),
(155, 'NL', 'Netherlands'),
(156, 'AN', 'Netherlands Antilles'),
(157, 'NC', 'New Caledonia'),
(158, 'NZ', 'New Zealand'),
(159, 'NI', 'Nicaragua'),
(160, 'NE', 'Niger'),
(161, 'NG', 'Nigeria'),
(162, 'NU', 'Niue'),
(163, 'NF', 'Norfolk Island'),
(164, 'MP', 'Northern Mariana Islands'),
(165, 'NO', 'Norway'),
(166, 'OM', 'Oman'),
(167, 'PK', 'Pakistan'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestine'),
(170, 'PA', 'Panama'),
(171, 'PG', 'Papua New Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Peru'),
(174, 'PH', 'Philippines'),
(175, 'PN', 'Pitcairn'),
(176, 'PL', 'Poland'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'RE', 'Reunion'),
(181, 'RO', 'Romania'),
(182, 'RU', 'Russian Federation'),
(183, 'RW', 'Rwanda'),
(184, 'KN', 'Saint Kitts and Nevis'),
(185, 'LC', 'Saint Lucia'),
(186, 'VC', 'Saint Vincent and the Grenadines'),
(187, 'WS', 'Samoa'),
(188, 'SM', 'San Marino'),
(189, 'ST', 'Sao Tome and Principe'),
(190, 'SA', 'Saudi Arabia'),
(191, 'SN', 'Senegal'),
(192, 'RS', 'Serbia'),
(193, 'SC', 'Seychelles'),
(194, 'SL', 'Sierra Leone'),
(195, 'SG', 'Singapore'),
(196, 'SK', 'Slovakia'),
(197, 'SI', 'Slovenia'),
(198, 'SB', 'Solomon Islands'),
(199, 'SO', 'Somalia'),
(200, 'ZA', 'South Africa'),
(201, 'GS', 'South Georgia South Sandwich Islands'),
(202, 'ES', 'Spain'),
(203, 'LK', 'Sri Lanka'),
(204, 'SH', 'St. Helena'),
(205, 'PM', 'St. Pierre and Miquelon'),
(206, 'SD', 'Sudan'),
(207, 'SR', 'Suriname'),
(208, 'SJ', 'Svalbard and Jan Mayen Islands'),
(209, 'SZ', 'Swaziland'),
(210, 'SE', 'Sweden'),
(211, 'CH', 'Switzerland'),
(212, 'SY', 'Syrian Arab Republic'),
(213, 'TW', 'Taiwan'),
(214, 'TJ', 'Tajikistan'),
(215, 'TZ', 'Tanzania, United Republic of'),
(216, 'TH', 'Thailand'),
(217, 'TG', 'Togo'),
(218, 'TK', 'Tokelau'),
(219, 'TO', 'Tonga'),
(220, 'TT', 'Trinidad and Tobago'),
(221, 'TN', 'Tunisia'),
(222, 'TR', 'Turkey'),
(223, 'TM', 'Turkmenistan'),
(224, 'TC', 'Turks and Caicos Islands'),
(225, 'TV', 'Tuvalu'),
(226, 'UG', 'Uganda'),
(227, 'UA', 'Ukraine'),
(228, 'AE', 'United Arab Emirates'),
(229, 'GB', 'United Kingdom'),
(230, 'AF', 'Afghanistan'),
(231, 'UM', 'United States minor outlying islands'),
(232, 'UY', 'Uruguay'),
(233, 'UZ', 'Uzbekistan'),
(234, 'VU', 'Vanuatu'),
(235, 'VA', 'Vatican City State'),
(236, 'VE', 'Venezuela'),
(237, 'VN', 'Vietnam'),
(238, 'VG', 'Virgin Islands (British)'),
(239, 'VI', 'Virgin Islands (U.S.)'),
(240, 'WF', 'Wallis and Futuna Islands'),
(241, 'EH', 'Western Sahara'),
(242, 'YE', 'Yemen'),
(243, 'YU', 'Yugoslavia'),
(244, 'ZR', 'Zaire'),
(245, 'ZM', 'Zambia'),
(246, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_disount`
--

CREATE TABLE `coupon_disount` (
  `discount_id` int(11) NOT NULL,
  `coupon_code` varchar(100) NOT NULL,
  `coupon_discount` float NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `created_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon_disount`
--

INSERT INTO `coupon_disount` (`discount_id`, `coupon_code`, `coupon_discount`, `status`, `created_date`, `created_time`, `updated_time`, `role`) VALUES
(2, 'LNJKs154545', 12, 1, '2017-04-21', 1492774654, 1492774654, 0),
(4, 'Links787889', 15, 1, '2017-04-21', 1492774882, 1492774882, 0);

-- --------------------------------------------------------

--
-- Table structure for table `friends_request`
--

CREATE TABLE `friends_request` (
  `request_id` int(11) NOT NULL,
  `request_by` int(11) NOT NULL,
  `request_to` varchar(100) NOT NULL,
  `request_email` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `request_code` varchar(40) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=pending request,1=confirm a friend request,2=declined',
  `request_time` int(11) NOT NULL,
  `request_time1` int(11) NOT NULL,
  `request_time2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends_request`
--

INSERT INTO `friends_request` (`request_id`, `request_by`, `request_to`, `request_email`, `description`, `request_code`, `status`, `request_time`, `request_time1`, `request_time2`) VALUES
(3, 6, '7', 'tt.harpreet.kaur@gmail.com', 'Join Linkibag', '_(qynGAx2zKq4xu99H', 0, 1578034978, 0, 0),
(10, 6, 'mws.rajdeep.singh@gmail.com', 'mws.rajdeep.singh@gmail.com', 'I would like to invite you to join Linkibag.', 'DEC{I{ah!CJK5zqayb', 0, 1578048674, 0, 0),
(11, 6, '9', 'tt.harpreet.kaur@gmail.com', 'I would like to invite you to join Linkibag.', 'IXwMsH!XDu38_HUJSt', 0, 1578048740, 0, 0),
(12, 6, '9', 'tt.harpreet.kaur@gmail.com', 'I would like to invite you to join Linkibag.', 'SUI7aPXs1fmJhLuH{8', 0, 1578048797, 0, 0),
(13, 6, '9', 'tt.harpreet.kaur@gmail.com', 'I would like to invite you to join Linkibag.', 'JablzIQSK94J6{o1pB', 0, 1578048842, 0, 0),
(14, 9, 'mws.rajdeep.singh@gmail.com', 'mws.rajdeep.singh@gmail.com', 'I would like to invite you to join Linkibag.', 'MT93c7D7X!LFOC_db)', 0, 1578048976, 0, 0),
(15, 6, 'mws.rajdeep.singh@gmail.com', 'mws.rajdeep.singh@gmail.com', 'I would like to invite you to join Linkibag.', 'TNW}cvnKs{jnug4vjB', 0, 1578049101, 0, 0),
(16, 6, 'mws.rajdeep.singh@gmail.com', 'mws.rajdeep.singh@gmail.com', 'I would like to invite you to join Linkibag.', 'Coyhxjj7bPTMUkUI7m', 0, 1578049357, 0, 0),
(17, 9, 'mws.rajdeep.singh@gmail.com', 'mws.rajdeep.singh@gmail.com', 'I would like to invite you to join Linkibag.', 'zGD1sqzJ6sO{tABVsS', 0, 1578049542, 0, 0),
(18, 9, 'mws.rajdeep.singh@gmail.com', 'mws.rajdeep.singh@gmail.com', 'I would like to invite you to join Linkibag.', 'byVl9IaHGPbPWz!L1y', 0, 1578049558, 0, 0),
(19, 6, 'tt.harpreet.kaur@gmail.com', 'tt.harpreet.kaur@gmail.com', 'I would like to invite you to join Linkibag.', '(jn1z40r0kt)DqNEC{', 0, 1578049734, 0, 0),
(20, 6, 'tt.harpreet.kaur@gmail.com', 'tt.harpreet.kaur@gmail.com', 'I would like to invite you to join Linkibag.', 'K)ZD!8x4t9rH_l3yrA', 0, 1578050027, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `friends` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `defaults` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `uid`, `group_name`, `friends`, `created`, `updated`, `status`, `defaults`) VALUES
(-2, 0, 'Spam', '', 1470311071, 1470311071, 1, 0),
(-1, 0, 'Blocked', '', 1470311071, 1470311071, 1, 0),
(0, 0, 'Ungrouped', '', 1470311071, 1470311071, 1, 0),
(2, 5, 'My First Group', '', 1575893673, 1575893673, 1, 1),
(3, 6, 'My First Group', '', 1578027448, 1578027448, 1, 1),
(4, 7, 'My First Group', '', 1578030038, 1578030038, 1, 1),
(5, 6, 'Test New Share Group', '', 1578034978, 1578034978, 1, 0),
(6, 8, 'My First Group', '', 1578035550, 1578035550, 1, 1),
(7, 9, 'My First Group', '', 1578048949, 1578048949, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups_friends`
--

CREATE TABLE `groups_friends` (
  `groups_friends_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `groups` int(11) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups_friends`
--

INSERT INTO `groups_friends` (`groups_friends_id`, `uid`, `groups`, `email_id`, `created`, `updated`, `status`) VALUES
(1, 6, 5, '7', 1578034978, 1578034978, 1),
(2, 6, 5, 'mws.rajdeep.singh@gmail.com', 1578034978, 1578034978, 1);

-- --------------------------------------------------------

--
-- Table structure for table `info_security_links`
--

CREATE TABLE `info_security_links` (
  `info_security_link_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT 'created-by,0=admin',
  `info_security_company_name` text NOT NULL,
  `info_security_url_value` varchar(255) NOT NULL,
  `info_security_notes` text NOT NULL,
  `info_security_txt` text NOT NULL,
  `info_security_photo` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `info_security_start_date` datetime NOT NULL,
  `updated_time` int(11) NOT NULL,
  `info_security_end_date` datetime NOT NULL,
  `info_security_type` int(11) NOT NULL COMMENT '0=free,1=paid'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `info_security_links`
--

INSERT INTO `info_security_links` (`info_security_link_id`, `uid`, `info_security_company_name`, `info_security_url_value`, `info_security_notes`, `info_security_txt`, `info_security_photo`, `status`, `created_time`, `info_security_start_date`, `updated_time`, `info_security_end_date`, `info_security_type`) VALUES
(125, 0, 'linkibag', 'https://linkibag.com/linkibag', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.', 'files/info_security_links/slide-0.png', 1, 1481199451, '2016-12-08 00:00:00', 1481199451, '2016-12-09 00:00:00', 0),
(126, 0, 'demo company', 'https://linkibag.com/linkibag/index.php', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the', 'demo', 'files/info_security_links/Tulips.jpg', 1, 1481199410, '2016-12-10 00:00:00', 1481199410, '2016-12-13 00:00:00', 0),
(127, 0, 'demo company', 'yahoo.com', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the', 'demo2 paid', 'files/info_security_links/slide-1.png', 1, 1481180896, '2016-12-08 00:00:00', 1481180896, '2016-12-09 00:00:00', 1),
(128, 0, 'demo company', 'https://gmail.com/', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the', 'demo3 paid', 'files/info_security_links/Generic_icon_HIGH RES.png', 1, 1481198806, '2016-12-08 00:00:00', 1481198806, '2016-12-08 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `interested_category`
--

CREATE TABLE `interested_category` (
  `interested_cat` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT 'created-by',
  `cat` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=no,1=yes',
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `interested_category`
--

INSERT INTO `interested_category` (`interested_cat`, `uid`, `cat`, `status`, `created`, `updated`) VALUES
(1, 0, '74', 1, 1490868549, 1490868549),
(2, 0, '73', 1, 1490868549, 1490868549),
(3, 0, '30', 1, 1490868549, 1490868549),
(4, 0, '15', 1, 1490868549, 1490868549),
(5, 0, '74', 1, 1492751998, 1492751998),
(6, 0, '73', 1, 1492751998, 1492751998),
(7, 0, '30', 1, 1492751998, 1492751998),
(8, 0, '74', 1, 1496140529, 1496140529),
(9, 0, '73', 1, 1496140529, 1496140529),
(10, 0, '30', 1, 1496140529, 1496140529),
(25, 0, '74', 1, 1522324399, 1522324399),
(26, 0, '73', 1, 1522324399, 1522324399),
(27, 0, '30', 1, 1522324399, 1522324399),
(28, 0, '74', 1, 1522324427, 1522324427),
(29, 0, '73', 1, 1522324427, 1522324427),
(31, 0, '-2', 1, 1522324427, 1522324427),
(32, 0, '30', 1, 1522324446, 1522324446),
(33, 0, '15', 1, 1522324446, 1522324446),
(34, 0, '-2', 1, 1522324446, 1522324446),
(35, 0, '30', 1, 1522324488, 1522324488),
(36, 0, '15', 1, 1522324488, 1522324488),
(37, 0, '-2', 1, 1522324488, 1522324488),
(38, 0, '74', 1, 1522327953, 1522327953),
(39, 0, '73', 1, 1522327953, 1522327953),
(40, 0, '-2', 1, 1522327953, 1522327953);

-- --------------------------------------------------------

--
-- Table structure for table `linkibag_service_countries`
--

CREATE TABLE `linkibag_service_countries` (
  `service_id` int(11) NOT NULL,
  `outside_service_text` text NOT NULL,
  `allowed_counties` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `linkibag_service_countries`
--

INSERT INTO `linkibag_service_countries` (`service_id`, `outside_service_text`, `allowed_counties`) VALUES
(1, 'Based on provided information you are located outside of our service area. Please share your email address and we will contact you when service will be available in your region.', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}');

-- --------------------------------------------------------

--
-- Table structure for table `linkibooks`
--

CREATE TABLE `linkibooks` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `book_subtitle` varchar(255) NOT NULL,
  `pdf_size` double NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `linkibook_shared`
--

CREATE TABLE `linkibook_shared` (
  `shared_id` int(11) NOT NULL,
  `share_number` int(11) NOT NULL,
  `shared_by` int(11) NOT NULL,
  `shared_to` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `linkibook_urls`
--

CREATE TABLE `linkibook_urls` (
  `bookurl_id` int(11) NOT NULL,
  `linkibook_id` int(11) NOT NULL,
  `url_id` int(11) NOT NULL,
  `url_title` varchar(255) NOT NULL,
  `url_subtitle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `newsletters_id` int(11) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `newsletters`
--

INSERT INTO `newsletters` (`newsletters_id`, `email_id`, `subject`, `message`, `created`, `updated`, `status`) VALUES
(1, 'sasdfa@asdafs.com', 'Newsletter at Linkibag', 'Dear sir sasdfa@asdafs.com wants to connect you.', 1518449774, 1518449774, 1),
(2, 'jimmyrana786+786@gmail.com', 'Newsletter at Linkibag', 'Dear sir jimmyrana786+786@gmail.com wants to connect you.', 1518610361, 1518610361, 1),
(3, 'sadfsa@asfda.com', 'Newsletter at Linkibag', 'Dear sir sadfsa@asfda.com wants to connect you.', 1519003101, 1519003101, 1),
(4, 'jimmyrana786@gmail.com', 'Newsletter at Linkibag', 'Dear sir jimmyrana786@gmail.com wants to connect you.', 1519114650, 1519114650, 1),
(5, 'jimmyrana786+12@gmail.com', 'Newsletter at Linkibag', 'Dear sir jimmyrana786+12@gmail.com wants to connect you.', 1519115175, 1519115175, 1),
(6, 'jimmyrana786+154@gmail.com', 'Newsletter at Linkibag', 'Dear sir jimmyrana786+154@gmail.com wants to connect you.', 1519115805, 1519115805, 1),
(7, 'thisisexample@notworking.com', 'Newsletter at Linkibag', 'Dear sir thisisexample@notworking.com wants to connect you.', 1520722416, 1520722416, 1),
(8, 'dalvir4u@gmail.com', 'Newsletter at Linkibag', 'Dear sir dalvir4u@gmail.com wants to connect you.', 1521181218, 1521181218, 1),
(9, 'fkravets@usa.net', 'Newsletter at Linkibag', 'Dear sir fkravets@usa.net wants to connect you.', 1552720772, 1552720772, 1),
(10, 'iamsewak@gmail.com', 'Newsletter at Linkibag', 'Dear sir iamsewak@gmail.com wants to connect you.', 1558422529, 1558422529, 1),
(11, 'iam@gmail.com', 'Newsletter at Linkibag', 'Dear sir iam@gmail.com wants to connect you.', 1558423435, 1558423435, 1),
(12, 'iamlinkiuser@gmail.com', 'Newsletter at Linkibag', 'Dear sir iamlinkiuser@gmail.com wants to connect you.', 1558426769, 1558426769, 1),
(13, '99singh.vikash@gmail.com', 'Newsletter at Linkibag', 'Dear sir 99singh.vikash@gmail.com wants to connect you.', 1569612715, 1569612715, 1),
(14, 'vik99@gmail.com', 'Newsletter at Linkibag', 'Dear sir vik99@gmail.com wants to connect you.', 1569612738, 1569612738, 1),
(15, 'dalbeer.singh.tt+3@gmail.com', 'Newsletter at Linkibag', 'Dear sir dalbeer.singh.tt+3@gmail.com wants to connect you.', 1576588569, 1576588569, 1),
(16, 'dalbeer.singh.tt@gmail.com', 'Newsletter at Linkibag', 'Dear sir dalbeer.singh.tt@gmail.com wants to connect you.', 1578006357, 1578006357, 1),
(17, 'dalbeer.singh@gmail.com', 'Newsletter at Linkibag', 'Dear sir dalbeer.singh@gmail.com wants to connect you.', 1578006645, 1578006645, 1);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscription`
--

CREATE TABLE `newsletter_subscription` (
  `subscribe_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  `subscribe_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `outside_linkibag_service_area`
--

CREATE TABLE `outside_linkibag_service_area` (
  `service_area_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `country` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `page_body` text NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `title`, `page_body`, `created`, `updated`, `status`) VALUES
(1, 'Free personal accounts', '<p>Individual accounts are easy to set up, easy to use, and free. Click the &ldquo;Free Signup&rdquo; link to start using LinkiBag today. Drop your first links into your LinkiBag and see how easy and convenient it is. Store and group your links inside of your LinkiBag for future use. Share any of your links with your friends or family.</p>\r\n<!--\r\n<p>Feel like sharing with the world? Select â€œadd to public bagâ€ to send the link to the editor.</p>-->', 0, 1534142155, 1),
(2, 'Free professional accounts', '<p>With your LinkiBag business account, you get the ability to store and share internet links with your associates or business partners. Store links to use for business references, hiring, purchasing, or future business-development ideas. Set user groups to share with staff or clients.</p>\r\n\r\n<p>Get your web sources mobile and organized in our secure and fast environment. Make LinkiBag work for you and your business. Send any of your links to be added to our web public library to share with business owners like you.</p>\r\n', 0, 1534142140, 1),
(3, 'Institutional accounts', '<p>A LinkiBag educational account can be your best web tool to save internet links to resources for the courses you are teaching or developing. Set user groups to share any of your links with your colleagues, dissertation committee members, or students.</p>\r\n\r\n<p>LinkiBag is fast and simple to use. Get your web sources organized and take them with you wherever you go online. Send us any link to be added to our web public library. Make LinkiBag work for you to meet your teaching and research needs.</p>\r\n', 0, 1534142120, 1),
(4, 'About us', '<p>LinkiBag.com is the bag to keep your links.</p>\r\n\r\n<p>Build your personal library of important web sources for any type of use. Keep your links private or share any of them with your LinkiBag friends. Great for institutional, research and commercial storage and sharing of web sources. Save your links and keep them with you wherever you go.</p>\r\n', 0, 1534142109, 1),
(5, 'How it works', '<p><strong>A.</strong> Create your FREE LinkiBag account today. Save your favorite links. Access your<br />\r\nLinkiBag from wherever you go.</p>\r\n\r\n<p><strong>B.</strong> Organize your links: separate links by placing them under different<br />\r\ncategories. It is easier than you think.</p>\r\n\r\n<p><strong>C.</strong> Share things you like: share your favorite links you like with a friend or a group.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Great for personal and professional use.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 0, 1534142100, 1),
(6, 'Linkidrops accounts', '<p>Market your products or services to LinkiBag users. Let us drop your links into users&#39; LinkiBags. Drop links by users&#39; zip codes or group names. Your link and short content description will appear on each user&#39;s list of links following the links that the user has stored. We do not access or share users&#39; links. LinkiBag accesses users&#39; LinkiTabs, which are the name tags that users place to categorize their groups. Target prospective clients by using specific LinkiTabs. Contact us <a href=\"index.php?p=contact-us\">for more information.</a></p>\r\n', 1470467037, 1534142085, 1),
(7, 'Personal FAQs', '<ul>\r\n	<li>\r\n	<h3>1. What types of accounts are offered by LinkiBag?</h3>\r\n	</li>\r\n	<li>\r\n	<p>To learn more about personal and commercial LinkiBag account types, <a href=\"index.php?p=free-personal-accounts\">click here.</a></p>\r\n	</li>\r\n	<li>\r\n	<h3>2. How can I obtain pricing information?</h3>\r\n	</li>\r\n	<li>\r\n	<p>LinkiBag accounts accounts are free. Click on the orange \"Free Signup\" link in the header area of the LinkiBag homepage to sign up. LinkiBag business solutions are tailored to your professional and educational needs.</p>\r\n	</li>\r\n	<li>\r\n	<h3>3. What do I need to sign up for my free personal account?</h3>\r\n	</li>\r\n	<li>\r\n	<p>You must be at least 18 years old and have a valid personal email account.</p>\r\n	</li>\r\n	<li>\r\n	<h3>4. What should I do if I forgot my password?</h3>\r\n	</li>\r\n	<li>\r\n	<p>Simply click on the &quot;Forgot password?&quot; link located on the <a href=\"index.php?p=login\">login</a> page.</p>\r\n	</li>\r\n	<li>\r\n	<h3>5. How do I update my account information?</h3>\r\n	</li>\r\n	<li>\r\n	<p>To update your account information, select the &quot;<a href=\"index.php?p=login\">My Account</a>&quot; link located in the right corner of your top blue header. You must be logged in to view this option.</p>\r\n	</li>\r\n</ul>\r\n', 1470467389, 1512110363, 1),
(8, 'Terms of Use', '<h4 style=\"text-align: justify;\"><strong>By accessing or using any part of the site, you agree to be bound by the following Terms of Use</strong></h4>\r\n\r\n<p style=\"text-align:justify\"><strong>1. Acknowledgment and Acceptance</strong></p>\r\n\r\n<p style=\"text-align:justify\">LinkiBag Inc. (&ldquo;LinkiBag&rdquo;) provides the use of this LinkiBag web site (located at <a href=\"http://www.linkibag.com/\">www.LinkiBag.com</a><u>)</u> (&ldquo;Web Site&rdquo;) to you, conditioned upon your acceptance without modification of the following terms and conditions (&ldquo;Terms of Use&rdquo;). This Web Site and its contents are designed specifically to comply with U.S. laws and regulations. LinkiBag makes no claims regarding access or use of the Site or content on the Site outside of the United States. If you use or access the Web Site or Web Site content outside of the United States, you do so at your own risk and are responsible for compliance with the laws and regulations of your jurisdiction as well as these Terms of Use. You warrant that you will abide by, without limitation, all applicable local, state, national and international laws and regulations with respect to your use of the Web Site and not interfere with the use and enjoyment of the Web Site by other users or with the operation and management of the Web Site.</p>\r\n\r\n<p style=\"text-align:justify\">Please review these Terms of Use carefully. By using the LinkiBag Web Site you consent that you agree to these Terms of Use. If you do not agree or do not wish to abide by or cannot comply with these Terms of Use, you must: (1) not use or access the Web Site; (2) not use any of our services; and (3) not consume, use or download any content and/or materials. If you breach any of the terms of these Terms of Use, your authorization to use this Web Site and any content located on the Web Site shall automatically terminate and you must immediately cease using this Web Site and any content located on the Web Site, and destroy any and all copied downloaded and printed Web Site content and material.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><strong>2. Use of LinkiBag Web Site Intended for Users 13 Years of Age or Older</strong></p>\r\n\r\n<p style=\"text-align:justify\">The LinkiBag Web Site is intended for use strictly by individuals 13 years of age or older. The LinkiBag Web Site is not directed for use by children under the age of 13.&nbsp; Users under the age of 13 must be assisted by a parent or guardian to use the LinkiBag Web Site. LinkiBag.com. For more information about the Children&rsquo;s Online Privacy Protection Act (COPPA), please visit www.ftc.gov.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><strong>3. Modification of These Terms of Use</strong></p>\r\n\r\n<p style=\"text-align:justify\">LinkiBag reserves the right to change the terms, conditions, and notices under which the LinkiBag Web Site is offered, including but not limited to the charges associated with the use of the LinkiBag, at any time, without liability or prior notice.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\">4. <strong>Accounts, Passwords and Security</strong></p>\r\n\r\n<p style=\"text-align:justify\">Certain features or services offered on or through the Web Site may require you to open an account (including setting up an LinkiBag ID and password). You are entirely responsible for maintaining the confidentiality of the information you hold for your account, including your password, and for any and all activity that occurs under your account as a result of your failing to keep this information secure and confidential. You agree to notify LinkiBag immediately of any unauthorized use of your account or password, or any other breach of security. You may be held liable for losses incurred by LinkiBag or any other user of or visitor to the Web Site due to someone else using your LinkiBag ID, password or account as a result of your failing to keep your account information secure and confidential.</p>\r\n\r\n<p style=\"text-align:justify\">You may not use anyone else&rsquo;s LinkiBag ID, password or account at any time without the express permission and consent of the holder of that LinkiBag ID, password or account. LinkiBag cannot and will not be liable for any loss or damage arising from your failure to comply with these obligations.</p>\r\n\r\n<p style=\"text-align:justify\">TO THE GREATEST EXTENT PERMISSIBLE BY APPLICABLE LAW, LINKIBAG AND ITS VENDORS DO NOT GUARANTEE OR WARRANT THAT ANY CONTENT YOU MAY STORE OR ACCESS THROUGH THE SERVICE WILL NOT BE SUBJECT TO INADVERTENT DAMAGE, CORRUPTION, LOSS, OR REMOVAL IN ACCORDANCE WITH THE TERMS OF THIS AGREEMENT, AND LINKIBAG AND ITS VENDORS SHALL NOT BE RESPONSIBLE SHOULD SUCH DAMAGE, CORRUPTION, LOSS, OR REMOVAL OCCUR.&nbsp; You are responsible for backing up, to your own computer or other device, any content that you store or access via the Web Site, including important documents, data, images, messages and other information.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><strong>4. Intellectual Property Rights</strong></p>\r\n\r\n<p style=\"text-align:justify\">All contents, text, images, data, information and other material displayed, available or present on the LinkiBag Web Site, including any trademarks or copyrights, are the property of LinkiBag or the designated owner and are protected by applicable intellectual property laws. You agree not to infringe upon or dilute any intellectual property of LinkiBag, as well as not to remove or modify any trademark, copyright or other proprietary notice appearing on the LinkiBag Web Site. You are not allowed to link to, reproduce, sell, publish, distribute, modify, or display the LinkiBag Web Site or any Content without the prior written permission of LinkiBag.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><strong>5. Authorized and Prohibited Uses</strong></p>\r\n\r\n<p style=\"text-align:justify\">As a condition of your use of the LinkiBag Web Site, you warrant to LinkiBag that you will not use the LinkiBag Web Site for any purpose that is unlawful or prohibited by these Terms of Use, including without limitation, any violations of any third-parties&rsquo; intellectual property.&nbsp; You may not use the LinkiBag Web Site in any manner which could damage, disable, overburden, or impair the LinkiBag Web Site or interfere with any other party&rsquo;s use and enjoyment of the LinkiBag Web Site.&nbsp; You may not obtain or attempt to obtain any materials or information through any means not intentionally made available or provided for through the LinkiBag Web Site. Any violation of the foregoing shall lead to the immediate termination of your account and access to this Web Site and any other action as deemed appropriate by LinkiBag.&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><strong>6. Links to Third Party </strong></p>\r\n\r\n<p style=\"text-align:justify\">The LinkiBag Web Site and LinkiBag portal may contain links to other web sites provided by LinkiBag or sponsored and/or provided by third-party advertisers or LinkiBag may provide your information to other third-parties who then will provide their own weblinks to you (collectively, &ldquo;Linked Site(s)&rdquo;).&nbsp; The Linked Sites shared by LinkiBag users or other third-party advertisers are not under the control of LinkiBag and LinkiBag is not responsible for the contents of any Linked Site (including without limitation, any infected weblinks, illegal solicitation of products or services, malicious websites containing viruses and financial or marketing scams), or any changes or updates to a Linked Site.&nbsp; Each Linked Site is subject to and governed by its own respective terms and conditions of use and privacy policy and is in no way associated with this Web Site, these Terms of Use or Privacy Policy. It is your responsibility to review and understand your rights, obligations and restrictions in using these Linked Sites. LinkiBag is not responsible for webcasting or any other form of transmission received from any Linked Site.&nbsp; LinkiBag is providing these links to you only as a convenience, and the inclusion of any link does not imply endorsement by LinkiBag of the Linked Site or any association with its operators.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><strong>7. Limitation of Liability and Disclaimers&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></p>\r\n\r\n<p style=\"text-align:justify\">Any and all content appearing on the LinkiBag Web Site is provided for informational purposes only. The LinkiBag Web Site, its content and its links are provided on an &ldquo;As Is&rdquo;, &ldquo;As Available&rdquo; basis and are used only at your sole risk, to the fullest extent permissible by law. LinkiBag, its parent, and affiliated companies disclaim all warranties, express or implied, of any kind, regarding the LinkiBag Web Site (including its content, hardware, software and links), including as to fitness for a particular purpose, merchantability, title, non-infringement, results, accuracy, completeness, accessibility, compatibility, security and freedom from computer virus. LinkiBag, its parent, and its affiliated companies will not be liable for any damages or losses, including direct, indirect, consequential, special, incidental or punitive damages and/or lost profits, in connection with use of the Internet, the LinkiBag Web Site and Privacy Policy, its content or its links.<strong> </strong></p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><strong>8. Indemnification</strong></p>\r\n\r\n<p style=\"text-align:justify\">You will defend, indemnify and hold harmless LinkiBag<strong>, </strong>its parent<strong>,</strong> and its affiliates, officers, directors, employees and contractors from any demands, claims, damages, liabilities, expenses or harms, including attorneys&rsquo; fees, arising in connection with your use of the LinkiBag Web Site, online conduct, breach of these Terms of Use or dealings or transactions with other persons resulting from use of the LinkiBag Web Site.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><strong>9. Termination/Access Restriction</strong></p>\r\n\r\n<p style=\"text-align:justify\">LinkiBag reserves the right, in its sole discretion, to terminate your access to the LinkiBag Web Site and the related services or any portion thereof at any time, without notice. Use of the LinkiBag Web Site is unauthorized in any jurisdiction that does not give effect to all provisions of these Terms of Use, including without limitation this paragraph. You agree that no joint venture, partnership, employment, or agency relationship exists between you and LinkiBag as a result of this agreement or use of the LinkiBag Web Site. LinkiBag&rsquo;s performance of this agreement is subject to existing laws and legal processes, and nothing contained in this agreement is in derogation of LinkiBag&rsquo;s right to comply with governmental, court and law enforcement requests or requirements relating to your use of the LinkiBag Web Site or information provided to or gathered by LinkiBag with respect to such use.</p>\r\n\r\n<p style=\"text-align:justify\">If any part of this agreement is determined to be invalid or unenforceable pursuant to applicable law including, but not limited to, the warranty disclaimers and liability limitations set forth above, then the invalid or unenforceable provision will be deemed superseded by a valid, enforceable provision that most closely matches the intent of the original provision and the remainder of the agreement shall continue in effect.</p>\r\n\r\n<p style=\"text-align:justify\">Unless otherwise specified herein, this agreement constitutes the entire agreement between the user and LinkiBag with respect to the LinkiBag Web Site and it supersedes all prior or contemporaneous communications and proposals, whether electronic, oral or written, between the user and LinkiBag with respect to the LinkiBag Web Site. A printed version of this agreement and of any notice given in electronic form shall be admissible in judicial or administrative proceedings based upon or relating to this agreement to the same extent and subject to the same conditions as other business documents and records originally generated and maintained in printed form. It is the express wish of the parties that this agreement and all related documents be drawn up in English.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><strong>10. </strong><strong>Governing Law and Jurisdiction </strong><br />\r\nThis website and your use of the contents of this website shall be governed by and in accordance with the internal laws of the State of Delaware, without regard to rules of conflicts of law or choice of law, and by the federal laws of the United States. For all legal proceedings related to this website, by using this website you agree that any legal filings, proceedings, and adjudication will be in the state and federal courts of Delaware. You also agree to the exclusive jurisdiction of state and federal courts in the state of Delaware sitting in New Castle County.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><strong>11. Miscellaneous Provisions</strong></p>\r\n\r\n<p style=\"text-align:justify\">You represent and warrant that you are authorized to enter into these Terms of Use on behalf of any entity which you represent. These Terms of Use may only be modified by LinkiBag, at its sole discretion. Your obligations pursuant to these Terms of Use shall survive termination of the LinkiBag Web Site, any use by you of the LinkiBag Web Site and of its content, or these Terms of Use.</p>\r\n', 1470467587, 1566997335, 1),
(9, 'Privacy Policy', '<h4 style=\"text-align:justify\"><strong>By accessing or using any part of the site, you agree to be bound by the following Privacy Policy</strong></h4>\r\n\r\n<p style=\"text-align:justify\">BY USING THIS SITE, YOU SIGNIFY YOUR ACCEPTANCE OF THIS POLICY AND TERMS OF SERVICE (COLLECTIVELY, &ldquo;POLICY&rdquo;). &nbsp;IF YOU DO NOT AGREE TO THIS POLICY, YOU MAY NOT USE THIS SITE. &nbsp;YOUR CONTINUED USE OF THE SITE FOLLOWING ANY POSTING OF CHANGES TO THIS POLICY WILL BE DEEMED AS YOUR FULL AND COMPLETE ACCEPTANCE OF THOSE CHANGES.&nbsp;<br />\r\nThis Privacy Policy governs the manner in which LinkiBag Inc collects, uses, maintains and discloses information collected from users (each, a &ldquo;User&rdquo;) of the <a href=\"http://www.LinkiBag.com\">http://www.LinkiBag.com</a> website and any directly related LinkiBag Inc website (collectively, &ldquo;Site(s)&rdquo;). This privacy policy applies to the Site and all products and services offered by LinkiBag Inc. This Site and its contents are intended to comply with U.S. privacy laws and regulations. Although accessible by others, it and its content are intended for access and users residing in the U.S. only &nbsp;.</p>\r\n\r\n<p style=\"text-align:justify\"><br />\r\n<strong>Personal identification information</strong><br />\r\nWe may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users visit our site, register on the site, place an order, subscribe to or sign up for a newsletter, and in connection with other activities, services, features or resources we make available on our Site. Users may be asked for, as appropriate, name, email address, mailing address, phone number, and credit card information (e.g., credit card number, expiration date, security code billing information, contact information and other related information). &nbsp;Other information may be collected through third-party services such as PayPal or other online payment services. &nbsp;Use of any such services through our site shall be subject to the respective service&rsquo;s privacy policy, terms and conditions of use and any other application guidelines.</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;<br />\r\n<strong>Non-personal identification information</strong><br />\r\nWe may collect non-personal identification information about Users whenever they interact with our Site. Non-personal identification information may include the browser name, the type of computer and technical information about Users means of connection to our Site, such as the operating system and the Internet service providers utilized and other similar information.</p>\r\n\r\n<p style=\"text-align:justify\"><br />\r\n<strong>Children Under the Age of 13</strong><br />\r\nThe Site is not intended for children under 13 years of age. No one under age 13 may provide any personal information or other information to or on the Site. We do not knowingly collect personal information or other information from children under 13. If you are under 13, do not use or provide any information on this Site or on or through any of its features or register on the Site, make any purchases through the Site, use any of the interactive or public comment features of this Site or provide any information about yourself to us, including your name, address, telephone number, e-mail address or any screen name or user name you may use. If we learn we have collected or received personal information from a child under 13 without verification of parental consent, we will delete that information. If you believe we might have any information from or about a child under 13, please contact us at legal@LinkiBag.com. &nbsp;For more information about the Children&rsquo;s Online Privacy Protection Act (COPPA), please visit www.ftc.gov.</p>\r\n\r\n<p style=\"text-align:justify\"><br />\r\n<strong>Web browser cookies</strong><br />\r\nOur Site may use &ldquo;cookies&rdquo; to enhance User experience. User&rsquo;s web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. User may choose to set their web browser to refuse cookies, or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly. &nbsp;Pages of the Site and our e-mails may also contain small electronic files known as web beacons (also referred to as clear gifs. pixel tags and single-pixel gifs) that permit the us, for example, to count users who have visited those pages or opened an e-mail and for other related website statistics (for example, recording the popularity of certain website content and verifying system and server integrity).</p>\r\n\r\n<p style=\"text-align:justify\"><br />\r\n<strong>Links</strong><br />\r\nIn certain cases, we may display advertisements from third parties and other content that links to third-party websites. We cannot control, monitor or be held responsible for third parties&rsquo; terms of use, privacy practices and content. Please carefully review their terms of use, privacy practices to understand how they collect, share and process your personal information.&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>\r\n\r\n<p style=\"text-align:justify\"><strong>How we use collected information</strong><br />\r\nLinkiBag Inc may collect and use Users personal information for the following purposes:</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ul>\r\n	<li style=\"text-align:justify\">\r\n	<p>To improve customer service</p>\r\n\r\n	<p>Information you provide helps us respond to your customer service requests and support&nbsp; needs more efficiently.</p>\r\n	</li>\r\n	<li style=\"text-align:justify\">\r\n	<p>To personalize user experience</p>\r\n\r\n	<p>We may use information in the aggregate to understand how our Users as a group use the services and resources provided on our Site.</p>\r\n	</li>\r\n	<li style=\"text-align:justify\">\r\n	<p>To improve our Site</p>\r\n\r\n	<p>We may use feedback you provide to improve our products and services.</p>\r\n	</li>\r\n	<li style=\"text-align:justify\">\r\n	<p>To share with our business partners, trusted affiliates, advertisers and other users</p>\r\n\r\n	<p>We may share your information with our business partners, trusted affiliates, &nbsp;advertisers and other users for marketing, advertising and other purposes. &nbsp;For these purposes, we may also use one of the Google Analytics products or other similar programs for analyzing sales, advertising and marketing data. &nbsp;If you would like to opt out of Google Analytics, their opt-out browser add-on is available here: https://tools.google.com/dlpage/gaoptout/ &nbsp;&nbsp;</p>\r\n	</li>\r\n	<li style=\"text-align:justify\">\r\n	<p>To process payments</p>\r\n\r\n	<p>We may use the information Users provide about themselves when placing an order only to provide service to that order. We do not share this information with outside parties except to the extent necessary to provide the service.</p>\r\n	</li>\r\n	<li style=\"text-align:justify\">\r\n	<p>To send periodic emails</p>\r\n\r\n	<p>We may use the email address to send User information and updates pertaining to their order. It may also be used to respond to their inquiries, questions, and/or other requests. If User decides to opt-in to our mailing list, they will receive emails that may include company news, updates, related product or service information, and /or updates, information and advertisements from our partners &nbsp;, etc. If at any time the User would like to unsubscribe from receiving future emails, we include detailed unsubscribe instructions at the bottom of each email.</p>\r\n	</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Who do we share information with</strong><br />\r\nLinkiBag may share your information with the following category of third-parties:<br />\r\nWe may share information with advertising partners in order to send you promotional communications about their products and services or to show you more tailored content, including relevant advertising for products and services that may be of interest to you, and to understand how users interact with advertisements. The information we share is in a non-personal, de-identified format (for example, advertiser targets users interested in medical resources) that does not personally identify you. &nbsp; &nbsp;<br />\r\nTo review and request changes to your personally identifiable information, please e-mail us at legal@LinkiBag.com.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>How we protect your information</strong><br />\r\nWe adopt appropriate data collection, storage and processing practices and security measures to protect against unauthorized access, alteration, disclosure or destruction of your personal information, username, password, transaction information and data stored on our Site.<br />\r\nSensitive and private data exchange between the Site and its Users happens over a SSL-secured communication channel and is encrypted and protected with digital signatures.</p>\r\n\r\n<p><br />\r\n<strong>California Do Not Track Disclosure</strong><br />\r\nWe do not track our customers over time and across third party websites for targeted advertising purposes . Accordingly, we do not respond to Do Not Track signals. Third parties cannot collect any other personally identifiable information from the Site unless you provide it to them directly.&nbsp;</p>\r\n\r\n<p><br />\r\n<strong>Your California Privacy Rightr</strong><br />\r\nCalifornia Civil Code Section &sect; 1798.83 permits users of our Site that are California residents to request certain information regarding our disclosure of personal information to third parties for their direct marketing purposes. To make such a request, please send an e-mail to legal@LinkiBag.&nbsp;</p>\r\n\r\n<p><br />\r\n<strong>Changes to this privacy policy</strong><br />\r\nLinkiBag Inc has the discretion to update this Privacy Policy at any time. When we do, we will revise the updated date at the top of this page. We encourage Users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect. You acknowledge and agree that it is your responsibility to review this privacy policy periodically and become aware of modifications.</p>\r\n\r\n<p><br />\r\n<strong>Contacting us</strong><br />\r\nIf you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us at: legal@LinkiBag.com&nbsp;<br />\r\n&nbsp;</p>\r\n', 1470467599, 1566997281, 1);

-- --------------------------------------------------------

--
-- Table structure for table `page_imgs`
--

CREATE TABLE `page_imgs` (
  `img_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `entity_field` varchar(30) NOT NULL,
  `img_name` varchar(100) NOT NULL,
  `img_title` varchar(200) NOT NULL,
  `img_desc` varchar(500) NOT NULL,
  `img_original` varchar(200) NOT NULL,
  `img_thumbnails` text NOT NULL,
  `img_delta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_imgs`
--

INSERT INTO `page_imgs` (`img_id`, `entity_id`, `entity_field`, `img_name`, `img_title`, `img_desc`, `img_original`, `img_thumbnails`, `img_delta`) VALUES
(2, 1, 'page_imgs', 'personal-accounts5.png', '', '', 'files/page_imgs/original/personal-accounts5.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/personal-accounts5.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/personal-accounts5.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/personal-accounts5.png\";}', 0),
(3, 1, 'page_imgs', 'personal-accounts4.png', '', '', 'files/page_imgs/original/personal-accounts4.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/personal-accounts4.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/personal-accounts4.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/personal-accounts4.png\";}', 1),
(4, 1, 'page_imgs', 'personal-accounts3.png', '', '', 'files/page_imgs/original/personal-accounts3.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/personal-accounts3.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/personal-accounts3.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/personal-accounts3.png\";}', 2),
(5, 1, 'page_imgs', 'personal-accounts2.png', '', '', 'files/page_imgs/original/personal-accounts2.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/personal-accounts2.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/personal-accounts2.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/personal-accounts2.png\";}', 3),
(6, 1, 'page_imgs', 'personal-accounts1.png', '', '', 'files/page_imgs/original/personal-accounts1.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/personal-accounts1.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/personal-accounts1.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/personal-accounts1.png\";}', 4),
(7, 2, 'page_imgs', 'business-accounts6.png', '', '', 'files/page_imgs/original/business-accounts6.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/business-accounts6.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/business-accounts6.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/business-accounts6.png\";}', 0),
(8, 2, 'page_imgs', 'business-accounts5.png', '', '', 'files/page_imgs/original/business-accounts5.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/business-accounts5.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/business-accounts5.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/business-accounts5.png\";}', 1),
(9, 2, 'page_imgs', 'business-accounts4.png', '', '', 'files/page_imgs/original/business-accounts4.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/business-accounts4.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/business-accounts4.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/business-accounts4.png\";}', 2),
(10, 2, 'page_imgs', 'business-accounts3.png', '', '', 'files/page_imgs/original/business-accounts3.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/business-accounts3.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/business-accounts3.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/business-accounts3.png\";}', 3),
(11, 2, 'page_imgs', 'business-accounts2.png', '', '', 'files/page_imgs/original/business-accounts2.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/business-accounts2.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/business-accounts2.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/business-accounts2.png\";}', 4),
(12, 2, 'page_imgs', 'business-accounts1.png', '', '', 'files/page_imgs/original/business-accounts1.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/business-accounts1.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/business-accounts1.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/business-accounts1.png\";}', 5),
(13, 3, 'page_imgs', 'institutional-accounts5.png', '', '', 'files/page_imgs/original/institutional-accounts5.png', 'a:3:{s:9:\"thumbnail\";s:53:\"files/page_imgs/thumbnail/institutional-accounts5.png\";s:6:\"medium\";s:50:\"files/page_imgs/medium/institutional-accounts5.png\";s:13:\"premium_image\";s:57:\"files/page_imgs/premium_image/institutional-accounts5.png\";}', 0),
(14, 3, 'page_imgs', 'institutional-accounts4.png', '', '', 'files/page_imgs/original/institutional-accounts4.png', 'a:3:{s:9:\"thumbnail\";s:53:\"files/page_imgs/thumbnail/institutional-accounts4.png\";s:6:\"medium\";s:50:\"files/page_imgs/medium/institutional-accounts4.png\";s:13:\"premium_image\";s:57:\"files/page_imgs/premium_image/institutional-accounts4.png\";}', 1),
(15, 3, 'page_imgs', 'institutional-accounts3.png', '', '', 'files/page_imgs/original/institutional-accounts3.png', 'a:3:{s:9:\"thumbnail\";s:53:\"files/page_imgs/thumbnail/institutional-accounts3.png\";s:6:\"medium\";s:50:\"files/page_imgs/medium/institutional-accounts3.png\";s:13:\"premium_image\";s:57:\"files/page_imgs/premium_image/institutional-accounts3.png\";}', 2),
(16, 3, 'page_imgs', 'institutional-accounts2.png', '', '', 'files/page_imgs/original/institutional-accounts2.png', 'a:3:{s:9:\"thumbnail\";s:53:\"files/page_imgs/thumbnail/institutional-accounts2.png\";s:6:\"medium\";s:50:\"files/page_imgs/medium/institutional-accounts2.png\";s:13:\"premium_image\";s:57:\"files/page_imgs/premium_image/institutional-accounts2.png\";}', 3),
(17, 3, 'page_imgs', 'institutional-accounts1.png', '', '', 'files/page_imgs/original/institutional-accounts1.png', 'a:3:{s:9:\"thumbnail\";s:53:\"files/page_imgs/thumbnail/institutional-accounts1.png\";s:6:\"medium\";s:50:\"files/page_imgs/medium/institutional-accounts1.png\";s:13:\"premium_image\";s:57:\"files/page_imgs/premium_image/institutional-accounts1.png\";}', 4),
(18, 4, 'page_imgs', 'aboutus4.png', '', '', 'files/page_imgs/original/aboutus4.png', 'a:3:{s:9:\"thumbnail\";s:38:\"files/page_imgs/thumbnail/aboutus4.png\";s:6:\"medium\";s:35:\"files/page_imgs/medium/aboutus4.png\";s:13:\"premium_image\";s:42:\"files/page_imgs/premium_image/aboutus4.png\";}', 0),
(19, 4, 'page_imgs', 'aboutus3.png', '', '', 'files/page_imgs/original/aboutus3.png', 'a:3:{s:9:\"thumbnail\";s:38:\"files/page_imgs/thumbnail/aboutus3.png\";s:6:\"medium\";s:35:\"files/page_imgs/medium/aboutus3.png\";s:13:\"premium_image\";s:42:\"files/page_imgs/premium_image/aboutus3.png\";}', 1),
(20, 4, 'page_imgs', 'aboutus2.png', '', '', 'files/page_imgs/original/aboutus2.png', 'a:3:{s:9:\"thumbnail\";s:38:\"files/page_imgs/thumbnail/aboutus2.png\";s:6:\"medium\";s:35:\"files/page_imgs/medium/aboutus2.png\";s:13:\"premium_image\";s:42:\"files/page_imgs/premium_image/aboutus2.png\";}', 2),
(21, 4, 'page_imgs', 'aboutus1.png', '', '', 'files/page_imgs/original/aboutus1.png', 'a:3:{s:9:\"thumbnail\";s:38:\"files/page_imgs/thumbnail/aboutus1.png\";s:6:\"medium\";s:35:\"files/page_imgs/medium/aboutus1.png\";s:13:\"premium_image\";s:42:\"files/page_imgs/premium_image/aboutus1.png\";}', 3),
(22, 5, 'page_imgs', 'howitworks3.jpg', '', '', 'files/page_imgs/original/howitworks3.jpg', 'a:3:{s:9:\"thumbnail\";s:41:\"files/page_imgs/thumbnail/howitworks3.jpg\";s:6:\"medium\";s:38:\"files/page_imgs/medium/howitworks3.jpg\";s:13:\"premium_image\";s:45:\"files/page_imgs/premium_image/howitworks3.jpg\";}', 0),
(23, 5, 'page_imgs', 'howitworks2.jpg', '', '', 'files/page_imgs/original/howitworks2.jpg', 'a:3:{s:9:\"thumbnail\";s:41:\"files/page_imgs/thumbnail/howitworks2.jpg\";s:6:\"medium\";s:38:\"files/page_imgs/medium/howitworks2.jpg\";s:13:\"premium_image\";s:45:\"files/page_imgs/premium_image/howitworks2.jpg\";}', 1),
(24, 5, 'page_imgs', 'howitworks1.jpg', '', '', 'files/page_imgs/original/howitworks1.jpg', 'a:3:{s:9:\"thumbnail\";s:41:\"files/page_imgs/thumbnail/howitworks1.jpg\";s:6:\"medium\";s:38:\"files/page_imgs/medium/howitworks1.jpg\";s:13:\"premium_image\";s:45:\"files/page_imgs/premium_image/howitworks1.jpg\";}', 2),
(25, 1, 'page_imgs', 'howitworks3.jpg', '', '', 'files/page_imgs/original/howitworks3-0.jpg', 'a:3:{s:9:\"thumbnail\";s:43:\"files/page_imgs/thumbnail/howitworks3-0.jpg\";s:6:\"medium\";s:40:\"files/page_imgs/medium/howitworks3-0.jpg\";s:13:\"premium_image\";s:47:\"files/page_imgs/premium_image/howitworks3-0.jpg\";}', 5),
(29, 6, 'page_imgs', 'linki-drops-accounts.png', '', '', 'files/page_imgs/original/linki-drops-accounts.png', 'a:3:{s:9:\"thumbnail\";s:50:\"files/page_imgs/thumbnail/linki-drops-accounts.png\";s:6:\"medium\";s:47:\"files/page_imgs/medium/linki-drops-accounts.png\";s:13:\"premium_image\";s:54:\"files/page_imgs/premium_image/linki-drops-accounts.png\";}', 0),
(30, 7, 'page_imgs', 'faq.jpg', '', '', 'files/page_imgs/original/faq.jpg', 'a:3:{s:9:\"thumbnail\";s:33:\"files/page_imgs/thumbnail/faq.jpg\";s:6:\"medium\";s:30:\"files/page_imgs/medium/faq.jpg\";s:13:\"premium_image\";s:37:\"files/page_imgs/premium_image/faq.jpg\";}', 0),
(31, 8, 'page_imgs', 'gold-bars-png.png', '', '', 'files/page_imgs/original/gold-bars-png.png', 'a:3:{s:9:\"thumbnail\";s:43:\"files/page_imgs/thumbnail/gold-bars-png.png\";s:6:\"medium\";s:40:\"files/page_imgs/medium/gold-bars-png.png\";s:13:\"premium_image\";s:47:\"files/page_imgs/premium_image/gold-bars-png.png\";}', 0),
(32, 8, 'page_imgs', 'smartphone_PNG8519.png', '', '', 'files/page_imgs/original/smartphone_PNG8519.png', 'a:3:{s:9:\"thumbnail\";s:48:\"files/page_imgs/thumbnail/smartphone_PNG8519.png\";s:6:\"medium\";s:45:\"files/page_imgs/medium/smartphone_PNG8519.png\";s:13:\"premium_image\";s:52:\"files/page_imgs/premium_image/smartphone_PNG8519.png\";}', 1),
(33, 8, 'page_imgs', 'laptop_PNG5930.png', '', '', 'files/page_imgs/original/laptop_PNG5930.png', 'a:3:{s:9:\"thumbnail\";s:44:\"files/page_imgs/thumbnail/laptop_PNG5930.png\";s:6:\"medium\";s:41:\"files/page_imgs/medium/laptop_PNG5930.png\";s:13:\"premium_image\";s:48:\"files/page_imgs/premium_image/laptop_PNG5930.png\";}', 2);

-- --------------------------------------------------------

--
-- Table structure for table `popup_setting`
--

CREATE TABLE `popup_setting` (
  `popup_id` int(11) NOT NULL,
  `popup_msg` text NOT NULL,
  `popup_show` int(11) NOT NULL,
  `cookie_popup_msg` text NOT NULL,
  `cookie_popup_show` int(11) NOT NULL,
  `popup_updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `popup_setting`
--

INSERT INTO `popup_setting` (`popup_id`, `popup_msg`, `popup_show`, `cookie_popup_msg`, `cookie_popup_show`, `popup_updated`) VALUES
(1, 'We currently updated website <a target=\"_blank\" href=\"index.php?p=pages&id=8\"> Terms of Use </a> and <a target=\"_blank\" href=\"index.php?p=pages&id=9\"> Privacy Policy </a>. By accessing or using any part of the site, you agree to be bound by these Terms.', 1, 'We use cookies to ensure that we give you the best experience on our website. By closing this message you concent to our cookies on this device in accordance with our <a href=\"index.php?p=pages&id=9\" target=\"_blank\">Privacy Policy</a> unless you have diabled them.', 1, 1582027934);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `profile_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `salutation` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `account` varchar(50) NOT NULL,
  `country` int(11) NOT NULL,
  `terms_and_conditions` int(11) NOT NULL,
  `sign_me_for_email_filter` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `security_question` int(11) NOT NULL,
  `security_answer` text NOT NULL,
  `profile_photo` varchar(100) NOT NULL,
  `subscribe` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `uid`, `first_name`, `last_name`, `company_name`, `salutation`, `dob`, `account`, `country`, `terms_and_conditions`, `sign_me_for_email_filter`, `state`, `zip_code`, `security_question`, `security_answer`, `profile_photo`, `subscribe`, `start_date`, `end_date`) VALUES
(5, 5, 'Bob Smith', 'Junior', '', 'mr', '0000-00-00', '', 4, 1, 1, 0, 0, 2, 'punjab', 'files/profile_photo/-field_profilbild_3.jpg', 1, '2017-03-16', '2017-03-21'),
(6, 6, 'jimmy', 'rana', '', 'mr', '0000-00-00', '', 99, 1, 0, 0, 0, 0, '', '', 0, '1970-01-01', '1970-01-01'),
(7, 7, 'gurdeep', 'oshanan', '', 'mr', '0000-00-00', '', 17, 1, 1, 0, 0, 1, 'ludhiana', '', 0, '0000-00-00', '0000-00-00'),
(8, 8, 'dalvir', 'singh', '', 'mr', '0000-00-00', '', 0, 1, 0, 0, 0, 0, '', '', 0, '1969-12-31', '1969-12-31'),
(9, 9, 'jasvinder', 'singh', '', 'mr', '0000-00-00', '', 2, 1, 1, 0, 0, 1, 'sdfsdaf', '', 0, '0000-00-00', '0000-00-00'),
(10, 10, '', '', '', '', '0000-00-00', '', 0, 1, 0, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(11, 11, '', '', '', 'mr', '0000-00-00', '', 0, 1, 0, 0, 0, 0, '', '', 0, '1970-01-01', '1970-01-01'),
(12, 12, '', '', '', '', '0000-00-00', '', 0, 1, 0, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(13, 13, '', '', '', 'mr', '0000-00-00', '', 0, 1, 0, 0, 0, 0, '', '', 0, '1970-01-01', '1970-01-01'),
(14, 14, 'jimmy sinngh', 'rana', '', 'mr', '0000-00-00', '', 0, 1, 0, 0, 0, 0, '', '', 0, '1970-01-01', '1970-01-01'),
(15, 15, '', '', '', '', '0000-00-00', '', 0, 1, 0, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(16, 16, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(17, 17, 'Linki', 'Bag', '', 'mr', '0000-00-00', '', 1, 1, 0, 17, 60605, 1, 'password', '', 1, '0000-00-00', '0000-00-00'),
(18, 18, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(19, 19, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(20, 20, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(21, 21, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(22, 22, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(23, 23, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(24, 24, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(25, 25, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(26, 26, '', '', '', '', '0000-00-00', '', 1, 1, 0, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(27, 27, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(28, 28, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(29, 29, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(30, 30, '', '', '', '', '0000-00-00', '', 1, 1, 0, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(31, 31, '', '', '', '', '0000-00-00', '', 12, 1, 0, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(32, 32, '', '', '', '', '0000-00-00', '', 1, 1, 0, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(33, 33, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(34, 34, '', '', '', '', '0000-00-00', '', 1, 1, 0, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(35, 35, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(36, 36, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(37, 37, 'Gursewak', 'Gursewak', 'TT', 'mr', '0000-00-00', '', 1, 1, 1, 4, 141001, 1, 'Ludhiana', '', 0, '0000-00-00', '0000-00-00'),
(38, 38, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(39, 39, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(40, 40, '', '', '', '', '0000-00-00', '', 1, 1, 0, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(41, 41, '', '', '', '', '0000-00-00', '', 1, 1, 0, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(42, 6, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(43, 7, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(44, 8, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00'),
(45, 9, '', '', '', '', '0000-00-00', '', 1, 1, 1, 0, 0, 0, '', '', 0, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `recommend_user_category_msgs`
--

CREATE TABLE `recommend_user_category_msgs` (
  `recommend_msg_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `recommend_category_msg` text NOT NULL,
  `status` int(11) NOT NULL,
  `recommend_category_msg_created` int(11) NOT NULL,
  `recommend_category_msg_updated` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recommend_user_category_msgs`
--

INSERT INTO `recommend_user_category_msgs` (`recommend_msg_id`, `uid`, `recommend_category_msg`, `status`, `recommend_category_msg_created`, `recommend_category_msg_updated`) VALUES
(1, 8, 'sir please recommend classic category.', 0, 1536314452, 1536314452),
(2, 8, 'sir please recommend internet category.', 0, 1536314623, 1536314623),
(3, 8, 'sir please recommend fitness category.', 0, 1536315354, 1536315354),
(4, 8, 'sir please recommend restaurant category.', 0, 1536315430, 1536315430),
(5, 8, 'sir please recommend virtual classic category.', 0, 1536315514, 1536315514),
(6, 26, 'sadasdas', 0, 1569839129, 1569839129),
(7, 26, 'best service', 0, 1569839170, 1569839170),
(8, 26, 'test', 0, 1569839208, 1569839208),
(9, 26, 'hello', 0, 1569839286, 1569839286),
(10, 37, 'dfgdf', 0, 1573633870, 1573633870);

-- --------------------------------------------------------

--
-- Table structure for table `securiy_questions`
--

CREATE TABLE `securiy_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `security_question` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `securiy_questions`
--

INSERT INTO `securiy_questions` (`id`, `security_question`) VALUES
(1, 'In which city were you born?'),
(2, 'In which state were you born?'),
(3, 'In which province were you born?'),
(4, 'What is the name of your favourite cousin?'),
(5, 'What is tha name of street where you grew up?'),
(6, 'Who was your childhood hero?');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` char(2) NOT NULL,
  `state_name` varchar(64) NOT NULL,
  `country` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `code`, `state_name`, `country`) VALUES
(1, 'AL', 'Alabama', 230),
(2, 'AK', 'Alaska', 230),
(3, 'AS', 'American Samoa', 230),
(4, 'AZ', 'Arizona', 230),
(5, 'AR', 'Arkansas', 230),
(6, 'CA', 'California', 230),
(7, 'CO', 'Colorado', 230),
(8, 'CT', 'Connecticut', 230),
(9, 'DE', 'Delaware', 230),
(10, 'DC', 'District of Columbia', 230),
(11, 'FM', 'Federated States of Micronesia', 230),
(12, 'FL', 'Florida', 230),
(13, 'GA', 'Georgia', 230),
(14, 'GU', 'Guam', 230),
(15, 'HI', 'Hawaii', 230),
(16, 'ID', 'Idaho', 230),
(17, 'IL', 'Illinois', 230),
(18, 'IN', 'Indiana', 230),
(19, 'IA', 'Iowa', 230),
(20, 'KS', 'Kansas', 230),
(21, 'KY', 'Kentucky', 230),
(22, 'LA', 'Louisiana', 230),
(23, 'ME', 'Maine', 230),
(24, 'MH', 'Marshall Islands', 230),
(25, 'MD', 'Maryland', 230),
(26, 'MA', 'Massachusetts', 230),
(27, 'MI', 'Michigan', 230),
(28, 'MN', 'Minnesota', 230),
(29, 'MS', 'Mississippi', 230),
(30, 'MO', 'Missouri', 230),
(31, 'MT', 'Montana', 230),
(32, 'NE', 'Nebraska', 230),
(33, 'NV', 'Nevada', 230),
(34, 'NH', 'New Hampshire', 230),
(35, 'NJ', 'New Jersey', 230),
(36, 'NM', 'New Mexico', 230),
(37, 'NY', 'New York', 230),
(38, 'NC', 'North Carolina', 230),
(39, 'ND', 'North Dakota', 230),
(40, 'MP', 'Northern Mariana Islands', 230),
(41, 'OH', 'Ohio', 230),
(42, 'OK', 'Oklahoma', 230),
(43, 'OR', 'Oregon', 230),
(44, 'PW', 'Palau', 230),
(45, 'PA', 'Pennsylvania', 230),
(46, 'PR', 'Puerto Rico', 230),
(47, 'RI', 'Rhode Island', 230),
(48, 'SC', 'South Carolina', 230),
(49, 'SD', 'South Dakota', 230),
(50, 'TN', 'Tennessee', 230),
(51, 'TX', 'Texas', 230),
(52, 'UT', 'Utah', 230),
(53, 'VT', 'Vermont', 230),
(54, 'VI', 'Virgin Islands', 230),
(55, 'VA', 'Virginia', 230),
(56, 'WA', 'Washington', 230),
(57, 'WV', 'West Virginia', 230),
(58, 'WI', 'Wisconsin', 230),
(59, 'WY', 'Wyoming', 230);

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `subscription_id` int(11) NOT NULL,
  `package_name` varchar(200) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`subscription_id`, `package_name`, `price`) VALUES
(1, 'Free Personal Account', 0),
(2, 'Business Account', 97.49),
(3, 'Institutional Account', 47.99);

-- --------------------------------------------------------

--
-- Table structure for table `unsubscribe`
--

CREATE TABLE `unsubscribe` (
  `us_id` int(11) NOT NULL,
  `mail_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `email_id` varchar(150) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `decrypt_pass` varchar(255) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `role` text NOT NULL COMMENT '1=personal, 2=business, 3=education',
  `verified` int(11) NOT NULL,
  `verified_time` int(11) NOT NULL,
  `verify_code` varchar(100) NOT NULL,
  `reset_time` int(11) NOT NULL,
  `reset_code` varchar(100) NOT NULL,
  `reset_request` int(11) NOT NULL,
  `lastactivity` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_user_login` int(11) NOT NULL,
  `last_login_time` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=active,  -1,0=blocked,  -2=deleted',
  `updated` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `reset_email_time` int(11) NOT NULL,
  `email_unique_path` varchar(100) NOT NULL,
  `reset_email_created` int(11) NOT NULL,
  `closed_account` int(11) NOT NULL,
  `deleted_account` int(11) NOT NULL,
  `paid_users_generate_links` varchar(255) NOT NULL,
  `paid_users_generate_links_created` int(11) NOT NULL,
  `remove_profile` int(11) NOT NULL,
  `hide_nonfriend_msg` int(11) NOT NULL,
  `hide_scan_fulldetail` int(11) NOT NULL,
  `user_timezone` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `email_id`, `pass`, `decrypt_pass`, `mobile`, `role`, `verified`, `verified_time`, `verify_code`, `reset_time`, `reset_code`, `reset_request`, `lastactivity`, `created_by`, `is_user_login`, `last_login_time`, `status`, `updated`, `created`, `reset_email_time`, `email_unique_path`, `reset_email_created`, `closed_account`, `deleted_account`, `paid_users_generate_links`, `paid_users_generate_links_created`, `remove_profile`, `hide_nonfriend_msg`, `hide_scan_fulldetail`, `user_timezone`) VALUES
(5, 'user2525@gmail.com', 'test2525x', 'c5e8eb156cef49a46f36138e306e7bc5', '', '3', 1, 0, 'verifybcXAbJNK5bOoEP(rm', 1479185171, 'bh0P(vLSwbTv4YR0mQtmwpY720{1!wIWN8l', 1, 0, 0, 0, 1575893683, 1, 1522307971, 1462508024, 1533359325, 'Bnxpj_1{{dDDJ5X(lk1558526488', 1495437833, 0, 0, 'http://www.linkibag.net/PTest25x/linkibag/index.php?p=viewprofile&id=5', 1530192309, 0, 0, 0, ''),
(6, 'tt.gursewak.singh@gmail.com', 'Dass@1234', 'cfb599cf91a88b2eeaf2872fbb6b426d', '', '1', 1, 1578027448, 'verifyF8ICZb[n62V8f{Oe(', 1578037511, '', 0, 0, 0, 1, 1578048776, 1, 0, 1578027412, 0, '', 0, 0, 0, '', 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_friends`
--

CREATE TABLE `user_friends` (
  `friend_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `fgroup` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=pending,1=confirmed,2=decline',
  `read_status` int(11) NOT NULL,
  `num_of_visits` int(11) NOT NULL,
  `date` date NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_friends`
--

INSERT INTO `user_friends` (`friend_id`, `request_id`, `uid`, `fid`, `fgroup`, `status`, `read_status`, `num_of_visits`, `date`, `created`, `updated`) VALUES
(3, 2, 6, 8, 0, 0, 0, 0, '2020-01-03', 1578030002, 1578030002),
(4, 2, 8, 6, 0, 0, 0, 0, '2020-01-03', 1578030002, 1578030002),
(5, 3, 6, 7, 0, 0, 0, 0, '2020-01-03', 1578034978, 1578034978),
(6, 3, 7, 6, 0, 0, 0, 0, '2020-01-03', 1578034978, 1578034978),
(7, 4, 6, 8, 0, 0, 0, 0, '2020-01-03', 1578034978, 1578034978),
(8, 4, 8, 6, 0, 0, 0, 0, '2020-01-03', 1578034978, 1578034978),
(9, 5, 6, 8, 0, 0, 0, 0, '2020-01-03', 1578039906, 1578039906),
(10, 5, 8, 6, 0, 0, 0, 0, '2020-01-03', 1578039906, 1578039906),
(11, 6, 6, 0, 0, 0, 0, 0, '2020-01-03', 1578047772, 1578047772),
(12, 6, 0, 6, 0, 0, 0, 0, '2020-01-03', 1578047772, 1578047772),
(13, 7, 6, 0, 0, 0, 0, 0, '2020-01-03', 1578048131, 1578048131),
(14, 7, 0, 6, 0, 0, 0, 0, '2020-01-03', 1578048131, 1578048131),
(15, 8, 6, 0, 0, 0, 0, 0, '2020-01-03', 1578048357, 1578048357),
(16, 8, 0, 6, 0, 0, 0, 0, '2020-01-03', 1578048357, 1578048357),
(19, 10, 6, 0, 0, 0, 0, 0, '2020-01-03', 1578048674, 1578048674),
(20, 10, 0, 6, 0, 0, 0, 0, '2020-01-03', 1578048674, 1578048674),
(21, 11, 6, 9, 0, 0, 0, 0, '2020-01-03', 1578048740, 1578048740),
(22, 11, 9, 6, 0, 0, 0, 0, '2020-01-03', 1578048740, 1578048740),
(23, 12, 6, 9, 0, 0, 0, 0, '2020-01-03', 1578048797, 1578048797),
(24, 12, 9, 6, 0, 0, 0, 0, '2020-01-03', 1578048797, 1578048797),
(25, 13, 6, 9, 0, 0, 0, 0, '2020-01-03', 1578048842, 1578048842),
(26, 13, 9, 6, 0, 0, 0, 0, '2020-01-03', 1578048842, 1578048842),
(27, 14, 9, 0, 0, 0, 0, 0, '2020-01-03', 1578048976, 1578048976),
(28, 14, 0, 9, 0, 0, 0, 0, '2020-01-03', 1578048976, 1578048976),
(29, 15, 6, 0, 0, 0, 0, 0, '2020-01-03', 1578049101, 1578049101),
(30, 15, 0, 6, 0, 0, 0, 0, '2020-01-03', 1578049101, 1578049101),
(31, 16, 6, 0, 0, 0, 0, 0, '2020-01-03', 1578049357, 1578049357),
(32, 16, 0, 6, 0, 0, 0, 0, '2020-01-03', 1578049357, 1578049357),
(33, 17, 9, 0, 0, 0, 0, 0, '2020-01-03', 1578049542, 1578049542),
(34, 17, 0, 9, 0, 0, 0, 0, '2020-01-03', 1578049542, 1578049542),
(35, 18, 9, 0, 0, 0, 0, 0, '2020-01-03', 1578049558, 1578049558),
(36, 18, 0, 9, 0, 0, 0, 0, '2020-01-03', 1578049558, 1578049558),
(37, 19, 6, 0, 0, 0, 0, 0, '2020-01-03', 1578049734, 1578049734),
(38, 19, 0, 6, 0, 0, 0, 0, '2020-01-03', 1578049734, 1578049734),
(39, 20, 6, 0, 0, 0, 0, 0, '2020-01-03', 1578050027, 1578050027),
(40, 20, 0, 6, 0, 0, 0, 0, '2020-01-03', 1578050027, 1578050027);

-- --------------------------------------------------------

--
-- Table structure for table `user_payments`
--

CREATE TABLE `user_payments` (
  `payment_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `payment_by` int(11) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_payments`
--

INSERT INTO `user_payments` (`payment_id`, `uid`, `payment_by`, `payment_type`, `total_pay`, `status`) VALUES
(2, 5, 5, 'subscription', 48, 1),
(3, 5, 5, 'subscription', 97, 1),
(4, 5, 5, 'subscription', 97, 1),
(5, 5, 5, 'subscription', 48, 1),
(6, 5, 5, 'subscription', 48, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_public_category`
--

CREATE TABLE `user_public_category` (
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT 'created-by',
  `cname` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=pending,1=approved',
  `photo` varchar(500) NOT NULL,
  `photo_thumbnail` varchar(1000) NOT NULL,
  `in_list` int(11) NOT NULL,
  `trending_cat` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_public_category`
--

INSERT INTO `user_public_category` (`cid`, `uid`, `cname`, `status`, `photo`, `photo_thumbnail`, `in_list`, `trending_cat`, `created_time`, `updated_time`) VALUES
(1, 0, 'Technology', 1, '', '', 0, 0, 1498213568, 1498213568),
(2, 0, 'Medical', 1, '', '', 0, 0, 1498213564, 1498213564),
(3, 0, 'Mathematics', 1, '', '', 0, 0, 1498213557, 1498213557),
(4, 0, 'Law', 1, '', '', 0, 0, 1498213547, 1498213547),
(5, 0, 'History', 1, '', '', 0, 0, 1498213536, 1498213536),
(6, 0, 'Geography', 1, '', '', 0, 0, 1498213531, 1498213531),
(7, 0, 'Fine Art', 1, '', '', 0, 0, 1498213542, 1498213542),
(8, 0, 'Economics and Management', 1, '', '', 0, 0, 1498213518, 1498213518),
(9, 8, 'Travel Agency', 0, '', '', 0, 0, 1537182032, 1537182032),
(10, 8, 'Travel shoot agency', 0, '', '', 0, 0, 1537182238, 1537182238);

-- --------------------------------------------------------

--
-- Table structure for table `user_public_category_comments`
--

CREATE TABLE `user_public_category_comments` (
  `comment_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `url_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `notes` text NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  `created_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_shared_urls`
--

CREATE TABLE `user_shared_urls` (
  `shared_url_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `shared_to` varchar(100) NOT NULL,
  `url_id` int(11) NOT NULL,
  `url_cat` int(11) NOT NULL COMMENT '0=trash,-1=inbag',
  `read_status` int(11) NOT NULL,
  `like_status` int(11) NOT NULL COMMENT '0=nothing,1=like,2=unlike',
  `like_unlike_time` int(11) NOT NULL,
  `recommend_link` int(11) NOT NULL COMMENT '0=nothing,1=recommend,2=unrecommend',
  `recommend_link_time` int(11) NOT NULL,
  `sponsored_link` int(11) NOT NULL,
  `visit_status` int(11) NOT NULL,
  `num_of_visits` int(11) NOT NULL,
  `groups` int(11) NOT NULL,
  `share_number` int(11) NOT NULL,
  `shared_time` int(11) NOT NULL,
  `url_msg` text NOT NULL,
  `url_msg_time` int(11) NOT NULL,
  `activate_share_id` int(11) NOT NULL COMMENT '0=notactive,1=active',
  `scan_result_show` int(11) NOT NULL,
  `scan_result_show_time` int(11) NOT NULL,
  `share_type_change` int(11) NOT NULL,
  `public_cat_change` int(11) NOT NULL,
  `add_to_search_page_change` int(11) NOT NULL,
  `search_page_status_change` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_shared_urls`
--

INSERT INTO `user_shared_urls` (`shared_url_id`, `uid`, `shared_to`, `url_id`, `url_cat`, `read_status`, `like_status`, `like_unlike_time`, `recommend_link`, `recommend_link_time`, `sponsored_link`, `visit_status`, `num_of_visits`, `groups`, `share_number`, `shared_time`, `url_msg`, `url_msg_time`, `activate_share_id`, `scan_result_show`, `scan_result_show_time`, `share_type_change`, `public_cat_change`, `add_to_search_page_change`, `search_page_status_change`) VALUES
(1, 6, '6', 13, -2, 1, 1, 0, 0, 0, 0, 0, 2, 0, 0, 1578029638, '', 0, 0, 0, 0, 2, 1, 0, 0),
(2, 6, '6', 14, -2, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1578029703, '', 0, 0, 0, 0, 1, 1, 0, 0),
(3, 6, '6', 15, -2, 1, 1, 0, 0, 0, 0, 0, 2, 0, 0, 1578029739, '', 0, 0, 0, 0, 2, 1, 0, 0),
(4, 6, '6', 16, -2, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1578029773, '', 0, 0, 0, 0, 1, 1, 0, 0),
(5, 6, '7', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5369761, 1578034978, '', 0, 1, 0, 0, 2, 1, 0, 0),
(6, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5369761, 1578034978, '', 0, 1, 0, 0, 2, 1, 0, 0),
(7, 6, '7', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5369761, 1578034978, '', 0, 1, 0, 0, 2, 1, 0, 0),
(8, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5369761, 1578034978, '', 0, 1, 0, 0, 2, 1, 0, 0),
(9, 6, '6', 17, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1578035276, '', 0, 0, 0, 0, 0, 0, 0, 0),
(10, 6, '6', 18, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1578035276, '', 0, 0, 0, 0, 0, 0, 0, 0),
(11, 8, '8', 19, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1578035614, '', 0, 0, 0, 0, 0, 0, 0, 0),
(12, 8, '8', 20, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1578035614, '', 0, 0, 0, 0, 0, 0, 0, 0),
(13, 8, '6', 19, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2379204, 1578035671, '', 0, 1, 0, 0, 0, 0, 0, 0),
(14, 8, '6', 20, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2379204, 1578035671, '', 0, 1, 0, 0, 0, 0, 0, 0),
(15, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5402454, 1578039852, '', 0, 1, 0, 0, 2, 1, 0, 0),
(16, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5402454, 1578039852, '', 0, 1, 0, 0, 2, 1, 0, 0),
(17, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9261779, 1578041053, '', 0, 1, 0, 0, 2, 1, 0, 0),
(18, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9261779, 1578041053, '', 0, 1, 0, 0, 2, 1, 0, 0),
(19, 7, '7', 21, -2, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1578041231, '', 0, 0, 0, 0, 2, 1, 0, 0),
(20, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3261679, 1578041247, '', 0, 1, 0, 0, 2, 1, 0, 0),
(21, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9356717, 1578044172, '', 0, 1, 0, 0, 2, 1, 0, 0),
(22, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4351711, 1578044184, '', 0, 1, 0, 0, 2, 1, 0, 0),
(23, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4351711, 1578044191, '', 0, 1, 0, 0, 2, 1, 0, 0),
(24, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4351711, 1578044191, '', 0, 1, 0, 0, 2, 1, 0, 0),
(25, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4351711, 1578044191, '', 0, 1, 0, 0, 2, 1, 0, 0),
(26, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2121177, 1578044241, '', 0, 1, 0, 0, 2, 1, 0, 0),
(27, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2121177, 1578044241, '', 0, 1, 0, 0, 2, 1, 0, 0),
(28, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2121177, 1578044245, '', 0, 1, 0, 0, 2, 1, 0, 0),
(29, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2121177, 1578044245, '', 0, 1, 0, 0, 2, 1, 0, 0),
(30, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2121177, 1578044246, '', 0, 1, 0, 0, 2, 1, 0, 0),
(31, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2121177, 1578044246, '', 0, 1, 0, 0, 2, 1, 0, 0),
(32, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2121177, 1578044246, '', 0, 1, 0, 0, 2, 1, 0, 0),
(33, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2121177, 1578044246, '', 0, 1, 0, 0, 2, 1, 0, 0),
(34, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2121177, 1578044276, '', 0, 1, 0, 0, 2, 1, 0, 0),
(35, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2121177, 1578044276, '', 0, 1, 0, 0, 2, 1, 0, 0),
(36, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044671, '', 0, 1, 0, 0, 2, 1, 0, 0),
(37, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044671, '', 0, 1, 0, 0, 2, 1, 0, 0),
(38, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044677, '', 0, 1, 0, 0, 2, 1, 0, 0),
(39, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044677, '', 0, 1, 0, 0, 2, 1, 0, 0),
(40, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044677, '', 0, 1, 0, 0, 2, 1, 0, 0),
(41, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044677, '', 0, 1, 0, 0, 2, 1, 0, 0),
(42, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044677, '', 0, 1, 0, 0, 2, 1, 0, 0),
(43, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044677, '', 0, 1, 0, 0, 2, 1, 0, 0),
(44, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044678, '', 0, 1, 0, 0, 2, 1, 0, 0),
(45, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044678, '', 0, 1, 0, 0, 2, 1, 0, 0),
(46, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044678, '', 0, 1, 0, 0, 2, 1, 0, 0),
(47, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044678, '', 0, 1, 0, 0, 2, 1, 0, 0),
(48, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044678, '', 0, 1, 0, 0, 2, 1, 0, 0),
(49, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044678, '', 0, 1, 0, 0, 2, 1, 0, 0),
(50, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044679, '', 0, 1, 0, 0, 2, 1, 0, 0),
(51, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2081627, 1578044679, '', 0, 1, 0, 0, 2, 1, 0, 0),
(52, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6028735, 1578044688, '', 0, 1, 0, 0, 2, 1, 0, 0),
(53, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6028735, 1578044691, '', 0, 1, 0, 0, 2, 1, 0, 0),
(54, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6028735, 1578044691, '', 0, 1, 0, 0, 2, 1, 0, 0),
(55, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4005325, 1578044965, '', 0, 1, 0, 0, 2, 1, 0, 0),
(56, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4005325, 1578044965, '', 0, 1, 0, 0, 2, 1, 0, 0),
(57, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4005325, 1578044968, '', 0, 1, 0, 0, 2, 1, 0, 0),
(58, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4005325, 1578044968, '', 0, 1, 0, 0, 2, 1, 0, 0),
(59, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4005325, 1578044968, '', 0, 1, 0, 0, 2, 1, 0, 0),
(60, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4005325, 1578044968, '', 0, 1, 0, 0, 2, 1, 0, 0),
(61, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1339290, 1578045073, '', 0, 1, 0, 0, 2, 1, 0, 0),
(62, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1339290, 1578045073, '', 0, 1, 0, 0, 2, 1, 0, 0),
(63, 6, '8', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1683597, 1578045360, '', 0, 1, 0, 0, 2, 1, 0, 0),
(64, 6, '8', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1683597, 1578045360, '', 0, 1, 0, 0, 2, 1, 0, 0),
(65, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9857138, 1578045543, '', 0, 1, 0, 0, 2, 1, 0, 0),
(66, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4424863, 1578045833, '', 0, 1, 0, 0, 2, 1, 0, 0),
(67, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4424863, 1578045952, '', 0, 1, 0, 0, 2, 1, 0, 0),
(68, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6104988, 1578046059, '', 0, 1, 0, 0, 2, 1, 0, 0),
(69, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5023916, 1578046644, '', 0, 1, 0, 0, 2, 1, 0, 0),
(70, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4560518, 1578047056, '', 0, 1, 0, 0, 2, 1, 0, 0),
(71, 7, '6', 21, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2106924, 1578047305, '', 0, 1, 0, 0, 2, 1, 0, 0),
(72, 6, 'tt.harpreet.kaur@gmail.com', 13, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4847180, 1578050309, '', 0, 1, 0, 0, 2, 1, 0, 0),
(73, 6, 'tt.harpreet.kaur@gmail.com', 15, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4847180, 1578050309, '', 0, 1, 0, 0, 2, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_subscriptions`
--

CREATE TABLE `user_subscriptions` (
  `subs_id` int(11) NOT NULL,
  `subs_uid` int(11) NOT NULL,
  `subs_payment_id` int(11) NOT NULL,
  `subs_package` int(20) NOT NULL COMMENT '0=free,anynumber id',
  `subs_amt` float NOT NULL,
  `subs_start_date` datetime NOT NULL,
  `subs_end_date` datetime NOT NULL,
  `adjust_sub_id` int(11) NOT NULL,
  `adjust_sub_days` int(11) NOT NULL,
  `adjust_sub_price` int(11) NOT NULL,
  `subs_created` int(11) NOT NULL,
  `subs_updated` int(11) NOT NULL,
  `subs_status` int(11) NOT NULL COMMENT '0=Pending, 1=Paid, 2=Adjusted, 3=Expired'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_urls`
--

CREATE TABLE `user_urls` (
  `url_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT 'created-by,0=admin',
  `url_title` text NOT NULL,
  `url_value` text NOT NULL,
  `url_desc` varchar(1000) NOT NULL,
  `url_cat` varchar(100) NOT NULL,
  `editor_web_link` int(11) NOT NULL,
  `youtube_link_pick` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `updated_time` int(11) NOT NULL,
  `updated_date` date NOT NULL,
  `ip_address` int(11) NOT NULL,
  `public_bag_link` int(11) NOT NULL,
  `trending_link` int(11) NOT NULL,
  `you_tube_link` int(11) NOT NULL,
  `is_video_link` int(11) NOT NULL,
  `video_id` varchar(100) NOT NULL,
  `video_web` int(11) NOT NULL,
  `video_embed_code` text NOT NULL,
  `video_week` int(11) NOT NULL,
  `video_updated` int(11) NOT NULL,
  `pick_week_link` int(11) NOT NULL,
  `share_type` int(11) NOT NULL,
  `public_cat` int(11) NOT NULL,
  `add_to_search_page` int(11) NOT NULL,
  `search_page_status` int(11) NOT NULL,
  `permalink` varchar(2000) NOT NULL,
  `scan_id` varchar(2000) NOT NULL,
  `total_scans` int(11) NOT NULL,
  `approved_public` int(11) NOT NULL,
  `approved_public_cat` int(11) NOT NULL,
  `approved_public_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_urls`
--

INSERT INTO `user_urls` (`url_id`, `uid`, `url_title`, `url_value`, `url_desc`, `url_cat`, `editor_web_link`, `youtube_link_pick`, `status`, `created_time`, `created_date`, `updated_time`, `updated_date`, `ip_address`, `public_bag_link`, `trending_link`, `you_tube_link`, `is_video_link`, `video_id`, `video_web`, `video_embed_code`, `video_week`, `video_updated`, `pick_week_link`, `share_type`, `public_cat`, `add_to_search_page`, `search_page_status`, `permalink`, `scan_id`, `total_scans`, `approved_public`, `approved_public_cat`, `approved_public_time`) VALUES
(1, 0, 'facebbok', 'facebook.com', 'this is book', '-2', 1, 0, 1, 1535022992, '2018-08-23', 0, '0000-00-00', 0, 0, 0, 0, 0, '', 0, '', 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, 0, 0),
(2, 0, 'zomato', 'https://www.zomato.com/india', 'From swanky upscale restaurants to the cosiest hidden gems serving the most incredible food, Zomato covers it all. Explore menus, and millions of restaurant photos and reviews from users just like you, to find your next great meal.', '-2', 1, 0, 1, 1535023045, '2018-08-23', 0, '0000-00-00', 0, 0, 0, 0, 0, '', 0, '', 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, 0, 0),
(12, 0, 'Linkibag net', 'http://www.linkibag.net/PTest25x/linkibag/index.php', '1. What types of accounts are offered by LinkiBag?\r\nTo learn more about personal and commercial LinkiBag account types, click here.\r\n\r\n2. How can I obtain pricing information?\r\nLinkiBag accounts accounts are free. Click on the orange \"Free Signup\" link in the header area of the LinkiBag homepage to sign', '-2', 1, 0, 1, 1537273874, '2018-09-18', 0, '0000-00-00', 0, 0, 0, 0, 0, '', 0, '', 0, 0, 1, 0, 0, 0, 0, '', '', 0, 0, 0, 0),
(13, 6, 'test', 'https://google.com/', '', '-2', 0, 0, 1, 1578029638, '2020-01-03', 1578029638, '2020-01-03', 123456, 0, 0, 0, 0, '', 0, '', 0, 0, 0, 1, 1, 0, 0, 'https://www.virustotal.com/url/9d116b1b0c1200ca75016e4c010bc94836366881b021a658ea7f8548b6543c1e/analysis/1578029471/', '9d116b1b0c1200ca75016e4c010bc94836366881b021a658ea7f8548b6543c1e-1578029471', 72, 0, 0, 0),
(14, 6, 'test', 'https://www.facebook.com/', '', '-2', 0, 0, 1, 1578029703, '2020-01-03', 1578029703, '2020-01-03', 123456, 0, 0, 0, 0, '', 0, '', 0, 0, 0, 1, 1, 0, 0, 'https://www.virustotal.com/url/0b2df0f635584f42c895f1d7b9cd105d3106accd9804d30556da88ae1bb0d62c/analysis/1578027895/', '0b2df0f635584f42c895f1d7b9cd105d3106accd9804d30556da88ae1bb0d62c-1578027895', 72, 0, 0, 0),
(15, 6, 'test', 'https://www.wikipedia.org/', '', '-2', 0, 0, 1, 1578029739, '2020-01-03', 1578029739, '2020-01-03', 123456, 0, 0, 0, 0, '', 0, '', 0, 0, 0, 1, 1, 0, 0, 'https://www.virustotal.com/url/9a9d50ec8631eafde241ce5b6991ebb9ba74c8543397179e1b589e700bedefd4/analysis/1578023356/', '9a9d50ec8631eafde241ce5b6991ebb9ba74c8543397179e1b589e700bedefd4-1578023356', 72, 0, 0, 0),
(16, 6, 'test', 'https://medium.com/', '', '-2', 0, 0, 1, 1578029773, '2020-01-03', 1578029773, '2020-01-03', 123456, 0, 0, 0, 0, '', 0, '', 0, 0, 0, 1, 1, 0, 0, 'https://www.virustotal.com/url/206cc24ad041a6acd8fb5a12e42a8c7b3a29e0d4a98cb89287b44f8311487eaa/analysis/1578000139/', '206cc24ad041a6acd8fb5a12e42a8c7b3a29e0d4a98cb89287b44f8311487eaa-1578000139', 72, 0, 0, 0),
(17, 6, 'test', 'https://www.wikipedia.org/', '', '-2', 0, 0, 1, 1578035275, '2020-01-03', 1578035275, '2020-01-03', 123456, 0, 0, 0, 0, '', 0, '', 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, 0, 0),
(18, 6, 'test', 'https://google.com/', '', '-2', 0, 0, 1, 1578035276, '2020-01-03', 1578035276, '2020-01-03', 123456, 0, 0, 0, 0, '', 0, '', 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, 0, 0),
(19, 8, 'test', 'https://www.wikipedia.org/', '', '-2', 0, 0, 1, 1578035614, '2020-01-03', 1578035614, '2020-01-03', 123456, 0, 0, 0, 0, '', 0, '', 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, 0, 0),
(20, 8, 'test', 'https://google.com/', '', '-2', 0, 0, 1, 1578035614, '2020-01-03', 1578035614, '2020-01-03', 123456, 0, 0, 0, 0, '', 0, '', 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, 0, 0),
(21, 7, 'test', 'http://gmail.com/', '', '-2', 0, 0, 1, 1578041231, '2020-01-03', 1578041231, '2020-01-03', 123456, 0, 0, 0, 0, '', 0, '', 0, 0, 0, 2, 1, 0, 0, 'https://www.virustotal.com/url/282b361bc40f4db27462801befe15e387e87b87dbd36c6c3253a6bcc17d85596/analysis/1578040510/', '282b361bc40f4db27462801befe15e387e87b87dbd36c6c3253a6bcc17d85596-1578040510', 72, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `video_webs`
--

CREATE TABLE `video_webs` (
  `web_id` int(11) NOT NULL,
  `web_name` text NOT NULL,
  `status` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_webs`
--

INSERT INTO `video_webs` (`web_id`, `web_name`, `status`, `created`, `updated`) VALUES
(1, 'youtube', 1, 0, 0),
(2, 'dailymotion', 1, 0, 0),
(3, 'others', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_users_attachment`
--
ALTER TABLE `additional_users_attachment`
  ADD PRIMARY KEY (`attach_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `admin_ads`
--
ALTER TABLE `admin_ads`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`contact_info_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_disount`
--
ALTER TABLE `coupon_disount`
  ADD PRIMARY KEY (`discount_id`);

--
-- Indexes for table `friends_request`
--
ALTER TABLE `friends_request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `groups_friends`
--
ALTER TABLE `groups_friends`
  ADD PRIMARY KEY (`groups_friends_id`);

--
-- Indexes for table `info_security_links`
--
ALTER TABLE `info_security_links`
  ADD PRIMARY KEY (`info_security_link_id`);

--
-- Indexes for table `interested_category`
--
ALTER TABLE `interested_category`
  ADD PRIMARY KEY (`interested_cat`);

--
-- Indexes for table `linkibag_service_countries`
--
ALTER TABLE `linkibag_service_countries`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `linkibooks`
--
ALTER TABLE `linkibooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `linkibook_shared`
--
ALTER TABLE `linkibook_shared`
  ADD PRIMARY KEY (`shared_id`);

--
-- Indexes for table `linkibook_urls`
--
ALTER TABLE `linkibook_urls`
  ADD PRIMARY KEY (`bookurl_id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`newsletters_id`);

--
-- Indexes for table `newsletter_subscription`
--
ALTER TABLE `newsletter_subscription`
  ADD PRIMARY KEY (`subscribe_id`);

--
-- Indexes for table `outside_linkibag_service_area`
--
ALTER TABLE `outside_linkibag_service_area`
  ADD PRIMARY KEY (`service_area_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `page_imgs`
--
ALTER TABLE `page_imgs`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `popup_setting`
--
ALTER TABLE `popup_setting`
  ADD PRIMARY KEY (`popup_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`);

--
-- Indexes for table `recommend_user_category_msgs`
--
ALTER TABLE `recommend_user_category_msgs`
  ADD PRIMARY KEY (`recommend_msg_id`);

--
-- Indexes for table `securiy_questions`
--
ALTER TABLE `securiy_questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`subscription_id`);

--
-- Indexes for table `unsubscribe`
--
ALTER TABLE `unsubscribe`
  ADD PRIMARY KEY (`us_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `user_friends`
--
ALTER TABLE `user_friends`
  ADD PRIMARY KEY (`friend_id`);

--
-- Indexes for table `user_payments`
--
ALTER TABLE `user_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `user_public_category`
--
ALTER TABLE `user_public_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `user_public_category_comments`
--
ALTER TABLE `user_public_category_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `user_shared_urls`
--
ALTER TABLE `user_shared_urls`
  ADD PRIMARY KEY (`shared_url_id`);

--
-- Indexes for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD PRIMARY KEY (`subs_id`);

--
-- Indexes for table `user_urls`
--
ALTER TABLE `user_urls`
  ADD PRIMARY KEY (`url_id`);

--
-- Indexes for table `video_webs`
--
ALTER TABLE `video_webs`
  ADD PRIMARY KEY (`web_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_users_attachment`
--
ALTER TABLE `additional_users_attachment`
  MODIFY `attach_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_ads`
--
ALTER TABLE `admin_ads`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `contact_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `coupon_disount`
--
ALTER TABLE `coupon_disount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `friends_request`
--
ALTER TABLE `friends_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `groups_friends`
--
ALTER TABLE `groups_friends`
  MODIFY `groups_friends_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `info_security_links`
--
ALTER TABLE `info_security_links`
  MODIFY `info_security_link_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `interested_category`
--
ALTER TABLE `interested_category`
  MODIFY `interested_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `linkibag_service_countries`
--
ALTER TABLE `linkibag_service_countries`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `linkibooks`
--
ALTER TABLE `linkibooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `linkibook_shared`
--
ALTER TABLE `linkibook_shared`
  MODIFY `shared_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `linkibook_urls`
--
ALTER TABLE `linkibook_urls`
  MODIFY `bookurl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `newsletters_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `newsletter_subscription`
--
ALTER TABLE `newsletter_subscription`
  MODIFY `subscribe_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `outside_linkibag_service_area`
--
ALTER TABLE `outside_linkibag_service_area`
  MODIFY `service_area_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `page_imgs`
--
ALTER TABLE `page_imgs`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `popup_setting`
--
ALTER TABLE `popup_setting`
  MODIFY `popup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `recommend_user_category_msgs`
--
ALTER TABLE `recommend_user_category_msgs`
  MODIFY `recommend_msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `securiy_questions`
--
ALTER TABLE `securiy_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `subscription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `unsubscribe`
--
ALTER TABLE `unsubscribe`
  MODIFY `us_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_friends`
--
ALTER TABLE `user_friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user_payments`
--
ALTER TABLE `user_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_public_category`
--
ALTER TABLE `user_public_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_public_category_comments`
--
ALTER TABLE `user_public_category_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_shared_urls`
--
ALTER TABLE `user_shared_urls`
  MODIFY `shared_url_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  MODIFY `subs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_urls`
--
ALTER TABLE `user_urls`
  MODIFY `url_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `video_webs`
--
ALTER TABLE `video_webs`
  MODIFY `web_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
