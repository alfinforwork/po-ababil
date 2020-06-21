-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2020 at 12:40 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ababil`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `password`) VALUES
(24, 'admin@gmail.com', '$2y$10$0x.95qLj9Br66CEOfAkbQe5C0tKoL0hHDKVMgUtnl6yH4UF8E.ZGa');

-- --------------------------------------------------------

--
-- Table structure for table `alamat`
--

CREATE TABLE `alamat` (
  `id_alamat` bigint(20) NOT NULL,
  `nama_lokasi` varchar(50) NOT NULL,
  `remove` tinyint(2) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alamat`
--

INSERT INTO `alamat` (`id_alamat`, `nama_lokasi`, `remove`, `created_at`) VALUES
(3, 'bekasi', 1, '2020-06-01 06:07:37'),
(4, 'jakarta', 1, '2020-06-01 06:07:56'),
(5, 'jogja', 1, '2020-06-01 06:08:05'),
(6, 'solo', 1, '2020-06-01 06:08:12');

-- --------------------------------------------------------

--
-- Table structure for table `biaya`
--

CREATE TABLE `biaya` (
  `id_biaya` bigint(20) NOT NULL,
  `id_lokasi_dari` bigint(20) DEFAULT NULL,
  `id_lokasi_ke` bigint(20) DEFAULT NULL,
  `biaya` bigint(20) DEFAULT NULL,
  `remove` bigint(20) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `biaya`
--

INSERT INTO `biaya` (`id_biaya`, `id_lokasi_dari`, `id_lokasi_ke`, `biaya`, `remove`, `created_at`, `updated_at`) VALUES
(12, 3, 4, 1000000000000, 1, '2020-06-01 08:55:57', '2020-06-01 12:57:06'),
(13, 5, 6, 213421, 1, '2020-06-01 08:56:06', '2020-06-20 12:01:58'),
(14, 5, 3, 21324, 1, '2020-06-01 12:26:06', '2020-06-20 12:01:59'),
(15, 4, 6, 214234, 1, '2020-06-01 12:26:16', '2020-06-20 12:01:59'),
(17, 5, 4, 1000000000000, 1, '2020-06-01 13:10:44', '2020-06-20 12:02:00');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(10) NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_baca_admin` int(11) NOT NULL DEFAULT 1,
  `is_baca_user` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `username`, `created_at`, `is_baca_admin`, `is_baca_user`) VALUES
(9, 'admin', '2020-04-06 12:52:11', 1, 1),
(67, 'alfinforwork', '2020-06-20 13:52:34', 0, 1),
(68, 'pelanggan', '2020-05-05 13:17:14', 1, 0),
(69, '', '2020-06-20 12:49:23', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chat_detail`
--

CREATE TABLE `chat_detail` (
  `id_chat_detail` int(11) NOT NULL,
  `id_chat_from` varchar(50) NOT NULL,
  `id_chat_to` varchar(50) NOT NULL,
  `chat` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(10) NOT NULL,
  `jam` varchar(50) DEFAULT NULL,
  `ket_jadwal` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `jam`, `ket_jadwal`) VALUES
(8, '08.00', 'Berangkat setiap senin s/d jum\'at pagi'),
(9, '17.00', 'Berangkat setiap senin s/d jum\'at sore');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_sopir` int(11) DEFAULT NULL,
  `id_mobil` int(11) DEFAULT NULL,
  `latitude` varchar(200) DEFAULT NULL,
  `longitude` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_sopir`, `id_mobil`, `latitude`, `longitude`) VALUES
(8, 0, '-7.150975', '110.14025934999'),
(9, 0, '-7.150975', '110.14025939999999'),
(10, 40, '-7.5360639', '112.2384017');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int(10) NOT NULL,
  `nopol` varchar(50) DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `ket_mobil` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `nopol`, `merk`, `ket_mobil`) VALUES
(39, 'G 1001 AB', 'Toyota Hi Ace', 'Hitam th 2005'),
(40, 'G 1002 AB', 'Toyota Hi Ace', 'Hitam th 2006');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id_reset` int(11) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `key` varchar(250) DEFAULT NULL,
  `expired` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(10) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `pelanggan` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `tmp_lahir` varchar(200) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` varchar(250) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `is_online` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `avatar`, `pelanggan`, `email`, `password`, `tmp_lahir`, `tgl_lahir`, `alamat`, `hp`, `is_online`) VALUES
