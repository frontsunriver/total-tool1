-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2019 at 07:49 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mainbible`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `assetsid` int(100) NOT NULL,
  `assetsdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assetsitem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assetsamount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assetsverifiedby` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assetsnote` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assetsmonth` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assetsyear` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`assetsid`, `assetsdate`, `assetsitem`, `assetsamount`, `assetsverifiedby`, `assetsnote`, `assetsmonth`, `assetsyear`, `cdate`) VALUES
(3, '09/02/2017', 'Fans (100 Peices)', '5000', 'Pastor', '', 'February', '2017', ''),
(4, '18/02/2017', 'Projector', '30000', 'Pa', '', 'February', '2017', ''),
(5, '14/02/2017', 'A Computer', '200000', 'Pastor', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>', 'February', '2017', '15th September, 2017'),
(6, '29/06/2017', 'Computer', '10000', '', 'Note Something', 'June', '2017', '29 June 2017'),
(7, '29/06/2017', 'Printer', '10000', '', 'Note Something', 'June', '2017', '29 June 2017'),
(8, '29/06/2017', 'Camera', '10000', '', 'Note Something', 'June', '2017', '29 June 2017'),
(9, '29/06/2017', 'Photo Copyer', '15000', '', 'Note Something', 'June', '2017', '29 June 2017'),
(10, '29/06/2017', 'Telephone', '10000', '', 'Note Something', 'June', '2017', '29 June 2017'),
(11, '29/06/2017', 'Phone', '150', '', 'Note Something', 'June', '2017', '29 June 2017');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attenid` int(100) NOT NULL,
  `userid` int(100) NOT NULL,
  `time` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `grouptype` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attenid`, `userid`, `time`, `type`, `grouptype`, `status`, `month`, `year`) VALUES
(51, 2, '29/11/2017', 'Family Prayer Meeting', 'chorus', 'present', '11', '2017'),
(52, 3, '29/11/2017', 'Family Prayer Meeting', 'chorus', 'present', '11', '2017'),
(53, 3, '26/11/2017', 'Family Prayer Meeting', 'member', 'Present', '11', '2017'),
(54, 4, '26/11/2017', 'Family Prayer Meeting', 'member', 'Present', '11', '2017'),
(55, 5, '26/11/2017', 'Family Prayer Meeting', 'member', 'Present', '11', '2017'),
(56, 4, '26/11/2017', 'Family Prayer Meeting', 'committee', 'Present', '11', '2017'),
(57, 5, '26/11/2017', 'Family Prayer Meeting', 'committee', 'Present', '11', '2017'),
(58, 7, '26/11/2017', 'Family Prayer Meeting', 'committee', 'Present', '11', '2017'),
(59, 8, '26/11/2017', 'Family Prayer Meeting', 'committee', 'Present', '11', '2017'),
(60, 9, '26/11/2017', 'Family Prayer Meeting', 'committee', 'Present', '11', '2017'),
(61, 5, '26/11/2017', 'Family Prayer Meeting', 'pastor', 'Present', '11', '2017'),
(62, 2, '26/11/2017', 'Family Prayer Meeting', 'chorus', 'Present', '11', '2017'),
(63, 3, '26/11/2017', 'Family Prayer Meeting', 'chorus', 'Present', '11', '2017'),
(64, 2, '26/11/2017', 'Family Prayer Meeting', 'clan', 'Present', '11', '2017'),
(65, 3, '26/11/2017', 'Family Prayer Meeting', 'clan', 'Present', '11', '2017'),
(66, 3, '10-12-2017', 'Family Prayer Meeting', 'member', 'Absent', '12', '2017'),
(67, 5, '10-12-2017', 'Family Prayer Meeting', 'member', 'Present', '12', '2017'),
(68, 4, '20-02-2018', 'Family Prayer Meeting', 'committee', 'Present', '02', '2018'),
(69, 5, '20-02-2018', 'Family Prayer Meeting', 'committee', 'Present', '02', '2018'),
(70, 7, '20-02-2018', 'Family Prayer Meeting', 'committee', 'Present', '02', '2018'),
(71, 8, '20-02-2018', 'Family Prayer Meeting', 'staff', 'Present', '02', '2018'),
(72, 7, '20-02-2018', 'Family Prayer Meeting', 'staff', 'Absent', '02', '2018'),
(73, 6, '20-02-2018', 'Family Prayer Meeting', 'staff', 'Absent', '02', '2018'),
(74, 1, '20-02-2018', 'Family Prayer Meeting', 'staff', 'Absent', '02', '2018'),
(75, 9, '20-02-2018', 'Family Prayer Meeting', 'staff', 'Present', '02', '2018'),
(76, 3, '12-02-2018', 'Family Prayer Meeting', 'member', 'Present', '02', '2018'),
(77, 4, '12-02-2018', 'Family Prayer Meeting', 'member', 'Present', '02', '2018'),
(78, 8, '12-02-2018', 'Family Prayer Meeting', 'member', 'Present', '02', '2018'),
(79, 3, '15-02-2018', 'Christmas', 'member', 'Present', '02', '2018'),
(80, 5, '15-02-2018', 'Christmas', 'member', 'Present', '02', '2018'),
(81, 8, '15-02-2018', 'Christmas', 'member', 'Present', '02', '2018'),
(82, 5, '18-04-2018', 'Family Prayer Meeting', 'committee', 'Present', '04', '2018'),
(83, 9, '18-04-2018', 'Family Prayer Meeting', 'committee', 'Present', '04', '2018'),
(84, 4, '01-07-2018', 'Family Prayer Meeting', 'committee', 'Present', '07', '2018'),
(85, 7, '01-07-2018', 'Family Prayer Meeting', 'committee', 'Present', '07', '2018'),
(86, 11, '01-07-2018', 'Family Prayer Meeting', 'committee', 'Present', '07', '2018'),
(87, 7, '11-12-2018', 'Family Prayer Meeting', 'committee', 'Present', '12', '2018'),
(88, 8, '11-12-2018', 'Family Prayer Meeting', 'committee', 'Present', '12', '2018'),
(89, 9, '11-12-2018', 'Family Prayer Meeting', 'committee', 'Present', '12', '2018');

-- --------------------------------------------------------

--
-- Table structure for table `attendancetype`
--

