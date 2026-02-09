-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2017 at 07:28 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inc`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `DEPARTMENT_NAME` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`DEPARTMENT_NAME`) VALUES
('COPT'),
('CTS'),
('INT'),
('OPT');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EMPLOYEE_ID` bigint(20) NOT NULL,
  `EMPLOYEE_PASSWORD` varchar(30) NOT NULL,
  `EMPLOYEE_PRIVILEGE` int(11) NOT NULL,
  `EMPLOYEE_NAME` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EMPLOYEE_ID`, `EMPLOYEE_PASSWORD`, `EMPLOYEE_PRIVILEGE`, `EMPLOYEE_NAME`) VALUES
(1, 'zia', 1, 'Zia'),
(10, 'ahad', 3, 'ahad'),
(11, 'sharif', 2, 'sharif'),
(12, 'shahjahan', 2, 'shahjahan'),
(13, 'selim', 2, 'selim'),
(14, 'kamrul', 2, 'kamrul'),
(15, 'shamseer', 2, 'shamseer'),
(16, 'mahin', 2, 'mahin'),
(17, 'maruf', 2, 'maruf'),
(18, 'shohag', 3, 'shohag'),
(19, 'emon', 3, 'emon'),
(21, 'shabnam', 2, 'shabnam'),
(22, 'shuvo', 3, 'shuvo'),
(23, 'auntu', 3, 'auntu'),
(24, 'nazmul', 3, 'nazmul'),
(25, 'faiza', 3, 'faiza'),
(26, 'rajiur', 3, 'rajiur'),
(27, 'priyadip', 3, 'priyadip'),
(28, 'ashraf', 2, 'ashraf'),
(29, 'alo', 3, 'alo'),
(30, 'asad', 3, 'asad'),
(31, 'shishir', 3, 'shishir'),
(32, 'nasir', 3, 'nasir'),
(33, 'nafis', 3, 'nafis');

-- --------------------------------------------------------

--
-- Table structure for table `employee_task_assignment`
--

CREATE TABLE `employee_task_assignment` (
  `EMPLOYEE_ID` bigint(20) NOT NULL,
  `ASSIGNED_TO` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `TASK_CATEGORY` varchar(50) NOT NULL,
  `DATE_ASSIGNED` date DEFAULT NULL,
  `DATE_COMPLETED` date DEFAULT NULL,
  `TASK_ID` bigint(20) NOT NULL,
  `TASK_TITLE` varchar(70) NOT NULL,
  `TASK_AMOUNT` int(11) UNSIGNED NOT NULL,
  `TASK_PERCENTAGE` int(11) UNSIGNED DEFAULT '0',
  `DATE_ADDED` date NOT NULL,
  `TASK_AMOUNT_DONE` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `TASK_AMOUNT_ASSIGNED` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`TASK_CATEGORY`, `DATE_ASSIGNED`, `DATE_COMPLETED`, `TASK_ID`, `TASK_TITLE`, `TASK_AMOUNT`, `TASK_PERCENTAGE`, `DATE_ADDED`, `TASK_AMOUNT_DONE`, `TASK_AMOUNT_ASSIGNED`) VALUES
('TRX addition/ Deletion', '2017-01-26', NULL, 26, 'TRX ADD 78', 78, NULL, '2017-01-03', 32, 32),
(' Backup', '2017-01-18', '2017-01-08', 27, 'BACKUP DEC', 20, NULL, '2017-01-03', 20, 20),
(' Backup', '2017-01-19', NULL, 28, 'FEB Backup', 45, NULL, '2017-01-08', 5, 32),
('Traffic shifting', '2017-02-14', NULL, 29, 'FEB Traffic Shift', 40, NULL, '2017-01-08', 4, 19),
('BSC Add/del', '2017-01-12', NULL, 30, 'JAN BSC ADD', 50, NULL, '2017-01-08', 4, 2),
('3G Sectorization', '2017-01-20', NULL, 31, 'APRIL SECT', 30, NULL, '2017-01-08', 2, 4),
('EDB Tuning', '2017-01-26', NULL, 32, 'FEB EDB', 23, NULL, '2017-01-08', 5, 5),
('Cell addition (2G)', '2017-01-10', NULL, 33, 'CELL ADDITION JAN', 150, NULL, '2017-01-08', 8, 20),
('TRX addition/ Deletion', '2017-01-20', NULL, 34, 'TRX ADD', 20, NULL, '2017-01-11', 11, 10);

-- --------------------------------------------------------

--
-- Table structure for table `task_assignment`
--

CREATE TABLE `task_assignment` (
  `TASK_ASSIGNMENT_ID` bigint(20) NOT NULL,
  `ASSIGNED_TO` varchar(50) NOT NULL,
  `ASSIGNED_BY` varchar(50) NOT NULL,
  `DATE_ASSIGNED` date NOT NULL,
  `TASK_ID` bigint(20) NOT NULL,
  `DATE_ACCEPTED` date DEFAULT NULL,
  `DATE_COMPLETED` date DEFAULT NULL,
  `ASSIGNED_AMOUNT` int(11) UNSIGNED NOT NULL,
  `DONE_AMOUNT` int(11) NOT NULL DEFAULT '0',
  `MANAGER_COMMENT` varchar(250) NOT NULL DEFAULT 'Nothing',
  `ARTISAN_COMMENT` varchar(250) NOT NULL DEFAULT 'Nothing'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_assignment`
