-- phpMyAdmin SQL Dump
-- version 2.6.0-rc3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Czas wygenerowania: 14 Lis 2005, 22:59
-- Wersja serwera: 4.0.21
-- Wersja PHP: 5.0.1
-- 
-- Baza danych: `sklep`
-- 

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `kategorie`
-- 

DROP TABLE IF EXISTS `kategorie`;
CREATE TABLE `kategorie` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nazwa` varchar(50) default NULL,
  `nadrzedny_id` int(10) unsigned default NULL,
  `kolejnosc` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=11 ;

-- 
-- Zrzut danych tabeli `kategorie`
-- 

INSERT INTO `kategorie` (`id`, `nazwa`, `nadrzedny_id`, `kolejnosc`) VALUES (1, 'Albumy', 1, 1);
INSERT INTO `kategorie` (`id`, `nazwa`, `nadrzedny_id`, `kolejnosc`) VALUES (2, 'Albumy z ok³adk± z PCV', 1, 2);
INSERT INTO `kategorie` (`id`, `nazwa`, `nadrzedny_id`, `kolejnosc`) VALUES (3, 'Albumy z ok³adk± tekturow±', 1, 1);
INSERT INTO `kategorie` (`id`, `nazwa`, `nadrzedny_id`, `kolejnosc`) VALUES (7, 'Kartki inne', 5, 2);
INSERT INTO `kategorie` (`id`, `nazwa`, `nadrzedny_id`, `kolejnosc`) VALUES (5, 'Akcesoria', 5, 2);
INSERT INTO `kategorie` (`id`, `nazwa`, `nadrzedny_id`, `kolejnosc`) VALUES (6, 'Kartki tekturowe', 5, 1);
INSERT INTO `kategorie` (`id`, `nazwa`, `nadrzedny_id`, `kolejnosc`) VALUES (4, 'Albumy z ok³adk± ze skóry', 1, 3);
INSERT INTO `kategorie` (`id`, `nazwa`, `nadrzedny_id`, `kolejnosc`) VALUES (8, 'Oprawki na zdjêcia', 8, 3);
INSERT INTO `kategorie` (`id`, `nazwa`, `nadrzedny_id`, `kolejnosc`) VALUES (9, 'portretowe', 8, 4);
INSERT INTO `kategorie` (`id`, `nazwa`, `nadrzedny_id`, `kolejnosc`) VALUES (10, 'panoramiczne', 8, 5);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `klienci`
-- 

DROP TABLE IF EXISTS `klienci`;
CREATE TABLE `klienci` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nazwa` varchar(250) default NULL,
  `email` varchar(100) default NULL,
  `adres` varchar(250) default NULL,
  `telefon` varchar(50) default NULL,
  `opis` varchar(250) default NULL,
  `identyfikacja` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=18 ;

-- 
-- Zrzut danych tabeli `klienci`
-- 

INSERT INTO `klienci` (`id`, `nazwa`, `email`, `adres`, `telefon`, `opis`, `identyfikacja`) VALUES (13, 'Pierwszy klient', 'klient1@costam.com', 'Myszków ul. Go³êbiewska 43', 'sdf', NULL, '127.0.0.1');
INSERT INTO `klienci` (`id`, `nazwa`, `email`, `adres`, `telefon`, `opis`, `identyfikacja`) VALUES (14, 'Micha³ Poniatowski', 'michal@onet.pl', 'Kraków, Armii Ludowej 5', '608-234034', NULL, '127.0.0.1');
INSERT INTO `klienci` (`id`, `nazwa`, `email`, `adres`, `telefon`, `opis`, `identyfikacja`) VALUES (12, 'Fajny S³awomir', 'fajnys@3mail.com', 'Szczecin ul. Zamglona 15 m 45', 'asd', NULL, '127.0.0.1');
INSERT INTO `klienci` (`id`, `nazwa`, `email`, `adres`, `telefon`, `opis`, `identyfikacja`) VALUES (15, 'Micha³ Przyby³', 'mickpr@polbox.com', 'Baby, Zielona 30', '509240859', NULL, '127.0.0.1');
INSERT INTO `klienci` (`id`, `nazwa`, `email`, `adres`, `telefon`, `opis`, `identyfikacja`) VALUES (16, 'a', 'b', 'c', 'd', NULL, '');
INSERT INTO `klienci` (`id`, `nazwa`, `email`, `adres`, `telefon`, `opis`, `identyfikacja`) VALUES (17, 'Micha³ Przyby³', 'mickpr@poczta.onet.pl', 'Baby, ul. Zielona 30', '509-240859', NULL, '');

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `konfiguracja`
-- 

