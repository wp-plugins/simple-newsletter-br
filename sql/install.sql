CREATE TABLE IF NOT EXISTS `simplenewsletter_subscriptions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(50) DEFAULT NULL,
	`channel` int(11) NOT NULL DEFAULT '0',
	`email` varchar(100) NOT NULL DEFAULT '',
	`cellphone` varchar(20) NOT NULL DEFAULT '',
	`hash` varchar(32) NOT NULL DEFAULT '',
	`confirmed` int(1) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `IEmail` (`email`),
	KEY `InPhone` (`cellphone`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;