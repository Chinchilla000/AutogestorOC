-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-12-2023 a las 17:16:27
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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
  `precio_unitario` int(11) DEFAULT NULL,
  `total_item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_solicitud_orden_compra`
--

INSERT INTO `detalles_solicitud_orden_compra` (`id_detalle`, `id_solicitud`, `item`, `descripcion`, `unidad`, `cantidad`, `precio_unitario`, `total_item`) VALUES
(8, 6, 'Martillo', 'martillo para construccion', '1', 1, 1500, 1500),
(12, 9, '1', 'martillo para construccion', 'c/u', 2, 300, 600),
(13, 9, '2', 'taladro dsadasdas', 'c/u', 3, 300, 900),
(14, 10, 'a', 'martillo para construccion', 'm3', 2, 200, 400),
(15, 11, 'dasd', 'martillo para construccion', 'c/u', 2, 300, 600),
(16, 11, 'aa', 'aa', 'cc', 2, 100, 200),
(17, 12, 'cc', 'martillo para construccion', 'm2', 2, 100, 200),
(18, 12, 'ccccc', 'a', 'c/u', 3, 300, 900),
(19, 13, 'taladro', 'b', 'm2', 1, 500, 500),
(20, 14, 'Martillo', 'martillo para construccion', 'm3', 2, 700, 0),
(21, 15, 'dasd', '123', 'm3', 1, 600, 600),
(22, 16, 'q', 'q', 'm3', 2, 300, 600),
(23, 17, '', '', '', 0, 0, 0),
(24, 18, '', '', '', 0, 0, 0),
(25, 19, 'taladro', 'asdas', 'm2', 2, 2, 4),
(26, 20, 'asdas', 'asd', 'c/u', 1, 1, 1),
(27, 21, 'a', 'a', 'm3', 1, 2, 2),
(28, 22, 'bb', 'bb', 'm3', 2, 3, 6),
(29, 23, 'asd', 'asd', 'm2', 2, 300, 600),
(30, 23, 'v', 'v', 'm3', 5, 2500, 12500);

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
(25, 'Valentina', '$2y$10$sUQgD4q1sdLoUsdpvU4Gueen68KZzQMGy587GTueOjAwkehOsBhxa', 'shynny baby shop', '12321323123', 'Cosmeticos', 'valentina@123', '123', '2023-12-11 14:11:59'),
(26, 'aaaa', '$2y$10$iXziInfplXpautuAwNqus.sx35FH6.Z3nWKOtP3rwig8LVE3lcKrG', 'aaaa', '123123', 'sdasdas', '123@123', 'aaaaa', '2023-12-13 15:30:35');

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
(14, 25, 'CLaudio', 'poerez', '12312312', 'Gerente General', 'ejemplo@gmail.com', '$2y$10$/tEUcp50wx7uLw.n8AzoK.s4iFUeg0Q6REJqBSahETC1PMFIK5WMe');

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
(12, 25, 'Xinxilla', 'Obando', '20010126-k', 'Residente de Obras', 'callito@123', '$2y$10$fJ9W8HYz3KNJzm7ym7vHR.pbV6zzvixle5A1K.kGewHA8cCDL9Wb2');

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
  `direccion` varchar(255) DEFAULT NULL,
  `solicitado_por` varchar(255) DEFAULT NULL,
  `total_neto` int(11) DEFAULT NULL,
  `iva` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `nombre_pago` varchar(255) DEFAULT NULL,
  `rut_pago` varchar(20) DEFAULT NULL,
  `correo_pago` varchar(100) DEFAULT NULL,
  `banco` varchar(100) DEFAULT NULL,
  `numero_cuenta` varchar(50) DEFAULT NULL,
  `archivo_cotizacion` varchar(255) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'En espera',
  `fecha_pago` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes_orden_compra`
--

INSERT INTO `solicitudes_orden_compra` (`id_solicitud`, `id_residente`, `id_empresa`, `fecha_creacion`, `obra`, `direccion`, `solicitado_por`, `total_neto`, `iva`, `total`, `metodo_pago`, `nombre_pago`, `rut_pago`, `correo_pago`, `banco`, `numero_cuenta`, `archivo_cotizacion`, `estado`, `fecha_pago`) VALUES
(6, 12, 25, '2023-12-11 19:27:28', 'Nueva Obra', 'Pindapulli 195', 'Pihuel', 1500, 285, 1785, 'efectivo', 'claudio', '20010126-k', 'cayoperez98@gmail.com', NULL, NULL, '../cotizacion_solicitudes/LOGO APP WEB.png', 'En espera', NULL),
(9, 12, 25, '2023-12-12 01:15:53', 'Obra ejemplo', 'Huenteo 725', 'Claudio', 1500, 285, 1785, 'efectivo', 'claudio', '20010126-k', 'cayoperez98@gmail.com', NULL, NULL, '../cotizacion_solicitudes/cotizacion_20231212021553_6577b449c241b.png', 'En espera', NULL),
(10, 12, 25, '2023-12-12 03:03:27', 'nn', 'nn', 'nn', 400, 76, 476, 'efectivo', '', '', '', NULL, NULL, NULL, 'En espera', NULL),
(11, 12, 25, '2023-12-12 03:13:51', 'ss', 'ss', 'ss', 800, 152, 952, 'credito', '', '', '', NULL, NULL, '../cotizacion_solicitudes/cotizacion_20231212041351_6577cfef9c69f.png', 'En espera', NULL),
(12, 12, 25, '2023-12-12 03:42:22', 'ww', 'ww', 'ww', 1100, 209, 1309, 'credito', 'Vww', 'www', 'w@w', 'Falabella', 'wwww', '../cotizacion_solicitudes/cotizacion_20231212044222_6577d69e80b01.png', 'Aprobado', '30'),
(13, 12, 25, '2023-12-12 03:48:57', 'bb', 'bb', 'bb', 500, 95, 595, 'efectivo', 'bb', 'bb', 'bb', 'bb', 'bb', '../cotizacion_solicitudes/cotizacion_20231212044857_6577d82976863.png', 'En espera', '15'),
(14, 12, 25, '2023-12-12 03:52:57', 'xxxx', 'xxx', 'xxxxx', 0, 0, 0, 'efectivo', 'xxxx', 'xxxxx', 'xxxx', 'xxxxxx', 'xxxxxxx', '../cotizacion_solicitudes/cotizacion_20231212045257_6577d9198a6d4.png', 'En espera', NULL),
(15, 12, 25, '2023-12-12 04:00:33', '123', '123', '123', 600, 114, 714, 'efectivo', '', '', '', '', '', NULL, 'En espera', NULL),
(16, 12, 25, '2023-12-12 04:04:43', 'qqqq', 'qq', 'qqq', 600, 114, 714, 'efectivo', '', '', '', '', '', NULL, 'En espera', NULL),
(17, 12, 25, '2023-12-12 04:18:31', '', '', '', 0, 0, 0, 'efectivo', '', '', '', '', '', NULL, 'En espera', NULL),
(18, 12, 25, '2023-12-12 04:20:28', '', '', '', 0, 0, 0, 'efectivo', '', '', '', '', '', NULL, 'En espera', NULL),
(19, 12, 25, '2023-12-12 04:27:54', 'qweqw', 'qweq', 'qwe', 4, 1, 5, 'efectivo', '', '', '', '', '', '../cotizacion_solicitudes/cotizacion_20231212052754_6577e14a98501.png', 'En espera', NULL),
(20, 12, 25, '2023-12-12 04:44:07', 'xxxx', 'xxxx', 'xxxxx', 1, 0, 1, 'credito', 'xx', 'xx', 'xx@xx', 'xx', 'xx', '../cotizacion_solicitudes/cotizacion_20231212054407_6577e51723f88.png', 'En espera', '45'),
(21, 12, 25, '2023-12-12 05:11:52', 'aaaaaa', 'aaaaaaa', 'aaaaa', 2, 0, 2, 'efectivo', 'aaa', 'aa', 'aa@a', 'aa', 'aa', '../cotizacion_solicitudes/cotizacion_20231212061152_6577eb983150b.png', 'En espera', NULL),
(22, 12, 25, '2023-12-12 05:12:34', 'bb', 'bb', 'bb', 6, 1, 7, 'credito', 'bb', 'bb', 'b@b', 'bbb', 'bbb', '../cotizacion_solicitudes/cotizacion_20231212061234_6577ebc266acb.png', 'En espera', '30'),
(23, 10, 19, '2023-12-13 15:02:46', 'Obra 3', 'Tenaun 145', 'Valentina', 13, 2, 16, 'efectivo', 'Claudio', '20010126-k', 'cayoperesz@gmail.com', 'Copeuch', '20010126', '../cotizacion_solicitudes/cotizacion_20231213160246_6579c79621b1e.png', 'En espera', NULL);

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
(9, 19, 'bb', 'aa', 'vv', 'Visitador de Obras', 'a@a', '$2y$10$4TX4TljVkeezhiP5jSPxlOMK7NZAul9n0mNQhNQCIyCtxV7NoF.7K'),
(10, 26, 'xxxx', 'xxxxx', 'xxxxxx', 'Visitador de Obras', 'x@x', '$2y$10$1NPar.Tp84SRdxYlP8FUfOPkfbDFXPhM6ihmfQiTIsgMW0ODMPsHW');

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
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `gerentes_generales`
--
ALTER TABLE `gerentes_generales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `residentes_obra`
--
ALTER TABLE `residentes_obra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `solicitudes_orden_compra`
--
ALTER TABLE `solicitudes_orden_compra`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `visitadores_obra`
--
ALTER TABLE `visitadores_obra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
