-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 01-06-2026 a las 05:54:10
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `spectral`
--
CREATE DATABASE IF NOT EXISTS `spectral` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `spectral`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos_clases`
--

CREATE TABLE `alumnos_clases` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `clase_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alumnos_clases`
--

INSERT INTO `alumnos_clases` (`id`, `alumno_id`, `clase_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `clase_id` int(11) DEFAULT NULL,
  `asistencia` tinyint(1) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario_clases`
--

CREATE TABLE `calendario_clases` (
  `id` int(11) NOT NULL,
  `clase_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `tema` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `maestro_id` int(11) DEFAULT NULL,
  `color_enfasis` varchar(20) DEFAULT '#6c63ff'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id`, `nombre`, `codigo`, `maestro_id`, `color_enfasis`) VALUES
(1, 'Matematicas', '1554F', NULL, '#6c63ff'),
(2, 'Sweetie', 'C78889', 2, '#6c63ff');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
  `id` int(11) NOT NULL,
  `tarea_id` int(11) DEFAULT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `entregado` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id` int(11) NOT NULL,
  `clase_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `imagen` text DEFAULT NULL,
  `link` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id`, `clase_id`, `titulo`, `descripcion`, `tipo`, `imagen`, `link`, `created_at`) VALUES
(1, 2, 'prueba', 'aSASADA', 'tarea', '1779066705_IMG_3896.JPG', '', '2026-05-18 01:11:45'),
(2, 2, 'prueba', 'dsdsdfsds', 'tarea', '1779067264_IMG_3896.JPG', '', '2026-05-18 01:21:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `clase_id` int(11) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `puntos` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `clase_id`, `titulo`, `puntos`) VALUES
(1, 2, 'prueba', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` enum('alumno','maestro') DEFAULT 'alumno',
  `xp` int(11) DEFAULT 0,
  `nivel` int(11) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`, `xp`, `nivel`) VALUES
(1, 'Spectral', 'sebaselpro0908@gmail.com', '$2y$10$uRNTTINBbEr3lKkLs36sDOmssgFMW9yNe9m4saD3oKMSzkdhxCNgq', 'alumno', 0, 1),
(2, 'Maestro Spectral', 'maestro@spectral.com', '$2y$10$zpsejBry5kWt3qAcxZgGxuKJ2Sx0bZ9VIll8VXDqAGujmsXzvROi2', 'maestro', 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos_clases`
--
ALTER TABLE `alumnos_clases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calendario_clases`
--
ALTER TABLE `calendario_clases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos_clases`
--
ALTER TABLE `alumnos_clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calendario_clases`
--
ALTER TABLE `calendario_clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
