-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jan 2026 pada 05.00
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbraport_istifafakha`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_istifafakha`
--

CREATE TABLE `absensi_istifafakha` (
  `id_absen` int(11) NOT NULL,
  `nis` varchar(15) NOT NULL,
  `sakit` int(3) DEFAULT 0,
  `izin` int(3) DEFAULT 0,
  `alfa` int(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi_istifafakha`
--

INSERT INTO `absensi_istifafakha` (`id_absen`, `nis`, `sakit`, `izin`, `alfa`) VALUES
(1, '1', 2, 1, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru_istifafakha`
--

CREATE TABLE `guru_istifafakha` (
  `id_guru` varchar(15) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru_istifafakha`
--

INSERT INTO `guru_istifafakha` (`id_guru`, `nip`, `nama_guru`, `no_telp`) VALUES
('1', '001', 'Fauzi Irwana', '7876'),
('2', '002', 'Dirgahayu Dwi Saputra', '3544'),
('3', '003', 'Rahma Khoyrul Hawa', '78987'),
('4', '004', 'Fahri Hadi T.OnGs', '5567');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_istifafakha`
--

CREATE TABLE `kelas_istifafakha` (
  `id_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(20) NOT NULL,
  `id_guru` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas_istifafakha`
--

INSERT INTO `kelas_istifafakha` (`id_kelas`, `nama_kelas`, `id_guru`) VALUES
('1', 'X RPL A', '1'),
('2', 'X RPL B', '2'),
('3', 'XI RPL A', '3'),
('4', 'XI RPL B', '4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel_istifafaka`
--

CREATE TABLE `mapel_istifafaka` (
  `id_mapel` varchar(10) NOT NULL,
  `nama_mapel` varchar(50) NOT NULL,
  `kkm` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mapel_istifafaka`
--

INSERT INTO `mapel_istifafaka` (`id_mapel`, `nama_mapel`, `kkm`) VALUES
('1', 'Matematika', 80),
('2', 'Bahasa Indonesia', 80),
('3', 'Bahasa Inggris', 80),
('4', 'PAI', 85),
('5', 'IPA', 80),
('6', 'PPKn', 80);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_istifafakha`
--

CREATE TABLE `nilai_istifafakha` (
  `id_nilai` varchar(11) NOT NULL,
  `nis` varchar(15) NOT NULL,
  `id_mapel` varchar(10) NOT NULL,
  `nilai_tugas` int(3) DEFAULT NULL,
  `nilai_uts` int(3) DEFAULT NULL,
  `nilai_uas` int(3) DEFAULT NULL,
  `nilai_akhir` decimal(5,2) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai_istifafakha`
--

INSERT INTO `nilai_istifafakha` (`id_nilai`, `nis`, `id_mapel`, `nilai_tugas`, `nilai_uts`, `nilai_uas`, `nilai_akhir`, `deskripsi`, `semester`, `tahun_ajaran`) VALUES
('N001', '2', '3', 90, 89, 98, 93.70, 'tau', 'Ganjil', '2024/2025'),
('N002', '1', '1', 100, 90, 100, 97.00, 'HAHAHA', 'Ganjil', '2025/2026'),
('N003', '3', '4', 98, 89, 90, 91.30, 'y', 'Genap', '2025/2026'),
('N004', '4', '1', 89, 98, 87, 90.70, 'gg', 'Ganjil', '2024/2025'),
('N005', '1', '6', 90, 89, 90, 89.70, 'well', 'Genap', '2023/2024'),
('N006', '2', '3', 89, 58, 98, 81.67, 'kamu keren', 'Ganjil', '2025/2026'),
('N007', '5', '1', 78, 76, 65, 73.00, 'hjh', 'Genap', '2025/2026'),
('N008', '6', '3', 80, 56, 78, 71.33, 'g', 'Ganjil', '2025/2026'),
('N009', '7', '2', 89, 87, 67, 81.00, 'jh', 'Genap', '2024/2025');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa_istifafakha`
--

CREATE TABLE `siswa_istifafakha` (
  `nis` varchar(15) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `id_kelas` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa_istifafakha`
--

INSERT INTO `siswa_istifafakha` (`nis`, `nama`, `tempat_lahir`, `tgl_lahir`, `alamat`, `id_kelas`) VALUES
('1', 'Revita Gadis Amijaya', 'Bandung', '2009-04-15', 'Cisarua No.90', '4'),
('2', 'Muhammad Ezra', 'Cimahi', '2008-03-14', 'Cibaligo NO.89', '2'),
('3', 'Dean Petra', 'Cimahi', '2008-04-18', 'Tegal Kawung NO.77', '3'),
('4', 'Rafasya Atthaulah', 'Bandung', '2008-01-16', 'Padalarang NO.54', '4'),
('5', 'Novri Krisna', 'Cimahi', '2008-11-03', 'Sangkurr', '2'),
('6', 'Alfin Bathosan', 'Cimahi', '2006-07-14', 'sakngur', '3'),
('7', 'Yunifa Rizky', 'Cimahi', '2008-11-13', 's', '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_istifafakha`
--

CREATE TABLE `users_istifafakha` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','walikelas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users_istifafakha`
--

INSERT INTO `users_istifafakha` (`id`, `username`, `password`, `role`) VALUES
(1, 'istifafakha', 'istifa45', 'admin'),
(2, 'fauzi', 'uzi33', 'walikelas'),
(3, 'Dirga', 'ddirga5', 'walikelas'),
(4, 'Rahma', 'rhm98', 'walikelas'),
(5, 'Fahri', 'hadirfa4', 'walikelas');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi_istifafakha`
--
ALTER TABLE `absensi_istifafakha`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `nis` (`nis`);

--
-- Indeks untuk tabel `guru_istifafakha`
--
ALTER TABLE `guru_istifafakha`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `kelas_istifafakha`
--
ALTER TABLE `kelas_istifafakha`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `mapel_istifafaka`
--
ALTER TABLE `mapel_istifafaka`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `nilai_istifafakha`
--
ALTER TABLE `nilai_istifafakha`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `nis` (`nis`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indeks untuk tabel `siswa_istifafakha`
--
ALTER TABLE `siswa_istifafakha`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `users_istifafakha`
--
ALTER TABLE `users_istifafakha`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi_istifafakha`
--
ALTER TABLE `absensi_istifafakha`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users_istifafakha`
--
ALTER TABLE `users_istifafakha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi_istifafakha`
--
ALTER TABLE `absensi_istifafakha`
  ADD CONSTRAINT `absensi_istifafakha_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_istifafakha` (`nis`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas_istifafakha`
--
ALTER TABLE `kelas_istifafakha`
  ADD CONSTRAINT `kelas_istifafakha_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru_istifafakha` (`id_guru`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_istifafakha`
--
ALTER TABLE `nilai_istifafakha`
  ADD CONSTRAINT `nilai_istifafakha_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_istifafakha` (`nis`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_istifafakha_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel_istifafaka` (`id_mapel`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa_istifafakha`
--
ALTER TABLE `siswa_istifafakha`
  ADD CONSTRAINT `siswa_istifafakha_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas_istifafakha` (`id_kelas`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
