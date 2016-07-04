<?php

require_once('tcpdf_include.php');
include("conexion.php");
//error_reporting(0);
//include("../../classes_servi/CreaTablasMysqlVender.php");
////////////////////////////////////////////
/////////////Verifico que haya una sesion activa
////////////////////////////////////////////
session_start();
if(!isset($_SESSION["username"]))
   header("Location: index.php");

////////////////////////////////////////////
/////////////Obtengo datos necesarios para registrar el cierre
////////////////////////////////////////////


$NombreUsuario="$_SESSION[nombre] $_SESSION[apellido]";
$idUsuario=$_SESSION["idUser"];
$fecha=date("Y-m-d");
$hora=date("H:i:s");

$con=mysql_connect($host,$user,$pw) or die("problemas con el servidor");
mysql_select_db($db,$con) or die("la base de datos no abre");


if(!empty($_REQUEST['idFacturasAbonos'])){
	$idFacturasAbonos=$_REQUEST['idFacturasAbonos'];
	$sql="SELECT * FROM facturas_abonos fa INNER JOIN facturas f ON fa.Facturas_idFacturas=f.idFacturas WHERE fa.idFacturasAbonos='$idFacturasAbonos'";
	$datosAbonos=mysql_query($sql,$con) or die('no se pudo obtener los datos de la factura: ' . mysql_error());
	$datosAbonos=mysql_fetch_array($datosAbonos);
	$idFactura=$datosAbonos["Facturas_idFacturas"];
	$Monto=$datosAbonos["Monto"];
	$Saldo=$datosAbonos["SaldoFact"];
	$idCliente=$datosAbonos["Clientes_idClientes"];
	$NumFactura=$datosAbonos["OSalida"];
}


if(!empty($_POST['idFactura'])){
	$idFactura=$_POST["idFactura"];
	$Monto=$_POST["TxtAbono"];
	$Saldo=$_POST["TxtSaldo"];
	$Saldo=$Saldo-$Monto;
	$sql="SELECT * FROM facturas WHERE idFacturas='$idFactura'";
	$datos=mysql_query($sql,$con) or die('no se pudo obtener los datos de la factura: ' . mysql_error());
	$datos=mysql_fetch_array($datos);
	$idCliente=$datos["Clientes_idClientes"];
	$NumFactura=$datos["OSalida"];
}


////////////////////////////////////////////
/////////////Me conecto a la db
////////////////////////////////////////////


$sql="SELECT * FROM clientes WHERE idClientes='$idCliente'";
$datos=mysql_query($sql,$con) or die('no se pudo obtener los datos del cliente: ' . mysql_error());
$DatosCliente=mysql_fetch_array($datos);
$RazonSocial=$DatosCliente["RazonSocial"];

//////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////		 
		   
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
		//$img_file = K_PATH_IMAGES.'tsfondo.jpg';
		//$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Julian Andres Alvaran Valencia');
$pdf->SetTitle('Relacion TS');
$pdf->SetSubject('Relacion');
$pdf->SetKeywords('Techno Soluciones, PDF, Relacion, CCTV, Alarmas, Computadores');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
//$pdf->SetFont('helvetica', 'B', 16);

// add a page
$pdf->AddPage();

//$pdf->Write(0, 'Taller industrial Servi Torno tiene el agrado de cotizarle los siguientes servicios:', '', 0, 'L', true, 0, false, false, 0);

//$pdf->SetFont('helvetica', '', 6);

///////////////////////////////////////////////////////
//////////////encabezado//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<hr id="Line1" style="margin:0;padding:0;position:absolute;left:0px;top:44px;width:625px;height:2px;z-index:1;">
<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Comprobante de Abono</span></div><br>
<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Cliente: $RazonSocial</span></div>
<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:16px;text-align:left;z-index:2;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:13px;"><strong><em>El dia $fecha siendo las $hora se recibe un abono de la factura $NumFactura con numero de verificacion $idFactura por valor de: $Monto
, el nuevo saldo es: $Saldo 
</em></strong></span></div>
<div id="wb_Text2" style="position:absolute;left:37px;top:106px;width:150px;height:16px;z-index:4;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;"><strong><em>Abono recibido por:</em></strong></span></div>
<div id="wb_Text2" style="position:absolute;left:37px;top:106px;width:150px;height:16px;z-index:4;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;"><strong><em>$NombreUsuario</em></strong></span></div>



<hr id="Line3" style="margin:0;padding:0;position:absolute;left:0px;top:219px;width:625px;height:2px;z-index:9;">
</div>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


//Close and output PDF document
$pdf->Output('Comprobante abono'.'.pdf', 'I');


///////////////////////////////////////////
/////////////////////IMPRESORA POS


if(($handle = @fopen($COMPrinter, "w")) === FALSE){
        die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
    }



$con=mysql_connect($host,$user,$pw) or die("problemas con el servidor");
mysql_select_db($db,$con) or die("la base de datos no abre");

$sql="SELECT * FROM empresapro WHERE idEmpresaPro='1'";
$DatosEmpresa=mysql_query($sql,$con) or die('no se pudo obtener los datos de la empresa: ' . mysql_error());

$DatosEmpresa=mysql_fetch_array($DatosEmpresa);
$RazonSocial=$DatosEmpresa["RazonSocial"];
$NIT=$DatosEmpresa["NIT"];
$Direccion=$DatosEmpresa["Direccion"];
$Ciudad=$DatosEmpresa["Ciudad"];
$ResolucionDian=$DatosEmpresa["ResolucionDian"];
$Telefono=$DatosEmpresa["Telefono"];

for($i=1;$i<=2;$i++){
	
fwrite($handle,chr(27). chr(64));//REINICIO
//fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
fwrite($handle,"=================================");
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
fwrite($handle,"=================================");
fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

		fwrite($handle,"Factura No: ".$NumFactura."..");
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA	
		fwrite($handle,"Verificacion: ".$idFactura."..");
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA		
		fwrite($handle,"Abono: ".number_format($Monto)."..");
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Saldo: ".number_format($Saldo)."..");
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Cliente: ".$DatosCliente["RazonSocial"]);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
			


fwrite($handle, chr(27). chr(100). chr(1));//salto de linea


fwrite($handle,$Fecha);
fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
fwrite($handle,"*..COMPROBANTE DE ABONO FECHA: $fecha");
fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

fwrite($handle,"***Recibe: $NombreUsuario");

fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

//fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
//fwrite($handle, chr(27). chr(100). chr(0));
//fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
fwrite($handle, chr(27). chr(100). chr(1));
fwrite($handle, chr(27). chr(100). chr(1));
fwrite($handle,"***Comprobante impreso por SoftConTech***");
fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
fwrite($handle,"Software diseniado por Techno Soluciones, 3177740609, www.technosoluciones.com");
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
$salida = shell_exec("lpr $COMPrinter");

//============================================================+
// END OF FILE
//============================================================+
?>