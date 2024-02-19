-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2024 at 09:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;

/*!40101 SET NAMES utf8mb4 */
;

--
-- Database: `litlist`
--
-- --------------------------------------------------------
--
-- Table structure for table `authors`
--
CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `infix` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--
INSERT INTO
  `authors` (`author_id`, `first_name`, `infix`, `last_name`)
VALUES
  (12, 'Abdelkader', '', 'Benali '),
  (2, 'Clar', '', 'Accord'),
  (8, 'Dirk', '', 'Ayelt Kooiman'),
  (10, 'Els', '', 'Beerten'),
  (9, 'Gerbrand', '', 'Bakker'),
  (13, 'J.', '', 'Bernlef'),
  (1, 'Kader', '', 'Abdolah'),
  (4, 'Karin', '', 'Amatmoekrim'),
  (11, 'Kees', 'van', 'Beijnum'),
  (3, 'Özcan', '', 'Akyol'),
  (6, 'René', '', 'Appel'),
  (5, 'Robert', '', 'Anker'),
  (7, 'Simone', '', 'Atangana Bekono');

-- --------------------------------------------------------
--
-- Table structure for table `authors_books`
--
CREATE TABLE `authors_books` (
  `author_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `authors_books`
--
INSERT INTO
  `authors_books` (`author_id`, `book_id`)
VALUES
  (1, 2),
  (1, 3),
  (1, 4),
  (2, 2),
  (2, 5),
  (3, 6),
  (4, 7),
  (5, 8),
  (5, 9),
  (6, 10),
  (6, 11),
  (7, 12),
  (9, 14),
  (9, 15),
  (9, 16),
  (9, 17),
  (10, 18),
  (11, 19),
  (11, 20),
  (11, 21),
  (12, 22),
  (12, 23),
  (13, 24),
  (13, 25);

-- --------------------------------------------------------
--
-- Table structure for table `books`
--
CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `blurb` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `pages` smallint(6) DEFAULT NULL,
  `reading_level` tinyint(4) DEFAULT NULL,
  `publication_year` year(4) DEFAULT NULL,
  `review_link` varchar(255) DEFAULT NULL,
  `discussed_in` varchar(255) DEFAULT NULL,
  `image_link` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `books`
--
INSERT INTO
  `books` (
    `book_id`,
    `title`,
    `blurb`,
    `summary`,
    `pages`,
    `reading_level`,
    `publication_year`,
    `review_link`,
    `discussed_in`,
    `image_link`
  )
VALUES
  (
    2,
    'De reis van de lege flessen',
    'Een asielzoeker doet zijn best om te integreren in Nederland.',
    'Bolfazl is gevlucht uit Iran. In Nederland probeert hij te integreren. Samen met zijn gezin woont hij in een klein plaatsje aan de oever van de IJssel. Zijn buurman, Ren?, gescheiden vader van een dochtertje, en homo, vangt hem op en probeert hem wegwijs te maken in ons land. Als de moeder van Bolfazl komt logeren, heeft ze grote moeite met het idee dat ze naast een homofiele man logeert, hoe attent die ook voor haar is.\nRen? verhuist en verdwijnt later definitief uit het leven van Bolfazl. Deze realiseert zich dat zijn vrouw en zijn kind zich gemakkelijker aanpassen aan de nieuwe situatie.\nBolfazl beseft dat hij vooruit moet en ondanks de problemen die hij op zijn pad vindt en die hem nog vaak doen terugdenken aan zijn land van herkomst, merkt hij dat hij zich langzaam maar zeker in ons land gaat thuis voelen.',
    156,
    3,
    '1997',
    '',
    '',
    'https://media.s-bol.com/mZRwNoZ49pyG/748x1200.jpg'
  ),
  (
    3,
    'Het huis van de moskee',
    'Het leven in een Iraans dorp in de afgelopen vijftig jaar.',
    'Het huis van de moskee is een roman over een oude Perzische familie die al heel lang de zorg over de grote moskee heeft. Maar het is ook een roman over de politieke ontwikkelingen in Iran, waar de sjah probeerde zijn land te moderniseren en toen grote problemen kreeg met de overwegend nog streng gelovige bevolking. De huidige politieke situatie is een rechtstreeks voortvloeisel uit de revolutie die in dit boek treffend beschreven wordt.\nHet boek eindigde in de verkiezing van het belangrijkste Nederlandse literaire werk aller tijden op de tweede plaats!',
    400,
    3,
    '2005',
    '',
    '',
    'https://media.s-bol.com/qZJ6gx4AVQ2p/534x840.jpg'
  ),
  (
    4,
    'Spijkerschrift',
    'Het levensverhaal van een doofstomme Pers in de woelige jaren rondom de Revolutie, verteld door zijn zoon',
    'Spijkerschrift gaat over Aga Akbar, de doofstomme vader van Ismaiel. Aga heeft in de loop van zijn leven zijn ervaringen opgetekend in een zelf ontworpen spijkerschrift. Na Aga\"s dood krijgt Ismaiel, die om politieke redenen naar Nederland is gekomen, de op het eerste gezicht volstrekt onbegrijpelijke aantekeningen van zijn vader thuisbezorgd. Ismaiel, die vroeger al de gebarentaal van zijn vader moest \"vertalen\" voor anderen, maakt van de aantekeningen de levensbeschrijving van zijn vader. Een meeslepend verhaal!',
    374,
    4,
    '2000',
    '',
    '',
    ''
  ),
  (
    5,
    'De koningin van Paramaribo',
    'https://15-18.jeugdbibliotheek.nl/lezen/lezen-voor-de-lijst/niveau-2/de-koningin-van-paramaribo.html',
    '',
    317,
    2,
    '1999',
    '',
    '',
    ''
  ),
  (
    6,
    'Eus',
    'https://15-18.jeugdbibliotheek.nl/lezen/lezen-voor-de-lijst/niveau-2/eus.html',
    '',
    271,
    2,
    '2012',
    '',
    '',
    ''
  ),
  (
    7,
    'Het gym',
    'De twaalfjarige Sandra Spalburg woont met haar moeder en halfzusje in \'De Wijk\', een vervallen, armoedig deel van een stad aan de kust. Sandra is een heel intelligent meisje en zij gaat daarom als enige kind uit De Wijk naar het chique gymnasium in het ri',
    '',
    256,
    2,
    '2011',
    '',
    '',
    ''
  ),
  (
    8,
    'Hajar en Daan',
    'Een leraar wordt verliefd op een van zijn Marokkaanse leerlingen',
    'Daan Hollander is leraar geschiedenis op een zwarte school in Amsterdam. Hij is totaal niet ge?nteresseerd in zijn vak, niet in leerlingen, alleen in alles wat hem snel genot garandeert. Maar dan komt het Marokkaanse meisje Hajar in zijn klas. Ze zijn meteen w?g van elkaar. Tegen alle waarschuwingen vanuit zijn omgeving in, begint Daan een relatie met het meisje. Het is niet zo verwonderlijk dat die relatie bij een heleboel mensen (collega\'s, de rector, de familie van Hajar) op steeds meer tegenstand stuit, maar Hajar en Daan gaan de confrontatie aan met hun omgeving.\nHajar heeft duidelijk ook een zeer beschavende invloed op Daan, die warempel aangestoken wordt door haar streven om zichzelf en haar omgeving maximaal te emanciperen, te ontwikkelen. Hij raakt ge?nteresseerd in allerlei zaken die hem tevoren koud lieten.\nHoe hun liefdesrelatie verder verloopt, moet je zelf maar lezen.',
    288,
    3,
    '2004',
    '',
    '',
    ''
  ),
  (
    9,
    'Een soort Engeland',
    'https://www.bibliotheek.nl/catalogus/titel.299124754.html/een-soort-engeland/',
    '',
    268,
    0,
    '2002',
    'https://www.volkskrant.nl/nieuws-achtergrond/bijna-ziekmakend-realistisch~b71c3b88/',
    '',
    ''
  ),
  (
    10,
    'Loverboy',
    'Een schrijfster brengt een van haar gewelddadige verhalen in de praktijk.',
    'Loverboy is een spannend verhaal over een schrijfster van misdaadverhalen, Yoka, die haar man Hans, journalist, verdenkt van overspel.\nZe schrijft een roman die gaat over Anouk, een detective die een weggelopen tienermeisje moet zien te vinden. Yoka gaat zich in haar gewone leven steeds meer gedragen als haar romanpersonage Anouk. Verhaal en werkelijkheid gaan steeds meer op elkaar lijken!!\nEen spannend verhaal, dat door de wisseling van de twee verhaallijnen wel van je vraagt dat je er met je hersens bij blijft.',
    297,
    2,
    '2005',
    '',
    '',
    'https://media.s-bol.com/7vOX5gnkk6B/522x840.jpg'
  ),
  (
    11,
    'Noodzakelijk kwaad',
    'In het gezin van een bouwondernemer leiden grote spanningen tussen de ouders en hun opstandige dochter, maar ook tussen de ouders onderling tot een drama.',
    'Menno, bouwondernemer, neemt het niet zo nauw met de regels. Hij heeft een \'dure\' vrouw, Franka, en een opstandige dochter, Cecile. Dat Franka overspel pleegt met zijn compagnon Wouter, weet hij niet. Dat Cecile na knallende ruzies thuis wegloopt en gaat samenwonen met de lesbische Danny, in een kraakpand, stemt hem bepaald niet gelukkig. Hij denkt echter de zaken nog wel onder controle te hebben. Maar door een domme samenloop van omstandigheden ontstaat er een drama, en komen hij ?n die vier mensen om hem heen stuk voor stuk in grote problemen.',
    268,
    2,
    '2002',
    '',
    '',
    ''
  ),
  (
    12,
    'Confrontaties',
    'Een jong meisje zit in een jeugdgevangenis nadat ze twee schoolgenoten zwaar heeft mishandeld. ',
    'Salom? is veroordeeld tot zes maanden jeugddetentie, na de mishandeling van twee schoolgenoten. Woede, eenzaamheid, verdriet en ook angst houden haar in hun greep: want ze moet ook weer terug naar huis, naar haar ouders en zus, ?n naar haar dorp, waar haar slachtoffers wonen.  ',
    221,
    3,
    '2020',
    '',
    '',
    ''
  ),
  (
    14,
    'De kapperszoon',
    'Een eenzelvige, ?onsociale? man raakt ge?ntrigeerd door de gebeurtenissen rond zijn vader, die kort voor zijn geboorte  zijn moeder in de steek liet en bij een vliegramp om het leven kwam.',
    'Simon heeft zijn vader nooit gekend. Die liet, kort voor zijn geboorte zijn zwangere vrouw in de steek en ging op reis met het KLM-toestel dat in 1977 op Tenerife tegen een Amerikaanse Boeing knalde. Alle passagiers in het Nederlandse toestel kwamen om het leven. Simon raakt ge?ntrigeerd door die verdwijning en die ramp, gaat, na al die jaren, zijn oude moeder vragen stellen. Wat speelde er destijds??',
    299,
    3,
    '2022',
    '',
    '',
    'https://media.s-bol.com/XnlvA65Bry3l/mOOJ7q3/523x840.jpg'
  ),
  (
    15,
    'De omweg',
    'Een vrouw vertrekt naar het buitenland, zonder haar man iets te zeggen, en vestigt zich in een afgelegen huis in Wales. Langzaam wordt duidelijk waarom ze deze opmerkelijke stap gezet heeft\'?',
    'Een vrouw vertrekt zonder haar man iets te zeggen, met wat spullen in de aanhanger achter haar auto en reist naar Wales, waar ze een afgelegen huisje huurt. Dat maakt ze bewoonbaar en ze verzorgt de tuin. Een jonge Welshman trekt bij haar in. Haar ogenschijnlijk idyllische bestaan begint steeds meer barstjes te vertonen, en langzaam wordt duidelijk waarom ze de eenzaamheid heeft opgezocht. ',
    235,
    3,
    '2010',
    '',
    '',
    ''
  ),
  (
    16,
    'Perenbomen bloeien wit',
    'https://12-15.jeugdbibliotheek.nl/lezen/lezen-voor-de-lijst/niveau-3/perenbomen-bloeien-wit.html',
    '',
    137,
    0,
    '1999',
    'https://www.volkskrant.nl/cultuur-media/van-blind-spelen-tot-blind-zijn~ba5a5719/',
    '',
    ''
  ),
  (
    17,
    'Boven is het stil',
    'https://15-18.jeugdbibliotheek.nl/lezen/lezen-voor-de-lijst/niveau-4/boven-is-het-stil.html',
    'Het is het verhaal van Helmer van Wonderen die, nadat zijn tweelingbroer bij een ongeluk om het leven gekomen is, min of meer gedwongen wordt door zijn vader om diens plaats op de boerderij in te nemen, terwijl hij heel andere plannen had. Als zijn vader oud geworden is en Helmer de touwtjes in handen heeft, neemt hij wraak op hem. Maar er verandert nog meer in zijn leven, als hij eenmaal de eerste stap gezet heeft.',
    264,
    4,
    '2006',
    'https://www.volkskrant.nl/cultuur-media/vader-is-naar-boven-gedaan~b5fb9d05/',
    '',
    ''
  ),
  (
    18,
    'Lopen voor je leven',
    'Tijdens het lopen van een marathon komen bij Noor allerlei herinneringen boven, waaronder die aan een gruwelijke gebeurtenis uit haar jeugd.',
    'Tijdens het lopen van haar eerste marathon overdenkt de achttienjarige Noor de gebeurtenissen uit haar leven, hoe schuldgevoel vanwege de dood van een vriendinnetje haar tot op dat moment in zijn greep houdt.',
    183,
    2,
    '2003',
    '',
    '',
    ''
  ),
  (
    19,
    '23 Seconden',
    'Een jonge vrouw, wier moeder, prostituee op de Wallen, destijds is vermoord, gaat op zoek naar wat er destijds precies gebeurd is en komt tot schokkende ontdekkingen',
    'Anne was 18 toen haar moeder in haar peeskamer op de Wallen werd vermoord. Ze wil een roman schrijven over haar jeugd en daar hoort het verhaal van die moord natuurlijk ook in. Ze zoekt oude kennissen op, merkt dat er nogal wat onduidelijkheden zijn terwijl de zaak destijds heel helder leek, en komt erachter dat sommige mensen heel ver willen gaan om haar te verhinderen om door te zoeken. De uitkomst van haar zoektocht is schokkend!',
    389,
    3,
    '2019',
    '',
    '',
    ''
  ),
  (
    20,
    'Oesters van Nam Kee',
    'Een jongen, opgesloten in een Franse gevangenis, kijkt terug op de ontwikkelingen die hem daar gebracht hebben.',
    'Berry Kooijman is een scholier uit een van de \"betere\" buurten van Amsterdam. Zijn vader is gestorven, zijn moeder werkt bij de reclassering, zijn oudere broer is een voorbeeld en een bron van ergernis voor Berry. Op het moment dat het verhaal begint, is Berry gevlucht uit Amsterdam, naar het huis in Frankrijk waar hun gezin destijds mooie vakanties beleefde. Waarom hij precies moest vluchten wordt langzaam maar zeker onthuld. Berry liegt tegen iedereen in zijn omgeving: tegen zijn vrienden over zijn \"sjieke\" afkomst, tegen zijn moeder en broer over zijn mislukking op school. Alleen tegen zijn vriendin Thera is hij eerlijk. Thera en Berry beleven samen een prachtige tijd, maar nadat ze op een slimme wijze een aantal mensen een groot bedrag afhandig hebben gemaakt om aan geld te komen voor een wereldreis, ver van alle kneuterigheid van ouders en verplichtingen, haakt Thera af en kiest ze voor de veiligheid van een \"vaste(re) relatie\". \"Dirty Berry\" zoals Berry zich graag laat noemen door zijn vrienden van de straat, of \"Diablo\", zoals alleen Thera hem mag noemen, wacht in het huis van bewaring op zijn proces. Daar vertelt hij aan een psychiater wat er allemaal gebeurd is in zijn leven. Ook hierbij kleurt hij de werkelijkheid. Toch wordt langzaam maar zeker duidelijk dat Berry eigenlijk, net als miljoenen andere jongeren, op zoek is naar \"echtheid\", naar liefde. Stap voor stap wordt hem duidelijk dat hij die echtheid niet bij zijn vrienden kan vinden, dat de herinneringen aan zijn vader wel eens niet echt zouden kunnen zijn, dat de grote liefde voor Thera uiteindelijk onbeantwoord zal blijven. Dan komt hij tot een daad waarvan hij de gevolgen niet kan overzien',
    320,
    3,
    '2000',
    '',
    '',
    'https://media.s-bol.com/mnW9ror1GNBn/xRB6PP/778x1200.jpg'
  ),
  (
    21,
    'Paradiso',
    'Een man besluit te gaan scheiden; maar een dijkdoorbraak waarbij zijn vrouw vermist raakt, verandert de situatie.',
    'Paradiso is het verhaal Mart Hitz, op weg naar huis om zijn vrouw te vertellen dat hij haar gaat verlaten voor zijn nieuwe liefde. Maar dan blijkt er een dijkdoorbraak te hebben plaatsgevonden: de hele omgeving is ge?vacueerd en zijn vrouw is nergens te vinden. Mart start een zoektocht naar zijn vrouw die hem nogal wat schokkende informatie oplevert over haar leven!.\n',
    292,
    3,
    '2008',
    '',
    '',
    ''
  ),
  (
    22,
    'Bruiloft aan zee',
    'https://15-18.jeugdbibliotheek.nl/lezen/lezen-voor-de-lijst/niveau-4/bruiloft-aan-zee.html',
    '',
    222,
    4,
    '1996',
    '',
    '',
    ''
  ),
  (
    23,
    'De langverwachte',
    'https://www.hebban.nl/boeken/de-langverwachte-abdelkader-benali',
    '',
    396,
    0,
    '2003',
    '',
    '',
    ''
  ),
  (
    24,
    'Op slot',
    'Als na de dood van een oude schilder zijn vriend zich over de nalatenschap buigt, stuit hij op schokkende stukjes verleden.',
    'Op slot is het verhaal van twee oude kunstenaars, de schilder IJsbrand Blok en de fotograaf Dick Noordeloos. Als Blok plotseling sterft, vraagt zijn dochter Karien aan Dick om de collectie schilderijen te fotograferen voor een catalogus bij een overzichtstentoonstelling van Bloks werk. Dick stuit, samen met Karien, op een afgesloten kamer en langzaam komt hij erachter wat voor drama zich in de woning van zijn oude vriend heeft afgespeeld.',
    185,
    3,
    '2007',
    '',
    '',
    ''
  ),
  (
    25,
    'De onzichtbare jongen',
    'De vriendschap tussen twee opmerkelijke jongens bloedt dood. Jaren later ontmoeten ze elkaar onder merkwaardige omstandigheden.',
    'De onzichtbare jongen gaat over twee vrienden, kort na de Tweede Wereldoorlog: Max Veldman en Wouter van Bakel komen bij elkaar in de klas en raken bevriend. Max is gefascineerd door zaken waar zijn leeftijdgenoten niets aan vinden: hij wil de onzichtbare wereld van de wind in kaart brengen. Wouter is hardloper en droomt van records.Later verwatert hun vriendschap.\nWouter krijgt te maken met tegenslagen en ziekte, maar als hij daar net van aan het bijkomen is, komt hij erachter dat het met Max ook niet best gegaan is.\nEen helder verhaal over twee opvallende jongens.\n',
    188,
    3,
    '2005',
    '',
    '',
    ''
  );

-- --------------------------------------------------------
--
-- Table structure for table `genres`
--
CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `genre` varchar(40) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `genres_books`
--
CREATE TABLE `genres_books` (
  `genre_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `themes`
--
CREATE TABLE `themes` (
  `theme_id` int(11) NOT NULL,
  `theme` varchar(50) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `themes`
--
INSERT INTO
  `themes` (`theme_id`, `theme`)
VALUES
  (3, 'andere plaatsen andere tijden'),
  (16, 'berust op werkelijkheid'),
  (13, 'de adolescent'),
  (4, 'eenzaamheid'),
  (14, 'familie'),
  (15, 'kunst en kunstenaar'),
  (2, 'liefde'),
  (5, 'misdaad'),
  (6, 'oorlog'),
  (10, 'op zoek naar je wortels'),
  (11, 'ouders en kinderen'),
  (7, 'psychische gestoordheid'),
  (1, 'rebellie'),
  (12, 'school'),
  (9, 'vrouwenstrijd'),
  (8, 'ziekte en dood');

-- --------------------------------------------------------
--
-- Table structure for table `themes_books`
--
CREATE TABLE `themes_books` (
  `theme_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `themes_books`
--
INSERT INTO
  `themes_books` (`theme_id`, `book_id`)
VALUES
  (1, 2),
  (1, 7),
  (1, 20),
  (2, 2),
  (2, 7),
  (3, 2),
  (3, 8),
  (4, 3),
  (4, 8),
  (4, 14),
  (5, 3),
  (5, 8),
  (5, 15),
  (6, 3),
  (6, 9),
  (6, 15),
  (7, 4),
  (7, 9),
  (7, 16),
  (8, 4),
  (8, 10),
  (8, 16),
  (9, 4),
  (9, 10),
  (9, 16),
  (10, 5),
  (10, 10),
  (10, 18),
  (11, 5),
  (11, 11),
  (11, 18),
  (12, 5),
  (12, 11),
  (12, 19),
  (13, 6),
  (13, 11),
  (13, 20),
  (14, 6),
  (14, 12),
  (14, 20),
  (15, 6),
  (15, 12),
  (15, 20),
  (16, 7),
  (16, 12),
  (16, 20);

--
-- Indexes for dumped tables
--
--
-- Indexes for table `authors`
--
ALTER TABLE
  `authors`
ADD
  PRIMARY KEY (`author_id`),
ADD
  UNIQUE KEY `first_name` (`first_name`, `infix`, `last_name`);

--
-- Indexes for table `authors_books`
--
ALTER TABLE
  `authors_books`
ADD
  UNIQUE KEY `author_id` (`author_id`, `book_id`),
ADD
  KEY `book_id` (`book_id`);

--
-- Indexes for table `books`
--
ALTER TABLE
  `books`
ADD
  PRIMARY KEY (`book_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE
  `genres`
ADD
  PRIMARY KEY (`genre_id`),
ADD
  UNIQUE KEY `genre` (`genre`);

--
-- Indexes for table `genres_books`
--
ALTER TABLE
  `genres_books`
ADD
  UNIQUE KEY `genre_id` (`genre_id`, `book_id`),
ADD
  KEY `book_id` (`book_id`);

--
-- Indexes for table `themes`
--
ALTER TABLE
  `themes`
ADD
  PRIMARY KEY (`theme_id`),
ADD
  UNIQUE KEY `theme` (`theme`);

--
-- Indexes for table `themes_books`
--
ALTER TABLE
  `themes_books`
ADD
  UNIQUE KEY `theme_id` (`theme_id`, `book_id`),
ADD
  KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE
  `authors`
MODIFY
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 15;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE
  `books`
MODIFY
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 26;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE
  `genres`
MODIFY
  `genre_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE
  `themes`
MODIFY
  `theme_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 17;

--
-- Constraints for dumped tables
--
--
-- Constraints for table `authors_books`
--
ALTER TABLE
  `authors_books`
ADD
  CONSTRAINT `authors_books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`author_id`) ON DELETE CASCADE,
ADD
  CONSTRAINT `authors_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `genres_books`
--
ALTER TABLE
  `genres_books`
ADD
  CONSTRAINT `genres_books_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`) ON DELETE CASCADE,
ADD
  CONSTRAINT `genres_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `themes_books`
--
ALTER TABLE
  `themes_books`
ADD
  CONSTRAINT `themes_books_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`theme_id`) ON DELETE CASCADE,
ADD
  CONSTRAINT `themes_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;