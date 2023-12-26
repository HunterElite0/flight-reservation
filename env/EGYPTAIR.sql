-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 26, 2023 at 08:31 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `EGYPTAIR`
--

-- --------------------------------------------------------

--
-- Table structure for table `City`
--

CREATE TABLE `City` (
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `City`
--

INSERT INTO `City` (`name`) VALUES
('Cairo'),
('Canada'),
('Iraq'),
('KL'),
('KSA'),
('Kuwait'),
('LA'),
('Malaysia'),
('Paris'),
('Shibuya'),
('UAE');

-- --------------------------------------------------------

--
-- Table structure for table `Company`
--

CREATE TABLE `Company` (
  `id` int NOT NULL,
  `bio` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Company`
--

INSERT INTO `Company` (`id`, `bio`, `address`, `location`, `logo`) VALUES
(134, 'lol', 'lol', 'lol', 'https://www.egyptair.com/Style%20Library/Images/egyptairmainlogo.png'),
(135, 'best comp ever', 'Cairo, Mokattam, street 33, building 36', 'Cairo University', 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse2.mm.bing.net%2Fth%3Fid%3DOIP.sHWnRfYN1Y-T5LmU5wk3xwHaGM%26pid%3DApi&f=1&ipt=59269e8f68e0ffa3143a6e90ee24dd929f6dd303a3cb17443eb840de63bd8ed7&ipo=images');

-- --------------------------------------------------------

--
-- Table structure for table `Flight`
--

CREATE TABLE `Flight` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `fees` decimal(10,0) NOT NULL,
  `complete` tinyint(1) NOT NULL,
  `pending_passengers` int NOT NULL,
  `registered_passengers` int NOT NULL,
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Flight`
--

INSERT INTO `Flight` (`id`, `name`, `fees`, `complete`, `pending_passengers`, `registered_passengers`, `company_id`) VALUES
(1, 'test', 100, 0, 2, 3, 134),
(12, 'test2', 100, 0, 4, 6, 134);

-- --------------------------------------------------------

--
-- Table structure for table `Flight_City`
--

CREATE TABLE `Flight_City` (
  `flight_id` int NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `flight_order` int NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Flight_City`
--

INSERT INTO `Flight_City` (`flight_id`, `city_name`, `flight_order`, `start_time`, `end_time`) VALUES
(1, 'Cairo', 1, '2020-01-01 00:00:00', '2021-01-01 00:00:00'),
(12, 'Canada', 1, '2020-01-01 00:00:00', '2021-01-01 00:00:00'),
(12, 'Iraq', 2, '2020-01-01 00:00:00', '2021-01-01 00:00:00'),
(12, 'KSA', 3, '2020-01-01 00:00:00', '2021-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE `Messages` (
  `m_from` int NOT NULL,
  `m_to` int NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Messages`
--

INSERT INTO `Messages` (`m_from`, `m_to`, `message`) VALUES
(122, 134, '123123'),
(122, 134, '12312311111111'),
(122, 134, '11111111111111111111111'),
(134, 122, 'testerrrrrrr'),
(122, 135, 'cmon man'),
(122, 135, 'cmon ma2222222n');

-- --------------------------------------------------------

--
-- Table structure for table `Passenger`
--

CREATE TABLE `Passenger` (
  `id` int NOT NULL,
  `photo` text NOT NULL,
  `passport_img` text NOT NULL,
  `balance` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Passenger`
--

INSERT INTO `Passenger` (`id`, `photo`, `passport_img`, `balance`) VALUES
(122, 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.pb-GW96sflZiGPmP7RVpXQHaEo%26pid%3DApi%26h%3D160&f=1&ipt=cf86949fc11a700ed83710c4110ec5bead7952ed67325043c3bfc4990f2175da&ipo=images', '123', -300),
(136, 'ss', 'ss', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Passenger_Flight`
--

CREATE TABLE `Passenger_Flight` (
  `flight_id` int NOT NULL,
  `passenger_id` int NOT NULL,
  `f_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `f_to` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Passenger_Flight`
--

INSERT INTO `Passenger_Flight` (`flight_id`, `passenger_id`, `f_from`, `f_to`) VALUES
(1, 122, '0', ''),
(12, 122, 'Canada', 'KSA');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `account_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `name`, `email`, `password`, `tel`, `account_type`) VALUES
(122, 'Mostafa Hesham', 'mostafa777444333@gmail.com', '$2y$10$z.BXsIJHE0/yJHKduSRY9.mx5/BESnIw4C9ToY5aJdvdhuN0OtIeK', '+20103212621231', 1),
(134, 'ea', 'ea@lol.com', '$2y$10$8PP2fUBtaCw7jSNSxsQpDu4J/T.UCpykma55c6X0mcfIRA6ZuYU46', '02', 0),
(135, 'Mostafa Hesham', 'mostafa777444333@gmail', '$2y$10$Tmu4zfWx132VvSsUrCnyduELncq2o2YgxJDbo10KxpsDClqwUtP4y', '+201032126278111', 0),
(136, 'fares', 'pop@lol.com', '$2y$10$EmmuXgh7oYgz4euDN7555.IeCbXKwg/A9TAQ2sRYOlJ1ehDbFSl3a', '012121', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `City`
--
ALTER TABLE `City`
  ADD PRIMARY KEY (`name`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `Company`
--
ALTER TABLE `Company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `Flight`
--
ALTER TABLE `Flight`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flight_company` (`company_id`);

--
-- Indexes for table `Flight_City`
--
ALTER TABLE `Flight_City`
  ADD PRIMARY KEY (`flight_id`,`city_name`,`flight_order`),
  ADD KEY `city_name` (`city_name`),
  ADD KEY `flight_id` (`flight_id`),
  ADD KEY `flight_order` (`flight_order`);

--
-- Indexes for table `Messages`
--
ALTER TABLE `Messages`
  ADD KEY `m_from` (`m_from`,`m_to`),
  ADD KEY `m_to` (`m_to`);

--
-- Indexes for table `Passenger`
--
ALTER TABLE `Passenger`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `Passenger_Flight`
--
ALTER TABLE `Passenger_Flight`
  ADD PRIMARY KEY (`flight_id`,`passenger_id`),
  ADD KEY `Passenger_Flight_ibfk_2` (`passenger_id`),
  ADD KEY `destination` (`f_from`),
  ADD KEY `f_to` (`f_to`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `tel` (`tel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Flight`
--
ALTER TABLE `Flight`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Company`
--
ALTER TABLE `Company`
  ADD CONSTRAINT `user_company` FOREIGN KEY (`id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Flight`
--
ALTER TABLE `Flight`
  ADD CONSTRAINT `flight_company` FOREIGN KEY (`company_id`) REFERENCES `Company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Flight_City`
--
ALTER TABLE `Flight_City`
  ADD CONSTRAINT `city` FOREIGN KEY (`city_name`) REFERENCES `City` (`name`),
  ADD CONSTRAINT `flight` FOREIGN KEY (`flight_id`) REFERENCES `Flight` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`m_from`) REFERENCES `User` (`id`),
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`m_to`) REFERENCES `User` (`id`);

--
-- Constraints for table `Passenger`
--
ALTER TABLE `Passenger`
  ADD CONSTRAINT `user_passenger` FOREIGN KEY (`id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Passenger_Flight`
--
ALTER TABLE `Passenger_Flight`
  ADD CONSTRAINT `flight_passenger` FOREIGN KEY (`flight_id`) REFERENCES `Flight` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
