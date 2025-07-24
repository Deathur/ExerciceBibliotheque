-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 24 juil. 2025 à 14:13
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

--
-- Déchargement des données de la table `appartient`
--

INSERT INTO `appartient` (`id_livres`, `id_genres`) VALUES
(7, 1),
(8, 5);

-- --------------------------------------------------------

--
-- Structure de la table `ecrire`
--

CREATE TABLE `ecrire` (
  `idLivres` int(11) NOT NULL,
  `id_ecrivains` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ecrire`
--

INSERT INTO `ecrire` (`idLivres`, `id_ecrivains`) VALUES
(7, 6),
(8, 3);

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

--
-- Déchargement des données de la table `ecrivains`
--

INSERT INTO `ecrivains` (`id_ecrivains`, `nomEcrivains`, `prenomEcrivains`, `nationalitéEcrivains`) VALUES
(3, 'Proust', 'Marcel', 'Française'),
(5, 'Baelen', 'Matthieu', 'Française'),
(6, 'Rowling', 'J.K', 'Anglaise');

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

--
-- Déchargement des données de la table `emprunts`
--

INSERT INTO `emprunts` (`id_emprunts`, `dateEmprunts`, `renduEmprunts`, `id_utilisateurs`, `id_livres`) VALUES
(86, '23-07-2025', 1, 1, 7),
(89, '23-07-2025', 1, 1, 7),
(90, '23-07-2025', 1, 1, 7),
(92, '24-07-2025', 1, 1, 7);

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE `genres` (
  `id_genres` int(11) NOT NULL,
  `nomGenres` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `genres`
--

INSERT INTO `genres` (`id_genres`, `nomGenres`) VALUES
(1, 'Fantastique'),
(2, 'Science Fiction'),
(3, 'Biopic'),
(4, 'Littéraire'),
(5, 'Scientifique');

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

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`idLivres`, `nomLivres`, `annee`, `dispoLivres`) VALUES
(7, 'Harry Potter à l&#039;École des Sorciers', 1997, 1),
(8, 'A la recherche du temps perdu', 1907, 1);

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
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateurs`, `nomUtilisateurs`, `prenomUtilisateurs`, `mailUtilisateurs`) VALUES
(1, 'Baelen', 'Matthieu', 'aa'),
(2, 'Forever', 'Michel', 'aa'),
(3, 'test', 'test', 'test');

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
  MODIFY `id_livres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `ecrire`
--
ALTER TABLE `ecrire`
  MODIFY `idLivres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `ecrivains`
--
ALTER TABLE `ecrivains`
  MODIFY `id_ecrivains` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `emprunts`
--
ALTER TABLE `emprunts`
  MODIFY `id_emprunts` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT pour la table `genres`
--
ALTER TABLE `genres`
  MODIFY `id_genres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `idLivres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateurs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
