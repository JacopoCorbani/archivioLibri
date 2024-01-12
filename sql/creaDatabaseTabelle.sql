-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              10.4.28-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dump della struttura del database archivio
CREATE DATABASE IF NOT EXISTS `archivio` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `archivio`;

-- Dump della struttura di tabella archivio.autori
CREATE TABLE IF NOT EXISTS `autori` (
  `cf` varchar(16) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `nazionalità` int(11) NOT NULL,
  `data_nascita` date DEFAULT NULL,
  PRIMARY KEY (`cf`),
  KEY `nazionalità` (`nazionalità`),
  CONSTRAINT `autori_ibfk_1` FOREIGN KEY (`nazionalità`) REFERENCES `nazioni` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella archivio.autori: ~8 rows (circa)
INSERT INTO `autori` (`cf`, `nome`, `cognome`, `nazionalità`, `data_nascita`) VALUES
	('BPMFLS87C43E376F', 'Bianca', 'TavernaPonte', 65, '2000-04-10'),
	('GRBJHN92F23Z352V', 'Jhon', 'Green', 182, '1992-02-23'),
	('HQKSXG77M44A198L', 'Mario', 'Caminetti', 34, '1687-05-04'),
	('KPSJML51E18L929J', 'steven', 'basalari', 81, '1989-04-10'),
	('LDTJDT71R48I037E', 'Giovanna', 'Biachi', 3, '1993-03-23'),
	('LNMKPL78H13C754I', 'Carolina', 'Lenz', 63, '1978-07-13'),
	('RSSMRA85M01H501Z', 'Maria', 'Rossi', 81, '1985-01-15'),
	('ZRXRZR39S70B996W', 'John', 'Smith', 158, '1856-05-04');

-- Dump della struttura di tabella archivio.autori_libri
CREATE TABLE IF NOT EXISTS `autori_libri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ISBN_Libro` varchar(10) NOT NULL,
  `cf_autore` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ISBN_Libro` (`ISBN_Libro`),
  KEY `cf_autore` (`cf_autore`),
  CONSTRAINT `autori_libri_ibfk_1` FOREIGN KEY (`ISBN_Libro`) REFERENCES `libri` (`ISBN`),
  CONSTRAINT `autori_libri_ibfk_2` FOREIGN KEY (`cf_autore`) REFERENCES `autori` (`cf`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella archivio.autori_libri: ~5 rows (circa)
INSERT INTO `autori_libri` (`id`, `ISBN_Libro`, `cf_autore`) VALUES
	(5, '5685544323', 'GRBJHN92F23Z352V'),
	(6, '0987654322', 'LNMKPL78H13C754I'),
	(7, '0987654321', 'RSSMRA85M01H501Z'),
	(8, '0990876543', 'LNMKPL78H13C754I'),
	(9, '0990876543', 'RSSMRA85M01H501Z');

-- Dump della struttura di tabella archivio.casa_editrice
CREATE TABLE IF NOT EXISTS `casa_editrice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `via` varchar(50) NOT NULL,
  `citta` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella archivio.casa_editrice: ~2 rows (circa)
INSERT INTO `casa_editrice` (`id`, `nome`, `via`, `citta`) VALUES
	(1, 'Zanichelli', 'via Irnerio 34', 'Bologna'),
	(2, 'Minerva', 'via montanara', 'Parma');

-- Dump della struttura di tabella archivio.clienti
CREATE TABLE IF NOT EXISTS `clienti` (
  `cf` varchar(16) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  PRIMARY KEY (`cf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella archivio.clienti: ~5 rows (circa)
INSERT INTO `clienti` (`cf`, `nome`, `cognome`) VALUES
	('CF12345678901234', 'Mario', 'Rossi'),
	('CF23456789012345', 'Luigi', 'Bianchi'),
	('CF34567890123456', 'Anna', 'Verdi'),
	('CF45678901234567', 'Paola', 'Neri'),
	('CF56789012345678', 'Roberto', 'Gialli');

-- Dump della struttura di tabella archivio.generi
CREATE TABLE IF NOT EXISTS `generi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genere` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `genere` (`genere`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella archivio.generi: ~16 rows (circa)
INSERT INTO `generi` (`id`, `genere`) VALUES
	(2, 'AUTOBIOGRAFIA'),
	(6, 'AVVENTURA'),
	(7, 'AZIONE'),
	(1, 'BIOGRAFIA'),
	(8, 'DISTOPIA'),
	(14, 'EROTICO'),
	(47, 'FANTASCIENZA'),
	(9, 'FANTASY'),
	(4, 'GIALLO'),
	(10, 'HORROR'),
	(12, 'ROMANZO DI FORMAZION'),
	(3, 'ROMANZO STORICO'),
	(48, 'ROSA'),
	(5, 'THRILLER'),
	(15, 'UMORISTICO'),
	(11, 'YOUNG ADULT');

-- Dump della struttura di tabella archivio.libri
CREATE TABLE IF NOT EXISTS `libri` (
  `ISBN` varchar(10) NOT NULL,
  `titolo` varchar(50) NOT NULL,
  `genere` int(11) NOT NULL,
  `prezzo` float NOT NULL CHECK (`prezzo` > 0),
  `anno_publicazione` int(11) DEFAULT NULL CHECK (`anno_publicazione` > 0),
  `id_casa_editrice` int(11) NOT NULL,
  PRIMARY KEY (`ISBN`),
  KEY `genere` (`genere`),
  KEY `id_casa_editrice` (`id_casa_editrice`),
  CONSTRAINT `libri_ibfk_1` FOREIGN KEY (`genere`) REFERENCES `generi` (`id`),
  CONSTRAINT `libri_ibfk_2` FOREIGN KEY (`id_casa_editrice`) REFERENCES `casa_editrice` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella archivio.libri: ~0 rows (circa)
INSERT INTO `libri` (`ISBN`, `titolo`, `genere`, `prezzo`, `anno_publicazione`, `id_casa_editrice`) VALUES
	('0987654321', 'frankestain', 47, 20.5, 1947, 2),
	('0987654322', 'superman', 9, 63.7, 1956, 2),
	('0990876543', 'i malavoglia', 3, 34.8, 1875, 1),
	('5685544323', 'cappuccetto rosso', 9, 10.2, 1975, 1);

-- Dump della struttura di tabella archivio.nazioni
CREATE TABLE IF NOT EXISTS `nazioni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_nazione` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella archivio.nazioni: ~191 rows (circa)
INSERT INTO `nazioni` (`id`, `nome_nazione`) VALUES
	(1, 'Afghanistan'),
	(2, 'Albania'),
	(3, 'Algeria'),
	(4, 'Andorra'),
	(5, 'Angola'),
	(6, 'Antigua e Barbuda'),
	(7, 'Argentina'),
	(8, 'Armenia'),
	(9, 'Australia'),
	(10, 'Austria'),
	(11, 'Azerbaigian'),
	(12, 'Bahamas'),
	(13, 'Bahrein'),
	(14, 'Bangladesh'),
	(15, 'Barbados'),
	(16, 'Bielorussia'),
	(17, 'Belgio'),
	(18, 'Belize'),
	(19, 'Benin'),
	(20, 'Bhutan'),
	(21, 'Bolivia'),
	(22, 'Bosnia ed Erzegovina'),
	(23, 'Botswana'),
	(24, 'Brasile'),
	(25, 'Brunei'),
	(26, 'Bulgaria'),
	(27, 'Burkina Faso'),
	(28, 'Burundi'),
	(29, 'Cabo Verde'),
	(30, 'Cambogia'),
	(31, 'Camerun'),
	(32, 'Canada'),
	(33, 'Ciad'),
	(34, 'Cile'),
	(35, 'Cina'),
	(36, 'Colombia'),
	(37, 'Comore'),
	(38, 'Congo'),
	(39, 'Costa d\'Avorio'),
	(40, 'Costa Rica'),
	(41, 'Croazia'),
	(42, 'Cuba'),
	(43, 'Cipro'),
	(44, 'Repubblica Ceca'),
	(45, 'Danimarca'),
	(46, 'Gibuti'),
	(47, 'Dominica'),
	(48, 'Repubblica Dominicana'),
	(49, 'Timor Est'),
	(50, 'Ecuador'),
	(51, 'Egitto'),
	(52, 'El Salvador'),
	(53, 'Guinea Equatoriale'),
	(54, 'Eritrea'),
	(55, 'Estonia'),
	(56, 'Etiopia'),
	(57, 'Figi'),
	(58, 'Finlandia'),
	(59, 'Francia'),
	(60, 'Gabon'),
	(61, 'Gambia'),
	(62, 'Georgia'),
	(63, 'Germania'),
	(64, 'Ghana'),
	(65, 'Grecia'),
	(66, 'Grenada'),
	(67, 'Guatemala'),
	(68, 'Guinea'),
	(69, 'Guinea-Bissau'),
	(70, 'Guyana'),
	(71, 'Haiti'),
	(72, 'Honduras'),
	(73, 'Ungheria'),
	(74, 'Islanda'),
	(75, 'India'),
	(76, 'Indonesia'),
	(77, 'Iran'),
	(78, 'Iraq'),
	(79, 'Irlanda'),
	(80, 'Israele'),
	(81, 'Italia'),
	(82, 'Giamaica'),
	(83, 'Giappone'),
	(84, 'Giordania'),
	(85, 'Kazakistan'),
	(86, 'Kenya'),
	(87, 'Kiribati'),
	(88, 'Kuwait'),
	(89, 'Kirghizistan'),
	(90, 'Laos'),
	(91, 'Lettonia'),
	(92, 'Libano'),
	(93, 'Lesotho'),
	(94, 'Liberia'),
	(95, 'Libia'),
	(96, 'Liechtenstein'),
	(97, 'Lituania'),
	(98, 'Lussemburgo'),
	(99, 'Macedonia del Nord'),
	(100, 'Madagascar'),
	(101, 'Malawi'),
	(102, 'Malaysia'),
	(103, 'Maldive'),
	(104, 'Mali'),
	(105, 'Malta'),
	(106, 'Isole Marshall'),
	(107, 'Mauritania'),
	(108, 'Mauritius'),
	(109, 'Messico'),
	(110, 'Micronesia'),
	(111, 'Moldova'),
	(112, 'Monaco'),
	(113, 'Mongolia'),
	(114, 'Montenegro'),
	(115, 'Marocco'),
	(116, 'Mozambico'),
	(117, 'Myanmar'),
	(118, 'Namibia'),
	(119, 'Nauru'),
	(120, 'Nepal'),
	(121, 'Paesi Bassi'),
	(122, 'Nuova Zelanda'),
	(123, 'Nicaragua'),
	(124, 'Niger'),
	(125, 'Nigeria'),
	(126, 'Corea del Nord'),
	(127, 'Norvegia'),
	(128, 'Oman'),
	(129, 'Pakistan'),
	(130, 'Palau'),
	(131, 'Panama'),
	(132, 'Papua Nuova Guinea'),
	(133, 'Paraguay'),
	(134, 'Perù'),
	(135, 'Filippine'),
	(136, 'Polonia'),
	(137, 'Portogallo'),
	(138, 'Qatar'),
	(139, 'Romania'),
	(140, 'Russia'),
	(141, 'Rwanda'),
	(142, 'Saint Kitts e Nevis'),
	(143, 'Santa Lucia'),
	(144, 'Saint Vincent e Grenadine'),
	(145, 'Samoa'),
	(146, 'San Marino'),
	(147, 'Sao Tome e Principe'),
	(148, 'Arabia Saudita'),
	(149, 'Senegal'),
	(150, 'Serbia'),
	(151, 'Seychelles'),
	(152, 'Sierra Leone'),
	(153, 'Singapore'),
	(154, 'Slovacchia'),
	(155, 'Slovenia'),
	(156, 'Isole Salomone'),
	(157, 'Somalia'),
	(158, 'Sud Africa'),
	(159, 'Corea del Sud'),
	(160, 'Sudan del Sud'),
	(161, 'Spagna'),
	(162, 'Sri Lanka'),
	(163, 'Sudan'),
	(164, 'Suriname'),
	(165, 'Svezia'),
	(166, 'Svizzera'),
	(167, 'Siria'),
	(168, 'Tagikistan'),
	(169, 'Tanzania'),
	(170, 'Thailandia'),
	(171, 'Togo'),
	(172, 'Tonga'),
	(173, 'Trinidad e Tobago'),
	(174, 'Tunisia'),
	(175, 'Turchia'),
	(176, 'Turkmenistan'),
	(177, 'Tuvalu'),
	(178, 'Uganda'),
	(179, 'Ucraina'),
	(180, 'Emirati Arabi Uniti'),
	(181, 'Regno Unito'),
	(182, 'Stati Uniti'),
	(183, 'Uruguay'),
	(184, 'Uzbekistan'),
	(185, 'Vanuatu'),
	(186, 'Città del Vaticano'),
	(187, 'Venezuela'),
	(188, 'Vietnam'),
	(189, 'Yemen'),
	(190, 'Zambia'),
	(191, 'Zimbabwe');

-- Dump della struttura di tabella archivio.prestiti
CREATE TABLE IF NOT EXISTS `prestiti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ISBN_Libro` varchar(10) NOT NULL,
  `cf_cliente` varchar(16) NOT NULL,
  `data_inizio` date NOT NULL,
  `data_fine` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella archivio.prestiti: ~4 rows (circa)
INSERT INTO `prestiti` (`id`, `ISBN_Libro`, `cf_cliente`, `data_inizio`, `data_fine`) VALUES
	(1, '0987654321', 'CF12345678901234', '2023-01-01', '2023-02-01'),
	(2, '0987654322', 'CF23456789012345', '2023-02-15', '2023-03-15'),
	(3, '0990876543', 'CF34567890123456', '2023-03-20', '2024-04-20'),
	(4, '0987654322', 'CF23456789012345', '2023-12-29', '2024-01-30');

-- Dump della struttura di tabella archivio.utenti
CREATE TABLE IF NOT EXISTS `utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `nomeUtente` varchar(20) NOT NULL,
  `passwordUtente` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomeUtente` (`nomeUtente`),
  UNIQUE KEY `passwordUtente` (`passwordUtente`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella archivio.utenti: ~1 rows (circa)
INSERT INTO `utenti` (`id`, `nome`, `cognome`, `nomeUtente`, `passwordUtente`) VALUES
	(1, 'Mario', 'Rossi', 'admin', '$2y$10$NEmcWGWg5SCJs3TlAniXmecIjhPfE/yabYG3xwncuJ7jCQCEO7sPq'),
	(2, 'Jacopo', 'Corbani', 'Corbisr', '$2y$10$CoQCZ/ctKaQLL10bCg1WdONqR3GttS31Ceh7zt/g/9J4yveIwPVA.');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
