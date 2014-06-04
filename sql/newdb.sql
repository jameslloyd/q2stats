SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `googleauth` (
  `handle` varchar(255) NOT NULL,
  `timestamp` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `timestamp` int(15) NOT NULL,
  `gamedate` int(15) NOT NULL,
  `map` varchar(255) NOT NULL,
  `action` varchar(50) NOT NULL,
  `who` varchar(50) NOT NULL,
  `target` varchar(50) NOT NULL,
  `weapon` varchar(50) NOT NULL,
  `ping` int(99) DEFAULT NULL,
  `server` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32987 ;
CREATE TABLE IF NOT EXISTS `map_totals` (
`count` bigint(21)
,`map` varchar(255)
,`action` varchar(50)
);
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `name` varchar(99) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
CREATE TABLE IF NOT EXISTS `player_summary` (
`player` varchar(50)
,`kills` bigint(21)
,`deaths` bigint(21)
,`Suicides` bigint(21)
,`ratio` decimal(23,4)
);
CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `name` varchar(99) NOT NULL,
  `kills` int(99) NOT NULL,
  `killsrank` int(99) NOT NULL,
  `deaths` int(99) NOT NULL,
  `deathsrank` int(99) NOT NULL,
  `suicides` int(99) NOT NULL,
  `suicidesrank` int(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=174 ;

CREATE TABLE IF NOT EXISTS `rounddetails` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `roundid` int(99) NOT NULL,
  `who` varchar(99) NOT NULL,
  `blaster` int(99) NOT NULL,
  `shotgun` int(99) NOT NULL,
  `supershotgun` int(99) NOT NULL,
  `machinegun` int(99) NOT NULL,
  `chaingun` int(99) NOT NULL,
  `grenadelauncher` int(99) NOT NULL,
  `rocketlauncher` int(99) NOT NULL,
  `hyperblaster` int(99) NOT NULL,
  `railgun` int(99) NOT NULL,
  `bfg10k` int(99) NOT NULL,
  `handgrenade` int(99) NOT NULL,
  `telefrag` int(99) NOT NULL,
  `grapplinghook` int(99) NOT NULL,
  `kills` int(99) NOT NULL,
  `deaths` int(99) NOT NULL,
  `suicides` int(99) NOT NULL,
  `killstreak` int(99) NOT NULL,
  `deathstreak` int(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2140 ;

CREATE TABLE IF NOT EXISTS `rounds` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `server` varchar(99) NOT NULL,
  `timestamp` int(99) NOT NULL,
  `map` varchar(99) NOT NULL,
  `winner` varchar(99) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=727 ;

CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `serverip` varchar(20) NOT NULL,
  `serverport` int(20) NOT NULL,
  `servername` varchar(99) NOT NULL,
  `description` varchar(255) NOT NULL,
  `owner` varchar(99) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;
CREATE TABLE IF NOT EXISTS `total_deaths` (
`deaths` bigint(21)
,`target` varchar(50)
);CREATE TABLE IF NOT EXISTS `total_deaths_server` (
`deaths` bigint(21)
,`target` varchar(50)
,`server` varchar(50)
);CREATE TABLE IF NOT EXISTS `total_kill` (
`Kills` bigint(21)
,`who` varchar(50)
);CREATE TABLE IF NOT EXISTS `total_kills_server` (
`kills` bigint(21)
,`who` varchar(50)
,`server` varchar(50)
);CREATE TABLE IF NOT EXISTS `total_suicides` (
`Suicides` bigint(21)
,`who` varchar(50)
);CREATE TABLE IF NOT EXISTS `total_suicides_server` (
`suicides` bigint(21)
,`who` varchar(50)
,`server` varchar(50)
);
CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `timestamp` varchar(255) NOT NULL,
  `lines` int(99) NOT NULL,
  `actions` int(99) NOT NULL,
  `processtime` varchar(99) NOT NULL,
  `inserted` int(99) NOT NULL,
  `skipped` int(99) NOT NULL,
  `server` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2991 ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `timestamp` int(99) NOT NULL,
  `email` varchar(50) NOT NULL,
  `googleusername` varchar(50) NOT NULL,
  `fname` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `level` int(10) NOT NULL DEFAULT '1',
  `group` varchar(255) NOT NULL,
  `nick` varchar(100) NOT NULL,
  `knownas` varchar(10) NOT NULL DEFAULT 'First Name',
  `status` varchar(10) NOT NULL DEFAULT 'enabled',
  `twitteraccesstoken` varchar(100) NOT NULL,
  `playername` varchar(255) DEFAULT NULL,
  `avatar` varchar(99) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;
CREATE TABLE IF NOT EXISTS `weapon_totals` (
`count` bigint(21)
,`action` varchar(50)
,`who` varchar(50)
,`weapon` varchar(50)
);DROP TABLE IF EXISTS `map_totals`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `map_totals` AS select count(`log`.`action`) AS `count`,`log`.`map` AS `map`,`log`.`action` AS `action` from `log` group by `log`.`map`,`log`.`action` order by `log`.`map`;
DROP TABLE IF EXISTS `player_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `player_summary` AS select `total_kill`.`who` AS `player`,`total_kill`.`Kills` AS `kills`,`total_deaths`.`deaths` AS `deaths`,`total_suicides`.`Suicides` AS `Suicides`,(`total_kill`.`Kills` / (`total_deaths`.`deaths` + `total_suicides`.`Suicides`)) AS `ratio` from ((`total_kill` left join `total_deaths` on((`total_kill`.`who` = `total_deaths`.`target`))) left join `total_suicides` on((`total_kill`.`who` = `total_suicides`.`who`)));
DROP TABLE IF EXISTS `total_deaths`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_deaths` AS select count(`log`.`action`) AS `deaths`,`log`.`target` AS `target` from `log` where (`log`.`action` = _latin1'kill') group by `log`.`target`;
DROP TABLE IF EXISTS `total_deaths_server`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_deaths_server` AS select count(`log`.`action`) AS `deaths`,`log`.`target` AS `target`,`log`.`server` AS `server` from `log` where (`log`.`action` = _latin1'kill') group by `log`.`target`,`log`.`server` order by `log`.`who` desc;
DROP TABLE IF EXISTS `total_kill`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_kill` AS select count(`log`.`action`) AS `Kills`,`log`.`who` AS `who` from `log` where (`log`.`action` = _latin1'Kill') group by `log`.`who`;
DROP TABLE IF EXISTS `total_kills_server`;

CREATE ALGORITHM=UNDEFINED DEFINER=`q2stats`@`%` SQL SECURITY DEFINER VIEW `total_kills_server` AS select count(`log`.`action`) AS `kills`,`log`.`who` AS `who`,`log`.`server` AS `server` from `log` where (`log`.`action` = _latin1'kill') group by `log`.`who`,`log`.`server` order by count(`log`.`action`) desc;
DROP TABLE IF EXISTS `total_suicides`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_suicides` AS select count(`log`.`action`) AS `Suicides`,`log`.`who` AS `who` from `log` where (`log`.`action` = _latin1'Suicide') group by `log`.`who`;
DROP TABLE IF EXISTS `total_suicides_server`;

CREATE ALGORITHM=UNDEFINED DEFINER=`q2stats`@`%` SQL SECURITY DEFINER VIEW `total_suicides_server` AS select count(`log`.`action`) AS `suicides`,`log`.`who` AS `who`,`log`.`server` AS `server` from `log` where (`log`.`action` = _latin1'suicide') group by `log`.`who` order by count(`log`.`action`) desc;
DROP TABLE IF EXISTS `weapon_totals`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `weapon_totals` AS select count(`log`.`action`) AS `count`,`log`.`action` AS `action`,`log`.`who` AS `who`,`log`.`weapon` AS `weapon` from `log` where (`log`.`action` = _latin1'kill') group by `log`.`who`,`log`.`action`,`log`.`weapon` order by `log`.`who`,count(`log`.`action`);