CREATE TABLE `attendancetype` (
  `attendancetypeid` int(100) NOT NULL,
  `attendancetype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendancetype`
--

INSERT INTO `attendancetype` (`attendancetypeid`, `attendancetype`) VALUES
(1, 'Family Prayer Meeting'),
(2, 'Christmas'),
(3, 'New Year Prayer'),
(4, 'John Marriage Ceremony'),
(5, 'Other Events'),
(6, 'Sunday Prayer');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `postID` int(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `cdate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`postID`, `image`, `title`, `content`, `author`, `cdate`) VALUES
(11, '20180422_075954_688638.jpeg', 'Decorate Your House at Christmas Time', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\"><br></span><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\"><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-weight: 700; margin: 0px; padding: 0px;\">Lorem Ipsum</span><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></span></p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\"><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\"><br></span></span><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\"><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\"><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-weight: 700; margin: 0px; padding: 0px;\">Lorem Ipsum</span><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></span></span></p>', '152', '22 April 2018'),
(12, '20180422_080413_542972.jpg', 'What is Holy Week?', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '152', '22 April 2018'),
(13, '20180422_080520_112837.jpg', 'Jesus is The Way, The Truth, and The Life', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '152', '22 April 2018'),
(14, '20180422_081017_374088.jpeg', 'The Power Of Prayer', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '152', '22 April 2018'),
(15, '20180422_081248_855327.jpeg', 'Read The Bible Everyday', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '152', '22 April 2018'),
(16, '20180422_081519_108135.jpg', 'Sunday Prayer Meeting', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '152', '22 April 2018');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(100) NOT NULL,
  `cartProductID` int(100) NOT NULL,
  `cartUserID` int(100) NOT NULL,
  `price` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `cartcdate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `cartProductID`, `cartUserID`, `price`, `quantity`, `status`, `cartcdate`) VALUES
(1, 13, 152, '2', 2, 'Cancel', '19 April 2018'),
(2, 13, 152, '2', 2, 'Cancel', '19 April 2018'),
(3, 13, 152, '2', 2, 'Not Bought', '19 April 2018'),
(4, 11, 152, '2', 3, 'Not Bought', '19 April 2018'),
(5, 10, 152, '2', 2, 'Bought', '20 April 2018'),
(6, 7, 152, '5', 2, 'Cancel', '20 April 2018'),
(7, 13, 152, '2', 2, 'Cancel', '20 April 2018'),
(8, 13, 152, '2', 1, 'Bought', '20 April 2018'),
(9, 13, 152, '2', 2, 'Bought', '20 April 2018'),
(10, 13, 152, '2', 3, 'Bought', '20 April 2018'),
(11, 13, 153, '2', 1, 'Not Bought', '22 April 2018'),
(12, 10, 153, '2', 0, 'Cancel', '22 April 2018'),
(13, 13, 153, '2', 1, 'Not Bought', '22 April 2018'),
(14, 11, 152, '3', 1, 'Not Bought', '24 April 2018'),
(15, 12, 152, '2', 1, 'Not Bought', '24 April 2018'),
(16, 7, 152, '5', 3, 'Not Bought', '25 April 2018'),
(17, 13, 152, '2', 3, 'Not Bought', '25 April 2018'),
(18, 7, 152, '5', 1, 'Not Bought', '28 April 2018'),
(19, 1, 152, '10', 1, 'Bought', '13 July 2018'),
(20, 7, 152, '5', 1, 'Bought', '13 July 2018'),
(21, 7, 152, '5', 2, 'Bought', '14 July 2018'),
(22, 8, 152, '10', 1, 'Bought', '14 July 2018'),
(23, 12, 152, '2', 1, 'Bought', '14 July 2018'),
(24, 13, 152, '2', 1, 'Bought', '14 July 2018'),
(25, 13, 152, '2', 1, 'Cancel', '29 July 2018');

-- --------------------------------------------------------

--
-- Table structure for table `chorus`
--

CREATE TABLE `chorus` (
  `chorusid` int(100) NOT NULL,
  `profileimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bpdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blood` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pinterest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marriagedate` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `socialstatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `family` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `job` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `chorus`
--

INSERT INTO `chorus` (`chorusid`, `profileimage`, `fname`, `lname`, `gender`, `phone`, `email`, `bpdate`, `dob`, `blood`, `position`, `nationality`, `address`, `city`, `country`, `postal`, `cdate`, `facebook`, `twitter`, `googleplus`, `linkedin`, `youtube`, `pinterest`, `instagram`, `whatsapp`, `marriagedate`, `socialstatus`, `family`, `department`, `job`) VALUES
(2, '20171017_092054_861697.jpg', 'Adam', 'Simon', 'Male', '908-773-7785', 'JohnMDejesus@dayrep.com', '28/02/2017', '21/02/2017', 'B+', 'Member', 'USA', '', '', '', '', '17 October 2017', 'https://www.facebook.com/profile', '', 'https://plus.google.com/', 'https://www.linkedin.com/', 'https://www.youtube.com/', 'https://www.pinterest.com/', 'https://www.instagram.com/', '+00000000000', '', '', '', '', ''),
(3, '20171017_092015_407291.jpg', 'Philip', 'Simon', 'Male', '908-773-7785', 'JohnMDejesus@dayrep.com', '28/02/2017', '21/02/2017', 'B+', 'Member', 'USA', '', '', '', '', '17 October 2017', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `clan`
--

CREATE TABLE `clan` (
  `clanid` int(100) NOT NULL,
  `profileimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bpdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blood` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pinterest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marriagedate` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `socialstatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `family` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `job` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clan`
--

INSERT INTO `clan` (`clanid`, `profileimage`, `fname`, `lname`, `gender`, `phone`, `email`, `position`, `bpdate`, `dob`, `blood`, `nationality`, `address`, `city`, `country`, `postal`, `cdate`, `facebook`, `twitter`, `googleplus`, `linkedin`, `youtube`, `pinterest`, `instagram`, `whatsapp`, `marriagedate`, `socialstatus`, `family`, `department`, `job`) VALUES
(2, '20171017_091806_655314.jpg', 'Arnold', 'Simon', 'Male', '908-773-7785', 'JohnMDejesus@dayrep.com', 'Member', '17/10/1937', '17/10/1937', 'B+', 'USA', '', '', '', '', '17 October 2017', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, '20171017_091750_533684.jpg', 'Philip', 'Simon', 'Male', '908-773-7785', 'JohnMDejesus@dayrep.com', 'Member', '22/02/2017', '09/02/2017', 'B+', 'USA', '', '', '', '', '17 October 2017', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `committee`
--

CREATE TABLE `committee` (
  `committeeid` int(100) NOT NULL,
  `profileimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bpdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blood` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `speech` text COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pinterest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marriagedate` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `socialstatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `family` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `job` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `committee`
--

INSERT INTO `committee` (`committeeid`, `profileimage`, `fname`, `lname`, `phone`, `email`, `position`, `bpdate`, `blood`, `dob`, `nationality`, `speech`, `address`, `city`, `country`, `postal`, `cdate`, `facebook`, `twitter`, `googleplus`, `linkedin`, `youtube`, `pinterest`, `instagram`, `whatsapp`, `marriagedate`, `socialstatus`, `family`, `department`, `job`) VALUES
(7, '20180423_060237_657732.jpg', 'David', 'Hal', '01726562944', 'david@cms.com', 'Minister', '14/02/2017', 'B+', '21/02/2017', 'Bengali', '<p><span style=\"text-align: justify;\">Lorem Ipsum</span><span style=\"text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '', 'Savar', 'Bangladesh', '1340', '23 April 2018', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, '20180423_060157_314181.jpg', 'John', 'Hal', '01726562944', 'john@cms.com', 'Minister', '14/02/2017', 'B+', '21/02/2017', 'Bengali', '<p><span style=\"text-align: justify;\">Lorem Ipsum</span><span style=\"text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '', 'Savar', 'Bangladesh', '1340', '23 April 2018', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, '20171209_042354_554338.jpg', 'Andrew', 'Ben', '1-593-758-5039', 'xnader@xn--qei.usa.cc', 'Minister', '13-02-1981', 'B+', '21-02-1971', 'USA', '<p><span style=\"color: rgb(153, 153, 153); text-align: center;\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</span></p>', '', '', '', '', '9 December 2017', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentid` int(100) NOT NULL,
  `departmentname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `departmentleader` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `departmentcontact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `departmentarea` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentid`, `departmentname`, `departmentleader`, `departmentcontact`, `departmentarea`, `description`, `address`, `city`, `country`, `postal`, `cdate`) VALUES
(1, 'Department 2', 'Simon', '', 'North Side', '', '', '', '', '', '16 July 2018'),
(2, 'Department 01', 'Simon', '', 'South Side', '', '', '', '', '', '16 July 2018');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `donationid` int(100) NOT NULL,
  `donationdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `donationmonth` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `donationyear` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `donationamount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `donationsource` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `donationby` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `donationinfo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `donationreceivedby` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `donationnote` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donationid`, `donationdate`, `donationmonth`, `donationyear`, `donationamount`, `donationsource`, `donationby`, `donationinfo`, `donationreceivedby`, `donationnote`, `cdate`) VALUES
(16, '19/04/2018', 'April', '2018', '10.00', 'Donation From (John Doe) () (1726562944)', 'Paypal', 'PAY-10K13345G25428219LLMPB3A', ' ', ' ', '19 April 2018'),
(17, '13/07/2018', 'July', '2018', '50.00', 'Donation From (John Doe) (admin@site.com) (1726562944)', 'Stripe', 'txn_1CnRhgA4JNh6ZWXn3DpHla0r (4242)', ' ', 'Donation Currency USD', '13 July 2018'),
(18, '13/07/2018', 'July', '2018', '50.00', 'Donation From (sdfsdf) (admin@site.com) (1726562944)', 'Stripe', 'txn_1CnRwPA4JNh6ZWXnZPbaYAg7 (4242)', ' ', 'Donation Currency USD', '13 July 2018'),
(19, '13/07/2018', 'July', '2018', '50.00', 'Donation From (John Doe) (admin@site.com) (1726562944)', 'Stripe', 'txn_1CnSd5A4JNh6ZWXnoY48oXxD (4242)', ' ', 'Donation Currency USD', '13 July 2018'),
(20, '13/07/2018', 'July', '2018', '50.00', 'Donation From (John Doe) (admin@site.com) (1726562944)', 'Stripe', 'txn_1CnSd7A4JNh6ZWXn7OO4DjEW (4242)', ' ', 'Donation Currency USD', '13 July 2018'),
(21, '13/07/2018', 'July', '2018', '50.00', 'Donation From (sdfsd) (admin@site.com) (1726562944)', 'Stripe', 'txn_1CnSnBA4JNh6ZWXnW2HojGRm (4242)', ' ', 'Donation Currency USD', '13 July 2018'),
(22, '13/07/2018', 'July', '2018', '50.00', 'Donation From (sdfsd) (admin@site.com) (1726562944)', 'Stripe', 'txn_1CnSnEA4JNh6ZWXnL3aHco6b (4242)', ' ', 'Donation Currency USD', '13 July 2018'),
(23, '14/07/2018', 'July', '2018', '5.00', 'Donation From (John Doe) (admin@site.com) (1726562944)', 'Paypal', 'PAY-04D55408SG7781000LNEZ5AA', ' ', 'Donation Currecny USD', '14 July 2018'),
(24, '14/07/2018', 'July', '2018', '5.00', 'Donation From (John Doe) (admin@site.com) (1726562944)', 'Stripe', 'txn_1CnhhIA4JNh6ZWXnJZr3gExD (4242)', ' ', 'Donation Currency USD', '14 July 2018');

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `emailID` int(255) NOT NULL,
  `emailTo` varchar(255) NOT NULL,
  `emailSubject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `time` varchar(255) NOT NULL,
  `network` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `eventid` int(100) NOT NULL,
  `eventimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `eventtitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `eventdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `eventtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `eventlocation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `eventdescription` text COLLATE utf8_unicode_ci NOT NULL,
  `eventstartdate` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eventenddate` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventid`, `eventimage`, `eventtitle`, `eventdate`, `eventtime`, `eventlocation`, `eventdescription`, `eventstartdate`, `eventenddate`, `cdate`) VALUES
(3, '20180212_070413_258458.jpg', 'Family Prayer', '13/05/2017', '15:00', 'Purnima\'s House', '<p><strong>Lorem Ipsum</strong><span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', NULL, '', '12 February 2018'),
(4, '20180212_070428_587922.jpg', 'Happy New Year', '30/05/2017', '12:00', 'Dhaka AG Church', '<p><strong>Lorem Ipsum</strong><span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', NULL, '', '12 February 2018'),
(5, '20171202_070840_549117.jpg', 'Merry Christmas 2019', '25-12-2019', '12:00 PM', 'Temple, London EC4Y 7BB, UK', '<p>Christmas is an annual festival commemorating the birth of Jesus Christ, observed most commonly on December 25 as a religious and cultural celebration among billions of people around the world.</p><p>Christmas is an annual festival commemorating the birth of Jesus Christ, observed most commonly on December 25 as a religious and cultural celebration among billions of people around the world.<br></p><p>Christmas is an annual festival commemorating the birth of Jesus Christ, observed most commonly on December 25 as a religious and cultural celebration among billions of people around the world.Christmas is an annual festival commemorating the birth of Jesus Christ, observed most commonly on December 25 as a religious and cultural celebration among billions of people around the world.Christmas is an annual festival commemorating the birth of Jesus Christ, observed most commonly on December 25 as a religious and cultural celebration among billions of people around the world.Christmas is an annual festival commemorating the birth of Jesus Christ, observed most commonly on December 25 as a religious and cultural celebration among billions of people around the world.</p>', NULL, '', '18 April 2019');

-- --------------------------------------------------------

--
-- Table structure for table `eventregistration`
--

CREATE TABLE `eventregistration` (
  `registrationID` int(11) NOT NULL,
  `fname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `profession` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `userID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `hotel` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `room` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seat` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bus` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `badge` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmation` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `participant` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comingchildern` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `manychildren` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `listchildern` text COLLATE utf8_unicode_ci NOT NULL,
  `babysitting` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `transportation` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `seaport` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `airport` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `landcrossing` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pickentey` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `arrivaldate` datetime NOT NULL,
  `departuredate` datetime NOT NULL,
  `koume` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `koumedetails` text COLLATE utf8_unicode_ci NOT NULL,
  `bertoua` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `provided` text COLLATE utf8_unicode_ci NOT NULL,
  `accommodation` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `perfectaccommodation` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `special` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `specifyrestriction` text COLLATE utf8_unicode_ci NOT NULL,
  `medicalreport` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `specialmedical` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `medicalcondition` text COLLATE utf8_unicode_ci NOT NULL,
  `anyconvention` text COLLATE utf8_unicode_ci NOT NULL,
  `fristname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `transportationport` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventregistration`
--

INSERT INTO `eventregistration` (`registrationID`, `fname`, `lname`, `email`, `phone`, `profession`, `birthdate`, `gender`, `nationality`, `address`, `language`, `city`, `country`, `postal`, `userID`, `eventID`, `hotel`, `room`, `seat`, `bus`, `badge`, `confirmation`, `participant`, `cdate`, `comingchildern`, `manychildren`, `listchildern`, `babysitting`, `transportation`, `seaport`, `airport`, `landcrossing`, `pickentey`, `arrivaldate`, `departuredate`, `koume`, `koumedetails`, `bertoua`, `provided`, `accommodation`, `perfectaccommodation`, `special`, `specifyrestriction`, `medicalreport`, `specialmedical`, `medicalcondition`, `anyconvention`, `fristname`, `surname`, `transportationport`) VALUES
(9, 'Tarun', 'Modhu', 'admin@site.com', '01869611132', '', '2018-04-24 18:00:00', 'Male', 'Bangladesh', 'Savar', '', 'Dhaka', 'Bangladesh', '110', 0, 3, 'Radisson ', '620', '100', '1223', '100', 'Yes', 'Others', '27 December 2018', '', '', '', '', '', '', NULL, NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(10, 'Arun', 'Modhu', 'admin@site.com', '01869611132', '', '2018-10-19 18:00:00', 'Male', 'Bangladesh', 'Dhaka', '', 'Dhaka', 'Bangladesh', '110', 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, 'Qulified', '27 December 2018', '', '', '', '', '', '', NULL, NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(11, 'Barun', 'Modhu', 'admin@site.com', '01869611132', '', '2018-05-09 18:00:00', 'Male', 'Bangladeshi', 'Dhaka', '', 'Daka', 'Bangladesh', '112', 0, 5, 'Radisson ', '620', '100', '1223', '100', 'Yes', 'Guests', '27 December 2018', '', '', '', '', '', '', NULL, NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, 'Tarun 22', 'Modhu', 'admin@site.com', '1726562944', '', '0000-00-00 00:00:00', 'Male', 'United Kingdom', 'London', '', 'London', 'Bangladesh', '1000', 0, 3, '', '', '', '', '', '', 'Qulifide', '31 December 2018', '', '', '', '', '', '', NULL, NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, '', '', 'admina@site.com', '00', 'holjhlj', '2019-03-06 19:34:02', 'Male', 'Aruba', '', 'French', 'ljlkjl', 'Australia', '', 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, '', '6 March 2019', 'Yes', '2', 'lkjlkjl', 'Yes', 'By Air', '', 'Airport-2', '', 'Yes', '2019-03-07 00:00:00', '2019-03-07 00:00:00', 'Yes', 'jhgkjhgjg', 'Yes', 'hjgjhgj', '', '', 'Yes', 'hjgjhgjhgjh', 'images (4).jpg', 'Yes', 'jhgjhgjhgjh', '', 'fgdfg', 'df;lgd;gl', ''),
(14, 'nnnnnnnnnnnnnnnnn', '', 'admin2@site.com', '0012', 'cvgfhbn', '2019-03-07 12:07:16', 'Male', 'Bangladesh', '', 'English', 'Dhaka', 'Åland Islands', '', 0, 3, 'ggggggggggggggggg', 'gggggggggggggggggggg', 'gggggggggggggg', 'gggggggggggggg', 'gggggggggggggggg', 'Yes', '', '7 March 2019', 'Yes', '1', 'gggggggggggggggggggggggggggg', 'Yes', 'By Air', '', 'Airport-3', '', 'Yes', '2019-01-06 00:00:00', '2019-01-02 00:00:00', 'Yes', 'ggggggggggggggggggggggggggggggggggggggggggg', 'Yes', 'ggggggggggggggggggggggggggggggggggggggg', '', '', 'Yes', 'gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg', '20190307_010716_344991.jpg', 'Yes', 'ggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg', '', 'fvcbnnnnnn', 'nnnnnnnn', ''),
(15, 'nmmmmm h,.bfg', '', 'admin22@site.com', '1245533', 'kmgghfnfhnmm', '2019-03-07 12:47:16', 'Male', 'Andorra', '', 'English', 'njhhhhhhhhhhhhhhhhhhhhn', 'Algeria', '', 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, '', '7 March 2019', 'Yes', '2', 'njmmmmmkkkkkkkkkkkkkkkkkklgh', 'Yes', 'By Air', '', 'Airport-1', '', 'Yes', '2019-01-02 00:00:00', '2019-01-01 00:00:00', 'Yes', ' bjfgjkykdxsghnjhui', 'Yes', 'hfffffffffffffffffffffffffffffffdjk', '', '', 'Yes', 'bbbbbgdfklxhjc.dhmnl,jg', '', 'Yes', 'dygygethiiiiiiiiiiiiiiiiiiiiiiiiro98uuuuujhit', '', 'ghdjksljl;djlh', 'fjgklll;lhfdklhm', ''),
(16, 'dfgdfg', '', 'admidfgdn@site.com', '00', 'fhfghfh', '2019-03-07 12:55:01', 'Male', 'Algeria', '', 'English', 'fhfh', 'Åland Islands', '', 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, '', '7 March 2019', 'Yes', '2', 'fhfhfh', 'Yes', 'By Air', '', 'Airport-2', '', 'Yes', '2019-03-07 00:00:00', '2019-03-08 00:00:00', 'Yes', 'fhfghfgh', 'Yes', 'fghfgh', '', '', 'Yes', 'fghfghfgh', '', 'Yes', 'fghfghfgh', '', 'fhfdghdg', 'dfgdfg', ''),
(17, 'Zohara Dncc', '', 'admin2@site.com', '12222', 'bjfffffffffffffffffffffdk', '2019-03-07 13:05:18', 'Male', 'Bangladesh', '', 'French', 'Dhaka', 'Bangladesh', '', 0, 3, 'hhhjdkg', 'fgghhjjj', 'jfhgfghfh', 'gghhhjghjjjmj', 'nmjdgkdk', 'Yes', '', '7 March 2019', 'Yes', '1', 'ghdkjllkhgjkkklllll', 'Yes', 'By Air', '', 'Airport-1', '', 'Yes', '2019-01-01 00:00:00', '2019-02-01 00:00:00', 'Yes', 'bhvjjjkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgbkgb db ggbn bnbn', 'Yes', 'jhhhhhhhhhhhhhhhhhhhhkl', '', '', 'Yes', 'dtryththththththththijiohhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhnmnm', '20190307_020518_766933.jpg', 'Yes', 'hffffffffffjgmbiofcpk,mhnmhhhhhj', '', 'hhhhhhhhhhjk', 'hhhhjkdghkd', ''),
(18, 'ppppppppp', '', 'admin222@site.com', '1254555', '5hhfvdvjhvb', '2019-03-07 13:13:17', 'Male', 'Bangladesh', '', 'English', 'Dhaka', 'Bangladesh', '', 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, '', '7 March 2019', 'Yes', '1', 'ppppppppppppp', 'Yes', 'By Air', '', 'Airport-1', '', 'Yes', '2019-11-05 00:00:00', '2019-02-03 00:00:00', 'Yes', 'gffffffffffffffffffjh', 'Yes', 'jklhffffffffffffffffffj', '', '', 'Yes', 'fjkkkkkkkkkkkkkkkkkh', '20190307_021317_232937.jpg', 'Yes', 'jnkkkkkkkkkkkkkkkkkkkfh', '', 'pppppppp', 'pppppppppp', ''),
(19, 'ppppppppp', '', 'admin222@site.com', '1254555', '5hhfvdvjhvb', '2019-03-07 13:17:21', 'Male', 'Bangladesh', '', 'English', 'Dhaka', 'Bangladesh', '', 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, '', '7 March 2019', 'Yes', '1', 'ppppppppppppp', 'Yes', 'By Air', '', 'Airport-1', '', 'Yes', '2019-11-05 00:00:00', '2019-02-03 00:00:00', 'Yes', 'gffffffffffffffffffjh', 'Yes', 'jklhffffffffffffffffffj', '', '', 'Yes', 'fjkkkkkkkkkkkkkkkkkh', '20190307_021721_154751.jpg', 'Yes', 'jnkkkkkkkkkkkkkkkkkkkfh', '', 'pppppppp', 'pppppppppp', ''),
(20, 'ppppppppp', '', 'admin222@site.com', '1254555', '5hhfvdvjhvb', '2019-03-07 14:32:52', 'Male', 'Albania', '', 'English', 'Dhaka', 'Anguilla', '', 0, 3, 'dfgdghj', 'jjytfgdf', 'fdhgfhgj', 'ghjjsdfgg', 'ghtrfhjgkd', 'Yes', 'Qulified', '7 March 2019', '', '1', 'ppppppppppppp', 'Yes', 'By Air', '', 'Airport-1', '', 'Yes', '2019-02-02 00:00:00', '2019-02-05 00:00:00', 'Yes', 'gffffffffffffffffffjhgh', 'Yes', 'jklhffffffffffffffffffjgfh', '', '', 'Yes', 'fjkkkkkkkkkkkkkkkkkh', '20190307_021817_331764.jpg', 'Yes', 'jnkkkkkkkkkkkkkkkkkkkfhfghhhhhhh', '', 'pppppppp', 'pppppppppp', ''),
(21, 'Mukta vai gulshan .....2', '', 'admin@example.com', '124556', 'Dofhdfjjkgk', '2019-04-11 17:12:10', 'Female', 'Belgium', '', 'English', 'nnnnnnnvv', 'Vanuatu', '', 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, '', '11 April 2019', 'Yes', '1', 'kjffffffghdryholjdi8gthhgdhuifkmkhkmjnfhjnjmhkmjm', 'Yes', 'By Air', '', 'Airport-1', '', 'Yes', '2019-11-04 00:00:00', '2019-11-04 00:00:00', 'Yes', 'ghvdjvfngvjdjkklmsxnjnfgdmdnndfmh gnjdklngikdgjkdkklnjmdkhkdddddddddddddddddddddddddddddg', 'Yes', 'fjhksdjflhfhkmflllllllllgpoklkhbjmdf,.bhmdfnkl', '', '', 'Yes', 'fvc bbbbvm,,,,,,,,,,,,,,,,,,,,bncdfjkmngklfnkldngn', '20190411_071210_698215.jpg', 'Yes', 'jdlggggggggggggggmkbn mghk,.mnlkgvjkfkcjbmk,,,,,,sglkfbsjk', '', 'purnima', 'roybbnn', ''),
(22, 'Nahian', '', 'admin@example.com', '88656585', 'ddddddddfgd', '2019-04-11 17:21:28', 'Female', 'Bahamas', '', 'English', 'gggggggggggggggg', 'Barbados', '', 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, '', '11 April 2019', 'Yes', '1', 'gggggggggggggggggjio', 'Yes', 'By Air', '', 'Airport-1', '', 'Yes', '2019-04-05 00:00:00', '2019-05-04 00:00:00', 'Yes', 'hfkjjjjhikfopihkfpojhoifjo', 'Yes', 'hjnfkkknholfjkhpfj0ojhndolhnm', '', '', 'Yes', 'dnmhklllllllllkg;ld,lg.m dk ;d,lhbfdgokdm', '20190411_072128_118420.jpg', 'Yes', 'dkjhllllllfkphd;ojkd mglbd,k;dmko', '', 'pppppppppp', 'pppppppppp', '');

-- --------------------------------------------------------

--
-- Table structure for table `family`
--

CREATE TABLE `family` (
  `familyid` int(100) NOT NULL,
  `familyname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `familyleader` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `memberquantity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `familycontact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `family`
--

INSERT INTO `family` (`familyid`, `familyname`, `familyleader`, `memberquantity`, `familycontact`, `address`, `city`, `country`, `postal`, `cdate`) VALUES
(2, 'Smith Family', 'Smith', '5', '', '', '', '', '', '16 July 2018'),
(3, 'Williams Family', 'William', '10', '', '', '', '', '', '16 July 2018');

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE `funds` (
  `fundsid` int(100) NOT NULL,
  `fundsdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fundsmonth` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fundsyear` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fundsamount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fundstype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `receivedby` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fundssource` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fundsnote` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fundsbalance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `funds`
--

INSERT INTO `funds` (`fundsid`, `fundsdate`, `fundsmonth`, `fundsyear`, `fundsamount`, `fundstype`, `receivedby`, `fundssource`, `fundsnote`, `fundsbalance`, `cdate`) VALUES
(80, '29/07/2018', 'July', '2018', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(81, '29/07/2018', 'July', '2018', '5000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(82, '29/07/2018', 'July', '2018', '8000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(83, '29/07/2018', 'July', '2018', '5000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(84, '29/07/2018', 'July', '2018', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(85, '29/07/2018', 'July', '2018', '2300', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(86, '29/08/2018', 'August', '2018', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(87, '29/08/2018', 'August', '2018', '5000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(88, '29/08/2018', 'August', '2018', '18000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(89, '29/08/2018', 'August', '2018', '4000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(90, '29/08/2018', 'August', '2018', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(91, '29/08/2018', 'August', '2018', '3000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(92, '29/09/2018', 'September', '2018', '9000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(93, '29/09/2018', 'September', '2018', '5000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(94, '29/09/2018', 'September', '2018', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(95, '29/09/2018', 'September', '2018', '4000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(96, '29/09/2018', 'September', '2018', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(97, '29/09/2018', 'September', '2018', '2000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(98, '29/10/2018', 'October', '2018', '9000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(99, '29/10/2018', 'October', '2018', '5000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(100, '29/10/2018', 'October', '2018', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(101, '29/10/2018', 'October', '2018', '4000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(102, '29/10/2018', 'October', '2018', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(103, '29/10/2018', 'October', '2018', '10000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(104, '29/11/2018', 'November', '2018', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(105, '29/11/2017', 'November', '2017', '5000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(106, '29/11/2017', 'November', '2017', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(107, '29/11/2017', 'November', '2017', '4000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(108, '29/11/2017', 'November', '2017', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(109, '29/11/2017', 'November', '2017', '6000', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(110, '29/12/2017', 'December', '2017', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(111, '29/12/2017', 'December', '2017', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(112, '29/12/2017', 'December', '2017', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(113, '29/01/2017', 'January', '2017', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(114, '29/01/2017', 'January', '2017', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(115, '29/01/2017', 'January', '2017', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(116, '01/03/2017', 'March', '2017', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(117, '01/03/2017', 'March', '2017', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(118, '01/03/2017', 'March', '2017', '100', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(120, '01/03/2017', 'March', '2017', '500', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(121, '29/03/2017', 'March', '2017', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(123, '29/03/2017', 'March', '2017', '100', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(124, '29/03/2017', 'March', '2017', '6500', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(125, '29/04/2017', 'April', '2017', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(126, '29/04/2017', 'April', '2017', '6000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(127, '29/04/2017', 'April', '2017', '100', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(128, '29/04/2017', 'April', '2017', '5500', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(129, '29/05/2017', 'May', '2017', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(130, '29/05/2017', 'May', '2017', '16000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(131, '29/05/2017', 'May', '2017', '100', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(132, '29/05/2017', 'May', '2017', '5500', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(133, '29/05/2017', 'May', '2017', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(134, '29/05/2017', 'May', '2017', '11000', 'Collect', 'John', 'Londan Church', '', '', '5 September 2017'),
(135, '29/05/2017', 'May', '2017', '100', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(136, '29/05/2017', 'May', '2017', '5500', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(137, '29/05/2017', 'May', '2017', '5000', 'Spend', 'John', 'Londan Church', '', '', '5 September 2017'),
(138, '29/06/2017', 'June', '2017', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(139, '29/06/2017', 'June', '2017', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(140, '29/06/2017', 'June', '2017', '100', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(141, '29/06/2017', 'June', '2017', '5500', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(142, '29/06/2017', 'June', '2017', '500', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(143, '01/03/2017', 'March', '2017', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(145, '01/03/2017', 'March', '2017', '100', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(146, '01/03/2017', 'March', '2017', '5500', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(147, '01/03/2017', 'March', '2017', '500', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(148, '01/03/2017', 'March', '2017', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(150, '01/03/2017', 'March', '2017', '100', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(151, '01/03/2017', 'March', '2017', '5500', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(152, '01/03/2017', 'March', '2017', '500', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(153, '15/02/2017', 'February', '2017', '5000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(154, '15/02/2017', 'February', '2017', '10000', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(155, '15/02/2017', 'February', '2017', '100', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(156, '15/02/2017', 'February', '2017', '5500', 'Collect', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(157, '15/02/2017', 'February', '2017', '500', 'Spend', 'John', 'Londan Church', 'Note Something', '', '5 September 2017'),
(158, '27-02-2018', 'February', '2018', '10000', 'Collect', 'sdfsdf', 'sdfsdfsdf', '', '10000', '27 February 2018'),
(159, '20 April 2018', 'April', '2018', '2.00', 'Collect', 'Pastor', 'Item Sold', 'Purchased By johnsmith', '', '20 April 2018'),
(160, '20 April 2018', 'April', '2018', '4.00', 'Collect', 'Pastor', 'Item Sold', 'Purchased By johnsmith', '', '20 April 2018'),
(161, '20 April 2018', 'April', '2018', '6.00', 'Collect', 'Pastor', 'Item Sold', 'Purchased By johnsmith', '', '20 April 2018'),
(162, '13 July 2018', 'July', '2018', '15.00', 'Collect', 'Admin', 'Item Sold', 'Purchased By johnsmith', '', '13 July 2018'),
(163, '13 July 2018', 'July', '2018', '5.00', 'Collect', 'Admin', 'Item Sold', 'Purchased By johnsmith', '', '13 July 2018'),
(164, '14 July 2018', 'July', '2018', '20.00', 'Collect', 'Admin', 'Item Sold', 'Purchased By johnsmith', '', '14 July 2018'),
(165, '14 July 2018', 'July', '2018', '12.00', 'Collect', 'Admin', 'Item Sold', 'Purchased By johnsmith', '', '14 July 2018'),
(166, '14 July 2018', 'July', '2018', '4.00', 'Collect', 'Admin', 'Item Sold', 'Purchased By johnsmith', '', '14 July 2018');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `galleryid` int(100) NOT NULL,
  `serialid` int(255) NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`galleryid`, `serialid`, `filename`, `cdate`) VALUES
(84, 0, '20180423_062129_187326.jpeg', '23 April 2018'),
(85, 1, '20180423_062129_587738.jpeg', '23 April 2018'),
(86, 2, '20180423_062129_992823.jpeg', '23 April 2018'),
(87, 3, '20180423_062129_233124.jpeg', '23 April 2018'),
(88, 4, '20180423_062129_499370.jpeg', '23 April 2018'),
(89, 5, '20180423_062129_473248.jpeg', '23 April 2018'),
(90, 6, '20180423_062130_471793.jpeg', '23 April 2018'),
(91, 7, '20180423_062130_478593.jpeg', '23 April 2018'),
(92, 9, '20180423_062130_873731.jpeg', '23 April 2018'),
(93, 8, '20180423_062131_152365.jpeg', '23 April 2018');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `memberid` int(100) NOT NULL,
  `profileimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bpdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blood` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pinterest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marriagedate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `socialstatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `family` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`memberid`, `profileimage`, `fname`, `lname`, `phone`, `email`, `position`, `bpdate`, `blood`, `dob`, `job`, `nationality`, `address`, `city`, `country`, `postal`, `cdate`, `facebook`, `twitter`, `googleplus`, `linkedin`, `youtube`, `pinterest`, `instagram`, `whatsapp`, `marriagedate`, `socialstatus`, `family`, `department`) VALUES
(3, '20171210_124644_224479.jpeg', 'Jackson', '', '908-773-7785', 'JohnMDejesus@dayrep.com', 'Member', '', '', '', '', '', '', '', '', '', '10 December 2017', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, '20171210_124923_864944.jpeg', 'Thomas', '', '908-773-7785', 'JohnMDejesus@dayrep.com', 'Member', '', '', '', '', '', '', '', '', '', '10 December 2017', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, '20180423_060337_145843.jpg', 'Philip', '', '908-773-7785', 'JohnMDejesus@dayrep.com', 'Member', '', '', '', '', '', '<p><span style=\"text-align: justify;\">Lorem Ipsum</span><span style=\"text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown p', '', '', '', '23 April 2018', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, '20171210_125049_658936.jpeg', 'Horace', '', '316-531-2034', 'HoraceCWard@teleworm.us', 'Member', '', '', '', '', '', '', '', '', '', '10 December 2017', '', '', '', '', '', '', '', '', '13-12-2017', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menuid` int(100) NOT NULL,
  `serialid` int(100) NOT NULL,
  `subserialid` int(100) NOT NULL,
  `menupageid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `menuname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `menuparentid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `menulink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menuid`, `serialid`, `subserialid`, `menupageid`, `menuname`, `menuparentid`, `menulink`, `cdate`) VALUES
(5, 1, 0, '', 'Profiles', '', '#', '18 April 2019'),
(8, 5, 4, '', 'Member', '5', 'http://localhost/mainbible/home/member', '18 April 2019'),
(10, 5, 5, '', 'Clan', '5', 'http://localhost/mainbible/home/clan', '18 April 2019'),
(11, 5, 7, '', 'Student', '5', 'http://localhost/mainbible/home/school', '18 April 2019'),
(12, 5, 6, '', 'Staff', '5', 'http://localhost/mainbible/home/staff', '18 April 2019'),
(35, 0, 0, '', 'Home', '', 'http://localhost/mainbible/', '18 April 2019'),
(36, 5, 2, 'ourpastor', 'Committee', '5', 'http://localhost/mainbible/home/committee', '18 April 2019'),
(37, 5, 3, '', 'Pastor', '5', 'http://localhost/mainbible/home/pastor', '18 April 2019'),
(38, 47, 10, '', 'Events', '47', 'http://localhost/mainbible/home/event', '18 April 2019'),
(39, 47, 11, '', 'Sermon', '47', 'http://localhost/mainbible/home/sermon', '18 April 2019'),
(40, 47, 13, '', 'Prayer', '47', 'http://localhost/mainbible/home/prayer', '18 April 2019'),
(41, 47, 9, '', 'Notice', '47', 'http://localhost/mainbible/home/notice', '18 April 2019'),
(42, 47, 14, '', 'Speech', '47', 'http://localhost/mainbible/home/speech', '18 April 2019'),
(43, 47, 12, '', 'Seminar', '47', 'http://localhost/mainbible/home/seminar', '18 April 2019'),
(45, 16, 0, '', 'Gallery', '', 'http://localhost/mainbible/home/gallery', '18 April 2019'),
(46, 17, 0, '', 'Blog', '', 'http://localhost/mainbible/home/blog', '18 April 2019'),
(47, 8, 0, '', 'Pages', '', '#', '18 April 2019'),
(48, 15, 0, '', 'Shop', '', 'http://localhost/mainbible/home/shop', '18 April 2019');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `noticeid` int(100) NOT NULL,
  `noticetitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `noticedescription` text COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`noticeid`, `noticetitle`, `noticedescription`, `cdate`) VALUES
(2, 'Prayer For Illness from Fever', '<p><strong>Lorem Ipsum</strong><span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', ''),
(3, 'Prayer For Business', '<p><strong>Lorem Ipsum</strong><span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', ''),
(4, 'Prayer For Education', '<p><strong>Lorem Ipsum</strong><span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', ''),
(5, 'Prayer For Health Test', '<p><strong>Lorem Ipsum</strong><span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '15th September, 2017');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(100) NOT NULL,
  `orderUserID` int(100) NOT NULL,
  `orderCartIDs` text NOT NULL,
  `orderStatus` varchar(255) NOT NULL,
  `orderAmount` varchar(255) NOT NULL,
  `orderMethod` varchar(255) NOT NULL,
  `orderPayment` varchar(255) NOT NULL,
  `orderDeliver` varchar(255) DEFAULT NULL,
  `orderAddress` text NOT NULL,
  `orderCdate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `orderUserID`, `orderCartIDs`, `orderStatus`, `orderAmount`, `orderMethod`, `orderPayment`, `orderDeliver`, `orderAddress`, `orderCdate`) VALUES
(3, 152, '7,', 'Pending', '4.00', 'Paypal', 'PAY-17P27914GS2640320LLMXHRI', 'Delivered', 'USA', '20 April 2018'),
(5, 152, '9,', 'Pending', '4.00', 'Stripe', 'txn_1CIrlAA4JNh6ZWXnmPGbAgAy (4242)', NULL, 'Your Address (*)', '20 April 2018'),
(6, 153, '10,', 'Pending', '6.00', 'Stripe', 'txn_1CIroIA4JNh6ZWXnkLfEaXzn (4242)', 'Delivered', 'Your Address (*)', '20 April 2018'),
(7, 152, '19,20,', 'Pending', '15.00', 'Stripe', 'txn_1CnSp8A4JNh6ZWXnkFyfygbT (4242)', 'Delivered', 'sdfsdfsdfsdf', '13 July 2018');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `pageid` int(100) NOT NULL,
  `pagetitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pageslug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pagecontent` text COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`pageid`, `pagetitle`, `pageslug`, `pagecontent`, `cdate`) VALUES
(1, 'Our Pastor', 'ourpastor', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '8 September 2017'),
(2, 'About', 'about', '<p>sdasdasdasdasda</p>', '12 October 2017'),
(3, 'Chart', 'chart', '<h2>What is Lorem Ipsum?</h2><p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h2>Why do we use it?</h2><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', '15th September, 2017');

-- --------------------------------------------------------

--
-- Table structure for table `pastor`
--

CREATE TABLE `pastor` (
  `pastorid` int(100) NOT NULL,
  `profileimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bpdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blood` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `speech` text COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pinterest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marriagedate` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `socialstatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `family` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `job` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pastor`
--

INSERT INTO `pastor` (`pastorid`, `profileimage`, `fname`, `lname`, `phone`, `email`, `position`, `bpdate`, `blood`, `dob`, `nationality`, `speech`, `address`, `city`, `country`, `postal`, `cdate`, `facebook`, `twitter`, `googleplus`, `linkedin`, `youtube`, `pinterest`, `instagram`, `whatsapp`, `marriagedate`, `socialstatus`, `family`, `department`, `job`) VALUES
(5, '20171017_091530_921286.jpg', 'Josh', 'Baei', '908-773-7785', 'JohnMDejesus@dayrep.com', 'Pastor', '05/02/1980', 'B+', '22/02/2017', 'USA', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '', '', '', '', '16 July 2018', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, '20171206_075705_584127.jpeg', 'David', 'D. Pettengill', '708-939-3934', 'DavidDPettengill@rhyta.com', 'Senior Pastor', '27-11-2017', '', '', '', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '', '', '', '', '16 July 2018', '', '', '', '', '', '', '', '', '05-12-2017', '', '', '', ''),
(7, '20171209_070314_873427.jpg', 'Phillip', 'K. Manning', '860-202-6209', 'PhillipKManning@teleworm.us', 'Junior Pastor', '06-12-2017', '', '', '', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '', '', '', '', '16 July 2018', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, '20171209_070539_815271.jpg', 'Jessica', 'J. Byrd', '240-646-5493', '', 'Pastor', '19-12-2017', '', '', '', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '', '', '', '', '16 July 2018', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `prayer`
--

CREATE TABLE `prayer` (
  `prayerid` int(100) NOT NULL,
  `prayertitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prayerdescription` text COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `prayer`
--

INSERT INTO `prayer` (`prayerid`, `prayertitle`, `prayerdescription`, `cdate`) VALUES
(10, 'Prayer For Mr. John', 'Lorem Ipsum has been the industry\'s standard dumm', '29 June 2017'),
(13, 'Prayer For Mr. John', 'Lorem Ipsum has been the industry\'s standard dumm', '29 June 2017'),
(14, 'Prayer For Mr. John', 'Lorem Ipsum has been the industry\'s standard dumm', '29 June 2017'),
(15, 'Prayer For Mr. John', 'Lorem Ipsum has been the industry\'s standard dumm', '29 June 2017');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` int(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `sale` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cdate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `image`, `title`, `price`, `category`, `tag`, `sale`, `description`, `cdate`) VALUES
(1, '20180425_101807_436675.jpeg', 'Bible', '10', 'Bible, Book', 'bible, book, reading', '', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p>', '25 April 2018'),
(7, '20180425_101833_347666.jpeg', 'Christmas Light', '5', 'Christmas, Music, Entertainment', 'cd, song, xmas', 'Yes', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '25 April 2018'),
(8, '20180425_101902_695124.jpg', 'Christmas Toy', '10', 'Christmas, Music, Entertainment', 'cd, song, xmas', '1.5', '<p><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '25 April 2018'),
(9, '20180425_101937_675485.jpg', 'Christmas Sweater', '3', 'Christmas, Music, Entertainment', 'cd, song, xmas', '1.5', '<p><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '25 April 2018'),
(10, '20180425_102014_401414.jpeg', 'Decorative Flower', '8', 'Christmas, Music, Entertainment', 'cd, song, xmas', '', '<p><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '25 April 2018'),
(11, '20180425_103035_369435.jpg', 'Christmas Items', '3', 'Christmas, Music, Entertainment', 'cd, song, xmas', '1.5', '<p><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '25 April 2018'),
(12, '20180425_103126_462341.jpeg', 'Fireworks', '2', 'Christmas, Music, Entertainment', 'cd, song, xmas', '1.5', '<p><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '25 April 2018'),
(13, '20180425_103207_138560.jpg', 'Pencil', '2', 'Christmas, Music, Entertainment', 'cd, song, xmas', '1.5', '<p><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><strong open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; margin: 0px; padding: 0px; color: rgb(0, 0, 0);\">Lorem Ipsum</strong><span open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\" style=\"font-family: Bitter, serif; font-size: 18.2px; color: rgb(0, 0, 0);\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '25 April 2018');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `roleID` int(11) NOT NULL,
  `roletype` int(11) NOT NULL,
  `website` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `finance` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sermon` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prayer` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notice` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `speech` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `family` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `committee` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pastor` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clans` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chorus` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `staffs` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `school` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seminar` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attendance` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `communicaction` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blog` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shop` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`roleID`, `roletype`, `website`, `finance`, `sermon`, `event`, `prayer`, `notice`, `speech`, `family`, `department`, `committee`, `member`, `pastor`, `clans`, `chorus`, `staffs`, `school`, `user`, `seminar`, `attendance`, `communicaction`, `blog`, `shop`, `import`) VALUES
(2, 1, NULL, 'on', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 2, 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on'),
(4, 3, NULL, NULL, NULL, NULL, 'on', NULL, NULL, 'on', NULL, NULL, 'on', NULL, NULL, 'on', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 6, 'on', NULL, NULL, 'on', NULL, NULL, 'on', NULL, NULL, 'on', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'on', NULL, NULL, NULL, NULL, NULL, 'on');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `sectionid` int(100) NOT NULL,
  `serialid` int(100) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `background` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sectiononoff` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shortcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `btntext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`sectionid`, `serialid`, `title`, `background`, `sectiononoff`, `shortcode`, `content`, `link`, `btntext`, `cdate`) VALUES
(6, 0, 'About Us', '', 'Yes', '', '<h4>Lorem Ipsum<span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</h4><h4>Lorem Ipsum is simply dum text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</h4>', 'home/page/welcome', 'Read More...', '18 April 2019'),
(9, 5, 'Speech/Testimonial', '', 'Yes', 'speech, speech, desc, speechid, 4', '', 'http://localhost/cms/home/speech', 'All Testimonails', '18 April 2019'),
(12, 4, 'Seminar', '', 'Yes', 'event, seminar, desc,  seminarid, 6', '', '#', 'View More', '18 April 2019'),
(13, 3, 'Sermon', '', 'Yes', 'event, sermon, desc, sermonid, 6', '', '#', 'View More', '18 April 2019'),
(14, 8, 'Member', '', 'Yes', 'group, member, desc, memberid, 4', '', '#', 'View More', '18 April 2019'),
(15, 6, 'Church Committee', '', 'Yes', 'group, committee, desc, committeeid, 4', '', '#', 'View More', '18 April 2019'),
(16, 7, 'Pastor', '', NULL, 'group, pastor, desc, pastorid, 4', '', '#', 'View More', '6 December 2017'),
(17, 2, 'Latest Blog Posts', '', 'Yes', 'event, blog, desc, postID, 6', '', 'http://localhost/cms/home/blog', 'Visit Blog', '18 April 2019'),
(18, 1, 'Shop', '', 'Yes', 'shop, product, desc, productID, 6', '', 'http://onezeroart.com/bible/home/shop', 'Visit More', '18 April 2019');

-- --------------------------------------------------------

--
-- Table structure for table `seminar`
--

CREATE TABLE `seminar` (
  `seminarid` int(100) NOT NULL,
  `seminarbanner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seminartitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seminarslogan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seminardescription` text COLLATE utf8_unicode_ci NOT NULL,
  `seminarstart` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seminarend` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seminarlocation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `seminar`
--

INSERT INTO `seminar` (`seminarid`, `seminarbanner`, `seminartitle`, `seminarslogan`, `seminardescription`, `seminarstart`, `seminarend`, `seminarlocation`, `cdate`) VALUES
(5, '20171210_015602_144156.jpg', 'Believe in Jesus', 'What is Lorem Ipsum?', '<p>Lorem Ipsum<span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it tLorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it tLorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it tLorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it tLorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it tLorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it t</p>', '27/03/2017', '27/03/2017', 'USA', '10 December 2017'),
(6, '20180713_071548_254977.jpeg', 'Growing Up in Jesus', 'What is Lorem Ipsum?', '<p>Lorem Ipsum<span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it t</p><p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it t<br></p><p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it t<br></p><p>Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it t<br></p>', '27/03/2017', '27/03/2017', 'Temple, London EC4Y 7BB, UK', '13 July 2018'),
(9, '20171210_014422_135739.jpg', 'Youth Conference', 'What is Lorem Ipsum?', '<h4><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" text-align:=\"\" justify;\"=\"\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></h4>', '01-12-2017', '03-12-2017', 'Temple, London EC4Y 7BB, UK', '10 December 2017');

-- --------------------------------------------------------

--
-- Table structure for table `seminarregistration`
--

CREATE TABLE `seminarregistration` (
  `seminarregid` int(100) NOT NULL,
  `selectedseminarid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profileimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `age` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `education` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `church` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `churchpastor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guardian` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guardiancontact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paymentgateway` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paymentgatewayinfo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paymentsenderinfo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pinterest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `seminarregistration`
--

INSERT INTO `seminarregistration` (`seminarregid`, `selectedseminarid`, `profileimage`, `fname`, `lname`, `gender`, `phone`, `email`, `age`, `education`, `church`, `churchpastor`, `guardian`, `guardiancontact`, `nationality`, `paymentgateway`, `paymentgatewayinfo`, `paymentsenderinfo`, `address`, `city`, `country`, `postal`, `cdate`, `facebook`, `twitter`, `googleplus`, `linkedin`, `youtube`, `pinterest`, `instagram`, `whatsapp`) VALUES
(30, '6', '20180214_075117_701597.jpeg', 'Anukul', 'Smith', 'Male', '908-773-7785', 'JohnMDejesus@dayrep.com', '22', 'Honours', 'KCC AG Church', 'Ojit Kormoker', 'Simon', '908-773-7785', 'American', 'Credit/Debit Card', '908-773-7785', '908-773-7785', '', '', '', '', '14 February 2018', '', '', '', '', '', '', '', ''),
(31, '6', '20180214_075147_743151.jpeg', 'John', 'Borman', 'Male', '908-773-7785', 'JohnMDejesus@dayrep.com', '22', 'Honours', 'KCC AG Church', 'Ojit Cruz', 'Simon', '908-773-7785', 'American', 'Bank', '054811649224674', '598746487', '', '', '', '', '14 February 2018', '', '', '', '', '', '', '', ''),
(32, '6', '20180214_075044_511821.jpeg', 'John M.', 'Dejesus', 'Male', '908-773-7785', 'JohnMDejesus@dayrep.com', '', '', '', '', '', '', '', 'Paypal', '', '', '', '', '', '', '14 February 2018', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sermon`
--

CREATE TABLE `sermon` (
  `sermonid` int(100) NOT NULL,
  `sermonbanner` varchar(255) NOT NULL,
  `sermontitle` varchar(255) NOT NULL,
  `sermondate` varchar(255) NOT NULL,
  `sermontime` varchar(255) NOT NULL,
  `sermonlocation` varchar(255) NOT NULL,
  `sermonauthor` varchar(255) NOT NULL,
  `sermonyoutube` varchar(255) NOT NULL,
  `sermonsoundcloud` varchar(255) NOT NULL,
  `sermondescription` text NOT NULL,
  `video` varchar(100) DEFAULT NULL,
  `audio` varchar(100) DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `cdate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sermon`
--

INSERT INTO `sermon` (`sermonid`, `sermonbanner`, `sermontitle`, `sermondate`, `sermontime`, `sermonlocation`, `sermonauthor`, `sermonyoutube`, `sermonsoundcloud`, `sermondescription`, `video`, `audio`, `file`, `cdate`) VALUES
(1, '20171210_014021_117671.jpg', 'The God Who Is Rich In Mercy', '25-12-2017', '10:00 AM', 'Temple, London EC4Y 7BB, UK', 'John', 'https://www.youtube.com', 'https://soundcloud.com/', '<p style=\"line-height: 1.1;\">Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '20180728_084416_195685.mp4', '20180729_092553_105378.mp3', NULL, '29 July 2018'),
(2, '20171210_014115_782090.jpg', 'Power Of Transformation', '11-12-2017', '3:30 PM', 'Temple, London EC4Y 7BB, UK', 'John', 'https://www.youtube.com', 'https://soundcloud.com/', '<blockquote style=\"font-family: Ubuntu, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); font-size: 18px;\"><span style=\"font-weight: 700;\">Lorem Ipsum</span>&nbsp;is simply dummy&nbsp;text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,&nbsp;when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</blockquote>', NULL, NULL, NULL, '10 December 2017'),
(3, '20171210_014215_449872.jpg', 'The Voice Of The Sign', '01-01-2018', '10:00 AM', 'Temple, London EC4Y 7BB, UK', 'John', 'https://www.youtube.com', 'https://soundcloud.com/', '<h4 style=\"font-family: Ubuntu, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); font-size: 18px;\"><span style=\"font-weight: 700;\">Lorem Ipsum</span>&nbsp;is simply dummy&nbsp;text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,&nbsp;when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</h4>', NULL, NULL, NULL, '10 December 2017'),
(47, '20171210_014021_117671.jpg', 'The God Who Is Rich In Mercy', '25-12-2017', '10:00 AM', 'Temple, London EC4Y 7BB, UK', 'John', 'https://www.youtube.com', 'https://soundcloud.com/', '<p style=\"line-height: 1.1;\">Lorem Ipsum&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '20180728_084416_195685.mp4', '20180729_092553_105378.mp3', NULL, '29 July 2018'),
(48, '20171210_014115_782090.jpg', 'Power Of Transformation', '11-12-2017', '3:30 PM', 'Temple, London EC4Y 7BB, UK', 'John', 'https://www.youtube.com', 'https://soundcloud.com/', '<blockquote style=\"font-family: Ubuntu, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); font-size: 18px;\"><span style=\"font-weight: 700;\">Lorem Ipsum</span>&nbsp;is simply dummy&nbsp;text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,&nbsp;when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</blockquote>', NULL, NULL, NULL, '10 December 2017'),
(49, '20171210_014215_449872.jpg', 'The Voice Of The Sign', '01-01-2018', '10:00 AM', 'Temple, London EC4Y 7BB, UK', 'John', 'https://www.youtube.com', 'https://soundcloud.com/', '<h4 style=\"font-family: Ubuntu, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); font-size: 18px;\"><span style=\"font-weight: 700;\">Lorem Ipsum</span>&nbsp;is simply dummy&nbsp;text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,&nbsp;when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</h4>', NULL, NULL, NULL, '10 December 2017');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `sliderid` int(100) NOT NULL,
  `serialid` int(255) NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`sliderid`, `serialid`, `filename`, `cdate`) VALUES
(4, 0, '20190418_045913_179827.jpg', '18 April 2019'),
(5, 0, '20190418_045938_264871.jpg', '18 April 2019'),
(6, 0, '20190418_050006_485261.jpg', '18 April 2019');

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `smsID` int(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `messageid` varchar(255) NOT NULL,
  `messageprice` varchar(255) NOT NULL,
  `network` varchar(255) NOT NULL,
  `remainingbalance` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `speech`
--

CREATE TABLE `speech` (
  `speechid` int(100) NOT NULL,
  `profileimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `speech` text COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pinterest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `speech`
--

INSERT INTO `speech` (`speechid`, `profileimage`, `fname`, `lname`, `position`, `category`, `speech`, `cdate`, `facebook`, `twitter`, `googleplus`, `linkedin`, `youtube`, `pinterest`, `instagram`, `whatsapp`, `city`, `country`) VALUES
(4, '20171016_095601_529785.jpg', 'John M.', 'Dejesus', 'Senior Pastor', '', '<p>Lorem Ipsum<span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '17 July 2018', '', '', '', '', '', '', '', '', '', ''),
(5, '20171016_095525_624378.jpg', 'Mark Cornel', 'Wally', 'Senior Pastor', '', '<p>Lorem Ipsum<span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '16 October 2017', '', '', '', '', '', '', '', '', '', ''),
(6, '20171016_095329_115976.jpg', 'Joseph S.', 'Johnson', 'Pastor', '', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '16 October 2017', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffid` int(100) NOT NULL,
  `profileimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bpdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blood` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marriagedate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `socialstatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `family` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pinterest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffid`, `profileimage`, `fname`, `lname`, `gender`, `phone`, `email`, `position`, `bpdate`, `blood`, `dob`, `marriagedate`, `socialstatus`, `job`, `family`, `department`, `nationality`, `address`, `city`, `country`, `postal`, `cdate`, `facebook`, `twitter`, `googleplus`, `linkedin`, `youtube`, `pinterest`, `instagram`, `whatsapp`) VALUES
(1, '20171017_092322_322886.jpg', 'Philip', 'Duke', 'Male', '908-773-7785', 'JohnMDejesus@dayrep.com', 'Senior Pastor', '05/11/1985', 'B+', '05/11/1985', '', '', '', '', '', 'USA', '', '', '', '', '17 October 2017', '', '', '', '', '', '', '', ''),
(6, '20171017_092528_892078.jpg', 'Alan', 'Harper', 'Male', '908-773-7785', 'JohnMDejesus@dayrep.com', 'Member', '17/10/1937', 'AB+', '17/10/1937', '', '', '', '', '', 'USA', '', '', '', '', '17 October 2017', '', '', '', '', '', '', '', ''),
(7, '20171017_092722_462681.jpg', 'Alex', 'Cruz', 'Male', '908-773-7785', 'JohnMDejesus@dayrep.com', 'Member', '17/10/1995', 'AB+', '17/10/1995', '', '', '', '', '', 'American', '', 'New York', 'USA', '', '17 October 2017', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sundayschool`
--

CREATE TABLE `sundayschool` (
  `sschoolid` int(100) NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profileimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bpdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guardian` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `age` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sclass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blood` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marriagedate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `socialstatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `family` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pinterest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sundayschool`
--

INSERT INTO `sundayschool` (`sschoolid`, `fname`, `lname`, `profileimage`, `gender`, `phone`, `position`, `bpdate`, `guardian`, `age`, `sclass`, `blood`, `dob`, `marriagedate`, `socialstatus`, `job`, `family`, `department`, `nationality`, `address`, `city`, `country`, `postal`, `cdate`, `facebook`, `twitter`, `googleplus`, `linkedin`, `youtube`, `pinterest`, `instagram`, `whatsapp`) VALUES
(4, 'Philip', 'Simon', '20171017_093306_151256.jpg', 'Male', '021584678', '', '20/03/2017', 'Matthew Alex', '13', '2nd Session', 'B+', '15/03/2017', '', '', '', '', '', 'USA', '', 'NY', 'USA', '', '17 October 2017', '', '', '', '', '', '', '', ''),
(5, 'John', 'Mendis', '20171017_093603_943271.jpg', 'Male', '908-773-7785', 'member', '13/01/1995', 'Philip', '12', '2nd Session', 'AB+', '20/02/1995', '', '', '', '', '', 'American', '', 'NY', 'USA', '', '17 October 2017', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(100) NOT NULL,
  `userstatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profileimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mediaIdentifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bpdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blood` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `about` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `terms_and_condition` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pinterest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `userstatus`, `username`, `profileimage`, `fname`, `lname`, `phone`, `email`, `password`, `mediaIdentifier`, `position`, `bpdate`, `blood`, `dob`, `nationality`, `about`, `address`, `city`, `country`, `postal`, `terms_and_condition`, `cdate`, `facebook`, `twitter`, `googleplus`, `linkedin`, `youtube`, `pinterest`, `instagram`, `whatsapp`) VALUES
(152, 'Active', 'johnsmith', '20171017_093821_438451.jpg', 'John', 'Smith', '908-773-7785', 'admin@site.com', 'e10adc3949ba59abbe56e057f20f883e', '', 'Admin', '13/09/2017', '', '', '', '', '', '', '', '', '', '18 December 2018', '', '', '', '', '', '', '', ''),
(153, 'Active', 'miltonfields', '20171017_093925_806732.jpg', 'Milton', 'Fields', '908-773-7785', 'user@site.com', 'e10adc3949ba59abbe56e057f20f883e', '', 'Subscriber', '', '', '', '', '', '', '', '', '', '', '17 October 2017', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `websitebasic`
--

CREATE TABLE `websitebasic` (
  `basicid` int(11) NOT NULL,
  `favicon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `map` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapapi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fbappid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `churchtime` text COLLATE utf8_unicode_ci NOT NULL,
  `about` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pinterest` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `copyright` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `donationtext` text COLLATE utf8_unicode_ci,
  `verify` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mailgun_api` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mailgun_from` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mailgun_domain` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nexmo_api` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nexmo_secret` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nexmo_from` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_client_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_secret` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_apikey` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_secret` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twilio_sid` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twilio_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twilio_sender` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `smsapi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `websitebasic`
--

INSERT INTO `websitebasic` (`basicid`, `favicon`, `logo`, `title`, `tag`, `currency`, `map`, `mapapi`, `fbappid`, `email`, `color`, `churchtime`, `about`, `contact`, `address`, `city`, `country`, `postal`, `facebook`, `twitter`, `linkedin`, `googleplus`, `youtube`, `pinterest`, `instagram`, `whatsapp`, `copyright`, `donationtext`, `verify`, `mailgun_api`, `mailgun_from`, `mailgun_domain`, `nexmo_api`, `nexmo_secret`, `nexmo_from`, `paypal_client_id`, `paypal_secret`, `stripe_apikey`, `stripe_secret`, `twilio_sid`, `twilio_token`, `twilio_sender`, `smsapi`) VALUES
(1, '20180423_071141_858952.png', '20180423_071141_8589521.png', 'Trinity Church', 'Let\'s Spread The News Of Jesus', 'USD', 'Episcopal church in New York City, New York', 'AIzaSyAIB2KNkAf47At1Tlp5PCYFA7518OZhJ64', '1959877937615152', 'admin@site.com', '#131111', '<p><span style=\"text-align: justify;\">Lorem Ipsum</span><span style=\"text-align: justify;\">&nbsp;is simply dummied text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>', '<p><span style=\"text-align: justify;\">Lorem Ipsum</span><span style=\"text-align: justify;\">&nbsp;is simply dummied text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s when an unknown&', '<p><span style=\"text-align: justify;\">Lorem Ipsum</span><span style=\"text-align: justify;\">&nbsp;is simply dummied text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s when an unknown ', '<p><span style=\"text-align: justify;\">Lorem Ipsum</span><span style=\"text-align: justify;\">&nbsp;is simply dummied text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s when an unknown ', 'New York', 'USA', '1000', 'https://www.facebook.com/onezeroart/', '#', '#', '#', '#', '#', '#', '#', '<p>Web Support - OneZeroArt&nbsp;<br></p>', '<p>Carry Each Other’s Burdens, And In This Way You Will Fulfill The Law Of Christ.<br>Galatians 6:2</p>', '', 'key-74283e3f76b48e69b95e12cd16a8b797', 'support@onezeroart.com', 'onezeroart.com', 'f97f7001', '461e78bbb24e42abf6', '880172446562944', 'Adx465SgkzVfGrNW125cDCatbbCqiYqj7hKDbJk0og08jkVoBVV-b1SlDuL60z4aztGgSgMVdb5xPaNLzl', 'ELyLozS1eVoORdlvYZFaitwlKRXtKgAOMEdG_Za-jcLRyPN2LjfY-XtbbeUU4O6VSLj9dJHYjWBcZlQ1K4', 'pk_test_uavQVbbvB1ueyXPdPQTTi6LeDp', 'sk_test_mi57FrbbKIBSffQz88cpLzHGxS', 'AC7e747bc3b0cbb1c96406031065afce5d63', 'de94f32ebbf5dba7d72eb97593b91143d3', '+1701401137644', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`assetsid`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attenid`);

--
-- Indexes for table `attendancetype`
--
ALTER TABLE `attendancetype`
  ADD PRIMARY KEY (`attendancetypeid`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`);

--
-- Indexes for table `chorus`
--
ALTER TABLE `chorus`
  ADD PRIMARY KEY (`chorusid`);

--
-- Indexes for table `clan`
--
ALTER TABLE `clan`
  ADD PRIMARY KEY (`clanid`);

--
-- Indexes for table `committee`
--
ALTER TABLE `committee`
  ADD PRIMARY KEY (`committeeid`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentid`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`donationid`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`emailID`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventid`);

--
-- Indexes for table `eventregistration`
--
ALTER TABLE `eventregistration`
  ADD PRIMARY KEY (`registrationID`);

--
-- Indexes for table `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`familyid`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`fundsid`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`galleryid`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`memberid`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menuid`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`noticeid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`pageid`);

--
-- Indexes for table `pastor`
--
ALTER TABLE `pastor`
  ADD PRIMARY KEY (`pastorid`);

--
-- Indexes for table `prayer`
--
ALTER TABLE `prayer`
  ADD PRIMARY KEY (`prayerid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`roleID`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`sectionid`);

--
-- Indexes for table `seminar`
--
ALTER TABLE `seminar`
  ADD PRIMARY KEY (`seminarid`);

--
-- Indexes for table `seminarregistration`
--
ALTER TABLE `seminarregistration`
  ADD PRIMARY KEY (`seminarregid`);

--
-- Indexes for table `sermon`
--
ALTER TABLE `sermon`
  ADD PRIMARY KEY (`sermonid`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`sliderid`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`smsID`);

--
-- Indexes for table `speech`
--
ALTER TABLE `speech`
  ADD PRIMARY KEY (`speechid`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffid`);

--
-- Indexes for table `sundayschool`
--
ALTER TABLE `sundayschool`
  ADD PRIMARY KEY (`sschoolid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `websitebasic`
--
ALTER TABLE `websitebasic`
  ADD PRIMARY KEY (`basicid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `assetsid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attenid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `attendancetype`
--
ALTER TABLE `attendancetype`
  MODIFY `attendancetypeid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `postID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `chorus`
--
ALTER TABLE `chorus`
  MODIFY `chorusid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clan`
--
ALTER TABLE `clan`
  MODIFY `clanid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `committee`
--
ALTER TABLE `committee`
  MODIFY `committeeid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `donationid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `emailID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `eventregistration`
--
ALTER TABLE `eventregistration`
  MODIFY `registrationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `family`
--
ALTER TABLE `family`
  MODIFY `familyid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
  MODIFY `fundsid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `galleryid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `memberid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menuid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `noticeid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `pageid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pastor`
--
ALTER TABLE `pastor`
  MODIFY `pastorid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prayer`
--
ALTER TABLE `prayer`
  MODIFY `prayerid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `sectionid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `seminar`
--
ALTER TABLE `seminar`
  MODIFY `seminarid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seminarregistration`
--
ALTER TABLE `seminarregistration`
  MODIFY `seminarregid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sermon`
--
ALTER TABLE `sermon`
  MODIFY `sermonid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `sliderid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `smsID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `speech`
--
ALTER TABLE `speech`
  MODIFY `speechid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sundayschool`
--
ALTER TABLE `sundayschool`
  MODIFY `sschoolid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `websitebasic`
--
ALTER TABLE `websitebasic`
  MODIFY `basicid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
