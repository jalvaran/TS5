<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */

if(!empty($_REQUEST["BtnCrearPV"])){
    $obVenta=new ProcesoVenta($idUser);        
    $idDepartamento=$obVenta->normalizar($_REQUEST["idDepartamento"]);
    $Sub1=$obVenta->normalizar($_REQUEST["Sub1"]);
    $Sub2=$obVenta->normalizar($_REQUEST["Sub2"]);
    $Sub3=$obVenta->normalizar($_REQUEST["Sub3"]);
    $Sub4=$obVenta->normalizar($_REQUEST["Sub4"]);
    $Sub5=$obVenta->normalizar($_REQUEST["Sub5"]);
    $Nombre=$obVenta->normalizar($_REQUEST["TxtNombre"]);
    $Existencias=$obVenta->normalizar($_REQUEST["TxtExistencias"]);
    $PrecioVenta=$obVenta->normalizar($_REQUEST["TxtPrecioVenta"]);
    $CostoUnitario=$obVenta->normalizar($_REQUEST["TxtCostoUnitario"]);
    $IVA=$obVenta->normalizar($_REQUEST["CmbIVA"]);
    $CuentaPUC=$obVenta->normalizar($_REQUEST["TxtCuentaPUC"]);
    $PrecioMayor=$obVenta->normalizar($_REQUEST["TxtPrecioMayorista"]);
    $Referencia="";
    $CodigoBarras="";
    //print($PrecioMayor." sub5= ".$Sub5);
    //print_r($_REQUEST["Sub5"]);
   
    if(isset($_REQUEST["TxtReferencia"])){
        $Referencia=$obVenta->normalizar($_REQUEST["TxtReferencia"]);
        $Referencia=$obVenta->QuitarAcentos($Referencia);
    }
    if(isset($_REQUEST["TxtCodigoBarras"])){
        $CodigoBarras=$obVenta->normalizar($_REQUEST["TxtCodigoBarras"]);
        $Referencia=$obVenta->QuitarAcentos($Referencia);
    }
     
    $idProducto=$obVenta->CrearProductoVenta($Nombre,$CodigoBarras,$Referencia,$PrecioVenta,$PrecioMayor,$Existencias,$CostoUnitario,$IVA,$idDepartamento,$Sub1,$Sub2,$Sub3,$Sub4,$Sub5,$CuentaPUC,"");
    header("location:productosventa.php?idProducto=$idProducto");
    
    
    
}
?>