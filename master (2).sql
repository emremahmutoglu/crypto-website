-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 08 Haz 2024, 08:16:34
-- Sunucu sürümü: 8.0.17
-- PHP Sürümü: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `master`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `coins`
--

CREATE TABLE `coins` (
  `coin_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `price` decimal(20,8) NOT NULL,
  `percent_change_1h` decimal(10,2) DEFAULT NULL,
  `percent_change_24h` decimal(10,2) DEFAULT NULL,
  `percent_change_7d` decimal(10,2) DEFAULT NULL,
  `market_cap` bigint(20) DEFAULT NULL,
  `volume_24h` bigint(20) DEFAULT NULL,
  `circulating_supply` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `coins`
--

INSERT INTO `coins` (`coin_id`, `name`, `price`, `percent_change_1h`, `percent_change_24h`, `percent_change_7d`, `market_cap`, `volume_24h`, `circulating_supply`) VALUES
(1, 'Bitcoin', '70981.24930611', '-0.74', '0.53', '5.32', 1398897325625, 33059777353, 19707984),
(2, 'Ethereum', '3847.14774085', '-0.41', '1.04', '2.40', 462228483241, 14780645961, 120148358),
(3, 'Tether USDt', '1.00006968', '0.01', '-0.01', '0.08', 112324600066, 68163801358, 112316773848),
(4, 'BNB', '689.58988588', '-1.61', '3.27', '15.98', 101766009272, 3692064384, 147574684),
(5, 'Solana', '172.91011200', '-0.92', '2.14', '1.97', 79525546709, 2556727856, 459924210),
(6, 'USDC', '1.00007091', '-0.01', '0.00', '-0.02', 32412996432, 6307050813, 32410698213),
(7, 'XRP', '0.52596097', '-0.68', '-0.55', '1.79', 29079830168, 1245312266, 55288951055),
(8, 'Dogecoin', '0.16141976', '-3.72', '-1.12', '5.43', 23310451467, 1677295329, 144408906384),
(9, 'Toncoin', '7.39777125', '-0.72', '5.71', '13.11', 17866048632, 536278229, 2415058269),
(10, 'Cardano', '0.46061296', '-0.41', '-0.52', '1.50', 16447229707, 304878234, 35707266632),
(11, 'Avalanche', '36.58207070', '-0.62', '2.06', '0.03', 14385403071, 343013518, 393236435),
(12, 'Shiba Inu', '0.00002585', '-0.49', '5.66', '-6.98', 15230214593, 988320275, 589271803029900),
(13, 'Polkadot', '7.23143390', '-0.65', '0.44', '0.32', 10398465197, 172557302, 1437953431),
(14, 'Chainlink', '17.79425921', '-0.64', '0.46', '-4.43', 10447009054, 363081240, 587099970),
(15, 'TRON', '0.11468052', '-0.06', '0.36', '2.16', 10016737567, 240364925, 87344719263),
(16, 'Bitcoin Cash', '487.11047700', '-0.44', '2.57', '3.98', 9603550498, 262117360, 19715344),
(17, 'NEAR Protocol', '7.62120192', '-0.13', '3.08', '-0.42', 8250389467, 271454356, 1082557522),
(18, 'Polygon', '0.72074513', '-0.30', '0.80', '0.28', 7133554007, 231505905, 9897471007),
(19, 'Litecoin', '86.92014308', '-0.12', '0.96', '5.90', 6480937523, 517212268, 74561975),
(20, 'Internet Computer', '12.35663345', '-0.46', '1.13', '1.49', 5739144646, 68299280, 464458598),
(21, 'UNUS SED LEO', '6.03580619', '-0.04', '1.45', '1.24', 5590782906, 4504030, 926269455),
(22, 'Dai', '1.00002290', '0.02', '-0.03', '0.01', 5348011040, 290296769, 5347888596),
(23, 'Uniswap', '11.15400042', '-0.54', '-3.79', '5.92', 6691923915, 566945357, 599957295),
(24, 'Ethereum Classic', '29.73021422', '-0.70', '0.18', '-2.77', 4382074789, 191503074, 147394659),
(25, 'Hedera', '0.10372148', '-0.43', '1.31', '-0.52', 3708041078, 53246054, 35749981471),
(26, 'Aptos', '9.26660759', '-0.63', '1.41', '1.44', 4054178951, 108672904, 437504115),
(27, 'First Digital USD', '1.00023993', '0.02', '0.01', '0.17', 2753016327, 7233127789, 2752355954),
(28, 'Render', '10.48761026', '-0.69', '1.15', '0.98', 4075974832, 200606615, 388646672),
(29, 'Pepe', '0.00001468', '0.70', '1.81', '-0.31', 6176015473, 1462322643, 420689899999990),
(30, 'Cronos', '0.11818278', '0.15', '8.20', '0.99', 3140300887, 18165383, 26571560696),
(31, 'Cosmos', '8.68524339', '-0.32', '1.89', '-0.52', 3395328027, 101500980, 390930671),
(32, 'Mantle', '1.01213854', '0.13', '4.44', '1.16', 3304067257, 76283082, 3264441708),
(33, 'Stacks', '2.37375057', '-1.49', '13.04', '21.86', 3472338783, 306851520, 1462806929),
(34, 'dogwifhat', '3.43463440', '-0.01', '0.27', '-10.44', 3430876685, 637992884, 998905933),
(35, 'Filecoin', '6.05118768', '-0.36', '1.25', '3.38', 3388101960, 183885478, 559906937),
(36, 'Immutable', '2.31885619', '0.00', '0.60', '3.67', 3437345844, 53011268, 1482345419),
(37, 'Stellar', '0.10718180', '-0.12', '0.53', '-0.09', 3112532855, 56375799, 29039751222),
(38, 'OKB', '48.65367663', '-0.32', '1.47', '6.08', 2919220598, 10035875, 60000000),
(39, 'Optimism', '2.52494251', '-0.50', '2.77', '-0.27', 2744334673, 212188472, 1086889963),
(40, 'Bittensor', '414.83292238', '0.30', '5.55', '3.77', 2857105336, 42973488, 6887364),
(41, 'Arbitrum', '1.12501609', '-0.64', '1.69', '-2.95', 3258541981, 280817289, 2896440329),
(42, 'VeChain', '0.03536861', '-0.74', '2.96', '-0.08', 2571811732, 59061310, 72714516834),
(43, 'Maker', '2685.24480698', '0.06', '2.46', '-0.10', 2491289662, 71203871, 927770),
(44, 'The Graph', '0.30283346', '-0.31', '0.91', '-2.83', 2879846679, 90488298, 9509671265),
(45, 'Kaspa', '0.18217704', '-0.31', '3.82', '32.19', 4343423141, 155500061, 23841769955),
(46, 'Sui', '1.08653883', '-0.18', '3.84', '6.63', 2636099522, 186086281, 2426143881),
(47, 'Arweave', '44.41352710', '-0.47', '-2.85', '12.87', 2915857578, 98135129, 65652466),
(48, 'Monero', '164.82083636', '0.70', '3.83', '17.31', 3040296847, 66483894, 18446071),
(49, 'Injective', '26.65278226', '-0.30', '5.67', '-0.22', 2489369863, 94590492, 93400000),
(50, 'Theta Network', '2.22166105', '-0.36', '3.75', '-1.63', 2221661049, 27733204, 1000000000),
(51, 'Fantom', '0.83750528', '-0.61', '0.00', '2.75', 2348058983, 170777025, 2803634836),
(52, 'Fetch.ai', '2.14065544', '-0.54', '0.57', '-3.92', 1815690878, 190902570, 848193896),
(53, 'FLOKI', '0.00030738', '-0.56', '6.70', '13.31', 2938227105, 1591138626, 9559068589561),
(54, 'Celestia', '10.47368016', '-0.18', '-2.09', '-3.43', 1977685845, 123870273, 188824350),
(55, 'Lido DAO', '2.26366429', '-1.59', '-2.78', '-2.39', 2019915857, 125217012, 892321298),
(56, 'THORChain', '6.24861968', '-0.98', '0.63', '-5.75', 2093104141, 219832922, 334970641),
(57, 'Core', '1.92801061', '-0.36', '-4.69', '-4.82', 1719184454, 87660379, 891688273),
(58, 'Bonk', '0.00003381', '-0.08', '2.51', '-9.34', 2293624617, 668442314, 67844923081082),
(59, 'Bitget Token', '1.32147071', '0.02', '-0.91', '0.77', 1850058993, 34773134, 1400000000),
(60, 'Algorand', '0.18893501', '-0.16', '1.41', '-1.51', 1544611420, 34556695, 8175358542),
(61, 'Sei', '0.52478736', '-0.82', '0.96', '1.38', 1535003042, 64619809, 2925000000),
(62, 'Jupiter', '1.15651105', '-0.85', '2.82', '0.41', 1561289919, 128332111, 1350000000),
(63, 'Flow', '0.93704426', '-0.44', '3.56', '1.90', 1415276363, 34291119, 1510362347),
(64, 'Gala', '0.04669355', '-0.74', '2.10', '5.52', 1474200017, 234185761, 31571812777),
(65, 'Aave', '104.31400833', '-0.65', '1.32', '1.40', 1548590152, 83436160, 14845467),
(66, 'Bitcoin SV', '63.89411935', '-0.34', '2.08', '2.04', 1259430564, 33152264, 19711213),
(67, 'Beam', '0.02785460', '-0.67', '-1.65', '1.14', 1377855748, 16068984, 49466004168),
(68, 'Quant', '90.81985788', '-0.17', '-0.40', '-0.39', 1096444349, 19643436, 12072738),
(69, 'Pendle', '6.17743075', '0.40', '-1.72', '-0.97', 953036704, 57854517, 154277197),
(70, 'BitTorrent (New)', '0.00000120', '0.11', '0.62', '-0.85', 1164346513, 18125076, 968246428571000),
(71, 'Wormhole', '0.63133899', '0.36', '-2.21', '7.62', 1136410186, 93619754, 1800000000),
(72, 'Flare', '0.02855240', '-0.35', '0.79', '3.42', 1168020529, 8677705, 40907956503),
(73, 'Neo', '15.27136913', '-0.30', '1.52', '1.71', 1077224526, 30644695, 70538831),
(74, 'SingularityNET', '0.90656759', '-0.55', '1.61', '-2.32', 1164751864, 99489339, 1284793190),
(75, 'Ethena', '0.98255073', '-1.04', '-1.36', '16.39', 1493784151, 257493607, 1520312500),
(76, 'Ondo', '1.38804909', '-0.03', '-3.06', '17.91', 1929054879, 270042806, 1389759838),
(77, 'Akash Network', '4.65367457', '0.36', '3.12', '-10.22', 1113812498, 16100993, 239340435),
(78, 'MultiversX', '39.74385573', '-0.39', '0.97', '-1.04', 1074017489, 23920647, 27023485),
(79, 'Worldcoin', '4.90816988', '-0.42', '2.39', '0.35', 1133328955, 329880593, 230906628),
(80, 'Axie Infinity', '8.63454101', '0.51', '6.60', '9.20', 1257110413, 84744154, 145590879),
(81, 'Chiliz', '0.14507126', '0.18', '0.10', '-8.53', 1289435451, 106914528, 8888289967),
(82, 'The Sandbox', '0.46983527', '-0.28', '2.01', '4.79', 1064520775, 88395319, 2265731926),
(83, 'dYdX (Native)', '2.08852589', '0.17', '1.50', '1.25', 1239594708, 48922902, 593526139),
(84, 'KuCoin Token', '10.18525001', '0.38', '1.08', '-0.53', 974147473, 734924, 95642961),
(85, 'eCash', '0.00004738', '-0.75', '1.95', '-0.82', 933839698, 12106927, 19711464048092),
(86, 'Starknet', '1.33930536', '-0.33', '0.82', '10.09', 1741514619, 256196184, 1300311845),
(87, 'JasmyCoin', '0.03769950', '-1.29', '-5.52', '54.11', 1858585302, 272161147, 49299999677),
(88, 'Tezos', '0.95304803', '-0.36', '0.74', '-0.88', 938113895, 24309036, 984330137),
(89, 'Synthetix', '2.81084286', '-0.24', '2.58', '-3.28', 921307705, 28349389, 327769196),
(90, 'Mina', '0.86564526', '-0.36', '1.65', '1.45', 966092524, 27099104, 1116037439),
(91, 'EOS', '0.80733609', '-0.52', '-0.05', '-0.87', 910304483, 119457977, 1127540931),
(92, 'Helium', '4.63599090', '0.72', '-5.13', '-6.38', 745817084, 8285942, 160875442),
(93, 'Ronin', '3.17858308', '0.06', '3.39', '3.01', 1036842849, 23621057, 326196554),
(94, 'Conflux', '0.22508141', '-0.14', '1.69', '1.34', 910451530, 32628890, 4044987763),
(95, 'Decentraland', '0.47143699', '0.01', '1.39', '2.50', 899652566, 55474906, 1908319865),
(96, 'ORDI', '57.25224933', '1.40', '4.59', '39.66', 1202297236, 390474834, 21000000),
(97, 'Nervos Network', '0.01792670', '1.03', '-1.05', '10.60', 790867519, 34407986, 44116725854),
(98, 'Gnosis', '340.11834557', '-0.36', '2.33', '-0.33', 880766386, 14015124, 2589588),
(99, 'Axelar', '1.15829930', '0.31', '-7.06', '4.56', 755885022, 15951233, 652581781),
(100, 'Pyth Network', '0.47078988', '0.47', '4.88', '9.95', 1706608110, 188916555, 3624988964),
(7186, 'PancakeSwap', '2.98793291', '-0.21', '2.29', '11.94', 803892036, 33973715, 269046214),
(9104, 'AIOZ Network', '0.84017505', '-0.08', '-1.50', '2.25', 920710568, 6507964, 1095855637),
(13855, 'Ethereum Name Service', '28.39934404', '0.81', '10.89', '24.72', 893939040, 202149738, 31477454),
(16086, 'BitTorrent [New]', '0.00000117', '-0.21', '1.28', '-2.63', 1128055960, 24735286, 968246428571000),
(21585, 'Safe', '2.03018693', '-0.38', '-2.00', '-3.31', 866514330, 16171181, 426815046),
(28850, 'Notcoin', '0.02179417', '-0.35', '-11.03', '129.41', 2238680252, 1953147206, 102719221714),
(29870, 'BOOK OF MEME', '0.01332050', '-0.11', '1.21', '-4.54', 918666302, 303229796, 68966327627),
(30933, 'Dog (Runes)', '0.00924725', '-1.50', '-1.71', '46.09', 924725153, 77124850, 100000000000);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int(11) NOT NULL,
  `coin_id` int(11) NOT NULL,
  `coin_name` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `forex_data`
--

CREATE TABLE `forex_data` (
  `id` int(11) NOT NULL,
  `symbol` varchar(10) COLLATE utf8_turkish_ci DEFAULT NULL,
  `open` decimal(10,5) DEFAULT NULL,
  `high` decimal(10,5) DEFAULT NULL,
  `low` decimal(10,5) DEFAULT NULL,
  `close` decimal(10,5) DEFAULT NULL,
  `previous_close` decimal(10,5) DEFAULT NULL,
  `change` decimal(10,5) DEFAULT NULL,
  `percent_change` decimal(10,5) DEFAULT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `forex_data`
--

INSERT INTO `forex_data` (`id`, `symbol`, `open`, `high`, `low`, `close`, `previous_close`, `change`, `percent_change`) VALUES
(1, 'EUR/USD', '1.08800', '1.08865', '1.08590', '1.08805', '1.08800', '0.00005', '0.00459'),
(2, 'USD/JPY', '154.85500', '156.31000', '154.75000', '156.07500', '154.89999', '1.17500', '0.75856'),
(3, 'GBP/USD', '1.27650', '1.27920', '1.27635', '1.27915', '1.27700', '0.00215', '0.16837'),
(4, 'USD/CHF', '0.89010', '0.89320', '0.88965', '0.89230', '0.89030', '0.00200', '0.22465'),
(5, 'AUD/USD', '0.66450', '0.66650', '0.66390', '0.66490', '0.66490', '0.00000', '0.00000'),
(6, 'USD/CAD', '1.36765', '1.36910', '1.36665', '1.36710', '1.36770', '-0.00060', '-0.04387'),
(7, 'USD/TRY', '32.58200', '32.67100', '32.34250', '32.38110', '32.57950', '-0.19840', '-0.60897');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `forum_messages`
--

CREATE TABLE `forum_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coin_id` int(11) NOT NULL,
  `message` text COLLATE utf8_turkish_ci NOT NULL,
  `message_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `reply_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `KullaniciID` int(11) NOT NULL,
  `Isim` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `Soyisim` varchar(150) COLLATE utf8_turkish_ci DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8_turkish_ci DEFAULT NULL,
  `EPosta` varchar(320) COLLATE utf8_turkish_ci DEFAULT NULL,
  `Sifre` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `profil_resmi` varchar(255) COLLATE utf8_turkish_ci DEFAULT 'pfp.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `portfoy`
--

CREATE TABLE `portfoy` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coin_id` int(11) NOT NULL,
  `quantity` decimal(18,8) NOT NULL,
  `cost` decimal(18,8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `symbol` varchar(10) COLLATE utf8_turkish_ci DEFAULT NULL,
  `open` float DEFAULT NULL,
  `high` float DEFAULT NULL,
  `low` float DEFAULT NULL,
  `close` float DEFAULT NULL,
  `previous_close` float DEFAULT NULL,
  `volume` bigint(20) DEFAULT NULL,
  `change` float DEFAULT NULL,
  `percent_change` float DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `stocks`
--

INSERT INTO `stocks` (`id`, `symbol`, `open`, `high`, `low`, `close`, `previous_close`, `volume`, `change`, `percent_change`, `timestamp`) VALUES
(1, 'AAPL', 194.64, 195.32, 193.03, 194.35, 194.03, 45372900, 0.32001, 0.16493, '2024-06-05 10:39:08'),
(2, 'MSFT', 412.43, 416.44, 409.68, 416.07, 413.52, 13573800, 2.55002, 0.61666, '2024-06-05 10:39:08'),
(3, 'AMZN', 177.64, 179.82, 176.44, 179.34, 178.34, 26177000, 1, 0.56073, '2024-06-05 10:39:08'),
(4, 'NVDA', 1157.16, 1166, 1140.45, 1164.37, 1150, 39537900, 14.37, 1.24956, '2024-06-05 10:39:08'),
(5, 'GOOGL', 173.28, 173.85, 171.89, 173.79, 173.17, 22732000, 0.62, 0.35803, '2024-06-05 10:39:08'),
(6, 'TSLA', 174.78, 177.76, 174, 174.77, 176.29, 59733200, -1.51999, -0.86221, '2024-06-05 10:39:08'),
(7, 'META', 477, 478.89, 473.23, 476.99, 477.49, 6958700, -0.5, -0.10471, '2024-06-05 10:39:08');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `coins`
--
ALTER TABLE `coins`
  ADD PRIMARY KEY (`coin_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Tablo için indeksler `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`coin_id`);

--
-- Tablo için indeksler `forex_data`
--
ALTER TABLE `forex_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_symbol` (`symbol`);

--
-- Tablo için indeksler `forum_messages`
--
ALTER TABLE `forum_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `coin_id` (`coin_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`KullaniciID`);

--
-- Tablo için indeksler `portfoy`
--
ALTER TABLE `portfoy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `coin_id` (`coin_id`);

--
-- Tablo için indeksler `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `symbol` (`symbol`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `coins`
--
ALTER TABLE `coins`
  MODIFY `coin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206808;

--
-- Tablo için AUTO_INCREMENT değeri `forex_data`
--
ALTER TABLE `forex_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=463;

--
-- Tablo için AUTO_INCREMENT değeri `forum_messages`
--
ALTER TABLE `forum_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `KullaniciID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `portfoy`
--
ALTER TABLE `portfoy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=596;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `forum_messages`
--
ALTER TABLE `forum_messages`
  ADD CONSTRAINT `forum_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`KullaniciID`),
  ADD CONSTRAINT `forum_messages_ibfk_2` FOREIGN KEY (`coin_id`) REFERENCES `coins` (`coin_id`);

--
-- Tablo kısıtlamaları `portfoy`
--
ALTER TABLE `portfoy`
  ADD CONSTRAINT `portfoy_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`KullaniciID`),
  ADD CONSTRAINT `portfoy_ibfk_2` FOREIGN KEY (`coin_id`) REFERENCES `coins` (`coin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
