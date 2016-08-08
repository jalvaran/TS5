-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-08-2016 a las 13:28:22
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
-- Estructura de tabla para la tabla `empresapro_resoluciones_facturacion`
--

CREATE TABLE IF NOT EXISTS `empresapro_resoluciones_facturacion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreInterno` text COLLATE utf8_spanish2_ci NOT NULL,
  `NumResolucion` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NumSolicitud` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Tipo` varchar(4) COLLATE utf8_spanish2_ci NOT NULL,
  `Factura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Prefijo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Desde` int(16) NOT NULL,
  `Hasta` int(16) NOT NULL,
  `FechaVencimiento` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idEmpresaPro` int(11) NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'OC: Ocupada',
  `Completada` varchar(2) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'NO',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
