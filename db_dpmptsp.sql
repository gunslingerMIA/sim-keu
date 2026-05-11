-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 10:22 AM
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
  `tahun` year(4) NOT NULL,
  `kode_rekening` varchar(255) NOT NULL,
  `nama_rekening` varchar(255) NOT NULL,
  `kelompok` enum('sub-kegiatan','non sub-kegiatan') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `tahun`, `kode_rekening`, `nama_rekening`, `kelompok`, `created_at`, `updated_at`) VALUES
(1, '2026', '5.1.01.01.01.0001', 'Belanja Gaji Pokok PNS', 'sub-kegiatan', '2026-04-27 23:23:22', '2026-04-27 23:23:22'),
(2, '2026', '5.1.01.01.01.0002', 'Belanja Gaji Pokok PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(3, '2026', '5.1.01.01.02.0001', 'Belanja Tunjangan Keluarga PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(4, '2026', '5.1.01.01.02.0002', 'Belanja Tunjangan Keluarga PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(5, '2026', '5.1.01.01.03.0001', 'Belanja Tunjangan Jabatan PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(6, '2026', '5.1.01.01.04.0001', 'Belanja Tunjangan Fungsional PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(7, '2026', '5.1.01.01.04.0002', 'Belanja Tunjangan Fungsional PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(8, '2026', '5.1.01.01.05.0001', 'Belanja Tunjangan Fungsional Umum PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(9, '2026', '5.1.01.01.05.0002', 'Belanja Tunjangan Fungsional Umum PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(10, '2026', '5.1.01.01.06.0001', 'Belanja Tunjangan Beras PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(11, '2026', '5.1.01.01.06.0002', 'Belanja Tunjangan Beras PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(12, '2026', '5.1.01.01.07.0001', 'Belanja Tunjangan PPh/Tunjangan Khusus PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(13, '2026', '5.1.01.01.08.0001', 'Belanja Pembulatan Gaji PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(14, '2026', '5.1.01.01.08.0002', 'Belanja Pembulatan Gaji PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(15, '2026', '5.1.01.01.09.0001', 'Belanja Iuran Jaminan Kesehatan PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(16, '2026', '5.1.01.01.09.0002', 'Belanja Iuran Jaminan Kesehatan PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(17, '2026', '5.1.01.01.10.0001', 'Belanja Iuran Jaminan Kecelakaan Kerja PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(18, '2026', '5.1.01.01.10.0002', 'Belanja Iuran Jaminan Kecelakaan Kerja PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(19, '2026', '5.1.01.01.11.0001', 'Belanja Iuran Jaminan Kematian PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(20, '2026', '5.1.01.01.11.0002', 'Belanja Iuran Jaminan Kematian PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(21, '2026', '5.1.01.01.12.0001', 'Belanja Iuran Simpanan Peserta Tabungan Perumahan Rakyat PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(22, '2026', '5.1.01.01.12.0002', 'Belanja Iuran Simpanan Peserta Tabungan Perumahan Rakyat PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(23, '2026', '5.1.01.02.01.0001', 'Tambahan Penghasilan berdasarkan Beban Kerja PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(24, '2026', '5.1.01.02.01.0002', 'Tambahan Penghasilan berdasarkan Beban Kerja PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(25, '2026', '5.1.01.02.05.0001', 'Tambahan Penghasilan berdasarkan Prestasi Kerja PNS', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(26, '2026', '5.1.01.02.05.0002', 'Tambahan Penghasilan berdasarkan Prestasi Kerja PPPK', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(27, '2026', '5.1.01.03.07.0002', 'Belanja Honorarium Pengadaan Barang/Jasa', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(28, '2026', '5.1.02.01.01.0001', 'Belanja Bahan-Bahan Bangunan dan Konstruksi', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(29, '2026', '5.1.02.01.01.0004', 'Belanja Bahan-Bahan Bakar dan Pelumas', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(30, '2026', '5.1.02.01.01.0005', 'Belanja Bahan - Bahan Baku', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(31, '2026', '5.1.02.01.01.0009', 'Belanja Bahan Isi Tabung Pemadam Kebakaran', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(32, '2026', '5.1.02.01.01.0013', 'Belanja Suku Cadang-Suku Cadang Alat Angkutan', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(33, '2026', '5.1.02.01.01.0024', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Tulis Kantor', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(34, '2026', '5.1.02.01.01.0025', 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(35, '2026', '5.1.02.01.01.0026', 'Belanja Alat/Bahan untuk Kegiatan Kantor- Bahan Cetak', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(36, '2026', '5.1.02.01.01.0027', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Benda Pos', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(37, '2026', '5.1.02.01.01.0028', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Persediaan Dokumen/Administrasi Tender', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(38, '2026', '5.1.02.01.01.0029', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(39, '2026', '5.1.02.01.01.0030', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perabot Kantor', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(40, '2026', '5.1.02.01.01.0031', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Listrik', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(41, '2026', '5.1.02.01.01.0043', 'Belanja Natura dan Pakan-Natura', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(42, '2026', '5.1.02.01.01.0052', 'Belanja Makanan dan Minuman Rapat', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(43, '2026', '5.1.02.02.01.0003', 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(44, '2026', '5.1.02.02.01.0004', 'Honorarium Tim Pelaksana Kegiatan dan Sekretariat Tim Pelaksana Kegiatan', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(45, '2026', '5.1.02.02.01.0016', 'Belanja Jasa Tenaga Penanganan Prasarana dan Sarana Umum', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(46, '2026', '5.1.02.02.01.0028', 'Belanja Jasa Tenaga Pelayanan Umum', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(47, '2026', '5.1.02.02.01.0032', 'Belanja Jasa Tenaga Caraka', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(48, '2026', '5.1.02.02.01.0036', 'Belanja Jasa Audit/Surveillance ISO', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(49, '2026', '5.1.02.02.01.0039', 'Belanja Jasa Tenaga Informasi dan Teknologi', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(50, '2026', '5.1.02.02.01.0041', 'Belanja Jasa Pemasangan Instalasi Telepon, Air dan Listrik', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(51, '2026', '5.1.02.02.01.0047', 'Belanja Jasa Penyelenggaraan Acara', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(52, '2026', '5.1.02.02.01.0051', 'Belanja Jasa Pengolahan Sampah', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(53, '2026', '5.1.02.02.01.0055', 'Belanja Jasa Iklan/Reklame, Film, dan Pemotretan', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(54, '2026', '5.1.02.02.01.0059', 'Belanja Tagihan Telepon', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(55, '2026', '5.1.02.02.01.0060', 'Belanja Tagihan Air', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(56, '2026', '5.1.02.02.01.0061', 'Belanja Tagihan Listrik', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(57, '2026', '5.1.02.02.01.0062', 'Belanja Langganan Jurnal/Surat Kabar/Majalah', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(58, '2026', '5.1.02.02.01.0063', 'Belanja Kawat/Faksimili/Internet/TV Berlangganan', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(59, '2026', '5.1.02.02.01.0064', 'Belanja Paket/Pengiriman', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(60, '2026', '5.1.02.02.01.0067', 'Belanja Pembayaran Pajak, Bea, dan Perizinan', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(61, '2026', '5.1.02.02.01.0080', 'Belanja Honorarium Penanggungjawaban Pengelola Keuangan', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(62, '2026', '5.1.02.02.01.0081', 'Belanja Honorarium Pengadaan Barang/Jasa', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(63, '2026', '5.1.02.02.01.0087', 'Belanja Jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada Jabatan Pengelola Umum Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(64, '2026', '5.1.02.02.01.0088', 'Belanja jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada jabatan operator layanan operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(65, '2026', '5.1.02.02.01.0089', 'Belanja jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada jabatan pengelola layanan operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(66, '2026', '5.1.02.02.01.0090', 'Belanja jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada jabatan penata layanan operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(67, '2026', '5.1.02.02.02.0005', 'Belanja Iuran Jaminan Kesehatan bagi Non ASN', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(68, '2026', '5.1.02.02.02.0006', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(69, '2026', '5.1.02.02.02.0007', 'Belanja Iuran Jaminan Kematian bagi Non ASN', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(70, '2026', '5.1.02.02.02.0010', 'Belanja Iuran Jaminan Hari Tua bagi Non ASN', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(71, '2026', '5.1.02.02.02.0018', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Pengelola Umum Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(72, '2026', '5.1.02.02.02.0019', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Operator Layanan Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(73, '2026', '5.1.02.02.02.0020', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Pengelola Layanan Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(74, '2026', '5.1.02.02.02.0021', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Penata Layanan Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(75, '2026', '5.1.02.02.02.0026', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Pengelola Umum Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(76, '2026', '5.1.02.02.02.0027', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Operator Layanan Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(77, '2026', '5.1.02.02.02.0028', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Pengelola Layanan Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(78, '2026', '5.1.02.02.02.0029', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Penata Layanan Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(79, '2026', '5.1.02.02.02.0034', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Pengelola Umum Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(80, '2026', '5.1.02.02.02.0035', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Operator Layanan Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(81, '2026', '5.1.02.02.02.0036', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Pengelola Layanan Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(82, '2026', '5.1.02.02.02.0037', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Penata Layanan Operasional', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(83, '2026', '5.1.02.02.02.0081', 'Belanja Honorarium Pengadaan Barang/Jasa', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(84, '2026', '5.1.02.02.09.0013', 'Belanja Jasa Konsultansi Berorientasi Layanan-Jasa Konsultansi Manajemen', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(85, '2026', '5.1.02.02.12.0002', 'Belanja Sosialisasi', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(86, '2026', '5.1.02.02.12.0003', 'Belanja Bimbingan Teknis', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(87, '2026', '5.1.02.03.02.0022', 'Belanja Pemeliharaan Alat Besar-Alat Bantu-Electric Generating Set', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(88, '2026', '5.1.02.03.02.0038', 'Belanja Pemeliharaan Alat Angkutan-Alat Angkutan Darat Bermotor-Kendaraan Bermotor Beroda Dua', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(89, '2026', '5.1.02.03.02.0040', 'Belanja Pemeliharaan Alat Angkutan-Alat Angkutan Darat Bermotor-Kendaraan Bermotor Khusus', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(90, '2026', '5.1.02.03.02.0121', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Alat Pendingin', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(91, '2026', '5.1.02.03.02.0123', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Alat Rumah Tangga Lainnya (Home Use)', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(92, '2026', '5.1.02.03.02.0405', 'Belanja Pemeliharaan Komputer-Komputer Unit-Personal Computer', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(93, '2026', '5.1.02.03.02.0410', 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Jaringan', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(94, '2026', '5.1.02.03.02.0411', 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Komputer Lainnya', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(95, '2026', '5.1.02.03.03.0001', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Kantor', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(96, '2026', '5.1.02.04.01.0001', 'Belanja Perjalanan Dinas Biasa', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(97, '2026', '5.1.02.04.01.0003', 'Belanja Perjalanan Dinas Dalam Kota', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(98, '2026', '5.1.02.04.01.0004', 'Belanja Perjalanan Dinas Paket Meeting Dalam Kota', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(99, '2026', '5.2.02.05.01.0005', 'Belanja Modal Alat Kantor Lainnya', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(100, '2026', '5.2.02.05.02.0001', 'Belanja Modal Mebel', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(101, '2026', '5.2.02.05.02.0004', 'Belanja Modal Alat Pendingin', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(102, '2026', '5.2.02.05.02.0005', 'Belanja Modal Alat Dapur', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(103, '2026', '5.2.02.05.02.0006', 'Belanja Modal Alat Rumah Tangga Lainnya (Home Use)', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(104, '2026', '5.2.02.05.02.0007', 'Belanja Modal Alat Pemadam Kebakaran', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(105, '2026', '5.2.02.10.01.0002', 'Belanja Modal Personal Computer', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(106, '2026', '5.2.02.10.01.0003', 'Belanja Modal Komputer Unit Lainnya', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(107, '2026', '5.2.02.10.02.0004', 'Belanja Modal Peralatan Jaringan', 'sub-kegiatan', '2026-04-27 23:23:23', '2026-04-27 23:23:23'),
(108, '2026', 'A002', 'Panjar Didik', 'non sub-kegiatan', '2026-04-27 23:30:05', '2026-04-27 23:30:05'),
(109, '2026', '1.1.1.03.01', 'Kas di Bendahara Pengeluaran (Bank)', 'non sub-kegiatan', '2026-04-29 01:10:09', '2026-04-29 01:10:09'),
(110, '2026', '1.1.1.03.02', 'Kas di Bendahara Pengeluaran (Tunai)', 'non sub-kegiatan', '2026-04-29 01:10:34', '2026-04-29 01:10:34'),
(111, '2026', '3.1.3.01.01', 'RK PPKD', 'non sub-kegiatan', '2026-04-29 01:10:49', '2026-04-29 01:10:49');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL,
  `program_id` bigint(20) UNSIGNED NOT NULL,
  `kode_kegiatan` varchar(255) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `tahun`, `program_id`, `kode_kegiatan`, `nama_kegiatan`, `created_at`, `updated_at`) VALUES
(1, '2026', 1, '2.18.01.2.01', 'Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(2, '2026', 1, '2.18.01.2.02', 'Administrasi Keuangan Perangkat Daerah', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(3, '2026', 1, '2.18.01.2.05', 'Administrasi Kepegawaian Perangkat Daerah', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(4, '2026', 1, '2.18.01.2.06', 'Administrasi Umum Perangkat Daerah', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(5, '2026', 1, '2.18.01.2.08', 'Penyediaan Jasa Penunjang Urusan Pemerintahan Daerah', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(6, '2026', 1, '2.18.01.2.09', 'Pemeliharaan Barang Milik Daerah Penunjang Urusan Pemerintahan Daerah', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(7, '2026', 2, '2.18.02.2.01', 'Penetapan Pemberian Fasilitas/Insentif', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(8, '2026', 2, '2.18.02.2.02', 'Pembuatan Peta Potensi Investasi', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(9, '2026', 3, '2.18.03.2.01', 'Penyelenggaraan Promosi Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/Kota', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(10, '2026', 4, '2.18.04.2.01', 'Pelayanan Perizinan dan Non Perizinan Secara Terpadu Satu Pintu dibidang Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/ Kota', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(11, '2026', 5, '2.18.05.2.01', 'Pengendalian Pelaksanaan Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/Kota', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(12, '2026', 6, '2.18.06.2.01', 'Pengelolaan Data dan Informasi Perizinan dan Non Perizinan yang Terintegrasi pada Tingkat Daerah Kabupaten/Kota', '2026-04-27 23:23:53', '2026-04-27 23:23:53');

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

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_activity_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `nominal` double NOT NULL,
  `stage_id` bigint(20) UNSIGNED NOT NULL,
  `versi` int(11) NOT NULL DEFAULT 1,
  `dasar_hukum` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budgets`
--

INSERT INTO `budgets` (`id`, `sub_activity_id`, `account_id`, `nominal`, `stage_id`, `versi`, `dasar_hukum`, `tahun`, `created_at`, `updated_at`) VALUES
(3, 3, 35, 900000, 1, 1, NULL, '2026', '2026-04-28 20:13:51', '2026-04-28 20:13:51'),
(4, 1, 35, 125000, 1, 1, NULL, '2026', '2026-04-28 20:16:02', '2026-04-28 20:16:02'),
(6, 1, 42, 975000, 1, 1, NULL, '2026', '2026-04-28 20:18:24', '2026-04-28 20:18:24'),
(7, 2, 35, 296000, 1, 1, NULL, '2026', '2026-04-28 20:18:48', '2026-04-28 20:18:48'),
(8, 2, 42, 975000, 1, 1, NULL, '2026', '2026-04-28 20:19:00', '2026-04-28 20:19:00'),
(9, 4, 1, 1059349000, 1, 1, NULL, '2026', '2026-04-28 20:19:42', '2026-04-28 20:19:42'),
(10, 4, 2, 132967000, 1, 1, NULL, '2026', '2026-04-28 20:19:55', '2026-04-28 20:19:55'),
(11, 4, 3, 119734000, 1, 1, NULL, '2026', '2026-04-28 20:20:08', '2026-04-28 20:20:08'),
(12, 4, 4, 15857000, 1, 1, NULL, '2026', '2026-04-28 20:20:39', '2026-04-28 20:20:39'),
(13, 4, 5, 90764000, 1, 1, NULL, '2026', '2026-04-28 20:20:52', '2026-04-28 20:20:52'),
(14, 4, 6, 34916000, 1, 1, NULL, '2026', '2026-04-28 20:25:45', '2026-04-28 20:25:45'),
(15, 4, 7, 17435000, 1, 1, NULL, '2026', '2026-04-28 20:26:14', '2026-04-28 20:26:14'),
(16, 4, 8, 35153000, 1, 1, NULL, '2026', '2026-04-28 20:26:31', '2026-04-28 20:26:31'),
(17, 4, 9, 5310000, 1, 1, NULL, '2026', '2026-04-28 20:26:51', '2026-04-28 20:26:51'),
(18, 4, 10, 69913000, 1, 1, NULL, '2026', '2026-04-28 20:27:03', '2026-04-28 20:27:03'),
(19, 4, 11, 9353000, 1, 1, NULL, '2026', '2026-04-28 20:27:15', '2026-04-28 20:27:15'),
(20, 4, 12, 16937000, 1, 1, NULL, '2026', '2026-04-28 20:27:30', '2026-04-28 20:27:30'),
(21, 4, 13, 620000, 1, 1, NULL, '2026', '2026-04-28 20:27:43', '2026-04-28 20:27:43'),
(22, 4, 14, 7000, 1, 1, NULL, '2026', '2026-04-28 20:27:57', '2026-04-28 20:27:57'),
(23, 4, 15, 78321000, 1, 1, NULL, '2026', '2026-04-28 20:28:32', '2026-04-28 20:28:32'),
(24, 4, 16, 10879000, 1, 1, NULL, '2026', '2026-04-28 20:28:45', '2026-04-28 20:28:45'),
(25, 4, 17, 2601000, 1, 1, NULL, '2026', '2026-04-28 20:30:30', '2026-04-28 20:30:30'),
(26, 4, 18, 773000, 1, 1, NULL, '2026', '2026-04-28 20:30:40', '2026-04-28 20:30:54'),
(27, 4, 19, 7287000, 1, 1, NULL, '2026', '2026-04-28 20:31:14', '2026-04-28 20:31:14'),
(28, 4, 20, 1566000, 1, 1, NULL, '2026', '2026-04-28 20:31:28', '2026-04-28 20:31:28'),
(29, 4, 23, 375915000, 1, 1, NULL, '2026', '2026-04-28 20:31:45', '2026-04-28 20:31:45'),
(30, 4, 24, 7387000, 1, 1, NULL, '2026', '2026-04-28 20:32:00', '2026-04-28 20:32:00'),
(31, 4, 25, 566291000, 1, 1, NULL, '2026', '2026-04-28 20:32:15', '2026-04-28 20:32:15'),
(32, 4, 26, 11081000, 1, 1, NULL, '2026', '2026-04-28 20:32:30', '2026-04-28 20:32:30'),
(33, 6, 35, 180000, 1, 1, NULL, '2026', '2026-04-28 20:38:52', '2026-04-28 20:38:52'),
(34, 6, 42, 780000, 1, 1, NULL, '2026', '2026-04-28 20:39:06', '2026-04-28 20:39:06'),
(35, 8, 40, 4000000, 1, 1, NULL, '2026', '2026-04-28 20:56:07', '2026-04-28 20:56:07'),
(36, 9, 33, 6420000, 1, 1, NULL, '2026', '2026-04-28 20:56:42', '2026-04-28 20:56:42'),
(37, 9, 34, 6452000, 1, 1, NULL, '2026', '2026-04-28 20:56:54', '2026-04-28 20:56:54'),
(38, 9, 35, 7558000, 1, 1, NULL, '2026', '2026-04-28 20:57:06', '2026-04-28 20:57:06'),
(39, 9, 36, 500000, 1, 1, NULL, '2026', '2026-04-28 20:57:19', '2026-04-28 20:57:19'),
(40, 10, 39, 6560000, 1, 1, NULL, '2026', '2026-04-28 20:57:47', '2026-04-28 20:57:47'),
(41, 11, 41, 17279000, 1, 1, NULL, '2026', '2026-04-28 23:51:36', '2026-04-28 23:51:36'),
(42, 11, 42, 2600000, 1, 1, NULL, '2026', '2026-04-28 23:51:50', '2026-04-28 23:51:50'),
(43, 12, 33, 3900000, 1, 1, NULL, '2026', '2026-04-28 23:52:38', '2026-04-28 23:52:38'),
(44, 12, 35, 10966000, 1, 1, NULL, '2026', '2026-04-28 23:52:51', '2026-04-28 23:52:51'),
(45, 12, 37, 6900000, 1, 1, NULL, '2026', '2026-04-28 23:53:09', '2026-04-28 23:53:09'),
(46, 14, 35, 80000, 1, 1, NULL, '2026', '2026-04-28 23:53:36', '2026-04-28 23:53:36'),
(47, 14, 96, 66946000, 1, 1, NULL, '2026', '2026-04-28 23:53:49', '2026-04-28 23:53:49'),
(48, 15, 47, 3000000, 1, 1, NULL, '2026', '2026-04-28 23:54:27', '2026-04-28 23:54:27'),
(49, 16, 54, 2400000, 1, 1, NULL, '2026', '2026-04-28 23:54:58', '2026-04-28 23:54:58'),
(50, 16, 55, 12600000, 1, 1, NULL, '2026', '2026-04-28 23:55:10', '2026-04-28 23:55:10'),
(51, 16, 56, 287280000, 1, 1, NULL, '2026', '2026-04-28 23:55:26', '2026-04-28 23:55:26'),
(52, 16, 58, 96000000, 1, 1, NULL, '2026', '2026-04-28 23:55:40', '2026-04-28 23:55:40'),
(53, 17, 35, 1000, 1, 1, NULL, '2026', '2026-04-28 23:56:12', '2026-04-28 23:56:12'),
(54, 17, 39, 347000, 1, 1, NULL, '2026', '2026-04-28 23:56:26', '2026-04-28 23:56:26'),
(55, 17, 46, 194400000, 1, 1, NULL, '2026', '2026-04-28 23:56:40', '2026-04-28 23:56:40'),
(56, 17, 52, 2700000, 1, 1, NULL, '2026', '2026-04-28 23:56:54', '2026-04-28 23:56:54'),
(57, 17, 63, 24000000, 1, 1, NULL, '2026', '2026-04-28 23:57:24', '2026-04-28 23:57:24'),
(58, 17, 64, 177000000, 1, 1, NULL, '2026', '2026-04-28 23:57:39', '2026-04-28 23:57:39'),
(59, 17, 65, 105783000, 1, 1, NULL, '2026', '2026-04-28 23:57:56', '2026-04-28 23:57:56'),
(60, 17, 66, 218400000, 1, 1, NULL, '2026', '2026-04-28 23:58:09', '2026-04-28 23:58:09'),
(61, 17, 67, 10848000, 1, 1, NULL, '2026', '2026-04-28 23:58:21', '2026-04-28 23:58:21'),
(62, 17, 68, 768000, 1, 1, NULL, '2026', '2026-04-28 23:58:32', '2026-04-28 23:58:32'),
(63, 17, 69, 864000, 1, 1, NULL, '2026', '2026-04-28 23:58:42', '2026-04-28 23:58:42'),
(64, 17, 70, 1272000, 1, 1, NULL, '2026', '2026-04-28 23:58:53', '2026-04-28 23:58:53'),
(65, 17, 71, 1356000, 1, 1, NULL, '2026', '2026-04-28 23:59:03', '2026-04-28 23:59:03'),
(66, 17, 72, 9492000, 1, 1, NULL, '2026', '2026-04-28 23:59:14', '2026-04-28 23:59:14'),
(67, 17, 73, 4536000, 1, 1, NULL, '2026', '2026-04-28 23:59:25', '2026-04-28 23:59:25'),
(68, 17, 74, 9996000, 1, 1, NULL, '2026', '2026-04-28 23:59:36', '2026-04-28 23:59:36'),
(69, 17, 75, 84000, 1, 1, NULL, '2026', '2026-04-28 23:59:47', '2026-04-28 23:59:47'),
(70, 17, 76, 588000, 1, 1, NULL, '2026', '2026-04-28 23:59:58', '2026-04-28 23:59:58'),
(71, 17, 77, 276000, 1, 1, NULL, '2026', '2026-04-29 00:00:10', '2026-04-29 00:00:10'),
(72, 17, 78, 612000, 1, 1, NULL, '2026', '2026-04-29 00:00:20', '2026-04-29 00:00:20'),
(73, 17, 79, 108000, 1, 1, NULL, '2026', '2026-04-29 00:00:31', '2026-04-29 00:00:31'),
(74, 17, 80, 756000, 1, 1, NULL, '2026', '2026-04-29 00:00:39', '2026-04-29 00:00:39'),
(75, 17, 81, 360000, 1, 1, NULL, '2026', '2026-04-29 00:00:50', '2026-04-29 00:00:50'),
(76, 17, 82, 792000, 1, 1, NULL, '2026', '2026-04-29 00:01:00', '2026-04-29 00:01:00'),
(77, 18, 29, 16458000, 1, 1, NULL, '2026', '2026-04-29 00:01:51', '2026-04-29 00:01:51'),
(78, 18, 35, 3000, 1, 1, NULL, '2026', '2026-04-29 00:02:00', '2026-04-29 00:02:00'),
(79, 18, 60, 9000000, 1, 1, NULL, '2026', '2026-04-29 00:02:09', '2026-04-29 00:02:09'),
(80, 18, 88, 5000000, 1, 1, NULL, '2026', '2026-04-29 00:02:21', '2026-04-29 00:02:21'),
(81, 18, 89, 17000000, 1, 1, NULL, '2026', '2026-04-29 00:02:34', '2026-04-29 00:02:34'),
(82, 19, 28, 7226000, 1, 1, NULL, '2026', '2026-04-29 00:24:03', '2026-04-29 00:24:03'),
(83, 19, 45, 9000000, 1, 1, NULL, '2026', '2026-04-29 00:24:16', '2026-04-29 00:24:16'),
(84, 20, 29, 294000, 1, 1, NULL, '2026', '2026-04-29 00:24:48', '2026-04-29 00:24:48'),
(85, 20, 35, 6000, 1, 1, NULL, '2026', '2026-04-29 00:24:58', '2026-04-29 00:24:58'),
(86, 20, 90, 8400000, 1, 1, NULL, '2026', '2026-04-29 00:25:08', '2026-04-29 00:25:08'),
(87, 20, 92, 2000000, 1, 1, NULL, '2026', '2026-04-29 00:25:19', '2026-04-29 00:25:19'),
(88, 20, 94, 1200000, 1, 1, NULL, '2026', '2026-04-29 00:25:28', '2026-04-29 00:25:28'),
(89, 21, 35, 169000, 1, 1, NULL, '2026', '2026-04-29 00:27:13', '2026-04-29 00:27:13'),
(90, 21, 42, 780000, 1, 1, NULL, '2026', '2026-04-29 00:27:33', '2026-04-29 00:27:33'),
(91, 22, 35, 239000, 1, 1, NULL, '2026', '2026-04-29 00:27:54', '2026-04-29 00:47:55'),
(92, 22, 42, 520000, 1, 1, NULL, '2026', '2026-04-29 00:28:04', '2026-04-29 00:48:06'),
(93, 23, 35, 879000, 1, 1, NULL, '2026', '2026-04-29 00:28:36', '2026-04-29 00:28:36'),
(94, 23, 42, 260000, 1, 1, NULL, '2026', '2026-04-29 00:30:29', '2026-04-29 00:30:29'),
(95, 24, 35, 54000, 1, 1, NULL, '2026', '2026-04-29 00:30:59', '2026-04-29 00:30:59'),
(96, 24, 42, 2340000, 1, 1, NULL, '2026', '2026-04-29 00:31:11', '2026-04-29 00:31:11'),
(97, 25, 35, 147000, 1, 1, NULL, '2026', '2026-04-29 00:31:52', '2026-04-29 00:31:52'),
(98, 25, 42, 975000, 1, 1, NULL, '2026', '2026-04-29 00:32:08', '2026-04-29 00:32:08'),
(99, 25, 44, 16500000, 1, 1, NULL, '2026', '2026-04-29 00:32:17', '2026-04-29 00:32:17'),
(100, 25, 46, 138000000, 1, 1, NULL, '2026', '2026-04-29 00:32:29', '2026-04-29 00:32:29'),
(101, 25, 67, 6072000, 1, 1, NULL, '2026', '2026-04-29 00:32:38', '2026-04-29 00:32:38'),
(102, 25, 68, 408000, 1, 1, NULL, '2026', '2026-04-29 00:32:47', '2026-04-29 00:32:47'),
(103, 25, 69, 504000, 1, 1, NULL, '2026', '2026-04-29 00:32:56', '2026-04-29 00:32:56'),
(104, 26, 35, 1172000, 1, 1, NULL, '2026', '2026-04-29 00:38:15', '2026-04-29 00:38:15'),
(105, 26, 37, 1328000, 1, 1, NULL, '2026', '2026-04-29 00:38:25', '2026-04-29 00:38:25'),
(106, 26, 42, 3900000, 1, 1, NULL, '2026', '2026-04-29 00:38:35', '2026-04-29 00:38:35'),
(107, 26, 44, 16500000, 1, 1, NULL, '2026', '2026-04-29 00:38:44', '2026-04-29 00:38:44'),
(108, 27, 35, 176000, 1, 1, NULL, '2026', '2026-04-29 00:39:32', '2026-04-29 00:39:32'),
(109, 27, 42, 2340000, 1, 1, NULL, '2026', '2026-04-29 00:39:58', '2026-04-29 00:39:58'),
(110, 27, 46, 82800000, 1, 1, NULL, '2026', '2026-04-29 00:40:07', '2026-04-29 00:40:07'),
(111, 27, 67, 4068000, 1, 1, NULL, '2026', '2026-04-29 00:40:17', '2026-04-29 00:40:17'),
(112, 27, 68, 252000, 1, 1, NULL, '2026', '2026-04-29 00:40:26', '2026-04-29 00:40:26'),
(113, 27, 69, 324000, 1, 1, NULL, '2026', '2026-04-29 00:40:35', '2026-04-29 00:40:35'),
(114, 28, 35, 694000, 1, 1, NULL, '2026', '2026-04-29 00:41:17', '2026-04-29 00:41:17'),
(115, 28, 42, 2080000, 1, 1, NULL, '2026', '2026-04-29 00:41:28', '2026-04-29 00:41:28'),
(116, 29, 34, 524000, 1, 1, NULL, '2026', '2026-04-29 00:41:53', '2026-04-29 00:41:53'),
(117, 29, 35, 845000, 1, 1, NULL, '2026', '2026-04-29 00:42:03', '2026-04-29 00:42:03'),
(118, 29, 42, 1300000, 1, 1, NULL, '2026', '2026-04-29 00:42:12', '2026-04-29 00:42:12'),
(119, 29, 46, 26400000, 1, 1, NULL, '2026', '2026-04-29 00:42:21', '2026-04-29 00:49:25'),
(120, 29, 67, 1356000, 1, 1, NULL, '2026', '2026-04-29 00:42:30', '2026-04-29 00:42:30'),
(121, 29, 68, 84000, 1, 1, NULL, '2026', '2026-04-29 00:42:38', '2026-04-29 00:42:38'),
(122, 29, 69, 108000, 1, 1, NULL, '2026', '2026-04-29 00:42:46', '2026-04-29 00:42:46'),
(123, 30, 35, 167000, 1, 1, NULL, '2026', '2026-04-29 00:43:08', '2026-04-29 00:43:08'),
(124, 30, 42, 260000, 1, 1, NULL, '2026', '2026-04-29 00:43:17', '2026-04-29 00:43:17'),
(125, 31, 35, 243000, 1, 1, NULL, '2026', '2026-04-29 00:43:37', '2026-04-29 00:43:37'),
(126, 31, 42, 260000, 1, 1, NULL, '2026', '2026-04-29 00:43:45', '2026-04-29 00:43:45'),
(127, 31, 46, 55200000, 1, 1, NULL, '2026', '2026-04-29 00:43:55', '2026-04-29 00:43:55'),
(128, 31, 67, 2712000, 1, 1, NULL, '2026', '2026-04-29 00:44:05', '2026-04-29 00:44:05'),
(129, 31, 68, 168000, 1, 1, NULL, '2026', '2026-04-29 00:44:36', '2026-04-29 00:44:36'),
(130, 31, 69, 216000, 1, 1, NULL, '2026', '2026-04-29 00:44:44', '2026-04-29 00:44:44'),
(131, 3, 42, 3900000, 1, 1, NULL, '2026', '2026-05-06 22:04:51', '2026-05-06 22:04:51');

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
(4, '2026_04_16_082303_create_stages_table', 1),
(5, '2026_04_18_152959_create_budget_plans_table', 1),
(6, '2026_04_18_154941_create_accounts_table', 1),
(7, '2026_04_18_155142_create_budgets_table', 1),
(8, '2026_04_18_155322_create_transactions_table', 1),
(9, '2026_04_22_073049_create_app_settings_table', 1),
(10, '2026_04_25_082521_create_years_table', 1),
(11, '2026_04_25_153242_add_tahun_to_master_tables', 1),
(12, '2026_04_26_094817_add_type_to_transasctions_table', 1);

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
  `tahun` year(4) NOT NULL,
  `kode_program` varchar(255) NOT NULL,
  `nama_program` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `tahun`, `kode_program`, `nama_program`, `created_at`, `updated_at`) VALUES
(1, '2026', '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(2, '2026', '2.18.02', 'PROGRAM PENGEMBANGAN IKLIM PENANAMAN MODAL', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(3, '2026', '2.18.03', 'PROGRAM PROMOSI PENANAMAN MODAL', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(4, '2026', '2.18.04', 'PROGRAM PELAYANAN PENANAMAN MODAL', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(5, '2026', '2.18.05', 'PROGRAM PENGENDALIAN PELAKSANAAN PENANAMAN MODAL', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(6, '2026', '2.18.06', 'PROGRAM PENGELOLAAN DATA DAN SISTEM INFORMASI PENANAMAN MODAL', '2026-04-27 23:23:53', '2026-04-27 23:23:53');

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
('b9QVz5onHdiVJtE5A7R1JGe7y8JdC9QGrUosk0WJ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiTnJtMGI3RXUyc0haR2tZQ255Zzg2Q3JZZ2VYUkNRaUV6YjBPUXN2TCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Nzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXBvcnRzL2pvdXJuYWw/ZW5kX2RhdGU9MjAyNi0wNS0zMSZzdGFydF9kYXRlPTIwMjYtMDUtMDEiO3M6NToicm91dGUiO3M6MTU6InJlcG9ydHMuam91cm5hbCI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFuc2FjdGlvbnMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTQ6InRhaHVuX2FuZ2dhcmFuIjtzOjQ6IjIwMjYiO3M6MTU6ImFjdGl2ZV9zdGFnZV9pZCI7aToxO3M6MTI6Im5hbWFfdGFoYXBhbiI7czoxMDoiQVBCRCBNdXJuaSI7fQ==', 1778225155),
('cx11BvZKnF5GPcqpz1Nmpnm5HOcNqnpk3Al117LK', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoibERPQzRFdGw5RW5iMTlxZ1h6b2NnV3dqaGZFZWZmZ1M2V1RVUUtqMCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3RyYW5zYWN0aW9ucyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjc5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcmVwb3J0cy9qb3VybmFsP2VuZF9kYXRlPTIwMjYtMDUtMzAmc3RhcnRfZGF0ZT0yMDI2LTA0LTAxIjtzOjU6InJvdXRlIjtzOjE1OiJyZXBvcnRzLmpvdXJuYWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTQ6InRhaHVuX2FuZ2dhcmFuIjtzOjQ6IjIwMjYiO3M6MTU6ImFjdGl2ZV9zdGFnZV9pZCI7aToxO3M6MTI6Im5hbWFfdGFoYXBhbiI7czoxMDoiQVBCRCBNdXJuaSI7fQ==', 1778487696);

-- --------------------------------------------------------

--
-- Table structure for table `stages`
--

CREATE TABLE `stages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL,
  `nama_tahapan` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stages`
--

INSERT INTO `stages` (`id`, `tahun`, `nama_tahapan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2026', 'APBD Murni', 1, '2026-04-27 23:23:37', '2026-04-27 23:23:37');

-- --------------------------------------------------------

--
-- Table structure for table `sub_activities`
--

CREATE TABLE `sub_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `kode_sub_kegiatan` varchar(255) NOT NULL,
  `nama_sub_kegiatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_activities`
--

INSERT INTO `sub_activities` (`id`, `tahun`, `activity_id`, `kode_sub_kegiatan`, `nama_sub_kegiatan`, `created_at`, `updated_at`) VALUES
(1, '2026', 1, '2.18.01.2.01.0001', 'Penyusunan Dokumen Perencanaan Perangkat Daerah', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(2, '2026', 1, '2.18.01.2.01.0002', 'Koordinasi dan Penyusunan Dokumen RKA-SKPD', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(3, '2026', 1, '2.18.01.2.01.0007', 'Evaluasi Kinerja Perangkat Daerah', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(4, '2026', 2, '2.18.01.2.02.0001', 'Penyediaan Gaji dan Tunjangan ASN', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(5, '2026', 2, '2.18.01.2.02.0003', 'Pelaksanaan Penatausahaan dan Pengujian/Verifikasi Keuangan SKPD', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(6, '2026', 2, '2.18.01.2.02.0005', 'Koordinasi dan Penyusunan Laporan Keuangan Akhir Tahun SKPD', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(7, '2026', 3, '2.18.01.2.05.0002', 'Pengadaan Pakaian Dinas beserta Atribut Kelengkapannya', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(8, '2026', 4, '2.18.01.2.06.0001', 'Penyediaan Komponen Instalasi Listrik/Penerangan Bangunan Kantor', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(9, '2026', 4, '2.18.01.2.06.0002', 'Penyediaan Peralatan dan Perlengkapan Kantor', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(10, '2026', 4, '2.18.01.2.06.0003', 'Penyediaan Peralatan Rumah Tangga', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(11, '2026', 4, '2.18.01.2.06.0004', 'Penyediaan Bahan Logistik Kantor', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(12, '2026', 4, '2.18.01.2.06.0005', 'Penyediaan Barang Cetakan dan Penggandaan', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(13, '2026', 4, '2.18.01.2.06.0006', 'Penyediaan Bahan Bacaan dan Peraturan Perundang-undangan', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(14, '2026', 4, '2.18.01.2.06.0009', 'Penyelenggaraan Rapat Koordinasi dan Konsultasi SKPD', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(15, '2026', 5, '2.18.01.2.08.0001', 'Penyediaan Jasa Surat Menyurat', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(16, '2026', 5, '2.18.01.2.08.0002', 'Penyediaan Jasa Komunikasi, Sumber Daya Air dan Listrik', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(17, '2026', 5, '2.18.01.2.08.0004', 'Penyediaan Jasa Pelayanan Umum Kantor', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(18, '2026', 6, '2.18.01.2.09.0001', 'Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan, dan Pajak Kendaraan', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(19, '2026', 6, '2.18.01.2.09.0009', 'Pemeliharaan/Rehabilitasi Gedung Kantor', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(20, '2026', 6, '2.18.01.2.09.0010', 'Pemeliharaan/Rehabilitasi Sarana dan Prasarana Gedung', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(21, '2026', 7, '2.18.02.2.01.0004', 'Rekomendasi kebijakan sektor usaha', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(22, '2026', 8, '2.18.02.2.02.0004', 'Penyusunan Peta Potensi Investasi', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(23, '2026', 9, '2.18.03.2.01.0002', 'Pelaksanaan Kegiatan Promosi Penanaman Modal Daerah Kabupaten/Kota', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(24, '2026', 10, '2.18.04.2.01.0005', 'Koordinasi dan Sinkronisasi Penetapan Pemberian Fasilitas/Insentif Daerah', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(25, '2026', 10, '2.18.04.2.01.0006', 'Penyediaan Pelayanan Perizinan Berusaha melalui Sistem Perizinan Berusaha Berbasis Risiko Terintegrasi secara Elektronik', '2026-04-27 23:23:53', '2026-05-06 23:12:22'),
(26, '2026', 10, '2.18.04.2.01.0007', 'Penyediaan dan pengelolaan Layanan konsultasi perizinan berusaha berbasis risiko', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(27, '2026', 10, '2.18.04.2.01.0008', 'Pemantauan, analisis, evaluasi, dan pelaporan di bidang perizinan berusaha berbasis risiko', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(28, '2026', 11, '2.18.05.2.01.0004', 'Penyelesaian Permasalahan dan Hambatan yang dihadapi Pelaku Usaha dalam merealisasikan Kegiatan Usahanya', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(29, '2026', 11, '2.18.05.2.01.0005', 'Bimbingan Teknis kepada Pelaku Usaha', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(30, '2026', 11, '2.18.05.2.01.0006', 'Pengawasan Penanaman Modal', '2026-04-27 23:23:53', '2026-04-27 23:23:53'),
(31, '2026', 12, '2.18.06.2.01.0002', 'Pengolahan, Penyajian dan Pemanfaatan Data dan Informasi Perizinan Berbasis Sistem Pelayanan Perizinan Berusaha Terintegrasi secara Elektronik', '2026-04-27 23:23:53', '2026-04-27 23:23:53');

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
(5, 'B26051107311037', 'JKK', '2026-05-11', 'A-03-002', 'Makmin rapat evaluasi', 42, 108, 3, 260000.00, '2026-05-11 00:31:10', '2026-05-11 00:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nip`, `jabatan`, `role`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Didik Yogo Suro Prasojo, S.Kom', '199801092022031007', 'Pranata Komputer Ahli Pertama', 'admin', '$2y$12$.FPiM2KdL0jtAl6N3cjolONmsSo.d9wZ56N2pYk/GKvtrtmQ6oVx2', '2026-04-27 23:23:44', '2026-04-27 23:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `tahun`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2026', 1, '2026-04-27 23:24:02', '2026-04-27 23:24:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_kode_rekening_unique` (`kode_rekening`),
  ADD KEY `accounts_tahun_index` (`tahun`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activities_kode_kegiatan_unique` (`kode_kegiatan`),
  ADD KEY `activities_program_id_foreign` (`program_id`),
  ADD KEY `activities_tahun_index` (`tahun`);

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
  ADD KEY `budgets_account_id_foreign` (`account_id`),
  ADD KEY `budgets_stage_id_foreign` (`stage_id`);

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
  ADD UNIQUE KEY `programs_kode_program_unique` (`kode_program`),
  ADD KEY `programs_tahun_index` (`tahun`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stages`
--
ALTER TABLE `stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_activities`
--
ALTER TABLE `sub_activities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_activities_kode_sub_kegiatan_unique` (`kode_sub_kegiatan`),
  ADD KEY `sub_activities_activity_id_foreign` (`activity_id`),
  ADD KEY `sub_activities_tahun_index` (`tahun`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_account_debit_foreign` (`account_debit`),
  ADD KEY `transactions_account_kredit_foreign` (`account_kredit`),
  ADD KEY `transactions_sub_activity_id_foreign` (`sub_activity_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_nip_unique` (`nip`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `years_tahun_unique` (`tahun`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stages`
--
ALTER TABLE `stages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_activities`
--
ALTER TABLE `sub_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
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
  ADD CONSTRAINT `budgets_stage_id_foreign` FOREIGN KEY (`stage_id`) REFERENCES `stages` (`id`),
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
  ADD CONSTRAINT `transactions_account_debit_foreign` FOREIGN KEY (`account_debit`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `transactions_account_kredit_foreign` FOREIGN KEY (`account_kredit`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `transactions_sub_activity_id_foreign` FOREIGN KEY (`sub_activity_id`) REFERENCES `sub_activities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
