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
/////////////Obtengo datos necesarios para registrar el cierre
////////////////////////////////////////////


$NombreUsuario="$_SESSION[nombre] $_SESSION[apellido]";
$idUsuario=$_SESSION["idUser"];
$fecha=date("Y-m-d");
$hora=date("H:i:s");

////////////////////////////////////////////
/////////////Me conecto a la db
////////////////////////////////////////////

$con=mysql_connect($host,$user,$pw) or die("problemas con el servidor");
mysql_select_db($db,$con) or die("la base de datos no abre");
////////////////////////////////////////////
/////////////Obtengo valores de la cotizacion
////////////////////////////////////////////
			
		  $sel1=mysql_query("SELECT SUM(TotalVenta) as TotalVentas, SUM(TotalCosto) as TotalCostos, SUM(Descuentos) as Descuentos , SUM(Impuestos) as Impuestos
		   FROM ventas WHERE CerradoDiario = '' AND Usuarios_idUsuarios='$idUsuario' AND TipoVenta='Contado'",$con) or die("problemas con la consulta a la tabla Ventas .".mysql_error());
		 
		  $Sumas=mysql_fetch_array($sel1);	
		  $TotalVentas1= $Sumas["TotalVentas"];
		  $TotalVentas=number_format($Sumas["TotalVentas"]);
		  $TotalCostos=$Sumas["TotalCostos"];
		  $Descuentos=$Sumas["Descuentos"];
		  $Impuestos=$Sumas["Impuestos"];
		  
		  $sel1=mysql_query("SELECT SUM(TotalVenta) as TotalVentas, SUM(TotalCosto) as TotalCostos, SUM(Descuentos) as Descuentos , SUM(Impuestos) as Impuestos
		   FROM ventas WHERE CerradoDiario = '' AND Usuarios_idUsuarios='$idUsuario' AND TipoVenta='Credito'",$con) or die("problemas con la consulta a la tabla Ventas .".mysql_error());
		 
		 
		 $Sumas=mysql_fetch_array($sel1);	
		  
		  $TotalVentasC=number_format($Sumas["TotalVentas"]);
		  $TotalCostos=number_format($TotalCostos+$Sumas["TotalCostos"]);
		  $Descuentos=number_format($Descuentos+$Sumas["Descuentos"]);
		  $Impuestos=number_format($Impuestos+$Sumas["Impuestos"]);
		  
		  $sel1=mysql_query("SELECT SUM(Total) as Abonos FROM ingresos WHERE CerradoDiario = '' AND Usuarios_idUsuarios='$idUsuario' ",$con) or die("problemas con la consulta a la tabla Ventas .".mysql_error());
		 
		 
		 $Sumas=mysql_fetch_array($sel1);
		  $TotalAbonos=$Sumas["Abonos"];
		  
		  
		  //echo("$TotalVentas, $TotalCostos, $Descuentos, $Impuestos");
	   $sel1=mysql_query("SELECT SUM(Valor) as TotalEgresos FROM egresos WHERE CerradoDiario = '' AND Usuario_idUsuario='$idUsuario' AND PagoProg<>'Programado'",$con) 
	   or die("problemas con la consulta a la tabla Ventas .".mysql_error());
		 
		  $Sumas=mysql_fetch_array($sel1);	
		  $TotalEgresos1=$Sumas["TotalEgresos"];
		  $TotalEgresos=number_format($Sumas["TotalEgresos"]);
		  
		  
		  
		  		  		  
		  $nombre_file="Relacion".$fecha."_".$hora;
		  
		  


$sql = " UPDATE ventas SET
				CerradoDiario = 'SI',
		  		FechaCierreDiario = '$fecha',
				HoraCierreDiario='$hora',
				UsuarioCierreDiario='$NombreUsuario'
				
		WHERE CerradoDiario = '' AND Usuarios_idUsuarios='$idUsuario'";
		
$r = mysql_query($sql,$con) or die("No se actualizo la tabla Ventas .".mysql_error());	 

$sql = " UPDATE egresos SET
				CerradoDiario = 'SI',
		  		FechaCierreDiario = '$fecha',
				HoraCierreDiario='$hora',
				UsuarioCierreDiario='$NombreUsuario'
				
		WHERE CerradoDiario = '' AND Usuario_idUsuario='$idUsuario'";
		
$r = mysql_query($sql,$con) or die("No se actualizo la tabla egresos .".mysql_error());	 

$sql = " UPDATE ingresos SET
				CerradoDiario = 'SI',
		  		FechaCierreDiario = '$fecha',
				HoraCierreDiario='$hora',
				UsuarioCierreDiario='$NombreUsuario'
				
		WHERE CerradoDiario = '' AND Usuarios_idUsuarios='$idUsuario'";
		
$r = mysql_query($sql,$con) or die("No se actualizo la tabla ingresos .".mysql_error());	 


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
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">$fecha</span></div>
<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:16px;text-align:left;z-index:2;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:13px;"><strong><em>Relacion de Ventas $fecha $hora
</em></strong></span></div>
<div id="wb_Text2" style="position:absolute;left:37px;top:106px;width:150px;height:16px;z-index:4;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;"><strong><em>Reporte realizado por:</em></strong></span></div>
<div id="wb_Text2" style="position:absolute;left:37px;top:106px;width:150px;height:16px;z-index:4;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;"><strong><em>$NombreUsuario</em></strong></span></div>



<hr id="Line3" style="margin:0;padding:0;position:absolute;left:0px;top:219px;width:625px;height:2px;z-index:9;">
</div>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


// NON-BREAKING ROWS (nobr="true")

$SaldoCaja=$TotalVentas1-$TotalEgresos1+$TotalAbonos;
$SaldoCaja=number_format($SaldoCaja);
$TotalAbonos=number_format($TotalAbonos);	  
$tbl = <<<EOD


<table border="1"  cellpadding="1" cellspacing="1" align="center" style="border-left: 3px solid #000099;
		border-right: 3px solid #000099;
		border-top: 3px solid #000099;
		border-bottom: 3px solid #000099;">
  

 <tr nobr="true">
  <th style= "border: 2px solid #000099;" ><h3>Total Ventas</h3></th><th style= "border: 2px solid #000099;" ><h3>Total Costos</h3></th>
  <th  style= "border: 2px solid #000099;"><h3>Total Descuentos</h3></th><th style= "border: 2px solid #000099;"><h3>Total Impuestos</h3></th>
  <th style= "border: 2px solid #000099;"><h3>Total Egresos</h3></th>
 </tr>
 
 <tr nobr="true">
  <th style= "border: 2px solid #000099;" ><h3>$TotalVentas</h3></th><th style= "border: 2px solid #000099;" ><h3>$TotalCostos</h3></th>
  <th  style= "border: 2px solid #000099;"><h3>$Descuentos</h3></th><th style= "border: 2px solid #000099;"><h3>$Impuestos</h3></th>
  <th style= "border: 2px solid #000099;"><h3>$TotalEgresos</h3></th>
 </tr>
 
 <tr nobr="true">
  <th colspan=4 style= "border: 2px solid #000099;" ><h3>Total Creditos</h3></th><th style= "border: 2px solid #000099;" ><h3>$TotalVentasC</h3></th>
  
 </tr>
 
 <tr nobr="true">
  <th colspan=4 style= "border: 2px solid #000099;" ><h3>Total Abonos</h3></th><th style= "border: 2px solid #000099;" ><h3>$TotalAbonos</h3></th>
  
 </tr>
 
 <tr nobr="true">
  <th colspan=4 style= "border: 2px solid #000099;" ><h3>Saldo en Caja</h3></th><th style= "border: 2px solid #000099;" ><h3>$SaldoCaja</h3></th>
  
 </tr>
 
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');



//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>