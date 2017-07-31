<?php

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
//$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");
include_once("../../modelo/php_tablas.php");
include_once("../css_construct.php");

$css =  new CssIni("id");
$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);
$myPage=$obVenta->normalizar($_REQUEST['myPage']);
$idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
$obTabla->DibujaSeparado($myPage,$idPreventa,"");
$obTabla->DibujaCredito($myPage,$idPreventa,"");
//$key=$obVenta->normalizar($_REQUEST['key']);


?>