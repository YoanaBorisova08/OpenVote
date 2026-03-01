-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Време на генериране: 28 фев 2026 в 08:49
-- Версия на сървъра: 10.4.32-MariaDB
-- Версия на PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данни: `open_vote`
--

-- --------------------------------------------------------

--
-- Структура на таблица `comments`
--

CREATE TABLE `comments` (
  `id` int(20) NOT NULL,
  `admin_id` int(20) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `suggestion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура на таблица `suggestions`
--

CREATE TABLE `suggestions` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('new','approved','in_progress','completed','rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `suggestions`
--

INSERT INTO `suggestions` (`id`, `title`, `description`, `created_at`, `updated_at`, `status`) VALUES
(3, 'Mobile App Development', 'Create a native mobile application for iOS and Android to improve user engagement and notifications.', '2026-02-27 14:32:11', '2026-02-21 18:25:22', 'new'),
(4, 'Weekly Top Proposal Highlight', 'Display the most voted proposal on the homepage every week to increase visibility.', '2026-02-21 14:32:11', '2026-02-26 15:41:36', 'approved'),
(5, 'Add Comment Moderation Tools', 'Provide administrators with tools to manage and moderate user comments.', '2026-02-21 14:32:11', '2026-02-21 14:58:16', 'new'),
(6, 'Email Notification System', 'Notify users when their proposal receives votes or comments.', '2026-02-21 14:32:11', '2026-02-21 18:16:24', 'new'),
(7, 'Improve Website Performance', 'Optimize loading speed and database queries for better user experience.', '2026-02-21 14:32:11', '2026-02-26 18:56:13', 'new'),
(8, 'Add Category Filtering', 'Allow users to filter proposals by category for easier navigation.', '2026-02-21 14:32:11', '2026-02-21 18:16:17', 'new'),
(9, 'Two-Factor Authentication', 'Add 2FA for improved account security.', '2026-02-21 14:32:11', '2026-02-21 18:16:15', 'new'),
(10, 'Export Voting Results as PDF', 'Enable administrators to download voting statistics in PDF format.', '2026-03-06 14:32:11', '2026-02-21 18:16:23', 'new');

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` enum('admin','regular') NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `first_name`, `last_name`) VALUES
(1, 'yoana_borisova', '$2y$10$yQgSRuigwxO4NyS.lZVlVOV7dESPxTzK5wqSn1FE664KtG/nGjUBK', 'admin', NULL, 'Yoana', 'Borisova'),
(4, 'AnaMilkova', '$2y$10$nTmeIWBpuLfDcD7/QjvtFuDqIIJUHIPh3z8ePgAlF0Fzs.TJsSjGW', 'regular', 'anamilkova@gmail.com', 'Ana', 'Milkova');

-- --------------------------------------------------------

--
-- Структура на таблица `users_suggestions`
--

CREATE TABLE `users_suggestions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `suggestion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `users_suggestions`
--

INSERT INTO `users_suggestions` (`id`, `user_id`, `suggestion_id`) VALUES
(9, 1, 3),
(1, 1, 5),
(8, 1, 7),
(6, 1, 10),
(7, 4, 6);

-- --------------------------------------------------------

--
-- Структура на таблица `votes`
--

CREATE TABLE `votes` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `suggestion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `suggestion_id`) VALUES
(66, 1, 8),
(64, 1, 9),
(70, 4, 8);

--
-- Indexes for dumped tables
--

--
-- Индекси за таблица `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `suggestion_id` (`suggestion_id`);

--
-- Индекси за таблица `suggestions`
--
ALTER TABLE `suggestions`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Индекси за таблица `users_suggestions`
--
ALTER TABLE `users_suggestions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`suggestion_id`),
  ADD KEY `suggestion_id` (`suggestion_id`);

--
-- Индекси за таблица `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`suggestion_id`),
  ADD KEY `suggestion_id` (`suggestion_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_suggestions`
--
ALTER TABLE `users_suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`suggestion_id`) REFERENCES `suggestions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `users_suggestions`
--
ALTER TABLE `users_suggestions`
  ADD CONSTRAINT `users_suggestions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_suggestions_ibfk_2` FOREIGN KEY (`suggestion_id`) REFERENCES `suggestions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`suggestion_id`) REFERENCES `suggestions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
