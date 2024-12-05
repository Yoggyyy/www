-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-10-2022 a las 19:00:50
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tiendamercha`
--
CREATE DATABASE IF NOT EXISTS `merchashop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `merchashop`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `sale` int(4) NOT NULL DEFAULT 0 COMMENT 'porcentaje a aplicar',
  `stock` int(4) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `sale`, `stock`, `image`) VALUES
(1, 'Anillo único', 'El señor de los anillos', 22.95, 10, 12, 'anillounico.png'),
(2, 'Felpudo Kame House', 'Dragon Ball', 19.99, 0, 20, 'felpudokamehouse.png'),
(3, 'Goku', 'Dragon Ball', 34.99, 0, 9, 'gokunamek.png'),
(4, 'Abrecartas Espada de Griffindor', 'Harry Potter', 21.49, 0, 16, 'espadagriffindor.png'),
(5, 'Monedero Gama Chan', 'Naruto', 13.95, 15, 7, 'monederonaruto.png'),
(6, 'Taza Portal', 'Rick y Morty', 9.99, 0, 11, 'tazaportalrym.png'),
(7, 'The child (Grogu) 42cm', 'Mandalorian', 395.99, 0, 2, 'grogu.png'),
(8, 'Camiseta Hellfire club', 'Stranger Things', 18.99, 0, 34, 'hellfireclub.png'),
(9, 'Trono de hierro', 'Game of Thrones', 52.95, 0, 6, 'tronohierro.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user` varchar(20) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `token` varchar(255),
  PRIMARY KEY (`user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--
-- Usuario de la web:
--   user: Rick
--   pass: Sanchez
INSERT INTO `users` VALUES
('Rick','rick@mail.com','$2y$10$KEqgNTfwuUhewNjiMOz3gO58GQdbgJdMOR/.QjQqJpRuPr6HYGHPu','admin','');


--
-- Estructura de tabla para la tabla `passwordrecovery`
--

DROP TABLE IF EXISTS `passwordrecovery`;
CREATE TABLE `passwordrecovery` (
  `email` varchar(80) NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- Usuario de la base de datos:
--   user: Lumos
--   pass: Nox
GRANT USAGE ON *.* TO `Lumos`@`%` IDENTIFIED BY PASSWORD '*A00FCC7FBBA4B7831882206AC58614DD0A66447E';
GRANT ALL PRIVILEGES ON `merchashop`.* TO `Lumos`@`%` WITH GRANT OPTION;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
