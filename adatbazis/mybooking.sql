-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Feb 18. 10:51
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `mybooking`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `adminok`
--

CREATE TABLE `adminok` (
  `id` int(11) NOT NULL,
  `felhasznalonev` varchar(255) DEFAULT NULL,
  `jelszo` text DEFAULT NULL,
  `nev` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `adminok`
--

INSERT INTO `adminok` (`id`, `felhasznalonev`, `jelszo`, `nev`) VALUES
(1, 'tamas', '123456789', 'Algács Tamás András'),
(2, 'david', '$2y$10$dsrf7ULnf.QCcKr8nWLX0.LLURlwAgex2s7tnUJpbA29Zt1K7XBd6', 'Nagy Dávid'),
(3, 'marcell', '$2y$10$sSwfkYJWmBWDWuv0t0sCg.j9./YIf5E4.lwxt3Ko01EItbDwLZvPG', 'Nágel Marcell');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `adok`
--

CREATE TABLE `adok` (
  `id` int(11) NOT NULL,
  `felhasznalonev` varchar(255) DEFAULT NULL,
  `jelszo` text DEFAULT NULL,
  `vezeteknev` varchar(255) DEFAULT NULL,
  `keresztnev` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telszam` varchar(255) DEFAULT NULL,
  `szak` text DEFAULT NULL,
  `kep` text DEFAULT NULL,
  `hely` text DEFAULT NULL,
  `leiras` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `adok`
--

INSERT INTO `adok` (`id`, `felhasznalonev`, `jelszo`, `vezeteknev`, `keresztnev`, `email`, `telszam`, `szak`, `kep`, `hely`, `leiras`) VALUES
(3, 'fekete', '$2y$10$GiZ/pLvwMQnC5TxmP/lNq.bw5ck0e1yyUQ3cOegApOqARDuQuX1qe', 'Dr.Fekete', 'Ferenc', 'fekete@gmail.com', '06301964538', 'orvos', '../adoprofilkepek/nagydavid.jpg', NULL, NULL),
(4, 'feher', '$2y$10$hi/r.k0xOiQKtTAXRZc2UOHcdo31arPlFwqWQauXp89ho6WcUKIOO', 'Dr.Fehér', 'András', 'feher@gmail.com', '06301978538', 'orvos', '../adoprofilkepek/drfekete.jpg', NULL, NULL),
(5, 'kek', '$2y$10$a/9ZwuHwRS3Wo0kTZP0wquG8FaCziFU1xysfhBqbqiovla5HjXIA6', 'Dr.Kék', 'Béla', 'kek@gmail.com', '06309864538', 'orvos', '../adoprofilkepek/drfekete.jpg', NULL, NULL),
(6, 'piros', '$2y$10$Lu7Y8gVM3nwe5XZezACwoe7VGIxABcs8vkQaJh5HsrY5Ghle50nTS', 'Dr.Piros', 'Gábor', 'piros@gmail.com', '06201948738', 'orvos', '../adoprofilkepek/67a49a1933c1bdrfekete.jpg', NULL, NULL),
(7, 'szerelo', '$2y$10$5vkpxVzQwqFeRtBqoAEfkuu6B4SLr7U0TVDw8R1cl9BaDH.ifQrq.', 'Szerelő ', 'János', 'szerelo@gmail.com', '06201214678', 'auto', '../adoprofilkepek/67b2f8d9715d1auto.jpg', NULL, NULL),
(8, 'cataflam', '$2y$10$dj1x1.JBYOfb9jiZTeCTYOj5xqX9nJVvYDh0gWp/24A0qABHu9UIS', 'Cat', 'Aflam', 'cataflam@ca.ro', '06312345678', 'tech', '../adoprofilkepek/67b4355d660e8techguy.png', NULL, NULL),
(14, 'buli', '$2y$10$t3EXGesV44JN8hrMy43oB.otNXCJl/1fe7RLNgGNNl8x5HFFF6tbe', 'Buli', 'Szabolcs', 'bilikiraly@gmail.com', '06709863464', 'buli', '../kepek/blankprofile.jpg', '4700 Mátészalka Árpád utca 2.', NULL),
(15, 'fodrasz', '$2y$10$pT0DufHvxv2WcmxWSP6do.97LWaN9vuY8PHlVHpVlcDtnd6WDHPMS', 'Borbély', 'Ferenc', 'fodrasz@gmail.com', '06209876512', 'fodrasz', '../adoprofilkepek/67b452d04cc8ffodrasz.jpg', '4700 Mátészalka Bajcsy utca 5.', 'Szeretettel várlak a szalonomba, választhatsz az időpontokat és kérhetsz egyedi időpontot is felár tekintetetében! Gyere hozzám ha a pacekság számít! ');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ugyfelek`
--

CREATE TABLE `ugyfelek` (
  `id` int(11) NOT NULL,
  `felhasznalonev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `jelszo` text DEFAULT NULL,
  `vezeteknev` varchar(255) DEFAULT NULL,
  `keresztnev` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telszam` varchar(255) DEFAULT NULL,
  `szul_ido` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `szul_hely` varchar(255) DEFAULT NULL,
  `nem` varchar(255) DEFAULT NULL,
  `lakcim` varchar(255) DEFAULT NULL,
  `tajszam` varchar(255) DEFAULT NULL,
  `a_neve` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `ugyfelek`
--

INSERT INTO `ugyfelek` (`id`, `felhasznalonev`, `jelszo`, `vezeteknev`, `keresztnev`, `email`, `telszam`, `szul_ido`, `szul_hely`, `nem`, `lakcim`, `tajszam`, `a_neve`) VALUES
(2, 'nmarcell', '$2y$10$4Eyaia9KZnQyN8tkg9YNZOb36x4iS6N03mJh9JLyYNn2lWlxMBIWC', 'Nágel', 'Marcell', 'marcika0913@gmail.com', '06301831754', '2005-09-12 22:00:00', 'Mátészalka', 'ferfi', 'Kántorjánosi', '936593272', 'Anyu'),
(3, 'david', '$2y$10$TDAQ5dEngfXGVfgWBijnmOUPxIC5ZLe7oFsRGNrKSQoX7myEdOLaa', 'Nagy', 'David', 'felalla@david.com', '06301537253783', '2005-01-17 23:00:00', 'Mátészalka', 'egyeb', 'Nagyecsed', '346262627', 'Nagyné'),
(10, 'pjanos', '$2y$10$pbKsyYQG.MqcFhKF/rDQEemNZmlxx4G1pqDKrn1JoAMtfFDW5f49q', 'Példa', 'János', 'peldajanos@gmail.com', '06301648635', '1996-10-04 22:00:00', 'Budapest', 'ferfi', 'Budapest XII.kerület', '6423624', 'Példané Erzsébet'),
(11, 'asd', '$2y$10$qfJ6wIiXxvEIvHGgi9wreuoKDRrXLa0FqRIb6IliBE4efZ3Go0HJW', 'Asder', 'Adam', 'asd@gmail.com', '0630165894952', '2015-12-02 23:00:00', 'Nagykálló', 'ferfi', '4700 Mátészalka Ravatal utca 128', '472142354', 'Asderné');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `adminok`
--
ALTER TABLE `adminok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `adok`
--
ALTER TABLE `adok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `ugyfelek`
--
ALTER TABLE `ugyfelek`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `felhasznalonev` (`felhasznalonev`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `adminok`
--
ALTER TABLE `adminok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `adok`
--
ALTER TABLE `adok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT a táblához `ugyfelek`
--
ALTER TABLE `ugyfelek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
