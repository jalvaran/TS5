<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["BtnCortarPV"])){
    $obVenta=new ProcesoVenta($idUser);        
    $idDepartamento=$obVenta->normalizar($_REQUEST["idDepartamento"]);
    $Sub1=$obVenta->normalizar($_REQUEST["Sub1"]);
    $Sub2=$obVenta->normalizar($_REQUEST["Sub2"]);
    $Sub3=$obVenta->normalizar($_REQUEST["Sub3"]);
    $Sub4=$obVenta->normalizar($_REQUEST["Sub4"]);
    $Sub5=$obVenta->normalizar($_REQUEST["Sub5"]);
    if($idDepartamento>0){
        $obVenta->CortarProductosVentaInventarioTemporal($idDepartamento,$Sub1,$Sub2,$Sub3,$Sub4,$Sub5,"");
    }
    header("location:inventario_preparacion.php");
        
}
?>