<?php 
$obVenta=new ProcesoVenta($idUser);
if(!empty($_REQUEST['del'])){
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre=$_REQUEST['TxtIdPre'];
    $DatosItem=$obVenta->DevuelveValores($Tabla, $IdTabla, $id);
    $obVenta->ActualizaRegistro("librodiario", "Estado", "", "idLibroDiario", $DatosItem["idLibroDiario"]);
    mysql_query("DELETE FROM $Tabla WHERE $IdTabla='$id'") or die(mysql_error());
    header("location:CreaComprobanteCont.php?idComprobante=$IdPre");
}

if(!empty($_REQUEST["BtnCrearConcepto"])){
        
    $NombreConcepto=$obVenta->normalizar($_REQUEST["TxtNombreNuevoConcepto"]);
    $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservacionesNuevoConcepto"]);
   
    $obVenta->CrearConceptoContable($NombreConcepto, $Observaciones,"");
   
    header("location:$myPage");
}


// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnCrearMonto"])){
    
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
    $Nombre=$obVenta->normalizar($_REQUEST["TxtMonto"]);
    $Dependencia=$obVenta->normalizar($_REQUEST["CmbDependencia"]); 
    $Operacion=$obVenta->normalizar($_REQUEST["CmbOperacion"]); 
    $ValorDependencia=$obVenta->normalizar($_REQUEST["TxtValorDependencia"]); 
    
    $obVenta->CrearMontoConcepto($idConcepto,$Nombre, $Dependencia,$Operacion,$ValorDependencia,"");    
    header("location:$myPage?ImprimeCC=$idComprobante");
    
}
///////////////fin
?>