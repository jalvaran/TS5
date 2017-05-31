<?php 
$obSistema=new Sistema($idUser);
if(!empty($_REQUEST['del'])){
    $id=$obSistema->normalizar($_REQUEST['del']);
    $idSistema=$obSistema->normalizar($_REQUEST['idSistema']);
    $obSistema->BorraReg("sistemas_relaciones", "ID", $id);
    header("location:$myPage?idSistema=$idSistema");
}

if(!empty($_REQUEST["BtnCrearSistema"])){
       
    $Nombre=$obSistema->normalizar($_REQUEST["TxtNombre"]);
    $PrecioVenta=$obSistema->normalizar($_REQUEST["TxtPrecioVenta"]);
    $PrecioMayorista=$obSistema->normalizar($_REQUEST["TxtPrecioMayor"]);
    $Observaciones=$obSistema->normalizar($_REQUEST["TxtObservaciones"]);
    $idSistema=$obSistema->CrearSistema($Nombre, $PrecioVenta, $PrecioMayorista, $Observaciones, "");
    header("location:$myPage?idSistema=$idSistema");
}

		
if(!empty($_REQUEST["BtnAgregarItem"])){
           
    $idSistema=$obSistema->normalizar($_REQUEST["idSistema"]);
    $Cantidad=$obSistema->normalizar($_REQUEST["TxtCantidad"]);
    $idItem=$obSistema->normalizar($_REQUEST["idProducto"]);
    $TipoItem=$obSistema->normalizar($_REQUEST["TipoItem"]);
    $obSistema->AgregarItemSistema($TipoItem,$idSistema,$Cantidad,$idItem,"");
    header("location:$myPage?idSistema=$idSistema");
}
// si se requiere editar una cantidad
if(!empty($_REQUEST["BtnEditarCantidad"])){
    
    $idSistema=$obSistema->normalizar($_REQUEST["idSistema"]);
    $idItem=$obSistema->normalizar($_REQUEST["idItem"]);
    $Cantidad=$obSistema->normalizar($_REQUEST["TxtCantidadEdit"]);
    $obSistema->ActualizaRegistro("sistemas_relaciones", "Cantidad", $Cantidad, "ID", $idItem);
    header("location:$myPage?idSistema=$idSistema");
    
}
// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnGuardar"])){
    
    $idComprobante=$_REQUEST["TxtIdComprobante"];
    $obVenta->GuardarTrasladoMercancia($idComprobante);
        
    header("location:$myPage?ImprimeCC=$idComprobante");
    
}
///////////////fin
?>