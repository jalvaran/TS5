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

