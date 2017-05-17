-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2017 a las 13:49:55
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
-- Estructura de tabla para la tabla `abonos_libro`
--

CREATE TABLE IF NOT EXISTS `abonos_libro` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Cantidad` float NOT NULL,
  `idLibroDiario` bigint(20) NOT NULL,
  `idComprobanteContable` bigint(20) NOT NULL,
  `TipoAbono` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activos`
--

CREATE TABLE IF NOT EXISTS `activos` (
  `idActivos` int(16) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreAct` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Marca` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Serie` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorEstimado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Bodega` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idActivos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `act_movimientos`
--

CREATE TABLE IF NOT EXISTS `act_movimientos` (
  `idAct_Movimientos` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Destino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `MotivoMovimiento` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `NumOrden` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `BodegaDestino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idActivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idAct_Movimientos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `act_ordenes`
--

CREATE TABLE IF NOT EXISTS `act_ordenes` (
  `idAct_Ordenes` int(16) NOT NULL AUTO_INCREMENT,
  `NumOrden` int(16) NOT NULL,
  `idAct_Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Destino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cerrada` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idAct_Ordenes`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `act_pre_movimientos`
--

CREATE TABLE IF NOT EXISTS `act_pre_movimientos` (
  `idAct_Movimientos` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Destino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `MotivoMovimiento` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `NumOrden` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `BodegaDestino` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idActivo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idAct_Movimientos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `act_pre_ordenes`
--

CREATE TABLE IF NOT EXISTS `act_pre_ordenes` (
  `idAct_Ordenes` int(16) NOT NULL DEFAULT '0',
  `NumOrden` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idAct_Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Entrega` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Recibe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alertas`
--

CREATE TABLE IF NOT EXISTS `alertas` (
  `idAlertas` int(45) NOT NULL AUTO_INCREMENT,
  `AlertaTipo` varchar(45) NOT NULL,
  `Mensaje` varchar(500) NOT NULL,
  `Cartera_idCartera` varchar(45) NOT NULL,
  `PagosProgram_idPagosProgram` varchar(45) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idAlertas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autorizaciones_generales`
--

CREATE TABLE IF NOT EXISTS `autorizaciones_generales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Proceso` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Clave` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE IF NOT EXISTS `bodega` (
  `idBodega` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idServidor` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idBodega`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE IF NOT EXISTS `cajas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Base` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUCEfectivo` bigint(20) NOT NULL,
  `CuentaPUCCheques` bigint(20) NOT NULL,
  `CuentaPUCOtros` bigint(20) NOT NULL,
  `CuentaPUCIVAEgresos` bigint(20) NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `idResolucionDian` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas_aperturas_cierres`
--

CREATE TABLE IF NOT EXISTS `cajas_aperturas_cierres` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Usuario` int(11) NOT NULL,
  `idCaja` int(11) NOT NULL,
  `Efectivo` double NOT NULL,
  `Devueltas` double NOT NULL,
  `TotalAbonos` double NOT NULL,
  `AbonosCreditos` double NOT NULL,
  `AbonosSisteCredito` double NOT NULL,
  `TotalEgresos` double NOT NULL,
  `TotalEfectivo` double NOT NULL,
  `TotalVentas` double NOT NULL,
  `TotalVentasContado` double NOT NULL,
  `TotalVentasCredito` double NOT NULL,
  `TotalVentasSisteCredito` double NOT NULL,
  `TotalDevoluciones` double NOT NULL,
  `TotalTarjetas` double NOT NULL,
  `TotalCheques` double NOT NULL,
  `TotalOtros` double NOT NULL,
  `TotalEntrega` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartera`
--

CREATE TABLE IF NOT EXISTS `cartera` (
  `idCartera` int(11) NOT NULL AUTO_INCREMENT,
  `Facturas_idFacturas` varchar(45) NOT NULL DEFAULT '0',
  `FechaIngreso` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Fecha en la que ingresa a Cartera',
  `FechaVencimiento` date NOT NULL DEFAULT '0000-00-00',
  `DiasCartera` int(11) DEFAULT NULL,
  `idCliente` varchar(45) NOT NULL DEFAULT '0',
  `RazonSocial` varchar(100) DEFAULT NULL,
  `Telefono` varchar(45) NOT NULL,
  `Contacto` varchar(45) NOT NULL,
  `TelContacto` varchar(45) NOT NULL,
  `TotalFactura` double NOT NULL,
  `TotalAbonos` double NOT NULL,
  `Saldo` double NOT NULL DEFAULT '0',
  `Observaciones` text,
  `TipoCartera` varchar(45) NOT NULL DEFAULT 'Interna',
  `idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCartera`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centrocosto`
--

CREATE TABLE IF NOT EXISTS `centrocosto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierres_contables`
--

CREATE TABLE IF NOT EXISTS `cierres_contables` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciuu`
--

CREATE TABLE IF NOT EXISTS `ciuu` (
  `Codigo` int(11) NOT NULL,
  `Descripcion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasecuenta`
--

CREATE TABLE IF NOT EXISTS `clasecuenta` (
  `PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clase` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `idClientes` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Documento` int(11) NOT NULL,
  `Num_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DV` int(11) NOT NULL,
  `Lugar_Expedicion_Documento` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Segundo_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Otros_Nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RazonSocial` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cod_Dpto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Pais_Domicilio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Contacto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `TelContacto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CIUU` int(11) NOT NULL,
  `Cupo` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idClientes`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cod_departamentos`
--

CREATE TABLE IF NOT EXISTS `cod_departamentos` (
  `Cod_dpto` int(11) NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Cod_dpto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cod_documentos`
--

CREATE TABLE IF NOT EXISTS `cod_documentos` (
  `Codigo` int(11) NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `Codigo` (`Codigo`),
  KEY `Codigo_2` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cod_municipios_dptos`
--

CREATE TABLE IF NOT EXISTS `cod_municipios_dptos` (
  `ID` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Dpto` int(11) NOT NULL,
  `Departamento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cod_paises`
--

CREATE TABLE IF NOT EXISTS `cod_paises` (
  `Codigo` int(11) NOT NULL,
  `Pais` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colaboradores`
--

CREATE TABLE IF NOT EXISTS `colaboradores` (
  `idColaboradores` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Identificacion` bigint(20) DEFAULT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Contacto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NumContacto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cargo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `SalarioBasico` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idColaboradores`),
  UNIQUE KEY `Identificacion` (`Identificacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colaboradores_ventas`
--

CREATE TABLE IF NOT EXISTS `colaboradores_ventas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Total` float NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `col_registrohoras`
--

CREATE TABLE IF NOT EXISTS `col_registrohoras` (
  `IdColRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `IdColaborador` int(11) NOT NULL,
  `RegistroFecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RegistroHora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `EntradaSalida` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`IdColRegistro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comisiones`
--

CREATE TABLE IF NOT EXISTS `comisiones` (
  `idComisiones` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comisionesporventas`
--

CREATE TABLE IF NOT EXISTS `comisionesporventas` (
  `idComisionesPorVentas` int(11) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci DEFAULT '5105',
  `NombreCuenta` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Colaboradores_idColaboradores` int(11) NOT NULL,
  `Ventas_NumVenta` int(11) NOT NULL,
  `Paga` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComisionesPorVentas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE IF NOT EXISTS `compras` (
  `idCompras` int(11) NOT NULL AUTO_INCREMENT,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci DEFAULT '62',
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NumFactura` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Retenciones` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoPago` varchar(45) COLLATE utf8_spanish_ci DEFAULT 'Contado',
  `Pagada` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Proveedores_idProveedores` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCompras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras_activas`
--

CREATE TABLE IF NOT EXISTS `compras_activas` (
  `idComprasActivas` int(11) NOT NULL AUTO_INCREMENT,
  `idProveedor` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Factura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombrePro` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaProg` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TotalCompra` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DocumentoGenerado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumComprobante` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComprasActivas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras_precompra`
--

CREATE TABLE IF NOT EXISTS `compras_precompra` (
  `idPreCompra` int(11) NOT NULL AUTO_INCREMENT,
  `idProductosVenta` int(11) NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idComprasActivas` int(11) NOT NULL,
  `PrecioVentaPre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPreCompra`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes_contabilidad`
--

CREATE TABLE IF NOT EXISTS `comprobantes_contabilidad` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes_contabilidad_items`
--

CREATE TABLE IF NOT EXISTS `comprobantes_contabilidad_items` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idComprobante` int(16) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` int(11) NOT NULL,
  `CuentaPUC` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `NombreCuenta` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `NumDocSoporte` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `Soporte` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `idLibroDiario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes_egreso_items`
--

CREATE TABLE IF NOT EXISTS `comprobantes_egreso_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idComprobante` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` int(11) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish2_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish2_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `OrigenMovimiento` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idOrigen` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes_ingreso`
--

CREATE TABLE IF NOT EXISTS `comprobantes_ingreso` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Tercero` int(11) NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Tipo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes_ingreso_anulaciones`
--

CREATE TABLE IF NOT EXISTS `comprobantes_ingreso_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Monto` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes_ingreso_items`
--

CREATE TABLE IF NOT EXISTS `comprobantes_ingreso_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idComprobante` int(16) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NombreCuenta` text COLLATE utf8_spanish2_ci NOT NULL,
  `Debito` int(16) NOT NULL,
  `Credito` int(16) NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `NumDocSoporte` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish2_ci NOT NULL,
  `idLibroDiario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `OrigenMovimiento` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idOrigen` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes_pre`
--

CREATE TABLE IF NOT EXISTS `comprobantes_pre` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `idComprobanteContabilidad` int(16) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concejales`
--

CREATE TABLE IF NOT EXISTS `concejales` (
  `ID` bigint(20) NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Cargo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Terminacion` date NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concejales_intervenciones`
--

CREATE TABLE IF NOT EXISTS `concejales_intervenciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idConcejal` bigint(20) NOT NULL,
  `idSesionConcejo` bigint(20) NOT NULL,
  `Fecha` date NOT NULL,
  `HoraInicio` time NOT NULL,
  `HoraFin` time NOT NULL,
  `Expresado` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concejo_sesiones`
--

CREATE TABLE IF NOT EXISTS `concejo_sesiones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Sesion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` date NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concejo_tipo_sesiones`
--

CREATE TABLE IF NOT EXISTS `concejo_tipo_sesiones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conceptos`
--

CREATE TABLE IF NOT EXISTS `conceptos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaHoraCreacion` datetime NOT NULL,
  `Nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Genera` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Completo` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conceptos_montos`
--

CREATE TABLE IF NOT EXISTS `conceptos_montos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idConcepto` int(11) NOT NULL,
  `NombreMonto` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Depende` bigint(20) NOT NULL,
  `Operacion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `ValorDependencia` bigint(20) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conceptos_movimientos`
--

CREATE TABLE IF NOT EXISTS `conceptos_movimientos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idConcepto` int(11) NOT NULL,
  `idMonto` int(11) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuentaPUC` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `TipoMovimiento` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_codigo_barras`
--

CREATE TABLE IF NOT EXISTS `config_codigo_barras` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TituloEtiqueta` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `DistaciaEtiqueta1` int(11) NOT NULL,
  `DistaciaEtiqueta2` int(11) NOT NULL,
  `DistaciaEtiqueta3` int(11) NOT NULL,
  `AlturaLinea1` int(11) NOT NULL,
  `AlturaLinea2` int(11) NOT NULL,
  `AlturaLinea3` int(11) NOT NULL,
  `AlturaLinea4` int(11) NOT NULL,
  `AlturaLinea5` int(11) NOT NULL,
  `AlturaCodigoBarras` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_puertos`
--

CREATE TABLE IF NOT EXISTS `config_puertos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Puerto` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Utilizacion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_tiketes_promocion`
--

CREATE TABLE IF NOT EXISTS `config_tiketes_promocion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreTiket` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Tope` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Multiple` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costos`
--

CREATE TABLE IF NOT EXISTS `costos` (
  `idCostos` int(20) NOT NULL AUTO_INCREMENT,
  `NombreCosto` varchar(45) NOT NULL,
  `ValorCosto` float NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCostos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE IF NOT EXISTS `cotizaciones` (
  `idCotizaciones` int(11) NOT NULL AUTO_INCREMENT,
  `NumCotizacion` int(11) NOT NULL,
  `NumSolicitud` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Fecha` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(300) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Subtotal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Total` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descuento` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ValorDescuento` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `PrecioCosto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `SubtotalCosto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(45) NOT NULL,
  `Observaciones` varchar(1000) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `TipoItem` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Devuelto` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCotizaciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacionesv5`
--

CREATE TABLE IF NOT EXISTS `cotizacionesv5` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `NumSolicitud` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NumOrden` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Seguimiento` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones_anexos`
--

CREATE TABLE IF NOT EXISTS `cotizaciones_anexos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FechaCreacion` datetime NOT NULL,
  `Titulo` text COLLATE utf8_spanish2_ci NOT NULL,
  `NumCotizacion` bigint(20) NOT NULL,
  `Anexo` text COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cot_itemscotizaciones`
--

CREATE TABLE IF NOT EXISTS `cot_itemscotizaciones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idCliente` int(11) NOT NULL DEFAULT '0',
  `NumCotizacion` int(16) NOT NULL,
  `Descripcion` varchar(300) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `TablaOrigen` varchar(45) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `ValorUnitario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `Multiplicador` int(11) NOT NULL,
  `Subtotal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Total` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descuento` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ValorDescuento` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `PrecioCosto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `SubtotalCosto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `TipoItem` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Devuelto` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) CHARACTER SET utf8 NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crono_controles`
--

CREATE TABLE IF NOT EXISTS `crono_controles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idSesionConcejo` bigint(20) NOT NULL,
  `idConcejal` bigint(20) NOT NULL,
  `Estado` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `Inicio` time NOT NULL,
  `Fin` time NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE IF NOT EXISTS `cuentas` (
  `idPUC` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `GupoCuentas_PUC` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentasfrecuentes`
--

CREATE TABLE IF NOT EXISTS `cuentasfrecuentes` (
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `ClaseCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsoFuturo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CuentaPUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentasxpagar`
--

CREATE TABLE IF NOT EXISTS `cuentasxpagar` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `DocumentoReferencia` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `FechaProgramada` date NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Retenciones` double NOT NULL,
  `Total` double NOT NULL,
  `Abonos` double NOT NULL,
  `Saldo` double NOT NULL,
  `idProveedor` bigint(20) NOT NULL,
  `RazonSocial` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Direccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Ciudad` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaBancaria` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `A_Nombre_De` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `TipoCuenta` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `EntidadBancaria` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Dias` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Soporte` text COLLATE utf8_spanish2_ci NOT NULL,
  `idCentroCostos` int(11) NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `DocumentoCruce` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentasxpagar_abonos`
--

CREATE TABLE IF NOT EXISTS `cuentasxpagar_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idCuentaXPagar` bigint(20) NOT NULL,
  `Monto` double NOT NULL,
  `idUsuarios` bigint(20) NOT NULL,
  `idComprobanteEgreso` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucionesventas`
--

CREATE TABLE IF NOT EXISTS `devolucionesventas` (
  `idComprasDevoluciones` int(11) NOT NULL AUTO_INCREMENT,
  `NumVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `EfectivoDevuelto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ProductosVenta_idProductosVenta` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComprasDevoluciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_generados`
--

CREATE TABLE IF NOT EXISTS `documentos_generados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Abreviatura` varchar(3) COLLATE utf8_spanish2_ci NOT NULL,
  `Libro` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Abreviatura` (`Abreviatura`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

CREATE TABLE IF NOT EXISTS `egresos` (
  `idEgresos` int(45) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) NOT NULL,
  `PagoProg` varchar(10) NOT NULL,
  `FechaPagoPro` varchar(20) NOT NULL,
  `FechaPago` varchar(20) NOT NULL,
  `Concepto` varchar(300) NOT NULL,
  `TipoEgreso` varchar(45) NOT NULL,
  `ServicioPago` varchar(45) NOT NULL,
  `Beneficiario` varchar(45) NOT NULL,
  `NIT` varchar(45) NOT NULL,
  `Direccion` varchar(45) NOT NULL,
  `Ciudad` varchar(45) NOT NULL,
  `Subtotal` varchar(45) NOT NULL,
  `IVA` varchar(45) NOT NULL,
  `Valor` varchar(45) NOT NULL,
  `Retenciones` varchar(45) NOT NULL,
  `NumFactura` varchar(45) NOT NULL,
  `idProveedor` varchar(45) NOT NULL,
  `Cuenta` varchar(45) NOT NULL,
  `Soporte` text NOT NULL,
  `Usuario_idUsuario` int(11) NOT NULL,
  `CerradoDiario` varchar(3) NOT NULL,
  `FechaCierreDiario` varchar(45) NOT NULL,
  `HoraCierreDiario` varchar(45) NOT NULL,
  `UsuarioCierreDiario` varchar(45) NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idEgresos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos_activos`
--

CREATE TABLE IF NOT EXISTS `egresos_activos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  `Cuentas_idCuentas` int(11) NOT NULL,
  `Visible` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos_items`
--

CREATE TABLE IF NOT EXISTS `egresos_items` (
  `ID` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaDestino` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Tercero` int(11) NOT NULL,
  `Debito` int(11) NOT NULL,
  `Credito` int(11) NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `TipoPago` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `FechaProgramada` date NOT NULL,
  `NumeroComprobante` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Soporte` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos_pre`
--

CREATE TABLE IF NOT EXISTS `egresos_pre` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCuentaXPagar` bigint(20) NOT NULL,
  `Abono` int(11) NOT NULL,
  `Descuento` double NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos_tipo`
--

CREATE TABLE IF NOT EXISTS `egresos_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Cuentas_idCuentas` int(11) NOT NULL,
  `Visible` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresapro`
--

CREATE TABLE IF NOT EXISTS `empresapro` (
  `idEmpresaPro` int(11) NOT NULL AUTO_INCREMENT,
  `RazonSocial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NIT` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Celular` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ResolucionDian` text COLLATE utf8_spanish_ci NOT NULL,
  `Regimen` enum('SIMPLIFICADO','COMUN') COLLATE utf8_spanish_ci DEFAULT 'SIMPLIFICADO',
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `WEB` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ObservacionesLegales` text COLLATE utf8_spanish_ci NOT NULL,
  `PuntoEquilibrio` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DatosBancarios` text COLLATE utf8_spanish_ci NOT NULL,
  `RutaImagen` varchar(200) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'LogosEmpresas/logotipo1.png',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idEmpresaPro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_pro_sucursales`
--

CREATE TABLE IF NOT EXISTS `empresa_pro_sucursales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Direccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `idEmpresaPro` int(11) NOT NULL,
  `Visible` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Actual` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `idServidor` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadosfinancieros_mayor_temporal`
--

CREATE TABLE IF NOT EXISTS `estadosfinancieros_mayor_temporal` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaCorte` date NOT NULL,
  `Clase` int(11) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `Neto` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE IF NOT EXISTS `facturas` (
  `idFacturas` varchar(45) NOT NULL,
  `idResolucion` int(11) NOT NULL,
  `TipoFactura` varchar(10) NOT NULL,
  `Prefijo` varchar(45) NOT NULL,
  `NumeroFactura` int(16) NOT NULL,
  `Fecha` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Hora` varchar(20) NOT NULL,
  `OCompra` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `OSalida` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Descuentos` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `SaldoFact` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Cotizaciones_idCotizaciones` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `EmpresaPro_idEmpresaPro` int(11) NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `TotalCostos` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `CerradoDiario` bigint(20) NOT NULL,
  `FechaCierreDiario` date NOT NULL,
  `HoraCierreDiario` time NOT NULL,
  `ObservacionesFact` text NOT NULL,
  `Efectivo` double NOT NULL,
  `Devuelve` double NOT NULL,
  `Cheques` double NOT NULL,
  `Otros` double NOT NULL,
  `Tarjetas` double NOT NULL,
  `idTarjetas` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `facturas`
--
DROP TRIGGER IF EXISTS `Actualiza_OriFacturas`;
DELIMITER //
CREATE TRIGGER `Actualiza_OriFacturas` AFTER UPDATE ON `facturas`
 FOR EACH ROW BEGIN

REPLACE INTO ori_facturas SELECT * FROM facturas WHERE idFacturas=New.idFacturas;


END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `InsertFacturaOri`;
DELIMITER //
CREATE TRIGGER `InsertFacturaOri` AFTER INSERT ON `facturas`
 FOR EACH ROW BEGIN

INSERT INTO ori_facturas SELECT * FROM facturas WHERE idFacturas=New.idFacturas;


END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_abonos`
--

CREATE TABLE IF NOT EXISTS `facturas_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Hora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Facturas_idFacturas` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteIngreso` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_anticipos`
--

CREATE TABLE IF NOT EXISTS `facturas_anticipos` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `CuentaIngreso` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_autoretenciones`
--

CREATE TABLE IF NOT EXISTS `facturas_autoretenciones` (
  `idFacturasAutoretenciones` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreAutoRetencion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Monto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Paga` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `FechaPago` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Soportes_idSoportes` int(11) DEFAULT NULL,
  `Facturas_idFacturas` int(11) DEFAULT NULL,
  `idImpRet` int(11) DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturasAutoretenciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_formapago`
--

CREATE TABLE IF NOT EXISTS `facturas_formapago` (
  `idFacturas_FormaPago` int(16) NOT NULL AUTO_INCREMENT,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Paga` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Devuelve` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Facturas_idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas_FormaPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_items`
--

CREATE TABLE IF NOT EXISTS `facturas_items` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FechaFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `TablaItems` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` double NOT NULL,
  `Cantidad` double NOT NULL,
  `Dias` double NOT NULL,
  `SubtotalItem` double NOT NULL,
  `IVAItem` double NOT NULL,
  `TotalItem` double NOT NULL COMMENT 'Total del valor del Item',
  `PorcentajeIVA` varchar(10) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'que porcentaje de IVA se le aplico',
  `PrecioCostoUnitario` double NOT NULL,
  `SubtotalCosto` double NOT NULL COMMENT 'Costo total del item',
  `TipoItem` varchar(10) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Disparadores `facturas_items`
--
DROP TRIGGER IF EXISTS `InsertFacturasItems`;
DELIMITER //
CREATE TRIGGER `InsertFacturasItems` AFTER INSERT ON `facturas_items`
 FOR EACH ROW BEGIN

INSERT INTO ori_facturas_items SELECT * FROM facturas_items WHERE ID=New.ID;


END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_pre`
--

CREATE TABLE IF NOT EXISTS `facturas_pre` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FechaFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `TablaItems` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` int(11) NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Dias` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `SubtotalItem` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `IVAItem` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `TotalItem` varchar(45) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Total del valor del Item',
  `PorcentajeIVA` varchar(10) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'que porcentaje de IVA se le aplico',
  `PrecioCostoUnitario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `SubtotalCosto` varchar(45) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Costo total del item',
  `TipoItem` varchar(10) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_reten_aplicadas`
--

CREATE TABLE IF NOT EXISTS `facturas_reten_aplicadas` (
  `idFacturasRetAplicadas` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreRetencion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Monto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cruzada` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `FechaCruce` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Soportes_idSoportes` int(11) DEFAULT NULL,
  `Facturas_idFacturas` int(11) DEFAULT NULL,
  `idImpRet` int(11) DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturasRetAplicadas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `facturas_reten_aplicadas`
--
DROP TRIGGER IF EXISTS `ActualizaSaldoFact`;
DELIMITER //
CREATE TRIGGER `ActualizaSaldoFact` AFTER INSERT ON `facturas_reten_aplicadas`
 FOR EACH ROW BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=NEW.Facturas_idFacturas;

SET @Saldo=@SaldoAnt-NEW.Monto;

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=NEW.Facturas_idFacturas;


END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `ActualizaSaldoFactDel`;
DELIMITER //
CREATE TRIGGER `ActualizaSaldoFactDel` BEFORE DELETE ON `facturas_reten_aplicadas`
 FOR EACH ROW BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=OLD.Facturas_idFacturas;

SET @Saldo=@SaldoAnt+OLD.Monto;

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=OLD.Facturas_idFacturas;


END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `ActualizaSaldoFactUpdate`;
DELIMITER //
CREATE TRIGGER `ActualizaSaldoFactUpdate` AFTER UPDATE ON `facturas_reten_aplicadas`
 FOR EACH ROW BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=NEW.Facturas_idFacturas;

SET @Saldo=@SaldoAnt+(OLD.Monto-NEW.Monto);

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=NEW.Facturas_idFacturas;


END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_tipo_pago`
--

CREATE TABLE IF NOT EXISTS `facturas_tipo_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoPago` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Leyenda` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechas_descuentos`
--

CREATE TABLE IF NOT EXISTS `fechas_descuentos` (
  `idFechaDescuentos` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Motivo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFechaDescuentos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formatos_calidad`
--

CREATE TABLE IF NOT EXISTS `formatos_calidad` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` text COLLATE utf8_spanish2_ci NOT NULL,
  `Version` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Codigo` text COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` date NOT NULL,
  `NotasPiePagina` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gupocuentas`
--

CREATE TABLE IF NOT EXISTS `gupocuentas` (
  `PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ClaseCuenta_PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impret`
--

CREATE TABLE IF NOT EXISTS `impret` (
  `idImpRet` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tipo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaRetFavor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaRetRealizadas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Aplicable_A` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idImpRet`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE IF NOT EXISTS `ingresos` (
  `idIngresos` int(200) NOT NULL AUTO_INCREMENT,
  `Observaciones` varchar(500) NOT NULL,
  `Total` int(10) NOT NULL,
  `Fecha` varchar(10) NOT NULL,
  `Facturas_idFacturas` int(45) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `CerradoDiario` varchar(5) NOT NULL,
  `FechaCierreDiario` varchar(25) NOT NULL,
  `HoraCierreDiario` varchar(25) NOT NULL,
  `UsuarioCierreDiario` varchar(45) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idIngresos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresosvarios`
--

CREATE TABLE IF NOT EXISTS `ingresosvarios` (
  `idIngresosVarios` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idIngresosVarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios_diferencias`
--

CREATE TABLE IF NOT EXISTS `inventarios_diferencias` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `ExistenciaAnterior` double NOT NULL,
  `ExistenciaActual` double NOT NULL,
  `Diferencia` double DEFAULT NULL,
  `PrecioVenta` double DEFAULT NULL,
  `CostoUnitario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Departamento` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios_temporal`
--

CREATE TABLE IF NOT EXISTS `inventarios_temporal` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardexmercancias`
--

CREATE TABLE IF NOT EXISTS `kardexmercancias` (
  `idKardexMercancias` bigint(20) NOT NULL AUTO_INCREMENT,
  `idBodega` int(11) NOT NULL DEFAULT '1',
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDocumento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ProductosVenta_idProductosVenta` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKardexMercancias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardexmercancias_temporal`
--

CREATE TABLE IF NOT EXISTS `kardexmercancias_temporal` (
  `idKardexMercancias` bigint(20) NOT NULL AUTO_INCREMENT,
  `idBodega` int(11) NOT NULL DEFAULT '1',
  `Fecha` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Movimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(400) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDocumento` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorUnitario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorTotal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `ProductosVenta_idProductosVenta` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKardexMercancias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kits`
--

CREATE TABLE IF NOT EXISTS `kits` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kits_relaciones`
--

CREATE TABLE IF NOT EXISTS `kits_relaciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaProducto` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `ReferenciaProducto` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `IDKit` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `librodiario`
--

CREATE TABLE IF NOT EXISTS `librodiario` (
  `idLibroDiario` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Tipo_Documento_Intero` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Num_Documento_Interno` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Num_Documento_Externo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Tipo_Documento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tercero_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tercero_DV` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Primer_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Segundo_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Primer_Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Otros_Nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Razon_Social` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Cod_Dpto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Cod_Mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Pais_Domicilio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Debito` double DEFAULT NULL,
  `Credito` double DEFAULT NULL,
  `Neto` double DEFAULT NULL,
  `Mayor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Esp` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idCentroCosto` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idLibroDiario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libromayorbalances`
--

CREATE TABLE IF NOT EXISTS `libromayorbalances` (
  `idLibroMayorBalances` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreCuenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Debito` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Credito` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idLibroMayorBalances`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maquinas`
--

CREATE TABLE IF NOT EXISTS `maquinas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notascontables`
--

CREATE TABLE IF NOT EXISTS `notascontables` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `FechaProgramada` date NOT NULL,
  `Detalle` text COLLATE utf8_spanish2_ci NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `Soporte` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `NumFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Usuario_idUsuario` int(11) NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notascredito`
--

CREATE TABLE IF NOT EXISTS `notascredito` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `Cliente` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenesdecompra`
--

CREATE TABLE IF NOT EXISTS `ordenesdecompra` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` int(11) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `PlazoEntrega` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NoCotizacion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Condiciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Solicitante` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Cargo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `UsuarioCreador` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenesdecompra_items`
--

CREATE TABLE IF NOT EXISTS `ordenesdecompra_items` (
  `ID` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NumOrden` int(11) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `ValorUnitario` float NOT NULL,
  `Subtotal` float NOT NULL,
  `IVA` float NOT NULL,
  `Total` float NOT NULL,
  `TablaOrigen` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenesdetrabajo`
--

CREATE TABLE IF NOT EXISTS `ordenesdetrabajo` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `FechaOT` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `idCliente` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `DireccionServicio` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `NombreSolicitante` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `TipoOrden` int(11) NOT NULL,
  `idUsuarioCreador` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Hora` time NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenesdetrabajo_items`
--

CREATE TABLE IF NOT EXISTS `ordenesdetrabajo_items` (
  `ID` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idOT` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Actividad` text COLLATE utf8_spanish2_ci NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `TiempoEstimadoHoras` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenesdetrabajo_tipo`
--

CREATE TABLE IF NOT EXISTS `ordenesdetrabajo_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ori_facturas`
--

CREATE TABLE IF NOT EXISTS `ori_facturas` (
  `idFacturas` varchar(45) CHARACTER SET utf8 NOT NULL,
  `idResolucion` int(11) NOT NULL,
  `TipoFactura` varchar(10) CHARACTER SET utf8 NOT NULL,
  `Prefijo` varchar(45) CHARACTER SET utf8 NOT NULL,
  `NumeroFactura` int(16) NOT NULL,
  `Fecha` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Hora` varchar(20) CHARACTER SET utf8 NOT NULL,
  `OCompra` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `OSalida` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Descuentos` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `SaldoFact` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Cotizaciones_idCotizaciones` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `EmpresaPro_idEmpresaPro` int(11) NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `TotalCostos` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `CerradoDiario` bigint(20) NOT NULL,
  `FechaCierreDiario` date NOT NULL,
  `HoraCierreDiario` time NOT NULL,
  `ObservacionesFact` text CHARACTER SET utf8 NOT NULL,
  `Efectivo` double NOT NULL,
  `Devuelve` double NOT NULL,
  `Cheques` double NOT NULL,
  `Otros` double NOT NULL,
  `Tarjetas` double NOT NULL,
  `idTarjetas` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ori_facturas_items`
--

CREATE TABLE IF NOT EXISTS `ori_facturas_items` (
  `ID` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `FechaFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `TablaItems` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` int(11) NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Dias` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `SubtotalItem` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `IVAItem` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `TotalItem` varchar(45) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Total del valor del Item',
  `PorcentajeIVA` varchar(10) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'que porcentaje de IVA se le aplico',
  `PrecioCostoUnitario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `SubtotalCosto` varchar(45) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Costo total del item',
  `TipoItem` varchar(10) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paginas`
--

CREATE TABLE IF NOT EXISTS `paginas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `TipoPagina` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Visible` tinyint(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paginas_bloques`
--

CREATE TABLE IF NOT EXISTS `paginas_bloques` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoUsuario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Pagina` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros_contables`
--

CREATE TABLE IF NOT EXISTS `parametros_contables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataforma_tablas`
--

CREATE TABLE IF NOT EXISTS `plataforma_tablas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `porcentajes_iva`
--

CREATE TABLE IF NOT EXISTS `porcentajes_iva` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precotizacion`
--

CREATE TABLE IF NOT EXISTS `precotizacion` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NumSolicitud` varchar(45) NOT NULL,
  `Cantidad` float NOT NULL,
  `Multiplicador` int(11) NOT NULL DEFAULT '1',
  `Referencia` varchar(45) NOT NULL,
  `ValorUnitario` int(11) NOT NULL,
  `SubTotal` int(11) NOT NULL,
  `Descripcion` varchar(500) NOT NULL,
  `IVA` int(11) NOT NULL,
  `Descuento` int(11) NOT NULL,
  `ValorDescuento` int(11) NOT NULL,
  `PrecioCosto` varchar(45) NOT NULL,
  `SubtotalCosto` varchar(45) NOT NULL,
  `Total` varchar(45) NOT NULL,
  `TipoItem` varchar(10) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `CuentaPUC` varchar(45) NOT NULL,
  `Tabla` varchar(45) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preventa`
--

CREATE TABLE IF NOT EXISTS `preventa` (
  `idPrecotizacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `VestasActivas_idVestasActivas` int(11) NOT NULL,
  `idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ProductosVenta_idProductosVenta` int(11) NOT NULL,
  `TablaItem` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorAcordado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descuento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Impuestos` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TotalVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoItem` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Autorizado` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPrecotizacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion_actividades`
--

CREATE TABLE IF NOT EXISTS `produccion_actividades` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idOrdenTrabajo` bigint(20) NOT NULL,
  `Fecha_Planeada_Inicio` date NOT NULL,
  `Fecha_Planeada_Fin` date NOT NULL,
  `Hora_Planeada_Inicio` time NOT NULL,
  `Hora_Planeada_Fin` time NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Fin` date NOT NULL,
  `Hora_Inicio` time NOT NULL,
  `Hora_Fin` time NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `idMaquina` int(11) NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Tiempo_Operacion` float NOT NULL,
  `Pausas_Operativas` float NOT NULL,
  `Pausas_No_Operativas` float NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion_horas_cronograma`
--

CREATE TABLE IF NOT EXISTS `produccion_horas_cronograma` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Hora` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion_ordenes_trabajo`
--

CREATE TABLE IF NOT EXISTS `produccion_ordenes_trabajo` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Compromiso_Entrega` date NOT NULL,
  `FechaTerminacion` date NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `TotalHorasPlaneadas` float NOT NULL,
  `TotalHorasEmpleadas` float NOT NULL,
  `Pausas_Operativas` float NOT NULL,
  `Pausas_No_Operativas` float NOT NULL,
  `Tiempo_Operacion` float NOT NULL,
  `ValorSugerido` bigint(20) NOT NULL,
  `ValorMateriales` bigint(20) NOT NULL,
  `ValorCotizado` bigint(20) NOT NULL,
  `ValorFacturado` bigint(20) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Facturado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `NumFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion_pausas_predefinidas`
--

CREATE TABLE IF NOT EXISTS `produccion_pausas_predefinidas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Suma` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion_registro_tiempos`
--

CREATE TABLE IF NOT EXISTS `produccion_registro_tiempos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idActividad` bigint(20) NOT NULL,
  `FechaHora` datetime NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Suma` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosalquiler`
--

CREATE TABLE IF NOT EXISTS `productosalquiler` (
  `idProductosVenta` int(11) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Existencias` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `PrecioVenta` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `ImagenRuta` text COLLATE utf8_spanish2_ci NOT NULL,
  `PesoUnitario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `PesoTotal` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `CostoUnitarioActivo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `Kit` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosventa`
--

CREATE TABLE IF NOT EXISTS `productosventa` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `productosventa`
--
DROP TRIGGER IF EXISTS `insKardex`;
DELIMITER //
CREATE TRIGGER `insKardex` AFTER INSERT ON `productosventa`
 FOR EACH ROW BEGIN

SET @fecha=CURDATE();
    INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (@fecha,'ENTRADA','INICIO',NEW.Existencias,NEW.CostoUnitario,NEW.CostoTotal,NEW.idProductosVenta);
    
    INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (@fecha,'SALDOS','INICIO',NEW.Existencias,NEW.CostoUnitario,NEW.CostoTotal,NEW.idProductosVenta);

SET @Dep=LPAD(NEW.Departamento,2,'0');

SET @Sub1=LPAD(NEW.Sub1,2,'0');

SET @id=LPAD(NEW.idProductosVenta,7,'0');
    
    
SET @Codigo=CONCAT(@Dep,@Sub1,@id);

INSERT INTO prod_codbarras (`CodigoBarras`,`ProductosVenta_idProductosVenta`) VALUES (@Codigo,NEW.idProductosVenta);

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosventa_bodega_1`
--

CREATE TABLE IF NOT EXISTS `productosventa_bodega_1` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosventa_bodega_2`
--

CREATE TABLE IF NOT EXISTS `productosventa_bodega_2` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosventa_bodega_3`
--

CREATE TABLE IF NOT EXISTS `productosventa_bodega_3` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosventa_bodega_4`
--

CREATE TABLE IF NOT EXISTS `productosventa_bodega_4` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosventa_bodega_5`
--

CREATE TABLE IF NOT EXISTS `productosventa_bodega_5` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
  `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
  `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Kit` int(11) NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_bajas_altas`
--

CREATE TABLE IF NOT EXISTS `prod_bajas_altas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoTotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_bodega`
--

CREATE TABLE IF NOT EXISTS `prod_bodega` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idProductoAlquiler` int(11) NOT NULL,
  `Bodega_idCliente` int(11) NOT NULL,
  `CantidadProd` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_codbarras`
--

CREATE TABLE IF NOT EXISTS `prod_codbarras` (
  `idCodBarras` int(11) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` int(11) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_codbarras_bodega_1`
--

CREATE TABLE IF NOT EXISTS `prod_codbarras_bodega_1` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_codbarras_bodega_2`
--

CREATE TABLE IF NOT EXISTS `prod_codbarras_bodega_2` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_codbarras_bodega_3`
--

CREATE TABLE IF NOT EXISTS `prod_codbarras_bodega_3` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_codbarras_bodega_4`
--

CREATE TABLE IF NOT EXISTS `prod_codbarras_bodega_4` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_codbarras_bodega_5`
--

CREATE TABLE IF NOT EXISTS `prod_codbarras_bodega_5` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_comisiones`
--

CREATE TABLE IF NOT EXISTS `prod_comisiones` (
  `idProd_Comisiones` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Comision` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `P_V` int(2) NOT NULL COMMENT '1 Valor 0 Porcentaje',
  `Valor_Comision` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Porcentaje_Comision` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Dep_Comision` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProd_Comisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_departamentos`
--

CREATE TABLE IF NOT EXISTS `prod_departamentos` (
  `idDepartamentos` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoItem` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `ManejaExistencias` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idDepartamentos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_kits`
--

CREATE TABLE IF NOT EXISTS `prod_kits` (
  `idKits` int(11) NOT NULL AUTO_INCREMENT,
  `TablaProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ReferenciaProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKits`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_sinc`
--

CREATE TABLE IF NOT EXISTS `prod_sinc` (
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `prod_sinc`
--
DROP TRIGGER IF EXISTS `Productos_Sinc`;
DELIMITER //
CREATE TRIGGER `Productos_Sinc` AFTER INSERT ON `prod_sinc`
 FOR EACH ROW BEGIN

UPDATE productosventa SET PrecioVenta=NEW.PrecioVenta WHERE Referencia=NEW.Referencia AND Departamento=NEW.Departamento;

UPDATE productosventa SET PrecioMayorista=NEW.PrecioMayorista WHERE Referencia=NEW.Referencia AND Departamento=NEW.Departamento;

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_sub1`
--

CREATE TABLE IF NOT EXISTS `prod_sub1` (
  `idSub1` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub1` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDepartamento` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub1`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_sub2`
--

CREATE TABLE IF NOT EXISTS `prod_sub2` (
  `idSub2` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub2` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub1` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_sub3`
--

CREATE TABLE IF NOT EXISTS `prod_sub3` (
  `idSub3` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub3` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub2` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub3`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_sub4`
--

CREATE TABLE IF NOT EXISTS `prod_sub4` (
  `idSub4` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub4` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub3` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub4`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_sub5`
--

CREATE TABLE IF NOT EXISTS `prod_sub5` (
  `idSub5` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub5` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub4` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub5`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_sub6`
--

CREATE TABLE IF NOT EXISTS `prod_sub6` (
  `idSub6` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub6` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub5` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub6`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `idProveedores` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Documento` int(11) NOT NULL,
  `Num_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DV` int(11) NOT NULL,
  `Lugar_Expedicion_Documento` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Segundo_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Primer_Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Otros_Nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RazonSocial` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cod_Dpto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Pais_Domicilio` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '169',
  `Telefono` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Contacto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `TelContacto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaBancaria` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `A_Nombre_De` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `TipoCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `EntidadBancaria` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `CIUU` int(11) NOT NULL,
  `Cupo` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProveedores`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registra_ediciones`
--

CREATE TABLE IF NOT EXISTS `registra_ediciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Tabla` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Campo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `ValorAnterior` text COLLATE utf8_spanish2_ci NOT NULL,
  `ValorNuevo` text COLLATE utf8_spanish2_ci NOT NULL,
  `ConsultaRealizada` text COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacioncompras`
--

CREATE TABLE IF NOT EXISTS `relacioncompras` (
  `idRelacionCompras` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Documento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NumDocumento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitarioAntesIVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TotalAntesIVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ProductosVenta_idProductosVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idRelacionCompras`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `relacioncompras`
--
DROP TRIGGER IF EXISTS `KardexCompras`;
DELIMITER //
CREATE TRIGGER `KardexCompras` AFTER INSERT ON `relacioncompras`
 FOR EACH ROW BEGIN


SELECT Existencias into @Cantidad FROM productosventa WHERE idProductosVenta=NEW.ProductosVenta_idProductosVenta;


SET @Saldo=@Cantidad+NEW.Cantidad;

SET @PrecioPromedio=NEW.TotalAntesIVA;
          
SET @TotalSaldo=NEW.ValorUnitarioAntesIVA*@Saldo;

    
 INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'ENTRADA',NEW.Documento,NEW.NumDocumento,NEW.Cantidad,NEW.ValorUnitarioAntesIVA,NEW.TotalAntesIVA,NEW.ProductosVenta_idProductosVenta);
    

INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'SALDOS',NEW.Documento,NEW.NumDocumento,@Saldo,NEW.ValorUnitarioAntesIVA,@TotalSaldo,NEW.ProductosVenta_idProductosVenta);

SELECT Existencias into @Saldoext FROM productosventa WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;

SET @Saldoext=@Saldoext+NEW.Cantidad;

UPDATE productosventa SET `Existencias`= @Saldoext WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;

UPDATE productosventa SET `CostoUnitario`= NEW.ValorUnitarioAntesIVA WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;

UPDATE productosventa SET `CostoTotal`= @TotalSaldo WHERE idProductosVenta = NEW.ProductosVenta_idProductosVenta;


END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remisiones`
--

CREATE TABLE IF NOT EXISTS `remisiones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Cotizaciones_idCotizaciones` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Obra` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Retira` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `FechaDespacho` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraDespacho` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ObservacionesRemision` text COLLATE utf8_spanish_ci NOT NULL,
  `Anticipo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Dias` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CentroCosto` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rem_devoluciones`
--

CREATE TABLE IF NOT EXISTS `rem_devoluciones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idRemision` int(16) NOT NULL,
  `idItemCotizacion` int(16) NOT NULL,
  `Cantidad` int(16) NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Dias` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NumDevolucion` int(16) NOT NULL,
  `FechaDevolucion` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `HoraDevolucion` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rem_devoluciones_totalizadas`
--

CREATE TABLE IF NOT EXISTS `rem_devoluciones_totalizadas` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `FechaDevolucion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `HoraDevolucion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idRemision` int(16) NOT NULL,
  `TotalDevolucion` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `ObservacionesDevolucion` text COLLATE utf8_spanish2_ci NOT NULL,
  `Usuarios_idUsuarios` int(16) NOT NULL,
  `Clientes_idClientes` int(16) NOT NULL,
  `Facturas_idFacturas` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rem_pre_devoluciones`
--

CREATE TABLE IF NOT EXISTS `rem_pre_devoluciones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idRemision` int(16) NOT NULL,
  `idItemCotizacion` int(16) NOT NULL,
  `Cantidad` int(16) NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Dias` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rem_relaciones`
--

CREATE TABLE IF NOT EXISTS `rem_relaciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaEntrega` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `CantidadEntregada` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Multiplicador` int(11) NOT NULL,
  `idItemCotizacion` int(11) NOT NULL,
  `idRemision` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repuestas_forma_pago`
--

CREATE TABLE IF NOT EXISTS `repuestas_forma_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DiasCartera` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `Etiqueta` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimientos_proyectos`
--

CREATE TABLE IF NOT EXISTS `requerimientos_proyectos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `HorasDesarrollo` double NOT NULL,
  `CostoEstimado` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_condicional`
--

CREATE TABLE IF NOT EXISTS `respuestas_condicional` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(4) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_tipo_item`
--

CREATE TABLE IF NOT EXISTS `respuestas_tipo_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(4) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurante_cierres`
--

CREATE TABLE IF NOT EXISTS `restaurante_cierres` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurante_mesas`
--

CREATE TABLE IF NOT EXISTS `restaurante_mesas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Capacidad` int(11) NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurante_pedidos`
--

CREATE TABLE IF NOT EXISTS `restaurante_pedidos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `Estado` varchar(4) COLLATE utf8_spanish2_ci NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `NombreCliente` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `DireccionEnvio` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `TelefonoConfirmacion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurante_pedidos_items`
--

CREATE TABLE IF NOT EXISTS `restaurante_pedidos_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idPedido` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `NombreProducto` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Estado` varchar(8) COLLATE utf8_spanish2_ci NOT NULL,
  `ProcentajeIVA` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `separados`
--

CREATE TABLE IF NOT EXISTS `separados` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Total` int(11) NOT NULL,
  `Saldo` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuarios` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `separados_abonos`
--

CREATE TABLE IF NOT EXISTS `separados_abonos` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idSeparado` bigint(20) unsigned NOT NULL,
  `Valor` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idUsuarios` int(11) NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `separados_items`
--

CREATE TABLE IF NOT EXISTS `separados_items` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idSeparado` bigint(20) NOT NULL,
  `TablaItems` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Nombre` text COLLATE utf8_spanish2_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `SubtotalItem` int(11) NOT NULL,
  `IVAItem` int(11) NOT NULL,
  `TotalItem` int(11) NOT NULL,
  `PorcentajeIVA` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `PrecioCostoUnitario` int(11) NOT NULL,
  `SubtotalCosto` int(11) NOT NULL,
  `TipoItem` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUC` int(11) NOT NULL,
  `GeneradoDesde` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NumeroIdentificador` int(11) NOT NULL,
  `Multiplicador` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE IF NOT EXISTS `servicios` (
  `idProductosVenta` int(16) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ImagenRuta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `Kit` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servidores`
--

CREATE TABLE IF NOT EXISTS `servidores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `DataBase` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistemas`
--

CREATE TABLE IF NOT EXISTS `sistemas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `PrecioVenta` double NOT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistemas_relaciones`
--

CREATE TABLE IF NOT EXISTS `sistemas_relaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TablaOrigen` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Referencia` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `idSistema` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcuentas`
--

CREATE TABLE IF NOT EXISTS `subcuentas` (
  `PUC` int(11) NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cuentas_idPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcuentas_equivalencias_niif`
--

CREATE TABLE IF NOT EXISTS `subcuentas_equivalencias_niif` (
  `CuentaNIIF` int(11) NOT NULL,
  `NombreCuentaNIIF` int(11) NOT NULL,
  `Equivale_A` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CuentaNIIF`),
  UNIQUE KEY `Equivale_A` (`Equivale_A`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablas_ventas`
--

CREATE TABLE IF NOT EXISTS `tablas_ventas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreTabla` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idTabla` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `TipoVenta` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `IVAIncluido` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUCDefecto` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas_forma_pago`
--

CREATE TABLE IF NOT EXISTS `tarjetas_forma_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `PorcentajeComision` float NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposretenciones`
--

CREATE TABLE IF NOT EXISTS `tiposretenciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPasivo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NombreCuentaPasivo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaActivo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NombreCuentaActivo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulos_abonos`
--

CREATE TABLE IF NOT EXISTS `titulos_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idVenta` bigint(20) NOT NULL,
  `Monto` double NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulos_asignaciones`
--

CREATE TABLE IF NOT EXISTS `titulos_asignaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Desde` int(11) NOT NULL,
  `Hasta` int(11) NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulos_comisiones`
--

CREATE TABLE IF NOT EXISTS `titulos_comisiones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idVenta` bigint(20) NOT NULL,
  `Monto` double NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `idEgreso` bigint(20) NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulos_cuentasxcobrar`
--

CREATE TABLE IF NOT EXISTS `titulos_cuentasxcobrar` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FechaIngreso` date NOT NULL,
  `Origen` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idDocumento` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idTercero` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `RazonSocial` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Direccion` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Ciudad` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Telefono` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Valor` double NOT NULL,
  `TotalAbonos` double NOT NULL,
  `Saldo` double NOT NULL,
  `CicloPagos` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `UltimoPago` date NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulos_devoluciones`
--

CREATE TABLE IF NOT EXISTS `titulos_devoluciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idVenta` bigint(20) NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor` bigint(20) NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulos_listados_promocion_1`
--

CREATE TABLE IF NOT EXISTS `titulos_listados_promocion_1` (
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `idColaborador` int(11) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `FechaEntregaColaborador` date NOT NULL,
  `idActa` bigint(20) NOT NULL,
  `TotalPagoComisiones` bigint(20) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `FechaVenta` date NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Mayor1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulos_listados_promocion_6`
--

CREATE TABLE IF NOT EXISTS `titulos_listados_promocion_6` (
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `idColaborador` int(11) NOT NULL,
  `NombreColaborador` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `FechaEntregaColaborador` date NOT NULL,
  `TotalPagoComisiones` bigint(20) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `FechaVenta` date NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Mayor1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulos_listados_promocion_7`
--

CREATE TABLE IF NOT EXISTS `titulos_listados_promocion_7` (
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `idColaborador` int(11) NOT NULL,
  `NombreColaborador` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `FechaEntregaColaborador` date NOT NULL,
  `idActa` bigint(20) NOT NULL,
  `TotalPagoComisiones` bigint(20) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `FechaVenta` date NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Mayor1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulos_promociones`
--

CREATE TABLE IF NOT EXISTS `titulos_promociones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `MayorInicial` int(11) NOT NULL,
  `MayorFinal` int(11) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `Valor` bigint(20) NOT NULL,
  `ComisionAPagar` bigint(20) NOT NULL,
  `Loteria` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NumeroGanador` int(11) NOT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL DEFAULT '413570',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulos_traslados`
--

CREATE TABLE IF NOT EXISTS `titulos_traslados` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor1` int(11) NOT NULL,
  `idColaboradorAnterior` bigint(20) NOT NULL,
  `NombreColaboradorAnterior` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `idColaboradorAsignado` bigint(20) NOT NULL,
  `NombreColaboradorAsignado` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulos_ventas`
--

CREATE TABLE IF NOT EXISTS `titulos_ventas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Promocion` int(11) NOT NULL,
  `Mayor1` int(11) NOT NULL,
  `Mayor2` int(11) NOT NULL,
  `Adicional` int(11) NOT NULL,
  `Valor` bigint(20) NOT NULL,
  `TotalAbonos` bigint(20) NOT NULL,
  `Saldo` bigint(20) NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `NombreCliente` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `idColaborador` bigint(20) NOT NULL,
  `NombreColaborador` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `ComisionAPagar` bigint(20) NOT NULL,
  `SaldoComision` double NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslados_estados`
--

CREATE TABLE IF NOT EXISTS `traslados_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslados_items`
--

CREATE TABLE IF NOT EXISTS `traslados_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idTraslado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Destino` int(11) NOT NULL,
  `CodigoBarras` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Referencia` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Nombre` text COLLATE utf8_spanish2_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `CuentaPUC` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `ServerSincronizado` datetime NOT NULL,
  `DestinoSincronizado` datetime NOT NULL,
  `CodigoBarras1` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `CodigoBarras2` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `CodigoBarras3` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `CodigoBarras4` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslados_mercancia`
--

CREATE TABLE IF NOT EXISTS `traslados_mercancia` (
  `ID` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Origen` int(11) NOT NULL,
  `ConsecutivoInterno` bigint(20) NOT NULL,
  `Destino` int(11) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `idBodega` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Abre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Cierra` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `ServerSincronizado` datetime NOT NULL,
  `DestinoSincronizado` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuarios` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Apellido` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Identificacion` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Login` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Password` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoUser` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Role` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idUsuarios`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_ip`
--

CREATE TABLE IF NOT EXISTS `usuarios_ip` (
  `Direccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Direccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_keys`
--

CREATE TABLE IF NOT EXISTS `usuarios_keys` (
  `KeyUsuario` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`KeyUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_tipo`
--

CREATE TABLE IF NOT EXISTS `usuarios_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE IF NOT EXISTS `ventas` (
  `idVentas` int(11) NOT NULL AUTO_INCREMENT,
  `NumVenta` int(16) DEFAULT NULL,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Productos_idProductos` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Producto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorCostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorVentaUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Impuestos` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descuentos` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TotalCosto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TotalVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoVenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT 'Contado' COMMENT 'Credito o contado',
  `Cotizaciones_idCotizaciones` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `CerradoDiario` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `FechaCierreDiario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `HoraCierreDiario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `UsuarioCierreDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraVenta` time NOT NULL,
  `NoReclamacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVentas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `ventas`
--
DROP TRIGGER IF EXISTS `UpdateProductos`;
DELIMITER //
CREATE TRIGGER `UpdateProductos` AFTER INSERT ON `ventas`
 FOR EACH ROW BEGIN


SELECT Existencias into @Cantidad FROM productosventa WHERE idProductosVenta=NEW.Productos_idProductos;

SET @PrecioPromedio=NEW.ValorCostoUnitario;

SET @Saldo=@Cantidad-NEW.Cantidad;

SET @TotalSaldo=@Saldo*@PrecioPromedio;
SET @TotalMov=NEW.Cantidad*@PrecioPromedio;
    
 INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'SALIDA','VENTA',NEW.NumVenta,NEW.Cantidad,@PrecioPromedio,@TotalMov,NEW.Productos_idProductos);
    

INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`,`idDocumento`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (NEW.Fecha,'SALDOS','VENTA',NEW.NumVenta,@Saldo,@PrecioPromedio,@TotalSaldo,NEW.Productos_idProductos);

UPDATE productosventa SET `Existencias`= @Saldo WHERE idProductosVenta = NEW.Productos_idProductos;

UPDATE productosventa SET `CostoTotal`= @TotalSaldo WHERE idProductosVenta = NEW.Productos_idProductos;

SET @SubTotal=NEW.TotalVenta-NEW.Impuestos;

IF (NEW.Especial = "NO" ) THEN

INSERT INTO cotizaciones (`NumCotizacion`, `Fecha`, `Descripcion`,`Referencia`, `ValorUnitario`,`Cantidad`, `Subtotal`, `IVA`, `Total`, `ValorDescuento`,`Clientes_idClientes`, `SubtotalCosto`,`Usuarios_idUsuarios`, `TipoItem`, `PrecioCosto`) VALUES (NEW.Cotizaciones_idCotizaciones,NEW.Fecha,NEW.Producto,NEW.Referencia,NEW.ValorVentaUnitario,NEW.Cantidad,@SubTotal,NEW.Impuestos, NEW.TotalVenta,NEW.Descuentos,NEW.Clientes_idClientes,NEW.TotalCosto,NEW.Usuarios_idUsuarios,'PR',@PrecioPromedio);

END IF;

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_devoluciones`
--

CREATE TABLE IF NOT EXISTS `ventas_devoluciones` (
  `idDevoluciones` int(16) NOT NULL AUTO_INCREMENT,
  `Facturas_idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaDevolucion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Subtotal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `IVA` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Total` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `SubtotalCosto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clientes_idClientes` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `CerradoDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaCierreDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `HoraCierreDiario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsuarioCierreDiario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idDevoluciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_nota_credito`
--

CREATE TABLE IF NOT EXISTS `ventas_nota_credito` (
  `idNotasCredito` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `NombreCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `DBCR` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Facturas_idFacturas` int(11) NOT NULL,
  `Concepto` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idNotasCredito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_separados`
--

CREATE TABLE IF NOT EXISTS `ventas_separados` (
  `idVentas_Separados` int(11) NOT NULL AUTO_INCREMENT,
  `Facturas_idFacturas` int(11) NOT NULL,
  `Retirado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `FechaRetiro` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsuariosEntrega` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVentas_Separados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vestasactivas`
--

CREATE TABLE IF NOT EXISTS `vestasactivas` (
  `idVestasActivas` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Usuario_idUsuario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Clientes_idClientes` int(11) NOT NULL DEFAULT '0',
  `SaldoFavor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVestasActivas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
