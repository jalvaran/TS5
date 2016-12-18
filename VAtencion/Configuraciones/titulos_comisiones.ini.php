<?php

$myTabla="titulos_comisiones";
$myPage="titulos_comisiones.php";
$myTitulo="Comisiones X Pagar";
$idTabla="ID";


/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
/*
 * Deshabilito Acciones
 * 
 */
          
//$Vector["VerRegistro"]["Deshabilitado"]=1;       
$Vector["NuevoRegistro"]["Deshabilitado"]=1;                                 
$Vector["EditarRegistro"]["Deshabilitado"]=1;

//Link para la accion ver
$Ruta="../tcpdf/examples/imprimircomp.php?ImgPrintComp=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="idEgreso";
//Selecciono las Columnas que tendran valores de otras tablas
//
//


///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>