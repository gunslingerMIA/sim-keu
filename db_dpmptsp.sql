-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 10:12 AM
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
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_rekening` varchar(255) NOT NULL,
  `nama_rekening` varchar(255) NOT NULL,
  `kelompok` enum('belanja','kas','panjar','pajak') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `kode_rekening`, `nama_rekening`, `kelompok`, `created_at`, `updated_at`) VALUES
(5, 'A002', 'Panjar Didik Didik', 'panjar', '2026-04-21 21:40:50', '2026-04-21 23:19:39'),
(6, 'A003', 'Panjar Dea', 'panjar', '2026-04-21 21:41:17', '2026-04-21 21:41:17');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `program_id` bigint(20) UNSIGNED NOT NULL,
  `kode_kegiatan` varchar(255) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `program_id`, `kode_kegiatan`, `nama_kegiatan`, `created_at`, `updated_at`) VALUES
(1, 1, '2.18.01.2.01', 'Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(2, 1, '2.18.01.2.02', 'Administrasi Keuangan Perangkat Daerah', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(3, 1, '2.18.01.2.05', 'Administrasi Kepegawaian Perangkat Daerah', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(4, 1, '2.18.01.2.06', 'Administrasi Umum Perangkat Daerah', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(5, 1, '2.18.01.2.08', 'Penyediaan Jasa Penunjang Urusan Pemerintahan Daerah', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(6, 1, '2.18.01.2.09', 'Pemeliharaan Barang Milik Daerah Penunjang Urusan Pemerintahan Daerah', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(7, 2, '2.18.02.2.01', 'Penetapan Pemberian Fasilitas/Insentif', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(8, 2, '2.18.02.2.02', 'Pembuatan Peta Potensi Investasi', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(9, 3, '2.18.03.2.01', 'Penyelenggaraan Promosi Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/Kota', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(10, 4, '2.18.04.2.01', 'Pelayanan Perizinan dan Non Perizinan Secara Terpadu Satu Pintu dibidang Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/ Kota', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(11, 5, '2.18.05.2.01', 'Pengendalian Pelaksanaan Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/Kota', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(12, 6, '2.18.06.2.01', 'Pengelolaan Data dan Informasi Perizinan dan Non Perizinan yang Terintegrasi pada Tingkat Daerah Kabupaten/Kota', '2026-04-18 16:29:07', '2026-04-18 16:29:07');

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `key`, `value`, `label`, `created_at`, `updated_at`) VALUES
(1, 'tahapan_aktif', 'murni', 'APBD Murni', '2026-04-22 00:36:25', '2026-04-22 00:36:25');

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_activity_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `nominal` double NOT NULL,
  `tahapan` varchar(255) NOT NULL,
  `versi` int(11) NOT NULL DEFAULT 1,
  `dasar_hukum` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_18_152959_create_budget_plans_table', 1),
(5, '2026_04_18_154941_create_accounts_table', 2),
(15, '2026_04_18_155142_create_budgets_table', 3),
(16, '2026_04_18_155322_create_transactions_table', 3),
(17, '2026_04_22_073049_create_app_settings_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_program` varchar(255) NOT NULL,
  `nama_program` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `kode_program`, `nama_program`, `created_at`, `updated_at`) VALUES
