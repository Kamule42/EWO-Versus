-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Sam 14 Avril 2012 à 12:46
-- Version du serveur: 5.5.20
-- Version de PHP: 5.3.10

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `versus`
--

-- --------------------------------------------------------

--
-- Structure de la table `armee`
--

DROP TABLE IF EXISTS `armee`;
CREATE TABLE IF NOT EXISTS `armee` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordre_id` mediumint(9) NOT NULL,
  `descr` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Structure de la table `camps`
--

DROP TABLE IF EXISTS `camps`;
CREATE TABLE IF NOT EXISTS `camps` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `chat_token`
--

DROP TABLE IF EXISTS `chat_token`;
CREATE TABLE IF NOT EXISTS `chat_token` (
  `utilisateur_id` int(10) unsigned NOT NULL,
  `token` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE IF NOT EXISTS `groupe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `utilisateur_id` mediumint(8) unsigned NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `inscr_token`
--

DROP TABLE IF EXISTS `inscr_token`;
CREATE TABLE IF NOT EXISTS `inscr_token` (
  `utilisateur_id` int(10) unsigned NOT NULL,
  `token` char(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auteur` int(10) unsigned NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `corps` text COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `objet`
--

DROP TABLE IF EXISTS `objet`;
CREATE TABLE IF NOT EXISTS `objet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descr` text COLLATE utf8_unicode_ci NOT NULL,
  `type` set('cac','distance','magique') COLLATE utf8_unicode_ci NOT NULL,
  `pv` int(11) NOT NULL,
  `mouv` int(11) NOT NULL,
  `force` int(11) NOT NULL,
  `des` int(11) NOT NULL,
  `atk` int(11) NOT NULL,
  `portee` int(11) NOT NULL,
  `cout` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `ordre`
--

DROP TABLE IF EXISTS `ordre`;
CREATE TABLE IF NOT EXISTS `ordre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `camps_id` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `unite`
--

DROP TABLE IF EXISTS `unite`;
CREATE TABLE IF NOT EXISTS `unite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pv` int(11) unsigned NOT NULL,
  `mouv` int(11) unsigned NOT NULL,
  `force` int(11) unsigned NOT NULL,
  `des` int(11) unsigned NOT NULL,
  `atk` int(11) unsigned NOT NULL,
  `cout` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `unite_arme`
--

DROP TABLE IF EXISTS `unite_arme`;
CREATE TABLE IF NOT EXISTS `unite_arme` (
  `arme_id` int(10) unsigned NOT NULL,
  `unite_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`arme_id`,`unite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `armee_id` mediumint(9) NOT NULL,
  `actif` enum('attente','actif','desactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'attente',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*******************************************
------------------ DATA --------------------
*******************************************/

-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Sam 14 Avril 2012 à 12:47
-- Version du serveur: 5.5.20
-- Version de PHP: 5.3.10

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `versus`
--

--
-- Contenu de la table `armee`
--

INSERT INTO `armee` (`id`, `nom`, `ordre_id`, `descr`) VALUES
(1, 'Les Tempérés', 1, 'Celui qui se ballade les mains dans les poches, mais qui fait son taf...'),
(2, 'Les Adorateurs', 1, 'Celui qui croit profondément en ce qu''il fait, en bien ou en mal. La race Céleste est toute puissante.'),
(3, 'Les Possessifs', 1, 'A moi ! A moi ! Mon précieuuux'),
(4, 'Les Illuminati', 2, 'Celui qui cherche la vérité. Mais on peut aussi traduire cela par "les illuminés", soit ceux qui ne savent pas ce qu''ils font.'),
(5, 'Les Guerriers éclairés', 2, 'Celui qui se bat pour l''honneur et l''intégrité, de sa race ou de lui-même ? A chacun son interprétation...'),
(6, 'Les Hérauts de Célestia', 2, 'Celui qui bourrine pour la gloire du Très-Haut, ou pas, mais il bourrine pour de la gloire.'),
(7, 'Les Avisés', 3, 'Celui qui cherche la vérité et la Justice, enfin, les siennes, souvent.'),
(8, 'Les Manipulateurs', 3, 'Celui qui est prêt à tout pour arriver à ses fins. Oui, ça y compris. Mais à chacun sa méthode...'),
(9, 'Les Cruels', 3, 'Celui qui fait souffrir pour son propre plaisir, parfois pour celui des autres. Mais souvent pour le sien.'),
(10, 'TEKTic''', 4, 'Le TeK'' au service de la logistique, du soin, de la tactique de front'),
(11, 'TeKToniK''', 4, 'La Tek'' au service du massacre d''ailés, en première ligne'),
(12, 'TeKNik'' ', 4, 'La Tek'' au service de la construction'),
(13, 'Police & Justice', 5, 'S''occupe des soucis internes à l''humanité, des conflits intra-humains.'),
(14, 'Armée régulière', 5, 'Offensive s''occupe de l''extérieur dans une politique d''extension.'),
(15, 'Au corps défendant humain', 5, 'Défensive, s''occupe de l''extérieur dans une politique de défense.'),
(16, 'l''ARCHE (Amicale Réunissant les Constructeurs Humains Emérites)', 6, 'La base du BTP, construisent, résistent, construisent.'),
(17, 'Collecteurs d''essences', 6, 'Pourchassent les ailés pour leurs précieux sésames. Transmettent les essences aux constructeurs de l''ARCHE'),
(18, 'Commandos', 6, 'Agissent en petits groupes dans le seul but de tuer les ailés isolés pour leur piquer leurs essences'),
(19, 'Les Luxurieux', 7, 'Ce sont clairement les Démons du corps et des plaisirs charnels. Ils pervertissent les autres par la séduction, n''hésitant pas à faire usage de leur corps et d''autres talents divers pour obtenir ce qu''ils veulent.'),
(20, 'Les Gourmands', 7, 'Les Gourmands aiment les plaisirs de manière excessive. Ils n''hésitent pas à outrepasser toutes les limites pour satisfaire leur moindre envie. Les Gourmands regroupent aussi bien les fanatiques de nourriture que les richissimes hommes d''affaires qui veulent toujours plus d''argent.'),
(21, 'Les Avares', 7, 'Les Avares sont les égoïstes de l''Enfer. Ceux qui refusent catégoriquement de se séparer de n''importe quoi leur appartenant. Un Avare laisserait un mendiant mourir sur le pas de sa porte… et pourrait même aller jusqu''à le tuer lui-même car celui-ci use son perron. '),
(22, 'Le Limbe', 8, 'Le Limbe regroupe tous les Démons qui n''ont rien de démoniaque… ou qui le cachent très bien. C''est le genre de Démon qui est capable d''afficher un visage d''Ange pour obtenir ce qu''il veut.'),
(23, 'Les Fraudeurs', 8, 'Ils vendent des assurances vie aux immortels, des vraies cornes de Démons en résine aux Humains et des photos de Dix Yeux aux Anges. Les rois de l''arnaque et de l''escroquerie, ce sont les Fraudeurs de l''Enfer.'),
(24, 'Les Traitres', 8, 'Ils ne vous attaquent que lorsque vous avez le dos tourné, séduisent les Luxurieux pour les étouffer durant l''acte et passent leur temps à conspirer contre leurs supérieurs. Les Traitres forment probablement le Caveau le plus instable de l''Enfer.'),
(25, 'Les Colériques', 9, 'Ils ont le sang chaud, s''énervent à la moindre contrariété, agissent de manière totalement subjective, insultent sans aucune raison et n''agissent que sous le coup d''une émotion. Mais on les aime bien quand même.'),
(26, 'Les Hérétiques', 9, 'Les Hérétiques crachent littéralement à la face des Anges et aux représentations de toute icône sacrée. Ils pratiquent ouvertement la magie noire et effectuent sans vergogne des cultes et rituels interdits. Les gothiques de l''Enfer, en somme.'),
(27, 'Les Violents', 9, 'Dans un groupe de rock, le Violent serait le batteur. Il a un besoin presque vital de taper tout ce qui vit (ou pas). C''est sa façon d''aimer. Le Violent peut l''être aussi bien dans sa manière d''agir que dans son comportement en société ou dans sa manière de s''exprimer. ');

--
-- Contenu de la table `camps`
--

INSERT INTO `camps` (`id`, `nom`) VALUES
(1, 'Paradis'),
(2, 'Humanité'),
(3, 'Enfer'),
(4, 'Parias');

--
-- Contenu de la table `groupe`
--

--
-- Contenu de la table `news`
--

INSERT INTO `news` (`id`, `auteur`, `titre`, `corps`, `date`) VALUES
(1, 1, 'Recherche de graphiste(s)', 'Si vous possédez quelques talents en la matière, de la volonté et du temps, faites signe au matricule 2 sur le jeu ou contactez la Team Ewo via le formulaire de contact accessible en bas de cette page. :) ', '2012-04-08 18:53:50'),
(2, 1, 'Beta n°2 d''EWO : Avancement', 'EWO est en beta (la 2ème depuis Avril 2011), ce qui signifie que le jeu est en plein développement. \r\nPour pouvoir jouer vous devez recréer un compte ! Au cas où vous jouez avec les mêmes noms de personnages dans le même camp, et avez utilisé la même adresse mail que sur la beta 1, les comptes du forum sont conservés et réutilisables. \r\n\r\nLa durée de la beta 2 est inconnue mais ce qui est sûr c''est qu''elle est la dernière étape avant la Version Finale ! Elle devrait aussi être plus courte que la 1ère.\r\n\r\nAutre chose d''incertain (comment ça on se contredit ?) : C''est que l''on ne sait pas quand sortira la VF. Sinon quand tout sera prêt. :) \r\n\r\nLes nouveaux gains d''xp sont en place! N''hésitez pas à signaler tout gains (ou pertes) suspect(e)s sur Mantis et/où le forum ', '2012-04-08 18:53:50');

--
-- Contenu de la table `objet`
--

INSERT INTO `objet` (`id`, `nom`, `descr`, `type`, `pv`, `mouv`, `force`, `des`, `atk`, `portee`, `cout`) VALUES
(1, 'épée', 'Une simple épée', 'cac', 0, 0, 0, 0, 0, 1, 1),
(2, 'arc court', 'L''arc le plus simple qu''il soit.', 'distance', 0, 0, 4, 0, 0, 4, 2);

--
-- Contenu de la table `ordre`
--

INSERT INTO `ordre` (`id`, `nom`, `camps_id`) VALUES
(1, 'L''Ordre de Cristal', 1),
(2, 'L''Ordre de Lumière', 1),
(3, 'L''Ordre des Ombres', 1),
(4, 'La Tek''', 2),
(5, 'L''Ordre Militaire', 2),
(6, 'Les BTP', 2),
(7, 'L''Ordre des Envieux', 3),
(8, 'L''Ordre des Indus', 3),
(9, 'L''Ordre des Ardents', 3),
(10, 'La Loge ', 4);

--
-- Contenu de la table `unite`
--

INSERT INTO `unite` (`id`, `nom`, `pv`, `mouv`, `force`, `des`, `atk`, `cout`) VALUES
(1, 'Fantassin angélique', 20, 6, 5, 8, 1, 8);

--
-- Contenu de la table `unite_arme`
--

INSERT INTO `unite_arme` (`arme_id`, `unite_id`) VALUES
(1, 1),
(2, 1);

--
-- Contenu de la table `utilisateur`
--

SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
