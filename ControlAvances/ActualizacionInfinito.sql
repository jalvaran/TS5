

ALTER TABLE `ori_facturas_items` CHANGE `idFactura` `idFactura` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `facturas_abonos` CHANGE `Fecha` `Fecha` DATE NOT NULL;
ALTER TABLE `ori_facturas_items` CHANGE `FechaFactura` `FechaFactura` DATE NOT NULL;
ALTER TABLE `facturas_abonos` CHANGE `Valor` `Valor` DOUBLE NOT NULL;
ALTER TABLE `separados_abonos` CHANGE `Valor` `Valor` DOUBLE NOT NULL;
ALTER TABLE `ori_facturas_items` CHANGE `TotalItem` `TotalItem` DOUBLE NOT NULL COMMENT 'Total del valor del Item';

DROP VIEW IF EXISTS `vista_entregas`;
CREATE VIEW vista_entregas AS 
SELECT 'ventas' as Tabla,f.FormaPago as Tipo, fa.FechaFactura as Fecha, fa.idUsuarios as idUsuario, fa.TotalItem as Total FROM ori_facturas_items fa INNER JOIN ori_facturas f ON f.idFacturas=fa.idFactura WHERE f.FormaPago='Contado'
UNION 
SELECT 'abonos_creditos' as Tabla,fa.FormaPago as Tipo,fa.Fecha as Fecha, fa.Usuarios_idUsuarios as idUsuario, fa.Valor as Total FROM facturas_abonos fa
UNION 
SELECT 'abonos_separados' as Tabla,('AbonoSeparado') as Tipo,fa.Fecha as Fecha, fa.idUsuarios as idUsuario, fa.Valor as Total FROM separados_abonos fa
UNION 
SELECT 'egresos' as Tabla,('Egresos') as Tipo,fa.Fecha as Fecha, fa.Usuario_idUsuario as idUsuario, fa.Valor as Total FROM egresos fa WHERE TipoEgreso='VentasRapidas';

DROP VIEW IF EXISTS `vista_abonos`;
CREATE VIEW vista_abonos AS 
SELECT 'abonos_factura' as Tabla,fa.FormaPago as TipoAbono,fa.Fecha as Fecha, fa.Valor as Valor, fa.Usuarios_idUsuarios as idUsuario, fa.idCierre FROM facturas_abonos fa
UNION 
SELECT 'abonos_separados' as Tabla,'Separados' as TipoAbono,fa.Fecha as Fecha, fa.Valor as Valor, fa.idUsuarios as idUsuario, fa.idCierre FROM separados_abonos fa;

ALTER TABLE `cajas_aperturas_cierres` ADD `TotalRetiroSeparados` DOUBLE NOT NULL AFTER `TotalVentasSisteCredito`;
ALTER TABLE `empresapro` ADD `FacturaSinInventario` VARCHAR(2) NOT NULL AFTER `RutaImagen`;

ALTER TABLE `cot_itemscotizaciones` CHANGE `ValorUnitario` `ValorUnitario` DOUBLE NOT NULL;
ALTER TABLE `cot_itemscotizaciones` CHANGE `Cantidad` `Cantidad` DOUBLE NOT NULL;
ALTER TABLE `cot_itemscotizaciones` CHANGE `Subtotal` `Subtotal` DOUBLE NOT NULL;
ALTER TABLE `cot_itemscotizaciones` CHANGE `IVA` `IVA` DOUBLE NOT NULL;
ALTER TABLE `cot_itemscotizaciones` CHANGE `Total` `Total` DOUBLE NOT NULL;
ALTER TABLE `cot_itemscotizaciones` CHANGE `Descuento` `Descuento` DOUBLE NOT NULL;
ALTER TABLE `cot_itemscotizaciones` CHANGE `ValorDescuento` `ValorDescuento` DOUBLE NOT NULL;
ALTER TABLE `cot_itemscotizaciones` CHANGE `PrecioCosto` `PrecioCosto` DOUBLE NOT NULL;
ALTER TABLE `cot_itemscotizaciones` CHANGE `SubtotalCosto` `SubtotalCosto` DOUBLE NOT NULL;

