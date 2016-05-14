-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2016 at 03:02 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zakaria_tp`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_auteur` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text,
  `date_creation` datetime NOT NULL,
  `statue` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`ID`, `ID_auteur`, `titre`, `contenu`, `date_creation`, `statue`, `id_cat`) VALUES
(1, 3, 'le 1er article', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2016-05-10 08:51:54', 1, 0),
(2, 3, 'article en attente', 'psssst', '2016-05-11 08:18:33', 1, 0),
(4, 5, 'art1', 'arti1', '2016-05-12 10:26:28', 1, 0),
(5, 5, 'art2', 'art2', '2016-05-12 10:26:35', 1, 0),
(6, 5, 'art3', 'art3', '2016-05-12 10:26:40', 1, 0),
(7, 7, 'Article tech', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2016-05-13 09:10:30', 1, 4),
(12, 12, 'test email 5', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometime', '2016-05-14 12:03:31', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  `cat_label` text NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_cat`, `cat_label`) VALUES
(4, 'Tech');

-- --------------------------------------------------------

--
-- Table structure for table `commentaires`
--

CREATE TABLE IF NOT EXISTS `commentaires` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_utilisateur` int(11) NOT NULL,
  `ID_article` int(11) NOT NULL,
  `contenu_com` text,
  `date_commentaire` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `commentaires`
--

INSERT INTO `commentaires` (`ID`, `ID_utilisateur`, `ID_article`, `contenu_com`, `date_commentaire`) VALUES
(1, 3, 1, 'bull shit', '2016-05-17 00:00:00'),
(2, 3, 1, 'c''est un comment ', '2016-05-11 07:19:58'),
(3, 3, 1, 'sshshshsht', '2016-05-11 07:28:47'),
(4, 3, 1, 'c''est trop long ! ', '2016-05-11 07:52:13'),
(5, 6, 7, 'Nice', '2016-05-13 09:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_de_naissance` text NOT NULL,
  `statut` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`ID`, `nom`, `prenom`, `sexe`, `mail`, `password`, `date_de_naissance`, `statut`) VALUES
(10, 'zaki', 'oro', 'masculine', 'zakarab@outlook.com', 'u42JzjTfsYG/9+7HG0fqzQeyhN2Ybos3yKitk2ii0qw=', '25-06-1994', 'admin'),
(12, 'test', 'test', 'masculine', 'testnewsnl@gmail.com', 'u42JzjTfsYG/9+7HG0fqzQeyhN2Ybos3yKitk2ii0qw=', '23-05-1995', 'Membre'),
(13, 'test', 'test', 'masculine', 'test@test.com', 'u42JzjTfsYG/9+7HG0fqzQeyhN2Ybos3yKitk2ii0qw=', '23-05-1995', 'Membre');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
