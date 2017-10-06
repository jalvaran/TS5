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
    $Error=$obVenta->AgregarCotizacionPrefactura($idCotizacion);
    if(is_array($Error)){
        foreach ($Error as $Productos){
            $css->CrearNotificacionRoja("El producto con el id $Productos no tiene existencias, no se puede realizar la factura",16);
        }
        $obVenta->VaciarTabla("facturas_pre");
    }
    //header("location:FacturaCotizacion.php");
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
        
        $DatosFactura["CmbCliente"]=$obVenta->normalizar($_REQUEST['CmbCliente']);        
        $DatosFactura["CmbCentroCostos"]=$obVenta->normalizar($_REQUEST["CmbCentroCostos"]);
        $DatosFactura["CmbResolucion"]=$obVenta->normalizar($_REQUEST["CmbResolucion"]);
        $DatosFactura["CmbFormaPago"]=$obVenta->normalizar($_REQUEST["CmbFormaPago"]);
        $DatosFactura["CmbCuentaDestino"]=$obVenta->normalizar($_REQUEST["CmbCuentaDestino"]);
        $DatosFactura["TxtOrdenCompra"]=$obVenta->normalizar($_REQUEST["TxtOrdenCompra"]);
        $DatosFactura["TxtOrdenSalida"]=$obVenta->normalizar($_REQUEST["TxtOrdenSalida"]);
        $DatosFactura["TxtObservacionesFactura"]=$obVenta->normalizar($_REQUEST["TxtObservacionesFactura"]);
        $DatosFactura["TxtFechaFactura"]=$obVenta->normalizar($_REQUEST["TxtFechaFactura"]);
        $DatosFactura["TxtNumeroFactura"]=$obVenta->normalizar($_REQUEST["TxtNumeroFactura"]);
        $DatosFactura["CmbColaborador"]=$obVenta->normalizar($_REQUEST["CmbColaborador"]);
        
        
        $ID=$obVenta->CrearFacturaDesdePrefactura($DatosFactura);
        $obVenta->BorraReg("facturas_pre", "idUsuarios", $idUser);
        
        header("location:FacturaCotizacion.php?TxtidFactura=$ID");
        
    }
    
?>