DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(63) NOT NULL,
  `username` varchar(63) NOT NULL,
  `password` char(40) NOT NULL,
  `first_name` varchar(63) NOT NULL,
  `last_name` varchar(31) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `candidates`;
CREATE TABLE IF NOT EXISTS `candidates` (
  `id` int(11) NOT NULL auto_increment,
  `first_name` varchar(63) NOT NULL,
  `last_name` varchar(31) NOT NULL,
  `party_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `description` text,
  `picture` char(40) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `parties`;
CREATE TABLE IF NOT EXISTS `parties` (
  `id` int(11) NOT NULL auto_increment,
  `party` varchar(63) NOT NULL,
  `description` text,
  `logo` char(40) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `positions`;
CREATE TABLE IF NOT EXISTS `positions` (
  `id` int(11) NOT NULL auto_increment,
  `position` varchar(63) NOT NULL,
  `description` text,
  `maximum` smallint(6) NOT NULL,
  `ordinality` smallint(6) NOT NULL,
  `abstain` tinyint(1) NOT NULL,
  `unit` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `positions_voters`;
CREATE TABLE IF NOT EXISTS `positions_voters` (
  `position_id` int(11) NOT NULL,
  `voter_id` int(11) NOT NULL,
  PRIMARY KEY  (`position_id`,`voter_id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `voters`;
CREATE TABLE IF NOT EXISTS `voters` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(63) NOT NULL,
  `password` char(40) NOT NULL,
  `pin` char(40) NOT NULL,
  `first_name` varchar(63) NOT NULL,
  `last_name` varchar(31) NOT NULL,
  `voted` tinyint(1) NOT NULL,
  `login` datetime NOT NULL,
  `logout` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `candidate_id` int(11) NOT NULL,
  `voter_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY  (`candidate_id`,`voter_id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `result` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

INSERT INTO `options` (`id`, `status`, `result`) VALUES (1, 0, 0);