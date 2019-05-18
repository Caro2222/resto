-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 18 mai 2019 à 16:55
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `resto_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `booking_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `dateResa` date NOT NULL,
  `service` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `placesDemandees` int(11) NOT NULL,
  `cancelled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`booking_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `dateResa`, `service`, `placesDemandees`, `cancelled`) VALUES
(1, 2, '2019-05-04', 'midi', 5, 0),
(2, 2, '2019-05-05', 'midi', 10, 0),
(3, 2, '2019-05-08', 'midi', 12, 0),
(4, 2, '2019-05-04', 'midi', 3, 0),
(5, 2, '2019-05-04', 'midi', 3, 0),
(6, 2, '2019-05-09', 'midi', 2, 0),
(7, 2, '2019-05-09', 'midi', 2, 0),
(8, 2, '2019-05-10', 'midi', 5, 0),
(9, 2, '2019-05-10', 'midi', 5, 0),
(10, 2, '2019-05-10', 'midi', 5, 0),
(11, 2, '2019-05-10', 'midi', 5, 0),
(12, 2, '2019-05-10', 'midi', 5, 0),
(13, 2, '2019-05-10', 'midi', 5, 0),
(14, 2, '2019-05-10', 'midi', 5, 0),
(15, 2, '2019-05-23', 'midi', 2, 0),
(16, 2, '2019-05-11', 'midi', 5, 0),
(17, 2, '2019-05-24', 'midi', 1, 0),
(18, 2, '2019-05-06', 'midi', 5, 0),
(19, 2, '2019-05-05', 'midi', 3, 0),
(20, 2, '2019-05-01', 'midi', 3, 1),
(21, 2, '2019-05-01', 'midi', 5, 0),
(22, 2, '2019-05-18', 'midi', 5, 0),
(23, 2, '2019-04-30', 'midi', 5, 0),
(24, 2, '2019-04-29', 'midi', 5, 0),
(25, 2, '2019-04-29', 'midi', 5, 0),
(26, 2, '2019-05-01', 'midi', 5, 0),
(27, 2, '2019-05-01', 'midi', 5, 0),
(28, 2, '2019-05-02', 'midi', 5, 0),
(29, 2, '2019-05-01', 'midi', 2, 0),
(30, 2, '2019-05-07', 'midi', 2, 0),
(31, 2, '2019-05-28', 'midi', 2, 0),
(32, 2, '2019-05-28', 'midi', 2, 0),
(33, 2, '2019-05-28', 'midi', 2, 0),
(34, 2, '2019-05-28', 'midi', 2, 0),
(35, 2, '2019-05-28', 'midi', 2, 0),
(36, 4, '2019-05-14', 'midi', 1, 0),
(37, 4, '2019-05-14', 'midi', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `menu_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_menu` float NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`menu_id`, `title`, `content`, `price_menu`, `startDate`, `endDate`) VALUES
(1, 'menu 1', '\r\nlasagnes\r\ncoco', 25.5, '2018-01-01', '2018-02-01'),
(5, 'menu 4', 'menu vegetarien', 25.5, '2019-04-27', '2019-05-25'),
(6, 'menu spécial ', 'promotion du mois', 18.5, '2019-05-01', '2019-05-31');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `OrdersDate` datetime DEFAULT NULL,
  `DeliveryDate` datetime DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `payed` tinyint(1) NOT NULL DEFAULT '0',
  `Status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `OrdersNumber` (`DeliveryDate`),
  KEY `order_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `OrdersDate`, `DeliveryDate`, `user_id`, `payed`, `Status`) VALUES
(16, '2019-05-11 14:47:53', '2019-05-13 20:21:02', 1, 0, 'confirm'),
(17, '2019-05-11 15:55:46', NULL, 3, 0, 'basket'),
(18, '2019-05-12 14:18:15', '2019-05-15 00:00:00', 4, 0, 'confirm'),
(19, '2019-05-13 21:43:45', '2019-05-22 00:00:00', 4, 0, 'confirm'),
(20, '2019-05-14 10:23:31', '2019-05-22 00:00:00', 4, 0, 'confirm'),
(21, '2019-05-14 10:33:00', '2019-05-22 00:00:00', 4, 0, 'confirm'),
(22, '2019-05-14 11:01:18', '2019-05-16 00:00:00', 4, 0, 'confirm'),
(23, '2019-05-14 16:48:22', '2019-05-15 00:00:00', 4, 0, 'confirm'),
(24, '2019-05-14 17:05:39', '2019-05-15 00:00:00', 4, 0, 'confirm'),
(25, '2019-05-14 22:03:13', '2019-05-16 00:00:00', 4, 0, 'confirm'),
(26, '2019-05-14 23:02:39', NULL, 2, 0, 'basket'),
(27, '2019-05-15 13:07:48', '2019-05-16 00:00:00', 4, 0, 'confirm');