--

INSERT INTO `task_assignment` (`TASK_ASSIGNMENT_ID`, `ASSIGNED_TO`, `ASSIGNED_BY`, `DATE_ASSIGNED`, `TASK_ID`, `DATE_ACCEPTED`, `DATE_COMPLETED`, `ASSIGNED_AMOUNT`, `DONE_AMOUNT`, `MANAGER_COMMENT`, `ARTISAN_COMMENT`) VALUES
(1, 'shohag', 'zia', '2016-12-14', 1, '2016-12-15', '2016-12-14', 16, 0, 'Nothing', 'Nothing'),
(5, 'priyadip', 'zia', '2016-12-17', 1, '2016-12-13', '2016-12-14', 13, 13, 'Nothing', 'Nothing'),
(6, 'shohag', 'zia', '2016-12-17', 2, NULL, '2016-12-14', 20, 0, 'Nothing', 'Nothing'),
(7, 'priyadip', 'zia', '2016-12-18', 2, '2016-12-13', NULL, 15, 0, 'Nothing', 'Nothing'),
(8, 'shohag', 'zia', '2016-12-18', 3, NULL, '2016-12-22', 26, 0, 'Nothing', 'Nothing'),
(9, 'shohag', 'zia', '2016-12-17', 4, '2016-12-13', NULL, 26, 0, 'Nothing', 'Nothing'),
(10, 'shohag', 'zia', '2016-12-17', 5, '2016-12-13', NULL, 10, 0, 'Nothing', 'Nothing'),
(11, 'priyadip', 'zia', '2016-12-16', 6, '2016-12-13', NULL, 8, 8, 'Nothing', 'Nothing'),
(12, 'shohag', 'zia', '2016-12-18', 6, '2016-12-13', NULL, 10, 0, 'Nothing', 'Nothing'),
(13, 'priyadip', 'zia', '2016-12-17', 7, '2016-12-13', '2016-12-14', 20, 10, 'Nothing', 'Nothing'),
(14, 'priyadip', 'zia', '2016-12-18', 8, '2016-12-13', '2016-12-14', 10, 10, 'Nothing', 'Nothing'),
(15, 'shohag', 'zia', '2016-12-18', 9, '2016-12-13', NULL, 15, 0, 'Nothing', 'Nothing'),
(16, 'shohag', 'zia', '2016-12-19', 10, '2016-12-14', NULL, 65, 0, 'Nothing', 'Nothing'),
(17, 'priyadip', 'zia', '2016-12-19', 10, '2016-12-14', NULL, 10, 10, 'Nothing', 'Nothing'),
(18, 'shohag', 'zia', '2016-12-29', 11, '2016-12-13', '2016-12-14', 0, 0, 'Nothing', 'Nothing'),
(19, 'shohag', 'zia', '2016-12-19', 14, '2016-12-15', NULL, 20, 0, 'Nothing', 'Nothing'),
(20, 'priyadip', 'zia', '2016-12-19', 14, '2016-12-22', NULL, 20, 0, 'Nothing', 'Nothing'),
(21, 'shohag', 'shahjahan', '2016-12-26', 16, '2016-12-13', NULL, 12, 12, 'Nothing', 'Nothing'),
(22, 'shohag', 'zia', '2016-12-22', 5, NULL, NULL, 20, 0, 'Nothing', 'Nothing'),
(23, 'priyadip', 'zia', '2016-12-18', 11, '2016-12-14', NULL, 10, 0, 'Nothing', 'Nothing'),
(24, 'priyadip', 'zia', '2016-12-18', 9, '2016-12-18', NULL, 10, 2, 'Nothing', 'Nothing'),
(25, 'shohag', 'zia', '2016-12-18', 17, NULL, NULL, 10, 0, 'Nothing', 'Nothing'),
(26, 'priyadip', 'zia', '2016-12-19', 21, '2016-12-22', NULL, 20, 12, 'Nothing', 'Nothing'),
(27, 'priyadip', 'zia', '2016-12-22', 20, NULL, NULL, 10, 5, 'Nothing', 'Nothing'),
(28, 'priyadip', 'zia', '2016-12-31', 15, NULL, NULL, 15, 0, 'Nothing', 'Nothing'),
(29, 'priyadip', 'zia', '2016-12-31', 22, NULL, NULL, 20, 0, 'Nothing', 'Nothing'),
(30, 'shohag', 'zia', '2017-01-12', 26, '2017-01-08', NULL, 23, 0, 'Nothing', 'Nothing'),
(31, 'ahad', 'zia', '2017-01-25', 27, '2017-01-08', '2017-01-08', 17, 17, 'Nothing', 'Nothing'),
(32, 'rajiur', 'zia', '2017-01-18', 27, '2017-01-08', '2017-01-08', 3, 3, 'Nothing', 'Nothing'),
(33, 'priyadip', 'zia', '2017-01-16', 28, '2017-01-08', NULL, 20, 0, 'Nothing', 'Nothing'),
(34, 'selim', 'zia', '2017-01-13', 29, NULL, NULL, 12, 0, 'Nothing', 'Nothing'),
(35, 'priyadip', 'zia', '2017-01-17', 29, '2017-01-08', '2017-01-16', 2, 2, 'Nothing', 'finished bruh!'),
(36, 'kaiser', 'shahjahan', '2017-01-18', 26, '2017-01-08', '2017-01-08', 5, 5, 'Nothing', 'Nothing'),
(37, 'ahad', 'shahjahan', '2017-01-12', 30, '2017-01-08', '2017-01-16', 2, 2, 'Nothing', 'done bruh'),
(38, 'emon', 'zia', '2017-01-19', 31, '2017-01-16', '2017-01-16', 2, 2, 'Nothing', 'jhggggggd'),
(39, 'ahad', 'zia', '2017-01-10', 33, '2017-01-08', NULL, 20, 8, 'Nothing', 'Nothing'),
(40, 'ahad', 'zia', '2017-01-20', 34, '2017-01-11', NULL, 10, 10, 'Nothing', 'Nothing'),
(41, 'ahad', 'zia', '2017-01-26', 32, '2017-01-17', NULL, 5, 5, '', 'Nothing'),
(42, 'ahad', 'zia', '2017-01-19', 28, '2017-01-17', NULL, 12, 5, '', 'Nothing'),
(43, 'ahad', 'zia', '2017-01-20', 31, NULL, NULL, 2, 0, '', 'Nothing'),
(44, 'rajiur', 'zia', '2017-01-18', 26, NULL, NULL, 2, 0, '', 'Nothing'),
(45, 'emon', 'zia', '2017-01-26', 26, '2017-01-16', '2017-01-16', 2, 2, 'sdfsdf', ''),
(46, 'ahad', 'zia', '2017-02-14', 29, '2017-01-17', NULL, 5, 2, 'do it on valnetine', 'Nothing');

