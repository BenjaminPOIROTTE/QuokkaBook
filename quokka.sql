-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 172.18.0.3
-- Généré le : lun. 09 mai 2022 à 14:15
-- Version du serveur : 10.3.34-MariaDB-0+deb10u1
-- Version de PHP : 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `quokkapedo`
--

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `mail` varchar(250) NOT NULL,
  `password` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `accounts`
--

INSERT INTO `accounts` (`id`, `mail`, `password`) VALUES
(2, 'morganpetit5@gmail.com', '1234SuperMotDePasse'),
(4, 'morganpetit56@gmail.com', '1234SuperMotDePasse'),
(9, 'hdhdhd', 'hdhdhdh'),
(10, 'test@gmail.com', '1234'),
(11, 'test2@gmail.com', '1234'),
(12, 'test3@gmail.com', '1234'),
(13, 'test5@gmail.com', '1234'),
(15, 'benjamin.poirotte@gmail.com', '235DD5F26FC7F3FA8CEDD2E690F81B1A'),
(16, 'test', 'E7FE9187B806C653E18CAB1410FA4440');

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Image` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`id`, `Nom`, `Description`, `Image`) VALUES
(2, 'Titeuf le guide du zizi sexuel', 'LE SEXE', 'https://www.glenat.com/sites/default/files/images/livres/couv/9782344044322-001-T.jpeg'),
(4, 'Peppa pig va à l\'école', 'Peppa est débile', 'https://images-na.ssl-images-amazon.com/images/I/71RsrajOIvL.jpg'),
(6, 'Livre de recette', 'Par Chef Michel Dumas', 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.pinimg.com%2Foriginals%2F22%2F07%2F1a%2F22071a0b029ff968f6a7aa918e96e936.png&f=1&nofb=1'),
(7, 'Shrek', 'Par william steig', 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fimages.macmillan.com%2Ffolio-assets%2Fmacmillan_us_frontbookcovers_1000H%2F9781466833272.jpg&f=1&nofb=1'),
(8, 'Frigiel et fluffy', 'Ce livre a du chien', 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fmedia.standaardboekhandel.be%2F-%2Fmedia%2Fmdm%2Fproduct%2F9782375541180%2FfrontImagesLink.img%3Frev%3D2081201396%26hash%3D903AE77AA3E03DEB44E6E7D358B4B4FC&f=1&nofb=1'),
(9, 'Cahier Swan et Neo', 'Arrete', 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fmedia.cultura.com%2Fmedia%2Fcatalog%2Fproduct%2Fcache%2F1%2Fimage%2F1000x1000%2F9df78eab33525d08d6e5fb8d27136e95%2Fs%2Fw%2Fa%2Fswan-neo-cahier-de-textes-9782821212084_0.jpg%3Ft%3D1603193948&f=1&nofb=1'),
(11, 'Honda Tuning', 'Vroom vroom', 'https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2F4.bp.blogspot.com%2F_Rn49OLcM5Ts%2FTCFPLoear2I%2FAAAAAAAAApk%2FAhWNvtZ3Emw%2Fs1600%2Fhonda%2Btuning%2Bcover.jpg&f=1&nofb=1'),
(12, 'Lapin cretin', 'BWAAAAAAAHH', 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.manga-news.com%2Fpublic%2Fimages%2Fseries%2Fluminys-quest-temp.jpg&f=1&nofb=1');

-- --------------------------------------------------------

--
-- Structure de la table `Note`
--

CREATE TABLE `Note` (
  `id_note` int(11) NOT NULL,
  `note` int(11) DEFAULT NULL,
  `id_livre` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `Note`
--

INSERT INTO `Note` (`id_note`, `note`, `id_livre`, `id_user`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 0, 3, 1),
(8, 2, 6, 1),
(17, 0, 4, 1),
(18, 0, 4, 2),
(19, 0, 5, 15),
(20, 0, 5, 1),
(21, 2, 6, 15),
(22, 1, 7, 1),
(23, 0, 3, 15),
(24, 2, 11, 1),
(25, 1, 1, 15),
(26, 0, 4, 15),
(27, 1, 2, 16),
(28, 2, 7, 15),
(29, 1, 10, 1);

--
-- Déclencheurs `Note`
--
DELIMITER $$
CREATE TRIGGER `T_CacaChocolatMilka` BEFORE INSERT ON `Note` FOR EACH ROW BEGIN 
    IF((SELECT COUNT(*) FROM Note WHERE id_user = new.id_user AND id_livre = new.id_livre) > 0) 
    THEN
   		signal sqlstate '45000' set message_text = "DOUBLON"; 
   	END IF;
END
$$
DELIMITER ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Note`
--
ALTER TABLE `Note`
  ADD PRIMARY KEY (`id_note`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `livre`
--
ALTER TABLE `livre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `Note`
--
ALTER TABLE `Note`
  MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
