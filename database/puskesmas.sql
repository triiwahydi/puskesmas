-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 15 Mar 2024 pada 20.03
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `puskesmas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian`
--

CREATE TABLE `antrian` (
  `id` bigint UNSIGNED NOT NULL,
  `kartu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `antrian`
--

INSERT INTO `antrian` (`id`, `kartu`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, '12345678', '2024-02-04 11:18:44', '2024-02-04 12:12:42', '2024-02-04 12:12:42'),
(4, '123456789', '2024-02-04 11:26:16', '2024-02-04 11:26:16', NULL),
(5, '12345677', '2024-02-04 11:47:02', '2024-02-04 11:47:02', NULL),
(6, '12345678', '2024-02-22 14:18:20', '2024-02-22 14:18:20', NULL),
(7, '12345678', '2024-02-22 15:54:30', '2024-02-22 15:54:30', NULL),
(8, '12345678', '2024-02-27 14:37:17', '2024-02-27 14:37:17', NULL),
(9, '123456789', '2024-02-27 14:37:27', '2024-02-27 14:37:27', NULL),
(10, '12345677', '2024-02-27 15:21:19', '2024-02-27 15:21:19', NULL),
(11, '12345678', '2024-03-02 11:49:31', '2024-03-02 11:49:31', NULL),
(12, '123456789', '2024-03-02 12:59:39', '2024-03-02 12:59:39', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(8, '2023_12_16_121646_create_cuti_table', 2),
(10, '2024_02_04_095605_create_antrian_table', 3),
(11, '2024_02_04_201740_create_model_pelayanans_table', 4),
(12, '2024_02_04_223842_create_model_antrian_dokters_table', 5),
(13, '2024_02_22_201740_create_model_pelayanans_dokter_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id` int NOT NULL,
  `pemeriksaan_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `obat` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id`, `pemeriksaan_id`, `pasien_id`, `obat`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 12, 11, 'panadol', '2024-03-02 12:56:03', '2024-03-02 12:56:03', NULL),
