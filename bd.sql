-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Mer 28 Avril 2021 à 16:48
-- Version du serveur :  5.7.29
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `in19b1171`
--

-- --------------------------------------------------------

--
-- Structure de la table `ftChaine`
--

CREATE TABLE `ftChaine` (
  `id_chaine` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `est_publique` tinyint(1) DEFAULT NULL,
  `evaluation` int(11) DEFAULT NULL,
  `date_derniere_video` date DEFAULT NULL,
  `est_bloquee` tinyint(1) DEFAULT NULL,
  `id_compte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ftCommentaire`
--

CREATE TABLE `ftCommentaire` (
  `id_commentaire` int(11) NOT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `date_publication` date DEFAULT NULL,
  `id_video` int(11) NOT NULL,
  `id_compte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ftCompte`
--

CREATE TABLE `ftCompte` (
  `id_compte` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `courriel` varchar(255) NOT NULL,
  `mot_de_passe` varchar(100) DEFAULT NULL,
  `est_bloque` tinyint(1) DEFAULT NULL,
  `photo` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ftDemande`
--

CREATE TABLE `ftDemande` (
  `id_compte` int(11) NOT NULL,
  `id_compte_1` int(11) NOT NULL,
  `estAcceptee` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ftEvaluer`
--

CREATE TABLE `ftEvaluer` (
  `id_compte` int(11) NOT NULL,
  `id_video` int(11) NOT NULL,
  `evaluation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ftVideo`
--

CREATE TABLE `ftVideo` (
  `id_video` int(11) NOT NULL,
  `intitule` varchar(255) DEFAULT NULL,
  `description` text,
  `html_fragment` varchar(500) DEFAULT NULL,
  `duree` time DEFAULT NULL,
  `url_apercu` varchar(255) DEFAULT NULL,
  `date_ajout` date DEFAULT NULL,
  `est_bloquee` tinyint(1) DEFAULT NULL,
  `miniature` varchar(500) NOT NULL,
  `id_chaine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ftVoir`
--

CREATE TABLE `ftVoir` (
  `id_compte` int(11) NOT NULL,
  `id_video` int(11) NOT NULL,
  `date_vue` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `ftChaine`
--
ALTER TABLE `ftChaine`
  ADD PRIMARY KEY (`id_chaine`),
  ADD KEY `id_compte` (`id_compte`);

--
-- Index pour la table `ftCommentaire`
--
ALTER TABLE `ftCommentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `id_video` (`id_video`),
  ADD KEY `id_compte` (`id_compte`);

--
-- Index pour la table `ftCompte`
--
ALTER TABLE `ftCompte`
  ADD PRIMARY KEY (`id_compte`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `courriel` (`courriel`);

--
-- Index pour la table `ftDemande`
--
ALTER TABLE `ftDemande`
  ADD PRIMARY KEY (`id_compte`,`id_compte_1`),
  ADD KEY `id_compte_1` (`id_compte_1`);

--
-- Index pour la table `ftEvaluer`
--
ALTER TABLE `ftEvaluer`
  ADD PRIMARY KEY (`id_compte`,`id_video`),
  ADD KEY `id_video` (`id_video`);

--
-- Index pour la table `ftVideo`
--
ALTER TABLE `ftVideo`
  ADD PRIMARY KEY (`id_video`),
  ADD KEY `id_chaine` (`id_chaine`);

--
-- Index pour la table `ftVoir`
--
ALTER TABLE `ftVoir`
  ADD PRIMARY KEY (`id_compte`,`id_video`),
  ADD KEY `id_video` (`id_video`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `ftChaine`
--
ALTER TABLE `ftChaine`
  MODIFY `id_chaine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `ftCommentaire`
--
ALTER TABLE `ftCommentaire`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ftCompte`
--
ALTER TABLE `ftCompte`
  MODIFY `id_compte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `ftVideo`
--
ALTER TABLE `ftVideo`
  MODIFY `id_video` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `ftChaine`
--
ALTER TABLE `ftChaine`
  ADD CONSTRAINT `ftChaine_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `ftCompte` (`id_compte`);

--
-- Contraintes pour la table `ftCommentaire`
--
ALTER TABLE `ftCommentaire`
  ADD CONSTRAINT `ftCommentaire_ibfk_1` FOREIGN KEY (`id_video`) REFERENCES `ftVideo` (`id_video`),
  ADD CONSTRAINT `ftCommentaire_ibfk_2` FOREIGN KEY (`id_compte`) REFERENCES `ftCompte` (`id_compte`);

--
-- Contraintes pour la table `ftDemande`
--
ALTER TABLE `ftDemande`
  ADD CONSTRAINT `ftDemande_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `ftCompte` (`id_compte`),
  ADD CONSTRAINT `ftDemande_ibfk_2` FOREIGN KEY (`id_compte_1`) REFERENCES `ftCompte` (`id_compte`);

--
-- Contraintes pour la table `ftEvaluer`
--
ALTER TABLE `ftEvaluer`
  ADD CONSTRAINT `ftEvaluer_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `ftCompte` (`id_compte`),
  ADD CONSTRAINT `ftEvaluer_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `ftVideo` (`id_video`);

--
-- Contraintes pour la table `ftVideo`
--
ALTER TABLE `ftVideo`
  ADD CONSTRAINT `ftVideo_ibfk_1` FOREIGN KEY (`id_chaine`) REFERENCES `ftChaine` (`id_chaine`);

--
-- Contraintes pour la table `ftVoir`
--
ALTER TABLE `ftVoir`
  ADD CONSTRAINT `ftVoir_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `ftCompte` (`id_compte`),
  ADD CONSTRAINT `ftVoir_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `ftVideo` (`id_video`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
