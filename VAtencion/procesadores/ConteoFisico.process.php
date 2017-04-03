<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["TxtCodigoBarras"])){
    $obVenta=new ProcesoVenta($idUser);        
    $Codigo=$obVenta->normalizar($_REQUEST["TxtCodigoBarras"]);
    $Cantidad=$obVenta->normalizar($_REQUEST["TxtCantidad"]);
    $Respuesta=$obVenta->RegistrarConteoFisicoInventario($Codigo,$Cantidad,"");
    header("location:productosventa.php?idProducto=$idProducto");
        
}
?>