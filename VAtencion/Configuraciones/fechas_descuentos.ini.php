<?php

$myTabla="fechas_descuentos";
$idTabla="idFechaDescuentos";
$myPage="fechas_descuentos.php";
$myTitulo="Fechas de Descuentos";



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
        
$Vector["VerRegistro"]["Deshabilitado"]=1; 
//Selecciono las Columnas que tendran valores de otras tablas

$Vector["Excluir"]["Usuarios_idUsuarios"]=1;

///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>