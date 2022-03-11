-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: ינואר 01, 2022 בזמן 05:02 PM
-- גרסת שרת: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project-db`
--

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `idNum` varchar(50) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `dealPackage` varchar(50) NOT NULL,
  `sector` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `passwords_history`
--

DROP TABLE IF EXISTS `passwords_history`;
CREATE TABLE IF NOT EXISTS `passwords_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `password` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `passwords_history_ibfk_1` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- הוצאת מידע עבור טבלה `passwords_history`
--

INSERT INTO `passwords_history` (`id`, `userId`, `password`) VALUES
(6, 4, '0ca12428b036ed29e04f3eeb11e6eea2f30c23e0'),
(7, 5, '0ca12428b036ed29e04f3eeb11e6eea2f30c23e0'),
(8, 5, '415461f14f66120da0ca1bc017de5137802d7148'),
(9, 5, '60a8f349529b3c248c2b8bd99838ce7ccedbeab5'),
(10, 5, '0756e56d1a2dab132994be3e784841ee05fb1872');

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login_attempts` int DEFAULT '0',
  `token` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- הוצאת מידע עבור טבלה `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `login_attempts`, `token`) VALUES
(4, 'test', 'test@gmail.com', '0ca12428b036ed29e04f3eeb11e6eea2f30c23e0', 2, NULL),
(5, 'eyal', 'eyalrafian@gmail.com', '0756e56d1a2dab132994be3e784841ee05fb1872', 0, NULL);

--
-- הגבלות לטבלאות שהוצאו
--

--
-- הגבלות לטבלה `passwords_history`
--
ALTER TABLE `passwords_history`
  ADD CONSTRAINT `passwords_history_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