ALTER TABLE `precotizacion` CHANGE `Cantidad` `Cantidad` DOUBLE NOT NULL;
ALTER TABLE `precotizacion` CHANGE `ValorUnitario` `ValorUnitario` DOUBLE NOT NULL;
ALTER TABLE `precotizacion` CHANGE `SubTotal` `SubTotal` DOUBLE NOT NULL;
ALTER TABLE `precotizacion` CHANGE `IVA` `IVA` DOUBLE NOT NULL;
ALTER TABLE `precotizacion` CHANGE `Descuento` `Descuento` DOUBLE NOT NULL;
ALTER TABLE `precotizacion` CHANGE `ValorDescuento` `ValorDescuento` DOUBLE NOT NULL;
ALTER TABLE `precotizacion` CHANGE `PrecioCosto` `PrecioCosto` DOUBLE NOT NULL;
ALTER TABLE `precotizacion` CHANGE `SubtotalCosto` `SubtotalCosto` DOUBLE NOT NULL;
ALTER TABLE `precotizacion` CHANGE `Total` `Total` DOUBLE NOT NULL;

DROP TABLE IF EXISTS `parametros_contables`;
CREATE TABLE IF NOT EXISTS `parametros_contables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `parametros_contables`
--

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(1, 'Cuenta que se utiliza para el iva generado en las operaciones de venta ', 240805, 'Impuesto sobre las ventas por pagar Generado', '2017-06-02 12:52:52', '2017-04-18 09:59:19'),
(2, 'Cuenta Costo de venta de la mercancia', 613501, 'Venta de Mercancias No Fabricadas por la Empresa', '2017-06-02 13:13:10', '2017-04-18 09:59:19'),
(3, 'Cuenta Gasto Para Bajas de Mercancias no fabricadas por la empresa', 529915, '', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(4, 'Cuenta donde se alojan los inventarios de las mercancias no fabricadas por la empresa', 143501, 'Mercancias No Fabricadas por la Empresa', '2017-05-26 00:53:09', '2017-04-18 09:59:19'),
(5, 'Cuenta para Realizar el Credito a las altas de un producto', 529915, '', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(6, 'Cuenta para realizar creditos o debitos a los clientes', 130505, 'CLIENTES NACIONALES', '2017-06-02 12:47:13', '2017-04-18 09:59:19'),
(7, 'Cuenta para registrar el gasto por otros descuentos cuando se registra un ingreso por cartera', 521095, 'OTROS DESCUENTOS', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(8, 'CUENTA PARA REGISTRAR EL PAGO DE COMISIONES', 520518, 'COMISIONES', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(9, 'Cuenta para registrar la devolucion de una venta', 417501, 'DEVOLUCIONES EN VENTA', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(10, 'CUENTA ORIGEN DE LA CREACION DE UN EGRESO A PARTIR DE UN CONCEPTO CONTABLE CREADO.', 110505, 'CAJA GENERAL', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(11, 'Cuenta para llevar la utilidad del ejercicio', 3605, 'Utilidad del Ejercicio', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(12, 'Cuenta para llevar la perdida del ejercicio', 3610, 'Perdida del Ejercicio', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(13, 'Contrapartida para llevar la perdida o ganancia del ejercicio', 5905, 'Ganancias y perdidas', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(14, 'Cuenta x pagar proveedores', 2205, 'PROVEEDORES NACIONALES', '2017-05-26 01:13:05', '2017-04-18 09:59:19'),
(15, 'Descuentos en compras por pronto pago', 421040, 'DESCUENTOS COMERCIALES CONDICIONADOS', '2017-05-25 22:45:57', '2017-04-18 09:59:19');


DROP TABLE IF EXISTS `porcentajes_iva`;
--
-- Estructura de tabla para la tabla `porcentajes_iva`
--

CREATE TABLE IF NOT EXISTS `porcentajes_iva` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `CuentaPUCIVAGenerado` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `porcentajes_iva`
--

INSERT INTO `porcentajes_iva` (`ID`, `Nombre`, `Valor`, `CuentaPUC`, `CuentaPUCIVAGenerado`, `NombreCuenta`, `Habilitado`, `Updated`, `Sync`) VALUES
(1, 'Sin IVA', '0', 2408, 2408, '', 'SI', '2017-06-02 13:28:26', '2017-04-18 09:59:23'),
(2, 'Excluidos', 'E', 2408, 2408, '', 'SI', '2017-06-02 13:28:30', '2017-04-18 09:59:23'),
(3, 'IVA 5 %', '0.05', 24080503, 24081003, 'Impuestos del 5%', 'SI', '2017-06-02 13:28:31', '2017-04-18 09:59:23'),
(4, 'IVA del 8%', '0.08', 24080502, 24081002, 'Impuestos del 8%', 'SI', '2017-06-02 13:28:33', '2017-04-18 09:59:23'),
(5, 'IVA del 16%', '0.16', 24080504, 24081004, 'Impuestos del 16%', 'NO', '2017-06-02 13:29:41', '2017-04-18 09:59:23'),
(6, 'IVA del 19%', '0.19', 24080501, 24081001, 'Impuestos del 19%', 'SI', '2017-06-02 13:28:36', '2017-04-18 09:59:23');

ALTER TABLE `prod_codbarras` CHANGE `ProductosVenta_idProductosVenta` `ProductosVenta_idProductosVenta` BIGINT NOT NULL;
ALTER TABLE `prod_codbarras` CHANGE `idCodBarras` `idCodBarras` BIGINT NOT NULL AUTO_INCREMENT;
ALTER TABLE `prod_codbarras` ADD `TablaOrigen` VARCHAR(90) NOT NULL DEFAULT 'productosventa' AFTER `CodigoBarras`;

--
-- Estructura de tabla para la tabla `factura_compra`
--

CREATE TABLE IF NOT EXISTS `factura_compra` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra_descuentos`
--

