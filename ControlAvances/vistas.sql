DROP VIEW IF EXISTS `vista_resumen_facturacion`;
CREATE VIEW vista_resumen_facturacion AS
SELECT ID,`FechaFactura` as FechaInicial,`FechaFactura` as FechaFinal,`Referencia`,(SELECT idProductosVenta FROM productosventa WHERE productosventa.Referencia=facturas_items.Referencia) as idProducto,`Nombre`,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,`SubGrupo4`,`SubGrupo5`,SUM(`Cantidad`) as Cantidad,round(SUM(`TotalItem`),2) as TotalVenta,round(SUM(`SubtotalCosto`),2) as Costo
  FROM `facturas_items` GROUP BY `FechaFactura`,`Referencia`;


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
(SELECT NumeroFactura FROM factura_compra WHERE ID=`idFacturaCompra`) as NumeroFactura,
fc.Tercero as Tercero,(SELECT RazonSocial FROM proveedores WHERE proveedores.Num_Identificacion=fc.Tercero LIMIT 1) as RazonSocial,
sum(`SubtotalCompra`) AS Subtotal, sum(`ImpuestoCompra`) as Impuestos,
(SELECT sum(ValorRetencion) FROM factura_compra_retenciones WHERE idCompra=`idFacturaCompra`) as TotalRetenciones,
sum(`TotalCompra`) as Total, fc.Concepto as Concepto,
(SELECT sum(Subtotal_Servicio) FROM factura_compra_servicios WHERE factura_compra_servicios.idFacturaCompra=fci.`idFacturaCompra`) as SubtotalServicios, 
(SELECT sum(Impuesto_Servicio) FROM factura_compra_servicios WHERE factura_compra_servicios.idFacturaCompra=fci.`idFacturaCompra`) as ImpuestosServicios,
(SELECT sum(Total_Servicio) FROM factura_compra_servicios WHERE factura_compra_servicios.idFacturaCompra=fci.`idFacturaCompra`) as TotalServicios,
(SELECT sum(SubtotalCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idFacturaCompra=fci.`idFacturaCompra`) as SubtotalDevoluciones,
(SELECT sum(ImpuestoCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idFacturaCompra=fci.`idFacturaCompra`) as ImpuestosDevueltos,
(SELECT sum(TotalCompra) FROM factura_compra_items_devoluciones WHERE factura_compra_items_devoluciones.idFacturaCompra=fci.`idFacturaCompra`) as TotalDevolucion,
fc.idUsuario as Usuario
FROM `factura_compra_items` fci INNER JOIN factura_compra fc ON fc.ID=fci.idFacturaCompra GROUP BY `idFacturaCompra`;

DROP VIEW IF EXISTS `vista_diferencia_inventarios`;
CREATE VIEW vista_diferencia_inventarios AS
SELECT idProductosVenta,`Referencia`,`Nombre`,`Existencias` as ExistenciaAnterior,
(SELECT Existencias FROM inventarios_temporal WHERE productosventa.Referencia = inventarios_temporal.Referencia) as ExistenciaActual,
(SELECT ExistenciaActual) - (Existencias) as Diferencia,PrecioVenta,CostoUnitario,
(SELECT Diferencia)*CostoUnitario AS TotalCostosDiferencia,Departamento,Sub1,Sub2,Sub3,Sub4,Sub5
  FROM `productosventa`;

DROP VIEW IF EXISTS `vista_facturacion_detalles`;
CREATE VIEW vista_facturacion_detalles AS
SELECT `ID`,`FechaFactura`,
(SELECT NumeroFactura FROM facturas WHERE idFacturas=`idFactura`) as NumeroFactura,
(SELECT FormaPago FROM facturas WHERE idFacturas=`idFactura`) as TipoFactura, 
`TablaItems`,`Referencia`,`Nombre`,`Departamento`,`SubGrupo1`,`SubGrupo2`,`SubGrupo3`,
`SubGrupo4`,`SubGrupo5`,`ValorUnitarioItem`,`Cantidad`,`SubtotalItem`,`IVAItem`,`TotalItem`,
`PorcentajeIVA`,`PrecioCostoUnitario`,`SubtotalCosto`,CuentaPUC,idUsuarios,idCierre,
(SELECT ObservacionesFact FROM facturas WHERE idFacturas=`idFactura`) as Observaciones 
FROM `facturas_items` ;