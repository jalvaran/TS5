<?php 

////////////////////////////////////(///////////////////////////////
//////////////////////FUNCIONES CALCULAR DIGITO DE VERIFICACION/////////////////////////////////////
///////////////////////////////////////////////////////////////////

    
    function calcularDV($nit) {
        if (! is_numeric($nit)) {
            return false;
        }
     
        $arr = array(1 => 3, 4 => 17, 7 => 29, 10 => 43, 13 => 59, 2 => 7, 5 => 19, 
        8 => 37, 11 => 47, 14 => 67, 3 => 13, 6 => 23, 9 => 41, 12 => 53, 15 => 71);
        $x = 0;
        $y = 0;
        $z = strlen($nit);
        $dv = '';
        
        for ($i=0; $i<$z; $i++) {
            $y = substr($nit, $i, 1);
            $x += ($y*$arr[$z-$i]);
        }
        
        $y = $x%11;
        
        if ($y > 1) {
            $dv = 11-$y;
            return $dv;
        } else {
            $dv = $y;
            return $dv;
        }
        
    }
    
    
   
	

	//////Creo una Preventa
	if(!empty($_REQUEST['BtnAgregarPreventa'])){
		
		$obVenta=new ProcesoVenta($idUser);
		$obVenta->CrearPreventa($idUser);// Crea otra preventa
		header("location:$myPage");
	}
	
	if(!empty($_REQUEST['TxtCodigoBarras'])){
		
		$CodBar=$_POST['TxtCodigoBarras'];
		$obVenta=new ProcesoVenta($idUser);
                $TablaItem="productosventa";
		$DatosCodigo=$obVenta->DevuelveValores('prod_codbarras',"CodigoBarras",$CodBar);
		//$DatosPreventa=$obVenta->DevuelveValores('vestasactivas',"idVestasActivas",$idPreventa);
		
		if($DatosCodigo['ProductosVenta_idProductosVenta']>0){
			$fecha=date("Y-m-d");
			$Cantidad=1;
			$obVenta->AgregaPreventa($fecha,$Cantidad,$idPreventa,$DatosCodigo['ProductosVenta_idProductosVenta'],$TablaItem);
		}else{
			
			print('<script language="JavaScript">alert("Este producto no esta en la base de datos por favor no lo entregue")</script>');
			
		}
		header("location:VentasRapidas.php?CmbPreVentaAct=$idPreventa");	
	}
	
	if(!empty($_REQUEST['del'])){
		$id=$_REQUEST['del'];
		$Tabla=$_REQUEST['TxtTabla'];
		$IdTabla=$_REQUEST['TxtIdTabla'];
		$IdPre=$_REQUEST['TxtIdPre'];
		mysql_query("DELETE FROM $Tabla WHERE $IdTabla='$id'") or die(mysql_error());
		header("location:$myPage?CmbPreVentaAct=$IdPre");
	}
		
	if(!empty($_REQUEST['CmbIDProducto'])){
		
		$DatosBuscar=  explode(";", $_REQUEST['CmbIDProducto']);
		$idItem=$DatosBuscar[0];
                if(isset($DatosBuscar[1])){
                    $TablaItem=$DatosBuscar[1];
                    $fecha=date("Y-m-d");
                    $Cantidad=1;

                    $obVenta=new ProcesoVenta($idUser);

                    $Cantidad=1;
                    $obVenta->AgregaPreventa($fecha,$Cantidad,$idPreventa,$idItem,$TablaItem);
                }
		header("location:VentasRapidas.php?CmbPreVentaAct=$idPreventa");
			
	}
	
	////Se recibe edicion
	
	if(!empty($_REQUEST['BtnEditarCantidad'])){
		$obVenta=new ProcesoVenta($idUser);
		$idItem=$_REQUEST['TxtPrecotizacion'];
		//$idClientes=$_REQUEST['TxtIdCliente'];
                $idPreventa=$_REQUEST['CmbPreVentaAct'];
		
		$Cantidad=$_REQUEST["TxtEditar$idItem"];
                //echo " $Cantidad $idItem";
		//$ValorAcordado=$_REQUEST['TxtValorUnitario'];
                $DatosPreventa=$obVenta->DevuelveValores("preventa", "idPrecotizacion", $idItem);
		$ValorAcordado=$DatosPreventa["ValorAcordado"];
		$idProducto=$DatosPreventa["ProductosVenta_idProductosVenta"];
		$Tabla=$DatosPreventa["TablaItem"];
		$Subtotal=$ValorAcordado*$Cantidad;
		$DatosProductos=$obVenta->DevuelveValores($Tabla,"idProductosVenta",$idProducto);
		$IVA=$Subtotal*$DatosProductos["IVA"];
		$SubtotalCosto=$DatosProductos["CostoUnitario"]*$Cantidad;
		$Total=$Subtotal+$IVA;
		$filtro="idPrecotizacion";
		
		$obVenta->ActualizaRegistro("preventa","Subtotal", $Subtotal, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","Impuestos", $IVA, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","TotalVenta", $Total, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","Cantidad", $Cantidad, $filtro, $idItem);
		
		
		header("location:$myPage?CmbPreVentaAct=$idPreventa");
			
	}
        
        ////Se recibe edicion
	
	if(!empty($_REQUEST['BtnEditar'])){
		$obVenta=new ProcesoVenta($idUser);
		$idItem=$_REQUEST['TxtPrecotizacion'];
		//$idClientes=$_REQUEST['TxtIdCliente'];
                $idPreventa=$_REQUEST['CmbPreVentaAct'];
		
		$ValorAcordado=$_REQUEST["TxtEditarPrecio$idItem"];
                //echo "<script>alert('Item $idItem VA $ValorAcordado')</script>";
		//$ValorAcordado=$_REQUEST['TxtValorUnitario'];
                $DatosPreventa=$obVenta->DevuelveValores("preventa", "idPrecotizacion", $idItem);
		$Cantidad=$DatosPreventa["Cantidad"];
		$idProducto=$DatosPreventa["ProductosVenta_idProductosVenta"];
		$Tabla=$DatosPreventa["TablaItem"];
		$Subtotal=$ValorAcordado*$Cantidad;
		$DatosProductos=$obVenta->DevuelveValores($Tabla,"idProductosVenta",$idProducto);
		$IVA=$Subtotal*$DatosProductos["IVA"];
		//$SubtotalCosto=$DatosProductos["CostoUnitario"]*$Cantidad;
		$Total=$Subtotal+$IVA;
		$filtro="idPrecotizacion";
		
		$obVenta->ActualizaRegistro("preventa","Subtotal", $Subtotal, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","Impuestos", $IVA, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","TotalVenta", $Total, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","ValorAcordado", $ValorAcordado, $filtro, $idItem);
		
		
		header("location:$myPage?CmbPreVentaAct=$idPreventa");
			
	}
	
	////Se guarda la Venta
	
	if(!empty($_REQUEST['TxtGranTotalH'])){
            //print("<script>alert('Entra 2')</script>");
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $idCliente=$_REQUEST["TxtCliente"];
            $idPreventa=$_REQUEST["CmbPreVentaAct"];
            $Efectivo=$_REQUEST["TxtPaga"];
            $Cheque=$_REQUEST["TxtPagaCheque"];
            $Tarjeta=$_REQUEST["TxtPagaTarjeta"];
            $idTarjeta=$_REQUEST["CmbIdTarjeta"];
            $OtrosPaga=$_REQUEST["TxtPagaOtros"];
            $Devuelta=$_REQUEST["TxtDevuelta"];
            $CuentaDestino=$_REQUEST["TxtCuentaDestino"];
            $TipoPago=$_REQUEST["TxtTipoPago"];
            $Observaciones="";
            $DatosVentaRapida["PagaCheque"]=$Cheque;
            $DatosVentaRapida["PagaTarjeta"]=$Tarjeta;
            $DatosVentaRapida["idTarjeta"]=$idTarjeta;
            $DatosVentaRapida["PagaOtros"]=$OtrosPaga;
            
            $DatosVentaRapida["CentroCostos"]=1;
            $DatosVentaRapida["ResolucionDian"]=1;
            
            $NumFactura=$obVenta->RegistreVentaRapida($idPreventa, $idCliente, $TipoPago, $Efectivo, $Devuelta, $CuentaDestino, $DatosVentaRapida);

            $obVenta->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
            $obVenta->ActualizaRegistro("vestasactivas","SaldoFavor", 0, "idVestasActivas", $idPreventa);
            $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
            if($DatosImpresora["Habilitado"]=="SI"){
                $obVenta->ImprimeFacturaPOS($NumFactura,$DatosImpresora["Puerto"],1);
            }
            header("location:$myPage?CmbPreVentaAct=$idPreventa&TxtidFactura=$NumFactura");
		
		
		
			
	}
	
	////Se guarda un separado
	
	if(isset($_REQUEST['BtnCrearSeparado'])){
		$fecha=date("Y-m-d");
		$Hora=date("H:i:s");
		
		$idPreventa=$_REQUEST['CmbPreVentaAct'];
                $idCliente=$_REQUEST['CmbClientes'];
                $Abono=$_REQUEST['TxtAbono'];
                if($idCliente<=1){
                    print("<script>alert('Debe seleccionar un Cliente para poder ejecutar esta accion')</script>");
                    exit("<a href='$myPage?CmbPreVentaAct=$idPreventa' ><h1>Volver</h1></a>");
                }
		        
		$obVenta=new ProcesoVenta($idUser);
		$DatosSeparado["Fut"]="";
		$idSeparado=$obVenta->RegistreSeparado($fecha,$Hora,$idPreventa,$idCliente,$Abono,$DatosSeparado);
                $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
                if($DatosImpresora["Habilitado"]=="SI"){
                    $obVenta->ImprimeSeparado($idSeparado, $DatosImpresora["Puerto"], 2);
                }
                $CuentaDestino="110510";
                $CentroCosto=1;
                $Concepto="ANTICIPO POR SEPARADO No $idSeparado";
                $VectorIngreso["fut"]="";
                $obVenta->RegistreAnticipo2($fecha,$CuentaDestino,$idCliente,$Abono,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
                header("location:$myPage?CmbPreVentaAct=$idPreventa&TxtidSeparado=$idSeparado");
				
	}
	
	
	////Se Crea un Cliente
	
	if(!empty($_REQUEST['BtnCrearCliente'])){
		
		
		//$idPreventa=$_REQUEST['CmbPreVentaAct'];
		$NIT=$_REQUEST['TxtNIT'];
                $idMun=$_REQUEST['CmbCodMunicipio'];
		$obVenta=new ProcesoVenta($idUser);
		$DatosClientes=$obVenta->DevuelveValores('clientes',"Num_Identificacion",$NIT);
                
                $DatosMunicipios=$obVenta->DevuelveValores('cod_municipios_dptos',"ID",$idMun);
		$DV="";
		
		
		if($DatosClientes["Num_Identificacion"]<>$NIT){
			
			///////////////////////////Ingresar a Clientes 
			
			if($_REQUEST['CmbTipoDocumento']==31){
			
				$DV=calcularDV($NIT);
		
			}
		
			$tab="clientes";
			$NumRegistros=15;  
								
			
			$Columnas[0]="Tipo_Documento";						$Valores[0]=$_REQUEST['CmbTipoDocumento'];
			$Columnas[1]="Num_Identificacion";					$Valores[1]=$_REQUEST['TxtNIT'];
			$Columnas[2]="DV";							$Valores[2]=$DV;
			$Columnas[3]="Primer_Apellido";						$Valores[3]=$_REQUEST['TxtPA'];
			$Columnas[4]="Segundo_Apellido";					$Valores[4]=$_REQUEST['TxtSA'];
			$Columnas[5]="Primer_Nombre";						$Valores[5]=$_REQUEST['TxtPN'];
			$Columnas[6]="Otros_Nombres";						$Valores[6]=$_REQUEST['TxtON'];
			$Columnas[7]="RazonSocial";						$Valores[7]=$_REQUEST['TxtRazonSocial'];
			$Columnas[8]="Direccion";						$Valores[8]=$_REQUEST['TxtDireccion'];
			$Columnas[9]="Cod_Dpto";						$Valores[9]=$DatosMunicipios["Cod_Dpto"];
			$Columnas[10]="Cod_Mcipio";						$Valores[10]=$DatosMunicipios["Cod_mcipio"];
			$Columnas[11]="Pais_Domicilio";						$Valores[11]=169;
			$Columnas[12]="Telefono";			    			$Valores[12]=$_REQUEST['TxtTelefono'];
			$Columnas[13]="Ciudad";			    				$Valores[13]=$DatosMunicipios["Ciudad"];
			$Columnas[14]="Email";			    				$Valores[14]=$_REQUEST['TxtEmail'];
			
			$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
				
			print("<script language='JavaScript'>alert('Se ha creado el Cliente $_REQUEST[TxtRazonSocial]')</script>");
			
		}else{
			
			print("<script language='JavaScript'>alert('El cliente con Identificacion: $NIT, ya existe y no se puede crear nuevamente')</script>");
		}	

		//header("location:VentaFacil.php?CmbPreVentaAct=$idPreventa");
		
			
	}
        
        
        /*
         * 
         * Imprimo el Cierre
         */
        
        ////Se Crea un Cliente
	
        if(!empty($_REQUEST['BtnCerrarTurno'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $VectorCierre["Fut"]=0;
            $idCaja=1;
            $idCierre=$obVenta->CierreTurno($idUser,$idCaja,$VectorCierre);
            $VectorCierre["idCierre"]=$idCierre;
            $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
                        
                if($DatosImpresora["Habilitado"]=="SI"){
                    
                    $obVenta->ImprimeCierre($idUser,$VectorCierre,$DatosImpresora["Puerto"],1);
                }
        }
        
        
        /*
         * Registra abonos de separados 
         */
        
              
        if(!empty($_REQUEST['TxtIdSeparado'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $Hora=date("H:i:s");
            $idSeparado=$_REQUEST['TxtIdSeparado'];
            $idPreventa=$_REQUEST['CmbPreVentaAct'];
            $Valor=$_REQUEST["TxtAbonoSeparado$idSeparado"];
            $VectorSeparados["Fut"]=0;
            $Saldo=$obVenta->RegistreAbonoSeparado($idSeparado,$Valor,$fecha,$Hora,$VectorSeparados);
            $idCliente=$_REQUEST['TxtIdClientes'];
            $CuentaDestino="110510";
            $CentroCosto=1;
            $Concepto="ABONO A SEPARADO No $idSeparado";
            $VectorIngreso["fut"]="";
            $obVenta->RegistreAnticipo2($fecha,$CuentaDestino,$idCliente,$Valor,$CentroCosto,$Concepto,$idUser,$VectorIngreso);
            $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
            if($Saldo==0){
                $VectorSeparados["Ft"]="";
                $CuentaDestino="110510";
                $NumFactura=$obVenta->CreaFacturaDesdeSeparado($idSeparado,$idPreventa,$CuentaDestino,$VectorSeparados);
               if($DatosImpresora["Habilitado"]=="SI"){
                $obVenta->ImprimeFacturaPOS($NumFactura,$DatosImpresora["Puerto"],1);
               }
            }
            
                if($DatosImpresora["Habilitado"]=="SI"){
                    $obVenta->ImprimeSeparado($idSeparado, $DatosImpresora["Puerto"], 2);
                    
            }
            header("location:$myPage?CmbPreVentaAct=$idPreventa&TxtidFactura=$NumFactura");
        }
        
         /*
         * Registra egresos 
         */
        
              
        if(isset($_REQUEST['BtnCrearEgreso'])){
            
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $FechaProgramada=$fecha;
            $Hora=date("H:i:s");
            $destino="";
            if(!empty($_FILES['foto']['name'])){
                 //echo "<script>alert ('entra foto')</script>";
                $carpeta="../SoportesEgresos/";
                opendir($carpeta);
                $Name=str_replace(' ','_',$_FILES['foto']['name']);  
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['foto']['tmp_name'],$destino);
            }
            
            $CuentaDestino=$_REQUEST['CmbCuentaDestino'];
            $NumFact=$_REQUEST["TxtNumFactura"];
            $Concepto=$_REQUEST["TxtConcepto"];
            $idProveedor=$_REQUEST["CmbProveedores"];
            $Subtotal=$_REQUEST["TxtSubtotalEgreso"];
            $IVA=$_REQUEST["TxtIVAEgreso"];
            $Total=$_REQUEST["TxtValorEgreso"];
            //Pendientes por definir de donde tomar los valores
            $CuentaOrigen=11051001;
            $CentroCostos=1;
            $CuentaPUCIVA=2408;
            ///
            //Constantes para este caso
            $TipoEgreso="VentasRapidas";
            $TipoPago="Contado";
            $Sanciones=0;
            $Intereses=0;
            $Impuestos=0;
            $ReteFuente=0;
            $ReteIVA=0;
            $ReteICA=0;
            $VectorEgreso["Fut"]=0;  //Uso futuro
            ///                
            
            $idEgreso=$obVenta->CrearEgreso($fecha,$FechaProgramada,$idUser,$CentroCostos,$TipoPago,$CuentaOrigen,$CuentaDestino,$CuentaPUCIVA,$idProveedor, $Concepto,$NumFact,$destino,$TipoEgreso,$Subtotal,$IVA,$Total,$Sanciones,$Intereses,$Impuestos,$ReteFuente,$ReteIVA,$ReteICA,$VectorEgreso);
            
            $DatosImpresora=$obVenta->DevuelveValores("config_puertos", "ID", 1);
            $VectorEgresos["Fut"]=1;
            if($DatosImpresora["Habilitado"]=="SI"){
                $obVenta->ImprimeEgresoPOS($idEgreso,$VectorEgresos,$DatosImpresora["Puerto"],1);
                    
            }
            header("location:$myPage?CmbPreVentaAct=$idPreventa&TxtIdEgreso=$idEgreso");
        }
        
        ///////////////Fin
        
	?>