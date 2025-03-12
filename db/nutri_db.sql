-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-02-2025 a las 01:34:34
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
-- Base de datos: `nutri_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentos`
--

CREATE TABLE `alimentos` (
  `ID_alimentos` int(11) NOT NULL,
  `nombre_alimento` varchar(100) NOT NULL,
  `ID_grupos` int(11) NOT NULL,
  `descripcion_alimento` varchar(255) NOT NULL,
  `calorias` decimal(6,2) NOT NULL,
  `proteinas` decimal(6,2) NOT NULL,
  `carbohidratos` decimal(6,2) NOT NULL,
  `fibra` decimal(6,2) NOT NULL,
  `grasas` decimal(6,2) NOT NULL,
  `imagen_alimento` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alimentos`
--

INSERT INTO `alimentos` (`ID_alimentos`, `nombre_alimento`, `ID_grupos`, `descripcion_alimento`, `calorias`, `proteinas`, `carbohidratos`, `fibra`, `grasas`, `imagen_alimento`) VALUES
(1, 'Yogurt Griego Natural', 1, 'Producto lácteo espeso y cremoso que se obtiene al filtrar el yogur para quitar el suero.  \r\nEs más cremoso y menos dulce que el yogur común. ', 82.40, 6.64, 5.92, 0.10, 3.60, 'https://imag.bonviveur.com/yogur-griego.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_alimentos`
--

CREATE TABLE `grupos_alimentos` (
  `ID_grupos` int(11) NOT NULL,
  `nombre_grupo` varchar(50) NOT NULL,
  `descripcion_grupo` text NOT NULL,
  `imagen_grupo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos_alimentos`
--

INSERT INTO `grupos_alimentos` (`ID_grupos`, `nombre_grupo`, `descripcion_grupo`, `imagen_grupo`) VALUES
(1, 'Lácteos', 'El grupo de los lácteos incluye alimentos como la leche (derivados de la leche de mamíferos, como la vaca, la cabra, la oveja o la búfala) y sus derivados procesados.\r\nSon productos altamente perecederos que deben mantener rigurosamente la cadena de frío.\r\nEjemplos de lácteos: leche, yogur, queso, manteca, cuajada, dulce de leche, helados, postres, etc.', 'https://www.webconsultas.com/sites/default/files/styles/wc_adaptive_image__medium/public/media/0d/articulos/productos-lacteos.jpg.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_usuario`, `nombre_usuario`, `contraseña`) VALUES
(1, 'webadmin', '$2y$10$F4f6c9Fy7GIlyJKO5mGcD.zUcibqsUEITjpV6vEKNpMoDwXUyFDWe');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  ADD PRIMARY KEY (`ID_alimentos`),
  ADD KEY `alimentos_ibfk_1` (`ID_grupos`);

--
-- Indices de la tabla `grupos_alimentos`
--
ALTER TABLE `grupos_alimentos`
  ADD PRIMARY KEY (`ID_grupos`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  MODIFY `ID_alimentos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `grupos_alimentos`
--
ALTER TABLE `grupos_alimentos`
  MODIFY `ID_grupos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alimentos`
--
ALTER TABLE `alimentos`
  ADD CONSTRAINT `alimentos_ibfk_1` FOREIGN KEY (`ID_grupos`) REFERENCES `grupos_alimentos` (`ID_grupos`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
