-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 12, 2025 at 07:52 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tabungan_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int NOT NULL,
  `nama_kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`) VALUES
(1, 'A'),
(2, 'B');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` int NOT NULL,
  `nama_petugas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','operator') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `nama_petugas`, `username`, `password`, `role`, `foto`) VALUES
(1, 'John Doe', 'john', '$2y$10$rPMFkhInBkGIclP1rLEXFOOJvskM8iKty7X//631glxsEjBTBoUni', 'admin', ''),
(2, 'Hana Hanifah', 'hana', '$2y$10$UGomjzwjqLnH.cE9qs.cNOIThmg1cuVXXjAt/M2rTpiPfrTrrEE6G', 'operator', ''),
(4, 'Bella', 'Bella', '$2y$10$Xb60is07KTCvxQDadsvHE.mxMBDOpFp3S3MmwWfVUjj7EmbJK.nkC', 'operator', '');

-- --------------------------------------------------------

--
-- Table structure for table `rekening_tabungan`
--

CREATE TABLE `rekening_tabungan` (
  `id` int NOT NULL,
  `id_rekening` varchar(100) NOT NULL,
  `id_siswa` int NOT NULL,
  `saldo` decimal(15,0) NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rekening_tabungan`
--

INSERT INTO `rekening_tabungan` (`id`, `id_rekening`, `id_siswa`, `saldo`, `status`) VALUES
(2, 'REK-0001', 21, 50000, 'Aktif'),
(3, 'REK-0002', 23, 30000, 'Aktif'),
(4, 'REK-0003', 24, 0, 'Aktif'),
(5, 'REK-0004', 26, 80000, 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `sekolah`
--

CREATE TABLE `sekolah` (
  `id` int NOT NULL,
  `nama_sekolah` varchar(100) NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `akreditasi` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sekolah`
--

INSERT INTO `sekolah` (`id`, `nama_sekolah`, `alamat`, `akreditasi`) VALUES
(1, 'RA Jihadul Akbar', 'Jl Raya Cipeundeuy RT 10 RW 03 Desa Cipeundeuy Kec Cipeundeuy Kab Subang', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `id_kelas` int NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `th_masuk` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nama`, `jenis_kelamin`, `id_kelas`, `alamat`, `no_telp`, `th_masuk`) VALUES
(21, '3213200001', 'Mike', 'L', 2, 'Jl Raya Cipeundeuy Kec Cipeundeuy - Subang', '0987797937249', '2024'),
(23, '320001', 'Amanda', 'P', 1, 'Jl Raya Pabuaran - Subang', '087968567098', '2024'),
(24, '4343242', 'Andre', 'L', 2, 'Tanggerang', '089777666555', '2023'),
(26, '32444555', 'Bella', 'P', 1, 'Jl Raya CIpeundeuy - Sadang ', '087779999000', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_tabungan`
--

CREATE TABLE `transaksi_tabungan` (
  `id` int NOT NULL,
  `id_rekening` varchar(100) NOT NULL,
  `id_siswa` int NOT NULL,
  `id_petugas` int NOT NULL,
  `tanggal_transaksi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jenis_transaksi` enum('Setor','Tarik') NOT NULL,
  `jumlah` decimal(15,0) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi_tabungan`
--

INSERT INTO `transaksi_tabungan` (`id`, `id_rekening`, `id_siswa`, `id_petugas`, `tanggal_transaksi`, `jenis_transaksi`, `jumlah`, `keterangan`) VALUES
(12, 'REK-0001', 21, 1, '2025-02-12 02:51:33', 'Setor', 50000, 'Setor Uang'),
(13, 'REK-0002', 23, 1, '2025-02-12 02:51:48', 'Setor', 30000, 'Setor Uang'),
(14, 'REK-0004', 26, 1, '2025-02-12 02:52:06', 'Setor', 100000, 'Setor Uang'),
(15, 'REK-0004', 26, 1, '2025-02-12 02:52:25', 'Tarik', 20000, 'Tarik Uang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rekening_tabungan`
--
ALTER TABLE `rekening_tabungan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_rekening` (`id_rekening`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `transaksi_tabungan`
--
ALTER TABLE `transaksi_tabungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rekening` (`id_rekening`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rekening_tabungan`
--
ALTER TABLE `rekening_tabungan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `transaksi_tabungan`
--
ALTER TABLE `transaksi_tabungan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rekening_tabungan`
--
ALTER TABLE `rekening_tabungan`
  ADD CONSTRAINT `rekening_tabungan_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_tabungan`
--
ALTER TABLE `transaksi_tabungan`
  ADD CONSTRAINT `transaksi_tabungan_ibfk_1` FOREIGN KEY (`id_rekening`) REFERENCES `rekening_tabungan` (`id_rekening`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_tabungan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
