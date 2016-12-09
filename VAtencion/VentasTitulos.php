<?php 
$myPage="VentasTitulos.php";
include_once("../sesiones/php_control.php");

include_once("css_construct.php");

$css =  new CssIni("TS5 Venta de Titulos");
$obVenta =  new ProcesoVenta($idUser);  
$css->CabeceraIni("TS5 Venta de Titulos"); 
    
$css->CreaBotonDesplegable("DialCliente","Tercero");

$css->CabeceraFin();

$obTabla = new Tabla($db);


include_once("procesadores/procesaVentasTitulos.php");
include_once 'CuadroDialogoCrearCliente.php';

$css->CrearDiv("Principal", "container", "center", 1, 1);

//////Espacio para verificar si un titulo ya esta vendido       

$obTabla->DibujeVerificacionTitulo($myPage, "");

$obTabla->DibujeAreaVentasTitulos($myPage, "");

$css->CerrarDiv();
$css->AgregaJS(); //Agregamos javascripts
$css->AnchoElemento("CmbCodMunicipio_chosen", 200);

$css->AgregaSubir();
$css->Footer();

ob_end_flush();
?>