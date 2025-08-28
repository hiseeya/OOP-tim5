-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Agu 2025 pada 03.38
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
-- Database: `expedition_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `city_distances`
--

CREATE TABLE `city_distances` (
  `id` int(11) NOT NULL,
  `origin` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `distance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `city_distances`
--

INSERT INTO `city_distances` (`id`, `origin`, `destination`, `distance`) VALUES
(1, 'Jakarta', 'Surabaya', 780.00),
(2, 'Surabaya', 'Jakarta', 780.00),
(3, 'Jakarta', 'Bandung', 150.00),
(4, 'Bandung', 'Jakarta', 150.00),
(5, 'Surabaya', 'Bandung', 670.00),
(6, 'Bandung', 'Surabaya', 670.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `base_price`, `image`) VALUES
(1, 'Instant', 'Pengiriman cepat dalam 1-2 jam', 50000.00, 'images/instant.png'),
(2, 'Regular', 'Pengiriman standar dalam 1-2 hari', 20000.00, 'images/regular.png'),
(3, 'Distance Based', 'Harga berdasarkan jarak per kilometer', 5000.00, 'images/distance.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `distance` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `route` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `service_id`, `customer_name`, `distance`, `total_price`, `route`, `created_at`) VALUES
(1, 1, 'kevin', 670.00, 50000.00, 'Surabaya → Bandung', '2025-08-28 01:31:18'),
(2, 3, 'koko', 45.00, 225000.00, NULL, '2025-08-28 01:32:08'),
(3, 3, 'koko', 45.00, 225000.00, NULL, '2025-08-28 01:32:43'),
(4, 3, 'koko', 45.00, 225000.00, NULL, '2025-08-28 01:32:46'),
(5, 2, 'jojo', 780.00, 20000.00, 'Jakarta → Surabaya', '2025-08-28 01:33:10'),
(6, 2, 'fulan', 150.00, 20000.00, 'Jakarta → Bandung', '2025-08-28 01:37:00'),
(7, 2, 'fulan', 150.00, 20000.00, 'Jakarta → Bandung', '2025-08-28 01:37:04');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `city_distances`
--
ALTER TABLE `city_distances`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `city_distances`
--
ALTER TABLE `city_distances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
