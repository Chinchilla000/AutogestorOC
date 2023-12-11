-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-12-2023 a las 15:30:39
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
-- Estructura de tabla para la tabla `detalles_solicitud_orden_compra`
--

CREATE TABLE `detalles_solicitud_orden_compra` (
  `id_detalle` int(11) NOT NULL,
  `id_solicitud` int(11) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `unidad` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `total_item` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `nombre_usuario`, `password`, `nombre_empresa`, `rut_empresa`, `giro_comercial`, `correo_empresa`, `numero_contacto`, `fecha_registro`) VALUES
(19, 'usuario1', '$2y$10$esRygOJGBpU5bvsWOnNKZOFenIxMDbE5eOvKT/Thyl8bnq6S3VC3C', 'Empresa Ficticia LTDA.', '124124124123', 'Ganaderia', 'asd@gmail.com', '1234124124', '2023-12-06 15:08:55'),
(21, 'aaaaa', '$2y$10$MdPMlCrQr.yM/Cl4oFH2H.gBL6uE661qX3FrQ.TZI33s4.7RClV7C', 'Empresa Nueva LTDA', '11111', '51111', 'empresa99@gmail.com', '222', '2023-12-11 03:01:55'),
(25, 'Valentina', '$2y$10$sUQgD4q1sdLoUsdpvU4Gueen68KZzQMGy587GTueOjAwkehOsBhxa', 'shynny baby shop', '12321323123', 'Cosmeticos', 'valentina@123', '123', '2023-12-11 14:11:59');

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

--
-- Volcado de datos para la tabla `gerentes_generales`
--

INSERT INTO `gerentes_generales` (`id`, `id_empresa`, `nombre`, `apellido`, `rut`, `cargo`, `correo`, `contrasena`) VALUES
(1, 19, 'Valentina', 'Obando', '20010126/k', 'Gerente General', 'valentina@123', '$2y$10$gF7NdMnpozoPxrrmLALrAuF0wvfXy.WRUFr7eECTJTn34iINP8Bju'),
(2, 19, 'Callito', '222222', '1123', 'Gerente General', '123@123', '$2y$10$WchJ3TZCevACl4QkLge4/.vGnqKHj4lGZApU9EOJxkjiCt4gOvNsa'),
(14, 25, 'CLaudio', 'poerez', '12312312', 'Gerente General', 'ejemplo@gmail.comd', '$2y$10$/tEUcp50wx7uLw.n8AzoK.s4iFUeg0Q6REJqBSahETC1PMFIK5WMe');

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

--
-- Volcado de datos para la tabla `residentes_obra`
--

INSERT INTO `residentes_obra` (`id`, `id_empresa`, `nombre`, `apellido`, `rut`, `cargo`, `correo`, `contrasena`) VALUES
(10, 19, 'residente1', 'aa', '123', 'Residente de Obras', 'residente@hotmail.com', '$2y$10$DvnoRj.7Fwmig7g3GUHvZunavo9zi6Z73oXzqk4A3K4nFNaPZssMq'),
(11, 19, 'bb', 'bb', 'bb', 'Residente de Obras', 'b@b', '$2y$10$Ou/tZM0wBO3vvX1B/LvTSeKe/O/EK/QdDqS3gVlFOrVHvncsrDyMe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_orden_compra`
--

CREATE TABLE `solicitudes_orden_compra` (
  `id_solicitud` int(11) NOT NULL,
  `id_residente` int(11) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `obra` varchar(255) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `solicitado_por` varchar(255) DEFAULT NULL,
  `total_neto` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `datos_pago` text DEFAULT NULL,
  `nombre_pago` varchar(255) DEFAULT NULL,
  `rut_pago` varchar(20) DEFAULT NULL,
  `correo_pago` varchar(100) DEFAULT NULL,
  `banco` varchar(100) DEFAULT NULL,
  `numero_cuenta` varchar(50) DEFAULT NULL
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
-- Volcado de datos para la tabla `visitadores_obra`
--

INSERT INTO `visitadores_obra` (`id`, `id_empresa`, `nombre`, `apellido`, `rut`, `cargo`, `correo`, `contrasena`) VALUES
(8, 19, 'aa', 'aa', 'aa', 'Visitador de Obras', 'aa@aa', '$2y$10$yUEBWVSPz/YCfhtc90uezuBpkWTpucFMVP6qtOwjYunDPIxFIpWHK'),
(9, 19, 'bb', 'aa', 'vv', 'Visitador de Obras', 'a@a', '$2y$10$4TX4TljVkeezhiP5jSPxlOMK7NZAul9n0mNQhNQCIyCtxV7NoF.7K');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalles_solicitud_orden_compra`
--
ALTER TABLE `detalles_solicitud_orden_compra`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_solicitud` (`id_solicitud`);

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
-- Indices de la tabla `solicitudes_orden_compra`
--
ALTER TABLE `solicitudes_orden_compra`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `id_residente` (`id_residente`),
  ADD KEY `id_empresa` (`id_empresa`);

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
-- AUTO_INCREMENT de la tabla `detalles_solicitud_orden_compra`
--
ALTER TABLE `detalles_solicitud_orden_compra`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `gerentes_generales`
--
ALTER TABLE `gerentes_generales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `residentes_obra`
--
ALTER TABLE `residentes_obra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `solicitudes_orden_compra`
--
ALTER TABLE `solicitudes_orden_compra`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `visitadores_obra`
--
ALTER TABLE `visitadores_obra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_solicitud_orden_compra`
--
ALTER TABLE `detalles_solicitud_orden_compra`
  ADD CONSTRAINT `detalles_solicitud_orden_compra_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes_orden_compra` (`id_solicitud`);

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
-- Filtros para la tabla `solicitudes_orden_compra`
--
ALTER TABLE `solicitudes_orden_compra`
  ADD CONSTRAINT `solicitudes_orden_compra_ibfk_1` FOREIGN KEY (`id_residente`) REFERENCES `residentes_obra` (`id`),
  ADD CONSTRAINT `solicitudes_orden_compra_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`);

--
-- Filtros para la tabla `visitadores_obra`
--
ALTER TABLE `visitadores_obra`
  ADD CONSTRAINT `visitadores_obra_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
