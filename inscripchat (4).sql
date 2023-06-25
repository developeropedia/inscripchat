-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2023 at 05:33 AM
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
-- Database: `inscripchat`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=unread,1=read'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `sender_id`, `receiver_id`, `message`, `timestamp`, `status`) VALUES
(1, 19, 21, 'Hello', '2023-06-10 08:00:32', 1),
(2, 21, 19, 'Hi, How are you?', '2023-06-11 08:01:00', 1),
(3, 19, 21, 'I am fine, how are you?', '2023-06-11 08:01:25', 1),
(4, 21, 19, 'I am also fine.', '2023-06-11 08:01:51', 1),
(5, 19, 22, 'Hi', '2023-06-11 08:28:59', 0),
(7, 19, 22, 'Hello', '2023-06-12 07:30:57', 0),
(9, 19, 21, 'Hi', '2023-06-12 07:46:04', 1),
(10, 19, 21, 'Hi', '2023-06-12 07:46:12', 1),
(11, 19, 22, 'Hi', '2023-06-12 07:46:20', 0),
(12, 19, 21, 'Hello', '2023-06-12 07:51:40', 1),
(13, 19, 21, '?', '2023-06-12 07:51:47', 1),
(14, 19, 21, '😎', '2023-06-12 07:51:59', 1),
(15, 21, 19, 'Hello', '2023-06-12 08:30:57', 1),
(16, 21, 19, '?', '2023-06-12 08:32:05', 1),
(17, 21, 19, 'Hello', '2023-06-12 08:33:15', 1),
(18, 22, 19, 'Hello', '2023-06-12 08:33:56', 1),
(19, 22, 19, 'hi', '2023-06-12 08:52:48', 1),
(20, 22, 19, '?', '2023-06-12 08:53:36', 1),
(21, 21, 19, '?', '2023-06-12 08:54:02', 1),
(22, 22, 19, 'Hello', '2023-06-12 09:00:24', 1),
(23, 22, 19, 'hi', '2023-06-12 09:02:50', 1),
(24, 22, 19, '?', '2023-06-12 09:05:12', 1),
(25, 22, 19, 'Hello', '2023-06-12 09:06:45', 1),
(26, 21, 19, 'Hi', '2023-06-12 09:07:06', 1),
(27, 22, 19, 'What are u doing?', '2023-06-12 09:07:28', 1),
(28, 22, 19, 'hi', '2023-06-12 09:10:01', 1),
(29, 22, 19, 'how are you?', '2023-06-12 09:12:23', 1),
(30, 22, 19, 'hi', '2023-06-12 09:14:06', 1),
(31, 22, 19, 'How are you?', '2023-06-12 09:24:46', 1),
(32, 21, 19, 'hello', '2023-06-12 09:28:38', 1),
(33, 22, 19, 'hi', '2023-06-12 09:48:07', 1),
(34, 21, 19, 'hi', '2023-06-12 09:50:50', 1),
(35, 22, 19, 'how r u?', '2023-06-12 09:51:15', 1),
(36, 21, 19, 'hello', '2023-06-12 09:52:40', 1),
(37, 21, 19, 'hi', '2023-06-12 09:53:29', 1),
(38, 21, 19, 'hellllo', '2023-06-12 09:54:05', 1),
(39, 22, 19, 'hello', '2023-06-12 10:12:14', 1),
(40, 21, 19, 'hi', '2023-06-12 11:16:41', 1),
(41, 21, 19, 'hiiii', '2023-06-12 11:22:18', 1),
(42, 21, 19, '???', '2023-06-12 11:22:30', 1),
(43, 21, 19, '???', '2023-06-12 11:25:09', 1),
(44, 21, 19, '???', '2023-06-12 11:25:23', 1),
(45, 21, 19, 'hi', '2023-06-12 11:25:42', 1),
(46, 21, 19, 'hiiii', '2023-06-12 11:26:02', 1),
(47, 21, 19, 'hiii', '2023-06-12 11:26:45', 1),
(48, 21, 19, 'helllo', '2023-06-12 11:30:42', 1),
(49, 21, 19, '???', '2023-06-12 11:31:04', 1),
(50, 21, 19, '?\"?\"?', '2023-06-12 11:31:33', 1),
(51, 21, 19, 'hi', '2023-06-12 11:32:11', 1),
(52, 21, 19, 'heelo', '2023-06-12 11:32:21', 1),
(53, 21, 19, 'Hello', '2023-06-12 11:36:50', 1),
(54, 21, 19, 'Hi', '2023-06-12 11:38:03', 1),
(55, 21, 19, '?', '2023-06-12 11:38:08', 1),
(56, 21, 19, 'hello', '2023-06-12 11:41:14', 1),
(57, 21, 19, 'hi', '2023-06-12 11:41:34', 1),
(58, 21, 19, '?', '2023-06-12 11:41:42', 1),
(59, 21, 19, 'new', '2023-06-12 11:47:13', 1),
(60, 21, 19, 'hello', '2023-06-12 11:47:54', 1),
(61, 21, 19, 'hi', '2023-06-12 11:48:50', 1),
(62, 21, 19, 'hiiii', '2023-06-12 11:49:45', 1),
(63, 21, 19, 'hello', '2023-06-12 11:50:20', 1),
(64, 21, 19, 'hi', '2023-06-12 11:52:07', 1),
(65, 21, 19, '???', '2023-06-12 11:55:37', 1),
(66, 21, 19, 'hi', '2023-06-12 11:56:53', 1),
(67, 21, 19, 'kkk', '2023-06-12 11:59:34', 1),
(68, 21, 19, '???', '2023-06-12 12:00:05', 1),
(69, 19, 21, 'yes', '2023-06-12 12:00:30', 1),
(70, 19, 21, '?', '2023-06-12 12:00:42', 1),
(71, 19, 21, 'what?', '2023-06-12 12:00:49', 1),
(72, 21, 19, '?', '2023-06-12 12:00:59', 1),
(95, 19, 21, 'Hi', '2023-06-12 23:23:25', 0),
(96, 19, 21, '?', '2023-06-12 23:23:55', 0),
(98, 22, 20, 'hi', '2023-06-17 06:08:59', 1),
(99, 20, 22, 'hello', '2023-06-17 06:09:05', 1),
(100, 22, 20, 'how r u?', '2023-06-18 16:28:45', 1),
(101, 20, 22, 'fine and u?', '2023-06-18 16:29:21', 1),
(102, 22, 20, 'fine', '2023-06-18 16:32:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `like_dislike` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment_likes`
--

INSERT INTO `comment_likes` (`comment_id`, `user_id`, `like_dislike`) VALUES
(1, 19, 1),
(2, 19, 1),
(20, 19, 1),
(21, 19, 1),
(22, 19, 1),
(16, 19, 0),
(26, 19, 0),
(4, 19, 0),
(27, 19, 0),
(28, 19, 0),
(10, 19, 1),
(10, 20, 1),
(33, 19, 1),
(37, 19, 1),
(38, 19, 0),
(40, 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment_replies`
--

CREATE TABLE `comment_replies` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment_replies`
--

INSERT INTO `comment_replies` (`id`, `comment_id`, `user_id`, `reply`, `created_at`, `updated_at`) VALUES
(1, 1, 19, 'reply 1', '2023-05-29 12:38:03', '2023-05-29 12:38:03'),
(2, 1, 19, 'reply 2', '2023-05-29 12:39:12', '2023-05-29 12:39:12'),
(3, 1, 19, 'reply 3', '2023-05-29 12:40:01', '2023-05-29 12:40:01'),
(4, 11, 19, 'reply 1', '2023-05-29 13:02:24', '2023-05-29 13:02:24'),
(5, 12, 19, 'reply 1', '2023-05-29 18:39:08', '2023-05-29 18:39:08'),
(6, 1, 19, 'reply 11', '2023-05-29 19:17:19', '2023-05-29 19:17:19'),
(7, 1, 19, 'reply 11', '2023-05-29 19:17:19', '2023-05-29 19:17:19'),
(8, 1, 19, 'reply 12', '2023-05-30 05:29:45', '2023-05-30 05:29:45'),
(9, 1, 19, 'reply 12', '2023-05-30 05:29:45', '2023-05-30 05:29:45'),
(10, 1, 19, 'reply 12', '2023-05-30 05:29:45', '2023-05-30 05:29:45'),
(11, 1, 19, 'reply 13', '2023-05-30 05:31:45', '2023-05-30 05:31:45'),
(12, 1, 19, 'reply 13', '2023-05-30 05:31:46', '2023-05-30 05:31:46'),
(13, 1, 19, 'reply 13', '2023-05-30 05:31:47', '2023-05-30 05:31:47'),
(14, 1, 19, 'reply 14', '2023-05-30 05:32:10', '2023-05-30 05:32:10'),
(15, 1, 19, 'reply 14', '2023-05-30 05:32:10', '2023-05-30 05:32:10'),
(16, 1, 19, 'reply 14', '2023-05-30 05:32:11', '2023-05-30 05:32:11'),
(17, 1, 19, 'reply 15', '2023-05-30 05:33:00', '2023-05-30 05:33:00'),
(18, 1, 19, 'reply 15', '2023-05-30 05:33:00', '2023-05-30 05:33:00'),
(19, 1, 19, 'reply 16', '2023-05-30 05:33:15', '2023-05-30 05:33:15'),
(20, 1, 19, 'reply 16', '2023-05-30 05:33:15', '2023-05-30 05:33:15'),
(21, 1, 19, 'relpy16', '2023-05-30 06:35:06', '2023-05-30 06:35:06'),
(22, 1, 19, 'relpy16', '2023-05-30 06:35:06', '2023-05-30 06:35:06'),
(23, 1, 19, 'reply17', '2023-05-30 06:35:38', '2023-05-30 06:35:38'),
(24, 1, 19, 'reply18', '2023-05-30 06:38:29', '2023-05-30 06:38:29'),
(25, 1, 19, '@awais reply18', '2023-05-30 06:38:29', '2023-05-30 07:37:14'),
(26, 1, 19, 'reply19', '2023-05-30 06:41:49', '2023-05-30 06:41:49'),
(27, 1, 19, 'reply20', '2023-05-30 06:44:54', '2023-05-30 06:44:54'),
(28, 1, 19, 'reply4', '2023-05-30 06:45:58', '2023-05-30 06:45:58'),
(29, 1, 19, '@awais new comment', '2023-05-30 16:39:21', '2023-05-30 16:39:21'),
(30, 13, 19, 'test', '2023-05-30 16:40:10', '2023-05-30 16:40:10'),
(31, 13, 19, '@awais test', '2023-05-30 16:40:21', '2023-05-30 16:40:21'),
(32, 1, 19, '@awais test', '2023-05-30 16:40:41', '2023-05-30 16:40:41'),
(33, 1, 19, 'new', '2023-05-30 16:51:18', '2023-05-30 16:51:18'),
(34, 1, 19, '@awais appen', '2023-05-30 16:51:29', '2023-05-30 16:51:29'),
(35, 1, 19, '@awais new', '2023-05-30 16:52:55', '2023-05-30 16:52:55'),
(36, 1, 19, '@awais new', '2023-05-30 16:58:59', '2023-05-30 16:58:59'),
(37, 1, 19, '@awais awais', '2023-05-30 17:02:09', '2023-05-30 17:02:09'),
(38, 1, 19, 'ali', '2023-05-30 17:02:14', '2023-05-30 17:02:14'),
(39, 1, 19, '@awais new', '2023-05-30 17:02:38', '2023-05-30 17:02:38'),
(40, 1, 19, '@awais new', '2023-05-30 17:02:46', '2023-05-30 17:02:46'),
(41, 1, 19, '@awais new', '2023-05-30 17:02:57', '2023-05-30 17:02:57'),
(42, 1, 19, '@awais new', '2023-05-30 17:03:13', '2023-05-30 17:03:13'),
(43, 1, 19, '@awais test', '2023-05-30 17:04:17', '2023-05-30 17:04:17'),
(44, 1, 19, '@awais new', '2023-05-30 17:06:08', '2023-05-30 17:06:08'),
(45, 1, 19, '@awais new 2', '2023-05-30 17:06:13', '2023-05-30 17:06:13'),
(46, 2, 19, 'new 1', '2023-05-30 17:06:34', '2023-05-30 17:06:34'),
(47, 2, 19, '@awais new', '2023-05-30 17:06:38', '2023-05-30 17:06:38'),
(48, 2, 19, '@awais append', '2023-05-30 17:07:01', '2023-05-30 17:07:01'),
(49, 16, 19, 'new', '2023-05-30 17:07:42', '2023-05-30 17:07:42'),
(50, 16, 19, 'new2 ', '2023-05-30 17:07:48', '2023-05-30 17:07:48'),
(51, 1, 19, 'new replt', '2023-06-01 10:41:10', '2023-06-01 10:41:10'),
(52, 1, 19, 'new again', '2023-06-01 10:46:55', '2023-06-01 10:46:55'),
(53, 35, 19, 'yes', '2023-06-09 11:39:07', '2023-06-09 11:39:07'),
(54, 38, 19, 'test', '2023-06-09 16:42:17', '2023-06-09 16:42:17'),
(55, 43, 19, 'new reply', '2023-06-24 15:45:24', '2023-06-24 15:45:24'),
(56, 56, 19, '😒', '2023-06-24 16:45:05', '2023-06-24 16:45:05'),
(57, 57, 19, '😑', '2023-06-24 16:45:44', '2023-06-24 16:45:44'),
(58, 57, 19, '@awais 😍', '2023-06-24 16:45:49', '2023-06-24 16:45:49'),
(59, 58, 20, 'reply', '2023-06-24 18:30:32', '2023-06-24 18:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`) VALUES
(1, 'Computer Science'),
(2, 'Chemistry'),
(3, 'Physics');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `created_at`, `updated_at`) VALUES
(78, 19, 20, '2023-06-05 13:04:55', '2023-06-05 13:04:55'),
(79, 19, 22, '2023-06-05 13:04:55', '2023-06-05 13:04:55'),
(86, 20, 22, '2023-06-17 01:08:14', '2023-06-17 01:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `owner_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 19, 'BSCS 18-22', 'This is BSCS Group', '2023-06-05 08:26:31', '2023-06-05 10:43:51'),
(2, 19, 'BSIT 18-22', 'This is BSIT Group', '2023-06-05 08:26:37', '2023-06-05 10:43:53'),
(9, 19, 'Incredibles', NULL, '2023-06-06 17:14:10', '2023-06-06 17:14:10'),
(10, 19, 'New 1', NULL, '2023-06-06 17:18:58', '2023-06-06 17:18:58'),
(11, 19, 'New 2', NULL, '2023-06-06 17:19:51', '2023-06-06 17:19:51'),
(12, 19, 'New 3', NULL, '2023-06-06 17:23:01', '2023-06-06 17:23:01'),
(13, 19, 'New 3', NULL, '2023-06-06 17:24:06', '2023-06-06 17:24:06'),
(16, 19, 'New 6', NULL, '2023-06-06 17:32:15', '2023-06-06 17:32:15'),
(17, 19, 'New 7', NULL, '2023-06-09 09:06:52', '2023-06-09 09:06:52'),
(18, 19, 'New 19', NULL, '2023-06-09 17:13:13', '2023-06-09 17:13:13'),
(19, 19, 'New 20', NULL, '2023-06-11 05:42:07', '2023-06-11 05:42:07'),
(20, 19, 'New 21', NULL, '2023-06-11 05:44:43', '2023-06-11 05:44:43'),
(21, 19, 'New 22', NULL, '2023-06-11 05:45:39', '2023-06-11 05:45:39'),
(22, 19, 'New 23', NULL, '2023-06-11 05:46:44', '2023-06-11 05:46:44'),
(23, 19, 'New 24', NULL, '2023-06-11 05:48:03', '2023-06-11 05:48:03'),
(24, 19, 'New 25', NULL, '2023-06-11 05:48:29', '2023-06-11 05:48:29'),
(25, 19, 'Group 1', NULL, '2023-06-12 16:16:13', '2023-06-12 16:16:13'),
(26, 19, 'Group 2', NULL, '2023-06-12 16:17:51', '2023-06-12 16:17:51'),
(27, 19, 'Group 3', NULL, '2023-06-12 16:21:23', '2023-06-12 16:21:23'),
(28, 20, 'Ali\'s group', NULL, '2023-06-24 18:47:50', '2023-06-24 18:47:50');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`group_id`, `user_id`) VALUES
(9, 22),
(10, 22),
(11, 20),
(11, 22),
(12, 22),
(13, 22),
(16, 20),
(16, 22),
(17, 20),
(17, 22),
(18, 20),
(18, 22),
(19, 20),
(19, 22),
(20, 20),
(20, 22),
(21, 20),
(21, 22),
(22, 20),
(22, 22),
(24, 22),
(24, 20),
(25, 20),
(26, 22),
(28, 22);

-- --------------------------------------------------------

--
-- Table structure for table `online_users`
--

CREATE TABLE `online_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `online_users`
--

INSERT INTO `online_users` (`id`, `user_id`, `last_activity`) VALUES
(1187, 19, '2023-06-25 03:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `title` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `group_id`, `title`, `content`, `type`, `tags`, `created_at`, `updated_at`) VALUES
(1, 19, 0, 'Parabolas in Symmetry', '1.jfif', 'image', 'UMW', '2023-05-19 17:17:16', '2023-05-21 10:12:07'),
(2, 19, 0, 'Parabolas in Symmetry 2', 'rete_metro.pdf', 'pdf', 'Computer Science', '2023-05-19 17:48:16', '2023-05-26 18:41:46'),
(3, 19, 0, 'Parabolas in Symmetry 3', '2.jfif', 'image', 'UMW', '2023-05-19 17:50:16', '2023-05-21 18:21:48'),
(4, 19, 0, 'Parabolas in Symmetry 4', '3.jfif', 'image', 'UMW', '2023-05-19 17:50:16', '2023-05-27 07:34:49'),
(5, 19, 1, 'BSCS is best field', 'group2.jpeg', 'image', 'Computer Science,UMW,Undergraduate', '2023-06-05 08:51:48', '2023-06-05 08:54:33'),
(6, 19, 2, 'BSIT is 2nd best field', '7.jfif', 'image', 'UMW', '2023-06-05 08:54:07', '2023-06-05 08:57:55'),
(7, 20, 1, 'Take admission in BSCS', 'rete_metro.pdf', 'pdf', 'Computer Science,UMW,Undergraduate', '2023-06-09 11:04:48', '2023-06-09 11:04:33'),
(8, 19, 1, 'Test 1', '6483152be872d3.21553200.pdf', 'pdf', 'Undergraduate,UMW,Computer Science', '2023-06-09 17:03:55', '2023-06-09 17:03:55'),
(9, 19, 1, 'Test 2', '6483166dd10651.17580920.jpg', 'image', 'Undergraduate,UMW,Computer Science', '2023-06-09 17:09:17', '2023-06-09 17:09:17'),
(12, 20, 9, 'Test 1', '6483eadc0a5675.71920321.pdf', 'pdf', 'Undergraduate,UMW,Computer Science', '2023-06-10 08:15:40', '2023-06-10 08:15:40'),
(14, 19, 0, 'Test pdf', '64840f9b5ba9f-US6ERL.pdf', 'pdf', 'umw', '2023-06-10 10:52:29', '2023-06-12 16:07:42'),
(15, 19, 0, 'New Post 3', '64873e0c626a4-code.png', 'image', 'umw,uos', '2023-06-12 20:47:26', '2023-06-12 20:47:26'),
(16, 19, 0, 'Admin Post', '648c7178dc312-LogIn.png', 'image', 'umw', '2023-06-16 19:28:11', '2023-06-16 19:28:11'),
(17, 19, 0, 'Admin Post 2', '648c71ad28035-Get_Started_With_Smallpdf.pdf', 'pdf', 'umw', '2023-06-16 19:29:03', '2023-06-16 19:29:03'),
(18, 19, 0, 'Admin Post 3', '648c71d00e66c-chat.png', 'image', 'umw', '2023-06-16 19:29:37', '2023-06-16 19:29:37'),
(19, 19, 0, 'Admin Post 5', '648cf674cbf09-rete_metro.pdf', 'pdf', 'umw', '2023-06-17 04:55:35', '2023-06-17 04:55:35'),
(20, 19, 0, 'Admin Post 6', '648cf6d3624b4-rete_metro.pdf', 'pdf', 'umw', '2023-06-17 04:57:08', '2023-06-17 04:57:08'),
(21, 19, 0, 'Admin Post 7', '648cf713e5d2a-rete_metro.pdf', 'pdf', 'umw', '2023-06-17 04:58:13', '2023-06-17 04:58:13'),
(22, 19, 0, 'Post admin', '648cf75ade13a-9.jfif', 'image', 'umw', '2023-06-17 04:59:24', '2023-06-17 04:59:24'),
(23, 20, 2, NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'text', 'umw', '2023-06-23 16:06:51', '2023-06-23 16:14:37'),
(24, 19, 2, NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. 😃', 'text', 'Undergraduate,UMW,Chemistry', '2023-06-23 16:43:51', '2023-06-23 16:43:51'),
(25, 19, 2, 'New post', '649585d44be745.93324287.png', 'image', 'Undergraduate,UMW,Chemistry', '2023-06-23 16:45:24', '2023-06-23 16:45:24'),
(26, 19, 2, NULL, 'New post', 'text', 'Undergraduate,UMW,Chemistry', '2023-06-23 16:56:56', '2023-06-23 16:56:56'),
(27, 19, 2, NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'text', 'Undergraduate,UMW,Chemistry', '2023-06-23 16:57:40', '2023-06-23 16:57:40'),
(28, 20, 27, NULL, 'New post', 'text', 'Undergraduate,UMW,Computer Science', '2023-06-24 18:06:28', '2023-06-24 18:06:28'),
(29, 20, 27, NULL, 'new', 'text', 'Undergraduate,UMW,Computer Science', '2023-06-24 18:16:16', '2023-06-24 18:16:16'),
(32, 19, 10, NULL, 'new post by admin', 'text', 'Undergraduate,UMW,Chemistry', '2023-06-24 18:46:50', '2023-06-24 18:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `post_id`, `user_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, 19, 'This is test comment', '2023-05-28 18:56:34', '2023-05-28 18:56:34'),
(2, 2, 19, 'This is test comment 2', '2023-05-28 18:58:00', '2023-05-28 18:58:00'),
(3, 2, 19, 'This is test comment 3', '2023-05-28 19:01:50', '2023-05-28 19:01:50'),
(4, 2, 19, 'This is test comment 4', '2023-05-29 12:34:58', '2023-05-29 12:34:58'),
(5, 2, 19, 'This is test comment 5', '2023-05-29 12:35:59', '2023-05-29 12:35:59'),
(6, 2, 19, 'comment 6', '2023-05-29 12:46:06', '2023-05-29 12:46:06'),
(7, 2, 19, 'comment 7', '2023-05-29 12:56:27', '2023-05-29 12:56:27'),
(8, 2, 19, 'comment 8', '2023-05-29 12:58:14', '2023-05-29 12:58:14'),
(9, 2, 19, 'comment 9', '2023-05-29 13:00:08', '2023-05-29 13:00:08'),
(10, 2, 19, 'comment 10', '2023-05-29 13:00:35', '2023-05-29 13:00:35'),
(11, 2, 19, 'comment 11', '2023-05-29 13:02:18', '2023-05-29 13:02:18'),
(12, 2, 19, 'comment 12', '2023-05-29 18:39:01', '2023-05-29 18:39:01'),
(13, 2, 19, 'new comment', '2023-05-30 16:40:02', '2023-05-30 16:40:02'),
(14, 2, 19, 'new', '2023-05-30 16:51:02', '2023-05-30 16:51:02'),
(15, 2, 19, 'new', '2023-05-30 16:54:35', '2023-05-30 16:54:35'),
(16, 2, 19, 'nwe', '2023-05-30 16:55:14', '2023-05-30 16:55:14'),
(17, 2, 19, 'New comment', '2023-06-01 08:29:54', '2023-06-01 08:29:54'),
(18, 2, 19, 'Test comment', '2023-06-01 08:32:02', '2023-06-01 08:32:02'),
(19, 2, 19, 'new', '2023-06-01 08:32:48', '2023-06-01 08:32:48'),
(20, 2, 19, 'new', '2023-06-01 08:33:49', '2023-06-01 08:33:49'),
(21, 2, 19, 'new', '2023-06-01 09:49:45', '2023-06-01 09:49:45'),
(22, 2, 19, 'my new comment', '2023-06-01 09:50:17', '2023-06-01 09:50:17'),
(23, 2, 19, 'new new', '2023-06-01 09:51:29', '2023-06-01 09:51:29'),
(24, 2, 19, 'comment 20', '2023-06-01 09:53:59', '2023-06-01 09:53:59'),
(25, 2, 19, 'comment 21', '2023-06-01 09:54:31', '2023-06-01 09:54:31'),
(26, 2, 19, 'comment 22', '2023-06-01 09:56:54', '2023-06-01 09:56:54'),
(27, 2, 19, 'comment 23', '2023-06-01 10:17:28', '2023-06-01 10:17:28'),
(28, 2, 19, 'comment 24', '2023-06-01 10:18:37', '2023-06-01 10:18:37'),
(33, 5, 20, 'Yes', '2023-06-05 10:30:18', '2023-06-05 10:30:18'),
(35, 5, 19, 'Right', '2023-06-09 10:48:18', '2023-06-09 10:48:18'),
(36, 5, 19, 'ofcourse', '2023-06-09 11:38:42', '2023-06-09 11:38:42'),
(37, 7, 19, 'ok', '2023-06-09 11:38:59', '2023-06-09 11:38:59'),
(38, 5, 19, 'Yes', '2023-06-09 16:42:05', '2023-06-09 16:42:05'),
(39, 6, 19, 'New', '2023-06-10 08:31:55', '2023-06-10 08:31:55'),
(40, 14, 19, 'Hello', '2023-06-12 16:51:45', '2023-06-12 16:51:45'),
(42, 23, 19, 'Text post', '2023-06-23 16:18:52', '2023-06-23 16:18:52'),
(43, 26, 19, 'New comment', '2023-06-24 15:29:33', '2023-06-24 15:29:33'),
(44, 27, 19, 'hello', '2023-06-24 16:13:28', '2023-06-24 16:13:28'),
(45, 27, 19, 'hi', '2023-06-24 16:18:33', '2023-06-24 16:18:33'),
(46, 27, 19, 'Hellooo', '2023-06-24 16:23:06', '2023-06-24 16:23:06'),
(47, 24, 19, 'new', '2023-06-24 16:25:20', '2023-06-24 16:25:20'),
(48, 24, 19, 'hello', '2023-06-24 16:27:44', '2023-06-24 16:27:44'),
(49, 24, 19, 'comment 1', '2023-06-24 16:31:13', '2023-06-24 16:31:13'),
(50, 24, 19, 'comment 2', '2023-06-24 16:32:28', '2023-06-24 16:32:28'),
(51, 24, 19, 'comment3', '2023-06-24 16:36:01', '2023-06-24 16:36:01'),
(52, 24, 19, 'comment4', '2023-06-24 16:36:29', '2023-06-24 16:36:29'),
(53, 24, 19, 'commtn5', '2023-06-24 16:38:07', '2023-06-24 16:38:07'),
(54, 24, 19, 'comment8', '2023-06-24 16:42:48', '2023-06-24 16:42:48'),
(55, 24, 19, 'comment9', '2023-06-24 16:44:13', '2023-06-24 16:44:13'),
(56, 24, 19, 'comment10', '2023-06-24 16:44:58', '2023-06-24 16:44:58'),
(57, 24, 19, 'comment11', '2023-06-24 16:45:39', '2023-06-24 16:45:39'),
(58, 28, 20, 'new', '2023-06-24 18:26:18', '2023-06-24 18:26:18');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `like_dislike` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`post_id`, `user_id`, `like_dislike`) VALUES
(2, 19, 1),
(4, 19, 0),
(2, 20, 1),
(5, 19, 1),
(25, 19, 1),
(24, 19, 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_views`
--

CREATE TABLE `post_views` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_views`
--

INSERT INTO `post_views` (`post_id`, `user_id`) VALUES
(4, 19),
(1, 19),
(2, 19),
(3, 19),
(5, 19),
(6, 19),
(7, 19),
(14, 19),
(8, 19),
(9, 19),
(12, 19),
(15, 19),
(15, 20);

-- --------------------------------------------------------

--
-- Table structure for table `reply_likes`
--

CREATE TABLE `reply_likes` (
  `reply_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `like_dislike` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reply_likes`
--

INSERT INTO `reply_likes` (`reply_id`, `user_id`, `like_dislike`) VALUES
(1, 19, 0),
(52, 19, 0),
(51, 19, 1),
(6, 19, 1),
(6, 20, 1),
(53, 19, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` text DEFAULT NULL,
  `course` int(11) NOT NULL,
  `qualification` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=undergraduate\r\n1=postgraduate',
  `institution` text DEFAULT NULL,
  `is_admin` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `is_confirmed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `img`, `course`, `qualification`, `institution`, `is_admin`, `created_at`, `status`, `confirmation_token`, `is_confirmed`) VALUES
(19, 'Muhammad Awais', 'awais', 'awais@gmail.com', '$2y$10$1t0GxRWok9tXc0v2.1rsT.sL4wlbdNk5qwyrl8AJuSdEDGuaVZAci', '64873d1932e3a-Product 17.jpeg', 2, 0, 'UMW', 1, '2023-05-19 15:42:58', 0, NULL, 0),
(20, 'Muhammad Ali', 'ali', 'ali@gmail.com', '$2y$10$.tu0DBAQuoN/W/dN1dhoOujU2F5GgYPMjaGOzaZhgSoMrbbw./K26', 'image 1.png', 1, 0, 'UMW', 0, '2023-06-01 15:42:58', 1, NULL, 0),
(21, 'Muhammad Amir', 'amir', 'amir@gmail.com', '$2y$10$DsyYnDC4Gf.mNa8a0dK9FOK0GXGHt0G38ycBdu0eRMYDt8QjKAeeS', 'male.webp', 2, 1, 'UMW', 0, '2023-06-02 15:42:58', 1, NULL, 0),
(22, 'Muhammad Shahid', 'shahid', 'shahid@gmail.com', '$2y$10$ZbS.P9VcDRqRIoqJmnjc2u7wRUv4D.rx2T5QXjuJEIqavuE00jk56', 'male2.jpg', 3, 0, 'UMW', 0, '2023-06-01 12:42:58', 1, NULL, 0),
(28, 'Muhammad Awais', 'awais1', 'hyipsgroup2025@gmail.com', '$2y$10$rxy/qMQLtU1/RWKI5AqO/u1iOIEjUjVEAbmMD.4sWzfwfuKbE6T72', '64951f700e6ff-277556430_5000877343335569_5888970134145952345_n.jpg', 1, 0, 'UMW', 0, '2023-06-23 09:28:32', 0, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD KEY `comment_like_fk` (`comment_id`),
  ADD KEY `user_comment_like_fk` (`user_id`);

--
-- Indexes for table `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_replies_comment_fk` (`comment_id`),
  ADD KEY `comment_replies_user_fk` (`user_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friends_ibfk_1` (`user_id`),
  ADD KEY `friends_ibfk_2` (`friend_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_owner_fk` (`owner_id`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD KEY `group_group_members_fk` (`group_id`),
  ADD KEY `user_group_members_fk` (`user_id`);

--
-- Indexes for table `online_users`
--
ALTER TABLE `online_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_fk` (`author_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_comments_post_fk` (`post_id`),
  ADD KEY `post_comments_user_fk` (`user_id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD KEY `post_like_fk` (`post_id`),
  ADD KEY `user_post_like_fk` (`user_id`);

--
-- Indexes for table `post_views`
--
ALTER TABLE `post_views`
  ADD KEY `post_views_user_fk` (`user_id`),
  ADD KEY `post_views_post_fk` (`post_id`);

--
-- Indexes for table `reply_likes`
--
ALTER TABLE `reply_likes`
  ADD KEY `reply_like_fk` (`reply_id`),
  ADD KEY `user_reply_like_fk` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_user_fk` (`course`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `comment_replies`
--
ALTER TABLE `comment_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `online_users`
--
ALTER TABLE `online_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1239;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `comment_like_fk` FOREIGN KEY (`comment_id`) REFERENCES `post_comments` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_comment_like_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD CONSTRAINT `comment_replies_comment_fk` FOREIGN KEY (`comment_id`) REFERENCES `post_comments` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `comment_replies_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `group_owner_fk` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_group_members_fk` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_group_members_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `user_post_fk` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_post_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_comments_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_like_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_post_like_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post_views`
--
ALTER TABLE `post_views`
  ADD CONSTRAINT `post_views_post_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_views_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `reply_likes`
--
ALTER TABLE `reply_likes`
  ADD CONSTRAINT `reply_like_fk` FOREIGN KEY (`reply_id`) REFERENCES `comment_replies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_reply_like_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `course_user_fk` FOREIGN KEY (`course`) REFERENCES `courses` (`id`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
