<?php
$myPage="FacturaCotizacion.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$idRemision="";
//////Si recibo un cliente
	if(!empty($_REQUEST['TxtAsociarCotizacion'])){
		
		$idCotizacion=$_REQUEST['TxtAsociarCotizacion'];
	}

	
print("<html>");
print("<head>");
$css =  new CssIni("Asociar una cotizacion a una factura");

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaFacturarCoti.php");
    
    $css->CabeceraIni("SoftConTech Facturar una Cotización"); //Inicia la cabecera de la pagina
       
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////
    $css->CrearTabla();
    $css->CrearForm2("FrmAgregaCotizacion", $myPage, "post", "_self");
    $css->CrearInputNumber("TxtAsociarCotizacion", "number", "Agregue una cotizacion:<br>", "", "Cotizacion a Asociar", "black", "", "", 300, 30, 0, 1, 1, "", 1);
    $css->CerrarForm();
    $css->CerrarTabla();
    $css->CrearImageLink("FactCoti.php", "../images/cotizacion.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    
        if(!empty($_REQUEST["TxtidFactura"])){
            
            $idFactura=$_REQUEST["TxtidFactura"];
            if($idFactura<>""){
                $RutaPrint="PDF_Factura.php?ImgPrintFactura=".$idFactura;
                $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
                $css->CrearTabla();
                $css->CrearFilaNotificacion("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $DatosFactura[NumeroFactura]</a>",16);
                $css->CerrarTabla();
            }else{
                
               $css->AlertaJS("No se pudo crear la factura porque no hay resoluciones disponibles", 1, "", ""); 
            }
            
        }
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   
    $consulta=$obVenta->ConsultarTabla("facturas_pre"," WHERE idUsuarios='$idUser' ORDER BY ID desc");
          

    if(mysql_affected_rows()){

        
        $css->CrearTabla();
        $css->CrearFilaNotificacion("PRE-FACTURA",18);
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Referencia</strong>", 1);
        $css->ColTabla("<strong>Descripcion</strong>", 1);
        $css->ColTabla("<strong>Valor Unitario / Cantidad</strong>", 1);
        $css->ColTabla("<strong>Total Item</strong>", 1);
        $css->ColTabla("<strong>Borrar</strong>", 1);
        $css->CierraFilaTabla();

        while($DatosItemsCotizacion=mysql_fetch_array($consulta)){
            $idItem=$DatosItemsCotizacion["ID"];
            $css->FilaTabla(16);
            $css->ColTabla($DatosItemsCotizacion["Referencia"], 1);
            $css->ColTabla($DatosItemsCotizacion["Nombre"], 1);
            
            print("<td>");
                $css->CrearForm2("FormEditarCotizacion$idItem", $myPage, "post", "_self");
                //$css->CrearInputText("TxtIdCotizacion", "hidden", "", $idCotizacion, "", "", "", "", "", "", 0, 0);
                $css->CrearInputText("TxtIdItemCotizacion", "hidden", "", $idItem, "", "", "", "", "", "", 0, 0);
                $css->CrearInputNumber("TxtValorUnitario", "number", "", $DatosItemsCotizacion["ValorUnitarioItem"], "ValorUnitario", "black", "", "", 120, 30, 0, 1, $DatosItemsCotizacion["PrecioCostoUnitario"], $DatosItemsCotizacion["ValorUnitarioItem"]."0", "any");
                $css->CrearInputNumber("TxtCantidad", "number", "", $DatosItemsCotizacion["Cantidad"], "ValorUnitario", "black", "", "", 80, 30, 0, 1, 0.00001, "", "any");
                $css->CrearBotonVerde("BtnEditar", "E");
                $css->CerrarForm();
            print("</td>");
            
            
            $css->ColTabla($DatosItemsCotizacion["SubtotalItem"], 1);
            
            $css->ColTablaDel($myPage,"facturas_pre","ID",$DatosItemsCotizacion['ID'],"");
            $css->CierraFilaTabla();
        }

        $css->CerrarTabla();
        /////////////////Mostramos Totales y Se crea el formulario para guardar la devolucion
        ////
        ////
        
        $Subtotal=$obVenta->Sume("facturas_pre", "SubtotalItem", "WHERE idUsuarios='$idUser'");
        $IVA=$obVenta->Sume("facturas_pre", "IVAItem", "WHERE idUsuarios='$idUser'");
        $Total=$obVenta->Sume("facturas_pre", "TotalItem", "WHERE idUsuarios='$idUser'");
        $css->CrearFormularioEvento("FormGeneraFactura", $myPage, "post", "_self","");
        
             
        $css->CrearTabla();
        $css->FilaTabla(12);
        $css->ColTabla("<h4 align='right'>Subtotal</h4>", 1);
        $css->ColTabla("<h4 align='right'>".number_format($Subtotal)."</h4>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(12);
        $css->ColTabla("<h4 align='right'>IVA</h4>", 1);
        $css->ColTabla("<h4 align='right'>".number_format($IVA)."</h4>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(12);
        $css->ColTabla("<h4 align='right'>Total</h3>", 1);
        $css->ColTabla("<h4 align='right'>".number_format($Total)."</h4>", 1);
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        
        $css->CrearTabla();
        
        $css->FilaTabla(14);
       print("<strong>Seleccione un Cliente para esta Factura:<br>");
        $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione un Cliente";
            $VarSelect["Required"]=1;
            $css->CrearSelectChosen("CmbCliente", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione un Cliente" , 0);
            $sql="SELECT * FROM clientes";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosClientes=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosClientes["idClientes"], "$DatosClientes[Num_Identificacion] $DatosClientes[RazonSocial] $DatosClientes[Ciudad]" , $Sel);
               }
            $css->CerrarSelect();
           print("<br><br>");
            //print("<td>");
        print("Centro de costos: <br>");
        $css->CrearSelect("CmbCentroCostos", "");
            $Consulta=$obVenta->ConsultarTabla("centrocosto", "");
            if(mysql_num_rows($Consulta)){
            while($DatosCentroCosto=  mysql_fetch_array($Consulta)){
                $css->CrearOptionSelect($DatosCentroCosto["ID"], $DatosCentroCosto["Nombre"], 0);
            }
            }else{
                $css->AlertaJS("No hay centros de costo creados por favor cree uno", 1, "", "");
            }
        $css->CerrarSelect();
        //print("</td>");
        print("<br>");
        print("Resolucion:<br> ");
        $css->CrearSelect("CmbResolucion", "");
            $Consulta=$obVenta->ConsultarTabla("empresapro_resoluciones_facturacion", "WHERE Completada<>'SI'");
            if(mysql_num_rows($Consulta)){
            while($DatosResolucion=  mysql_fetch_array($Consulta)){
                $css->CrearOptionSelect($DatosResolucion["ID"], "$DatosResolucion[NombreInterno] $DatosResolucion[NumResolucion]", 0);
            }
            }else{
                
                $css->AlertaJS("No hay resoluciones de facturacion disponibles por favor cree una", 1, "", "");
                
                
            }
        $css->CerrarSelect();
        print("<br>Forma de Pago:<br> ");
        $css->CrearSelect("CmbFormaPago", "");
            $css->CrearOptionSelect("Contado", "Contado", 1);
            $css->CrearOptionSelect("15", "15 Dias", 0);
            $css->CrearOptionSelect("30", "30 Dias", 0);
            $css->CrearOptionSelect("60", "60 Dias", 0);
            $css->CrearOptionSelect("90", "90 Dias", 0);
        $css->CerrarSelect();
        
        print("<br>");
        
        print("Cuenta donde ingresa el dinero: <br>");
        $css->CrearSelect("CmbCuentaDestino", "");
            $Consulta=$obVenta->ConsultarTabla("cuentasfrecuentes", "WHERE ClaseCuenta='ACTIVOS'");
            if(mysql_num_rows($Consulta)){
            while($DatosCuentasFrecuentes=  mysql_fetch_array($Consulta)){
                $css->CrearOptionSelect($DatosCuentasFrecuentes["CuentaPUC"], $DatosCuentasFrecuentes["Nombre"], 0);
            }
            }else{
                print("<script>alert('No hay cuentas frecuentes creadas debe crear al menos una')</script>");
            }
        $css->CerrarSelect();
        print("<br>Fecha de la Factura: <br>");
        $css->CrearInputText("TxtFechaFactura","text","",date("Y-m-d"),"FechaFactura","black","","",130,30,0,1);
        print("<br>");
        $css->CrearInputText("TxtNumeroFactura","number","",0,"","black","","",130,30,0,1,0,$DatosResolucion["Hasta"]);
        print("<br>");
        $css->CrearInputText("TxtOrdenCompra","text","","","Orden de Compra","black","","",150,30,0,0);
        $css->CrearInputText("TxtOrdenSalida","text","","","Orden de Salida","black","","",150,30,0,0);
        print("<br>");
        $css->CrearTextArea("TxtObservacionesFactura","","","Observaciones para esta Factura","black","","",300,100,0,0);
        print("<br>");
        $css->CrearBotonConfirmado("BtnGenerarFactura","Guardar");
        print("</td>");
        $css->CierraFilaTabla();

        $css->CerrarTabla();
        $css->CerrarForm();
    }


    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->Footer();
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    print("</body></html>");
    ob_end_flush();
?>