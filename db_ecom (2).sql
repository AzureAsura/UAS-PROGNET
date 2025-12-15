-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 09, 2025 at 01:59 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id_order_item` int(11) NOT NULL,
  `id_order` int(200) NOT NULL,
  `id_produk` int(200) NOT NULL,
  `qty` int(200) NOT NULL,
  `harga` int(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id_order_item`, `id_order`, `id_produk`, `qty`, `harga`, `created_at`) VALUES
(8, 4, 4, 2, 25000000, '2025-12-09 06:59:32'),
(9, 4, 6, 1, 16499000, '2025-12-09 06:59:32'),
(10, 5, 6, 1, 16499000, '2025-12-09 07:23:04'),
(11, 6, 7, 1, 17249000, '2025-12-09 09:48:49'),
(12, 7, 6, 1, 16499000, '2025-12-09 10:40:54'),
(13, 7, 7, 3, 17249000, '2025-12-09 10:40:54'),
(14, 8, 6, 2, 16499000, '2025-12-09 12:24:45'),
(15, 8, 7, 2, 17249000, '2025-12-09 12:24:45'),
(16, 10, 4, 3, 25000000, '2025-12-09 12:52:03'),
(17, 10, 6, 1, 16499000, '2025-12-09 12:52:03'),
(18, 11, 6, 1, 16499000, '2025-12-09 12:53:09');

-- --------------------------------------------------------

--
-- Table structure for table `tb_carts`
--

