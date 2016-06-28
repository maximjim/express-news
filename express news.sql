-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `post` int(11) NOT NULL,
  `author` int(11) NOT NULL DEFAULT '1',
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post` (`post`),
  KEY `author` (`author`),
  CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_ibfk_4` FOREIGN KEY (`author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `comment` (`id`, `content`, `post`, `author`, `time`) VALUES
(1,	'да, это серьезно',	1,	1,	'2016-06-28 22:03:27'),
(2,	'а вот это еще нужно проверить',	1,	1,	'2016-06-28 22:03:46');

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `author` int(11) NOT NULL DEFAULT '1',
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `region` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `isVisible` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `region` (`region`),
  KEY `author` (`author`),
  CONSTRAINT `post_ibfk_6` FOREIGN KEY (`region`) REFERENCES `region` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_ibfk_7` FOREIGN KEY (`author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `post` (`id`, `name`, `content`, `author`, `image`, `region`, `created`, `isVisible`) VALUES
(1,	'Яценюк розказав, про що говорив із Байденом у Вашингтоні',	'За словами Яценюка, Байден під час розмови наголосив на підтримці українських реформ з боку США. Політики обговорили, зокрема, проведення судової реформи.',	6,	'1.bmp',	26,	'2016-06-28 23:01:28',	1);

DROP TABLE IF EXISTS `region`;
CREATE TABLE `region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `region` (`id`, `name`) VALUES
(18,	'Винницкая область'),
(19,	'Волынская область'),
(20,	'Днепропетровская область'),
(21,	'Донецкая область'),
(22,	'Житомирская область'),
(23,	'Закарпатская область'),
(24,	'Запорожская область'),
(25,	'Ивано- Франковская область'),
(26,	'Киевская область'),
(27,	'Кировоградская область'),
(28,	'Луганская область'),
(29,	'Львовская область'),
(30,	'Николаевская область'),
(31,	'Одесская область'),
(32,	'Полтавская область'),
(33,	'Ровенская область'),
(34,	'Сумская область'),
(35,	'Тернопольская область'),
(36,	'Харьковская область'),
(37,	'Херсонская область'),
(38,	'Хмельницкая область'),
(39,	'Черкасская область'),
(40,	'Черниговская область'),
(41,	'Черновицкая область');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isAdmin` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`id`, `login`, `password`, `name`, `surname`, `email`, `isAdmin`) VALUES
(1,	'Аноним',	'user',	'user',	'user',	'user',	1),
(6,	'maximjim',	'maximjim',	'Максим',	'Джим',	'maxim-jim@mail.ru',	1);

-- 2016-06-28 23:10:01