DROP TABLE IF EXISTS `konfiguracja`;
CREATE TABLE `konfiguracja` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nazwa` varchar(50) NOT NULL default '',
  `opis` text,
  `wartosc` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Zrzut danych tabeli `konfiguracja`
-- 

INSERT INTO `konfiguracja` (`id`, `nazwa`, `opis`, `wartosc`) VALUES (1, 'nazwa_sklepu', NULL, 'Sklep internetowy MONIKA');
INSERT INTO `konfiguracja` (`id`, `nazwa`, `opis`, `wartosc`) VALUES (2, 'telefon_sklepu', NULL, '(509) 240-859');
INSERT INTO `konfiguracja` (`id`, `nazwa`, `opis`, `wartosc`) VALUES (3, '', NULL, NULL);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `pozycje_zamowien`
-- 

DROP TABLE IF EXISTS `pozycje_zamowien`;
CREATE TABLE `pozycje_zamowien` (
  `produkty_id` int(10) unsigned NOT NULL default '0',
  `zamowienia_id` int(10) unsigned NOT NULL default '0',
  `vat` float(11,2) NOT NULL default '22.00',
  `brutto` float(11,2) NOT NULL default '0.00',
  `netto` float(11,2) NOT NULL default '0.00',
  `ilosc` float(11,2) NOT NULL default '1.00'
) TYPE=MyISAM;

-- 
-- Zrzut danych tabeli `pozycje_zamowien`
-- 

INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (1, 35, 22.00, 12.00, 12.00, 1.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (2, 35, 22.00, 122.00, 100.00, 3.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (1, 34, 22.00, 12.00, 12.00, 1.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (4, 39, 22.00, 3.00, 4.00, 1.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (2, 38, 22.00, 122.00, 100.00, 2.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (11, 37, 22.00, 10.00, 12.20, 2.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (5, 39, 22.00, 10.00, 12.20, 4.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (4, 39, 22.00, 3.00, 4.00, 3.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (7, 39, 22.00, 12.00, 10.00, 2.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (3, 39, 22.00, 3.00, 3.00, 9.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (5, 40, 22.00, 10.00, 12.20, 4.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (7, 40, 22.00, 12.00, 10.00, 5.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (2, 41, 22.00, 122.00, 100.00, 200.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (1, 42, 22.00, 68.32, 56.00, 6.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (7, 42, 22.00, 12.00, 10.00, 2.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (1, 43, 22.00, 68.32, 56.00, 1.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (2, 43, 22.00, 122.00, 100.00, 2.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (7, 44, 22.00, 12.00, 10.00, 1.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (6, 44, 22.00, 17.08, 14.00, 1.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (2, 45, 22.00, 122.00, 100.00, 1.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (11, 45, 22.00, 10.00, 12.20, 1.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (3, 46, 22.00, 3.66, 3.00, 678.00);
INSERT INTO `pozycje_zamowien` (`produkty_id`, `zamowienia_id`, `vat`, `brutto`, `netto`, `ilosc`) VALUES (7, 47, 22.00, 12.00, 10.00, 3.00);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `producenci`
-- 

DROP TABLE IF EXISTS `producenci`;
CREATE TABLE `producenci` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nazwa` varchar(100) NOT NULL default '',
  `strona_www` varchar(100) default NULL,
  `ranking` int(10) unsigned default '0',
  `opis` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Zrzut danych tabeli `producenci`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `produkty`
-- 

