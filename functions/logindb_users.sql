-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 01, 2020 at 08:31 AM
-- Server version: 5.7.18-16
-- PHP Version: 7.0.22

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT
= 0;
START TRANSACTION;
SET time_zone
= "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users`
(
  `user_id` int
(11) NOT NULL,
  `username` varchar
(255) NOT NULL,
  `email` varchar
(255) NOT NULL,
  `password` varchar
(255) NOT NULL,
  `first_name` varchar
(255) NOT NULL,
  `last_name` varchar
(255) NOT NULL,
  `validation_code` text NOT NULL,
  `active` tinyint
(4) NOT NULL DEFAULT '0',
  `reset_code` int
(255) NOT NULL,
  `remember` varchar
(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--
-- clear password is 1111
INSERT INTO `users` (`
user_id`,
`username
`, `email`, `password`, `first_name`, `last_name`, `validation_code`, `active`, `reset_code`, `remember`) VALUES
(01, 'admin', 'admin@gmail.com', '$2y$10$XbYIhZVT/zyuKAnl/JfTreAY.dpzc2hvrGDm8P0shDlktlQlVQOPu', 'Joe', 'Shmoe', '20d135f0f28185b84a4cf7aa51f29500', 1, 986887852, '8981a85e1ea7ed40e60be389705c9ecb');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY
(`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int
(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
