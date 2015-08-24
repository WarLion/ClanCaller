-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2015 at 03:07 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `clanwars`
--

-- --------------------------------------------------------

--
-- Table structure for table `caller`
--

CREATE TABLE IF NOT EXISTS `caller` (
  `caller_id` int(11) NOT NULL AUTO_INCREMENT,
  `war_warid` varchar(255) NOT NULL,
  `war_enemy` varchar(255) NOT NULL,
  `war_enemynumber` varchar(2) DEFAULT NULL,
  `call_th` varchar(10) DEFAULT 'noselect',
  `call_base` varchar(255) NOT NULL DEFAULT 'noscreen.jpg',
  `user_username1` varchar(255) NOT NULL,
  `user_username2` varchar(255) NOT NULL,
  `user_username3` varchar(255) NOT NULL,
  `user_username4` varchar(255) NOT NULL,
  PRIMARY KEY (`caller_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

--
-- Dumping data for table `caller`
--

INSERT INTO `caller` (`caller_id`, `war_warid`, `war_enemy`, `war_enemynumber`, `call_th`, `call_base`, `user_username1`, `user_username2`, `user_username3`, `user_username4`) VALUES
(101, '', 'first war ', '1', 'noselect', 'noscreen.jpg', '', '', '', ''),
(102, '', 'first war ', '2', 'noselect', 'noscreen.jpg', '', '', '', ''),
(103, '', 'first war ', '3', 'noselect', 'noscreen.jpg', '', '', '', ''),
(104, '', 'first war ', '4', 'noselect', 'noscreen.jpg', '', '', '', ''),
(105, '', 'first war ', '5', 'noselect', 'noscreen.jpg', '', '', '', ''),
(106, '', 'first war ', '6', 'noselect', 'noscreen.jpg', '', '', '', ''),
(107, '', 'first war ', '7', 'noselect', 'noscreen.jpg', '', '', '', ''),
(108, '', 'first war ', '8', 'noselect', 'noscreen.jpg', '', '', '', ''),
(109, '', 'first war ', '9', 'noselect', 'noscreen.jpg', '', '', '', ''),
(110, '', 'first war ', '10', 'noselect', 'noscreen.jpg', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE IF NOT EXISTS `rules` (
  `rules_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(255) NOT NULL,
  `rule_txt` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`rules_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`rules_id`, `user_username`, `rule_txt`) VALUES
(1, 'admin', '<p>here the rules of you clan </p>');

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE IF NOT EXISTS `score` (
  `score_id` int(10) NOT NULL AUTO_INCREMENT,
  `war_enemy` varchar(255) DEFAULT NULL,
  `user_username` varchar(255) DEFAULT NULL,
  `enemy_enemynumber` int(1) DEFAULT NULL,
  `score` int(1) DEFAULT '0',
  `favattack` varchar(255) DEFAULT NULL,
  `plan` varchar(255) DEFAULT 'userfiles/screenshoots/noplan.jpg',
  PRIMARY KEY (`score_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=165 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` text NOT NULL,
  `user_avatar` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_favtroop` varchar(10) NOT NULL DEFAULT 'none',
  `user_favattack` varchar(15) NOT NULL DEFAULT 'none',
  `user_th` varchar(4) NOT NULL,
  `user_bk` varchar(2) NOT NULL DEFAULT '00',
  `user_aq` varchar(2) NOT NULL DEFAULT '00',
  `user_title` varchar(1) NOT NULL DEFAULT '1',
  `user_active` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_username` (`user_username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1490 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_email`, `user_password`, `user_firstname`, `user_avatar`, `user_username`, `user_favtroop`, `user_favattack`, `user_th`, `user_bk`, `user_aq`, `user_title`, `user_active`) VALUES
(1, '', 'admin', '', 'default.jpg', 'admin', '', '', '', '', '', '6', '2');

-- --------------------------------------------------------

--
-- Table structure for table `war_table`
--

CREATE TABLE IF NOT EXISTS `war_table` (
  `war_warid` int(11) NOT NULL AUTO_INCREMENT,
  `war_enemy` varchar(255) NOT NULL,
  `war_size` varchar(2) NOT NULL,
  `war_active` varchar(10) NOT NULL DEFAULT 'active',
  `war_enemy_1` varchar(20) NOT NULL DEFAULT 'enemy_1',
  `war_enemy_2` varchar(20) NOT NULL DEFAULT 'enemy_2',
  `war_enemy_3` varchar(20) NOT NULL DEFAULT 'enemy_3',
  `war_enemy_4` varchar(20) NOT NULL DEFAULT 'enemy_4',
  `war_enemy_5` varchar(20) NOT NULL DEFAULT 'enemy_5',
  `war_enemy_6` varchar(20) NOT NULL DEFAULT 'enemy_6',
  `war_enemy_7` varchar(20) NOT NULL DEFAULT 'enemy_7',
  `war_enemy_8` varchar(20) NOT NULL DEFAULT 'enemy_8',
  `war_enemy_9` varchar(20) NOT NULL DEFAULT 'enemy_9',
  `war_enemy_10` varchar(20) NOT NULL DEFAULT 'enemy_10',
  `war_enemy_11` varchar(20) NOT NULL DEFAULT 'enemy_11',
  `war_enemy_12` varchar(20) NOT NULL DEFAULT 'enemy_12',
  `war_enemy_13` varchar(20) NOT NULL DEFAULT 'enemy_13',
  `war_enemy_14` varchar(20) NOT NULL DEFAULT 'enemy_14',
  `war_enemy_15` varchar(20) NOT NULL DEFAULT 'enemy_15',
  `war_enemy_16` varchar(20) NOT NULL DEFAULT 'enemy_16',
  `war_enemy_17` varchar(20) NOT NULL DEFAULT 'enemy_17',
  `war_enemy_18` varchar(20) NOT NULL DEFAULT 'enemy_18',
  `war_enemy_19` varchar(20) NOT NULL DEFAULT 'enemy_19',
  `war_enemy_20` varchar(20) NOT NULL DEFAULT 'enemy_20',
  `war_enemy_21` varchar(20) NOT NULL DEFAULT 'enemy_21',
  `war_enemy_22` varchar(20) NOT NULL DEFAULT 'enemy_22',
  `war_enemy_23` varchar(20) NOT NULL DEFAULT 'enemy_23',
  `war_enemy_24` varchar(20) NOT NULL DEFAULT 'enemy_24',
  `war_enemy_25` varchar(20) NOT NULL DEFAULT 'enemy_25',
  `war_enemy_26` varchar(20) NOT NULL DEFAULT 'enemy_26',
  `war_enemy_27` varchar(20) NOT NULL DEFAULT 'enemy_27',
  `war_enemy_28` varchar(20) NOT NULL DEFAULT 'enemy_28',
  `war_enemy_29` varchar(20) NOT NULL DEFAULT 'enemy_29',
  `war_enemy_30` varchar(20) NOT NULL DEFAULT 'enemy_30',
  `war_enemy_31` varchar(20) NOT NULL DEFAULT 'enemy_31',
  `war_enemy_32` varchar(20) NOT NULL DEFAULT 'enemy_32',
  `war_enemy_33` varchar(20) NOT NULL DEFAULT 'enemy_33',
  `war_enemy_34` varchar(20) NOT NULL DEFAULT 'enemy_34',
  `war_enemy_35` varchar(20) NOT NULL DEFAULT 'enemy_35',
  `war_enemy_36` varchar(20) NOT NULL DEFAULT 'enemy_36',
  `war_enemy_37` varchar(20) NOT NULL DEFAULT 'enemy_37',
  `war_enemy_38` varchar(20) NOT NULL DEFAULT 'enemy_38',
  `war_enemy_39` varchar(20) NOT NULL DEFAULT 'enemy_39',
  `war_enemy_40` varchar(20) NOT NULL DEFAULT 'enemy_40',
  `war_enemy_41` varchar(20) NOT NULL DEFAULT 'enemy_41',
  `war_enemy_42` varchar(20) NOT NULL DEFAULT 'enemy_42',
  `war_enemy_43` varchar(20) NOT NULL DEFAULT 'enemy_43',
  `war_enemy_44` varchar(20) NOT NULL DEFAULT 'enemy_44',
  `war_enemy_45` varchar(20) NOT NULL DEFAULT 'enemy_45',
  `war_enemy_46` varchar(20) NOT NULL DEFAULT 'enemy_46',
  `war_enemy_47` varchar(20) NOT NULL DEFAULT 'enemy_47',
  `war_enemy_48` varchar(20) NOT NULL DEFAULT 'enemy_48',
  `war_enemy_49` varchar(20) NOT NULL DEFAULT 'enemy_49',
  `war_enemy_50` varchar(20) NOT NULL DEFAULT 'enemy_50',
  PRIMARY KEY (`war_warid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `war_table`
--

INSERT INTO `war_table` (`war_warid`, `war_enemy`, `war_size`, `war_active`, `war_enemy_1`, `war_enemy_2`, `war_enemy_3`, `war_enemy_4`, `war_enemy_5`, `war_enemy_6`, `war_enemy_7`, `war_enemy_8`, `war_enemy_9`, `war_enemy_10`, `war_enemy_11`, `war_enemy_12`, `war_enemy_13`, `war_enemy_14`, `war_enemy_15`, `war_enemy_16`, `war_enemy_17`, `war_enemy_18`, `war_enemy_19`, `war_enemy_20`, `war_enemy_21`, `war_enemy_22`, `war_enemy_23`, `war_enemy_24`, `war_enemy_25`, `war_enemy_26`, `war_enemy_27`, `war_enemy_28`, `war_enemy_29`, `war_enemy_30`, `war_enemy_31`, `war_enemy_32`, `war_enemy_33`, `war_enemy_34`, `war_enemy_35`, `war_enemy_36`, `war_enemy_37`, `war_enemy_38`, `war_enemy_39`, `war_enemy_40`, `war_enemy_41`, `war_enemy_42`, `war_enemy_43`, `war_enemy_44`, `war_enemy_45`, `war_enemy_46`, `war_enemy_47`, `war_enemy_48`, `war_enemy_49`, `war_enemy_50`) VALUES
(7, 'first war ', '10', 'active', 'enemy_1', 'enemy_2', 'enemy_3', 'enemy_4', 'enemy_5', 'enemy_6', 'enemy_7', 'enemy_8', 'enemy_9', 'enemy_10', 'enemy_11', 'enemy_12', 'enemy_13', 'enemy_14', 'enemy_15', 'enemy_16', 'enemy_17', 'enemy_18', 'enemy_19', 'enemy_20', 'enemy_21', 'enemy_22', 'enemy_23', 'enemy_24', 'enemy_25', 'enemy_26', 'enemy_27', 'enemy_28', 'enemy_29', 'enemy_30', 'enemy_31', 'enemy_32', 'enemy_33', 'enemy_34', 'enemy_35', 'enemy_36', 'enemy_37', 'enemy_38', 'enemy_39', 'enemy_40', 'enemy_41', 'enemy_42', 'enemy_43', 'enemy_44', 'enemy_45', 'enemy_46', 'enemy_47', 'enemy_48', 'enemy_49', 'enemy_50');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