-- --------------------------------------------------------

--
-- Structure de la table `orders_details`
--

DROP TABLE IF EXISTS `orders_details`;
CREATE TABLE IF NOT EXISTS `orders_details` (
  `orderDetails_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(10) UNSIGNED NOT NULL,
  `quantityOrdered` int(11) NOT NULL,
  `menu_Id` int(10) UNSIGNED NOT NULL,
  `end_Orders` int(11) DEFAULT NULL,
  `priceEach` float NOT NULL,
  PRIMARY KEY (`orderDetails_id`),
  UNIQUE KEY `basket_unicity` (`order_id`,`menu_Id`),
  KEY `product` (`menu_Id`),
  KEY `menu_Id` (`menu_Id`),
  KEY `order_id` (`order_id`),
  KEY `orders_details` (`order_id`,`menu_Id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orders_details`
--

INSERT INTO `orders_details` (`orderDetails_id`, `order_id`, `quantityOrdered`, `menu_Id`, `end_Orders`, `priceEach`) VALUES
(1, 16, 1, 6, NULL, 20),
(14, 16, 1, 5, NULL, 25.5),
(24, 17, 5, 1, NULL, 25.5),
(32, 18, 8, 1, NULL, 25.5),
(33, 18, 4, 6, NULL, 18.5),
(36, 18, 1, 5, NULL, 25.5),
(37, 19, 4, 5, NULL, 25.5),
(39, 22, 4, 1, NULL, 25.5),
(40, 23, 4, 5, NULL, 25.5),
(41, 23, 1, 1, NULL, 25.5),
(42, 25, 2, 1, NULL, 25.5),
(43, 25, 2, 5, NULL, 25.5);

-- --------------------------------------------------------

--
-- Structure de la table `plates`
--

DROP TABLE IF EXISTS `plates`;
CREATE TABLE IF NOT EXISTS `plates` (
  `plates_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_description` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingredient` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `photo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`plates_id`),
  KEY `product` (`product`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `plates`
--

INSERT INTO `plates` (`plates_id`, `product`, `product_description`, `ingredient`, `price`, `photo`, `category`) VALUES
(1, 'Salade de pâtes au thon', 'une salade fraiche à la fois gourmande et légère', 'thon,penne,olive tomate', 12, 'salade-de-pate-au-thon.jpg', 'plat principal'),
(2, 'Salade de riz complète', 'Rien que des bonnes petites choses fraîches et savoureuses pour une salade composée au top', ' maïs,  petits pois,  carottes, tomates,  oeufs, saucisses de francfort', 10, 'salade-de-riz-complete-min.jpg', 'plat principal'),
(3, 'Brochettes de noix de Saint-Jacques à la citronnelle et gingembre', 'Les fêtes de fin d’année approchent, nous avons sélectionné pour vous cette recette de \"brochettes de noix de saint-jacques à la citronnelle et gingembre', 'Saint-jacque,citonnelle,gingembre', 13, 'brochettes-de-noix-de-saint-jacques.jpg', 'entrée'),
(4, 'Petits flans de coquilles Saint Jacques', 'Noël pointe le bout de son nez, nous avons sélectionné pour vous cette recette de \"petits flans de coquilles saint jacques\" facile qui enchantera votre famille pour un réveillon de noël inoubliable', 'Saint-Jacque,tomate,créme fraiche', 8, 'petits-flans-de-coquilles-saint-jacques.jpg', 'entrée'),
(5, 'Riz au lait de coco et pistache', 'Image même de l’originalité et de la typicité des vins d’Alsace, le Gewurztraminer est le partenaire idéal de nombreux plats asiatiques : cuisines chinoise, indonésienne, malaise, thaï et indienne.', 'Riz, lait de coco, fraise,pistache', 10, 'photo-de-riz-au-lait-de-coco-et-pistache.jpg', 'dessert'),
(6, 'Brochettes de fruits à la fondue de chocolat', 'banane,kiwi,fraise,pomme,chocolat', 'banane,kiwi,fraise,pomme,chocolat', 8, 'brochettes-de-fruits-a-la-fondue-de-chocolat.jpg', 'dessert'),
(7, 'Petits gâteaux au chocolat fondant', 'Petits gâteaux au chocolat fondant fait maison', 'chocolat, buerre, sucre,oeuf', 9, 'gateaux-au-chocolat-fondant.jpg', 'dessert'),
(8, 'Lasagnes aux légumes et au thon', 'Les légumes sont des sources inépuisables de minéraux et vitamines, c’est pourquoi il est conseillé d’en consommer à chaque repas crus ou cuits. ', 'aubergine courgette \r\npoivron rouge tomate \r\n', 15, 'lasagnes-aux-legumes-et-au-thon.jpg', 'plat principal'),
(23, 'hgdgd', 'gfgftyfy', 'cgfddg', 2, NULL, 'entrée');

-- --------------------------------------------------------

--
-- Structure de la table `plates_menus`
--

DROP TABLE IF EXISTS `plates_menus`;
CREATE TABLE IF NOT EXISTS `plates_menus` (
  `plates_id` int(11) UNSIGNED NOT NULL,
  `menu_id` int(11) UNSIGNED NOT NULL,
  KEY `plate_id` (`plates_id`),
  KEY `menu_id` (`menu_id`),
  KEY `plate_id_2` (`plates_id`),
  KEY `plate_id_3` (`plates_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `plates_menus`
--

INSERT INTO `plates_menus` (`plates_id`, `menu_id`) VALUES
(8, 1),
(4, 1),
(5, 1),
(3, 5),
(8, 5),
(7, 5),
(6, 6),
(8, 6),
(4, 6);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `reviews_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `dateCreation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` int(11) NOT NULL,
  PRIMARY KEY (`reviews_id`),
  UNIQUE KEY `comment` (`comment`),
  KEY `comment_2` (`comment`),
  KEY `user_id` (`user_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`reviews_id`, `user_id`, `menu_id`, `dateCreation`, `comment`, `note`) VALUES
