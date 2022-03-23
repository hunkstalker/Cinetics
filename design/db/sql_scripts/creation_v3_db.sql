DROP DATABASE IF EXISTS `cineticsdb`;
CREATE DATABASE IF NOT EXISTS `cineticsdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE `cineticsdb`;

CREATE TABLE IF NOT EXISTS `users`(
    `iduser` INT AUTO_INCREMENT NOT NULL,
    `mail` VARCHAR(40) UNIQUE NOT NULL,
    `username` VARCHAR(16) UNIQUE NOT NULL,
    `passHash` VARCHAR(60) NOT NULL,
    `userFirstName` VARCHAR(60),
    `userLastName` VARCHAR(120),
    `creationDate` DATETIME DEFAULT NOW(),
    `removeDate` DATETIME,
    `lastSignIn` DATETIME,
    `active` TINYINT(1) DEFAULT 0,
    `activationDate` DATETIME, 
    `activationCode` CHAR(64),
    `resetPassExpiry` DATETIME, 
    `resetPassCode` CHAR(64),
    PRIMARY KEY(`iduser`)
);

CREATE TABLE IF NOT EXISTS `videos`
(
  `idvideo` INT AUTO_INCREMENT NOT NULL,
  `description` VARCHAR(120) NOT NULL,
  `publicationDate` DATETIME DEFAULT NOW(),
  `likes` INT DEFAULT 0,
  `dislikes` INT DEFAULT 0,
  `fileName` CHAR(100) NOT NULL,
  `iduser` INT NOT NULL,
  PRIMARY KEY (`idvideo`),
  FOREIGN KEY (`iduser`) REFERENCES `users`(`iduser`)
);

CREATE TABLE IF NOT EXISTS `hashtags`
(
  `idhashtag` INT AUTO_INCREMENT NOT NULL,
  `tag` VARCHAR(30) NOT NULL UNIQUE,
  PRIMARY KEY (`idhashtag`)
);

CREATE TABLE IF NOT EXISTS `videohashtags`
(
  `idvideo` INT NOT NULL,
  `idhashtag` INT NOT NULL,
  PRIMARY KEY (`idvideo`, `idhashtag`),
  FOREIGN KEY (`idvideo`) REFERENCES `videos`(`idvideo`),
  FOREIGN KEY (`idhashtag`) REFERENCES `hashtags`(`idhashtag`)
);

CREATE TABLE IF NOT EXISTS `userreactions`
(
  `idvideo` INT NOT NULL,
  `iduser` INT NOT NULL,
  `reaction` TINYINT(1),
  PRIMARY KEY (`idvideo`, `iduser`),
  FOREIGN KEY (`idvideo`) REFERENCES `videos`(`idvideo`),
  FOREIGN KEY (`iduser`) REFERENCES `users`(`iduser`)
);