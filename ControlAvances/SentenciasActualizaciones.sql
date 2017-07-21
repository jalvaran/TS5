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
(1, 'Impoconsumo', '215865', '20', '24081011', 'IMPUESTO AL CONSUMO DE BOLSAS');