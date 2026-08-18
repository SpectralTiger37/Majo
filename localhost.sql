-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-08-2026 a las 03:31:08
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
CREATE DATABASE IF NOT EXISTS `spectral` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
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
(4, 1, 6);

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

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `alumno_id`, `clase_id`, `asistencia`, `fecha`) VALUES
(1, 1, 6, 1, '2026-06-19'),
(2, 1, 6, 1, '2026-06-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `tarea_id` int(11) DEFAULT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `calificacion` decimal(5,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `maestro_id` int(11) DEFAULT NULL,
  `portada` varchar(255) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id`, `nombre`, `codigo`, `maestro_id`, `portada`, `color`, `imagen`, `descripcion`) VALUES
(6, 'LISA', 'C43CC7', 2, NULL, '#ff0000', '1780374119_f768x1-1094055_1094182_5050.webp', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
  `id` int(11) NOT NULL,
  `tarea_id` int(11) DEFAULT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `entregado` tinyint(1) DEFAULT 0,
  `calificacion` decimal(5,2) DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `entregas`
--

INSERT INTO `entregas` (`id`, `tarea_id`, `alumno_id`, `entregado`, `calificacion`, `archivo`, `fecha`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL),
(4, 5, 1, 1, 40.00, '1781844504_ECM0293-YouthSpark-Desarrollo_de_aplicaciones_en_la_nube.pdf', '2026-06-18 22:48:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logros`
--

CREATE TABLE `logros` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `xp_requerida` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `logros`
--

INSERT INTO `logros` (`id`, `nombre`, `descripcion`, `icono`, `xp_requerida`) VALUES
(1, 'Primer Paso', 'Obtén 50 XP', '🥉', 50),
(2, 'Estudiante Activo', 'Obtén 250 XP', '🥈', 250),
(3, 'Aprendiz Experto', 'Obtén 500 XP', '🥇', 500),
(4, 'Maestro Spectral', 'Obtén 1000 XP', '👑', 1000),
(5, 'Leyenda', 'Obtén 5000 XP', '🔥', 5000);

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
(5, 6, 'prueba', 'prueba', 'noticia', '1782266596_2e2dd0be0eda855da32dae784c661da7-2.jpg', '', '2026-06-24 02:03:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `clase_id` int(11) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `puntos` int(11) DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `clase_id`, `titulo`, `puntos`, `fecha_entrega`, `descripcion`) VALUES
(5, 6, 'prueba', 80, '2026-06-18', 'xd');

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
  `nivel` int(11) DEFAULT 1,
  `foto` varchar(255) DEFAULT NULL,
  `semestre` varchar(20) DEFAULT NULL,
  `grupo` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`, `xp`, `nivel`, `foto`, `semestre`, `grupo`) VALUES
(1, 'SpectralTiger', 'sebaselpro0908@gmail.com', '$2y$10$uRNTTINBbEr3lKkLs36sDOmssgFMW9yNe9m4saD3oKMSzkdhxCNgq', 'alumno', 150, 1, '1780366398_images.jpg', '6', 'F'),
(2, 'Maestro ST', 'maestro@spectral.com', '$2y$10$zpsejBry5kWt3qAcxZgGxuKJ2Sx0bZ9VIll8VXDqAGujmsXzvROi2', 'maestro', 0, 1, 'perfil_2_1781846735.jpg', NULL, NULL),
(3, 'Osvaldo', 'osvaldo@tufino.com', '$2y$12$CiYqdZw.hIRtZ.PwmHtGPOMxFHjMvv6Shpm7G7sHuVxPkk4LZGbW.', 'alumno', 0, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_logros`
--

CREATE TABLE `usuarios_logros` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `logro_id` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
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
-- Indices de la tabla `logros`
--
ALTER TABLE `logros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `usuarios_logros`
--
ALTER TABLE `usuarios_logros`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos_clases`
--
ALTER TABLE `alumnos_clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `logros`
--
ALTER TABLE `logros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios_logros`
--
ALTER TABLE `usuarios_logros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
