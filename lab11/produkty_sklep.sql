-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 10 Sty 2024, 01:39
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `moja_strona`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty_sklep`
--

CREATE TABLE `produkty_sklep` (
  `id` int(11) NOT NULL,
  `tytul` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL,
  `data_utworzenia` date NOT NULL,
  `data_modyfikacji` date NOT NULL,
  `data_wygasniecia` date NOT NULL,
  `cena_netto` double NOT NULL,
  `podatek_vat` double NOT NULL,
  `dostepne_sztuki` int(11) NOT NULL,
  `status_dostepnosci` tinyint(1) NOT NULL DEFAULT 1,
  `kategoria` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `gabaryt_produktu` double NOT NULL,
  `zdjecie` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `produkty_sklep`
--
ALTER TABLE `produkty_sklep`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `produkty_sklep`
--
ALTER TABLE `produkty_sklep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