CREATE TABLE `tb_carts` (
  `id_cart` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `prod_qty` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_carts`
--

INSERT INTO `tb_carts` (`id_cart`, `id_user`, `id_produk`, `prod_qty`, `created_at`) VALUES
(43, 4, 6, 2, '2025-12-09 11:09:03'),
(48, 3, 6, 2, '2025-12-09 12:27:54'),
(49, 3, 7, 1, '2025-12-09 12:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `deskripsi` mediumtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `popularitas` tinyint(4) NOT NULL DEFAULT 0,
  `gambar` varchar(200) NOT NULL,
  `meta_title` varchar(200) NOT NULL,
  `meta_description` mediumtext NOT NULL,
  `meta_keywords` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori`, `slug`, `deskripsi`, `status`, `popularitas`, `gambar`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`) VALUES
(17, 'Macbook', 'macbook', 'Ultra-thin, fast performance', 0, 1, '1764916507.png', 'Macbook', 'Ultra-thin, fast performance', 'Mac', '2025-12-05 06:35:07'),
(18, 'Iphone', 'Iphone', 'Fast, smooth, reliable device', 0, 1, '1764916605.png', 'Iphone', 'Fast, smooth, reliable device', 'Iphone', '2025-12-05 06:36:45'),
(19, 'Ipad', 'ipad', 'Portable creative work device', 0, 1, '1764916999.png', 'Ipad', 'Portable creative work device', 'Ipad', '2025-12-05 06:43:19'),
(20, 'Apple Watch', 'Apple Watch', 'Smart, stylish, powerful', 0, 1, '1765093857.avif', 'Apple Watch', 'Smart, stylish, powerful', 'Apple Watch', '2025-12-07 07:47:56'),
(21, 'Airpods', 'Airpods', 'Premium sound, ultimate focus', 0, 1, '1765093754.webp', 'Airpods', 'Premium sound, ultimate focus', 'Airpods', '2025-12-07 07:49:14'),
(22, 'Aksesoris', 'Aksesoris', 'Crafted for seamless use.', 0, 1, '1765094145.webp', 'Aksesoris', 'Crafted for seamless use.', 'Aksesoris', '2025-12-07 07:55:45');

-- --------------------------------------------------------

--
-- Table structure for table `tb_orders`
--

CREATE TABLE `tb_orders` (
  `id_order` int(11) NOT NULL,
  `no_tracking` varchar(200) NOT NULL,
  `id_user` int(200) NOT NULL,
  `nama_user` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `no_telp` varchar(200) NOT NULL,
  `alamat` mediumtext NOT NULL,
  `pincode` int(200) NOT NULL,
  `total_harga` int(200) NOT NULL,
  `payment_mode` varchar(200) NOT NULL,
  `id_payment` varchar(200) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `comments` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_orders`
--

INSERT INTO `tb_orders` (`id_order`, `no_tracking`, `id_user`, `nama_user`, `email`, `no_telp`, `alamat`, `pincode`, `total_harga`, `payment_mode`, `id_payment`, `status`, `comments`, `created_at`) VALUES
(4, 'aldyne7873727378382', 4, 'aldin', 'muhamadaldin@gmail.com', '09727378382', 'timor', 30494, 66499000, 'COD', '', 0, NULL, '2025-12-09 06:59:32'),
(5, '7818988444', 4, 'aldin', 'muhamadaldin@gmail.com', '03988444', 'timor', 30494, 16499000, 'COD', '', 0, NULL, '2025-12-09 07:23:04'),
(6, '886473837382', 4, 'suraz', 'paramasuraqutay@gmail.com', '0873837382', 'sidakarya', 2838822, 17249000, 'COD', '', 2, NULL, '2025-12-09 09:48:49'),
(7, '9174988444', 3, 'anjing', 'muhamadaldin@gmail.com', '03988444', 'anxcssxsx', 30494, 68246000, 'COD', '', 0, NULL, '2025-12-09 10:40:54'),
(8, '7516988444', 3, 'e', 'paramasuraqutay@gmail.com', '03988444', 'timor', 233, 67496000, 'COD', '', 0, NULL, '2025-12-09 12:24:45'),
(9, 'ORD20251209605', 8, 'babi', 'paramasuraqutay@gmail.com', '03988444', 'njknjnjnsa', 30494, 91499000, 'COD', NULL, 0, NULL, '2025-12-09 12:50:54'),
(10, 'ORD20251209213', 8, 'babi', 'paramasuraqutay@gmail.com', '03988444', 'njknjnjnsa', 30494, 91499000, 'COD', NULL, 0, NULL, '2025-12-09 12:52:03'),
(11, 'ORD20251209552', 8, 'anjing', 'muhamadaldin@gmail.com', '03988444', 'eee', 30494, 16499000, 'COD', NULL, 0, NULL, '2025-12-09 12:53:09');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `headline` mediumtext NOT NULL,
  `deskripsi` mediumtext NOT NULL,
  `harga_asli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `gambar` text NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `popularitas` tinyint(4) NOT NULL,
  `meta_title` varchar(200) NOT NULL,
  `meta_description` mediumtext NOT NULL,
  `meta_keywords` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id_produk`, `nama_produk`, `slug`, `headline`, `deskripsi`, `harga_asli`, `harga_jual`, `gambar`, `id_kategori`, `qty`, `status`, `popularitas`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`) VALUES
(4, '14-inch MacBook Pro M4', '14-inch-MacBook-Pro-M4', 'BERTENAGA SUPER BERKAT M4 ', 'MacBook Pro 14 inci dengan chip M4 menghadirkan performa spektakuler dalam laptop super bertenaga. Pro dari segala sisi, dengan kekuatan baterai hingga 24 jam serta layar Liquid Retina XDR yang menawan dengan kecerahan puncak hingga 1.600 nit.', 26499000, 25000000, '1765086978.webp', 17, 37, 0, 1, '14-inch MacBook Pro M4', 'MacBook Pro 14 inci dengan chip M4 menghadirkan performa spektakuler dalam laptop super bertenaga. Pro dari segala sisi, dengan kekuatan baterai hingga 24 jam serta layar Liquid Retina XDR yang menawan dengan kecerahan puncak hingga 1.600 nit.', '14-inch MacBook Pro M4', '2025-12-07 05:56:18'),
(6, 'iPhone 16 Pro', 'iPhone-16-Pro', 'Super cepat. Super pintar. Mulai dari Rp 17.499.000', 'iPhone 16 Pro. Dengan desain titanium yang memukau. Kontrol Kamera. Dolby Vision 4K 120 fps. Dan chip A18 Pro.', 17499000, 16499000, '1765116711.png', 18, 69, 0, 1, 'iPhone 16 Pro', 'iPhone 16 Pro. Dengan desain titanium yang memukau. Kontrol Kamera. Dolby Vision 4K 120 fps. Dan chip A18 Pro.', 'iPhone 16 Pro', '2025-12-07 14:11:51'),
(7, 'iPhone 17', 'iPhone-17', 'Keajaiban warna.\r\nMulai dari Rp 17.249.000', 'iPhone 17. Makin menyenangkan. Makin tahan lama. Layar ProMotion 6,3 inci,1 Ceramic Shield 2, semua kamera belakang 48 MP, kamera depan Center Stage, chip A19, dan banyak lagi.', 18249000, 17249000, '1765187628.webp', 18, 49, 0, 0, 'iPhone 17', 'iPhone 17. Makin menyenangkan. Makin tahan lama. Layar ProMotion 6,3 inci,1 Ceramic Shield 2, semua kamera belakang 48 MP, kamera depan Center Stage, chip A19, dan banyak lagi.', 'iPhone 17', '2025-12-08 09:53:48');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_user`, `email`, `no_telp`, `password`, `role`, `created_at`) VALUES
(3, 'Kei Uzuki', 'muhamadaldin@gmail.com', '38884844', 'test', 0, '2025-11-25 13:25:29'),
(4, 'Sura', 'paramasuraqutay@gmail.com', '087784078923', 'TESTTEST', 1, '2025-11-27 08:55:03'),
(5, 'ronni', 'roni@gmail.com', '2939844', 'lol', 0, '2025-11-27 10:40:32'),
(6, 'krisna', 'krisna@gmail.com', '028383929', 'tes', 0, '2025-11-27 11:03:50'),
(7, 'telorgoreng', 'telor@gmail.com', '9837883', '$2y$10$DZ7Sp8dQNL35b1LMuTuaAOfUnpbB0XLKV/3hM/fm4EMVb1c9/aG9a', 0, '2025-12-09 07:37:02'),
(8, 'zz', 'haha@gmail.com', '0293993', '$2y$10$ck2AWVvIufIfWDFHXnAE3usdScekSa/idFjboOHHvekdJ5gG3g4b6', 1, '2025-12-09 07:40:13'),
(9, 'E', 'anjing@gmail.com', '343', '$2y$10$Ca.iaWIE65J4Dn/t1SLlD.rclqMMxxAzHZr/cdmIp1.EyGeL7S1U2', 0, '2025-12-09 07:45:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id_order_item`);

--
-- Indexes for table `tb_carts`
--
ALTER TABLE `tb_carts`
  ADD PRIMARY KEY (`id_cart`);

--
-- Indexes for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tb_orders`
--
ALTER TABLE `tb_orders`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id_order_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_carts`
--
ALTER TABLE `tb_carts`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tb_orders`
--
ALTER TABLE `tb_orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
