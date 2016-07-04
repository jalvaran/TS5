<?php 
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
	if(!empty($_REQUEST['TxtAsociarRemision'])){
		
		$idRemision=$_REQUEST['TxtAsociarRemision'];
	}

	
print("<html>");
print("<head>");
$css =  new CssIni("Comprobantes Ingreso");

print("</head>");
print("<body>");
    $obVenta = new ProcesoVenta($idUser);
    include_once("procesadores/procesaCompIngreso.php");
    $myPage="ComprobantesIngreso.php";
    $css->CabeceraIni("Registrar Ingreso"); //Inicia la cabecera de la pagina
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink($myPage, "../images/ingreso.jpg", "_self",200,200);
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    /*
     * Dibujamos el formulario para seleccionar los datos del ingreso
     * 
     */
    if(!empty($_REQUEST["TxtidIngreso"])){
        $RutaPrintIngreso="../tcpdf/examples/imprimiringreso.php?ImgPrintIngreso=".$_REQUEST["TxtidIngreso"];			
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Comprobante de Ingreso Creado Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Comprobante de Ingreso No. $_REQUEST[TxtidIngreso]</a>",16);
        $css->CerrarTabla();
    }
            
    $css->CrearNotificacionAzul("Ingrese los datos para realizar el movimiento", 16);
    $css->CrearForm2("FrmIngresos", $myPage, "post", "_self");
    
    $css->CrearTabla();
        $css->FilaTabla(14);
        $css->ColTabla("<strong>Fecha</strong>", 1);
        $css->ColTabla("<strong>Cuenta Ingreso</strong>", 1);
        $css->ColTabla("<strong>Centro de Costo</strong>", 1);
        $css->ColTabla("<strong>Tercero que Suministra</strong>", 1);
        
        $css->CierraFilaTabla();
        $css->FilaTabla(14);
        print("<td>");
        $css->CrearInputText("TxtFecha", "text", "", date("Y-m-d"), "Fecha", "Fecha", "", "", 100, 30, 0, 1);
        
        print("</td>");
        print("<td>");
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
        print("</td>");
        print("<td>");
        $css->CrearSelect("CmbCentroCostos", "");
        $Consulta=$obVenta->ConsultarTabla("centrocosto", "");
            if(mysql_num_rows($Consulta)){
            while($DatosCentroCosto=  mysql_fetch_array($Consulta)){
                $css->CrearOptionSelect($DatosCentroCosto["ID"], $DatosCentroCosto["Nombre"], 0);
            }
            }else{
                print("<script>alert('No hay centros de costo, debe crear al menos uno')</script>");
            }
        $css->CerrarSelect();
        print("</td>");
        print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el tercero";
            $css->CrearSelectChosen("TxtTercero", $VarSelect);

            $sql="SELECT * FROM proveedores";
            $Consulta=$obVenta->Query($sql);
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["idProveedores"], "$DatosProveedores[RazonSocial] $DatosProveedores[Num_Identificacion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(14);
        print("<td colspan='2' style='text-align:center'>");
        $css->CrearTextArea("TxtConcepto", "Concepto:<br>", "", "Concepto", "black", "", "", 200, 80, 0, 1);
        print("</td>");
        print("<td colspan='2' style='text-align:center'>");
        $css->CrearInputNumber("TxtTotal", "Number", "Total:<br>", "", "Total", "Black", "", "", 120, 30, 0, 1, 1, "", 1);
        print("<br>");
        $css->CrearBotonConfirmado("BtnGuardarIngreso", "Guardar");
        print("</td>");
        
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>