DROP TABLE IF EXISTS `#__vkmachine_ld`;
DROP TABLE IF EXISTS `#__vkmachine_ht`;
DROP TABLE IF EXISTS `#__vkmachine_license`;
DROP TABLE IF EXISTS `#__vkmachine_cron`;

CREATE TABLE IF NOT EXISTS `#__vkmachine_added` (
  `id` int(11) DEFAULT NULL,
  `id_article` int(11) NOT NULL,
  `hashtag` varchar(255) NOT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__vkmachine_hts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hashtag` varchar(255) NOT NULL,
  `menutype` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `state` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__vkmachine_license` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `license` int(11) DEFAULT 0,
  `tempLicense` int(11) DEFAULT 0,
  `template` int(11) DEFAULT 0,
  `lastLaunch` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__vkmachine_crons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partOf` int(11) DEFAULT 1,
  `interval` int(11) DEFAULT 1,
  `hour` int(11) DEFAULT 0,
  `minute` int(11) DEFAULT 0,
  `state` int(11) DEFAULT 0,
  `php` varchar(255) DEFAULT '',
  `time` varchar(255) DEFAULT '',
  `path` varchar(255) DEFAULT '',
  `args` varchar(255) DEFAULT 'add.cron',
  `lastLaunch` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
);