CREATE TABLE IF NOT EXISTS `factura_compra_descuentos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCompra` bigint(20) NOT NULL,
  `CuentaPUCDescuento` bigint(20) NOT NULL,
  `NombreCuentaDescuento` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `ValorDescuento` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra_items`
--

CREATE TABLE IF NOT EXISTS `factura_compra_items` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra_items_devoluciones`
--

CREATE TABLE IF NOT EXISTS `factura_compra_items_devoluciones` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra_retenciones`
--

CREATE TABLE IF NOT EXISTS `factura_compra_retenciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCompra` bigint(20) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `ValorRetencion` double NOT NULL,
  `PorcentajeRetenido` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `sistemas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` text COLLATE utf8_spanish2_ci NOT NULL,
  `PrecioVenta` double NOT NULL,
  `PrecioMayorista` double NOT NULL,
  `RutaImagen` text COLLATE utf8_spanish2_ci NOT NULL,
  `Observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `Departamento` int(11) NOT NULL,
  `Sub1` int(11) NOT NULL,
  `Sub2` int(11) NOT NULL,
  `Sub3` int(11) NOT NULL,
  `Sub4` int(11) NOT NULL,
  `Sub5` int(11) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistemas_relaciones`
--

CREATE TABLE IF NOT EXISTS `sistemas_relaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TablaOrigen` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `Referencia` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Cantidad` double NOT NULL,
  `idSistema` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

DROP VIEW IF EXISTS `vista_compras_productos`;
CREATE VIEW 
vista_compras_productos AS 
SELECT `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,
fi.idProducto AS idProducto,pv.Referencia AS Referencia,pv.Nombre AS Producto, pv.PrecioVenta,fi.Cantidad,fi.CostoUnitarioCompra AS CostoUnitario, fi.SubtotalCompra AS Subtotal,
fi.ImpuestoCompra AS Impuestos, fi.TotalCompra AS Total,fi.Tipo_Impuesto AS Tipo_Impuesto,
`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,
`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,
`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,
`c`.`idSucursal` AS `idSucursal`,c.Updated,c.Sync
FROM factura_compra c INNER JOIN proveedores t ON `c`.`Tercero` = `t`.`Num_Identificacion` 
INNER JOIN factura_compra_items fi ON fi.idFacturaCompra=c.ID INNER JOIN productosventa pv ON fi.idProducto=pv.idProductosVenta
WHERE c.`Estado`='CERRADA';

DROP VIEW IF EXISTS `vista_compras_productos_devueltos`;
CREATE VIEW 
vista_compras_productos_devueltos AS 
SELECT `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,
fi.idProducto AS idProducto,pv.Referencia AS Referencia,pv.Nombre AS Producto, pv.PrecioVenta,fi.Cantidad,fi.CostoUnitarioCompra AS CostoUnitario, fi.SubtotalCompra AS Subtotal,
fi.ImpuestoCompra AS Impuestos, fi.TotalCompra AS Total,fi.Tipo_Impuesto AS Tipo_Impuesto,
`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,
`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,
`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,
`c`.`idSucursal` AS `idSucursal`,c.Updated,c.Sync
FROM factura_compra c INNER JOIN proveedores t ON `c`.`Tercero` = `t`.`Num_Identificacion` 
INNER JOIN factura_compra_items_devoluciones fi ON fi.idFacturaCompra=c.ID INNER JOIN productosventa pv ON fi.idProducto=pv.idProductosVenta
WHERE c.`Estado`='CERRADA';

