-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jul 2021 pada 11.15
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventori`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(5) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `username` varchar(25) NOT NULL,
  `level` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_lengkap`, `username`, `level`, `password`, `last_login`) VALUES
(1, 'Antonius Widiyanto', 'widi99', 'pemilik', '$2y$10$wH7ae0bA8.GsH5vI8FPLoOYXgmxJlvJLMawElChfZMQB401fpU9pu', '2021-07-16 15:37:00'),
(8, 'Ibnu Fathonah Yudha', 'ibnu99', 'pegawai', '$2y$10$3qLWNq9fHOGkkJwJXzb/SOqsXRn0hF0efngximsNV0LmZY0B2uJAa', '2021-07-16 15:35:37'),
(20, 'tri amin ridho', 'tri', 'pegawai', '$2y$10$jdBDGOrBOZ/26IxlKIwyNep36USCLwnt0S4sCWyzsGcrxPOsAjHva', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(5) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `stok` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `deskripsi`, `stok`) VALUES
(2, 'benih melon kuning F1 golden langkawi', 'benih melon untuk menanam', 189),
(3, 'Bibit Bunga Matahari', 'Bibit Bunga sebanyak 10 biji', 50),
(6, 'Bibit Kangkung', 'Bibit Kangkung siap tanam dan cepat panen', 10),
(8, 'Netpot 5cm', 'Tempat meletakan media tanam', 100),
(10, 'Pupuk Tanaman', 'untuk nutrisi yang dibutuhkan tanaman', 1),
(11, 'Bibit Mint', 'Bibit Mint siap tanam', 300),
(13, 'Teh daun mint', 'teh herbal dari daun mint', 1),
(16, 'Netpot 10 CM', 'Tempat untuk tanaman sayuran dan buah', 100),
(17, 'Rockwoll', 'Media Tanam Hidroponik', 15),
(18, 'netpot 10 cm', 'media tempat tanaman', 40),
(19, 'Bibit Cabai', 'Bibit cabai siap tanam dan cepat tumbuh', 500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangkeluar`
--

CREATE TABLE `barangkeluar` (
  `id_barangkeluar` int(5) NOT NULL,
  `tanggal_keluar` datetime NOT NULL DEFAULT current_timestamp(),
  `id_barang` int(5) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `harga_jual` int(9) NOT NULL,
  `total` int(9) NOT NULL,
  `id_customer` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barangkeluar`
--

INSERT INTO `barangkeluar` (`id_barangkeluar`, `tanggal_keluar`, `id_barang`, `jumlah`, `harga_jual`, `total`, `id_customer`) VALUES
(3, '2021-05-03 17:11:15', 2, 10, 5500, 55000, 1),
(5, '2021-05-06 10:16:50', 2, 3, 6000, 18000, 1),
(6, '2021-05-20 16:36:53', 2, 1, 6000, 6000, 1),
(7, '2021-05-23 11:16:31', 2, 1, 5000, 5000, 1),
(8, '2021-05-23 11:16:56', 2, 1, 5000, 5000, 1),
(9, '2021-05-23 11:21:06', 10, 4, 15000, 60000, 1),
(10, '2021-05-25 19:35:32', 13, 4, 15000, 60000, 1),
(11, '2021-06-16 18:47:06', 17, 5, 5000, 25000, 1),
(13, '2021-06-21 20:06:42', 3, 50, 5000, 250000, 1),
(14, '2021-06-25 10:49:18', 18, 50, 2000, 100000, 1),
(15, '2021-07-16 15:40:46', 19, 600, 5000, 3000000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangmasuk`
--

CREATE TABLE `barangmasuk` (
  `id_barangmasuk` int(5) NOT NULL,
  `tanggal_masuk` datetime NOT NULL DEFAULT current_timestamp(),
  `id_barang` int(5) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `harga_beli` int(9) NOT NULL,
  `total` int(9) NOT NULL,
  `id_supplier` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barangmasuk`
--

INSERT INTO `barangmasuk` (`id_barangmasuk`, `tanggal_masuk`, `id_barang`, `jumlah`, `harga_beli`, `total`, `id_supplier`) VALUES
(5, '2021-05-03 16:39:41', 2, 90, 5000, 450000, 1),
(8, '2021-05-05 15:03:43', 2, 10, 5000, 50000, 1),
(9, '2021-05-05 15:06:14', 2, 10, 5000, 50000, 1),
(10, '2021-05-05 15:06:31', 2, 90, 10000, 900000, 1),
(11, '2021-05-17 11:42:36', 3, 10, 7000, 70000, 1),
(12, '2021-05-17 11:43:30', 6, 10, 5000, 50000, 1),
(13, '2021-05-17 11:56:38', 8, 100, 150, 15000, 1),
(15, '2021-05-23 11:20:41', 10, 5, 10000, 50000, 1),
(16, '2021-05-25 19:34:47', 2, 5, 1000, 5000, 1),
(17, '2021-05-25 19:35:07', 13, 5, 10000, 50000, 1),
(18, '2021-06-05 11:45:39', 11, 100, 1000, 100000, 2),
(20, '2021-06-14 07:37:42', 16, 100, 1000, 100000, 1),
(21, '2021-06-16 18:46:28', 17, 20, 1000, 20000, 1),
(22, '2021-06-16 18:52:06', 11, 200, 1000, 200000, 1),
(23, '2021-06-21 20:05:59', 3, 90, 2000, 180000, 1),
(24, '2021-06-25 10:48:05', 18, 90, 1000, 90000, 1),
(25, '2021-07-16 15:39:54', 19, 1100, 2000, 2200000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(5) NOT NULL,
  `nama_customer` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `telp_customer` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_customer`, `nama_customer`, `alamat`, `telp_customer`) VALUES
(1, 'Citra Indah City', 'Jl. Raya Jonggol - Cileungsi No.km 23, Sukamaju, Kec. Jonggol, Bogor, Jawa Barat', '02189930606'),
(5, 'Gereja Katolik Hati Kudus Yesu', 'Jl. Citra Indah, Singasari, Kec. Jonggol, Bogor, Jawa Barat 16830', '082122267621');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(5) NOT NULL,
  `nama_supplier` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `telp_supplier` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `telp_supplier`) VALUES
(1, '18 hidroponik', 'kalimalang', '089674545891'),
(2, 'Purie Garden Jakarta', 'Jl. River Garden Boulevard No.C1-19, RW.7, Cakung Tim., Kec. Cakung, Kota Jakarta Timur.', '085790405804');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `barangkeluar`
--
ALTER TABLE `barangkeluar`
  ADD PRIMARY KEY (`id_barangkeluar`);

--
-- Indeks untuk tabel `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD PRIMARY KEY (`id_barangmasuk`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `barangkeluar`
--
ALTER TABLE `barangkeluar`
  MODIFY `id_barangkeluar` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `barangmasuk`
--
ALTER TABLE `barangmasuk`
  MODIFY `id_barangmasuk` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
