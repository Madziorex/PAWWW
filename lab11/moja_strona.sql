-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 16 Sty 2024, 19:50
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
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(11) NOT NULL,
  `matka` int(11) DEFAULT 0,
  `nazwa` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `page_content` text COLLATE utf8_polish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`) VALUES
(1, 'glowna.html', 'Wiedźmin 3: Dziki Gon jest fabularną grą akcji z otwartym światem. Gracz steruje postacią Geralta z Rivii z perspektywy trzeciej osoby. W niektórych fragmentach gry gracz wciela się w postać Ciri. Poza poruszaniem się po lądzie można także pływać zarówno na jak i pod powierzchnią wody. Gra jest kontynuacją wydanego w 2007 roku Wiedźmina oraz Wiedźmina 2: Zabójców królów, który miał swoją premierę w 2011 roku. Tak jak poprzednie części, opowiada ona historię tytułowego wiedźmina – Geralta z Rivii – i jest osadzona w świecie wiedźmina, którego twórcą jest Andrzej Sapkowski. Produkcja jest ostatnią częścią cyklu, którego głównym bohaterem jest tytułowy wiedźmin, razem z nią stanowiącego trylogię.', 1),
(2, 'bazyliszek.html', '<h1>Bazyliczek</h1>\r\n<img src=\"./img/bazyliszek2.jpg\" style=\"float:left\" width=\"100\" height=\"120\">\r\n<img src=\"./img/bazyliszek1.jpg\" style=\"float:right\" width=\"200\" height=\"90\">\r\n<img src=\"./img/bazyliszek3.jpg\" style=\"float:right\" width=\"100\" height=\"50\">\r\n<p>\r\n    Tego straszliwego stwora unikają nawet niektóre smoki. \r\n    Jego skóra jest bardzo dobrym i bardzo drogim materiałem służącym do produkcji obuwia. \r\n    Istnieją mity mówiące o jego umiejętności zmiany ludzi w kamień za pomocą spojrzenia oraz o tym, \r\n    że bazyliszek rodzi się z jaja zniesionego przez koguta, a następnie wysiedzianego przez \r\n    sto i jednego jadowitego węża. Bazyliszki zarówno z wyglądu jak i charakteru są straszne i \r\n    bardzo agresywne przez co zaciekle walczą.\r\n</p>', 1),
(3, 'leszy.html', '<h1>Leszy</h1>\r\n<p>\r\n    <img src=\"./img/leszy1.png\" style=\"float:left\" width=\"200\" height=\"160\">\r\n    <img src=\"./img/leszy2.png\" style=\"float:right\" width=\"200\" height=\"100\">\r\n    <img src=\"./img/leszy3.png\" style=\"float:right\" width=\"100\" height=\"50\">\r\n    Potwór zamieszkujący świat Wiedźmina. Spotkać go można głównie w lasach i puszczach. \r\n    Potrafi teleportować się, oraz przybierać wiele form, zarówno humanoidalnych jak i zwierzęcych. \r\n    Młode osobniki wybierają na swoją siedzibę mniejsze lasy i puszcze, po czym budują tam swoje totemy, \r\n    których zawzięcie strzegą.\r\n</p>', 1),
(4, 'him.html', '<h1>Him</h1>\r\n<p>\r\n    <img src=\"./img/him1.png\" style=\"float:left\" width=\"100\" height=\"120\">\r\n    <img src=\"./img/him2.png\" style=\"float:right\" width=\"200\" height=\"90\">\r\n    <img src=\"./img/him3.png\" style=\"float:right\" width=\"100\" height=\"50\">\r\n    Niezwykle rzadki i niebezpieczny rodzaj demona, wiodący pasożytniczy tryb życia. \r\n    Na swoich żywicieli wybiera osoby, które popełniły okrutne zbrodnie. \r\n    Przemawia do ofiary poprzez głosy w głowie i sny, przejmując nad nim coraz większą kontrolę. \r\n    Wymusza na niej cierpienie, dzięki któremu rośnie w siłę, jednak nie prowadzi do jego śmierci, bo wtedy \r\n    straciłby źródło mocy. Boi się światła i zawsze stara się utrzymać w cieniu, który zresztą przypomina. \r\n    Hima można przegnać na dwa sposoby:\r\n    <ul>\r\n        <li>\r\n            Po wiedźmińsku: Wiedźmin musi spędzić z żywicielem upiora noc w miejscu, \r\n            w którym ten do niego przemawia. Może zabić demona dopiero wtedy, gdy wywabi go z cienia.\r\n        </li>\r\n        <li>\r\n            Podstępem: Ktoś musi udawać popełnianie brutalnej zbrodni, by przyciągnąć do siebie hima. \r\n            Gdy demon zda sobie sprawę z tego, że został oszukany, będzie musiał odejść. Ta metoda \r\n            jest zdecydowanie trudniejsza, bo osoba \"niby\" dokonująca złego czynu nie może wiedzieć, \r\n            że jest niewinna, w przeciwnym wypadku plan nie wypali.\r\n        </li>\r\n    </ul>\r\n</p>', 1),
(5, 'bies.html', '<h1>Bies</h1>\r\n<p>\r\n    <img src=\"./img/bies2.png\" style=\"float:left\" width=\"100\" height=\"120\">\r\n    <img src=\"./img/bies3.png\" style=\"float:right\" width=\"200\" height=\"90\">\r\n    <img src=\"./img/bies1.png\" style=\"float:right\" width=\"100\" height=\"50\">\r\n    Biesy są dużymi czworonożnymi ssakami, prawdopodobnie spokrewnionymi z czartami. \r\n    Są to potwory kopytne, posiadają poroże, oraz troje oczu. Ich najgroźniejszą bronią \r\n    jest mordercza szarża, którą przeprowadzają podobnie jak woły, a także zdolności \r\n    hipnotyczne – za pomocą środkowego oka potrafią tak zamącić percepcję ofiary, by ta \r\n    nie widziała nic poza owym okiem. Jest zaliczany do grona reliktów.\r\n</p>', 1),
(6, 'poludnica.html', '<h1>Południca</h1>\r\n<p>\r\n    <img src=\"./img/poludnica1.png\" style=\"float:left\" width=\"150\" height=\"120\">\r\n    <img src=\"./img/poludnica2.png\" style=\"float:right\" width=\"200\" height=\"90\">\r\n    <img src=\"./img/poludnica3.png\" style=\"float:right\" width=\"100\" height=\"50\">\r\n    Do walki z Południcą najlepiej zaopatrzyć się w srebrny miecz i atakować stylem szybkim. \r\n    Dobrze jest także użyć oleju przeciw upiorom, który będzie jej zadawać dodatkowe obrażenia. \r\n    Znakami, które najmocniej uszkadzają ducha są Igni oraz znak Aard.\r\n</p>', 1),
(7, 'filmy.html', '<h1>Zwiastun gry</h1>\r\n<iframe width=\"750\" height=\"312\" src=\"https://www.youtube.com/embed/x05hIYpw1lU\" title=\"Wiedźmin 3: Dziki Gon - trailer PL\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>\r\n<h1>Wilcza zamieć</h1>\r\n<iframe width=\"750\" height=\"421\" src=\"https://www.youtube.com/embed/KAeiATpNtys\" title=\"Pieśń Priscilli - &quot;Wilcza Zamieć&quot; (Wiedźmin III: Dziki Gon Soundtrack + tekst)\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id` int(11) NOT NULL,
  `matka` int(11) NOT NULL DEFAULT 0,
  `nazwa` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`id`, `matka`, `nazwa`) VALUES
