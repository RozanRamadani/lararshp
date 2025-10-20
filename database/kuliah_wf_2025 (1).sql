-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2025 at 02:36 AM
-- Server version: 8.0.30
-- PHP Version: 8.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kuliah_wf_2025`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_rekam_medis`
--

CREATE TABLE `detail_rekam_medis` (
  `iddetail_rekam_medis` int NOT NULL,
  `idrekam_medis` int NOT NULL,
  `idkode_tindakan_terapi` int NOT NULL,
  `detail` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_rekam_medis`
--

INSERT INTO `detail_rekam_medis` (`iddetail_rekam_medis`, `idrekam_medis`, `idkode_tindakan_terapi`, `detail`) VALUES
(3, 3, 1, 'Rabies');

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
-- Table structure for table `jenis_hewan`
--

CREATE TABLE `jenis_hewan` (
  `idjenis_hewan` int NOT NULL,
  `nama_jenis_hewan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_hewan`
--

INSERT INTO `jenis_hewan` (`idjenis_hewan`, `nama_jenis_hewan`) VALUES
(1, 'Anjing (Canis lupus familiaris)'),
(2, 'Kucing (Felis catus)'),
(3, 'Kelinci (Oryctolagus cuniculus)'),
(4, 'Burung'),
(5, 'Reptil'),
(6, 'Rodent / Hewan Kecil');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int NOT NULL,
  `nama_kategori` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `nama_kategori`) VALUES
(1, 'Vaksinasi'),
(2, 'Bedah / Operasi'),
(3, 'Cairan infus'),
(4, 'Terapi Injeksi'),
(5, 'Terapi Oral'),
(6, 'Diagnostik'),
(7, 'Rawat Inap'),
(8, 'Lain-lain');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_klinis`
--

CREATE TABLE `kategori_klinis` (
  `idkategori_klinis` int NOT NULL,
  `nama_kategori_klinis` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_klinis`
--

INSERT INTO `kategori_klinis` (`idkategori_klinis`, `nama_kategori_klinis`) VALUES
(1, 'Terapi'),
(2, 'Tindakan');

-- --------------------------------------------------------

--
-- Table structure for table `kode_tindakan_terapi`
--

CREATE TABLE `kode_tindakan_terapi` (
  `idkode_tindakan_terapi` int NOT NULL,
  `kode` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi_tindakan_terapi` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idkategori` int NOT NULL,
  `idkategori_klinis` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kode_tindakan_terapi`
--

INSERT INTO `kode_tindakan_terapi` (`idkode_tindakan_terapi`, `kode`, `deskripsi_tindakan_terapi`, `idkategori`, `idkategori_klinis`) VALUES
(1, 'T01', 'Vaksinasi Rabies', 1, 1),
(2, 'T02', 'Vaksinasi Polivalen (DHPPi/L untuk anjing)', 1, 1),
(3, 'T03', 'Vaksinasi Panleukopenia / Tricat kucing', 1, 1),
(4, 'T04', 'Vaksinasi lainnya (bordetella, influenza, dsb.)', 1, 1),
(5, 'T05', 'Sterilisasi jantan', 2, 2),
(6, 'T06', 'Sterilisasi betina', 2, 2),
(9, 'T07', 'Minor surgery (luka, abses)', 2, 2),
(10, 'T08', 'Major surgery (laparotomi, tumor)', 2, 2),
(11, 'T09', 'Infus intravena cairan kristaloid', 3, 1),
(12, 'T10', 'Infus intravena cairan koloid', 3, 1),
(13, 'T11', 'Antibiotik injeksi', 4, 1),
(14, 'T12', 'Antiparasit injeksi', 4, 1),
(15, 'T13', 'Antiemetik / gastroprotektor', 4, 1),
(16, 'T14', 'Analgesik / antiinflamasi', 4, 1),
(17, 'T15', 'Kortikosteroid', 4, 1),
(18, 'T16', 'Antibiotik oral', 5, 1),
(19, 'T17', 'Antiparasit oral', 5, 1),
(20, 'T18', 'Vitamin / suplemen', 5, 1),
(21, 'T19', 'Diet khusus', 5, 1),
(22, 'T20', 'Pemeriksaan darah rutin', 6, 2),
(23, 'T21', 'Pemeriksaan kimia darah', 6, 2),
(24, 'T22', 'Pemeriksaan feses / parasitologi', 6, 2),
(25, 'T23', 'Pemeriksaan urin', 6, 2),
(26, 'T24', 'Radiografi (rontgen)', 6, 2),
(27, 'T25', 'USG Abdomen', 6, 2),
(28, 'T26', 'Sitologi / biopsi', 6, 2),
(29, 'T27', 'Rapid test penyakit infeksi', 6, 2),
(30, 'T28', 'Observasi sehari', 7, 2),
(31, 'T29', 'Observasi lebih dari 1 hari', 7, 2),
(32, 'T30', 'Grooming medis', 8, 2),
(33, 'T31', 'Deworming', 8, 1),
(34, 'T32', 'Ektoparasit control', 8, 1);

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

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
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `NIP` char(25) NOT NULL,
  `nama_pegawai` varchar(50) NOT NULL,
  `No_telp` varchar(18) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemilik`
--

CREATE TABLE `pemilik` (
  `idpemilik` int NOT NULL,
  `no_wa` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `iduser` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemilik`
--

INSERT INTO `pemilik` (`idpemilik`, `no_wa`, `alamat`, `iduser`) VALUES
(5, '0865645354347', 'Jl. Durian\r\n', 9),
(6, '08556263156356', 'Jl. Nangka', 33),
(7, '0865645354345', 'Jl. Kenanga', 36),
(8, '085277575645', 'Jl. Sawo', 35);

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `idpet` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `warna_tanda` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` char(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idpemilik` int NOT NULL,
  `idras_hewan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`idpet`, `nama`, `tanggal_lahir`, `warna_tanda`, `jenis_kelamin`, `idpemilik`, `idras_hewan`) VALUES
(11, 'Sumbul', '2025-06-12', 'Hitam', 'J', 6, 18),
(12, 'Galaxy Destroyer', '2025-06-11', 'Hitam', 'J', 7, 4),
(13, 'Cukurukuk', '2025-06-18', 'Oren', 'B', 6, 18);

-- --------------------------------------------------------

--
-- Table structure for table `proyek`
--

CREATE TABLE `proyek` (
  `id_proyek` char(25) NOT NULL,
  `nama_proyek` varchar(50) NOT NULL,
  `tanggal_dimulai` datetime DEFAULT CURRENT_TIMESTAMP,
  `tanggal_berakhir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ras_hewan`
--

CREATE TABLE `ras_hewan` (
  `idras_hewan` int NOT NULL,
  `nama_ras` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idjenis_hewan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ras_hewan`
--

INSERT INTO `ras_hewan` (`idras_hewan`, `nama_ras`, `idjenis_hewan`) VALUES
(1, 'Golden Retriever', 1),
(2, 'Labrador Retriever', 1),
(3, 'German Shepherd', 1),
(4, 'Bulldog (English, French)', 1),
(5, 'Poodle (Toy, Miniature, Standard)', 1),
(6, 'Beagle', 1),
(7, 'Siberian Husky', 1),
(8, 'Shih Tzu', 1),
(9, 'Dachshund', 1),
(10, 'Chihuahua', 1),
(11, 'Persia', 2),
(12, 'Maine Coon', 2),
(13, 'Siamese', 2),
(14, 'Bengal', 2),
(15, 'Sphynx', 2),
(16, 'Scottish Fold', 2),
(17, 'British Shorthair', 2),
(18, 'Anggora', 2),
(19, 'Domestic Shorthair (kampung)', 2),
(20, 'Ragdoll', 2),
(21, 'Holland Lop', 3),
(22, 'Netherland Dwarf', 3),
(23, 'Flemish Giant', 3),
(24, 'Lionhead', 3),
(25, 'Rex', 3),
(26, 'Angora Rabbit', 3),
(27, 'Mini Lop', 3),
(28, 'Lovebird (Agapornis sp.)', 4),
(29, 'Kakatua (Cockatoo)', 4),
(30, 'Parrot / Nuri (Macaw, African Grey, Amazon Parrot)', 4),
(31, 'Kenari (Serinus canaria)', 4),
(32, 'Merpati (Columba livia)', 4),
(33, 'Parkit (Budgerigar / Melopsittacus undulatus)', 4),
(34, 'Jalak (Sturnus sp.)', 4),
(35, 'Kura-kura Sulcata (African spurred tortoise)', 5),
(36, 'Red-Eared Slider (Trachemys scripta elegans)', 5),
(37, 'Leopard Gecko', 5),
(38, 'Iguana hijau', 5),
(39, 'Ball Python', 5),
(40, 'Corn Snake', 5),
(41, 'Hamster (Syrian, Roborovski, Campbell, Winter White)', 6),
(42, 'Guinea Pig (Abyssinian, Peruvian, American Shorthair)', 6),
(43, 'Gerbil', 6),
(44, 'Chinchilla', 6);

-- --------------------------------------------------------

--
-- Table structure for table `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `idrekam_medis` int NOT NULL,
  `idreservasi_dokter` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `anamesis` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `temuan_klinis` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `diagnosa` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dokter_pemeriksa` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekam_medis`
--

INSERT INTO `rekam_medis` (`idrekam_medis`, `idreservasi_dokter`, `created_at`, `anamesis`, `temuan_klinis`, `diagnosa`, `dokter_pemeriksa`) VALUES
(3, 17, '2025-09-21 20:21:12', 'Anjing tidak mau makan dan muntah sejak kemarin.', 'Suhu tubuh 40°C, dehidrasi ringan, bulu kusam.', 'Gastroenteritis pada Anjing', 14),
(18, 22, '2025-10-06 21:39:29', 'Kucinggg tidak mau makan dan muntah sejak kemarin.', 'Suhu tubuh 41°C, dehidrasi ringan, bulu kusam.', 'Gastroenteritis pada Kucingggg', 24);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `idrole` int NOT NULL,
  `nama_role` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`idrole`, `nama_role`) VALUES
(1, 'Administrator'),
(2, 'Dokter'),
(3, 'Perawat'),
(4, 'Resepsionis'),
(5, 'Pemilik');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `idrole_user` int NOT NULL,
  `iduser` bigint NOT NULL,
  `idrole` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`idrole_user`, `iduser`, `idrole`, `status`) VALUES
(14, 10, 2, 1),
(23, 27, 4, 1),
(24, 28, 2, 1),
(26, 33, 5, 1),
(27, 9, 5, 1),
(28, 34, 3, 1),
(29, 6, 1, 1),
(30, 6, 3, 0),
(32, 35, 5, 1),
(33, 36, 5, 1),
(35, 37, 2, 1),
(38, 41, 5, 1),
(39, 41, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('YI3msB7A9KBijJnaR28X85Y6PgtOce0SuAPT2rDL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVDlRdU12UmtqaTNmVnEyMmNOVm16WFhkY2wxdFQ1c2EwQVo1d0NEcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW1pbGlrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760927698);

-- --------------------------------------------------------

--
-- Table structure for table `temu_dokter`
--

CREATE TABLE `temu_dokter` (
  `idreservasi_dokter` int NOT NULL,
  `no_urut` int DEFAULT NULL,
  `waktu_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idpet` int NOT NULL,
  `idrole_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temu_dokter`
--

INSERT INTO `temu_dokter` (`idreservasi_dokter`, `no_urut`, `waktu_daftar`, `status`, `idpet`, `idrole_user`) VALUES
(17, 1, '2025-09-21 12:28:04', '0', 11, 14),
(18, 1, '2025-09-22 04:42:21', '0', 11, 14),
(19, 1, '2025-10-06 06:50:54', '0', 12, 24),
(20, 1, '2025-10-07 02:47:54', '0', 13, 24),
(21, 2, '2025-10-07 03:43:46', '0', 12, 14),
(22, 3, '2025-10-07 04:07:48', '0', 13, 14);

-- --------------------------------------------------------

--
-- Table structure for table `todo_list`
--

CREATE TABLE `todo_list` (
  `status_selesai` tinyint(1) DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `NIP` char(25) DEFAULT NULL,
  `id_proyek` char(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` bigint NOT NULL,
  `nama` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `nama`, `email`, `password`) VALUES
(6, 'admin', 'admin@mail.com', '$2y$10$V8ZlMp6ICQzYc/Eb8RwPluPeK5REwS9htuCJLNTkwAXXl.L7M.3Di'),
(9, 'rozan', 'rozan@gmail.com', '$2y$10$x0sTz7/GAJqLumJJR2ALTugVrF8hlKCblfghgWyXaZih./MjWAWuO'),
(10, 'John', 'aiman@gmail.com', '$2y$10$9fXhPidL8UeqQe.zMwTDvu4GizW1lELJ4bZ//O8ke9MNSyH45gXAO'),
(27, 'aiman', 'aiman@mail.com', '$2y$10$rpyKuHq4MFKguloYjZl6XeBJVOvLuj9B6Tkx7LuEkxrDN4qt3M/ya'),
(28, 'James', 'james@gmail.com', '$2y$10$nJKqu2iowzb/ZvYaqPLkk.KZmvtSfx.0g0WaDWxPVx9O/oapsDmx6'),
(33, 'Mich', 'mich@gmail.com', '$2y$10$E9.HKJploE5TiHmzRaFAIuStApv92rw63MBH6JkaeVoHnkW9lCyii'),
(34, 'Perawat', 'perawat@gmail.com', '$2y$10$W93n.qXld4kcGAY5TFAE.uo4liVvgh8f8IntLE/7wv9fuWQkzQnpm'),
(35, 'Oliver Sykes', 'oliver@gmail.com', '$2y$10$3I0ezyG.aTO83AcpARMGxeUMxIkIMrkWGUZMKx69gxCiKZo0.L9P.'),
(36, 'Liam Gallagher', 'liam@gmail.com', '$2y$10$aq4KfGV3JaVzWMlJCn2f.OgxPzzZiqkMN4P8a6IGFm8R3/3ZUcvEC'),
(37, 'Doc Hudson', 'doc@gmail.com', '$2y$10$IjMacivz1PgBOtNJ2rNgB.hPLQME9Oq4GzWAMYTp3m6S1mpOF7W.y'),
(38, 'Bill Armstrong', 'bill@gmail.com', '$2y$10$7LcDUHmWk90eQJ3GsUatqOBci.swcs0TxMbSlhcmtuJ56lJlK3p4S'),
(41, 'Kurt Cobain', 'kurt@gmail.com', '$2y$10$WzhULMT.JVAL3Ar9vunZveY19aiUZytVpT3GTPuja3lo7BHAdQxtS');

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
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `detail_rekam_medis`
--
ALTER TABLE `detail_rekam_medis`
  ADD PRIMARY KEY (`iddetail_rekam_medis`),
  ADD KEY `fk_detail_rekam_medis_rekam_medis1_idx` (`idrekam_medis`),
  ADD KEY `idkode_tindakan_terapi` (`idkode_tindakan_terapi`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jenis_hewan`
--
ALTER TABLE `jenis_hewan`
  ADD PRIMARY KEY (`idjenis_hewan`);

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
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indexes for table `kategori_klinis`
--
ALTER TABLE `kategori_klinis`
  ADD PRIMARY KEY (`idkategori_klinis`);

--
-- Indexes for table `kode_tindakan_terapi`
--
ALTER TABLE `kode_tindakan_terapi`
  ADD PRIMARY KEY (`idkode_tindakan_terapi`),
  ADD KEY `fk_kode_tindakan_terapi_kategori1_idx` (`idkategori`),
  ADD KEY `fk_kode_tindakan_terapi_kategori_klinis1_idx` (`idkategori_klinis`);

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
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`NIP`);

--
-- Indexes for table `pemilik`
--
ALTER TABLE `pemilik`
  ADD PRIMARY KEY (`idpemilik`),
  ADD KEY `fk_pemilik_user1_idx` (`iduser`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`idpet`),
  ADD KEY `fk_pet_pemilik1_idx` (`idpemilik`),
  ADD KEY `fk_pet_ras_hewan1_idx` (`idras_hewan`);

--
-- Indexes for table `proyek`
--
ALTER TABLE `proyek`
  ADD PRIMARY KEY (`id_proyek`);

--
-- Indexes for table `ras_hewan`
--
ALTER TABLE `ras_hewan`
  ADD PRIMARY KEY (`idras_hewan`),
  ADD KEY `fk_ras_hewan_jenis_hewan1_idx` (`idjenis_hewan`);

--
-- Indexes for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`idrekam_medis`),
  ADD KEY `fk_rekam_medis_role_user1_idx` (`dokter_pemeriksa`),
  ADD KEY `fk_rekam_temu_idx` (`idreservasi_dokter`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idrole`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`idrole_user`),
  ADD KEY `fk_role_user_user_idx` (`iduser`),
  ADD KEY `fk_role_user_role1_idx` (`idrole`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `temu_dokter`
--
ALTER TABLE `temu_dokter`
  ADD PRIMARY KEY (`idreservasi_dokter`),
  ADD KEY `fk_temu_dokter_pet_idx` (`idpet`),
  ADD KEY `fk_temu_dokter_role_user_idx` (`idrole_user`);

--
-- Indexes for table `todo_list`
--
ALTER TABLE `todo_list`
  ADD KEY `fk_pegawai` (`NIP`),
  ADD KEY `fk_proyek` (`id_proyek`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT for table `detail_rekam_medis`
--
ALTER TABLE `detail_rekam_medis`
  MODIFY `iddetail_rekam_medis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_hewan`
--
ALTER TABLE `jenis_hewan`
  MODIFY `idjenis_hewan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kategori_klinis`
--
ALTER TABLE `kategori_klinis`
  MODIFY `idkategori_klinis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kode_tindakan_terapi`
--
ALTER TABLE `kode_tindakan_terapi`
  MODIFY `idkode_tindakan_terapi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pemilik`
--
ALTER TABLE `pemilik`
  MODIFY `idpemilik` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `idpet` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ras_hewan`
--
ALTER TABLE `ras_hewan`
  MODIFY `idras_hewan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `idrekam_medis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `idrole` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `idrole_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `temu_dokter`
--
ALTER TABLE `temu_dokter`
  MODIFY `idreservasi_dokter` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_rekam_medis`
--
ALTER TABLE `detail_rekam_medis`
  ADD CONSTRAINT `detail_rekam_medis_ibfk_1` FOREIGN KEY (`idkode_tindakan_terapi`) REFERENCES `kode_tindakan_terapi` (`idkode_tindakan_terapi`),
  ADD CONSTRAINT `fk_detail_rekam_medis_rekam_medis1` FOREIGN KEY (`idrekam_medis`) REFERENCES `rekam_medis` (`idrekam_medis`);

--
-- Constraints for table `kode_tindakan_terapi`
--
ALTER TABLE `kode_tindakan_terapi`
  ADD CONSTRAINT `fk_kode_tindakan_terapi_kategori_klinis1` FOREIGN KEY (`idkategori_klinis`) REFERENCES `kategori_klinis` (`idkategori_klinis`);

--
-- Constraints for table `pemilik`
--
ALTER TABLE `pemilik`
  ADD CONSTRAINT `fk_pemilik_user1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`);

--
-- Constraints for table `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `fk_pet_pemilik1` FOREIGN KEY (`idpemilik`) REFERENCES `pemilik` (`idpemilik`),
  ADD CONSTRAINT `fk_pet_ras_hewan1` FOREIGN KEY (`idras_hewan`) REFERENCES `ras_hewan` (`idras_hewan`);

--
-- Constraints for table `ras_hewan`
--
ALTER TABLE `ras_hewan`
  ADD CONSTRAINT `fk_ras_hewan_jenis_hewan1` FOREIGN KEY (`idjenis_hewan`) REFERENCES `jenis_hewan` (`idjenis_hewan`);

--
-- Constraints for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `fk_rekam_temu` FOREIGN KEY (`idreservasi_dokter`) REFERENCES `temu_dokter` (`idreservasi_dokter`),
  ADD CONSTRAINT `rekam_medis_ibfk_1` FOREIGN KEY (`dokter_pemeriksa`) REFERENCES `role_user` (`idrole_user`);

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `fk_role_user_role1` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`),
  ADD CONSTRAINT `fk_role_user_user` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`);

--
-- Constraints for table `temu_dokter`
--
ALTER TABLE `temu_dokter`
  ADD CONSTRAINT `fk_temu_dokter_pet` FOREIGN KEY (`idpet`) REFERENCES `pet` (`idpet`),
  ADD CONSTRAINT `fk_temu_dokter_role_user` FOREIGN KEY (`idrole_user`) REFERENCES `role_user` (`idrole_user`);

--
-- Constraints for table `todo_list`
--
ALTER TABLE `todo_list`
  ADD CONSTRAINT `fk_pegawai` FOREIGN KEY (`NIP`) REFERENCES `pegawai` (`NIP`),
  ADD CONSTRAINT `fk_proyek` FOREIGN KEY (`id_proyek`) REFERENCES `proyek` (`id_proyek`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
