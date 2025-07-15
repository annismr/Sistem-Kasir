-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2025 at 02:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `detailpesanan`
--

CREATE TABLE `detailpesanan` (
  `id_detailpesanan` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailpesanan`
--

INSERT INTO `detailpesanan` (`id_detailpesanan`, `id_pesanan`, `id_produk`, `qty`) VALUES
(1, 1, 9, 2),
(3, 1, 8, 1),
(5, 9, 9, 1),
(6, 9, 14, 2),
(7, 9, 19, 1),
(8, 1, 20, 1),
(9, 10, 8, 1),
(10, 10, 10, 1),
(11, 11, 12, 1),
(12, 11, 18, 2),
(13, 11, 10, 1),
(14, 11, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kasirr`
--

CREATE TABLE `kasirr` (
  `id_kasir` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `level` varchar(10) NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kasirr`
--

INSERT INTO `kasirr` (`id_kasir`, `nama`, `email`, `telepon`, `alamat`, `username`, `level`, `id_user`) VALUES
(2, 'Annisa MR', 'tokosamsung164@gmail.com', '085156040391', 'Jakarta Barat, DKI Jakarta, Indonesia', 'annismr', 'admin', 2),
(3, 'Jamal', 'jamal14@gmail.com', '0812345678', 'Jl. jalan dulu N0. 127', 'jamalgans', 'kasir', 1);

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `periode` date NOT NULL,
  `total_transaksi` int(11) NOT NULL,
  `total_pendapatan` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `id_masuk` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `tanggalmasuk` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`id_masuk`, `id_produk`, `qty`, `tanggalmasuk`) VALUES
(1, 11, 4, '2024-12-30 15:35:16'),
(2, 8, 3, '2024-12-30 15:36:15');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `namapelanggan` varchar(50) NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `namapelanggan`, `notelp`, `alamat`) VALUES
(1, 'Nisa', '0897654321', 'Jakarta Barat, DKI Jakarta'),
(2, 'Meki', '08123456789', 'Indonesia'),
(3, 'Iqbal', '0856418965', 'Kp. Koang'),
(4, 'Bibah', '08976123465', 'Taman Sari, Jakarta Barat, DKI Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_pelanggan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `tanggal`, `id_pelanggan`) VALUES
(1, '2024-12-26 05:13:43', 1),
(9, '2024-12-28 08:31:33', 2),
(10, '2025-01-01 06:58:18', 3),
(11, '2025-01-10 06:10:23', 4);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `warna` varchar(50) NOT NULL,
  `ukuran` varchar(10) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar_produk` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produkk`
--

CREATE TABLE `produkk` (
  `id_produk` int(11) NOT NULL,
  `namaproduk` varchar(30) NOT NULL,
  `deskripsi` varchar(30) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `image` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produkk`
--

INSERT INTO `produkk` (`id_produk`, `namaproduk`, `deskripsi`, `harga`, `stok`, `image`) VALUES
(8, 'Baju Koko', 'Atasan Anak Laki-laki', 70000, 4, 'a3e2769f78bc4bbde8b85179b8ea40d5'),
(9, 'Rok Span', 'Bawahan Anak Perempuan', 45000, 2, 'c6b45451ceb744d3ae281dd78e853545'),
(10, 'Dress Bunga Bunga', 'Atasan Anak Perempuan', 65000, 4, '89008c1edc4d806c3e7b19d009f71f25'),
(11, 'Baju Labubu', 'Setelan Anak Perempuan', 55000, 5, 'b99b259884e9ef93c736ce48f78e4109'),
(12, 'Celana Cutbray', 'Bawahan Anak Perempuan', 35000, 3, '635300f79102507678e3478349ccae80'),
(13, 'Kaos Anak Laki-laki', 'Atasan Anak Laki-laki', 43000, 4, 'ba0eb2958b379b7930e0448d33058add'),
(14, 'Celana Anak Laki-laki', 'Bawahan Anak Laki-laki', 27000, 4, '319899358f717bb808de97b77a1172b0'),
(15, 'Baju Setelan Pilot', 'Setelan Anak Laki-laki', 43500, 3, '41214fe70d1c3b4c177af0d8302d3dd9'),
(16, 'Celana Dalam Micky Mouse', 'Daleman Anak Perempuan', 15000, 15, '4ba1a2d9acfffd6220da6fd183b25cb9'),
(17, 'Celana Dalam Thomas', 'Dalaman Anak Laki-laki', 15000, 13, '23f0c9373bb2767d22190aae3c788eac'),
(18, 'Jepitan', 'Aksesoris Anak Perempuan', 8000, 5, '86f10fa6545b477afab16920e0383476'),
(19, 'Topi Boboiboy', 'Aksesoris Anak Laki-laki', 25000, 5, 'ce5fa2b8295b1d8c4f845d84412bd557'),
(20, 'Sandal Selop', 'Sandal Anak Perempuan', 30000, 5, '42838ad3a5b4e40c5298a56126460c78'),
(21, 'Sandal Gunung', 'Sandal Anak Laki-laki', 55000, 5, 'ba96dcb4ba38471677bc40dc338ef533');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `namatoko` varchar(30) NOT NULL,
  `alamattoko` text NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `email` varchar(20) NOT NULL,
  `pemilik` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`namatoko`, `alamattoko`, `telepon`, `email`, `pemilik`) VALUES
('Kid Chic', 'Fashion Avenue, Jalan Sudirman No. 25, Jakarta Pusat, DKI Jakarta, Indonesia', '08567894321', 'tokosamsung164@gmail', 'Annisa MR');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `metode_bayar` enum('tunai','e-wallet') NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`) VALUES
(1, 'jamalgans', 'kasir', 'kasir'),
(2, 'admin', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detailpesanan`
--
ALTER TABLE `detailpesanan`
  ADD PRIMARY KEY (`id_detailpesanan`);

--
-- Indexes for table `kasirr`
--
ALTER TABLE `kasirr`
  ADD PRIMARY KEY (`id_kasir`),
  ADD KEY `fk_id_user` (`id_user`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`id_masuk`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `produkk`
--
ALTER TABLE `produkk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detailpesanan`
--
ALTER TABLE `detailpesanan`
  MODIFY `id_detailpesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kasirr`
--
ALTER TABLE `kasirr`
  MODIFY `id_kasir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produkk`
--
ALTER TABLE `produkk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kasirr`
--
ALTER TABLE `kasirr`
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
