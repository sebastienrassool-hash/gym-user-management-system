-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2026 at 02:37 PM
-- Server version: 10.11.16-MariaDB
-- PHP Version: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Sebastien Rassool', 'sebastien.rassool@gmail.com', 'excellent', 'very good gym', '2026-11-10 08:35:48'),
(2, 'moummou', 'moumouadrian@gmail.com', 'nice', 'sweating everyday', '2026-11-10 08:50:39'),
(3, 'betram', 'betramalbest@gmail.com', 'wonderful', 'im gaining progress', '2026-11-10 08:55:52'),
(4, 'Elad', 'Eladmarcel@gmail.com', 'clean', 'very good gym', '2026-11-10 08:58:35'),
(5, 'nathan', 'nathangill@gmail.com', 'nice', 'it is very hot, but equipments are clean', '2026-11-10 12:40:50');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_name` enum('Basic','Standard','Premium') NOT NULL DEFAULT 'Basic',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Active','Expired','Cancelled') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `user_id`, `plan_name`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(2, 3, 'Premium', '2026-11-10', '2026-12-10', 'Active', '2026-11-10 04:38:43'),
(5, 6, 'Standard', '2026-11-10', '2026-12-10', 'Active', '2026-11-10 07:33:12'),
(6, 7, 'Standard', '2026-11-10', '2026-12-10', 'Active', '2026-11-10 12:41:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','member') NOT NULL DEFAULT 'member',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Gym Administrator', 'admin', 'admin@gym.local', '$2y$10$Btjp8Ow5HdxNPnRHSW2SqOXZyzb9gCwN6q5HnSzgfFn/gkm7I8tFi', 'admin', '2026-11-09 16:52:11'),
(3, 'Sebastien Rassool', 'Sebas', 'sebastien.rassool@gmail.com', '$2y$10$RNeX6gbUGakn0w2ed.TDvetYV0JVN1j131mK.Lc1cE99aSrc29TW.', 'member', '2026-11-10 04:38:43'),
(6, 'Stan Laporte', 'Stan', 'stanlaporte@gmail.com', '$2y$10$7S8hen/t/p5AcQZPpxO1qebaCwQxtdhLpZAbsIG1quDK5Ky8ctdtG', 'member', '2026-11-10 07:33:12'),
(7, 'Nathan Gill', 'Nathan', 'nathangill@gmail.com', '$2y$10$uF2RrkHPgxcOt/.qJk9yleRbWjGdWv9zf/p6KLQBKTIBwJQVFwY12', 'member', '2026-11-10 12:41:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_membership_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `memberships`
--
ALTER TABLE `memberships`
  ADD CONSTRAINT `fk_membership_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
