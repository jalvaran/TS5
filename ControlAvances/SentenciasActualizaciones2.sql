ALTER TABLE `facturas_pre` CHANGE `Cantidad` `Cantidad` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `Dias` `Dias` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `SubtotalItem` `SubtotalItem` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `IVAItem` `IVAItem` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `TotalItem` `TotalItem` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `PorcentajeIVA` `PorcentajeIVA` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `PrecioCostoUnitario` `PrecioCostoUnitario` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `SubtotalCosto` `SubtotalCosto` DOUBLE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `FechaFactura` `FechaFactura` DATE NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `Nombre` `Nombre` TEXT CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL;
ALTER TABLE `facturas_pre` CHANGE `ValorUnitarioItem` `ValorUnitarioItem` DOUBLE NOT NULL;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (111, 'Historial detallado', '33', '3', 'traslados_items.php', '_SELF', b'1', 'historial2.png', '4', '2017-10-13 14:16:57', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (112, 'Sistemas', '27', '3', 'sistemas.php', '_SELF', b'1', 'sistem.png', '1', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

ALTER TABLE `inventarios_temporal` ADD `CostoUnitarioPromedio` DOUBLE NOT NULL AFTER `CostoTotal`;
ALTER TABLE `inventarios_temporal` CHANGE `PrecioMayorista` `PrecioMayorista` DOUBLE NOT NULL;
ALTER TABLE `inventarios_temporal` CHANGE `CostoUnitario` `CostoUnitario` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `inventarios_temporal` CHANGE `CostoTotal` `CostoTotal` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `inventarios_temporal` ADD `CostoTotalPromedio` DOUBLE NOT NULL AFTER `CostoUnitarioPromedio`;

INSERT INTO `subcuentas` (`PUC`, `Nombre`, `Valor`, `Cuentas_idPUC`, `Updated`, `Sync`) VALUES ('220505', 'PROVEEDORES NACIONALES', NULL, '2205', CURRENT_TIMESTAMP, '0000-00-00 00:00:00');
ALTER TABLE `cuentasxpagar` ADD `CuentaPUC` VARCHAR(20) NOT NULL DEFAULT '220505' AFTER `Estado`;


DROP VIEW IF EXISTS `vista_inventario_separados`;
CREATE VIEW vista_inventario_separados AS
SELECT si.`ID`,`Referencia`,`Nombre`,SUM(`Cantidad`) as Cantidad,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5` 
FROM `separados_items` si INNER JOIN separados s ON s.ID=si.`idSeparado` 
WHERE s.Estado='Abierto' GROUP BY si.`Referencia`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (113, 'Inventario de Separados', '22', '3', 'vista_inventario_separados.php', '_SELF', b'1', 'inventario_separados.png', '3', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

ALTER TABLE `separados` ADD `Observaciones` TEXT NOT NULL AFTER `Estado`;

INSERT INTO `porcentajes_iva` (`ID`, `Nombre`, `Valor`, `Factor`, `CuentaPUC`, `CuentaPUCIVAGenerado`, `NombreCuenta`, `Habilitado`, `Updated`, `Sync`) VALUES ('8', 'impuesto del 1.9%', '0.019', 'M', '24080505', '24081005', 'Impuestos del 10% del 19%', 'SI', '2017-10-13 14:28:50', '2017-10-13 14:28:50');

ALTER TABLE `comprobantes_contabilidad_items` CHANGE `Tercero` `Tercero` VARCHAR(45) NOT NULL;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (114, 'Comparacion Anual', '9', '5', 'YearsComparison.php', '_SELF', b'1', 'anualcomp.jpg', '6', '2017-10-13 14:16:57', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (115, 'Comparacion Diaria', '9', '5', 'DiasComparacion.php', '_SELF', b'1', 'diascomp.png', '6', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES (5, '../Graficos/', '2017-10-13 14:16:51', '2017-10-13 14:16:51');

INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (26, 'Salud', '1', 'MnuSalud.php', '_BLANK', '0', 'salud.png', '18', '2017-10-16 20:26:13', '2017-10-13 14:16:49');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (116, 'Subir RIPS Generados', '36', '5', 'Salud_SubirRips.php', '_SELF', b'1', 'upload2.png', '1', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES (36, 'RIPS', '26', '1', b'1', '2017-10-13 14:16:55', '2017-10-13 14:16:55');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (117, 'Subir RIPS de pago', '36', '3', 'Salud_SubirRipsPagos.php', '_SELF', b'1', 'upload.png', '3', '2017-12-11 10:44:06', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (118, 'Radicar Facturas', '36', '3', 'salud_radicacion_facturas.php', '_SELF', b'1', 'radicar.jpg', '2', '2017-12-11 10:44:06', '2017-10-13 14:16:57');



DROP VIEW IF EXISTS `vista_salud_facturas_pagas`;
CREATE VIEW vista_salud_facturas_pagas AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,t1.`fecha_factura`,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar`,t2.`id_pagados` as id_factura_pagada,t2.`fecha_pago_factura`,t2.`valor_pagado`,t2.`num_pago` ,t1.`tipo_negociacion`,
t1.`dias_pactados`,t1.`fecha_radicado`,t1.`numero_radicado`,t1.`Soporte` 
FROM salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t1.estado='PAGADA';

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (119, 'Historial de Facturas Pagas', '36', '3', 'vista_salud_facturas_pagas.php', '_SELF', b'1', 'historial.png', '4', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

DROP VIEW IF EXISTS `vista_salud_facturas_no_pagas`;
CREATE VIEW vista_salud_facturas_no_pagas AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada, 
(SELECT DATEDIFF(now(),t1.`fecha_radicado` ) - t1.`dias_pactados`) as DiasMora ,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,
t1.`fecha_factura`, t1.`fecha_radicado`,t1.`numero_radicado`,t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar` ,t1.`tipo_negociacion`, 
t1.`dias_pactados`,t1.`Soporte`
FROM salud_archivo_facturacion_mov_generados t1 WHERE t1.estado='RADICADO' OR t1.estado=''; 

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (120, 'Historial de Facturas NO Pagadas', '36', '3', 'vista_salud_facturas_no_pagas.php', '_SELF', b'1', 'historial2.png', '5', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

DROP VIEW IF EXISTS `vista_salud_facturas_diferencias`;
CREATE VIEW vista_salud_facturas_diferencias AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,t1.`fecha_factura`,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar`,t2.`id_pagados` as id_factura_pagada,t2.`fecha_pago_factura`,t2.`valor_pagado`,t2.`num_pago` ,
(SELECT t1.`valor_neto_pagar`-t2.`valor_pagado`) as DiferenciaEnPago ,t1.`tipo_negociacion`,
t1.`dias_pactados`,t1.`fecha_radicado`,t1.`numero_radicado`,t1.`Soporte` 
FROM salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t1.estado='DIFERENCIA';

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (121, 'Historial de Facturas Con Diferencias', '36', '3', 'vista_salud_facturas_diferencias.php', '_SELF', b'1', 'historial3.png', '6', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

CREATE TABLE IF NOT EXISTS `productos_lista_precios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `Descripcion` text COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `productos_lista_precios`
--

INSERT INTO `productos_lista_precios` (`ID`, `Nombre`, `Descripcion`, `idUser`, `Updated`, `Sync`) VALUES
(1, 'Distribuidor', 'Precio dado para un distribuidor', 3, '2017-12-19 13:27:55', '0000-00-00 00:00:00'),
(2, 'Intermediario', '', 3, '2017-12-19 13:27:55', '0000-00-00 00:00:00'),
(3, 'Morosos', '', 3, '2017-12-19 13:27:55', '0000-00-00 00:00:00');


CREATE TABLE IF NOT EXISTS `productos_precios_adicionales` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `idListaPrecios` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='tabla para agregar precios a los productos' AUTO_INCREMENT=1 ;


ALTER TABLE `productos_precios_adicionales` ADD `TablaVenta` VARCHAR(45) NOT NULL AFTER `PrecioVenta`;

ALTER TABLE `productos_precios_adicionales` ADD `idUser` INT NOT NULL AFTER `TablaVenta`;
