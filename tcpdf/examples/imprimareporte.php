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

$pdf->SetFont('helvetica', '', 8);

///////////////////////////////////////////////////////
//////////////encabezado//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<hr id="Line1" style="margin:0;padding:0;position:absolute;left:0px;top:44px;width:625px;height:2px;z-index:1;">
<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Fecha: $fecha</span></div>

<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:10px;text-align:center;z-index:2;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>MOVIMIENTO DE CUENTAS
</em></strong></span><BR>
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>RESULTADOS ENTRE EL $FechaIni Y EL $FechaFinal
</em></strong></span><BR><BR>

EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

///////////////////////////////////////////////////////
//////////////tabla con los datos//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="4" align="center" >
  <tr style= "background-color:#FE642E; color: white;" > 
    <th><h3>Cuenta</h3></th>
    <th><h3>Nombre</h3></th>		
    <th><h3>Debito</h3></th>
	<th><h3>Credito</h3></th>
	<th><h3>Diferencia</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

$TotalDebitos=0;
$TotalCreditos=0;

$sel1=mysql_query("SELECT CuentaPUC as Cuenta, SUM(Debito) as SumDebito, SUM(Credito) as SumCredito FROM librodiario WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
GROUP BY CuentaPUC",$con) or die("problemas con la consulta".mysql_error());

if(mysql_num_rows($sel1)){
	
	$i=0;
	while($DatosLibro=mysql_fetch_array($sel1)){
		if($i==0){
			$back="#D8F0F1";
			$i=1;
		}else{
			$back="#ffffff";
			$i=0;
		}
		$Neto=$DatosLibro["SumDebito"]-$DatosLibro["SumCredito"];
		if($Neto>0){
			$TotalDebitos=$TotalDebitos+$Neto;
			$Debitos=number_format($Neto);
			
			$Creditos="";
		}else{
			$TotalCreditos=$TotalCreditos+($Neto*(-1));
			$Creditos=number_format($Neto*(-1));
			
			$Debitos="";
		}
		
		$Debitos=number_format($DatosLibro["SumDebito"]);
		$Creditos=number_format($DatosLibro["SumCredito"]);
		$Diferencia=number_format($DatosLibro["SumDebito"]-$DatosLibro["SumCredito"]);
		$Cuenta=$DatosLibro["Cuenta"];
		$reg=mysql_query("SELECT Nombre FROM subcuentas WHERE PUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center">
 <tr style= "background-color:$back;">
  <td>$DatosLibro[Cuenta]</td><td>$DatosCuentas[Nombre]</td>
  <td>$Debitos</td><td>$Creditos</td><td>$Diferencia</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	
}	

$sel1=mysql_query("SELECT SUM(Debito) as SumDebito, SUM(Credito) as SumCredito FROM librodiario WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' ",$con) 
or die("problemas con la consulta".mysql_error());

//$sel1=mysql_query("SELECT SUM(Neto) as Neto FROM librodiario WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
//GROUP BY substring(CuentaPUC,1,4)",$con) or die("problemas con la consulta".mysql_error());

$Totales=mysql_fetch_array($sel1);
$TotalDebito=number_format($Totales["SumDebito"]);
$TotalCredito=number_format($Totales["SumCredito"]);

$tbl = <<<EOD

<table border="1" cellpadding="2" cellspacing="2" align="center">
 <tr nobr="true" style= "background-color:#F6D7EC">
  
  
  <td colspan="2" align="rigth" ><h3>Totales</h3></td><td>$$TotalDebito</td><td>$$TotalCredito</td>
  
  
 </tr>
 </table>
 <br><br>
 
 
 <br>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');	


$pdf->AddPage();

///////////////////////////////////////////////////////
//////////////encabezado ESTADO DE RESULTADOS//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<hr id="Line1" style="margin:0;padding:0;position:absolute;left:0px;top:44px;width:625px;height:2px;z-index:1;">
<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Fecha: $fecha</span></div>

<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:10px;text-align:center;z-index:2;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>ESTADO DE RESULTADOS
</em></strong></span><BR>
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>FECHA DE CORTE $FechaFinal
</em></strong></span><BR><BR>

EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


///////////////////////////////////////////////////////
//////////////tabla con los datos de INGRESOS//////////////////
////////////////////////////////////////////////////////

$TotalIngresos=0;

$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center" >
  <tr style= "background-color:#3865EC; color: white;" > 
    <th colspan=3><h3>INGRESOS</h3></th>
    
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT substring(CuentaPUC,1,4) as Cuenta, SUM(Debito) as SumDebito, SUM(Credito) as SumCredito FROM librodiario 
WHERE (Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal') AND (Mayor='NO') AND  (substring(CuentaPUC,1,1) = 4)
GROUP BY substring(CuentaPUC,1,4)",$con) or die("problemas con la consulta".mysql_error());

if(mysql_num_rows($sel1)){
	
	$i=0;
	while($DatosLibro=mysql_fetch_array($sel1)){
		if($i==0){
			$back="#D8F0F1";
			$i=1;
		}else{
			$back="#ffffff";
			$i=0;
		}
		$Neto=($DatosLibro["SumDebito"]-$DatosLibro["SumCredito"])*(-1);
		$TotalIngresos=$TotalIngresos+$Neto;
		$NumberNeto=number_format($Neto);
		//$Debitos=number_format($DatosLibro["SumDebito"]);
		//$Creditos=number_format($DatosLibro["SumCredito"]);
		
		$Cuenta=$DatosLibro["Cuenta"];
		$reg=mysql_query("SELECT Nombre FROM cuentas WHERE idPUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 <tr style= "background-color:$back;">
  <td>$DatosCuentas[Nombre]</td>
  <td align="center">$NumberNeto</td><td> </td>
 </tr>
 
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	$NumberNeto=number_format($TotalIngresos);
	$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 
 <tr style= "background-color:#FFC17F;">
  <td colspan=2 align="rigth"><h4>Total Ingresos</h4></td>
  <td></td><td><h4>$NumberNeto </h4></td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}	



///////////////////////////////////////////////////////
//////////////tabla con los datos de Costos//////////////////
////////////////////////////////////////////////////////
$UtilidadNeta=0;
$UtilidadBruta=0;
$NumberUti=0;
$TotalCostos=0;

$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center" >
  <tr style= "background-color:#3865EC; color: white;" > 
    <th colspan=3><h3>COSTOS</h3></th>
    
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT substring(CuentaPUC,1,4) as Cuenta, SUM(Debito) as SumDebito, SUM(Credito) as SumCredito FROM librodiario 
WHERE (Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal') AND (Mayor='NO') AND  (substring(CuentaPUC,1,1) = 6)
GROUP BY substring(CuentaPUC,1,4)",$con) or die("problemas con la consulta".mysql_error());

if(mysql_num_rows($sel1)){
	
	$i=0;
	while($DatosLibro=mysql_fetch_array($sel1)){
		if($i==0){
			$back="#D8F0F1";
			$i=1;
		}else{
			$back="#ffffff";
			$i=0;
		}
		$Neto=($DatosLibro["SumDebito"]-$DatosLibro["SumCredito"]);
		$TotalCostos=$TotalCostos+$Neto;
		$NumberNeto=number_format($Neto);
		//$Debitos=number_format($DatosLibro["SumDebito"]);
		//$Creditos=number_format($DatosLibro["SumCredito"]);
		
		$Cuenta=$DatosLibro["Cuenta"];
		$reg=mysql_query("SELECT Nombre FROM cuentas WHERE idPUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 <tr style= "background-color:$back;">
  <td>$DatosCuentas[Nombre]</td>
  <td align="center">$NumberNeto</td><td> </td>
 </tr>
 
 </table>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');

}

/////////////////////////////////////////////////////////////
////////////UTILIDAD BRUTA////////////////////////////////////
/////////////////////////////////////////////////////////////

$UtilidadBruta=$TotalIngresos-$TotalCostos;
$NumberUti=number_format($UtilidadBruta);

	
	$NumberNeto=number_format($TotalCostos);
	$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 
 <tr style= "background-color:#FFC17F;">
  <td colspan=2 align="rigth"><h4>Total Costos</h4></td>
  <td> </td><td><h4>$NumberNeto</h4> </td>
 </tr>
 <tr > 
    <th></th><th></th><th></th>
    
  </tr >
 <tr style="background-color:#90FFB9; color: black;">
  <th colspan=2 align="rigth"><h4>UTILIDAD BRUTA</h4> </th>
  <td> </td><td><h4>$NumberUti </h4></td>
 </tr>
 <tr > 
    <th></th><th></th><th></th>
    
  </tr >
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}	


///////////////////////////////////////////////////////
//////////////tabla con los datos de GASTOS//////////////////
////////////////////////////////////////////////////////

$TotalGastos=0;

$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center" >
  <tr style= "background-color:#3865EC; color: white;" > 
    <th colspan=3><h3>GASTOS</h3></th>
    
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT substring(CuentaPUC,1,4) as Cuenta, SUM(Debito) as SumDebito, SUM(Credito) as SumCredito FROM librodiario 
WHERE (Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal') AND (Mayor='NO') AND  (substring(CuentaPUC,1,1) = 5)
GROUP BY substring(CuentaPUC,1,4)",$con) or die("problemas con la consulta".mysql_error());

if(mysql_num_rows($sel1)){
	
	$i=0;
	while($DatosLibro=mysql_fetch_array($sel1)){
		if($i==0){
			$back="#D8F0F1";
			$i=1;
		}else{
			$back="#ffffff";
			$i=0;
		}
		$Neto=($DatosLibro["SumDebito"]-$DatosLibro["SumCredito"]);
		$TotalGastos=$TotalGastos+$Neto;
		$NumberNeto=number_format($Neto);
		//$Debitos=number_format($DatosLibro["SumDebito"]);
		//$Creditos=number_format($DatosLibro["SumCredito"]);
		
		$Cuenta=$DatosLibro["Cuenta"];
		$reg=mysql_query("SELECT Nombre FROM cuentas WHERE idPUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 <tr style= "background-color:$back;">
  <td>$DatosCuentas[Nombre]</td>
  <td align="center">$NumberNeto</td><td> </td>
 </tr>
 
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	$NumberNeto=number_format($TotalGastos);
	$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 
 <tr style= "background-color:#FFC17F;">
  <td colspan=2 align="rigth"><h4>Total Gastos</h4></td>
  <td></td><td><h4>$NumberNeto </h4></td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
/////////////////////////////////////////////////////////////
////////////UTILIDAD NETA////////////////////////////////////
/////////////////////////////////////////////////////////////

$UtilidadNeta=$UtilidadBruta-$TotalGastos;
$NumberUti=number_format($UtilidadNeta);

	$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 
 
 <tr > 
    <th></th><th></th><th></th>
    
  </tr >
 <tr style="background-color:#90FFB9; color: black;">
  <th colspan=2 align="rigth"><h4>UTILIDAD NETA ANTES DE IMPUESTOS</h4> </th>
  <td> </td><td><h4>$NumberUti </h4></td>
 </tr>
 
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
	
}	


////////////////////////////////////////////////////////////////////
///////////////////BALANCE GENERAL/////////////////////////////////
//////////////////////////////////////////////////////////////////


$pdf->AddPage();

///////////////////////////////////////////////////////
//////////////encabezado BALANCE GENERAL//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<hr id="Line1" style="margin:0;padding:0;position:absolute;left:0px;top:44px;width:625px;height:2px;z-index:1;">
<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Fecha: $fecha</span></div>

<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:10px;text-align:center;z-index:2;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>BALANCE GENERAL
</em></strong></span><BR>
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>FECHA DE CORTE $FechaFinal
</em></strong></span><BR><BR><BR><BR><BR>

EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


///////////////////////////////////////////////////////
//////////////tabla con los datos de ACTIVOS//////////////////
////////////////////////////////////////////////////////

$TotalActivos=0;

$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center" >
  <tr style= "background-color:#3865EC; color: white;" > 
    <th colspan=3><h3>ACTIVOS</h3></th>
    
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT substring(CuentaPUC,1,4) as Cuenta, SUM(Debito) as SumDebito, SUM(Credito) as SumCredito FROM librodiario 
WHERE (Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal') AND (Mayor='NO') AND  (substring(CuentaPUC,1,1) = 1)
GROUP BY substring(CuentaPUC,1,4)",$con) or die("problemas con la consulta".mysql_error());

if(mysql_num_rows($sel1)){
	
	$i=0;
	while($DatosLibro=mysql_fetch_array($sel1)){
		if($i==0){
			$back="#D8F0F1";
			$i=1;
		}else{
			$back="#ffffff";
			$i=0;
		}
		$Neto=($DatosLibro["SumDebito"]-$DatosLibro["SumCredito"]);
		$TotalActivos=$TotalActivos+$Neto;
		$NumberNeto=number_format($Neto);
		//$Debitos=number_format($DatosLibro["SumDebito"]);
		//$Creditos=number_format($DatosLibro["SumCredito"]);
		
		$Cuenta=$DatosLibro["Cuenta"];
		$reg=mysql_query("SELECT Nombre FROM cuentas WHERE idPUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 <tr style= "background-color:$back;">
  <td>$DatosCuentas[Nombre]</td>
  <td align="center">$NumberNeto</td><td> </td>
 </tr>
 
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	$NumberNeto=number_format($TotalActivos);
	$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 
 <tr style= "background-color:#FFC17F;">
  <td colspan=2 align="rigth"><h4>Total Activos</h4></td>
  <td></td><td><h4>$NumberNeto </h4></td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}	



///////////////////////////////////////////////////////
//////////////tabla con los datos de PASIVOS//////////////////
////////////////////////////////////////////////////////
$TotalPasivos=0;

$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center" >
  <tr style= "background-color:#3865EC; color: white;" > 
    <th colspan=3><h3>PASIVOS</h3></th>
    
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT substring(CuentaPUC,1,4) as Cuenta, SUM(Debito) as SumDebito, SUM(Credito) as SumCredito FROM librodiario 
WHERE (Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal') AND (Mayor='NO') AND  (substring(CuentaPUC,1,1) = 2)
GROUP BY substring(CuentaPUC,1,4)",$con) or die("problemas con la consulta".mysql_error());

if(mysql_num_rows($sel1)){
	
	$i=0;
	while($DatosLibro=mysql_fetch_array($sel1)){
		if($i==0){
			$back="#D8F0F1";
			$i=1;
		}else{
			$back="#ffffff";
			$i=0;
		}
		$Neto=($DatosLibro["SumDebito"]-$DatosLibro["SumCredito"])*(-1);
		$TotalPasivos=$TotalPasivos+$Neto;
		$NumberNeto=number_format($Neto);
		//$Debitos=number_format($DatosLibro["SumDebito"]);
		//$Creditos=number_format($DatosLibro["SumCredito"]);
		
		$Cuenta=$DatosLibro["Cuenta"];
		$reg=mysql_query("SELECT Nombre FROM cuentas WHERE idPUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 <tr style= "background-color:$back;">
  <td>$DatosCuentas[Nombre]</td>
  <td align="center">$NumberNeto</td><td> </td>
 </tr>
 
 </table>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');

}
	
	$NumberNeto=number_format($TotalPasivos);
	$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 
 <tr style= "background-color:#FFC17F;">
  <td colspan=2 align="rigth"><h4>Total Pasivos</h4></td>
  <td> </td><td><h4>$NumberNeto</h4> </td>
 </tr>
 
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}	


///////////////////////////////////////////////////////
//////////////tabla con los datos del Patrimonio//////////////////
////////////////////////////////////////////////////////

$TotalPatrimonio=0;

$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center" >
  <tr style= "background-color:#3865EC; color: white;" > 
    <th colspan=3><h3>PATRIMONIO</h3></th>
    
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT substring(CuentaPUC,1,4) as Cuenta, SUM(Debito) as SumDebito, SUM(Credito) as SumCredito FROM librodiario 
WHERE (Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal') AND (Mayor='NO') AND  (substring(CuentaPUC,1,1) = 3)
GROUP BY substring(CuentaPUC,1,4)",$con) or die("problemas con la consulta".mysql_error());

if(mysql_num_rows($sel1)){
	
	$i=0;
	while($DatosLibro=mysql_fetch_array($sel1)){
		if($i==0){
			$back="#D8F0F1";
			$i=1;
		}else{
			$back="#ffffff";
			$i=0;
		}
		$Neto=($DatosLibro["SumDebito"]-$DatosLibro["SumCredito"])*(-1);
		$TotalPatrimonio=$TotalPatrimonio+$Neto;
		$NumberNeto=number_format($Neto);
		//$Debitos=number_format($DatosLibro["SumDebito"]);
		//$Creditos=number_format($DatosLibro["SumCredito"]);
		
		$Cuenta=$DatosLibro["Cuenta"];
		$reg=mysql_query("SELECT Nombre FROM cuentas WHERE idPUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 <tr style= "background-color:$back;">
  <td>$DatosCuentas[Nombre]</td>
  <td align="center">$NumberNeto</td><td> </td>
 </tr>
 
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	$NumberNeto=number_format($TotalPatrimonio);
	$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 
 <tr style= "background-color:#FFC17F;">
  <td colspan=2 align="rigth"><h4>Patrimonio</h4></td>
  <td></td><td><h4>$NumberNeto </h4></td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
/////////////////////////////////////////////////////////////
////////////TOTAL PATRIMONIO////////////////////////////////////
/////////////////////////////////////////////////////////////

$TotalPatrimonio=$TotalPatrimonio+$UtilidadNeta;
$PasivoPatrimonio=$TotalPatrimonio+$TotalPasivos;
$NumberNeto=number_format($TotalPatrimonio);
$NumberPP=number_format($PasivoPatrimonio);
	$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="left">
 
 <tr style="background-color:#FFEBCF; color: black;">
  <th colspan=2 align="rigth"><h4>Utilidad del ejercicio</h4> </th>
  <td> </td><td><h4>$NumberUti </h4></td>
 </tr>
 <tr style="background-color:#F6FF89; color: black;">
  <th colspan=2 align="rigth"><h4>TOTAL PATRIMONIO</h4> </th>
  <td> </td><td><h4>$NumberNeto </h4></td>
 </tr>
 <tr style="background-color:#09CAFF; color: black;">
  <th colspan=2 align="rigth"><h4>PASIVO + PATRIMONIO</h4> </th>
  <td> </td><td><h4>$NumberPP </h4></td>
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