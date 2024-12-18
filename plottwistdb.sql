-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 17, 2024 at 07:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plottwistdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(30) DEFAULT NULL,
  `genre_id` int(11) NOT NULL,
  `mood_id` int(11) NOT NULL,
  `length_id` int(11) NOT NULL,
  `publication_year` year(4) NOT NULL,
  `isbn` varchar(13) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `book_file` varchar(250) NOT NULL,
  `page_count` int(11) NOT NULL,
  `cover_file` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `genre_id`, `mood_id`, `length_id`, `publication_year`, `isbn`, `description`, `book_file`, `page_count`, `cover_file`) VALUES
(68, 'Edit test', 'Rerum asperiores quo', 1, 13, 1, '2005', 'Repellendus ', 'In cupiditate obcaec', '../assets/book_uploads/white-spiral-staircase.epub', 200, ''),
(70, 'Eum accusantium blan', 'Eos quia proident ', 1, 13, 1, '2006', 'Ad ut velit ', 'Vitae qui aut ipsam ', '../assets/book_uploads/dostoyevsky-white-nights-and-other-stories.epub', 867, ''),
(71, 'To Kill a Mocking Bird', 'Gwen Stephano', 2, 13, 1, '2007', '123424-90', 'This is a great read', '../assets/book_uploads/white-spiral-staircase.epub', 43, ''),
(72, 'Eiusmod in est rerum', 'Unde mollitia conseq', 2, 15, 2, '1992', 'Enim deserunt', 'Nisi nihil voluptate', '../assets/book_uploads/pg74914-images-3.epub', 320, '../assets/cover_uploads/859672.png'),
(73, 'Unde dolor excepteur', 'Consequat Non autem', 1, 14, 1, '1985', 'Dolore magnam', 'Pariatur Esse perf', '../assets/book_uploads/pg74914-images-3.epub', 12, '../assets/cover_uploads/Colorful T-Shirt Transparent.png'),
(74, 'Sed autem nulla ut c', 'Laborum dolor et ad ', 5, 14, 1, '1976', 'Officia volup', 'Aliquip est officia ', '../assets/book_uploads/pg74914-images-3.epub', 77, '../assets/cover_uploads/feature_graphic1.png');

-- --------------------------------------------------------

--
-- Table structure for table `book_length`
--

