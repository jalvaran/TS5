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
    $idSistema=$obSistema->CrearSistema($Nombre, $PrecioVenta, $PrecioMayorista, $Observaciones,$idUser, "");
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
    $obSistema->ActualizaRegistro("sistemas_relaciones", "Cantidad", $Cantidad, "ID", $idItem,0);
    header("location:$myPage?idSistema=$idSistema");
    
}
// si se requiere editar una cantidad
if(!empty($_REQUEST["BtnEditarPrecioVenta"])){
    
    $idSistema=$obSistema->normalizar($_REQUEST["idSistema"]);
    $TotalSistema=$obSistema->normalizar($_REQUEST["TxtValorSistema"]);
    $PrecioMayorista=$obSistema->normalizar($_REQUEST["TxtPrecioMayor"]);
    $Observaciones=$obSistema->normalizar($_REQUEST["TxtObservaciones"]);
    $obSistema->ActualizaRegistro("sistemas", "PrecioVenta", $TotalSistema, "ID", $idSistema,0);
    $obSistema->ActualizaRegistro("sistemas", "PrecioMayorista", $PrecioMayorista, "ID", $idSistema,0);
    $obSistema->ActualizaRegistro("sistemas", "Observaciones", $Observaciones, "ID", $idSistema,0);
    header("location:$myPage?idSistema=$idSistema");
    
}
// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnGuardar"])){
    
    $idSistema=$obSistema->normalizar($_REQUEST["idSistema"]);
    $obSistema->ActualizaRegistro("sistemas", "Estado", "CERRADO", "ID", $idSistema);
        
    header("location:$myPage");
    
}
///////////////fin
?>