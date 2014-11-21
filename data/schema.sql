CREATE TABLE `mailQueue` (
  `qId` bigint(20) NOT NULL AUTO_INCREMENT,
  `prio` tinyint(1) NOT NULL DEFAULT '1',
  `send` tinyint(1) NOT NULL DEFAULT '0',
  `recipientName` varchar(100) DEFAULT NULL,
  `recipientEmail` varchar(100) NOT NULL,
  `senderName` varchar(100) DEFAULT NULL,
  `senderEmail` varchar(100) NOT NULL,
  `createDate` datetime NOT NULL,
  `sendDate` datetime DEFAULT NULL,
  `subject` varchar(100) NOT NULL,
  `bodyHTML` mediumtext,
  `bodyText` mediumtext,
  `error` text,
  PRIMARY KEY (`qId`),
  KEY `send` (`send`),
  KEY `prio` (`prio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPRESSED;