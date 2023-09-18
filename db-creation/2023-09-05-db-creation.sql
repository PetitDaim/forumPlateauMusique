-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum_dv
CREATE DATABASE IF NOT EXISTS `forum_dv` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */;
USE `forum_dv`;

-- Listage de la structure de la table forum_dv. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` smallint(6) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `categoryNameSingulier` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `presentation` text COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.category : ~5 rows (environ)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id_category`, `categoryName`, `categoryNameSingulier`, `presentation`) VALUES
	(1, 'textes de chansons', 'un texte de chanson', 'Bonjour, dans cette catégorie vous pouvez voir tous les textes de chansons postés, y répondre et/ou poster tous les textes que vous avez écrits vous-même, de chansons dont vous êtes l\'auteur, le compositeur et l\'interprète'),
	(2, 'musiques de chansons', 'une musique de chanson', 'Bonjour, dans cette catégorie vous pouvez écouter toutes les chansons postées, y répondre et/ou poster toutes les musiques que vous avez enregistées vous-même, de chansons dont vous êtes l\'auteur, le compositeur et l\'interprète'),
	(3, 'partitions de chansons', 'une partition de chanson', 'Bonjour, dans cette catégorie vous pouvez voir tous les partitions de chansons postées, y répondre et/ou poster toutes les partitions de chansons que vous avez composées et écrites vous-même'),
	(4, 'vidéos de chansons', 'une vidéo de chanson', 'Bonjour, dans cette catégorie vous pouvez voir tous les vidéos de chansons postées, y répondre et/ou poster toutes les vidéos que vous avez filmées vous-même, de chansons dont vous êtes l\'auteur, le compositeur et l\'interprète'),
	(7, 'musiques instrumentales', 'une musique instrumentale', 'Bonjour, dans cette cat&eacute;gorie vous pouvez &eacute;couter toutes les musiques instrumentales post&eacute;es, y r&eacute;pondre et/ou poster toutes les musiques que vous avez enregistr&eacute;es vous-m&ecirc;me, de musiques instrumentales dont vous &ecirc;tes le compositeur et l&#039;interpr&egrave;te');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Listage de la structure de la table forum_dv. media
