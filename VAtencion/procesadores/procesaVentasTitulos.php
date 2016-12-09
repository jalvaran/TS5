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
                        $tab="proveedores";
                        $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
				
			print("<script language='JavaScript'>alert('Se ha creado el Cliente $_REQUEST[TxtRazonSocial]')</script>");
			
		}else{
			
			print("<script language='JavaScript'>alert('El cliente con Identificacion: $NIT, ya existe y no se puede crear nuevamente')</script>");
		}	

		//header("location:VentaFacil.php?CmbPreVentaAct=$idPreventa");
		
			
	}
        
        ////Se registra una venta de un titulo
	
	if(!empty($_REQUEST['BtnVenderTitulo'])){
            $Fecha=$obVenta->normalizar($_REQUEST['TxtFechaVenta']);
            $idCliente=$obVenta->normalizar($_REQUEST['TxtCliente']);
            $idColaborador=$obVenta->normalizar($_REQUEST['TxtColaborador']);
            $idPromocion=$obVenta->normalizar($_REQUEST['CmbPromocion']);
            $Mayor=$obVenta->normalizar($_REQUEST['TxtTitulo']);
            $Abono=$obVenta->normalizar($_REQUEST['TxtAbonoTitulo']);
            $CicloPago=$obVenta->normalizar($_REQUEST['CmbCicloPago']);
            
            $idVenta=$obVenta->RegistreVentaTitulo($Fecha, $idPromocion, $Mayor, $idColaborador, $idCliente, "");
            
            if($idVenta=="E"){
                $css->CrearNotificacionRoja("ERROR! El Titulo $Mayor de la promocion $idPromocion, ya fue vendido",16);
            }else{
                $css->CrearNotificacionVerde("Venta registrada con exito del Titulo $Mayor de la promocion $idPromocion",16);
            }
            
        }
        ///////////////Fin
?>