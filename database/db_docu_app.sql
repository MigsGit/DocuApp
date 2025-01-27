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
-- Database: `db_docu_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `approver_ordinates`
--

CREATE TABLE `approver_ordinates` (
  `uuid` varchar(255) NOT NULL,
  `fk_document` bigint DEFAULT NULL,
  `date_created` varchar(20) DEFAULT NULL,
  `created_by` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'PENDING,APPROVED,DISAPPROVED,CANCELLED',
  `date_approved` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `approver_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `approver_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `page_no` int DEFAULT NULL,
  `ordinates` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `order_no` tinyint DEFAULT NULL,
  `updated_at` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `approver_ordinates`
--

INSERT INTO `approver_ordinates` (`uuid`, `fk_document`, `date_created`, `created_by`, `status`, `date_approved`, `approver_remarks`, `approver_id`, `page_no`, `ordinates`, `order_no`, `updated_at`, `username`, `deleted_at`) VALUES
('0e121843-5d74-4a59-83ce-39974840ef87', 1, NULL, NULL, NULL, NULL, NULL, '1', 1, '0.4489150090415913 | 0.5732846048423937', NULL, NULL, NULL, NULL),
('dc9ac388-a803-47bb-b84b-46939602279a', 6, NULL, NULL, NULL, NULL, NULL, '1', 1, '0.6867088607594937 | 0.6195960524212881', NULL, NULL, NULL, NULL),
('f89dc0e0-d823-4d2b-932d-2ac7b77758d8', 6, NULL, NULL, NULL, NULL, NULL, '3', 2, '0.6934900542495479 | 0.9079131372862395', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` bigint NOT NULL,
  `document_id` bigint DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `orig_filename` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `date_created` varchar(20) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `lastupdate` varchar(20) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int UNSIGNED NOT NULL,
  `date_created` varchar(20) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0-For approval, 1-approved, 2-disapproved,3-cancelled',
  `document_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `filtered_document_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `page_count` int DEFAULT NULL,
  `remarks` text,
  `approval_order` tinyint DEFAULT NULL,
  `view_access_users` text,
  `dcc_status` tinyint DEFAULT '0' COMMENT '0=Pending, 1=Controlled',
  `updated_at` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `date_created`, `created_by`, `category_id`, `status`, `document_name`, `filtered_document_name`, `page_count`, `remarks`, `approval_order`, `view_access_users`, `dcc_status`, `updated_at`, `username`, `deleted_at`) VALUES
(1, '2018-05-15 16:11:58', 'dormarm', 3, 0, 'undefined', '0_updated_crud_ypics_as_of_september_2024.pdf', 1, '', 1, '', 0, '2025-01-22 17:56:29', 'dormarm', NULL),
(3, NULL, NULL, NULL, NULL, 'bbbb', NULL, NULL, NULL, NULL, NULL, 0, '2024-10-22 16:36:53', NULL, NULL),
(4, NULL, NULL, NULL, NULL, 'qwerty', NULL, NULL, NULL, NULL, NULL, 0, '2024-10-22 16:36:04', NULL, NULL),
(5, NULL, NULL, NULL, NULL, 'zzz', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(6, NULL, NULL, NULL, NULL, 'undefined', '0_0_soa_2024_0001_pricon_january_2024.pdf', 2, NULL, NULL, NULL, 0, '2025-01-08 18:32:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` smallint NOT NULL DEFAULT '2' COMMENT '0=super_admin, 1=admin, 2=user',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roles`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Migz Legaspi', 'migz@gmail.com', '2024-06-27 16:37:57', '$2a$12$nFYWCwS7l.32qSuia1cGAuf/9rMopRNK7MieZBaS4itx1jRaTVfY.', 2, NULL, 'KFrN52GgFt', '2024-06-27 16:37:57', '2024-08-14 23:45:51'),
(3, 'Clark Casuyon', 'cdcausyon@gmail.com', '2024-06-27 16:37:57', '$2a$12$nFYWCwS7l.32qSuia1cGAuf/9rMopRNK7MieZBaS4itx1jRaTVfY.', 2, NULL, 'KFrN52GgFt', '2024-06-27 16:37:57', '2024-08-14 23:45:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approver_ordinates`
--
ALTER TABLE `approver_ordinates`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
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
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
