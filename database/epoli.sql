-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2024 at 05:06 PM
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
-- Database: `epoli`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `keluhan` text DEFAULT NULL,
  `no_antrian` int(11) DEFAULT NULL,
  `status_periksa` enum('Belum Diperiksa','Sudah Diperiksa') DEFAULT 'Belum Diperiksa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daftar_poli`
--

INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`, `status_periksa`) VALUES
(13, 6, 6, 'Masuk Angin', 1, 'Belum Diperiksa'),
(14, 6, 11, 'cenat cenut', 2, 'Sudah Diperiksa'),
(15, 6, 7, 'Budeg', 3, 'Sudah Diperiksa'),
(16, 3, 6, 'Preketek', 4, 'Belum Diperiksa'),
(23, 6, 6, 'Coba', 5, 'Belum Diperiksa'),
(24, 6, 6, '', 6, 'Belum Diperiksa'),
(25, 6, 7, 'Cobain', 7, 'Belum Diperiksa'),
(26, 6, 6, 'coba lagi', 8, 'Belum Diperiksa'),
(27, 8, 12, 'Saya mengalami sakit di bagian perut\r\n', 9, 'Sudah Diperiksa'),
(28, 8, 12, 'Coba1', 10, 'Sudah Diperiksa');

-- --------------------------------------------------------

--
-- Table structure for table `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` int(11) NOT NULL,
  `id_periksa` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_periksa`
--

INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`) VALUES
(1, 1, 2),
(2, 2, 2),
(3, 3, 2),
(4, 4, 1),
(7, 6, 6),
(8, 6, 8),
(9, 7, 1),
(10, 7, 5),
(11, 7, 7),
(12, 8, 1),
(13, 8, 9),
(14, 9, 1),
(15, 9, 6),
(16, 5, 3),
(17, 5, 8),
(18, 5, 2),
(19, 5, 3),
(20, 5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `id_poli` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `alamat`, `no_hp`, `id_poli`) VALUES
(6, 'Adi', 'Bekasi', '083819195000', 1),
(8, 'Aidi', 'Semarang', '081545454649', 2),
(9, 'Tedy', 'Nakula', '081001010102', 3);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status_aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`, `status_aktif`) VALUES
(6, 6, 'Senin', '08:00:00', '16:00:00', 1),
(7, 8, 'Senin', '07:00:00', '08:00:00', 1),
(11, 6, 'Rabu', '15:00:00', '16:00:00', 1),
(12, 9, 'Sabtu', '07:00:00', '15:00:00', 1),
(15, 9, 'Jumat', '08:00:00', '09:00:00', 0),
(16, 9, 'Kamis', '10:00:00', '12:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama_obat` varchar(50) NOT NULL,
  `kemasan` varchar(35) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`) VALUES
(1, 'Paracetamol', 'Tablet', 5000),
(2, 'Bodrex', 'Tablet', 15000),
(3, 'Panadol', 'Tablet', 20000),
(5, 'Ibuprofen', 'Kapsul', 3000),
(6, 'Amoxicillin', 'Suspensi', 15000),
(7, 'Cetirizine', 'Tablet', 1200),
(8, 'Promethazine', 'Sirup', 7000),
(9, 'Omeprazole', 'Tablet', 5000),
(10, 'Loratadine', 'Tablet', 1800),
(11, 'Metformin', 'Tablet', 4000),
(12, 'Amlodipine', 'Tablet', 3500),
(13, 'Simvastatin', 'Tablet', 4500);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_ktp` varchar(20) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `no_rm` char(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `alamat`, `no_ktp`, `no_hp`, `no_rm`, `created_at`) VALUES
(3, 'Adi', 'Semarang', '1234567891234567', '083819195220', '202412-002', '2024-12-20 12:40:27'),
(4, 'Gulung', 'semarang', '4294967295', '4294967295', '202412-003', '2024-12-20 12:41:16'),
(6, 'Firman', 'Semarang', '1234567890123454', '083819195221', '202412-001', '2024-12-20 12:46:06'),
(7, 'Gilang Ramadhan', 'Semarang', '1234567890123453', '0895403699944', '202412-004', '2024-12-20 12:46:34'),
(8, 'Abe', 'Semarang', '123123123123123123', '081001010102', '202412-005', '2024-12-27 11:05:28');

-- --------------------------------------------------------

--
-- Table structure for table `periksa`
--

CREATE TABLE `periksa` (
  `id` int(11) NOT NULL,
  `id_daftar_poli` int(11) NOT NULL,
  `tgl_periksa` date NOT NULL,
  `catatan` text DEFAULT NULL,
  `biaya_periksa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periksa`
--

INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`) VALUES
(1, 15, '2024-12-27', 'Dibersihin setiap hari', 165000),
(2, 15, '2024-12-27', 'Dibersihin setiap hari', 165000),
(3, 15, '2024-12-27', 'Dibersihin setiap hari', 165000),
(4, 14, '2024-12-27', 'Hati hati', 155000),
(5, 27, '2024-12-27', 'Hindari makanan Pedas dan minum obat 3 kali sehari', 192000),
(6, 27, '2024-12-28', 'Jangan makan pedes\r\n', 172000),
(7, 28, '2024-12-28', 'test', 159200),
(8, 27, '2024-12-29', 'tessss', 160000),
(9, 27, '2024-12-24', 'testtt', 170000);

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` int(11) NOT NULL,
  `nama_poli` varchar(25) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
(1, 'Poli Jantung', 'poli Jantung\r\n'),
(2, 'Poli THT', 'Poli yang menangani masalah pendengaran\r\n'),
(3, 'Poli Umum', 'Poli Umum adalah salah satu bagian dari layanan kesehatan di rumah sakit atau puskesmas yang menangani berbagai masalah kesehatan umum.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_jadwal` (`id_jadwal`);

--
-- Indexes for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_periksa` (`id_periksa`),
  ADD KEY `id_obat` (`id_obat`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indexes for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_daftar_poli` (`id_daftar_poli`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `daftar_poli_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `daftar_poli_ibfk_2` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_periksa` (`id`);

--
-- Constraints for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `detail_periksa_ibfk_1` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`),
  ADD CONSTRAINT `detail_periksa_ibfk_2` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`);

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `dokter_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id`);

--
-- Constraints for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `jadwal_periksa_ibfk_1` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Constraints for table `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `periksa_ibfk_1` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
