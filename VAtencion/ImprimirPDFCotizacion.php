<?php 
$myPage="ImprimirPDFCotizacion.php";
include_once("../sesiones/php_control.php");


if(isset($_REQUEST["ImgPrintCoti"])){
    $obVenta = new ProcesoVenta($idUser);
    $obTabla = new Tabla($db);
    $idCotizacion=$obVenta->normalizar($_REQUEST["ImgPrintCoti"]);
    $obTabla->PDF_Cotizacion($idCotizacion, "");
}
?>