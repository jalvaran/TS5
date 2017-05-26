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
$Concepto=$obCompra->normalizar($_REQUEST["TxtConcepto"]);
$idCompra=$obCompra->CrearCompra($Fecha, $idTercero, "", $CentroCosto, $idSede, $idUser,$TipoCompra,$NumeroFactura,$Concepto, $Vector);
header("location:$myPage?idCompra=$idCompra");
      
}
//Verificamos si se recibe la peticion de Agregar un item a la compra
if(!empty($_REQUEST["TxtAgregarItemCompra"])){
      
    $idItem=$obCompra->normalizar($_REQUEST["TxtAgregarItemCompra"]);
    $idCompra=$obCompra->normalizar($_REQUEST["TxtAgregarItemCompra"]);
    $idCompra=$obCompra->CrearCompra($Fecha, $idTercero, "", $CentroCosto, $idSede, $idUser,$TipoCompra,$NumeroFactura,$Concepto, $Vector);
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
		
}

//Agrega un item a la compra

if(isset($_REQUEST["BtnAgregarItem"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $idProducto=$obCompra->normalizar($_REQUEST["TxtidProducto"]);
    $Cantidad=$obCompra->normalizar($_REQUEST["TxtCantidad"]);
    $TipoIVA=$obCompra->normalizar($_REQUEST["TipoIVA"]);
    $IVAIncluido=$obCompra->normalizar($_REQUEST["IVAIncluido"]);
    $CostoUnitario=$obCompra->normalizar($_REQUEST["TxtCosto"]);
    switch ($_REQUEST["TipoItem"]){
        case 1:
            $obCompra->AgregueProductoCompra($idCompra,$idProducto,$Cantidad,$CostoUnitario,$TipoIVA,$IVAIncluido,"");
            break;
    }
}

//Eliminar un item a la compra

if(isset($_REQUEST["del"])){
    $idItem=$obCompra->normalizar($_REQUEST["del"]);
    $idCompra=$_REQUEST["TxtIdPre"];
    $obCompra->BorraReg("factura_compra_items", "ID", $idItem);
    header("location:$myPage?idCompra=$idCompra");
}


//Agrega una retencion en la fuente a la compra

if(isset($_REQUEST["BtnAgregueReteFuente"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $Cuenta=$obCompra->normalizar($_REQUEST["CmbCuentaReteFuente"]);
    $Porcentaje=$obCompra->normalizar($_REQUEST["TxtPorReteFuente"]);
    $Valor=$obCompra->normalizar($_REQUEST["TxtReteFuenteProductos"]);
    $TotalCompra=$obCompra->SumeColumna("factura_compra_items", "TotalCompra", "idFacturaCompra", $idCompra);
    if($TotalCompra>0 and $TotalCompra>$Valor){
        $obCompra->AgregueRetencionCompra($idCompra, $Cuenta, $Valor, $Porcentaje, "");
    }else{
       $css->CrearNotificacionRoja("No se pueden agregar retenciones sin valor o Mayores a la base", 16);
    }
}

//Agrega reteica a la compra

if(isset($_REQUEST["BtnAgregueReteICA"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $Cuenta=$obCompra->normalizar($_REQUEST["CmbCuentaReteICA"]);
    $Porcentaje=$obCompra->normalizar($_REQUEST["TxtPorReteICA"]);
    $Valor=$obCompra->normalizar($_REQUEST["TxtReteICA"]);
    $TotalCompra=$obCompra->SumeColumna("factura_compra_items", "TotalCompra", "idFacturaCompra", $idCompra);
    if($TotalCompra>0 and $TotalCompra>$Valor){
        $obCompra->AgregueRetencionCompra($idCompra, $Cuenta, $Valor, $Porcentaje, "");
    }else{
       $css->CrearNotificacionRoja("No se pueden agregar retenciones sin valor o Mayores a la base", 16);
    }
}

//Agrega reteiva a la compra

if(isset($_REQUEST["BtnAgregueReteIVA"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $Cuenta=$obCompra->normalizar($_REQUEST["CmbCuentaReteIVA"]);
    $Porcentaje=$obCompra->normalizar($_REQUEST["TxtPorReteIVA"]);
    $Valor=$obCompra->normalizar($_REQUEST["TxtReteIVA"]);
    $TotalCompra=$obCompra->SumeColumna("factura_compra_items", "ImpuestoCompra", "idFacturaCompra", $idCompra);
    if($TotalCompra>0 and $TotalCompra>$Valor){
        $obCompra->AgregueRetencionCompra($idCompra, $Cuenta, $Valor, $Porcentaje, "");
    }else{
       $css->CrearNotificacionRoja("No se pueden agregar retenciones sin valor o Mayores a la base", 16);
    }
}

//Eliminar una retencion

if(isset($_REQUEST["DelRetencion"])){
    $idItem=$obCompra->normalizar($_REQUEST["DelRetencion"]);
    $idCompra=$_REQUEST["idCompra"];
    $obCompra->BorraReg("factura_compra_retenciones", "ID", $idItem);
    header("location:$myPage?idCompra=$idCompra");
}
//Eliminar una retencion

if(isset($_REQUEST["BtnGuardarCompra"])){
    $idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
    $TipoPago=$obCompra->normalizar($_REQUEST["CmbTipoPago"]);
    $CuentaOrigen=$obCompra->normalizar($_REQUEST["CmbCuentaOrigen"]);
    $obCompra->GuardarFacturaCompra($idCompra, $TipoPago, $CuentaOrigen, "");
    header("location:$myPage?idCompra=$idCompra");
}
?>