-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-07-2025 a las 00:29:40
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
-- Base de datos: `barber`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barberos`
--

CREATE TABLE `barberos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `barberos`
--

INSERT INTO `barberos` (`id`, `nombre`, `especialidad`, `estado`) VALUES
(1, 'Luis', 'Fade y corte clásico', 1),
(2, 'Marcos', 'Diseños y barba', 1),
(3, 'Sofi', 'Corte clásico y afeitado premium', 1),
(4, 'kevin', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `venta_id`, `producto_id`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 2, 1, 2200.00),
(2, 2, 1, 1, 1500.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id`, `nombre`) VALUES
(1, 'Efectivo'),
(2, 'Mercado Pagopo'),
(3, 'Débito'),
(4, 'Crédito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `detalles` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `detalles`, `precio`, `imagen`) VALUES
(1, 'Cera para Cabello', 'Fijación fuerte y acabado natural. Ideal para estilos modernos y clásicos. No deja residuos y se elimina fácilmente con agua.', 'Modo de uso: Aplicar una pequeña cantidad sobre el cabello seco o húmedo y peinar a gusto. Ingredientes: Cera de abejas, aceites naturales, fragancia. Recomendado para: Todo tipo de cabello.', 1500.00, 'cera.jpg\r\n'),
(2, 'Aceite para Barba', 'Hidrata y suaviza la barba, aportando brillo y un aroma fresco. Previene la irritación y la resequedad de la piel.', 'Modo de uso: Colocar unas gotas en la palma de la mano y masajear la barba y la piel. Ingredientes: Aceite de argán, jojoba, vitamina E, fragancia. Recomendado para: Barbas de cualquier largo.', 2200.00, 'aceiteBarba.png'),
(3, 'Shampoo Especial', 'Limpieza profunda para cabello y barba. Fórmula suave, sin sulfatos, ideal para uso diario y todo tipo de piel.', 'Modo de uso: Aplicar sobre el cabello o barba mojados, masajear suavemente y enjuagar. Ingredientes: Extractos naturales, sin sulfatos, sin parabenos. Recomendado para: Uso diario.', 1800.00, 'ShampooEspecial.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `descripcion`, `precio`) VALUES
(1, 'Corte Clásico', 'Corte tradicional y profesional', 2500.00),
(2, 'Diseños & Fade', 'Degradados con diseño artístico', 3500.00),
(3, 'Afeitado Premium', 'Afeitado con toalla caliente y productos especiales', 3000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `servicio` int(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `barbero` int(100) DEFAULT NULL,
  `whatsapp` tinyint(1) DEFAULT 0,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('activo','cancelado') NOT NULL DEFAULT 'activo',
  `cancelacion_motivo` text DEFAULT NULL,
  `metodo_pago` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`id`, `usuario_id`, `fecha`, `hora`, `servicio`, `descripcion`, `barbero`, `whatsapp`, `creado_en`, `estado`, `cancelacion_motivo`, `metodo_pago`, `precio`) VALUES
(1, 2, '2025-07-25', '23:42:00', 1, '0', 4, 1, '2025-07-19 03:39:06', 'cancelado', NULL, NULL, NULL),
(2, 2, '2025-07-23', '21:42:00', 1, '0', 2, 1, '2025-07-19 03:41:10', 'cancelado', NULL, NULL, NULL),
(4, 3, '2025-07-24', '16:41:00', 2, '0', 4, 1, '2025-07-19 22:41:56', 'cancelado', NULL, NULL, NULL),
(5, 3, '2025-07-22', '20:58:00', 1, '0', 4, 1, '2025-07-19 22:52:44', 'cancelado', NULL, NULL, NULL),
(6, 3, '2025-07-25', '15:10:00', 2, '0', 1, 1, '2025-07-19 23:10:26', 'cancelado', NULL, NULL, NULL),
(7, 3, '2025-07-20', '17:55:00', 3, '0', NULL, 1, '2025-07-19 23:23:18', 'cancelado', NULL, NULL, NULL),
(8, 3, '2025-08-15', '12:55:00', 1, '0', 4, 1, '2025-07-19 23:32:27', 'cancelado', NULL, NULL, NULL),
(9, 2, '2025-07-23', '14:10:00', 1, '0', NULL, 1, '2025-07-20 19:36:56', 'cancelado', NULL, NULL, NULL),
(10, 2, '2025-07-22', '10:50:00', 3, '0', 3, 1, '2025-07-20 20:03:10', 'cancelado', NULL, NULL, NULL),
(11, 4, '2025-07-22', '10:50:00', 1, '0', NULL, 0, '2025-07-20 20:04:41', 'cancelado', NULL, NULL, NULL),
(12, 4, '2025-07-22', '14:35:00', 1, '0', NULL, 0, '2025-07-20 21:49:44', 'cancelado', NULL, NULL, NULL),
(13, 2, '2025-07-22', '14:35:00', 3, '0', NULL, 0, '2025-07-20 21:50:43', 'cancelado', NULL, NULL, NULL),
(14, 2, '2025-07-22', '11:40:00', 1, '0', NULL, 0, '2025-07-21 06:46:38', 'cancelado', NULL, NULL, NULL),
(15, 2, '2025-07-23', '12:05:00', 2, '0', 2, 0, '2025-07-22 02:47:38', 'cancelado', NULL, NULL, NULL),
(16, 2, '2025-07-22', '11:40:00', 2, '0', 1, 1, '0000-00-00 00:00:00', 'cancelado', NULL, 2, NULL),
(17, 2, '2025-08-01', '17:30:00', 1, '0', 2, 1, '0000-00-00 00:00:00', 'cancelado', NULL, 3, NULL),
(20, 2, '0000-00-00', '00:00:00', 2, '0', 2, 0, '0000-00-00 00:00:00', 'activo', NULL, 4, NULL),
(21, 10, '2025-07-26', '10:25:00', 2, '0', 2, 1, '0000-00-00 00:00:00', 'cancelado', NULL, 4, NULL),
(22, 10, '2025-07-26', '10:25:00', 1, '0', NULL, 1, '0000-00-00 00:00:00', 'cancelado', NULL, 3, 2500.00),
(23, 10, '2025-07-26', '10:25:00', 1, '0', 1, 1, '0000-00-00 00:00:00', 'activo', NULL, 2, 2500.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol` enum('cliente','admin') NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `fecha`, `telefono`, `email`, `pass`, `creado_en`, `rol`) VALUES
(1, 'alejo', 'perez', '2025-07-06', '2343423423', 'p@gmail.com', 'acosta10', '2025-07-17 21:23:40', 'cliente'),
(2, 'juan', 'pe', '2025-07-11', '45454254', 'h@gmail.com', '$2y$10$rfDbDozSUZn2enPtbmDtWODEHvihm3YvKyQC87xWJNFBljH6K8hzC', '2025-07-17 21:35:33', 'cliente'),
(3, 'pan', 'quesp', '2009-05-05', '2321313123', 'pan@gmail.com', '$2y$10$SrU7fbS8oBjRCqap8rIHRuz9VGry8KZvXApVbSjwFS6ZOMXmY44Mu', '2025-07-19 17:16:42', 'cliente'),
(4, 'pepe', 'dd', '2025-07-01', '231232312312', 'pepe@gmail.com', '$2y$10$vlB8B6JNoJGhnMKdiyTZsuQdk8XuaVaYMkIBn7OHQlRQFDveggj6.', '2025-07-20 15:03:47', 'cliente'),
(5, 'facu', 'asc', '2025-07-02', '343242432', 'fa@gmail.com', 'acosta10', '2025-07-20 17:43:19', 'admin'),
(7, 'facu', 'asc', '2025-07-02', '343242432', 'fac@gmail.com', 'acosta10', '2025-07-20 17:43:45', 'admin'),
(8, 'adsasd', 'sds', '2025-07-10', '234314324', 'facc@gmail.com', '$2y$10$2mRpSO13ZPrJgnASZMX9meJu7SnrruHE/yfReNULpgXIKImjkdeKq', '2025-07-20 17:44:49', 'admin'),
(9, 'juan', '', '0000-00-00', '', 'w@gmail.com', '$2y$10$JgyTGhXyY9g0Ib9QG7zJPe7acPDcfsus5buk0L/7NEO45.MIMwUxW', '2025-07-20 23:09:59', 'admin'),
(10, 'queso', 'sss', '2025-07-17', '324324324', 'queso@gmail.com', '$2y$10$jjUmPLOi5nQ.9U0E10h5KO7rpDRcJu2eJgOyw0srP8mZGAtIZw9D.', '2025-07-20 23:17:17', 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `usuario_id`, `total`, `fecha`) VALUES
(1, 2, 2200.00, '2025-07-27 19:24:42'),
(2, 2, 1500.00, '2025-07-27 19:28:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `barberos`
--
ALTER TABLE `barberos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `servicio` (`servicio`,`barbero`),
  ADD KEY `barbero` (`barbero`),
  ADD KEY `metodo_pago_2` (`metodo_pago`),
  ADD KEY `metodo_pago_3` (`metodo_pago`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `barberos`
--
ALTER TABLE `barberos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `turnos`
--
ALTER TABLE `turnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD CONSTRAINT `turnos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `turnos_ibfk_2` FOREIGN KEY (`barbero`) REFERENCES `barberos` (`id`),
  ADD CONSTRAINT `turnos_ibfk_3` FOREIGN KEY (`servicio`) REFERENCES `servicios` (`id`),
  ADD CONSTRAINT `turnos_ibfk_4` FOREIGN KEY (`metodo_pago`) REFERENCES `metodos_pago` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
