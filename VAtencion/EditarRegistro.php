<?php
//ob_start();
/* Desarrollado por Julian Alvaran, Techno Soluciones SAS
 * Este archivo se encargará de insertar un registro nuevo a una tabla
 * 
 */
$Parametros = json_decode(urldecode($_REQUEST['TxtParametros']));  //Decodifico el Vector y llega como un objeto
$IDEdit=$_GET['TxtIdEdit'];
$VarEdit["ID"]=$IDEdit;
//print("Parametros: ");
//print_r($Parametros);
$TablaEdit=$Parametros->Tabla;
$myPage="EditarRegistro.php";
$myTitulo="Editar Registro En ".$Parametros->Titulo;

//Con esto visualizo los parametros recibidos
/* 
echo ("<pre>");
print_r($Parametros);
echo ("</pre>");
*/
include_once("../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
include_once("css_construct.php");
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta(1);
include_once("procesadores/procesaEdicion.Conf.php"); //Procesa la insercion
include_once("procesadores/procesaEdicion.php"); //Procesa la insercion
print("<html>");
print("<head>");

$css =  new CssIni($myTitulo);
print("</head>");
print("<body>");
//Cabecera
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina
$css->CabeceraFin(); 

///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);
//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////
$MyPage="$Parametros->Tabla.php";
if(isset($VarEdit[$Parametros->Tabla]["MyPage"])){
    $MyPage=$VarEdit[$Parametros->Tabla]["MyPage"];
}
$css->CrearImageLink($MyPage, "../images/volver.png", "_self",133,200);
$obTabla->FormularioEditarRegistro($Parametros,$VarEdit);

$css->CerrarDiv();//Cerramos contenedor Principal

$css->AgregaJS(); //Agregamos javascripts
$css->AgregaSubir();    
////Fin HTML  
///Verifico si hay peticiones para exportar
///
///

print("</body></html>");
//ob_end_flush();
?>