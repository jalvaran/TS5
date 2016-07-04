<?php

$myTabla="facturas";
$MyID="idFacturas";
$myPage="facturas.php";
$myTitulo="Facturas";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar

/*
 * Opciones en Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1; 

//Link para la accion ver
$Ruta="../tcpdf/examples/imprimirFactura.php?ImgPrintFactura=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="idFacturas";
/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */

// Nueva Accion
$Ruta="AnularFactura.php?idFactura=";
$Vector["NuevaAccionLink"][0]="AsociarCoti";
$Vector["NuevaAccion"]["AsociarCoti"]["Titulo"]="Anular Factura";
$Vector["NuevaAccion"]["AsociarCoti"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["AsociarCoti"]["ColumnaLink"]="idFacturas";
$Vector["NuevaAccion"]["AsociarCoti"]["Target"]="_self";

$Vector["CentroCosto"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["CentroCosto"]["TablaVinculo"]="centrocosto";  //tabla de donde se vincula
$Vector["CentroCosto"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["CentroCosto"]["Display"]="Nombre"; 
$Vector["CentroCosto"]["Predeterminado"]=1;

$Vector["EmpresaPro_idEmpresaPro"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["EmpresaPro_idEmpresaPro"]["TablaVinculo"]="empresapro";  //tabla de donde se vincula
$Vector["EmpresaPro_idEmpresaPro"]["IDTabla"]="idEmpresaPro"; //id de la tabla que se vincula
$Vector["EmpresaPro_idEmpresaPro"]["Display"]="RazonSocial"; 
$Vector["EmpresaPro_idEmpresaPro"]["Predeterminado"]=1;

$Vector["Clientes_idClientes"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Clientes_idClientes"]["TablaVinculo"]="clientes";  //tabla de donde se vincula
$Vector["Clientes_idClientes"]["IDTabla"]="idClientes"; //id de la tabla que se vincula
$Vector["Clientes_idClientes"]["Display"]="RazonSocial"; 
$Vector["Clientes_idClientes"]["Predeterminado"]=1;
///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>