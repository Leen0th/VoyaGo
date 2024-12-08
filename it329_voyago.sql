-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2024 at 07:56 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `it329_voyago`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `placeID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `placeID`, `userID`, `comment`) VALUES
(1, 9, 2, 'nice'),
(2, 11, 1, 'love it!'),
(7, 7, 5, 'good one '),
(8, 18, 5, 'wow');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `country`) VALUES
(1, 'Japan'),
(2, 'USA'),
(3, 'France'),
(4, 'Italy'),
(5, 'Spain'),
(6, 'Brazil'),
(7, 'Australia'),
(8, 'Canada');

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE `like` (
  `placeID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `like`
--

INSERT INTO `like` (`placeID`, `userID`) VALUES
(13, 1),
(3, 2),
(9, 2),
(7, 5),
(18, 5);

-- --------------------------------------------------------

--
-- Table structure for table `place`
--

CREATE TABLE `place` (
  `id` int(11) NOT NULL,
  `travelID` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text,
  `photoFileName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `place`
--

INSERT INTO `place` (`id`, `travelID`, `name`, `location`, `description`, `photoFileName`) VALUES
(2, 2, ' Tower of Pisa', 'Piazza del Duomo', 'The Leaning Tower of Pisa, or simply the Tower of Pisa, is the campanile, or freestanding bell tower, of Pisa Cathedral. It is known for its nearly four-degree lean, the result of an unstable foundation', 'images/bizza.jpg'),
(3, 3, 'Statue of Liberty', 'NY', 'The Statue of Liberty is a colossal neoclassical sculpture on Liberty Island in New York Harbor, within New York City', 'images/liberty2.jpg'),
(4, 6, 'Sydney Harbour Bridge', 'Sydney ', 'e Sydney Harbour Bridge is a steel through arch bridge in Sydney, New South Wales, Australia,', 'images/unnamed.jpg'),
(7, 9, 'Alexander Spatari', 'spain', 'cated on the Iberian Peninsula, Spain comprises 17 autonomous regions, each with its own distinctive scenery, landmarks, culture, and cuisine. ', 'images/spain.jpg'),
(8, 10, 'Rio De Janeiro', 'Rio de Janeiro', 'Rio de Janeiro is a huge seaside city in Brazil, famed for its Copacabana and Ipanema beaches, 38m Christ the Redeemer statue atop Mount Corcovado and for Sugarloaf Mountain, a granite peak with cable cars to its summit. The city is also known for its sprawling favelas (shanty towns). Its raucous Carnaval festival, featuring parade floats, flamboyant costumes and samba dancers, is considered the world’s largest', 'images/braz.avif'),
(9, 13, 'Manhaten ', 'Manhaten  city ', 'cool', 'images/man.jpg'),
(10, 14, 'samurai club', 'Tokyou ', 'Nice place to visit ', 'images/Samurai-Club.jpg'),
(11, 16, 'The Eiffel Tower', 'paris', 'The Eiffel Tower is a wrought-iron lattice tower on the Champ de Mars in Paris, France. It is named after the engineer Gustave Eiffel, whose company designed and built the tower from 1887 to 1889', 'images/109772534672cc83d6b1787.96494892.jpg'),
(12, 16, 'Marseille', 'Marseille', 'COOL', 'images/508882307672cc8a827f2e0.60437256.jpg'),
(13, 16, 'Bordeaux', 'Bordeaux', 'Good', 'images/2109535032672cc8e57a9243.62354760.jpg'),
(14, 17, 'Nagoya', 'Nagoya', 'Nagoya, capital of Japan’s Aichi Prefecture, is a manufacturing and shipping hub in central Honshu. The city’s Naka ward is home to museums and pachinko (gambling machine) parlors', 'images/718753304672cca206a3dd9.54109103.jpg'),
(18, 20, 'Great Ocean Road', 'Sydney', 'good place !', 'images/823295420672d1681926d95.84440295.jfif'),
(19, 21, 'Art park', 'Sao Paulo', 'good one wow ', 'images/1663307598672d1a8fbe0076.66323637.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `travel`
--

CREATE TABLE `travel` (
  `id` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `month` varchar(30) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `countryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel`
--

INSERT INTO `travel` (`id`, `userID`, `month`, `year`, `countryID`) VALUES
(2, 3, 'March', 2021, 4),
(3, 3, 'January', 2024, 2),
(6, 3, 'May', 2022, 7),
(9, 1, 'September', 2023, 5),
(10, 2, 'August', 2024, 6),
(13, 2, 'August', 2023, 2),
(14, 2, 'May', 2021, 1),
(16, 1, 'March', 2022, 3),
(17, 1, 'August', 2024, 1),
(20, 5, 'April', 2023, 7),
(21, 5, 'April', 2022, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photoFileName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `emailAddress`, `password`, `photoFileName`) VALUES
(1, 'lu', 'luh', 'lu@luluh.com', '$2y$12$aRm.7zXSeqFk37EYQqIchOWDbJo/1SNZs/btJmxeg/S/RL8eNIF72', ''),
(2, 'leen', '1', 'leen@luluh.com', '$2y$12$jjF2QnxaBxyIW5JThloj1e/OjwIHDOEJv6wSB4ValfpFUQWfmvQEu', ''),
(3, 'Ghaida', '2', 'Ghaida@luluh.com', '$2y$12$cjbA2IXv7NT46hiHpsk.eemugklo4fbt123sb26Ft9ioIA30sfNoG', ''),
(5, 'ahmad', 'awad', 'ahmad34@gmail.com', '$2y$12$VoDfH9zNO3mL6K6aIixyoeJvE6H5zbwMHSiZz6CHPpLk6wzayjZ3y', 'images/1785707758672cee80c61630.71646784.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `placeID` (`placeID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`placeID`,`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`id`),
  ADD KEY `travelID` (`travelID`);

--
-- Indexes for table `travel`
--
ALTER TABLE `travel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`),
  ADD KEY `countryID` (`countryID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `travel`
--
ALTER TABLE `travel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`placeID`) REFERENCES `place` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);

--
-- Constraints for table `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`placeID`) REFERENCES `place` (`id`),
  ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);

--
-- Constraints for table `place`
--
ALTER TABLE `place`
  ADD CONSTRAINT `place_ibfk_1` FOREIGN KEY (`travelID`) REFERENCES `travel` (`id`);

--
-- Constraints for table `travel`
--
ALTER TABLE `travel`
  ADD CONSTRAINT `travel_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `travel_ibfk_2` FOREIGN KEY (`countryID`) REFERENCES `country` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
