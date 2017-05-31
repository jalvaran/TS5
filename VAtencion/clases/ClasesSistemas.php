<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Sistema extends ProcesoVenta{
    public function CrearSistema($Nombre, $PrecioVenta, $PrecioMayorista,$Observaciones,$Vector ) {
        
        //////Creo la compra            
        $tab="sistemas";
        $NumRegistros=7;

        $Columnas[0]="Nombre";		$Valores[0]=$Nombre;
        $Columnas[1]="idUsuario";       $Valores[1]=$this->idUser;
        $Columnas[2]="PrecioVenta";     $Valores[2]=$PrecioVenta;
        $Columnas[3]="PrecioMayorista";	$Valores[3]=$PrecioMayorista;
        $Columnas[4]="RutaImagen";	$Valores[4]="";
        $Columnas[5]="Observaciones";	$Valores[5]=$Observaciones;
        $Columnas[6]="Estado";          $Valores[6]="ABIERTO";
               
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        $idSistema=$this->ObtenerMAX($tab,"ID", 1,"");
        
        //Miro si se recibe un archivo
        //
        if(!empty($_FILES['foto']['name'])){
            //echo "<script>alert ('entra foto')</script>";
            $Atras="../";
            $carpeta="ImagenesProductos/";
            opendir($Atras.$carpeta);
            $Name=$idSistema."_".str_replace(' ','_',$_FILES['foto']['name']);
            $destino=$carpeta.$Name;
            move_uploaded_file($_FILES['foto']['tmp_name'],$Atras.$destino);
	}
        $this->ActualizaRegistro("sistemas", "RutaImagen", $destino, "ID", $idSistema);
        return $idSistema;
    }
    
    //Clase para agregar un item a un sistema
    public function AgregarItemSistema($TipoItem,$idSistema,$Cantidad,$idItem,$Vector) {
        //Proceso la informacion
        if($TipoItem==1){
            $TablaOrigen="productosventa";
        }else{
            $TablaOrigen="servicios";
        }
        $DatosProducto=$this->DevuelveValores($TablaOrigen, "idProductosVenta", $idItem);
        //////Agrego el registro           
        $tab="sistemas_relaciones";
        $NumRegistros=4;

        $Columnas[0]="TablaOrigen";         $Valores[0]=$TablaOrigen;
        $Columnas[1]="Referencia";          $Valores[1]=$DatosProducto["Referencia"];
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="idSistema";           $Valores[3]=$idSistema;
                            
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
    //Contabilizar Items de la compra
    public function ContabilizarProductosCompra($idCompra) {
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        $TotalesCompra=$this->CalculeTotalesCompra($idCompra);
        $ParametrosContables=$this->DevuelveValores("parametros_contables", "ID", 4);   //Cuenta de inventarios
        $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $ParametrosContables["CuentaPUC"], $ParametrosContables["NombreCuenta"], "Compras", "DB", $TotalesCompra["Subtotal_Productos_Add"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
        $sql="SELECT SUM(`ImpuestoCompra`) AS IVA, `Tipo_Impuesto` AS TipoImpuesto FROM `factura_compra_items` WHERE `idFacturaCompra`='$idCompra' GROUP BY `Tipo_Impuesto` ";
        $consulta= $this->Query($sql);
        while($DatosImpuestos= $this->FetchArray($consulta)){
            $DatosTipoIVA= $this->DevuelveValores("porcentajes_iva", "Valor", $DatosImpuestos["TipoImpuesto"]);
            if($DatosImpuestos["IVA"]>0){
                $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosTipoIVA["CuentaPUC"], $DatosTipoIVA["NombreCuenta"], "Compras", "DB", $DatosImpuestos["IVA"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            }
        }
    }
    
    //Contabilizar Items de la compra
    public function ContabilizarServiciosCompra($idCompra) {
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        //$TotalesCompra=$this->CalculeTotalesCompra($idCompra);
        $sql="SELECT CuentaPUC_Servicio AS CuentaPUC,Nombre_Cuenta AS NombreCuenta, Concepto_Servicio AS Concepto,`Subtotal_Servicio` AS Subtotal,`Impuesto_Servicio` AS IVA, `Tipo_Impuesto` AS TipoImpuesto FROM `factura_compra_servicios` WHERE `idFacturaCompra`='$idCompra' ";
        $consulta= $this->Query($sql);
        while($DatosServicios= $this->FetchArray($consulta)){
            $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosServicios["CuentaPUC"], $DatosServicios["NombreCuenta"], "Servicios", "DB", $DatosServicios["Subtotal"], $DatosServicios["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            $DatosTipoIVA= $this->DevuelveValores("porcentajes_iva", "Valor", $DatosServicios["TipoImpuesto"]);
            if($DatosServicios["IVA"]>0){
                $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosTipoIVA["CuentaPUC"], $DatosTipoIVA["NombreCuenta"], "Servicios", "DB", $DatosServicios["IVA"], $DatosServicios["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            }
        }
    }
    //Contabilice Retenciones
    public function ContabilizarRetencionesCompra($idCompra) {
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        //$TotalesCompra=$this->CalculeTotalesCompra($idCompra);
        $sql="SELECT SUM(`ValorRetencion`) AS Retencion, `CuentaPUC` AS CuentaPUC,`NombreCuenta` AS NombreCuenta FROM `factura_compra_retenciones` WHERE `idCompra`='$idCompra' GROUP BY `CuentaPUC` ";
        $consulta= $this->Query($sql);
        while($DatosRetencion= $this->FetchArray($consulta)){
            
            $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosRetencion["CuentaPUC"], $DatosRetencion["NombreCuenta"], "Retenciones", "CR", $DatosRetencion["Retencion"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            
        }
    }
    
    //Ingrese los items al inventario o retire items del inventario
    public function IngreseRetireProductosInventarioCompra($idCompra,$Movimiento) {
        if($Movimiento=="ENTRADA"){
            $consulta= $this->ConsultarTabla("factura_compra_items", "WHERE idFacturaCompra='$idCompra'");
        }else{
            $consulta= $this->ConsultarTabla("factura_compra_items_devoluciones", "WHERE idFacturaCompra='$idCompra'");
        } 
        while($DatosProductos= $this->FetchArray($consulta)){
            $DatosProductoGeneral= $this->DevuelveValores("productosventa", "idProductosVenta", $DatosProductos["idProducto"]);
            $DatosKardex["Cantidad"]=$DatosProductos["Cantidad"];
            $DatosKardex["idProductosVenta"]=$DatosProductos["idProducto"];
            $DatosKardex["CostoUnitario"]=$DatosProductos['CostoUnitarioCompra'];
            $DatosKardex["Existencias"]=$DatosProductoGeneral['Existencias'];
            $DatosKardex["Detalle"]="FacturaCompra";
            $DatosKardex["idDocumento"]=$idCompra;
            $DatosKardex["TotalCosto"]=$DatosProductos["Cantidad"]*$DatosProductos['CostoUnitario'];
            $DatosKardex["Movimiento"]=$Movimiento;
            
            $this->InserteKardex($DatosKardex);
        }
    }
    //Revise si hay productos devueltos y contabilice
    public function ContabiliceProductosDevueltos($idCompra) {
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        $TotalesCompra=$this->CalculeTotalesCompra($idCompra);
        
        if($TotalesCompra["Total_Productos_Dev"]>0){
            
            $ParametrosContables=$this->DevuelveValores("parametros_contables", "ID", 4); //Cuenta de inventarios
            $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $ParametrosContables["CuentaPUC"], $ParametrosContables["NombreCuenta"], "DevolucionCompras", "CR", $TotalesCompra["Subtotal_Productos_Dev"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            $sql="SELECT SUM(`ImpuestoCompra`) AS IVA, `Tipo_Impuesto` AS TipoImpuesto FROM `factura_compra_items_devoluciones` WHERE `idFacturaCompra`='$idCompra' GROUP BY `Tipo_Impuesto` ";
            $consulta= $this->Query($sql);
            while($DatosImpuestos= $this->FetchArray($consulta)){
                $DatosTipoIVA= $this->DevuelveValores("porcentajes_iva", "Valor", $DatosImpuestos["TipoImpuesto"]);
                if($DatosImpuestos["IVA"]>0){
                    $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $DatosTipoIVA["CuentaPUC"], $DatosTipoIVA["NombreCuenta"], "DevolucionCompras", "CR", $DatosImpuestos["IVA"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
                }
            }
                       
        }
    }
    //Guarde una Compra
    public function GuardarFacturaCompra($idCompra,$TipoPago,$CuentaOrigen,$Vector) {
        $DatosFacturaCompra= $this->DevuelveValores("factura_compra", "ID", $idCompra);
        $TotalesCompra=$this->CalculeTotalesCompra($idCompra);
        $TotalRetenciones= $TotalesCompra["Total_Retenciones"];
        $this->ContabilizarProductosCompra($idCompra);     //Contabilizo los productos agregados
        $this->ContabilizarServiciosCompra($idCompra);     //Contabilizo los Servicios agregados
        $this->ContabilizarRetencionesCompra($idCompra);   //Contabilizo las Retenciones
        //Contabilizo salida de dinero o cuenta X Pagar
        if($TipoPago=="Credito"){
            $ParametrosContables=$this->DevuelveValores("parametros_contables", "ID", 14);
            $CuentaDestino=$ParametrosContables["CuentaPUC"];
            $NombreCuenta=$ParametrosContables["NombreCuenta"];
        }else{
            $DatosSubcuentas= $this->DevuelveValores("subcuentas", "PUC", $CuentaOrigen);
            $CuentaDestino=$CuentaOrigen;
            $NombreCuenta=$DatosSubcuentas["Nombre"];
        }
        $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $CuentaDestino, $NombreCuenta, "Compras", "CR", $TotalesCompra["Total_Productos_Add"]+$TotalesCompra["Total_Servicios"]-$TotalesCompra["Total_Retenciones"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
        if($TotalesCompra["Total_Productos_Dev"]>0){  //Si hay devoluciones en compras se debita la cuenta de proveedores
          $this->IngreseMovimientoLibroDiario($DatosFacturaCompra["Fecha"], "FacturaCompra", $idCompra, $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Tercero"], $CuentaDestino, $NombreCuenta, "DevolucionCompras", "DB", $TotalesCompra["Total_Productos_Dev"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["idSucursal"], "");
            
        }
        $this->ContabiliceProductosDevueltos($idCompra);
        $this->IngreseRetireProductosInventarioCompra($idCompra,"ENTRADA");  //Ingreso los productos al inventario
        $this->IngreseRetireProductosInventarioCompra($idCompra,"SALIDA");   //Retiro los productos del inventario
        //Si es credito se ingresa a cuentas X Pagar
        
        if($TipoPago=="Credito"){
            $SubtotalCuentaXPagar=$TotalesCompra["Gran_Subtotal"];
            $TotalIVACXP=$TotalesCompra["Gran_Impuestos"];
            $TotalCompraCXP=$TotalesCompra["Gran_Total"];
            $this->RegistrarCuentaXPagar($DatosFacturaCompra["Fecha"], $DatosFacturaCompra["NumeroFactura"], $DatosFacturaCompra["Fecha"], "factura_compra", $idCompra, $SubtotalCuentaXPagar, $TotalIVACXP, $TotalCompraCXP, $TotalesCompra["Total_Retenciones"], 0, 0, $DatosFacturaCompra["Tercero"], $DatosFacturaCompra["idSucursal"], $DatosFacturaCompra["idCentroCostos"], $DatosFacturaCompra["Concepto"], $DatosFacturaCompra["Soporte"], "");
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
    
    //Agregar Un Servicio
    public function AgregueServicioCompra($idCompra,$CuentaPUC,$Concepto,$Valor,$TipoIVA,$Vector) {
        //Proceso la informacion
        $DatosCuenta= $this->DevuelveValores("subcuentas", "PUC", $CuentaPUC);
        $Impuestos=0;
        if(is_numeric($TipoIVA)){
            $Impuestos=$Valor*$TipoIVA;
        } 
        $Total=$Valor+$Impuestos;
        
        //////Agrego el registro           
        $tab="factura_compra_servicios";
        $NumRegistros=8;

        $Columnas[0]="idFacturaCompra";     $Valores[0]=$idCompra;
        $Columnas[1]="CuentaPUC_Servicio";  $Valores[1]=$CuentaPUC;
        $Columnas[2]="Nombre_Cuenta";       $Valores[2]=$DatosCuenta["Nombre"];
        $Columnas[3]="Concepto_Servicio";   $Valores[3]=$Concepto;
        $Columnas[4]="Subtotal_Servicio";   $Valores[4]=$Valor;
        $Columnas[5]="Impuesto_Servicio";   $Valores[5]=$Impuestos;
        $Columnas[6]="Total_Servicio";      $Valores[6]=$Total;
        $Columnas[7]="Tipo_Impuesto";       $Valores[7]=$TipoIVA;
                    
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Calcule totales de la compra
    
    public function CalculeTotalesCompra($idCompra) {
        $sql="SELECT SUM(SubtotalCompra) as Subtotal, sum(ImpuestoCompra) as IVA, SUM(TotalCompra) AS Total FROM factura_compra_items "
                    . " WHERE idFacturaCompra='$idCompra'";
        $consulta= $this->Query($sql);
        $TotalesCompraProductos=$this->FetchArray($consulta);
        
        $sql="SELECT SUM(SubtotalCompra) as Subtotal, sum(ImpuestoCompra) as IVA, SUM(TotalCompra) AS Total FROM factura_compra_items_devoluciones "
                    . " WHERE idFacturaCompra='$idCompra'";
        $consulta= $this->Query($sql);
        $TotalesItemsDevueltos=$this->FetchArray($consulta);
        $TotalRetenciones= $this->SumeColumna("factura_compra_retenciones", "ValorRetencion", "idCompra", $idCompra);
        
        $sql="SELECT SUM(Subtotal_Servicio) as Subtotal, sum(Impuesto_Servicio) as IVA, SUM(Total_Servicio) AS Total FROM factura_compra_servicios "
                    . " WHERE idFacturaCompra='$idCompra'";
        $consulta= $this->Query($sql);
        $TotalesServicios=$this->FetchArray($consulta);
        $TotalesCompra["Subtotal_Productos_Add"]=$TotalesCompraProductos["Subtotal"];
        $TotalesCompra["Impuestos_Productos_Add"]=$TotalesCompraProductos["IVA"];
        $TotalesCompra["Total_Productos_Add"]=$TotalesCompraProductos["Total"];
        $TotalesCompra["Subtotal_Servicios"]=$TotalesServicios["Subtotal"];
        $TotalesCompra["Impuestos_Servicios"]=$TotalesServicios["IVA"];
        $TotalesCompra["Total_Servicios"]=$TotalesServicios["Total"];
        $TotalesCompra["Total_Retenciones"]=$TotalRetenciones;
        $TotalesCompra["Subtotal_Productos_Dev"]=$TotalesItemsDevueltos["Subtotal"];
        $TotalesCompra["Impuestos_Productos_Dev"]=$TotalesItemsDevueltos["IVA"];
        $TotalesCompra["Total_Productos_Dev"]=$TotalesItemsDevueltos["Total"];
        $TotalesCompra["Subtotal_Productos"]=$TotalesCompra["Subtotal_Productos_Add"]-$TotalesCompra["Subtotal_Productos_Dev"];
        $TotalesCompra["Impuestos_Productos"]=$TotalesCompra["Impuestos_Productos_Add"]-$TotalesCompra["Impuestos_Productos_Dev"];
        $TotalesCompra["Total_Productos"]=$TotalesCompra["Total_Productos_Add"]-$TotalesCompra["Total_Productos_Dev"];
        $TotalesCompra["Gran_Subtotal"]=$TotalesCompra["Subtotal_Productos"]+$TotalesCompra["Subtotal_Servicios"];
        $TotalesCompra["Gran_Impuestos"]=$TotalesCompra["Impuestos_Productos"]+$TotalesCompra["Impuestos_Servicios"];
        $TotalesCompra["Gran_Total"]=$TotalesCompra["Total_Productos"]+$TotalesCompra["Total_Servicios"];
        $TotalesCompra["Total_Pago"]=$TotalesCompra["Gran_Total"]-$TotalesCompra["Total_Retenciones"];
        return($TotalesCompra);
    }
    
    //Fin Clases
}