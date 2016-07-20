<?php

$myTabla="config_tiketes_promocion";
$idTabla="ID";
$myPage="config_tiketes_promocion.php";
$myTitulo="Configurar Tiketes de Promocion";



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

$Vector["NuevoRegistro"]["Deshabilitado"]=1;          
$Vector["VerRegistro"]["Deshabilitado"]=1; 
///Columnas excluidas

$Vector["Multiple"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Multiple"]["TablaVinculo"]="respuestas_condicional";  //tabla de donde se vincula
$Vector["Multiple"]["IDTabla"]="Valor"; //id de la tabla que se vincula
$Vector["Multiple"]["Display"]="Valor"; 

$Vector["Activo"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Activo"]["TablaVinculo"]="respuestas_condicional";  //tabla de donde se vincula
$Vector["Activo"]["IDTabla"]="Valor"; //id de la tabla que se vincula
$Vector["Activo"]["Display"]="Valor"; 
///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>