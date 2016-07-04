<?php
ob_start();
session_start();
include_once("../modelo/php_conexion.php");
include_once("css_construct.php");
if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}
if ($_SESSION['tipouser']<>"administrador")
	{
	  exit("Usted No esta autorizado para ingresar a esta parte <a href='Menu.php' >Menu </a>");
	  
	}
$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	
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
    $obVenta = new ProcesoVenta($idUser);
    include_once("procesadores/procesaFacturarCoti.php");
    $myPage="FacturaCotizacion.php";
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
    $css->CrearImageLink("FactCoti.php", "../images/cotizacion.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    
        if(!empty($_REQUEST["TxtidFactura"])){
            
            $idFactura=$_REQUEST["TxtidFactura"];
            if($idFactura<>""){
                $RutaPrint="../tcpdf/examples/imprimirFactura.php?ImgPrintFactura=".$idFactura;
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
   										
   	
    //////////////////////////Se dibujan los campos de la cotizacion
    /////
    /////
    if(!empty($idCotizacion)){
        //print("<script>alert('entra')</script>");
        $DatosCotizacion=$obVenta->DevuelveValores("cotizacionesv5","ID",$idCotizacion);
        $idCliente=$DatosCotizacion["Clientes_idClientes"];
        $DatosCliente=$obVenta->DevuelveValores("clientes","idClientes",$idCliente);

            $css->CrearTabla();
           
            $css->FilaTabla(16);
            $css->ColTabla('COTIZACION:',1);
            $css->ColTabla($idCotizacion,1);
            $css->ColTabla('CLIENTE:',1);
            $css->ColTabla($DatosCliente["RazonSocial"],1);
            
            $css->CierraFilaTabla();
            $css->CerrarTabla();
            
            
			
    ///////////////////////////////////////////
    /////////////Visualizamos la COTIZACION
    ///
    ///
    ///
    $sql="SELECT * FROM cot_itemscotizaciones WHERE NumCotizacion='$idCotizacion'";
    $consulta=$obVenta->Query($sql);              

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
            $css->ColTabla($DatosItemsCotizacion["Descripcion"], 1);
            $DatosProducto=$obVenta->DevuelveValores($DatosItemsCotizacion["TablaOrigen"], "Referencia", $DatosItemsCotizacion["Referencia"]);
            print("<td>");
                $css->CrearForm("FormEditarCotizacion$idItem", $myPage, "post", "_self");
                $css->CrearInputText("TxtIdCotizacion", "hidden", "", $idCotizacion, "", "", "", "", "", "", 0, 0);
                $css->CrearInputText("TxtIdItemCotizacion", "hidden", "", $idItem, "", "", "", "", "", "", 0, 0);
                $css->CrearInputNumber("TxtValorUnitario", "number", "", $DatosItemsCotizacion["ValorUnitario"], "ValorUnitario", "black", "", "", 120, 30, 0, 1, $DatosProducto["CostoUnitario"], $DatosItemsCotizacion["ValorUnitario"]."0", "any");
                $css->CrearInputNumber("TxtCantidad", "number", "", $DatosItemsCotizacion["Cantidad"], "ValorUnitario", "black", "", "", 80, 30, 0, 1, 0.00001, "", "any");
                $css->CrearBotonVerde("BtnEditar", "E");
                $css->CerrarForm();
            print("</td>");
            
            
            $css->ColTabla($DatosItemsCotizacion["Subtotal"], 1);
            
            $css->ColTablaDel($myPage,"cot_itemscotizaciones","ID",$DatosItemsCotizacion['ID'],$idCotizacion);
            $css->CierraFilaTabla();
        }

        $css->CerrarTabla();
        /////////////////Mostramos Totales y Se crea el formulario para guardar la devolucion
        ////
        ////
        
        $Subtotal=$obVenta->Sume("cot_itemscotizaciones", "Subtotal", "WHERE NumCotizacion='$idCotizacion'");
        $IVA=$obVenta->Sume("cot_itemscotizaciones", "IVA", "WHERE NumCotizacion='$idCotizacion'");
        $Total=$obVenta->Sume("cot_itemscotizaciones", "Total", "WHERE NumCotizacion='$idCotizacion'");
        $css->CrearFormularioEvento("FormGeneraFactura", $myPage, "post", "_self","");
        $css->CrearInputText("TxtIdCotizacion","hidden","",$idCotizacion,"","black","","",150,30,0,0);
        $css->CrearInputText("TxtIdCliente","hidden","",$idCliente,"","black","","",150,30,0,0);      
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
        print("<br>");
        print("Resolucion:<br> ");
        $css->CrearSelect("CmbResolucion", "");
            $Consulta=$obVenta->ConsultarTabla("empresapro_resoluciones_facturacion", "WHERE Completada<>'SI'");
            if(mysql_num_rows($Consulta)){
            while($DatosResolucion=  mysql_fetch_array($Consulta)){
                $css->CrearOptionSelect($DatosResolucion["ID"], $DatosResolucion["NumResolucion"], 0);
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


    }else{
            $css->CrearTabla();
            $css->CrearFilaNotificacion("Por favor busque y asocie una cotizacion",16);
            $css->CerrarTabla();
    }
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->Footer();
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    print("</body></html>");
    ob_end_flush();
?>