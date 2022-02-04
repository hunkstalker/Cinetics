USE `cineticsdb`;

CREATE TABLE IF NOT EXISTS `videos`
(
  `idvideo` INT AUTO_INCREMENT NOT NULL,
  `description` VARCHAR(120) NOT NULL,
  `publicationDate` DATETIME DEFAULT NOW(),
  `likes` INT DEFAULT 0,
  `dislikes` INT DEFAULT 0,
  `score` INT DEFAULT 0,
  `fileName` CHAR(64) NOT NULL,
  `iduser` INT NOT NULL,
  PRIMARY KEY (`idvideo`),
  FOREIGN KEY (`iduser`) REFERENCES `users`(`iduser`)
);

CREATE TABLE IF NOT EXISTS `hashtags`
(
  `idhashtag` INT AUTO_INCREMENT NOT NULL,
  `tag` VARCHAR(30) NOT NULL,
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