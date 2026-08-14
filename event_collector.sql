-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Erstellungszeit: 14. Aug 2026 um 14:14
-- Server-Version: 8.0.44
-- PHP-Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `event_collector`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `event`
--

CREATE TABLE `event` (
  `ID_event` int NOT NULL,
  `date` date NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `booking_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `event`
--

INSERT INTO `event` (`ID_event`, `date`, `place`, `start_time`, `end_time`, `booking_link`, `title`, `created_at`, `updated_at`) VALUES
(1, '2029-01-29', 'Lübeck', '21:00:00', NULL, 'https://gruene-niedersachsen.de/termine/liste/?tribe-bar-date=2026-08-09', 'Grüneveranstaltung', '2026-08-07 07:23:27', '2026-08-07 07:23:27'),
(2, '2002-01-19', 'Lübeck', '19:20:00', '20:20:00', 'https://www.w3schools.com/sql/sql_insert.asp', 'Was Geht Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque ', '2026-08-07 09:46:31', '2026-08-07 09:46:31'),
(3, '2021-01-19', 'Lübeck', '19:20:00', '20:20:00', 'https://www.w3schools.com/sql/sql_insert.asp', 'Neue sachen sind neu darum ist der text neu', '2026-08-07 09:47:39', '2026-08-07 09:47:39'),
(4, '4000-01-19', 'Lübeck', '19:20:00', '20:20:00', 'https://www.w3schools.com/sql/sql_insert.asp', 'Was Geht ab es muss mehr werden ', '2026-08-07 11:35:30', '2026-08-07 11:35:30'),
(5, '1998-03-31', 'Hamburg', '11:00:00', NULL, 'https://www.boell.de/de/veranstaltungen', 'Keine Ahnung', '2026-08-10 11:55:44', '2026-08-10 11:55:44'),
(6, '1998-03-31', 'Hamburg', '16:00:00', NULL, 'https://www.boell.de/de/veranstaltungen', 'Keine Ahnung', '2026-08-10 11:55:54', '2026-08-10 11:55:54'),
(7, '1998-03-31', 'Hamburg', '11:00:00', NULL, 'https://www.boell.de/de/veranstaltungen', 'Keine Ahnung weiß ich wirklich net', '2026-08-10 11:55:56', '2026-08-10 11:55:56'),
(8, '1938-03-31', 'Hamburg', '11:00:00', NULL, 'https://www.boell.de/de/veranstaltungen', 'Keine Ahnung', '2026-08-10 11:56:08', '2026-08-10 11:56:08'),
(9, '2998-03-31', 'Hamburg', '16:00:00', NULL, 'https://www.boell.de/de/veranstaltungen', 'Keine Ahnung', '2026-08-10 11:56:15', '2026-08-10 11:56:15'),
(10, '1998-03-31', 'Hamburg', '11:00:00', NULL, 'https://www.boell.de/de/veranstaltungen', 'Keine Ahnung', '2026-08-10 11:56:39', '2026-08-10 11:56:39');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `scrape_logs`
--

CREATE TABLE `scrape_logs` (
  `id` int NOT NULL,
  `source_id` int NOT NULL,
  `status` enum('success','failed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `started_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `finished_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `source`
--

CREATE TABLE `source` (
  `ID_source` int NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scraper_rule` json NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `last_run` timestamp NULL DEFAULT NULL,
  `next_run` timestamp NULL DEFAULT NULL,
  `scrape_interval` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `ID_user` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`ID_event`);

--
-- Indizes für die Tabelle `scrape_logs`
--
ALTER TABLE `scrape_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `source_id` (`source_id`);

--
-- Indizes für die Tabelle `source`
--
ALTER TABLE `source`
  ADD PRIMARY KEY (`ID_source`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_user`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `event`
--
ALTER TABLE `event`
  MODIFY `ID_event` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `scrape_logs`
--
ALTER TABLE `scrape_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `source`
--
ALTER TABLE `source`
  MODIFY `ID_source` int NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `scrape_logs`
--
ALTER TABLE `scrape_logs`
  ADD CONSTRAINT `scrape_logs_ibfk_1` FOREIGN KEY (`source_id`) REFERENCES `source` (`ID_source`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
