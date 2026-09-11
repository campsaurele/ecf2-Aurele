-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 11 sep. 2026 à 14:16
-- Version du serveur : 8.4.7
-- Version de PHP : 8.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecf2aurele`
--

-- --------------------------------------------------------

--
-- Structure de la table `absences`
--

DROP TABLE IF EXISTS `absences`;
CREATE TABLE IF NOT EXISTS `absences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_time` date NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `reason_id` int NOT NULL,
  `trainee_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F9C0EFFF59BB1592` (`reason_id`),
  KEY `IDX_F9C0EFFF36C682D0` (`trainee_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `absences`
--

INSERT INTO `absences` (`id`, `date_time`, `document`, `reason_id`, `trainee_id`) VALUES
(1, '2026-09-15', 'maladie-aurele-15-09-2026-6aa3fbd22866f.pdf', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260911095715', '2026-09-11 09:57:23', 454);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reasons`
--

DROP TABLE IF EXISTS `reasons`;
CREATE TABLE IF NOT EXISTS `reasons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reasons`
--

INSERT INTO `reasons` (`id`, `name`) VALUES
(1, 'Maladie'),
(2, 'Légale'),
(3, 'Sans Motif');

-- --------------------------------------------------------

--
-- Structure de la table `trainee`
--

DROP TABLE IF EXISTS `trainee`;
CREATE TABLE IF NOT EXISTS `trainee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `training_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_46C68DE7BEFD98D1` (`training_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `trainee`
--

INSERT INTO `trainee` (`id`, `lastname`, `name`, `phone`, `email`, `photo`, `training_id`) VALUES
(1, 'Camps', 'Aurele', '06060606060', 'campsaurele@gmail.com', 'camps-aurele-6aa3fbe805c64.webp', 1),
(2, 'Kehlaoui', 'Adila', '0600000000', 'adi.kehlaoui@gmail.com', 'kehlaoui-adila-6aa40c018b938.webp', 1),
(3, 'Benerroua', 'Mohammed', '0767250170', 'benerrouamohammed@gmail.com', 'benerroua-mohammed-6aa40c1524c72.webp', 1),
(4, 'Fabre', 'Nelly', '0600000000', 'nelly.fabre@hotmail.fr', 'fabre-nelly-6aa40c30590b0.webp', 1),
(5, 'Bellia', 'Ghislène', '06060606060', 'ghislenebellia@gmail.com', 'bellia-ghislene-6aa40c48e0fd7.webp', 1),
(6, 'Casabianca', 'Sarah', '0600000000', 'sarah.casabianca@gmail.com', 'casabianca-sarah-6aa40c5544446.webp', 1),
(7, 'Rojas Cuicas', 'Juan', '0600000000', 'rjuan3683@gmail.com', 'rojas-cuicas-juan-6aa40c6533e42.webp', 1),
(8, 'Merlet', 'Lucas', '06060606060', 'merletlucas2@gmail.com', 'merlet-lucas-6aa40c748a810.webp', 1),
(9, 'Kenzey', 'Nathanael', '0600000000', 'nathanael.kenzey@gmail.com', 'kenzey-nathanael-6aa40c87aad16.webp', 1),
(10, 'Lutard', 'Anthony', '0600000000', 'anthony.lutard33@gmail.com', 'lutard-anthony-6aa40c95ded07.webp', 1),
(11, 'Saez', 'Mélanie', '0767250170', 'emel.saez@gmail.com', 'saez-melanie-6aa40ca73e88e.webp', 1);

-- --------------------------------------------------------

--
-- Structure de la table `training`
--

DROP TABLE IF EXISTS `training`;
CREATE TABLE IF NOT EXISTS `training` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `training`
--

INSERT INTO `training` (`id`, `name`) VALUES
(1, 'DWWM'),
(2, 'CDUI'),
(3, 'CDA');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(180) NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_LOGIN` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
