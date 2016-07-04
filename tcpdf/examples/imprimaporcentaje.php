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
$FechaIni = substr("$_POST[TxtFechaIni]", 6, 7)."-".substr("$_POST[TxtFechaIni]", 3, 2)."-".substr("$_POST[TxtFechaIni]", 0, 2);
$FechaFinal = substr("$_POST[TxtFechaFinal]", 6, 7)."-".substr("$_POST[TxtFechaFinal]", 3, 2)."-".substr("$_POST[TxtFechaFinal]", 0, 2);
$Porcentaje =$_POST["TxtProcentaje"]/100;

////////////////////////////////////////////
/////////////Me conecto a la db
////////////////////////////////////////////

$con=mysql_connect($host,$user,$pw) or die("problemas con el servidor");
mysql_select_db($db,$con) or die("la base de datos no abre");


		 
		  
		  $nombre_file=$fecha."_Reporte_Ventas";
		   
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
$pdf->SetTitle('Infome Ventas');
$pdf->SetSubject('Infome Ventas');
$pdf->SetKeywords('Techno Soluciones, PDF, Informe, CCTV, Alarmas, Computadores');

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

$pdf->SetFont('helvetica', '', 6);


///////////////////////////////////////////////////////
//////////////encabezado//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<hr id="Line1" style="margin:0;padding:0;position:absolute;left:0px;top:44px;width:625px;height:2px;z-index:1;">
<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Fecha: $fecha</span></div>

<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:10px;text-align:center;z-index:2;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>COMPROBANTE INFORME DE VENTAS
</em></strong></span><BR>
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>RESULTADOS ENTRE EL $FechaIni Y EL $FechaFinal
</em></strong></span><BR><BR>

EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

///////////////////////////////////////////////////////
//////////////tabla con los datos de ventas//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Total de Ventas:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    
	<th><h3>TipoVenta</h3></th>
	<th><h3>Total Items</h3></th>
    <th><h3>SubTotal</h3></th>
	<th><h3>IVA</h3></th>
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

