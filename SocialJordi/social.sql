-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2023 a las 15:31:26
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `social`
--
CREATE DATABASE IF NOT EXISTS `social` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `social`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `entry_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `entry_id`, `user_id`, `text`, `date`) VALUES
(1, 2, 6, 'Qué bien te lo montas', '2022-10-20 22:12:41'),
(2, 3, 6, 'Seguro que te gusta', '2022-10-20 22:12:41'),
(3, 3, 1, 'Vamossss', '2022-10-20 22:12:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dislikes`
--

DROP TABLE IF EXISTS `dislikes`;
CREATE TABLE `dislikes` (
  `entry_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dislikes`
--

INSERT INTO `dislikes` (`entry_id`, `user_id`) VALUES
(2, 5),
(5, 5),
(7, 2),
(10, 3),
(11, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follows`
--

DROP TABLE IF EXISTS `follows`;
CREATE TABLE `follows` (
  `user_id` int(10) NOT NULL,
  `user_followed` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `follows`
--

INSERT INTO `follows` (`user_id`, `user_followed`) VALUES
(1, 4),
(6, 1),
(6, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `entry_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`entry_id`, `user_id`) VALUES
(1, 3),
(1, 6),
(8, 3),
(9, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entries`
--

DROP TABLE IF EXISTS `entries`;
CREATE TABLE `entries` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `entries`
--

INSERT INTO `entries` (`id`, `user_id`, `text`, `date`) VALUES
(1, 1, 'De vacaciones', '2022-08-06 13:16:17'),
(2, 1, 'En la playa (Tenerife)', '2022-08-20 09:45:05'),
(3, 4, 'Probando esto', '2022-09-13 07:06:24'),
(4, 5, 'Me han contratado en una empresa nueva', '2022-09-19 20:55:36'),
(5, 3, 'Disfrutando de la vida', '2022-10-02 15:15:31'),
(6, 1, 'Submarinismo en Fuerteventura', '2022-10-10 07:16:42'),
(7, 4, 'A tope con la vida', '2022-10-10 08:11:41'),
(8, 2, 'Hola hola', '2022-10-11 11:21:08'),
(9, 2, 'Aquí estoy', '2022-10-12 15:21:08'),
(10, 1, 'Ya de vuelta en casa', '2022-10-13 12:01:12'),
(11, 5, 'Me encanta esta empresa', '2022-10-15 10:28:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `user` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user`, `password`, `email`) VALUES
(1, 'Antonio', '$2y$11$Jcr5/i4aw5YtjtlgO6oBJ.93RJSlVOM7iDJ0GgW7ezFU4L7Wr7qVK', 'antonio@mail.com'),
(2, 'Lucas', '$2y$11$vJbfqvwWcUJDW9ldPAEQq.coYscsR6kR7hceN9PRzbTE8LqKZL/ou', 'lucas@mail.com'),
(3, 'Ana', '$2y$11$lI7mvbOQqNRUucLxqCcqA.5yIS40b1rPC5EDfu5gEJjdvr3zyTIPO', 'ana@mail.com'),
(4, 'Patricia', '$2y$11$NCZGoKARuJJKgc0QIlntbu1BFazUHqOyMoxbVmDqxgW9yx91Hrupu', 'patricia@mail.com'),
(5, 'Oscar', '$2y$11$/eMmhFdDCKg5.xNu6Ox32.idXyHugeiUjOHS4XOJuMo5Y7yYrGU0O', 'oscar@mail.com'),
(6, 'Eva', '$2y$11$H2CAEXusZCBOHQjdO54Y..GLP5u1WhEJNRbuHAD5tTaTPIGmKef8e', 'eva@mail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `entry_id` (`entry_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `dislikes`
--
ALTER TABLE `dislikes`
  ADD PRIMARY KEY (`entry_id`,`user_id`),
  ADD KEY `entry_id` (`entry_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`user_id`,`user_followed`),
  ADD KEY `user_followed` (`user_followed`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`entry_id`,`user_id`),
  ADD KEY `entry_id` (`entry_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `entries`
--
ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `entries`
--
ALTER TABLE `entries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`entry_id`) REFERENCES `entries` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `dislikes`
--
ALTER TABLE `dislikes`
  ADD CONSTRAINT `dislikes_ibfk_1` FOREIGN KEY (`entry_id`) REFERENCES `entries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dislikes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`user_followed`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`entry_id`) REFERENCES `entries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entries`
--
ALTER TABLE `entries`
  ADD CONSTRAINT `entries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;


-- user: social
-- pass: laicos
GRANT USAGE ON *.* TO `social`@`%` IDENTIFIED BY PASSWORD '*B7EAE7504C000699CB42EB74663DF894BD3AE341';
GRANT ALL PRIVILEGES ON `social`.* TO `social`@`%` WITH GRANT OPTION;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
