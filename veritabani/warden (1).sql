-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 05 Eyl 2021, 03:22:13
-- Sunucu sürümü: 10.4.19-MariaDB
-- PHP Sürümü: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `warden`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `birim`
--

CREATE TABLE `birim` (
  `id` int(10) UNSIGNED NOT NULL,
  `isim` varchar(255) NOT NULL DEFAULT 'No Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `birim`
--

INSERT INTO `birim` (`id`, `isim`) VALUES
(1, 'Uygulama Yöneticisi'),
(4, 'Güvenlik'),
(5, 'Acil Hemşire'),
(7, 'Acil Doktor');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `id` int(10) UNSIGNED NOT NULL,
  `kullanici_adi` varchar(30) NOT NULL,
  `sifre` varchar(30) NOT NULL,
  `tc_no` varchar(11) NOT NULL,
  `e_posta_adresi` varchar(50) NOT NULL,
  `rol` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`id`, `kullanici_adi`, `sifre`, `tc_no`, `e_posta_adresi`, `rol`) VALUES
(1, 'admin', 'warden', '12345678900', 'admin@mail.com', 0),
(11, 'Zeki Arslan', 'adaf', '12457685212', 'regergreh', 2),
(13, 'Ahmet', 'sgrgeh', '5458498489', 'ergeherh', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_birimi`
--

CREATE TABLE `kullanici_birimi` (
  `id` int(10) UNSIGNED NOT NULL,
  `kullanici_id` int(10) UNSIGNED NOT NULL,
  `birim_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kullanici_birimi`
--

INSERT INTO `kullanici_birimi` (`id`, `kullanici_id`, `birim_id`) VALUES
(1, 1, 1),
(12, 11, 4),
(13, 12, 5),
(14, 13, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `nobet`
--

CREATE TABLE `nobet` (
  `id` int(10) UNSIGNED NOT NULL,
  `baslangic` datetime NOT NULL,
  `bitis` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `nobet`
--

INSERT INTO `nobet` (`id`, `baslangic`, `bitis`) VALUES
(8, '2021-09-01 04:08:00', '2021-09-02 04:08:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `nobetci_nobeti`
--

CREATE TABLE `nobetci_nobeti` (
  `id` int(10) UNSIGNED NOT NULL,
  `kullanici_id` int(10) UNSIGNED NOT NULL,
  `nobet_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `nobetci_nobeti`
--

INSERT INTO `nobetci_nobeti` (`id`, `kullanici_id`, `nobet_id`) VALUES
(8, 11, 8);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `birim`
--
ALTER TABLE `birim`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanici_birimi`
--
ALTER TABLE `kullanici_birimi`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `nobet`
--
ALTER TABLE `nobet`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `nobetci_nobeti`
--
ALTER TABLE `nobetci_nobeti`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `birim`
--
ALTER TABLE `birim`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici_birimi`
--
ALTER TABLE `kullanici_birimi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `nobet`
--
ALTER TABLE `nobet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `nobetci_nobeti`
--
ALTER TABLE `nobetci_nobeti`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
