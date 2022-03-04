USE cineticsdb;
INSERT INTO `users` (mail,username,passHash) VALUES ("cinetics@cinetics.com", "cinetic", "$2y$10$190FEE5F112C73739155671F44A4CCF6462CAD9B09CA1DF5BE9295432B547054");
INSERT INTO `videos` (description,fileName,iduser) VALUES ('Welcome to Cinetics community!', "welcomecinetics.webm", 1);
INSERT INTO `hashtags` (tag) VALUES ("welcome");
INSERT INTO `hashtags` (tag) VALUES ("cinetics");
INSERT INTO `videohashtags` VALUES (1, 1);
INSERT INTO `videohashtags` VALUES (1, 2);