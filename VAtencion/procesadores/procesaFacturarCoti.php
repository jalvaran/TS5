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
    header("location:FacturaCotizacion.php?TxtAsociarCotizacion=$IdPre");
}


////Se recibe edicion
	
if(!empty($_REQUEST['BtnEditar'])){

        $idItem=$_REQUEST['TxtIdItemCotizacion'];
        $idCotizacion=$_REQUEST['TxtIdCotizacion'];
        //$Tabla=$_REQUEST['TxtTabla'];
        $Cantidad=$_REQUEST['TxtCantidad'];
        $ValorAcordado=$_REQUEST['TxtValorUnitario'];

        $obVenta=new ProcesoVenta($idUser);
        $DatosPreventa=$obVenta->DevuelveValores('cot_itemscotizaciones',"ID",$idItem);
        $Subtotal=round($ValorAcordado*$Cantidad);
        $DatosProductos=$obVenta->DevuelveValores($DatosPreventa["TablaOrigen"],"Referencia",$DatosPreventa["Referencia"]);
        $IVA=round($Subtotal*$DatosProductos["IVA"]);
        $SubtotalCosto=round($DatosProductos["CostoUnitario"]*$Cantidad);
        $Total=$Subtotal+$IVA;
        $filtro="ID";

        $obVenta->ActualizaRegistro("cot_itemscotizaciones","SubTotal", $Subtotal, $filtro, $idItem);
        $obVenta->ActualizaRegistro("cot_itemscotizaciones","IVA", $IVA, $filtro, $idItem);
        $obVenta->ActualizaRegistro("cot_itemscotizaciones","SubtotalCosto", $SubtotalCosto, $filtro, $idItem);
        $obVenta->ActualizaRegistro("cot_itemscotizaciones","Total", $Total, $filtro, $idItem);
        $obVenta->ActualizaRegistro("cot_itemscotizaciones","ValorUnitario", $ValorAcordado, $filtro, $idItem);
        $obVenta->ActualizaRegistro("cot_itemscotizaciones","Cantidad", $Cantidad, $filtro, $idItem);

        header("location:FacturaCotizacion.php?TxtAsociarCotizacion=$idCotizacion");

}
/*
 * 
 * Si llega la peticion de crear la factura
 * 
 */

