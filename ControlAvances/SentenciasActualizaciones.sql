ALTER TABLE `facturas_abonos` ADD `TipoPagoAbono` VARCHAR(30) NOT NULL AFTER `Hora`;
--
-- Estructura de tabla para la tabla `parametros_contables`
--
DROP TABLE IF EXISTS `parametros_contables`;
CREATE TABLE IF NOT EXISTS `parametros_contables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `parametros_contables`
--

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(1, 'Cuenta que se utiliza para el iva generado en las operaciones de venta ', 24080501, 'Impuesto sobre las ventas por pagar Generado', '2017-06-22 22:35:55', '2017-06-22 17:35:55'),
(2, 'Cuenta Costo de venta de la mercancia', 613501, 'Venta de Mercancias No Fabricadas por la Empresa', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(3, 'Cuenta Gasto Para Bajas de Mercancias no fabricadas por la empresa', 529915, '', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(4, 'Cuenta donde se alojan los inventarios de las mercancias no fabricadas por la empresa', 143501, 'Mercancias No Fabricadas por la Empresa', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(5, 'Cuenta para Realizar el Credito a las altas de un producto', 529915, '', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(6, 'Cuenta para realizar creditos o debitos a los clientes', 130505, 'CLIENTES NACIONALES', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(7, 'Cuenta para registrar el gasto por otros descuentos cuando se registra un ingreso por cartera', 521095, 'OTROS DESCUENTOS', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(8, 'CUENTA PARA REGISTRAR EL PAGO DE COMISIONES', 520518, 'COMISIONES', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(9, 'Cuenta para registrar la devolucion de una venta', 417501, 'DEVOLUCIONES EN VENTA', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(10, 'CUENTA ORIGEN DE LA CREACION DE UN EGRESO A PARTIR DE UN CONCEPTO CONTABLE CREADO.', 110505, 'CAJA GENERAL', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(11, 'Cuenta para llevar la utilidad del ejercicio', 3605, 'Utilidad del Ejercicio', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(12, 'Cuenta para llevar la perdida del ejercicio', 3610, 'Perdida del Ejercicio', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(13, 'Contrapartida para llevar la perdida o ganancia del ejercicio', 5905, 'Ganancias y perdidas', '2017-04-18 14:59:19', '2017-04-18 09:59:19'),
(14, 'Cuenta x pagar proveedores', 220505, 'PROVEEDORES NACIONALES', '2017-06-16 17:13:00', '2017-06-16 12:13:00'),
(15, 'Descuentos en compras por pronto pago', 421040, 'DESCUENTOS COMERCIALES CONDICIONADOS', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(16, 'impuesto generado al consumo de bolsas plasticas', 24081004, 'IMPUESTO AL CONSUMO DE BOLSAS PLASTICAS', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(17, 'Cuenta para registrar los abonos a los creditos con tarjetas', 11100501, 'BANCOS', '2017-06-15 14:05:38', '2017-06-15 09:05:38'),
(18, 'Cuenta para registrar los abonos a los creditos con Cheques', 11100510, 'BANCOS CHEQUES', '2017-06-15 14:05:38', '2017-06-15 09:05:38');
DROP TABLE IF EXISTS `registro_basculas`;
CREATE TABLE IF NOT EXISTS `registro_basculas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Gramos` double NOT NULL,
  `idBascula` int(11) NOT NULL,
  `Leido` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `porcentajes_iva` ADD `Factor` VARCHAR(10) NOT NULL DEFAULT 'M' AFTER `Valor`;

DROP TABLE IF EXISTS `porcentajes_iva`;
CREATE TABLE IF NOT EXISTS `porcentajes_iva` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `porcentajes_iva`
--

INSERT INTO `porcentajes_iva` (`ID`, `Nombre`, `Valor`, `Factor`, `CuentaPUC`, `CuentaPUCIVAGenerado`, `NombreCuenta`, `Habilitado`, `Updated`, `Sync`) VALUES
(1, 'Sin IVA', '0', 'M', 2408, 2408, '', 'SI', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(2, 'Excluidos', 'E', 'M', 2408, 2408, '', 'SI', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(3, 'IVA 5 %', '0.05', 'M', 24080503, 24081003, 'Impuestos del 5%', 'SI', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(4, 'IVA del 8%', '0.08', 'M', 24080502, 24081002, 'Impuestos del 8%', 'SI', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(5, 'IVA del 16%', '0.16', 'M', 24080504, 24081004, 'Impuestos del 16%', 'NO', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(6, 'IVA del 19%', '0.19', 'M', 24080501, 24081001, 'Impuestos del 19%', 'SI', '2017-06-15 14:05:43', '2017-06-15 09:05:43'),
(7, 'ImpoConsumo Bolsas', '20', 'S', 24080511, 24081011, 'IMPUESTO AL CONSUMO DE BOLSAS', 'SI', '2017-07-21 15:35:47', '0000-00-00 00:00:00');

ALTER TABLE `facturas_items` ADD `idPorcentajeIVA` INT NOT NULL AFTER `PorcentajeIVA`;
ALTER TABLE `ori_facturas_items` ADD `idPorcentajeIVA` INT NOT NULL AFTER `PorcentajeIVA`;

ALTER TABLE `facturas_items` ADD `ValorOtrosImpuestos` DOUBLE NOT NULL AFTER `IVAItem`;
ALTER TABLE `facturas_items` ADD `idOtrosImpuestos` INT NOT NULL AFTER `PorcentajeIVA`;

ALTER TABLE `ori_facturas_items` ADD `ValorOtrosImpuestos` DOUBLE NOT NULL AFTER `IVAItem`;
ALTER TABLE `ori_facturas_items` ADD `idOtrosImpuestos` INT NOT NULL AFTER `PorcentajeIVA`;


DROP TABLE IF EXISTS `productos_impuestos_adicionales`;
CREATE TABLE IF NOT EXISTS `productos_impuestos_adicionales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreImpuesto` text COLLATE latin1_spanish_ci NOT NULL,
  `idProducto` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `ValorImpuesto` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `NombreCuenta` text COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `productos_impuestos_adicionales`
--

INSERT INTO `productos_impuestos_adicionales` (`ID`, `NombreImpuesto`, `idProducto`, `ValorImpuesto`, `CuentaPUC`, `NombreCuenta`) VALUES
(1, 'Impoconsumo', '0', '20', '24081011', 'IMPUESTO AL CONSUMO DE BOLSAS');

ALTER TABLE `egresos_pre` CHANGE `Abono` `Abono` DOUBLE NOT NULL;
ALTER TABLE `cuentasxpagar_abonos` CHANGE `idCuentaXPagar` `idCuentaXPagar` TEXT NOT NULL;

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(1, 'Administrar', 1, 'Admin.php', '_BLANK', 1, 'admin.png', 1, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(2, 'Gestión Comercial', 1, 'MnuVentas.php', '_BLANK', 1, 'comercial.png', 2, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(3, 'Facturación', 1, 'MnuFacturacion.php', '_BLANK', 1, 'factura.png', 3, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(4, 'Cartera', 3, 'cartera.php', '_BLANK', 1, 'cartera.png', 4, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(5, 'Compras', 1, 'MnuCompras.php', '_BLANK', 1, 'factura_compras.png', 5, '2017-07-24 19:38:53', '2017-06-22 18:08:59'),
(6, 'Egresos', 1, 'MnuEgresos.php', '_BLANK', 1, 'egresos.png', 6, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(7, 'Comprobantes Contables', 3, 'CreaComprobanteCont.php', '_BLANK', 1, 'egresoitems.png', 7, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(8, 'Conceptos Contables', 3, 'ConceptosContablesUtilidad.php', '_BLANK', 1, 'conceptos.png', 8, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(9, 'Clientes', 3, 'clientes.php', '_BLANK', 1, 'clientes.png', 9, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(10, 'Proveedores', 3, 'proveedores.php', '_BLANK', 1, 'proveedores.png', 10, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(11, 'Cuentas X Pagar', 3, 'cuentasxpagar.php', '_BLANK', 1, 'cuentasxpagar.png', 11, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(12, 'Inventarios', 1, 'MnuInventarios.php', '_BLANK', 1, 'inventarios.png', 12, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(13, 'Ordenes de Servicio', 3, 'ordenesdetrabajo.php', '_BLANK', 1, 'ordentrabajo.png', 13, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(14, 'Producción', 3, 'CronogramaProduccion.php', '_BLANK', 1, 'produccion.png', 14, '2017-07-24 19:03:17', '2017-06-22 18:08:59'),
(15, 'Títulos', 1, 'MnuTitulos.php', '_BLANK', 1, 'titulos.jpg', 15, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(16, 'Restaurante', 1, 'MnuRestaurante.php', '_BLANK', 1, 'restaurante.png', 16, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(17, 'Informes', 1, 'MnuInformes.php', '_BLANK', 1, 'informes.png', 17, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(18, 'Gestión de Requerimientos', 1, 'MnuRequerimientos.php', '_BLANK', 1, 'requerimientos.png', 18, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(19, 'Ajustes y Servicios Generales', 1, 'MnuAjustes.php', '_BLANK', 1, 'ajustes.png', 19, '2017-07-24 19:05:12', '2017-06-22 18:08:59'),
(20, 'Salir', 2, 'destruir.php', '_SELF', 1, 'salir.png', 20, '2017-07-24 19:07:08', '2017-06-22 18:08:59'),
(21, 'Administrar Tiempos', 3, 'crono_admin_sesiones.php', '_BLANK', 0, 'admin.png', 21, '2017-07-24 19:10:13', '2017-06-22 18:08:59'),
(22, 'Visualizar Tiempo', 3, 'crono.php', '_BLANK', 0, 'crono.png', 22, '2017-07-24 19:10:11', '2017-06-22 18:08:59'),
(23, 'Ingresos', 1, 'MnuIngresos.php', '_BLANK', 1, 'ingresos.png', 5, '2017-07-24 19:38:53', '2017-06-22 18:08:59');


DROP TABLE IF EXISTS `menu_carpetas`;
CREATE TABLE IF NOT EXISTS `menu_carpetas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ruta` varchar(90) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `menu_carpetas`
--

INSERT INTO `menu_carpetas` (`ID`, `Ruta`) VALUES
(1, ''),
(2, '../'),
(3, '../VAtencion/');

ALTER TABLE `facturas` CHANGE `Fecha` `Fecha` DATE NOT NULL;

ALTER TABLE `preventa` ADD `CostoUnitario` DOUBLE NOT NULL AFTER `ValorAcordado`, ADD `PrecioMayorista` DOUBLE NOT NULL AFTER `CostoUnitario`;
ALTER TABLE `preventa` ADD `PorcentajeIVA` DOUBLE NOT NULL AFTER `Impuestos`;

ALTER TABLE `preventa` CHANGE `ValorAcordado` `ValorAcordado` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `ValorUnitario` `ValorUnitario` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `Subtotal` `Subtotal` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `Impuestos` `Impuestos` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `TotalVenta` `TotalVenta` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `Cantidad` `Cantidad` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `Descuento` `Descuento` DOUBLE NOT NULL;
ALTER TABLE `preventa` CHANGE `ProductosVenta_idProductosVenta` `ProductosVenta_idProductosVenta` BIGINT NOT NULL;

DROP VIEW IF EXISTS `vista_titulos_devueltos`;
CREATE VIEW vista_titulos_devueltos AS
SELECT td.`ID` as ID,td.`Fecha` as Fecha, td.`idVenta` as idVenta,td.`Promocion` as Promocion, td.`Mayor` as Mayor,td.`Concepto` as Concepto,td.`idColaborador` as idColaborador,td.`NombreColaborador`,td.idUsuario,tv.`Mayor2`,tv.`Adicional`,tv.`Valor`,tv.`TotalAbonos`,tv.`Saldo`,tv.`idCliente`,tv.`NombreCliente`  FROM titulos_devoluciones td INNER JOIN titulos_ventas tv ON td.idVenta=tv.ID;


DROP VIEW IF EXISTS `vista_titulos_abonos`;
CREATE VIEW vista_titulos_abonos AS
SELECT td.`ID` as ID,td.`Fecha` as Fecha,td.`Hora` ,td.Monto, td.`idVenta`,tv.`Promocion` as Promocion, tv.`Mayor1` as Mayor,td.`Observaciones` as Concepto,td.`idColaborador` as idColaborador,td.`NombreColaborador`,td.`Estado`,td.`idComprobanteIngreso`,tv.`Mayor2`,tv.`Adicional`,tv.`Valor`,tv.`TotalAbonos`,tv.`Saldo`,tv.`idCliente`,tv.`NombreCliente`  FROM titulos_abonos td INNER JOIN titulos_ventas tv ON td.idVenta=tv.ID;

DROP VIEW IF EXISTS `vista_titulos_comisiones`;
CREATE VIEW vista_titulos_comisiones AS 
SELECT td.`ID` as ID,td.`Fecha` as Fecha,td.`Hora` ,td.Monto, td.`idVenta`,tv.`Promocion` as Promocion, tv.`Mayor1` as Mayor,td.`Observaciones` as Concepto,td.`idColaborador` as idColaborador,td.`NombreColaborador`,td.`idUsuario`,td.`idEgreso`,tv.`Mayor2`,tv.`Adicional`,tv.`Valor`,tv.`TotalAbonos`,tv.`Saldo`,tv.`idCliente`,tv.`NombreCliente` FROM titulos_comisiones td INNER JOIN titulos_ventas tv ON td.idVenta=tv.ID;

DROP VIEW IF EXISTS `vista_preventa`;
CREATE VIEW vista_preventa AS 
select p.VestasActivas_idVestasActivas,'productosventa' AS `TablaItems`,`pv`.`Referencia` AS `Referencia`,`pv`.`Nombre` AS `Nombre`,`pv`.`Departamento` AS `Departamento`,`pv`.`Sub1` AS `SubGrupo1`,`pv`.`Sub2` AS `SubGrupo2`,`pv`.`Sub3` AS `SubGrupo3`,`pv`.`Sub4` AS `SubGrupo4`,`pv`.`Sub5` AS `SubGrupo5`,`p`.`ValorAcordado` AS `ValorUnitarioItem`,`p`.`Cantidad` AS `Cantidad`,'1' AS `Dias`,(`p`.`ValorAcordado` * `p`.`Cantidad`) AS `SubtotalItem`,((`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA`) AS `IVAItem`,((select `productos_impuestos_adicionales`.`ValorImpuesto` from `productos_impuestos_adicionales` where (`productos_impuestos_adicionales`.`idProducto` = `p`.`ProductosVenta_idProductosVenta`)) * `p`.`Cantidad`) AS `ValorOtrosImpuestos`, ((`p`.`ValorAcordado` * `p`.`Cantidad`) + (`p`.`ValorAcordado` * `p`.`Cantidad`) * `pv`.`IVA` ) as TotalItem,(CONCAT(pv.IVA*100,'%')) as PorcentajeIVA,pv.CostoUnitario as PrecioCostoUnitario, pv.CostoUnitario*p.Cantidad as SubtotalCosto,(SELECT TipoItem FROM prod_departamentos WHERE idDepartamentos=pv.Departamento) as TipoItem,pv.CuentaPUC as CuentaPUC,p.Updated as Updated,p.Sync as Sync from (`preventa` `p` join `productosventa` `pv` on((`p`.`ProductosVenta_idProductosVenta` = `pv`.`idProductosVenta`))) where (`p`.`TablaItem` = 'productosventa');
