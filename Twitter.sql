-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 05 Lis 2016, 15:05
-- Wersja serwera: 5.5.49-0ubuntu0.14.04.1
-- Wersja PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `Twitter`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Tweet`
--

CREATE TABLE IF NOT EXISTS `Tweet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `content` varchar(140) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Zrzut danych tabeli `Tweet`
--

INSERT INTO `Tweet` (`id`, `user_id`, `content`, `creation_date`) VALUES
(1, 16, 'nowy tweet', '2016-10-29 11:08:20'),
(2, 16, 'Oh oh jaki piękny dzień!', '2016-10-29 11:42:26'),
(3, 16, 'Kolejny piękny dzień z PHP', '2016-10-29 11:42:42'),
(4, 15, 'a mój dzień mniej piękny', '2016-10-29 13:34:46'),
(5, 16, 'testestestt', '2016-10-29 16:58:38'),
(6, 19, 'nowy tweet', '2016-11-05 08:50:46');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Zrzut danych tabeli `Users`
--

INSERT INTO `Users` (`id`, `email`, `name`, `hashed_password`) VALUES
(2, 'damian.graver@gmail.com', 'Damian', '$2y$10$TWRsb40O.OxoDOnDDeOBjObqu3/qAVQlc32jfewLfimbFNezhyVES'),
(3, 'user@gmail.com', 'User 1', '$2y$10$MJ7dNrp9WfaQkG/N0Dmf/uKaDeDnTL6gRcavs/dUjmuWCZKJ7Ypce'),
(4, 'user2@gmail.com', 'user2', '$2y$10$d3v3jJzMfLc/.1Rl//.I/.uX0H91Y8HTPHHonS4s9Jfc0xVxz5sqO'),
(5, 'user3@gmail.com', 'user3', '$2y$10$ZMMikcEW5BtrbWLjSOEpUe/N4M9gnjajVnppJGfi5wbtuI1W3Xitu'),
(7, 'user4@gmail.com', 'user4', '$2y$10$NOp/g3Yl8NVJILaJEXu9EO65jeK9WaJjZ6x5q3wsTRf4zsRKOKKm.'),
(8, 'milena@gmail.com', 'milena', '$2y$10$jqKamfyGStrpbEz3WLqvBeP1241u740cBElxGY4C0wzf4ZioBexeG'),
(9, 'milena2gmail.com', 'milena2', '$2y$10$FbpyQrCChJTNlIBolcJRT.iNCwpPiz0fvQIyklKUMHZbUikQSL9n6'),
(10, 'test123@gmail.com', 'test123', '$2y$10$TxATCBvDE6OG1fgFpsrH1ObNp7rbuJK4xBoV0UvZ6qw7Y.Kxq0N1u'),
(12, 'test@fds.pl', 'testtest', '$2y$10$i4g12KDU.D9gufgI6nTWfOkRNzCGAweqCEEKM4xrGV6m08vdYepLK'),
(14, 'sdfsfs@dsfsdf', 'dsfsdfsf', '$2y$10$yAUg7eTwJ.5wbykfDb3NDusUQiod9RUwQQX73pZgKJGtdTR4r1Zz.'),
(15, 'test22@gmal.com', 'test222', '$2y$10$LIgbxrjpEAMArshaQICI.uinVHFn5qiuP.YN5gsH9fqU0PC9iWFPC'),
(16, 'damian@gmail.com', 'damianda', '$2y$10$hvMMgcALFMkQ2MxWina/ZOpZ75ZnmU7OwMLju7EQERl37tx2JBHOO'),
(17, 'bartosz@gmail.com', 'bartosz', '$2y$10$0fzNOs/whcsSwdp.AK8p5ORr1yOxBsWdjT592yJTL0B4zIb5P9bIC'),
(18, 'bla@gmail.com', 'blabla', '$2y$10$D6L0tHksYAvoVaqXatdVPexj98g.X5r5F8woShgY3UvSCY2XZHkbm'),
(19, 'damian.graver123@gmail.com', 'damian', '$2y$10$Buht3/WalBE2tDVht29aBeAshN7zDz59d9s3fhBWFRanTbv2q.cL.');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Tweet`
--
ALTER TABLE `Tweet`
  ADD CONSTRAINT `Tweet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
