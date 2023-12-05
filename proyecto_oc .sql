-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2023 a las 20:46:37
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
-- Base de datos: `proyecto_oc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre_empresa` varchar(100) NOT NULL,
  `rut_empresa` varchar(20) NOT NULL,
  `giro_comercial` varchar(100) NOT NULL,
  `correo_empresa` varchar(100) NOT NULL,
  `numero_contacto` varchar(15) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gerentes_generales`
--

CREATE TABLE `gerentes_generales` (
  `id` int(11) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `residentes_obra`
--

CREATE TABLE `residentes_obra` (
  `id` int(11) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitadores_obra`
--

CREATE TABLE `visitadores_obra` (
  `id` int(11) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gerentes_generales`
--
ALTER TABLE `gerentes_generales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gerentes_generales_ibfk_1` (`id_empresa`);

--
-- Indices de la tabla `residentes_obra`
--
ALTER TABLE `residentes_obra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `residentes_obra_ibfk_1` (`id_empresa`);

--
-- Indices de la tabla `visitadores_obra`
--
ALTER TABLE `visitadores_obra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitadores_obra_ibfk_1` (`id_empresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `gerentes_generales`
--
ALTER TABLE `gerentes_generales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `residentes_obra`
--
ALTER TABLE `residentes_obra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `visitadores_obra`
--
ALTER TABLE `visitadores_obra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `gerentes_generales`
--
ALTER TABLE `gerentes_generales`
  ADD CONSTRAINT `gerentes_generales_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `residentes_obra`
--
ALTER TABLE `residentes_obra`
  ADD CONSTRAINT `residentes_obra_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `visitadores_obra`
--
ALTER TABLE `visitadores_obra`
  ADD CONSTRAINT `visitadores_obra_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
