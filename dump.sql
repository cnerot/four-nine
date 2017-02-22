-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 22 Février 2017 à 20:24
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `four`
--

-- --------------------------------------------------------

--
-- Structure de la table `contest`
--

CREATE TABLE `contest` (
  `id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `link`
--

CREATE TABLE `link` (
  `id` int(11) NOT NULL,
  `id_contest` int(11) NOT NULL,
  `id_photo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `id_fb` text COMMENT 'vaut NULL si photo depuis ordinateur',
  `description` text COMMENT 'Se servir de l''id FB',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `staticpages`
--

CREATE TABLE `staticpages` (
  `id` int(11) NOT NULL,
  `Title` varchar(45) DEFAULT NULL,
  `Content` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `bgColor` varchar(250) NOT NULL,
  `bgImage` varchar(250) NOT NULL,
  `bgNavColor` varchar(250) NOT NULL,
  `iconHomeColor` varchar(250) NOT NULL,
  `iconOffColor` varchar(250) NOT NULL,
  `nameColor` varchar(250) NOT NULL,
  `titleColor` varchar(250) NOT NULL,
  `textNavColor` varchar(250) NOT NULL,
  `textColor` varchar(250) NOT NULL,
  `btnColor` varchar(250) NOT NULL,
  `textBtnColor` varchar(250) NOT NULL,
  `collapsibleHeader` varchar(250) NOT NULL,
  `collapsibleBody` varchar(250) NOT NULL,
  `pageStat` varchar(250) NOT NULL,
  `applicated` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `theme`
--

INSERT INTO `theme` (`id`, `name`, `bgColor`, `bgImage`, `bgNavColor`, `iconHomeColor`, `iconOffColor`, `nameColor`, `titleColor`, `textNavColor`, `textColor`, `btnColor`, `textBtnColor`, `collapsibleHeader`, `collapsibleBody`, `pageStat`, `applicated`) VALUES
(1, 'default', 'grey darken-2', '', 'grey darken-4', '', '', '0', '0', 'yellow-text text-darken-2', 'yellow-text text-accent-4', 'yellow lighten-1', '', '', '', '', 1),
(2, 'done know why', 'teal accent-4', '/tmp/phpMypYFy', 'light-green darken-4', 'teal accent-4', 'green accent-4', 'teal darken-1', 'light-green darken-4', 'purple darken-1', 'teal accent-4', 'blue accent-1', 'blue darken-4', 'purple darken-1', 'indigo darken-4', 'purple darken-1', 0),
(3, 'theme darken', 'indigo darken-4', '/tmp/phpLs6jry', 'indigo darken-4', 'red darken-1', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'teal accent-4', 'yellow darken-2', 'green accent-4', 'grey darken-3', 'grey darken-3', 0),
(4, 'theme life', 'indigo darken-4', '/tmp/php7twNqK', 'indigo darken-4', 'red darken-1', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'teal accent-4', 'yellow darken-2', 'green accent-4', 'grey darken-3', 'grey darken-3', 0),
(5, 'themed', 'indigo darken-4', '/tmp/phpJPgj0Z', 'indigo darken-4', 'red darken-1', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'teal accent-4', 'yellow darken-2', 'green accent-4', 'grey darken-3', 'grey darken-3', 0),
(6, 'themed', 'indigo darken-4', '/tmp/php9ujNVr', 'indigo darken-4', 'red darken-1', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'blue darken-4', 'teal accent-4', 'yellow darken-2', 'green accent-4', 'grey darken-3', 'grey darken-3', 0),
(7, '', 'pink lighten-2', '', 'pink darken-1', 'text-string(12) ', 'text-string(15) ', 'text-string(14) ', 'text-string(12) ', 'text-string(12) ', 'text-string(13) ', 'light-blue darken-3', 'text-string(20) ', 'purple darken-1', 'indigo darken-1', 'grey darken-2', 0),
(8, 'newtestThme', 'pink lighten-2', '', 'pink darken-1', 'text-string(12) ', 'text-string(15) ', 'text-string(14) ', 'text-string(12) ', 'text-string(12) ', 'text-string(13) ', 'light-blue darken-3', 'text-string(20) ', 'purple darken-1', 'indigo darken-1', 'grey darken-2', 0),
(9, 'newtestThme', 'pink lighten-2', '', 'pink darken-1', 'text-string(12) ', 'text-string(15) ', 'text-string(14) ', 'text-string(12) ', 'text-string(12) ', 'text-string(13) ', 'light-blue darken-3', 'text-string(20) ', 'purple darken-1', 'indigo darken-1', 'grey darken-2', 0),
(10, 'time to test', 'brown darken-1', '', 'teal darken-1', 'text-purple darken-3', 'text-red darken-1', 'text-red accent-4', 'text-purple accent-1', 'text-pink darken-1', 'text-deep-orange darken-4', 'red darken-4', 'text-teal accent-4', 'light-blue darken-3', 'blue accent-1', 'indigo darken-4', 0),
(11, 'time to test', 'brown darken-1', '', 'teal darken-1', 'text-purple darken-3', 'text-red darken-1', 'text-red accent-4', 'text-purple accent-1', 'text-pink darken-1', 'text-deep-orange darken-4', 'red darken-4', 'text-teal accent-4', 'light-blue darken-3', 'blue accent-1', 'indigo darken-4', 0),
(12, 'never mind', 'brown darken-1', '', 'teal darken-1', 'text-purple text-darken-3', 'text-red text-darken-1', 'text-red text-accent-4', 'text-purple text-accent-1', 'text-pink text-darken-1', 'text-deep-orange text-darken-4', 'red darken-4', 'text-teal text-accent-4', 'light-blue darken-3', 'blue accent-1', 'indigo darken-4', 0),
(13, 'mierdas', 'pink darken-1', '', 'pink lighten-2', 'text-red text-accent-4', 'text-purple text-accent-1', 'text-purple text-darken-1', 'text-purple text-darken-3', 'text-indigo text-darken-4', 'text-indigo text-darken-1', 'blue darken-4', 'text-light-blue text-darken-3', 'teal darken-1', 'teal accent-4', 'teal', 0),
(14, 'mierdas', 'pink darken-1', '', 'pink lighten-2', 'text-red text-accent-4', 'text-purple text-accent-1', 'text-purple text-darken-1', 'text-purple text-darken-3', 'text-indigo text-darken-4', 'text-indigo text-darken-1', 'blue darken-4', 'text-light-blue text-darken-3', 'teal darken-1', 'teal accent-4', 'teal', 0),
(15, 'now or no', 'red darken-4', '', 'red darken-1', 'text-grey text-darken-4', 'text-brown text-darken-2', 'orange accent-3', 'text-blue text-accent-1', 'text-blue text-darken-4', 'text-yellow text-darken-2', 'light-green darken-4', 'text-teal', 'blue accent-1', 'yellow lighten-1', 'yellow lighten-1', 0),
(16, 'jkkkkkkkkkkkkk', 'pink lighten-2', '', 'green accent-4', 'teal-text text-accent-4', 'red-text text-darken-1', 'purple accent-1', 'yellow-text text-accent-4', 'blue-text text-darken-4', 'blue-text text-accent-1', 'teal', 'yellow-text text-accent-4', 'deep-orange darken-4', 'grey', 'white', 0),
(17, 'jkkkkkkkkkkkkk', 'pink lighten-2', '', 'green accent-4', 'teal-text text-accent-4', 'red-text text-darken-1', 'purple accent-1', 'yellow-text text-accent-4', 'blue-text text-darken-4', 'blue-text text-accent-1', 'teal', 'yellow-text text-accent-4', 'deep-orange darken-4', 'grey', 'white', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(100) DEFAULT NULL,
  `id_user` bigint(20) DEFAULT NULL COMMENT 'REferents'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

CREATE TABLE `vote` (
  `id` int(11) NOT NULL,
  `grade` int(11) DEFAULT NULL,
  `id_utilisateurs` bigint(255) NOT NULL,
  `id_link` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `contest`
--
ALTER TABLE `contest`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `link`
--
ALTER TABLE `link`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Photo_Utilisateurs_idx` (`id_user`);

--
-- Index pour la table `staticpages`
--
ALTER TABLE `staticpages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Utilisateurs_Utilisateurs1_idx` (`id_user`);

--
-- Index pour la table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Vote_Utilisateurs1_idx` (`id_utilisateurs`),
  ADD KEY `fk_Vote_link_coucours_photo1_idx` (`id_link`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `contest`
--
ALTER TABLE `contest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `link`
--
ALTER TABLE `link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `staticpages`
--
ALTER TABLE `staticpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
