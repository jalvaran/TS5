<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
///////////////////////////////
////////Si se solicita borrar algo
////
////

if(!empty($_REQUEST['del'])){
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre=$_REQUEST['TxtIdPre'];
    mysql_query("DELETE FROM $Tabla WHERE $IdTabla='$id'") or die(mysql_error());
    header("location:FacturaCotizacion.php");
}

/*
 * 
 * Si llega la peticion de crear la factura
 * 
 */

if(!empty($_REQUEST["TxtAsociarCotizacion"])){
    $idCotizacion=$_REQUEST["TxtAsociarCotizacion"];
    $obVenta=new ProcesoVenta($idUser);
    $obVenta->AgregarCotizacionPrefactura($idCotizacion);
    header("location:FacturaCotizacion.php");
}
////Se recibe edicion
	
if(!empty($_REQUEST['BtnEditar'])){

        $idItem=$_REQUEST['TxtIdItemCotizacion'];
        $idCotizacion=$_REQUEST['TxtIdCotizacion'];
        //$Tabla=$_REQUEST['TxtTabla'];
        $Cantidad=$_REQUEST['TxtCantidad'];
        $ValorAcordado=$_REQUEST['TxtValorUnitario'];

        $obVenta=new ProcesoVenta($idUser);
        $DatosPreventa=$obVenta->DevuelveValores('facturas_pre',"ID",$idItem);
        $Subtotal=round($ValorAcordado*$Cantidad);
        $DatosProductos=$obVenta->DevuelveValores($DatosPreventa["TablaItems"],"Referencia",$DatosPreventa["Referencia"]);
        $IVA=round($Subtotal*$DatosProductos["IVA"]);
        $SubtotalCosto=round($DatosProductos["CostoUnitario"]*$Cantidad);
        $Total=$Subtotal+$IVA;
        $filtro="ID";

        $obVenta->ActualizaRegistro("facturas_pre","SubtotalItem", $Subtotal, $filtro, $idItem);
        $obVenta->ActualizaRegistro("facturas_pre","IVAItem", $IVA, $filtro, $idItem);
        $obVenta->ActualizaRegistro("facturas_pre","SubtotalCosto", $SubtotalCosto, $filtro, $idItem);
        $obVenta->ActualizaRegistro("facturas_pre","TotalItem", $Total, $filtro, $idItem);
        $obVenta->ActualizaRegistro("facturas_pre","ValorUnitarioItem", $ValorAcordado, $filtro, $idItem);
        $obVenta->ActualizaRegistro("facturas_pre","Cantidad", $Cantidad, $filtro, $idItem);

        header("location:FacturaCotizacion.php");

}
/*
 * 
 * Si llega la peticion de crear la factura
 * 
 */

if(!empty($_REQUEST["BtnGenerarFactura"])){
        $obVenta=new ProcesoVenta($idUser);
        
        $DatosFactura["CmbCliente"]=$_REQUEST['CmbCliente'];        
        $DatosFactura["CmbCentroCostos"]=$_REQUEST["CmbCentroCostos"];
        $DatosFactura["CmbResolucion"]=$_REQUEST["CmbResolucion"];
        $DatosFactura["CmbFormaPago"]=$_REQUEST["CmbFormaPago"];
        $DatosFactura["CmbCuentaDestino"]=$_REQUEST["CmbCuentaDestino"];
        $DatosFactura["TxtOrdenCompra"]=$_REQUEST["TxtOrdenCompra"];
        $DatosFactura["TxtOrdenSalida"]=$_REQUEST["TxtOrdenSalida"];
        $DatosFactura["TxtObservacionesFactura"]=$_REQUEST["TxtObservacionesFactura"];
        $DatosFactura["TxtFechaFactura"]=$_REQUEST["TxtFechaFactura"];
        $DatosFactura["TxtNumeroFactura"]=$_REQUEST["TxtNumeroFactura"];
        
        
        
        $ID=$obVenta->CrearFacturaDesdePrefactura($DatosFactura);
        $obVenta->BorraReg("facturas_pre", "idUsuarios", $idUser);
        
        header("location:FacturaCotizacion.php?TxtidFactura=$ID");
        
    }
?>