-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `abonos_libro`;
CREATE TABLE `abonos_libro` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Cantidad` float NOT NULL,
  `idLibroDiario` bigint(20) NOT NULL,
  `idComprobanteContable` bigint(20) NOT NULL,
  `TipoAbono` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `activos`;
CREATE TABLE `activos` (
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


DROP TABLE IF EXISTS `act_movimientos`;
CREATE TABLE `act_movimientos` (
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


DROP TABLE IF EXISTS `act_ordenes`;
CREATE TABLE `act_ordenes` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `act_pre_movimientos`;
CREATE TABLE `act_pre_movimientos` (
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


DROP TABLE IF EXISTS `act_pre_ordenes`;
CREATE TABLE `act_pre_ordenes` (
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


DROP TABLE IF EXISTS `alertas`;
CREATE TABLE `alertas` (
  `idAlertas` int(45) NOT NULL AUTO_INCREMENT,
  `AlertaTipo` varchar(45) NOT NULL,
  `Mensaje` varchar(500) NOT NULL,
  `Cartera_idCartera` varchar(45) NOT NULL,
  `PagosProgram_idPagosProgram` varchar(45) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idAlertas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `autorizaciones_generales`;
CREATE TABLE `autorizaciones_generales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Proceso` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Clave` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `bodega`;
CREATE TABLE `bodega` (
  `idBodega` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idServidor` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idBodega`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cajas`;
CREATE TABLE `cajas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Base` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUCEfectivo` bigint(20) NOT NULL,
  `CuentaPUCCheques` bigint(20) NOT NULL,
  `CuentaPUCOtros` bigint(20) NOT NULL,
  `CuentaPUCIVAEgresos` bigint(20) NOT NULL,
  `idTerceroIntereses` bigint(20) NOT NULL COMMENT 'Nit del Tercero al que se va a ir la cuent x parar de intereses',
  `CentroCostos` int(11) NOT NULL,
  `idResolucionDian` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `cajas_aperturas_cierres`;
CREATE TABLE `cajas_aperturas_cierres` (
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
  `TotalRetiroSeparados` double NOT NULL,
  `TotalDevoluciones` double NOT NULL,
  `TotalTarjetas` double NOT NULL,
  `TotalCheques` double NOT NULL,
  `TotalOtros` double NOT NULL,
  `TotalEntrega` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `cartera`;
CREATE TABLE `cartera` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `centrocosto`;
CREATE TABLE `centrocosto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `cierres_contables`;
CREATE TABLE `cierres_contables` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `ciuu`;
CREATE TABLE `ciuu` (
  `Codigo` int(11) NOT NULL,
  `Descripcion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `clasecuenta`;
CREATE TABLE `clasecuenta` (
  `PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clase` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `idClientes` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Documento` int(11) NOT NULL,
  `Num_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DV` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
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
  `Soporte` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idClientes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cod_departamentos`;
CREATE TABLE `cod_departamentos` (
  `Cod_dpto` int(11) NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Cod_dpto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cod_documentos`;
CREATE TABLE `cod_documentos` (
  `Codigo` int(11) NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `Codigo` (`Codigo`),
  KEY `Codigo_2` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cod_municipios_dptos`;
CREATE TABLE `cod_municipios_dptos` (
  `ID` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Dpto` int(11) NOT NULL,
  `Departamento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cod_paises`;
CREATE TABLE `cod_paises` (
  `Codigo` int(11) NOT NULL,
  `Pais` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `colaboradores`;
CREATE TABLE `colaboradores` (
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
  `Activo` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idColaboradores`),
  UNIQUE KEY `Identificacion` (`Identificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `colaboradores_ventas`;
CREATE TABLE `colaboradores_ventas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Total` float NOT NULL,
  `idColaborador` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `col_registrohoras`;
CREATE TABLE `col_registrohoras` (
  `IdColRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `IdColaborador` int(11) NOT NULL,
  `RegistroFecha` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `RegistroHora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `EntradaSalida` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`IdColRegistro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comisiones`;
CREATE TABLE `comisiones` (
  `idComisiones` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Porcentaje` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idComisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comisionesporventas`;
CREATE TABLE `comisionesporventas` (
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


DROP TABLE IF EXISTS `compras`;
CREATE TABLE `compras` (
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


DROP TABLE IF EXISTS `compras_activas`;
CREATE TABLE `compras_activas` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `compras_precompra`;
CREATE TABLE `compras_precompra` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comprobantes_contabilidad`;
CREATE TABLE `comprobantes_contabilidad` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `comprobantes_contabilidad_items`;
CREATE TABLE `comprobantes_contabilidad_items` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idComprobante` int(16) NOT NULL,
  `Fecha` date NOT NULL,
  `CentroCostos` int(11) NOT NULL,
  `Tercero` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `comprobantes_egreso_items`;
CREATE TABLE `comprobantes_egreso_items` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `comprobantes_ingreso`;
CREATE TABLE `comprobantes_ingreso` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Clientes_idClientes` int(11) NOT NULL,
  `Tercero` int(11) NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Tipo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `comprobantes_ingreso_anulaciones`;
CREATE TABLE `comprobantes_ingreso_anulaciones` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `comprobantes_ingreso_items`;
CREATE TABLE `comprobantes_ingreso_items` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `comprobantes_pre`;
CREATE TABLE `comprobantes_pre` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `idComprobanteContabilidad` int(16) NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `concejales`;
CREATE TABLE `concejales` (
  `ID` bigint(20) NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Cargo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Terminacion` date NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `concejales_intervenciones`;
CREATE TABLE `concejales_intervenciones` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `concejo_sesiones`;
CREATE TABLE `concejo_sesiones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Sesion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` date NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `concejo_tipo_sesiones`;
CREATE TABLE `concejo_tipo_sesiones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `conceptos`;
CREATE TABLE `conceptos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `conceptos_montos`;
CREATE TABLE `conceptos_montos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `conceptos_movimientos`;
CREATE TABLE `conceptos_movimientos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `configuracion_general`;
CREATE TABLE `configuracion_general` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE latin1_spanish_ci NOT NULL,
  `Valor` text COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `config_codigo_barras`;
CREATE TABLE `config_codigo_barras` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `config_puertos`;
CREATE TABLE `config_puertos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Puerto` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Utilizacion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `config_tiketes_promocion`;
CREATE TABLE `config_tiketes_promocion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreTiket` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Tope` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Multiple` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Activo` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `costos`;
CREATE TABLE `costos` (
  `idCostos` int(20) NOT NULL AUTO_INCREMENT,
  `NombreCosto` varchar(45) NOT NULL,
  `ValorCosto` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCostos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cotizacionesv5`;
CREATE TABLE `cotizacionesv5` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `cotizaciones_anexos`;
CREATE TABLE `cotizaciones_anexos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FechaCreacion` datetime NOT NULL,
  `Titulo` text COLLATE utf8_spanish2_ci NOT NULL,
  `NumCotizacion` bigint(20) NOT NULL,
  `Anexo` text COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `cot_itemscotizaciones`;
CREATE TABLE `cot_itemscotizaciones` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `idCliente` int(11) NOT NULL DEFAULT '0',
  `NumCotizacion` int(16) NOT NULL,
  `Descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `Referencia` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `TablaOrigen` varchar(45) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `ValorUnitario` double NOT NULL,
  `Cantidad` double NOT NULL,
  `Multiplicador` int(11) NOT NULL,
  `Subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `Total` double NOT NULL,
  `Descuento` double NOT NULL,
  `ValorDescuento` double NOT NULL,
  `PrecioCosto` double NOT NULL,
  `SubtotalCosto` double NOT NULL,
  `TipoItem` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Devuelto` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) CHARACTER SET utf8 NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `NumCotizacion` (`NumCotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `crono_controles`;
CREATE TABLE `crono_controles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idSesionConcejo` bigint(20) NOT NULL,
  `idConcejal` bigint(20) NOT NULL,
  `Estado` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `Inicio` time NOT NULL,
  `Fin` time NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE `cuentas` (
  `idPUC` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `GupoCuentas_PUC` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `cuentasfrecuentes`;
CREATE TABLE `cuentasfrecuentes` (
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `ClaseCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsoFuturo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CuentaPUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `cuentasxpagar`;
CREATE TABLE `cuentasxpagar` (
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
  `CuentaPUC` varchar(20) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '220505',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `cuentasxpagar_abonos`;
CREATE TABLE `cuentasxpagar_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idCuentaXPagar` text COLLATE utf8_spanish2_ci NOT NULL,
  `Monto` double NOT NULL,
  `idUsuarios` bigint(20) NOT NULL,
  `idComprobanteEgreso` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `devolucionesventas`;
CREATE TABLE `devolucionesventas` (
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


DROP TABLE IF EXISTS `documentos_generados`;
CREATE TABLE `documentos_generados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Abreviatura` varchar(3) COLLATE utf8_spanish2_ci NOT NULL,
  `Libro` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Abreviatura` (`Abreviatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `egresos`;
CREATE TABLE `egresos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `egresos_activos`;
CREATE TABLE `egresos_activos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  `Cuentas_idCuentas` int(11) NOT NULL,
  `Visible` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `egresos_anulaciones`;
CREATE TABLE `egresos_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `idComprobanteEgreso` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `egresos_items`;
CREATE TABLE `egresos_items` (
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


DROP TABLE IF EXISTS `egresos_pre`;
CREATE TABLE `egresos_pre` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCuentaXPagar` bigint(20) NOT NULL,
  `Abono` double NOT NULL,
  `Descuento` double NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `egresos_tipo`;
CREATE TABLE `egresos_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Cuentas_idCuentas` int(11) NOT NULL,
  `Visible` int(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `empresapro`;
CREATE TABLE `empresapro` (
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
  `FacturaSinInventario` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CXPAutomaticas` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idEmpresaPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `empresapro_resoluciones_facturacion`;
CREATE TABLE `empresapro_resoluciones_facturacion` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `empresa_pro_sucursales`;
CREATE TABLE `empresa_pro_sucursales` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `estadosfinancieros_mayor_temporal`;
CREATE TABLE `estadosfinancieros_mayor_temporal` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaCorte` date NOT NULL,
  `Clase` int(11) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `SaldoAnterior` double NOT NULL,
  `Neto` double NOT NULL,
  `SaldoFinal` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `facturas`;
CREATE TABLE `facturas` (
  `idFacturas` varchar(45) NOT NULL,
  `idResolucion` int(11) NOT NULL,
  `TipoFactura` varchar(10) NOT NULL,
  `Prefijo` varchar(45) NOT NULL,
  `NumeroFactura` int(16) NOT NULL,
  `Fecha` date NOT NULL,
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


DELIMITER ;;

CREATE TRIGGER `InsertFacturaOri` AFTER INSERT ON `facturas` FOR EACH ROW
BEGIN

INSERT INTO ori_facturas SELECT * FROM facturas WHERE idFacturas=New.idFacturas;


END;;

CREATE TRIGGER `Actualiza_OriFacturas` AFTER UPDATE ON `facturas` FOR EACH ROW
BEGIN

REPLACE INTO ori_facturas SELECT * FROM facturas WHERE idFacturas=New.idFacturas;


END;;

DELIMITER ;

DROP TABLE IF EXISTS `facturas_abonos`;
CREATE TABLE `facturas_abonos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `TipoPagoAbono` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Facturas_idFacturas` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `FormaPago` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idComprobanteIngreso` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `facturas_anticipos`;
CREATE TABLE `facturas_anticipos` (
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


DROP TABLE IF EXISTS `facturas_autoretenciones`;
CREATE TABLE `facturas_autoretenciones` (
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


DROP TABLE IF EXISTS `facturas_formapago`;
CREATE TABLE `facturas_formapago` (
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


DROP TABLE IF EXISTS `facturas_intereses_sistecredito`;
CREATE TABLE `facturas_intereses_sistecredito` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idFactura` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `Valor` double NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `facturas_items`;
CREATE TABLE `facturas_items` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FechaFactura` date NOT NULL,
  `idFactura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `TablaItems` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
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
  `ValorOtrosImpuestos` double NOT NULL,
  `TotalItem` double NOT NULL COMMENT 'Total del valor del Item',
  `PorcentajeIVA` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'que porcentaje de IVA se le aplico',
  `idOtrosImpuestos` int(11) NOT NULL,
  `idPorcentajeIVA` int(11) NOT NULL,
  `PrecioCostoUnitario` double NOT NULL,
  `SubtotalCosto` double NOT NULL COMMENT 'Costo total del item',
  `TipoItem` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFactura` (`idFactura`),
  KEY `idCierre` (`idCierre`),
  KEY `FechaFactura` (`FechaFactura`),
  KEY `Referencia` (`Referencia`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DELIMITER ;;

CREATE TRIGGER `InsertFacturasItems` AFTER INSERT ON `facturas_items` FOR EACH ROW
BEGIN

INSERT INTO ori_facturas_items SELECT * FROM facturas_items WHERE ID=New.ID;

END;;

DELIMITER ;

DROP TABLE IF EXISTS `facturas_kardex`;
CREATE TABLE `facturas_kardex` (
  `idFacturas` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `CuentaDestino` bigint(20) NOT NULL,
  `Kardex` varchar(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'NO',
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `facturas_pre`;
CREATE TABLE `facturas_pre` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `FechaFactura` date NOT NULL,
  `idFactura` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `TablaItems` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` text COLLATE utf8_spanish2_ci NOT NULL,
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
  `TotalItem` double NOT NULL,
  `PorcentajeIVA` double NOT NULL,
  `PrecioCostoUnitario` double NOT NULL,
  `SubtotalCosto` double NOT NULL,
  `TipoItem` varchar(10) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `facturas_reten_aplicadas`;
CREATE TABLE `facturas_reten_aplicadas` (
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


DELIMITER ;;

CREATE TRIGGER `ActualizaSaldoFact` AFTER INSERT ON `facturas_reten_aplicadas` FOR EACH ROW
BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=NEW.Facturas_idFacturas;

SET @Saldo=@SaldoAnt-NEW.Monto;

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=NEW.Facturas_idFacturas;


END;;

CREATE TRIGGER `ActualizaSaldoFactUpdate` AFTER UPDATE ON `facturas_reten_aplicadas` FOR EACH ROW
BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=NEW.Facturas_idFacturas;

SET @Saldo=@SaldoAnt+(OLD.Monto-NEW.Monto);

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=NEW.Facturas_idFacturas;


END;;

CREATE TRIGGER `ActualizaSaldoFactDel` BEFORE DELETE ON `facturas_reten_aplicadas` FOR EACH ROW
BEGIN

SELECT SaldoFact into @SaldoAnt FROM facturas WHERE idFacturas=OLD.Facturas_idFacturas;

SET @Saldo=@SaldoAnt+OLD.Monto;

UPDATE facturas SET SaldoFact=@Saldo WHERE idFacturas=OLD.Facturas_idFacturas;


END;;

DELIMITER ;

DROP TABLE IF EXISTS `facturas_tipo_pago`;
CREATE TABLE `facturas_tipo_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoPago` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Leyenda` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `factura_compra`;
CREATE TABLE `factura_compra` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Tercero` bigint(20) NOT NULL,
  `Concepto` text COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `NumeroFactura` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Estado` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `TipoCompra` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Soporte` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idCentroCostos` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `factura_compra_anulaciones`;
CREATE TABLE `factura_compra_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `idCompra` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `factura_compra_descuentos`;
CREATE TABLE `factura_compra_descuentos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCompra` bigint(20) NOT NULL,
  `CuentaPUCDescuento` bigint(20) NOT NULL,
  `NombreCuentaDescuento` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `ValorDescuento` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `factura_compra_items`;
CREATE TABLE `factura_compra_items` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFacturaCompra` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoUnitarioCompra` double NOT NULL,
  `SubtotalCompra` double NOT NULL,
  `ImpuestoCompra` double NOT NULL,
  `TotalCompra` double NOT NULL,
  `Tipo_Impuesto` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `ProcentajeDescuento` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `ValorDescuento` double NOT NULL,
  `SubtotalDescuento` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idFacturaCompra` (`idFacturaCompra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `factura_compra_items_devoluciones`;
CREATE TABLE `factura_compra_items_devoluciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFacturaCompra` bigint(20) NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoUnitarioCompra` double NOT NULL,
  `SubtotalCompra` double NOT NULL,
  `ImpuestoCompra` double NOT NULL,
  `TotalCompra` double NOT NULL,
  `Tipo_Impuesto` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `factura_compra_retenciones`;
CREATE TABLE `factura_compra_retenciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCompra` bigint(20) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `ValorRetencion` double NOT NULL,
  `PorcentajeRetenido` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `factura_compra_servicios`;
CREATE TABLE `factura_compra_servicios` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `fechas_descuentos`;
CREATE TABLE `fechas_descuentos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `formatos_calidad`;
CREATE TABLE `formatos_calidad` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` text COLLATE utf8_spanish2_ci NOT NULL,
  `Version` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Codigo` text COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` date NOT NULL,
  `CuerpoFormato` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `NotasPiePagina` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `gupocuentas`;
CREATE TABLE `gupocuentas` (
  `PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ClaseCuenta_PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `impret`;
CREATE TABLE `impret` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `ingresos`;
CREATE TABLE `ingresos` (
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


DROP TABLE IF EXISTS `ingresosvarios`;
CREATE TABLE `ingresosvarios` (
  `idIngresosVarios` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idIngresosVarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `inventarios_diferencias`;
CREATE TABLE `inventarios_diferencias` (
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


DROP TABLE IF EXISTS `inventarios_temporal`;
CREATE TABLE `inventarios_temporal` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Nombre` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double DEFAULT NULL,
  `CostoTotal` double DEFAULT NULL,
  `CostoUnitarioPromedio` double NOT NULL,
  `CostoTotalPromedio` double NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `kardexmercancias`;
CREATE TABLE `kardexmercancias` (
  `idKardexMercancias` bigint(20) NOT NULL AUTO_INCREMENT,
  `idBodega` int(11) NOT NULL DEFAULT '1',
  `Fecha` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(400) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDocumento` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoUnitarioPromedio` double NOT NULL,
  `CostoTotalPromedio` double NOT NULL,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKardexMercancias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `kardexmercancias_temporal`;
CREATE TABLE `kardexmercancias_temporal` (
  `idKardexMercancias` bigint(20) NOT NULL AUTO_INCREMENT,
  `idBodega` int(11) NOT NULL DEFAULT '1',
  `Fecha` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Movimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(400) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDocumento` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorUnitario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `ValorTotal` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CostoPromedioUnitario` double NOT NULL,
  `CostoPromedioTotal` double NOT NULL,
  `ProductosVenta_idProductosVenta` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKardexMercancias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `kardex_alquiler`;
CREATE TABLE `kardex_alquiler` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Movimiento` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `Equipo` text COLLATE latin1_spanish_ci NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `RazonSocial` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `Detalle` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `NumDocumento` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorTotal` double NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `idProducto` (`idProducto`),
  KEY `idProducto_2` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `kits`;
CREATE TABLE `kits` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `kits_relaciones`;
CREATE TABLE `kits_relaciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TablaProducto` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `ReferenciaProducto` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `IDKit` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `librodiario`;
CREATE TABLE `librodiario` (
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
  PRIMARY KEY (`idLibroDiario`),
  KEY `Tipo_Documento_Intero` (`Tipo_Documento_Intero`),
  KEY `Tercero_Identificacion` (`Tercero_Identificacion`),
  KEY `Num_Documento_Interno` (`Num_Documento_Interno`),
  KEY `CuentaPUC` (`CuentaPUC`),
  KEY `Fecha` (`Fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `libromayorbalances`;
CREATE TABLE `libromayorbalances` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FechaInicial` date NOT NULL,
  `FechaFinal` date NOT NULL,
  `CuentaPUC` bigint(20) DEFAULT NULL,
  `NombreCuenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `SaldoAnterior` double NOT NULL,
  `Debito` double DEFAULT NULL,
  `Credito` double DEFAULT NULL,
  `NuevoSaldo` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `maquinas`;
CREATE TABLE `maquinas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `Pagina` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `Target` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '_SELF',
  `Estado` int(1) NOT NULL DEFAULT '1',
  `Image` text COLLATE latin1_spanish_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `menu_carpetas`;
CREATE TABLE `menu_carpetas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ruta` varchar(90) COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `menu_pestanas`;
CREATE TABLE `menu_pestanas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idMenu` int(11) NOT NULL,
  `Orden` int(11) NOT NULL,
  `Estado` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `menu_submenus`;
CREATE TABLE `menu_submenus` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `idPestana` int(11) NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `Pagina` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Target` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `Estado` bit(1) NOT NULL,
  `Image` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `notascontables`;
CREATE TABLE `notascontables` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `notascontables_anulaciones`;
CREATE TABLE `notascontables_anulaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `idNota` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `notascredito`;
CREATE TABLE `notascredito` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `ordenesdecompra`;
CREATE TABLE `ordenesdecompra` (
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


DROP TABLE IF EXISTS `ordenesdecompra_items`;
CREATE TABLE `ordenesdecompra_items` (
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


DROP TABLE IF EXISTS `ordenesdetrabajo`;
CREATE TABLE `ordenesdetrabajo` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `ordenesdetrabajo_items`;
CREATE TABLE `ordenesdetrabajo_items` (
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


DROP TABLE IF EXISTS `ordenesdetrabajo_tipo`;
CREATE TABLE `ordenesdetrabajo_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `ori_facturas`;
CREATE TABLE `ori_facturas` (
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


DROP TABLE IF EXISTS `ori_facturas_items`;
CREATE TABLE `ori_facturas_items` (
  `ID` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `FechaFactura` date NOT NULL,
  `idFactura` varchar(45) NOT NULL,
  `TablaItems` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla donde se encuentra el producto o servicio',
  `Referencia` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Referencia del producto o servicio',
  `Nombre` varchar(500) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `SubGrupo1` int(11) NOT NULL,
  `SubGrupo2` int(11) NOT NULL,
  `SubGrupo3` int(11) NOT NULL,
  `SubGrupo4` int(11) NOT NULL,
  `SubGrupo5` int(11) NOT NULL,
  `ValorUnitarioItem` int(11) NOT NULL,
  `Cantidad` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `Dias` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `SubtotalItem` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `IVAItem` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `ValorOtrosImpuestos` double NOT NULL,
  `TotalItem` double NOT NULL COMMENT 'Total del valor del Item',
  `PorcentajeIVA` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'que porcentaje de IVA se le aplico',
  `idOtrosImpuestos` int(11) NOT NULL,
  `idPorcentajeIVA` int(11) NOT NULL,
  `PrecioCostoUnitario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `SubtotalCosto` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Costo total del item',
  `TipoItem` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Define si se realiza ajustes a inventarios',
  `CuentaPUC` int(11) NOT NULL COMMENT 'Cuenta donde se llevara el asiento contable ',
  `GeneradoDesde` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tabla que agrega el item',
  `NumeroIdentificador` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Identificar del que agrega el item',
  `idUsuarios` int(11) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `idFactura` (`idFactura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `paginas`;
CREATE TABLE `paginas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `TipoPagina` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Visible` tinyint(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `paginas_bloques`;
CREATE TABLE `paginas_bloques` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoUsuario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Pagina` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `parametros_contables`;
CREATE TABLE `parametros_contables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `parametros_generales`;
CREATE TABLE `parametros_generales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `KardexCotizacion` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `plataforma_tablas`;
CREATE TABLE `plataforma_tablas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `porcentajes_iva`;
CREATE TABLE `porcentajes_iva` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Factor` varchar(10) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'M',
  `CuentaPUC` bigint(20) NOT NULL,
  `CuentaPUCIVAGenerado` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `precotizacion`;
CREATE TABLE `precotizacion` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NumSolicitud` varchar(45) NOT NULL,
  `Cantidad` double NOT NULL,
  `Multiplicador` int(11) NOT NULL DEFAULT '1',
  `Referencia` varchar(45) NOT NULL,
  `ValorUnitario` double NOT NULL,
  `SubTotal` double NOT NULL,
  `Descripcion` text NOT NULL,
  `IVA` double NOT NULL,
  `Descuento` double NOT NULL,
  `ValorDescuento` double NOT NULL,
  `PrecioCosto` double NOT NULL,
  `SubtotalCosto` double NOT NULL,
  `Total` double NOT NULL,
  `TipoItem` varchar(10) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `CuentaPUC` varchar(45) NOT NULL,
  `Tabla` varchar(45) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `preventa`;
CREATE TABLE `preventa` (
  `idPrecotizacion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Cantidad` double NOT NULL,
  `VestasActivas_idVestasActivas` int(11) NOT NULL,
  `idFacturas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `TablaItem` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ValorUnitario` double NOT NULL,
  `Subtotal` double NOT NULL,
  `ValorAcordado` double NOT NULL,
  `CostoUnitario` double NOT NULL,
  `PrecioMayorista` double NOT NULL,
  `Descuento` double NOT NULL,
  `Impuestos` double NOT NULL,
  `PorcentajeIVA` double NOT NULL,
  `TotalVenta` double NOT NULL,
  `TipoItem` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idSistema` int(11) NOT NULL,
  `Autorizado` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPrecotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `produccion_actividades`;
CREATE TABLE `produccion_actividades` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `produccion_horas_cronograma`;
CREATE TABLE `produccion_horas_cronograma` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Hora` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `produccion_ordenes_trabajo`;
CREATE TABLE `produccion_ordenes_trabajo` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `produccion_pausas_predefinidas`;
CREATE TABLE `produccion_pausas_predefinidas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Suma` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `produccion_registro_tiempos`;
CREATE TABLE `produccion_registro_tiempos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idActividad` bigint(20) NOT NULL,
  `FechaHora` datetime NOT NULL,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Suma` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `productosalquiler`;
CREATE TABLE `productosalquiler` (
  `idProductosVenta` int(11) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Existencias` int(11) NOT NULL,
  `EnAlquiler` int(11) NOT NULL,
  `EnBodega` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `productosventa`;
CREATE TABLE `productosventa` (
  `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Existencias` double DEFAULT '0',
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayorista` double NOT NULL,
  `CostoUnitario` double DEFAULT NULL,
  `CostoTotal` double DEFAULT NULL,
  `CostoUnitarioPromedio` double NOT NULL,
  `CostoTotalPromedio` double NOT NULL,
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
  `ValorComision1` int(11) NOT NULL,
  `ValorComision2` int(11) NOT NULL,
  `ValorComision3` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProductosVenta`),
  UNIQUE KEY `Referencia` (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `insKardex` AFTER INSERT ON `productosventa` FOR EACH ROW
BEGIN

SET @fecha=CURDATE();
    INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (@fecha,'ENTRADA','INICIO',NEW.Existencias,NEW.CostoUnitario,NEW.CostoTotal,NEW.idProductosVenta);
    
    INSERT INTO kardexmercancias (`Fecha`, `Movimiento`, `Detalle`, `Cantidad`,`ValorUnitario`, `ValorTotal`, `ProductosVenta_idProductosVenta`) VALUES (@fecha,'SALDOS','INICIO',NEW.Existencias,NEW.CostoUnitario,NEW.CostoTotal,NEW.idProductosVenta);

SET @Dep=LPAD(NEW.Departamento,2,'0');

SET @Sub1=LPAD(NEW.Sub1,2,'0');

SET @id=LPAD(NEW.idProductosVenta,7,'0');
    
    
SET @Codigo=CONCAT(@Dep,@Sub1,@id);

INSERT INTO prod_codbarras (`CodigoBarras`,`ProductosVenta_idProductosVenta`) VALUES (@Codigo,NEW.idProductosVenta);

END;;

DELIMITER ;

DROP TABLE IF EXISTS `productosventa_bodega_1`;
CREATE TABLE `productosventa_bodega_1` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa_bodega_2`;
CREATE TABLE `productosventa_bodega_2` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa_bodega_3`;
CREATE TABLE `productosventa_bodega_3` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa_bodega_4`;
CREATE TABLE `productosventa_bodega_4` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productosventa_bodega_5`;
CREATE TABLE `productosventa_bodega_5` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `productos_impuestos_adicionales`;
CREATE TABLE `productos_impuestos_adicionales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreImpuesto` text COLLATE latin1_spanish_ci NOT NULL,
  `idProducto` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `ValorImpuesto` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE latin1_spanish_ci NOT NULL,
  `Incluido` enum('SI','NO') COLLATE latin1_spanish_ci NOT NULL DEFAULT 'NO',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `productos_lista_precios`;
CREATE TABLE `productos_lista_precios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `Descripcion` text COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `productos_precios_adicionales`;
CREATE TABLE `productos_precios_adicionales` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `idListaPrecios` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `TablaVenta` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='tabla para agregar precios a los productos';


DROP TABLE IF EXISTS `prod_bajas_altas`;
CREATE TABLE `prod_bajas_altas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Movimiento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `CostoTotal` double NOT NULL,
  `Observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_bodega`;
CREATE TABLE `prod_bodega` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idProductoAlquiler` int(11) NOT NULL,
  `Bodega_idCliente` int(11) NOT NULL,
  `CantidadProd` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `prod_codbarras`;
CREATE TABLE `prod_codbarras` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `TablaOrigen` varchar(90) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'productosventa',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras_bodega_1`;
CREATE TABLE `prod_codbarras_bodega_1` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras_bodega_2`;
CREATE TABLE `prod_codbarras_bodega_2` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras_bodega_3`;
CREATE TABLE `prod_codbarras_bodega_3` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras_bodega_4`;
CREATE TABLE `prod_codbarras_bodega_4` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_codbarras_bodega_5`;
CREATE TABLE `prod_codbarras_bodega_5` (
  `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
  `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
  `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCodBarras`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_comisiones`;
CREATE TABLE `prod_comisiones` (
  `idProd_Comisiones` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre_Comision` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `P_V` int(2) NOT NULL COMMENT '1 Valor 0 Porcentaje',
  `ValorComision1` double NOT NULL,
  `ValorComision2` double NOT NULL,
  `ValorComision3` double NOT NULL,
  `Porcentaje_Comision` double NOT NULL,
  `Dep_Comision` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProd_Comisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_departamentos`;
CREATE TABLE `prod_departamentos` (
  `idDepartamentos` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TablaOrigen` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `TipoItem` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `ManejaExistencias` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idDepartamentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_kits`;
CREATE TABLE `prod_kits` (
  `idKits` int(11) NOT NULL AUTO_INCREMENT,
  `TablaProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ReferenciaProducto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idKits`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sinc`;
CREATE TABLE `prod_sinc` (
  `Referencia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Departamento` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioVenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `Productos_Sinc` AFTER INSERT ON `prod_sinc` FOR EACH ROW
BEGIN

UPDATE productosventa SET PrecioVenta=NEW.PrecioVenta WHERE Referencia=NEW.Referencia AND Departamento=NEW.Departamento;

UPDATE productosventa SET PrecioMayorista=NEW.PrecioMayorista WHERE Referencia=NEW.Referencia AND Departamento=NEW.Departamento;

END;;

DELIMITER ;

DROP TABLE IF EXISTS `prod_sub1`;
CREATE TABLE `prod_sub1` (
  `idSub1` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub1` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idDepartamento` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sub2`;
CREATE TABLE `prod_sub2` (
  `idSub2` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub2` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub1` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sub3`;
CREATE TABLE `prod_sub3` (
  `idSub3` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub3` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub2` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sub4`;
CREATE TABLE `prod_sub4` (
  `idSub4` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub4` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub3` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub4`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sub5`;
CREATE TABLE `prod_sub5` (
  `idSub5` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub5` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub4` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub5`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `prod_sub6`;
CREATE TABLE `prod_sub6` (
  `idSub6` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSub6` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSub5` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idSub6`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `idProveedores` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Documento` int(11) NOT NULL,
  `Num_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DV` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
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
  `Soporte` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idProveedores`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `publicidad_encabezado_cartel`;
CREATE TABLE `publicidad_encabezado_cartel` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` text COLLATE latin1_spanish_ci NOT NULL,
  `ColorTitulo` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `Desde` int(11) NOT NULL,
  `Hasta` int(11) NOT NULL,
  `Mes` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `Anio` int(11) NOT NULL,
  `ColorRazonSocial` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `ColorPrecios` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `ColorBordes` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `publicidad_paginas`;
CREATE TABLE `publicidad_paginas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `registra_apertura_documentos`;
CREATE TABLE `registra_apertura_documentos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Documento` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NumDocumento` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `ConceptoApertura` text COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `registra_ediciones`;
CREATE TABLE `registra_ediciones` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `registra_eliminaciones`;
CREATE TABLE `registra_eliminaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Campo` text COLLATE latin1_spanish_ci NOT NULL,
  `Valor` text COLLATE latin1_spanish_ci NOT NULL,
  `Causal` text COLLATE latin1_spanish_ci NOT NULL,
  `TablaOrigen` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `idTabla` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idItemEliminado` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `TablaOrigen` (`TablaOrigen`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `registro_basculas`;
CREATE TABLE `registro_basculas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Gramos` double NOT NULL,
  `idBascula` int(11) NOT NULL,
  `Leido` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `relacioncompras`;
CREATE TABLE `relacioncompras` (
  `idRelacionCompras` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DELIMITER ;;

CREATE TRIGGER `KardexCompras` AFTER INSERT ON `relacioncompras` FOR EACH ROW
BEGIN


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


END;;

DELIMITER ;

DROP TABLE IF EXISTS `remisiones`;
CREATE TABLE `remisiones` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `rem_devoluciones`;
CREATE TABLE `rem_devoluciones` (
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


DROP TABLE IF EXISTS `rem_devoluciones_totalizadas`;
CREATE TABLE `rem_devoluciones_totalizadas` (
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


DROP TABLE IF EXISTS `rem_pre_devoluciones`;
CREATE TABLE `rem_pre_devoluciones` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `rem_relaciones`;
CREATE TABLE `rem_relaciones` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `repuestas_forma_pago`;
CREATE TABLE `repuestas_forma_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DiasCartera` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Etiqueta` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `requerimientos_proyectos`;
CREATE TABLE `requerimientos_proyectos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `respuestas_condicional`;
CREATE TABLE `respuestas_condicional` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(4) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `respuestas_tipo_item`;
CREATE TABLE `respuestas_tipo_item` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(4) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `restaurante_cierres`;
CREATE TABLE `restaurante_cierres` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `restaurante_mesas`;
CREATE TABLE `restaurante_mesas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Capacidad` int(11) NOT NULL,
  `Estado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `restaurante_pedidos`;
CREATE TABLE `restaurante_pedidos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idMesa` int(11) NOT NULL,
  `Estado` varchar(4) COLLATE utf8_spanish2_ci NOT NULL,
  `Tipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `restaurante_pedidos_items`;
CREATE TABLE `restaurante_pedidos_items` (
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
  PRIMARY KEY (`ID`),
  KEY `idPedido` (`idPedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `salud_archivo_conceptos_glosas`;
CREATE TABLE `salud_archivo_conceptos_glosas` (
  `id_concepto_glosa` int(20) NOT NULL AUTO_INCREMENT,
  `cod_glosa` int(3) NOT NULL COMMENT 'Codigo de glosa, Devolucion o Respuestas',
  `cod_concepto_general` int(1) NOT NULL COMMENT 'Concepto general de la glosa',
  `cod_concepto_especifico` int(2) unsigned zerofill NOT NULL COMMENT 'Concepto especifico de la glosa',
  `descrpcion_concep_especifico` text CHARACTER SET utf8 NOT NULL COMMENT 'Descripción de la glosa ',
  `aplicacion` text CHARACTER SET utf8 NOT NULL COMMENT 'Aplica cuando:',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_concepto_glosa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT COMMENT='manual unico glosas,devoluciones y resp Ver Anexo tecn #6';


DROP TABLE IF EXISTS `salud_archivo_consultas`;
CREATE TABLE `salud_archivo_consultas` (
  `id_consultas` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `fecha_consulta` date NOT NULL COMMENT 'Fecha de la consulta " Ver Alineamientos tecnicos para ips ver pag 20"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_consulta` varchar(7) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código de la consulta " Ver Alineamientos tecnicos para ips ver pag 20"',
  `finalidad_consulta` enum('01','02','03','04','05','06','07','08','09','10') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Finalidad de la consulta " Ver Alineamientos tecnicos para ips ver pag 25"',
  `causa_externa` enum('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Causa externa " Ver Alineamientos tecnicos para ips ver pag 26"',
  `cod_diagnostico_principal` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código del diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 26"',
  `cod_diagnostico_relacionado1` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 1 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `cod_diagnostico_relacionado2` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 2 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `cod_diagnostico_relacionado3` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 3 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `tipo_diagn_principal` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_consulta` double(15,2) NOT NULL COMMENT 'Valor de la consulta " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_cuota_moderadora` double(15,2) NOT NULL COMMENT 'Valor de la cuota moderadora " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_neto_pagar_consulta` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la consulta " Ver Alineamientos tecnicos para ips ver pag 28"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_consultas`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de cosnultas AC';


DROP TABLE IF EXISTS `salud_archivo_consultas_temp`;
CREATE TABLE `salud_archivo_consultas_temp` (
  `id_consultas` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `fecha_consulta` date NOT NULL COMMENT 'Fecha de la consulta " Ver Alineamientos tecnicos para ips ver pag 20"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_consulta` varchar(7) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código de la consulta " Ver Alineamientos tecnicos para ips ver pag 20"',
  `finalidad_consulta` enum('01','02','03','04','05','06','07','08','09','10') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Finalidad de la consulta " Ver Alineamientos tecnicos para ips ver pag 25"',
  `causa_externa` enum('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Causa externa " Ver Alineamientos tecnicos para ips ver pag 26"',
  `cod_diagnostico_principal` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código del diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 26"',
  `cod_diagnostico_relacionado1` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 1 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `cod_diagnostico_relacionado2` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 2 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `cod_diagnostico_relacionado3` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 3 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `tipo_diagn_principal` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_consulta` double(15,2) NOT NULL COMMENT 'Valor de la consulta " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_cuota_moderadora` double(15,2) NOT NULL COMMENT 'Valor de la cuota moderadora " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_neto_pagar_consulta` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la consulta " Ver Alineamientos tecnicos para ips ver pag 28"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_consultas` (`id_consultas`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de cosnultas AC';


DROP TABLE IF EXISTS `salud_archivo_facturacion_mov_generados`;
CREATE TABLE `salud_archivo_facturacion_mov_generados` (
  `id_fac_mov_generados` int(20) NOT NULL AUTO_INCREMENT,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado  " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre con el que se hizo el cargue al sistema de cartera',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha Y Hora que se hizo el cargue',
  `idUser` int(11) NOT NULL,
  `eps_radicacion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Eps en la que se radico la factura',
  `dias_pactados` int(2) DEFAULT NULL COMMENT 'Dias que se pactaron para el pago de la factura con eps',
  `fecha_radicado` date DEFAULT NULL COMMENT 'Fecha de la radicacion de la factura',
  `numero_radicado` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero con que se radico la factura',
  `Soporte` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Ruta de Archivo de comprobación de radicado',
  `estado` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Indica en que tabla esta el registro en un momento dado ',
  `EstadoCobro` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_fac_mov_generados`),
  UNIQUE KEY `num_factura` (`num_factura`),
  KEY `estado` (`estado`),
  KEY `tipo_negociacion` (`tipo_negociacion`),
  KEY `Updated` (`Updated`),
  KEY `EstadoCobro` (`EstadoCobro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de transacciones_AF_generadas';


DROP TABLE IF EXISTS `salud_archivo_facturacion_mov_pagados`;
CREATE TABLE `salud_archivo_facturacion_mov_pagados` (
  `id_pagados` bigint(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura ',
  `fecha_pago_factura` date NOT NULL COMMENT 'Fecha de pago de la factura',
  `num_pago` int(10) NOT NULL COMMENT 'Número del comprobante del pago ',
  `valor_bruto_pagar` double(15,2) NOT NULL COMMENT 'Valor bruto a pagar',
  `valor_descuento` double(15,2) NOT NULL COMMENT 'Valor descuento',
  `valor_iva` double(15,2) NOT NULL COMMENT 'Valor iva',
  `valor_retefuente` double(15,2) NOT NULL COMMENT 'Valor retefuente',
  `valor_reteiva` double(15,2) NOT NULL COMMENT 'Valor reteiva',
  `valor_reteica` double(15,2) NOT NULL COMMENT 'Valor reteica',
  `valor_otrasretenciones` double(15,2) NOT NULL COMMENT 'Valor otras retenciones',
  `valor_cruces` double(15,2) NOT NULL COMMENT 'Valor de cruces posible glosas ',
  `valor_anticipos` double(15,2) NOT NULL COMMENT 'Valor de anticipos ',
  `valor_pagado` double(15,2) NOT NULL COMMENT 'Valor transferidoa banco ',
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_pagados`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de transacciones_AF_pagadas';


DROP TABLE IF EXISTS `salud_archivo_facturacion_mov_pagados_temp`;
CREATE TABLE `salud_archivo_facturacion_mov_pagados_temp` (
  `id_pagados` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura ',
  `fecha_pago_factura` date NOT NULL COMMENT 'Fecha de pago de la factura',
  `num_pago` int(10) NOT NULL COMMENT 'Número del comprobante del pago ',
  `valor_bruto_pagar` double(15,2) NOT NULL COMMENT 'Valor bruto a pagar',
  `valor_descuento` double(15,2) NOT NULL COMMENT 'Valor descuento',
  `valor_iva` double(15,2) NOT NULL COMMENT 'Valor iva',
  `valor_retefuente` double(15,2) NOT NULL COMMENT 'Valor retefuente',
  `valor_reteiva` double(15,2) NOT NULL COMMENT 'Valor reteiva',
  `valor_reteica` double(15,2) NOT NULL COMMENT 'Valor reteica',
  `valor_otrasretenciones` double(15,2) NOT NULL COMMENT 'Valor otras retenciones',
  `valor_cruces` double(15,2) NOT NULL COMMENT 'Valor de cruces posible glosas ',
  `valor_anticipos` double(15,2) NOT NULL COMMENT 'Valor de anticipos ',
  `valor_pagado` double(15,2) NOT NULL COMMENT 'Valor transferidoa banco ',
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_temp_rips_pagados` (`id_pagados`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo temporal de rips pagados';


DROP TABLE IF EXISTS `salud_archivo_hospitalizaciones`;
CREATE TABLE `salud_archivo_hospitalizaciones` (
  `id_hospitalizacion` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `via_ingreso` enum('1','2','3','4') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Vía de ingreso a la institución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `fecha_ingreso_hospi` date NOT NULL COMMENT 'Fecha de ingreso del usuario a la institución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `hora_ingreso` time NOT NULL COMMENT 'Hora de ingreso del usuario a la\r\nInstitución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 32" ',
  `causa_externa` enum('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Causa externa " Ver Alineamientos tecnicos para ips ver pag 32"',
  `diagn_princ_ingreso` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal de ingreso " Ver Alineamientos tecnicos para ips ver pag 36"',
  `diagn_princ_egreso` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac1_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 1 de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac2_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 2 de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac3_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 3 de egreso " Ver Alineamientos tecnicos para ips ver pag 38"',
  `diagn_complicacion` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico de la complicación " Ver Alineamientos tecnicos para ips ver pag 38"',
  `estado_salida_hospi` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Estado a la salida " Ver Alineamientos tecnicos para ips ver pag 38"',
  `diagn_causa_muerte` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico de la causa básica de muerte " Ver Alineamientos tecnicos para ips ver pag 38"',
  `fecha_salida_hospi` date NOT NULL COMMENT 'Fecha de egreso del usuario a la institución " Ver Alineamientos tecnicos para ips ver pag 38"',
  `hora_salida_hospi` time NOT NULL COMMENT 'Hora de egreso del usuario de la institución " Ver Alineamientos tecnicos para ips ver pag 38"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_hospitalizacion`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de hospitalización AH';


DROP TABLE IF EXISTS `salud_archivo_hospitalizaciones_temp`;
CREATE TABLE `salud_archivo_hospitalizaciones_temp` (
  `id_hospitalizacion` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `via_ingreso` enum('1','2','3','4') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Vía de ingreso a la institución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `fecha_ingreso_hospi` date NOT NULL COMMENT 'Fecha de ingreso del usuario a la institución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `hora_ingreso` time NOT NULL COMMENT 'Hora de ingreso del usuario a la\r\nInstitución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 32" ',
  `causa_externa` enum('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Causa externa " Ver Alineamientos tecnicos para ips ver pag 32"',
  `diagn_princ_ingreso` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal de ingreso " Ver Alineamientos tecnicos para ips ver pag 36"',
  `diagn_princ_egreso` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac1_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 1 de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac2_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 2 de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac3_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 3 de egreso " Ver Alineamientos tecnicos para ips ver pag 38"',
  `diagn_complicacion` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico de la complicación " Ver Alineamientos tecnicos para ips ver pag 38"',
  `estado_salida_hospi` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Estado a la salida " Ver Alineamientos tecnicos para ips ver pag 38"',
  `diagn_causa_muerte` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico de la causa básica de muerte " Ver Alineamientos tecnicos para ips ver pag 38"',
  `fecha_salida_hospi` date NOT NULL COMMENT 'Fecha de egreso del usuario a la institución " Ver Alineamientos tecnicos para ips ver pag 38"',
  `hora_salida_hospi` time NOT NULL COMMENT 'Hora de egreso del usuario de la institución " Ver Alineamientos tecnicos para ips ver pag 38"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_hospitalizacion` (`id_hospitalizacion`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de hospitalización AH';


DROP TABLE IF EXISTS `salud_archivo_medicamentos`;
CREATE TABLE `salud_archivo_medicamentos` (
  `id_medicamentos` bigint(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_medicamento` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `tipo_medicamento` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `forma_farmaceutica` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Forma farmacéutica" Ver Alineamientos tecnicos para ips ver pag 41"',
  `nom_medicamento` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre genérico del medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `concentracion_medic` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Concentración del medicamento" Ver Alineamientos tecnicos para ips ver pag 41"',
  `um_medicamento` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Unidad de medida del medicamento" Ver Alineamientos tecnicos para ips ver pag 41"',
  `num_und_medic` int(5) NOT NULL COMMENT 'Número de unidades" Ver Alineamientos tecnicos para ips ver pag 41"',
  `valor_unit_medic` double(15,2) NOT NULL COMMENT 'Valor unitario de medicamento " Ver Alineamientos tecnicos para ips ver pag 42"',
  `valor_total_medic` double(15,2) NOT NULL COMMENT 'Valor total del medicamento " Ver Alineamientos tecnicos para ips ver pag 42"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_medicamentos`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `nom_cargue_2` (`nom_cargue`),
  KEY `num_factura_2` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de medicamentos AM';


DROP TABLE IF EXISTS `salud_archivo_medicamentos_temp`;
CREATE TABLE `salud_archivo_medicamentos_temp` (
  `id_medicamentos` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_medicamento` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `tipo_medicamento` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `forma_farmaceutica` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Forma farmacéutica" Ver Alineamientos tecnicos para ips ver pag 41"',
  `nom_medicamento` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre genérico del medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `concentracion_medic` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Concentración del medicamento" Ver Alineamientos tecnicos para ips ver pag 41"',
  `um_medicamento` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Unidad de medida del medicamento" Ver Alineamientos tecnicos para ips ver pag 41"',
  `num_und_medic` int(5) NOT NULL COMMENT 'Número de unidades" Ver Alineamientos tecnicos para ips ver pag 41"',
  `valor_unit_medic` double(15,2) NOT NULL COMMENT 'Valor unitario de medicamento " Ver Alineamientos tecnicos para ips ver pag 42"',
  `valor_total_medic` double(15,2) NOT NULL COMMENT 'Valor total del medicamento " Ver Alineamientos tecnicos para ips ver pag 42"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_medicamentos` (`id_medicamentos`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `nom_cargue_2` (`nom_cargue`),
  KEY `num_factura_2` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de medicamentos AM';


DROP TABLE IF EXISTS `salud_archivo_nacidos`;
CREATE TABLE `salud_archivo_nacidos` (
  `id_recien_nacido` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación de la madre " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación de la madre en el Sistema " Ver Alineamientos tecnicos para ips ver pag 39"',
  `fecha_nacimiento_rn` date NOT NULL COMMENT 'Fecha de nacimiento del recién nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `hora_nacimiento_rc` time NOT NULL COMMENT 'Hora de nacimiento " Ver Alineamientos tecnicos para ips ver pag 39"',
  `edad_gestacional` int(2) NOT NULL COMMENT 'Edad gestacional " Ver Alineamientos tecnicos para ips ver pag 39 "',
  `control_prenatal` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Control prenatal " Ver Alineamientos tecnicos para ips ver pag 39"',
  `sexo_rc` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Sexo del recien nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `peso_rc` int(4) NOT NULL COMMENT 'Peso del recien nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `diagn_rc` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico del recién nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `causa_muerte_rc` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Causa básica de muerte recien nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `fecha_muerte_rc` date NOT NULL COMMENT 'Fecha de muerte del recién nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `hora_muerte_rc` time NOT NULL COMMENT 'Hora de muerte del recién nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_recien_nacido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de recien nacidos AN';


DROP TABLE IF EXISTS `salud_archivo_nacidos_temp`;
CREATE TABLE `salud_archivo_nacidos_temp` (
  `id_recien_nacido` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación de la madre " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación de la madre en el Sistema " Ver Alineamientos tecnicos para ips ver pag 39"',
  `fecha_nacimiento_rn` date NOT NULL COMMENT 'Fecha de nacimiento del recién nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `hora_nacimiento_rc` time NOT NULL COMMENT 'Hora de nacimiento " Ver Alineamientos tecnicos para ips ver pag 39"',
  `edad_gestacional` int(2) NOT NULL COMMENT 'Edad gestacional " Ver Alineamientos tecnicos para ips ver pag 39 "',
  `control_prenatal` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Control prenatal " Ver Alineamientos tecnicos para ips ver pag 39"',
  `sexo_rc` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Sexo del recien nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `peso_rc` int(4) NOT NULL COMMENT 'Peso del recien nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `diagn_rc` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico del recién nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `causa_muerte_rc` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Causa básica de muerte recien nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `fecha_muerte_rc` date NOT NULL COMMENT 'Fecha de muerte del recién nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `hora_muerte_rc` time NOT NULL COMMENT 'Hora de muerte del recién nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_recien_nacido` (`id_recien_nacido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de recien nacidos AN';


DROP TABLE IF EXISTS `salud_archivo_otros_servicios`;
CREATE TABLE `salud_archivo_otros_servicios` (
  `id_otro_servicios` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `tipo_servicio` enum('1','2','3','4') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de servicio " Ver Alineamientos tecnicos para ips ver pag 43"',
  `cod_servicio` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del servicio " Ver Alineamientos tecnicos para ips ver pag 44"',
  `nom_servicio` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del servicio " Ver Alineamientos tecnicos para ips ver pag 44"',
  `cantidad` int(5) NOT NULL COMMENT 'Cantidad" Ver Alineamientos tecnicos para ips ver pag 44"',
  `valor_unit_material` double(15,2) NOT NULL COMMENT 'Valor unitario del material e insumo " Ver Alineamientos tecnicos para ips ver pag 45"',
  `valor_total_material` double(15,2) NOT NULL COMMENT 'Valor total del material e insumo " Ver Alineamientos tecnicos para ips ver pag 45"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_otro_servicios`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de otros servicios AT';


DROP TABLE IF EXISTS `salud_archivo_otros_servicios_temp`;
CREATE TABLE `salud_archivo_otros_servicios_temp` (
  `id_otro_servicios` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `tipo_servicio` enum('1','2','3','4') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de servicio " Ver Alineamientos tecnicos para ips ver pag 43"',
  `cod_servicio` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del servicio " Ver Alineamientos tecnicos para ips ver pag 44"',
  `nom_servicio` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del servicio " Ver Alineamientos tecnicos para ips ver pag 44"',
  `cantidad` int(5) NOT NULL COMMENT 'Cantidad" Ver Alineamientos tecnicos para ips ver pag 44"',
  `valor_unit_material` double(15,2) NOT NULL COMMENT 'Valor unitario del material e insumo " Ver Alineamientos tecnicos para ips ver pag 45"',
  `valor_total_material` double(15,2) NOT NULL COMMENT 'Valor total del material e insumo " Ver Alineamientos tecnicos para ips ver pag 45"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_otro_servicios` (`id_otro_servicios`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de otros servicios AT';


DROP TABLE IF EXISTS `salud_archivo_procedimientos`;
CREATE TABLE `salud_archivo_procedimientos` (
  `id_procedimiento` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `fecha_procedimiento` date NOT NULL COMMENT 'Fecha del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_procedimiento` varchar(7) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `ambito_reali_procedimiento` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ámbito de realización del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `finalidad_procedimiento` enum('1','2','3','4','5') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Finalidad del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `personal_atiende` enum('1','2','3','4','5') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Personal que atiende " Ver Alineamientos tecnicos para ips ver pag 29"',
  `cod_diagn_princ_procedimiento` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 29"',
  `cod_diagn_relac_procedimiento` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado " Ver Alineamientos tecnicos para ips ver pag 30"',
  `complicaciones` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Complicación " Ver Alineamientos tecnicos para ips ver pag 30"',
  `realizacion_quirurgico` enum('1','2','3','4','5') COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Forma de realización del acto quirúrgico " Ver Alineamientos tecnicos para ips ver pag 30"',
  `valor_procedimiento` double(15,2) DEFAULT NULL COMMENT 'Valor del procedimiento " Ver Alineamientos tecnicos para ips ver pag 31"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_procedimiento`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de procedimientos AP';


DROP TABLE IF EXISTS `salud_archivo_procedimientos_temp`;
CREATE TABLE `salud_archivo_procedimientos_temp` (
  `id_procedimiento` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `fecha_procedimiento` date NOT NULL COMMENT 'Fecha del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_procedimiento` varchar(7) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `ambito_reali_procedimiento` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ámbito de realización del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `finalidad_procedimiento` enum('1','2','3','4','5') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Finalidad del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `personal_atiende` enum('1','2','3','4','5') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Personal que atiende " Ver Alineamientos tecnicos para ips ver pag 29"',
  `cod_diagn_princ_procedimiento` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 29"',
  `cod_diagn_relac_procedimiento` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado " Ver Alineamientos tecnicos para ips ver pag 30"',
  `complicaciones` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Complicación " Ver Alineamientos tecnicos para ips ver pag 30"',
  `realizacion_quirurgico` enum('1','2','3','4','5') COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Forma de realización del acto quirúrgico " Ver Alineamientos tecnicos para ips ver pag 30"',
  `valor_procedimiento` double(15,2) DEFAULT NULL COMMENT 'Valor del procedimiento " Ver Alineamientos tecnicos para ips ver pag 31"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_procedimiento` (`id_procedimiento`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de procedimientos AP';


DROP TABLE IF EXISTS `salud_archivo_urgencias`;
CREATE TABLE `salud_archivo_urgencias` (
  `id_urgencias` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `fecha_ingreso` date NOT NULL COMMENT 'Fecha de ingreso del usuario a observación " Ver Alineamientos tecnicos para ips ver pag 31"',
  `hora_ingreso` time NOT NULL COMMENT 'Hora de ingreso del usuario a observación " Ver Alineamientos tecnicos para ips ver pag 31"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 32" ',
  `causa_externa` enum('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Causa externa " Ver Alineamientos tecnicos para ips ver pag 32"',
  `diagnostico_salida` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico a la salida " Ver Alineamientos tecnicos para ips ver pag 32"',
  `diagn_relac1_salida` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 1 a la salida " Ver Alineamientos tecnicos para ips ver pag 33"',
  `diagn_relac2_salida` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 2 a la salida " Ver Alineamientos tecnicos para ips ver pag 33"',
  `diagn_relac3_salida` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 3 a la salida " Ver Alineamientos tecnicos para ips ver pag 33"',
  `destino_usuario` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Destino del usuario a la salida de observacion " Ver Alineamientos tecnicos para ips ver pag 29"',
  `estado_salida` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Estado a la salida " Ver Alineamientos tecnicos para ips ver pag 34"',
  `causa_muerte` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Causa básica de muerte en urgencias " Ver Alineamientos tecnicos para ips ver pag 34"',
  `fecha_salida` date NOT NULL COMMENT 'Fecha de la salida del usuario en observación " Ver Alineamientos tecnicos para ips ver pag 34"',
  `hora_salida` time NOT NULL COMMENT 'Hora de la salida del usuario en observación " Ver Alineamientos tecnicos para ips ver pag 31"',
  `nom_cargue` varchar(10) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_urgencias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de urgencias AU';


DROP TABLE IF EXISTS `salud_archivo_usuarios`;
CREATE TABLE `salud_archivo_usuarios` (
  `id_usuarios_salud` int(20) NOT NULL AUTO_INCREMENT,
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `cod_ident_adm_pb` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora de planes de beneficio (EPS) " Ver Alineamientos tecnicos para ips ver pag 16"',
  `tipo_usuario` enum('1','2','3','4','5','6','7','8') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de usuario " Ver Alineamientos tecnicos para ips ver pag 16"',
  `primer_ape_usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Primer apellido del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `segundo_ape_usuario` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Segundo apellido del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `primer_nom_usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Primer nombre del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `segundo_nom_usuario` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Segundo nombre del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `edad` int(3) NOT NULL COMMENT 'Edad " Ver Alineamientos tecnicos para ips ver pag 17 "',
  `unidad_medida_edad` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Unidad de medida de la edad " Ver Alineamientos tecnicos para ips ver pag 17"',
  `sexo` enum('M','F') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Sexo del usuario " Ver Alineamientos tecnicos para ips ver pag 18"',
  `cod_depa_residencial` int(2) NOT NULL COMMENT 'Código del departamento de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `cod_muni_residencial` int(3) NOT NULL COMMENT 'Código del municipio de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `zona_residencial` enum('U','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Zona de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_usuarios_salud`),
  KEY `num_ident_usuario` (`num_ident_usuario`),
  KEY `primer_ape_usuario` (`primer_ape_usuario`),
  KEY `segundo_ape_usuario` (`segundo_ape_usuario`),
  KEY `primer_nom_usuario` (`primer_nom_usuario`),
  KEY `segundo_nom_usuario` (`segundo_nom_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT COMMENT='Archivo de usuarios US';


DROP TABLE IF EXISTS `salud_archivo_usuarios_temp`;
CREATE TABLE `salud_archivo_usuarios_temp` (
  `id_usuarios_salud` varchar(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `cod_ident_adm_pb` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora de planes de beneficio (EPS) " Ver Alineamientos tecnicos para ips ver pag 16"',
  `tipo_usuario` enum('1','2','3','4','5','6','7','8') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de usuario " Ver Alineamientos tecnicos para ips ver pag 16"',
  `primer_ape_usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Primer apellido del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `segundo_ape_usuario` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Segundo apellido del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `primer_nom_usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Primer nombre del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `segundo_nom_usuario` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Segundo nombre del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `edad` int(3) NOT NULL COMMENT 'Edad " Ver Alineamientos tecnicos para ips ver pag 17 "',
  `unidad_medida_edad` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Unidad de medida de la edad " Ver Alineamientos tecnicos para ips ver pag 17"',
  `sexo` enum('M','F') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Sexo del usuario " Ver Alineamientos tecnicos para ips ver pag 18"',
  `cod_depa_residencial` int(2) NOT NULL COMMENT 'Código del departamento de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `cod_muni_residencial` int(3) NOT NULL COMMENT 'Código del municipio de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `zona_residencial` enum('U','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Zona de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_usuarios_salud` (`id_usuarios_salud`),
  KEY `num_ident_usuario` (`num_ident_usuario`),
  KEY `primer_ape_usuario` (`primer_ape_usuario`),
  KEY `segundo_ape_usuario` (`segundo_ape_usuario`),
  KEY `primer_nom_usuario` (`primer_nom_usuario`),
  KEY `segundo_nom_usuario` (`segundo_nom_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT COMMENT='Archivo de usuarios US';


DROP TABLE IF EXISTS `salud_bancos`;
CREATE TABLE `salud_bancos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `nit_banco` bigint(12) NOT NULL COMMENT 'NIT del banco',
  `banco_transaccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del banco donde entra la transaccion',
  `tipo_cuenta` enum('ahorros','corriente') COLLATE utf8_spanish_ci NOT NULL COMMENT 'tipo de cuenta',
  `num_cuenta_banco` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de cuenta en la cual entra la transaccion',
  `observacion` text COLLATE utf8_spanish_ci COMMENT 'observaciones de diagnostico ',
  `fecha_hora_registro` datetime DEFAULT NULL COMMENT 'fecha y hora del registro',
  `user` int(2) DEFAULT NULL COMMENT 'usuario que registra',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de banco';


DROP TABLE IF EXISTS `salud_cie10`;
CREATE TABLE `salud_cie10` (
  `ID` int(20) NOT NULL,
  `codigo_sistema` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SubCategoria de diagnostico ',
  `descripcion_cups` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Descrpcion de la Clasificacion internacional de Emfermedades ',
  `observacion` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'observaciones de CIE ',
  `fecha_hora_registro` datetime DEFAULT NULL COMMENT 'fecha y hora del registro',
  `user` int(2) DEFAULT NULL COMMENT 'usuario que registra',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de Clasificacion internacional de Emfermedades CIE10';


DROP TABLE IF EXISTS `salud_circular030`;
CREATE TABLE `salud_circular030` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TipoRegistro` int(1) NOT NULL,
  `Consecutivo` int(10) NOT NULL,
  `tipo_ident_erp` enum('NI','MU','DE','DI') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `num_ident_erp` bigint(12) NOT NULL COMMENT 'Número de identificación de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `razon_social` varchar(250) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `tipo_ident_ips` enum('NI') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación de ips " Ver circulra 030 anexo tecnico 2"',
  `num_ident_ips` bigint(12) NOT NULL COMMENT 'Número de identificación de ips " Ver circulra 030 anexo tecnico 2"',
  `tipo_cobro` enum('F','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de cobro " Ver circulra 030 anexo tecnico 2"',
  `pref_factura` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Prefijo factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `num_factura` int(20) NOT NULL COMMENT 'Número de la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `indic_act_fact` enum('I','A','E') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Prefijo factura o recobro "Ver circulra 030 anexo tecnico 2"',
  `valor_factura` double(15,2) NOT NULL COMMENT 'Valor de la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver circulra 030 anexo tecnico 2"',
  `fecha_radicado` date NOT NULL COMMENT 'Fecha de la radicacion de la factura " Ver circulra 030 anexo tecnico 2"',
  `fecha_devolucion` date DEFAULT NULL COMMENT 'Fecha de la devolucion de la factura " Ver circulra 030 anexo tecnico 2"',
  `valor_total_pagos` double(15,2) NOT NULL COMMENT 'Valor total de los pagos aplicados a la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `valor_glosa_acept` double(15,2) NOT NULL COMMENT 'Valor glosa aceptada de la factura o recobro segun la notificacion de la glosa de la ERP " Ver circulra 030 anexo tecnico 2"',
  `glosa_respondida` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Glosa fue respondida " Ver circulra 030 anexo tecnico 2"',
  `saldo_factura` double(15,2) NOT NULL COMMENT 'Saldo pendiente de la cancelacion de la factura o recobro debe ser igual al valor de la factura o recobro menos la glosa aceptada y menos los pagos aplicados "Ver circulra 030 anexo tecnico 2"',
  `cobro_juridico` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Factura o recobro se encuentra en cobro juridico" Ver circulra 030 anexo tecnico 2"',
  `etapa_proceso` enum('0','1','2','3','4','5','6','7','8') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Etapa en que se encuentra el proceso "Ver circulra 030 anexo tecnico 2"',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Formato Anexo tecnico 2 cir030';


DROP TABLE IF EXISTS `salud_circular030_2`;
CREATE TABLE `salud_circular030_2` (
  `Tipo_registro` int(1) NOT NULL COMMENT 'Tipo de registro " Ver circulra 030 anexo tecnico 2"',
  `id_circular030_2` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Consecutivo de registro debe comenzar en 1 " Ver circulra 030 anexo tecnico 2"',
  `tipo_ident_erp` enum('NI','MU','DE','DI') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `num_ident_erp` bigint(12) NOT NULL COMMENT 'Número de identificación de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `razon_social` varchar(250) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `tipo_ident_ips` enum('NI') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación de ips " Ver circulra 030 anexo tecnico 2"',
  `num_ident_ips` bigint(12) NOT NULL COMMENT 'Número de identificación de ips " Ver circulra 030 anexo tecnico 2"',
  `tipo_cobro` enum('F','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de cobro " Ver circulra 030 anexo tecnico 2"',
  `pref_factura` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Prefijo factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `num_factura` int(20) NOT NULL COMMENT 'Número de la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `indic_act_fact` enum('I','A','E') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Prefijo factura o recobro "Ver circulra 030 anexo tecnico 2"',
  `valor_factura` double(15,2) NOT NULL COMMENT 'Valor de la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver circulra 030 anexo tecnico 2"',
  `fecha_radicado` date NOT NULL COMMENT 'Fecha de la radicacion de la factura " Ver circulra 030 anexo tecnico 2"',
  `fecha_devolucion` date DEFAULT NULL COMMENT 'Fecha de la devolucion de la factura " Ver circulra 030 anexo tecnico 2"',
  `valor_total_pagos` double(15,2) NOT NULL COMMENT 'Valor total de los pagos aplicados a la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `valor_glosa_acept` double(15,2) NOT NULL COMMENT 'Valor glosa aceptada de la factura o recobro segun la notificacion de la glosa de la ERP " Ver circulra 030 anexo tecnico 2"',
  `glosa_respondida` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Glosa fue respondida " Ver circulra 030 anexo tecnico 2"',
  `saldo_factura` double(15,2) NOT NULL COMMENT 'Saldo pendiente de la cancelacion de la factura o recobro debe ser igual al valor de la factura o recobro menos la glosa aceptada y menos los pagos aplicados "Ver circulra 030 anexo tecnico 2"',
  `cobro_juridico` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Factura o recobro se encuentra en cobro juridico" Ver circulra 030 anexo tecnico 2"',
  `etapa_proceso` enum('0','1','2','3','4','5','6','7','8') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Etapa en que se encuentra el proceso "Ver circulra 030 anexo tecnico 2"',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_circular030_2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Formato Anexo tecnico 2 cir030';


DROP TABLE IF EXISTS `salud_circular030_3`;
CREATE TABLE `salud_circular030_3` (
  `Tipo_registro` int(1) NOT NULL COMMENT 'Tipo de registro " Ver circulra 030 anexo tecnico 2"',
  `id_circular030_3` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Consecutivo de registro debe comenzar en 1 " Ver circulra 030 anexo tecnico 2"',
  `tipo_ident_erp` enum('NI','MU','DE','DI') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `num_ident_erp` bigint(12) NOT NULL COMMENT 'Número de identificación de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `razon_social` varchar(250) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `tipo_ident_ips` enum('NI') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación de ips " Ver circulra 030 anexo tecnico 2"',
  `num_ident_ips` bigint(12) NOT NULL COMMENT 'Número de identificación de ips " Ver circulra 030 anexo tecnico 2"',
  `tipo_cobro` enum('F','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de cobro " Ver circulra 030 anexo tecnico 2"',
  `pref_factura` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Prefijo factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `num_factura` int(20) NOT NULL COMMENT 'Número de la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `indic_act_fact` enum('I','A','E') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Prefijo factura o recobro "Ver circulra 030 anexo tecnico 2"',
  `valor_factura` double(15,2) NOT NULL COMMENT 'Valor de la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver circulra 030 anexo tecnico 2"',
  `fecha_radicado` date NOT NULL COMMENT 'Fecha de la radicacion de la factura " Ver circulra 030 anexo tecnico 2"',
  `fecha_devolucion` date DEFAULT NULL COMMENT 'Fecha de la devolucion de la factura " Ver circulra 030 anexo tecnico 2"',
  `valor_total_pagos` double(15,2) NOT NULL COMMENT 'Valor total de los pagos aplicados a la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `valor_glosa_acept` double(15,2) NOT NULL COMMENT 'Valor glosa aceptada de la factura o recobro segun la notificacion de la glosa de la ERP " Ver circulra 030 anexo tecnico 2"',
  `glosa_respondida` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Glosa fue respondida " Ver circulra 030 anexo tecnico 2"',
  `saldo_factura` double(15,2) NOT NULL COMMENT 'Saldo pendiente de la cancelacion de la factura o recobro debe ser igual al valor de la factura o recobro menos la glosa aceptada y menos los pagos aplicados "Ver circulra 030 anexo tecnico 2"',
  `cobro_juridico` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Factura o recobro se encuentra en cobro juridico" Ver circulra 030 anexo tecnico 2"',
  `etapa_proceso` enum('0','1','2','3','4','5','6','7','8') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Etapa en que se encuentra el proceso "Ver circulra 030 anexo tecnico 2"',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_circular030_3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Formato Anexo tecnico 2 cir030';


DROP TABLE IF EXISTS `salud_circular030_4`;
CREATE TABLE `salud_circular030_4` (
  `Tipo_registro` int(1) NOT NULL COMMENT 'Tipo de registro " Ver circulra 030 anexo tecnico 2"',
  `id_circular030_4` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Consecutivo de registro debe comenzar en 1 " Ver circulra 030 anexo tecnico 2"',
  `tipo_ident_erp` enum('NI','MU','DE','DI') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `num_ident_erp` bigint(12) NOT NULL COMMENT 'Número de identificación de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `razon_social` varchar(250) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `tipo_ident_ips` enum('NI') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación de ips " Ver circulra 030 anexo tecnico 2"',
  `num_ident_ips` bigint(12) NOT NULL COMMENT 'Número de identificación de ips " Ver circulra 030 anexo tecnico 2"',
  `tipo_cobro` enum('F','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de cobro " Ver circulra 030 anexo tecnico 2"',
  `pref_factura` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Prefijo factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `num_factura` int(20) NOT NULL COMMENT 'Número de la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `indic_act_fact` enum('I','A','E') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Prefijo factura o recobro "Ver circulra 030 anexo tecnico 2"',
  `valor_factura` double(15,2) NOT NULL COMMENT 'Valor de la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver circulra 030 anexo tecnico 2"',
  `fecha_radicado` date NOT NULL COMMENT 'Fecha de la radicacion de la factura " Ver circulra 030 anexo tecnico 2"',
  `fecha_devolucion` date DEFAULT NULL COMMENT 'Fecha de la devolucion de la factura " Ver circulra 030 anexo tecnico 2"',
  `valor_total_pagos` double(15,2) NOT NULL COMMENT 'Valor total de los pagos aplicados a la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `valor_glosa_acept` double(15,2) NOT NULL COMMENT 'Valor glosa aceptada de la factura o recobro segun la notificacion de la glosa de la ERP " Ver circulra 030 anexo tecnico 2"',
  `glosa_respondida` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Glosa fue respondida " Ver circulra 030 anexo tecnico 2"',
  `saldo_factura` double(15,2) NOT NULL COMMENT 'Saldo pendiente de la cancelacion de la factura o recobro debe ser igual al valor de la factura o recobro menos la glosa aceptada y menos los pagos aplicados "Ver circulra 030 anexo tecnico 2"',
  `cobro_juridico` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Factura o recobro se encuentra en cobro juridico" Ver circulra 030 anexo tecnico 2"',
  `etapa_proceso` enum('0','1','2','3','4','5','6','7','8') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Etapa en que se encuentra el proceso "Ver circulra 030 anexo tecnico 2"',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_circular030_4`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Formato Anexo tecnico 2 cir030';


DROP TABLE IF EXISTS `salud_circular_030_control`;
CREATE TABLE `salud_circular_030_control` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TipoRegistro` int(1) NOT NULL,
  `TipoIdentificacion` varchar(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'NI',
  `NumIdentificacion` bigint(20) NOT NULL,
  `RazonSocial` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `FechaInicial` date NOT NULL,
  `FechaFinal` date NOT NULL,
  `NumRegistros` bigint(10) NOT NULL,
  `idUser` int(11) NOT NULL,
  `FechaGeneracion` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_cobros_prejuridicos`;
CREATE TABLE `salud_cobros_prejuridicos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TipoCobro` enum('1','2','3','4') COLLATE latin1_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Soporte` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Fecha` (`Fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_cobros_prejuridicos_relaciones`;
CREATE TABLE `salud_cobros_prejuridicos_relaciones` (
  `idCobroPrejuridico` int(11) NOT NULL,
  `num_factura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  KEY `idCobroPrejuridico` (`idCobroPrejuridico`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_cups`;
CREATE TABLE `salud_cups` (
  `ID` int(20) NOT NULL,
  `grupo` varchar(2) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Grupo de diagnostico ',
  `subgrupo` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SubGrupo de diagnostico ',
  `categoria` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Categoria de diagnostico ',
  `subcategoria` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SubCategoria de diagnostico ',
  `codigo_ley` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SubCategoria de diagnostico ',
  `codigo_sistema` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SubCategoria de diagnostico ',
  `descripcion_cups` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Descrpcion del C.U.P.S ',
  `observacion` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'observaciones de diagnostico ',
  `fecha_hora_registro` datetime DEFAULT NULL COMMENT 'fecha y hora del registro',
  `user` int(2) DEFAULT NULL COMMENT 'usuario que registra',
  PRIMARY KEY (`ID`),
  KEY `codigo_sistema` (`codigo_sistema`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de cups';


DROP TABLE IF EXISTS `salud_dias_habiles`;
CREATE TABLE `salud_dias_habiles` (
  `fecha_dia` date NOT NULL COMMENT 'fecha del dia',
  `dia` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo') COLLATE utf8_spanish_ci NOT NULL COMMENT 'dia de la semana',
  `tipo_dia` enum('festivo','dominical','sabatino','normal','') COLLATE utf8_spanish_ci NOT NULL COMMENT 'tipo de dia',
  `estado_dia` enum('habil','no habil','','') COLLATE utf8_spanish_ci NOT NULL COMMENT 'estado de dia es habil o no lo es'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla para controlar los días hábiles';


DROP TABLE IF EXISTS `salud_eps`;
CREATE TABLE `salud_eps` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `cod_pagador_min` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Codigo del pagador ante el ministerio de salud ',
  `nit` bigint(20) NOT NULL,
  `TipoIdentificacion` enum('MU','DE','DI','NI') COLLATE utf8_spanish_ci NOT NULL,
  `sigla_nombre` varchar(120) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre corto del pagador del servicio salud',
  `nombre_completo` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre completo del pagador del servicio',
  `tipo_regimen` enum('CONTRIBUTIVO','SUBSIDIADO','','') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de regimen',
  `dias_convenio` int(11) NOT NULL,
  `Nombre_gerente` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del gerente del pagador',
  `saldo_inicial` double NOT NULL,
  `fecha_saldo_inicial` date NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `cod_pagador_min` (`cod_pagador_min`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='directorio de empresas promotoras de salud (EPS)';


DROP TABLE IF EXISTS `salud_facturas_radicacion_numero`;
CREATE TABLE `salud_facturas_radicacion_numero` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFactura` bigint(20) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_pagos_temporal`;
CREATE TABLE `salud_pagos_temporal` (
  `id_temp_rips_generados` varchar(1) COLLATE latin1_spanish_ci NOT NULL,
  `Proceso` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `CodigoEPS` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `NombreEPS` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `FormaContratacion` enum('Evento','Capitacion') COLLATE latin1_spanish_ci NOT NULL,
  `Departamento` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Municipio` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `FechaFactura` date NOT NULL,
  `PrefijoFactura` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `NumeroFactura` bigint(20) NOT NULL,
  `ValorGiro` double NOT NULL,
  `FechaPago` date NOT NULL,
  `NumeroGiro` bigint(20) NOT NULL,
  `nom_cargue` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `Soporte` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `numero_factura` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_procesos_gerenciales`;
CREATE TABLE `salud_procesos_gerenciales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `EPS` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `NombreProceso` text COLLATE latin1_spanish_ci NOT NULL,
  `Concepto` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_procesos_gerenciales_archivos`;
CREATE TABLE `salud_procesos_gerenciales_archivos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProceso` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `Soporte` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_procesos_gerenciales_conceptos`;
CREATE TABLE `salud_procesos_gerenciales_conceptos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Concepto` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_registro_glosas`;
CREATE TABLE `salud_registro_glosas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `PrefijoArchivo` enum('AC','AM','AP','AT','AF') COLLATE latin1_spanish_ci NOT NULL COMMENT 'AC, AM, AP, AT,AF',
  `idArchivo` bigint(20) NOT NULL COMMENT 'id de la tabla',
  `TipoGlosa` enum('1','2','3','4','5') COLLATE latin1_spanish_ci NOT NULL COMMENT '1 inicial, 2 levantada, 3 aceptada, 4 X Conciliar,5 Devuelta',
  `CodigoGlosa` int(11) NOT NULL COMMENT 'Codigo de la glosa',
  `FechaReporte` date NOT NULL COMMENT 'Fecha de reporte o gestion',
  `GlosaEPS` double NOT NULL COMMENT 'Valor que La EPS dice que hay Glosa',
  `GlosaAceptada` double NOT NULL COMMENT 'Valor que la IPS esta dispuesta a perder',
  `Soporte` varchar(100) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Documento que soporta la decision o gestion',
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL COMMENT 'Lo que el gestor gestionó',
  `cod_enti_administradora` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_factura` date NOT NULL,
  `idUser` int(11) NOT NULL COMMENT 'usuario que ingresó el registro',
  `TablaOrigen` varchar(45) COLLATE latin1_spanish_ci NOT NULL COMMENT 'tabla donde esta el archiv',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_rips_diferencias`;
CREATE TABLE `salud_rips_diferencias` (
  `id_rips_diferencias` int(20) NOT NULL,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_pagado` double(15,2) DEFAULT NULL COMMENT 'Valor que la eps pago',
  `valor_diferencia` double(15,2) DEFAULT NULL COMMENT 'Valor de la diferencia del valor neto a pagar y el valor pagado',
  `fecha_act_pago` date DEFAULT NULL COMMENT 'Fecha de pago del ultimo abono',
  `num_comp_pago` int(15) DEFAULT NULL COMMENT 'Numero de comprobante del ultimo abono',
  `eps_radicacion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Eps en la que se radico la factura',
  `dias_pactados` int(2) DEFAULT NULL COMMENT 'Dias que se pactaron para el pago de la factura con eps',
  `fecha_radicado` date DEFAULT NULL COMMENT 'Fecha de la radicacion de la factura',
  `numero_radicado` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Numero con que se radico la factura',
  `fecha_ult_validacion` datetime DEFAULT NULL COMMENT 'Fecha de ultima validacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_rips_diferencias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de diferencias de validacion';


DROP TABLE IF EXISTS `salud_rips_facturas_generadas_temp`;
CREATE TABLE `salud_rips_facturas_generadas_temp` (
  `id_temp_rips_generados` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_temp_rips_generados` (`id_temp_rips_generados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo temporal de rips generados';


DROP TABLE IF EXISTS `salud_rips_nopagados`;
CREATE TABLE `salud_rips_nopagados` (
  `id_rips_nopagados` int(20) NOT NULL,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `nom_cargue` varchar(8) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre con el que se hizo el cargue al sistema de cartera',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha Y Hora que se hizo el cargue',
  `eps_radicacion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Eps en la que se radico la factura',
  `dias_pactados` int(2) DEFAULT NULL COMMENT 'Dias que se pactaron para el pago de la factura con eps',
  `fecha_radicado` date DEFAULT NULL COMMENT 'Fecha de la radicacion de la factura',
  `numero_radicado` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Numero con que se radico la factura',
  `fecha_ult_validacion` datetime DEFAULT NULL COMMENT 'Fecha de ultima validacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_rips_nopagados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='archivos de rips no pagados';


DROP TABLE IF EXISTS `salud_rips_pagos_validados`;
CREATE TABLE `salud_rips_pagos_validados` (
  `id_rips_pagos_validados` int(20) NOT NULL,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_pagado` double(15,2) DEFAULT NULL COMMENT 'Valor que la eps pago',
  `valor_diferencia` double(15,2) DEFAULT NULL COMMENT 'Valor de la diferencia del valor neto a pagar y el valor pagado',
  `fecha_pago` date DEFAULT NULL COMMENT 'Fecha de pago del ultimo abono',
  `num_comprobante` int(15) DEFAULT NULL COMMENT 'Numero de comprobante del ultimo abono',
  `eps_radicacion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Eps en la que se radico la factura',
  `dias_pactados` int(2) DEFAULT NULL COMMENT 'Dias que se pactaron para el pago de la factura con eps',
  `fecha_radicado` date DEFAULT NULL COMMENT 'Fecha de la radicacion de la factura',
  `numero_radicado` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Numero con que se radico la factura',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_rips_pagos_validados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de pagos validados';


DROP TABLE IF EXISTS `salud_rips_vencidos`;
CREATE TABLE `salud_rips_vencidos` (
  `id_rips_vencidos` int(20) NOT NULL,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `nom_cargue` varchar(8) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre con el que se hizo el cargue al sistema de cartera',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha Y Hora que se hizo el cargue',
  `eps_radicacion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Eps en la que se radico la factura',
  `dias_pactados` int(2) DEFAULT NULL COMMENT 'Dias que se pactaron para el pago de la factura con eps',
  `fecha_radicado` date DEFAULT NULL COMMENT 'Fecha de la radicacion de la factura',
  `numero_radicado` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Numero con que se radico la factura',
  `fecha_vencimiento` date NOT NULL COMMENT 'Fecha de vencimiento de la facrura ',
  `fecha_ult_validacion` datetime DEFAULT NULL COMMENT 'Fecha de ultima validacion',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_rips_vencidos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='archivos de rips vencidos';


DROP TABLE IF EXISTS `salud_tesoreria`;
CREATE TABLE `salud_tesoreria` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad que paga',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad que paga',
  `fecha_transaccion` date NOT NULL COMMENT 'fecha entra el dinero al banco',
  `num_transaccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de la transaccion con la cual entra al banco',
  `banco_transaccion` varchar(10) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del banco donde entra la transaccion',
  `num_cuenta_banco` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de cuenta en la cual entra la transaccion',
  `valor_transaccion` double(15,2) NOT NULL COMMENT 'Valor de transaccion ',
  `Soporte` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Soporte que argumenta  o justifica el pago',
  `observacion` text COLLATE utf8_spanish_ci COMMENT 'observaciones de diagnostico ',
  `fecha_hora_registro` datetime DEFAULT NULL COMMENT 'fecha y hora del registro',
  `idUser` int(11) DEFAULT NULL COMMENT 'usuario que registra',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de tesoreria';


DROP TABLE IF EXISTS `salud_tipo_glosas`;
CREATE TABLE `salud_tipo_glosas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoGlosa` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_upload_control`;
CREATE TABLE `salud_upload_control` (
  `id_upload_control` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_cargue` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `Analizado` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_upload_control`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `separados`;
CREATE TABLE `separados` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idCliente` int(11) NOT NULL,
  `Total` int(11) NOT NULL,
  `Saldo` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuarios` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `separados_abonos`;
CREATE TABLE `separados_abonos` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `idSeparado` bigint(20) unsigned NOT NULL,
  `Valor` double NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idUsuarios` int(11) NOT NULL,
  `idComprobanteIngreso` bigint(20) NOT NULL,
  `idCierre` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `separados_items`;
CREATE TABLE `separados_items` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `servicios`;
CREATE TABLE `servicios` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `servidores`;
CREATE TABLE `servidores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `DataBase` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `sistemas`;
CREATE TABLE `sistemas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` text COLLATE utf8_spanish2_ci NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `sistemas_relaciones`;
CREATE TABLE `sistemas_relaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TablaOrigen` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `ValorUnitario` double NOT NULL,
  `idSistema` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `subcuentas`;
CREATE TABLE `subcuentas` (
  `PUC` int(11) NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cuentas_idPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `subcuentas_equivalencias_niif`;
CREATE TABLE `subcuentas_equivalencias_niif` (
  `CuentaNIIF` int(11) NOT NULL,
  `NombreCuentaNIIF` int(11) NOT NULL,
  `Equivale_A` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CuentaNIIF`),
  UNIQUE KEY `Equivale_A` (`Equivale_A`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `tablas_ventas`;
CREATE TABLE `tablas_ventas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreTabla` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `idTabla` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `TipoVenta` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `IVAIncluido` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUCDefecto` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `tarjetas_forma_pago`;
CREATE TABLE `tarjetas_forma_pago` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `PorcentajeComision` float NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `tiposretenciones`;
CREATE TABLE `tiposretenciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPasivo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NombreCuentaPasivo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaActivo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `NombreCuentaActivo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `titulos_abonos`;
CREATE TABLE `titulos_abonos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `titulos_asignaciones`;
CREATE TABLE `titulos_asignaciones` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `titulos_comisiones`;
CREATE TABLE `titulos_comisiones` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `titulos_cuentasxcobrar`;
CREATE TABLE `titulos_cuentasxcobrar` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `titulos_devoluciones`;
CREATE TABLE `titulos_devoluciones` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `titulos_listados_promocion_1`;
CREATE TABLE `titulos_listados_promocion_1` (
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


DROP TABLE IF EXISTS `titulos_listados_promocion_6`;
CREATE TABLE `titulos_listados_promocion_6` (
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


DROP TABLE IF EXISTS `titulos_listados_promocion_7`;
CREATE TABLE `titulos_listados_promocion_7` (
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


DROP TABLE IF EXISTS `titulos_promociones`;
CREATE TABLE `titulos_promociones` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `titulos_traslados`;
CREATE TABLE `titulos_traslados` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `titulos_ventas`;
CREATE TABLE `titulos_ventas` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `traslados_estados`;
CREATE TABLE `traslados_estados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Estado` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `traslados_items`;
CREATE TABLE `traslados_items` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `traslados_mercancia`;
CREATE TABLE `traslados_mercancia` (
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


DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `usuarios_ip`;
CREATE TABLE `usuarios_ip` (
  `Direccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Direccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `usuarios_keys`;
CREATE TABLE `usuarios_keys` (
  `KeyUsuario` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`KeyUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `usuarios_tipo`;
CREATE TABLE `usuarios_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas` (
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


DELIMITER ;;

CREATE TRIGGER `UpdateProductos` AFTER INSERT ON `ventas` FOR EACH ROW
BEGIN


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

END;;

DELIMITER ;

DROP TABLE IF EXISTS `ventas_devoluciones`;
CREATE TABLE `ventas_devoluciones` (
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


DROP TABLE IF EXISTS `ventas_nota_credito`;
CREATE TABLE `ventas_nota_credito` (
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


DROP TABLE IF EXISTS `ventas_separados`;
CREATE TABLE `ventas_separados` (
  `idVentas_Separados` int(11) NOT NULL AUTO_INCREMENT,
  `Facturas_idFacturas` int(11) NOT NULL,
  `Retirado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `FechaRetiro` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsuariosEntrega` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVentas_Separados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `vestasactivas`;
CREATE TABLE `vestasactivas` (
  `idVestasActivas` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Usuario_idUsuario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Clientes_idClientes` int(11) NOT NULL DEFAULT '0',
  `SaldoFavor` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVestasActivas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP VIEW IF EXISTS `vista_abonos`;
CREATE TABLE `vista_abonos` (`Tabla` varchar(16), `TipoAbono` varchar(45), `Fecha` date, `Valor` double, `idUsuario` int(11), `idCierre` bigint(20));


DROP VIEW IF EXISTS `vista_compras_productos`;
CREATE TABLE `vista_compras_productos` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `idProducto` bigint(20), `Referencia` varchar(200), `Producto` varchar(70), `PrecioVenta` double, `Cantidad` double, `CostoUnitario` double, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_compras_productos_devueltos`;
CREATE TABLE `vista_compras_productos_devueltos` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `idProducto` bigint(20), `Referencia` varchar(200), `Producto` varchar(70), `PrecioVenta` double, `Cantidad` double, `CostoUnitario` double, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_compras_servicios`;
CREATE TABLE `vista_compras_servicios` (`ID` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `RazonSocial` varchar(300), `NIT` bigint(20), `Cuenta` bigint(20), `NombreCuenta` varchar(100), `Concepto_Servicio` text, `Subtotal` double, `Impuestos` double, `Total` double, `Tipo_Impuesto` double, `Concepto` text, `Observaciones` text, `TipoCompra` varchar(2), `Soporte` varchar(150), `idUsuario` bigint(20), `idCentroCostos` int(11), `idSucursal` int(11), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_entregas`;
CREATE TABLE `vista_entregas` (`Tabla` varchar(16), `Tipo` varchar(45), `Fecha` varchar(45), `idUsuario` int(11), `Total` varchar(45));


DROP VIEW IF EXISTS `vista_factura_compra_totales`;
CREATE TABLE `vista_factura_compra_totales` (`idFacturaCompra` bigint(20), `Fecha` date, `NumeroFactura` varchar(100), `Tercero` bigint(20), `RazonSocial` varchar(300), `Subtotal` double, `Impuestos` double, `TotalRetenciones` double, `Total` double, `Concepto` text, `SubtotalServicios` double, `ImpuestosServicios` double, `TotalServicios` double, `SubtotalDevoluciones` double, `ImpuestosDevueltos` double, `TotalDevolucion` double, `Usuario` bigint(20));


DROP VIEW IF EXISTS `vista_inventario_separados`;
CREATE TABLE `vista_inventario_separados` (`ID` bigint(20) unsigned, `Referencia` varchar(45), `Nombre` text, `Cantidad` decimal(32,0), `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11));


DROP VIEW IF EXISTS `vista_kardex`;
CREATE TABLE `vista_kardex` (`ID` bigint(20), `Fecha` varchar(45), `Movimiento` varchar(45), `Detalle` varchar(400), `idDocumento` varchar(100), `Cantidad` varchar(45), `ValorUnitario` varchar(45), `ValorTotal` varchar(45), `ProductosVenta_idProductosVenta` bigint(20), `Referencia` varchar(200), `Nombre` varchar(70), `Existencias` double, `CostoUnitario` double, `CostoTotal` double, `IVA` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_ori_facturas`;
CREATE TABLE `vista_ori_facturas` (`Fecha` date, `idFactura` varchar(45), `Referencia` varchar(200), `Nombre` varchar(500), `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `ValorUnitarioItem` int(11), `Cantidad` varchar(45), `Dias` varchar(45), `SubtotalItem` varchar(45), `IVAItem` varchar(45), `ValorOtrosImpuestos` double, `TotalItem` double, `PorcentajeIVA` varchar(10), `idOtrosImpuestos` int(11), `idPorcentajeIVA` int(11), `PrecioCostoUnitario` varchar(45), `SubtotalCosto` varchar(45), `TipoItem` varchar(10), `CuentaPUC` int(11), `GeneradoDesde` varchar(100), `NumeroIdentificador` varchar(45), `idUsuarios` int(11), `idCierre` bigint(20), `idResolucion` int(11), `TipoFactura` varchar(10), `Prefijo` varchar(45), `NumeroFactura` int(16), `Hora` varchar(20), `FormaPago` varchar(20), `CentroCosto` int(11), `idSucursal` int(11), `EmpresaPro_idEmpresaPro` int(11), `Clientes_idClientes` int(11), `ObservacionesFact` text);


DROP VIEW IF EXISTS `vista_preventa`;
CREATE TABLE `vista_preventa` (`VestasActivas_idVestasActivas` int(11), `TablaItems` varchar(14), `Referencia` varchar(200), `Nombre` varchar(70), `Departamento` varchar(45), `SubGrupo1` varchar(45), `SubGrupo2` varchar(45), `SubGrupo3` varchar(45), `SubGrupo4` varchar(45), `SubGrupo5` varchar(45), `ValorUnitarioItem` double, `Cantidad` double, `Dias` varchar(1), `SubtotalItem` double, `IVAItem` double, `ValorOtrosImpuestos` double, `TotalItem` double, `PorcentajeIVA` varchar(24), `PrecioCostoUnitario` double, `SubtotalCosto` double, `TipoItem` varchar(2), `CuentaPUC` varchar(45), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_resumen_facturacion`;
CREATE TABLE `vista_resumen_facturacion` (`ID` bigint(20) unsigned, `FechaInicial` date, `FechaFinal` date, `Referencia` varchar(200), `Nombre` text, `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `Cantidad` double, `TotalVenta` double(19,2), `Costo` double(19,2));


DROP VIEW IF EXISTS `vista_resumen_ventas_departamentos`;
CREATE TABLE `vista_resumen_ventas_departamentos` (`FechaFactura` date, `Departamento` int(11), `SubGrupo1` int(11), `SubGrupo2` int(11), `SubGrupo3` int(11), `SubGrupo4` int(11), `SubGrupo5` int(11), `Total` double);


DROP VIEW IF EXISTS `vista_salud_facturas_diferencias`;
CREATE TABLE `vista_salud_facturas_diferencias` (`id_factura_generada` int(20), `cod_prest_servicio` bigint(12), `razon_social` varchar(60), `num_factura` varchar(20), `fecha_factura` date, `cod_enti_administradora` varchar(6), `nom_enti_administradora` varchar(30), `valor_neto_pagar` double(15,2), `id_factura_pagada` bigint(20), `fecha_pago_factura` date, `valor_pagado` double(15,2), `num_pago` int(10), `DiferenciaEnPago` double(19,2), `tipo_negociacion` enum('evento','capita'), `dias_pactados` int(2), `fecha_radicado` date, `numero_radicado` varchar(20), `Soporte` varchar(200));


DROP VIEW IF EXISTS `vista_salud_facturas_no_pagas`;
CREATE TABLE `vista_salud_facturas_no_pagas` (`id_factura_generada` int(20), `DiasMora` bigint(12), `cod_prest_servicio` bigint(12), `razon_social` varchar(60), `num_factura` varchar(20), `fecha_factura` date, `fecha_radicado` date, `numero_radicado` varchar(20), `cod_enti_administradora` varchar(6), `nom_enti_administradora` varchar(30), `valor_neto_pagar` double(15,2), `tipo_negociacion` enum('evento','capita'), `dias_pactados` int(2), `Soporte` varchar(200), `EstadoCobro` varchar(20));


DROP VIEW IF EXISTS `vista_salud_facturas_pagas`;
CREATE TABLE `vista_salud_facturas_pagas` (`id_factura_generada` int(20), `cod_prest_servicio` bigint(12), `razon_social` varchar(60), `num_factura` varchar(20), `fecha_factura` date, `cod_enti_administradora` varchar(6), `nom_enti_administradora` varchar(30), `valor_neto_pagar` double(15,2), `id_factura_pagada` bigint(20), `fecha_pago_factura` date, `valor_pagado` double(15,2), `num_pago` int(10), `tipo_negociacion` enum('evento','capita'), `dias_pactados` int(2), `fecha_radicado` date, `numero_radicado` varchar(20), `Soporte` varchar(200));


DROP VIEW IF EXISTS `vista_salud_facturas_prejuridicos`;
CREATE TABLE `vista_salud_facturas_prejuridicos` (`ID` int(20), `idCobroPrejuridico` int(11), `num_factura` varchar(20), `cod_prest_servicio` bigint(12), `razon_social` varchar(60), `num_ident_prest_servicio` bigint(20), `fecha_factura` date, `cod_enti_administradora` varchar(6), `nom_enti_administradora` varchar(30), `valor_neto_pagar` double(15,2), `tipo_negociacion` enum('evento','capita'), `fecha_radicado` date, `numero_radicado` varchar(20), `SoporteRadicado` varchar(200), `SoporteCobro` varchar(50), `EstadoFactura` varchar(50), `EstadoCobro` varchar(20));


DROP VIEW IF EXISTS `vista_salud_pagas_no_generadas`;
CREATE TABLE `vista_salud_pagas_no_generadas` (`id_pagados` bigint(20), `num_factura` varchar(20), `fecha_pago_factura` date, `num_pago` int(10), `valor_bruto_pagar` double(15,2), `valor_descuento` double(15,2), `valor_iva` double(15,2), `valor_retefuente` double(15,2), `valor_reteiva` double(15,2), `valor_reteica` double(15,2), `valor_otrasretenciones` double(15,2), `valor_cruces` double(15,2), `valor_anticipos` double(15,2), `valor_pagado` double(15,2), `nom_cargue` varchar(20), `fecha_cargue` datetime, `Estado` varchar(10), `idUser` int(11), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_salud_procesos_gerenciales`;
CREATE TABLE `vista_salud_procesos_gerenciales` (`ID` bigint(20), `idProceso` int(11), `Fecha` date, `EPS` varchar(50), `NombreProceso` text, `Concepto` varchar(45), `Observaciones` text, `Soporte` varchar(200));


DROP VIEW IF EXISTS `vista_sistemas`;
CREATE TABLE `vista_sistemas` (`ID` bigint(20), `idSistema` bigint(20), `Nombre_Sistema` text, `Observaciones` text, `TablaOrigen` varchar(90), `CodigoInterno` bigint(20), `Nombre` text, `Cantidad` double, `PrecioUnitario` double, `PrecioVenta` double(17,0), `CostoUnitario` double(17,0), `Costo_Total_Item` double(17,0), `IVA` varchar(10), `Departamento` varchar(45), `Sub1` varchar(45), `Sub2` varchar(45), `Sub3` varchar(45), `Sub4` varchar(45), `Sub5` varchar(45), `Updated` timestamp, `Sync` datetime);


DROP VIEW IF EXISTS `vista_titulos_abonos`;
CREATE TABLE `vista_titulos_abonos` (`ID` bigint(20), `Fecha` date, `Hora` time, `Monto` double, `idVenta` bigint(20), `Promocion` int(11), `Mayor` int(11), `Concepto` text, `idColaborador` bigint(20), `NombreColaborador` varchar(90), `Estado` varchar(45), `idComprobanteIngreso` bigint(20), `Mayor2` int(11), `Adicional` int(11), `Valor` bigint(20), `TotalAbonos` bigint(20), `Saldo` bigint(20), `idCliente` bigint(20), `NombreCliente` varchar(90));


DROP VIEW IF EXISTS `vista_titulos_comisiones`;
CREATE TABLE `vista_titulos_comisiones` (`ID` bigint(20), `Fecha` date, `Hora` time, `Monto` double, `idVenta` bigint(20), `Promocion` int(11), `Mayor` int(11), `Concepto` text, `idColaborador` bigint(20), `NombreColaborador` varchar(90), `idUsuario` int(11), `idEgreso` bigint(20), `Mayor2` int(11), `Adicional` int(11), `Valor` bigint(20), `TotalAbonos` bigint(20), `Saldo` bigint(20), `idCliente` bigint(20), `NombreCliente` varchar(90));


DROP VIEW IF EXISTS `vista_titulos_devueltos`;
CREATE TABLE `vista_titulos_devueltos` (`ID` bigint(20), `Fecha` date, `idVenta` bigint(20), `Promocion` int(11), `Mayor` bigint(20), `Concepto` text, `idColaborador` bigint(20), `NombreColaborador` varchar(90), `idUsuario` int(11), `Mayor2` int(11), `Adicional` int(11), `Valor` bigint(20), `TotalAbonos` bigint(20), `Saldo` bigint(20), `idCliente` bigint(20), `NombreCliente` varchar(90));


DROP TABLE IF EXISTS `vista_abonos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_abonos` AS select 'abonos_factura' AS `Tabla`,`fa`.`FormaPago` AS `TipoAbono`,`fa`.`Fecha` AS `Fecha`,`fa`.`Valor` AS `Valor`,`fa`.`Usuarios_idUsuarios` AS `idUsuario`,`fa`.`idCierre` AS `idCierre` from `facturas_abonos` `fa` union select 'abonos_separados' AS `Tabla`,'Separados' AS `TipoAbono`,`fa`.`Fecha` AS `Fecha`,`fa`.`Valor` AS `Valor`,`fa`.`idUsuarios` AS `idUsuario`,`fa`.`idCierre` AS `idCierre` from `separados_abonos` `fa`;

DROP TABLE IF EXISTS `vista_compras_productos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_compras_productos` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fi`.`idProducto` AS `idProducto`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Producto`,`pv`.`PrecioVenta` AS `PrecioVenta`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`CostoUnitarioCompra` AS `CostoUnitario`,`fi`.`SubtotalCompra` AS `Subtotal`,`fi`.`ImpuestoCompra` AS `Impuestos`,`fi`.`TotalCompra` AS `Total`,`fi`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from (((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_items` `fi` on((`fi`.`idFacturaCompra` = `c`.`ID`))) join `productosventa` `pv` on((`fi`.`idProducto` = `pv`.`idProductosVenta`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_compras_productos_devueltos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_compras_productos_devueltos` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fi`.`idProducto` AS `idProducto`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Producto`,`pv`.`PrecioVenta` AS `PrecioVenta`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`CostoUnitarioCompra` AS `CostoUnitario`,`fi`.`SubtotalCompra` AS `Subtotal`,`fi`.`ImpuestoCompra` AS `Impuestos`,`fi`.`TotalCompra` AS `Total`,`fi`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from (((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_items_devoluciones` `fi` on((`fi`.`idFacturaCompra` = `c`.`ID`))) join `productosventa` `pv` on((`fi`.`idProducto` = `pv`.`idProductosVenta`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_compras_servicios`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_compras_servicios` AS select `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,`fs`.`CuentaPUC_Servicio` AS `Cuenta`,`fs`.`Nombre_Cuenta` AS `NombreCuenta`,`fs`.`Concepto_Servicio` AS `Concepto_Servicio`,`fs`.`Subtotal_Servicio` AS `Subtotal`,`fs`.`Impuesto_Servicio` AS `Impuestos`,`fs`.`Total_Servicio` AS `Total`,`fs`.`Tipo_Impuesto` AS `Tipo_Impuesto`,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,`c`.`idSucursal` AS `idSucursal`,`c`.`Updated` AS `Updated`,`c`.`Sync` AS `Sync` from ((`factura_compra` `c` join `proveedores` `t` on((`c`.`Tercero` = `t`.`Num_Identificacion`))) join `factura_compra_servicios` `fs` on((`fs`.`idFacturaCompra` = `c`.`ID`))) where (`c`.`Estado` = 'CERRADA');

DROP TABLE IF EXISTS `vista_entregas`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_entregas` AS select 'ventas' AS `Tabla`,`f`.`FormaPago` AS `Tipo`,`fa`.`FechaFactura` AS `Fecha`,`fa`.`idUsuarios` AS `idUsuario`,`fa`.`TotalItem` AS `Total` from (`ori_facturas_items` `fa` join `ori_facturas` `f` on((`f`.`idFacturas` = `fa`.`idFactura`))) where (`f`.`FormaPago` = 'Contado') union select 'bolsas' AS `Tabla`,`f`.`FormaPago` AS `Tipo`,`fa`.`FechaFactura` AS `Fecha`,`fa`.`idUsuarios` AS `idUsuario`,`fa`.`ValorOtrosImpuestos` AS `Total` from (`ori_facturas_items` `fa` join `ori_facturas` `f` on((`f`.`idFacturas` = `fa`.`idFactura`))) where (`f`.`FormaPago` = 'Contado') union select 'abonos_creditos' AS `Tabla`,`fa`.`FormaPago` AS `Tipo`,`fa`.`Fecha` AS `Fecha`,`fa`.`Usuarios_idUsuarios` AS `idUsuario`,`fa`.`Valor` AS `Total` from `facturas_abonos` `fa` union select 'abonos_separados' AS `Tabla`,'AbonoSeparado' AS `Tipo`,`fa`.`Fecha` AS `Fecha`,`fa`.`idUsuarios` AS `idUsuario`,`fa`.`Valor` AS `Total` from `separados_abonos` `fa` union select 'egresos' AS `Tabla`,'Egresos' AS `Tipo`,`fa`.`Fecha` AS `Fecha`,`fa`.`Usuario_idUsuario` AS `idUsuario`,`fa`.`Valor` AS `Total` from `egresos` `fa` where (`fa`.`TipoEgreso` = 'VentasRapidas');

DROP TABLE IF EXISTS `vista_factura_compra_totales`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_factura_compra_totales` AS select `fci`.`idFacturaCompra` AS `idFacturaCompra`,(select `factura_compra`.`Fecha` from `factura_compra` where (`factura_compra`.`ID` = `fci`.`idFacturaCompra`)) AS `Fecha`,(select `factura_compra`.`NumeroFactura` from `factura_compra` where (`factura_compra`.`ID` = `fci`.`idFacturaCompra`)) AS `NumeroFactura`,`fc`.`Tercero` AS `Tercero`,(select `proveedores`.`RazonSocial` from `proveedores` where (`proveedores`.`Num_Identificacion` = `fc`.`Tercero`) limit 1) AS `RazonSocial`,sum(`fci`.`SubtotalCompra`) AS `Subtotal`,sum(`fci`.`ImpuestoCompra`) AS `Impuestos`,(select sum(`factura_compra_retenciones`.`ValorRetencion`) from `factura_compra_retenciones` where (`factura_compra_retenciones`.`idCompra` = `fci`.`idFacturaCompra`)) AS `TotalRetenciones`,sum(`fci`.`TotalCompra`) AS `Total`,`fc`.`Concepto` AS `Concepto`,(select sum(`factura_compra_servicios`.`Subtotal_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `SubtotalServicios`,(select sum(`factura_compra_servicios`.`Impuesto_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `ImpuestosServicios`,(select sum(`factura_compra_servicios`.`Total_Servicio`) from `factura_compra_servicios` where (`factura_compra_servicios`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `TotalServicios`,(select sum(`factura_compra_items_devoluciones`.`SubtotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `SubtotalDevoluciones`,(select sum(`factura_compra_items_devoluciones`.`ImpuestoCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `ImpuestosDevueltos`,(select sum(`factura_compra_items_devoluciones`.`TotalCompra`) from `factura_compra_items_devoluciones` where (`factura_compra_items_devoluciones`.`idFacturaCompra` = `fci`.`idFacturaCompra`)) AS `TotalDevolucion`,`fc`.`idUsuario` AS `Usuario` from (`factura_compra_items` `fci` join `factura_compra` `fc` on((`fc`.`ID` = `fci`.`idFacturaCompra`))) group by `fci`.`idFacturaCompra`;

DROP TABLE IF EXISTS `vista_inventario_separados`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_inventario_separados` AS select `si`.`ID` AS `ID`,`si`.`Referencia` AS `Referencia`,`si`.`Nombre` AS `Nombre`,sum(`si`.`Cantidad`) AS `Cantidad`,`si`.`Departamento` AS `Departamento`,`si`.`SubGrupo1` AS `SubGrupo1`,`si`.`SubGrupo2` AS `SubGrupo2`,`si`.`SubGrupo3` AS `SubGrupo3`,`si`.`SubGrupo4` AS `SubGrupo4`,`si`.`SubGrupo5` AS `SubGrupo5` from (`separados_items` `si` join `separados` `s` on((`s`.`ID` = `si`.`idSeparado`))) where (`s`.`Estado` = 'Abierto') group by `si`.`Referencia`;

DROP TABLE IF EXISTS `vista_kardex`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_kardex` AS select `k`.`idKardexMercancias` AS `ID`,`k`.`Fecha` AS `Fecha`,`k`.`Movimiento` AS `Movimiento`,`k`.`Detalle` AS `Detalle`,`k`.`idDocumento` AS `idDocumento`,`k`.`Cantidad` AS `Cantidad`,`k`.`ValorUnitario` AS `ValorUnitario`,`k`.`ValorTotal` AS `ValorTotal`,`k`.`ProductosVenta_idProductosVenta` AS `ProductosVenta_idProductosVenta`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Nombre`,`pv`.`Existencias` AS `Existencias`,`pv`.`CostoUnitario` AS `CostoUnitario`,`pv`.`CostoTotal` AS `CostoTotal`,`pv`.`IVA` AS `IVA`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`k`.`Updated` AS `Updated`,`k`.`Sync` AS `Sync` from (`kardexmercancias` `k` join `productosventa` `pv` on((`k`.`ProductosVenta_idProductosVenta` = `pv`.`idProductosVenta`)));

DROP TABLE IF EXISTS `vista_ori_facturas`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_ori_facturas` AS select `fi`.`FechaFactura` AS `Fecha`,`fi`.`idFactura` AS `idFactura`,`fi`.`Referencia` AS `Referencia`,`fi`.`Nombre` AS `Nombre`,`fi`.`Departamento` AS `Departamento`,`fi`.`SubGrupo1` AS `SubGrupo1`,`fi`.`SubGrupo2` AS `SubGrupo2`,`fi`.`SubGrupo3` AS `SubGrupo3`,`fi`.`SubGrupo4` AS `SubGrupo4`,`fi`.`SubGrupo5` AS `SubGrupo5`,`fi`.`ValorUnitarioItem` AS `ValorUnitarioItem`,`fi`.`Cantidad` AS `Cantidad`,`fi`.`Dias` AS `Dias`,`fi`.`SubtotalItem` AS `SubtotalItem`,`fi`.`IVAItem` AS `IVAItem`,`fi`.`ValorOtrosImpuestos` AS `ValorOtrosImpuestos`,`fi`.`TotalItem` AS `TotalItem`,`fi`.`PorcentajeIVA` AS `PorcentajeIVA`,`fi`.`idOtrosImpuestos` AS `idOtrosImpuestos`,`fi`.`idPorcentajeIVA` AS `idPorcentajeIVA`,`fi`.`PrecioCostoUnitario` AS `PrecioCostoUnitario`,`fi`.`SubtotalCosto` AS `SubtotalCosto`,`fi`.`TipoItem` AS `TipoItem`,`fi`.`CuentaPUC` AS `CuentaPUC`,`fi`.`GeneradoDesde` AS `GeneradoDesde`,`fi`.`NumeroIdentificador` AS `NumeroIdentificador`,`fi`.`idUsuarios` AS `idUsuarios`,`fi`.`idCierre` AS `idCierre`,`f`.`idResolucion` AS `idResolucion`,`f`.`TipoFactura` AS `TipoFactura`,`f`.`Prefijo` AS `Prefijo`,`f`.`NumeroFactura` AS `NumeroFactura`,`f`.`Hora` AS `Hora`,`f`.`FormaPago` AS `FormaPago`,`f`.`CentroCosto` AS `CentroCosto`,`f`.`idSucursal` AS `idSucursal`,`f`.`EmpresaPro_idEmpresaPro` AS `EmpresaPro_idEmpresaPro`,`f`.`Clientes_idClientes` AS `Clientes_idClientes`,`f`.`ObservacionesFact` AS `ObservacionesFact` from (`ori_facturas_items` `fi` join `facturas` `f` on((`fi`.`idFactura` = `f`.`idFacturas`)));

DROP TABLE IF EXISTS `vista_preventa`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_preventa` AS select `p`.`VestasActivas_idVestasActivas` AS `VestasActivas_idVestasActivas`,'productosventa' AS `TablaItems`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Nombre`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `SubGrupo1`,`pv`.`Sub2` AS `SubGrupo2`,`pv`.`Sub3` AS `SubGrupo3`,`pv`.`Sub4` AS `SubGrupo4`,`pv`.`Sub5` AS `SubGrupo5`,`p`.`ValorAcordado` AS `ValorUnitarioItem`,`p`.`Cantidad` AS `Cantidad`,'1' AS `Dias`,(`p`.`ValorAcordado` * `p`.`Cantidad`) AS `SubtotalItem`,((`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA`) AS `IVAItem`,((select `productos_impuestos_adicionales`.`ValorImpuesto` from `productos_impuestos_adicionales` where (`productos_impuestos_adicionales`.`idProducto` = `p`.`ProductosVenta_idProductosVenta`)) * `p`.`Cantidad`) AS `ValorOtrosImpuestos`,((`p`.`ValorAcordado` * `p`.`Cantidad`) + ((`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA`)) AS `TotalItem`,concat((`pv`.`IVA` * 100),'%') AS `PorcentajeIVA`,`pv`.`CostoUnitario` AS `PrecioCostoUnitario`,(`pv`.`CostoUnitario` * `p`.`Cantidad`) AS `SubtotalCosto`,(select `prod_departamentos`.`TipoItem` from `prod_departamentos` where (`prod_departamentos`.`idDepartamentos` = `pv`.`Departamento`)) AS `TipoItem`,`pv`.`CuentaPUC` AS `CuentaPUC`,`p`.`Updated` AS `Updated`,`p`.`Sync` AS `Sync` from (`preventa` `p` join `productosventa` `pv` on((`p`.`ProductosVenta_idProductosVenta` = `pv`.`idProductosVenta`))) where (`p`.`TablaItem` = 'productosventa');

DROP TABLE IF EXISTS `vista_resumen_facturacion`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_resumen_facturacion` AS select `facturas_items`.`ID` AS `ID`,`facturas_items`.`FechaFactura` AS `FechaInicial`,`facturas_items`.`FechaFactura` AS `FechaFinal`,`facturas_items`.`Referencia` AS `Referencia`,`facturas_items`.`Nombre` AS `Nombre`,`facturas_items`.`Departamento` AS `Departamento`,`facturas_items`.`SubGrupo1` AS `SubGrupo1`,`facturas_items`.`SubGrupo2` AS `SubGrupo2`,`facturas_items`.`SubGrupo3` AS `SubGrupo3`,`facturas_items`.`SubGrupo4` AS `SubGrupo4`,`facturas_items`.`SubGrupo5` AS `SubGrupo5`,sum(`facturas_items`.`Cantidad`) AS `Cantidad`,round(sum(`facturas_items`.`TotalItem`),2) AS `TotalVenta`,round(sum(`facturas_items`.`SubtotalCosto`),2) AS `Costo` from `facturas_items` group by `facturas_items`.`Referencia`,`facturas_items`.`FechaFactura`;

DROP TABLE IF EXISTS `vista_resumen_ventas_departamentos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_resumen_ventas_departamentos` AS select `facturas_items`.`FechaFactura` AS `FechaFactura`,`facturas_items`.`Departamento` AS `Departamento`,`facturas_items`.`SubGrupo1` AS `SubGrupo1`,`facturas_items`.`SubGrupo2` AS `SubGrupo2`,`facturas_items`.`SubGrupo3` AS `SubGrupo3`,`facturas_items`.`SubGrupo4` AS `SubGrupo4`,`facturas_items`.`SubGrupo5` AS `SubGrupo5`,sum(`facturas_items`.`TotalItem`) AS `Total` from `facturas_items` group by `facturas_items`.`FechaFactura`,`facturas_items`.`Departamento`,`facturas_items`.`SubGrupo1`,`facturas_items`.`SubGrupo2`,`facturas_items`.`SubGrupo3`,`facturas_items`.`SubGrupo4`,`facturas_items`.`SubGrupo5`;

DROP TABLE IF EXISTS `vista_salud_facturas_diferencias`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_salud_facturas_diferencias` AS select `t1`.`id_fac_mov_generados` AS `id_factura_generada`,`t1`.`cod_prest_servicio` AS `cod_prest_servicio`,`t1`.`razon_social` AS `razon_social`,`t1`.`num_factura` AS `num_factura`,`t1`.`fecha_factura` AS `fecha_factura`,`t1`.`cod_enti_administradora` AS `cod_enti_administradora`,`t1`.`nom_enti_administradora` AS `nom_enti_administradora`,`t1`.`valor_neto_pagar` AS `valor_neto_pagar`,`t2`.`id_pagados` AS `id_factura_pagada`,`t2`.`fecha_pago_factura` AS `fecha_pago_factura`,`t2`.`valor_pagado` AS `valor_pagado`,`t2`.`num_pago` AS `num_pago`,(select (`t1`.`valor_neto_pagar` - `t2`.`valor_pagado`)) AS `DiferenciaEnPago`,`t1`.`tipo_negociacion` AS `tipo_negociacion`,`t1`.`dias_pactados` AS `dias_pactados`,`t1`.`fecha_radicado` AS `fecha_radicado`,`t1`.`numero_radicado` AS `numero_radicado`,`t1`.`Soporte` AS `Soporte` from (`salud_archivo_facturacion_mov_generados` `t1` join `salud_archivo_facturacion_mov_pagados` `t2` on((`t1`.`num_factura` = `t2`.`num_factura`))) where ((`t1`.`estado` = 'DIFERENCIA') and (`t1`.`tipo_negociacion` = 'evento'));

DROP TABLE IF EXISTS `vista_salud_facturas_no_pagas`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_salud_facturas_no_pagas` AS select `t1`.`id_fac_mov_generados` AS `id_factura_generada`,(select ((to_days(now()) - to_days(`t1`.`fecha_radicado`)) - `t1`.`dias_pactados`)) AS `DiasMora`,`t1`.`cod_prest_servicio` AS `cod_prest_servicio`,`t1`.`razon_social` AS `razon_social`,`t1`.`num_factura` AS `num_factura`,`t1`.`fecha_factura` AS `fecha_factura`,`t1`.`fecha_radicado` AS `fecha_radicado`,`t1`.`numero_radicado` AS `numero_radicado`,`t1`.`cod_enti_administradora` AS `cod_enti_administradora`,`t1`.`nom_enti_administradora` AS `nom_enti_administradora`,`t1`.`valor_neto_pagar` AS `valor_neto_pagar`,`t1`.`tipo_negociacion` AS `tipo_negociacion`,`t1`.`dias_pactados` AS `dias_pactados`,`t1`.`Soporte` AS `Soporte`,`t1`.`EstadoCobro` AS `EstadoCobro` from `salud_archivo_facturacion_mov_generados` `t1` where ((`t1`.`tipo_negociacion` = 'evento') and ((`t1`.`estado` = 'RADICADO') or (`t1`.`estado` = '')));

DROP TABLE IF EXISTS `vista_salud_facturas_pagas`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_salud_facturas_pagas` AS select `t1`.`id_fac_mov_generados` AS `id_factura_generada`,`t1`.`cod_prest_servicio` AS `cod_prest_servicio`,`t1`.`razon_social` AS `razon_social`,`t1`.`num_factura` AS `num_factura`,`t1`.`fecha_factura` AS `fecha_factura`,`t1`.`cod_enti_administradora` AS `cod_enti_administradora`,`t1`.`nom_enti_administradora` AS `nom_enti_administradora`,`t1`.`valor_neto_pagar` AS `valor_neto_pagar`,`t2`.`id_pagados` AS `id_factura_pagada`,`t2`.`fecha_pago_factura` AS `fecha_pago_factura`,`t2`.`valor_pagado` AS `valor_pagado`,`t2`.`num_pago` AS `num_pago`,`t1`.`tipo_negociacion` AS `tipo_negociacion`,`t1`.`dias_pactados` AS `dias_pactados`,`t1`.`fecha_radicado` AS `fecha_radicado`,`t1`.`numero_radicado` AS `numero_radicado`,`t1`.`Soporte` AS `Soporte` from (`salud_archivo_facturacion_mov_generados` `t1` join `salud_archivo_facturacion_mov_pagados` `t2` on((`t1`.`num_factura` = `t2`.`num_factura`))) where (`t1`.`estado` = 'PAGADA');

DROP TABLE IF EXISTS `vista_salud_facturas_prejuridicos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_salud_facturas_prejuridicos` AS select `t2`.`id_fac_mov_generados` AS `ID`,`t1`.`idCobroPrejuridico` AS `idCobroPrejuridico`,`t2`.`num_factura` AS `num_factura`,`t2`.`cod_prest_servicio` AS `cod_prest_servicio`,`t2`.`razon_social` AS `razon_social`,`t2`.`num_ident_prest_servicio` AS `num_ident_prest_servicio`,`t2`.`fecha_factura` AS `fecha_factura`,`t2`.`cod_enti_administradora` AS `cod_enti_administradora`,`t2`.`nom_enti_administradora` AS `nom_enti_administradora`,`t2`.`valor_neto_pagar` AS `valor_neto_pagar`,`t2`.`tipo_negociacion` AS `tipo_negociacion`,`t2`.`fecha_radicado` AS `fecha_radicado`,`t2`.`numero_radicado` AS `numero_radicado`,`t2`.`Soporte` AS `SoporteRadicado`,(select `salud_cobros_prejuridicos`.`Soporte` from `salud_cobros_prejuridicos` where (`salud_cobros_prejuridicos`.`ID` = `t1`.`idCobroPrejuridico`)) AS `SoporteCobro`,`t2`.`estado` AS `EstadoFactura`,`t2`.`EstadoCobro` AS `EstadoCobro` from (`salud_cobros_prejuridicos_relaciones` `t1` join `salud_archivo_facturacion_mov_generados` `t2` on((`t1`.`num_factura` = `t2`.`num_factura`))) where ((`t2`.`EstadoCobro` = 'PREJURIDICO1') or (`t2`.`EstadoCobro` = 'PREJURIDICO2'));

DROP TABLE IF EXISTS `vista_salud_pagas_no_generadas`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_salud_pagas_no_generadas` AS select `t1`.`id_pagados` AS `id_pagados`,`t1`.`num_factura` AS `num_factura`,`t1`.`fecha_pago_factura` AS `fecha_pago_factura`,`t1`.`num_pago` AS `num_pago`,`t1`.`valor_bruto_pagar` AS `valor_bruto_pagar`,`t1`.`valor_descuento` AS `valor_descuento`,`t1`.`valor_iva` AS `valor_iva`,`t1`.`valor_retefuente` AS `valor_retefuente`,`t1`.`valor_reteiva` AS `valor_reteiva`,`t1`.`valor_reteica` AS `valor_reteica`,`t1`.`valor_otrasretenciones` AS `valor_otrasretenciones`,`t1`.`valor_cruces` AS `valor_cruces`,`t1`.`valor_anticipos` AS `valor_anticipos`,`t1`.`valor_pagado` AS `valor_pagado`,`t1`.`nom_cargue` AS `nom_cargue`,`t1`.`fecha_cargue` AS `fecha_cargue`,`t1`.`Estado` AS `Estado`,`t1`.`idUser` AS `idUser`,`t1`.`Updated` AS `Updated`,`t1`.`Sync` AS `Sync` from (`salud_archivo_facturacion_mov_pagados` `t1` left join `salud_archivo_facturacion_mov_generados` `t2` on((`t1`.`num_factura` = `t2`.`num_factura`))) where isnull(`t2`.`num_factura`);

DROP TABLE IF EXISTS `vista_salud_procesos_gerenciales`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_salud_procesos_gerenciales` AS select `t1`.`ID` AS `ID`,`t1`.`idProceso` AS `idProceso`,`t1`.`Fecha` AS `Fecha`,(select `salud_eps`.`nombre_completo` from `salud_eps` where (`salud_eps`.`cod_pagador_min` = `t2`.`EPS`)) AS `EPS`,`t2`.`NombreProceso` AS `NombreProceso`,`t2`.`Concepto` AS `Concepto`,`t1`.`Observaciones` AS `Observaciones`,`t1`.`Soporte` AS `Soporte` from (`salud_procesos_gerenciales_archivos` `t1` join `salud_procesos_gerenciales` `t2` on((`t1`.`idProceso` = `t2`.`ID`)));

DROP TABLE IF EXISTS `vista_sistemas`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_sistemas` AS select `si`.`ID` AS `ID`,`st`.`ID` AS `idSistema`,`st`.`Nombre` AS `Nombre_Sistema`,`st`.`Observaciones` AS `Observaciones`,`si`.`TablaOrigen` AS `TablaOrigen`,`s`.`idProductosVenta` AS `CodigoInterno`,`s`.`Nombre` AS `Nombre`,`si`.`Cantidad` AS `Cantidad`,`si`.`ValorUnitario` AS `PrecioUnitario`,round((`si`.`ValorUnitario` * `si`.`Cantidad`),0) AS `PrecioVenta`,round(`s`.`CostoUnitario`,0) AS `CostoUnitario`,round((`si`.`Cantidad` * `s`.`CostoUnitario`),0) AS `Costo_Total_Item`,`s`.`IVA` AS `IVA`,`s`.`Departamento` AS `Departamento`,`s`.`Sub1` AS `Sub1`,`s`.`Sub2` AS `Sub2`,`s`.`Sub3` AS `Sub3`,`s`.`Sub4` AS `Sub4`,`s`.`Sub5` AS `Sub5`,`st`.`Updated` AS `Updated`,`st`.`Sync` AS `Sync` from ((`sistemas_relaciones` `si` join `servicios` `s` on((`s`.`Referencia` = `si`.`Referencia`))) join `sistemas` `st` on((`st`.`ID` = `si`.`idSistema`))) union select `si`.`ID` AS `ID`,`st`.`ID` AS `idSistema`,`st`.`Nombre` AS `Nombre_Sistema`,`st`.`Observaciones` AS `Observaciones`,`si`.`TablaOrigen` AS `TablaOrigen`,`s`.`idProductosVenta` AS `CodigoInterno`,`s`.`Nombre` AS `Nombre`,`si`.`Cantidad` AS `Cantidad`,`si`.`ValorUnitario` AS `PrecioUnitario`,round((`si`.`ValorUnitario` * `si`.`Cantidad`),0) AS `PrecioVenta`,round(`s`.`CostoUnitario`,0) AS `CostoUnitario`,round((`si`.`Cantidad` * `s`.`CostoUnitario`),0) AS `Costo_Total_Item`,`s`.`IVA` AS `IVA`,`s`.`Departamento` AS `Departamento`,`s`.`Sub1` AS `Sub1`,`s`.`Sub2` AS `Sub2`,`s`.`Sub3` AS `Sub3`,`s`.`Sub4` AS `Sub4`,`s`.`Sub5` AS `Sub5`,`st`.`Updated` AS `Updated`,`st`.`Sync` AS `Sync` from ((`sistemas_relaciones` `si` join `productosventa` `s` on((`s`.`Referencia` = `si`.`Referencia`))) join `sistemas` `st` on((`st`.`ID` = `si`.`idSistema`)));

DROP TABLE IF EXISTS `vista_titulos_abonos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_titulos_abonos` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`Hora` AS `Hora`,`td`.`Monto` AS `Monto`,`td`.`idVenta` AS `idVenta`,`tv`.`Promocion` AS `Promocion`,`tv`.`Mayor1` AS `Mayor`,`td`.`Observaciones` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`Estado` AS `Estado`,`td`.`idComprobanteIngreso` AS `idComprobanteIngreso`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_abonos` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

DROP TABLE IF EXISTS `vista_titulos_comisiones`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_titulos_comisiones` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`Hora` AS `Hora`,`td`.`Monto` AS `Monto`,`td`.`idVenta` AS `idVenta`,`tv`.`Promocion` AS `Promocion`,`tv`.`Mayor1` AS `Mayor`,`td`.`Observaciones` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`idUsuario` AS `idUsuario`,`td`.`idEgreso` AS `idEgreso`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_comisiones` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

DROP TABLE IF EXISTS `vista_titulos_devueltos`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vista_titulos_devueltos` AS select `td`.`ID` AS `ID`,`td`.`Fecha` AS `Fecha`,`td`.`idVenta` AS `idVenta`,`td`.`Promocion` AS `Promocion`,`td`.`Mayor` AS `Mayor`,`td`.`Concepto` AS `Concepto`,`td`.`idColaborador` AS `idColaborador`,`td`.`NombreColaborador` AS `NombreColaborador`,`td`.`idUsuario` AS `idUsuario`,`tv`.`Mayor2` AS `Mayor2`,`tv`.`Adicional` AS `Adicional`,`tv`.`Valor` AS `Valor`,`tv`.`TotalAbonos` AS `TotalAbonos`,`tv`.`Saldo` AS `Saldo`,`tv`.`idCliente` AS `idCliente`,`tv`.`NombreCliente` AS `NombreCliente` from (`titulos_devoluciones` `td` join `titulos_ventas` `tv` on((`td`.`idVenta` = `tv`.`ID`)));

-- 2018-03-15 15:35:11
