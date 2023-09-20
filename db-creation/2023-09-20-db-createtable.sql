-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum_dv
CREATE DATABASE IF NOT EXISTS `forum_dv` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum_dv`;

-- Listage de la structure de table forum_dv. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` smallint NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `categoryNameSingulier` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `presentation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_category`),
  UNIQUE KEY `categoryName` (`categoryName`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.category : ~7 rows (environ)
INSERT INTO `category` (`id_category`, `categoryName`, `categoryNameSingulier`, `presentation`) VALUES
	(1, 'textes de chansons', 'un texte de chanson', 'Bonjour, dans cette catégorie vous pouvez voir tous les textes de chansons postés, Et si vous êtes connecté, y répondre et/ou poster tous les textes que vous avez écrits vous-même, de chansons dont vous êtes l\'auteur, le compositeur et l\'interprète'),
	(2, 'musiques de chansons', 'une musique de chanson', 'Bonjour, dans cette catégorie vous pouvez écouter toutes les chansons postées, Et si vous êtes connecté, y répondre et/ou poster toutes les musiques que vous avez enregistées vous-même, de chansons dont vous êtes l\'auteur, le compositeur et l\'interprète'),
	(3, 'partitions de chansons', 'une partition de chanson', 'Bonjour, dans cette catégorie vous pouvez voir tous les partitions de chansons postées, Et si vous êtes connecté, y répondre et/ou poster toutes les partitions de chansons que vous avez composées et écrites vous-même'),
	(4, 'vidéos de chansons', 'une vidéo de chanson', 'Bonjour, dans cette catégorie vous pouvez voir tous les vidéos de chansons postées, Et si vous êtes connecté, y répondre et/ou poster toutes les vidéos que vous avez filmées vous-même, de chansons dont vous êtes l\'auteur, le compositeur et l\'interprète'),
	(7, 'musiques instrumentales', 'une musique instrumentale', 'Bonjour, dans cette cat&eacute;gorie vous pouvez &eacute;couter toutes les musiques instrumentales post&eacute;es, Et si vous êtes connecté, y r&eacute;pondre et/ou poster toutes les musiques que vous avez enregistr&eacute;es vous-m&ecirc;me, de musiques instrumentales dont vous &ecirc;tes le compositeur et l&#039;interpr&egrave;te'),
	(8, 'partitions de musiques instrumentales', 'une partition de musique instrumentale', 'Bonjour, dans cette cat&eacute;gorie vous pouvez trouver toutes les partitions de musiques instrumentales post&eacute;es, Et si vous êtes connecté, y r&eacute;pondre et/ou poster toutes les partitions de musiques que vous avez &eacute;crites vous-m&ecirc;me, de musiques instrumentales dont vous &ecirc;tes le compositeur'),
	(25, 'vid&eacute;os de musiques instrumentales', 'une vid&eacute;o de musique instrumentale', 'Bonjour, dans cette cat&eacute;gorie vous pouvez voir tous les concerts de musiques instrumentales post&eacute;es, Et si vous êtes connecté, y r&eacute;pondre et/ou poster toutes les vud&eacute;os que vous avez tourn&eacute;es vous-m&ecirc;me, de musiques instrumentales dont vous &ecirc;tes le compositeur et l&#039;interpr&egrave;te');

-- Listage de la structure de table forum_dv. media
CREATE TABLE IF NOT EXISTS `media` (
  `id_media` int NOT NULL AUTO_INCREMENT,
  `tinyMediaName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tinyMediaUrl` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tinyMediaType` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `mediumMediaName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `mediumMediaUrl` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `mediumMediaType` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `bigMediaName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `bigMediaUrl` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `bigMediaType` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `mediaDescription` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `mediaSuppressed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_media`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.media : ~6 rows (environ)
INSERT INTO `media` (`id_media`, `tinyMediaName`, `tinyMediaUrl`, `tinyMediaType`, `mediumMediaName`, `mediumMediaUrl`, `mediumMediaType`, `bigMediaName`, `bigMediaUrl`, `bigMediaType`, `mediaDescription`, `mediaSuppressed`) VALUES
	(1, './img/1-mini.jpg', './img/1-mini.jpg', 'image/jpeg', './img/1-medium.jpg', './img/1-medium.jpg', 'image/jpeg', './img/1-big.jpg', './img/1-big.jpg', 'image/jpeg', 'Texte chanson : Jeux-Paralympiques', 0),
	(2, './audio/2-mini.mp3', './audio/2-mini.mp3', 'audio/mpeg', './audio/2-medium.mp3', './audio/2-medium.mp3', 'audio/mpeg', './audio/2-big.mp3', './audio/2-big.mp3', 'audio/mpeg', 'Chanson : Jeux-Paralympiques', 0),
	(3, './video/3-mini.mp4', './video/3-mini.mp4', 'video/mp4', './video/3-medium.mp4', './video/3-medium.mp4', 'video/mp4', './video/3-big.mp4', './video/3-big.mp4', 'video/mp4', 'Vidéo N°3', 0),
	(4, './pdf/4-mini.jpg', './pdf/4-mini.jpg', 'image/jpeg', './pdf/4-medium.jpg', './pdf/4-medium.jpg', 'image/jpeg', './pdf/4-big.pdf', './pdf/4-big.pdf', 'app/pdf', 'Partition : Jeux-Paralympiques', 0),
	(10, '2023-08-14-tiny-LeBrame.mp3', './audio/64f60958755ad.mpeg', 'audio/mpeg', '2023-08-14-médium-LeBrame.mp3', './audio/64f6095875f46.mpeg', 'audio/mpeg', '2023-08-14-LeBrame.mp3', './audio/64f6095876fa4.mpeg', 'audio/mpeg', 'chanson : Le brame', 0),
	(11, '1-mini.jpg', './img/64fec9c151727.jpeg', 'image/jpeg', '1-medium.jpg', './img/64fec9c15d47a.jpeg', 'image/jpeg', '1-big.jpg', './img/64fec9c15dd4c.jpeg', 'image/jpeg', 'test', 0);

-- Listage de la structure de table forum_dv. message
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `object` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `message` varchar(255) NOT NULL DEFAULT '',
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_message`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_dv.message : ~0 rows (environ)

-- Listage de la structure de table forum_dv. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` bigint NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `topic_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_post`),
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.post : ~19 rows (environ)
INSERT INTO `post` (`id_post`, `user_id`, `topic_id`, `message`, `creationDate`) VALUES
	(1, 16, 2, 'Bravo ! C\'est super !', '2023-09-04 12:41:31'),
	(2, 18, 2, 'Améliorez l\'enregistrement de la voix et ce sera extra !', '2023-09-04 12:42:14'),
	(3, 12, 12, 'Bonjour,\r\nMerci de me dire ce que vous pensez de cette chanson.\r\nEt si le c&oelig;ur vous en dit :\r\nPourquoi ne pas partager ce lien.\r\nOu m&ecirc;me acheter la version compl&egrave;te de cette chanson pour pouvoir l&#039;&eacute;couter tout &agrave; loisir.', '2023-09-04 18:51:24'),
	(4, 12, 2, 'Bonjour, Merci de me dire ce que vous pensez de cette chanson. Et si le c&oelig;ur vous en dit : Pourquoi ne pas partager ce lien. Ou m&ecirc;me acheter la version compl&egrave;te de cette chanson pour pouvoir l&#039;&eacute;couter tout &agrave; loisir.', '2023-09-03 23:52:26'),
	(5, 12, 2, 'Merci pour les commentaires, c&#039;est tr&egrave;s encourageant.', '2023-09-06 12:06:30'),
	(6, 14, 12, 'Un message sale !', '2023-09-07 10:23:48'),
	(7, 14, 12, 'Un autre message sale !', '2023-09-07 11:32:40'),
	(8, 14, 12, 'Un autre message sale !', '2023-09-07 11:32:49'),
	(9, 16, 12, 'Je vous encourage &agrave; continuer, c&#039;est tr&egrave;s bien', '2023-09-07 18:50:28'),
	(10, 18, 12, 'Quelques petits d&eacute;tails dans la voix, sinon, c&#039;est bien', '2023-09-07 21:30:38'),
	(11, 12, 3, 'Bonjour, Merci de me dire ce que vous pensez de cette partition. Et si le c&oelig;ur vous en dit : Pourquoi ne pas partager ce lien. Ou m&ecirc;me acheter la version compl&egrave;te de cette partition pour pouvoir la jouer tout &agrave; loisir.', '2023-09-08 10:34:23'),
	(12, 12, 1, 'Bonjour, Merci de me dire ce que vous pensez de ce texte. Et si le c&oelig;ur vous en dit : Pourquoi ne pas partager ce lien. Ou m&ecirc;me acheter la version compl&egrave;te de ce texte pour pouvoir la chanter tout &agrave; loisir.', '2023-09-08 10:44:33'),
	(13, 12, 4, 'Bonjour, Merci de me dire ce que vous pensez de cette vid&eacute;o de chanson. Et si le c&oelig;ur vous en dit : Pourquoi ne pas partager ce lien. Ou m&ecirc;me acheter la version compl&egrave;te de cette vid&eacute;o de chanson pour pouvoir la regarder tout &agrave; loisir.', '2023-09-08 11:31:18'),
	(14, 13, 4, 'Int&eacute;ressant... Je crois qu&#039;il manque un couplet ou bien ?', '2023-09-08 11:34:01'),
	(18, 12, 12, 'Merci pour ces gentils messages, cela m&#039;encourrage &agrave; pers&eacute;v&eacute;rer.', '2023-09-11 20:41:23'),
	(19, 19, 3, 'C&#039;est une tr&egrave;s bonne id&eacute;e de mettre les partitions, c&#039;est juste dommage que la partition compl&egrave;te soit payante !', '2023-09-11 21:07:41'),
	(20, 14, 2, 'Message tr&egrave;s tr&egrave;s sale !', '2023-09-18 14:21:04'),
	(21, 14, 2, 'Message vraiment tr&egrave;s sale', '2023-09-18 14:22:25'),
	(22, 13, 1, 'Joli texte ma fois, tout &agrave; fait dans le th&egrave;me !', '2023-09-18 14:40:26');

-- Listage de la structure de table forum_dv. postlike
CREATE TABLE IF NOT EXISTS `postlike` (
  `id_postlike` bigint NOT NULL AUTO_INCREMENT,
  `post_id` bigint NOT NULL,
  `user_id` int NOT NULL,
  `likeDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_postlike`),
  UNIQUE KEY `post_id_user_id` (`post_id`,`user_id`),
  KEY `FK_postlike_user` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `FK_postlike_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id_post`),
  CONSTRAINT `FK_postlike_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.postlike : ~17 rows (environ)
INSERT INTO `postlike` (`id_postlike`, `post_id`, `user_id`, `likeDate`) VALUES
	(13, 1, 15, '2023-09-07 18:06:15'),
	(14, 5, 15, '2023-09-07 18:06:20'),
	(15, 5, 16, '2023-09-07 18:49:14'),
	(16, 1, 12, '2023-09-07 22:04:40'),
	(17, 2, 12, '2023-09-07 22:04:41'),
	(18, 5, 13, '2023-09-07 22:05:59'),
	(23, 14, 12, '2023-09-08 11:35:01'),
	(24, 9, 12, '2023-09-08 11:36:08'),
	(25, 10, 12, '2023-09-08 11:36:12'),
	(28, 1, 13, '2023-09-09 14:44:03'),
	(30, 9, 13, '2023-09-11 12:00:44'),
	(35, 9, 14, '2023-09-11 20:22:56'),
	(37, 18, 16, '2023-09-12 18:30:57'),
	(47, 5, 14, '2023-09-18 14:12:00'),
	(48, 20, 14, '2023-09-18 14:21:42'),
	(49, 21, 14, '2023-09-18 14:22:31'),
	(50, 18, 13, '2023-09-19 10:03:49'),
	(51, 10, 13, '2023-09-19 14:25:35'),
	(52, 19, 13, '2023-09-19 14:28:22');

-- Listage de la structure de table forum_dv. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_id` int NOT NULL,
  `category_id` smallint NOT NULL,
  `media_id` int NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_topic`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`),
  KEY `picture_id` (`media_id`) USING BTREE,
  CONSTRAINT `FK_topic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_topic_media` FOREIGN KEY (`media_id`) REFERENCES `media` (`id_media`),
  CONSTRAINT `FK_topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.topic : ~5 rows (environ)
INSERT INTO `topic` (`id_topic`, `title`, `user_id`, `category_id`, `media_id`, `creationDate`, `closed`) VALUES
	(1, 'Texte chanson Jeux-Paralympiques', 12, 1, 1, '2023-08-30 22:59:44', 0),
	(2, 'Chanson : Jeux-Paralympiques', 12, 2, 2, '2023-08-30 23:01:38', 0),
	(3, 'Partition chanson Jeux-Paralympiques', 12, 3, 4, '2023-08-30 23:02:27', 0),
	(4, 'Vidéo chanson : La promenade', 12, 4, 3, '2023-08-30 23:03:32', 0),
	(12, 'Chanson : Le brame', 12, 2, 10, '2023-09-04 18:51:24', 0);

-- Listage de la structure de table forum_dv. topiclike
CREATE TABLE IF NOT EXISTS `topiclike` (
  `id_topiclike` bigint NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `user_id` int NOT NULL,
  `likeDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_topiclike`),
  UNIQUE KEY `topic_id_user_id` (`topic_id`,`user_id`),
  KEY `FK_topiclike_user` (`user_id`),
  KEY `topic_id` (`topic_id`),
  CONSTRAINT `FK_topiclike_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_topiclike_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.topiclike : ~14 rows (environ)
INSERT INTO `topiclike` (`id_topiclike`, `topic_id`, `user_id`, `likeDate`) VALUES
	(12, 2, 13, '2023-09-07 18:00:27'),
	(14, 2, 15, '2023-09-07 18:06:25'),
	(28, 12, 16, '2023-09-07 18:49:59'),
	(29, 12, 18, '2023-09-07 21:29:41'),
	(30, 2, 12, '2023-09-07 22:04:37'),
	(36, 3, 13, '2023-09-08 10:37:12'),
	(37, 12, 13, '2023-09-08 10:40:09'),
	(38, 4, 12, '2023-09-08 11:34:58'),
	(39, 12, 12, '2023-09-08 11:35:58'),
	(40, 3, 12, '2023-09-08 11:37:27'),
	(41, 1, 12, '2023-09-08 11:37:54'),
	(43, 2, 16, '2023-09-08 14:24:13'),
	(46, 12, 14, '2023-09-11 20:22:08'),
	(47, 3, 19, '2023-09-11 21:08:02');

-- Listage de la structure de table forum_dv. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT './img/Users/undefinedUserImg.jpg',
  `registrationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `banned` tinyint NOT NULL DEFAULT '0',
  `role` json NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.user : ~10 rows (environ)
INSERT INTO `user` (`id_user`, `pseudo`, `password`, `email`, `avatar`, `registrationDate`, `banned`, `role`) VALUES
	(12, 'Denis Balades', '$2y$10$k1fUN9p1Uis.ncMExRd/2e3YYjJI/ops7UzM94oKPi3M8PZDWUOsy', 'villaumedenis@wanadoo.fr', './img/Users/12.jpg', '2023-09-05 11:51:33', 0, '["ROLE_USER", "ROLE_ARTIST"]'),
	(13, 'PetitDaim', '$2y$10$D80nUYz0Fm9QTAWm2v3vGuaSdDs/9LnGZQPbsQGYiu0D.RUijXZdi', 'de.villaume@v-e-r-t-e.com', './img/Users/13.jpg', '2023-09-06 13:28:35', 0, '["ROLE_USER", "ROLE_ADMIN"]'),
	(14, 'MustBeBanned', '$2y$10$OxLrZaG5E5kic525W7AuQeDDoh142yQ5aosdjev46K6F4aprpfDw.', 'test@test.com', './img/Users/undefinedUserImg.jpg', '2023-09-07 10:22:30', 1, '["ROLE_USER"]'),
	(15, 'Denis', '$2y$10$GlbqjYZ0hkXd0SNjiXkE9.yicWYE0UYxQXnfpbsnMjYen6Mu.0lvS', 'dv@wanadoo.fr', './img/Users/15.jpg', '2023-09-07 13:48:31', 0, '["ROLE_USER"]'),
	(16, 'Gentil', '$2y$10$UWFyB2Q3z6a.8swl7bZiJOMvzbVY3nQaWBEoE6K07g9E2vnybYyta', 'gentil@wanadoo.fr', './img/Users/16.jpg', '2023-09-07 18:44:13', 0, '["ROLE_USER"]'),
	(18, 'Pr&eacute;venant', '$2y$10$5a1nRNzEwMIh8SNwQsd5.ebX1ewee67IAlVJ0kFuzIhIRfiu8otKq', 'prevenant@wanadoo.fr', './img/Users/18.jpg', '2023-09-07 18:45:25', 0, '["ROLE_USER"]'),
	(19, 'Musicien', '$2y$10$yRU1CgCfnZSvb0ooO4yUNe1ljHuP4W32jTAW5qyktjdXlQMysIapC', 'musicien@wanadoo.fr', './img/Users/undefinedUserImg.jpg', '2023-09-11 21:05:51', 0, '["ROLE_USER"]'),
	(20, 'Chanteur', '$2y$10$3iAk72pQNI1FMAWcrtICh.vckKVVAkhBX5Yos104qB.utGTUAjEki', 'chanteur@test.com', './img/Users/undefinedUserImg.jpg', '2023-09-12 14:55:02', 0, '["ROLE_USER"]'),
	(21, 'test1', '$2y$10$GDtEkyOaCPfJXHzkiyejteAZpIryBUwkS3pg.vp/9kDiU/U0qn1E.', 'test1@test.com', './img/Users/undefinedUserImg.jpg', '2023-09-12 17:37:14', 0, '["ROLE_USER"]'),
	(22, 'test2', '$2y$10$qCH8zcfIVTb1Dj12hvtYdubK.LUCtN90R/qbPPPxH9eTf.V01opWG', 'test2@test.com', './img/Users/undefinedUserImg.jpg', '2023-09-12 17:40:03', 0, '["ROLE_USER"]');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
