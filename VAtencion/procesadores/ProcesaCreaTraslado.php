<?php 
if(!empty($_REQUEST['del'])){
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre= $_REQUEST['TxtIdPre'];
    $DatosItem=$obVenta->DevuelveValores($Tabla, $IdTabla, $id);
    $obVenta->ActualizaRegistro("librodiario", "Estado", "", "idLibroDiario", $DatosItem["idLibroDiario"]);
    mysql_query("DELETE FROM $Tabla WHERE $IdTabla='$id'") or die(mysql_error());
    
    header("location:$MyPage?CmbTrasladoID=$IdPre");
}

if(!empty($_REQUEST["BtnCrearTraslado"])){
    
    $obVenta=new ProcesoVenta($idUser);
    
    $fecha=$_REQUEST["TxtFecha"];
    $hora=$_REQUEST["TxtHora"];
    $Concepto=$_REQUEST["TxtDescripcion"];
    $Destino=$_REQUEST["CmbDestino"];
    $VectorTraslado["Fut"]=0;
    $idComprobante=CrearTraslado($fecha,$hora,$Concepto,$Destino);
        
    //$obVenta->CerrarCon();
    header("location:$myPage");
}

		
if(!empty($_REQUEST["BtnAgregarItem"])){
    
   
    $obVenta=new ProcesoVenta($idUser);
        
    $idComprobante=$_REQUEST["TxtIdCC"];
    $Cantidad=$_REQUEST["TxtCantidad"];
    
    $idProducto=$_REQUEST["CmbProducto"];
    $VectorItem["Fut"]=0;
    $obVenta->AgregarItemTraslado($idComprobante,$idProducto,$Cantidad,$VectorItem);
    
    //header("location:$myPage?idComprobante=$idComprobante");
}

// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnGuardarMovimiento"])){
    
    $idComprobante=$_REQUEST["TxtIdComprobanteContable"];    
    $obVenta->RegistreComprobanteContable($idComprobante);    
    header("location:$myPage?ImprimeCC=$idComprobante");
    
}
///////////////fin
?>