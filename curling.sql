-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 19, 2013 at 03:09 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `curling`
--

-- --------------------------------------------------------

--
-- Table structure for table `druzyna`
--

CREATE TABLE IF NOT EXISTS `druzyna` (
  `id_druzyna` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(45) DEFAULT NULL,
  `typ` varchar(10) DEFAULT NULL,
  `plec` varchar(1) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_druzyna`),
  UNIQUE KEY `id_druzyna_UNIQUE` (`id_druzyna`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `druzyna`
--

INSERT INTO `druzyna` (`id_druzyna`, `nazwa`, `typ`, `plec`, `photo`) VALUES
(1, 'Team Scotland', 'senior', 'K', 'img/flags/SCO.jpg'),
(2, 'Team Russia', 'senior', 'K', 'img/flags/RUS.jpg'),
(3, 'Team Norway', 'senior', 'K', 'img/flags/NOR.jpg'),
(4, 'Team Italy', 'senior', 'K', 'img/flags/ITA.jpg'),
(5, 'Team Mix Fix', 'senior', 'X', 'img/flags/140px-Winged_Goombo.png'),
(6, 'Team Denmark', 'senior', 'K', 'img/flags/DEN.jpg'),
(7, 'Team Switzerland', 'senior', 'K', 'img/flags/SUI.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `game_end_stat`
--

CREATE TABLE IF NOT EXISTS `game_end_stat` (
  `id_mecz` int(11) NOT NULL,
  `id_druzyna` int(11) NOT NULL,
  `end_1` varchar(1) DEFAULT NULL,
  `end_2` varchar(1) DEFAULT NULL,
  `end_3` varchar(1) DEFAULT NULL,
  `end_4` varchar(1) DEFAULT NULL,
  `end_5` varchar(1) DEFAULT NULL,
  `end_6` varchar(1) DEFAULT NULL,
  `end_7` varchar(1) DEFAULT NULL,
  `end_8` varchar(1) DEFAULT NULL,
  `end_9` varchar(1) DEFAULT NULL,
  `end_10` varchar(1) DEFAULT NULL,
  `end_11` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_mecz`,`id_druzyna`),
  KEY `id_druzyna_idx` (`id_druzyna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `game_end_stat`
--

INSERT INTO `game_end_stat` (`id_mecz`, `id_druzyna`, `end_1`, `end_2`, `end_3`, `end_4`, `end_5`, `end_6`, `end_7`, `end_8`, `end_9`, `end_10`, `end_11`) VALUES
(1, 1, '0', '1', '1', '2', '0', '6', '0', '1', 'X', 'X', NULL),
(1, 2, '1', '0', '0', '0', '2', '0', '2', '0', 'X', 'X', NULL),
(2, 3, '1', '2', '3', '0', '4', '0', '0', '1', '1', 'X', NULL),
(2, 4, '0', '0', '0', '2', '0', '1', '1', '0', '0', 'X', NULL),
(3, 6, '0', '1', '0', '0', '0', '2', '1', '0', '1', '0', NULL),
(3, 7, '0', '0', '2', '2', '2', '0', '0', '1', '0', '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kraj`
--

CREATE TABLE IF NOT EXISTS `kraj` (
  `id_kraj` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(45) NOT NULL,
  `img` varchar(265) DEFAULT NULL,
  `akronym` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id_kraj`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `kraj`
--

INSERT INTO `kraj` (`id_kraj`, `nazwa`, `img`, `akronym`) VALUES
(1, 'Szkocja', 'img/flags/SCO.jpg', 'sco'),
(2, 'Rosja', 'img/flags/RUS.jpg', 'rus'),
(3, 'Szwajcaria', 'img/flags/SUI.jpg', 'sui'),
(4, 'Dania', 'img/flags/DEN.jpg', 'den'),
(5, 'Szwecja', 'img/flags/SWE.jpg', 'swe'),
(6, 'Czechy', 'img/flags/CZE.jpg', 'cze'),
(7, 'Niemcy', 'img/flags/GER.jpg', 'ger'),
(8, 'Włochy', 'img/flags/ITA.jpg', 'ita'),
(9, 'Łotwa', 'img/flags/LAT.jpg', 'lat'),
(10, 'Norwegia', 'img/flags/NOR.jpg', 'nor'),
(12, 'Chile', 'img/flags/CHL.png', 'chl'),
(13, 'Chiny', 'img/flags/CHN.png', 'chn'),
(14, 'Kanada', 'img/flags/CND.png', 'can');

-- --------------------------------------------------------

--
-- Table structure for table `mecz`
--

CREATE TABLE IF NOT EXISTS `mecz` (
  `id_mecz` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `hammer` int(11) DEFAULT NULL,
  `LSD` decimal(5,2) DEFAULT NULL,
  `sheet` varchar(1) DEFAULT NULL,
  `id_druzyna_1` int(11) NOT NULL,
  `id_druzyna_2` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `id_turniej` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_mecz`),
  KEY `id_status_idx` (`status`),
  KEY `id_druzyna_1_idx` (`id_druzyna_1`),
  KEY `id_druzyna_2_idx` (`id_druzyna_2`),
  KEY `id_turniej_idx` (`id_turniej`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mecz`
--

INSERT INTO `mecz` (`id_mecz`, `data`, `hammer`, `LSD`, `sheet`, `id_druzyna_1`, `id_druzyna_2`, `status`, `id_turniej`) VALUES
(1, '2013-11-23', 1, 56.80, 'A', 1, 2, 2, 1),
(2, '2013-11-23', 3, 0.00, 'B', 3, 4, 2, 1),
(3, '2013-11-23', 6, 15.90, 'C', 6, 7, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `opis` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id_status`, `opis`) VALUES
(1, 'live'),
(2, 'finished');

-- --------------------------------------------------------

--
-- Table structure for table `turniej`
--

CREATE TABLE IF NOT EXISTS `turniej` (
  `id_turniej` int(11) NOT NULL,
  `nazwa` varchar(45) NOT NULL,
  `klasa` varchar(45) DEFAULT NULL,
  `data_od` date DEFAULT NULL,
  `data_do` date DEFAULT NULL,
  `miasto` varchar(45) DEFAULT NULL,
  `kraj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_turniej`),
  KEY `fk_turKraj` (`kraj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `turniej`
--

INSERT INTO `turniej` (`id_turniej`, `nazwa`, `klasa`, `data_od`, `data_do`, `miasto`, `kraj`) VALUES
(1, 'European Curling Championships 2013', 'European Championship', '2013-11-23', '2013-12-01', 'Stavanger', 10),
(2, 'World Women''s Curling Championship 2013', 'World Championship', '2013-03-16', '2013-03-24', 'Riga', 9),
(3, '2014 Ford World Women''s Curling Championship', 'World Championship', '2014-03-15', '2014-03-23', ' Saint John', 14);

-- --------------------------------------------------------

--
-- Table structure for table `wyniki`
--

CREATE TABLE IF NOT EXISTS `wyniki` (
  `id_druzyny` int(11) NOT NULL,
  `rozegrane` int(11) DEFAULT NULL,
  `zwyciestwa` int(11) DEFAULT NULL,
  `porazki` int(11) DEFAULT NULL,
  `id_turniej` int(11) NOT NULL,
  PRIMARY KEY (`id_druzyny`,`id_turniej`),
  KEY `id_turnieju_idx` (`id_turniej`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wyniki`
--

INSERT INTO `wyniki` (`id_druzyny`, `rozegrane`, `zwyciestwa`, `porazki`, `id_turniej`) VALUES
(1, 1, 1, 0, 1),
(2, 1, 0, 1, 1),
(3, 1, 1, 0, 1),
(4, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `zawodnik`
--

CREATE TABLE IF NOT EXISTS `zawodnik` (
  `id_zawodnik` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(45) NOT NULL,
  `nazwisko` varchar(45) NOT NULL,
  `data_ur` date DEFAULT NULL,
  `plec` varchar(1) NOT NULL,
  `photo` varchar(256) DEFAULT NULL,
  `kierunek` varchar(1) DEFAULT NULL,
  `id_kraj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_zawodnik`),
  UNIQUE KEY `id_zawodnik_UNIQUE` (`id_zawodnik`),
  KEY `id_kraj_idx` (`id_kraj`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `zawodnik`
--

INSERT INTO `zawodnik` (`id_zawodnik`, `imie`, `nazwisko`, `data_ur`, `plec`, `photo`, `kierunek`, `id_kraj`) VALUES
(1, 'Eve', 'Muirhead', '1990-04-22', 'K', 'SCO01-Eve-Muirhead.jpg', 'R', 1),
(2, 'Anna', 'Sloan', '1991-02-05', 'K', 'SCO02-Anna-Sloan.jpg', 'L', 1),
(3, 'Vicki', 'Adams', '1989-11-16', 'K', 'SCO03-Vicki-Adams.jpg', 'R', 1),
(4, 'Claire', 'Hamilton', '1989-01-31', 'K', 'SCO04-Claire-Hamilton.jpg', 'R', 1),
(5, 'Lauren', 'Gray', '1991-11-03', 'K', 'SCO05-Lauren-Gray.jpg', 'R', 1),
(6, 'Anna', 'Sidorova', '1991-02-06', 'K', 'RUS01-Anna-Sidorova.jpg', 'R', 2),
(7, 'Margarita', 'Fomina', '1988-08-19', 'K', 'RUS02-Margarita-Fomina.jpg', 'R', 2),
(8, 'Alexandra', 'Saitova', '1992-08-20', 'K', 'RUS03-Alexandra-Saitova.jpg', 'R', 2),
(9, 'Ekaterina', 'Galkina', '1988-08-10', 'K', 'RUS04-Ekaterina-Galkina.jpg', 'R', 2),
(10, 'Nkeiruka', 'Ezekh', '1983-10-17', 'K', 'RUS05-Nkeiruka-Ezekh.jpg', 'R', 2),
(11, 'Marianne', 'Roervik', '1983-08-02', 'K', 'NOR01-Marianne-Rorvik.jpg', 'R', 10),
(12, 'Anneline', 'Skaarsmoen', '1989-01-23', 'K', 'NOR02-Anneline-Skarsmoen.jpg', 'R', 10),
(13, 'Camilla', 'Holth', '1978-12-25', 'K', 'NOR03-Camilla-Holth.jpg', 'R', 10),
(14, 'Julie Kjaer', 'Molnar', '1993-07-13', 'K', 'NOR04-Julie-KjaerMolnar.jpg', 'L', 10),
(15, 'Pia ', 'Trulsen', '1991-04-09', 'K', 'NOR05-Pia-Trulsen.jpg', 'R', 10),
(16, 'Veronica', 'Zappone', '1993-04-11', 'K', 'IT01-Veronica-Zappone.jpg', 'R', 8),
(17, 'Sara', 'Levetti', '1991-10-31', 'K', 'IT02-Sara-Levetti.jpg', 'R', 8),
(18, 'Elisa', 'Patono', '1995-05-01', 'K', 'IT03-Elisa-Patono.jpg', 'L', 8),
(19, 'Arianna', 'Losano', '1994-06-13', 'K', 'IT04-Arianna-Losano.jpg', 'L', 8),
(20, 'Martina', 'Bronsino', '1996-11-07', 'K', 'IT05-Martina-Bronsino.jpg', 'R', 8),
(21, 'Anna', 'Kubeskova', '1989-10-30', 'K', '21-Tereza-Pliskova.jpg', 'L', 6),
(22, 'Tereza', 'Pliskova', '1990-02-06', 'K', '22-Tereza-Pliskova.jpg', 'R', 6),
(23, 'Martina', 'Strnadova', '1990-01-17', 'K', '23-Martina-Strnadova.jpg', 'R', 6),
(24, 'Klara', 'Svatonova', '1993-01-24', 'K', '24-Klara-Svatonova.jpg', 'R', 6),
(25, 'Veronika', 'Herdova', '1988-12-11', 'K', '25-Veronika-Herdova.jpg', 'R', 6),
(26, 'Lene', 'Nielsen', '1986-08-31', 'K', '26-Lene-Nielsen.jpg', 'R', 4),
(27, 'Helle', 'Simonsen', '1984-09-07', 'K', '27-Helle-Simonsen.jpg', 'R', 4),
(28, 'Jeanne', 'Ellegaard', '1987-07-02', 'K', '28-Jeanne-Ellegaard.jpg', 'R', 4),
(29, 'Maria', 'Poulsen', '1984-10-29', 'K', '29-Maria-Poulsen.jpg', 'R', 4),
(30, 'Mette', 'Neergaard', '1991-11-06', 'K', '30-Mette-Neergaard.jpg', 'R', 4),
(31, 'Andrea', 'Schoepp', '1965-02-27', 'K', '31-Andrea-Schoepp.jpg', 'R', 7),
(32, 'Imogen Oona', 'Lehmann', '1989-12-30', 'K', '32-ImogenOona-Lehmann.jpg', 'R', 7),
(33, 'Corinna', 'Scholz', '1989-08-01', 'K', '33-Corinna-Scholz.jpg', 'R', 7),
(34, 'Nicole', 'Muskatewitz', '1994-08-06', 'K', '34-Nicole-Muskatewitz.jpg', 'R', 7),
(35, 'Stella', 'Heiss', '1993-01-15', 'K', '35-Stella-Heiss.jpg', 'R', 7),
(36, 'Evita', 'Regza', '1982-10-26', 'K', '36-Evita-Regza.jpg', 'R', 9),
(37, 'Dace', 'Regza', '1962-04-25', 'K', '37-Dace-Regza.jpg', 'R', 9),
(38, 'Ieva', 'Berzina', '1967-11-19', 'K', '38-Ieva-Berzina.jpg', 'R', 9),
(39, 'Zaklina', 'Litauniece', '1968-11-20', 'K', '39-Zaklina-Litauniece.jpg', 'R', 9),
(40, 'Iluta', 'Linde', '1972-01-14', 'K', '40-Iluta-Linde.jpg', 'R', 9),
(41, 'Maria', 'Prytz', '1976-10-18', 'K', '41-Maria-Prytz.jpg', 'R', 5),
(42, 'Christina', 'Bertrup', '1976-12-23', 'K', '42-Christina-Bertrup.jpg', 'R', 5),
(43, 'Maria', 'Wennerstroem', '1985-04-10', 'K', '43-Maria-Wennerstroem.jpg', 'R', 5),
(44, 'Margaretha', 'Sigfridsson', '1976-01-28', 'K', '44-Margaretha-Sigfridsson.jpg', 'R', 5),
(45, 'Agnes', 'Knochenhauer', '1989-05-05', 'K', '45-Agnes-Knochenhauer.jpg', 'R', 5),
(46, 'Mirjam', 'Ott', '1972-01-27', 'K', '46-Mirjam-Ott.jpg', 'R', 3),
(47, 'Carmen', 'Schaeffer', '1981-01-08', 'K', '47-Carmen-Schaeffer.jpg', 'R', 3),
(48, 'Carmen', 'Kueng', '1978-01-30', 'K', '48-Carmen-Kueng.jpg', 'R', 3),
(49, 'Janine', 'Greiner', '1981-02-13', 'K', '49-Janine-Greiner.jpg', 'R', 3),
(50, 'Alina', 'Paetz', '1990-03-08', 'K', '50-Alina-Paetz.jpg', 'R', 3),
(52, 'Jan', 'Kowalski', '2013-12-11', 'M', NULL, 'L', 12),
(53, 'Maria', 'Nowak', '2013-12-11', 'K', NULL, 'R', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zawodnik_druzyna`
--

CREATE TABLE IF NOT EXISTS `zawodnik_druzyna` (
  `id_zawodnik` int(11) NOT NULL AUTO_INCREMENT,
  `id_druzyna` int(11) NOT NULL,
  `data_od` date DEFAULT NULL,
  `data_do` date DEFAULT NULL,
  `pozycja` varchar(1) DEFAULT NULL,
  `funkcja` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_zawodnik`,`id_druzyna`),
  KEY `id_druzyna_idx` (`id_druzyna`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `zawodnik_druzyna`
--

INSERT INTO `zawodnik_druzyna` (`id_zawodnik`, `id_druzyna`, `data_od`, `data_do`, `pozycja`, `funkcja`) VALUES
(1, 1, '2007-10-10', NULL, '4', 'S'),
(1, 5, '2013-12-01', NULL, '4', 'S'),
(2, 1, '2007-10-10', NULL, '3', 'V'),
(3, 1, '2007-10-10', NULL, '2', NULL),
(4, 1, '2007-10-10', NULL, '1', NULL),
(5, 1, '2007-10-10', NULL, 'A', NULL),
(6, 2, '2008-11-11', NULL, '4', 'S'),
(7, 2, '2008-11-11', NULL, '3', 'V'),
(8, 2, '2008-11-11', NULL, '2', NULL),
(8, 5, '2009-11-04', NULL, '3', 'V'),
(9, 2, '2008-11-11', NULL, '1', NULL),
(10, 2, '2008-11-11', NULL, 'A', NULL),
(11, 3, '2012-05-30', NULL, '4', 'S'),
(12, 3, '2012-05-30', NULL, '3', 'V'),
(13, 3, '2012-05-30', NULL, '2', NULL),
(14, 3, '2012-05-30', NULL, '1', NULL),
(14, 5, '2009-11-04', NULL, '3', NULL),
(15, 3, '2012-05-30', NULL, 'A', NULL),
(16, 4, '2011-07-01', NULL, '4', 'S'),
(17, 4, '2011-07-01', NULL, '3', 'V'),
(18, 4, '2011-07-01', NULL, '2', NULL),
(19, 4, '2011-07-01', NULL, '1', NULL),
(20, 4, '2011-07-01', NULL, 'A', NULL),
(26, 6, '2009-11-04', NULL, '4', 'S'),
(27, 6, '2009-11-04', NULL, '3', NULL),
(28, 6, '2009-11-04', NULL, '2', 'V'),
(29, 6, '2011-12-01', NULL, '1', NULL),
(30, 6, '2009-11-04', NULL, 'A', NULL),
(46, 7, '2009-11-04', NULL, 'A', 'S'),
(47, 7, '2009-11-04', NULL, '3', 'V'),
(48, 7, '2009-11-04', NULL, '2', NULL),
(49, 7, '2009-11-04', NULL, '1', NULL),
(50, 7, '2009-11-04', NULL, 'A', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `game_end_stat`
--
ALTER TABLE `game_end_stat`
  ADD CONSTRAINT `fk_id_druzyna` FOREIGN KEY (`id_druzyna`) REFERENCES `druzyna` (`id_druzyna`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_mecz` FOREIGN KEY (`id_mecz`) REFERENCES `mecz` (`id_mecz`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `mecz`
--
ALTER TABLE `mecz`
  ADD CONSTRAINT `id_druzyna_1` FOREIGN KEY (`id_druzyna_1`) REFERENCES `druzyna` (`id_druzyna`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_druzyna_2` FOREIGN KEY (`id_druzyna_2`) REFERENCES `druzyna` (`id_druzyna`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_status` FOREIGN KEY (`status`) REFERENCES `status` (`id_status`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_turniej` FOREIGN KEY (`id_turniej`) REFERENCES `turniej` (`id_turniej`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `turniej`
--
ALTER TABLE `turniej`
  ADD CONSTRAINT `fk_turKraj` FOREIGN KEY (`kraj`) REFERENCES `kraj` (`id_kraj`);

--
-- Constraints for table `wyniki`
--
ALTER TABLE `wyniki`
  ADD CONSTRAINT `id_druzyny` FOREIGN KEY (`id_druzyny`) REFERENCES `druzyna` (`id_druzyna`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_turnieju` FOREIGN KEY (`id_turniej`) REFERENCES `turniej` (`id_turniej`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `zawodnik`
--
ALTER TABLE `zawodnik`
  ADD CONSTRAINT `id_kraj` FOREIGN KEY (`id_kraj`) REFERENCES `kraj` (`id_kraj`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `zawodnik_druzyna`
--
ALTER TABLE `zawodnik_druzyna`
  ADD CONSTRAINT `id_druzyna` FOREIGN KEY (`id_druzyna`) REFERENCES `druzyna` (`id_druzyna`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_zawodnik` FOREIGN KEY (`id_zawodnik`) REFERENCES `zawodnik` (`id_zawodnik`) ON DELETE NO ACTION ON UPDATE NO ACTION;

  
CREATE USER 'curling_user'@'localhost' IDENTIFIED BY 'qwerty'; 
GRANT SELECT , INSERT , UPDATE , DELETE ON `curling` . * TO 'curling_user'@'localhost';
  
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
