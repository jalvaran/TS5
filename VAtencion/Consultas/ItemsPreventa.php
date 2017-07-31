<?php

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
//$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("id");
$obVenta = new ProcesoVenta($idUser);
//$key=$obVenta->normalizar($_REQUEST['key']);
$myPage=$obVenta->normalizar($_REQUEST['myPage']);
$idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
$idClientes=1;
//////Si recibo un cliente
if(isset($_REQUEST['idClientes'])){

    $idClientes=$_REQUEST['idClientes'];
}


//Si se recibe un codigo de barras
if(isset($_REQUEST['key'])){
		
        $CodBar=$obVenta->normalizar($_REQUEST['key']);
        $obVenta=new ProcesoVenta($idUser);
        $TablaItem="productosventa";
        $Cantidad=1;
        //$DatosCodigo=$obVenta->DevuelveValores('prod_codbarras',"CodigoBarras",$CodBar);
                
        if(isset($_REQUEST['Pesaje'])){
            $css->CrearNotificacionNaranja("Modo Bascula Activo", 16);
            $Cantidad=$obVenta->ObtenerPesoPCR_phpSerial("");
            $Cantidad=str_replace(' ', '', $Cantidad);            
        }
        $fecha=date("Y-m-d");
        if($Cantidad>0){
            $sql="SELECT ProductosVenta_idProductosVenta as idProductosVenta FROM prod_codbarras WHERE CodigoBarras='$CodBar'";
            $consulta=$obVenta->Query($sql);
            $DatosProducto=$obVenta->FetchArray($consulta);
            if($DatosProducto["idProductosVenta"]==''){
                $idProducto=ltrim($CodBar, "0");
                $sql="SELECT idProductosVenta FROM productosventa WHERE idProductosVenta='$CodBar'";
                $consulta=$obVenta->Query($sql);
                $DatosProducto=$obVenta->FetchArray($consulta);
            }
            /*
            $sql="SELECT pv.`idProductosVenta` FROM `productosventa` pv "
                . " INNER JOIN prod_codbarras k ON pv.`idProductosVenta`=k.ProductosVenta_idProductosVenta "
                . " WHERE pv.`idProductosVenta`='$CodBar' "
                . " OR pv.`CodigoBarras`='$CodBar' "
                . " OR k.`CodigoBarras`='$CodBar' LIMIT 1 ";
            
            $sql="SELECT pv.`idProductosVenta` FROM `productosventa` pv "
                . " INNER JOIN prod_codbarras k ON pv.`idProductosVenta`=k.ProductosVenta_idProductosVenta "
                . " WHERE k.`CodigoBarras`='$CodBar' "
                . " OR pv.`CodigoBarras`='$CodBar' "
                . " OR pv.`idProductosVenta`='$CodBar' ORDER BY pv.`idProductosVenta` DESC LIMIT 1";
            $Consulta=$obVenta->Query($sql);
            $DatosProducto=$obVenta->FetchArray($Consulta);
             * 
             */
            if($DatosProducto["idProductosVenta"]){
                $Error=$obVenta->AgregaPreventa($fecha,$Cantidad,$idPreventa,$DatosProducto['idProductosVenta'],$TablaItem);
                if($Error=="E1"){
                    $css->CrearNotificacionRoja("Este producto no tiene precio de venta, no lo entregue", 16);
                }
            }else{
                $css->CrearNotificacionRoja("Este producto no esta en la base de datos, no lo entregue", 16);
            }
            
        }else{
            $css->CrearNotificacionRoja("No se pueden agregar Cantidades en Cero", 16);
        }
}

//Si se recibe una autorizacion

