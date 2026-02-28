-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Creato il: Feb 09, 2026 alle 07:18
-- Versione del server: 11.3.2-MariaDB-1:11.3.2+maria~ubu2204
-- Versione PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Chatroom`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Messaggi`
--

CREATE TABLE `Messaggi` (
  `ID` int(11) NOT NULL,
  `testo` text DEFAULT NULL,
  `data` timestamp NULL DEFAULT current_timestamp(),
  `nomeStanza` varchar(50) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Messaggi`
--

INSERT INTO `Messaggi` (`ID`, `testo`, `data`, `nomeStanza`, `user`) VALUES
(1, 'Ciao a tutti!', '2026-02-09 07:14:06', 'Generale', 'manu'),
(2, 'Benvenuti nella chat generale', '2026-02-09 07:14:06', 'Generale', 'santa'),
(3, 'Qualcuno per una partita?', '2026-02-09 07:14:06', 'Sport', 'pippo'),
(4, 'Forza Inter!', '2026-02-09 07:14:06', 'Sport', 'manu'),
(5, 'Domani verifica di informatica 😭', '2026-02-09 07:14:06', 'Scuola', 'manuzz'),
(6, 'Che musica state ascoltando?', '2026-02-09 07:14:06', 'Musica', 'santa'),
(7, 'Ultimo album top 🔥', '2026-02-09 07:14:06', 'Musica', 'pippo'),
(8, 'ciao', '2026-02-09 07:17:18', 'sistemi e reti', 'manuzzz');

-- --------------------------------------------------------

--
-- Struttura della tabella `Partecipa`
--

CREATE TABLE `Partecipa` (
  `nome` varchar(50) NOT NULL,
  `user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Partecipa`
--

INSERT INTO `Partecipa` (`nome`, `user`) VALUES
('Generale', 'manu'),
('Scuola', 'manu'),
('Sport', 'manu'),
('Generale', 'manuzz'),
('Scuola', 'manuzz'),
('sistemi e reti', 'manuzzz'),
('Generale', 'pippo'),
('Musica', 'pippo'),
('Sport', 'pippo'),
('Generale', 'santa'),
('Musica', 'santa'),
('sistemi e reti', 'santa');

-- --------------------------------------------------------

--
-- Struttura della tabella `Stanze`
--

CREATE TABLE `Stanze` (
  `nome` varchar(50) NOT NULL,
  `creatore` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Stanze`
--

INSERT INTO `Stanze` (`nome`, `creatore`) VALUES
('Generale', 'manu'),
('Scuola', 'manuzz'),
('sistemi e reti', 'manuzzz'),
('Sport', 'pippo'),
('Musica', 'santa');

-- --------------------------------------------------------

--
-- Struttura della tabella `Utenti`
--

CREATE TABLE `Utenti` (
  `user` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Utenti`
--

INSERT INTO `Utenti` (`user`, `password`) VALUES
('manu', '$2y$12$ibINM6oMzv4c2x7TS.zot.PYJ5tlJgPEDD5gsWK/FXYROcyK4Uube'),
('manuzz', '$2y$12$GzyxdxqKZAcbBXjub8eqSO3.M3JZeZILCIk/ATTkIf2KJGIloV04W'),
('manuzzz', '$2y$12$FX9Q/wLSmWtCSxGekxfN8Ofj5ROGna./K3O.6b2oEeGHkPphfw5Hi'),
('pippo', '$2y$12$SbwtYLFBY54J2XextJ32KOG6JnnxfmZFjcNaK21oSWwKIq2GZ5AxC'),
('santa', '$2y$12$dC4eZYsE4SJmDscs14iufOpGU.3HhXokk4nfqo6uSMlnaw519nhkC');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Messaggi`
--
ALTER TABLE `Messaggi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `nomeStanza` (`nomeStanza`),
  ADD KEY `user` (`user`);

--
-- Indici per le tabelle `Partecipa`
--
ALTER TABLE `Partecipa`
  ADD PRIMARY KEY (`nome`,`user`),
  ADD KEY `user` (`user`);

--
-- Indici per le tabelle `Stanze`
--
ALTER TABLE `Stanze`
  ADD PRIMARY KEY (`nome`),
  ADD KEY `creatore` (`creatore`);

--
-- Indici per le tabelle `Utenti`
--
ALTER TABLE `Utenti`
  ADD PRIMARY KEY (`user`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Messaggi`
--
ALTER TABLE `Messaggi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Messaggi`
--
ALTER TABLE `Messaggi`
  ADD CONSTRAINT `Messaggi_ibfk_1` FOREIGN KEY (`nomeStanza`) REFERENCES `Stanze` (`nome`),
  ADD CONSTRAINT `Messaggi_ibfk_2` FOREIGN KEY (`user`) REFERENCES `Utenti` (`user`);

--
-- Limiti per la tabella `Partecipa`
--
ALTER TABLE `Partecipa`
  ADD CONSTRAINT `Partecipa_ibfk_1` FOREIGN KEY (`nome`) REFERENCES `Stanze` (`nome`),
  ADD CONSTRAINT `Partecipa_ibfk_2` FOREIGN KEY (`user`) REFERENCES `Utenti` (`user`);

--
-- Limiti per la tabella `Stanze`
--
ALTER TABLE `Stanze`
  ADD CONSTRAINT `Stanze_ibfk_1` FOREIGN KEY (`creatore`) REFERENCES `Utenti` (`user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
