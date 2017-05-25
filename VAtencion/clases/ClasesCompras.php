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
    //Fin Clases
}