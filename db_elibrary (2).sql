-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jul 2025 pada 09.56
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
-- Database: `db_elibrary`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `no_telp`, `email`, `username`, `password`) VALUES
('ADM002', 'ADMIN11', '081122234566', 'julius@gmail.com', 'ADMIN', 'caesar117'),
('[ADM001]', '[Anthoni]', '[081122334455]', '[tonijc@gmail.com]', '[tonijulius]', '[$2y$10$RkKf5o2VHy0yZVNi6oeWRemMK268JkOkThSNoijlvjGtKUqDETNou]');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_buku`
--

CREATE TABLE `data_buku` (
  `id_buku` varchar(10) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `judul` varchar(200) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `sinopsis` text DEFAULT NULL,
  `link_file` text NOT NULL,
  `status_buku` enum('tersedia','dipinjam','sedang_dibaca') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_buku`
--

INSERT INTO `data_buku` (`id_buku`, `isbn`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `kategori`, `sinopsis`, `link_file`, `status_buku`) VALUES
('BK001', '978-623-228-221-6', 'Web Programming', 'Ani Oktarini Sari, Ari Abdilah, Sunarti', 'Graha Ilmu', 2019, 'Pemrograman', 'Buku Web Programing belajar mengenai dasar-dasar pemrograman\r\nweb disusun untuk keperluan mahasiswa atau siapapun yang ingin belajar\r\nmengenai dasar-dasar pemrograman web. Pada buku ini berisi bagaimana\r\ndapat membuat membuat website dan belajar dasar-dasar pemrograman\r\nweb dengan mudah, praktis dan cepat disertakan contoh latihan-latihan', 'Buku/BK001.pdf', 'tersedia'),
('BK002', '978-602-6635-66-2', 'Pengantar Ilmu Hukum', 'Yuhelson', 'Ideas Publishing', 2017, 'Hukum', 'pengantar ilmu hukum', 'Buku/BK002.pdf', 'tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `katalog_buku`
--

CREATE TABLE `katalog_buku` (
  `id` int(11) NOT NULL,
  `id_buku` varchar(10) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `katalog_buku`
--

INSERT INTO `katalog_buku` (`id`, `id_buku`, `judul`, `kategori`, `gambar`, `tanggal_input`) VALUES
(2, 'BK001', 'Web Programming', 'Pemrograman', 'webprogramming.png', '2025-06-26 20:51:44'),
(3, 'BK002', 'Pengantar Ilmu Hukum', 'Hukum', 'pengantarilmuhukum.png', '2025-06-26 20:52:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_buku` varchar(10) NOT NULL,
  `tgl_pinjam` datetime NOT NULL,
  `tgl_kembali` datetime NOT NULL,
  `tgl_pengembalian` datetime DEFAULT NULL,
  `status_peminjaman` enum('aktif','selesai') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_pengguna`, `id_buku`, `tgl_pinjam`, `tgl_kembali`, `tgl_pengembalian`, `status_peminjaman`) VALUES
(1, 2, 'BK002', '2025-06-29 15:32:49', '2025-06-30 15:32:49', NULL, 'selesai'),
(2, 2, 'BK002', '2025-06-29 15:38:07', '2025-06-30 15:38:07', NULL, 'selesai'),
(3, 2, 'BK002', '2025-06-29 15:56:01', '2025-06-30 15:56:01', NULL, 'selesai'),
(4, 2, 'BK002', '2025-06-29 16:05:51', '2025-07-02 16:05:51', NULL, 'selesai'),
(5, 2, 'BK002', '2025-06-29 16:54:19', '2025-06-30 16:54:19', NULL, 'selesai'),
(6, 1, 'BK001', '2025-06-29 21:45:06', '2025-06-30 21:45:06', NULL, 'selesai'),
(7, 1, 'BK002', '2025-06-29 21:48:36', '2025-07-02 21:48:36', '2025-06-29 22:36:33', 'selesai'),
(8, 1, 'BK001', '2025-06-29 23:23:36', '2025-06-30 23:23:36', '2025-06-29 23:57:22', 'selesai'),
(9, 1, 'BK002', '2025-07-01 10:48:40', '2025-07-02 10:48:40', '2025-07-01 10:55:05', 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `jk` tinyint(1) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `nik`, `jk`, `alamat`, `no_telp`, `email`, `username`, `password`, `status_aktif`) VALUES
(1, 'toni julius', '123456789012345', 1, 'komplek puri anggrek', '08123456789', 'kastil@gmail.com', 'tonijulius20', '$2y$10$dQpfCE6VTXL9bs8id.Xld.NPP9MKja9ICzUXJ4JcMYkrioxOcEj0q', 1),
(2, 'Dwi Nugroho', '123123123123123', 0, 'kebon jahe', '081125449012', 'dwinugroho@gmail.com', 'dwinugroho12', '$2y$10$3W76AboMf3iQm1X1d3hbv.Th07Ts3SZ0w75g7ScmciBnF19t5xxHi', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sesi_baca`
--

CREATE TABLE `sesi_baca` (
  `id_sesi_baca` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_buku` varchar(10) NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_selesai` datetime NOT NULL,
  `waktu_selesai_manual` datetime DEFAULT NULL,
  `status` enum('aktif','selesai') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sesi_baca`
--

INSERT INTO `sesi_baca` (`id_sesi_baca`, `id_pengguna`, `id_buku`, `waktu_mulai`, `waktu_selesai`, `waktu_selesai_manual`, `status`) VALUES
(4, 2, 'BK002', '2025-06-28 17:07:56', '2025-06-29 23:07:56', '2025-06-28 12:49:18', 'selesai'),
(5, 2, 'BK002', '2025-06-28 19:01:44', '2025-06-30 01:01:44', '2025-06-28 14:02:40', 'selesai'),
(6, 2, 'BK002', '2025-06-28 19:57:25', '2025-07-01 07:57:25', '2025-06-28 14:57:53', 'selesai'),
(7, 2, 'BK001', '2025-06-28 20:41:05', '2025-06-28 21:11:05', '2025-06-28 15:41:48', 'selesai'),
(8, 2, 'BK001', '2025-06-28 20:55:28', '2025-06-28 21:25:28', '2025-06-28 20:58:09', 'selesai'),
(11, 2, 'BK002', '2025-06-28 21:25:29', '2025-06-28 21:55:29', '2025-06-28 22:05:31', 'selesai'),
(12, 2, 'BK002', '2025-06-28 22:09:39', '2025-06-28 22:14:39', '2025-06-28 22:14:39', 'selesai'),
(13, 2, 'BK001', '2025-06-28 22:21:06', '2025-06-28 22:26:06', '2025-06-28 22:26:06', 'selesai'),
(14, 2, 'BK001', '2025-06-29 13:53:43', '2025-06-29 13:58:43', '2025-06-29 13:58:43', 'selesai'),
(15, 2, 'BK002', '2025-06-29 14:19:44', '2025-06-29 14:24:44', '2025-06-29 14:24:44', 'selesai'),
(16, 2, 'BK001', '2025-06-29 14:28:35', '2025-06-29 14:33:35', '2025-06-29 14:31:29', 'selesai');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `data_buku`
--
ALTER TABLE `data_buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `katalog_buku`
--
ALTER TABLE `katalog_buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_buku` (`id_buku`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `sesi_baca`
--
ALTER TABLE `sesi_baca`
  ADD PRIMARY KEY (`id_sesi_baca`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_buku` (`id_buku`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `katalog_buku`
--
ALTER TABLE `katalog_buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `sesi_baca`
--
ALTER TABLE `sesi_baca`
  MODIFY `id_sesi_baca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `katalog_buku`
--
ALTER TABLE `katalog_buku`
  ADD CONSTRAINT `fk_id_buku` FOREIGN KEY (`id_buku`) REFERENCES `data_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `data_buku` (`id_buku`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sesi_baca`
--
ALTER TABLE `sesi_baca`
  ADD CONSTRAINT `sesi_baca_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `sesi_baca_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `data_buku` (`id_buku`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