if(isset($_POST["BtnVistaPrevia"])){
	
	
	
	$sel1=mysql_query("SELECT TipoVenta as TipoVenta, SUM((TotalVenta-Impuestos)*$Porcentaje) as Subtotal, ROUND(SUM(Impuestos*$Porcentaje)) as IVA, ROUND(SUM(TotalVenta*$Porcentaje)) as Total, ROUND(SUM(Cantidad*$Porcentaje)) as Items FROM ventas
	WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
	GROUP BY TipoVenta",$con) or die("problemas con la consulta a ventas".mysql_error());
}

if(isset($_POST["BtnAplicarP"])){
	
	mysql_query("UPDATE ventas SET TotalVenta=(ROUND(TotalVenta*$Porcentaje)), Impuestos=(ROUND(Impuestos*$Porcentaje)), Descuentos= (ROUND(Descuentos*$Porcentaje))
	WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal'",$con) or die("problemas al actualizar la tabla ventas".mysql_error());
	
	$sel1=mysql_query("SELECT Usuarios_idUsuarios as IdUsuarios, TipoVenta as TipoVenta, SUM(TotalVenta-Impuestos) as Subtotal, SUM(Impuestos) as IVA, SUM(TotalVenta) as Total, SUM(Cantidad) as Items FROM ventas
	WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
	GROUP BY TipoVenta",$con) or die("problemas con la consulta a ventas".mysql_error());
	
}


	

if(mysql_num_rows($sel1)){
	$Subtotal=0;
	$TotalIVA=0;
	$TotalVentas=0;
	$TotalItems=0;
	
	$i=0;
	while($DatosVentas=mysql_fetch_array($sel1)){
			
		$SubtotalUser=number_format($DatosVentas["Subtotal"]);
		$IVA=number_format($DatosVentas["IVA"]);
		$Total=number_format($DatosVentas["Total"]);
		$Items=number_format($DatosVentas["Items"]);
		$TipoVenta=$DatosVentas["TipoVenta"];
		
		$Subtotal=$Subtotal+$DatosVentas["Subtotal"];
		$TotalIVA=$TotalIVA+$DatosVentas["IVA"];
		$TotalVentas=$TotalVentas+$DatosVentas["Total"];
		$TotalItems=$TotalItems+$DatosVentas["Items"];
		//$idUser=$DatosVentas["IdUsuarios"];
		
		
		$tbl = <<<EOD

<table border="1" cellpadding="2"  align="center">
 <tr>
 
  <td>$TipoVenta</td>
  <td>$Items</td>
  <td>$SubtotalUser</td>
  <td>$IVA</td>
  <td>$Total</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	$TotalItems=number_format($TotalItems);
	$Subtotal=number_format($Subtotal);
	$TotalIVA=number_format($TotalIVA);
	$TotalVentas=number_format($TotalVentas);
	$tbl = <<<EOD

<table border="1" cellspacing="2" align="center">
 <tr>
  <td align="RIGHT"><h3>SUMATORIA</h3></td>
 
  <td><h3>$TotalItems</h3></td>
  <td><h3>$Subtotal</h3></td>
  <td><h3>$TotalIVA</h3></td>
  <td><h3>$TotalVentas</h3></td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}



////////////////////////////////////////////////////////////////////////////////
/////////////////////////FACTURAS NUMERACION////////////////////////////
////////////////////////////////////////////////////////////////////////////////

$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Informe de Numeracion Facturas:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Factura Inicial</h3></th>
	<th><h3>Factura Final</h3></th>
    <th><h3>Total Clientes</h3></th>
	
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT MAX(idFacturas) as MaxFact, MIN(idFacturas) as MinFact, COUNT(idFacturas) as TotalFacts FROM facturas
	WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal'",$con) or die("problemas con la consulta a numeracion de facturas".mysql_error());


while($DatosNumFact=mysql_fetch_array($sel1)){
	$MinFact=$DatosNumFact["MinFact"];
	$MaxFact=$DatosNumFact["MaxFact"];
	$TotalFacts=$MaxFact-$MinFact+1;
	
	
	
$tbl = <<<EOD

<table border="1"  cellpadding="2" align="center">
 <tr>
  <td>$MinFact</td>
  <td>$MaxFact</td>
  <td>$TotalFacts</td>
 
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}


//$pdf->AddPage();

////////////////////////////////////////////////////////////////////////////////////7
//////////////tabla con los datos de ventas DISCRIMINADAS POR FECHAS//////////////////
//////////////////////////////////////////////////////////////////////////////////77


$tbl = <<<EOD


<br><br><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Total de Ventas Discriminadas por Fecha:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    
	<th><h3>Fecha</h3></th>
	<th><h3>Total Items</h3></th>
    <th><h3>SubTotal</h3></th>
	<th><h3>IVA</h3></th>
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

if(isset($_POST["BtnVistaPrevia"])){
	
	
	
	$sel1=mysql_query("SELECT Fecha as FechaVenta, SUM((TotalVenta-Impuestos)*$Porcentaje) as Subtotal, ROUND(SUM(Impuestos*$Porcentaje)) as IVA, ROUND(SUM(TotalVenta*$Porcentaje)) as Total, ROUND(SUM(Cantidad*$Porcentaje)) as Items FROM ventas
	WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
	GROUP BY Fecha",$con) or die("problemas con la consulta a ventas".mysql_error());
}

if(isset($_POST["BtnAplicarP"])){

	
	$sel1=mysql_query("SELECT Fecha as FechaVenta, TipoVenta as TipoVenta, SUM(TotalVenta-Impuestos) as Subtotal, SUM(Impuestos) as IVA, SUM(TotalVenta) as Total, SUM(Cantidad) as Items FROM ventas
	WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
	GROUP BY Fecha",$con) or die("problemas con la consulta a ventas".mysql_error());
	
}


	

if(mysql_num_rows($sel1)){
	$Subtotal=0;
	$TotalIVA=0;
	$TotalVentas=0;
	$TotalItems=0;
	
	$i=0;
	while($DatosVentas=mysql_fetch_array($sel1)){
			
		$SubtotalUser=number_format($DatosVentas["Subtotal"]);
		$IVA=number_format($DatosVentas["IVA"]);
		$Total=number_format($DatosVentas["Total"]);
		$Items=number_format($DatosVentas["Items"]);
		//$TipoVenta=$DatosVentas["TipoVenta"];
		
		$Subtotal=$Subtotal+$DatosVentas["Subtotal"];
		$TotalIVA=$TotalIVA+$DatosVentas["IVA"];
		$TotalVentas=$TotalVentas+$DatosVentas["Total"];
		$TotalItems=$TotalItems+$DatosVentas["Items"];
		$FechaVenta=$DatosVentas["FechaVenta"];
		
		
		$tbl = <<<EOD

<table border="1" cellpadding="2"  align="center">
 <tr>
 
  <td>$FechaVenta</td>
  <td>$Items</td>
  <td>$SubtotalUser</td>
  <td>$IVA</td>
  <td>$Total</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	$TotalItems=number_format($TotalItems);
	$Subtotal=number_format($Subtotal);
	$TotalIVA=number_format($TotalIVA);
	$TotalVentas=number_format($TotalVentas);
	$tbl = <<<EOD

<table border="1" cellspacing="2" align="center">
 <tr>
  <td align="RIGHT"><h3>SUMATORIA</h3></td>
 
  <td><h3>$TotalItems</h3></td>
  <td><h3>$Subtotal</h3></td>
  <td><h3>$TotalIVA</h3></td>
  <td><h3>$TotalVentas</h3></td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}


 
//$pdf->writeHTML($tab, false, false, false, false, '');
//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>