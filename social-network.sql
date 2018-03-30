-- --------------------------------------------------------
-- Hostitel:                     127.0.0.1
-- Verze serveru:                10.1.30-MariaDB - mariadb.org binary distribution
-- OS serveru:                   Win32
-- HeidiSQL Verze:               9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Exportování struktury databáze pro
CREATE DATABASE IF NOT EXISTS `social-network` /*!40100 DEFAULT CHARACTER SET utf32 COLLATE utf32_czech_ci */;
USE `social-network`;

-- Exportování struktury pro tabulka social-network.friends
CREATE TABLE IF NOT EXISTS `friends` (
  `user_id` int(11) DEFAULT NULL,
  `friend_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_czech_ci;

-- Exportování dat pro tabulku social-network.friends: ~4 rows (přibližně)
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` (`user_id`, `friend_id`) VALUES
	(1, 2),
	(2, 1),
	(3, 1),
	(3, 2);
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;

-- Exportování struktury pro tabulka social-network.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf32_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_czech_ci;

-- Exportování dat pro tabulku social-network.groups: ~0 rows (přibližně)
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;

-- Exportování struktury pro tabulka social-network.likes
CREATE TABLE IF NOT EXISTS `likes` (
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_czech_ci;

-- Exportování dat pro tabulku social-network.likes: ~2 rows (přibližně)
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` (`user_id`, `post_id`) VALUES
	(2, 2),
	(1, 1);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;

-- Exportování struktury pro tabulka social-network.membership
CREATE TABLE IF NOT EXISTS `membership` (
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_czech_ci;

-- Exportování dat pro tabulku social-network.membership: ~0 rows (přibližně)
/*!40000 ALTER TABLE `membership` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership` ENABLE KEYS */;

-- Exportování struktury pro tabulka social-network.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `content` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `shared_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf32 COLLATE=utf32_czech_ci;

-- Exportování dat pro tabulku social-network.posts: ~4 rows (přibližně)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `user_id`, `created`, `content`, `shared_by`) VALUES
	(1, 2, '2018-03-24 22:31:50', 'Můj první příspěvek', NULL),
	(2, 1, '2018-03-25 11:14:19', 'První příspěvek uživatele Jiří Pochop', NULL),
	(4, 1, '2018-03-25 16:18:48', 'Druhý příspěvek', NULL),
	(5, 3, '2018-03-30 14:43:16', 'Čau', NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Exportování struktury pro tabulka social-network.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `forename` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `surname` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `header_pic` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `profile_pic` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Exportování dat pro tabulku social-network.users: ~3 rows (přibližně)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `forename`, `surname`, `password`, `header_pic`, `profile_pic`) VALUES
	(1, 'jiri.pochop01@gmail.com', 'Jiří', 'Pochop', '$2y$10$fcUTO20ZeWMix2xsGuKwJONa5BVRNbYIljMUUa4GIIp', 'default-header.jpg', 'default-picture.jpg'),
	(2, 'admin@admin.cz', 'Ad', 'Min', '$2y$10$XD9zMRAHC9OOePBQ29TjQODCnazm0j/bNEP1hJLqI0k', 'default-header.jpg', 'default-picture.jpg'),
	(3, 'pepazdepa@email.cz', 'Pepa', 'z Depa', '$2y$10$firiLOxpGp3GtTCA1oFAge1mgsMJ/kKsjty2/JNjs9k', 'pepazdepa@email.czh.jpg', 'pepazdepa@email.czp.jpg');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
