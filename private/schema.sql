-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2024 at 06:34 PM
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

-- --------------------------------------------------------
--
-- Table structure for table `books`
--
CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_link` varchar(255) DEFAULT NULL,
  `publication_year` smallint(4) DEFAULT NULL,
  `audiobook` varchar(25) DEFAULT NULL,
  `pages` smallint(6) DEFAULT NULL,
  `blurb` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `reading_level` tinyint(4) DEFAULT NULL,
  `recommendation_text` text DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `review_link` varchar(255) DEFAULT NULL,
  `secondary_literature_text` text DEFAULT NULL,
  `secondary_literature_link` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `books_authors`
--
CREATE TABLE `books_authors` (
  `book_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `books_themes`
--
CREATE TABLE `books_themes` (
  `book_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL
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
-- Indexes for table `books`
--
ALTER TABLE
  `books`
ADD
  PRIMARY KEY (`book_id`);

--
-- Indexes for table `books_authors`
--
ALTER TABLE
  `books_authors`
ADD
  UNIQUE KEY `author_id` (`author_id`, `book_id`),
ADD
  KEY `book_id` (`book_id`);

--
-- Indexes for table `books_themes`
--
ALTER TABLE
  `books_themes`
ADD
  UNIQUE KEY `theme_id` (`theme_id`, `book_id`),
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
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE
  `authors`
MODIFY
  `author_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE
  `books`
MODIFY
  `book_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE
  `themes`
MODIFY
  `theme_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--
--
-- Constraints for table `books_authors`
--
ALTER TABLE
  `books_authors`
ADD
  CONSTRAINT `books_authors_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`author_id`) ON DELETE CASCADE,
ADD
  CONSTRAINT `books_authors_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `books_themes`
--
ALTER TABLE
  `books_themes`
ADD
  CONSTRAINT `books_themes_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`theme_id`) ON DELETE CASCADE,
ADD
  CONSTRAINT `books_themes_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;