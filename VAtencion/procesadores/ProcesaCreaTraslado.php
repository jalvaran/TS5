<?php 
if(!empty($_REQUEST['del'])){
    $id=$_REQUEST['del'];
    $Tabla=$_REQUEST['TxtTabla'];
    $IdTabla=$_REQUEST['TxtIdTabla'];
    $IdPre=$_REQUEST['TxtIdPre'];
    $DatosItem=$obVenta->DevuelveValores($Tabla, $IdTabla, $id);
    $obVenta->ActualizaRegistro("librodiario", "Estado", "", "idLibroDiario", $DatosItem["idLibroDiario"]);
    mysql_query("DELETE FROM $Tabla WHERE $IdTabla='$id'") or die(mysql_error());
    header("location:CreaComprobanteCont.php?idComprobante=$IdPre");
}

if(!empty($_REQUEST["BtnCrearTraslado"])){
    
    $obVenta=new ProcesoVenta($idUser);
    $sql="SELECT Identificacion FROM usuarios WHERE idUsuarios='$idUser'";
    $Consulta=$obVenta->Query($sql);
    $DatosUsuario=$obVenta->FetchArray($Consulta);
    $fecha=$_REQUEST["TxtFecha"];
    $hora=$_REQUEST["TxtHora"];
    $Concepto=$_REQUEST["TxtDescripcion"];
    $Destino=$_REQUEST["CmbDestino"];
    
     ////////////////Creo el comprobante
    /////
    ////
    $Consecutivo=$obVenta->ObtenerMAX("traslados_mercancia", "ConsecutivoInterno", 1, 0);
    $Consecutivo++;
    $DatosSucursalActual=$obVenta->DevuelveValores("empresa_pro_sucursales", "Actual", 1);
    $tab="traslados_mercancia";
    $NumRegistros=9; 
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
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    $idComprobante=$id;
    $DatosServer2=$obVenta->DevuelveValores("servidores", "ID", 1);
    
    
    //$obVenta->CerrarCon();
    header("location:$myPage");
}

		
if(!empty($_REQUEST["BtnAgregarItemMov"])){
    
    $obVenta=new ProcesoVenta($idUser);
    
    $destino="";
    //echo "<script>alert ('entra')</script>";
    if(!empty($_FILES['foto']['name'])){
        
        $carpeta="../SoportesEgresos/";
        opendir($carpeta);
        $Name=str_replace(' ','_',$_FILES['foto']['name']);  
        $destino=$carpeta.$Name;
        move_uploaded_file($_FILES['foto']['tmp_name'],$destino);
    }
    
    $idComprobante=$_REQUEST["TxtIdCC"];
    $DatosComprobante=$obVenta->DevuelveValores("comprobantes_contabilidad", "ID", $idComprobante);
    $fecha=$DatosComprobante["Fecha"];
    
    $Concepto=$_REQUEST["TxtConceptoEgreso"];
    $CentroCosto=$_REQUEST["CmbCentroCosto"];
    $Tercero=$_REQUEST["CmbTerceroItem"];
    $DatosCuentaDestino=$_REQUEST["CmbCuentaDestino"];
    $DatosCuentaDestino=explode(";",$DatosCuentaDestino);
    $CuentaPUC=$DatosCuentaDestino[0];
    $NombreCuenta=$NombreCuenta=str_replace("_"," ",$DatosCuentaDestino[1]);
    
    $Valor=$_REQUEST["TxtValorItem"];
    $DC=$_REQUEST["CmbDebitoCredito"];
    $NumDocSoporte=$_REQUEST["TxtNumFactura"];
    if($DC=="C"){
        $Debito=0;
        $Credito= $Valor;       
    }else{
       $Debito=$Valor;
       $Credito=0; 
    }
     ////////////////Ingreso el Item
    /////
    ////
    
    $tab="comprobantes_contabilidad_items";
    $NumRegistros=11;

    $Columnas[0]="Fecha";			$Valores[0]=$fecha;
    $Columnas[1]="CentroCostos";		$Valores[1]=$CentroCosto;
    $Columnas[2]="Tercero";			$Valores[2]=$Tercero;
    $Columnas[3]="CuentaPUC";			$Valores[3]=$CuentaPUC;
    $Columnas[4]="Debito";			$Valores[4]=$Debito;
    $Columnas[5]="Credito";                     $Valores[5]=$Credito;
    $Columnas[6]="Concepto";			$Valores[6]=$Concepto;
    $Columnas[7]="NumDocSoporte";		$Valores[7]=$NumDocSoporte;
    $Columnas[8]="Soporte";			$Valores[8]=$destino;
    $Columnas[9]="idComprobante";		$Valores[9]=$idComprobante;
    $Columnas[10]="NombreCuenta";		$Valores[10]=$NombreCuenta;

    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    //header("location:$myPage?idComprobante=$idComprobante");
}

if(!empty($_REQUEST["CmbComprobante"])){
    
    $idComprobante=$_REQUEST["CmbComprobante"];
    header("location:$myPage?idComprobante=$idComprobante");
}

// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnGuardarMovimiento"])){
    
    $idComprobante=$_REQUEST["TxtIdComprobanteContable"];    
    $obVenta->RegistreComprobanteContable($idComprobante);    
    header("location:$myPage?ImprimeCC=$idComprobante");
    
}
///////////////fin
?>