DROP TABLE IF EXISTS `produkty`;
CREATE TABLE `produkty` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nazwa` varchar(250) NOT NULL default '',
  `symbol` varchar(20) default NULL,
  `miniatura` varchar(50) default NULL,
  `zdjecie` varchar(50) default NULL,
  `opis` text,
  `typy_id` int(10) unsigned NOT NULL default '1',
  `kategorie_id` int(10) unsigned NOT NULL default '1',
  `promocje_id` int(10) unsigned NOT NULL default '1',
  `vat` float(11,2) NOT NULL default '22.00',
  `zakup_brutto` float(11,2) NOT NULL default '0.00',
  `zakup_netto` float(11,2) NOT NULL default '0.00',
  `brutto` float(11,2) NOT NULL default '0.00',
  `netto` float(11,2) NOT NULL default '0.00',
  `ilosc` float(11,2) NOT NULL default '0.00',
  `data_ceny` date default NULL,
  PRIMARY KEY  (`id`),
  KEY `SYMBOL` (`symbol`)
) TYPE=MyISAM AUTO_INCREMENT=21 ;

-- 
-- Zrzut danych tabeli `produkty`
-- 

INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (1, 'Album fotograficzny', '0009', '', 'album1.jpg', 'Album z ok³adk± tekturow± jest albumem do zwyk³ych zdjêæ formatu pocztówkowego. Wykonany jest z grubej p³askiej tektury pokrytej wybranym wzorem z fragmentu mapy geofizycznej. Doskonale pasuje jako album do zdjêæ z podró¿y lub podobnych. Jego niewygórowana cena i staranna jako¶æ wykonania stanowi± oprócz trwa³o¶ci i estetyki jego podstawowe zalety.', 4, 3, 2, 22.00, 12.20, 10.00, 15.00, 12.30, 6.00, '2005-11-12');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (2, 'Album fotograficzny 2', '1231', 's_album2.jpg', 'album2.jpg', 'Jest to album do przechowywania plyt CD ze zdjêciami cyfrowymi :-)', 4, 2, 1, 22.00, 122.00, 100.00, 122.00, 100.00, -2.00, '2005-07-14');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (3, 'Kartka do albumu', '4534', 's_kartki1.jpg', 'kartki1.jpg', 'Kartki z tektury litej do albumów pozwalaj± zmieniæ standardow± ilo¶æ zdjêæ wg upodobañ klienta. Zdjêcia s± wsuwane poprzez szczelinê, za¶ okienko, przez które widaæ zdjêcie mo¿e byæ owalne, prostokatne lub w innej wybranej formie (witra¿, serce itp). Kolorystyka tektury u¿ytej do wykonania kartek jest bogata (od bia³ej poprzez be¿ow±, niebieski± a nawet czarn±). Istnieje równie¿ wiele faktur charakteryzuj±cych u¿yt± tekturê (g³adkie,  faliste i inne).\r\n', 1, 6, 1, 22.00, 2.44, 2.00, 3.66, 3.00, -570.00, '2005-07-16');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (4, 'Kartka do albumu', '8908', '000209_2.jpg', '', 'Kartki z tektury litej do albumów pozwalaj± zmieniæ standardow± ilo¶æ zdjêæ wg upodobañ klienta. Zdjêcia s± wsuwane poprzez szczelinê, za¶ okienko, przez które widaæ zdjêcie mo¿e byæ owalne, prostokatne lub w innej wybranej formie (witra¿, serce itp). Kolorystyka tektury u¿ytej do wykonania kartek jest bogata (od bia³ej poprzez be¿ow±, niebiesk,czarn± itp...). Istnieje równie¿ wiele faktur charakteryzuj±cych u¿yt± tekturê (g³adkie,  faliste i inne).\r\n', 4, 6, 1, 22.00, 3.05, 2.50, 3.90, 3.20, 8.00, '2005-07-15');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (5, 'Album typu harmonijka', '0001', '000206_1.jpg', '', '', 1, 3, 1, 22.00, 10.00, 8.20, 10.00, 12.20, 2.00, '2005-11-12');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (6, 'Album B5', '0008', '', 'elan2003_CUdetail150_225.jpg', '', 1, 4, 1, 22.00, 14.64, 0.00, 17.08, 14.00, 54.00, '2005-10-13');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (7, 'Florentina 01', '1001', 'florentina01.jpg', '', '<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>Album typu <b>Florentina</b> - typ pierwszy', 2, 4, 6, 22.00, 12.00, 10.00, 12.00, 10.00, 7.00, '2005-07-14');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (8, 'Florentina 02', '1002', 'florentina02.jpg', '', '<br><br><br><br><br><br><br><br><br><br><br><br>\r\nAlbum tego typu jest spoko!', 1, 4, 1, 22.00, 42.70, 35.00, 46.36, 38.00, 9.00, '2005-07-13');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (9, 'Florentina 03', '1003', 'florentina03.jpg', '', '<br><br><br><br><br><br><br><br><br><br><br><br>\r\nAlbum trzeci - tu jakis opis.', 1, 4, 1, 22.00, 54.90, 45.00, 81.74, 67.00, 8.00, '2005-07-13');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (10, 'Florentina 04', '1004', 'florentina04.jpg', '', '<br><br><br><br><br><br><br><br><br><br><br><br>\r\nAlbum czwarty', 1, 4, 1, 22.00, 68.32, 56.00, 78.08, 64.00, 6.00, '2005-07-13');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (11, 'Album LAD', '', 's_LAD_10x13.jpg', 'LAD_10x13.jpg', 'Album w skórzanej oprawie.', 4, 2, 1, 22.00, 10.00, 12.20, 10.00, 12.20, 26.00, '2005-07-14');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (14, 'Album Plate', '0010', 'AlbumWithImprintPlateSQ.jpg', '', 'Album z mosiê¿n± wpink± z wybranym napisem.', 3, 2, 1, 22.00, 100.00, 81.97, 132.00, 108.20, 30.00, '2005-07-16');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (15, 'Kartki z PCV', '0932', '000210_2.jpg', '', 'Kartki z tworzywa sztucznego pó³prze¼roczyste. :-)', 2, 7, 1, 22.00, 1.20, 0.00, 1.50, 1.23, 97.00, '2005-10-01');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (16, 'Album czarny', '1233', '', 'supersavercovers25.jpg', '', 1, 3, 1, 22.00, 5.00, 0.00, 6.00, 4.92, 87.00, '2005-10-13');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (17, 'Generations', '0893', '', 'gp_generations602alb.jpg', 'Ekskluzywne albumy z serii Generations.', 3, 4, 1, 22.00, 120.00, 0.00, 140.00, 114.75, 1.00, '2005-10-02');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (18, 'Album Z0190', '0923', '', 'rekl2.jpg', 'Albumy z ok³adk± tekturow±.', 4, 3, 1, 22.00, 35.00, 0.00, 40.00, 32.79, 67.00, '2005-10-02');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (19, 'Oprawki Dakota Collection', '0939', '', 'dakota.jpg', 'Oprawki na zdjêcia z serii "Dakota Collection" to portretowe oprawki z obramowaniem z ciemnego lakierowanego drewna i sk³adan± podpórk± umo¿liwiaj±c± postawienie zdjecia na biurku/szafce. Ramka wykonana jest z drewna machoniowego lub wi¶niowego. Szczerze polecamy. :-)', 3, 9, 1, 22.00, 20.00, 0.00, 22.00, 18.03, 78.00, '2005-10-15');
INSERT INTO `produkty` (`id`, `nazwa`, `symbol`, `miniatura`, `zdjecie`, `opis`, `typy_id`, `kategorie_id`, `promocje_id`, `vat`, `zakup_brutto`, `zakup_netto`, `brutto`, `netto`, `ilosc`, `data_ceny`) VALUES (20, 'Onyx Interior', '0937', '', 'artleather_metroONYXalbums30.jpg', 'Album Onyx Interior w kolorze czarnym stanowi ¶wietn± propozycjê dla zdjêæ ¶lubnych. :-)', 4, 4, 1, 22.00, 55.00, 0.00, 86.00, 70.49, 23.00, '2005-11-01');

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `promocje`
-- 

DROP TABLE IF EXISTS `promocje`;
CREATE TABLE `promocje` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nazwa` varchar(250) default NULL,
  `opis` text,
  `data_waznosci` date NOT NULL default '0000-00-00',
  `wyswietlac` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

