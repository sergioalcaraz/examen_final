-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 21, 2020 at 10:15 AM
-- Server version: 10.3.25-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examen_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `bill_date` datetime NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `bill_date`, `customer_id`, `user_id`) VALUES
(10, '2020-11-21 12:22:22', 1, 12),
(11, '2020-11-21 12:22:22', 1, 12),
(12, '2020-11-21 12:22:22', 1, 12),
(13, '2020-11-21 12:22:22', 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `bill_details`
--

CREATE TABLE `bill_details` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `part_id` int(11) DEFAULT NULL,
  `details` varchar(250) COLLATE utf8_unicode_520_ci NOT NULL,
  `amount` decimal(16,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Dumping data for table `bill_details`
--

INSERT INTO `bill_details` (`id`, `bill_id`, `part_id`, `details`, `amount`) VALUES
(8, 10, NULL, 'Mano de obra - colocar paragolpes', '100.00'),
(9, 10, 3, 'Paragolpes', '1000.00'),
(10, 10, 4, 'Faros traseros', '1400.00'),
(11, 10, NULL, 'Colocacion de faro', '200.00'),
(12, 11, NULL, 'Mano de obra - colocar paragolpes', '100.00'),
(13, 11, 3, 'Paragolpes', '1000.00'),
(14, 11, 4, 'Faros traseros', '1400.00'),
(15, 11, NULL, 'Colocacion de faro', '200.00'),
(16, 12, NULL, 'Mano de obra - colocar paragolpes', '100.00'),
(17, 12, 3, 'Paragolpes', '1000.00'),
(18, 12, 4, 'Faros traseros', '1400.00'),
(19, 12, NULL, 'Colocacion de faro', '200.00'),
(20, 13, NULL, 'Mano de obra - colocar paragolpes', '100.00'),
(21, 13, 3, 'Paragolpes', '1000.00'),
(22, 13, 4, 'Faros traseros', '1400.00'),
(23, 13, NULL, 'Colocacion de faro', '200.00');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `person_id` int(11) NOT NULL,
  `dni` varchar(20) COLLATE utf8_unicode_520_ci NOT NULL,
  `address` varchar(200) COLLATE utf8_unicode_520_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`person_id`, `dni`, `address`, `phone`) VALUES
(1, '987654321', 'Siempre Viva', '0987654321');

-- --------------------------------------------------------

--
-- Table structure for table `mechanics`
--

CREATE TABLE `mechanics` (
  `person_id` int(11) NOT NULL,
  `is_idle` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Dumping data for table `mechanics`
--

INSERT INTO `mechanics` (`person_id`, `is_idle`) VALUES
(14, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mechanics_registrations`
--

CREATE TABLE `mechanics_registrations` (
  `registration_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci COMMENT='Mecanicos asignados a reparar';

--
-- Dumping data for table `mechanics_registrations`
--

INSERT INTO `mechanics_registrations` (`registration_id`, `person_id`) VALUES
(1, 14);

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_520_ci NOT NULL,
  `price` decimal(16,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`id`, `name`, `price`) VALUES
(2, 'Paragolpes - delatenros', '1000.00'),
(3, 'Paragolpes', '1000.00'),
(4, 'Faros traseros', '1400.00');

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_520_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `name`, `last_name`) VALUES
(1, 'Homero', 'Simpson'),
(12, 'Sergio', 'Alcaraz'),
(14, 'Sergio I', 'Alcaraz C');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `entry_date` datetime NOT NULL,
  `person_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci COMMENT='Registros de entrada de vehiculos al taller';

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `entry_date`, `person_id`, `vehicle_id`) VALUES
(1, '2020-11-21 10:50:35', 1, 2),
(2, '2020-11-21 10:50:35', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `person_id` int(11) NOT NULL,
  `email` varchar(320) COLLATE utf8_unicode_520_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`person_id`, `email`, `password`) VALUES
(12, 'siac215@gmail.com', '$2y$10$7OuJlFaeoHAyR4bvobi7Z.hOTUgmZwK/x56vRQiu.7r5gow.FOZ16');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `license_plate` varchar(10) COLLATE utf8_unicode_520_ci NOT NULL COMMENT 'matrícula',
  `model` varchar(100) COLLATE utf8_unicode_520_ci NOT NULL,
  `year` year(4) NOT NULL COMMENT 'año de fabricación',
  `color` varchar(20) COLLATE utf8_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `license_plate`, `model`, `year`, `color`) VALUES
(2, 'AAAA 000', 'Nissan Navara', 2015, 'azul');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bill_details`
--
ALTER TABLE `bill_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `part_id` (`part_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`person_id`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indexes for table `mechanics`
--
ALTER TABLE `mechanics`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `mechanics_registrations`
--
ALTER TABLE `mechanics_registrations`
  ADD PRIMARY KEY (`registration_id`,`person_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrations_ibfk_1` (`person_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`person_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `license_plate` (`license_plate`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `bill_details`
--
ALTER TABLE `bill_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `bill_details`
--
ALTER TABLE `bill_details`
  ADD CONSTRAINT `bill_details_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `bill_details_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `mechanics`
--
ALTER TABLE `mechanics`
  ADD CONSTRAINT `mechanics_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `mechanics_registrations`
--
ALTER TABLE `mechanics_registrations`
  ADD CONSTRAINT `mechanics_registrations_ibfk_1` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `mechanics_registrations_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `mechanics` (`person_id`);

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `customers` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