(2, 13, 12, 'paracetamol, sirup', '2024-03-02 13:30:42', '2024-03-02 13:30:42', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` bigint UNSIGNED NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bpjs` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hp` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kartu` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `nik`, `bpjs`, `nama`, `tgl_lahir`, `hp`, `alamat`, `kartu`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, '3328120812000001', '12345678', 'Ego Winasis', '2000-12-08', '089694589275', 'Jalan Projosumarto 1 Rt: 014/ Rw: 003 , Desa Kaladawa, Kecamatan Talang', '123456789', '2024-02-03 23:30:40', '2024-02-04 00:25:29', '2024-02-04 00:25:29'),
(11, '3328120812000001', '12345678', 'Ego Winasis', '2000-12-08', '089694589275', 'Jalan Projosumarto 1 Rt: 014/ Rw: 003 , Desa Kaladawa, Kecamatan Talang', '12345678', '2024-02-04 00:30:16', '2024-02-04 00:30:16', NULL),
(12, '3328120812000002', '123456789', 'Luluatun Khasanah', '2024-02-06', '089694589276', 'Getaskerep', '123456789', '2024-02-04 03:11:55', '2024-02-04 03:11:55', NULL),
(13, '3328120812000005', '123456788', 'Retno Intan Lestari', '2024-02-06', '0896945892', 'Desa Kertayasa, Kecamatan Kramat', '12345677', '2024-02-04 11:46:43', '2024-02-04 11:46:43', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelayanan`
--

CREATE TABLE `pelayanan` (
  `id` bigint UNSIGNED NOT NULL,
  `pasien_id` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `antrian_id` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keluhan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pelayanan`
--

INSERT INTO `pelayanan` (`id`, `pasien_id`, `antrian_id`, `tujuan`, `keluhan`, `catatan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, '12', '4', 'Dokter Umum', 'Panas', 'Aaa', '2024-02-04 14:22:26', '2024-02-04 14:22:26', NULL),
(3, '13', '5', 'Dokter Gigi', 'Sakit gigi', '', '2024-02-04 14:25:37', '2024-02-04 14:25:37', NULL),
(4, '11', '6', 'Dokter Umum', 'Panas', '', '2024-02-22 14:18:52', '2024-02-22 14:18:52', NULL),
(5, '11', '7', 'Dokter Umum', 'Sakit gigi', 'Aaa', '2024-02-22 15:54:41', '2024-02-22 15:54:41', NULL),
(6, '11', '8', 'Dokter Umum', 'Panas', 'Aaa', '2024-02-27 14:37:53', '2024-02-27 14:37:53', NULL),
(7, '12', '9', 'Dokter Umum', 'Panas', 'Aaa', '2024-02-27 14:38:03', '2024-02-27 14:38:03', NULL),
(8, '11', '11', 'Dokter Umum', 'Panas', 'Aaa', '2024-03-02 11:49:43', '2024-03-02 11:49:43', NULL),
(9, '12', '12', 'Dokter Umum', 'A', 'A', '2024-03-02 13:27:20', '2024-03-02 13:27:20', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaan`
--

CREATE TABLE `pemeriksaan` (
  `id` bigint UNSIGNED NOT NULL,
  `pasien_id` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelayanan_id` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keluhan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnosa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `obat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pemeriksaan`
--

INSERT INTO `pemeriksaan` (`id`, `pasien_id`, `pelayanan_id`, `tujuan`, `keluhan`, `catatan`, `diagnosa`, `obat`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, '11', '4', 'Dokter Umum', 'Panas', '', '', '', '2024-02-22 16:10:17', '2024-02-22 16:10:17', NULL),
(9, '11', '5', 'Dokter Umum', 'Sakit gigi', 'Aaa', '', '', '2024-02-22 16:13:22', '2024-02-22 16:13:22', NULL),
(10, '11', '6', 'Dokter Umum', 'Panas', 'Aaa', 'aa', 'aa', '2024-02-27 14:38:33', '2024-02-27 14:59:42', NULL),
(11, '12', '7', 'Dokter Umum', 'Panas', 'Aaa', '', '', '2024-02-27 15:08:42', '2024-02-27 15:08:42', NULL),
(12, '11', '8', 'Dokter Umum', 'Panas', 'Aaa', 'panas, pusing', 'obat panas', '2024-03-02 11:50:21', '2024-03-02 11:50:53', NULL),
(13, '12', '9', 'Dokter Umum', 'A', 'A', 'panas', 'paracetamol', '2024-03-02 13:28:39', '2024-03-02 13:29:04', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','dokter','apoteker','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `bagian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `pangkat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user.png',
  `isActive` int NOT NULL DEFAULT '0',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nip`, `name`, `email`, `email_verified_at`, `password`, `role`, `bagian`, `pangkat`, `jabatan`, `image`, `isActive`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, '12345678', 'Tri Wahyudi P', 'triwahyudiamungkas@gmail.com', NULL, '$2y$12$bPUt9L1jwcLPNEyxKBxEkexKiqsJO57LJf4UpzVqEau/7JXQnr/5i', 'admin', 'Pelayanan Umum', 'IIC', 'Admin Pelayanan Umum', '65d75747c50cf.jpg', 1, NULL, '2024-01-14 16:38:19', '2024-02-22 14:16:40', NULL),
(7, '12345678', 'Ego Winasis', 'egowinasis22@gmail.com', NULL, '$2y$12$F/TJ2N7J7GdNyc5IX2maOuc3A0/nVg6yq9rO5tiVwdNyQ55c24Qzy', 'dokter', 'Dokter', 'IIC', 'Dokter Umum', '65bfaccb7068f.jpg', 1, NULL, '2024-01-14 16:57:20', '2024-03-15 20:03:02', NULL),
(8, '112346', 'Retno Intan', 'retno@gmail.com', NULL, '$2y$12$Ce/NmH9m0uwefVFxHWjqZeS4hRZ4BmkrRIzCojka6d7KzXFug3wTy', 'apoteker', 'Apoteker', 'IIC', 'Apoteker', '65e315edd2b7a.jpg', 1, NULL, '2024-01-14 17:10:37', '2024-03-15 20:01:31', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pelayanan`
--
ALTER TABLE `pelayanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `pelayanan`
--
ALTER TABLE `pelayanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
