-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2017 a las 12:23:50
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ts5`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra_servicios`
--

CREATE TABLE IF NOT EXISTS `factura_compra_servicios` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFacturaCompra` bigint(20) NOT NULL,
  `CuentaPUC_Servicio` bigint(20) NOT NULL,
  `Nombre_Cuenta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Concepto_Servicio` text COLLATE utf8_spanish2_ci NOT NULL,
  `Subtotal_Servicio` double NOT NULL,
  `Impuesto_Servicio` double NOT NULL,
  `Total_Servicio` double NOT NULL,
  `Tipo_Impuesto` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
