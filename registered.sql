-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2023 at 11:05 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `registered`
--

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` int(100) NOT NULL COMMENT '1:brekfast,2:lunch,3:snacks,4:dinner',
  `category` int(10) NOT NULL DEFAULT 1 COMMENT '1: Veg, 2: Non-Veg',
  `calories` int(11) NOT NULL,
  `recipe` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `name`, `type`, `category`, `calories`, `recipe`) VALUES
(1, 'Meal 1', 4, 1, 150, 'dsds'),
(2, 'Chocolate and Banana Kefir Smoothie', 2, 1, 600, 'dsds'),
(3, 'Chocolate and Banana Kefir Smoothie', 2, 1, 700, 'dsds'),
(4, 'Chocolate and Banana Kefir Smoothie', 2, 1, 400, 'dsds'),
(5, 'Chocolate and Banana Kefir Smoothie', 2, 1, 1500, 'dsds'),
(6, 'Atlassian', 1, 1, 200, 'doene ekjdise'),
(7, 'Chocolate and Banana Kefir Smoothie', 2, 1, 2500, 'dsds'),
(8, 'Chocolate and Banana Kefir Smoothie', 2, 1, 2000, 'dsds'),
(9, 'Chocolate and Banana Kefir Smoothie', 2, 1, 3000, 'dsds'),
(10, 'Chocolate and Banana Kefir Smoothie', 2, 1, 800, 'dsds'),
(11, 'Chocolate and Banana Kefir Smoothie', 2, 1, 300, 'dsds'),
(12, 'Chocolate and Banana Kefir Smoothie', 2, 1, 1000, 'dsds'),
(13, 'Recruiteing Head', 3, 1, 100, 'dsdssd'),
(14, 'Atlassian', 2, 1, 500, 'doene ekjdise'),
(15, 'Atlassian', 2, 1, 1000, 'doene ekjdise'),
(16, 'Meal 2', 1, 2, 400, 'Yayy'),
(17, 'Recruiteing Head 1', 3, 1, 200, 'dsdssd'),
(18, 'Recruiteing Head 2', 3, 1, 250, 'dsdssd'),
(19, 'Recruiteing Head 2', 3, 1, 300, 'dsdssd'),
(20, 'Recruiteing Head 2', 3, 1, 350, 'dsdssd'),
(21, 'Meal 1', 4, 1, 2000, 'dsds'),
(22, 'Meal 1', 4, 1, 1000, 'dsds'),
(23, 'Meal 1', 4, 1, 1500, 'dsds'),
(24, 'Meal 1', 4, 1, 2500, 'dsds'),
(25, 'Meal 1', 4, 1, 3500, 'dsds'),
(26, 'Meal 1', 4, 1, 500, 'dsds'),
(27, 'Atlassian', 1, 1, 100, 'doene ekjdise'),
(28, 'Atlassian', 1, 1, 300, 'doene ekjdise'),
(29, 'Atlassian', 1, 1, 250, 'doene ekjdise'),
(30, 'Atlassian', 1, 1, 350, 'doene ekjdise');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `gender` int(10) NOT NULL COMMENT '1:Female, 2: Male',
  `age` int(100) NOT NULL,
  `weight` int(100) NOT NULL,
  `height` int(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `gender`, `age`, `weight`, `height`, `email`, `password`, `reg_date`) VALUES
(1, 'admin', 2, 25, 70, 140, 'admin@gmail.com', '$2y$10$pTjwC523xIUbERfpSVUtG.XXOyI0yCWbMXVesTRSsjEJF5AtZ.4zm', '2023-11-01 15:27:59'),
(2, 'user1', 2, 22, 80, 166, 'user1@gmail.com', '$2y$10$ASaQkGVWaJDAG2Ay0SuSsO.cE5yrf.7kkmwTSXQWXPk2beTvhSUgG', '2023-11-03 10:51:04'),
(3, 'user2', 1, 20, 50, 122, 'user2@gmail.com', '$2y$10$wpVwqM57TccRpEehqg0l9egGmTCFktye0bHKuBBal9QwAjeCbfOYG', '2023-11-03 11:07:41'),
(4, 'user3', 2, 22, 60, 155, 'user3@gmail.com', '$2y$10$5BiiTSeYMFw2OLi97L16d.S9EDMHVmYDbjNo.wBGSkI8.O0LyujLu', '2023-11-03 22:47:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
