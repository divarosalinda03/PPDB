-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jun 2025 pada 20.19
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
-- Database: `ppdb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_seleksi`
--

CREATE TABLE `hasil_seleksi` (
  `id_hasil` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_wali` int(11) DEFAULT NULL,
  `status_pendaftaran` varchar(20) DEFAULT NULL,
  `keterangan_seleksi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_seleksi`
--

INSERT INTO `hasil_seleksi` (`id_hasil`, `id_siswa`, `id_wali`, `status_pendaftaran`, `keterangan_seleksi`) VALUES
(1, 1, 4, 'Diterima', 'Lolos seleksi berkas'),
(2, 2, 5, 'Diterima', 'Lolos seleksi berkas'),
(3, 3, 6, 'Diterima', 'Lolos seleksi berkas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nama_pegawai` varchar(100) DEFAULT NULL,
  `username_pegawai` varchar(50) DEFAULT NULL,
  `password_pegawai` varchar(100) DEFAULT NULL,
  `role_pegawai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama_pegawai`, `username_pegawai`, `password_pegawai`, `role_pegawai`) VALUES
(1, 'dzaki', 'dzaki', '123456', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_biaya` int(11) DEFAULT NULL,
  `id_wali` int(11) DEFAULT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `nominal_dibayar` decimal(10,2) DEFAULT NULL,
  `status_pembayaran` varchar(20) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `keterangan_pembayaran` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rincian_biaya`
--

CREATE TABLE `rincian_biaya` (
  `id_biaya` int(11) NOT NULL,
  `nama_biaya` varchar(100) DEFAULT NULL,
  `tipe_biaya` varchar(50) DEFAULT NULL,
  `nominal_biaya` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rincian_biaya`
--

INSERT INTO `rincian_biaya` (`id_biaya`, `nama_biaya`, `tipe_biaya`, `nominal_biaya`) VALUES
(1, 'Biaya Pendaftaran', 'Sekali', 550000.00),
(2, 'Seragam', 'Sekali', 250000.00),
(3, 'Buku', 'Sekali', 100000.00),
(4, 'SPP Bulanan', 'Bulanan', 100000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `id_wali` int(11) DEFAULT NULL,
  `id_sekolah` int(11) DEFAULT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `nik_siswa` varchar(20) NOT NULL,
  `jenis_kelamin_siswa` varchar(10) DEFAULT NULL,
  `umur_siswa` int(11) DEFAULT NULL,
  `alamat_siswa` text DEFAULT NULL,
  `akta_kelahiran_siswa` varchar(100) DEFAULT NULL,
  `kk_siswa` varchar(100) DEFAULT NULL,
  `foto_siswa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `id_wali`, `id_sekolah`, `nama_siswa`, `nik_siswa`, `jenis_kelamin_siswa`, `umur_siswa`, `alamat_siswa`, `akta_kelahiran_siswa`, `kk_siswa`, `foto_siswa`) VALUES
(1, 4, NULL, '123123sfdsfd', '2131', 'Laki-laki', 324, 'fsdsdf', '../uploads/Screenshot 2025-01-13 201802.png', '../uploads/Screenshot 2025-01-13 201943.png', ''),
(2, 5, NULL, 'dzaki', '213333333333333333', 'Laki-laki', 12, 'dsad', '../uploads/Screenshot 2025-01-13 201802.png', '../uploads/Screenshot 2025-01-13 201802.png', ''),
(3, 6, NULL, 'dzaki', '213333333333333333', 'Laki-laki', 24, 'sda', '../uploads/Screenshot 2025-01-13 201802.png', '../uploads/Screenshot 2025-01-13 201802.png', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id_biaya` int(11) NOT NULL,
  `id_wali` int(11) DEFAULT NULL,
  `bulan_tagihan` varchar(20) DEFAULT NULL,
  `status_tagihan` varchar(20) DEFAULT NULL,
  `nominal_tagihan` decimal(10,2) DEFAULT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id_biaya`, `id_wali`, `bulan_tagihan`, `status_tagihan`, `nominal_tagihan`, `tanggal_jatuh_tempo`) VALUES
(1, 3, '2025-03', 'Belum Lunas', 150000.00, '2025-06-03'),
(3, 5, '2025-03', 'Belum Lunas', 100000.00, '2025-06-10'),
(4, 1, 'juni 2025', 'Belum Lunas', 1000000.00, '2025-06-10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wali_siswa`
--

CREATE TABLE `wali_siswa` (
  `id_wali` int(11) NOT NULL,
  `nama_wali` varchar(100) NOT NULL,
  `nik_wali` varchar(20) NOT NULL,
  `hubungan_wali` varchar(50) DEFAULT NULL,
  `jenis_kelamin_wali` varchar(10) DEFAULT NULL,
  `alamat_wali` text DEFAULT NULL,
  `username_login` varchar(50) DEFAULT NULL,
  `password_login` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `wali_siswa`
--

INSERT INTO `wali_siswa` (`id_wali`, `nama_wali`, `nik_wali`, `hubungan_wali`, `jenis_kelamin_wali`, `alamat_wali`, `username_login`, `password_login`) VALUES
(1, 'nasuha', '1231321', 'asda', 'Laki-laki', 'asda', 'asdsa', '$2y$10$LhQHyufxcsZQYTFA5oxKFO/Ka7eCTx1PaiMPUdCtgUqs.rV9v8BNC'),
(3, 'nasuha', '1231321', 'asda', 'Laki-laki', 'asda', 'asdsagh', '$2y$10$raz6e3Nr9.HfwbkdiBsCruJbGzv9zAoGuMAWb.7trFQriEKhQqeb6'),
(4, 'nasuha', '2131231', 'sfhdfgd', 'Laki-laki', 'fdssfdssf', '2131231', '$2y$10$aegdmfU7XH6tt3LbjEESceKnBC4zk/ONDw15jHJW9cmUcrM5uB14m'),
(5, 'dzaki', '123456', 'anak', 'Laki-laki', 'bgd', 'fikri', '$2y$10$1VPxNzhl1vZrhp9Oo.tJ3OglXk4abrFTjIH8i0l/8FnzJsTRYrEUi'),
(6, 'dzaki', '123456', 'asda', 'Laki-laki', 'df', NULL, '$2y$10$MDV8chSkkKOTwuPnB3qr6.pU5.5gaIlclyA6qkuMslF7UsK4kVfP2'),
(7, 'dzaki', '1234', NULL, 'Laki-laki', 'bandung', 'dzaki', '$2y$10$SsaDUluyujLCOuTkZTcSP.RgvyYj4mDo11Bz8a2Iptu3bZHvnMa5K');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `hasil_seleksi`
--
ALTER TABLE `hasil_seleksi`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_wali` (`id_wali`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD UNIQUE KEY `username_pegawai` (`username_pegawai`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_biaya` (`id_biaya`),
  ADD KEY `id_wali` (`id_wali`);

--
-- Indeks untuk tabel `rincian_biaya`
--
ALTER TABLE `rincian_biaya`
  ADD PRIMARY KEY (`id_biaya`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `id_wali` (`id_wali`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_biaya`),
  ADD KEY `id_wali` (`id_wali`);

--
-- Indeks untuk tabel `wali_siswa`
--
ALTER TABLE `wali_siswa`
  ADD PRIMARY KEY (`id_wali`),
  ADD UNIQUE KEY `username_login` (`username_login`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `hasil_seleksi`
--
ALTER TABLE `hasil_seleksi`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rincian_biaya`
--
ALTER TABLE `rincian_biaya`
  MODIFY `id_biaya` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id_biaya` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `wali_siswa`
--
ALTER TABLE `wali_siswa`
  MODIFY `id_wali` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `hasil_seleksi`
--
ALTER TABLE `hasil_seleksi`
  ADD CONSTRAINT `hasil_seleksi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `hasil_seleksi_ibfk_2` FOREIGN KEY (`id_wali`) REFERENCES `wali_siswa` (`id_wali`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_biaya`) REFERENCES `tagihan` (`id_biaya`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_wali`) REFERENCES `wali_siswa` (`id_wali`);

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_wali`) REFERENCES `wali_siswa` (`id_wali`);

--
-- Ketidakleluasaan untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`id_wali`) REFERENCES `wali_siswa` (`id_wali`),
  ADD CONSTRAINT `tagihan_ibfk_2` FOREIGN KEY (`id_biaya`) REFERENCES `rincian_biaya` (`id_biaya`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
