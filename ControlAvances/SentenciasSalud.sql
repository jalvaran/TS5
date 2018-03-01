--Saldos iniciales de las eps
ALTER TABLE `salud_eps` ADD `saldo_inicial` DOUBLE NOT NULL AFTER `Nombre_gerente`;
ALTER TABLE `salud_eps` ADD `fecha_saldo_inicial` DATE NOT NULL AFTER `saldo_inicial`;
--tabla de tesoreria
DROP TABLE IF EXISTS `salud_tesoreria`;
CREATE TABLE IF NOT EXISTS `salud_tesoreria` (
  `ID` bigint(20) NOT NULL,
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

ALTER TABLE `salud_tesoreria` CHANGE `ID` `ID` BIGINT(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `salud_bancos` CHANGE `ID` `ID` BIGINT NOT NULL AUTO_INCREMENT;

ALTER TABLE `salud_archivo_facturacion_mov_generados` CHANGE `Soporte` `Soporte` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL COMMENT 'Ruta de Archivo de comprobación de radicado';