-- 
-- Zrzut danych tabeli `promocje`
-- 

INSERT INTO `promocje` (`id`, `nazwa`, `opis`, `data_waznosci`, `wyswietlac`) VALUES (1, '--brak promocji---', '', '0000-00-00', 1);
INSERT INTO `promocje` (`id`, `nazwa`, `opis`, `data_waznosci`, `wyswietlac`) VALUES (2, 'Promocja', '<b>Serdecznie witamy w naszym sklepie internetowym i zapraszamy do zakupów.</b>', '2006-08-31', 1);
INSERT INTO `promocje` (`id`, `nazwa`, `opis`, `data_waznosci`, `wyswietlac`) VALUES (6, 'Promocja florentina', 'Mamy przyjemno¶æ zaproponowaæ Pañstwu szeroki asortyment produktów nowego typu - <b>Florentina</b>.<br>\r\nS± to produkty wysokiej jako¶ci o ok³adce ze skóry z wmontowanym zdjêciem/emblematem. <br><img src="img/artleather_albfamily.jpg"><br><font color=red size=2>Serdecznie zapraszamy do zakupów.</font>', '2006-12-31', 1);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `typy`
-- 

DROP TABLE IF EXISTS `typy`;
CREATE TABLE `typy` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nazwa` varchar(100) NOT NULL default '',
  `kolejnosc` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Zrzut danych tabeli `typy`
-- 

INSERT INTO `typy` (`id`, `nazwa`, `kolejnosc`) VALUES (1, '9cm x 13cm', 1);
INSERT INTO `typy` (`id`, `nazwa`, `kolejnosc`) VALUES (2, '13cm x 18cm', 3);
INSERT INTO `typy` (`id`, `nazwa`, `kolejnosc`) VALUES (3, '10cm x 15cm', 2);
INSERT INTO `typy` (`id`, `nazwa`, `kolejnosc`) VALUES (4, '15cm x 21cm', 4);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `uzytkownicy`
-- 

DROP TABLE IF EXISTS `uzytkownicy`;
CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL auto_increment,
  `nazwa` varchar(50) NOT NULL default '',
  `haslo` varchar(50) NOT NULL default '',
  `promocja` float(11,2) NOT NULL default '0.00',
  `klientid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Zrzut danych tabeli `uzytkownicy`
