<?php 
$obSistema=new Sistema($idUser);
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

if(!empty($_REQUEST["BtnCrearSistema"])){
       
    $Nombre=$obSistema->normalizar($_REQUEST["TxtNombre"]);
    $PrecioVenta=$obSistema->normalizar($_REQUEST["TxtPrecioVenta"]);
    $PrecioMayorista=$obSistema->normalizar($_REQUEST["TxtPrecioMayor"]);
    $Observaciones=$obSistema->normalizar($_REQUEST["TxtObservaciones"]);
    
    $idSistema=$obSistema->CrearSistema($Nombre, $PrecioVenta, $PrecioMayorista, $Observaciones, "");
        
    //$obVenta->CerrarCon();
    header("location:$myPage?idSistema=$idSistema");
}

		
if(!empty($_REQUEST["BtnAgregarItem"])){
    
   
    $obVenta=new ProcesoVenta($idUser);
        
    $idComprobante=$_REQUEST["TxtidPre"];
    $Cantidad=$_REQUEST["TxtCantidad"];
    
    $idProducto=$_REQUEST["TxtIdItem"];
    $VectorItem["Fut"]=0;
    $obVenta->AgregarItemTraslado($idComprobante,$idProducto,$Cantidad,$VectorItem);
    
    //header("location:$myPage?idComprobante=$idComprobante");
}

// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnGuardar"])){
    
    $idComprobante=$_REQUEST["TxtIdComprobante"];
    $obVenta->GuardarTrasladoMercancia($idComprobante);
        
    header("location:$myPage?ImprimeCC=$idComprobante");
    
}
///////////////fin
?>