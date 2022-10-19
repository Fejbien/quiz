-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Paź 2022, 08:55
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `quiz`
--
CREATE DATABASE IF NOT EXISTS `quiz` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `quiz`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `anserws`
--

CREATE TABLE `anserws` (
  `id` int(11) NOT NULL,
  `anserw` longtext DEFAULT NULL,
  `is_correct` tinyint(4) DEFAULT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `anserws`
--

INSERT INTO `anserws` (`id`, `anserw`, `is_correct`, `question_id`) VALUES
(1, '7', NULL, 1),
(2, '13', 1, 1),
(3, '13', 1, 1),
(4, '49', NULL, 1),
(5, 'widomy', NULL, 2),
(6, 'niewidomy', 1, 2),
(7, 'gluchy', NULL, 2),
(8, 'nie widzacy', 1, 2),
(9, '\"', NULL, 3),
(10, 'zaprzeczenie jako znak', 1, 3),
(11, '?', NULL, 3),
(12, '!', 1, 3),
(13, 'W', NULL, 3),
(14, '3', 1, 4),
(15, '1', NULL, 4),
(16, '2', NULL, 4),
(18, 'Nie', NULL, 5),
(19, 'Tak', 1, 5),
(20, 'Nie', NULL, 5),
(21, 'Tak', NULL, 6),
(22, 'Nie', 1, 6),
(23, 'Tak', NULL, 6),
(24, 'a', NULL, 7),
(25, 'b', NULL, 7),
(26, 'c', 1, 7),
(29, 'a', 1, 8),
(30, 'b', NULL, 8),
(31, 'c', NULL, 8),
(38, '65', NULL, 9),
(39, '5', 1, 9),
(40, '5', 1, 9),
(41, '4', NULL, 9),
(42, '5', 1, 9),
(43, 'o', NULL, 10),
(44, 'p', 1, 10),
(45, 'p', 1, 10),
(46, 'p', 1, 10),
(47, 'n', NULL, 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `questions`
--

INSERT INTO `questions` (`id`, `question`) VALUES
(1, 'Ile to jest 4+9?'),
(2, 'Kto jest niewidomy?'),
(3, 'Znak negacji?'),
(4, 'Ile ma to odpowiedzi?'),
(5, 'Czy tak?'),
(6, 'Czy nie?'),
(7, 'c?'),
(8, 'a?'),
(9, 'Ile to ma?'),
(10, 'p?');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `right` int(11) NOT NULL,
  `wrong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `name`, `right`, `wrong`) VALUES
(1, 'Fabian', 17, 7),
(2, 'Cezar', 5, 30);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `anserws`
--
ALTER TABLE `anserws`
  ADD PRIMARY KEY (`id`,`question_id`),
  ADD KEY `fk_odpowiedzi_pytania_idx` (`question_id`);

--
-- Indeksy dla tabeli `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `anserws`
--
ALTER TABLE `anserws`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT dla tabeli `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `anserws`
--
ALTER TABLE `anserws`
  ADD CONSTRAINT `fk_odpowiedzi_pytania` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