if(!empty($_REQUEST["BtnGenerarFactura"])){
        
        $idCliente=$_REQUEST['TxtIdCliente'];
        $idCotizacion=$_REQUEST['TxtIdCotizacion'];
        $CentroCostos=$_REQUEST["CmbCentroCostos"];
        $ResolucionDian=$_REQUEST["CmbResolucion"];
        $TipoPago=$_REQUEST["CmbFormaPago"];
        $CuentaDestino=$_REQUEST["CmbCuentaDestino"];
        $OrdenCompra=$_REQUEST["TxtOrdenCompra"];
        $OrdenSalida=$_REQUEST["TxtOrdenSalida"];
        $ObservacionesFactura=$_REQUEST["TxtObservacionesFactura"];
        $FechaFactura=$_REQUEST["TxtFechaFactura"];
        $NumeroForzado=$_REQUEST["TxtNumeroFactura"];
        $Consulta=$obVenta->DevuelveValores("centrocosto", "ID", $CentroCostos);
        $EmpresaPro=$Consulta["EmpresaPro"];
        if($TipoPago=="Contado"){
            $SumaDias=0;
        }else{
            $SumaDias=$TipoPago;
        }
        ////////////////////////////////Preguntamos por disponibilidad
        ///////////
        ///////////
        $ID="";
        $DatosResolucion=$obVenta->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
        if($DatosResolucion["Completada"]=="NO"){           ///Pregunto si la resolucion ya fue completada
            $Disponibilidad=$DatosResolucion["Estado"];
                                              //si entra a verificar es porque estaba ocupada y cambiará a 1
            while($Disponibilidad=="OC"){                   //miro que esté disponible para facturar, esto para no crear facturas dobles
                print("Esperando disponibilidad<br>");
                usleep(300);
                $DatosResolucion=$obVenta->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
                $Disponibilidad=$DatosResolucion["Estado"];
                
            }
            
            $DatosResolucion=$obVenta->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
            if($DatosResolucion["Completada"]<>"SI"){
                $obVenta->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "OC", "ID", $ResolucionDian); //Ocupo la resolucion
                
                $sql="SELECT MAX(NumeroFactura) as FacturaActual FROM facturas WHERE Prefijo='$DatosResolucion[Prefijo]' "
                        . "AND TipoFactura='$DatosResolucion[Tipo]' AND idResolucion='$ResolucionDian'";
                $Consulta=$obVenta->Query($sql);
                $Consulta=$obVenta->FetchArray($Consulta);
                $FacturaActual=$Consulta["FacturaActual"];
                $idFactura=$FacturaActual+1;
                if($NumeroForzado>0){
                    $sql="SELECT NumeroFactura FROM facturas WHERE Prefijo='$DatosResolucion[Prefijo]' "
                        . "AND TipoFactura='$DatosResolucion[Tipo]' AND idResolucion='$ResolucionDian'";
                    $Consulta=$obVenta->Query($sql);
                    $Consulta=$obVenta->FetchArray($Consulta);
                    $Existe=$Consulta["NumeroFactura"];
                    if($Existe==$NumeroForzado){
                        //libero la resolucion
                        $obVenta->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "", "ID", $ResolucionDian);
                        exit("<a href='FacturaCotizacion.php'>La factura $NumeroForzado ya existe, no se puede crear, Volver</a>");
                    }else{
                        $idFactura=$NumeroForzado;
                    }
                }
                //Verificamos si ya se completó el numero de la resolucion y si es así se cambia su estado
                if($DatosResolucion["Hasta"]==$idFactura){ 
                    $obVenta->ActualizaRegistro("empresapro_resoluciones_facturacion", "Completada", "SI", "ID", $ResolucionDian);
                }
                //Verificamos si es la primer factura que se creará con esta resolucion
                //Si es así se inicia desde el numero autorizado
                if($idFactura==1){
                   $idFactura=$DatosResolucion["Desde"];
                }
                //Convertimos los dias en credito
                $FormaPagoFactura=$TipoPago;
                if($TipoPago<>"Contado"){
                    $FormaPagoFactura="Credito a $TipoPago dias";
                }
                ////////////////Inserto datos de la factura
                /////
                ////
                $ID=date("YmdHis").microtime(false);
                $tab="facturas";
                $NumRegistros=25; 
                
                $Columnas[0]="TipoFactura";		    $Valores[0]=$DatosResolucion["Tipo"];
                $Columnas[1]="Prefijo";                     $Valores[1]=$DatosResolucion["Prefijo"];
                $Columnas[2]="NumeroFactura";               $Valores[2]=$idFactura;
                $Columnas[3]="Fecha";                       $Valores[3]=$FechaFactura;
                $Columnas[4]="OCompra";                     $Valores[4]=$OrdenCompra;
                $Columnas[5]="OSalida";                     $Valores[5]=$OrdenSalida;
                $Columnas[6]="FormaPago";                   $Valores[6]=$FormaPagoFactura;
                $Columnas[7]="Subtotal";                    $Valores[7]="";
                $Columnas[8]="IVA";                         $Valores[8]="";
                $Columnas[9]="Descuentos";                  $Valores[9]="";
                $Columnas[10]="Total";                      $Valores[10]="";
                $Columnas[11]="SaldoFact";                  $Valores[11]="";
                $Columnas[12]="Cotizaciones_idCotizaciones";$Valores[12]="";
                $Columnas[13]="EmpresaPro_idEmpresaPro";    $Valores[13]=$EmpresaPro;
                $Columnas[14]="Usuarios_idUsuarios";        $Valores[14]=$idUser;
                $Columnas[15]="Clientes_idClientes";        $Valores[15]=$idCliente;
                $Columnas[16]="TotalCostos";                $Valores[16]="";
                $Columnas[17]="CerradoDiario";              $Valores[17]="";
                $Columnas[18]="FechaCierreDiario";          $Valores[18]="";
                $Columnas[19]="HoraCierreDiario";           $Valores[19]="";
                $Columnas[20]="ObservacionesFact";          $Valores[20]=$ObservacionesFactura;
                $Columnas[21]="CentroCosto";                $Valores[21]=$CentroCostos;
                $Columnas[22]="idResolucion";               $Valores[22]=$ResolucionDian;
                $Columnas[23]="idFacturas";                 $Valores[23]=$ID;
                $Columnas[24]="Hora";                       $Valores[24]=date("H:i:s");
                
                $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                
                //libero la resolucion
                $obVenta->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "", "ID", $ResolucionDian);
                
                //////////////////////Agrego Items a la Factura desde la devolucion
                /////
                /////
                $Datos["NumCotizacion"]=$idCotizacion;
                $Datos["NumFactura"]=$idFactura;
                $Datos["FechaFactura"]=$FechaFactura;
                $Datos["ID"]=$ID;
                $Datos["CuentaDestino"]=$CuentaDestino;
                $Datos["EmpresaPro"]=$EmpresaPro;
                $Datos["CentroCostos"]=$CentroCostos;
                $obVenta->InsertarItemsCotizacionAItemsFactura($Datos);///Relaciono los items de la factura
                
                $obVenta->InsertarFacturaLibroDiario($Datos);///Inserto Items en el libro diario
               
                if($TipoPago<>"Contado"){                   //Si es a Credito
                    $Datos["Fecha"]=$FechaFactura; 
                    $Datos["Dias"]=$SumaDias;
                    $FechaVencimiento=$obVenta->SumeDiasFecha($Datos);
                    $Datos["idFactura"]=$Datos["ID"]; 
                    $Datos["FechaFactura"]=$FechaFactura; 
                    $Datos["FechaVencimiento"]=$FechaVencimiento;
                    $Datos["idCliente"]=$idCliente;
                    $obVenta->InsertarFacturaEnCartera($Datos);///Inserto La factura en la cartera
                }
                
            }    
           
        }
        
        header("location:FacturaCotizacion.php?TxtidFactura=$ID");
        
    }
?>