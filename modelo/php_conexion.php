<?php
	
	include_once 'php_settings.php';
	$CuentaDestino=110510;   //Cuenta Por defecto para caja menor
	$CuentaIngresos=4135;
	$TablaCuentaIngreso="cuentas";
	$CuentaIVAGen=2408;
	$TablaIVAGen="cuentas";
        $IDTablaIVAGen="idPUC";
	$RegCREE="SI";
        $CuentaCREE=135595;
        $ContraPartidaCREE=23657502;
	$CuentaCostoMercancia=6135;
	$CuentaInventarios=1435;
	$AjustaInventario="SI";
	$RegCREE="SI";
	$COMPrinter=3;
	$PrintCuenta="SI";
        $CuentaAnticipos=2705;
 
//////////////////////////////////////////////////////////////////////////
////////////Clase para guardar ventas ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

class ProcesoVenta{
	private $consulta;
	private $fetch;
	private $MaxNumCoti;
	private $idUser;
	private $NumCotizacion;
	private $NombreUser;
        public  $CuentaIVAGen=2408;
        public  $TablaIVAGen="cuentas";
        public  $IDTablaIVAGen="idPUC";
        public  $RegCREE="NO";
        public  $CuentaCREE=135595;
        public  $ContraPartidaCREE=23657502;
	public  $CuentaCostoMercancia=6135;
	public  $CuentaInventarios=1435;
              
	function __construct($idUserR){
		$idUserR=$this->normalizar($idUserR);		
		$this->consulta =mysql_query("SELECT Nombre, TipoUser FROM usuarios WHERE idUsuarios='$idUserR'") or die('problemas para consultas usuarios: ' . mysql_error());
		$this->fetch = mysql_fetch_array($this->consulta);
		$this->NombreUser = $this->fetch['Nombre'];
		$this->idUser=$idUserR;
                $this->TipoUser=$this->fetch['TipoUser'];
                
                //$this->VerificaPermisos($VectorPermisos);
	}
	
	/////////////////////Funcion que permite verificar u obtener los datos de la venta activa si extisten
	
	function ObtengaDatosEspacio(){
		
		return array($this->CotiUser,$this->NumVenta,$this->NumFactura);
	}
	
	/////////////////////Si no existen datos de venta activa deberá crearse
	
	function ObtengaEspacioVenta(){
		
		$this->consulta=mysql_query("SELECT MAX(NumCotizacion) as NumCotizacion, MAX(NumVenta) as NumVenta, MAX(NumFactura) as NumFactura  FROM vestasactivas") or die('problemas para consultas vestasactivas: ' . mysql_error());
		$this->fetch=mysql_fetch_array($this->consulta);
		$this->NumCotizacion = $this->fetch["NumCotizacion"]+1;
		$this->NumVenta = $this->fetch["NumVenta"]+1;
		$this->NumFactura = $this->fetch["NumFactura"]+1;
		if($this->CotiUser>0){
				
			mysql_query("UPDATE vestasactivas SET NumCotizacion='$this->NumCotizacion' WHERE Usuario_idUsuario='$this->idUser'") or die('problemas para actualizar vestasactivas: ' . mysql_error());
			
		}else{
						
			mysql_query("INSERT INTO vestasactivas (`Nombre`,`Usuario_idUsuario`,`Clientes_idClientes`, `NumCotizacion`,`NumVenta`,`NumFactura` ) 
						VALUES('Venta por: $this->NombreUser','$this->idUser','1','$this->NumCotizacion','$this->NumVenta','$this->NumFactura')") 
						or die('problemas para actualizar vestasactivas: ' . mysql_error());
		}

		
		return array($this->CotiUser,$this->NumVenta,$this->NumFactura);
	}
	
		
	/////Suma un valor en especifico de una tabla	
		
	function SumeColumna($Tabla,$NombreColumnaSuma, $NombreColumnaFiltro,$filtro){
	
	$Tabla=$this->normalizar($Tabla);
        $NombreColumnaSuma=$this->normalizar($NombreColumnaSuma);
        $NombreColumnaFiltro=$this->normalizar($NombreColumnaFiltro);
        $filtro=$this->normalizar($filtro);
		
	$sql="SELECT SUM($NombreColumnaSuma) AS suma FROM $Tabla WHERE $NombreColumnaFiltro = '$filtro'";
	
	$reg=mysql_query($sql) or die('no se pudo obtener la suma de $NombreColumnaSuma para la tabla $Tabla en SumeColumna: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	
	return($reg["suma"]);

	}	
        
        /////Suma un valor en especifico de una tabla segun una condicion
		
	function Sume($Tabla,$NombreColumnaSuma, $Condicion){
	
	
		
	$sql="SELECT SUM($NombreColumnaSuma) AS suma FROM $Tabla $Condicion";
	
	$reg=mysql_query($sql) or die('no se pudo obtener la suma de '.$sql.' '.$NombreColumnaSuma.' para la tabla '.$Tabla.' en SumeColumna: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	
	return($reg["suma"]);

	}	
	
	///Totaliza una venta
	
	function ObtengaTotalesVenta($NumVenta){
  
	$NumVenta=$this->normalizar($NumVenta);
		
	$sql="SELECT SUM(TotalVenta) AS TotalVenta, SUM(Impuestos) AS Impuestos, SUM(TotalCosto) AS TotalCosto FROM ventas 
	WHERE NumVenta = '$NumVenta'";
	
	$reg=mysql_query($sql) or die('no se pudo obtener los totales de la venta No $NumVenta en ObtengaTotalesVenta: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	
	$Subtotal=$reg["TotalVenta"]-$reg["Impuestos"];
	$GranTotal=$reg["TotalVenta"];
	return array($Subtotal,$reg["Impuestos"],$reg["TotalVenta"],$reg["TotalCosto"], $GranTotal);

	}	
	
	//////Funcion para insertar un Registro a un tabla
	
	public function InsertarRegistro($tabla,$NumRegistros,$Columnas,$Valores){
  
  	$tabla=$this->normalizar($tabla);
        
      
	$sql="INSERT INTO $tabla (";
	$fin=$NumRegistros-1;
	for($i=0;$i<$NumRegistros;$i++){
		$col=$Columnas[$i];
		$reg=$this->normalizar($Valores[$i]);
		if($fin<>$i)
			$sql=$sql."`$col`,";
		else	
			$sql=$sql."`$col`)";
	}
	$sql=$sql."VALUES (";
	
	for($i=0;$i<$NumRegistros;$i++){
		
		$reg=$Valores[$i];
		if($fin<>$i)
			$sql=$sql."'$reg',";
		else	
			$sql=$sql."'$reg')";
	}
	
	
	mysql_query($sql) or die("no se pudo ingresar el registro en la tabla $tabla desde la funcion Insertar Registro: " . mysql_error());	
		
}


////////////////////////////////////////////////////////////////////
//////////////////////Funcion devuelve valores
///////////////////////////////////////////////////////////////////

public function DevuelveValores($tabla,$ColumnaFiltro, $idItem){
        $tabla=$this->normalizar($tabla);
        $ColumnaFiltro=$this->normalizar($ColumnaFiltro);
        $idItem=$this->normalizar($idItem);
        $reg=mysql_query("select * from $tabla where $ColumnaFiltro = '$idItem'") or die("no se pudo consultar los valores de la tabla $tabla en DevuelveValores: " . mysql_error());
        $reg=mysql_fetch_array($reg);	
        return ($reg);
}
        
////////////////////////////////////////////////////////////////////
//////////////////////Funcion devuelve el valor de una columna
///////////////////////////////////////////////////////////////////

public function ValorActual($tabla,$Columnas,$Condicion){

        $reg=mysql_query("SELECT $Columnas FROM $tabla WHERE $Condicion") or die("no se pudo consultar los valores de la tabla $tabla en ValorActual: " . mysql_error());
        $reg=mysql_fetch_array($reg);	
        return ($reg);
}

////////////////////////////////////////////////////////////////////
//////////////////////Funcion realiza asiento contable factura
///////////////////////////////////////////////////////////////////

public function RegFactLibroDiario($NumFact,$CuentaDestino,$CuentaIngresos,$TablaCuentaIngreso,$CuentaIVAGen, $TablaIVAGen, $CuentaCostoMercancia,$CuentaInventarios,$AjustaInventario,$RegCREE){

        

        $DatosFactura=$this->DevuelveValores("facturas","idFacturas",$NumFact);
        $fecha=	$DatosFactura["Fecha"];	
        $idFact=$DatosFactura["idFacturas"];
        $TotalVenta=$DatosFactura["Total"];
        $Subtotal=$DatosFactura["Subtotal"];
        $Impuestos=$DatosFactura["IVA"];
        $TotalCostosM=$DatosFactura["TotalCostos"];


        $DatosCliente=$this->DevuelveValores("clientes","idClientes",$DatosFactura['Clientes_idClientes']);
        $idCliente=$DatosFactura['Clientes_idClientes'];
        $NIT=$DatosCliente["Num_Identificacion"];
        $RazonSocialC=$DatosCliente["RazonSocial"];

        $tab="librodiario";
        $NumRegistros=24;

        if($DatosFactura['FormaPago']=="Contado"){
                $CuentaPUC=$CuentaDestino;
                $DatosCuenta=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaPUC);

                $NombreCuenta=$DatosCuenta["Nombre"];
        }else{	
                $CuentaPUC="130505";
                $NombreCuenta="Clientes Nacionales $RazonSocialC NIT $NIT";
        }


        $Columnas[0]="Fecha";					$Valores[0]=$fecha;
        $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="FACTURA";
        $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idFact;
        $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
        $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
        $Columnas[5]="Tercero_DV";				$Valores[5]=$DatosCliente['DV'];
        $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
        $Columnas[7]="Tercero_Segundo_Apellido";$Valores[7]=$DatosCliente['Segundo_Apellido'];
        $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
        $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
        $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
        $Columnas[11]="Tercero_Direccion";		$Valores[11]=$DatosCliente['Direccion'];
        $Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]=$DatosCliente['Cod_Dpto'];
        $Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]=$DatosCliente['Cod_Mcipio'];
        $Columnas[14]="Tercero_Pais_Domicilio";  $Valores[14]=$DatosCliente['Pais_Domicilio'];

        $Columnas[15]="CuentaPUC";				$Valores[15]=$CuentaPUC;
        $Columnas[16]="NombreCuenta";			$Valores[16]=$NombreCuenta;
        $Columnas[17]="Detalle";				$Valores[17]="ventas";
        $Columnas[18]="Debito";					$Valores[18]=$TotalVenta;
        $Columnas[19]="Credito";				$Valores[19]="0";
        $Columnas[20]="Neto";					$Valores[20]=$Valores[18];
        $Columnas[21]="Mayor";					$Valores[21]="NO";
        $Columnas[22]="Esp";					$Valores[22]="NO";
        $Columnas[23]="Concepto";				$Valores[23]="Ventas Por Atn Admin";

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


        ///////////////////////Registramos ingresos

        $CuentaPUC=$CuentaIngresos; //4135   comercio al por menor y mayor

        $DatosCuenta=$this->DevuelveValores($TablaCuentaIngreso,"idPUC",$CuentaPUC);
        $NombreCuenta=$DatosCuenta["Nombre"];

        $Valores[15]=$CuentaPUC;
        $Valores[16]=$NombreCuenta;
        $Valores[18]="0";
        $Valores[19]=$Subtotal; 			//Credito se escribe el total de la venta menos los impuestos
        $Valores[20]=$Valores[19]*(-1);  											//Credito se escribe el total de la venta menos los impuestos

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        ///////////////////////Registramos IVA Generado si aplica

        if($Impuestos<>0){

                $CuentaPUC=$CuentaIVAGen; //2408   IVA Generado

                $DatosCuenta=$this->DevuelveValores($TablaIVAGen,"idPUC",$CuentaPUC);

                $NombreCuenta=$DatosCuenta["Nombre"];

                $Valores[15]=$CuentaPUC;
                $Valores[16]=$NombreCuenta;
                $Valores[18]="0";
                $Valores[19]=round($Impuestos); 			//Credito se escribe el total de la venta
                $Valores[20]=$Valores[19]*(-1);  	//para la sumatoria contemplar el balance

                $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        }


                                ///////////////////////////////////////////////////////////////
        ////////////Registramos Autoretencion
        if($RegCREE=="SI"){

                $CREE=$this->DevuelveValores("impret","Nombre","CREE");

                $ValorCREE=round($Subtotal*$CREE['Valor']);

                $CuentaPUC=135595; //  Autorretenciones CREE

                $DatosCuenta=$this->DevuelveValores("subcuentas","PUC",$CuentaPUC);
                $NombreCuenta=$DatosCuenta["Nombre"];

                $Valores[15]=$CuentaPUC;
                $Valores[16]=$NombreCuenta;
                $Valores[18]=$ValorCREE;     //Valor del CREE
                $Valores[19]=0; 			
                $Valores[20]=$ValorCREE;  	//para la sumatoria contemplar el balance

                $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        ///////////////////////////////////////////////////////////////
        ////////////contra partida de la Autoretencion

                $CuentaPUC=23657502; //  Cuentas por pagar Autorretenciones CREE

                $DatosCuenta=$this->DevuelveValores("subcuentas","PUC",$CuentaPUC);
                $NombreCuenta=$DatosCuenta["Nombre"];

                $Valores[15]=$CuentaPUC;
                $Valores[16]=$NombreCuenta;
                $Valores[18]=0;     //Valor del CREE
                $Valores[19]=$ValorCREE; 			
                $Valores[20]=$ValorCREE*(-1);  	//para la sumatoria contemplar el balance

                $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

                }

                ///////////////////////Ajustamos el inventario

                if($AjustaInventario=="SI"){

                        $CuentaPUC=$CuentaCostoMercancia; //6135   costo de mercancia vendida

                        $DatosCuenta=$this->DevuelveValores('cuentas',"idPUC",$CuentaPUC);
                        $NombreCuenta=$DatosCuenta["Nombre"];

                        $Valores[15]=$CuentaPUC;
                        $Valores[16]=$NombreCuenta;
                        $Valores[18]=$TotalCostosM;//Debito se escribe el costo de la mercancia vendida
                        $Valores[19]="0"; 			
                        $Valores[20]=$TotalCostosM;  	//para la sumatoria contemplar el balance

                        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

                        ///////////////////////Ajustamos el inventario

                        $CuentaPUC=$CuentaInventarios; //1435   Mercancias no fabricadas por la empresa

                        $DatosCuenta=$this->DevuelveValores('cuentas',"idPUC",$CuentaPUC);
                        $NombreCuenta=$DatosCuenta["Nombre"];

                        $Valores[15]=$CuentaPUC;
                        $Valores[16]=$NombreCuenta;
                        $Valores[18]="0";
                        $Valores[19]=$TotalCostosM;//Credito se escribe el costo de la mercancia vendida			
                        $Valores[20]=$TotalCostosM*(-1);  	//para la sumatoria contemplar el balance

                        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

                }
}	


        
/*
 * Funcion realiza asiento contable facturas item por item
 */

    public function InsertarFacturaLibroDiario($Datos){

            $idFact=$Datos["ID"];		
            $DatosFactura=$this->DevuelveValores("facturas","idFacturas",$idFact);
            $fecha=	$DatosFactura["Fecha"];	
            $CuentaDestino=$Datos["CuentaDestino"];
            $DatosCliente=$this->DevuelveValores("clientes","idClientes",$DatosFactura['Clientes_idClientes']);
            $idCliente=$DatosFactura['Clientes_idClientes'];
            $NIT=$DatosCliente["Num_Identificacion"];
            $RazonSocialC=$DatosCliente["RazonSocial"];
            $EmpresaPro=$Datos["EmpresaPro"];
            $CentroCostos=$Datos["CentroCostos"];
            $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
            $sql="SELECT CuentaPUC, TipoItem, sum(SubtotalItem) as SubtotalItem,sum(TotalItem) as TotalItem,sum(IVAItem) as IVAItem ,sum(SubtotalCosto) as SubtotalCosto  "
                    . "FROM facturas_items WHERE idFactura='$idFact' GROUP BY CuentaPUC";
            $Consulta=$this->Query($sql);
            
              
            $tab="librodiario";
            $NumRegistros=27;
            while($DatosItems=$this->FetchArray($Consulta)){
                
		$Subtotal=$DatosItems["SubtotalItem"];
                $Total=$DatosItems["TotalItem"];
                $Impuestos=$DatosItems["IVAItem"];
                $TotalCostosM=$DatosItems["SubtotalCosto"];
		if($DatosFactura['FormaPago']=="Contado"){
			$CuentaPUC=$CuentaDestino;
			$DatosCuenta=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaPUC);
			
			$NombreCuenta=$DatosCuenta["Nombre"];
		}else{	
			$CuentaPUC="1305";
			$NombreCuenta="Clientes Nacionales $RazonSocialC NIT $NIT";
		}
		
		
		$Columnas[0]="Fecha";			$Valores[0]=$fecha;
		$Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="FACTURA";
		$Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idFact;
		$Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
		$Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
		$Columnas[5]="Tercero_DV";		$Valores[5]=$DatosCliente['DV'];
		$Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
		$Columnas[7]="Tercero_Segundo_Apellido";$Valores[7]=$DatosCliente['Segundo_Apellido'];
		$Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
		$Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
		$Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
		$Columnas[11]="Tercero_Direccion";      $Valores[11]=$DatosCliente['Direccion'];
		$Columnas[12]="Tercero_Cod_Dpto";	$Valores[12]=$DatosCliente['Cod_Dpto'];
		$Columnas[13]="Tercero_Cod_Mcipio";	$Valores[13]=$DatosCliente['Cod_Mcipio'];
		$Columnas[14]="Tercero_Pais_Domicilio"; $Valores[14]=$DatosCliente['Pais_Domicilio'];
		
		$Columnas[15]="CuentaPUC";		$Valores[15]=$CuentaPUC;
		$Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
		$Columnas[17]="Detalle";		$Valores[17]="Ventas";
		$Columnas[18]="Debito";			$Valores[18]=$Total;
		$Columnas[19]="Credito";		$Valores[19]="0";
		$Columnas[20]="Neto";			$Valores[20]=$Valores[18];
		$Columnas[21]="Mayor";			$Valores[21]="NO";
		$Columnas[22]="Esp";			$Valores[22]="NO";
		$Columnas[23]="Concepto";		$Valores[23]="Ventas";
		$Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCostos;
		$Columnas[25]="idEmpresa";		$Valores[25]=$EmpresaPro;
                $Columnas[26]="idSucursal";		$Valores[26]=$DatosSucursal["ID"];
                
		$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		
		///////////////////////Registramos ingresos
		
		$CuentaPUC=$DatosItems["CuentaPUC"]; 
		$Longitud=strlen($CuentaPUC);
                if($Longitud>4){
                    $TablaCuenta="subcuentas";
                    $idTablaCuenta="PUC";
                }else{
                    $TablaCuenta="cuentas";
                    $idTablaCuenta="idPUC";
                }
		$DatosCuenta=$this->DevuelveValores($TablaCuenta,$idTablaCuenta,$CuentaPUC);
		$NombreCuenta=$DatosCuenta["Nombre"];
		
		$Valores[15]=$CuentaPUC;
		$Valores[16]=$NombreCuenta;
		$Valores[18]="0";
		$Valores[19]=$Subtotal;
		$Valores[20]=$Valores[19]*(-1);  											//Credito se escribe el total de la venta menos los impuestos
		
		$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		///////////////////////Registramos IVA Generado si aplica
		
		if($Impuestos<>0){
		
                    $CuentaPUC=$this->CuentaIVAGen; //2408   IVA Generado
                    $DatosCuenta=$this->DevuelveValores($this->TablaIVAGen,$this->IDTablaIVAGen,$CuentaPUC);

                    $NombreCuenta=$DatosCuenta["Nombre"];

                    $Valores[15]=$CuentaPUC;
                    $Valores[16]=$NombreCuenta;
                    $Valores[18]="0";
                    $Valores[19]=round($Impuestos); 			//Credito se escribe el total de la venta
                    $Valores[20]=$Valores[19]*(-1);  	//para la sumatoria contemplar el balance

                    $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		}
					
					
					///////////////////////////////////////////////////////////////
		////////////Registramos Autoretencion
		if($this->RegCREE=="SI"){
			
			$CREE=$this->DevuelveValores("impret","Nombre","CREE");
			
			$ValorCREE=round($Subtotal*$CREE['Valor']);
			
			$CuentaPUC=$this->CuentaCREE; //  Autorretenciones CREE
			
			$DatosCuenta=$this->DevuelveValores("subcuentas","PUC",$CuentaPUC);
			$NombreCuenta=$DatosCuenta["Nombre"];
			
			$Valores[15]=$CuentaPUC;
			$Valores[16]=$NombreCuenta;
			$Valores[18]=$ValorCREE;     //Valor del CREE
			$Valores[19]=0; 			
			$Valores[20]=$ValorCREE;  	//para la sumatoria contemplar el balance
			
			$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		///////////////////////////////////////////////////////////////
		////////////contra partida de la Autoretencion
		
			$CuentaPUC=$this->ContraPartidaCREE; //  Cuentas por pagar Autorretenciones CREE
			
			$DatosCuenta=$this->DevuelveValores("subcuentas","PUC",$CuentaPUC);
			$NombreCuenta=$DatosCuenta["Nombre"];
			
			$Valores[15]=$CuentaPUC;
			$Valores[16]=$NombreCuenta;
			$Valores[18]=0;     //Valor del CREE
			$Valores[19]=$ValorCREE; 			
			$Valores[20]=$ValorCREE*(-1);  	//para la sumatoria contemplar el balance
			
			$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
			
			}
					
			///////////////////////Ajustamos el inventario
                        
			if($DatosItems["TipoItem"]=="PR"){
				
				$CuentaPUC=$this->CuentaCostoMercancia; //6135   costo de mercancia vendida
				
				$DatosCuenta=$this->DevuelveValores('cuentas',"idPUC",$CuentaPUC);
				$NombreCuenta=$DatosCuenta["Nombre"];
				
				$Valores[15]=$CuentaPUC;
				$Valores[16]=$NombreCuenta;
				$Valores[18]=$TotalCostosM;//Debito se escribe el costo de la mercancia vendida
				$Valores[19]="0"; 			
				$Valores[20]=$TotalCostosM;  	//para la sumatoria contemplar el balance
				
				$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
				
				///////////////////////Ajustamos el inventario
				
				$CuentaPUC=$this->CuentaInventarios; //1435   Mercancias no fabricadas por la empresa
				
				$DatosCuenta=$this->DevuelveValores('cuentas',"idPUC",$CuentaPUC);
				$NombreCuenta=$DatosCuenta["Nombre"];
				
				$Valores[15]=$CuentaPUC;
				$Valores[16]=$NombreCuenta;
				$Valores[18]="0";
				$Valores[19]=$TotalCostosM;//Credito se escribe el costo de la mercancia vendida			
				$Valores[20]=$TotalCostosM*(-1);  	//para la sumatoria contemplar el balance
				
				$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
				
			}

            }



    }        
	////////////////////////////////////////////////////////////////////
//////////////////////Funcion imprima factura
///////////////////////////////////////////////////////////////////

public function ImprimeFactura($NumFactura,$COMPrinter,$PrintCuenta,$ruta){

        header("location:../printer/imprimir.php?print=$NumFactura&ruta=$ruta");
}	

////////////////////////////////////////////////////////////////////
//////////////////////Funcion borra registro
///////////////////////////////////////////////////////////////////

	public function BorraReg($Tabla,$Filtro,$idFiltro){
            $Tabla=  $this->normalizar($Tabla);
            $Filtro=  $this->normalizar($Filtro);
            $idFiltro=  $this->normalizar($idFiltro);
            mysql_query("DELETE FROM $Tabla WHERE $Filtro='$idFiltro'");
	}
	
	////////////////////////////////////////////////////////////////////
//////////////////////Funcion reiniciar preventa
///////////////////////////////////////////////////////////////////

	public function ReiniciarPreventa($idPreventa){
                $idPreventa=  $this->normalizar($idPreventa);
		$sql="UPDATE `vestasactivas` SET `Clientes_idClientes` = '1', `SaldoFavor` = '0' WHERE `idVestasActivas` = $idPreventa;";

		mysql_query($sql) or die('no se pudo actualizar la Preventa: ' . mysql_error());	
	}

////////////////////////////////////////////////////////////////////
//////////////////////Funcion crea Preventa
///////////////////////////////////////////////////////////////////

	public function CrearPreventa($idUser){
            $idUser=  $this->normalizar($idUser);
		
            $sql="INSERT INTO vestasactivas (`Nombre`,`Usuario_idUsuario`,`Clientes_idClientes` ) 
                                    VALUES('Venta por: $this->NombreUser','$this->idUser','1')";
            $this->Query($sql);        	
		
		
	}	
	
	
////////////////////////////////////////////////////////////////////
//////////////////////Funcion agregar preventa
///////////////////////////////////////////////////////////////////


public function AgregaPreventa($fecha,$Cantidad,$idVentaActiva,$idProducto,$TablaItem)
  {
        $fecha=$this->normalizar($fecha);
        $Cantidad=$this->normalizar($Cantidad);
        $idVentaActiva=$this->normalizar($idVentaActiva);
        $idProducto=$this->normalizar($idProducto);
        $TablaItem=$this->normalizar($TablaItem);
        
	$DatosProductoGeneral=$this->DevuelveValores($TablaItem, "idProductosVenta", $idProducto);
        $DatosDepartamento=$this->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosProductoGeneral["Departamento"]);
        $DatosTablaItem=$this->DevuelveValores("tablas_ventas", "NombreTabla", $TablaItem);
        $TipoItem=$DatosDepartamento["TipoItem"];
        $consulta=$this->ConsultarTabla("preventa", "WHERE TablaItem='$TablaItem' AND ProductosVenta_idProductosVenta='$idProducto' AND VestasActivas_idVestasActivas='$idVentaActiva' ORDER BY idPrecotizacion DESC");
        $DatosProduto=$this->FetchArray($consulta);
	if($DatosProduto["Cantidad"]>0){
            
            $Cantidad=$DatosProduto["Cantidad"]+$Cantidad;
            $Subtotal=$DatosProduto["ValorAcordado"]*$Cantidad;
            $Impuestos=$DatosProductoGeneral["IVA"]*$Subtotal;
            $TotalVenta=$Subtotal+$Impuestos;
            $sql="UPDATE preventa SET Subtotal='$Subtotal', Impuestos='$Impuestos', TotalVenta='$TotalVenta', Cantidad='$Cantidad' WHERE idPrecotizacion='$DatosProduto[idPrecotizacion]'";
            //$sql="UPDATE preventa SET Subtotal='$Subtotal', Impuestos='$Impuestos', TotalVenta='$TotalVenta', Cantidad='$Cantidad' WHERE TablaItem='$TablaItem' AND ProductosVenta_idProductosVenta='$idProducto' AND VestasActivas_idVestasActivas='$idVentaActiva'";
            $this->Query($sql);
        }else{
            $reg=mysql_query("select * from fechas_descuentos where (Departamento = '$DatosProductoGeneral[Departamento]' OR Departamento ='0') AND (Sub1 = '$DatosProductoGeneral[Sub1]' OR Sub1 ='0')  ORDER BY idFechaDescuentos DESC LIMIT 1") or die('no se pudo consultar los valores de fechas descuentos en AgregaPreventa: ' . mysql_error());
            $reg=mysql_fetch_array($reg);
            $Porcentaje=$reg["Porcentaje"];
            $Departamento=$reg["Departamento"];
            $FechaDescuento=$reg["Fecha"];
            
            $impuesto=$DatosProductoGeneral["IVA"];
            $impuesto=$impuesto+1;
            if($DatosTablaItem["IVAIncluido"]=="SI"){
                $ValorUnitario=$DatosProductoGeneral["PrecioVenta"]/$impuesto;
                
            }else{
                $ValorUnitario=$DatosProductoGeneral["PrecioVenta"];
                
            }
            if($Porcentaje>0 and $FechaDescuento==$fecha){

                    $Porcentaje=(100-$Porcentaje)/100;
                    $ValorUnitario=$ValorUnitario*$Porcentaje;

            }

            $Subtotal=$ValorUnitario*$Cantidad;
            $impuesto=($impuesto-1)*$Subtotal;
            $Total=$Subtotal+$impuesto;


            $sql="INSERT INTO `preventa` ( `Fecha`, `Cantidad`, `VestasActivas_idVestasActivas`, `ProductosVenta_idProductosVenta`, `ValorUnitario`,`ValorAcordado`, `Subtotal`, `Impuestos`, `TotalVenta`, `TablaItem`, `TipoItem`)
                    VALUES ('$fecha', '$Cantidad', '$idVentaActiva', '$idProducto', '$ValorUnitario','$ValorUnitario', '$Subtotal', '$impuesto', '$Total', '$TablaItem', '$TipoItem');";

            $this->Query($sql) or die('no se pudo guardar el item en preventa: ' . mysql_error());	
	
        }
	}	
        
        
        
	
	////////////////////////////////////////////////////////////////////