(21, 'pop 1.png', 'pelanggan', 'pelanggan@gmail.com', '$2y$10$hXNFSb4U3UwlpEMEKKSjpOtiEuw8VanutwtcMhg0nQdmPpgQHaYju', 'pekalongan', '2020-03-03', 'bojong', '08222223333', 1),
(22, NULL, 'aku', 'aku@gmail.com', '$2y$10$hXNFSb4U3UwlpEMEKKSjpOtiEuw8VanutwtcMhg0nQdmPpgQHaYju', 'batang', '2020-03-09', 'sumurjomblangbogo', '088888888888', 0),
(23, NULL, 'alfinforwork', 'alfinforwork@gmail.com', '$2y$10$hXNFSb4U3UwlpEMEKKSjpOtiEuw8VanutwtcMhg0nQdmPpgQHaYju', 'mbuh', '2020-04-21', 'raruh', '982932892', 0),
(24, NULL, 'Jono', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(25, NULL, 'Mamat', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(26, NULL, 'Eza', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(27, NULL, 'Elfa', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(28, NULL, 'meymey', NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `kd_pemesanan` int(11) NOT NULL,
  `tgl_berangkat` date DEFAULT NULL,
  `jml_tiket` int(11) DEFAULT NULL,
  `no_kursi` varchar(50) DEFAULT NULL,
  `id_biaya` int(20) DEFAULT NULL,
  `alamat_lengkap_dari` varchar(250) DEFAULT NULL,
  `alamat_lengkap_ke` varchar(250) DEFAULT NULL,
  `bukti_transfer` varchar(250) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `waktu` varchar(50) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `expired` int(11) DEFAULT 1,
  `dibuat_tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`kd_pemesanan`, `tgl_berangkat`, `jml_tiket`, `no_kursi`, `id_biaya`, `alamat_lengkap_dari`, `alamat_lengkap_ke`, `bukti_transfer`, `status`, `waktu`, `id_pelanggan`, `expired`, `dibuat_tanggal`) VALUES
(61, '2020-06-21', 4, '1,2,3,4,', 15, 'bekasi timur', 'bekasi', 'bukti_transfer/8dcca41917d2bac60bfeeda335941ca8.jpg', 'sudah dibayar', 'pagi', 21, 1, '2020-06-20 14:04:51');

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `id_pesan` int(11) NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `hp` varchar(200) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `waktu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `id_rekening` int(10) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `norek` varchar(100) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`id_rekening`, `nama`, `norek`, `bank`) VALUES
(15, 'PO ABABIL', '12345', 'BRI');

-- --------------------------------------------------------

--
-- Table structure for table `sopir`
--

CREATE TABLE `sopir` (
  `id_sopir` int(10) NOT NULL,
  `sopir` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `alamat` varchar(250) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `sopir`
--

INSERT INTO `sopir` (`id_sopir`, `sopir`, `email`, `password`, `alamat`, `hp`) VALUES
(10, 'supir', 'supir@gmail.com', '$2y$10$WDwrV0nx69hNDFMGJwb3wevAcRMy.JNQn3Hzi7ZDofxJLoS5l1.1y', 'Jogja', '098763222111');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(25) CHARACTER SET latin1 NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `loginDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `email`, `loginDate`) VALUES
('admin', 'ababil.transs@gmail.com', '2020-04-06 12:50:00'),
('ogik', 'ababil.transs@gmail.com', '2020-04-06 13:02:53'),
('pelanggan', 'pelanggan@gmail.com', '2020-04-06 13:42:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id_alamat`);

--
-- Indexes for table `biaya`
--
ALTER TABLE `biaya`
  ADD PRIMARY KEY (`id_biaya`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_detail`
--
ALTER TABLE `chat_detail`
  ADD PRIMARY KEY (`id_chat_detail`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id_reset`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`kd_pemesanan`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id_rekening`);

--
-- Indexes for table `sopir`
--
ALTER TABLE `sopir`
  ADD PRIMARY KEY (`id_sopir`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id_alamat` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `biaya`
--
ALTER TABLE `biaya`
  MODIFY `id_biaya` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `chat_detail`
--
ALTER TABLE `chat_detail`
  MODIFY `id_chat_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id_reset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `kd_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id_rekening` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sopir`
--
ALTER TABLE `sopir`
  MODIFY `id_sopir` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
