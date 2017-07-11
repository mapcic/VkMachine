CREATE TABLE IF NOT EXISTS `#__vkmachine_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL, 
  `pageId` varchar(255) DEFAULT '',
  `pageName` varchar(255) DEFAULT '',
  `type` int(11) DEFAULT 0,
  `beginCode` varchar(255) DEFAULT '',
  `endCode` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
);