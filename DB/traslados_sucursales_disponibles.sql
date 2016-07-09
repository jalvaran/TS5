-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2016 a las 09:39:35
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `softcontech_v5`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslados_sucursales_disponibles`
--

CREATE TABLE IF NOT EXISTS `traslados_sucursales_disponibles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idEmpresaPro` int(11) NOT NULL,
  `Visible` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Actual` bit(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `traslados_sucursales_disponibles`
--

INSERT INTO `traslados_sucursales_disponibles` (`ID`, `Nombre`, `Ciudad`, `Direccion`, `idEmpresaPro`, `Visible`, `Actual`) VALUES
(1, 'INIFINITO YOTOCO', 'YOTOCO', '', 1, 'SI', b'0'),
(2, 'INIFINITO BUGA', 'BUGA', '', 1, 'SI', b'1'),
(3, 'INIFINITO GINEBRA', 'GINEBRA', '', 1, 'SI', b'0'),
(4, 'INIFINITO SAN PEDRO', 'SAN PEDRO', '', 1, 'SI', b'0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
