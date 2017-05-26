<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Compra extends ProcesoVenta{
    public function CrearCompra($Fecha, $idTercero, $Observaciones,$CentroCostos, $idSucursal, $idUser,$TipoCompra,$NumeroFactura,$Concepto,$Vector ) {
        
        //////Creo la compra            
        $tab="factura_compra";
        $NumRegistros=11;

        $Columnas[0]="Fecha";		$Valores[0]=$Fecha;
        $Columnas[1]="Tercero";         $Valores[1]=$idTercero;
        $Columnas[2]="Observaciones";   $Valores[2]=$Observaciones;
        $Columnas[3]="Estado";		$Valores[3]="ABIERTA";
        $Columnas[4]="idUsuario";	$Valores[4]=$idUser;
        $Columnas[5]="idCentroCostos";	$Valores[5]=$CentroCostos;
        $Columnas[6]="idSucursal";	$Valores[6]=$idSucursal;
        $Columnas[7]="TipoCompra";	$Valores[7]=$TipoCompra;
        $Columnas[8]="NumeroFactura";	$Valores[8]=$NumeroFactura;
        $Columnas[9]="Soporte";         $Valores[9]="";
        $Columnas[10]="Concepto";        $Valores[10]=$Concepto;
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        $idCompra=$this->ObtenerMAX($tab,"ID", 1,"");
        
        //Miro si se recibe un archivo
        //
        if(!empty($_FILES['foto']['name'])){
            //echo "<script>alert ('entra foto')</script>";
            $Atras="../";
            $carpeta="SoportesCompras/";
            opendir($Atras.$carpeta);
            $Name=$idCompra."_".str_replace(' ','_',$_FILES['foto']['name']);
            $destino=$carpeta.$Name;
            move_uploaded_file($_FILES['foto']['tmp_name'],$Atras.$destino);
	}
        $this->ActualizaRegistro("factura_compra", "Soporte", $destino, "ID", $idCompra);
        return $idCompra;
    }
    
    //Clase para agregar un item a una compra
    public function AgregueProductoCompra($idCompra,$idProducto,$Cantidad,$CostoUnitario,$TipoIVA,$IVAIncluido,$Vector) {
        //Proceso la informacion
        if($IVAIncluido=="SI"){
            if(is_numeric($TipoIVA)){
                $CostoUnitario=round($CostoUnitario/(1+$TipoIVA));
            }            
        }
        $Subtotal= round($CostoUnitario*$Cantidad);
        if(is_numeric($TipoIVA)){
            $Impuestos=round($Subtotal*$TipoIVA);
        }else{
            $Impuestos=0;
        }
        $Total=$Subtotal+$Impuestos;
        //////Agrego el registro           
        $tab="factura_compra_items";
        $NumRegistros=8;

        $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
        $Columnas[1]="idProducto";          $Valores[1]=$idProducto;
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$CostoUnitario;
        $Columnas[4]="SubtotalCompra";      $Valores[4]=$Subtotal;
        $Columnas[5]="ImpuestoCompra";      $Valores[5]=$Impuestos;
        $Columnas[6]="TotalCompra";         $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Clase para agregar un item a una compra
    public function AgregueRetencionCompra($idCompra,$Cuenta,$Valor,$Porcentaje,$Vector) {
        //Proceso la informacion
        $DatosCuentas= $this->DevuelveValores("subcuentas", "PUC", $Cuenta);
        //////Agrego el registro           
        $tab="factura_compra_retenciones";
        $NumRegistros=5;

        $Columnas[0]="idCompra";            $Valores[0]=$idCompra;
        $Columnas[1]="CuentaPUC";           $Valores[1]=$Cuenta;
        $Columnas[2]="NombreCuenta";        $Valores[2]=$DatosCuentas["Nombre"];
        $Columnas[3]="ValorRetencion";      $Valores[3]=$Valor;
        $Columnas[4]="PorcentajeRetenido";  $Valores[4]=$Porcentaje;       
                            
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Guarde una Compra
    public function GuardarFacturaCompra($idCompra,$TipoPago,$CuentaOrigen,$Vector) {
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        $TotalInventarios= $this->Sume("factura_compra_items", "SubtotalCompra", "WHERE idFacturaCompra='$idCompra'");
        $IVA= $this->Sume("factura_compra_items", "ImpuestoCompra", "WHERE idFacturaCompra='$idCompra'");
        $TotalCompra= $this->Sume("factura_compra_items", "TotalCompra", "WHERE idFacturaCompra='$idCompra'");
        $TotalRetenciones= $this->Sume("factura_compra_retenciones", "ValorRetencion", "WHERE idCompra='$idCompra'");
        $TotalCompra=$TotalCompra-$TotalRetenciones;
        
        $ParametrosContables=$this->DevuelveValores("parametros_contables", "ID", 4);
        $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $ParametrosContables["CuentaPUC"], $ParametrosContables["NombreCuenta"], "Compras", "DB", $TotalInventarios, $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
        $sql="SELECT SUM(`ImpuestoCompra`) AS IVA, `Tipo_Impuesto` AS TipoImpuesto FROM `factura_compra_items` WHERE `idFacturaCompra`='$idCompra' GROUP BY `Tipo_Impuesto` ";
        $consulta= $this->Query($sql);
        while($DatosImpuestos= $this->FetchArray($consulta)){
            $DatosTipoIVA= $this->DevuelveValores("porcentajes_iva", "Valor", $DatosImpuestos["TipoImpuesto"]);
            if($DatosImpuestos["IVA"]>0){
                $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosTipoIVA["CuentaPUC"], $DatosTipoIVA["NombreCuenta"], "Compras", "DB", $DatosImpuestos["IVA"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            }
        }
        $sql="SELECT SUM(`ValorRetencion`) AS Retencion, `CuentaPUC` AS CuentaPUC,`NombreCuenta` AS NombreCuenta FROM `factura_compra_retenciones` WHERE `idCompra`='$idCompra' GROUP BY `CuentaPUC` ";
        $consulta= $this->Query($sql);
        while($DatosRetencion= $this->FetchArray($consulta)){
            
            $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosRetencion["CuentaPUC"], $DatosRetencion["NombreCuenta"], "Compras", "CR", $DatosRetencion["Retencion"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            
        }
        if($TipoPago=="Credito"){
            $ParametrosContables=$this->DevuelveValores("parametros_contables", "ID", 14);
            $CuentaDestino=$ParametrosContables["CuentaPUC"];
            $NombreCuenta=$ParametrosContables["NombreCuenta"];
        }else{
            $DatosSubcuentas= $this->DevuelveValores("subcuentas", "PUC", $CuentaOrigen);
            $CuentaDestino=$CuentaOrigen;
            $NombreCuenta=$DatosSubcuentas["Nombre"];
        }
        $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $CuentaDestino, $NombreCuenta, "Compras", "CR", $TotalCompra, $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
        
        $consulta= $this->ConsultarTabla("factura_compra_items", "WHERE idFacturaCompra='$idCompra'");
        while($DatosProductos= $this->FetchArray($consulta)){
            $DatosProductoGeneral= $this->DevuelveValores("productosventa", "idProductosVenta", $DatosProductos["idProducto"]);
            $DatosKardex["Cantidad"]=$DatosProductos["Cantidad"];
            $DatosKardex["idProductosVenta"]=$DatosProductos["idProducto"];
            $DatosKardex["CostoUnitario"]=$DatosProductos['CostoUnitarioCompra'];
            $DatosKardex["Existencias"]=$DatosProductoGeneral['Existencias'];
            $DatosKardex["Detalle"]="FacturaCompra";
            $DatosKardex["idDocumento"]=$idCompra;
            $DatosKardex["TotalCosto"]=$DatosProductos["Cantidad"]*$DatosProductos['CostoUnitario'];
            $DatosKardex["Movimiento"]="ENTRADA";
            
            $this->InserteKardex($DatosKardex);
        }
        //Miro si hay productos devueltos
        $TotalInventariosDevuelto= $this->Sume("factura_compra_items_devoluciones", "SubtotalCompra", "WHERE idFacturaCompra='$idCompra'");
        $IVADev=0;
        if($TotalInventariosDevuelto>0){
            $IVADev= $this->Sume("factura_compra_items_devoluciones", "ImpuestoCompra", "WHERE idFacturaCompra='$idCompra'");
            $TotalCompraDev= $this->Sume("factura_compra_items_devoluciones", "TotalCompra", "WHERE idFacturaCompra='$idCompra'");
            $ParametrosContables=$this->DevuelveValores("parametros_contables", "ID", 4);
            $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $ParametrosContables["CuentaPUC"], $ParametrosContables["NombreCuenta"], "DevolucionCompras", "CR", $TotalInventariosDevuelto, $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            $sql="SELECT SUM(`ImpuestoCompra`) AS IVA, `Tipo_Impuesto` AS TipoImpuesto FROM `factura_compra_items_devoluciones` WHERE `idFacturaCompra`='$idCompra' GROUP BY `Tipo_Impuesto` ";
            $consulta= $this->Query($sql);
            while($DatosImpuestos= $this->FetchArray($consulta)){
                $DatosTipoIVA= $this->DevuelveValores("porcentajes_iva", "Valor", $DatosImpuestos["TipoImpuesto"]);
                if($DatosImpuestos["IVA"]>0){
                    $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosTipoIVA["CuentaPUC"], $DatosTipoIVA["NombreCuenta"], "DevolucionCompras", "CR", $DatosImpuestos["IVA"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
                }
            }
            
            if($TipoPago=="Credito"){
                $ParametrosContables=$this->DevuelveValores("parametros_contables", "ID", 14);
                $CuentaDestino=$ParametrosContables["CuentaPUC"];
                $NombreCuenta=$ParametrosContables["NombreCuenta"];
            }else{
                $DatosSubcuentas= $this->DevuelveValores("subcuentas", "PUC", $CuentaOrigen);
                $CuentaDestino=$CuentaOrigen;
                $NombreCuenta=$DatosSubcuentas["Nombre"];
            }
            $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $CuentaDestino, $NombreCuenta, "DevolucionCompras", "DB", $TotalCompraDev, $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            //Retiro los Productos de inventario
            $consulta= $this->ConsultarTabla("factura_compra_items_devoluciones", "WHERE idFacturaCompra='$idCompra'");
            while($DatosProductos= $this->FetchArray($consulta)){
                $DatosProductoGeneral= $this->DevuelveValores("productosventa", "idProductosVenta", $DatosProductos["idProducto"]);
                $DatosKardex["Cantidad"]=$DatosProductos["Cantidad"];
                $DatosKardex["idProductosVenta"]=$DatosProductos["idProducto"];
                $DatosKardex["CostoUnitario"]=$DatosProductos['CostoUnitarioCompra'];
                $DatosKardex["Existencias"]=$DatosProductoGeneral['Existencias'];
                $DatosKardex["Detalle"]="FacturaCompra";
                $DatosKardex["idDocumento"]=$idCompra;
                $DatosKardex["TotalCosto"]=$DatosProductos["Cantidad"]*$DatosProductos['CostoUnitario'];
                $DatosKardex["Movimiento"]="SALIDA";

                $this->InserteKardex($DatosKardex);
            }
        }
        if($TipoPago=="Credito"){
            $SubtotalCuentaXPagar=$TotalInventarios-$TotalInventariosDevuelto;
            $TotalIVACXP=$IVA-$IVADev;
            $TotalCompraCXP=$TotalCompra-$TotalCompraDev+$TotalRetenciones;
            $this->RegistrarCuentaXPagar($DatosFacturaCompra["Fecha"], $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Fecha"], "factura_compra", $idCompra, $SubtotalCuentaXPagar, $TotalIVACXP, $TotalCompraCXP, $TotalRetenciones, 0, 0, $DatosFacturaCompra["Tercero"], $DatosFacturaCompra["idSucursal"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["Soporte"], "");
        }
        $this->ActualizaRegistro("factura_compra", "Estado", "CERRADA", "ID", $idCompra);
    }
    
    //Clase para devolver un item a una compra
    public function DevolverProductoCompra($idCompra,$idProducto,$Cantidad,$idFacturaItems,$Vector) {
        //Proceso la informacion
        $DatosFacturaItems= $this->DevuelveValores("factura_compra_items", "ID", $idFacturaItems);
        $CostoUnitario=$DatosFacturaItems["CostoUnitarioCompra"];
        $TipoIVA=$DatosFacturaItems["Tipo_Impuesto"];
        $Subtotal=round($CostoUnitario*$Cantidad);
        $Impuestos= round($Subtotal*$TipoIVA);
        $Total=$Subtotal+$Impuestos;
        //////Agrego el registro           
        $tab="factura_compra_items_devoluciones";
        $NumRegistros=8;

        $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
        $Columnas[1]="idProducto";          $Valores[1]=$idProducto;
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="CostoUnitarioCompra"; $Valores[3]=$CostoUnitario;
        $Columnas[4]="SubtotalCompra";      $Valores[4]=$Subtotal;
        $Columnas[5]="ImpuestoCompra";      $Valores[5]=$Impuestos;
        $Columnas[6]="TotalCompra";         $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    //Fin Clases
}