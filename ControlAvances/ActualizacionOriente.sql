ALTER TABLE `productosventa` ADD `CostoUnitarioPromedio` DOUBLE NOT NULL AFTER `CostoTotal`;
ALTER TABLE `productosventa` CHANGE `PrecioMayorista` `PrecioMayorista` DOUBLE NOT NULL;
ALTER TABLE `productosventa` CHANGE `CostoUnitario` `CostoUnitario` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `productosventa` CHANGE `CostoTotal` `CostoTotal` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `productosventa` ADD `CostoTotalPromedio` DOUBLE NOT NULL AFTER `CostoUnitarioPromedio`;
UPDATE `productosventa` SET `CostoUnitarioPromedio`=`CostoUnitario`,`CostoTotalPromedio`=`CostoTotal` ;


DROP VIEW IF EXISTS `vista_resumen_facturacion`;
CREATE VIEW vista_resumen_facturacion AS
SELECT ID,`FechaFactura`,`Referencia`,`Nombre`,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5`,SUM(`Cantidad`) as Cantidad,SUM(`TotalItem`) as TotalVenta,SUM(`SubtotalCosto`) as Costo
  FROM `facturas_items` GROUP BY `Referencia`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES ('105', 'Resumen de facturacion', '12', '3', 'vista_resumen_facturacion.php', '_SELF', b'1', 'resumen.png', '5', '2017-09-07 12:12:07', '0000-00-00 00:00:00');
ALTER TABLE `cot_itemscotizaciones` ADD INDEX(`NumCotizacion`);
ALTER TABLE `facturas_items` ADD INDEX(`idCierre`);

INSERT INTO `parametros_contables` (`ID`, `Descripcion`, `CuentaPUC`, `NombreCuenta`, `Updated`, `Sync`) VALUES
(20, 'Anticipos realizados por clientes', 280505, 'ANTICIPOS REALIZADOS POR CLIENTES', '2017-09-29 15:24:03', '2017-06-06 12:13:00');


ALTER TABLE `comprobantes_ingreso` ADD `idCierre` BIGINT NOT NULL AFTER `Estado`;
UPDATE `comprobantes_ingreso` SET `idCierre`=1;
ALTER TABLE `empresapro` ADD `CXPAutomaticas` VARCHAR(2) NOT NULL DEFAULT 'SI' AFTER `FacturaSinInventario`;
ALTER TABLE `colaboradores` ADD `Activo` VARCHAR(2) NOT NULL DEFAULT 'SI' AFTER `SalarioBasico`;
INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `NotasPiePagina`, `Updated`, `Sync`) VALUES (25, 'COMPROBANTE DE BAJAS O ALTAS', '001', 'F-GI-006', '2017-08-09', '', '2017-06-15 09:03:57', '2017-06-15 09:03:57');

ALTER TABLE `productosalquiler` CHANGE `Existencias` `Existencias` INT NOT NULL;
ALTER TABLE `productosalquiler` CHANGE `PrecioVenta` `PrecioVenta` DOUBLE NOT NULL;
ALTER TABLE `productosalquiler` CHANGE `PrecioMayorista` `PrecioMayorista` DOUBLE NOT NULL;
ALTER TABLE `productosalquiler` CHANGE `CostoUnitario` `CostoUnitario` DOUBLE NOT NULL;
ALTER TABLE `productosalquiler` ADD `EnAlquiler` INT NOT NULL AFTER `Existencias`, ADD `EnBodega` INT NOT NULL AFTER `EnAlquiler`;
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES ('106', 'Kardex Alquiler', '22', '3', 'kardex_alquiler.php', '_SELF', b'1', 'kardex_alquiler.png', '5', '2017-09-07 11:03:21', '0000-00-00 00:00:00');
ALTER TABLE `restaurante_pedidos_items` ADD INDEX(`idPedido`);
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES ('107', 'Historial de Cierres', '30', '3', 'restaurante_cierres.php', '_SELF', b'1', 'historial.png', '4', '2017-10-11 20:22:44', '0000-00-00 00:00:00');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES ('108', 'Historial de Pedidos', '30', '3', 'restaurante_pedidos.php', '_SELF', b'1', 'historial2.png', '5', '2017-10-11 23:03:06', '0000-00-00 00:00:00');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES ('109', 'Historial de Eliminaciones', '21', '3', 'registra_eliminaciones.php', '_SELF', b'1', 'papelera.png', '3', '2017-09-07 07:49:20', '0000-00-00 00:00:00');

DROP TABLE IF EXISTS `registra_eliminaciones`;
CREATE TABLE IF NOT EXISTS `registra_eliminaciones` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `colaboradores` CHANGE `Activo` `Activo` VARCHAR(2) NOT NULL DEFAULT 'SI';
ALTER TABLE `empresapro` CHANGE `CXPAutomaticas` `CXPAutomaticas` VARCHAR(2) NOT NULL DEFAULT 'SI';

CREATE TABLE IF NOT EXISTS `facturas_kardex` (
  `idFacturas` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `CuentaDestino` bigint(20) NOT NULL,
  `Kardex` varchar(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'NO',
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idFacturas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

UPDATE `menu` SET `Image` = 'pub.png' WHERE `menu`.`ID` = 25;

ALTER TABLE `librodiario` ADD INDEX(`Tipo_Documento_Intero`);
ALTER TABLE `librodiario` ADD INDEX(`Num_Documento_Interno`);
ALTER TABLE `librodiario` ADD INDEX(`Tercero_Identificacion`);
ALTER TABLE `librodiario` ADD INDEX(`CuentaPUC`);

ALTER TABLE `kardexmercancias` ADD `CostoUnitarioPromedio` DOUBLE NOT NULL AFTER `ValorTotal`, ADD `CostoTotalPromedio` DOUBLE NOT NULL AFTER `CostoUnitarioPromedio`;
ALTER TABLE `kardexmercancias_temporal` ADD `CostoUnitarioPromedio` DOUBLE NOT NULL AFTER `ValorTotal`, ADD `CostoTotalPromedio` DOUBLE NOT NULL AFTER `CostoUnitarioPromedio`;
UPDATE `kardexmercancias` SET `CostoUnitarioPromedio`=`ValorUnitario`,`CostoTotalPromedio`=`ValorTotal`;
INSERT INTO `formatos_calidad` (`ID`, `Nombre`, `Version`, `Codigo`, `Fecha`, `NotasPiePagina`, `Updated`, `Sync`) VALUES ('26', 'ESTADO DE RESULTADO INTEGRAL', '001', 'F-GF-002', '2017-08-09', '', '2017-10-13 14:10:40', '2017-10-13 14:10:40');
ALTER TABLE `estadosfinancieros_mayor_temporal` ADD `SaldoAnterior` DOUBLE NOT NULL AFTER `NombreCuenta`;
ALTER TABLE `estadosfinancieros_mayor_temporal` ADD `SaldoFinal` DOUBLE NOT NULL AFTER `Neto`;
ALTER TABLE `estadosfinancieros_mayor_temporal` CHANGE `Neto` `Neto` DOUBLE NOT NULL;
