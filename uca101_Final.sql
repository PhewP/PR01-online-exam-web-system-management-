-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-04-2021 a las 20:11:39
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `uca101`
--
CREATE DATABASE IF NOT EXISTS `uca101`
DEFAULT CHARACTER SET utf8
COLLATE utf8_spanish_ci;
USE `uca101`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE `asignatura` (
  `id` int(11) NOT NULL,
  `id_Grado` int(11) NOT NULL,
  `codigo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `fechaCurso` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`id`, `id_Grado`, `codigo`, `nombre`, `fechaCurso`) VALUES
(1, 1, '1111', 'Programacion Web', 2021),
(2, 1, '1112', 'Administracion de Servidores', 2021),
(3, 1, '1113', 'Programacion Orientada a Objetos', 2021),
(4, 1, '1114', 'Diseño de Sistemas Hipermedia', 2021);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `id` int(11) NOT NULL,
  `id_Usuario` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  `fecha_ini` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenpregunta`
--

CREATE TABLE `examenpregunta` (
  `id` int(11) NOT NULL,
  `id_Examen` int(11) NOT NULL,
  `id_Pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Estructura de tabla para la tabla `usuariorespuestas`
--

CREATE TABLE `usuariorespuestas` (
  `id` int(11) NOT NULL,
  `id_Examen` int(11) NOT NULL,
  `id_Pregunta` int(11) NOT NULL,
  `id_Usuario` int(11) NOT NULL,
  `id_respuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado`
--

CREATE TABLE `grado` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `grado`
--

INSERT INTO `grado` (`id`, `codigo`, `nombre`) VALUES
(1, '111', 'Grado en Ingenieria Informatica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe`
--

CREATE TABLE `informe` (
  `id` int(11) NOT NULL,
  `id_Examen` int(11) NOT NULL,
  `nota_media` float DEFAULT NULL,
  `numero_suspensos` int(11) DEFAULT NULL,
  `numero_aprobados` int(11) DEFAULT NULL,
  `numero_notables` int(11) DEFAULT NULL,
  `numero_sobresalientes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id` int(11) NOT NULL,
  `id_Tema` int(11) NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `invalida` boolean DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id`, `id_Tema`, `nombre`) VALUES
(16, 3, 'Pregunta 1 poo'),
(17, 4, 'Pregunta 2 poo'),
(18, 5, 'Pregunta 3 de poo'),
(19, 4, 'Esta es la pregunta 4'),
(20, 3, 'Esta respuesta es si'),
(21, 4, 'Responde 4'),
(22, 4, 'Responde sinceramente'),
(23, 8, 'Esta pregunta es de PW y responde 5'),
(24, 8, 'PW significa'),
(25, 9, 'Â¿Que se me olvida?'),
(26, 8, 'Me canso de crear preguntas, responde 23'),
(27, 9, 'Vamos a sacar un 10, Nacho'),
(28, 8, 'Domingo de Ramoh viendo salih al Nasareno jabe peish'),
(29, 6, 'Motores rugen al cielo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id` int(11) NOT NULL,
  `id_Pregunta` int(11) NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `verdadero` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id`, `id_Pregunta`, `nombre`, `verdadero`) VALUES
(43, 16, 'Esta es la pregunta 4', 0),
(44, 16, 'Esta es la pregunta 3', 0),
(45, 16, 'Esta es la pregunta 2', 0),
(46, 16, 'Esta es la pregunta 1', 1),
(47, 17, 'Esta es la pregunta 1', 0),
(48, 17, 'Esta es la pregunta 2', 1),
(49, 17, 'Esta es la pregunta 3', 0),
(50, 17, 'Esta es la pregunta 4', 0),
(51, 18, 'Esta es la pregunta 1', 0),
(52, 18, 'Esta es la pregunta 2', 0),
(53, 18, 'Esta es la pregunta 3', 1),
(54, 18, 'Esta es la pregunta 4', 0),
(55, 19, 'Esta es la pregunta 4', 1),
(56, 19, 'Esta es la pregunta 3', 0),
(57, 19, 'Esta es la pregunta 2', 0),
(58, 19, 'Esta es la pregunta 1', 0),
(59, 20, 'si', 1),
(60, 20, 'vale', 0),
(61, 20, 'no', 0),
(62, 20, 'Nada', 0),
(63, 21, '4', 1),
(64, 21, '333', 0),
(65, 21, '123', 0),
(66, 21, 'todas', 0),
(67, 22, 'te quiero', 0),
(68, 22, 'no te quiero', 0),
(69, 22, 'jeje', 0),
(70, 22, 'sinceramente', 1),
(71, 23, 'Comer', 0),
(72, 23, 'Dormir', 0),
(73, 23, 'Llorar', 0),
(74, 23, '5', 1),
(75, 24, 'PoWer', 0),
(76, 24, 'Programacion Web', 1),
(77, 24, 'Po Way', 0),
(78, 24, 'Po Weno', 0),
(79, 25, 'Tu nombre', 0),
(80, 25, 'Tu casa', 0),
(81, 25, 'Tu cara', 0),
(82, 25, 'Pega la vuelta, estas mintiendo, ya lo se', 1),
(83, 26, '2233', 0),
(84, 26, '32', 0),
(85, 26, '23', 1),
(86, 26, '232323', 0),
(87, 27, 'Si', 0),
(88, 27, 'Tal vez', 0),
(89, 27, 'No', 0),
(90, 27, 'Todas las respuestas son correctas', 1),
(91, 28, 'Aro ompareh', 0),
(92, 28, 'Mah dejame quedarme hasta las 2 ', 0),
(93, 28, 'Todas son correctas', 1),
(94, 28, 'Yo compro el lote', 0),
(95, 29, 'Gasolina', 0),
(96, 29, 'Todas son correctas', 1),
(97, 29, 'Sangre', 0),
(98, 29, 'Fuego', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE `tema` (
  `id` int(11) NOT NULL,
  `id_Asignatura` int(11) NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`id`, `id_Asignatura`, `nombre`, `numero`) VALUES
(3, 3, 'Tema 1 - POO', 1),
(4, 3, 'Tema 2 POO', 2),
(5, 3, 'Tema 3 POO', 3),
(6, 4, 'Tema 1 DSH', 1),
(7, 4, 'Tema 2 DSH', 2),
(8, 1, 'Tema 1 PW', 1),
(9, 1, 'Tema 2 PW', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `user_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `rol` set('estudiante','profesor','administrador') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'estudiante'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `user_name`, `password`, `email`, `nombre`, `apellidos`, `rol`) VALUES
(1, 'u11111111', '1234', 'esperanza.canocanalejas@alum.uca.es', 'Esperanza', 'Cano Canalejas', 'estudiante'),
(2, 'u33333333', '1234', 'manuel.pallaresnunez@alum.uca.es', 'Manuel', 'Pallares Nunez', 'profesor'),
(3, 'u22222222', '1234', 'mercedes.canalejas@alum.uca.es', 'Mercedes', 'Canalejas', 'estudiante'),
(4, 'u44444444', '1234', 'antonio.cano@alum.uca.es', 'Antonio', 'Cano', 'profesor'),
(5, 'u55555555', '1234', 'luisa.rodriguez@alum.uca.es', 'Luisa', 'Rodriguez', 'estudiante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioasignatura`
--

CREATE TABLE `usuarioasignatura` (
  `id` int(11) NOT NULL,
  `id_Usuario` int(11) NOT NULL,
  `id_Asignatura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarioasignatura`
--

INSERT INTO `usuarioasignatura` (`id`, `id_Usuario`, `id_Asignatura`) VALUES
(7, 1, 1),
(8, 1, 3),
(9, 3, 3),
(10, 3, 4),
(11, 5, 3),
(12, 4, 4),
(13, 4, 1),
(14, 3, 4),
(15, 2, 3),
(16, 2, 1),
(17, 2, 4),
(18, 2, 2),
(19, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioexamen`
--

CREATE TABLE `usuarioexamen` (
  `id` int(11) NOT NULL,
  `id_Usuario` int(11) NOT NULL,
  `id_Examen` int(11) NOT NULL,
  `nota` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Grado` (`id_Grado`);

--
-- Indices de la tabla `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Usuario` (`id_Usuario`),
  ADD KEY `id_Asignatura` (`id_asignatura`);

--
-- Indices de la tabla `examenpregunta`
--
ALTER TABLE `examenpregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Examen` (`id_Examen`),
  ADD KEY `id_Pregunta` (`id_Pregunta`);

--
-- Indices de la tabla `usuariorespuestas`
--
ALTER TABLE `usuariorespuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Examen` (`id_Examen`),
  ADD KEY `id_Pregunta` (`id_Pregunta`),
  ADD KEY `id_Usuario` (`id_Usuario`),
  ADD KEY `id_Respuesta` (`id_Respuesta`);

--
-- Indices de la tabla `grado`
--
ALTER TABLE `grado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `informe`
--
ALTER TABLE `informe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Examen` (`id_Examen`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Tema` (`id_Tema`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Pregunta` (`id_Pregunta`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Asignatura` (`id_Asignatura`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarioasignatura`
--
ALTER TABLE `usuarioasignatura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Usuario` (`id_Usuario`),
  ADD KEY `id_Asignatura` (`id_Asignatura`);

--
-- Indices de la tabla `usuarioexamen`
--
ALTER TABLE `usuarioexamen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Pregunta` (`id_Usuario`),
  ADD KEY `id_Examen` (`id_Examen`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `examenpregunta`
--
ALTER TABLE `examenpregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT de la tabla `usuariorespuestas`
--

ALTER TABLE `usuariorespuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grado`
--
ALTER TABLE `grado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarioasignatura`
--
ALTER TABLE `usuarioasignatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuarioexamen`
--
ALTER TABLE `usuarioexamen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD CONSTRAINT `asignatura_ibfk_1` FOREIGN KEY (`id_Grado`) REFERENCES `grado` (`id`);

--
-- Filtros para la tabla `examen`
--
ALTER TABLE `examen`
  ADD CONSTRAINT `examen_ibfk_1` FOREIGN KEY (`id_Usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `examen_ibfk_2` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id`);

--
-- Filtros para la tabla `examenpregunta`
--
ALTER TABLE `examenpregunta`
  ADD CONSTRAINT `examenpregunta_ibfk_1` FOREIGN KEY (`id_Examen`) REFERENCES `examen` (`id`),
  ADD CONSTRAINT `examenpregunta_ibfk_2` FOREIGN KEY (`id_Pregunta`) REFERENCES `pregunta` (`id`);

--
-- Filtros para la tabla `usuariorespuestas`
--
ALTER TABLE `usuariorespuestas`
  ADD CONSTRAINT `usuariorespuestas_ibfk_1` FOREIGN KEY (`id_Examen`) REFERENCES `examen` (`id`),
  ADD CONSTRAINT `usuariorespuestas_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id`),
  ADD CONSTRAINT `usuariorespuestas_ibfk_3` FOREIGN KEY (`id_Usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `usuariorespuestas_ibfk_4` FOREIGN KEY (`id_Respuesta`) REFERENCES `respuesta` (`id`);

--
-- Filtros para la tabla `informe`
--
ALTER TABLE `informe`
  ADD CONSTRAINT `informe_ibfk_1` FOREIGN KEY (`id_Examen`) REFERENCES `examen` (`id`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`id_Tema`) REFERENCES `tema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`id_Pregunta`) REFERENCES `pregunta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tema`
--
ALTER TABLE `tema`
  ADD CONSTRAINT `tema_ibfk_1` FOREIGN KEY (`id_Asignatura`) REFERENCES `asignatura` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarioasignatura`
--
ALTER TABLE `usuarioasignatura`
  ADD CONSTRAINT `usuarioasignatura_ibfk_1` FOREIGN KEY (`id_Usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `usuarioasignatura_ibfk_2` FOREIGN KEY (`id_Asignatura`) REFERENCES `asignatura` (`id`);

--
-- Filtros para la tabla `usuarioexamen`
--
ALTER TABLE `usuarioexamen`
  ADD CONSTRAINT `usuarioexamen_ibfk_1` FOREIGN KEY (`id_Usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `usuarioexamen_ibfk_2` FOREIGN KEY (`id_Examen`) REFERENCES `examen` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
