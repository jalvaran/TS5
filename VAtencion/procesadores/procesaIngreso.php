<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!empty($_REQUEST["BtnGuardarPago"])){
        include_once("../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
    
        $obTabla = new Tabla($db);
        $obVenta = new ProcesoVenta(1);
        
        $idFactura=$_REQUEST['TxtIdFactura'];
        $fecha=$_REQUEST['TxtFecha'];
        $ReteFuente=$_REQUEST["TxtRetefuente"];
        $CuentaDestino=$_REQUEST["CmbCuentaDestino"];
        $ReteICA=$_REQUEST["TxtReteICA"];
        $ReteIVA=$_REQUEST["TxtReteIVA"];
        $Pago=$_REQUEST["TxtPagoH"];
        
        $DatosFactura=$obVenta->DevuelveValores("facturas","idFacturas",$idFactura);
        $idIngreso=$obVenta->RegistrePagoFactura($idFactura, $fecha, $Pago, $CuentaDestino, $ReteFuente, $ReteIVA, $ReteICA, $idUser, $DatosFactura);
        $obVenta->BorraReg("cartera", "Facturas_idFacturas", $idFactura);
        header("location:RegistrarIngreso.php?TxtidIngreso=$idIngreso");
        
    }
?>