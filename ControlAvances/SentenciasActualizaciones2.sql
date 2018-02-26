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
ALTER TABLE `cuentasxpagar` ADD `Estado` VARCHAR(20) NOT NULL  AFTER `idUsuario`;

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
FROM salud_archivo_facturacion_mov_generados t1 WHERE t1.tipo_negociacion='evento' AND (t1.estado='RADICADO' OR t1.estado=''); 

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (120, 'Historial de Facturas NO Pagadas', '36', '3', 'vista_salud_facturas_no_pagas.php', '_SELF', b'1', 'historial2.png', '5', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

DROP VIEW IF EXISTS `vista_salud_facturas_diferencias`;
CREATE VIEW vista_salud_facturas_diferencias AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,t1.`fecha_factura`,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar`,t2.`id_pagados` as id_factura_pagada,t2.`fecha_pago_factura`,t2.`valor_pagado`,t2.`num_pago` ,
(SELECT t1.`valor_neto_pagar`-t2.`valor_pagado`) as DiferenciaEnPago ,t1.`tipo_negociacion`,
t1.`dias_pactados`,t1.`fecha_radicado`,t1.`numero_radicado`,t1.`Soporte` 
FROM salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t1.estado='DIFERENCIA' AND t1.tipo_negociacion='evento';

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

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (122, 'Listas de precios', '22', '3', 'productos_lista_precios.php', '_SELF', b'1', 'listasprecios.png', '5', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (123, 'Precios Adicionales', '22', '3', 'productos_precios_adicionales.php', '_SELF', b'1', 'productos_precios.png', '5', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES
(39, 'Legal', 26, 3, b'1', '2017-12-20 15:06:39', '2017-10-13 14:16:55'),
(38, 'Archivos', 26, 4, b'1', '2017-12-20 15:06:39', '2017-10-13 14:16:55'),
(37, 'Auditoria', 26, 2, b'1', '2017-12-20 15:07:49', '2017-10-13 14:16:55');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (124, 'Glosas y Devoluciones', '37', '3', 'SaludGlosasDevoluciones.php', '_SELF', b'1', 'glosas.png', '1', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES (40, 'Informes', '26', '5', b'1', '2017-12-20 10:06:39', '2017-10-13 14:16:55');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (125, 'Informe de Estado de Rips', '40', '3', 'SaludInformeEstadoRips.php', '_SELF', b'1', 'estadorips.png', '1', '2017-12-20 10:14:35', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (126, 'Cartera X Edades', '40', '3', 'salud_edad_cartera.php', '_SELF', b'1', 'cartera.png', '2', '2017-12-20 10:14:35', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (127, 'Registro de Glosas', '36', '3', 'salud_registro_glosas.php', '_SELF', b'1', 'glosas2.png', '7', '2017-12-18 07:51:25', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (128, 'Archivo de Consultas AC', '38', '3', 'salud_archivo_consultas.php', '_SELF', b'1', 'ac.png', '1', '2017-12-18 07:51:25', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (129, 'Archivo de Hospitalizaciones AH', '38', '3', 'salud_archivo_hospitalizaciones.php', '_SELF', b'1', 'ah.png', '2', '2017-12-18 07:51:25', '2017-10-13 14:16:57');


INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (130, 'Archivo de Medicamentos AM', '38', '3', 'salud_archivo_medicamentos.php', '_SELF', b'1', 'am.png', '3', '2017-12-18 07:51:25', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (131, 'Otros Servicios AT', '38', '3', 'salud_archivo_otros_servicios.php', '_SELF', b'1', 'at.png', '4', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (132, 'Archivo de Procedimientos AP', '38', '3', 'salud_archivo_procedimientos.php', '_SELF', b'1', 'ap.jpg', '5', '2017-12-18 07:51:25', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (134, 'Archivo de usuarios US', '38', '3', 'salud_archivo_usuarios.php', '_SELF', b'1', 'us.png', '6', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (135, 'Facturacion Generada AF', '38', '3', 'salud_archivo_facturacion_mov_generados.php', '_SELF', b'1', 'af.png', '7', '2017-12-18 07:51:25', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (136, 'Facturacion Recaudada AR', '38', '3', 'salud_archivo_facturacion_mov_pagados.php', '_SELF', b'1', 'ar.png', '8', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (137, 'Listado de EPS', '36', '3', 'salud_eps.php', '_SELF', b'1', 'eps.png', '8', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

-- Vista para seleccionar lo que se pagó pero no fue generado
DROP VIEW IF EXISTS `vista_salud_pagas_no_generadas`;
CREATE VIEW vista_salud_pagas_no_generadas AS 
Select T1.* From salud_archivo_facturacion_mov_pagados T1 
Left Outer Join salud_archivo_facturacion_mov_generados T2 ON T1.num_factura = T2.num_factura 
where T2.num_factura is null ;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (138, 'Facturas Pagas No Generadas', '37', '3', 'vista_salud_pagas_no_generadas.php', '_SELF', b'1', 'factura3.png', '8', '2017-12-18 07:51:25', '2017-10-13 14:16:57');

DROP TABLE IF EXISTS `libromayorbalances`;
CREATE TABLE IF NOT EXISTS `libromayorbalances` (
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


INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (139, 'Libro Mayor y Balances', '16', '3', 'libromayorbalances.php', '_SELF', b'1', 'libromayor.png', '1', '2017-10-13 14:16:57', '2017-10-13 14:16:57');


INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES (6, '../Salud/', '2017-10-13 14:16:51', '2017-10-13 14:16:51');

ALTER TABLE `salud_archivo_facturacion_mov_pagados` ADD `Soporte` VARCHAR(45) NOT NULL AFTER `Estado`;
ALTER TABLE `salud_archivo_facturacion_mov_pagados_temp` ADD `Soporte` VARCHAR(45) NOT NULL AFTER `Estado`;

DROP VIEW IF EXISTS `vista_salud_facturas_no_pagas`;
CREATE VIEW vista_salud_facturas_no_pagas AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada, 
(SELECT DATEDIFF(now(),t1.`fecha_radicado` ) - t1.`dias_pactados`) as DiasMora ,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,
t1.`fecha_factura`, t1.`fecha_radicado`,t1.`numero_radicado`,t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar` ,t1.`tipo_negociacion`, 
t1.`dias_pactados`,t1.`Soporte`,t1.`EstadoCobro`
FROM salud_archivo_facturacion_mov_generados t1 WHERE t1.tipo_negociacion='evento' AND (t1.estado='RADICADO' OR t1.estado=''); 


DROP VIEW IF EXISTS `vista_salud_facturas_diferencias`;
CREATE VIEW vista_salud_facturas_diferencias AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,t1.`fecha_factura`,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar`,t2.`id_pagados` as id_factura_pagada,t2.`fecha_pago_factura`,t2.`valor_pagado`,t2.`num_pago` ,
(SELECT t1.`valor_neto_pagar`-t2.`valor_pagado`) as DiferenciaEnPago ,t1.`tipo_negociacion`,
t1.`dias_pactados`,t1.`fecha_radicado`,t1.`numero_radicado`,t1.`Soporte` 
FROM salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t1.estado='DIFERENCIA' AND t1.tipo_negociacion='evento';

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (140, 'Generar Prejuridicos', '39', '6', 'SaludPrejuridicos.php', '_SELF', b'1', 'prejuridico.jpg', '1', '2018-01-04 08:40:15', '2017-10-13 14:16:57');

DROP VIEW IF EXISTS `vista_salud_facturas_prejuridicos`;
CREATE VIEW vista_salud_facturas_prejuridicos AS 
SELECT t2.`id_fac_mov_generados` as ID,t1.idCobroPrejuridico,t2.`num_factura`,`cod_prest_servicio`,`razon_social`,`num_ident_prest_servicio`,`fecha_factura`,`cod_enti_administradora`,`nom_enti_administradora`,`valor_neto_pagar`,`tipo_negociacion`,`fecha_radicado`,`numero_radicado`,`Soporte` as SoporteRadicado,(SELECT Soporte FROM salud_cobros_prejuridicos WHERE ID=t1.idCobroPrejuridico) AS SoporteCobro,`estado` as EstadoFactura,`EstadoCobro` FROM `salud_cobros_prejuridicos_relaciones` t1 
INNER JOIN salud_archivo_facturacion_mov_generados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t2.EstadoCobro='PREJURIDICO1' OR t2.EstadoCobro='PREJURIDICO2';

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `NotasPiePagina`, `Updated`, `Sync`) VALUES (27, 'COBRO PREJURIDICO 1', '001', 'F-GSL-001', '2018-01-02', '', '2017-10-20 10:30:00', '2017-10-20 10:30:00');
INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `NotasPiePagina`, `Updated`, `Sync`) VALUES (28, 'COBRO PREJURIDICO 2', '001', 'F-GSL-002', '2018-01-02', '', '2017-10-20 10:30:00', '2017-10-20 10:30:00');

ALTER TABLE `prod_bajas_altas` CHANGE `Fecha` `Fecha` DATE NOT NULL;
ALTER TABLE `prod_bajas_altas` CHANGE `Cantidad` `Cantidad` DOUBLE NOT NULL;

DROP VIEW IF EXISTS `vista_resumen_ventas_departamentos`;
CREATE VIEW vista_resumen_ventas_departamentos AS 
SELECT `FechaFactura`,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5`, 
SUM(`TotalItem`) AS Total FROM `facturas_items`  
GROUP BY `FechaFactura`, `Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5` ;

INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (28, 'Graficos', '1', 'MnuGraficosVentas.php', '_BLANK', '0', 'graficos.png', '1', '2017-10-13 14:16:49', '2017-10-13 14:16:49');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) 
VALUES (41, 'Reportes Graficos', '17', '7', b'1', '2017-12-26 21:55:19', '2017-10-13 14:16:55');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (141, 'Reportes Graficos', '41', '1', 'MnuGraficosVentas.php', '_SELF', b'1', 'graficos.png', '1', '2017-12-19 11:03:31', '2017-10-13 14:16:57');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) 
VALUES (42, 'Ventas', '28', '1', b'1', '2018-01-22 15:05:00', '2017-10-13 14:16:55');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (142, 'Comparacion Anual', '42', '5', 'YearsComparison.php', '_SELF', b'1', 'anualcomp.jpg', '1', '2017-11-23 13:19:43', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (143, 'Comparacion Diaria', '42', '5', 'DiasComparacion.php', '_SELF', b'1', 'diascomp.png', '2', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (144, 'Graficos Ventas Departamentos', '42', '3', 'GraficosVentasXDepartamentos.php', '_SELF', b'1', 'graficos.png', '2', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (145, 'Circular 030', '40', '6', 'salud_edad_cartera.php', '_SELF', b'1', '030.jpg', '3', '2018-01-04 08:40:18', '2017-10-13 14:16:57');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (146, 'SIHO', '40', '6', 'salud_edad_cartera.php', '_SELF', b'1', 'siho.png', '4', '2018-01-04 08:40:18', '2017-10-13 14:16:57');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES (43, 'Tesoreria', '26', '6', b'1', '2017-12-26 21:55:19', '2017-10-13 14:16:55');

DROP VIEW IF EXISTS `vista_factura_compra_totales`;
CREATE VIEW vista_factura_compra_totales AS 
SELECT `idFacturaCompra`,(SELECT Fecha FROM factura_compra WHERE ID=`idFacturaCompra`) as Fecha,
(SELECT Tercero FROM factura_compra WHERE ID=`idFacturaCompra`) as Tercero,
sum(`SubtotalCompra`) AS Subtotal, sum(`ImpuestoCompra`) as Impuestos,
(SELECT sum(ValorRetencion) FROM factura_compra_retenciones WHERE idCompra=`idFacturaCompra`) as TotalRetenciones,
sum(`TotalCompra`) as Total, 
(SELECT sum(Subtotal_Servicio) FROM factura_compra_servicios WHERE factura_compra_servicios.idFacturaCompra=`factura_compra_items`.`idFacturaCompra`) as SubtotalServicios, 
(SELECT sum(Impuesto_Servicio) FROM factura_compra_servicios WHERE factura_compra_servicios.idFacturaCompra=`factura_compra_items`.`idFacturaCompra`) as ImpuestosServicios,
(SELECT sum(Total_Servicio) FROM factura_compra_servicios WHERE factura_compra_servicios.idFacturaCompra=`factura_compra_items`.`idFacturaCompra`) as TotalServicios,
(SELECT sum(SubtotalCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idFacturaCompra=`factura_compra_items`.`idFacturaCompra`) as SubtotalDevoluciones,
(SELECT sum(ImpuestoCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idFacturaCompra=`factura_compra_items`.`idFacturaCompra`) as ImpuestosDevueltos,
(SELECT sum(TotalCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idFacturaCompra=`factura_compra_items`.`idFacturaCompra`) as TotalDevolucion 
FROM `factura_compra_items` GROUP BY `idFacturaCompra`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (147, 'Totales en Compras', '13', '3', 'vista_factura_compra_totales.php', '_SELF', b'1', 'historial3.png', '6', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

ALTER TABLE `prod_comisiones` CHANGE `Dep_Comision` `Dep_Comision` INT NOT NULL;

ALTER TABLE `prod_comisiones` CHANGE `Porcentaje_Comision` `Porcentaje_Comision` DOUBLE NOT NULL;
ALTER TABLE `prod_comisiones` CHANGE `Valor_Comision` `Valor_Comision` DOUBLE NOT NULL;

ALTER TABLE `preventa` CHANGE `Fecha` `Fecha` DATE NULL DEFAULT NULL;

ALTER TABLE `productos_impuestos_adicionales` ADD `Incluido` ENUM('SI','NO') NOT NULL DEFAULT 'NO' AFTER `NombreCuenta`;

ALTER TABLE `prod_comisiones` CHANGE `Valor_Comision` `ValorComision1` DOUBLE NOT NULL;
ALTER TABLE `prod_comisiones` ADD `ValorComision2` DOUBLE NOT NULL AFTER `ValorComision1`;
ALTER TABLE `prod_comisiones` ADD `ValorComision3` DOUBLE NOT NULL AFTER `ValorComision2`;

ALTER TABLE `facturas_items` CHANGE `Referencia` `Referencia` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL ;
ALTER TABLE `productosventa` CHANGE `Referencia` `Referencia` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL ;

DROP VIEW IF EXISTS `vista_comisiones_venta_productos`;

ALTER TABLE `productosventa` ADD `ValorComision1` INT NOT NULL AFTER `CuentaPUC`, 
ADD `ValorComision2` INT NOT NULL AFTER `ValorComision1`,
 ADD `ValorComision3` INT NOT NULL AFTER `ValorComision2`;

INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `NotasPiePagina`, `Updated`, `Sync`) VALUES (29, 'COMPROBANTE DE MOVIMIENTOS CONTABLES', '001', 'F-GFC-003', '2018-02-13', '', '2018-01-10 17:22:33', '2017-10-20 10:30:00');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (148, 'Generar Comprobante de movimientos contables', '16', '3', 'ComprobantesContables.php', '_SELF', b'1', 'comprobantes.png', '3', '2017-10-13 14:16:57', '2017-10-13 14:16:57');

ALTER TABLE `preventa` ADD `idSistema` INT NOT NULL AFTER `TipoItem`;

ALTER TABLE `kardexmercancias` CHANGE `ProductosVenta_idProductosVenta` `ProductosVenta_idProductosVenta` BIGINT NOT NULL;

ALTER TABLE `proveedores` ADD `Soporte` VARCHAR(150) NOT NULL AFTER `Cupo`;
ALTER TABLE `clientes` ADD `Soporte` VARCHAR(150) NOT NULL AFTER `Cupo`;
