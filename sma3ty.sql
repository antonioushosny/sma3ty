-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2020 at 02:19 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sma3ty`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `day` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `day`, `from`, `to`, `status`, `doctor_id`, `created_at`, `updated_at`) VALUES
(1, 'Sat', '7:00', '7:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(2, 'Sat', '7:30', '8:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(3, 'Sat', '8:00', '8:15', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(4, 'Sat', '8:15', '8:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(5, 'Sat', '8:30', '8:45', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(6, 'Sat', '8:45', '9:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(7, 'Sun', '7:00', '7:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(8, 'Sun', '7:30', '8:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(9, 'Sun', '8:00', '8:15', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(10, 'Sun', '8:15', '8:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(11, 'Sun', '8:30', '8:45', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(12, 'Sun', '8:45', '9:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(13, 'Mon', '7:00', '7:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(14, 'Mon', '7:30', '8:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(15, 'Mon', '8:00', '8:15', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(16, 'Mon', '8:15', '8:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(17, 'Mon', '8:30', '8:45', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(18, 'Mon', '8:45', '9:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(19, 'Tue', '7:00', '7:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(20, 'Tue', '7:30', '8:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(21, 'Tue', '8:00', '8:15', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(22, 'Tue', '8:15', '8:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(23, 'Tue', '8:30', '8:45', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(24, 'Tue', '8:45', '9:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(25, 'Wed', '7:00', '7:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(26, 'Wed', '7:30', '8:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(27, 'Wed', '8:00', '8:15', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(28, 'Wed', '8:15', '8:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(29, 'Wed', '8:30', '8:45', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(30, 'Wed', '8:45', '9:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(31, 'Thu', '7:00', '7:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(32, 'Thu', '7:30', '8:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(33, 'Thu', '8:00', '8:15', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(34, 'Thu', '8:15', '8:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(35, 'Thu', '8:30', '8:45', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(36, 'Thu', '8:45', '9:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(37, 'Fri', '7:00', '7:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(38, 'Fri', '7:30', '8:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(39, 'Fri', '8:00', '8:15', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(40, 'Fri', '8:15', '8:30', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(41, 'Fri', '8:30', '8:45', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(42, 'Fri', '8:45', '9:00', '1', 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `image`, `status`, `city_id`, `created_at`, `updated_at`) VALUES
(1, 'المعادي', NULL, '1', 1, '2019-06-22 06:30:21', '2019-06-22 06:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `status`, `doctor_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '1', 1, 2, '2020-03-14 13:57:09', '2020-03-14 13:57:09');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `image`, `status`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'القاهرة', NULL, '1', 1, '2019-06-22 06:30:21', '2019-06-22 06:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'مصر', NULL, '1', '2019-06-22 06:30:21', '2019-06-22 06:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `docs`
--

CREATE TABLE `docs` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disc` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `docs`
--

INSERT INTO `docs` (`id`, `image`, `title`, `disc`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'عن التطبيق', 'سماعتي هو تطبيق يتيح للمستخدمين حجز مواعيد كشف ومتابعة الحجز كما يتيح لهم التواصل المباشر بالدكتور سواء عن طريق اجراء مكالمة او عمل شات داخل التطبيق ', 'about', '1', '2020-03-13 22:00:00', '2020-03-13 22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_details`
--

