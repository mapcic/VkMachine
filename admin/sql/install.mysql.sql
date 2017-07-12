CREATE TABLE IF NOT EXISTS `#__vkmachine_added` (
  `id` int(11) NOT NULL,
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

CREATE TABLE IF NOT EXISTS `#__vkmachine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastLaunch` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `#__vkmachine_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL, 
  `pageId` varchar(255) DEFAULT '',
  `pageName` varchar(255) DEFAULT '',
  `skey` varchar(255) DEFAULT '',
  `type` int(11) DEFAULT 0,
  `beginCode` varchar(255) DEFAULT '',
  `endCode` varchar(255) DEFAULT '',
  `lang` varchar(255) DEFAULT '*',
  PRIMARY KEY (`id`)
);
