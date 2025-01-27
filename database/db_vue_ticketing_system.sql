-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 27, 2025 at 03:21 PM
-- Server version: 8.0.40-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_vue_ticketing_system`
--

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
(10, '2014_10_12_000000_create_users_table', 1),
(11, '2014_10_12_100000_create_password_resets_table', 1),
(12, '2019_08_19_000000_create_failed_jobs_table', 1),
(13, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(14, '2023_09_12_033008_create_tickets_table', 1),
(15, '2023_09_15_052144_create_trts_table', 1),
(16, '2023_09_18_050001_create_resolution_procedure_titles_table', 1),
(17, '2023_09_18_055937_create_resolution_procedure_lists_table', 1),
(18, '2023_09_21_073052_create_ticket_close_details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
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
-- Table structure for table `resolution_procedure_lists`
--

CREATE TABLE `resolution_procedure_lists` (
  `id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `resolution_procedure_title_id` bigint UNSIGNED NOT NULL,
  `procedure_list` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resolution_procedure_lists`
--

INSERT INTO `resolution_procedure_lists` (`id`, `deleted_at`, `resolution_procedure_title_id`, `procedure_list`, `created_at`, `updated_at`) VALUES
(1, '2025-01-16 02:59:57', 1, 'n/a', NULL, '2025-01-16 02:59:57'),
(2, '2025-01-16 02:59:57', 1, 'n/a', NULL, '2025-01-16 02:59:57'),
(3, '2025-01-16 02:59:57', 1, 'n/a', NULL, '2025-01-16 02:59:57'),
(4, '2025-01-16 02:59:57', 1, 'Check the PC', NULL, '2025-01-16 02:59:57'),
(5, '2025-01-16 02:59:57', 1, 'n/a', NULL, '2025-01-16 02:59:57'),
(6, '2025-01-16 02:59:57', 1, 'n/a', NULL, '2025-01-16 02:59:57'),
(7, NULL, 2, 'test', NULL, NULL),
(8, NULL, 2, 'test', NULL, NULL),
(9, NULL, 1, 'Check the PC', NULL, NULL),
(10, NULL, 1, 'n/a', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resolution_procedure_titles`
--

