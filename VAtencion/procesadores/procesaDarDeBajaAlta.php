<?php

/* 
 * Este archivo procesa la anulacion de una factura
 */

if(!empty($_REQUEST["BtnBaja"])){
$obVenta=new ProcesoVenta($idUser);        
$RefProducto=$_REQUEST["CmbProducto"];
$fecha=$_REQUEST["TxtFecha"];
$Observaciones=$_REQUEST["TxtConcepto"];
$Cantidad=$_REQUEST["TxtCantidad"];
$VectorBA["f"]="";
$idBaja=$obVenta->DarDeBajaAltaProducto("BAJA",$fecha, $Observaciones,$RefProducto,$Cantidad,$VectorBA);

header("location:$myPage?TxtidComprobante=$idBaja");
        
    }
?>