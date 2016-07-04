<?php

require_once('tcpdf_include.php');
include("conexion.php");
////////////////////////////////////////////
/////////////Verifico que haya una sesion activa
////////////////////////////////////////////
session_start();
if(!isset($_SESSION["username"]))
   header("Location: index.php");

////////////////////////////////////////////
/////////////Obtengo el rango de fechas
////////////////////////////////////////////

$fecha=date("Y-m-d");
$FechaIni = substr("$_POST[TxtFechaIni]", 6, 7)."-".substr("$_POST[TxtFechaIni]", 3, 2)."-".substr("$_POST[TxtFechaIni]", 0, 2);;
$FechaFinal = substr("$_POST[TxtFechaFinal]", 6, 7)."-".substr("$_POST[TxtFechaFinal]", 3, 2)."-".substr("$_POST[TxtFechaFinal]", 0, 2);;

////////////////////////////////////////////
/////////////Me conecto a la db
////////////////////////////////////////////

$con=mysql_connect($host,$user,$pw) or die("problemas con el servidor");
mysql_select_db($db,$con) or die("la base de datos no abre");

////////////////////////////////////////////
/////////////Obtengo valores de egresos si es un reporte General
////////////////////////////////////////////

	
		 	  
		  $sel1=mysql_query("SELECT SUM(Total) as suma , SUM(IVA) as ivaegre FROM egresos WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal'",$con) or die("problemas con la consulta a egresos");
		  $sa=mysql_fetch_array($sel1);	
		  $TotalEgresos=$sa["suma"];
		  $TotalIVAEgresos=$sa["ivaegre"];
		  
		  $sel1=mysql_query("SELECT SUM(Total) as suma FROM ingresos WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal'",$con) or die("problemas con la consulta a ingresos");
		  $sa=mysql_fetch_array($sel1);	
		  $TotalIngresos=$sa["suma"];
		  $DifEgreIngre=$TotalIngresos-$TotalEgresos;
		 
		  $sel1=mysql_query("SELECT SUM(IVA) as suma FROM facturas fact INNER JOIN ingresos ing ON idFacturas=Facturas_idFacturas WHERE ing.Fecha >= '$FechaIni' AND ing.Fecha <= '$FechaFinal'",$con) or die("problemas con la consulta a ingresos");
		  $sa=mysql_fetch_array($sel1);	
		  $TotalIVAFacturado=$sa["suma"];
		  $DifIVA=$TotalIVAFacturado-$TotalIVAEgresos;
		  
		  //echo "El total de los Ingresos VS Egresos entre $FechaIni y $FechaFinal es: $TotalIngresos - $TotalEgresos = $DifEgreIngre";
		  
		  $sel1=mysql_query("SELECT SUM(Saldo) as suma FROM cartera WHERE FechaVencimiento >= '$FechaIni' AND FechaVencimiento <= '$FechaFinal'",$con) or die("problemas con la consulta a cartera");
		  $sa=mysql_fetch_array($sel1);	
		  $TotalCartera=$sa["suma"];
		  
		  
		  
		 // $DifCarteraCuentas=$TotalCartera-$TotalCuentasPorPagar;
		  
		  
		  $TotalGastos = $TotalEgresos;
		  $SuperTotalIng=$TotalIngresos + $TotalCartera;
		  
		  $DifIVA=number_format(round($DifIVA,2));
		  $TotalIVAFacturado=number_format(round($TotalIVAFacturado,2));
		  $TotalIVAEgresos=number_format(round($TotalIVAEgresos,2));
		  $TotalEgresos=number_format(round($TotalEgresos,2));
		  $TotalIngresos=number_format(round($TotalIngresos,2));
		  $DifEgreIngre=number_format(round($DifEgreIngre,2));
		  
		  $TotalCartera=number_format(round($TotalCartera,2));
		  //$TotalCuentasPorPagar=number_format(round($TotalCuentasPorPagar,2));
		  //$DifCarteraCuentas=number_format(round($DifCarteraCuentas,2));
		  $TotalGastos=number_format(round($TotalGastos,2));
		  $SuperTotalIng=number_format(round($SuperTotalIng,2));
		 
		  
		  $nombre_file=$fecha."_Balance";
		   
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
		$img_file = K_PATH_IMAGES.'tsfondo.jpg';
		$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
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
$pdf->SetTitle('Cotizacion TS');
$pdf->SetSubject('Cotizacion');
$pdf->SetKeywords('Techno Soluciones, PDF, cotizacion, CCTV, Alarmas, Computadores');

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
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Fecha: $fecha</span></div>

<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:10px;text-align:center;z-index:2;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>INFORME GENERAL POR RANGO DE FECHAS
</em></strong></span><BR>
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>RESULTADOS ENTRE EL $FechaIni Y EL $FechaFinal
</em></strong></span><BR><BR><BR><BR><BR>


<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:13px;"><strong><em>Total de ingresos: </em></strong></span><span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">$TotalIngresos</span></div>

<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:13px;"><strong><em>Total de egresos: </em></strong></span><span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">$TotalEgresos</span></div>

<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:13px;"><strong><em>Utilidad: </em></strong></span><span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">$DifEgreIngre</span></div>

<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:13px;"><strong><em>Total en cartera: </em></strong></span><span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">$TotalCartera</span></div>


<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:13px;"><strong><em>Total de IVA Facturado: </em></strong></span><span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;"></span>$TotalIVAFacturado</div>

<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:13px;"><strong><em>Total de IVA Pagado en Egresos: </em></strong></span><span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;"></span>$TotalIVAEgresos</div>

<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:13px;"><strong><em>IVA Factura - IVA Pagado en Egresos: </em></strong></span><span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;"></span>$DifIVA</div>

<BR><BR><BR><BR>

<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:8px;">Reporte Generado por SOFTCONTECH V1.0, Software Diseñado por TECHNO SOLUCIONES para SERVITORNO, www.technosoluciones.com, info@technosoluciones.com</div></span>

<hr id="Line3" style="margin:0;padding:0;position:absolute;left:0px;top:219px;width:625px;height:2px;z-index:9;">
</div>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>