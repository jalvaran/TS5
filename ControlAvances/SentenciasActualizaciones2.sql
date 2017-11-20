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