CREATE TABLE `book_length` (
  `length_id` int(11) NOT NULL,
  `length_name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_length`
--

INSERT INTO `book_length` (`length_id`, `length_name`) VALUES
(1, 'Short'),
(2, 'Medium'),
(3, 'Long');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_name`) VALUES
(1, 'Fiction'),
(2, 'Thriller'),
(3, 'Romance'),
(4, 'Fantasy'),
(5, 'Non-Fiction');

-- --------------------------------------------------------

--
-- Table structure for table `mood`
--

CREATE TABLE `mood` (
  `mood_id` int(11) NOT NULL,
  `mood_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mood`
--

INSERT INTO `mood` (`mood_id`, `mood_name`) VALUES
(13, 'Happy'),
(14, 'Sad'),
(15, 'Inspirational'),
(16, 'Thrilling');

-- --------------------------------------------------------

--
-- Table structure for table `personality`
--

CREATE TABLE `personality` (
  `personality_id` int(11) NOT NULL,
  `personality_name` varchar(20) NOT NULL,
  `description` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personality`
--

INSERT INTO `personality` (`personality_id`, `personality_name`, `description`) VALUES
(1, 'The Explorer', ''),
(2, 'The Adventurer', ''),
(3, 'The Dreamer', ''),
(4, 'The Scholar', ''),
(5, 'The Free Spirit', '');

-- --------------------------------------------------------

--
-- Table structure for table `personality_mapping`
--

CREATE TABLE `personality_mapping` (
  `personality_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personality_mapping`
--

INSERT INTO `personality_mapping` (`personality_id`, `genre_id`) VALUES
(2, 2),
(3, 3),
(3, 1),
(2, 1),
(5, 4),
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `quiz_name` varchar(100) NOT NULL,
  `quiz_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `user_id` int(11) NOT NULL,
  `personality` int(11) NOT NULL,
  `result_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`user_id`, `personality`, `result_date`) VALUES
(1, 2, '2024-12-16 22:29:33'),
(4, 5, '2024-12-16 23:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `reading_progress`
--

CREATE TABLE `reading_progress` (
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_started` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_completed` timestamp NULL DEFAULT NULL,
  `current_page_location` varchar(120) DEFAULT NULL,
  `progress_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reading_progress`
--

INSERT INTO `reading_progress` (`user_id`, `book_id`, `status`, `date_started`, `date_completed`, `current_page_location`, `progress_count`) VALUES
(1, 70, 2, '2024-12-16 17:33:08', '2024-12-17 18:25:01', 'epubcfi(/6/74!/4/4[id70285891906980]/160/1:993)', 100),
(1, 68, 1, '2024-12-16 17:35:21', NULL, 'epubcfi(/6/4!/4/4/1:0)', 0),
(1, 72, 1, '2024-12-17 14:21:43', NULL, 'epubcfi(/6/4!/4/82[id00039]/1:248)', 13),
(1, 71, 1, '2024-12-17 14:24:22', NULL, 'epubcfi(/6/10!/4/4[id70322861922500]/54/1:0)', 3);

-- --------------------------------------------------------

--
-- Table structure for table `reading_status`
--

CREATE TABLE `reading_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reading_status`
--

INSERT INTO `reading_status` (`status_id`, `status_name`) VALUES
(1, 'Reading'),
(2, 'Finished'),
(3, 'Bookmarked');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `registration_date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_role` int(11) NOT NULL DEFAULT 2,
  `first_login_quiz_completed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `profile_picture`, `registration_date`, `user_role`, `first_login_quiz_completed`) VALUES
(1, 'venegareza', 'pamuzeqy@mailinator.com', '$2y$10$eHD9eeTQ/5vt/y.C9vpTGuqaiTO13BsOUyTYRvf6EY.9VV2odKEhm', NULL, '2024-12-15 13:31:39', 2, 1),
(2, 'locorode', 'lysozafav@mailinator.com', '$2y$10$W1iJM.q426Ms5CdjNtrOKOR.IUr5/NDh6.yMR2DsF/qNtzRXHSmQe', NULL, '2024-12-16 16:19:11', 1, 0),
(4, 'dsaf', 'kawadomo@mailinator.com', '$2y$10$GXujB/AQWH0YG2PFnWxB6OkMWfx/c/QymmVJ.1YR6z8yMpPwVRl.K', NULL, '2024-12-16 22:15:43', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_book_ratings`
--

CREATE TABLE `user_book_ratings` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL CHECK (`rating` >= 0 and `rating` <= 5),
  `review_text` text DEFAULT NULL,
  `rating_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `genre_id` (`genre_id`),
  ADD KEY `length_id` (`length_id`),
  ADD KEY `mood_id` (`mood_id`);

--
-- Indexes for table `book_length`
--
ALTER TABLE `book_length`
  ADD PRIMARY KEY (`length_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `mood`
--
ALTER TABLE `mood`
  ADD PRIMARY KEY (`mood_id`);

--
-- Indexes for table `personality`
--
ALTER TABLE `personality`
  ADD PRIMARY KEY (`personality_id`);

--
-- Indexes for table `personality_mapping`
--
ALTER TABLE `personality_mapping`
  ADD KEY `genre_id` (`genre_id`),
  ADD KEY `personality_id` (`personality_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `personality` (`personality`);

--
-- Indexes for table `reading_progress`
--
ALTER TABLE `reading_progress`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `reading_status`
--
ALTER TABLE `reading_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_role` (`user_role`);

--
-- Indexes for table `user_book_ratings`
--
ALTER TABLE `user_book_ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `book_length`
--
ALTER TABLE `book_length`
  MODIFY `length_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mood`
--
ALTER TABLE `mood`
  MODIFY `mood_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personality`
--
ALTER TABLE `personality`
  MODIFY `personality_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reading_status`
--
ALTER TABLE `reading_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_book_ratings`
--
ALTER TABLE `user_book_ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `Genres` (`genre_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_ibfk_3` FOREIGN KEY (`length_id`) REFERENCES `book_length` (`length_id`),
  ADD CONSTRAINT `books_ibfk_4` FOREIGN KEY (`mood_id`) REFERENCES `mood` (`mood_id`);

--
-- Constraints for table `personality_mapping`
--
ALTER TABLE `personality_mapping`
  ADD CONSTRAINT `personality_mapping_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`),
  ADD CONSTRAINT `personality_mapping_ibfk_2` FOREIGN KEY (`personality_id`) REFERENCES `personality` (`personality_id`);

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_results_ibfk_2` FOREIGN KEY (`personality`) REFERENCES `personality` (`personality_id`);

--
-- Constraints for table `reading_progress`
--
ALTER TABLE `reading_progress`
  ADD CONSTRAINT `reading_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reading_progress_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `reading_progress_ibfk_3` FOREIGN KEY (`status`) REFERENCES `reading_status` (`status_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_role`) REFERENCES `user_role` (`role_id`);

--
-- Constraints for table `user_book_ratings`
--
ALTER TABLE `user_book_ratings`
  ADD CONSTRAINT `user_book_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_book_ratings_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `Books` (`book_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
