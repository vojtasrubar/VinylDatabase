-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Úte 14. kvě 2024, 10:24
-- Verze serveru: 10.4.28-MariaDB
-- Verze PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `vinyldatabase`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `heslo` varchar(255) NOT NULL,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`userid`, `username`, `heslo`, `jmeno`, `prijmeni`, `email`, `role`) VALUES
(1, 'vojta', 'vojta', 'Vojtěch', 'Šrubař', 'v.srubar.st@spseiostrava.cz', 'user'),
(2, 'vojtisek', 'vojta', 'Vojtěch', 'Šrubař', 'v.srubar.st@spseiostrava.cz', 'admin'),
(5, 'rostik', 'rosta', 'Rostislav', 'Peřina', 'r.perina.st@spseiostrava.cz', 'user');

-- --------------------------------------------------------

--
-- Struktura tabulky `vinyl`
--

CREATE TABLE `vinyl` (
  `idvinyl` int(11) NOT NULL,
  `nazev` varchar(100) NOT NULL,
  `umelec` varchar(100) NOT NULL,
  `DatumVydani` date NOT NULL,
  `zanr_zanrID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `vinyl`
--

INSERT INTO `vinyl` (`idvinyl`, `nazev`, `umelec`, `DatumVydani`, `zanr_zanrID`) VALUES
(1, 'ASTROWORLD', 'Travis Scott', '2018-08-03', 2),
(3, 'In Rainbows', 'Radiohead', '2007-12-28', 3);

-- --------------------------------------------------------

--
-- Struktura tabulky `vinyluzivatele`
--

CREATE TABLE `vinyluzivatele` (
  `vinyl_idvinyl` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `vinyluzivatele`
--

INSERT INTO `vinyluzivatele` (`vinyl_idvinyl`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `zanr`
--

CREATE TABLE `zanr` (
  `zanrID` int(11) NOT NULL,
  `NazevZanru` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Vypisuji data pro tabulku `zanr`
--

INSERT INTO `zanr` (`zanrID`, `NazevZanru`) VALUES
(1, 'Jazz'),
(2, 'Rap'),
(3, 'Rock'),
(4, 'Pop');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexy pro tabulku `vinyl`
--
ALTER TABLE `vinyl`
  ADD PRIMARY KEY (`idvinyl`);

--
-- Indexy pro tabulku `vinyluzivatele`
--
ALTER TABLE `vinyluzivatele`
  ADD PRIMARY KEY (`vinyl_idvinyl`,`user_id`);

--
-- Indexy pro tabulku `zanr`
--
ALTER TABLE `zanr`
  ADD PRIMARY KEY (`zanrID`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pro tabulku `vinyl`
--
ALTER TABLE `vinyl`
  MODIFY `idvinyl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `zanr`
--
ALTER TABLE `zanr`
  MODIFY `zanrID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