//////////////////////Funcion Actualizar registro en tabla
///////////////////////////////////////////////////////////////////


public function ActualizaRegistro($tabla,$campo, $value, $filtro, $idItem)
  {		
	$tabla=$this->normalizar($tabla);
        $campo=$this->normalizar($campo);
        $value=$this->normalizar($value);
        $filtro=$this->normalizar($filtro);
        $idItem=$this->normalizar($idItem);
        
	$sql="UPDATE `$tabla` SET `$campo` = '$value' WHERE `$filtro` = '$idItem'";
	
	mysql_query($sql) or die('no se pudo actualizar el registro en la $tabla: ' . mysql_error());	
		
	}
        
        ////////////////////////////////////////////////////////////////////
//////////////////////Funcion Actualizar registro en tabla
///////////////////////////////////////////////////////////////////


public function update($tabla,$campo, $value, $condicion)
  {		
	
	$sql="UPDATE `$tabla` SET `$campo` = '$value' $condicion";
	
	mysql_query($sql) or die('no se pudo actualizar el registro en la $tabla: ' . mysql_error());	
		
	}
	

	
	////////////////////////////////////////////////////////////////////
//////////////////////Funcion Obtener Ultimo ID de una Tabla
///////////////////////////////////////////////////////////////////


public function ObtenerMAX($tabla,$campo, $filtro, $idItem)
  {	
        $tabla=$this->normalizar($tabla);
        $campo=$this->normalizar($campo);
        $filtro=$this->normalizar($filtro);
        $idItem=$this->normalizar($idItem);
	if($filtro==1){
		$sql="SELECT MAX($campo) AS MaxNum FROM `$tabla`";
	}else{
		$sql="SELECT MAX($campo) AS MaxNum FROM `$tabla` WHERE `$filtro` = '$idItem'";
	}
		
	$Reg=mysql_query($sql) or die('no se pudo actualizar el registro en la $tabla: ' . mysql_error());	
	$MN=mysql_fetch_array($Reg);
	return($MN["MaxNum"]);	
	}
			
////////////////////////////////////////////////////////////////////
//////////////////////Funcion Obtener vaciar una tabla
///////////////////////////////////////////////////////////////////
public function VaciarTabla($tabla)
  {		
	$tabla=$this->normalizar($tabla);
	$sql="TRUNCATE `$tabla`";
	
	mysql_query($sql) or die('no se pudo vaciar la tabla $tabla: ' . mysql_error());	
		
	}

	
	
////////////////////////////////////////////////////////////////////
//////////////////////Funcion Obtener inicializar las preventas
///////////////////////////////////////////////////////////////////
public function InicializarPreventas()
  {		
		$this->BorraReg("vestasactivas","Usuario_idUsuario","INI");
		$MaxFact=$this->ObtenerMAX("facturas","idFacturas", "1", "");
		$MaxCoti=$this->ObtenerMAX("cotizaciones","NumCotizacion", "1", "");
		$MaxNumVenta=$this->ObtenerMAX("ventas","NumVenta", "1", "");
		
		$tab="vestasactivas";
		$NumRegistros=6;
					
		$Columnas[0]="Nombre";				$Valores[0]="INICIALIZACION";
		$Columnas[1]="Usuario_idUsuario";	$Valores[1]="INI";
		$Columnas[2]="Clientes_idClientes";	$Valores[2]="1";
		$Columnas[3]="NumVenta";			$Valores[3]=$MaxNumVenta;
		$Columnas[4]="NumFactura";			$Valores[4]=$MaxFact;
		$Columnas[5]="NumCotizacion";		$Valores[5]=$MaxCoti;
											
		$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		$sql="UPDATE `usuarios` SET Role=''";
	
		mysql_query($sql) or die('no se pudo actualizar los usuarios: ' . mysql_error());	
		
	}
	
////////////////////////////////////////////////////////////////////
//////////////////////Funcion Habilitar un espacio disponible
///////////////////////////////////////////////////////////////////
public function AsignarEspacioDisponible($idUser)
  {		
		$sql="SELECT (t1.idFacturas + 1) as gap_starts_at, (SELECT MIN(t3.idFacturas) -1 FROM facturas t3 WHERE t3.idFacturas > t1.idFacturas) as gap_ends_at FROM facturas t1 
		WHERE NOT EXISTS (SELECT t2.idFacturas FROM facturas t2 WHERE t2.idFacturas = t1.idFacturas + 1) HAVING gap_ends_at IS NOT NULL";
		$this->CrearPreventa($idUser);
		$DatosVenta=$this->DevuelveValores("vestasactivas","Usuario_idUsuario",$idUser);
			
		$Consul=mysql_query($sql) or die('no se pudo actualizar los usuarios: ' . mysql_error());
		while($DatosDispo=mysql_fetch_array($Consul)){
		
		$FactDispo=$DatosDispo['gap_starts_at'];
		$Ocupado=$this->DevuelveValores("vestasactivas","NumFactura",$FactDispo);
		if($FactDispo < $DatosVenta['NumFactura'] AND $Ocupado["NumFactura"]<>$FactDispo){
			$this->ActualizaRegistro("vestasactivas","NumVenta", $FactDispo, "Usuario_idUsuario", $idUser);
			$this->ActualizaRegistro("vestasactivas","NumFactura", $FactDispo, "Usuario_idUsuario", $idUser);
			
		}
		
		}
		//print("<script language='JavaScript'>alert('Factura $DatosVenta[NumFactura], Cotizacion $DatosVenta[NumCotizacion], Venta $DatosVenta[NumVenta], Ini $DatosDispo[gap_starts_at] , FIN $DatosDispo[gap_ends_at]')</script>");
		
	}	

////////////////////////////////////////////////////////////////////
//////////////////////Funcion consultar una tabla
///////////////////////////////////////////////////////////////////
public function ConsultarTabla($tabla,$Condicion)
  {		
    $sql="SELECT * FROM $tabla $Condicion";


    $Consul=mysql_query($sql) or die("no se pudo consultar la tabla $tabla en CosultarTabla php_conexion: " . mysql_error());

    return($Consul);
}	
	
////////////////////////////////////////////////////////////////////
//////////////////////Funcion query mysql
///////////////////////////////////////////////////////////////////
public function Query($sql)
  {		
					
    $Consul=mysql_query($sql) or die("<pre>no se pudo realizar la consulta $sql en query php_conexion: " . mysql_error()."</pre>");
    return($Consul);
}

////////////////////////////////////////////////////////////////////
//////////////////////Funcion fetcharray mysql
///////////////////////////////////////////////////////////////////
public function FetchArray($Datos)
  {		
					
    $Vector=  mysql_fetch_array($Datos);
    return($Vector);
}
////////////////////////////////////////////////////////////////////
//////////////////////Funcion Registra Anticipo
///////////////////////////////////////////////////////////////////

	public function RegistreAnticipo($idCliente,$Anticipo, $CuentaDestino,$CentroCosto,$Concepto,$idUser){
            $fecha=date("Y-m-d");
            $DatosCentro=$this->DevuelveValores("centrocosto","ID",$CentroCosto);
            $DatosCliente=$this->DevuelveValores("clientes","idClientes",$idCliente);
            $DatosCuentasFrecuentes=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaDestino);
            $NIT=$DatosCliente["Num_Identificacion"];
            $RazonSocialC=$DatosCliente["RazonSocial"];
            
            //////Creo el comprobante de Ingreso
            
            $tab="comprobantes_ingreso";
            $NumRegistros=6;

            $Columnas[0]="Fecha";		$Valores[0]=$fecha;
            $Columnas[1]="Clientes_idClientes";	$Valores[1]=$idCliente;
            $Columnas[2]="Valor";               $Valores[2]=$Anticipo;
            $Columnas[3]="Tipo";		$Valores[3]="EFECTIVO";
            $Columnas[4]="Concepto";		$Valores[4]=$Concepto;
            $Columnas[5]="Usuarios_idUsuarios";	$Valores[5]=$idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            $idIngreso=$this->ObtenerMAX($tab,"ID", 1,"");
            
            ////Registro el anticipo en el libro diario
            
            $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
            
            $tab="librodiario";
            $NumRegistros=27;
            $CuentaPUC=$CuentaDestino;
            $NombreCuenta=$DatosCuentasFrecuentes["Nombre"];
            $CuentaPUCContraPartida="238020".$NIT;
            $NombreCuentaContraPartida="Anticipos recibidos Cliente: $RazonSocialC NIT $NIT";
            


            $Columnas[0]="Fecha";			$Valores[0]=$fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="ComprobanteIngreso";
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idIngreso;
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
            $Columnas[5]="Tercero_DV";			$Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
            $Columnas[11]="Tercero_Direccion";		$Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];
            $Columnas[15]="CuentaPUC";			$Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";			$Valores[17]="Anticipos";
            $Columnas[18]="Debito";			$Valores[18]=$Anticipo;
            $Columnas[19]="Credito";			$Valores[19]="0";
            $Columnas[20]="Neto";			$Valores[20]=$Valores[18];
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";			$Valores[23]=$Concepto;
            $Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCosto;
            $Columnas[25]="idEmpresa";			$Valores[25]=$DatosCentro["EmpresaPro"];
            $Columnas[26]="idSucursal";                 $Valores[26]=$DatosSucursal["ID"];

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


            ///////////////////////Registramos contra partida del anticipo

            $CuentaPUC=$CuentaPUCContraPartida; 
            $NombreCuenta=$NombreCuentaContraPartida;

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]="0";
            $Valores[19]=$Anticipo; 			//Credito se escribe el total de la venta menos los impuestos
            $Valores[20]=$Valores[19]*(-1);  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
            return($idIngreso);
	}
        
/*
 * Funcion Registra Ingreso
 */


	public function RegistreIngreso($fecha,$CuentaDestino,$idProveedor,$Total,$CentroCosto,$Concepto,$idUser,$VectorIngreso){
            
            $DatosCentro=$this->DevuelveValores("centrocosto","ID",$CentroCosto);
            $DatosCliente=$this->DevuelveValores("proveedores","idProveedores",$idProveedor);
            $DatosCuentasFrecuentes=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaDestino);
            $NIT=$DatosCliente["Num_Identificacion"];
            $RazonSocialC=$DatosCliente["RazonSocial"];
            
            //////Creo el comprobante de Ingreso
            
            $tab="comprobantes_ingreso";
            $NumRegistros=6;

            $Columnas[0]="Fecha";		$Valores[0]=$fecha;
            $Columnas[1]="Tercero";             $Valores[1]=$idProveedor;
            $Columnas[2]="Valor";               $Valores[2]=$Total;
            $Columnas[3]="Tipo";		$Valores[3]="EFECTIVO";
            $Columnas[4]="Concepto";		$Valores[4]=$Concepto;
            $Columnas[5]="Usuarios_idUsuarios";	$Valores[5]=$idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            $idIngreso=$this->ObtenerMAX($tab,"ID", 1,"");
            
            ////Registro el anticipo en el libro diario
            $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
            $tab="librodiario";
            $NumRegistros=27;
            $CuentaPUC=$CuentaDestino;
            $NombreCuenta=$DatosCuentasFrecuentes["Nombre"];
            $CuentaPUCContraPartida="2205".$NIT;
            $NombreCuentaContraPartida="Proveedores Nacionales: $RazonSocialC NIT $NIT";
            


            $Columnas[0]="Fecha";			$Valores[0]=$fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="ComprobanteIngreso";
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idIngreso;
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
            $Columnas[5]="Tercero_DV";			$Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
            $Columnas[11]="Tercero_Direccion";		$Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];
            $Columnas[15]="CuentaPUC";			$Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";			$Valores[17]="Ingresos";
            $Columnas[18]="Debito";			$Valores[18]=$Total;
            $Columnas[19]="Credito";			$Valores[19]=0;
            $Columnas[20]="Neto";			$Valores[20]=$Valores[18];
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";			$Valores[23]=$Concepto;
            $Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCosto;
            $Columnas[25]="idEmpresa";			$Valores[25]=$DatosCentro["EmpresaPro"];
            $Columnas[26]="idSucursal";                 $Valores[26]=$DatosSucursal["ID"];
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


            ///////////////////////Registramos contra partida del anticipo

            $CuentaPUC=$CuentaPUCContraPartida; 
            $NombreCuenta=$NombreCuentaContraPartida;

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=0;
            $Valores[19]=$Total; 			//Credito se escribe el total de la venta menos los impuestos
            $Valores[20]=$Valores[19]*(-1);  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
            return($idIngreso);
	}
        
        /*
 * Funcion Registra Ingreso
 */


	public function RegistreAnticipo2($fecha,$CuentaDestino,$idCliente,$Total,$CentroCosto,$Concepto,$idUser,$VectorIngreso){
            
            $DatosCentro=$this->DevuelveValores("centrocosto","ID",$CentroCosto);
            $DatosCliente=$this->DevuelveValores("clientes","idClientes",$idCliente);
            $DatosCuentasFrecuentes=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaDestino);
            $NIT=$DatosCliente["Num_Identificacion"];
            $RazonSocialC=$DatosCliente["RazonSocial"];
            
            //////Creo el comprobante de Ingreso
            
            $tab="comprobantes_ingreso";
            $NumRegistros=6;

            $Columnas[0]="Fecha";		$Valores[0]=$fecha;
            $Columnas[1]="Clientes_idClientes"; $Valores[1]=$idCliente;
            $Columnas[2]="Valor";               $Valores[2]=$Total;
            $Columnas[3]="Tipo";		$Valores[3]="EFECTIVO";
            $Columnas[4]="Concepto";		$Valores[4]=$Concepto;
            $Columnas[5]="Usuarios_idUsuarios";	$Valores[5]=$idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            $idIngreso=$this->ObtenerMAX($tab,"ID", 1,"");
            
            ////Registro el anticipo en el libro diario
            $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1); 
            
            $tab="librodiario";
            $NumRegistros=27;
            $CuentaPUC=$CuentaDestino;
            $NombreCuenta=$DatosCuentasFrecuentes["Nombre"];
            $CuentaPUCContraPartida="238020";
            $NombreCuentaContraPartida="Anticipos recibidos Cliente: $RazonSocialC NIT $NIT";
            


            $Columnas[0]="Fecha";			$Valores[0]=$fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="ComprobanteIngreso";
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idIngreso;
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
            $Columnas[5]="Tercero_DV";			$Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
            $Columnas[11]="Tercero_Direccion";		$Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];
            $Columnas[15]="CuentaPUC";			$Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";			$Valores[17]="Ingresos";
            $Columnas[18]="Debito";			$Valores[18]=$Total;
            $Columnas[19]="Credito";			$Valores[19]=0;
            $Columnas[20]="Neto";			$Valores[20]=$Valores[18];
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";			$Valores[23]=$Concepto;
            $Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCosto;
            $Columnas[25]="idEmpresa";			$Valores[25]=$DatosCentro["EmpresaPro"];
            $Columnas[26]="idSucursal";                 $Valores[26]=$DatosSucursal["ID"];
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


            ///////////////////////Registramos contra partida del anticipo

            $CuentaPUC=$CuentaPUCContraPartida; 
            $NombreCuenta=$NombreCuentaContraPartida;

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=0;
            $Valores[19]=$Total; 			//Credito se escribe el total de la venta menos los impuestos
            $Valores[20]=$Valores[19]*(-1);  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
            return($idIngreso);
	}
        
        
        /*
 * Funcion Cruza anticipos
 */


	public function CruceAnticiposSeparados($fecha,$CuentaDestino,$idCliente,$Total,$CentroCosto,$Concepto,$idUser,$idFactura,$VectorCruce){
            
            $DatosCentro=$this->DevuelveValores("centrocosto","ID",$CentroCosto);
            $DatosCliente=$this->DevuelveValores("clientes","idClientes",$idCliente);
            
            $NIT=$DatosCliente["Num_Identificacion"];
            $RazonSocialC=$DatosCliente["RazonSocial"];
                
            ////Registro el anticipo en el libro diario
            $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);  
            
            $tab="librodiario";
            $NumRegistros=27;
            $CuentaPUC=$CuentaDestino;
            $NombreCuenta="Clientes Nacionales $RazonSocialC NIT: $NIT";
            $CuentaPUCContraPartida="238020";
            $NombreCuentaContraPartida="Anticipos recibidos Cliente: $RazonSocialC NIT $NIT";
            


            $Columnas[0]="Fecha";			$Valores[0]=$fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="FACTURA";
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idFactura;
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
            $Columnas[5]="Tercero_DV";			$Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
            $Columnas[11]="Tercero_Direccion";		$Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];
            $Columnas[15]="CuentaPUC";			$Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";			$Valores[17]="Cruce de Anticipos";
            $Columnas[18]="Debito";			$Valores[18]=0;
            $Columnas[19]="Credito";			$Valores[19]=$Total;
            $Columnas[20]="Neto";			$Valores[20]=$Valores[19]*(-1);
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";			$Valores[23]=$Concepto;
            $Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCosto;
            $Columnas[25]="idEmpresa";			$Valores[25]=$DatosCentro["EmpresaPro"];
            $Columnas[26]="idSucursal";                 $Valores[26]=$DatosSucursal["ID"];
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


            ///////////////////////Registramos contra partida del anticipo

            $CuentaPUC=$CuentaPUCContraPartida; 
            $NombreCuenta=$NombreCuentaContraPartida;

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=$Total;
            $Valores[19]=0; 			//Credito se escribe el total de la venta menos los impuestos
            $Valores[20]=$Valores[18];  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
            return;
	}
        
/*
 * Funcion Registra Pago de una factura
 * 
 */

    public function RegistrePagoFactura($idFactura,$fecha,$Pago,$CuentaDestino,$Retefuente,$ReteIVA,$ReteICA,$idUser,$Vector){
        
        $DatosFactura=$this->DevuelveValores("facturas","idFacturas",$idFactura);
        $CentroCostos=$DatosFactura["CentroCosto"]; 
        $idEmpresaPro=$DatosFactura["EmpresaPro_idEmpresaPro"];
        $DatosCliente=$this->DevuelveValores("clientes","idClientes",$DatosFactura["Clientes_idClientes"]);
        $DatosCuentasFrecuentes=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaDestino);
        $NIT=$DatosCliente["Num_Identificacion"];
        $RazonSocialC=$DatosCliente["RazonSocial"];
        $Detalle="Pago de Factura $DatosFactura[Prefijo] $DatosFactura[NumeroFactura]";
        $OtrosDescuentos=0;
        if(isset($Vector["OtrosDescuentos"])){
            $OtrosDescuentos=$Vector["OtrosDescuentos"];
        }
        $ValorIngreso=$Pago-$Retefuente-$ReteIVA-$ReteICA-$OtrosDescuentos;
        //////Creo el comprobante de Ingreso

        $tab="comprobantes_ingreso";
        $NumRegistros=6;

        $Columnas[0]="Fecha";               $Valores[0]=$fecha;
        $Columnas[1]="Clientes_idClientes"; $Valores[1]=$DatosFactura["Clientes_idClientes"];
        $Columnas[2]="Valor";               $Valores[2]=$ValorIngreso;
        $Columnas[3]="Tipo";                $Valores[3]="EFECTIVO";
        $Columnas[4]="Concepto";            $Valores[4]=$Detalle;
        $Columnas[5]="Usuarios_idUsuarios"; $Valores[5]=$idUser;

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        $idIngreso=$this->ObtenerMAX($tab,"ID", 1,"");

        ////Registro el anticipo en el libro diario
        $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
        
        $tab="librodiario";
        $NumRegistros=27;
        $CuentaPUC="130505".$NIT;
        $NombreCuenta="Clientes Nacionales $RazonSocialC $NIT";
        
        $Columnas[0]="Fecha";			$Valores[0]=$fecha;
        $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="ComprobanteIngreso";
        $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idIngreso;
        $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
        $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
        $Columnas[5]="Tercero_DV";		$Valores[5]=$DatosCliente['DV'];
        $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
        $Columnas[7]="Tercero_Segundo_Apellido";$Valores[7]=$DatosCliente['Segundo_Apellido'];
        $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
        $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
        $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
        $Columnas[11]="Tercero_Direccion";	$Valores[11]=$DatosCliente['Direccion'];
        $Columnas[12]="Tercero_Cod_Dpto";	$Valores[12]=$DatosCliente['Cod_Dpto'];
        $Columnas[13]="Tercero_Cod_Mcipio";	$Valores[13]=$DatosCliente['Cod_Mcipio'];
        $Columnas[14]="Tercero_Pais_Domicilio"; $Valores[14]=$DatosCliente['Pais_Domicilio'];
        $Columnas[15]="CuentaPUC";		$Valores[15]=$CuentaPUC;
        $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
        $Columnas[17]="Detalle";		$Valores[17]="Pago";
        $Columnas[18]="Debito";			$Valores[18]=0;
        $Columnas[19]="Credito";		$Valores[19]=$Pago;
        $Columnas[20]="Neto";			$Valores[20]=$Valores[19]*(-1);
        $Columnas[21]="Mayor";			$Valores[21]="NO";
        $Columnas[22]="Esp";			$Valores[22]="NO";
        $Columnas[23]="Concepto";		$Valores[23]=$Detalle;
        $Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCostos;
        $Columnas[25]="idEmpresa";		$Valores[25]=$idEmpresaPro;
        $Columnas[26]="idSucursal";		$Valores[26]=$DatosSucursal["ID"];
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


        ///////////////////////Registramos contra partida del anticipo

        $CuentaPUC=$CuentaDestino; 
               
        $Valores[15]=$CuentaPUC;
        $Valores[16]=$DatosCuentasFrecuentes["Nombre"];
        $Valores[18]=$ValorIngreso;
        $Valores[19]=0; 			//Credito se escribe el total de la venta menos los impuestos
        $Valores[20]=$Valores[18];  											//Credito se escribe el total de la venta menos los impuestos

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        //Si hay retefuente se registra
        if($Retefuente>0){
            
            $DatosCuenta=$this->DevuelveValores("tiposretenciones","ID",1);
                                        
            $NombreCuenta=$DatosCuenta["NombreCuentaActivo"];
            $CuentaPUC=$DatosCuenta["CuentaActivo"];

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=$Retefuente;
            $Valores[19]=0; 						
            $Valores[20]=$Retefuente;  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores); //Registro el credito
        }
        //Si hay reteIVA se registra
        if($ReteIVA>0){
            
            $DatosCuenta=$this->DevuelveValores("tiposretenciones","ID",2);
                                        
            $NombreCuenta=$DatosCuenta["NombreCuentaActivo"];
            $CuentaPUC=$DatosCuenta["CuentaActivo"];

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=$ReteIVA;
            $Valores[19]=0; 						
            $Valores[20]=$ReteIVA;  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores); //Registro el credito
        }
        //Si hay reteICA se registra
        if($ReteICA>0){
            
            $DatosCuenta=$this->DevuelveValores("tiposretenciones","ID",3);
                                        
            $NombreCuenta=$DatosCuenta["NombreCuentaActivo"];
            $CuentaPUC=$DatosCuenta["CuentaActivo"];

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=$ReteICA;
            $Valores[19]=0; 						
            $Valores[20]=$ReteICA;  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores); //Registro el credito
        }
        //Si hay retefuente se registra
        if($OtrosDescuentos>0){
            
            $DatosCuenta=$this->DevuelveValores("parametros_contables","ID",7);
                                        
            $NombreCuenta=$DatosCuenta["NombreCuenta"];
            $CuentaPUC=$DatosCuenta["CuentaPUC"];

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=$OtrosDescuentos;
            $Valores[19]=0; 						
            $Valores[20]=$OtrosDescuentos;  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores); //Registro el credito
        }
        $this->ActualizaRegistro("facturas", "SaldoFact", 0, "idFacturas", $idFactura);
        return($idIngreso);
    }        
////////////////////////////////////////////////////////////////////
//////////////////////Funcion calcular peso de una remision
///////////////////////////////////////////////////////////////////
public function CalculePesoRemision($idCotizacion)
  {	
    $idCotizacion=$this->normalizar($idCotizacion);
        $Peso=0;
        $Consulta=$this->ConsultarTabla("cot_itemscotizaciones", "WHERE NumCotizacion=$idCotizacion");
        while($DatosItems=  mysql_fetch_array($Consulta)){
            if($DatosItems["TablaOrigen"]=="productosalquiler"){
                $Producto=  $this->DevuelveValores("productosalquiler", "Referencia", $DatosItems["Referencia"]);
                $Peso=$Peso+($Producto["PesoUnitario"]*$DatosItems["Cantidad"]);
            }

        }

        return($Peso);
	}
        
        
/*
 * 
 * Funcion para sumar dias a una fecha
 */

    public function SumeDiasFecha($Datos){		
        $Fecha=$Datos["Fecha"]; 
        $Dias=$Datos["Dias"]; 
        $nuevafecha = date('Y-m-d', strtotime($Fecha) + 86400);
        $nuevafecha = date('Y-m-d', strtotime("$Fecha + $Dias day"));

        return($nuevafecha);

    }
   
    
