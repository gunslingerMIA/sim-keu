-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2026 at 10:20 AM
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
  `kelompok` enum('belanja','kas','panjar','pajak') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `tahun`, `kode_rekening`, `nama_rekening`, `kelompok`, `created_at`, `updated_at`) VALUES
(1, '2026', '5.1.01.01.01.0001', 'Belanja Gaji Pokok PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(2, '2026', '5.1.01.01.01.0002', 'Belanja Gaji Pokok PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(3, '2026', '5.1.01.01.02.0001', 'Belanja Tunjangan Keluarga PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(4, '2026', '5.1.01.01.02.0002', 'Belanja Tunjangan Keluarga PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(5, '2026', '5.1.01.01.03.0001', 'Belanja Tunjangan Jabatan PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(6, '2026', '5.1.01.01.04.0001', 'Belanja Tunjangan Fungsional PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(7, '2026', '5.1.01.01.04.0002', 'Belanja Tunjangan Fungsional PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(8, '2026', '5.1.01.01.05.0001', 'Belanja Tunjangan Fungsional Umum PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(9, '2026', '5.1.01.01.05.0002', 'Belanja Tunjangan Fungsional Umum PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(10, '2026', '5.1.01.01.06.0001', 'Belanja Tunjangan Beras PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(11, '2026', '5.1.01.01.06.0002', 'Belanja Tunjangan Beras PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(12, '2026', '5.1.01.01.07.0001', 'Belanja Tunjangan PPh/Tunjangan Khusus PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(13, '2026', '5.1.01.01.08.0001', 'Belanja Pembulatan Gaji PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(14, '2026', '5.1.01.01.08.0002', 'Belanja Pembulatan Gaji PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(15, '2026', '5.1.01.01.09.0001', 'Belanja Iuran Jaminan Kesehatan PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(16, '2026', '5.1.01.01.09.0002', 'Belanja Iuran Jaminan Kesehatan PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(17, '2026', '5.1.01.01.10.0001', 'Belanja Iuran Jaminan Kecelakaan Kerja PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(18, '2026', '5.1.01.01.10.0002', 'Belanja Iuran Jaminan Kecelakaan Kerja PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(19, '2026', '5.1.01.01.11.0001', 'Belanja Iuran Jaminan Kematian PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(20, '2026', '5.1.01.01.11.0002', 'Belanja Iuran Jaminan Kematian PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(21, '2026', '5.1.01.01.12.0001', 'Belanja Iuran Simpanan Peserta Tabungan Perumahan Rakyat PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(22, '2026', '5.1.01.01.12.0002', 'Belanja Iuran Simpanan Peserta Tabungan Perumahan Rakyat PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(23, '2026', '5.1.01.02.01.0001', 'Tambahan Penghasilan berdasarkan Beban Kerja PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(24, '2026', '5.1.01.02.01.0002', 'Tambahan Penghasilan berdasarkan Beban Kerja PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(25, '2026', '5.1.01.02.05.0001', 'Tambahan Penghasilan berdasarkan Prestasi Kerja PNS', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(26, '2026', '5.1.01.02.05.0002', 'Tambahan Penghasilan berdasarkan Prestasi Kerja PPPK', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(27, '2026', '5.1.01.03.07.0002', 'Belanja Honorarium Pengadaan Barang/Jasa', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(28, '2026', '5.1.02.01.01.0001', 'Belanja Bahan-Bahan Bangunan dan Konstruksi', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(29, '2026', '5.1.02.01.01.0004', 'Belanja Bahan-Bahan Bakar dan Pelumas', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(30, '2026', '5.1.02.01.01.0005', 'Belanja Bahan - Bahan Baku', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(31, '2026', '5.1.02.01.01.0009', 'Belanja Bahan Isi Tabung Pemadam Kebakaran', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(32, '2026', '5.1.02.01.01.0013', 'Belanja Suku Cadang-Suku Cadang Alat Angkutan', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(33, '2026', '5.1.02.01.01.0024', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Tulis Kantor', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(34, '2026', '5.1.02.01.01.0025', 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(35, '2026', '5.1.02.01.01.0026', 'Belanja Alat/Bahan untuk Kegiatan Kantor- Bahan Cetak', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(36, '2026', '5.1.02.01.01.0027', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Benda Pos', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(37, '2026', '5.1.02.01.01.0028', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Persediaan Dokumen/Administrasi Tender', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(38, '2026', '5.1.02.01.01.0029', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(39, '2026', '5.1.02.01.01.0030', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perabot Kantor', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(40, '2026', '5.1.02.01.01.0031', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Listrik', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(41, '2026', '5.1.02.01.01.0043', 'Belanja Natura dan Pakan-Natura', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(42, '2026', '5.1.02.01.01.0052', 'Belanja Makanan dan Minuman Rapat', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(43, '2026', '5.1.02.02.01.0003', 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(44, '2026', '5.1.02.02.01.0004', 'Honorarium Tim Pelaksana Kegiatan dan Sekretariat Tim Pelaksana Kegiatan', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(45, '2026', '5.1.02.02.01.0016', 'Belanja Jasa Tenaga Penanganan Prasarana dan Sarana Umum', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(46, '2026', '5.1.02.02.01.0028', 'Belanja Jasa Tenaga Pelayanan Umum', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(47, '2026', '5.1.02.02.01.0032', 'Belanja Jasa Tenaga Caraka', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(48, '2026', '5.1.02.02.01.0036', 'Belanja Jasa Audit/Surveillance ISO', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(49, '2026', '5.1.02.02.01.0039', 'Belanja Jasa Tenaga Informasi dan Teknologi', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(50, '2026', '5.1.02.02.01.0041', 'Belanja Jasa Pemasangan Instalasi Telepon, Air dan Listrik', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(51, '2026', '5.1.02.02.01.0047', 'Belanja Jasa Penyelenggaraan Acara', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(52, '2026', '5.1.02.02.01.0051', 'Belanja Jasa Pengolahan Sampah', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(53, '2026', '5.1.02.02.01.0055', 'Belanja Jasa Iklan/Reklame, Film, dan Pemotretan', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(54, '2026', '5.1.02.02.01.0059', 'Belanja Tagihan Telepon', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(55, '2026', '5.1.02.02.01.0060', 'Belanja Tagihan Air', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(56, '2026', '5.1.02.02.01.0061', 'Belanja Tagihan Listrik', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(57, '2026', '5.1.02.02.01.0062', 'Belanja Langganan Jurnal/Surat Kabar/Majalah', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(58, '2026', '5.1.02.02.01.0063', 'Belanja Kawat/Faksimili/Internet/TV Berlangganan', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(59, '2026', '5.1.02.02.01.0064', 'Belanja Paket/Pengiriman', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(60, '2026', '5.1.02.02.01.0067', 'Belanja Pembayaran Pajak, Bea, dan Perizinan', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(61, '2026', '5.1.02.02.01.0080', 'Belanja Honorarium Penanggungjawaban Pengelola Keuangan', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(62, '2026', '5.1.02.02.01.0081', 'Belanja Honorarium Pengadaan Barang/Jasa', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(63, '2026', '5.1.02.02.01.0087', 'Belanja Jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada Jabatan Pengelola Umum Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(64, '2026', '5.1.02.02.01.0088', 'Belanja jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada jabatan operator layanan operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(65, '2026', '5.1.02.02.01.0089', 'Belanja jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada jabatan pengelola layanan operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(66, '2026', '5.1.02.02.01.0090', 'Belanja jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada jabatan penata layanan operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(67, '2026', '5.1.02.02.02.0005', 'Belanja Iuran Jaminan Kesehatan bagi Non ASN', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(68, '2026', '5.1.02.02.02.0006', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(69, '2026', '5.1.02.02.02.0007', 'Belanja Iuran Jaminan Kematian bagi Non ASN', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(70, '2026', '5.1.02.02.02.0010', 'Belanja Iuran Jaminan Hari Tua bagi Non ASN', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(71, '2026', '5.1.02.02.02.0018', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Pengelola Umum Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(72, '2026', '5.1.02.02.02.0019', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Operator Layanan Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(73, '2026', '5.1.02.02.02.0020', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Pengelola Layanan Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(74, '2026', '5.1.02.02.02.0021', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Penata Layanan Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(75, '2026', '5.1.02.02.02.0026', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Pengelola Umum Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(76, '2026', '5.1.02.02.02.0027', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Operator Layanan Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(77, '2026', '5.1.02.02.02.0028', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Pengelola Layanan Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(78, '2026', '5.1.02.02.02.0029', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Penata Layanan Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(79, '2026', '5.1.02.02.02.0034', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Pengelola Umum Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(80, '2026', '5.1.02.02.02.0035', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Operator Layanan Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(81, '2026', '5.1.02.02.02.0036', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Pengelola Layanan Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(82, '2026', '5.1.02.02.02.0037', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Penata Layanan Operasional', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(83, '2026', '5.1.02.02.02.0081', 'Belanja Honorarium Pengadaan Barang/Jasa', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(84, '2026', '5.1.02.02.09.0013', 'Belanja Jasa Konsultansi Berorientasi Layanan-Jasa Konsultansi Manajemen', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(85, '2026', '5.1.02.02.12.0002', 'Belanja Sosialisasi', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(86, '2026', '5.1.02.02.12.0003', 'Belanja Bimbingan Teknis', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(87, '2026', '5.1.02.03.02.0022', 'Belanja Pemeliharaan Alat Besar-Alat Bantu-Electric Generating Set', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(88, '2026', '5.1.02.03.02.0038', 'Belanja Pemeliharaan Alat Angkutan-Alat Angkutan Darat Bermotor-Kendaraan Bermotor Beroda Dua', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(89, '2026', '5.1.02.03.02.0040', 'Belanja Pemeliharaan Alat Angkutan-Alat Angkutan Darat Bermotor-Kendaraan Bermotor Khusus', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(90, '2026', '5.1.02.03.02.0121', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Alat Pendingin', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(91, '2026', '5.1.02.03.02.0123', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Alat Rumah Tangga Lainnya (Home Use)', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(92, '2026', '5.1.02.03.02.0405', 'Belanja Pemeliharaan Komputer-Komputer Unit-Personal Computer', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(93, '2026', '5.1.02.03.02.0410', 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Jaringan', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(94, '2026', '5.1.02.03.02.0411', 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Komputer Lainnya', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(95, '2026', '5.1.02.03.03.0001', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Kantor', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(96, '2026', '5.1.02.04.01.0001', 'Belanja Perjalanan Dinas Biasa', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(97, '2026', '5.1.02.04.01.0003', 'Belanja Perjalanan Dinas Dalam Kota', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(98, '2026', '5.1.02.04.01.0004', 'Belanja Perjalanan Dinas Paket Meeting Dalam Kota', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(99, '2026', '5.2.02.05.01.0005', 'Belanja Modal Alat Kantor Lainnya', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(100, '2026', '5.2.02.05.02.0001', 'Belanja Modal Mebel', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(101, '2026', '5.2.02.05.02.0004', 'Belanja Modal Alat Pendingin', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(102, '2026', '5.2.02.05.02.0005', 'Belanja Modal Alat Dapur', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(103, '2026', '5.2.02.05.02.0006', 'Belanja Modal Alat Rumah Tangga Lainnya (Home Use)', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(104, '2026', '5.2.02.05.02.0007', 'Belanja Modal Alat Pemadam Kebakaran', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(105, '2026', '5.2.02.10.01.0002', 'Belanja Modal Personal Computer', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(106, '2026', '5.2.02.10.01.0003', 'Belanja Modal Komputer Unit Lainnya', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(107, '2026', '5.2.02.10.02.0004', 'Belanja Modal Peralatan Jaringan', 'belanja', '2026-04-26 17:50:19', '2026-04-26 17:50:19'),
(108, '2026', 'A002', 'Panjar DIdik', 'panjar', '2026-04-27 00:37:37', '2026-04-27 00:37:37');

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
(1, '2026', 1, '2.18.01.2.01', 'Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(2, '2026', 1, '2.18.01.2.02', 'Administrasi Keuangan Perangkat Daerah', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(3, '2026', 1, '2.18.01.2.05', 'Administrasi Kepegawaian Perangkat Daerah', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(4, '2026', 1, '2.18.01.2.06', 'Administrasi Umum Perangkat Daerah', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(5, '2026', 1, '2.18.01.2.08', 'Penyediaan Jasa Penunjang Urusan Pemerintahan Daerah', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(6, '2026', 1, '2.18.01.2.09', 'Pemeliharaan Barang Milik Daerah Penunjang Urusan Pemerintahan Daerah', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(7, '2026', 2, '2.18.02.2.01', 'Penetapan Pemberian Fasilitas/Insentif', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(8, '2026', 2, '2.18.02.2.02', 'Pembuatan Peta Potensi Investasi', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(9, '2026', 3, '2.18.03.2.01', 'Penyelenggaraan Promosi Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/Kota', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(10, '2026', 4, '2.18.04.2.01', 'Pelayanan Perizinan dan Non Perizinan Secara Terpadu Satu Pintu dibidang Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/ Kota', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(11, '2026', 5, '2.18.05.2.01', 'Pengendalian Pelaksanaan Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/Kota', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(12, '2026', 6, '2.18.06.2.01', 'Pengelolaan Data dan Informasi Perizinan dan Non Perizinan yang Terintegrasi pada Tingkat Daerah Kabupaten/Kota', '2026-04-26 17:50:11', '2026-04-26 17:50:11');

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
(1, 'tahapan_aktif', 'murni', 'APBD Murni', '2026-04-26 17:52:11', '2026-04-26 17:52:11');

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
(1, 1, 1, 1000000000, 1, 1, NULL, '2026', '2026-04-27 00:12:34', '2026-04-27 00:12:34');

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
(1, '2026', '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(2, '2026', '2.18.02', 'PROGRAM PENGEMBANGAN IKLIM PENANAMAN MODAL', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(3, '2026', '2.18.03', 'PROGRAM PROMOSI PENANAMAN MODAL', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(4, '2026', '2.18.04', 'PROGRAM PELAYANAN PENANAMAN MODAL', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(5, '2026', '2.18.05', 'PROGRAM PENGENDALIAN PELAKSANAAN PENANAMAN MODAL', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(6, '2026', '2.18.06', 'PROGRAM PENGELOLAAN DATA DAN SISTEM INFORMASI PENANAMAN MODAL', '2026-04-26 17:50:11', '2026-04-26 17:50:11');

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
('PAwgk1AjYvhOuHmLav9yiSc6vfC8faPlUV1UypGM', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiUjAxQkZYM2VpS2pzeU9RSEphcURNT3J0VTVzaWFST2pZM1dLU0FxRyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFuc2FjdGlvbnMvYWRkIjtzOjU6InJvdXRlIjtzOjE2OiJ0cmFuc2FjdGlvbnMuYWRkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE0OiJ0YWh1bl9hbmdnYXJhbiI7czo0OiIyMDI2IjtzOjE1OiJhY3RpdmVfc3RhZ2VfaWQiO2k6MTtzOjEyOiJuYW1hX3RhaGFwYW4iO3M6MTA6IkFQQkQgTXVybmkiO30=', 1777278001);

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
(1, '2026', 'APBD Murni', 1, '2026-04-26 17:52:24', '2026-04-26 17:52:24');

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
(1, '2026', 1, '2.18.01.2.01.0001', 'Penyusunan Dokumen Perencanaan Perangkat Daerah', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(2, '2026', 1, '2.18.01.2.01.0002', 'Koordinasi dan Penyusunan Dokumen RKA-SKPD', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(3, '2026', 1, '2.18.01.2.01.0007', 'Evaluasi Kinerja Perangkat Daerah', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(4, '2026', 2, '2.18.01.2.02.0001', 'Penyediaan Gaji dan Tunjangan ASN', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(5, '2026', 2, '2.18.01.2.02.0003', 'Pelaksanaan Penatausahaan dan Pengujian/Verifikasi Keuangan SKPD', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(6, '2026', 2, '2.18.01.2.02.0005', 'Koordinasi dan Penyusunan Laporan Keuangan Akhir Tahun SKPD', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(7, '2026', 3, '2.18.01.2.05.0002', 'Pengadaan Pakaian Dinas beserta Atribut Kelengkapannya', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(8, '2026', 4, '2.18.01.2.06.0001', 'Penyediaan Komponen Instalasi Listrik/Penerangan Bangunan Kantor', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(9, '2026', 4, '2.18.01.2.06.0002', 'Penyediaan Peralatan dan Perlengkapan Kantor', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(10, '2026', 4, '2.18.01.2.06.0003', 'Penyediaan Peralatan Rumah Tangga', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(11, '2026', 4, '2.18.01.2.06.0004', 'Penyediaan Bahan Logistik Kantor', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(12, '2026', 4, '2.18.01.2.06.0005', 'Penyediaan Barang Cetakan dan Penggandaan', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(13, '2026', 4, '2.18.01.2.06.0006', 'Penyediaan Bahan Bacaan dan Peraturan Perundang-undangan', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(14, '2026', 4, '2.18.01.2.06.0009', 'Penyelenggaraan Rapat Koordinasi dan Konsultasi SKPD', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(15, '2026', 5, '2.18.01.2.08.0001', 'Penyediaan Jasa Surat Menyurat', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(16, '2026', 5, '2.18.01.2.08.0002', 'Penyediaan Jasa Komunikasi, Sumber Daya Air dan Listrik', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(17, '2026', 5, '2.18.01.2.08.0004', 'Penyediaan Jasa Pelayanan Umum Kantor', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(18, '2026', 6, '2.18.01.2.09.0001', 'Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan, dan Pajak Kendaraan', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(19, '2026', 6, '2.18.01.2.09.0009', 'Pemeliharaan/Rehabilitasi Gedung Kantor', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(20, '2026', 6, '2.18.01.2.09.0010', 'Pemeliharaan/Rehabilitasi Sarana dan Prasarana Gedung', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(21, '2026', 7, '2.18.02.2.01.0004', 'Rekomendasi kebijakan sektor usaha', '2026-04-26 17:50:10', '2026-04-26 17:50:10'),
(22, '2026', 8, '2.18.02.2.02.0004', 'Penyusunan Peta Potensi Investasi', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(23, '2026', 9, '2.18.03.2.01.0002', 'Pelaksanaan Kegiatan Promosi Penanaman Modal Daerah Kabupaten/Kota', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(24, '2026', 10, '2.18.04.2.01.0005', 'Koordinasi dan Sinkronisasi Penetapan Pemberian Fasilitas/Insentif Daerah', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(25, '2026', 10, '2.18.04.2.01.0006', 'KPenyediaan Pelayanan Perizinan Berusaha melalui Sistem Perizinan Berusaha Berbasis Risiko Terintegrasi secara Elektronik', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(26, '2026', 10, '2.18.04.2.01.0007', 'Penyediaan dan pengelolaan Layanan konsultasi perizinan berusaha berbasis risiko', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(27, '2026', 10, '2.18.04.2.01.0008', 'Pemantauan, analisis, evaluasi, dan pelaporan di bidang perizinan berusaha berbasis risiko', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(28, '2026', 11, '2.18.05.2.01.0004', 'Penyelesaian Permasalahan dan Hambatan yang dihadapi Pelaku Usaha dalam merealisasikan Kegiatan Usahanya', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(29, '2026', 11, '2.18.05.2.01.0005', 'Bimbingan Teknis kepada Pelaku Usaha', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(30, '2026', 11, '2.18.05.2.01.0006', 'Pengawasan Penanaman Modal', '2026-04-26 17:50:11', '2026-04-26 17:50:11'),
(31, '2026', 12, '2.18.06.2.01.0002', 'Pengolahan, Penyajian dan Pemanfaatan Data dan Informasi Perizinan Berbasis Sistem Pelayanan Perizinan Berusaha Terintegrasi secara Elektronik', '2026-04-26 17:50:11', '2026-04-26 17:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` varchar(255) NOT NULL,
  `type` enum('JKK','JKM','JAK','JU') NOT NULL DEFAULT 'JKK',
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
(1, 'Didik Yogo Suro Prasojo, S.Kom', '199801092022031007', 'Pranata Komputer Ahli Pertama', 'admin', '$2y$12$dEESWNvzs45iGgNCWQ1n2.xtaf0fF9.icsWsEqv00X5C0Px9J1gF6', '2026-04-26 17:51:49', '2026-04-26 17:51:49');

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
(1, '2026', 1, '2026-04-26 17:50:55', '2026-04-26 17:50:55');

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
  ADD KEY `transactions_account_id_foreign` (`account_id`),
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `transactions_sub_activity_id_foreign` FOREIGN KEY (`sub_activity_id`) REFERENCES `sub_activities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
