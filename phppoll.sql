-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2022 at 01:14 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phppoll`
--

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `title`, `description`) VALUES
(3, 'Kas täna on soe', 'Hääleta selle eest'),
(5, 'asd', 'asdasdasd'),
(6, 'yugioh', 'tuasdasd'),
(7, 'Terekest', ''),
(8, 'asdasd', ''),
(9, 'raikoesimene', ''),
(10, 'asd', ''),
(11, 'Kuidas oli sinu tänane hommik', '');

-- --------------------------------------------------------

--
-- Table structure for table `poll_answers`
--

CREATE TABLE `poll_answers` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `votes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `poll_answers`
--

INSERT INTO `poll_answers` (`id`, `poll_id`, `title`, `votes`) VALUES
(8, 3, 'Ei ole', 5),
(9, 3, 'On', 0),
(10, 3, 'Ei oska öelda', 1),
(14, 5, 'asd1', 0),
(15, 5, 'asd2', 1),
(16, 5, 'asd3', 0),
(17, 6, 'yugi', 1),
(18, 6, 'seto kaiba', 0),
(19, 6, 'rv', 0),
(20, 7, 'Asd', 1),
(21, 7, 'asd', 0),
(22, 7, 'asd', 0),
(23, 8, 'teree', 1),
(24, 8, 'tereeeeee', 0),
(25, 8, 'tereeeeeeeeeeeeeee', 0),
(26, 9, 'asd', 0),
(27, 10, 'asd', 1),
(28, 10, 'asd', 0),
(29, 10, 'asd', 0),
(30, 11, 'Hea', 1),
(31, 11, 'Hal', 0),
(32, 11, 'Ei ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `poll_votes`
--

CREATE TABLE `poll_votes` (
  `ip` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `poll_votes`
--

INSERT INTO `poll_votes` (`ip`, `id`) VALUES
(0, 2),
(0, 3),
(0, 2),
(0, 2),
(0, 5),
(0, 6),
(0, 7),
(0, 8),
(0, 10),
(0, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll_answers`
--
ALTER TABLE `poll_answers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `poll_answers`
--
ALTER TABLE `poll_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