-- 

INSERT INTO `uzytkownicy` (`id`, `nazwa`, `haslo`, `promocja`, `klientid`) VALUES (1, 'admin', 'jmpe45f', 0.00, 0);
INSERT INTO `uzytkownicy` (`id`, `nazwa`, `haslo`, `promocja`, `klientid`) VALUES (2, 'mickpr', '1111', 2.12, 15);
INSERT INTO `uzytkownicy` (`id`, `nazwa`, `haslo`, `promocja`, `klientid`) VALUES (4, 'fajnys', 'fajnys', 10.00, 12);

-- --------------------------------------------------------

-- 
-- Struktura tabeli dla  `zamowienia`
-- 

DROP TABLE IF EXISTS `zamowienia`;
CREATE TABLE `zamowienia` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `klienci_id` int(10) unsigned default NULL,
  `datazamowienia` date NOT NULL default '0000-00-00',
  `opis` varchar(250) default NULL,
  `stan` int(10) unsigned default NULL,
  `data_realizacji` date default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=48 ;

-- 
-- Zrzut danych tabeli `zamowienia`
-- 

INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (37, 14, '2005-06-24', 'opis', 0, NULL);
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (35, 12, '2005-06-13', 'opis', 0, NULL);
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (34, 13, '2005-06-13', 'opis', 1, '2005-07-12');
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (38, 15, '2005-07-13', 'opis', 0, NULL);
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (39, 15, '2005-07-13', 'opis', 1, '2005-07-13');
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (40, 15, '2005-07-14', 'opis', 0, NULL);
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (41, 15, '2005-07-16', 'opis', 0, NULL);
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (42, 16, '2005-09-22', 'opis', 0, NULL);
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (43, 17, '2005-10-01', 'opis', 1, '2005-10-01');
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (44, 16, '2005-10-30', 'opis', 0, NULL);
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (45, 16, '2005-10-30', 'opis', 0, NULL);
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (46, 16, '2005-11-01', 'opis', 0, NULL);
INSERT INTO `zamowienia` (`id`, `klienci_id`, `datazamowienia`, `opis`, `stan`, `data_realizacji`) VALUES (47, 16, '2005-11-13', 'opis', 0, NULL);
        