/*
 * 
 * Funcion para sumar dias a una fecha
 */

    public function ActualiceDiasCartera(){		
        $FechaActual=date("Y-m-d");
        //$FechaActual='2016-05-10';
        $sql="UPDATE `cartera` SET `DiasCartera`= DATEDIFF('$FechaActual', `FechaVencimiento`)";
        $this->Query($sql);
        $SumatoriaDias=$this->Sume("cartera", 'DiasCartera', '');
        $sql="SELECT COUNT(idCartera) as NumRegistros FROM cartera";
        $Consulta=$this->Query($sql);
        $DatosCartera=$this->FetchArray($Consulta);
        $NumRegistros=$DatosCartera["NumRegistros"];
        if($NumRegistros>0){
            $Promedio=$SumatoriaDias/$NumRegistros;
        }else{
            $Promedio="";
        }
        return($Promedio);
    }    
    /*
 * 
 * Funcion evitar la inyeccion de codigo sql
 */

    public function normalizar($string){		
        $str=str_replace("'", "", $string);
        $str=str_replace(";", ",", $str);
        //$str=filter_var($string, FILTER_SANITIZE_STRING);
        return($str);
    }
    
    
    /*
 * 
 * Funcion ingresa factura a cartera
 */

    public function InsertarFacturaEnCartera($Datos){		
        $idFactura=$Datos["idFactura"]; 
        $FechaIngreso=$Datos["FechaFactura"]; 
        $FechaVencimiento=$Datos["FechaVencimiento"];
        $idCliente=$Datos["idCliente"];
        $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $idCliente);
        $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $idFactura);
        $RazonSocial=$DatosCliente["RazonSocial"];
        $Telefono=$DatosCliente["Telefono"];
        $Contacto=$DatosCliente["Contacto"];
        $TelContacto=$DatosCliente["TelContacto"];
        $TotalFactura=$DatosFactura["Total"];
        $tab="cartera";       
        $NumRegistros=13; 
                
        $Columnas[0]="Facturas_idFacturas";         $Valores[0]=$idFactura;
        $Columnas[1]="FechaIngreso";                $Valores[1]=$FechaIngreso;
        $Columnas[2]="FechaVencimiento";            $Valores[2]=$FechaVencimiento;
        $Columnas[3]="DiasCartera";                 $Valores[3]=0;
        $Columnas[4]="idCliente";                   $Valores[4]=$idCliente;
        $Columnas[5]="RazonSocial";                 $Valores[5]=$RazonSocial;
        $Columnas[6]="Telefono";                    $Valores[6]=$Telefono;
        $Columnas[7]="Contacto";                    $Valores[7]=$Contacto;
        $Columnas[8]="TelContacto";                 $Valores[8]=$TelContacto;
        $Columnas[9]="TotalFactura";                $Valores[9]=$TotalFactura;
        $Columnas[10]="TotalAbonos";                $Valores[10]=0;
        $Columnas[11]="Saldo";                      $Valores[11]=$TotalFactura;
        $Columnas[12]="idUsuarios";                 $Valores[12]= $this->idUser;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                
        
    }
/*
 * Funcion Agregar items de devolucion a una factura peso de una remision
 */
    
    public function InsertarItemsDevolucionAItemsFactura($Datos){
        $idDevolucion=$Datos["NumDevolucion"];
        $NumFactura=$Datos["ID"];
        $FechaFactura=$Datos["FechaFactura"];
        
        $sql="SELECT rd.Cantidad, rd.ValorUnitario,rd.Subtotal,rd.Dias,rd.Total,"
                        . "ci.Referencia,ci.TablaOrigen,ci.TipoItem"
                        . " FROM rem_devoluciones rd INNER JOIN cot_itemscotizaciones ci ON rd.idItemCotizacion=ci.ID"
                        . " WHERE rd.NumDevolucion='$idDevolucion' ";
        $Consulta=$this->Query($sql);
        $TotalSubtotal=0;
        $TotalIVA=0;
        $GranTotal=0;
        $TotalCostos=0;
        while($DatosDevolucion=  mysql_fetch_array($Consulta)){

            $DatosProducto=$this->DevuelveValores($DatosDevolucion["TablaOrigen"], "Referencia", $DatosDevolucion["Referencia"]);
            ////Empiezo a insertar en la tabla items facturas
            ///
            ///
            $IVA=$DatosProducto["IVA"];
            $IVAItem=round($IVA*$DatosDevolucion['Total']);
            $TotalIVA=$TotalIVA+$IVAItem; //se realiza la sumatoria del iva
            $TotalItem=$DatosDevolucion['Total']+$IVAItem;
            $TotalSubtotal=$TotalSubtotal+$DatosDevolucion['Total'];//se realiza la sumatoria del subtotal
            $GranTotal=$GranTotal+$TotalItem;//se realiza la sumatoria del total
            $SubtotalCosto=round($DatosProducto['CostoUnitario']*$DatosDevolucion['Cantidad']);
            $TotalCostos=$TotalCostos+$SubtotalCosto;//se realiza la sumatoria de los costos
            
            //$ID=date("YmdHis").microtime(true);
            $tab="facturas_items";
            $NumRegistros=26;
            $Columnas[0]="ID";			$Valores[0]="";
            $Columnas[1]="idFactura";           $Valores[1]=$NumFactura;
            $Columnas[2]="TablaItems";          $Valores[2]=$DatosDevolucion["TablaOrigen"];
            $Columnas[3]="Referencia";          $Valores[3]=$DatosDevolucion["Referencia"];
            $Columnas[4]="Nombre";              $Valores[4]=$DatosProducto["Nombre"];
            $Columnas[5]="Departamento";	$Valores[5]=$DatosProducto["Departamento"];
            $Columnas[6]="SubGrupo1";           $Valores[6]=$DatosProducto['Sub1'];
            $Columnas[7]="SubGrupo2";           $Valores[7]=$DatosProducto['Sub2'];
            $Columnas[8]="SubGrupo3";           $Valores[8]=$DatosProducto['Sub3'];
            $Columnas[9]="SubGrupo4";           $Valores[9]=$DatosProducto['Sub4'];
            $Columnas[10]="SubGrupo5";          $Valores[10]=$DatosProducto['Sub5'];
            $Columnas[11]="ValorUnitarioItem";	$Valores[11]=$DatosDevolucion['ValorUnitario'];
            $Columnas[12]="Cantidad";		$Valores[12]=$DatosDevolucion['Cantidad'];
            $Columnas[13]="Dias";		$Valores[13]=$DatosDevolucion['Dias'];
            $Columnas[14]="SubtotalItem";       $Valores[14]=$DatosDevolucion['Total'];
            $Columnas[15]="IVAItem";		$Valores[15]=$IVAItem;
            $Columnas[16]="TotalItem";		$Valores[16]=$TotalItem;
            $Columnas[17]="PorcentajeIVA";	$Valores[17]=($IVA*100)."%";
            $Columnas[18]="PrecioCostoUnitario";$Valores[18]=$DatosProducto['CostoUnitario'];
            $Columnas[19]="SubtotalCosto";	$Valores[19]=$SubtotalCosto;
            $Columnas[20]="TipoItem";		$Valores[20]=$DatosDevolucion["TipoItem"];
            $Columnas[21]="CuentaPUC";		$Valores[21]=$DatosProducto['CuentaPUC'];
            $Columnas[22]="GeneradoDesde";	$Valores[22]="rem_devoluciones";
            $Columnas[23]="NumeroIdentificador";$Valores[23]=$idDevolucion;
            $Columnas[24]="FechaFactura";       $Valores[24]=$FechaFactura;
            $Columnas[25]="idUsuarios";         $Valores[25]=  $this->idUser;
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }
        $ID=$Datos["ID"]; 
        $TotalSubtotal=round($TotalSubtotal);
        $TotalIVA=round($TotalIVA);
        $GranTotal=round($GranTotal);
        $TotalCostos=round($TotalCostos);
        $sql="UPDATE facturas SET Subtotal='$TotalSubtotal', IVA='$TotalIVA', Total='$GranTotal', "
                . "SaldoFact='$GranTotal', TotalCostos='$TotalCostos' WHERE idFacturas='$ID'";
        $this->Query($sql);
    }
             
    
