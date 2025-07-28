-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 28 juil. 2025 à 14:12
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `exercicebibliotheque`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartient`
--

CREATE TABLE `appartient` (
  `id_livres` int(11) NOT NULL,
  `id_genres` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ecrire`
--

CREATE TABLE `ecrire` (
  `idLivres` int(11) NOT NULL,
  `id_ecrivains` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ecrivains`
--

CREATE TABLE `ecrivains` (
  `id_ecrivains` int(11) NOT NULL,
  `nomEcrivains` varchar(255) DEFAULT NULL,
  `prenomEcrivains` varchar(255) DEFAULT NULL,
  `nationalitéEcrivains` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

CREATE TABLE `emprunts` (
  `id_emprunts` int(11) NOT NULL,
  `dateEmprunts` varchar(255) DEFAULT NULL,
  `renduEmprunts` tinyint(1) DEFAULT NULL,
  `id_utilisateurs` int(11) NOT NULL,
  `id_livres` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE `genres` (
  `id_genres` int(11) NOT NULL,
  `nomGenres` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

CREATE TABLE `livres` (
  `idLivres` int(11) NOT NULL,
  `nomLivres` varchar(255) DEFAULT NULL,
  `annee` int(11) NOT NULL,
  `dispoLivres` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateurs` int(11) NOT NULL,
  `nomUtilisateurs` varchar(255) DEFAULT NULL,
  `prenomUtilisateurs` varchar(255) DEFAULT NULL,
  `mailUtilisateurs` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appartient`
--
ALTER TABLE `appartient`
  ADD PRIMARY KEY (`id_livres`,`id_genres`),
  ADD KEY `FK_Appartient_id_genres` (`id_genres`);

--
-- Index pour la table `ecrire`
--
ALTER TABLE `ecrire`
  ADD PRIMARY KEY (`idLivres`,`id_ecrivains`),
  ADD KEY `FK_Ecrire_id_ecrivains` (`id_ecrivains`);

--
-- Index pour la table `ecrivains`
--
ALTER TABLE `ecrivains`
  ADD PRIMARY KEY (`id_ecrivains`);

--
-- Index pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD PRIMARY KEY (`id_emprunts`),
  ADD KEY `FK_Emprunts_id_utilisateurs` (`id_utilisateurs`),
  ADD KEY `FK_Emprunts_id_livres` (`id_livres`);

--
-- Index pour la table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id_genres`);

--
-- Index pour la table `livres`
--
ALTER TABLE `livres`
  ADD PRIMARY KEY (`idLivres`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateurs`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appartient`
--
ALTER TABLE `appartient`
  MODIFY `id_livres` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ecrire`
--
ALTER TABLE `ecrire`
  MODIFY `idLivres` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ecrivains`
--
ALTER TABLE `ecrivains`
  MODIFY `id_ecrivains` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `emprunts`
--
ALTER TABLE `emprunts`
  MODIFY `id_emprunts` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `genres`
--
ALTER TABLE `genres`
  MODIFY `id_genres` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `idLivres` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateurs` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartient`
--
ALTER TABLE `appartient`
  ADD CONSTRAINT `FK_Appartient_id_genres` FOREIGN KEY (`id_genres`) REFERENCES `genres` (`id_genres`),
  ADD CONSTRAINT `FK_Appartient_id_livres` FOREIGN KEY (`id_livres`) REFERENCES `livres` (`idLivres`);

--
-- Contraintes pour la table `ecrire`
--
ALTER TABLE `ecrire`
  ADD CONSTRAINT `FK_Ecrire_id_ecrivains` FOREIGN KEY (`id_ecrivains`) REFERENCES `ecrivains` (`id_ecrivains`),
  ADD CONSTRAINT `FK_Ecrire_id_livres` FOREIGN KEY (`idLivres`) REFERENCES `livres` (`idLivres`);

--
-- Contraintes pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD CONSTRAINT `FK_Emprunts_id_livres` FOREIGN KEY (`id_livres`) REFERENCES `livres` (`idLivres`),
  ADD CONSTRAINT `FK_Emprunts_id_utilisateurs` FOREIGN KEY (`id_utilisateurs`) REFERENCES `utilisateurs` (`id_utilisateurs`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
