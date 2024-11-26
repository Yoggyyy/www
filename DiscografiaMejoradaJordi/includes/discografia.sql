-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 28-10-2024 a las 23:09:50
-- Versión del servidor: 11.5.2-MariaDB-log
-- Versión de PHP: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `discografia`
--
DROP DATABASE IF EXISTS `discografia`;
CREATE DATABASE IF NOT EXISTS `discografia` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `discografia`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albums`
--

DROP TABLE IF EXISTS `albums`;
CREATE TABLE `albums` (
  `id` int(8) NOT NULL,
  `title` varchar(50) NOT NULL,
  `group_id` int(8) NOT NULL,
  `year` int(4) NOT NULL,
  `format` enum('vinilo','cd','dvd','mp3') NOT NULL,
  `buydate` date NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `albums`
--

INSERT INTO `albums` (`id`, `title`, `group_id`, `year`, `format`, `buydate`, `price`, `photo`) VALUES
(1, 'Mismo sitio, distinto lugar', 1, 2017, 'cd', '2018-11-09', 21.99, 'mismo-sitio-distinto-lugar.png'),
(2, 'La deriva', 1, 2014, 'vinilo', '2019-01-20', 18.45, 'la-deriva.png'),
(3, 'Un día en el mundo', 1, 2008, 'cd', '2018-07-08', 17.50, 'un-dia-en-el-mundo.png'),
(4, 'En la espiral', 3, 2017, 'cd', '2019-04-15', 15.90, 'en-la-espiral.png'),
(5, 'Impronta', 3, 2013, 'mp3', '2019-02-26', 13.50, 'impronta.png'),
(6, 'Autoterapia', 2, 2018, 'cd', '2019-04-16', 14.25, 'autoterapia.png'),
(7, 'Aurora', 4, 2016, 'mp3', '2018-12-29', 12.80, 'aurora.png'),
(8, 'A kind of magic', 6, 1986, 'vinilo', '2000-03-14', 39.99, 'a-kind-of-magic'),
(9, 'News of the World', 6, 1977, 'vinilo', '1998-07-19', 44.95, 'news-of-the-world.png'),
(10, 'The Joshua Tree', 5, 1987, 'vinilo', '1993-12-20', 19.45, 'the-joshua-tree.png'),
(11, 'All that you can\'t leave behind', 5, 2000, 'cd', '2001-01-23', 21.95, 'all-that-you-cant-leave-behind.png'),
(12, 'Cable a tierra', 1, 2021, 'vinilo', '2021-05-13', 19.90, 'cable-a-tierra.png'),
(13, 'Espacios infinitos', 3, 2021, 'mp3', '2021-10-30', 12.95, 'espacios-infinitos.png'),
(14, 'Hogar', 2, 2021, 'vinilo', '2021-08-04', 19.90, 'hogar.png'),
(15, 'El tiempo y la actitud', 7, 2020, 'mp3', '2023-05-10', 9.99, 'el-tiempo-y-la-actitud.png'),
(16, 'La noche', 7, 2021, 'vinilo', '2023-06-15', 15.50, 'la-noche.png'),
(17, 'Cowboys de la A3', 7, 2023, 'cd', '2023-07-20', 14.99, 'cowboys-de-la-a3.png'),
(18, 'Ya dormiré cuando me muera', 8, 2020, 'mp3', '2020-07-06', 21.50, 'ya-dormire-cuando-me-muera.png'),
(19, '¿Quién es Billie Max?', 8, 2023, 'mp3', '2024-03-10', 15.99, 'quien-es-billie-max.png'),
(20, 'Blockbuster', 9, 2023, 'vinilo', '2023-12-20', 19.50, 'blockbuster.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(8) NOT NULL,
  `name` varchar(50) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `country` varchar(20) NOT NULL,
  `startyear` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `name`, `genre`, `country`, `startyear`, `photo`) VALUES
(1, 'Vetusta Morla', 'Indie rock', 'España', 1998, 'vetustamorla.png'),
(2, 'Izal', 'Indie', 'España', 2010, 'izal.png'),
(3, 'Lori Meyers', 'Indie rock', 'España', 1998, 'lorimeyers.png'),
(4, 'Fuel Fandango', 'Fusión electro funk', 'España', 2010, 'fuelfandango.png'),
(5, 'U2', 'Pop rock', 'Irlanda', 1976, 'u2.png'),
(6, 'Queen', 'Rock', 'Inglaterra', 1970, 'queen.png'),
(7, 'Arde Bogotá', 'Rock Alternativo', 'España', 2017, 'ardebogota.png'),
(8, 'Ginebras', 'Indie rock', 'España', 2018, 'ginebras.png'),
(9, 'La la love you', 'Pop Punk', 'España', 2004, 'lalaloveyou.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `songs`
--

DROP TABLE IF EXISTS `songs`;
CREATE TABLE `songs` (
  `id` int(8) NOT NULL,
  `title` varchar(50) NOT NULL,
  `album_id` int(8) NOT NULL,
  `length` int(8) NOT NULL,
  `position` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `songs`
--

INSERT INTO `songs` (`id`, `title`, `album_id`, `length`, `position`) VALUES
(1, 'Deséame suerte', 1, 230, 1),
(2, 'El discurso del rey', 1, 222, 2),
(3, 'Palmeras en la mancha', 1, 218, 3),
(4, 'Consejo de sabios', 1, 318, 4),
(5, '23 de junio', 1, 207, 5),
(6, 'Guerra civil', 1, 215, 6),
(7, 'Te lo digo a ti', 1, 147, 7),
(8, 'Punto sin retorno', 1, 281, 8),
(9, 'La vieja escuela', 1, 253, 9),
(10, 'Mismo sitio, distinto lugar', 1, 222, 10),
(11, 'La deriva', 2, 211, 1),
(12, 'Golpe maestro', 2, 228, 2),
(13, 'La mosca en tu pared', 2, 224, 3),
(14, 'Fuego', 2, 245, 4),
(15, 'Fiesta mayor', 2, 216, 5),
(16, '¡Alto!', 2, 194, 6),
(17, 'La grieta', 2, 226, 7),
(18, 'Pirómanos', 2, 220, 8),
(19, 'Las salas de espera', 2, 221, 9),
(20, 'Cuarteles de invierno', 2, 236, 10),
(21, 'Tour de francia', 2, 255, 11),
(22, 'Una sonata fantasma', 2, 230, 12),
(23, 'Autocrítica', 3, 282, 1),
(24, 'Sálvese quien pueda', 3, 203, 2),
(25, 'Un día en el mundo', 3, 252, 3),
(26, 'Copenhague', 3, 304, 4),
(27, 'Valiente', 3, 209, 5),
(28, 'La marea', 3, 223, 6),
(29, 'Pequeño desastre animal', 3, 214, 7),
(30, 'La cuadratura del círculo', 3, 216, 8),
(31, 'Año nuevo', 3, 267, 9),
(32, 'Rey sol', 3, 208, 10),
(33, 'Saharabbey road', 3, 278, 11),
(34, 'Al respirar', 3, 215, 12),
(35, 'Vértigo I', 4, 282, 1),
(36, 'Evoluación', 4, 310, 2),
(37, 'Pierdo el control', 4, 273, 3),
(38, 'Todo lo que dicen de ti', 4, 212, 4),
(39, 'Zona de confort', 4, 362, 5),
(40, 'Organizaciones peligrosas', 4, 236, 6),
(41, 'Océanos', 4, 266, 7),
(42, '1981', 4, 225, 8),
(43, 'Eternidad', 4, 241, 9),
(44, 'Siempre brilla el sol', 4, 219, 10),
(45, 'Un nuevo horizonte', 4, 235, 11),
(46, 'No estoy solo', 4, 175, 12),
(47, 'Vértigo II', 4, 251, 13),
(48, 'Planilandia', 5, 221, 1),
(49, 'El tiempo pasará', 5, 243, 2),
(50, 'Huracán', 5, 240, 3),
(51, 'Impronta', 5, 264, 4),
(52, 'Emborracharme', 5, 212, 5),
(53, 'Deshielo', 5, 241, 6),
(54, 'Una señal', 5, 203, 7),
(55, 'Tengo un plan', 5, 234, 8),
(56, 'Zen', 5, 206, 9),
(57, 'A-sinte-odio', 5, 203, 10),
(58, 'De los nervios', 5, 206, 11),
(59, 'Despedirse', 5, 230, 12),
(60, 'Autoterapia', 6, 277, 1),
(61, 'El pozo', 6, 235, 2),
(62, 'Ruido blanco', 6, 183, 3),
(63, 'Bill Murray', 6, 340, 4),
(64, 'Pausa', 6, 173, 5),
(65, 'Santa paz', 6, 163, 6),
(66, 'Canción para nadie', 6, 207, 7),
(67, 'La increible historia del hombre que podía volar p', 6, 289, 8),
(68, 'El temblor', 6, 267, 9),
(69, 'Temas amables', 6, 230, 10),
(70, 'Variables', 6, 143, 11),
(71, 'Burning', 7, 275, 1),
(72, 'Salvaje', 7, 231, 2),
(73, 'Corazón', 7, 161, 3),
(74, 'Toda la vida', 7, 217, 4),
(75, 'La primavera', 7, 307, 5),
(76, 'Not true', 7, 244, 6),
(77, 'El viento', 7, 244, 7),
(78, 'El todo y la nada', 7, 312, 8),
(79, 'Today', 7, 301, 9),
(80, 'Mi secreto', 7, 301, 10),
(81, 'Medina', 7, 296, 11),
(82, 'Where the streets have no name', 10, 338, 1),
(83, 'I still haven\'t found what I\'m looking for', 10, 278, 2),
(84, 'With or without yot', 10, 298, 3),
(85, 'Bullet the blue sky', 10, 272, 4),
(86, 'Running to stand still', 10, 258, 5),
(87, 'Red hill minning town', 10, 294, 6),
(88, 'In God\'s country', 10, 177, 7),
(89, 'Trip through your wires', 10, 213, 8),
(90, 'One tree hill', 10, 323, 9),
(91, 'Exit', 10, 253, 10),
(92, 'Mothers of the disappeared', 10, 312, 11),
(93, 'Beautiful day', 11, 246, 1),
(94, 'Stuck in a moment you can\'t get out of', 11, 272, 2),
(95, 'Elevation', 11, 226, 3),
(96, 'Walk on', 11, 295, 4),
(97, 'Kite', 11, 263, 5),
(98, 'In a little while', 11, 217, 6),
(99, 'Wild honey', 11, 225, 7),
(100, 'Peace on earth', 11, 306, 8),
(101, 'When I look at the World', 11, 255, 9),
(102, 'New York', 11, 328, 10),
(103, 'Grace', 11, 331, 11),
(104, 'The ground beneath her feet', 11, 223, 12),
(105, 'Summer rain', 11, 251, 13),
(106, 'One vision', 8, 312, 1),
(107, 'We will rock you', 9, 122, 1),
(108, 'A kind og magic', 8, 265, 2),
(109, 'One year of love', 8, 270, 3),
(110, 'Pain is so close to pleasure', 8, 280, 4),
(111, 'Friends will be friends', 8, 250, 5),
(112, 'Who wants to live forever', 8, 320, 6),
(113, 'Gimme the prize', 8, 275, 7),
(114, 'Don\'t lose tour head', 8, 280, 8),
(115, 'Princess of the universe', 8, 214, 9),
(116, 'We are the champions', 9, 181, 2),
(117, 'Sheer heart attack', 9, 210, 3),
(118, 'All dead, all dead', 9, 190, 4),
(119, 'Spread your wings', 9, 275, 5),
(120, 'Fight form the inside', 9, 187, 6),
(121, 'Get down, make love', 9, 231, 7),
(122, 'Sleeping on the sidewalk', 9, 190, 8),
(123, 'Who needs you', 9, 187, 9),
(124, 'It\'s late', 9, 390, 10),
(125, 'My melancholy Blues', 9, 212, 11),
(126, 'Puñalada trapera', 12, 223, 1),
(127, 'La Virgen de la humanidad', 12, 184, 2),
(128, 'No seré yo', 12, 270, 3),
(129, 'El imperio del sol', 12, 177, 4),
(130, 'Corazón de lava', 12, 256, 5),
(131, 'La diana', 12, 165, 6),
(132, 'Palabra es lo único que tengo', 12, 194, 7),
(133, 'Si te quiebras', 12, 218, 8),
(134, 'Finisterre', 12, 195, 9),
(135, 'Al final de la escapada', 12, 237, 10),
(136, 'Hacerte volar', 13, 282, 1),
(137, 'Primaveras', 13, 237, 2),
(138, 'Presente', 13, 255, 3),
(139, 'Seres de luz', 13, 282, 4),
(140, 'Mis fantasmas', 12, 354, 5),
(141, 'Punk', 12, 198, 6),
(142, 'No hay excusa', 12, 248, 7),
(143, 'En el espejo', 12, 265, 8),
(144, 'Fatiga pandémica', 12, 210, 9),
(145, 'Un último baile', 12, 278, 10),
(146, 'Viento del norte', 13, 247, 11),
(147, 'Tramontana 7:44 am', 14, 40, 1),
(148, 'Meiuqèr', 14, 264, 2),
(149, 'Inercia', 14, 227, 3),
(150, 'Fotografías', 14, 217, 4),
(151, 'He vuelto', 14, 258, 5),
(152, 'El hombre del futuro', 14, 137, 6),
(153, 'Jóvenes Perfect@s', 14, 242, 7),
(154, 'La mala educación', 14, 270, 8),
(155, 'Telepatía', 14, 207, 9),
(156, 'Dobles', 14, 248, 10),
(157, 'Hogar', 14, 228, 11),
(158, 'Tramontana 5:47pm', 14, 46, 12),
(159, 'Antiaéreo', 15, 184, 1),
(160, 'Quiero casarme contigo', 15, 178, 2),
(161, 'Big Bang', 15, 186, 3),
(162, 'Virtud y castigo', 15, 210, 4),
(163, 'Te van a hacer cambiar', 15, 212, 5),
(164, 'Abajo', 16, 168, 1),
(165, 'Cariño', 16, 217, 2),
(166, 'Tijeras', 16, 141, 3),
(167, 'A lo oscuro', 16, 230, 4),
(168, 'El beso', 16, 190, 5),
(169, 'Dangerous', 16, 184, 6),
(170, 'Millenial', 16, 197, 7),
(171, 'Tan alto como tus dudas', 16, 199, 8),
(172, 'El Dorado', 16, 203, 9),
(173, 'Exoplaneta', 16, 232, 10),
(174, 'Los perros', 17, 229, 1),
(175, 'Nuestros pecados', 17, 159, 2),
(176, 'Qué vida tan dura', 17, 203, 3),
(177, 'Clávame tus palabras', 17, 208, 4),
(178, 'Cowboys de la A3', 17, 276, 5),
(179, 'Copilotos', 17, 152, 6),
(180, 'Veneno', 17, 234, 7),
(181, 'Escorpio y sagitario', 17, 171, 8),
(182, 'Besos y animales', 17, 208, 9),
(183, 'Flor de la mancha', 17, 263, 10),
(184, 'Todos mis amigos están tristes', 17, 275, 11),
(185, 'La salvación', 17, 263, 12),
(186, 'Crystal Fighters', 18, 176, 1),
(187, 'Chico Pum', 18, 186, 2),
(188, 'Filtro Valencia', 18, 170, 3),
(189, '6 AM', 18, 158, 4),
(190, 'Paco y Carmela', 18, 186, 5),
(191, 'Vintage', 18, 167, 6),
(192, 'Cosas Moradas', 18, 159, 7),
(193, 'Metro de Madrid Informa', 18, 158, 8),
(194, 'Campos de Fresas para Siempre', 18, 212, 9),
(195, 'Billie Max', 19, 175, 1),
(196, 'Alex Turner', 19, 160, 2),
(197, 'En bolas', 19, 150, 3),
(198, 'Desastre de persona', 19, 174, 4),
(199, 'Rapapá', 19, 169, 5),
(200, 'Omeprazol', 19, 202, 6),
(201, 'Lunes negro', 19, 188, 7),
(202, 'Ansiedad', 19, 179, 8),
(203, 'He resucitado a Elvis', 19, 174, 9),
(204, 'Qué gozadita', 19, 171, 10),
(205, 'Muchas gracias por venir', 19, 203, 11),
(206, 'El Principio de algo', 20, 148, 1),
(207, 'Polaroid', 20, 183, 2),
(208, 'Himno (para los que están jodidos)', 20, 186, 3),
(209, 'Big Bang', 20, 208, 4),
(210, 'Willy el tuerto', 20, 165, 5),
(211, 'Quiero Quedarme para Siempre', 20, 190, 6),
(212, 'Todo mal', 20, 187, 7),
(213, 'La Canción del Verano', 20, 202, 8),
(214, 'Los ojos, chica, no mienten', 20, 197, 9),
(215, 'Canción a quemarropa', 20, 160, 10),
(216, 'Mantita y peli', 20, 181, 11),
(217, 'El Día de Huki Huki', 20, 191, 12),
(218, 'Cero en conducta', 20, 167, 13),
(219, 'Mierda, te quiero...', 20, 208, 14);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- base de datos:
-- user: vetustamorla
-- pass: 15151
GRANT USAGE ON *.* TO `vetustamorla`@`%` IDENTIFIED BY PASSWORD '*C8B14D3B88D013C3CE54D1C78076C54E734FDEA0';
GRANT ALL PRIVILEGES ON `discografia`.* TO `vetustamorla`@`%` WITH GRANT OPTION;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
