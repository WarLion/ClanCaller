
CREATE TABLE IF NOT EXISTS `bugs` (
  `bug_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `message` varchar(255) NOT NULL,
  `read` varchar(5) DEFAULT '1',
  PRIMARY KEY (`bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;



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
  `user_username5` varchar(20) NOT NULL,
  `user_username6` varchar(20) NOT NULL,
  `user_username7` varchar(20) NOT NULL,
  `user_username8` varchar(20) NOT NULL,
  PRIMARY KEY (`caller_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;



INSERT INTO `caller` (`caller_id`, `war_warid`, `war_enemy`, `war_enemynumber`, `call_th`, `call_base`, `user_username1`, `user_username2`, `user_username3`, `user_username4`, `user_username5`, `user_username6`, `user_username7`, `user_username8`) VALUES
(1, '', 'test', '1', 'noselect', 'noscreen.jpg', '', '', '', '', '', '', '', ''),
(2, '', 'test', '2', 'noselect', 'noscreen.jpg', '', '', '', '', '', '', '', ''),
(3, '', 'test', '3', 'noselect', 'noscreen.jpg', '', '', '', '', '', '', '', ''),
(4, '', 'test', '4', 'noselect', 'noscreen.jpg', '', '', '', '', '', '', '', ''),
(5, '', 'test', '5', 'noselect', 'noscreen.jpg', '', '', '', '', '', '', '', ''),
(6, '', 'test', '6', 'noselect', 'noscreen.jpg', '', '', '', '', '', '', '', ''),
(7, '', 'test', '7', 'noselect', 'noscreen.jpg', '', '', '', '', '', '', '', ''),
(8, '', 'test', '8', 'noselect', 'noscreen.jpg', '', '', '', '', '', '', '', ''),
(9, '', 'test', '9', 'noselect', 'noscreen.jpg', '', '', '', '', '', '', '', ''),
(10, '', 'test', '10', 'noselect', 'noscreen.jpg', '', '', '', '', '', '', '', '');


CREATE TABLE IF NOT EXISTS `clan_info` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `war_won` varchar(10) NOT NULL,
  `war_lost` varchar(10) NOT NULL,
  `war_tie` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;



INSERT INTO `clan_info` (`id`, `war_won`, `war_lost`, `war_tie`) VALUES
(1, '0', '0', '0');



CREATE TABLE IF NOT EXISTS `rules` (
  `rules_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(255) NOT NULL,
  `rule_txt` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`rules_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;



CREATE TABLE IF NOT EXISTS `score` (
  `score_id` int(10) NOT NULL AUTO_INCREMENT,
  `war_enemy` varchar(255) DEFAULT NULL,
  `user_username` varchar(255) DEFAULT NULL,
  `enemy_enemynumber` int(1) DEFAULT NULL,
  `score` varchar(1) DEFAULT NULL,
  `favattack` varchar(255) DEFAULT NULL,
  `plan` varchar(255) DEFAULT 'userfiles/screenshoots/noplan.jpg',
  PRIMARY KEY (`score_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;



CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(20) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_firstname` varchar(30) NOT NULL,
  `user_avatar` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_favtroop` varchar(10) NOT NULL DEFAULT 'none',
  `user_favattack` varchar(15) NOT NULL DEFAULT 'none',
  `user_th` varchar(4) NOT NULL,
  `user_bk` varchar(2) NOT NULL DEFAULT '00',
  `user_aq` varchar(2) NOT NULL DEFAULT '00',
  `user_title` varchar(1) NOT NULL DEFAULT '1',
  `user_email_get` varchar(1) NOT NULL DEFAULT '1',
  `user_slogan` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_username` (`user_username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `user` (`user_id`, `user_email`, `user_password`, `user_firstname`, `user_avatar`, `user_username`, `user_favtroop`, `user_favattack`, `user_th`, `user_bk`, `user_aq`, `user_title`, `user_email_get`, `user_slogan`) VALUES
(2, 'admin@email.com', '7b7bc2512ee1fedcd76bdc68926d4f7b', 'Administrator', 'default.jpg', 'Admin', '', '', '', '', '', '6', '2', '');

CREATE TABLE IF NOT EXISTS `war_log` (
  `log_id` int(5) NOT NULL AUTO_INCREMENT,
  `log_username` varchar(30) NOT NULL,
  `log_score` varchar(3) NOT NULL,
  `log_status` varchar(30) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `log_clanname` varchar(255) NOT NULL,
  `log_enemy_number` varchar(2) NOT NULL,
  `log_as_user` varchar(30) NOT NULL,
  `log_time` time NOT NULL,
  `log_end_time` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


CREATE TABLE IF NOT EXISTS `war_table` (
  `war_warid` int(11) NOT NULL AUTO_INCREMENT,
  `war_enemy` varchar(255) NOT NULL,
  `war_size` varchar(2) NOT NULL,
  `war_time` timestamp NOT NULL,
  `caller_time` varchar(2) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;



INSERT INTO `war_table` (`war_warid`, `war_enemy`, `war_size`, `war_time`, `caller_time`, `war_enemy_1`, `war_enemy_2`, `war_enemy_3`, `war_enemy_4`, `war_enemy_5`, `war_enemy_6`, `war_enemy_7`, `war_enemy_8`, `war_enemy_9`, `war_enemy_10`, `war_enemy_11`, `war_enemy_12`, `war_enemy_13`, `war_enemy_14`, `war_enemy_15`, `war_enemy_16`, `war_enemy_17`, `war_enemy_18`, `war_enemy_19`, `war_enemy_20`, `war_enemy_21`, `war_enemy_22`, `war_enemy_23`, `war_enemy_24`, `war_enemy_25`, `war_enemy_26`, `war_enemy_27`, `war_enemy_28`, `war_enemy_29`, `war_enemy_30`, `war_enemy_31`, `war_enemy_32`, `war_enemy_33`, `war_enemy_34`, `war_enemy_35`, `war_enemy_36`, `war_enemy_37`, `war_enemy_38`, `war_enemy_39`, `war_enemy_40`, `war_enemy_41`, `war_enemy_42`, `war_enemy_43`, `war_enemy_44`, `war_enemy_45`, `war_enemy_46`, `war_enemy_47`, `war_enemy_48`, `war_enemy_49`, `war_enemy_50`) VALUES
(1, 'test', '10', '2015-10-06 08:55:16', '5', 'enemy_1', 'enemy_2', 'enemy_3', 'enemy_4', 'enemy_5', 'enemy_6', 'enemy_7', 'enemy_8', 'enemy_9', 'enemy_10', 'enemy_11', 'enemy_12', 'enemy_13', 'enemy_14', 'enemy_15', 'enemy_16', 'enemy_17', 'enemy_18', 'enemy_19', 'enemy_20', 'enemy_21', 'enemy_22', 'enemy_23', 'enemy_24', 'enemy_25', 'enemy_26', 'enemy_27', 'enemy_28', 'enemy_29', 'enemy_30', 'enemy_31', 'enemy_32', 'enemy_33', 'enemy_34', 'enemy_35', 'enemy_36', 'enemy_37', 'enemy_38', 'enemy_39', 'enemy_40', 'enemy_41', 'enemy_42', 'enemy_43', 'enemy_44', 'enemy_45', 'enemy_46', 'enemy_47', 'enemy_48', 'enemy_49', 'enemy_50');