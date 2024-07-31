-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 09:41 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbjai`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id_absen` int(10) UNSIGNED NOT NULL,
  `id_manager` int(11) DEFAULT NULL,
  `id_hr` int(11) DEFAULT NULL,
  `id_spv` int(11) DEFAULT NULL,
  `nip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_departemen` int(11) NOT NULL,
  `jns_absen` enum('Sakit','Izin','Izin Khusus','Cuti','Cuti Melahirkan','Cuti Haid','Izin Terlambat Datang','Izin Cepat Pulang','Izin Keluar Sementara','Dinas Luar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_absen` date NOT NULL,
  `tgl_absen_akhir` date DEFAULT NULL,
  `ket` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_persetujuan_spv` datetime DEFAULT NULL,
  `tgl_persetujuan_manager` datetime DEFAULT NULL,
  `status_pengajuan` enum('Diproses','Pending','Diterima','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensis`
--

INSERT INTO `absensis` (`id_absen`, `id_manager`, `id_hr`, `id_spv`, `nip`, `nama`, `id_departemen`, `jns_absen`, `tgl_absen`, `tgl_absen_akhir`, `ket`, `tgl_persetujuan_spv`, `tgl_persetujuan_manager`, `status_pengajuan`, `created_at`, `updated_at`) VALUES
(2, NULL, NULL, 110204, '110205', 'Wildansyah', 1, 'Izin', '2024-08-01', NULL, 'Acara Keluarga', '2024-07-31 11:24:27', NULL, 'Diterima', '2024-07-31 04:18:11', '2024-07-31 04:24:45'),
(4, 110202, NULL, NULL, '110204', 'Rizki', 1, 'Cuti', '2024-08-01', NULL, 'Cuti Tahunan', NULL, '2024-07-31 12:12:38', 'Diterima', '2024-07-31 05:12:26', '2024-07-31 05:12:51');

-- --------------------------------------------------------

--
-- Table structure for table `departemens`
--

CREATE TABLE `departemens` (
  `id_departemen` int(10) UNSIGNED NOT NULL,
  `nm_dept` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departemens`
--

INSERT INTO `departemens` (`id_departemen`, `nm_dept`, `created_at`, `updated_at`) VALUES
(1, 'PGA', '2024-07-31 04:02:22', '2024-07-31 04:02:22'),
(2, 'IT', '2024-07-31 04:32:26', '2024-07-31 04:32:26');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatans`
--

CREATE TABLE `jabatans` (
  `id_jabatan` int(10) UNSIGNED NOT NULL,
  `nm_jabatan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatans`
--

INSERT INTO `jabatans` (`id_jabatan`, `nm_jabatan`, `created_at`, `updated_at`) VALUES
(1, 'Manager', '2024-07-31 04:02:22', '2024-07-31 04:02:22'),
(2, 'HR', '2024-07-31 04:02:22', '2024-07-31 04:02:22'),
(3, 'SPV', '2024-07-31 04:02:22', '2024-07-31 04:02:22'),
(4, 'Staff', '2024-07-31 04:02:22', '2024-07-31 04:02:22'),
(5, 'Admin HR', '2024-07-31 04:02:22', '2024-07-31 04:02:22');

-- --------------------------------------------------------

--
-- Table structure for table `karyawans`
--

CREATE TABLE `karyawans` (
  `id_karyawan` int(10) UNSIGNED NOT NULL,
  `nip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_departemen` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `tempat_lahir` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `role` enum('SuperAdmin','Admin','Manager','SPV','Staff') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawans`
--

INSERT INTO `karyawans` (`id_karyawan`, `nip`, `username`, `password`, `nama`, `id_departemen`, `id_jabatan`, `tempat_lahir`, `tanggal_lahir`, `role`, `jenis_kelamin`, `created_at`, `updated_at`) VALUES
(1, '110202', 'Firdaus', '$2y$12$ij3wvPl2Iu5gnvK9KlmeW.5C2wpipTC8hOwJB6uAnJCZggrALC9lG', 'Firdaus', 1, 1, 'Nganjuk', '2024-07-31', 'SuperAdmin', 'Laki-laki', '2024-07-31 04:02:20', '2024-07-31 04:02:20'),
(2, '110203', 'Zubaidah', '$2y$12$lI25AaRnQLjQJJnEeM/ghuhiYOdRiQcU7ZdMX.qJHwY3n8se2Nsoa', 'Zubaidah', 1, 2, 'Malang', '2024-07-31', 'Admin', 'Perempuan', '2024-07-31 04:02:20', '2024-07-31 04:02:20'),
(3, '110204', 'Rizki', '$2y$12$s7307y0w/PvQfOPq8WFGXeMdbV4M1iYhPXZ24O3VnHCd2SNrnf28W', 'Rizki', 1, 3, 'Madiun', '2024-07-31', 'SPV', 'Laki-laki', '2024-07-31 04:02:21', '2024-07-31 04:02:21'),
(4, '110205', 'Wildansyah', '$2y$12$Sc1Ho2nBPVAI95SR5fFQ4uD1WN3PI5Zbl/xVyPfG8k2cluPI9.a2q', 'Wildansyah', 1, 4, 'Magetan', '2024-07-31', 'Staff', 'Laki-laki', '2024-07-31 04:02:21', '2024-07-31 04:02:21'),
(5, '110206', 'Aisyah', '$2y$12$10zjDKFhfScunNpeB3Z1l.0qUVgPCVxFVo4T.kglvh5fliDR.zohy', 'Aisyah', 1, 4, 'Surabaya', '2024-07-31', 'Staff', 'Perempuan', '2024-07-31 04:02:21', '2024-07-31 04:02:21'),
(6, '110207', 'Imelda', '$2y$12$BUm4y/oobJ0Pl9z26tIVZOXNhtx2.Kk7bLKgnC8alxd1xoqlwsum.', 'Imelda', 1, 5, 'Pasuruan', '2024-07-31', 'Admin', 'Perempuan', '2024-07-31 04:02:22', '2024-07-31 04:02:22'),
(7, '112233', 'Ahmad', '$2y$12$gwE5WkzBLrdUt0bK0Xbz4uVCdlJtwZt.aV8iw9y9xwPal32lIBY3e', 'Ahmad', 2, 1, 'Ngawi', '2002-07-05', 'Manager', 'Laki-laki', '2024-07-31 04:33:24', '2024-07-31 04:33:24'),
(8, '223344', 'Siti', '$2y$12$WdwQg5jusdP6XLdssru/m.hK3nDG2gxwMfZa8SWOWWv3nFT6EGnZS', 'Siti', 2, 2, 'Ponorogo', '1999-07-01', 'Manager', 'Perempuan', '2024-07-31 04:34:10', '2024-07-31 04:45:01'),
(9, '334455', 'Zubaida', '$2y$12$r3o7QAFL4MJ6bW5CR7F4iO/.YGVWQ2MTnRs1jpB.jxaIasNQ0OrzO', 'Zubaida', 2, 4, 'Ponorogo', '2000-07-06', 'Staff', 'Perempuan', '2024-07-31 04:35:01', '2024-07-31 04:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2024_02_12_114428_create_karyawans_table', 1),
(11, '2024_02_12_121454_create_absensis_table', 1),
(12, '2024_02_12_122908_create_overtimes_table', 1),
(13, '2024_03_01_090723_create_departemens_table', 1),
(14, '2024_03_01_091049_create_jabatans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `overtimes`
--

CREATE TABLE `overtimes` (
  `id_ovt` int(10) UNSIGNED NOT NULL,
  `id_manager` int(11) DEFAULT NULL,
  `id_hr` int(11) DEFAULT NULL,
  `id_spv` int(11) DEFAULT NULL,
  `nip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_departemen` int(11) NOT NULL,
  `tgl_ovt` date NOT NULL,
  `jam_awal` time NOT NULL,
  `jam_akhir` time NOT NULL,
  `ket` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_persetujuan_spv` datetime DEFAULT NULL,
  `tgl_persetujuan_manager` datetime DEFAULT NULL,
  `status_pengajuan` enum('Diproses','Pending','Diterima','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `overtimes`
--

INSERT INTO `overtimes` (`id_ovt`, `id_manager`, `id_hr`, `id_spv`, `nip`, `nama`, `id_departemen`, `tgl_ovt`, `jam_awal`, `jam_akhir`, `ket`, `tgl_persetujuan_spv`, `tgl_persetujuan_manager`, `status_pengajuan`, `created_at`, `updated_at`) VALUES
(1, NULL, 110203, 110204, '110205', 'Wildansyah', 1, '2024-08-02', '12:00:00', '16:00:00', 'Lembur harian', '2024-07-31 13:44:18', NULL, 'Diterima', '2024-07-31 06:25:52', '2024-07-31 07:07:50');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indexes for table `departemens`
--
ALTER TABLE `departemens`
  ADD PRIMARY KEY (`id_departemen`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jabatans`
--
ALTER TABLE `jabatans`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `karyawans`
--
ALTER TABLE `karyawans`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtimes`
--
ALTER TABLE `overtimes`
  ADD PRIMARY KEY (`id_ovt`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id_absen` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departemens`
--
ALTER TABLE `departemens`
  MODIFY `id_departemen` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatans`
--
ALTER TABLE `jabatans`
  MODIFY `id_jabatan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `karyawans`
--
ALTER TABLE `karyawans`
  MODIFY `id_karyawan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `overtimes`
--
ALTER TABLE `overtimes`
  MODIFY `id_ovt` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