-- --------------------------------------------------------

--
-- Table structure for table `task_category`
--

CREATE TABLE `task_category` (
  `TASK_CATEGORY_TITLE` varchar(100) NOT NULL,
  `TASK_CATEGORY_DEPARTMENT` varchar(100) NOT NULL,
  `TASK_CATEGORY_ID` int(11) NOT NULL,
  `UNIT_TASK_TIME` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_category`
--

INSERT INTO `task_category` (`TASK_CATEGORY_TITLE`, `TASK_CATEGORY_DEPARTMENT`, `TASK_CATEGORY_ID`, `UNIT_TASK_TIME`) VALUES
('EDB Tuning', 'COPT', 11, 1),
('STP', 'COPT', 12, 0.16),
(' Backup', 'COPT', 13, 16),
(' Re-Homing/Iub port shifting/Lac Optimization', 'COPT', 14, 16),
(' Channel Tuning & RP Parameter Tunning (Neighbors and Parameters)', 'COPT', 15, 16),
(' GPTTS Support & MLPM', 'COPT', 16, 6),
(' Resources pool optimization', 'COPT', 17, 0.33),
('FBB', 'CTS', 18, 0.44),
('EMS ', 'CTS', 19, 0.7),
('WB(TDM)', 'CTS', 20, 2),
('Traffic shifting', 'CTS', 21, 1.5),
('LOS Break', 'CTS', 22, 1.5),
('MGW Int./Deletion', 'CTS', 23, 4),
('TMGW Modernization(135 STM)', 'CTS', 24, 6.5),
('BSC Add/del', 'CTS', 25, 6),
('IPBH for BTS', 'CTS', 26, 0.16),
('IPBH for Traffic shifting', 'CTS', 27, 0.32),
('FBB MW configuration', 'CTS', 28, 0.44),
('TMGW deletion', 'CTS', 29, 4),
('ICX Int./Opt.', 'CTS', 30, 4),
('hiT Optimization', 'CTS', 31, 4),
('ET Int./Off loading', 'CTS', 32, 1),
('Switch Configuration', 'CTS', 33, 2),
('TDM Add/Del', 'CTS', 34, 2),
('New BTS (2g)', 'INT', 35, 2.5),
('IBS', 'INT', 36, 2.5),
('Relocation / Reposition (2G + 3G)', 'INT', 37, 3.5),
('New 3G ', 'INT', 38, 1.5),
('Small Cell(FEMTO, Pico,ATOM) Integration', 'INT', 39, 2),
('Hotline support', 'INT', 40, 9),
('Cell addition (2G)', 'OPT', 41, 1),
('TRX addition/ Deletion', 'OPT', 42, 0.06),
('WBBP card integration', 'OPT', 43, 0.5),
('2T4R Deployment', 'OPT', 44, 1),
('3G Sectorization', 'OPT', 45, 2),
('Abis BW for 2G & iuB BW ', 'OPT', 46, 0.08),
('MRFU/MRRU Addition', 'OPT', 47, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`DEPARTMENT_NAME`),
  ADD UNIQUE KEY `DEPARTMENT_NAME` (`DEPARTMENT_NAME`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EMPLOYEE_ID`),
  ADD UNIQUE KEY `EMPLOYEE_NAME` (`EMPLOYEE_NAME`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`TASK_ID`),
  ADD UNIQUE KEY `TASK_ID` (`TASK_ID`);

--
-- Indexes for table `task_assignment`
--
ALTER TABLE `task_assignment`
  ADD PRIMARY KEY (`TASK_ASSIGNMENT_ID`);

--
-- Indexes for table `task_category`
--
ALTER TABLE `task_category`
  ADD PRIMARY KEY (`TASK_CATEGORY_ID`),
  ADD UNIQUE KEY `TASK_CATEGORY_TITLE` (`TASK_CATEGORY_TITLE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EMPLOYEE_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `TASK_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `task_assignment`
--
ALTER TABLE `task_assignment`
  MODIFY `TASK_ASSIGNMENT_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `task_category`
--
ALTER TABLE `task_category`
  MODIFY `TASK_CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
