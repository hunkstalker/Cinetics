USE `cineticsdb`;
ALTER TABLE `users`
MODIFY COLUMN `active` TINYINT(1) DEFAULT 0,
ADD `activationDate` DATETIME, 
ADD `activationCode` CHAR(64),
ADD `resetPassExpiry` DATETIME, 
ADD `resetPassCode` CHAR(64);