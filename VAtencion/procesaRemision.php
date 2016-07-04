
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
				
		//$DatosCotizacion=$obVenta->DevuelveValores("cotizacionesv5","ID",$_REQUEST['TxtIdCotizacion']);
		
		$tab="remisiones";
		$NumRegistros=16;  
							
		
		$Columnas[0]="Fecha";						$Valores[0]=$_REQUEST['TxtFechaRemision'];
		$Columnas[1]="Clientes_idClientes";				$Valores[1]=$_REQUEST['TxtidCliente'];
		$Columnas[2]="ObservacionesRemision";				$Valores[2]=$_REQUEST['TxtObservacionesRemision'];
		$Columnas[3]="Cotizaciones_idCotizaciones";			$Valores[3]=$_REQUEST['TxtIdCotizacion'];
		$Columnas[4]="Obra";						$Valores[4]=$_REQUEST['TxtObra'];
		$Columnas[5]="Direccion";					$Valores[5]=$_REQUEST['TxtDireccionObra'];
		$Columnas[6]="Ciudad";						$Valores[6]=$_REQUEST['TxtCiudadObra'];
		$Columnas[7]="Telefono";					$Valores[7]=$_REQUEST['TxtTelefonoObra'];
		$Columnas[8]="Retira";						$Valores[8]=$_REQUEST['TxtRetira'];
		$Columnas[9]="FechaDespacho";					$Valores[9]=$_REQUEST['TxtFecha'];
		$Columnas[10]="HoraDespacho";					$Valores[10]=$_REQUEST['TxtHora'];
		$Columnas[11]="Anticipo";					$Valores[11]=$_REQUEST['TxtAnticipo'];
		$Columnas[12]="Dias";			    			$Valores[12]=$_REQUEST['TxtDias'];
                $Columnas[13]="Estado";			    			$Valores[13]="A";
		$Columnas[14]="Usuarios_idUsuarios";			    	$Valores[14]=$idUser;
                $Columnas[15]="CentroCosto";			    		$Valores[15]=$_REQUEST["CmbCentroCostos"];
                
		$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                 
                
		$idRemision=$obVenta->ObtenerMAX("remisiones", "ID", 1, "");
                
                ///////////////////////////////Se ingresa a rem_relaciones
                
                $ConsultaItems=$obVenta->ConsultarTabla("cot_itemscotizaciones","WHERE NumCotizacion='$_REQUEST[TxtIdCotizacion]'");
                while($DatosItemsCotizacion=  mysql_fetch_array($ConsultaItems)){
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
                    
                    $idIngreso=$obVenta->RegistreAnticipo($_REQUEST['TxtidCliente'],$_REQUEST['TxtAnticipo'],$_REQUEST['CmbCuentaDestino'],$_REQUEST['CmbCentroCostos'],"Anticipo por remision $idRemision",$idUser);
                    $VariblesImpresion=$VariblesImpresion."&TxtidIngreso=$idIngreso";
                    
                }
                    header("location:Remisiones.php?$VariblesImpresion");	
	}
	
	
		
			
	
	?>