CREATE TABLE `doctor_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `specialties_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_details`
--

INSERT INTO `doctor_details` (`id`, `title`, `price`, `desc`, `status`, `country_id`, `city_id`, `area_id`, `specialties_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'دكتور الامراض القلبية والاوعية الدموية ', '200', NULL, '1', 1, 1, 1, 1, 1, '2019-06-22 06:30:21', '2019-06-22 06:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `recipient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `chat_id`, `sender_id`, `recipient_id`, `text`, `status`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'السلام عليكم ورحمة الله', 'new', 'doctor', '2020-03-14 13:57:09', '2020-03-14 13:57:09'),
(2, 1, 1, 2, 'السلام عليكم ورحمة الله', 'new', 'doctor', '2020-03-14 13:57:34', '2020-03-14 13:57:34'),
(3, 1, 2, 1, 'السلام عليكم ورحمة الله', 'new', 'user', '2020-03-14 13:59:01', '2020-03-14 13:59:01');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(41, '2014_10_12_000001_create_users_table', 1),
(42, '2014_10_12_100000_create_password_resets_table', 1),
(43, '2018_09_02_085138_create_notifications_table', 1),
(44, '2018_12_11_214501_create_docs_table', 1),
(45, '2018_12_25_192915_create_countries_table', 1),
(46, '2018_12_25_192916_create_cities_table', 1),
(47, '2018_12_25_192917_create_areas_table', 1),
(48, '2018_12_25_192918_create_specialties_table', 1),
(49, '2018_12_25_192919_create_doctor_details_table', 1),
(50, '2018_12_25_192922_create_appointments_table', 1),
(51, '2018_12_25_192923_create_reservations_table', 1),
(52, '2018_12_25_192924_create_chats_table', 1),
(53, '2018_12_25_192925_create_messages_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('190c2694-0451-4ecc-9cf4-4cf2d38cd4b0', 'App\\Notifications\\Notifications', 'App\\Models\\User', 1, '{\"data\":\"test User \\u0642\\u0627\\u0645 \\u0628\\u062d\\u062c\\u0632 \\u0645\\u0648\\u0639\\u062f \\u062c\\u062f\\u064a\\u062f \\u0628\\u062a\\u0627\\u0631\\u064a\\u062e  2020-03-14\",\"type\":\"reservation\"}', '2020-03-14 02:34:42', '2020-03-14 01:52:50', '2020-03-14 02:34:42'),
('5744b704-fae6-4e4a-9a08-51bd188e0d9a', 'App\\Notifications\\Notifications', 'App\\Models\\User', 2, '{\"data\":\"\\u0623.\\u062f\\\\ \\u064a\\u0648\\u0633\\u0641 \\u0627\\u062d\\u0645\\u062f \\u0639\\u0644\\u064a \\u0627\\u0631\\u0633\\u0644 \\u0631\\u0633\\u0627\\u0644\\u0629 \\u062c\\u062f\\u064a\\u062f\\u0629 \\u0644\\u0643 \",\"type\":\"message\"}', NULL, '2020-03-14 13:57:36', '2020-03-14 13:57:36'),
('5d5e4ae1-a218-4855-988b-1d99def8760a', 'App\\Notifications\\Notifications', 'App\\Models\\User', 1, '{\"data\":\"test User\\u0627\\u0631\\u0633\\u0644 \\u0631\\u0633\\u0627\\u0644\\u0629 \\u062c\\u062f\\u064a\\u062f\\u0629 \\u0644\\u0643 \",\"type\":\"message\"}', NULL, '2020-03-14 13:59:01', '2020-03-14 13:59:01'),
('d6e05d4d-2885-4bf5-805e-c4c450af0aea', 'App\\Notifications\\Notifications', 'App\\Models\\User', 1, '{\"data\":\"test User \\u0642\\u0627\\u0645 \\u0628\\u062d\\u062c\\u0632 \\u0645\\u0648\\u0639\\u062f \\u062c\\u062f\\u064a\\u062f \\u0628\\u062a\\u0627\\u0631\\u064a\\u062e  2020-03-14\",\"type\":\"reservation\"}', '2020-03-14 02:34:42', '2020-03-14 01:54:06', '2020-03-14 02:34:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appointments_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `date`, `from`, `to`, `status`, `doctor_id`, `user_id`, `appointments_id`, `created_at`, `updated_at`) VALUES
(1, '2020-03-14', '7:00', '7:30', 'pending', 1, 2, 1, '2020-03-13 22:00:00', '2020-03-13 22:00:00'),
(2, '2020-03-14', '7:30', '8:00', 'pending', 1, 2, 2, '2020-03-14 01:52:50', '2020-03-14 01:52:50'),
(3, '2020-03-14', '8:00', '8:15', 'pending', 1, 2, 3, '2020-03-14 01:54:06', '2020-03-14 01:54:06');

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE `specialties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'امراض القلب والاوعية الدموية', NULL, '1', '2019-06-22 06:30:21', '2019-06-22 06:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','doctor','user') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `type` tinyint(4) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `lang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mobile`, `image`, `device_token`, `role`, `status`, `type`, `deleted_at`, `lang`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'أ.د\\ يوسف احمد علي ', 'ahmed@gmail.com', '$2y$10$gyKryqxSufNhnUi0pw6qL.H5uM77HBEj3Ul6LLn.4pp2tSXf25Msu', '123456789', NULL, 'fweowehksdgigslgihsghlsdkgihsdglsdig', 'doctor', '1', 0, NULL, NULL, 'm6wcnX1GnYmEl4riFP8YtpLDBzaSUup3yAVAWXdghAbABeoeK56wMv8JD5F5', '2020-03-11 17:39:41', '2020-03-14 02:34:19'),
(2, 'test User', 'test@gmail.com', '$2y$10$bZ6ARhUuGGE7l9G.bnzPoOvHQ85iHeZBZD.KWYSY.WkhQQQDonISu', '0108569754', NULL, 'fweowehksdgigslgihsghlsdkgihsdglsdig', 'user', '1', 0, NULL, NULL, 'aF0uX66BkMgVcrqraxG19AHADlzWJIs37uVq1MI9iJ5dR5lUJFxVVM7RxH0e', '2020-03-11 17:44:23', '2020-03-14 13:58:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areas_city_id_foreign` (`city_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_doctor_id_foreign` (`doctor_id`),
  ADD KEY `chats_user_id_foreign` (`user_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docs`
--
ALTER TABLE `docs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_details`
--
ALTER TABLE `doctor_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_details_country_id_foreign` (`country_id`),
  ADD KEY `doctor_details_city_id_foreign` (`city_id`),
  ADD KEY `doctor_details_area_id_foreign` (`area_id`),
  ADD KEY `doctor_details_specialties_id_foreign` (`specialties_id`),
  ADD KEY `doctor_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_chat_id_foreign` (`chat_id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_recipient_id_foreign` (`recipient_id`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_doctor_id_foreign` (`doctor_id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`),
  ADD KEY `reservations_appointments_id_foreign` (`appointments_id`);

--
-- Indexes for table `specialties`
--
ALTER TABLE `specialties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `docs`
--
ALTER TABLE `docs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor_details`
--
ALTER TABLE `doctor_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `specialties`
--
ALTER TABLE `specialties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_details`
--
ALTER TABLE `doctor_details`
  ADD CONSTRAINT `doctor_details_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_details_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_details_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_details_specialties_id_foreign` FOREIGN KEY (`specialties_id`) REFERENCES `specialties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_chat_id_foreign` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_recipient_id_foreign` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_appointments_id_foreign` FOREIGN KEY (`appointments_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
