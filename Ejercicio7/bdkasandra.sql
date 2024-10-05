-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2024 a las 05:26:51
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
-- Base de datos: `bdkasandra`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `ci` varchar(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `paterno` varchar(50) DEFAULT NULL,
  `materno` varchar(50) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `contraseña` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `ci`, `nombre`, `paterno`, `materno`, `usuario`, `contraseña`) VALUES
(1, '12345678', 'Juan', 'Perez', 'Gutierrez', 'adminjuanp', 'admin1234'),
(2, '87654321', 'Elena', 'Garcia', 'Paredes', 'adminelenag', 'admin5678');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

CREATE TABLE `distrito` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `distrito`
--

INSERT INTO `distrito` (`id`, `nombre`) VALUES
(1, 'Centro'),
(2, 'Cotahuma'),
(3, 'San Antonio'),
(4, 'Periférica'),
(5, 'Max Paredes'),
(6, 'Sur'),
(7, 'Mallasa'),
(8, 'Miraflores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `ci` varchar(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `paterno` varchar(50) DEFAULT NULL,
  `materno` varchar(50) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `contraseña` varchar(50) NOT NULL,
  `id_admi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `ci`, `nombre`, `paterno`, `materno`, `usuario`, `contraseña`, `id_admi`) VALUES
(1, '12345678', 'Juan', 'Perez', 'Gutierrez', 'juanp', '12345', 2),
(2, '87654321', 'Elena', 'Garcia', 'Paredes', 'elenag', 'egp8756', 1),
(3, '74125896', 'Carlos', 'Sánchez', 'Vega', 'carloss', 'user0001', 1),
(4, '85236974', 'María', 'Fernández', 'Lopez', 'mariaf', 'user0002', 1),
(5, '96385274', 'Ana', 'Rodríguez', 'Castro', 'anar', 'user0003', 2),
(6, '15975348', 'Pedro', 'Romero', 'Martínez', 'pedror', 'user0004', 2),
(7, '75395148', 'Laura', 'Jiménez', 'Hernández', 'lauraj', 'user0005', 2),
(8, '75315948', 'David', 'Castro', 'González', 'davidc', 'user0006', 1),
(9, '95175362', 'Sofía', 'Rivas', 'Mendoza', 'sofiar', 'user0007', 2),
(10, '12378945', 'Ricardo', 'Lopez', 'Mendez', 'ricardol', 'user0008', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedad`
--

CREATE TABLE `propiedad` (
  `id` int(11) NOT NULL,
  `zona` varchar(100) DEFAULT NULL,
  `xini` decimal(10,2) DEFAULT NULL,
  `yini` decimal(10,2) DEFAULT NULL,
  `xfin` decimal(10,2) DEFAULT NULL,
  `yfin` decimal(10,2) DEFAULT NULL,
  `superficie` decimal(10,2) DEFAULT NULL,
  `distrito` varchar(50) DEFAULT NULL,
  `id_propietario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `propiedad`
--

INSERT INTO `propiedad` (`id`, `zona`, `xini`, `yini`, `xfin`, `yfin`, `superficie`, `distrito`, `id_propietario`) VALUES
(10001, 'El Tejar', 15.50, 24.10, 13.50, 25.10, 100.00, 'Max Paredes', 1),
(10002, 'Villa Pabón', 18.30, 19.50, 19.30, 20.50, 90.00, 'Cotahuma', 2),
(10003, 'San Miguel', 13.70, 15.90, 14.70, 16.90, 102.00, 'Sur', 3),
(20001, 'Villa Copacabana', 22.30, 23.40, 23.30, 13.50, 120.00, 'San Antonio', 3),
(20002, 'Amor de Dios', 16.40, 21.20, 17.40, 22.20, 110.00, 'Mallasa', 3),
(20003, 'Sopocachi', 14.00, 18.00, 15.00, 19.00, 85.00, 'Centro', 4),
(20004, 'Miraflores Alto', 16.50, 18.70, 17.50, 21.30, 88.00, 'Miraflores', 5),
(20005, 'Achumani', 15.40, 21.50, 15.70, 22.50, 105.00, 'Sur', 6),
(20006, 'Villa Copacabana', 2.00, 2.00, 2.00, 22.00, 2.00, 'San Antonio', 1),
(30001, 'Callampaya', 17.10, 21.25, 17.25, 22.35, 80.30, 'Max Paredes', 7),
(30002, 'Tembladerani', 12.30, 15.50, 13.30, 16.50, 75.00, 'Cotahuma', 8),
(30003, 'Irpavi', 15.60, 21.80, 16.70, 22.90, 73.00, 'Sur', 9),
(30004, 'Aranjuez', 13.50, 22.40, 14.60, 23.50, 100.00, 'Mallasa', 10),
(30005, 'Mallasilla', 17.60, 24.30, 18.30, 25.30, 85.30, 'Mallasa', 3),
(30006, 'Gran Poder', 16.50, 21.10, 17.50, 22.10, 120.00, 'Max Paredes', 4),
(30007, 'Bajo Llojeta', 20.50, 25.60, 21.50, 26.60, 80.00, 'Cotahuma', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `distrito_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `zona`
--

INSERT INTO `zona` (`id`, `nombre`, `distrito_id`) VALUES
(1, 'El Rosario', 1),
(2, 'Miraflores', 1),
(3, 'San Sebastián', 1),
(4, 'San Pedro', 1),
(5, 'Central', 1),
(6, 'Sopocachi', 1),
(7, 'San Jorge', 1),
(8, '6 de Agosto', 1),
(9, 'Sopocachi Alto', 2),
(10, 'Llojeta', 2),
(11, 'Tembladerani', 2),
(12, 'Villa Pabón', 2),
(13, 'Bajo Llojeta', 2),
(14, 'Alto Tacagua', 2),
(15, 'Pampahasi', 3),
(16, 'Villa Armonía', 3),
(17, 'Villa Copacabana', 3),
(18, 'Kupini', 3),
(19, 'Valle Hermoso', 3),
(20, 'Achachicala', 4),
(21, 'Villa Fátima', 4),
(22, 'La Portada', 4),
(23, 'Villa El Carmen', 4),
(24, 'Chuquiaguillo', 4),
(25, 'Gran Poder', 5),
(26, 'El Tejar', 5),
(27, 'Munaypata', 5),
(28, 'Chamoco Chico', 5),
(29, 'Ciudadela Ferroviaria', 5),
(30, 'Callampaya', 5),
(31, 'Calacoto', 6),
(32, 'San Miguel', 6),
(33, 'Obrajes', 6),
(34, 'Achumani', 6),
(35, 'Cota Cota', 6),
(36, 'Irpavi', 6),
(37, 'Següencoma', 6),
(38, 'Mallasilla', 7),
(39, 'Aranjuez', 7),
(40, 'Jupapina', 7),
(41, 'Amor de Dios', 7),
(42, 'Miraflores Bajo', 8),
(43, 'Miraflores Alto', 8),
(44, 'Villa San Antonio', 8),
(45, 'Villa Salomé', 8),
(46, 'Las Lomas', 8);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ci` (`ci`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `fk_persona_administrador` (`id_admi`);

--
-- Indices de la tabla `propiedad`
--
ALTER TABLE `propiedad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_propietario` (`id_propietario`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `distrito_id` (`distrito_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `distrito`
--
ALTER TABLE `distrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `zona`
--
ALTER TABLE `zona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_persona_administrador` FOREIGN KEY (`id_admi`) REFERENCES `administrador` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `propiedad`
--
ALTER TABLE `propiedad`
  ADD CONSTRAINT `propiedad_ibfk_1` FOREIGN KEY (`id_propietario`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `zona`
--
ALTER TABLE `zona`
  ADD CONSTRAINT `zona_ibfk_1` FOREIGN KEY (`distrito_id`) REFERENCES `distrito` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