(8, 2, 5, '2019-05-07 18:59:41', 'tres bien ', 5),
(9, 2, 1, '2019-05-07 18:59:59', 'tres bon', 5);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `phone` int(11) NOT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postalCode` int(11) NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inscriptionDate` datetime NOT NULL,
  `lastLoginDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `FirstName`, `LastName`, `email`, `admin`, `phone`, `address`, `postalCode`, `city`, `password`, `inscriptionDate`, `lastLoginDate`) VALUES
(1, 'caroline', 'gottfried', 'Gottcaroline@gmail.com', 0, 641528956, '150 rue rechossiere, Batd', 93300, 'AUBERVILLIERS', '$2y$10$/xnwrbNeLl0tJF5nn0F0pux0D6C4HnDBkkA5A2RnFudSpdOsebWm2', '2019-05-02 19:11:42', '2019-05-15 13:09:36'),
(2, 'caroline', 'gottfried', 'caroline@gmail.com', 1, 641528956, '150 rue rechossiere, Batd', 93300, 'AUBERVILLIERS', '$2y$10$z84exMWmi5Wfc2pCv5wigOjW6zcjLP7gV4C/0Nd3lhz1QVUs/7Eqa', '2019-05-03 18:48:09', '2019-05-15 13:42:45'),
(3, 'caroline', 'gottfried', 'Gott@gmail.com', 0, 641528956, '150 rue rechossiere, Batd', 93300, 'AUBERVILLIERS', '$2y$10$Mhk9Vr.hiq/RxIb8YWhJdeinT3MEiLRHOakCxY9h1vbxRAca6vdw.', '2019-05-11 15:55:26', '2019-05-12 13:26:30'),
(4, 'caroline', 'gottfried', 'e@gmail.com', 0, 641528956, '150 rue rechossiere, Batd', 93300, 'AUBERVILLIERS', '$2y$10$nO70PytCq741HsXMI/KQQudM6QRn4mW50mi8L54h1bRmalx4LOfJm', '2019-05-12 14:17:47', '2019-05-14 23:04:00');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `orders_details`
--
ALTER TABLE `orders_details`
  ADD CONSTRAINT `menu_ibfk_2` FOREIGN KEY (`menu_Id`) REFERENCES `menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `plates_menus`
--
ALTER TABLE `plates_menus`
  ADD CONSTRAINT `menu_ibfk_3` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plate_ibfk_2` FOREIGN KEY (`plates_id`) REFERENCES `plates` (`plates_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
