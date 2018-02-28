DROP VIEW IF EXISTS `vista_inventario_separados`;
CREATE VIEW vista_inventario_separados AS
SELECT si.`ID`,`Referencia`,`Nombre`,SUM(`Cantidad`) as Cantidad,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5` 
FROM `separados_items` si INNER JOIN separados s ON s.ID=si.`idSeparado` 
WHERE s.Estado='Abierto' GROUP BY si.`Referencia`;

DROP VIEW IF EXISTS `vista_resumen_ventas_departamentos`;
CREATE VIEW vista_resumen_ventas_departamentos AS 
SELECT `FechaFactura`,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5`, 
SUM(`TotalItem`) AS Total FROM `facturas_items`  
GROUP BY `FechaFactura`, `Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5` ;

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