CREATE TABLE IF NOT EXISTS `media` (
  `id_media` int(11) NOT NULL AUTO_INCREMENT,
  `tinyMediaName` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `tinyMediaUrl` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `tinyMediaType` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `mediumMediaName` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `mediumMediaUrl` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `mediumMediaType` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `bigMediaName` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `bigMediaUrl` varchar(120) COLLATE utf8mb4_bin NOT NULL,
  `bigMediaType` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `mediaDescription` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `mediaSuppressed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_media`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.media : ~5 rows (environ)
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` (`id_media`, `tinyMediaName`, `tinyMediaUrl`, `tinyMediaType`, `mediumMediaName`, `mediumMediaUrl`, `mediumMediaType`, `bigMediaName`, `bigMediaUrl`, `bigMediaType`, `mediaDescription`, `mediaSuppressed`) VALUES
	(1, './img/1-mini.jpg', './img/1-mini.jpg', 'image/jpeg', './img/1-medium.jpg', './img/1-medium.jpg', 'image/jpeg', './img/1-big.jpg', './img/1-big.jpg', 'image/jpeg', 'Texte chanson : Jeux-Paralympiques', 0),
	(2, './audio/2-mini.mp3', './audio/2-mini.mp3', 'audio/mpeg', './audio/2-medium.mp3', './audio/2-medium.mp3', 'audio/mpeg', './audio/2-big.mp3', './audio/2-big.mp3', 'audio/mpeg', 'Chanson : Jeux-Paralympiques', 0),
	(3, './video/3-mini.mp4', './video/3-mini.mp4', 'video/mp4', './video/3-medium.mp4', './video/3-medium.mp4', 'video/mp4', './video/3-big.mp4', './video/3-big.mp4', 'video/mp4', 'Vidéo N°3', 0),
	(4, './pdf/4-mini.jpg', './pdf/4-mini.jpg', 'image/jpeg', './pdf/4-medium.jpg', './pdf/4-medium.jpg', 'image/jpeg', './pdf/4-big.pdf', './pdf/4-big.pdf', 'app/pdf', 'Partition : Jeux-Paralympiques', 0),
	(10, '2023-08-14-tiny-LeBrame.mp3', './audio/64f60958755ad.mpeg', 'audio/mpeg', '2023-08-14-médium-LeBrame.mp3', './audio/64f6095875f46.mpeg', 'audio/mpeg', '2023-08-14-LeBrame.mp3', './audio/64f6095876fa4.mpeg', 'audio/mpeg', 'chanson : Le brame', 0);
/*!40000 ALTER TABLE `media` ENABLE KEYS */;

-- Listage de la structure de la table forum_dv. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_bin NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_post`),
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.post : ~3 rows (environ)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` (`id_post`, `user_id`, `topic_id`, `message`, `creationDate`) VALUES
	(1, 1, 2, 'Bravo ! C\'est super !', '2023-09-04 12:41:31'),
	(2, 2, 2, 'Améliorez l\'enregistrement de la voix et ce sera extra !', '2023-09-04 12:42:14'),
	(3, 1, 12, 'Bonjour,\r\nMerci de me dire ce que vous pensez de cette chanson.\r\nEt si le c&oelig;ur vous en dit :\r\nPourquoi ne pas partager ce lien.\r\nOu m&ecirc;me acheter la version compl&egrave;te de cette chanson pour pouvoir l&#039;&eacute;couter tout &agrave; loisir.', '2023-09-04 18:51:24');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

-- Listage de la structure de la table forum_dv. postlike
CREATE TABLE IF NOT EXISTS `postlike` (
  `post_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `likeDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`,`user_id`),
  KEY `FK_postlike_user` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `FK_postlike_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id_post`),
  CONSTRAINT `FK_postlike_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.postlike : ~0 rows (environ)
/*!40000 ALTER TABLE `postlike` DISABLE KEYS */;
/*!40000 ALTER TABLE `postlike` ENABLE KEYS */;

-- Listage de la structure de la table forum_dv. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` smallint(6) NOT NULL,
  `media_id` int(11) NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_topic`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`),
  KEY `picture_id` (`media_id`) USING BTREE,
  CONSTRAINT `FK_topic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_topic_media` FOREIGN KEY (`media_id`) REFERENCES `media` (`id_media`),
  CONSTRAINT `FK_topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.topic : ~5 rows (environ)
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` (`id_topic`, `title`, `user_id`, `category_id`, `media_id`, `creationDate`, `closed`) VALUES
	(1, 'Texte chanson Jeux-Paralympiques', 1, 1, 1, '2023-08-30 22:59:44', 0),
	(2, 'Musique chanson Jeux-Paralympiques', 1, 2, 2, '2023-08-30 23:01:38', 0),
	(3, 'Partition chanson Jeux-Paralympiques', 1, 3, 4, '2023-08-30 23:02:27', 0),
	(4, 'Vidéo chanson n°1', 1, 4, 3, '2023-08-30 23:03:32', 0),
	(12, 'Chanson : Le brame', 1, 2, 10, '2023-09-04 18:51:24', 0);
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;

-- Listage de la structure de la table forum_dv. topiclike
CREATE TABLE IF NOT EXISTS `topiclike` (
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `likeDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`topic_id`,`user_id`),
  KEY `FK_topiclike_user` (`user_id`),
  KEY `topic_id` (`topic_id`),
  CONSTRAINT `FK_topiclike_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_topiclike_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.topiclike : ~0 rows (environ)
/*!40000 ALTER TABLE `topiclike` DISABLE KEYS */;
/*!40000 ALTER TABLE `topiclike` ENABLE KEYS */;

-- Listage de la structure de la table forum_dv. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `registrationDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `banned` tinyint(4) NOT NULL DEFAULT '0',
  `role` json DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Listage des données de la table forum_dv.user : ~2 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `pseudo`, `password`, `email`, `registrationDate`, `banned`, `role`) VALUES
	(1, 'test', 'test', 'test@test.fr', '2023-08-30 16:27:15', 0, '["ROLE_USER"]'),
	(2, 'test2', 'test2', 'test2@test.fr', '2023-08-30 16:42:14', 0, '["ROLE_USER"]'),
	(12, 'PetitDaim', '$2y$10$k1fUN9p1Uis.ncMExRd/2e3YYjJI/ops7UzM94oKPi3M8PZDWUOsy', 'villaumedenis@wanadoo.fr', '2023-09-05 11:51:33', 0, '["ROLE_USER"]');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
