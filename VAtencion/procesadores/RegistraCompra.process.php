<?php
/* 
 * Este archivo procesa el registro de compras
 */

//$obVenta=new ProcesoVenta($idUser); 
$obCompra=new Compra($idUser);
if(!empty($_REQUEST["BtnCrearCompra"])){
      
$Fecha=$obCompra->normalizar($_REQUEST["TxtFecha"]);
$idTercero=$obCompra->normalizar($_REQUEST["TxtTerceroCI"]);
$CentroCosto=$obCompra->normalizar($_REQUEST["CmbCentroCosto"]);
$idSede=$obCompra->normalizar($_REQUEST["idSucursal"]);
$TipoCompra=$obCompra->normalizar($_REQUEST["TipoCompra"]);
$NumeroFactura=$obCompra->normalizar($_REQUEST["TxtNumFactura"]);
$idCompra=$obCompra->CrearCompra($Fecha, $idTercero, "", $CentroCosto, $idSede, $idUser,$TipoCompra,$NumeroFactura, $Vector);
header("location:$myPage?idCompra=$idCompra");
      
}

//SI se recibe la solicitud de crear un proveedor

if(!empty($_REQUEST['BtnCrearProveedor'])){
		
    $NIT=$_REQUEST['TxtNIT'];
    $idCodMunicipio=$_REQUEST['CmbCodMunicipio'];
    $obVenta=new ProcesoVenta($idUser);
    $DatosClientes=$obVenta->DevuelveValores('proveedores',"Num_Identificacion",$NIT);
    $DV="";
    $DatosMunicipios=$obVenta->DevuelveValores('cod_municipios_dptos',"ID",$idCodMunicipio);		
    if($DatosClientes["Num_Identificacion"]<>$NIT){

            ///////////////////////////Ingresar a Clientes 

            if($_REQUEST['CmbTipoDocumento']==31){

                    $DV=$obVenta->CalcularDV($NIT);

            }

            $tab="proveedores";
            $NumRegistros=15;  


            $Columnas[0]="Tipo_Documento";					$Valores[0]=$obVenta->normalizar($_REQUEST['CmbTipoDocumento']);
            $Columnas[1]="Num_Identificacion";					$Valores[1]=$obVenta->normalizar($_REQUEST['TxtNIT']);
            $Columnas[2]="DV";                                                  $Valores[2]=$DV;
            $Columnas[3]="Primer_Apellido";					$Valores[3]=$obVenta->normalizar($_REQUEST['TxtPA']);
            $Columnas[4]="Segundo_Apellido";					$Valores[4]=$obVenta->normalizar($_REQUEST['TxtSA']);
            $Columnas[5]="Primer_Nombre";					$Valores[5]=$obVenta->normalizar($_REQUEST['TxtPN']);
            $Columnas[6]="Otros_Nombres";					$Valores[6]=$obVenta->normalizar($_REQUEST['TxtON']);
            $Columnas[7]="RazonSocial";						$Valores[7]=$obVenta->normalizar($_REQUEST['TxtRazonSocial']);
            $Columnas[8]="Direccion";						$Valores[8]=$obVenta->normalizar($_REQUEST['TxtDireccion']);
            $Columnas[9]="Cod_Dpto";						$Valores[9]=$obVenta->normalizar($DatosMunicipios["Cod_Dpto"]);
            $Columnas[10]="Cod_Mcipio";						$Valores[10]=$obVenta->normalizar($DatosMunicipios["Cod_mcipio"]);
            $Columnas[11]="Pais_Domicilio";					$Valores[11]=169;
            $Columnas[12]="Telefono";			    			$Valores[12]=$obVenta->normalizar($_REQUEST['TxtTelefono']);
            $Columnas[13]="Ciudad";			    			$Valores[13]=$obVenta->normalizar($DatosMunicipios["Ciudad"]);
            $Columnas[14]="Email";			    			$Valores[14]=$obVenta->normalizar($_REQUEST['TxtEmail']);

            $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            $obVenta->InsertarRegistro("clientes",$NumRegistros,$Columnas,$Valores);
            print("<script language='JavaScript'>alert('Se ha creado el Proveedor $_REQUEST[TxtRazonSocial]')</script>");

    }else{

            print("<script language='JavaScript'>alert('El cliente con Identificacion: $NIT, ya existe y no se puede crear nuevamente')</script>");
    }	

    //header("location:VentaFacil.php?CmbPreVentaAct=$idPreventa");

			
	}
?>