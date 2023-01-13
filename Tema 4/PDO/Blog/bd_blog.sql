-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-01-2023 a las 08:56:26
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_blog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `valor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `valor`) VALUES
(1, 'Deportes'),
(2, 'Economía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `idComentario` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idNoticia` int(11) DEFAULT NULL,
  `estado` enum('sin validar','apto') DEFAULT 'sin validar',
  `fCreacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `idNoticia` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `copete` varchar(255) DEFAULT NULL,
  `cuerpo` text DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `fPublicacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fModificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `titulo`, `copete`, `cuerpo`, `idUsuario`, `idCategoria`, `fPublicacion`, `fCreacion`, `fModificacion`) VALUES
(1, 'El Barça entra en bucle: repite errores en cada partido', 'Es incapaz de cerrar los partidos a pesar de ponerse por delante en el marcador\r\n\r\n', 'Al Barcelona le persiguen los mismos errores desde que se reanudó la competición en el mes de diciembre. Marca pronto, se adelanta en el partido, pero es incapaz de cerrar la contienda y le empatan una y otra vez. Le sucedió en el primer partido frente al Espanyol. El gol inicial fue neutralizado por el de Joselu en la segunda parte. Dos puntos que volaron en Liga. El Barça fue mejor, pero no ganó.', 2, 1, '2023-01-13 07:51:59', '2023-01-13 07:50:40', '2023-01-13 07:51:59'),
(2, 'AIE: nueva economía energética limpia frente a la falta de gas', 'Frente a la disminución del suministro de gas, una de las soluciones que propone la Agencia Internacional de la Energía es la nueva economía energética limpia que está surgiendo.', '\"Los países pueden expandir las cadenas de suministro de energía limpia, desarrollar la fabricación de energía limpia y beneficiarse de la nueva economía energética que está surgiendo\", se asegura en la última comunicación de la Agencia Internacional de la Energía (AIE), que próximamamente dará a conocer su nuevo informe Energy Technology Perspectives.\r\n\r\nSus últimas investigaciones han mostrado cómo la Unión Europea enfrenta un riesgo de escasez de gas natural en este invierno, \"pero esto puede evitarse mediante mayores esfuerzos para mejorar la eficiencia energética, desplegar energías renovables, instalar bombas de calor, promover el ahorro de energía y asegurar suministros adicionales de gas\".', 1, 2, '2023-01-13 07:51:38', '2023-01-13 07:50:40', '2023-01-13 07:51:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  `clave` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `tipo` enum('admin','normal') DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `clave`, `nombre`, `email`, `tipo`) VALUES
(1, 'miau', '50941bf460efcb1356249a2e5018f8c8', 'miau', 'miau@miau.es', 'admin'),
(2, 'javiakasino', '6e38372e29dfb46433e8a6473e84d641', 'Javier Parodi', 'javiakasino@miau.es', 'normal');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idComentario`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idNoticia` (`idNoticia`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticia`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`idNoticia`) REFERENCES `noticias` (`idNoticia`);

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `noticias_ibfk_2` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`idCategoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
