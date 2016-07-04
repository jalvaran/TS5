<?php
/*
 * Parametros de configuracion productosventa
 * Columnas Excluidas
 */
$TablaConfig="productosventa";
$VarEdit[$TablaConfig]["CodigoBarras"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Existencias"]["Excluir"]=1;
//$VarEdit[$TablaConfig]["Referencia"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Especial"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Kit"]["Excluir"]=1;
$VarEdit[$TablaConfig]["ImagenesProductos_idImagenesProductos"]["Excluir"]=1;


/*
 * Parametros de configuracion Tabla facturas_items
 * Columnas Excluidas
 */

$TablaConfig="facturas_items";
$VarEdit[$TablaConfig]["SubGrupo1"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubGrupo2"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubGrupo3"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubGrupo4"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubGrupo5"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubtotalItem"]["Excluir"]=1;
$VarEdit[$TablaConfig]["IVAItem"]["Excluir"]=1;
$VarEdit[$TablaConfig]["TotalItem"]["Excluir"]=1;
$VarEdit[$TablaConfig]["PorcentajeIVA"]["Excluir"]=1;
$VarEdit[$TablaConfig]["PrecioCostoUnitario"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubtotalCosto"]["Excluir"]=1;
$VarEdit[$TablaConfig]["TipoItem"]["Excluir"]=1;
$VarEdit[$TablaConfig]["CuentaPUC"]["Excluir"]=1;
$VarEdit[$TablaConfig]["GeneradoDesde"]["Excluir"]=1;
$VarEdit[$TablaConfig]["NumeroIdentificador"]["Excluir"]=1;
$VarEdit[$TablaConfig]["FechaFactura"]["Excluir"]=1;
$VarEdit[$TablaConfig]["idFactura"]["Excluir"]=1;
$VarEdit[$TablaConfig]["TablaItems"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Referencia"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Departamento"]["Excluir"]=1;
$VarEdit[$TablaConfig]["ValorUnitarioItem"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Cantidad"]["Excluir"]=1;

/*
 * Campos Requridos
 */

$VarEdit[$TablaConfig]["Dias"]["Required"]=1;

/*
 * Tabla Usuarios
 * Tipo de Texto
 */
$TablaConfig="usuarios";
$VarEdit[$TablaConfig]["Password"]["TipoText"]="password";


/*
 * Tabla librodiario
 * 
 * Campos Requridos
 */
$TablaConfig="librodiario";
$VarEdit[$TablaConfig]["idEmpresa"]["Required"]=1;
$VarEdit[$TablaConfig]["idCentroCosto"]["Required"]=1;


/*
 * Parametros de configuracion subcuentas
 * Columnas Excluidas
 */
$TablaConfig="subcuentas";
$VarEdit[$TablaConfig]["Valor"]["Excluir"]=1;

/*
 * Parametros de configuracion subcuentas
 * CAmpos requeridos y Columnas Excluidas
 */
$TablaConfig="cuentasfrecuentes";
$VarEdit[$TablaConfig]["ClaseCuenta"]["Required"]=1;
$VarEdit[$TablaConfig]["UsoFuturo"]["Excluir"]=1;

/*
 * Tabla cot_itemscotizaciones
 * 
 * Campos Requridos
 */
$TablaConfig="cot_itemscotizaciones";
$VarEdit[$TablaConfig]["CuentaPUC"]["Required"]=1;

/*
 * Tabla remisiones
 * 
 * Campos Requeridos
 */
$TablaConfig="remisiones";
$VarEdit[$TablaConfig]["Usuarios_idUsuarios"]["Required"]=1;
$VarEdit[$TablaConfig]["MyPage"]="historialremisiones.php";
$VarEdit[$TablaConfig]["Cotizaciones_idCotizaciones"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Anticipo"]["Excluir"]=1;


/*
 * Tabla ordenesdetrabajo
 * Tipo de ordenesdetrabajo
 * Campos Requridos
 */
$TablaConfig="ordenesdetrabajo";
$VarEdit[$TablaConfig]["Hora"]["Required"]=1;
$VarEdit[$TablaConfig]["idCliente"]["Required"]=1;
$VarEdit[$TablaConfig]["idUsuarioCreador"]["Required"]=1;
$VarEdit[$TablaConfig]["Descripcion"]["Required"]=1;
$VarEdit[$TablaConfig]["FechaOT"]["Required"]=1;
$VarEdit[$TablaConfig]["Estado"]["Excluir"]=1;

/*
 * Tabla cotizacionesv5
 * 
 * 
 */
$TablaConfig="cotizacionesv5";
$VarEdit[$TablaConfig]["Seguimiento"]["Required"]=1;
$VarEdit[$TablaConfig]["NumSolicitud"]["Excluir"]=1;
$VarEdit[$TablaConfig]["NumOrden"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Usuarios_idUsuarios"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Fecha"]["Excluir"]=1;

/*
 * Tabla ordenes de compra
 * 
 * 
 */
$TablaConfig="ordenesdecompra";

$VarEdit[$TablaConfig]["Created"]["Excluir"]=1;
$VarEdit[$TablaConfig]["UsuarioCreador"]["Excluir"]=1;

/*
 * Parametros de configuracion cartera
 * Columnas Excluidas
 */
$TablaConfig="cartera";
$VarEdit[$TablaConfig]["Facturas_idFacturas"]["Excluir"]=1;
$VarEdit[$TablaConfig]["FechaIngreso"]["Excluir"]=1;
$VarEdit[$TablaConfig]["FechaVencimiento"]["Excluir"]=1;
$VarEdit[$TablaConfig]["DiasCartera"]["Excluir"]=1;
$VarEdit[$TablaConfig]["idCliente"]["Excluir"]=1;
$VarEdit[$TablaConfig]["RazonSocial"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Telefono"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Contacto"]["Excluir"]=1;
$VarEdit[$TablaConfig]["TelContacto"]["Excluir"]=1;
$VarEdit[$TablaConfig]["TotalFactura"]["Excluir"]=1;
$VarEdit[$TablaConfig]["TotalAbonos"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Saldo"]["Excluir"]=1;
?>