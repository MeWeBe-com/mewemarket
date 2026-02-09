-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 03, 2021 at 11:52 AM
-- Server version: 10.2.36-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saasthemes_saascloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_setting`
--

CREATE TABLE `admin_setting` (
  `setting_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `paypal_email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_amount` varchar(255) NOT NULL,
  `subscription_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `billing_log` text NOT NULL,
  `app_url` text DEFAULT NULL,
  `billing_date` date NOT NULL,
  `billing_due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`id`, `product_id`, `user_id`, `package_amount`, `subscription_id`, `status`, `billing_log`, `app_url`, `billing_date`, `billing_due_date`) VALUES
(11, 11, 7, '1.00', 'I-DSXNDXEH9FJX', 'activate', '{\"txn_type\":\"subscr_signup\",\"subscr_id\":\"I-DSXNDXEH9FJX\",\"last_name\":\"Buy\",\"residence_country\":\"US\",\"mc_currency\":\"USD\",\"item_name\":\"Snap Time\",\"business\":\"haseebsale@gmail.com\",\"amount3\":\"1.00\",\"recurring\":\"1\",\"address_street\":\"001\",\"verify_sign\":\"ApRUeioe73Onh6wFz4HuRQR29JqaAp0nQbhPR5wIi4exJSJs.h.YnH0M\",\"payer_status\":\"verified\",\"test_ipn\":\"1\",\"payer_email\":\"haseebbuy@gmail.com\",\"address_status\":\"confirmed\",\"first_name\":\"Haseeb\",\"receiver_email\":\"haseebsale@gmail.com\",\"address_country_code\":\"US\",\"payer_id\":\"NV5D5ZQVJEX5N\",\"address_city\":\"San Jose\",\"reattempt\":\"1\",\"item_number\":\"11\",\"address_state\":\"CA\",\"subscr_date\":\"08:08:54 Nov 24, 2020 PST\",\"address_zip\":\"50002\",\"charset\":\"windows-1252\",\"notify_version\":\"3.9\",\"period3\":\"1 M\",\"address_country\":\"United States\",\"mc_amount3\":\"1.00\",\"address_name\":\"Haseeb Buy\",\"ipn_track_id\":\"e7a4ca24bb7a5\"}', 'http://mewemarket.com/apps/snaptime/login/Innovation', '2020-11-24', '2020-12-24'),
(12, 10, 7, '1.00', 'I-PWK9ET6ATG4K', 'activate', '{\"txn_type\":\"subscr_signup\",\"subscr_id\":\"I-PWK9ET6ATG4K\",\"last_name\":\"Buy\",\"residence_country\":\"US\",\"mc_currency\":\"USD\",\"item_name\":\"VisioPath - Hospital Management System\",\"business\":\"haseebsale@gmail.com\",\"amount3\":\"1.00\",\"recurring\":\"1\",\"address_street\":\"001\",\"verify_sign\":\"Ay2a19cGWLFCIbNr-bEEertvdb9wAVlcs.7A.qcELh-PJt.l0rsMlFAy\",\"payer_status\":\"verified\",\"test_ipn\":\"1\",\"payer_email\":\"haseebbuy@gmail.com\",\"address_status\":\"confirmed\",\"first_name\":\"Haseeb\",\"receiver_email\":\"haseebsale@gmail.com\",\"address_country_code\":\"US\",\"payer_id\":\"NV5D5ZQVJEX5N\",\"address_city\":\"San Jose\",\"reattempt\":\"1\",\"item_number\":\"10\",\"address_state\":\"CA\",\"subscr_date\":\"08:19:29 Nov 24, 2020 PST\",\"address_zip\":\"50002\",\"charset\":\"windows-1252\",\"notify_version\":\"3.9\",\"period3\":\"1 M\",\"address_country\":\"United States\",\"mc_amount3\":\"1.00\",\"address_name\":\"Haseeb Buy\",\"ipn_track_id\":\"8419f55ef3b78\"}', 'http://mewemarket.com/apps/visiopath/login/innovation', '2020-11-24', '2020-12-24'),
(15, 12, 7, '1.00', 'I-EFY6DV53R3YP', 'cancel', '{\"txn_type\":\"subscr_signup\",\"subscr_id\":\"I-EFY6DV53R3YP\",\"last_name\":\"Buy\",\"residence_country\":\"US\",\"mc_currency\":\"USD\",\"item_name\":\"Php QR Code Generator\",\"business\":\"haseebsale@gmail.com\",\"amount3\":\"1.00\",\"recurring\":\"1\",\"address_street\":\"001\",\"verify_sign\":\"ArOwH2-2U6ujY.v16rG9LUwNZrm7AWO4iEWG4r3dvnN.48lgRmiQMI7o\",\"payer_status\":\"verified\",\"test_ipn\":\"1\",\"payer_email\":\"haseebbuy@gmail.com\",\"address_status\":\"confirmed\",\"first_name\":\"Haseeb\",\"receiver_email\":\"haseebsale@gmail.com\",\"address_country_code\":\"US\",\"payer_id\":\"NV5D5ZQVJEX5N\",\"address_city\":\"San Jose\",\"reattempt\":\"1\",\"item_number\":\"12\",\"address_state\":\"CA\",\"subscr_date\":\"06:18:00 Nov 26, 2020 PST\",\"address_zip\":\"50002\",\"charset\":\"windows-1252\",\"notify_version\":\"3.9\",\"period3\":\"1 M\",\"address_country\":\"United States\",\"mc_amount3\":\"1.00\",\"address_name\":\"Haseeb Buy\",\"ipn_track_id\":\"a1ec31603a6b6\"}', 'http://mewemarket.com/apps/phpqrcode/Innovation', '2020-11-26', '2020-12-26'),
(16, 12, 7, '1.00', 'I-EFY6DV53R3YP', 'cancel', '{\"txn_type\":\"subscr_cancel\",\"subscr_id\":\"I-EFY6DV53R3YP\",\"last_name\":\"Buy\",\"residence_country\":\"US\",\"mc_currency\":\"USD\",\"item_name\":\"Php QR Code Generator\",\"business\":\"haseebsale@gmail.com\",\"amount3\":\"1.00\",\"recurring\":\"1\",\"address_street\":\"001\",\"verify_sign\":\"AgFTvQRc2EAdzwz9SI-w-03f3YqUAkRPmamHNYNci1ZHgFcm.M.5mmjj\",\"payer_status\":\"verified\",\"test_ipn\":\"1\",\"payer_email\":\"haseebbuy@gmail.com\",\"address_status\":\"confirmed\",\"first_name\":\"Haseeb\",\"receiver_email\":\"haseebsale@gmail.com\",\"address_country_code\":\"US\",\"payer_id\":\"NV5D5ZQVJEX5N\",\"address_city\":\"San Jose\",\"reattempt\":\"1\",\"item_number\":\"12\",\"address_state\":\"CA\",\"subscr_date\":\"22:07:25 Dec 06, 2020 PST\",\"address_zip\":\"50002\",\"charset\":\"windows-1252\",\"notify_version\":\"3.9\",\"period3\":\"1 M\",\"address_country\":\"United States\",\"mc_amount3\":\"1.00\",\"address_name\":\"Haseeb Buy\",\"ipn_track_id\":\"8152654ee254a\"}', NULL, '2020-12-07', '2021-01-07'),
(17, 13, 7, '1.00', 'I-GBRTFEASWYL6', 'activate', '{\"txn_type\":\"subscr_signup\",\"subscr_id\":\"I-GBRTFEASWYL6\",\"last_name\":\"Buy\",\"residence_country\":\"US\",\"mc_currency\":\"USD\",\"item_name\":\"Webid\",\"business\":\"mewemarket@gmail.com\",\"amount3\":\"1.00\",\"recurring\":\"1\",\"address_street\":\"001\",\"verify_sign\":\"A..cIorOvVulGraOKRIAVaAKsXqOAi-faf6gOqAp0kIz6cturLGxd-OK\",\"payer_status\":\"verified\",\"test_ipn\":\"1\",\"payer_email\":\"haseebbuy@gmail.com\",\"address_status\":\"confirmed\",\"first_name\":\"Haseeb\",\"receiver_email\":\"mewemarket@gmail.com\",\"address_country_code\":\"US\",\"payer_id\":\"NV5D5ZQVJEX5N\",\"address_city\":\"San Jose\",\"reattempt\":\"1\",\"item_number\":\"13\",\"address_state\":\"CA\",\"subscr_date\":\"06:16:10 Feb 01, 2021 PST\",\"address_zip\":\"50002\",\"charset\":\"UTF-8\",\"notify_version\":\"3.9\",\"period3\":\"1 M\",\"address_country\":\"United States\",\"mc_amount3\":\"1.00\",\"address_name\":\"Haseeb Buy\",\"ipn_track_id\":\"79656d550c3b5\"}', 'https://mewemarket.com/apps/web2/user_login.php/?company=innovation\r\n', '2021-02-01', '2021-03-01'),
(18, 14, 7, '1.00', 'I-EVW8UF9EY1RD', 'activate', '{\"txn_type\":\"subscr_signup\",\"subscr_id\":\"I-EVW8UF9EY1RD\",\"last_name\":\"Buy\",\"residence_country\":\"US\",\"mc_currency\":\"USD\",\"item_name\":\"Live Video Streaming\",\"business\":\"mewemarket@gmail.com\",\"amount3\":\"1.00\",\"recurring\":\"1\",\"address_street\":\"001\",\"verify_sign\":\"AOTcs.XquWMLAxq5xzefa12tZFDNAfZHGlqyyDaFraBUnnnIiW3zhxgS\",\"payer_status\":\"verified\",\"test_ipn\":\"1\",\"payer_email\":\"haseebbuy@gmail.com\",\"address_status\":\"confirmed\",\"first_name\":\"Haseeb\",\"receiver_email\":\"mewemarket@gmail.com\",\"address_country_code\":\"US\",\"payer_id\":\"NV5D5ZQVJEX5N\",\"address_city\":\"San Jose\",\"reattempt\":\"1\",\"item_number\":\"14\",\"address_state\":\"CA\",\"subscr_date\":\"09:29:35 Feb 02, 2021 PST\",\"address_zip\":\"50002\",\"charset\":\"UTF-8\",\"notify_version\":\"3.9\",\"period3\":\"1 M\",\"address_country\":\"United States\",\"mc_amount3\":\"1.00\",\"address_name\":\"Haseeb Buy\",\"ipn_track_id\":\"8570e40d4894f\"}', 'https://mewemarket.com/apps/video/', '2021-02-02', '2021-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_icon` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `visibility` int(11) NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_icon`, `category_name`, `visibility`, `ordering`) VALUES
(1, 'fas fa-lock-open', 'Open Source', 0, 1),
(2, 'fas fa-briefcase', 'Business', 1, 2),
(3, 'fas fa-mobile-alt', 'Application', 1, 3),
(4, 'fas fa-poll', 'Customer Service', 1, 4),
(5, 'fas fa-university', 'Education', 1, 5),
(6, 'fas fa-chart-line', 'Finance', 1, 6),
(7, 'fas fa-balance-scale-left', 'Legal', 1, 7),
(8, 'fas fa-trailer', 'Logistics', 1, 8),
(9, 'fas fa-bullhorn', 'Marketing', 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `country_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `country_code`) VALUES
(1, 'AFGHANISTAN', 'AF'),
(2, 'ALBANIA', 'AL'),
(3, 'ALGERIA', 'DZ'),
(4, 'AMERICAN SAMOA', 'AS'),
(5, 'ANDORRA', 'AD'),
(6, 'ANGOLA', 'AO'),
(7, 'ANGUILLA', 'AI'),
(8, 'ANTARCTICA', 'AQ'),
(9, 'ANTIGUA AND BARBUDA', 'AG'),
(10, 'ARGENTINA', 'AR'),
(11, 'ARMENIA', 'AM'),
(12, 'ARUBA', 'AW'),
(13, 'AUSTRALIA', 'AU'),
(14, 'AUSTRIA', 'AT'),
(15, 'AZERBAIJAN', 'AZ'),
(16, 'BAHAMAS', 'BS'),
(17, 'BAHRAIN', 'BH'),
(18, 'BANGLADESH', 'BD'),
(19, 'BARBADOS', 'BB'),
(20, 'BELARUS', 'BY'),
(21, 'BELGIUM', 'BE'),
(22, 'BELIZE', 'BZ'),
(23, 'BENIN', 'BJ'),
(24, 'BERMUDA', 'BM'),
(25, 'BHUTAN', 'BT'),
(26, 'BOLIVIA', 'BO'),
(27, 'BOSNIA AND HERZEGOVINA', 'BA'),
(28, 'BOTSWANA', 'BW'),
(29, 'BOUVET ISLAND', 'BV'),
(30, 'BRAZIL', 'BR'),
(31, 'BRITISH INDIAN OCEAN TERRITORY', 'IO'),
(32, 'BRUNEI DARUSSALAM', 'BN'),
(33, 'BULGARIA', 'BG'),
(34, 'BURKINA FASO', 'BF'),
(35, 'BURUNDI', 'BI'),
(36, 'CAMBODIA', 'KH'),
(37, 'CAMEROON', 'CM'),
(38, 'CANADA', 'CA'),
(39, 'CAPE VERDE', 'CV'),
(40, 'CAYMAN ISLANDS', 'KY'),
(41, 'CENTRAL AFRICAN REPUBLIC', 'CF'),
(42, 'CHAD', 'TD'),
(43, 'CHILE', 'CL'),
(44, 'CHINA', 'CN'),
(45, 'CHRISTMAS ISLAND', 'CX'),
(46, 'COCOS (KEELING) ISLANDS', 'CC'),
(47, 'COLOMBIA', 'CO'),
(48, 'COMOROS', 'KM'),
(49, 'CONGO', 'CG'),
(50, 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'CD'),
(51, 'COOK ISLANDS', 'CK'),
(52, 'COSTA RICA', 'CR'),
(53, 'COTE D\'IVOIRE', 'CI'),
(54, 'CROATIA', 'HR'),
(55, 'CUBA', 'CU'),
(56, 'CYPRUS', 'CY'),
(57, 'CZECH REPUBLIC', 'CZ'),
(58, 'DENMARK', 'DK'),
(59, 'DJIBOUTI', 'DJ'),
(60, 'DOMINICA', 'DM'),
(61, 'DOMINICAN REPUBLIC', 'DO'),
(62, 'ECUADOR', 'EC'),
(63, 'EGYPT', 'EG'),
(64, 'EL SALVADOR', 'SV'),
(65, 'EQUATORIAL GUINEA', 'GQ'),
(66, 'ERITREA', 'ER'),
(67, 'ESTONIA', 'EE'),
(68, 'ETHIOPIA', 'ET'),
(69, 'FALKLAND ISLANDS (MALVINAS)', 'FK'),
(70, 'FAROE ISLANDS', 'FO'),
(71, 'FIJI', 'FJ'),
(72, 'FINLAND', 'FI'),
(73, 'FRANCE', 'FR'),
(74, 'FRENCH GUIANA', 'GF'),
(75, 'FRENCH POLYNESIA', 'PF'),
(76, 'FRENCH SOUTHERN TERRITORIES', 'TF'),
(77, 'GABON', 'GA'),
(78, 'GAMBIA', 'GM'),
(79, 'GEORGIA', 'GE'),
(80, 'GERMANY', 'DE'),
(81, 'GHANA', 'GH'),
(82, 'GIBRALTAR', 'GI'),
(83, 'GREECE', 'GR'),
(84, 'GREENLAND', 'GL'),
(85, 'GRENADA', 'GD'),
(86, 'GUADELOUPE', 'GP'),
(87, 'GUAM', 'GU'),
(88, 'GUATEMALA', 'GT'),
(89, 'GUINEA', 'GN'),
(90, 'GUINEA-BISSAU', 'GW'),
(91, 'GUYANA', 'GY'),
(92, 'HAITI', 'HT'),
(93, 'HEARD ISLAND AND MCDONALD ISLANDS', 'HM'),
(94, 'HOLY SEE (VATICAN CITY STATE)', 'VA'),
(95, 'HONDURAS', 'HN'),
(96, 'HONG KONG', 'HK'),
(97, 'HUNGARY', 'HU'),
(98, 'ICELAND', 'IS'),
(99, 'INDIA', 'IN'),
(100, 'INDONESIA', 'ID'),
(101, 'IRAN, ISLAMIC REPUBLIC OF', 'IR'),
(102, 'IRAQ', 'IQ'),
(103, 'IRELAND', 'IE'),
(104, 'ISRAEL', 'IL'),
(105, 'ITALY', 'IT'),
(106, 'JAMAICA', 'JM'),
(107, 'JAPAN', 'JP'),
(108, 'JORDAN', 'JO'),
(109, 'KAZAKHSTAN', 'KZ'),
(110, 'KENYA', 'KE'),
(111, 'KIRIBATI', 'KI'),
(112, 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'KP'),
(113, 'KOREA, REPUBLIC OF', 'KR'),
(114, 'KUWAIT', 'KW'),
(115, 'KYRGYZSTAN', 'KG'),
(116, 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'LA'),
(117, 'LATVIA', 'LV'),
(118, 'LEBANON', 'LB'),
(119, 'LESOTHO', 'LS'),
(120, 'LIBERIA', 'LR'),
(121, 'LIBYAN ARAB JAMAHIRIYA', 'LY'),
(122, 'LIECHTENSTEIN', 'LI'),
(123, 'LITHUANIA', 'LT'),
(124, 'LUXEMBOURG', 'LU'),
(125, 'MACAO', 'MO'),
(126, 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'MK'),
(127, 'MADAGASCAR', 'MG'),
(128, 'MALAWI', 'MW'),
(129, 'MALAYSIA', 'MY'),
(130, 'MALDIVES', 'MV'),
(131, 'MALI', 'ML'),
(132, 'MALTA', 'MT'),
(133, 'MARSHALL ISLANDS', 'MH'),
(134, 'MARTINIQUE', 'MQ'),
(135, 'MAURITANIA', 'MR'),
(136, 'MAURITIUS', 'MU'),
(137, 'MAYOTTE', 'YT'),
(138, 'MEXICO', 'MX'),
(139, 'MICRONESIA, FEDERATED STATES OF', 'FM'),
(140, 'MOLDOVA, REPUBLIC OF', 'MD'),
(141, 'MONACO', 'MC'),
(142, 'MONGOLIA', 'MN'),
(143, 'MONTSERRAT', 'MS'),
(144, 'MOROCCO', 'MA'),
(145, 'MOZAMBIQUE', 'MZ'),
(146, 'MYANMAR', 'MM'),
(147, 'NAMIBIA', 'NA'),
(148, 'NAURU', 'NR'),
(149, 'NEPAL', 'NP'),
(150, 'NETHERLANDS', 'NL'),
(151, 'NETHERLANDS ANTILLES', 'AN'),
(152, 'NEW CALEDONIA', 'NC'),
(153, 'NEW ZEALAND', 'NZ'),
(154, 'NICARAGUA', 'NI'),
(155, 'NIGER', 'NE'),
(156, 'NIGERIA', 'NG'),
(157, 'NIUE', 'NU'),
(158, 'NORFOLK ISLAND', 'NF'),
(159, 'NORTHERN MARIANA ISLANDS', 'MP'),
(160, 'NORWAY', 'NO'),
(161, 'OMAN', 'OM'),
(162, 'PAKISTAN', 'PK'),
(163, 'PALAU', 'PW'),
(164, 'PALESTINIAN TERRITORY, OCCUPIED', 'PS'),
(165, 'PANAMA', 'PA'),
(166, 'PAPUA NEW GUINEA', 'PG'),
(167, 'PARAGUAY', 'PY'),
(168, 'PERU', 'PE'),
(169, 'PHILIPPINES', 'PH'),
(170, 'PITCAIRN', 'PN'),
(171, 'POLAND', 'PL'),
(172, 'PORTUGAL', 'PT'),
(173, 'PUERTO RICO', 'PR'),
(174, 'QATAR', 'QA'),
(175, 'REUNION', 'RE'),
(176, 'ROMANIA', 'RO'),
(177, 'RUSSIAN FEDERATION', 'RU'),
(178, 'RWANDA', 'RW'),
(179, 'SAINT HELENA', 'SH'),
(180, 'SAINT KITTS AND NEVIS', 'KN'),
(181, 'SAINT LUCIA', 'LC'),
(182, 'SAINT PIERRE AND MIQUELON', 'PM'),
(183, 'SAINT VINCENT AND THE GRENADINES', 'VC'),
(184, 'SAMOA', 'WS'),
(185, 'SAN MARINO', 'SM'),
(186, 'SAO TOME AND PRINCIPE', 'ST'),
(187, 'SAUDI ARABIA', 'SA'),
(188, 'SENEGAL', 'SN'),
(189, 'SERBIA AND MONTENEGRO', 'CS'),
(190, 'SEYCHELLES', 'SC'),
(191, 'SIERRA LEONE', 'SL'),
(192, 'SINGAPORE', 'SG'),
(193, 'SLOVAKIA', 'SK'),
(194, 'SLOVENIA', 'SI'),
(195, 'SOLOMON ISLANDS', 'SB'),
(196, 'SOMALIA', 'SO'),
(197, 'SOUTH AFRICA', 'ZA'),
(198, 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'GS'),
(199, 'SPAIN', 'ES'),
(200, 'SRI LANKA', 'LK'),
(201, 'SUDAN', 'SD'),
(202, 'SURINAME', 'SR'),
(203, 'SVALBARD AND JAN MAYEN', 'SJ'),
(204, 'SWAZILAND', 'SZ'),
(205, 'SWEDEN', 'SE'),
(206, 'SWITZERLAND', 'CH'),
(207, 'SYRIAN ARAB REPUBLIC', 'SY'),
(208, 'TAIWAN, PROVINCE OF CHINA', 'TW'),
(209, 'TAJIKISTAN', 'TJ'),
(210, 'TANZANIA, UNITED REPUBLIC OF', 'TZ'),
(211, 'THAILAND', 'TH'),
(212, 'TIMOR-LESTE', 'TL'),
(213, 'TOGO', 'TG'),
(214, 'TOKELAU', 'TK'),
(215, 'TONGA', 'TO'),
(216, 'TRINIDAD AND TOBAGO', 'TT'),
(217, 'TUNISIA', 'TN'),
(218, 'TURKEY', 'TR'),
(219, 'TURKMENISTAN', 'TM'),
(220, 'TURKS AND CAICOS ISLANDS', 'TC'),
(221, 'TUVALU', 'TV'),
(222, 'UGANDA', 'UG'),
(223, 'UKRAINE', 'UA'),
(224, 'UNITED ARAB EMIRATES', 'AE'),
(225, 'UNITED KINGDOM', 'GB'),
(226, 'UNITED STATES', 'US'),
(227, 'UNITED STATES MINOR OUTLYING ISLANDS', 'UM'),
(228, 'URUGUAY', 'UY'),
(229, 'UZBEKISTAN', 'UZ'),
(230, 'VANUATU', 'VU'),
(231, 'VENEZUELA', 'VE'),
(232, 'VIET NAM', 'VN'),
(233, 'VIRGIN ISLANDS, BRITISH', 'VG'),
(234, 'VIRGIN ISLANDS, U.S.', 'VI'),
(235, 'WALLIS AND FUTUNA', 'WF'),
(236, 'WESTERN SAHARA', 'EH'),
(237, 'YEMEN', 'YE'),
(238, 'ZAMBIA', 'ZM'),
(239, 'ZIMBABWE', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `custom_page`
--

CREATE TABLE `custom_page` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_slug` varchar(255) NOT NULL,
  `page_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `package_amount` varchar(255) NOT NULL,
  `package_duration` varchar(255) NOT NULL,
  `user_limit` varchar(255) DEFAULT NULL,
  `tools_limit` int(11) DEFAULT NULL,
  `reports` varchar(255) DEFAULT NULL,
  `package_description` text NOT NULL,
  `visibility` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `package_name`, `package_amount`, `package_duration`, `user_limit`, `tools_limit`, `reports`, `package_description`, `visibility`, `created_at`) VALUES
(1, 'Demo', '0', 'Half Month', '1', 1, '1', '1 user\r\n24-hour support\r\n1 tool', 0, '2020-10-21 19:32:17'),
(2, 'Basic', '2', 'Month', '9', 1, '0', '1-9 users\r\n24-hour support\r\n1 tool', 1, '2020-10-21 20:28:42'),
(3, 'Plus', '5', 'Month', '49', 5, '2', '10-49 users\r\n24-hour support\r\n2 reports a month\r\n5 tools', 1, '2020-10-21 20:30:08'),
(4, 'Pro', '10', 'Month', '50', 1000, '1000', '50+ users\r\n24-hour support\r\nUnlimited reports\r\nUnlimited tools', 1, '2020-10-21 20:35:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `demo_link` text DEFAULT NULL,
  `product_video` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `key_benefits` text NOT NULL,
  `compatible_browsers` varchar(255) NOT NULL,
  `files_included` varchar(255) NOT NULL,
  `software_framework` varchar(255) NOT NULL,
  `software_version` varchar(255) NOT NULL,
  `api_url` varchar(255) NOT NULL,
  `api_type` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_type`, `product_name`, `description`, `demo_link`, `product_video`, `featured_image`, `key_benefits`, `compatible_browsers`, `files_included`, `software_framework`, `software_version`, `api_url`, `api_type`, `created_at`, `updated_at`) VALUES
(10, 3, 'Hospital Management Tools', 'VisioPath - Hospital Management System', 'We provide a simple and easy booking online software system. So, the user could view all those services provided by the clinic, select the specialist, availability of doctors and appointment date. The time and date will be chosen after confirming the doctor’s availability. Our main aim is to provide simple and effective online services for doctor appointments.', 'http://mewemarket.com/apps/visiopath/login/demo', NULL, 'visiopathlogo.jpg', 'Visiopath Features:\r\n\r\n    New patients are easily register\r\n    Simple Login and Register\r\n    Select the clinic services based on the categories\r\n    Select the city through keyword for view the nearest clinic\r\n    View all the nearest clinics\r\n    View the detailed information about the clinic, doctor and images\r\n    Check the availability and cost\r\n    Provide ratings and comments\r\n    Make the simple appointment process\r\n\r\nOther Features:\r\n\r\n    Fully Responsive Layout\r\n    Tables and DataTables\r\n    Font Awesome icons\r\n    Feather icons\r\n    Cross Browser Compatible\r\n    Easy to Customize\r\n    Powerful & Lightweight\r\n    Clean & Well Commented Codes\r\n    Compatible to all Mobile Devices\r\n    Customizable Calender Design\r\n    Login, Sign Up pages\r\n    Chat View\r\n    Error pages\r\n\r\nAnd much more…\r\nWhat will you get?\r\n\r\n    Reliable Technical Support System\r\n    Lifetime Template Updates\r\n    Template Documentation\r\n\r\nThis item is supported\r\nSupport is conducted through our Support Forum. We are in GMT +05.30 and we aim to answer all questions within 24 hours on weekdays. In some cases, the waiting time can be extended to 48 hours. Support requests sent during weekends or public holidays will be processed on next Monday or the next business day.', 'IE6', 'HTML|CSS|PHP|SQL', 'CodeIgniter', 'PHP 7.x|MySQL 5.x', 'http://mewemarket.com/apps/visiopath/api', 'saas_app', '2020-11-23 13:40:49', NULL),
(11, 2, 'Project Management Tools', 'Snap Time ', 'Smarty themes give full-screen images with user-friendly and highly customizable features. The portfolio can be made in nine unique styles. The template is a real marvel in the field of Snapshots. On top of that, the themes are available in two color versions viz. dark and light. The key features of Smarty HTML portfolio templates are:\r\n\r\n    Trending styles available\r\n    Single and Multiple pages\r\n    38 different HTML files\r\n    Available in five blog styles\r\n    Expert Support and assistance in Documentation\r\n\r\nGrab a Smarty HTML creative theme and get your clicks to look more than just photos!', 'http://mewemarket.com/apps/snaptime/login/demo_company  ', NULL, 'Logo_white_on_black.jpg', '\r\n    Trending Design\r\n    100% Responsive\r\n    Onepage & Multipage versions\r\n    Light & Dark Version\r\n    W3C Validated\r\n    Bootstrap 3 with LESS preprocessor\r\n    Working Contact Forms\r\n    9 Portfolio Styles\r\n    5 Blog listing Styles\r\n    Contact & About Page\r\n    38 HTML files\r\n    Documentation & Elite Support', 'IE6', 'HTML|CSS|JavaScript JS|PHP', 'CodeIgniter', 'PHP 7.x|MySQL 5.x', 'http://mewemarket.com/apps/snaptime/api/authentication/register_from_sass', 'saas_app', '2020-11-23 17:31:19', NULL),
(12, 3, 'Generator', 'Php QR Code Generator', 'QR Code is a two-dimensional version of the barcode, typically made up of black and white pixel patterns. Denso Wave, a Japanese subsidiary of the Toyota supplier Denso, developed them for marking components in order to accelerate logistics processes for their automobile production. Now, it has found its way into mobile marketing with the widespread adoption of smartphones. \"QR\" stands for \"Quick Response\", which refers to the instant access to the information hidden in the Code.', 'http://mewemarket.com/apps/phpqrcode/', NULL, 'qr-code.jpg', 'Quick Response for the customer you can add your details in qr code', 'IE6', 'PHP', 'Core PHP', 'PHP 7.x', 'http://mewemarket.com/apps/phpqrcode/', 'normal_app', '2020-11-26 18:18:32', NULL),
(13, 2, 'Auction', 'Webid', 'WeBid is the perfect way to get your auction site up and away\r\n\r\nIt will allow you to quickly set up your own auction site and get started straight away.', 'https://mewemarket.com/apps/web2/', NULL, '3.jpg', 'Create auctions with galleries\r\nAllow to charge users fees\r\nFully customisable via admin panel\r\nBuilt in payment gateways\r\nAbility to set users to be sellers or buyers\r\nUser feedback and auction Q&A', 'IE6', 'HTML|CSS|JavaScript JS|PHP|SQL', 'Core PHP', 'PHP 7.x|MySQL 5.x', 'https://mewemarket.com/apps/web2/api.php', 'saas_app', '2021-02-01 13:24:39', NULL),
(14, 1, 'Video stream', 'Live Video Streaming', 'Live Streaming  Broadcast live video, Share link with others to watch, HTML5 WebRTC live video, Text chat with audio recordings / emoticons / mentions, Dark mode, Sound effects. ????100% Web Based,  No Flash. ', 'https://mewemarket.com/apps/video/', NULL, 'livestream.jpg', '1 way to many live video streaming, in public lobby\r\nvideo/audio recorder, emoticons, mentions in text chat\r\nWebRTC relayed streaming (reliable and scalable to many clients from streaming server, independent of broadcaster upload connection)\\\r\nfullscreen for videochat interface or playback video\r\nadaptive target video bitrate (depending on cam resolution) and configuration in resolution change\r\nbroadcasting/playback stats (open controls and stats should show in few seconds)\r\ndark mode / lights on: each user can toggle interface mode live at runtime, SFX (sound effects)\r\ntranslation and text change support\r\nrequest private 2 way calls / shows from group chat\r\nrandom videochat with Next button to move to different performer room\r\nlive wallet balance display (updates from tips and other transfers)\r\ntips with multiple customizable options, gift images', 'Firefox|Safari|Chrome', 'HTML|CSS|JavaScript JS', 'Core PHP', 'PHP 7.x', 'https://mewemarket.com/apps/video/', 'normal_app', '2021-02-02 18:16:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `id` int(11) NOT NULL,
  `test_title` varchar(255) NOT NULL,
  `test_description` varchar(255) NOT NULL,
  `test_designation` varchar(255) NOT NULL,
  `test_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_role` enum('1','0') NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `original_password` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `country_id` varchar(255) DEFAULT NULL,
  `verification_key` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `company_name`, `first_name`, `last_name`, `user_name`, `user_role`, `user_password`, `original_password`, `date_of_birth`, `user_email`, `contact_number`, `street`, `state`, `zip_code`, `country_id`, `verification_key`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin Store', 'Super', 'Admin', 'superadmin', '1', 'c1bb19b27818343c1926119b958741b5', 'Human', '1988-07-07', 'yaze.live@gmail.com', '+44778855662211', '123 street', 'london', 'AB4 6xy', '225', '', 1, '2020-10-19 19:54:55', NULL),
(7, 'Innovation', 'haseeb', 'Hanif', 'hussy123', '0', 'c1bb19b27818343c1926119b958741b5', 'Human', '2001-11-11', 'haseeb.idevation@gmail.com', '+44778855662211', '123 street', 'Sindh', 'AB4 6xy', '162', 'xT4QpK8ghs79WPRb', 1, '2020-11-24 15:31:26', NULL),
(8, 'Vewr', 'John', 'Does', 'Johndoe', '0', 'c1bb19b27818343c1926119b958741b5', 'Human', '0000-00-00', 'shturzka@gmail.com', '+995551080407', 'Chavahcavadze av', 'zugdidi', '0112', '79', NULL, 1, '2020-11-30 07:16:17', NULL),
(9, 'pULrheStMnYRxdso', 'pvlaIkCtwLKnSXYq', 'nwEVpkyZbAmeH', 'HCpAPBslTu', '0', '18144459b9fe423829b70727b3ce638c', '', '2020-02-12', 'chetsadaran70@gmail.com', 'FHqgKsNXnBlRGaJ', 'pJovQUcNxjTFBeCu', 'lkpThCmtO', 'dnZuhfVXHLY', '239', 'aQ7dDxWlZuq3Plpa', 1, '2020-12-02 02:22:45', NULL),
(10, 'xgtQiSNv', 'cTUoZyPz', 'baUEFQLeWYHh', 'SFzaZfoRU', '0', '2ef3af54cfa61477f8c27f0e1f54ca33', '', '2020-02-12', 'chetsadaran70@gmail.com', 'yJPAsaeSXGuv', 'stVahMcrNjoK', 'DJQstabvg', 'AjdFCpTlJHRhu', '239', 'aQ7dDxWlZuq3Plpa', 1, '2020-12-02 02:22:45', NULL),
(11, 'Creatwhix', 'create', 'whiz', 'hassy', '0', '5b53f04d3a92c759e4c72ce6b94a6243', '', '0000-00-00', 'createwhix@gmail.com', '+3462300676', 'portway Trade Center', 'sindh', 'Ab4 6xy', '162', NULL, 1, '2021-01-13 10:57:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_favourite`
--

CREATE TABLE `user_favourite` (
  `favourite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_favourite`
--

INSERT INTO `user_favourite` (`favourite_id`, `user_id`, `product_id`, `created_at`) VALUES
(9, 4, 0, '2020-11-19 16:27:11'),
(10, 4, 0, '2020-11-19 16:27:31'),
(12, 7, 11, '2020-11-24 15:40:02'),
(13, 7, 10, '2020-11-27 14:38:46'),
(14, 7, 12, '2020-12-07 07:06:56');

-- --------------------------------------------------------

--
-- Table structure for table `user_products`
--

CREATE TABLE `user_products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_setting`
--
ALTER TABLE `admin_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `custom_page`
--
ALTER TABLE `custom_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id_category_id` (`category_id`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_favourite`
--
ALTER TABLE `user_favourite`
  ADD PRIMARY KEY (`favourite_id`);

--
-- Indexes for table `user_products`
--
ALTER TABLE `user_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id_product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_setting`
--
ALTER TABLE `admin_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `custom_page`
--
ALTER TABLE `custom_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_favourite`
--
ALTER TABLE `user_favourite`
  MODIFY `favourite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_products`
--
ALTER TABLE `user_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `category_id_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_products`
--
ALTER TABLE `user_products`
  ADD CONSTRAINT `product_id_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
