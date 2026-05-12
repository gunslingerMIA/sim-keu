-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2026 at 10:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dpmptsp`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pkjur` varchar(255) NOT NULL,
  `type` enum('JKK','JKM','JAK','JU') NOT NULL DEFAULT 'JKK',
  `tanggal` date NOT NULL,
  `nobukti` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `account_debit` bigint(20) UNSIGNED NOT NULL,
  `account_kredit` bigint(20) UNSIGNED NOT NULL,
  `sub_activity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jumlah` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `pkjur`, `type`, `tanggal`, `nobukti`, `keterangan`, `account_debit`, `account_kredit`, `sub_activity_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(4, 'B26050801151217', 'JKK', '2026-05-08', 'A-03-001', 'Fotokopi jilid', 35, 108, 1, 90000.00, '2026-05-07 18:15:12', '2026-05-07 23:00:55'),
(5, 'B26051107311037', 'JKK', '2026-05-11', 'A-03-002', 'Makmin rapat evaluasi', 42, 108, 3, 260000.00, '2026-05-11 00:31:10', '2026-05-11 00:31:10'),
(6, 'B26051207181354', 'JKK', '2026-04-30', '-', 'Panjar Didik April', 108, 110, NULL, 2000000.00, '2026-05-12 00:18:13', '2026-05-12 00:18:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_account_debit_foreign` (`account_debit`),
  ADD KEY `transactions_account_kredit_foreign` (`account_kredit`),
  ADD KEY `transactions_sub_activity_id_foreign` (`sub_activity_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_account_debit_foreign` FOREIGN KEY (`account_debit`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `transactions_account_kredit_foreign` FOREIGN KEY (`account_kredit`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `transactions_sub_activity_id_foreign` FOREIGN KEY (`sub_activity_id`) REFERENCES `sub_activities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