DROP VIEW IF EXISTS `vista_compras_servicios`;
CREATE VIEW 
vista_compras_servicios AS 
SELECT `c`.`ID` AS `ID`,`c`.`Fecha` AS `Fecha`,`c`.`NumeroFactura` AS `NumeroFactura`,`t`.`RazonSocial` AS `RazonSocial`,`c`.`Tercero` AS `NIT`,
fs.CuentaPUC_Servicio AS Cuenta, fs.Nombre_Cuenta AS NombreCuenta, fs.Concepto_Servicio, fs.Subtotal_Servicio AS Subtotal, fs.Impuesto_Servicio AS Impuestos, 
fs.Total_Servicio AS Total,fs.Tipo_Impuesto ,`c`.`Concepto` AS `Concepto`,`c`.`Observaciones` AS `Observaciones`,
`c`.`TipoCompra` AS `TipoCompra`,`c`.`Soporte` AS `Soporte`,`c`.`idUsuario` AS `idUsuario`,`c`.`idCentroCostos` AS `idCentroCostos`,
`c`.`idSucursal` AS `idSucursal`,c.Updated,c.Sync
FROM factura_compra c INNER JOIN proveedores t ON `c`.`Tercero` = `t`.`Num_Identificacion` 
INNER JOIN factura_compra_servicios fs ON fs.idFacturaCompra=c.ID 
WHERE c.`Estado`='CERRADA';

ALTER TABLE `clientes` CHANGE `DV` `DV` VARCHAR(5) NOT NULL;
ALTER TABLE `proveedores` CHANGE `DV` `DV` VARCHAR(5) NOT NULL;

INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `Cuentas_idPUC`, `Updated`, `Sync`) VALUES ('236701', 'Impuesto a las ventas retenido', '0', '2367', CURRENT_TIMESTAMP, '0000-00-00 00:00:00');
INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `Cuentas_idPUC`, `Updated`, `Sync`) VALUES ('236801', 'Impuesto de industria y comercio retenido', '0', '2368', CURRENT_TIMESTAMP, '0000-00-00 00:00:00');

ALTER TABLE `facturas_items` CHANGE `Cantidad` `Cantidad` DOUBLE NOT NULL;
ALTER TABLE `facturas_items` CHANGE `SubtotalItem` `SubtotalItem` DOUBLE NOT NULL;
ALTER TABLE `facturas_items` CHANGE `IVAItem` `IVAItem` DOUBLE NOT NULL;
ALTER TABLE `facturas_items` CHANGE `TotalItem` `TotalItem` DOUBLE NOT NULL;
ALTER TABLE `facturas_items` CHANGE `PrecioCostoUnitario` `PrecioCostoUnitario` DOUBLE NOT NULL;
ALTER TABLE `facturas_items` CHANGE `SubtotalCosto` `SubtotalCosto` DOUBLE NOT NULL;

DROP VIEW IF EXISTS `vista_kardex`;
CREATE VIEW 
vista_kardex AS 
SELECT `k`.`idKardexMercancias` AS `ID`,`k`.`Fecha` AS `Fecha`,`k`.`Movimiento` AS `Movimiento`,`k`.`Detalle` AS `Detalle`,`k`.`idDocumento` AS `idDocumento`,`k`.`Cantidad` AS `Cantidad`,`k`.`ValorUnitario` AS `ValorUnitario`,`k`.`ValorTotal` AS `ValorTotal`,`k`.`ProductosVenta_idProductosVenta` AS `ProductosVenta_idProductosVenta`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Nombre`,`pv`.`Existencias` AS `Existencias`,`pv`.`CostoUnitario` AS `CostoUnitario`,`pv`.`CostoTotal` AS `CostoTotal`,`pv`.`IVA` AS `IVA`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `Sub1`,`pv`.`Sub2` AS `Sub2`,`pv`.`Sub3` AS `Sub3`,`pv`.`Sub4` AS `Sub4`,`pv`.`Sub5` AS `Sub5`,`k`.`Updated` AS `Updated`,`k`.`Sync` AS `Sync`
FROM kardexmercancias k INNER JOIN productosventa pv ON `k`.`ProductosVenta_idProductosVenta` = `pv`.`idProductosVenta`;