CREATE TABLE `resolution_procedure_titles` (
  `id` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `procedure_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resolution_procedure_titles`
--

INSERT INTO `resolution_procedure_titles` (`id`, `updated_by`, `procedure_title`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rapidx Account', NULL, NULL, '2025-01-16 02:59:57'),
(2, 1, 'PC Troubleshooting', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_unique_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0-unassigned, 1-assigned, 2-DNMR, 3-closed',
  `trt_id` bigint UNSIGNED DEFAULT NULL COMMENT 'trt_id',
  `assigned_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'user_id',
  `resolution_time` smallint UNSIGNED DEFAULT NULL,
  `created_by` smallint UNSIGNED DEFAULT NULL,
  `updated_by` smallint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_no`, `max_unique_no`, `subject`, `message`, `status`, `trt_id`, `assigned_to`, `resolution_time`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'SR+2024111200000001', '00000001', 'n/a', 'n/a', '3', NULL, '1', NULL, 1, NULL, NULL, '2024-11-12 03:07:11', '2025-01-15 18:56:31'),
(2, 'SR+2025011400000001', '00000001', 'test', 'test', '0', NULL, NULL, NULL, 1, NULL, NULL, '2025-01-14 02:50:18', '2025-01-14 05:26:56');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_close_details`
--

CREATE TABLE `ticket_close_details` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `resolution_procedure_title_id` bigint UNSIGNED NOT NULL,
  `initial_assessement_summary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `root_cause` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_time_closed` datetime DEFAULT NULL,
  `date_time_resolved` datetime DEFAULT NULL,
  `is_close` smallint DEFAULT NULL COMMENT '1-Yes|2-No',
  `conformance_mode` smallint DEFAULT NULL COMMENT '1-Verbal|2-Email',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_close_details`
--

INSERT INTO `ticket_close_details` (`id`, `ticket_id`, `resolution_procedure_title_id`, `initial_assessement_summary`, `root_cause`, `reference_link`, `date_time_closed`, `date_time_resolved`, `is_close`, `conformance_mode`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'n/a', 'n/a', 'n/a', '2025-01-14 10:49:00', '2025-01-14 10:49:00', 1, 2, NULL, NULL, NULL),
(2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trts`
--

CREATE TABLE `trts` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_day` smallint NOT NULL DEFAULT '0',
  `duration_hour` smallint NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` smallint UNSIGNED DEFAULT NULL,
  `updated_by` smallint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trts`
--

INSERT INTO `trts` (`id`, `code`, `duration_day`, `duration_hour`, `description`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'TEST', 1, 0, NULL, 1, NULL, NULL, '2024-11-11 19:05:01', NULL);

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
  `roles` smallint NOT NULL DEFAULT '2' COMMENT '0=super_admin, 1=admin, 2=user',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roles`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Migz Legaspi', 'migz@gmail.com', '2024-06-27 16:37:57', '$2a$12$nFYWCwS7l.32qSuia1cGAuf/9rMopRNK7MieZBaS4itx1jRaTVfY.', 2, NULL, 'KFrN52GgFt', '2024-06-27 16:37:57', '2024-08-14 23:45:51'),
(4, 'Clark Casuyon', 'cdcausyon@gmail.com', '2024-06-27 16:37:57', '$2a$12$nFYWCwS7l.32qSuia1cGAuf/9rMopRNK7MieZBaS4itx1jRaTVfY.', 2, NULL, 'KFrN52GgFt', '2024-06-27 16:37:57', '2024-08-14 23:45:51'),
(5, 'Clark Casuyon', 'cdcausyon1@gmail.com', '2024-06-27 16:37:57', '$2a$12$nFYWCwS7l.32qSuia1cGAuf/9rMopRNK7MieZBaS4itx1jRaTVfY.', 2, NULL, 'KFrN52GgFt', '2024-06-27 16:37:57', '2024-08-14 23:45:51');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `resolution_procedure_lists`
--
ALTER TABLE `resolution_procedure_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resolution_procedure_lists_resolution_procedure_title_id_foreign` (`resolution_procedure_title_id`);

--
-- Indexes for table `resolution_procedure_titles`
--
ALTER TABLE `resolution_procedure_titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resolution_procedure_titles_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_close_details`
--
ALTER TABLE `ticket_close_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_close_details_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_close_details_resolution_procedure_title_id_foreign` (`resolution_procedure_title_id`);

--
-- Indexes for table `trts`
--
ALTER TABLE `trts`
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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resolution_procedure_lists`
--
ALTER TABLE `resolution_procedure_lists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `resolution_procedure_titles`
--
ALTER TABLE `resolution_procedure_titles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ticket_close_details`
--
ALTER TABLE `ticket_close_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trts`
--
ALTER TABLE `trts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `resolution_procedure_lists`
--
ALTER TABLE `resolution_procedure_lists`
  ADD CONSTRAINT `resolution_procedure_lists_resolution_procedure_title_id_foreign` FOREIGN KEY (`resolution_procedure_title_id`) REFERENCES `resolution_procedure_titles` (`id`);

--
-- Constraints for table `resolution_procedure_titles`
--
ALTER TABLE `resolution_procedure_titles`
  ADD CONSTRAINT `resolution_procedure_titles_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `ticket_close_details`
--
ALTER TABLE `ticket_close_details`
  ADD CONSTRAINT `ticket_close_details_resolution_procedure_title_id_foreign` FOREIGN KEY (`resolution_procedure_title_id`) REFERENCES `resolution_procedure_titles` (`id`),
  ADD CONSTRAINT `ticket_close_details_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
