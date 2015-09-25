ALTER TABLE `simplenewsletter_subscriptions` 
ADD COLUMN `channel` INT(1) NOT NULL DEFAULT '1' AFTER `name`,
ADD COLUMN `cellphone` VARCHAR(20) NOT NULL DEFAULT '' AFTER `email`,
ADD INDEX `InPhone` (`cellphone` ASC),
DROP INDEX `UEmail`;