if(isset($_REQUEST['TxtAutorizacion'])){
    	
    $Clave=$obVenta->normalizar($_REQUEST['TxtAutorizacion']);
    $sql="SELECT Identificacion FROM usuarios WHERE Password='$Clave' AND (Role='ADMINISTRADOR' or Role='SUPERVISOR') LIMIT 1";
    $Datos=$obVenta->Query($sql);
    $DatosAutorizacion=$obVenta->FetchArray($Datos);
    
    $NoAutorizado="";
    if($DatosAutorizacion["Identificacion"]<>''){
        
        $obVenta->ActualizaRegistro("preventa", "Autorizado", $DatosAutorizacion["Identificacion"], "VestasActivas_idVestasActivas", $idPreventa);
        
        $css->CrearBotonOcultaDiv("Opciones: ", "DivDescuentos", 20, 20,0, "");
        $css->CrearDiv("DivDescuentos", "", "center", 0, 1);
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>DESCUENTO GENERAL POR PORCENTAJE</strong>", 1);
        //$css->ColTabla("<strong>DESCUENTO GENERAL AL POR MAYOR</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td style='text-align:center;'>");
        $css->CrearForm2("FrmAutorizacionDescuento", $myPage, "post", "_self");
        $css->CrearInputText("TxtidPreventa", "hidden", "", $idPreventa, "", "", "", "", "", "", "", "");
        $css->CrearInputNumber("TxtDescuento", "number", "", "", "Descuento", "", "", "", 100,30, 0, 1, 1, 30, 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnDescuentoGeneral", "Descuento %");

        $css->CerrarForm();
        print("</td>");

        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarDiv();
        
    }else{
        $css->CrearNotificacionRoja("Clave incorrecta o no autorizada", 16);
    }	
}
$sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ORDER BY Updated DESC";
    $pa=$obVenta->Query($sql);
    if($obVenta->NumRows($pa)){	
        
        $css->CrearTabla();
        $css->CrearNotificacionAzul("Items en Esta Preventa",16);
            $css->FilaTabla(14);
                $css->ColTabla("<strong>Referencia</strong>", 1);
                $css->ColTabla("<strong>Nombre</strong>", 1);
                $css->ColTabla("<strong>Cantidad</strong>", 1);
                $css->ColTabla("<strong>ValorUnitario</strong>", 1);
                $css->ColTabla("<strong>Subtotal</strong>", 1);
                $css->ColTabla("<strong>Borrar</strong>", 1);
            $css->CierraFilaTabla();
        
        
    while($DatosPreventa=$obVenta->FetchArray($pa)){
            
            $css->FilaTabla(16);
            $DatosProducto=$obVenta->DevuelveValores($DatosPreventa["TablaItem"],"idProductosVenta",$DatosPreventa["ProductosVenta_idProductosVenta"]);
            $css->ColTabla("$DatosProducto[Referencia]", 1);
            $css->ColTabla("$DatosProducto[Nombre]", 1);       
            
            $Autorizado=!$DatosPreventa["Autorizado"];
            $NameTxt="TxtEditar$DatosPreventa[idPrecotizacion]";
            
            if($Autorizado){
                $Evento="ConfirmarFormNegativo(`$NameTxt`);return false;";
                $VectorDatosExtra["JS"]="onclick='ConfirmarFormPass(); return false;'";
            }else{
                $Evento="";
                $VectorDatosExtra["JS"]="";
            }
            print("<td>");
                $css->DivColTablaFormInputText("FrmEdit$DatosPreventa[idPrecotizacion]",$myPage,"post","_self",$NameTxt,"Number",$DatosPreventa['Cantidad'],"","","","onClick",$Evento,"70","30","","","TxtPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa);
            print("</td>");
            $PrecioAcordado=round($DatosPreventa['ValorAcordado']);
            print("<td>");
              $css->DivColTablaFormEditarPrecio("FrmEditPrecio$DatosPreventa[idPrecotizacion]",$myPage,"post","_self","TxtEditarPrecio$DatosPreventa[idPrecotizacion]","Number",$PrecioAcordado,"","","","","","","150","30",$Autorizado,0,"TxtPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa,"TxtPrecioMayor",$DatosProducto["PrecioMayorista"]); 
            print("</td>");
            $css->ColTabla("<strong>".number_format($DatosPreventa['TotalVenta'])."</strong>", 1);    
            
            print("<td>");
            $css->DivColTable("center",0,1,"black","100%","");
            $VectorDatosExtra["ID"]="LinkDel$DatosPreventa[idPrecotizacion]";
            
            $link="$myPage?del=$DatosPreventa[idPrecotizacion]&TxtTabla=preventa&TxtIdTabla=idPrecotizacion&TxtIdPre=$idPreventa";
            $css->CrearLinkID($link,"_self","X",$VectorDatosExtra);
           print("</td>");
            
           
    }
    $css->CerrarTabla();
    $css->CerrarDiv();//Cierro la tabla
    }else{
      $css->CrearNotificacionRoja("No hay items en esta preventa",20);  
    }
$css->AgregaJS(); //Agregamos javascripts
?>