(1, 0, 'Bestie'),
(2, 0, 'Drakonidy'),
(5, 1, 'Niedźwiedź'),
(6, 2, 'Bazyliszek');

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
-- Zrzut danych tabeli `produkty_sklep`
--

INSERT INTO `produkty_sklep` (`id`, `tytul`, `opis`, `data_utworzenia`, `data_modyfikacji`, `data_wygasniecia`, `cena_netto`, `podatek_vat`, `dostepne_sztuki`, `status_dostepnosci`, `kategoria`, `gabaryt_produktu`, `zdjecie`) VALUES
(1, 'Abarad', 'Unikat', '2024-01-01', '2024-01-04', '2024-01-24', 2646, 608.58, 1, 1, 'Miecze stalowe', 4.16, '<img src=\"./img/abarad.png\" class=\"zdjecie_sklep\">'),
(2, 'Angivare', 'Unikat', '2024-01-15', '2024-01-17', '2024-01-31', 38, 8.74, 1, 1, 'Miecz stalowy', 3.16, '<img src=\"./img/angivare.png\" class=\"zdjecie_sklep\">'),
(3, 'Addan Deith', 'Unikat', '2024-01-15', '2024-01-18', '2024-01-26', 806, 185.38, 2, 1, 'Miecz srebrny', 1.18, '<img src=\"./img/addan_deith.png\" class=\"zdjecie_sklep\">'),
(4, 'Adwersarz', 'Magic', '2024-01-16', '2024-01-16', '2024-02-03', 1221, 280.83, 3, 1, 'Miecz srebrny', 1.56, '<img src=\"./img/adwersarz.png\" class=\"zdjecie_sklep\">'),
(5, 'An\'ferthe', 'Zwykłe', '2024-01-16', '0000-00-00', '2024-02-11', 200, 46, 5, 1, 'Miecz srebrny', 1.81, '<img src=\"./img/anferthe.png\" class=\"zdjecie_sklep\">'),
(8, 'Ard\'aenye', 'Unikat', '2024-01-16', '2024-01-16', '2024-02-11', 2249, 517.27, 3, 1, 'Miecz stalowy', 2.21, '<img src=\"./img/ardaenye.png\" class=\"zdjecie_sklep\">');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `produkty_sklep`
--
ALTER TABLE `produkty_sklep`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `produkty_sklep`
--
ALTER TABLE `produkty_sklep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
