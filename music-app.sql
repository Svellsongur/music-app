-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 03, 2024 at 11:52 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'The Book', '2024-01-22 09:18:17', '2024-01-22 09:18:17'),
(7, 'Alone', '2024-02-05 18:53:25', '2024-02-05 18:53:25'),
(8, 'Believer (Single)', '2024-02-06 10:16:14', '2024-02-06 10:16:14'),
(10, 'Dynasty (single)', '2024-02-18 18:56:10', '2024-02-18 18:56:10'),
(13, 'Parallax', '2024-02-23 09:27:29', '2024-02-23 09:27:29'),
(16, 'A Rush Of Blood To The Head', '2024-02-27 14:48:36', '2024-02-27 14:48:36'),
(17, 'Lost Game', '2024-02-27 16:34:25', '2024-02-27 16:34:25'),
(18, 'All Falls Down', '2024-02-29 09:19:18', '2024-02-29 09:19:18');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Yoasobi', '2024-01-22 09:18:17', '2024-01-22 09:18:17'),
(9, 'Alan Walker', '2024-02-05 18:53:25', '2024-02-05 18:53:25'),
(11, 'Imagine Dragons', '2024-02-06 10:16:14', '2024-02-06 10:16:14'),
(12, 'beowulf', '2024-02-06 10:16:14', '2024-02-06 10:16:14'),
(15, 'Đạt G/Ngọc Halleyy/Masew(remix)', '2024-02-18 18:56:10', '2024-02-18 18:56:10'),
(17, 'MIIA', '2024-02-18 18:56:10', '2024-02-18 18:56:10'),
(19, 'Survive Said The Prophet', '2024-02-19 03:16:16', '2024-02-19 03:16:16'),
(20, 'Charlie Puth', '2024-02-19 03:17:39', '2024-02-19 03:17:39'),
(22, 'Gotye', '2024-02-23 08:50:41', '2024-02-23 08:50:41'),
(23, 'Đức Phúc', '2024-02-23 08:52:47', '2024-02-23 08:52:47'),
(27, 'TheFatRat/Anjulie', '2024-02-23 09:27:29', '2024-02-23 09:27:29'),
(32, 'BEAUZ/JVNA', '2024-02-23 14:26:32', '2024-02-23 14:26:32'),
(34, 'Hà Duy Thái', '2024-02-27 14:47:16', '2024-02-27 14:47:16'),
(35, 'Coldplay', '2024-02-27 14:48:36', '2024-02-27 14:48:36'),
(36, 'Nulbarich', '2024-02-27 16:34:25', '2024-02-27 16:34:25'),
(37, 'TheFatRat', '2024-02-27 16:35:54', '2024-02-27 16:35:54'),
(38, 'Alan Walker,Noah Cyrus,Digital Farm Animals,Juliander', '2024-02-29 09:19:18', '2024-02-29 09:19:18'),
(39, 'Maroon 5', '2024-02-29 09:25:48', '2024-02-29 09:25:48'),
(40, 'Pháo/Kaiz (remix)', '2024-03-01 04:33:12', '2024-03-01 04:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `artists_has_songs`
--

CREATE TABLE `artists_has_songs` (
  `id` bigint UNSIGNED NOT NULL,
  `artist_id` int NOT NULL,
  `song_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artists_has_songs`
--

INSERT INTO `artists_has_songs` (`id`, `artist_id`, `song_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-01-22 09:18:17', '2024-01-22 09:18:17'),
(13, 9, 27, '2024-02-05 18:53:25', '2024-02-05 18:53:25'),
(15, 11, 29, '2024-02-06 10:16:14', '2024-02-06 10:16:14'),
(16, 12, 30, '2024-02-06 10:16:14', '2024-02-06 10:16:14'),
(20, 15, 33, '2024-02-18 18:56:10', '2024-02-18 18:56:10'),
(23, 17, 36, '2024-02-18 18:56:10', '2024-02-18 18:56:10'),
(26, 19, 38, '2024-02-19 03:16:16', '2024-02-19 03:16:16'),
(27, 20, 39, '2024-02-19 03:17:39', '2024-02-19 03:17:39'),
(33, 22, 45, '2024-02-23 08:50:41', '2024-02-23 08:50:41'),
(34, 23, 46, '2024-02-23 08:52:47', '2024-02-23 08:52:47'),
(38, 27, 50, '2024-02-23 09:27:29', '2024-02-23 09:27:29'),
(44, 32, 56, '2024-02-23 14:26:32', '2024-02-23 14:26:32'),
(47, 34, 59, '2024-02-27 14:47:16', '2024-02-27 14:47:16'),
(48, 35, 60, '2024-02-27 14:48:36', '2024-02-27 14:48:36'),
(49, 36, 61, '2024-02-27 16:34:25', '2024-02-27 16:34:25'),
(50, 37, 62, '2024-02-27 16:35:54', '2024-02-27 16:35:54'),
(51, 37, 63, '2024-02-27 16:35:54', '2024-02-27 16:35:54'),
(52, 38, 64, '2024-02-29 09:19:18', '2024-02-29 09:19:18'),
(53, 39, 65, '2024-02-29 09:25:48', '2024-02-29 09:25:48'),
(54, 40, 66, '2024-03-01 04:33:12', '2024-03-01 04:33:12'),
(55, 38, 67, '2024-03-01 04:50:16', '2024-03-01 04:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_12_25_024824_create_songs_table', 1),
(6, '2023_12_25_024838_create_albums_table', 1),
(7, '2023_12_25_024848_create_artists_table', 1),
(8, '2023_12_25_024858_create_artists_has_songs_table', 1),
(9, '2023_12_25_024915_create_playlists_table', 1),
(10, '2023_12_25_024926_create_playlists_has_songs_table', 1),
(11, '2024_02_23_155019_create_notifications_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('033085ed-f8ac-44a4-be22-0ae9c2fff935', 'App\\Notifications\\ActivityLog', 'App\\Models\\User', 1, '{\"message\":\"You deleted a playlist\",\"data\":[\"Nguy\\u1ec5n Ti\\u1ebfn \\u0110\\u1ea1t\"]}', '2024-03-01 08:30:55', '2024-03-01 07:33:54', '2024-03-01 08:30:55'),
('22de7a7d-17b8-4762-b266-882a08e0b5e3', 'App\\Notifications\\ActivityLog', 'App\\Models\\User', 1, '{\"message\":\"You uploaded 1 files.\",\"data\":[\"Ph\\u00e1o - 2 Ph\\u00fat H\\u01a1n (KAIZ Remix).mp3\"]}', '2024-03-01 07:22:26', '2024-03-01 04:33:15', '2024-03-01 07:22:26'),
('7cda2b7f-fb08-4377-b6a9-c7b025eb7412', 'App\\Notifications\\ActivityLog', 'App\\Models\\User', 1, '{\"message\":\"You uploaded 1 files.\",\"data\":[\"Animals - Maroon 5.mp3\"]}', '2024-03-01 07:22:26', '2024-02-29 09:25:49', '2024-03-01 07:22:26'),
('96b7dbef-e8be-4908-a473-dc8dc3431d36', 'App\\Notifications\\ActivityLog', 'App\\Models\\User', 1, '{\"message\":\"You uploaded 1 files.\",\"data\":[\"AllFallsDown-AlanWalkerNoahCyrusDigitalFarmAnimalsJuliander-5817723.mp3\"]}', '2024-03-01 07:22:26', '2024-02-29 09:19:20', '2024-03-01 07:22:26'),
('dcd9b251-c7c2-4f33-ad5b-ab24f16cb1ea', 'App\\Notifications\\ActivityLog', 'App\\Models\\User', 1, '{\"message\":\"You uploaded 1 files.\",\"data\":[\"AllFallsDown-AlanWalkerNoahCyrusDigitalFarmAnimalsJuliander-5817723.mp3\"]}', '2024-03-01 07:22:26', '2024-03-01 04:50:19', '2024-03-01 07:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `name`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Favorite', 1, '2024-02-20 10:38:06', '2024-02-20 10:38:06'),
(6, 'Favorite', 10, '2024-02-20 10:38:06', '2024-02-20 10:38:06'),
(8, 'abc', 1, '2024-02-20 10:56:35', '2024-02-20 10:56:35'),
(13, 'Nguyễn Tiến Đạt', 1, '2024-02-21 08:12:00', '2024-02-21 08:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `playlists_has_songs`
--

CREATE TABLE `playlists_has_songs` (
  `id` bigint UNSIGNED NOT NULL,
  `playlist_id` int NOT NULL,
  `song_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playlists_has_songs`
--

INSERT INTO `playlists_has_songs` (`id`, `playlist_id`, `song_id`, `created_at`, `updated_at`) VALUES
(4, 13, 67, '2024-03-01 09:52:04', '2024-03-01 09:52:04'),
(6, 8, 66, '2024-03-01 10:04:25', '2024-03-01 10:04:25'),
(8, 1, 66, '2024-03-01 19:13:41', '2024-03-01 19:13:41'),
(10, 13, 65, '2024-03-01 19:19:31', '2024-03-01 19:19:31'),
(11, 13, 50, '2024-03-01 19:35:37', '2024-03-01 19:35:37'),
(12, 13, 63, '2024-03-01 19:35:37', '2024-03-01 19:35:37'),
(13, 13, 30, '2024-03-01 19:35:37', '2024-03-01 19:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `album_id` int DEFAULT NULL,
  `song_path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `length` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `artwork_path` text COLLATE utf8mb4_unicode_ci,
  `lyrics` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `name`, `album_id`, `song_path`, `length`, `artwork_path`, `lyrics`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Yoru ni Kakeru', 1, 'storage/user/1/songs/YOASOBI「夜に駆ける」 Official Music Video.mp3', '4:22', NULL, NULL, 1, NULL, '2024-01-22 09:18:17', '2024-02-17 16:32:18'),
(27, 'Alone', 7, 'storage/user/1/songs/Alone - Alan Walker.mp3', '2:37', NULL, NULL, 1, NULL, '2024-02-05 18:53:25', '2024-02-23 09:20:04'),
(29, 'Believer', 8, 'storage/user/1/songs/Believer - Imagine Dragons.mp3', '3:24', NULL, NULL, 1, NULL, '2024-02-06 10:16:14', '2024-02-27 10:08:52'),
(30, 'savior', NULL, 'storage/user/1/songs/beowulf - savior.mp3', '2:04', NULL, NULL, 1, NULL, '2024-02-06 10:16:14', '2024-02-06 10:16:14'),
(33, 'Điều khác lạ', NULL, 'storage/user/1/songs/ĐIỀU KHÁC LẠ - ĐẠTG - NGỌC HALEYY (Masew Mix).mp3', '4:41', NULL, NULL, 1, NULL, '2024-02-18 18:56:10', '2024-02-27 12:16:47'),
(36, 'Dynasty', 10, 'storage/user/1/songs/Dynasty - MIIA [128kbps_MP3].mp3', '3:47', NULL, NULL, 1, NULL, '2024-02-18 18:56:10', '2024-02-24 11:38:25'),
(38, 'found & lost', NULL, 'storage/user/1/songs/found & lost - Survive Said The Prophet.mp3', '3:08', NULL, NULL, 1, NULL, '2024-02-19 03:16:16', '2024-02-23 09:40:28'),
(39, 'Attention - Charlie Puth', NULL, 'storage/user/1/songs/Attention-Charlie-Puth-Charlie-Puth.mp3', '3:27', NULL, NULL, 1, NULL, '2024-02-19 03:17:39', '2024-02-23 09:20:04'),
(45, 'Somebody That I Used To Know', NULL, 'storage/user/1/songs/Gotye - Somebody That I UsedTo Know.mp3', '4:04', NULL, NULL, 1, NULL, '2024-02-23 08:50:41', '2024-02-27 10:08:52'),
(46, 'Cũng Đành Thôi', NULL, 'storage/user/1/songs/Cũng đành thôi - Đức Phúc.mp3', '4:32', NULL, NULL, 1, NULL, '2024-02-23 08:52:47', '2024-02-23 08:52:47'),
(50, 'Let Love Win', 13, 'storage/user/1/songs/TheFatRat,Anjulie-Let Love Win.mp3', '3:19', NULL, NULL, 1, NULL, '2024-02-23 09:27:29', '2024-02-23 09:27:29'),
(56, 'Crazy', NULL, 'storage/user/1/songs/BEAUZ & JVNA - Crazy.mp3', '3:08', NULL, NULL, 1, NULL, '2024-02-23 14:26:32', '2024-02-27 08:26:23'),
(59, 'Quên Người Đã Quá Yêu', NULL, 'storage/user/10/songs/Quên Người Đã Quá Yêu.mp3', '4:53', NULL, NULL, 10, NULL, '2024-02-27 14:47:16', '2024-02-27 14:47:16'),
(60, 'The Scientist', 16, 'storage/user/10/songs/The Scientist - Coldplay.mp3', '5:09', 'http://music-app.test/storage/user/10/songs/artworks/65ddf6449d4441709045316BCCQwQ-artwork.jpeg', NULL, 10, NULL, '2024-02-27 14:48:36', '2024-02-27 14:48:36'),
(61, 'Lost Game', 17, 'storage/user/1/songs/Lost Game - Nulbarich [MP3 128kbps].mp3', '4:05', 'http://music-app.test/storage/user/1/songs/artworks/65de0f11dd36f1709051665tPoLss-artwork.jpeg', NULL, 1, NULL, '2024-02-27 16:34:25', '2024-02-27 16:34:25'),
(62, 'Windfall', NULL, 'storage/user/1/songs/TheFatRat - Windfall.mp3', '3:48', 'http://music-app.test/storage/user/1/songs/artworks/65de0f6aa91f01709051754vYY41I-artwork.jpeg', NULL, 1, NULL, '2024-02-27 16:35:54', '2024-02-27 16:35:54'),
(63, 'Xenogenesis', NULL, 'storage/user/1/songs/TheFatRat - Xenogenesis .mp3', '3:53', 'http://music-app.test/storage/user/1/songs/artworks/65de0f6ab93c41709051754XX7AsD-artwork.jpeg', NULL, 1, NULL, '2024-02-27 16:35:54', '2024-02-27 16:35:54'),
(65, 'Animals', NULL, 'storage/user/1/songs/Animals - Maroon 5.mp3', '3:56', NULL, NULL, 1, NULL, '2024-02-29 09:25:48', '2024-02-29 09:25:48'),
(66, '2 phút hơn', NULL, 'storage/user/1/songs/Pháo - 2 Phút Hơn (KAIZ Remix).mp3', '3:04', NULL, NULL, 1, NULL, '2024-03-01 04:33:12', '2024-03-01 04:33:12'),
(67, 'All Falls Down', 18, 'storage/user/1/songs/AllFallsDown-AlanWalkerNoahCyrusDigitalFarmAnimalsJuliander-5817723.mp3', '3:17', 'http://music-app.test/storage/user/1/songs/artworks/65e15e883cf9d1709268616e8kdBW-artwork.jpeg', NULL, 1, NULL, '2024-03-01 04:50:16', '2024-03-01 04:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `background` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `avatar`, `background`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Tiến Đạt', 'secretangent2112@gmail.com', NULL, '$2y$12$OLODMeKcs7ziK7Gkmc4Gru3XzqS8005DJ1dzoIqKmZCUiMGPliIBa', 'http://music-app.test/storage/user/1/library/380278955_4296408460583498_1768312424684244709_n.jpg', NULL, NULL, '2024-01-22 09:18:17', '2024-02-28 11:24:09'),
(10, 'Nguyễn Tiến Đạt', 'test@example.com', NULL, '$2y$12$Yrt80LSNS.880Cmsae4sKO6gdst8Qv72tqaUz3rgA.7oKuurxcRQK', NULL, NULL, NULL, '2024-02-20 10:38:06', '2024-02-20 10:38:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists_has_songs`
--
ALTER TABLE `artists_has_songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists_has_songs`
--
ALTER TABLE `playlists_has_songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `artists_has_songs`
--
ALTER TABLE `artists_has_songs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `playlists_has_songs`
--
ALTER TABLE `playlists_has_songs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
