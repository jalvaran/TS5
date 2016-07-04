<?php 

//print("<script>alert('entra');</script>");		
if(!empty($_REQUEST["TxtDias"])){
    //print("<script>alert('entra');</script>");
    $obVenta=new ProcesoVenta($idUser);
    $idItem=$_REQUEST["TxtIdItem"];
    $FechaDevolucion=$_REQUEST["TxtFechaDevolucion"];
    $HoraDevolucion=$_REQUEST["TxtHoraDevolucion"];
    $CantidadDevolucion=$_REQUEST["TxtCantidadDevolucion"];
    $idRemision=$_REQUEST["TxtAsociarRemision"];
    $Dias=$_REQUEST["TxtDias"];
    $ValorUnitario=$_REQUEST["TxtSubtotalUnitario"];
    $SubTotal=$ValorUnitario*$CantidadDevolucion;
    $Total=$SubTotal*$Dias;
    
    $tab="rem_pre_devoluciones";
    $NumRegistros=8; 
    $Columnas[0]="idRemision";		$Valores[0]=$idRemision;
    $Columnas[1]="idItemCotizacion";	$Valores[1]=$idItem;
    $Columnas[2]="Cantidad";		$Valores[2]=$CantidadDevolucion;
    $Columnas[3]="Usuarios_idUsuarios"; $Valores[3]=$idUser;
    $Columnas[4]="ValorUnitario";       $Valores[4]=$ValorUnitario;
    $Columnas[5]="Subtotal";            $Valores[5]=$SubTotal;
    $Columnas[6]="Dias";                $Valores[6]=$Dias;
    $Columnas[7]="Total";               $Valores[7]=$Total;
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
   
    header("location:Devoluciones.php?TxtAsociarRemision=$idRemision");
}

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
    header("location:Devoluciones.php?TxtAsociarRemision=$IdPre");
}
	
if(!empty($_REQUEST["BtnGuardarDevolucion"])){
   
    $obVenta=new ProcesoVenta($idUser);
    $FechaDevolucion=$_REQUEST["TxtFechaDevolucion"];
    $HoraDevolucion=$_REQUEST["TxtHoraDevolucion"];
    $idRemision=$_REQUEST["TxtIdRemision"];
    $Observaciones=$_REQUEST["TxtObservacionesDevolucion"];
    $TotalDevolucion=$_REQUEST["TxtTotalDevolucion"];
    
    $DatosRemision=$obVenta->DevuelveValores("remisiones", "ID", $idRemision);
    $idCliente=$DatosRemision["Clientes_idClientes"];
    ////Guardamos en la tabla devoluciones
    ////
    ////
    
    $tab="rem_devoluciones_totalizadas";
    $NumRegistros=8; 
    $Columnas[0]="FechaDevolucion";         $Valores[0]=$FechaDevolucion;
    $Columnas[1]="idRemision";              $Valores[1]=$idRemision;
    $Columnas[2]="TotalDevolucion";         $Valores[2]=$TotalDevolucion;
    $Columnas[3]="ObservacionesDevolucion"; $Valores[3]=$Observaciones;
    $Columnas[4]="Usuarios_idUsuarios";     $Valores[4]=$idUser;
    $Columnas[5]="Clientes_idClientes";     $Valores[5]=$DatosRemision["Clientes_idClientes"];
    $Columnas[6]="Facturas_idFacturas";     $Valores[6]="";
    $Columnas[7]="HoraDevolucion";          $Valores[7]=$HoraDevolucion;
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    
    $idDevolucion=$obVenta->ObtenerMAX("rem_devoluciones_totalizadas", "ID", 1, "");
    
    $Consulta=$obVenta->ConsultarTabla("rem_pre_devoluciones", " WHERE idRemision='$idRemision'");
    
    while($DatosPreDevolucion= mysql_fetch_array($Consulta)){
        
        $tab="rem_devoluciones";
        $NumRegistros=11; 
        $Columnas[0]="idRemision";          $Valores[0]=$idRemision;
        $Columnas[1]="idItemCotizacion";    $Valores[1]=$DatosPreDevolucion["idItemCotizacion"];
        $Columnas[2]="Cantidad";            $Valores[2]=$DatosPreDevolucion["Cantidad"];
        $Columnas[3]="ValorUnitario";       $Valores[3]=$DatosPreDevolucion["ValorUnitario"];
        $Columnas[4]="Subtotal";            $Valores[4]=$DatosPreDevolucion["Subtotal"];
        $Columnas[5]="Dias";                $Valores[5]=$DatosPreDevolucion["Dias"];
        $Columnas[6]="Total";               $Valores[6]=$DatosPreDevolucion["Total"];
        $Columnas[7]="NumDevolucion";       $Valores[7]=$idDevolucion;
        $Columnas[8]="FechaDevolucion";     $Valores[8]=$FechaDevolucion;
        $Columnas[9]="HoraDevolucion";      $Valores[9]=$HoraDevolucion;
        $Columnas[10]="Usuarios_idUsuarios";$Valores[10]=$DatosPreDevolucion["Usuarios_idUsuarios"];
        
        $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
   
    
    ////Iniciamos registro de facturas si aplica
    ////
    ////
    
    if($_REQUEST["CmbFactura"]=="SI"){
        
        $CentroCostos=$_REQUEST["CmbCentroCostos"];
        $ResolucionDian=$_REQUEST["CmbResolucion"];
        $TipoPago=$_REQUEST["CmbFormaPago"];
        $CuentaDestino=$_REQUEST["CmbCuentaDestino"];
        $OrdenCompra=$_REQUEST["TxtOrdenCompra"];
        $OrdenSalida=$_REQUEST["TxtOrdenSalida"];
        $ObservacionesFactura=$_REQUEST["TxtObservacionesFactura"];
        $FechaFactura=$_REQUEST["TxtFechaFactura"];
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
                $Datos["NumDevolucion"]=$idDevolucion;
                
                //$obVenta->InserteItemsDevolucionAFacturas($idRemision);
                $sql="SELECT MAX(NumeroFactura) as FacturaActual FROM facturas WHERE Prefijo='$DatosResolucion[Prefijo]' "
                        . "AND TipoFactura='$DatosResolucion[Tipo]' AND idResolucion='$ResolucionDian'";
                $Consulta=$obVenta->Query($sql);
                $Consulta=$obVenta->FetchArray($Consulta);
                $FacturaActual=$Consulta["FacturaActual"];
                $idFactura=$FacturaActual+1;
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
                $Datos["NumDevolucion"]=$idDevolucion;
                $Datos["NumFactura"]=$idFactura;
                $Datos["FechaFactura"]=$FechaFactura;
                $Datos["ID"]=$ID;
                $Datos["CuentaDestino"]=$CuentaDestino;
                $Datos["EmpresaPro"]=$EmpresaPro;
                $Datos["CentroCostos"]=$CentroCostos;
                $obVenta->InsertarItemsDevolucionAItemsFactura($Datos);///Relaciono los items de la factura
                $obVenta->ActualizaRegistro("rem_devoluciones_totalizadas", "Facturas_idFacturas", $ID, "ID", $idDevolucion);
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
        
        
        
    }
    
    $obVenta->BorraReg("rem_pre_devoluciones", "idRemision", $idRemision);
    header("location:Devoluciones.php?TxtidDevolucion=$idDevolucion&TxtidFactura=$ID");
}        


///////////////fin
?>