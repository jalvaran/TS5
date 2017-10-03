
<?php 
	
	
	if(!empty($_REQUEST['del'])){
		$id=$_REQUEST['del'];
		$Tabla=$_REQUEST['TxtTabla'];
		$IdTabla=$_REQUEST['TxtIdTabla'];
		$IdPre=$_REQUEST['TxtIdPre'];
		mysql_query("DELETE FROM $Tabla WHERE $IdTabla='$id'") or die(mysql_error());
		header("location:Cotizaciones.php?TxtIdCliente=$IdPre");
	}
		
	if(!empty($_REQUEST['TxtSaldo'])){
		
		$obVenta=new ProcesoVenta($idUser);
		$Fecha=$obVenta->normalizar($_REQUEST['TxtFechaRemision']);
                $idCliente=$obVenta->normalizar($_REQUEST['TxtidCliente']);
                $Observaciones=$obVenta->normalizar($_REQUEST['TxtObservacionesRemision']);
                $idCotizacion=$obVenta->normalizar($_REQUEST['TxtIdCotizacion']);
                $Obra=$obVenta->normalizar($_REQUEST['TxtObra']);
                $DireccionObra=$obVenta->normalizar($_REQUEST['TxtDireccionObra']);
                $CiudadObra=$obVenta->normalizar($_REQUEST['TxtCiudadObra']);
                $TelefonoObra=$obVenta->normalizar($_REQUEST['TxtTelefonoObra']);
                $ColaboradorRetira=$obVenta->normalizar($_REQUEST['TxtRetira']);
                $FechaDespacho=$obVenta->normalizar($_REQUEST['TxtFecha']);
                $HoraDespacho=$obVenta->normalizar($_REQUEST['TxtHora']);
                $Anticipo=$obVenta->normalizar($_REQUEST['TxtAnticipo']);
                $Dias=$obVenta->normalizar($_REQUEST['TxtDias']);
                $CentroCostos=$obVenta->normalizar($_REQUEST['CmbCentroCostos']);
                $CuentaDestino=$obVenta->normalizar($_REQUEST['CmbCuentaDestino']);
		//$DatosCotizacion=$obVenta->DevuelveValores("cotizacionesv5","ID",$_REQUEST['TxtIdCotizacion']);
		
		$tab="remisiones";
		$NumRegistros=16;  
							
		
		$Columnas[0]="Fecha";						$Valores[0]=$Fecha;
		$Columnas[1]="Clientes_idClientes";				$Valores[1]=$idCliente;
		$Columnas[2]="ObservacionesRemision";				$Valores[2]=$Observaciones;
		$Columnas[3]="Cotizaciones_idCotizaciones";			$Valores[3]=$idCotizacion;
		$Columnas[4]="Obra";						$Valores[4]=$Obra;
		$Columnas[5]="Direccion";					$Valores[5]=$DireccionObra;
		$Columnas[6]="Ciudad";						$Valores[6]=$CiudadObra;
		$Columnas[7]="Telefono";					$Valores[7]=$TelefonoObra;
		$Columnas[8]="Retira";						$Valores[8]=$ColaboradorRetira;
		$Columnas[9]="FechaDespacho";					$Valores[9]=$FechaDespacho;
		$Columnas[10]="HoraDespacho";					$Valores[10]=$HoraDespacho;
		$Columnas[11]="Anticipo";					$Valores[11]=$Anticipo;
		$Columnas[12]="Dias";			    			$Valores[12]=$Dias;
                $Columnas[13]="Estado";			    			$Valores[13]="A";
		$Columnas[14]="Usuarios_idUsuarios";			    	$Valores[14]=$idUser;
                $Columnas[15]="CentroCosto";			    		$Valores[15]=$CentroCostos;
                
		$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                 
                
		$idRemision=$obVenta->ObtenerMAX("remisiones", "ID", 1, "");
                
                ///////////////////////////////Se ingresa a rem_relaciones
                
                $ConsultaItems=$obVenta->ConsultarTabla("cot_itemscotizaciones","WHERE NumCotizacion='$_REQUEST[TxtIdCotizacion]'");
                while($DatosItemsCotizacion=  $obVenta->FetchArray($ConsultaItems)){
                    $tab="rem_relaciones";
                    $NumRegistros=6; 
                    $Columnas[0]="FechaEntrega";				$Valores[0]=$_REQUEST['TxtFechaRemision'];
                    $Columnas[1]="CantidadEntregada";				$Valores[1]=$DatosItemsCotizacion["Cantidad"];
                    $Columnas[2]="idItemCotizacion";				$Valores[2]=$DatosItemsCotizacion['ID'];
                    $Columnas[3]="idRemision";                                  $Valores[3]=$idRemision;
                    $Columnas[4]="Usuarios_idUsuarios";                         $Valores[4]=$idUser;
                    $Columnas[5]="Multiplicador";                               $Valores[5]=$DatosItemsCotizacion["Multiplicador"];
                    
                    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                }
                $VariblesImpresion="TxtidRemision=$idRemision";
                if($_REQUEST['TxtAnticipo']>0){
                    
                    //$idIngreso=$obVenta->RegistreAnticipo($_REQUEST['TxtidCliente'],$_REQUEST['TxtAnticipo'],$_REQUEST['CmbCuentaDestino'],$_REQUEST['CmbCentroCostos'],"Anticipo por remision $idRemision",$idUser);
                    $Concepto="Anticipo por remision $idRemision";
                    $idIngreso=$obVenta->RegistreAnticipo2($Fecha, $CuentaDestino, $idCliente, $Anticipo, $CentroCostos, $Concepto, $idUser, "");
                    $VariblesImpresion=$VariblesImpresion."&TxtidIngreso=$idIngreso";
                    
                }
                    header("location:Remisiones.php?$VariblesImpresion");	
	}
	
	
		
			
	
	?>