/*
 * Funcion Agregar items de una cotizacion a una factura
 */
    
    public function InsertarItemsCotizacionAItemsFactura($Datos){
        
        
        $NumFactura=$Datos["ID"];
        $FechaFactura=$Datos["FechaFactura"];
        
        $sql="SELECT * FROM facturas_pre WHERE idUsuarios='$this->idUser'";
        $Consulta=$this->Query($sql);
        $TotalSubtotal=0;
        $TotalIVA=0;
        $GranTotal=0;
        $TotalCostos=0;
        while($DatosCotizacion =  mysql_fetch_array($Consulta)){
            ////Empiezo a insertar en la tabla items facturas
            ///
            ///
            $SubtotalItem=$DatosCotizacion["SubtotalItem"];
            $TotalSubtotal=$TotalSubtotal+$SubtotalItem; //se realiza la sumatoria del subtotal
            
            $IVAItem=$DatosCotizacion["IVAItem"];
            $TotalIVA=$TotalIVA+$IVAItem; //se realiza la sumatoria del iva
            
            $TotalItem=$DatosCotizacion['TotalItem'];
            $GranTotal=$GranTotal+$TotalItem;//se realiza la sumatoria del total
            
            $SubtotalCosto=$DatosCotizacion['SubtotalCosto'];
            $TotalCostos=$TotalCostos+$SubtotalCosto;//se realiza la sumatoria de los costos
            
            //$ID=date("YmdHis").microtime(false);
            $tab="facturas_items";
            $NumRegistros=26;
            $Columnas[0]="ID";			$Valores[0]="";
            $Columnas[1]="idFactura";           $Valores[1]=$NumFactura;
            $Columnas[2]="TablaItems";          $Valores[2]=$DatosCotizacion["TablaItems"];
            $Columnas[3]="Referencia";          $Valores[3]=$DatosCotizacion["Referencia"];
            $Columnas[4]="Nombre";              $Valores[4]=$DatosCotizacion["Nombre"];
            $Columnas[5]="Departamento";	$Valores[5]=$DatosCotizacion["Departamento"];
            $Columnas[6]="SubGrupo1";           $Valores[6]=$DatosCotizacion['SubGrupo1'];
            $Columnas[7]="SubGrupo2";           $Valores[7]=$DatosCotizacion['SubGrupo2'];
            $Columnas[8]="SubGrupo3";           $Valores[8]=$DatosCotizacion['SubGrupo3'];
            $Columnas[9]="SubGrupo4";           $Valores[9]=$DatosCotizacion['SubGrupo4'];
            $Columnas[10]="SubGrupo5";          $Valores[10]=$DatosCotizacion['SubGrupo5'];
            $Columnas[11]="ValorUnitarioItem";	$Valores[11]=$DatosCotizacion['ValorUnitarioItem'];
            $Columnas[12]="Cantidad";		$Valores[12]=$DatosCotizacion['Cantidad'];
            $Columnas[13]="Dias";		$Valores[13]=$DatosCotizacion['Dias'];
            $Columnas[14]="SubtotalItem";       $Valores[14]=$DatosCotizacion['SubtotalItem'];
            $Columnas[15]="IVAItem";		$Valores[15]=$DatosCotizacion['IVAItem'];
            $Columnas[16]="TotalItem";		$Valores[16]=$DatosCotizacion['TotalItem'];
            $Columnas[17]="PorcentajeIVA";	$Valores[17]=$DatosCotizacion['PorcentajeIVA'];
            $Columnas[18]="PrecioCostoUnitario";$Valores[18]=$DatosCotizacion['PrecioCostoUnitario'];
            $Columnas[19]="SubtotalCosto";	$Valores[19]=$DatosCotizacion['SubtotalCosto'];
            $Columnas[20]="TipoItem";		$Valores[20]=$DatosCotizacion["TipoItem"];
            $Columnas[21]="CuentaPUC";		$Valores[21]=$DatosCotizacion['CuentaPUC'];
            $Columnas[22]="GeneradoDesde";	$Valores[22]="cotizacionesv5";
            $Columnas[23]="NumeroIdentificador";$Valores[23]="";
            $Columnas[24]="FechaFactura";       $Valores[24]=$FechaFactura;
            $Columnas[25]="idUsuarios";         $Valores[25]=  $this->idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            if($DatosCotizacion["TipoItem"]=="PR"){
                $DatosProducto=  $this->DevuelveValores($DatosCotizacion["TablaItems"], "Referencia", $DatosCotizacion["Referencia"]);
                $DatosKardex["Cantidad"]=$DatosCotizacion['Cantidad'];
                $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
                $DatosKardex["CostoUnitario"]=$DatosProducto['CostoUnitario'];
                $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
                $DatosKardex["Detalle"]="Factura";
                $DatosKardex["idDocumento"]=$NumFactura;
                $DatosKardex["TotalCosto"]=$SubtotalCosto;
                $DatosKardex["Movimiento"]="SALIDA";
                
                $this->InserteKardex($DatosKardex);
            }
        }
        $ID=$Datos["ID"]; 
        $TotalSubtotal=round($TotalSubtotal);
        $TotalIVA=round($TotalIVA);
        $GranTotal=round($GranTotal);
        $TotalCostos=round($TotalCostos);
        $sql="UPDATE facturas SET Subtotal='$TotalSubtotal', IVA='$TotalIVA', Total='$GranTotal', "
                . "SaldoFact='$GranTotal', TotalCostos='$TotalCostos' WHERE idFacturas='$ID'";
        $this->Query($sql);
        
    }   
    
    
    public function InserteKardex($DatosKardex){
        $Fecha=date("Y-m-d");
        if($DatosKardex["Movimiento"]=="SALIDA"){
            $Saldo=$DatosKardex["Existencias"]-$DatosKardex["Cantidad"];
        }else if($DatosKardex["Movimiento"]=="ENTRADA"){
            $Saldo=$DatosKardex["Existencias"]+$DatosKardex["Cantidad"];
        }else{
            $Saldo=0;
        }
        $TotalCostoSaldo=$Saldo*$DatosKardex["CostoUnitario"];
        
        /*
         * Inserto el kardex del producto primer movimiento 
         */
        $tab="kardexmercancias";
        $NumRegistros=8;
        $Columnas[0]="Fecha";                           $Valores[0]=$Fecha;
        $Columnas[1]="Movimiento";                      $Valores[1]=$DatosKardex["Movimiento"];
        $Columnas[2]="Detalle";                         $Valores[2]=$DatosKardex["Detalle"];
        $Columnas[3]="idDocumento";                     $Valores[3]=$DatosKardex["idDocumento"];
        $Columnas[4]="Cantidad";                        $Valores[4]=$DatosKardex["Cantidad"];
        $Columnas[5]="ValorUnitario";                   $Valores[5]=$DatosKardex["CostoUnitario"];
        $Columnas[6]="ValorTotal";                      $Valores[6]=$DatosKardex["TotalCosto"];
        $Columnas[7]="ProductosVenta_idProductosVenta"; $Valores[7]=$DatosKardex['idProductosVenta'];
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        /*
         * Inserto el kardex del producto segundo movimiento SALDOS 
         */
        
        $Columnas[1]="Movimiento";                      $Valores[1]="SALDOS";
        $Columnas[4]="Cantidad";                        $Valores[4]=$Saldo;
        $Columnas[6]="ValorTotal";                      $Valores[6]=$TotalCostoSaldo;
              
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        /*
         * Actualizo inventarios
         */
        $sql="UPDATE productosventa SET Existencias='$Saldo', CostoTotal='$TotalCostoSaldo'"
                . " WHERE idProductosVenta=$DatosKardex[idProductosVenta]";
        $this->Query($sql);
        
    }
    
    public function RegistreComprobanteContable($idComprobante){
        
        $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1); 
        $DatosGenerales=$this->DevuelveValores("comprobantes_contabilidad","ID",$idComprobante);
        $Consulta=$this->ConsultarTabla("comprobantes_contabilidad_items", "WHERE idComprobante=$idComprobante");
        while($DatosComprobante=$this->FetchArray($Consulta)){
            $Fecha=$DatosComprobante["Fecha"];
            
            $tab="librodiario";
            $NumRegistros=27;
            $CuentaPUC=$DatosComprobante["CuentaPUC"];
            $NombreCuenta=$DatosComprobante["NombreCuenta"];
            $DatosCliente=$this->DevuelveValores("proveedores", "Num_Identificacion", $DatosComprobante["Tercero"]);
            $DatosCentro=$this->DevuelveValores("centrocosto", "ID", $DatosComprobante["CentroCostos"]);
            
            $Columnas[0]="Fecha";			$Valores[0]=$Fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="COMPROBANTE CONTABLE";
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idComprobante;
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$DatosCliente['Num_Identificacion'];
            $Columnas[5]="Tercero_DV";                  $Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$DatosCliente['RazonSocial'];
            $Columnas[11]="Tercero_Direccion";          $Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";           $Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";         $Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];

            $Columnas[15]="CuentaPUC";                  $Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";                    $Valores[17]=$DatosGenerales["Concepto"];
            $Columnas[18]="Debito";			$Valores[18]=$DatosComprobante["Debito"];
            $Columnas[19]="Credito";                    $Valores[19]=$DatosComprobante["Credito"];
            $Columnas[20]="Neto";			$Valores[20]=$Valores[18]-$Valores[19];
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";                   $Valores[23]=$DatosComprobante["Concepto"];
            $Columnas[24]="idCentroCosto";		$Valores[24]=$DatosComprobante["CentroCostos"];
            $Columnas[25]="idEmpresa";                  $Valores[25]=$DatosCentro["EmpresaPro"];
            $Columnas[26]="idSucursal";                 $Valores[26]=$DatosSucursal["ID"];
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            
        }
        $this->ActualizaRegistro("comprobantes_contabilidad", "Estado", "C", "ID", $idComprobante);
        $this->ActualizaRegistro("comprobantes_pre", "Estado", "C", "idComprobanteContabilidad", $idComprobante);
    }
    
    public function ReingreseItemsInventario($idFactura){
        $Consulta=$this->ConsultarTabla("facturas_items", "WHERE idFactura='$idFactura'");
        while($DatosItems=$this->FetchArray($Consulta)){
            if($DatosItems["TipoItem"]=="PR"){
                $Referencia=$DatosItems["Referencia"];
                $DatosProducto=$this->DevuelveValores($DatosItems["TablaItems"], "Referencia", $Referencia);
                $DatosKardex["Cantidad"]=$DatosItems['Cantidad']*(-1);
                $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
                $DatosKardex["CostoUnitario"]=$DatosItems['PrecioCostoUnitario'];
                $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
                $DatosKardex["Detalle"]="Anulacion de Factura";
                $DatosKardex["idDocumento"]=$idFactura;
                $DatosKardex["TotalCosto"]=$DatosKardex["CostoUnitario"]*$DatosKardex["Cantidad"];
                $DatosKardex["Movimiento"]="SALIDA";
                
                $this->InserteKardex($DatosKardex);
            }
        }
    }
    
    /*
     * Funcion para registrar un abono
     * 2016-06-10 JULIAN ALVARAN
     */
    
    public function RegistreAbonoLibro($idLibro,$TablaAbonos,$CuentaDestino,$PageReturn,$TotalAbono,$Datos){
        
        $NomIdCentroCostos="idCentroCosto"; //Nombre de las columnas, se coloca porque en algunas versiones es diferente
        $NomIdEmpresa="idEmpresa";
        $Fecha=$Datos["Fecha"];
        $TipoAbono=$Datos["TipoAbono"];
        $idUser=$Datos["idUser"];
        $hora=date("H:i");
        if($TipoAbono=="CuentasXCobrar"){
            $Factor=1;
            $Page="CuentasXCobrar.php";
        }
        if($TipoAbono=="CuentasXPagar"){
            $Factor="-1";
            $Page="CuentasXPagar.php";
        }
        $DatosLibro=$this->DevuelveValores("librodiario", "idLibroDiario", $idLibro);
        $AbonosActuales=$this->Sume("abonos_libro", "Cantidad", "WHERE idLibroDiario='$idLibro' AND TipoAbono='$TipoAbono'");
        $AbonosActuales=$AbonosActuales+$TotalAbono;
        $SaldoTotal=$DatosLibro["Neto"]*$Factor;
        $NuevoSaldo=$SaldoTotal-$AbonosActuales;
        if($AbonosActuales>$SaldoTotal){
            echo "<script>alert('Abono incorrecto, supera el saldo total')</script>";
            exit(" <a href='$Page'> Volver</a> ");
        }
        $DatosCuentasFrecuentes=$this->DevuelveValores("cuentasfrecuentes", "CuentaPUC", $CuentaDestino);
        $Debitos1=0;
        $Creditos1=0;
        $Neto1=0;
        $Debitos2=0;
        $Creditos2=0;
        $Neto2=0;
        if($TipoAbono=="CuentasXPagar"){
            $Concepto="ABONO A LA CUENTA POR PAGAR ESPECIFICADA EN EL LIBRO DIARIO CON ID=$idLibro "
                    . "del Tercero $DatosLibro[Tercero_Razon_Social] con NIT $DatosLibro[Tercero_Identificacion] "
                    . "por total de: $SaldoTotal, Nuevo saldo: $NuevoSaldo";
            $Debitos1=$TotalAbono;
            $Neto1=$TotalAbono;
            $Neto2=$TotalAbono*(-1);
            
            $Creditos2=$TotalAbono;
        }
        
        if($TipoAbono=="CuentasXCobrar"){
            $Concepto="ABONO A LA CUENTA POR COBRAR ESPECIFICADA EN EL LIBRO DIARIO CON ID=$idLibro "
                    . "del Tercero $DatosLibro[Tercero_Razon_Social] con NIT $DatosLibro[Tercero_Identificacion] "
                    . "por total de: $SaldoTotal, Nuevo saldo: $NuevoSaldo";
            $Debitos1=0;
            $Creditos1=$TotalAbono;
            $Neto1=$TotalAbono*(-1);
            $Neto2=$TotalAbono;
            
            $Debitos2=$TotalAbono;
        }
        /*
         * Abro un nuevo comprobante de abono
         */
        
        $tab="comprobantes_contabilidad";
        $NumRegistros=4; 

        $Columnas[0]="Fecha";                   $Valores[0]=$Fecha;
        $Columnas[1]="Concepto";                $Valores[1]=$Concepto;
        $Columnas[2]="Hora";                    $Valores[2]=$hora;
        $Columnas[3]="Usuarios_idUsuarios";     $Valores[3]=$idUser;

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $idComprobante=$this->ObtenerMAX($tab, "ID", 1, "");
             
        /*
         * Inserto los datos a la tabla de abonos correspondiente 
         */
        
        $tab=$TablaAbonos;
        $NumRegistros=5;
        $Columnas[0]="Fecha";                           $Valores[0]=$Fecha;
        $Columnas[1]="Cantidad";                        $Valores[1]=$TotalAbono;
        $Columnas[2]="idLibroDiario";                   $Valores[2]=$idLibro;
        $Columnas[3]="idComprobanteContable";           $Valores[3]=$idComprobante;
        $Columnas[4]="TipoAbono";                       $Valores[4]=$TipoAbono;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        /*
         * Se registra en el libro diario
         * 
         */
         
        $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);   
        
        $tab="librodiario";
        $NumRegistros=27;
                
        $Columnas[0]="Fecha";			$Valores[0]=$Fecha;
        $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="COMPROBANTE CONTABLE";
        $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idComprobante;
        $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosLibro['Tercero_Tipo_Documento'];
        $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$DatosLibro['Tercero_Identificacion'];
        $Columnas[5]="Tercero_DV";		$Valores[5]=$DatosLibro['Tercero_DV'];
        $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosLibro['Tercero_Primer_Apellido'];
        $Columnas[7]="Tercero_Segundo_Apellido";$Valores[7]=$DatosLibro['Tercero_Segundo_Apellido'];
        $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosLibro['Tercero_Primer_Nombre'];
        $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosLibro['Tercero_Otros_Nombres'];
        $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$DatosLibro['Tercero_Razon_Social'];
        $Columnas[11]="Tercero_Direccion";	$Valores[11]=$DatosLibro['Tercero_Direccion'];
        $Columnas[12]="Tercero_Cod_Dpto";	$Valores[12]=$DatosLibro['Tercero_Cod_Dpto'];
        $Columnas[13]="Tercero_Cod_Mcipio";	$Valores[13]=$DatosLibro['Tercero_Cod_Mcipio'];
        $Columnas[14]="Tercero_Pais_Domicilio"; $Valores[14]=$DatosLibro['Tercero_Pais_Domicilio'];
        $Columnas[15]="CuentaPUC";		$Valores[15]=$DatosLibro["CuentaPUC"];
        $Columnas[16]="NombreCuenta";		$Valores[16]=$DatosLibro["NombreCuenta"];
        $Columnas[17]="Detalle";		$Valores[17]=$TipoAbono;
        $Columnas[18]="Debito";			$Valores[18]=$Debitos1;
        $Columnas[19]="Credito";		$Valores[19]=$Creditos1;
        $Columnas[20]="Neto";			$Valores[20]=$Neto1;
        $Columnas[21]="Mayor";			$Valores[21]="NO";
        $Columnas[22]="Esp";			$Valores[22]="NO";
        $Columnas[23]="Concepto";		$Valores[23]=$Concepto;
        $Columnas[24]=$NomIdCentroCostos;       $Valores[24]=$DatosLibro[$NomIdCentroCostos];
        $Columnas[25]=$NomIdEmpresa;		$Valores[25]=$DatosLibro[$NomIdEmpresa];
        $Columnas[26]="idSucursal";		$Valores[26]=$DatosSucursal["ID"];
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


        ///////////////////////Registramos contra partida del anticipo

        $CuentaPUC=$CuentaDestino; 
               
        $Valores[15]=$CuentaPUC;
        $Valores[16]=$DatosCuentasFrecuentes["Nombre"];
        $Valores[18]=$Debitos2;
        $Valores[19]=$Creditos2; 			//Credito se escribe el total de la venta menos los impuestos
        $Valores[20]=$Neto2;  											//Credito se escribe el total de la venta menos los impuestos

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        
        if($AbonosActuales==$SaldoTotal){
           $this->ActualizaRegistro("librodiario", "Estado", "CO", "idLibroDiario", $idLibro);
        }
        
        return ($idComprobante);
    }
    
    /*
     * revisa si hay resultados tras una consulta
     * 
     */
    
    public function NumRows($consulta){
  		
	$NR=mysql_num_rows($consulta);
	return ($NR);	
		
	}
        
        /*
     * Registra una Venta Rapida
     * 
     */
    
    public function RegistreVentaRapida($idPreventa, $idCliente, $TipoPago, $Paga, $Devuelta, $CuentaDestino, $DatosVentaRapida){
  	
        $sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa'";
        $Consulta=$this->Query($sql);
        if($this->NumRows($Consulta)<1){
            header("location:$myPage?CmbPreVentaAct=$idPreventa");
            exit();    
        }
        
        $CentroCostos=$DatosVentaRapida["CentroCostos"];
        
        $ResolucionDian=$DatosVentaRapida["ResolucionDian"];
        
        $Cheques=$DatosVentaRapida["PagaCheque"];
        $Tarjetas=$DatosVentaRapida["PagaTarjeta"];
        $idTarjetas=$DatosVentaRapida["idTarjeta"];
        $PagaOtros=$DatosVentaRapida["PagaOtros"];
        $Observaciones=$DatosVentaRapida["Observaciones"];
        
        //$CuentaDestino=$_REQUEST["CmbCuentaDestino"];
        //$CuentaDestino=110510;
        $OrdenCompra="";
        $OrdenSalida="";
        $ObservacionesFactura=$Observaciones;
        $FechaFactura=date("Y-m-d");
        
        $Consulta=$this->DevuelveValores("centrocosto", "ID", $CentroCostos);
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
        $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
        if($DatosResolucion["Completada"]=="NO"){           ///Pregunto si la resolucion ya fue completada
            $Disponibilidad=$DatosResolucion["Estado"];
                                              //si entra a verificar es porque estaba ocupada y cambiará a 1
            while($Disponibilidad=="OC"){                   //miro que esté disponible para facturar, esto para no crear facturas dobles
                print("Esperando disponibilidad<br>");
                usleep(300);
                $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
                $Disponibilidad=$DatosResolucion["Estado"];
                
            }
            
            $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
            if($DatosResolucion["Completada"]<>"SI"){
                $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "OC", "ID", $ResolucionDian); //Ocupo la resolucion
                
                $sql="SELECT MAX(NumeroFactura) as FacturaActual FROM facturas WHERE Prefijo='$DatosResolucion[Prefijo]' "
                        . "AND TipoFactura='$DatosResolucion[Tipo]' AND idResolucion='$ResolucionDian'";
                $Consulta=$this->Query($sql);
                $Consulta=$this->FetchArray($Consulta);
                $FacturaActual=$Consulta["FacturaActual"];
                $idFactura=$FacturaActual+1;
                
                //Verificamos si ya se completó el numero de la resolucion y si es así se cambia su estado
                if($DatosResolucion["Hasta"]==$idFactura){ 
                    $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Completada", "SI", "ID", $ResolucionDian);
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
                $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1); 
                $ID=date("YmdHis").microtime(false);
                $tab="facturas";
                $NumRegistros=32; 
                
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
                $Columnas[14]="Usuarios_idUsuarios";        $Valores[14]=$this->idUser;
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
                $Columnas[25]="Efectivo";                   $Valores[25]=$Paga;
                $Columnas[26]="Devuelve";                   $Valores[26]=$Devuelta;
                $Columnas[27]="Cheques";                    $Valores[27]=$Cheques;
                $Columnas[28]="Otros";                      $Valores[28]=$PagaOtros;
                $Columnas[29]="Tarjetas";                   $Valores[29]=$Tarjetas;
                $Columnas[30]="idTarjetas";                 $Valores[30]=$idTarjetas;
                $Columnas[31]="idSucursal";                 $Valores[31]=$DatosSucursal["ID"];
                
                $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                
                //libero la resolucion
                $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "", "ID", $ResolucionDian);
                
                //////////////////////Agrego Items a la Factura desde la devolucion
                /////
                /////
                
                
                $Datos["idPreventa"]=$idPreventa;
                $Datos["NumFactura"]=$idFactura;
                $Datos["FechaFactura"]=$FechaFactura;
                $Datos["ID"]=$ID;
                $Datos["CuentaDestino"]=$CuentaDestino;
                $Datos["EmpresaPro"]=$EmpresaPro;
                $Datos["CentroCostos"]=$CentroCostos;
                $this->InsertarItemsPreventaAItemsFactura($Datos);///Relaciono los items de la factura
                
                $this->InsertarFacturaLibroDiario($Datos);///Inserto Items en el libro diario
               
                if($TipoPago<>"Contado"){                   //Si es a Credito
                    $Datos["Fecha"]=$FechaFactura; 
                    $Datos["Dias"]=$SumaDias;
                    $FechaVencimiento=$this->SumeDiasFecha($Datos);
                    $Datos["idFactura"]=$Datos["ID"]; 
                    $Datos["FechaFactura"]=$FechaFactura; 
                    $Datos["FechaVencimiento"]=$FechaVencimiento;
                    $Datos["idCliente"]=$idCliente;
                    $this->InsertarFacturaEnCartera($Datos);///Inserto La factura en la cartera
                }
                 
            }    
          
        }else{
            exit("La Resolucion de facturacion fue completada");
        }
	return ($ID);	
		
	}

        /*
 * Funcion Agregar items de una preventa a una factura
 */
    
    public function InsertarItemsPreventaAItemsFactura($Datos){
        
        $idPreventa=$Datos["idPreventa"];
        $NumFactura=$Datos["ID"];
        $FechaFactura=$Datos["FechaFactura"];
        
        $sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa'";
        $Consulta=$this->Query($sql);
        $TotalSubtotal=0;
        $TotalIVA=0;
        $GranTotal=0;
        $TotalCostos=0;
        
        while($DatosCotizacion=  mysql_fetch_array($Consulta)){

            $DatosProducto=$this->DevuelveValores($DatosCotizacion["TablaItem"], "idProductosVenta", $DatosCotizacion["ProductosVenta_idProductosVenta"]);
            ////Empiezo a insertar en la tabla items facturas
            ///
            ///
            $SubtotalItem=round($DatosCotizacion["Subtotal"]);
            $TotalSubtotal=$TotalSubtotal+$SubtotalItem; //se realiza la sumatoria del subtotal
            
            $IVAItem=round($DatosCotizacion["Impuestos"]);
            $TotalIVA=$TotalIVA+$IVAItem; //se realiza la sumatoria del iva
            
            $TotalItem=round($DatosCotizacion['TotalVenta']);
            $GranTotal=$GranTotal+$TotalItem;//se realiza la sumatoria del total
            
            $SubtotalCosto=$DatosCotizacion['Cantidad']*$DatosProducto["CostoUnitario"];
            $TotalCostos=$TotalCostos+$SubtotalCosto;//se realiza la sumatoria de los costos
            
            //$ID=date("YmdHis").microtime(false);
            $tab="facturas_items";
            $NumRegistros=26;
            $Columnas[0]="ID";			$Valores[0]="";
            $Columnas[1]="idFactura";           $Valores[1]=$NumFactura;
            $Columnas[2]="TablaItems";          $Valores[2]=$DatosCotizacion["TablaItem"];
            $Columnas[3]="Referencia";          $Valores[3]=$DatosProducto["Referencia"];
            $Columnas[4]="Nombre";              $Valores[4]=$DatosProducto["Nombre"];
            $Columnas[5]="Departamento";	$Valores[5]=$DatosProducto["Departamento"];
            $Columnas[6]="SubGrupo1";           $Valores[6]=$DatosProducto['Sub1'];
            $Columnas[7]="SubGrupo2";           $Valores[7]=$DatosProducto['Sub2'];
            $Columnas[8]="SubGrupo3";           $Valores[8]=$DatosProducto['Sub3'];
            $Columnas[9]="SubGrupo4";           $Valores[9]=$DatosProducto['Sub4'];
            $Columnas[10]="SubGrupo5";          $Valores[10]=$DatosProducto['Sub5'];
            $Columnas[11]="ValorUnitarioItem";	$Valores[11]=$DatosCotizacion['ValorAcordado'];
            $Columnas[12]="Cantidad";		$Valores[12]=$DatosCotizacion['Cantidad'];
            $Columnas[13]="Dias";		$Valores[13]=1;
            $Columnas[14]="SubtotalItem";       $Valores[14]=$SubtotalItem;
            $Columnas[15]="IVAItem";		$Valores[15]=$IVAItem;
            $Columnas[16]="TotalItem";		$Valores[16]=$TotalItem;
            $Columnas[17]="PorcentajeIVA";	$Valores[17]=($DatosProducto['IVA']*100)."%";
            $Columnas[18]="PrecioCostoUnitario";$Valores[18]=$DatosProducto['CostoUnitario'];
            $Columnas[19]="SubtotalCosto";	$Valores[19]=$SubtotalCosto;
            $Columnas[20]="TipoItem";		$Valores[20]=$DatosCotizacion["TipoItem"];
            $Columnas[21]="CuentaPUC";		$Valores[21]=$DatosProducto['CuentaPUC'];
            $Columnas[22]="GeneradoDesde";	$Valores[22]="cotizacionesv5";
            $Columnas[23]="NumeroIdentificador";$Valores[23]="";
            $Columnas[24]="FechaFactura";       $Valores[24]=$FechaFactura;
            $Columnas[25]="idUsuarios";         $Valores[25]= $this->idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            if($DatosCotizacion["TipoItem"]=="PR"){
                
                $DatosKardex["Cantidad"]=$DatosCotizacion['Cantidad'];
                $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
                $DatosKardex["CostoUnitario"]=$DatosProducto['CostoUnitario'];
                $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
                $DatosKardex["Detalle"]="Factura";
                $DatosKardex["idDocumento"]=$NumFactura;
                $DatosKardex["TotalCosto"]=$SubtotalCosto;
                $DatosKardex["Movimiento"]="SALIDA";
                
                $this->InserteKardex($DatosKardex);
            }
        }
        $ID=$Datos["ID"]; 
        $TotalSubtotal=round($TotalSubtotal);
        $TotalIVA=round($TotalIVA);
        $GranTotal=round($GranTotal);
        $TotalCostos=round($TotalCostos);
        $sql="UPDATE facturas SET Subtotal='$TotalSubtotal', IVA='$TotalIVA', Total='$GranTotal', "
                . "SaldoFact='$GranTotal', TotalCostos='$TotalCostos' WHERE idFacturas='$ID'";
        $this->Query($sql);
        
    } 
    
    
    /*
     * Inserta Items de un separado a una factura
     * 
     */
    
     /*
 * Funcion Agregar items de una preventa a una factura
 */
    
    public function InsertarItemsSeparadoAItemsFactura($Datos){
        
        $idSeparado=$Datos["idSeparado"];
        $NumFactura=$Datos["ID"];
        $FechaFactura=$Datos["FechaFactura"];
        
        $sql="SELECT * FROM separados_items WHERE idSeparado='$idSeparado'";
        $Consulta=$this->Query($sql);
                
        while($DatosItems=  mysql_fetch_array($Consulta)){

              
            //$ID=date("YmdHis").microtime(false);
            $tab="facturas_items";
            $NumRegistros=26;
            $Columnas[0]="ID";			$Valores[0]="";
            $Columnas[1]="idFactura";           $Valores[1]=$NumFactura;
            $Columnas[2]="TablaItems";          $Valores[2]=$DatosItems["TablaItems"];
            $Columnas[3]="Referencia";          $Valores[3]=$DatosItems["Referencia"];
            $Columnas[4]="Nombre";              $Valores[4]=$DatosItems["Nombre"];
            $Columnas[5]="Departamento";	$Valores[5]=$DatosItems["Departamento"];
            $Columnas[6]="SubGrupo1";           $Valores[6]=$DatosItems['SubGrupo1'];
            $Columnas[7]="SubGrupo2";           $Valores[7]=$DatosItems['SubGrupo2'];
            $Columnas[8]="SubGrupo3";           $Valores[8]=$DatosItems['SubGrupo3'];
            $Columnas[9]="SubGrupo4";           $Valores[9]=$DatosItems['SubGrupo4'];
            $Columnas[10]="SubGrupo5";          $Valores[10]=$DatosItems['SubGrupo5'];
            $Columnas[11]="ValorUnitarioItem";	$Valores[11]=$DatosItems['ValorUnitarioItem'];
            $Columnas[12]="Cantidad";		$Valores[12]=$DatosItems['Cantidad'];
            $Columnas[13]="Dias";		$Valores[13]=1;
            $Columnas[14]="SubtotalItem";       $Valores[14]=$DatosItems['SubtotalItem'];
            $Columnas[15]="IVAItem";		$Valores[15]=$DatosItems['IVAItem'];
            $Columnas[16]="TotalItem";		$Valores[16]=$DatosItems['TotalItem'];
            $Columnas[17]="PorcentajeIVA";	$Valores[17]=$DatosItems['PorcentajeIVA'];
            $Columnas[18]="PrecioCostoUnitario";$Valores[18]=$DatosItems['PrecioCostoUnitario'];
            $Columnas[19]="SubtotalCosto";	$Valores[19]=$DatosItems['SubtotalCosto'];
            $Columnas[20]="TipoItem";		$Valores[20]=$DatosItems['TipoItem'];
            $Columnas[21]="CuentaPUC";		$Valores[21]=$DatosItems['CuentaPUC'];
            $Columnas[22]="GeneradoDesde";	$Valores[22]="cotizacionesv5";
            $Columnas[23]="NumeroIdentificador";$Valores[23]="";
            $Columnas[24]="FechaFactura";       $Valores[24]=$FechaFactura;
            $Columnas[25]="idUsuarios";         $Valores[25]= $this->idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
        }
        
        
    } 
    
    
    /*
     * Imprime una factura pos
     */
    public function ImprimeFacturaPOS($idFactura,$COMPrinter,$Copias){

        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $idFactura);
       $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $DatosFactura["EmpresaPro_idEmpresaPro"]);
       $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $DatosFactura["idResolucion"]);
       $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $DatosFactura["Usuarios_idUsuarios"]);
       $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
        $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
        $Regimen=$DatosEmpresa["Regimen"];
        $ResolucionDian1="RES DIAN: $DatosResolucion[NumResolucion] del $DatosResolucion[Fecha]";
        $ResolucionDian2="FACTURA AUT. $DatosResolucion[Prefijo] - $DatosResolucion[Desde] HASTA $DatosResolucion[Prefijo] - $DatosResolucion[Hasta]";
        $ResolucionDian3="Autoriza impresion en:  $DatosResolucion[Factura]";
        $Telefono=$DatosEmpresa["Telefono"];

        $impuesto=$DatosFactura["IVA"];
        $Descuento=$DatosFactura["Descuentos"];
        $TotalVenta=$DatosFactura["Total"];
        $Subtotal=$DatosFactura["Subtotal"];
        $TotalFinal=$DatosFactura["Total"];
        

        $Fecha=$DatosFactura["Fecha"];
        $Hora=$DatosFactura["Hora"];
        $NumFact=$DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"];
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        $InfoRegimen="REGIMEN SIMPLIFICADO";
        if($Regimen<>"SIMPLIFICADO"){
            $InfoRegimen="IVA REGIMEN COMUN";
        }
        fwrite($handle,"NIT: ".$NIT." ".$InfoRegimen);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		if($Regimen<>"SIMPLIFICADO"){
        fwrite($handle,$ResolucionDian1);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$ResolucionDian2);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$ResolucionDian3);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		}
        fwrite($handle,$Direccion." ".$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        
        fwrite($handle,"TEL: ".$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"Cliente: $DatosCliente[RazonSocial]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"NIT: $DatosCliente[Num_Identificacion]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha      HORA: $Hora");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"FACTURA DE VENTA No $NumFact");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

        /////////////////////////////ITEMS VENDIDOS

        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

        $sql = "SELECT * FROM facturas_items WHERE idFactura='$idFactura'";
	
        $consulta=$this->Query($sql);
								
	while($DatosVenta=$this->FetchArray($consulta)){
		
            //$Descuentos=$DatosVenta["Descuentos"];
            //$Impuestos=$DatosVenta["Impuestos"];
            $SubTotalITem=$DatosVenta["TotalItem"];
            //$SubTotalITem=$TotalVenta-$Impuestos;


            fwrite($handle,str_pad($DatosVenta["Cantidad"],4," ",STR_PAD_RIGHT));

            fwrite($handle,str_pad(substr($DatosVenta["Referencia"]." ".$DatosVenta["Nombre"],0,20),20," ",STR_PAD_BOTH)."   ");

            fwrite($handle,str_pad("$".number_format($SubTotalITem),10," ",STR_PAD_LEFT));

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
}




    /////////////////////////////TOTALES

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
    if($Regimen<>"SIMPLIFICADO"){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"SUBTOTAL         ".str_pad("$".number_format($Subtotal),20," ",STR_PAD_LEFT));

        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"IVA              ".str_pad("$".number_format($impuesto),20," ",STR_PAD_LEFT));
    }
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL A PAGAR    ".str_pad("$".number_format($TotalVenta),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    /////////////////////////////Forma de PAGO

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

    fwrite($handle,"Formas de Pago");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"       Efectivo ----> $".str_pad(number_format($DatosFactura["Efectivo"]),10," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"       Tarjetas ----> $".str_pad(number_format($DatosFactura["Tarjetas"]),10," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"       Cheques  ----> $".str_pad(number_format($DatosFactura["Cheques"]),10," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"       Otros    ----> $".str_pad(number_format($DatosFactura["Otros"]),10," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"       Cambio   ----> $".str_pad(number_format($DatosFactura["Devuelve"]),10," ",STR_PAD_LEFT));

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
    fwrite($handle,"***GRACIAS POR SU COMPRA***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
    //fwrite($handle, chr(27). chr(100). chr(0));
    //fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle,"***Factura impresa por SoftConTech***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"Software disenado por Techno Soluciones SAS, 3177740609, www.technosoluciones.com.co");
    //fwrite($handle,"=================================");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
    
    
    //imprime un tikete de promo
    public function ImprimirTiketePromo($idFactura,$Titulo,$COMPrinter,$Copias,$VectorTiket){
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $idFactura);
        $Fecha=$DatosFactura["Fecha"];
        $Hora=$DatosFactura["Hora"];
        $NumFact=$DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"];
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        //fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Titulo); // Titulo
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("NOMBRE:    ",40,"________________________________________",STR_PAD_RIGHT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("CEDULA:    ",40,"________________________________________",STR_PAD_RIGHT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("DIRECCION: ",40,"________________________________________",STR_PAD_RIGHT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("TELEFONO:  ",40,"________________________________________",STR_PAD_RIGHT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("CIUDAD:    ",40,"________________________________________",STR_PAD_RIGHT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha      HORA: $Hora");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"Factura: $NumFact total: $". number_format($DatosFactura["Total"]));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        
    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    }
    /*
     * Imprime un codigo de barras
     * 
     */
    
     public function ImprimirCodigoBarras($Tabla,$idProducto,$Cantidad,$Puerto,$DatosCB){
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        if(!isset($DatosCB["CodigoBarras"])){
            $sql="SELECT CodigoBarras FROM prod_codbarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 1";
            $Consulta =  $this->Query($sql);
            $DatosCodigo=  $this->FetchArray($Consulta);  
            $Codigo=$DatosCodigo["CodigoBarras"]; 
        }else{
            $Codigo=$DatosCB["CodigoBarras"]; 
        }
        
        $Cantidad=$Cantidad/3;
        $Numpages=ceil($Cantidad);
        $idEmpresaPro=$DatosCB["EmpresaPro"];
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $fecha=date("y-m-d");
        $DatosConfigCB = $this->DevuelveValores("config_codigo_barras", "ID", 1);
        $RazonSocial=substr($DatosConfigCB["TituloEtiqueta"],0,17);
        $DatosProducto=$this->DevuelveValores($Tabla, "idProductosVenta", $idProducto);
       
        $Descripcion=substr($DatosProducto["Nombre"],0,16);
        $PrecioVenta= number_format($DatosProducto["PrecioVenta"]);
        $Referencia= $DatosProducto["Referencia"];
        $ID= $DatosProducto["idProductosVenta"];
        $Costo2= substr($DatosProducto["CostoUnitario"], 1, -1);
        $Costo1= substr($DatosProducto["CostoUnitario"], 0, 1);
        $Costo=$Costo1."/".$Costo2;
        $enter="\r\n";
        
        $L1=$DatosConfigCB["DistaciaEtiqueta1"];
        $L2=$DatosConfigCB["DistaciaEtiqueta2"];
        $L3=$DatosConfigCB["DistaciaEtiqueta3"];
        $AL1=$DatosConfigCB["AlturaLinea1"];
        $AL2=$DatosConfigCB["AlturaLinea2"];
        $AL3=$DatosConfigCB["AlturaLinea3"];
        $AL4=$DatosConfigCB["AlturaLinea4"];
        $AL5=$DatosConfigCB["AlturaLinea5"];
        $AlturaCB=$DatosConfigCB["AlturaCodigoBarras"];
        if(strlen($PrecioVenta)>7){
            $TamPrecio=2;
        }else{
            $TamPrecio=4;
        }
        

        fwrite($handle,"SIZE 4,1.1".$enter);
        fwrite($handle,"GAP 4 mm,0".$enter);
        fwrite($handle,"DIRECTION 1".$enter);
        fwrite($handle,"CLS".$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L1.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$ '.$PrecioVenta.'"'.$enter);

        fwrite($handle,'TEXT '.$L2.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L2.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$ '.$PrecioVenta.'"'.$enter);

        fwrite($handle,'TEXT '.$L3.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L3.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$ '.$PrecioVenta.'"'.$enter);
        fwrite($handle,"PRINT $Numpages".$enter);

        $salida = shell_exec('lpr $Puerto');
        


     }
     
     
     /*
      * Imprime un separado
      */
     
     public function ImprimeSeparado($idSeparado,$COMPrinter,$Copias){

        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosSeparado=$this->DevuelveValores("separados", "ID", $idSeparado);
       $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
       
       $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $DatosSeparado["idUsuarios"]);
       $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosSeparado["idCliente"]);
        $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
       
        $Telefono=$DatosEmpresa["Telefono"];

        $Total=$DatosSeparado["Total"];
        $Saldo=$DatosSaldo["Saldo"];
        
        $Fecha=$DatosSeparado["Fecha"];
        $Hora=$DatosSeparado["Hora"];
        
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$NIT);
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Direccion);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"Cliente: $DatosCliente[RazonSocial]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"NIT: $DatosCliente[Num_Identificacion]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha        Hora: $Hora");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"COMPROBANTE DE SEPARADO No $idSeparado");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

        /////////////////////////////ITEMS VENDIDOS

        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

        $sql = "SELECT * FROM separados_items WHERE idSeparado='$idSeparado'";
	
        $consulta=$this->Query($sql);
							
	while($DatosVenta=$this->FetchArray($consulta)){
		
            //$Descuentos=$DatosVenta["Descuentos"];
            //$Impuestos=$DatosVenta["Impuestos"];
            $SubTotalITem=$DatosVenta["TotalItem"];
            //$SubTotalITem=$TotalVenta-$Impuestos;


            fwrite($handle,str_pad($DatosVenta["Cantidad"],4," ",STR_PAD_RIGHT));

            fwrite($handle,str_pad(substr($DatosVenta["Nombre"],0,20),20," ",STR_PAD_BOTH)."   ");

            fwrite($handle,str_pad("$".number_format($SubTotalITem),10," ",STR_PAD_LEFT));

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
}


    $TotalAbonos=$DatosSeparado['Total']-$DatosSeparado['Saldo'];

    /////////////////////////////TOTALES

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL           ".str_pad("$".number_format($DatosSeparado['Total']),20," ",STR_PAD_LEFT));

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"ABONOS:          ");
    $Consulta=$this->ConsultarTabla("separados_abonos", " WHERE idSeparado='$idSeparado'");
    while($DatosAbonos=$this->FetchArray($Consulta)){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"CI No: $DatosAbonos[idComprobanteIngreso]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"Fecha:  $DatosAbonos[Fecha]  Valor: ".str_pad("$".number_format($DatosAbonos["Valor"]),10," ",STR_PAD_LEFT));
               
    }
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL ABONOS:    ".str_pad("$".number_format($TotalAbonos),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"SALDO           ".str_pad("$".number_format($DatosSeparado['Saldo']),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
    fwrite($handle,"***GRACIAS POR ELEGIRNOS***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
    //fwrite($handle, chr(27). chr(100). chr(0));
    //fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle,"***Comprobante impreso por SoftConTech***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"Software disenado por Techno Soluciones SAS, 3177740609, www.technosoluciones.com.co");
    //fwrite($handle,"=================================");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
     
     /*
      * Registra un separado
      */
     
     public function RegistreSeparado($fecha,$Hora,$idPreventa,$idCliente,$Abono,$DatosSeparado) {
         ////Creo el Separado
         
        $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1); 
        $tab="separados";
        $NumRegistros=9;
        $Columnas[0]="ID";                  $Valores[0]="";
        $Columnas[1]="Fecha";               $Valores[1]=$fecha;
        $Columnas[2]="Hora";                $Valores[2]=$Hora;
        $Columnas[3]="idCliente";           $Valores[3]=$idCliente;
        $Columnas[4]="Saldo";               $Valores[4]=0;
        $Columnas[5]="Estado";              $Valores[5]="Abierto";
        $Columnas[6]="Total";               $Valores[6]=0;
        $Columnas[7]="idUsuarios";          $Valores[7]= $this->idUser;
        $Columnas[8]="idSucursal";          $Valores[8]=$DatosSucursal["ID"];
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $idSeparado=$this->ObtenerMAX($tab, "ID", 1, "");
        
        $Total=0;
        //Inserto los items
        $tab="separados_items";
        $NumRegistros=25;
        $Columnas[0]="ID";                  $Valores[0]="";
        $Columnas[1]="idSeparado";          $Valores[1]=$idSeparado;
        
        $consulta=$this->ConsultarTabla("preventa", "WHERE VestasActivas_idVestasActivas='$idPreventa' ");    
        
        while ($DatosPreventa=$this->FetchArray($consulta)){
            
            $DatosProducto= $this->DevuelveValores($DatosPreventa["TablaItem"], "idProductosVenta", $DatosPreventa["ProductosVenta_idProductosVenta"]);
            $Total=$Total+$DatosPreventa['TotalVenta'];
            $SubtotalCosto=$DatosProducto['CostoUnitario']*$DatosPreventa['Cantidad'];
            
            $Columnas[2]="TablaItems";          $Valores[2]=$DatosPreventa["TablaItem"];
            $Columnas[3]="Referencia";          $Valores[3]=$DatosProducto["Referencia"];
            $Columnas[4]="Nombre";              $Valores[4]=$DatosProducto["Nombre"];
            $Columnas[5]="Departamento";        $Valores[5]=$DatosProducto["Departamento"];
            $Columnas[6]="SubGrupo1";           $Valores[6]=$DatosProducto['Sub1'];
            $Columnas[7]="SubGrupo2";           $Valores[7]=$DatosProducto['Sub2'];
            $Columnas[8]="SubGrupo3";           $Valores[8]=$DatosProducto['Sub3'];
            $Columnas[9]="SubGrupo4";           $Valores[9]=$DatosProducto['Sub4'];
            $Columnas[10]="SubGrupo5";          $Valores[10]=$DatosProducto['Sub5'];
            $Columnas[11]="ValorUnitarioItem";  $Valores[11]=$DatosPreventa['ValorAcordado'];
            $Columnas[12]="Cantidad";           $Valores[12]=$DatosPreventa['Cantidad'];
            $Columnas[13]="Multiplicador";      $Valores[13]=1;
            $Columnas[14]="SubtotalItem";       $Valores[14]=$DatosPreventa['Subtotal'];
            $Columnas[15]="IVAItem";            $Valores[15]=$DatosPreventa['Impuestos'];
            $Columnas[16]="TotalItem";          $Valores[16]=$DatosPreventa['TotalVenta'];
            $Columnas[17]="PorcentajeIVA";	$Valores[17]=($DatosProducto['IVA']*100)."%";
            $Columnas[18]="PrecioCostoUnitario";$Valores[18]=$DatosProducto['CostoUnitario'];
            $Columnas[19]="SubtotalCosto";	$Valores[19]=$SubtotalCosto;
            $Columnas[20]="TipoItem";		$Valores[20]=$DatosPreventa["TipoItem"];
            $Columnas[21]="CuentaPUC";		$Valores[21]=$DatosProducto['CuentaPUC'];
            $Columnas[22]="GeneradoDesde";          $Valores[22]="cotizacionesv5";
            $Columnas[23]="NumeroIdentificador";    $Valores[23]="";
            $Columnas[24]="Fecha";                  $Valores[24]=$fecha;
            //$Columnas[25]="idClientes";             $Valores[25]=$idCliente;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            if($DatosPreventa["TipoItem"]=="PR"){
                
                $DatosKardex["Cantidad"]=$DatosPreventa['Cantidad'];
                $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
                $DatosKardex["CostoUnitario"]=$DatosProducto['CostoUnitario'];
                $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
                $DatosKardex["Detalle"]="Separado";
                $DatosKardex["idDocumento"]=$idSeparado;
                $DatosKardex["TotalCosto"]=$SubtotalCosto;
                $DatosKardex["Movimiento"]="SALIDA";
                
                $this->InserteKardex($DatosKardex);
            }
        }
        $idComprobanteAbono=$DatosSeparado["idCompIngreso"];
        $tab="separados_abonos";
        $NumRegistros=8;
        $Columnas[0]="ID";                  $Valores[0]="";
        $Columnas[1]="Fecha";               $Valores[1]=$fecha;
        $Columnas[2]="Hora";                $Valores[2]=$Hora;
        $Columnas[3]="idSeparado";           $Valores[3]=$idSeparado;
        $Columnas[4]="Valor";               $Valores[4]=$Abono;
        $Columnas[5]="idCliente";            $Valores[5]=$idCliente;
        $Columnas[6]="idUsuarios";           $Valores[6]=$this->idUser;
        $Columnas[7]="idComprobanteIngreso"; $Valores[7]=$idComprobanteAbono;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        $Saldo=$Total-$Abono;
        $sql="UPDATE separados SET Total='$Total', Saldo='$Saldo' WHERE ID='$idSeparado'";
        $this->Query($sql);
        $this->BorraReg("preventa", "VestasActivas_idVestasActivas", $idPreventa);
        return($idSeparado);
        
     }
     
     /*
      * Imprime el cierre de un dia
      * 
      */
     
     /*
      * Imprime un separado
      */
     
     public function ImprimeCierre($idUser,$VectorCierre,$COMPrinter,$Copias){
            
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $idCierre=$VectorCierre["idCierre"];
       $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
       $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
       
        $Telefono=$DatosEmpresa["Telefono"];

       $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $idUser);
       $DatosCierre=$this->DevuelveValores("cajas_aperturas_cierres", "ID", $idCierre);
      
       
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$NIT);
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Direccion);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $DatosCierre[Fecha]          HORA: $DatosCierre[Hora]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"COMPROBANTE DE ENTREGA:   $idCierre");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

        /////////////////////////////DEVOLUCIONES
        
        
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

        $sql = "SELECT Cantidad as Cantidad, TotalItem as Total, Referencia as Referencia"
                . " FROM facturas_items fi "
                . " WHERE Cantidad < 0 AND idCierre='$idCierre'";
	
        $consulta=$this->Query($sql);
	$TotalDevoluciones=0;						
	while($DatosVenta=$this->FetchArray($consulta)){
	
            $TotalDevoluciones=$TotalDevoluciones+$DatosVenta["Total"];
           
            fwrite($handle,str_pad($DatosVenta["Cantidad"],4," ",STR_PAD_RIGHT));

            fwrite($handle,str_pad(substr($DatosVenta["Referencia"],0,20),20," ",STR_PAD_BOTH)."   ");

            fwrite($handle,str_pad("$".number_format($DatosVenta["Total"]),10," ",STR_PAD_LEFT));

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        }

        fwrite($handle,str_pad("Total Devoluciones $TotalDevoluciones",10," ",STR_PAD_LEFT));
    
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
    /////////////////////////////TOTALES

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL VENTAS         ".str_pad("$".number_format($DatosCierre["TotalVentas"]),20," ",STR_PAD_LEFT));

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL VENTAS CONTADO ".str_pad("$".number_format($DatosCierre["TotalVentasContado"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL VENTAS CREDITO ".str_pad("$".number_format($DatosCierre["TotalVentasCredito"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"EFECTIVO             ".str_pad("$".number_format($DatosCierre["Efectivo"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"DEVUELTAS            ".str_pad("$".number_format($DatosCierre["Devueltas"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"ABONOS SEPARADOS     ".str_pad("$".number_format($DatosCierre["TotalAbonos"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"ABONOS CREDITOS      ".str_pad("$".number_format($DatosCierre["AbonosCreditos"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"EGRESOS              ".str_pad("$".number_format($DatosCierre["TotalEgresos"]),20," ",STR_PAD_LEFT));
        
    
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL TARJETAS       ".str_pad("$".number_format($DatosCierre["TotalTarjetas"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL CHEQUES        ".str_pad("$".number_format($DatosCierre["TotalCheques"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL OTROS          ".str_pad("$".number_format($DatosCierre["TotalOtros"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL ENTREGA        ".str_pad("$".number_format($DatosCierre["TotalEntrega"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"SALDO EN CAJA        ".str_pad("$".number_format($DatosCierre["TotalEfectivo"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
   
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
    //fwrite($handle, chr(27). chr(100). chr(0));
    //fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle,"***Comprobante impreso por SoftConTech***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"Software disenado por Techno Soluciones SAS, 3177740609, www.technosoluciones.com.co");
    //fwrite($handle,"=================================");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
    
    ///Registre un abono a un separado
    //
    public function CierreTurno($idUser,$idCaja,$VectorCierre) {
        
        $fecha=date("Y-m-d");
        $Hora=date("H:i:s");
       
        //Calculo las ventas
        
        $sql="SELECT SUM(Total) as Total, SUM(Efectivo) as Efectivo, SUM(Devuelve) as Devuelve, SUM(Cheques) as Cheques, SUM(Otros) as Otros, SUM(Tarjetas) as Tarjetas FROM facturas "
                . "WHERE Usuarios_idUsuarios='$idUser' AND CerradoDiario = '' AND FormaPago='Contado'";
        
        $Consulta=$this->Query($sql);
        $DatosSumatorias=$this->FetchArray($Consulta);
        
        $TotalVentasContado=$DatosSumatorias["Total"];
        $TotalEfectivo=$DatosSumatorias["Efectivo"];
        $TotalDevueltas=$DatosSumatorias["Devuelve"];
        $TotalCheques=$DatosSumatorias["Cheques"];
        $TotalOtros=$DatosSumatorias["Otros"];
        $TotalTarjetas=$DatosSumatorias["Tarjetas"];
        
        
        //Calculo las ventas a credito
        //
        $sql="SELECT SUM(Total) as Total FROM facturas "
                . "WHERE Usuarios_idUsuarios='$idUser' AND CerradoDiario = '' AND FormaPago<>'Contado'";
        
        $Consulta=$this->Query($sql);
        $DatosSumatorias=$this->FetchArray($Consulta);
        
        $TotalVentasCredito=$DatosSumatorias["Total"]; 
        
        //Calculo las devoluciones
        
        $sql="SELECT SUM(TotalItem) as TotalDevoluciones FROM facturas_items "
                . "WHERE idUsuarios='$idUser' AND idCierre = '' AND Cantidad < 0";
        
        $Consulta=$this->Query($sql);
        $DatosDevoluciones=$this->FetchArray($Consulta);
        
        $TotalDevoluciones=$DatosDevoluciones["TotalDevoluciones"];
        
        //Calculo los egresos
        
        $sql="SELECT SUM(Valor) as Valor, SUM(Retenciones) as Retenciones FROM egresos "
                . "WHERE Usuario_idUsuario='$idUser' AND CerradoDiario = '' AND PagoProg='Contado'";
        
        $Consulta=$this->Query($sql);
        $DatosEgresos=$this->FetchArray($Consulta);
        
        $TotalEgresos=$DatosEgresos["Valor"];
        $TotalRetenciones=$DatosEgresos["Retenciones"];
        $TotalEgresos=$TotalEgresos-$TotalRetenciones;
        
        
        //Calculo los abonos de separados
        
        $TotalAbonos=$this->Sume("separados_abonos", "Valor", "WHERE idUsuarios='$idUser' AND idCierre=''");
        //Calculo los abonos de Creditos
        
        $TotalAbonosCreditos=$this->Sume("facturas_abonos", "Valor", "WHERE Usuarios_idUsuarios='$idUser' AND idCierre=''");
        
        //Ingreso datos en tabla cierres
        
        $tab="cajas_aperturas_cierres";
        $NumRegistros=20;
        $Columnas[0]="ID";                  $Valores[0]="";
        $Columnas[1]="Fecha";               $Valores[1]=$fecha;
        $Columnas[2]="Hora";                $Valores[2]=$Hora;
        $Columnas[3]="Movimiento";           $Valores[3]="Cierre";
        $Columnas[4]="Usuario";               $Valores[4]=$idUser;
        $Columnas[5]="idCaja";            $Valores[5]=$idCaja;
        $Columnas[6]="TotalVentas";           $Valores[6]=$TotalVentasContado+$TotalVentasCredito-$TotalDevoluciones;
        $Columnas[7]="TotalVentasContado";                  $Valores[7]=$TotalVentasContado;
        $Columnas[8]="TotalVentasCredito";               $Valores[8]=$TotalVentasCredito;
        $Columnas[9]="TotalAbonos";                $Valores[9]=$TotalAbonos;
        $Columnas[10]="TotalDevoluciones";           $Valores[10]=$TotalDevoluciones;
        $Columnas[11]="TotalEntrega";               $Valores[11]=$TotalVentasContado+$TotalTarjetas+$TotalCheques+$TotalOtros+$TotalAbonos+$TotalAbonosCreditos-$TotalEgresos;
        $Columnas[12]="TotalEfectivo";            $Valores[12]=$TotalVentasContado-$TotalEgresos+$TotalAbonos+$TotalAbonosCreditos-$TotalTarjetas-$TotalCheques-$TotalOtros;
        $Columnas[13]="TotalTarjetas";           $Valores[13]=$TotalTarjetas;
        $Columnas[14]="TotalCheques";            $Valores[14]=$TotalCheques;
        $Columnas[15]="TotalOtros";           $Valores[15]=$TotalOtros;
        $Columnas[16]="TotalEgresos";           $Valores[16]=$TotalEgresos;
        $Columnas[17]="Efectivo";           $Valores[17]=$TotalEfectivo;
        $Columnas[18]="Devueltas";           $Valores[18]=$TotalDevueltas;
        $Columnas[19]="AbonosCreditos";           $Valores[19]=$TotalAbonosCreditos;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $idCierre=$this->ObtenerMAX($tab, "ID", 1, "");
        
        //UPDATES
        
        $this->update("facturas", "CerradoDiario", $idCierre, "WHERE CerradoDiario='' AND Usuarios_idUsuarios='$idUser'");
        $this->update("egresos", "CerradoDiario", $idCierre, "WHERE CerradoDiario='' AND Usuario_idUsuario='$idUser'");
        $this->update("separados_abonos", "idCierre", $idCierre, "WHERE idCierre='' AND idUsuarios='$idUser'");
        $this->update("facturas_abonos", "idCierre", $idCierre, "WHERE idCierre='' AND Usuarios_idUsuarios='$idUser'");
        $this->update("facturas_items", "idCierre", $idCierre, "WHERE idCierre='' AND idUsuarios='$idUser'");
         
         
        return ($idCierre);
        
    }
    ///Registre un abono a un separado
    //
    public function RegistreAbonoSeparado($idSeparado,$Valor,$fecha,$Hora,$VectorSeparados) {
        $idIngresos=$VectorSeparados["idCompIngreso"];
        $DatosSeparado=  $this->DevuelveValores("separados", "ID", $idSeparado);
        $tab="separados_abonos";
        $NumRegistros=8;
        $Columnas[0]="ID";                  $Valores[0]="";
        $Columnas[1]="Fecha";               $Valores[1]=$fecha;
        $Columnas[2]="Hora";                $Valores[2]=$Hora;
        $Columnas[3]="idSeparado";           $Valores[3]=$idSeparado;
        $Columnas[4]="Valor";               $Valores[4]=$Valor;
        $Columnas[5]="idCliente";            $Valores[5]=$DatosSeparado["idCliente"];
        $Columnas[6]="idUsuarios";           $Valores[6]=$this->idUser;
        $Columnas[7]="idComprobanteIngreso"; $Valores[7]=$idIngresos;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        $Saldo=$DatosSeparado["Saldo"]-$Valor;
        
        if($Saldo<=0){
            $sql="UPDATE separados SET Saldo='$Saldo', Estado='Cerrado' WHERE ID='$idSeparado'";
            
        }else{
            $sql="UPDATE separados SET Saldo='$Saldo' WHERE ID='$idSeparado'";
            
        }
        $this->Query($sql);
        return($Saldo);
        
    }
    
    ///Inserta items de un separado a una preventa
    //
    public function CreaFacturaDesdeSeparado($idSeparado,$CuentaDestino,$idPreventa) {
        
        $DatosSeparado=$this->DevuelveValores("separados", "ID", $idSeparado);
        $sql="SELECT SUM(SubtotalItem) as Subtotal, SUM(IVAItem) as IVA, SUM(TotalItem) as Total, SUM(SubtotalCosto) as Costo"
                . " FROM separados_items WHERE idSeparado='$idSeparado'";
        
        $consulta=$this->Query($sql);
        $DatosSeparadoItems=  $this->FetchArray($consulta);
        $DatosCaja=$this->DevuelveValores("cajas", "idUsuario", $this->idUser);
        $CentroCostos=$DatosCaja["CentroCostos"];
        $ResolucionDian=$DatosCaja["idResolucionDian"];
        
        //$CuentaDestino=$_REQUEST["CmbCuentaDestino"];
        //$CuentaDestino=110510;
        $OrdenCompra="";
        $OrdenSalida="";
        $ObservacionesFactura="";
        $FechaFactura=date("Y-m-d");
        $TipoPago=15;
        $Consulta=$this->DevuelveValores("centrocosto", "ID", $CentroCostos);
        $EmpresaPro=$Consulta["EmpresaPro"];
        
              
        ////////////////////////////////Preguntamos por disponibilidad
        ///////////
        ///////////
        $ID="";
        $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
        if($DatosResolucion["Completada"]=="NO"){           ///Pregunto si la resolucion ya fue completada
            $Disponibilidad=$DatosResolucion["Estado"];
                                              //si entra a verificar es porque estaba ocupada y cambiará a 1
            while($Disponibilidad=="OC"){                   //miro que esté disponible para facturar, esto para no crear facturas dobles
                print("Esperando disponibilidad<br>");
                usleep(300);
                $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
                $Disponibilidad=$DatosResolucion["Estado"];
                
            }
            
            $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
            if($DatosResolucion["Completada"]<>"SI"){
                $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "OC", "ID", $ResolucionDian); //Ocupo la resolucion
                
                $sql="SELECT MAX(NumeroFactura) as FacturaActual FROM facturas WHERE Prefijo='$DatosResolucion[Prefijo]' "
                        . "AND TipoFactura='$DatosResolucion[Tipo]' AND idResolucion='$ResolucionDian'";
                $Consulta=$this->Query($sql);
                $Consulta=$this->FetchArray($Consulta);
                $FacturaActual=$Consulta["FacturaActual"];
                $idFactura=$FacturaActual+1;
                
                //Verificamos si ya se completó el numero de la resolucion y si es así se cambia su estado
                if($DatosResolucion["Hasta"]==$idFactura){ 
                    $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Completada", "SI", "ID", $ResolucionDian);
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
                $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
                $ID=date("YmdHis").microtime(false);
                $tab="facturas";
                $NumRegistros=28; 
                
                $Columnas[0]="TipoFactura";		    $Valores[0]=$DatosResolucion["Tipo"];
                $Columnas[1]="Prefijo";                     $Valores[1]=$DatosResolucion["Prefijo"];
                $Columnas[2]="NumeroFactura";               $Valores[2]=$idFactura;
                $Columnas[3]="Fecha";                       $Valores[3]=$FechaFactura;
                $Columnas[4]="OCompra";                     $Valores[4]=$OrdenCompra;
                $Columnas[5]="OSalida";                     $Valores[5]=$OrdenSalida;
                $Columnas[6]="FormaPago";                   $Valores[6]=$FormaPagoFactura;
                $Columnas[7]="Subtotal";                    $Valores[7]=$DatosSeparadoItems["Subtotal"];
                $Columnas[8]="IVA";                         $Valores[8]=$DatosSeparadoItems["IVA"];
                $Columnas[9]="Descuentos";                  $Valores[9]="";
                $Columnas[10]="Total";                      $Valores[10]=$DatosSeparadoItems["Total"];
                $Columnas[11]="SaldoFact";                  $Valores[11]=$DatosSeparadoItems["Total"];
                $Columnas[12]="Cotizaciones_idCotizaciones";$Valores[12]="";
                $Columnas[13]="EmpresaPro_idEmpresaPro";    $Valores[13]=$EmpresaPro;
                $Columnas[14]="Usuarios_idUsuarios";        $Valores[14]=$this->idUser;
                $Columnas[15]="Clientes_idClientes";        $Valores[15]=$DatosSeparado["idCliente"];
                $Columnas[16]="TotalCostos";                $Valores[16]=$DatosSeparadoItems["Costo"];
                $Columnas[17]="CerradoDiario";              $Valores[17]="";
                $Columnas[18]="FechaCierreDiario";          $Valores[18]="";
                $Columnas[19]="HoraCierreDiario";           $Valores[19]="";
                $Columnas[20]="ObservacionesFact";          $Valores[20]=$ObservacionesFactura;
                $Columnas[21]="CentroCosto";                $Valores[21]=$CentroCostos;
                $Columnas[22]="idResolucion";               $Valores[22]=$ResolucionDian;
                $Columnas[23]="idFacturas";                 $Valores[23]=$ID;
                $Columnas[24]="Hora";                       $Valores[24]=date("H:i:s");
                $Columnas[25]="Efectivo";                   $Valores[25]=0;
                $Columnas[26]="Devuelve";                   $Valores[26]=0;
                $Columnas[27]="idSucursal";                 $Valores[27]=$DatosSucursal["ID"];
                
                $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                
                //libero la resolucion
                $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "", "ID", $ResolucionDian);
                
                //////////////////////Agrego Items a la Factura desde la devolucion
                /////
                /////
                
                $CuentaDestino="1305";
                $Datos["idSeparado"]=$idSeparado;
                $Datos["NumFactura"]=$idFactura;
                $Datos["FechaFactura"]=$FechaFactura;
                $Datos["ID"]=$ID;
                $Datos["CuentaDestino"]=$CuentaDestino;
                $Datos["EmpresaPro"]=$EmpresaPro;
                $Datos["CentroCostos"]=$CentroCostos;
                $this->InsertarItemsSeparadoAItemsFactura($Datos);///Relaciono los items de la factura
                
                $this->InsertarFacturaLibroDiario($Datos);///Inserto Items en el libro diario
                $CuentaDestino="1305";
                $Concepto="Cruce de anticipos por salida de separado No $idSeparado";
                $VectorCruce["fut"]="";
                $this->CruceAnticiposSeparados($FechaFactura,$CuentaDestino,$DatosSeparado["idCliente"],$DatosSeparadoItems["Total"],1,$Concepto,$this->idUser,$ID,$VectorCruce);
                                 
            }    
          
        }else{
            exit("La Resolucion de facturacion fue completada");
        }
	return ($ID);	
        
    }
    
    ///Creo un Egreso
    //
    public function CrearEgreso($fecha,$FechaProgramada,$idUser,$CentroCostos,$TipoPago,$CuentaOrigen,$CuentaDestino,$CuentaPUCIVA,$idProveedor, $Concepto,$NumFact,$destino,$TipoEgreso,$Subtotal,$IVA,$Total,$Sanciones,$Intereses,$Impuestos,$ReteFuente,$ReteIVA,$ReteICA,$VectorEgreso) {
      
        if($TipoEgreso==3){
			
			
                $TotalSanciones=$Sanciones+$Intereses;

                $Subtotal=$Impuestos;
			
								
		}elseif($TipoEgreso==1){
			$Subtotal=$Total;
				
		
		}else{
			$Subtotal=$Subtotal;
			$IVA=$IVA;
			
		}
                //$Subtotal=$Subtotal;   //Se le restan las retenciones
                $Valor=$Total;
		$Total=$Total-$ReteICA-$ReteIVA-$ReteFuente; 
		$Retenciones=$ReteICA+$ReteIVA+$ReteFuente;
		//////registramos en egresos
		
				
		$DatosProveedor=$this->DevuelveValores("proveedores","idProveedores",$idProveedor);
		$DatosCentroCosto=$this->DevuelveValores("centrocosto","ID",$CentroCostos);
                $NombreTipoEgreso="";
                if($TipoEgreso=="VentasRapidas"){
                    $NombreTipoEgreso=$TipoEgreso;
                }else{
                    $DatosTipoEgreso=$this->DevuelveValores("egresos_tipo","id",$TipoEgreso);
                    $NombreTipoEgreso=$DatosTipoEgreso["Nombre"];
                }
		$RazonSocial=$DatosProveedor["RazonSocial"];
		$NIT=$DatosProveedor["Num_Identificacion"];
		$idEmpresa=$DatosCentroCosto["EmpresaPro"];
		$idCentroCostos=$DatosCentroCosto["ID"];
                
                
                if($TipoPago=="Contado"){
                
                    $NumRegistros=20;

                    $Columnas[0]="Fecha";				$Valores[0]=$fecha;
                    $Columnas[1]="Beneficiario";		$Valores[1]=$RazonSocial;
                    $Columnas[2]="NIT";					$Valores[2]=$NIT;
                    $Columnas[3]="Concepto";			$Valores[3]=$Concepto;
                    $Columnas[4]="Valor";				$Valores[4]=$Valor;
                    $Columnas[5]="Usuario_idUsuario";	$Valores[5]=$idUser;
                    $Columnas[6]="PagoProg";			$Valores[6]=$TipoPago;
                    $Columnas[7]="FechaPagoPro";		$Valores[7]=$fecha;
                    $Columnas[8]="TipoEgreso";			$Valores[8]=$NombreTipoEgreso;
                    $Columnas[9]="Direccion";			$Valores[9]=$DatosProveedor["Direccion"];
                    $Columnas[10]="Ciudad";				$Valores[10]=$DatosProveedor["Ciudad"];
                    $Columnas[11]="Subtotal";			$Valores[11]=$Subtotal;
                    $Columnas[12]="IVA";				$Valores[12]=$IVA;
                    $Columnas[13]="NumFactura";			$Valores[13]=$NumFact;
                    $Columnas[14]="idProveedor";		$Valores[14]=$idProveedor;
                    $Columnas[15]="Cuenta";				$Valores[15]=$CuentaOrigen;
                    $Columnas[16]="CentroCostos";			$Valores[16]=$idCentroCostos;	
                    $Columnas[17]="EmpresaPro";		$Valores[17]= $idEmpresa;	
                    $Columnas[18]="Soporte";		$Valores[18]= $destino;
                    $Columnas[19]="Retenciones";	$Valores[19]= $Retenciones;

                    $this->InsertarRegistro("egresos",$NumRegistros,$Columnas,$Valores);
                    
                    $NumEgreso=$this->ObtenerMAX("egresos","idEgresos", 1, "");
                    $DocumentoSoporte="CompEgreso";
                    $RutaPrintComp="../tcpdf/examples/imprimircomp.php?ImgPrintComp=$NumEgreso";
                }
                
                if($TipoPago=="Programado"){
                
                    $NumRegistros=12;

                    $Columnas[0]="Fecha";		$Valores[0]=$fecha;
                    $Columnas[1]="Detalle";		$Valores[1]=$Concepto;
                    $Columnas[2]="idProveedor";		$Valores[2]=$idProveedor;
                    $Columnas[3]="Subtotal";		$Valores[3]=$Subtotal;
                    $Columnas[4]="IVA";			$Valores[4]=$IVA;
                    $Columnas[5]="Total";               $Valores[5]=$Valor;
                    $Columnas[6]="Soporte";		$Valores[6]=$destino;
                    $Columnas[7]="NumFactura";		$Valores[7]=$NumFact;
                    $Columnas[8]="Usuario_idUsuario";	$Valores[8]=$idUsuario;
                    $Columnas[9]="CentroCostos";	$Valores[9]=$idCentroCostos;
                    $Columnas[10]="EmpresaPro";		$Valores[10]=$idEmpresa;
                    $Columnas[11]="FechaProgramada";	$Valores[11]=$FechaProgramada;
                    
                    $this->InsertarRegistro("notascontables",$NumRegistros,$Columnas,$Valores);
                    
                    $NumEgreso=$tabla->ObtenerMAX("notascontables","ID", 1, "");
                    $DocumentoSoporte="NotaContable";
                    $RutaPrintComp="../tcpdf/examples/NotaContablePrint.php?ImgPrintComp=$NumEgreso";
                }
                
                
		/////////////////////////////////////////////////////////////////
		//////registramos en libro diario
		$DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
                
		$tab="librodiario";
		
		$NumRegistros=27;
		$CuentaPUC=$CuentaDestino;  			 
		if($TipoEgreso==3) //Si es pago de impuestos
			$DatosCuenta=$this->DevuelveValores("cuentas","idPUC",$CuentaPUC);	
		else
			$DatosCuenta=$this->DevuelveValores("subcuentas","PUC",$CuentaPUC);
		
		$NombreCuenta=$DatosCuenta["Nombre"];
			
		$Columnas[0]="Fecha";                   $Valores[0]=$fecha;
		$Columnas[1]="Tipo_Documento_Intero";	$Valores[1]=$DocumentoSoporte;
		$Columnas[2]="Num_Documento_Interno";	$Valores[2]=$NumEgreso;
		$Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosProveedor['Tipo_Documento'];
		$Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
		$Columnas[5]="Tercero_DV";		$Valores[5]=$DatosProveedor['DV'];
		$Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosProveedor['Primer_Apellido'];
		$Columnas[7]="Tercero_Segundo_Apellido";$Valores[7]=$DatosProveedor['Segundo_Apellido'];
		$Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosProveedor['Primer_Nombre'];
		$Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosProveedor['Otros_Nombres'];
		$Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocial;
		$Columnas[11]="Tercero_Direccion";	$Valores[11]=$DatosProveedor['Direccion'];
		$Columnas[12]="Tercero_Cod_Dpto";	$Valores[12]=$DatosProveedor['Cod_Dpto'];
		$Columnas[13]="Tercero_Cod_Mcipio";	$Valores[13]=$DatosProveedor['Cod_Mcipio'];
		$Columnas[14]="Tercero_Pais_Domicilio"; $Valores[14]=$DatosProveedor['Pais_Domicilio'];
		$Columnas[15]="CuentaPUC";		$Valores[15]=$CuentaPUC;
		$Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
		$Columnas[17]="Detalle";		$Valores[17]="egresos";		
		$Columnas[18]="Debito";			$Valores[18]=$Subtotal;
		$Columnas[19]="Credito";		$Valores[19]="0";
		$Columnas[20]="Neto";			$Valores[20]=$Subtotal;
		$Columnas[21]="Mayor";			$Valores[21]="NO";
		$Columnas[22]="Esp";			$Valores[22]="NO";
		$Columnas[23]="Concepto";		$Valores[23]=$Concepto;
		$Columnas[24]="idCentroCosto";		$Valores[24]=$idCentroCostos;
		$Columnas[25]="idEmpresa";              $Valores[25]=$idEmpresa;
		$Columnas[26]="idSucursal";             $Valores[26]=$DatosSucursal["ID"];					
		$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		/////////////////////////////////////////////////////////////////
		//////contra partida
		if($TipoPago=="Contado"){
			
			
			$CuentaPUC=$CuentaOrigen; //cuenta de donde sacaremos el valor del egreso
			
			$DatosCuenta=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaPUC);
			$NombreCuenta=$DatosCuenta["Nombre"];
		}
		if($TipoPago=="Programado"){
			$CuentaPUC="2205";
			$NombreCuenta="Proveedores Nacionales $RazonSocial $NIT";
		}
		
		
		$Valores[15]=$CuentaPUC;
		$Valores[16]=$NombreCuenta;
		$Valores[18]="0";
		$Valores[19]=$Total; 						//Credito se escribe el total de la venta menos los impuestos
		$Valores[20]=$Total*(-1);  											//Credito se escribe el total de la venta menos los impuestos
		
		$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		/////////////////////////////////////////////////////////////////
		//////Si hay IVA
		if($IVA<>0){
			$CuentaPUC=$CuentaPUCIVA; //cuenta de donde sacaremos el valor del egreso
			if($CuentaPUC>2408)
				$DatosCuenta=$this->DevuelveValores("subcuentas","PUC",$CuentaPUC);
			else
				$DatosCuenta=$this->DevuelveValores("cuentas","idPUC",$CuentaPUC);
			
			$NombreCuenta=$DatosCuenta["Nombre"];
			
			$Valores[15]=$CuentaPUC;
			$Valores[16]=$NombreCuenta;
			$Valores[18]=$IVA;
			$Valores[19]=0; 						
			$Valores[20]=$IVA;  											//Credito se escribe el total de la venta menos los impuestos
			
			$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		}
		
		//////Si hay IVA
		if(!empty($TotalSanciones)){
		
			$CuentaPUC=539520; //Multas, sanciones y litigios
			
			$DatosCuenta=$this->DevuelveValores("subcuentas","PUC",$CuentaPUC);
			$NombreCuenta=$DatosCuenta["Nombre"];
			
			$Valores[15]=$CuentaPUC;
			$Valores[16]=$NombreCuenta;
			$Valores[18]=$TotalSanciones;
			$Valores[19]=0; 						
			$Valores[20]=$TotalSanciones;  											//Credito se escribe el total de la venta menos los impuestos
			
			$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		}
                
                if(!empty($ReteFuente)){   //Si hay retencion en la fuente se registra
                    
			
                    $DatosCuenta=$this->DevuelveValores("tiposretenciones","ID",1);
                                        
                    $NombreCuenta=$DatosCuenta["NombreCuentaPasivo"];
                    $CuentaPUC=$DatosCuenta["CuentaPasivo"];
                    
                    $Valores[15]=$CuentaPUC;
                    $Valores[16]=$NombreCuenta;
                    $Valores[18]=0;
                    $Valores[19]=$ReteFuente; 						
                    $Valores[20]=$ReteFuente*(-1);  											//Credito se escribe el total de la venta menos los impuestos

                    $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores); //Registro el credito
                }
                
                if(!empty($ReteIVA)){   //Si hay retencion de IVA se registra
                    
			
                    $DatosCuenta=$this->DevuelveValores("tiposretenciones","ID",2);
                                        
                    $NombreCuenta=$DatosCuenta["NombreCuentaPasivo"];
                    $CuentaPUC=$DatosCuenta["CuentaPasivo"];
                    
                    $Valores[15]=$CuentaPUC;
                    $Valores[16]=$NombreCuenta;
                    $Valores[18]=0;
                    $Valores[19]=$ReteIVA; 						
                    $Valores[20]=$ReteIVA*(-1);  											//Credito se escribe el total de la venta menos los impuestos

                    $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores); //Registro el credito
                }
		
                
                if(!empty($ReteICA)){   //Si hay retencion de ICA se registra
                    
			
                    $DatosCuenta=$this->DevuelveValores("tiposretenciones","ID",3);
                                        
                    $NombreCuenta=$DatosCuenta["NombreCuentaPasivo"];
                    $CuentaPUC=$DatosCuenta["CuentaPasivo"];
                    
                    $Valores[15]=$CuentaPUC;
                    $Valores[16]=$NombreCuenta;
                    $Valores[18]=0;
                    $Valores[19]=$ReteICA; 						
                    $Valores[20]=$ReteICA*(-1);  											//Credito se escribe el total de la venta menos los impuestos

                    $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores); //Registro el credito
                }
                
        return ($NumEgreso);
    }
    
    /*
     * Imprime en un egreso en POS
     * 
     */
    
    public function ImprimeEgresoPOS($idEgreso,$VectorEgresos,$COMPrinter,$Copias){
            
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosEgreso=$this->DevuelveValores("egresos", "idEgresos", $idEgreso);
       $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
       $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
       
        $Telefono=$DatosEmpresa["Telefono"];

       $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $DatosEgreso["Usuario_idUsuario"]);
             
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$NIT);
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Direccion);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Usuario:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $DatosEgreso[Fecha]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"COMPROBANTE DE EGRESO:   $idEgreso");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

        /////////////////////////////Beneficiario
       
        fwrite($handle,"DATOS DEL BENEFICIARIO");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

        fwrite($handle,str_pad("Razon Social: $DatosEgreso[Beneficiario]",10," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("NIT: $DatosEgreso[NIT]",10," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,str_pad("Direccion: $DatosEgreso[Direccion]",10," ",STR_PAD_LEFT));
        
        fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle,str_pad("Ciudad: $DatosEgreso[Ciudad]",10," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));
    /////////////////////////////TOTALES
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    /////////////////////////////Beneficiario
    
    fwrite($handle,"CONCEPTO");
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,$DatosEgreso["Concepto"]);
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    /////////////////////////////Totales
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"SUBTOTAL:      ".str_pad("$".number_format($DatosEgreso["Subtotal"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"IVA:           ".str_pad("$".number_format($DatosEgreso["IVA"]),20," ",STR_PAD_LEFT));
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL:         ".str_pad("$".number_format($DatosEgreso["Valor"]),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"RECIBIDO:     _______________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"REALIZA:      _______________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"APRUEBA:      _______________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
   
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
    //fwrite($handle, chr(27). chr(100). chr(0));
    //fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle,"***Comprobante impreso por SoftConTech***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"Software disenado por Techno Soluciones SAS, 3177740609, www.technosoluciones.com.co");
    //fwrite($handle,"=================================");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
    //Funcion para Conetarse a un servidor y seleccionar una base de datos
     public function ConToServer($ip,$User,$Pass,$db,$VectorCon){
        
        $con = mysql_connect($ip,$User,$Pass);
        if(!$con){
            $Mensaje="No se pudo conectar al servidor en la ip: $ip ".  mysql_error();
            exit($Mensaje);
        }else{
            $Mensaje="Conexion satisfactoria";
            mysql_select_db($db,$con) or die("No es posible abrir la base de datos ".  mysql_error());
            return($Mensaje);
        }
            
            
    }
     
        
     //Funcion para Conetarse a un servidor y seleccionar una base de datos
     public function CerrarCon(){
        
         mysql_close();
        
        
     }
     
     
     
     //Funcion para Crear un nuevo traslado
     public function CrearTraslado($fecha,$hora,$Concepto,$Destino,$VectorTraslado){
        $idBodega=   $VectorTraslado["idBodega"];      
        $sql="SELECT Identificacion FROM usuarios WHERE idUsuarios='$this->idUser'";
        $Consulta=$this->Query($sql);
        $DatosUsuario=$this->FetchArray($Consulta);
        $DatosSucursalActual=$this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
        $Consecutivo=$this->ObtenerMAX("traslados_mercancia", "ConsecutivoInterno", "Origen", $DatosSucursalActual["ID"]);
        $Consecutivo++;
        
        $tab="traslados_mercancia";
        $NumRegistros=10; 
        $id=  $DatosSucursalActual["ID"]."-".$Consecutivo;
        $Columnas[0]="Fecha";               $Valores[0]=$fecha;
        $Columnas[1]="Descripcion";         $Valores[1]=$Concepto;
        $Columnas[2]="Hora";                $Valores[2]=$hora;
        $Columnas[3]="Abre";                $Valores[3]=$DatosUsuario["Identificacion"];
        $Columnas[4]="Estado";              $Valores[4]="EN DESARROLLO";
        $Columnas[5]="ID";                  $Valores[5]=$id;
        $Columnas[6]="Destino";             $Valores[6]=$Destino;
        $Columnas[7]="Origen";              $Valores[7]=$DatosSucursalActual["ID"];
        $Columnas[8]="ConsecutivoInterno";  $Valores[8]=$Consecutivo;
        $Columnas[9]="idBodega";            $Valores[9]=$idBodega;
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    
       return($id); 
        
     }
     
     //Funcion para Crear un nuevo traslado
     public function AgregarItemTraslado($idComprobante,$idProducto,$Cantidad,$VectorItem){
         
       $DatosTraslado=$this->DevuelveValores("traslados_mercancia", "ID", $idComprobante);
       $idBodega=$DatosTraslado["idBodega"];
       $DatosProducto=$this->DevuelveValores("productosventa", "idProductosVenta", $idProducto);
       $PrecioVenta=$DatosProducto["PrecioVenta"];
       $PrecioMayorista=$DatosProducto["PrecioMayorista"];
       if($idBodega>1){
            $DatosProductoBodega=$this->DevuelveValores("productosventa_bodega_$idBodega", "Referencia", $DatosProducto["Referencia"]);
            $PrecioVenta=$DatosProductoBodega["PrecioVenta"];
            $PrecioMayorista=$DatosProductoBodega["PrecioMayorista"];
            
       }
       $sql="SELECT CodigoBarras FROM prod_codbarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 1";
       $consulta=$this->Query($sql);
       $CodigoBarras=$this->FetchArray($consulta);
       //$CodigoBarras=$this->DevuelveValores("prod_codbarras", "ProductosVenta_idProductosVenta", $idProducto);
       $tab="traslados_items";
       $NumRegistros=19;

       $Columnas[0]="Fecha";			$Valores[0]=$DatosTraslado["Fecha"];
       $Columnas[1]="CodigoBarras";		$Valores[1]=$CodigoBarras["CodigoBarras"];
       $Columnas[2]="Referencia";		$Valores[2]=$DatosProducto["Referencia"];
       $Columnas[3]="Nombre";			$Valores[3]=$DatosProducto["Nombre"];
       $Columnas[4]="Cantidad";			$Valores[4]=$Cantidad;
       $Columnas[5]="PrecioVenta";              $Valores[5]=$PrecioVenta;
       $Columnas[6]="PrecioMayorista";		$Valores[6]=$PrecioMayorista;
       $Columnas[7]="CostoUnitario";		$Valores[7]=$DatosProducto["CostoUnitario"];
       $Columnas[8]="IVA";			$Valores[8]=$DatosProducto["IVA"];
       $Columnas[9]="Departamento";		$Valores[9]=$DatosProducto["Departamento"];
       $Columnas[10]="Sub1";                    $Valores[10]=$DatosProducto["Sub1"];
       $Columnas[11]="Sub2";			$Valores[11]=$DatosProducto["Sub2"];
       $Columnas[12]="Sub3";                    $Valores[12]=$DatosProducto["Sub3"];
       $Columnas[13]="Sub4";			$Valores[13]=$DatosProducto["Sub4"];
       $Columnas[14]="Sub5";                    $Valores[14]=$DatosProducto["Sub5"];
       $Columnas[15]="CuentaPUC";		$Valores[15]=$DatosProducto["CuentaPUC"];
       $Columnas[16]="idTraslado";		$Valores[16]=$idComprobante;
       $Columnas[17]="Estado";                  $Valores[17]="EN DESARROLLO";
       $Columnas[18]="Destino";                 $Valores[18]=$DatosTraslado["Destino"];
       
       $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    
     }
     
     //Funcion para Crear un nuevo traslado
     public function SubirTraslado($idServer,$VectorTraslado){
        $host=$VectorTraslado["LocalHost"];
        $user=$VectorTraslado["User"];
        $pw=$VectorTraslado["PW"];
        $db=$VectorTraslado["DB"];
        $sql1="";
        $sql2="";
                
        $VectorAS["f"]=0;
        $DatosServer=$this->DevuelveValores("servidores", "ID", $idServer); 
        $FechaSinc=date("Y-m-d H:i:s");
        //$Condicion=" WHERE ServerSincronizado='0000-00-00 00:00:00'";
        
        $CondicionUpdate=" WHERE ServerSincronizado = '0000-00-00 00:00:00' AND Estado='PREPARADO'";
        $sql1=$this->ArmeSqlInsert("traslados_mercancia", $db, $CondicionUpdate,$DatosServer["DataBase"],$FechaSinc, $VectorAS);
        $VectorAS["AI"]=1; //Indicamos que la tabla tiene id con autoincrement
        $sql2=$this->ArmeSqlInsert("traslados_items", $db, $CondicionUpdate,$DatosServer["DataBase"],$FechaSinc, $VectorAS);
        
        
        $VectorCon["Fut"]=0;  
        $this->ConToServer($DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], $VectorCon);
        if(!empty($sql1)){
            $this->Query($sql1);
        }
        if(!empty($sql2)){
            $this->Query($sql2);
        }
        
        $this->ConToServer($host, $user, $pw, $db, $VectorCon);   
        $this->update("traslados_mercancia", "ServerSincronizado", $FechaSinc, $CondicionUpdate); 
        $this->update("traslados_items", "ServerSincronizado", $FechaSinc, $CondicionUpdate); 
        
        return("Se han sincronizado todos los traslados");
         
     }
     
     /*
      * Descargar Traslados
      */
     
     //Funcion para Crear un nuevo traslado
     public function DescargarTraslado($idServer,$VectorTraslado){
        $host=$VectorTraslado["LocalHost"];
        $user=$VectorTraslado["User"];
        $pw=$VectorTraslado["PW"];
        $db=$VectorTraslado["DB"];
        $sql1="";
        $sql2="";
        $VectorCon["Fut"]=0; 
        $this->ConToServer($host, $user, $pw, $db, $VectorCon);
        $DatosSucursal=$this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);        
        $VectorAS["f"]=0;
        $DatosServer=$this->DevuelveValores("servidores", "ID", $idServer); 
        $FechaSinc=date("Y-m-d H:i:s");
        
        $this->ConToServer($DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], $VectorCon);
        
        $CondicionUpdate=" WHERE DestinoSincronizado ='0000-00-00 00:00:00' AND Destino='$DatosSucursal[ID]'";
        $sql1=$this->ArmeSqlInsert("traslados_mercancia", $DatosServer["DataBase"], $CondicionUpdate,$db,$FechaSinc, $VectorAS);
        $VectorAS["AI"]=1; //Indicamos que la tabla tiene id con autoincrement
        $sql2=$this->ArmeSqlInsert("traslados_items", $DatosServer["DataBase"], $CondicionUpdate,$db,$FechaSinc, $VectorAS);
        
        $this->update("traslados_mercancia", "DestinoSincronizado", $FechaSinc, $CondicionUpdate); 
        $this->update("traslados_items", "DestinoSincronizado", $FechaSinc, $CondicionUpdate); 
         
        $this->ConToServer($host, $user, $pw, $db, $VectorCon);  
        if(!empty($sql1)){
            $this->Query($sql1);
        }
        if(!empty($sql2)){
            $this->Query($sql2);
        }
        
        //$this->ConToServer($host, $user, $pw, $db, $VectorCon);   
        $this->update("traslados_mercancia", "DestinoSincronizado", $FechaSinc, $CondicionUpdate); 
        $this->update("traslados_items", "DestinoSincronizado", $FechaSinc, $CondicionUpdate); 
        
        return("Se han sincronizado todos los traslados");
         
     }
     //Obtiene los nombres de las columnas de una tabla
     
     public function MostrarColumnas($Tabla,$DataBase) {
         
        $sql="SHOW COLUMNS FROM `$DataBase`.`$Tabla`;";
        $Results=$this->Query($sql);
        $i=0;
        while($Columnas = $this->FetchArray($Results) ){
            $Nombres[$i]=$Columnas["Field"];
            $i++;

        }
        return($Nombres);

    }
    
    
    //Funcion para armar un sql de los datos en una tabla de acuerdo a una condicion
    
    public function ArmeSqlInsert($Tabla,$db,$Condicion,$DataBaseDestino,$FechaSinc, $VectorAS) {
        $ai=0;
        if(isset($VectorAS["AI"])){
            $ai=1;
        }
            
        
        
        ////Armo el sql de los items
        $tb=$Tabla;
        //$tb="librodiario";
        $Columnas=  $this->MostrarColumnas($tb,$db);
        $Leng=count($Columnas);
        
        $sql=" REPLACE INTO `$DataBaseDestino`.`$tb` (";
        $i=0;
        foreach($Columnas as $NombreCol){
            if($NombreCol=="ServerSincronizado"){
                $idServerCol=$i;
            }
            $sql.="`$NombreCol`,";
            $i++;
        }
        $sql=substr($sql, 0, -1);
        $sql.=") VALUES (";
        $consulta=$this->ConsultarTabla($tb, $Condicion);
        if($this->NumRows($consulta)){
        while($Datos =  $this->FetchArray($consulta)){
            
            for ($i=0;$i<$Leng;$i++){
                $DatoN=  $this->normalizar($Datos[$i]);
                if($i==0 and $ai==1){
                   $sql.="'',"; 
                }else{
                    
                    if($i==$idServerCol){
                       $sql.="'$FechaSinc',"; 
                    }else{
                       $sql.="'$DatoN',";
                    }
                }   
               
            }
            $sql=substr($sql, 0, -1);
            $sql.="),(";
            
        }
        $sql=substr($sql, 0, -2);
        $sql.="; ";
        }else{
           $sql=""; 
        }
        
        
        return($sql);
    }
    
    //Funcion para armar un sql de los datos en una tabla de acuerdo a una condicion
    
    public function ArmeSQLCopiarTabla($Tabla,$db,$DataBaseDestino, $VectorAS) {
        $ai=0;
        if(isset($VectorAS["AI"])){
            $ai=1;
        }
        $TablaOrigen=$Tabla;
        $TablaDestino=$Tabla;
        if(isset($VectorAS["TablaDestino"])){
            $TablaDestino=$VectorAS["TablaDestino"];
        }
        
        //Armo la informacion de la tabla
        $VectorE["F"]=0;
        //$sql=" SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
          //      SET time_zone = '+00:00';\r";
        
        $sql="CREATE TABLE IF NOT EXISTS `$DataBaseDestino`.`$TablaDestino` (\r";
        $Datos=$this->MuestraEstructura($Tabla, $db, $VectorE);
        $PrimaryKey="";
        $UniqueKey="";
        while($Estructura=$this->FetchArray($Datos)){
            $Comentarios="";
            
            if(!empty($Estructura["COLUMN_COMMENT"])){
                $Comentarios=" COMMENT '$Estructura[COLUMN_COMMENT]'";
            }
            if($Estructura["COLUMN_KEY"]=="PRI"){
                $PrimaryKey="PRIMARY KEY (`$Estructura[COLUMN_NAME]`),";
            }
            $Nullable="";
            if($Estructura["IS_NULLABLE"]=="NO"){
                $Nullable="NOT NULL";
            }
            if($Estructura["COLUMN_KEY"]=="UNI"){
                $UniqueKey="UNIQUE KEY (`$Estructura[COLUMN_NAME]`),";
            }
            if($Estructura["COLUMN_KEY"]=="MUL"){
                $UniqueKey="KEY `$Estructura[COLUMN_NAME]` (`$Estructura[COLUMN_NAME]`),";
            }
            $Collaction="";
            if(!empty($Estructura["COLLATION_NAME"])){
                $Collaction="COLLATE ".$Estructura["COLLATION_NAME"];
            }
            $Defecto="";
            if(!empty($Estructura["COLUMN_DEFAULT"])){
                if($Estructura["COLUMN_DEFAULT"]=="CURRENT_TIMESTAMP"){
                    $ValorDefecto="CURRENT_TIMESTAMP";
                }else{
                    $ValorDefecto="'$Estructura[COLUMN_DEFAULT]'";
                }
                $Defecto=" DEFAULT $ValorDefecto";
            }
            
            $sql.="`$Estructura[COLUMN_NAME]` $Estructura[COLUMN_TYPE] $Nullable $Collaction $Defecto $Estructura[EXTRA] $Comentarios,";
        }
        $sql.="$PrimaryKey$UniqueKey";
        $sql=substr($sql, 0, -1);
        $sql.="\r";
        $sql.=") ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci; \r";
        return ($sql);
    }
    //Funcion para armar un sql de los datos en una tabla de acuerdo a una condicion
    
    public function ArmeSqlReplace($Tabla,$db,$Condicion,$DataBaseDestino,$FechaSinc, $VectorAS) {
        $ai=0;
        if(isset($VectorAS["AI"])){
            $ai=1;
        }
        $TablaOrigen=$Tabla;
        $TablaDestino=$Tabla;
        if(isset($VectorAS["TablaDestino"])){
            $TablaDestino=$VectorAS["TablaDestino"];
        }
        
        
        $Columnas=  $this->MostrarColumnas($TablaOrigen,$db);
        $Leng=count($Columnas);
        
        $sql="\r REPLACE INTO `$DataBaseDestino`.`$TablaDestino` (";
        $i=0;
        foreach($Columnas as $NombreCol){
            if($NombreCol=="Sync"){
                $idServerCol=$i;
            }
            $sql.="`$NombreCol`,";
            $i++;
        }
        $sql=substr($sql, 0, -1);
        $sql.=") VALUES (";
        $ConsultaParcial=$sql;
        $consulta=$this->ConsultarTabla($TablaOrigen, $Condicion);
        if($this->NumRows($consulta)){
            $z=0;
        while($Datos =  $this->FetchArray($consulta)){
            $z++;
            for ($i=0;$i<$Leng;$i++){
                $DatoN=  $this->normalizar($Datos[$i]);
                if($i==0 and $ai==1){
                   $sql.="'',"; 
                }else{
                    
                    if($i==$idServerCol){
                       $sql.="'$FechaSinc',"; 
                    }else{
                       $sql.="'$DatoN',";
                    }
                }   
               
            }
            $sql=substr($sql, 0, -1);
            $sql.="),(";
            //if($z==500){
            //    $sql=substr($sql, 0, -2);
            //    $sql.="; ";
            //    $sql.=$ConsultaParcial;
            //    $z=0;
            //}    
        }
        $sql=substr($sql, 0, -2);
        $sql.="; ";
        }else{
           $sql=""; 
        }
        
        
        return($sql);
    }
    
    //funcion para avanzar un traslado a pendiente por subir
    
    public function GuardarTrasladoMercancia($idComprobante) {
        $Costo=0;
        $consulta=$this->ConsultarTabla("traslados_items", " WHERE idTraslado='$idComprobante'");
        $VectorCosto["F"]=0;
        while($DatosItems=  $this->FetchArray($consulta)){
            $fecha=$DatosItems["Fecha"];
            $Costo=$Costo+($DatosItems["CostoUnitario"]*$DatosItems["Cantidad"]);
            $DatosProducto=$this->DevuelveValores("productosventa", "Referencia", $DatosItems["Referencia"]);
            $DatosKardex["Cantidad"]=$DatosItems['Cantidad'];
            $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
            $DatosKardex["CostoUnitario"]=$DatosProducto['CostoUnitario'];
            $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
            $DatosKardex["Detalle"]="Traslado";
            $DatosKardex["idDocumento"]=$idComprobante;
            $DatosKardex["TotalCosto"]=$DatosItems['Cantidad']*$DatosProducto['CostoUnitario'];
            $DatosKardex["Movimiento"]="SALIDA";
            $this->InserteKardex($DatosKardex);
        }
        
        $this->RegistreCostoLibroDiario("NO", $Costo,$fecha,$idComprobante,1,$VectorCosto);
        $this->update("traslados_mercancia", "Estado", "PREPARADO", "WHERE ID='$idComprobante'");
        $this->update("traslados_items", "Estado", "PREPARADO", "WHERE idTraslado='$idComprobante'");
    }
    
    //funcion para avanzar un traslado a pendiente por subir
    
    public function GuardarTrasladoDescargado($idTraslado,$VectorTraslado) {
        $Costo=0;
        $consulta=$this->ConsultarTabla("traslados_items", " WHERE idTraslado='$idTraslado'");
        if($this->NumRows($consulta)){
        while($DatosItems=  $this->FetchArray($consulta)){
            $fecha=$DatosItems["Fecha"];
            $Costo=$Costo+($DatosItems["CostoUnitario"]*$DatosItems["Cantidad"]);
            $DatosProducto=$this->DevuelveValores("productosventa", "Referencia", $DatosItems["Referencia"]);
            if(empty($DatosProducto["Referencia"])){
                $VectorPTI["FUT"]="";
                $idProducto=$this->CrearProductoFromItemTraslado($DatosItems["ID"],$VectorPTI);
            }else{
            
                $DatosKardex["Cantidad"]=$DatosItems['Cantidad'];
                $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
                $DatosKardex["CostoUnitario"]=$DatosProducto['CostoUnitario'];
                $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
                $DatosKardex["Detalle"]="Traslado";
                $DatosKardex["idDocumento"]=$idTraslado;
                $DatosKardex["TotalCosto"]=$DatosItems['Cantidad']*$DatosProducto['CostoUnitario'];
                $DatosKardex["Movimiento"]="ENTRADA";
                $this->InserteKardex($DatosKardex);                
                $idProducto=$DatosProducto["idProductosVenta"];
            }
            $VectorCb["F"]="";
            $this->AgregueCodBarras($idProducto,$DatosItems['CodigoBarras'],$VectorCb);
            
        }
        $VectorCosto["Fut"]="";
        $this->RegistreCostoLibroDiario("SI", $Costo,$fecha,$idTraslado,1,$VectorCosto);
        $this->update("traslados_mercancia", "Estado", "VERIFICADO", "WHERE ID='$idTraslado'");
        $this->update("traslados_items", "Estado", "VERIFICADO", "WHERE idTraslado='$idTraslado'");
        }
    }
    
    //funcion para crear un producto desde un item de un traslado
    
    public function CrearProductoFromItemTraslado($idTrasladoItem,$VectorPTI) {
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
        $Regimen=$DatosEmpresa["Regimen"];
        $DatosItem =  $this->DevuelveValores("traslados_items", "ID", $idTrasladoItem);
        $id = $this->ObtenerMAX("productosventa", "idProductosVenta", 1, "");
        $id++;
        $IVA=$DatosItem["IVA"];
        if($Regimen=="SIMPLIFICADO"){
            $IVA=0;
        }
        $tab="productosventa";
		
        $NumRegistros=18;
        
        $Columnas[0]="idProductosVenta";$Valores[0]=$id;
        $Columnas[1]="CodigoBarras";	$Valores[1]=$id;
        $Columnas[2]="Referencia";	$Valores[2]=$DatosItem["Referencia"];
        $Columnas[3]="Nombre";          $Valores[3]=$DatosItem["Nombre"];
        $Columnas[4]="Existencias";	$Valores[4]=$DatosItem["Cantidad"];
        $Columnas[5]="PrecioVenta";	$Valores[5]=$DatosItem["PrecioVenta"];
        $Columnas[6]="PrecioMayorista";	$Valores[6]=$DatosItem["PrecioMayorista"];
        $Columnas[7]="CostoUnitario";   $Valores[7]=$DatosItem["CostoUnitario"];
        $Columnas[8]="CostoTotal";	$Valores[8]=$DatosItem["CostoUnitario"]*$DatosItem["Cantidad"];
        $Columnas[9]="IVA";             $Valores[9]=$IVA;
        $Columnas[10]="Bodega_idBodega";$Valores[10]=1;
        $Columnas[11]="Departamento";	$Valores[11]=$DatosItem["Departamento"];
        $Columnas[12]="Sub1";           $Valores[12]=$DatosItem["Sub1"];
        $Columnas[13]="Sub2";           $Valores[13]=$DatosItem["Sub2"];
        $Columnas[14]="Sub3";           $Valores[14]=$DatosItem["Sub3"];
        $Columnas[15]="Sub4";		$Valores[15]=$DatosItem["Sub4"];
        $Columnas[16]="Sub5";		$Valores[16]=$DatosItem["Sub5"];
        $Columnas[17]="CuentaPUC";	$Valores[17]=$DatosItem["CuentaPUC"];	
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        return $id;
    }
    //funcion para agregar un codigo de barras a un producto
    
    public function AgregueCodBarras($idProducto,$CB,$VectorCB) {
        
        $consulta=$this->ConsultarTabla("prod_codbarras", "WHERE ProductosVenta_idProductosVenta='$idProducto' AND CodigoBarras='$CB'");
        if($this->NumRows($consulta)){
            return;
        }else{
            $tab="prod_codbarras";
		
            $NumRegistros=2;

            $Columnas[0]="ProductosVenta_idProductosVenta"; $Valores[0]=$idProducto;
            $Columnas[1]="CodigoBarras";                    $Valores[1]=$CB;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }
        
        
    }
    
    public function RegistreCostoLibroDiario($Entrada, $Costo,$fecha,$idTraslado,$CentroCosto,$VectorCosto){
        
        $DatosCentro=  $this->DevuelveValores("centrocosto", "ID", $CentroCosto);
        $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
        if($Entrada=="SI"){
            $Creditos=0;
            $Debitos=$Costo;
            $Neto=$Debitos;
        }else{
            $Creditos=$Costo;
            $Debitos=0;  
            $Neto=$Creditos*(-1);
        }
        
        $tab="librodiario";
        $NumRegistros=27;
        $CuentaPUC=1435;
        
        $DatosCuenta=  $this->DevuelveValores("subcuentas","PUC" , $CuentaPUC);
       
        $NombreCuenta=$DatosCuenta["Nombre"];
        $CuentaPUCContraPartida=6135;
        $DatosCuenta=  $this->DevuelveValores("subcuentas","PUC" , $CuentaPUCContraPartida);
        $NombreCuentaContraPartida=$DatosCuenta["Nombre"];



        $Columnas[0]="Fecha";			$Valores[0]=$fecha;
        $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="Traslado";
        $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idTraslado;
        $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]="";
        $Columnas[4]="Tercero_Identificacion";	$Valores[4]="";
        $Columnas[5]="Tercero_DV";		$Valores[5]="";
        $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]="";
        $Columnas[7]="Tercero_Segundo_Apellido";$Valores[7]="";
        $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]="";
        $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]="";
        $Columnas[10]="Tercero_Razon_Social";	$Valores[10]="PROPIO";
        $Columnas[11]="Tercero_Direccion";		$Valores[11]="PROPIO";
        $Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]="";
        $Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]="";
        $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]="";
        $Columnas[15]="CuentaPUC";			$Valores[15]=$CuentaPUC;
        $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
        $Columnas[17]="Detalle";			$Valores[17]="Traslado de Mercancia";
        $Columnas[18]="Debito";			$Valores[18]=$Debitos;
        $Columnas[19]="Credito";		$Valores[19]=$Creditos;
        $Columnas[20]="Neto";			$Valores[20]=$Neto;
        $Columnas[21]="Mayor";			$Valores[21]="NO";
        $Columnas[22]="Esp";			$Valores[22]="NO";
        $Columnas[23]="Concepto";			$Valores[23]="Traslados";
        $Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCosto;
        $Columnas[25]="idEmpresa";			$Valores[25]=$DatosCentro["EmpresaPro"];
        $Columnas[26]="idSucursal";			$Valores[26]=$DatosSucursal["ID"];
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


        ///////////////////////Registramos contra partida del anticipo
        $aux1=0;
        $aux2=0;
        $aux1=$Debitos;
        $aux2=$Creditos;
        $Neto=$Neto*(-1);
        $Debitos=$aux2;
        $Creditos=$aux1;
        $CuentaPUC=$CuentaPUCContraPartida; 
        $NombreCuenta=$NombreCuentaContraPartida;

        $Valores[15]=$CuentaPUC;
        $Valores[16]=$NombreCuenta;
        $Valores[18]=$Debitos;
        $Valores[19]=$Creditos; 			//Credito se escribe el total de la venta menos los impuestos
        $Valores[20]=$Neto;  											//Credito se escribe el total de la venta menos los impuestos

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
    }
    
    //Esta clase permite agregar items desde un archivo csv cargado
    public function AgregarItemXCB($CodigoBarras, $Cantidad, $VectorItem) {
        $DatosCodigo=  $this->DevuelveValores("prod_codbarras", "CodigoBarras", $CodigoBarras);
        $DatosProducto=$this->DevuelveValores("productosventa", "idProductosVenta", $DatosCodigo["ProductosVenta_idProductosVenta"]);
        if(empty($DatosProducto["idProductosVenta"])){
            return ("SR");
        }
        $DatosKardex["Cantidad"]=$Cantidad;
        $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
        $DatosKardex["CostoUnitario"]=$DatosProducto['CostoUnitario'];
        $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
        $DatosKardex["Detalle"]="CargaCSV";
        $DatosKardex["idDocumento"]="NA";
        $DatosKardex["TotalCosto"]=$Cantidad*$DatosProducto['CostoUnitario'];
        $DatosKardex["Movimiento"]="ENTRADA";
        $this->InserteKardex($DatosKardex);
        return($DatosProducto);
    }
    
    
    ////////////////////////////////////////////////////////////////////
//////////////////////Funcion agregar precotizacion
///////////////////////////////////////////////////////////////////


public function AgregaPrecotizacion($Cantidad,$idProducto,$TablaItem,$VectorPrecoti){
    
	$DatosProductoGeneral=$this->DevuelveValores($TablaItem, "idProductosVenta", $idProducto);
        $DatosDepartamento=$this->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosProductoGeneral["Departamento"]);
        $DatosTablaItem=$this->DevuelveValores("tablas_ventas", "NombreTabla", $TablaItem);
        $TipoItem=$DatosDepartamento["TipoItem"];
        $reg=mysql_query("select * from fechas_descuentos where (Departamento = '$DatosProductoGeneral[Departamento]' OR Departamento ='0') AND (Sub1 = '$DatosProductoGeneral[Sub1]' OR Sub1 ='0')  ORDER BY idFechaDescuentos DESC LIMIT 1 ") or die('no se pudo consultar los valores de fechas descuentos en AgregaPreventa: ' . mysql_error());
        //$reg=$this->Query($sql);
        $reg=$this->FetchArray($reg);
        $Porcentaje=$reg["Porcentaje"];
        $Departamento=$reg["Departamento"];
        $FechaDescuento=$reg["Fecha"];

        $impuesto=$DatosProductoGeneral["IVA"];
        $impuesto=$impuesto+1;
        if($DatosTablaItem["IVAIncluido"]=="SI"){
            $ValorUnitario=$DatosProductoGeneral["PrecioVenta"]/$impuesto;

        }else{
            $ValorUnitario=$DatosProductoGeneral["PrecioVenta"];

        }
        if($Porcentaje>0 and $FechaDescuento==$fecha){

                $Porcentaje=(100-$Porcentaje)/100;
                $ValorUnitario=$ValorUnitario*$Porcentaje;

        }

        $Subtotal=$ValorUnitario*$Cantidad;
        $IVA=($impuesto-1)*$Subtotal;
        $Total=$Subtotal+$IVA;

        
        $tab="precotizacion";
        $NumRegistros=13;  


        $Columnas[0]="Cantidad";						$Valores[0]=$Cantidad;
        $Columnas[1]="Referencia";						$Valores[1]=$DatosProductoGeneral["Referencia"];
        $Columnas[2]="ValorUnitario";					$Valores[2]=$ValorUnitario;
        $Columnas[3]="SubTotal";						$Valores[3]=$Subtotal;
        $Columnas[4]="Descripcion";						$Valores[4]=$DatosProductoGeneral["Nombre"];
        $Columnas[5]="IVA";								$Valores[5]=$IVA;
        $Columnas[6]="PrecioCosto";						$Valores[6]=$DatosProductoGeneral["CostoUnitario"];
        $Columnas[7]="SubtotalCosto";					$Valores[7]=$DatosProductoGeneral["CostoUnitario"]*$Cantidad;
        $Columnas[8]="Total";							$Valores[8]=$Total;
        $Columnas[9]="TipoItem";						$Valores[9]=$DatosDepartamento["TipoItem"];
        $Columnas[10]="idUsuario";						$Valores[10]=$this->idUser;
        $Columnas[11]="CuentaPUC";						$Valores[11]=$DatosProductoGeneral["CuentaPUC"];
        $Columnas[12]="Tabla";			    			$Valores[12]=$TablaItem;

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
               
	
        }
		
        
        //funcion para crear un servicio
    
    public function CrearItemServicio($Tabla,$Nombre,$PrecioVenta,$CostoUnitario,$CostoUnitario,$CuentaPUC,$IVA,$Departamento,$VectorItem) {
        
        
        $id = $this->ObtenerMAX($Tabla, "idProductosVenta", 1, "");
        $id++;
        $tab=$Tabla;
		
        $NumRegistros=15;
        
        $Columnas[0]="idProductosVenta";$Valores[0]=$id;
        $Columnas[1]="Referencia";	$Valores[1]="REFSER".$id;
        $Columnas[2]="Nombre";          $Valores[2]=$Nombre;
        $Columnas[3]="PrecioVenta";     $Valores[3]=$PrecioVenta;
        $Columnas[4]="PrecioMayorista";	$Valores[4]=$PrecioVenta;
        $Columnas[5]="CostoUnitario";	$Valores[5]=$CostoUnitario;
        $Columnas[6]="IVA";             $Valores[6]=$IVA;
        $Columnas[7]="Departamento";    $Valores[7]=$Departamento;
        $Columnas[8]="ImagenRuta";	$Valores[8]="";
        $Columnas[9]="CuentaPUC";       $Valores[9]=$CuentaPUC;
        $Columnas[10]="Sub1";           $Valores[10]="";
        $Columnas[11]="Sub2";           $Valores[11]="";
        $Columnas[12]="Sub3";           $Valores[12]="";
        $Columnas[13]="Sub4";           $Valores[13]="";
        $Columnas[14]="Sub5";           $Valores[14]="";
        
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        return $id;
    }
    /*
     * Esta clase agrega items desde una cotizacion a una prefactura
     */
    public function AgregarCotizacionPrefactura($idCotizacion) {
        $Datos=  $this->ConsultarTabla("cot_itemscotizaciones", " WHERE NumCotizacion='$idCotizacion'");
        while($DatosCotizacion=  $this->FetchArray($Datos)){
            $DatosProducto=$this->DevuelveValores($DatosCotizacion["TablaOrigen"], "Referencia", $DatosCotizacion["Referencia"]);
            
            $tab="facturas_pre";
            $NumRegistros=26;
            $Columnas[0]="ID";			$Valores[0]="";
            $Columnas[1]="idFactura";           $Valores[1]=$NumFactura;
            $Columnas[2]="TablaItems";          $Valores[2]=$DatosCotizacion["TablaOrigen"];
            $Columnas[3]="Referencia";          $Valores[3]=$DatosCotizacion["Referencia"];
            $Columnas[4]="Nombre";              $Valores[4]=$DatosCotizacion["Descripcion"];
            $Columnas[5]="Departamento";	$Valores[5]=$DatosProducto["Departamento"];
            $Columnas[6]="SubGrupo1";           $Valores[6]=$DatosProducto['Sub1'];
            $Columnas[7]="SubGrupo2";           $Valores[7]=$DatosProducto['Sub2'];
            $Columnas[8]="SubGrupo3";           $Valores[8]=$DatosProducto['Sub3'];
            $Columnas[9]="SubGrupo4";           $Valores[9]=$DatosProducto['Sub4'];
            $Columnas[10]="SubGrupo5";          $Valores[10]=$DatosProducto['Sub5'];
            $Columnas[11]="ValorUnitarioItem";	$Valores[11]=$DatosCotizacion['ValorUnitario'];
            $Columnas[12]="Cantidad";		$Valores[12]=$DatosCotizacion['Cantidad'];
            $Columnas[13]="Dias";		$Valores[13]=1;
            $Columnas[14]="SubtotalItem";       $Valores[14]=$DatosCotizacion['Subtotal'];
            $Columnas[15]="IVAItem";		$Valores[15]=$DatosCotizacion['IVA'];
            $Columnas[16]="TotalItem";		$Valores[16]=$DatosCotizacion['Total'];
            $Columnas[17]="PorcentajeIVA";	$Valores[17]=($DatosProducto['IVA']*100)."%";
            $Columnas[18]="PrecioCostoUnitario";$Valores[18]=$DatosProducto['CostoUnitario'];
            $Columnas[19]="SubtotalCosto";	$Valores[19]=$DatosProducto['CostoUnitario']*$DatosCotizacion['Cantidad'];
            $Columnas[20]="TipoItem";		$Valores[20]=$DatosCotizacion['TipoItem'];
            $Columnas[21]="CuentaPUC";		$Valores[21]=$DatosProducto['CuentaPUC'];
            $Columnas[22]="GeneradoDesde";	$Valores[22]="cotizacionesv5";
            $Columnas[23]="NumeroIdentificador";$Valores[23]=$idCotizacion;
            $Columnas[24]="FechaFactura";       $Valores[24]="";
            $Columnas[25]="idUsuarios";         $Valores[25]= $this->idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }
    }
    
    
    /*
     * Esta clase agrega items desde una cotizacion a una prefactura
     */
    
    public function CrearFacturaDesdePrefactura($DatosFactura) {
        
        $idCliente=$DatosFactura['CmbCliente'];
        
        $CentroCostos=$DatosFactura["CmbCentroCostos"];
        $ResolucionDian=$DatosFactura["CmbResolucion"];
        $TipoPago=$DatosFactura["CmbFormaPago"];
        $CuentaDestino=$DatosFactura["CmbCuentaDestino"];
        $OrdenCompra=$DatosFactura["TxtOrdenCompra"];
        $OrdenSalida=$DatosFactura["TxtOrdenSalida"];
        $ObservacionesFactura=$DatosFactura["TxtObservacionesFactura"];
        $FechaFactura=$DatosFactura["TxtFechaFactura"];
        $NumeroForzado=$DatosFactura["TxtNumeroFactura"];
        $Consulta=$this->DevuelveValores("centrocosto", "ID", $CentroCostos);
        
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
        $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
        if($DatosResolucion["Completada"]=="NO"){           ///Pregunto si la resolucion ya fue completada
            $Disponibilidad=$DatosResolucion["Estado"];
                                              //si entra a verificar es porque estaba ocupada y cambiará a 1
            while($Disponibilidad=="OC"){                   //miro que esté disponible para facturar, esto para no crear facturas dobles
                print("Esperando disponibilidad<br>");
                usleep(300);
                $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
                $Disponibilidad=$DatosResolucion["Estado"];
                
            }
            
            $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
            if($DatosResolucion["Completada"]<>"SI"){
                $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "OC", "ID", $ResolucionDian); //Ocupo la resolucion
                
                $sql="SELECT MAX(NumeroFactura) as FacturaActual FROM facturas WHERE Prefijo='$DatosResolucion[Prefijo]' "
                        . "AND TipoFactura='$DatosResolucion[Tipo]' AND idResolucion='$ResolucionDian'";
                $Consulta=$this->Query($sql);
                $Consulta=$this->FetchArray($Consulta);
                $FacturaActual=$Consulta["FacturaActual"];
                $idFactura=$FacturaActual+1;
                if($NumeroForzado>0){
                    $sql="SELECT NumeroFactura FROM facturas WHERE Prefijo='$DatosResolucion[Prefijo]' "
                        . "AND TipoFactura='$DatosResolucion[Tipo]' AND idResolucion='$ResolucionDian'";
                    $Consulta=$this->Query($sql);
                    $Consulta=$this->FetchArray($Consulta);
                    $Existe=$Consulta["NumeroFactura"];
                    if($Existe==$NumeroForzado){
                        //libero la resolucion
                        $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "", "ID", $ResolucionDian);
                        exit("<a href='FacturaCotizacion.php'>La factura $NumeroForzado ya existe, no se puede crear, Volver</a>");
                    }else{
                        $idFactura=$NumeroForzado;
                    }
                }
                //Verificamos si ya se completó el numero de la resolucion y si es así se cambia su estado
                if($DatosResolucion["Hasta"]==$idFactura){ 
                    $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Completada", "SI", "ID", $ResolucionDian);
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
                $Columnas[14]="Usuarios_idUsuarios";        $Valores[14]=$this->idUser;
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
                
                $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                
                //libero la resolucion
                $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "", "ID", $ResolucionDian);
                
                //////////////////////Agrego Items a la Factura desde la devolucion
                /////
                /////
                
                $Datos["NumFactura"]=$idFactura;
                $Datos["FechaFactura"]=$FechaFactura;
                $Datos["ID"]=$ID;
                $Datos["CuentaDestino"]=$CuentaDestino;
                $Datos["EmpresaPro"]=$EmpresaPro;
                $Datos["CentroCostos"]=$CentroCostos;
                $this->InsertarItemsCotizacionAItemsFactura($Datos);///Relaciono los items de la factura
                
                $this->InsertarFacturaLibroDiario($Datos);///Inserto Items en el libro diario
               
                if($TipoPago<>"Contado"){                   //Si es a Credito
                    $Datos["Fecha"]=$FechaFactura; 
                    $Datos["Dias"]=$SumaDias;
                    $FechaVencimiento=$this->SumeDiasFecha($Datos);
                    $Datos["idFactura"]=$Datos["ID"]; 
                    $Datos["FechaFactura"]=$FechaFactura; 
                    $Datos["FechaVencimiento"]=$FechaVencimiento;
                    $Datos["idCliente"]=$idCliente;
                    $this->InsertarFacturaEnCartera($Datos);///Inserto La factura en la cartera
                }
                 return ($ID);
            }    
           
        }
        
       
    }
    
   //Verifica los permisos de los usuarios
    
public function VerificaPermisos($VectorPermisos) {
    if($this->TipoUser<>"administrador"){
        $Page=$VectorPermisos["Page"];
        
        $Consulta=  $this->ConsultarTabla("paginas_bloques", " WHERE Pagina='$Page' AND TipoUsuario='$this->TipoUser' AND Habilitado='SI'");
        $PaginasUser=  $this->FetchArray($Consulta);
        if($PaginasUser["Pagina"]==$Page){
            return true;
        }
        return false;
    }
    return true;
}


//Funcion para Crear los backups
     public function CrearBackup($idServer,$VectorBackup){
        $host=$VectorBackup["LocalHost"];
        $user=$VectorBackup["User"];
        $pw=$VectorBackup["PW"];
        $db=$VectorBackup["DB"];
        $Tabla=$VectorBackup["Tabla"];
        $AutoIncrement=$VectorBackup["AutoIncrement"];
        $sqlCrearTabla="";
        $sql="";
                        
        $VectorAS["f"]=0;
        $DatosServer=$this->DevuelveValores("servidores", "ID", $idServer); 
        $FechaSinc=date("Y-m-d H:i:s");
        //$Condicion=" WHERE ServerSincronizado='0000-00-00 00:00:00'";
        
        $CondicionUpdate=" WHERE Sync = '0000-00-00 00:00:00' OR Sync<>Updated";
        //$CondicionUpdate="";
        if($AutoIncrement<>0){
            $VectorAS["AI"]=$AutoIncrement; //Indicamos que la tabla tiene id con autoincrement
        }
        $sql=$this->ArmeSqlReplace($Tabla, $db, $CondicionUpdate,$DatosServer["DataBase"],$FechaSinc, $VectorAS);
        $Existe=  $this->DevuelveValores("plataforma_tablas", "Nombre", $Tabla);
        if(empty($Existe["Nombre"])){
            $sqlCrearTabla=$this->ArmeSQLCopiarTabla($Tabla, $db, $DatosServer["DataBase"], $VectorAS);
                    
        }
        $VectorCon["Fut"]=0;               
        
        if(empty($sql) AND !empty($Existe["Nombre"])){
            return("SA");
        }
        
        
        
        $this->ConToServer($DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], $VectorCon);
        
        if(!empty($sqlCrearTabla)){
            $this->Query($sqlCrearTabla);
        }
        if(!empty($sql)){
            $this->Query($sql);
        }
        $this->ConToServer($host, $user, $pw, $db, $VectorCon); 
        $sqlUp="UPDATE $Tabla SET Sync='$FechaSinc', Updated='$FechaSinc' $CondicionUpdate";
        $this->Query($sqlUp);
        if(empty($Existe["Nombre"])){
            $sqlInsertTabla="INSERT INTO plataforma_tablas (Nombre) VALUES ('$Tabla')";
            $this->Query($sqlInsertTabla);
        }
        return("Backup Realizado a la tabla $Tabla");
        //return("<pre>$sql</pre>");
         
     }
     /*
      * Muestra todas las tablas de una base de datos
      */
     public function MostrarTablas($DataBase,$Vector){
         $sql="SHOW FULL TABLES FROM $DataBase";
         $Datos=$this->Query($sql);
         //$Tablas=$this->FetchArray($Datos);
         return ($Datos);
     }
     
     /*
      * Agregar una Columna a una tabla
      */
     public function AgregarColumnaTabla($Tabla,$NombreCol,$Tipo,$Predeterminado,$Atributos,$Vector){
         $sql="ALTER TABLE `$Tabla` ADD `$NombreCol` $Tipo $Atributos NOT NULL $Predeterminado";
         $this->Query($sql);
        
     }
     
     /*
      * Agregar una Columna a una tabla
      */
     public function CreeColumnasBackup($Tabla,$DataBase,$Vector){
         
        $ColumnaCol=$this->MostrarColumnas($Tabla, $DataBase);
        foreach($ColumnaCol as $NombreCol){
            if($NombreCol<>'Updated'){
                $Vector["F"]="";
                $this->AgregarColumnaTabla($Tabla, 'Updated', 'TIMESTAMP', 'CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP', $Vector);
            }
        }
     }
     
     /*
      * Crear una Tabla de una sucursal 
      */
     public function CrearTablaBodegaSucursal($idBodega,$Vector){
        $NombreTabla="productosventa_bodega_$idBodega";
        $NombreTablaKardex="prod_codbarras_bodega_$idBodega";
        $sql="CREATE TABLE IF NOT EXISTS `$NombreTabla` (
            `idProductosVenta` bigint(20) NOT NULL AUTO_INCREMENT,
            `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
            `Referencia` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
            `Nombre` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
            `Existencias` double DEFAULT '0',
            `PrecioVenta` double DEFAULT NULL,
            `PrecioMayorista` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
            `CostoUnitario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
            `CostoTotal` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
            `IVA` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT '0',
            `Bodega_idBodega` int(11) NOT NULL DEFAULT '1',
            `Departamento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
            `Sub1` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
            `Sub2` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
            `Sub3` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
            `Sub4` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
            `Sub5` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
            `Kit` int(11) NOT NULL,
            `RutaImagen` text COLLATE utf8_spanish_ci NOT NULL,
            `Especial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
            `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT '4135',
            `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            PRIMARY KEY (`idProductosVenta`),
            UNIQUE KEY `Referencia` (`Referencia`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1;";
        $this->Query($sql);
        $sql="CREATE TABLE IF NOT EXISTS `$NombreTablaKardex` (
            `idCodBarras` bigint(20) NOT NULL AUTO_INCREMENT,
            `ProductosVenta_idProductosVenta` bigint(20) NOT NULL,
            `CodigoBarras` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
            `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            PRIMARY KEY (`idCodBarras`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;";
        $this->Query($sql);
     }
     /*
      * Descarga una tabla desde un servidor y la guarda 
      */
     public function DescargarDesdeServidor($TablaDestino,$idServidor ,$VectorBackup) {
         $host=$VectorBackup["LocalHost"];
        $user=$VectorBackup["User"];
        $pw=$VectorBackup["PW"];
        $db=$VectorBackup["DB"];
        $Tabla=$VectorBackup["Tabla"];
        $AutoIncrement=$VectorBackup["AutoIncrement"];
        $Condicion="";
        $VectorCon["F"]=0;
         $DatosServer=$this->DevuelveValores("servidores", "ID", $idServidor);
         $this->ConToServer($DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], $VectorCon);
         $VectorAS["TablaDestino"]=$TablaDestino;
         $sql=  $this->ArmeSqlReplace($Tabla, $DatosServer["DataBase"], $Condicion, $db, "", $VectorAS);
         $this->ConToServer($host, $user, $pw, $db, $VectorCon);
         
         $this->Query($sql);
         //return($sql);
         
     }
     
     /*
      * Muestra la estructura de una tabla
      */
     public function MuestraEstructura($Tabla,$DataBase,$Vector){
         
         $sql="SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$DataBase' AND TABLE_NAME = '$Tabla' ";
         $Datos=$this->Query($sql);
         //$Tablas=$this->FetchArray($Datos);
         return ($Datos);
     }
     
     /*
      * Muestra la estructura de una tabla
      */
     public function DarDeBajaAltaProducto($TipoMovimiento,$fecha, $Observaciones,$RefProducto,$Cantidad,$VectorBA){
         $DatosProducto=$this->DevuelveValores("productosventa", "Referencia", $RefProducto);
         $DatosSucursal=$this->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
         $CostoTotal=$DatosProducto["CostoUnitario"]*$Cantidad;
         $tab="prod_bajas_altas";
        $NumRegistros=9; 

        $Columnas[0]="Fecha";		    $Valores[0]=$fecha;
        $Columnas[1]="Departamento";        $Valores[1]=$DatosProducto["Departamento"];
        $Columnas[2]="Referencia";          $Valores[2]=$DatosProducto["Referencia"];
        $Columnas[3]="Nombre";              $Valores[3]=$DatosProducto["Nombre"];
        $Columnas[4]="Cantidad";            $Valores[4]=$Cantidad;
        $Columnas[5]="CostoTotal";          $Valores[5]=$CostoTotal;
        $Columnas[6]="Observaciones";       $Valores[6]=$Observaciones;
        $Columnas[7]="Usuarios_idUsuarios"; $Valores[7]=$this->idUser;
        $Columnas[8]="Movimiento";          $Valores[8]=$TipoMovimiento;
        
        if($TipoMovimiento=="BAJA"){
            $MovientoKardex="SALIDA";
        }else{
            $MovientoKardex="ENTRADA";
        }
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $idBaja=$this->ObtenerMAX("prod_bajas_altas", "ID", 1, "");
        
        $DatosKardex["Cantidad"]=$Cantidad;
        $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
        $DatosKardex["CostoUnitario"]=$DatosProducto['CostoUnitario'];
        $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
        $DatosKardex["Detalle"]=$TipoMovimiento;
        $DatosKardex["idDocumento"]=$idBaja;
        $DatosKardex["TotalCosto"]=$CostoTotal;
        $DatosKardex["Movimiento"]=$MovientoKardex;
        $this->InserteKardex($DatosKardex);
        
        ///////////////////////Ajustamos el inventario
        
        if($TipoMovimiento=="BAJA"){
            $DatosParametros=  $this->DevuelveValores("parametros_contables", "ID", 3);//Espacio donde se encuentra alojada la cuenta para gasto por perdidas o bjas
            $CuentaPUC=$DatosParametros["CuentaPUC"]; 
            if(strlen($CuentaPUC)>4){
                $TablaPUC="subcuentas";
                $idPUC="PUC";
            }else{
                $TablaPUC="cuentas";
                $idPUC="idPUC";
            }
            $CuentaPUCMov1=$CuentaPUC;
            $DatosCuenta=$this->DevuelveValores($TablaPUC,$idPUC,$CuentaPUC);
            $NombreCuentaMov1=$DatosCuenta["Nombre"];
            $DebitoMov1=$CostoTotal;
            $CreditoMov1=0;
            $NetoMov1=$CostoTotal;
            $DatosParametros=  $this->DevuelveValores("parametros_contables", "ID", 4);//Espacio donde se encuentra alojada la cuenta para inventarios mercancias no fabricadas
            $CuentaPUC=$DatosParametros["CuentaPUC"]; 

            if(strlen($CuentaPUC)>4){
                    $TablaPUC="subcuentas";
                    $idPUC="PUC";
            }else{
                $TablaPUC="cuentas";
                $idPUC="idPUC";
            }
            $CuentaPUCMov2=$CuentaPUC;
            $DatosCuenta=$this->DevuelveValores($TablaPUC,$idPUC,$CuentaPUC);
            $NombreCuentaMov2=$DatosCuenta["Nombre"];
            $DebitoMov2=0;
            $CreditoMov2=$CostoTotal;
            $NetoMov2=$CostoTotal*(-1);
            $TipoComprobante="COMPROBANTE DE BAJA";
            $Detalle="Baja Mercancias no Fabricadas por la Empresa";
        }else{
            $DatosParametros=  $this->DevuelveValores("parametros_contables", "ID", 5);//Espacio donde se encuentra alojada la cuenta para gasto por perdidas o bjas
            $CuentaPUC=$DatosParametros["CuentaPUC"]; 
            if(strlen($CuentaPUC)>4){
                $TablaPUC="subcuentas";
                $idPUC="PUC";
            }else{
                $TablaPUC="cuentas";
                $idPUC="idPUC";
            }
            $CuentaPUCMov1=$CuentaPUC;
            $DatosCuenta=$this->DevuelveValores($TablaPUC,$idPUC,$CuentaPUC);
            $NombreCuentaMov1=$DatosCuenta["Nombre"];
            $DebitoMov1=0;
            $CreditoMov1=$CostoTotal;
            $NetoMov1=$CostoTotal*(-1);
            $DatosParametros=  $this->DevuelveValores("parametros_contables", "ID", 4);//Espacio donde se encuentra alojada la cuenta para inventarios mercancias no fabricadas
            $CuentaPUC=$DatosParametros["CuentaPUC"]; 

            if(strlen($CuentaPUC)>4){
                    $TablaPUC="subcuentas";
                    $idPUC="PUC";
            }else{
                $TablaPUC="cuentas";
                $idPUC="idPUC";
            }
            $CuentaPUCMov2=$CuentaPUC;
            $DatosCuenta=$this->DevuelveValores($TablaPUC,$idPUC,$CuentaPUC);
            $NombreCuentaMov2=$DatosCuenta["Nombre"];
            $DebitoMov2=$CostoTotal;
            $CreditoMov2=0;
            $NetoMov2=$CostoTotal;
            $TipoComprobante="COMPROBANTE DE ALTA";
            $Detalle="Alta Mercancias no Fabricadas por la Empresa";
        }
        
                        
    $tab="librodiario";
    $NumRegistros=27;
    $Columnas[0]="Fecha";			$Valores[0]=$fecha;
    $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]=$TipoComprobante;
    $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idBaja;
    $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]="PROPIO";
    $Columnas[4]="Tercero_Identificacion";	$Valores[4]="";
    $Columnas[5]="Tercero_DV";                  $Valores[5]="0";
    $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]="";
    $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]="";
    $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]="";
    $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]="";
    $Columnas[10]="Tercero_Razon_Social";	$Valores[10]="PROPIO";
    $Columnas[11]="Tercero_Direccion";          $Valores[11]="";
    $Columnas[12]="Tercero_Cod_Dpto";           $Valores[12]="";
    $Columnas[13]="Tercero_Cod_Mcipio";         $Valores[13]="";
    $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]="";

    $Columnas[15]="CuentaPUC";                  $Valores[15]=$CuentaPUCMov1;
    $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuentaMov1;
    $Columnas[17]="Detalle";                    $Valores[17]=$Detalle;
    $Columnas[18]="Debito";			$Valores[18]=$DebitoMov1;
    $Columnas[19]="Credito";                    $Valores[19]=$CreditoMov1;
    $Columnas[20]="Neto";			$Valores[20]=$NetoMov1;
    $Columnas[21]="Mayor";			$Valores[21]="NO";
    $Columnas[22]="Esp";			$Valores[22]="NO";
    $Columnas[23]="Concepto";                   $Valores[23]=$Observaciones;
    $Columnas[24]="idCentroCosto";              $Valores[24]=1;
    $Columnas[25]="idEmpresa";                  $Valores[25]=$DatosSucursal["idEmpresaPro"];
    $Columnas[26]="idSucursal";                 $Valores[26]=$DatosSucursal["ID"];
                
    $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);	
        

    $Valores[15]=$CuentaPUCMov2;
    $Valores[16]=$NombreCuentaMov2;
    $Valores[18]=$DebitoMov2;//Debito se escribe el costo de la mercancia vendida
    $Valores[19]=$CreditoMov2; 			
    $Valores[20]=$NetoMov2;  	//para la sumatoria contemplar el balance

    $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
          
        return ($idBaja);
     }
     
     //Funcion para Agregar una actividad a una OT
     
     public function AgregaActividadOT($idOT,$idMaquina,$FechaInicioPlaneado,$HoraInicioPlaneado,$FechaFinPlaneado,$HoraFinPlaneado,$Descripcion,$Observaciones,$VectorAOT) {
        $tab="produccion_actividades";
        $NumRegistros=14;
        $Columnas[0]="idOrdenTrabajo";		$Valores[0]=$idOT;
        $Columnas[1]="Fecha_Planeada_Inicio";	$Valores[1]=$FechaInicioPlaneado;
        $Columnas[2]="Fecha_Planeada_Fin";	$Valores[2]=$FechaFinPlaneado;
        $Columnas[3]="Hora_Planeada_Inicio";	$Valores[3]=$HoraInicioPlaneado;
        $Columnas[4]="Hora_Planeada_Fin";	$Valores[4]=$HoraFinPlaneado;
        $Columnas[5]="Fecha_Inicio";            $Valores[5]=$FechaInicioPlaneado;
        $Columnas[6]="Fecha_Fin";               $Valores[6]=$FechaFinPlaneado;
        $Columnas[7]="Hora_Inicio";             $Valores[7]=$HoraInicioPlaneado;
        $Columnas[8]="Hora_Fin";                $Valores[8]=$HoraFinPlaneado;
        $Columnas[9]="Descripcion";             $Valores[9]=$Descripcion;
        $Columnas[10]="Observaciones";          $Valores[10]=$Observaciones;
        $Columnas[11]="idMaquina";              $Valores[11]=$idMaquina;
        $Columnas[12]="Estado";                 $Valores[12]="NO_INICIADA";
        $Columnas[13]="idUsuario";              $Valores[13]=$this->idUser;
       
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
     }
     
     //Agrega una venta a un colaborador
     
     
     public function AgregueVentaColaborador($idFactura,$idColaborador) {
        $DatosFactura=$this->DevuelveValores("Facturas", "idFacturas", $idFactura);
        $tab="colaboradores_ventas";
        $NumRegistros=4;
        $Columnas[0]="Fecha";                   $Valores[0]=$DatosFactura["Fecha"];
        $Columnas[1]="idFactura";               $Valores[1]=$idFactura;
        $Columnas[2]="Total";                   $Valores[2]=$DatosFactura["Total"];
        $Columnas[3]="idColaborador";           $Valores[3]=$idColaborador;
                   
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
     }

     
 /*
 * Funcion Abono a Cartera
 */


	public function RegistreAbonoCarteraCliente($fecha,$Hora,$CuentaDestino,$idFactura,$Total,$CentroCosto,$Concepto,$idUser,$VectorIngreso){
            
            $DatosCentro=$this->DevuelveValores("centrocosto","ID",$CentroCosto);
            $DatosFactura=$this->DevuelveValores("facturas","idFacturas",$idFactura);
            $idCliente=$DatosFactura["Clientes_idClientes"];
            $DatosCliente=$this->DevuelveValores("clientes","idClientes",$idCliente);
            $CuentaClientes=$this->DevuelveValores("parametros_contables","ID",6);
            $DatosCuentasFrecuentes=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaDestino);
            $NIT=$DatosCliente["Num_Identificacion"];
            $RazonSocialC=$DatosCliente["RazonSocial"];
            
            //////Creo el comprobante de Ingreso
            
            $tab="comprobantes_ingreso";
            $NumRegistros=6;

            $Columnas[0]="Fecha";		$Valores[0]=$fecha;
            $Columnas[1]="Clientes_idClientes"; $Valores[1]=$idCliente;
            $Columnas[2]="Valor";               $Valores[2]=$Total;
            $Columnas[3]="Tipo";		$Valores[3]="EFECTIVO";
            $Columnas[4]="Concepto";		$Valores[4]=$Concepto;
            $Columnas[5]="Usuarios_idUsuarios";	$Valores[5]=$idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            $idIngreso=$this->ObtenerMAX($tab,"ID", 1,"");
            
            ////Registro el anticipo en el libro diario
            $DatosSucursal=  $this->DevuelveValores("empresa_pro_sucursales", "Actual", 1); 
            
            $tab="librodiario";
            $NumRegistros=27;
            $CuentaPUC=$CuentaDestino;
            $NombreCuenta=$DatosCuentasFrecuentes["Nombre"];
            $CuentaPUCContraPartida=$CuentaClientes["CuentaPUC"];
            $NombreCuentaContraPartida="Clientes Nacionales";
            


            $Columnas[0]="Fecha";			$Valores[0]=$fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="ComprobanteIngreso";
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idIngreso;
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
            $Columnas[5]="Tercero_DV";			$Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
            $Columnas[11]="Tercero_Direccion";		$Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];
            $Columnas[15]="CuentaPUC";			$Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";			$Valores[17]="AbonoFacturaCredito";
            $Columnas[18]="Debito";			$Valores[18]=$Total;
            $Columnas[19]="Credito";			$Valores[19]=0;
            $Columnas[20]="Neto";			$Valores[20]=$Valores[18];
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";			$Valores[23]=$Concepto;
            $Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCosto;
            $Columnas[25]="idEmpresa";			$Valores[25]=$DatosCentro["EmpresaPro"];
            $Columnas[26]="idSucursal";                 $Valores[26]=$DatosSucursal["ID"];
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


            ///////////////////////Registramos contra partida del anticipo

            $CuentaPUC=$CuentaPUCContraPartida; 
            $NombreCuenta=$NombreCuentaContraPartida;

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=0;
            $Valores[19]=$Total; 			//Credito se escribe el total de la venta menos los impuestos
            $Valores[20]=$Valores[19]*(-1);  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
            $NuevoSaldo=$DatosFactura["SaldoFact"]-$Total;
            $TotalAbonos=$DatosFactura["Total"]-$NuevoSaldo;
            $this->ActualizaRegistro("facturas", "SaldoFact", $NuevoSaldo, "idFacturas", $idFactura);
            if($NuevoSaldo<=0){
                $this->BorraReg("cartera", "Facturas_idFacturas", $idFactura);
            }else{
                $this->ActualizaRegistro("cartera", "Saldo", $NuevoSaldo, "Facturas_idFacturas", $idFactura);
                $this->ActualizaRegistro("cartera", "TotalAbonos", $TotalAbonos, "Facturas_idFacturas", $idFactura);
            }
            
            //////Creo el comprobante de Ingreso
            
            $tab="facturas_abonos";
            $NumRegistros=6;

            $Columnas[0]="Fecha";                       $Valores[0]=$fecha;
            $Columnas[1]="Hora";                        $Valores[1]=$Hora;
            $Columnas[2]="Valor";                       $Valores[2]=$Total;
            $Columnas[3]="Usuarios_idUsuarios";		$Valores[3]=$idUser;
            $Columnas[4]="Facturas_idFacturas";		$Valores[4]=$idFactura;
            $Columnas[5]="idComprobanteIngreso";	$Valores[5]=$idIngreso;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            $idComprobanteAbono=$this->ObtenerMAX($tab,"ID", 1,"");
            
            
            return($idComprobanteAbono);
            
            
	}
        
        
        
        /*
      * Imprime un Comprobante de Abono de Factura
      */
     
     public function ImprimeComprobanteAbonoFactura($idComprobanteAbono,$COMPrinter,$Copias){

        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosAbono=$this->DevuelveValores("facturas_abonos", "ID", $idComprobanteAbono);
       $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $DatosAbono["Facturas_idFacturas"]);
       $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $DatosFactura["EmpresaPro_idEmpresaPro"]);
       
       $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $DatosAbono["Usuarios_idUsuarios"]);
       $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
        $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
       
        $Telefono=$DatosEmpresa["Telefono"];

        $Total=$DatosFactura["Total"];
        $Saldo=$DatosFactura["SaldoFact"];
        
        $Fecha=$DatosAbono["Fecha"];
        $Hora=$DatosAbono["Hora"];
        
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$NIT);
        
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Direccion);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"Cliente: $DatosCliente[RazonSocial]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"NIT: $DatosCliente[Num_Identificacion]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha        Hora: $Hora");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"COMPROBANTE DE ABONO No $idComprobanteAbono");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"FACTURA NUMERO: $DatosFactura[Prefijo] - $DatosFactura[NumeroFactura]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    $TotalAbonos=$DatosFactura['Total']-$DatosFactura['SaldoFact'];

    /////////////////////////////TOTALES

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL FACTURA        ".str_pad("$".number_format($DatosFactura['Total']),20," ",STR_PAD_LEFT));

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    $idFactura=$DatosFactura["idFacturas"];
    fwrite($handle,"ABONOS:          ");
    $Consulta=$this->ConsultarTabla("facturas_abonos", " WHERE Facturas_idFacturas='$idFactura'");
    $TotalAbonos=0;
    while($DatosAbonosFactura=$this->FetchArray($Consulta)){
        $TotalAbonos=$TotalAbonos+$DatosAbonosFactura["Valor"];
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"CI No: $DatosAbonosFactura[idComprobanteIngreso]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"Fecha:  $DatosAbonosFactura[Fecha]  Valor: ".str_pad("$".number_format($DatosAbonosFactura["Valor"]),10," ",STR_PAD_LEFT));
               
    }
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL ABONOS:    ".str_pad("$".number_format($TotalAbonos),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"SALDO           ".str_pad("$".number_format($DatosFactura['SaldoFact']),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
    fwrite($handle,"***GRACIAS POR ELEGIRNOS***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
    //fwrite($handle, chr(27). chr(100). chr(0));
    //fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle,"***Comprobante impreso por SoftConTech***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"Software disenado por Techno Soluciones SAS, 3177740609, www.technosoluciones.com.co");
    //fwrite($handle,"=================================");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
    
    ///procese ejecucion de trabajos
    
    public function ProceseEjecucionActividad($idActividad, $idMaquina,$idColaborador,$idEjecucion,$idPausa,$Vector) {
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $DatosActividad=$this->DevuelveValores("produccion_actividades", "ID", $idActividad);     
        switch($idEjecucion){
            case 1: 
                $this->RegistreTiempoActividad($idActividad, $fecha." ".$hora, "EJECUCION", "NO", "");
                $this->ActualizaRegistro("produccion_actividades", "Estado", "EJECUCION", "ID", $idActividad);
                $this->ActualizaRegistro("produccion_actividades", "Fecha_Inicio", $fecha, "ID", $idActividad);
                $this->ActualizaRegistro("produccion_actividades", "Hora_Inicio", $hora, "ID", $idActividad);
                $this->ActualizaRegistro("produccion_actividades", "idColaborador", $idColaborador, "ID", $idActividad);
                break;
            case 2: 
                
                $DatosPausas=$this->DevuelveValores("produccion_pausas_predefinidas", "ID", $idPausa);
                if($DatosPausas["Suma"]=="SI"){
                    $Estado="PAUSA_OPERATIVA";
                    $this->RegistreTiempoActividad($idActividad, $fecha." ".$hora, $Estado, "SI", "");
                }else{
                    $Estado="PAUSA_NO_OPERATIVA";
                    $this->RegistreTiempoActividad($idActividad, $fecha." ".$hora, $Estado, "NO", "");
                }
                $this->ActualizaRegistro("produccion_actividades", "Estado", $Estado, "ID", $idActividad);
                break;
            case 3: 
                $this->RegistreTiempoActividad($idActividad, $fecha." ".$hora, "REINICIA_PAUSA_OPERATIVA", "SI", "");
                $this->ActualizaRegistro("produccion_actividades", "Estado", "EJECUCION", "ID", $idActividad);
                break;
            case 4: 
                $SoloHoraPlan=date("H",  strtotime($DatosActividad["Hora_Fin"]));
                $SoloHora=date("H",strtotime($hora));
                $Minutos=date("i:s",strtotime($hora));
                if($DatosActividad["Fecha_Fin"]==$fecha and $SoloHora==$SoloHoraPlan){
                    $hora=($SoloHora+1).":".$Minutos;
                }
                //print("<script>alert('$SoloHoraPlan  $SoloHora, $hora')</script>");
                $this->RegistreTiempoActividad($idActividad, $fecha." ".$hora, "TERMINADA", "NO", "");
                $this->ActualizaRegistro("produccion_actividades", "Estado", "TERMINADA", "ID", $idActividad);
                $this->ActualizaRegistro("produccion_actividades", "Fecha_Fin", $fecha, "ID", $idActividad);
                $this->ActualizaRegistro("produccion_actividades", "Hora_Fin", $hora, "ID", $idActividad);
                break;
            case 5: 
                $this->RegistreTiempoActividad($idActividad, $fecha." ".$hora, "REINICIA_PAUSA_NO_OPERATIVA", "NO", "");
                $this->ActualizaRegistro("produccion_actividades", "Estado", "EJECUCION", "ID", $idActividad);
                break;
        }
        
    }
    
    //inserto los registros de tiempo de las actividades
    
    public function RegistreTiempoActividad($idActividad, $FechaHora, $Estado,$Suma, $Vector ) {
        //////Inserto los valores en la tabla de registro de actividades
            
            $tab="produccion_registro_tiempos";
            $NumRegistros=5;

            $Columnas[0]="idActividad";         $Valores[0]=$idActividad;
            $Columnas[1]="FechaHora";           $Valores[1]=$FechaHora;
            $Columnas[2]="Estado";              $Valores[2]=$Estado;
            $Columnas[3]="Suma";		$Valores[3]=$Suma;
            $Columnas[4]="idUsuario";		$Valores[4]=$this->idUser;
                        
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            if($Estado=="TERMINADA"){
                $sql="SELECT FechaHora FROM produccion_registro_tiempos WHERE idActividad='$idActividad' AND "
                        . " Estado = 'EJECUCION' ";
                $Datos=$this->Query($sql);
                $Actividad = $this->FetchArray($Datos);
                $FechaHoraInicio = new DateTime($Actividad["FechaHora"]);
                $FechaHoraFin = new DateTime($FechaHora);
                $Diff=$FechaHoraFin->diff($FechaHoraInicio);
                $TiempoEjecucion["Horas"]=$Diff->format("%H"); 
                $TiempoEjecucion["Minutos"]=$Diff->format("%I"); 
                $TotalHoras=$this->ConviertaHorasDecimal($TiempoEjecucion["Horas"],$TiempoEjecucion["Minutos"],"");
                $DatosActividad=  $this->DevuelveValores("produccion_actividades", "ID", $idActividad);
                $DatosOT=  $this->DevuelveValores("produccion_ordenes_trabajo", "ID", $DatosActividad["idOrdenTrabajo"]);
                $TiempoOperacion=$TotalHoras-$DatosActividad["Pausas_No_Operativas"];
                $TiempoOperacionOT=$TiempoOperacion+$DatosOT["Tiempo_Operacion"];
                $this->ActualizaRegistro("produccion_actividades", "Tiempo_Operacion", $TiempoOperacion, "ID", $idActividad);
                $this->ActualizaRegistro("produccion_ordenes_trabajo", "Tiempo_Operacion", $TiempoOperacionOT, "ID", $DatosActividad["idOrdenTrabajo"]);               
            }
            if($Estado=="REINICIA_PAUSA_OPERATIVA"){
                $sql="SELECT FechaHora FROM produccion_registro_tiempos WHERE idActividad='$idActividad' AND "
                        . " Estado = 'PAUSA_OPERATIVA' ORDER BY `ID` DESC LIMIT 1";
                $Datos=$this->Query($sql);
                $Actividad = $this->FetchArray($Datos);
                $FechaHoraInicio = new DateTime($Actividad["FechaHora"]);
                $FechaHoraFin = new DateTime($FechaHora);
                $Diff=$FechaHoraFin->diff($FechaHoraInicio);
                $TiempoEjecucion["Horas"]=$Diff->format("%H"); 
                $TiempoEjecucion["Minutos"]=$Diff->format("%I"); 
                $TotalHoras=$this->ConviertaHorasDecimal($TiempoEjecucion["Horas"],$TiempoEjecucion["Minutos"],"");
                $DatosActividad=  $this->DevuelveValores("produccion_actividades", "ID", $idActividad);
                $DatosOT=  $this->DevuelveValores("produccion_ordenes_trabajo", "ID", $DatosActividad["idOrdenTrabajo"]);
                $TotalPausas=$TotalHoras+$DatosActividad["Pausas_Operativas"];
                $TotalPausasOT=$TotalPausas+$DatosOT["Pausas_Operativas"];
                
                $this->ActualizaRegistro("produccion_actividades", "Pausas_Operativas", $TotalPausas, "ID", $idActividad);
                $this->ActualizaRegistro("produccion_ordenes_trabajo", "Pausas_Operativas", $TotalPausasOT, "ID", $DatosActividad["idOrdenTrabajo"]);                
            }
            
            if($Estado=="REINICIA_PAUSA_NO_OPERATIVA"){
                $sql="SELECT FechaHora FROM produccion_registro_tiempos WHERE idActividad='$idActividad' AND "
                        . " Estado = 'PAUSA_NO_OPERATIVA' ORDER BY `ID` DESC LIMIT 1";
                $Datos=$this->Query($sql);
                $Actividad = $this->FetchArray($Datos);
                $FechaHoraInicio = new DateTime($Actividad["FechaHora"]);
                $FechaHoraFin = new DateTime($FechaHora);
                $Diff=$FechaHoraFin->diff($FechaHoraInicio);
                $TiempoEjecucion["Horas"]=$Diff->format("%H"); 
                $TiempoEjecucion["Minutos"]=$Diff->format("%I"); 
                $TotalHoras=$this->ConviertaHorasDecimal($TiempoEjecucion["Horas"],$TiempoEjecucion["Minutos"],"");
                $DatosActividad=  $this->DevuelveValores("produccion_actividades", "ID", $idActividad);
                $DatosOT=  $this->DevuelveValores("produccion_ordenes_trabajo", "ID", $DatosActividad["idOrdenTrabajo"]);
                $TotalPausas=$TotalHoras+$DatosActividad["Pausas_No_Operativas"];
                $TotalPausasOT=$TotalPausas+$DatosOT["Pausas_No_Operativas"];
                $this->ActualizaRegistro("produccion_actividades", "Pausas_No_Operativas", $TotalPausas, "ID", $idActividad);
                $this->ActualizaRegistro("produccion_ordenes_trabajo", "Pausas_No_Operativas", $TotalPausasOT, "ID", $DatosActividad["idOrdenTrabajo"]);                   
            }
            
            
            
    }
    
    //Suma o resta dos horas con fecha
    
    public function ObtenerTiempo($FechaInicial,$FechaFinal,$Operacion) {
        if($Operacion=="-"){
            $dif=date("Y-m-d H:i:s", strtotime($FechaFinal) - strtotime($FechaInicial) );
        }
        if($Operacion=="+"){
            $dif=date("Y-m-d H:i:s", strtotime($FechaFinal) + strtotime($FechaInicial) );
        }
        return($dif);
    }
    
    //inserto los registros para la creacion de una sesion de concejo
    
    public function CrearSesionConsejo($FechaSesion,$TipoSesion,$NombreSesion, $Vector ) {
        //////Inserto los valores en la tabla de registro de actividades
            
            $tab="concejo_sesiones";
            $NumRegistros=3;

            $Columnas[0]="Sesion";         $Valores[0]=$NombreSesion." TIPO ".$TipoSesion;
            $Columnas[1]="Fecha";          $Valores[1]=$FechaSesion;
            $Columnas[2]="idUsuario";      $Valores[2]=$this->idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                      
            
    }
    
    //otorgo la palabra
    
    public function OtorgarPalabraSesion($idSesionConcejo,$idConcejal,$idTiempo,$Vector) {
        //////Inserto los valores en la tabla de registro de actividades
            $Fecha=date("Y-m-d");
            $HoraInicio=date("H:i:s");
            $tab="concejales_intervenciones";
            $NumRegistros=4;

            $Columnas[0]="idConcejal";      $Valores[0]=$idConcejal;
            $Columnas[1]="idSesionConcejo"; $Valores[1]=$idSesionConcejo;
            $Columnas[2]="Fecha";           $Valores[2]=$Fecha;
            $Columnas[3]="HoraInicio";      $Valores[3]=$HoraInicio;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            $this->ActualizaRegistro("crono_controles", "Estado", "PLAY", "ID", 1);
            $this->ActualizaRegistro("crono_controles", "idConcejal", $idConcejal, "ID", 1);
            $HoraInicial=strtotime($HoraInicio);
            $HoraFin=date("H:i:s",$HoraInicial+($idTiempo*60));
            $this->ActualizaRegistro("crono_controles", "Fin", $HoraFin, "ID", 1);          
            
    }
    
    public function ConviertaHorasDecimal($Horas,$Minutos, $Vector) {
        $HoraDecimal=$Horas+($Minutos/60);
        return ($HoraDecimal);
    }
//////////////////////////////Fin	
}
	
?>