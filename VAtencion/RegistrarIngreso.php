<?php 
ob_start();
session_start();
include_once("../modelo/php_conexion.php");
include_once("css_construct.php");
if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}
$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	
$idRemision="";
//////Si recibo un cliente
	if(!empty($_REQUEST['idFactura'])){
		
		$idFactura=$_REQUEST['idFactura'];
	}

	
print("<html>");
print("<head>");
$css =  new CssIni("Registrar Ingreso");

print("</head>");
print("<body>");
    $obVenta = new ProcesoVenta($idUser);
    include_once("procesadores/procesaIngreso.php");
    $myPage="RegistrarIngreso.php";
    $css->CabeceraIni("Registrar Ingreso"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
    $css->CrearForm("FrmBuscarFactura",$myPage,"post","_self");
        $css->CrearInputText("TxtBuscarFactura","text","Buscar Factura: ","","Digite el numero de una Factura","white","","",300,30,0,0);
        $css->CrearBoton("BtnBuscarFactura", "Buscar");
    $css->CerrarForm();
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink($myPage, "../images/pagos.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    if(!empty($_REQUEST["TxtidIngreso"])){
        $RutaPrintIngreso="../tcpdf/examples/imprimiringreso.php?ImgPrintIngreso=".$_REQUEST["TxtidIngreso"];			
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Comprobante de Ingreso Creado Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Comprobante de Ingreso No. $_REQUEST[TxtidIngreso]</a>",16);
        $css->CerrarTabla();
    }
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    ////////////////////////////////////Si se solicita buscar una Remision
    /////
    /////
    if(!empty($_REQUEST["TxtBuscarFactura"])){

        $Key=$_REQUEST["TxtBuscarFactura"];
        $pa=mysql_query("SELECT * FROM cartera c INNER JOIN facturas fac ON c.Facturas_idFacturas = fac.idFacturas "
                . "WHERE c.RazonSocial LIKE '%$Key%' OR fac.NumeroFactura = '$Key' ORDER BY fac.idFacturas DESC LIMIT 20") or die(mysql_error());
        if(mysql_num_rows($pa)){
            print("<br>");
            $css->CrearTabla();
            $css->FilaTabla(18);
            $css->ColTabla("Facturas Encontradas en cartera:",4);
            $css->CierraFilaTabla();

            $css->FilaTabla(18);
                $css->ColTabla("Factura",1);
                $css->ColTabla('Fecha Ingreso',1);
                $css->ColTabla('Fecha Vencimiento',1);
                $css->ColTabla('Cliente',1);
                $css->ColTabla('Total Factura',1);
                $css->ColTabla('Total Abonos',1);
                $css->ColTabla('Saldo',1);
                $css->ColTabla('Seleccionar',1);
                
            $css->CierraFilaTabla();
            while($DatosFactura=mysql_fetch_array($pa)){
                $css->FilaTabla(14);
                $css->ColTabla($DatosFactura['Prefijo'].$DatosFactura['NumeroFactura'],1);
                $css->ColTabla($DatosFactura['FechaIngreso'],1);
                $css->ColTabla($DatosFactura['FechaVencimiento'],1);
                $css->ColTabla($DatosFactura['RazonSocial'],1);
                $css->ColTabla($DatosFactura['TotalFactura'],1);
                $css->ColTabla($DatosFactura['TotalAbonos'],1);
                $css->ColTabla($DatosFactura['Saldo'],1);
               
               
                $css->ColTablaVar($myPage,"idFactura",$DatosFactura['idFacturas'],"","Seleccionar Factura");
                $css->CierraFilaTabla();
            }

            $css->CerrarTabla(); 
        }else{
                print("<h3>No hay resultados</h3>");
        }

    }
					
    //////////////////////////Se dibujan los campos para crear la remision
    /////
    /////
    if(!empty($idFactura)){
        
        $css->CrearTabla();
            $DatosCartera=$obVenta->DevuelveValores("cartera", "Facturas_idFacturas", $idFactura);
            $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
                if(empty($DatosCartera)){
                    $css->CrearNotificacionRoja("Error Esta factura no está en cartera", 16);
                    exit();
                }
            $css->CrearNotificacionAzul("Datos de la Factura", 18);
            $css->FilaTabla(14);
            
            $css->ColTabla("<strong>Cliente</strong>", 1);
            $css->ColTabla("<strong>Factura</strong>", 1);
            $css->ColTabla("<strong>Fecha de Creacion</strong>", 1);
            $css->ColTabla("<strong>Fecha de Vencimiento</strong>", 1);
            $css->ColTabla("<strong>Total Factura</strong>", 1);
            $css->ColTabla("<strong>Total Abonos</strong>", 1);
            $css->ColTabla("<strong>Saldo</strong>", 1);
            
            $css->CierraFilaTabla();
            
            $css->FilaTabla(14);
            
            $css->ColTabla($DatosCartera["RazonSocial"], 1);
            $css->ColTabla($DatosFactura["Prefijo"].$DatosFactura["NumeroFactura"], 1);
            $css->ColTabla($DatosFactura["Fecha"], 1);
            $css->ColTabla($DatosCartera["FechaVencimiento"], 1);
            $css->ColTabla($DatosCartera["TotalFactura"], 1);
            $css->ColTabla($DatosCartera["TotalAbonos"], 1);
            $css->ColTabla($DatosCartera["Saldo"], 1);
            
            $css->CierraFilaTabla();
            
        $css->CerrarTabla();
        $css->CrearForm2("FrmRegistraPago", $myPage, "post", "_self");
        $css->CrearInputText("TxtIdFactura", "hidden", "", $DatosFactura["idFacturas"], "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        $css->CrearNotificacionNaranja("Datos del Pago", 16);
        print("<td style='text-align:center'>");
        $css->CrearInputText("TxtFecha", "text", "Fecha de Pago: <br>", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
        
        print("<br><strong>Cuenta donde Ingresa el Dinero </strong><br>");
        $DatosSelect["Nombre"]="CmbCuentaDestino";
        $DatosSelect["Evento"]="";
        $DatosSelect["Funcion"]="";
        $DatosSelect["Required"]=1;
        $css->CrearSelect2($DatosSelect);
        $css->CrearOptionSelect("", "SELECCIONE UNA CUENTA", 0);
        $Consulta=$obVenta->ConsultarTabla("cuentasfrecuentes", "WHERE ClaseCuenta='ACTIVOS'");
        while($DatosCuentas=$obVenta->FetchArray($Consulta)){
            $css->CrearOptionSelect($DatosCuentas["CuentaPUC"], $DatosCuentas["Nombre"], 0);
        }
        
        $css->CerrarSelect();
        print("<br>");
        
        print("<br><strong>Te Realizaron Retenciones? </strong><br>");
        $css->CrearSelect("CmbRetenciones", "MuestraOculta('DivRetenciones')");
        $css->CrearOptionSelect("NO", "NO", 1);
        $css->CrearOptionSelect("SI", "SI", 0);
        $css->CerrarSelect();
        print("<br>");
        $css->CrearDiv("DivRetenciones", "", "center", 0, 1);
        
            $css->CrearInputNumber("TxtRetefuente", "number", "Retefuente:<br>", 0, "", "black", "onkeyup", "CalculeTotalPagoIngreso()", 150, 30, 0, 1, 0, "", "any");
            print("<br>");
            $css->CrearInputNumber("TxtReteICA", "number", "Rete-ICA:<br>", 0, "", "black", "onkeyup", "CalculeTotalPagoIngreso()", 150, 30, 0, 1, 0, "", "any");
            print("<br>");
            $css->CrearInputNumber("TxtReteIVA", "number", "ReteIVA:<br>", 0, "", "black", "onkeyup", "CalculeTotalPagoIngreso()", 150, 30, 0, 1, 0, "", "any");
            print("<br>");
        $css->CerrarDiv();
        print("<br>");
        $css->CrearInputNumber("TxtPagoH", "hidden", "", $DatosCartera["Saldo"], "", "", "","", "", 30,1, 1, 1, 1, "", "any");
        $css->CrearInputNumber("TxtPago", "number", "Total Pago: <br>", $DatosCartera["Saldo"], "", "black", "","", 200,30, 0, 0, 1, $DatosCartera["Saldo"], 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnGuardarPago","Guardar");	
            
        print("</td>");
        
        $css->CerrarTabla();
        $css->CerrarForm();
        
        
    }else{
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Por favor busque y asocie una factura",16);
        $css->CerrarTabla();
    }
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>