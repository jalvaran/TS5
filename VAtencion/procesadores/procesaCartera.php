<?php 

        /*
         * Registra abonos de creditos 
         */
        
              
        if(!empty($_REQUEST['TxtIdCartera'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            $idCartera=$_REQUEST['TxtIdCartera'];
            $idFactura=$_REQUEST['TxtIdFactura'];
            $CuentaDestino=$_REQUEST['CmbCuentaDestino'];
            $Valor=$_REQUEST["TxtAbonoCredito$idCartera"];
            $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
            
            $CentroCosto=$DatosFactura["CentroCosto"];
            $Concepto="ABONO A FACTURA No $DatosFactura[Prefijo] - $DatosFactura[NumeroFactura]";
            $VectorIngreso["fut"]="";
            $idComprobanteAbono=$obVenta->RegistreAbonoCarteraCliente($fecha,$Hora,$CuentaDestino,$idFactura,$Valor,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
            $DatosComprobanteAbono=$obVenta->DevuelveValores("facturas_abonos", "ID", $idComprobanteAbono);
            $idComprobanteIngreso=$DatosComprobanteAbono["idComprobanteIngreso"];
            header("location:$myPage?TxtidIngreso=$idComprobanteIngreso");
        }
        
        ///////////////Fin
        
	?>