(1, '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2026-04-18 16:29:07', '2026-04-19 10:19:42'),
(2, '2.18.02', 'PROGRAM PENGEMBANGAN IKLIM PENANAMAN MODAL', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(3, '2.18.03', 'PROGRAM PROMOSI PENANAMAN MODAL', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(4, '2.18.04', 'PROGRAM PELAYANAN PENANAMAN MODAL', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(5, '2.18.05', 'PROGRAM PENGENDALIAN PELAKSANAAN PENANAMAN MODAL', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(6, '2.18.06', 'PROGRAM PENGELOLAAN DATA DAN SISTEM INFORMASI PENANAMAN MODAL', '2026-04-18 16:29:07', '2026-04-18 16:29:07');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9n27LPOr7aTuFvOmPs6LJAwwKxDzOW30UUSao6oG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiekVsRTZVMHFoeFp2VEdOYzNHS3dqZGxoMUFBTGNiMlRjY0lXSG1qbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9idWRnZXRzPzE9IjtzOjU6InJvdXRlIjtzOjEzOiJidWRnZXRzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776845232);

-- --------------------------------------------------------

--
-- Table structure for table `sub_activities`
--

CREATE TABLE `sub_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `kode_sub_kegiatan` varchar(255) NOT NULL,
  `nama_sub_kegiatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_activities`
--

INSERT INTO `sub_activities` (`id`, `activity_id`, `kode_sub_kegiatan`, `nama_sub_kegiatan`, `created_at`, `updated_at`) VALUES
(1, 1, '2.18.01.2.01.0001', 'Penyusunan Dokumen Perencanaan Perangkat Daerah', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(2, 1, '2.18.01.2.01.0002', 'Koordinasi dan Penyusunan Dokumen RKA-SKPD', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(3, 1, '2.18.01.2.01.0007', 'Evaluasi Kinerja Perangkat Daerah', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(4, 2, '2.18.01.2.02.0001', 'Penyediaan Gaji dan Tunjangan ASN', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(5, 2, '2.18.01.2.02.0003', 'Pelaksanaan Penatausahaan dan Pengujian/Verifikasi Keuangan SKPD', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(6, 2, '2.18.01.2.02.0005', 'Koordinasi dan Penyusunan Laporan Keuangan Akhir Tahun SKPD', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(7, 3, '2.18.01.2.05.0002', 'Pengadaan Pakaian Dinas beserta Atribut Kelengkapannya', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(8, 4, '2.18.01.2.06.0001', 'Penyediaan Komponen Instalasi Listrik/Penerangan Bangunan Kantor', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(9, 4, '2.18.01.2.06.0002', 'Penyediaan Peralatan dan Perlengkapan Kantor', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(10, 4, '2.18.01.2.06.0003', 'Penyediaan Peralatan Rumah Tangga', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(11, 4, '2.18.01.2.06.0004', 'Penyediaan Bahan Logistik Kantor', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(12, 4, '2.18.01.2.06.0005', 'Penyediaan Barang Cetakan dan Penggandaan', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(13, 4, '2.18.01.2.06.0006', 'Penyediaan Bahan Bacaan dan Peraturan Perundang-undangan', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(14, 4, '2.18.01.2.06.0009', 'Penyelenggaraan Rapat Koordinasi dan Konsultasi SKPD', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(15, 5, '2.18.01.2.08.0001', 'Penyediaan Jasa Surat Menyurat', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(16, 5, '2.18.01.2.08.0002', 'Penyediaan Jasa Komunikasi, Sumber Daya Air dan Listrik', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(17, 5, '2.18.01.2.08.0004', 'Penyediaan Jasa Pelayanan Umum Kantor', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(18, 6, '2.18.01.2.09.0001', 'Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan, dan Pajak Kendaraan', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(19, 6, '2.18.01.2.09.0009', 'Pemeliharaan/Rehabilitasi Gedung Kantor', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(20, 6, '2.18.01.2.09.0010', 'Pemeliharaan/Rehabilitasi Sarana dan Prasarana Gedung', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(21, 7, '2.18.02.2.01.0004', 'Rekomendasi kebijakan sektor usaha', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(22, 8, '2.18.02.2.02.0004', 'Penyusunan Peta Potensi Investasi', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(23, 9, '2.18.03.2.01.0002', 'Pelaksanaan Kegiatan Promosi Penanaman Modal Daerah Kabupaten/Kota', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(24, 10, '2.18.04.2.01.0005', 'Koordinasi dan Sinkronisasi Penetapan Pemberian Fasilitas/Insentif Daerah', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(25, 10, '2.18.04.2.01.0006', 'KPenyediaan Pelayanan Perizinan Berusaha melalui Sistem Perizinan Berusaha Berbasis Risiko Terintegrasi secara Elektronik', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(26, 10, '2.18.04.2.01.0007', 'Penyediaan dan pengelolaan Layanan konsultasi perizinan berusaha berbasis risiko', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(27, 10, '2.18.04.2.01.0008', 'Pemantauan, analisis, evaluasi, dan pelaporan di bidang perizinan berusaha berbasis risiko', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(28, 11, '2.18.05.2.01.0004', 'Penyelesaian Permasalahan dan Hambatan yang dihadapi Pelaku Usaha dalam merealisasikan Kegiatan Usahanya', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(29, 11, '2.18.05.2.01.0005', 'Bimbingan Teknis kepada Pelaku Usaha', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(30, 11, '2.18.05.2.01.0006', 'Pengawasan Penanaman Modal', '2026-04-18 16:29:07', '2026-04-18 16:29:07'),
(31, 12, '2.18.06.2.01.0002', 'Pengolahan, Penyajian dan Pemanfaatan Data dan Informasi Perizinan Berbasis Sistem Pelayanan Perizinan Berusaha Terintegrasi secara Elektronik', '2026-04-18 16:29:07', '2026-04-18 16:29:07');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `evidence_number` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `sub_activity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `credit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-04-18 08:45:53', '$2y$12$Q1/1HIQNdNH64rMWqglqbe4WID.anehC7U7TBXTx1Qrx/qOV4lbGu', '0jnVk4Gq4W', '2026-04-18 08:45:53', '2026-04-18 08:45:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_code_unique` (`kode_rekening`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activities_kode_kegiatan_unique` (`kode_kegiatan`),
  ADD KEY `activities_program_id_foreign` (`program_id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_settings_key_unique` (`key`);

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budgets_sub_activity_id_foreign` (`sub_activity_id`),
  ADD KEY `budgets_account_id_foreign` (`account_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `programs_kode_program_unique` (`kode_program`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sub_activities`
--
ALTER TABLE `sub_activities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_activities_kode_sub_kegiatan_unique` (`kode_sub_kegiatan`),
  ADD KEY `sub_activities_activity_id_foreign` (`activity_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_account_id_foreign` (`account_id`),
  ADD KEY `transactions_sub_activity_id_foreign` (`sub_activity_id`);

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
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sub_activities`
--
ALTER TABLE `sub_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `budgets_sub_activity_id_foreign` FOREIGN KEY (`sub_activity_id`) REFERENCES `sub_activities` (`id`);

--
-- Constraints for table `sub_activities`
--
ALTER TABLE `sub_activities`
  ADD CONSTRAINT `sub_activities_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `transactions_sub_activity_id_foreign` FOREIGN KEY (`sub_activity_id`) REFERENCES `sub_activities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
