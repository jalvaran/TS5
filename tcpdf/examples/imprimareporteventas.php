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

$pdf->SetFont('helvetica', '', 9);

///////////////////////////////////////////////////////
//////////////encabezado//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<hr id="Line1" style="margin:0;padding:0;position:absolute;left:0px;top:44px;width:625px;height:2px;z-index:1;">
<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Fecha: $fecha</span></div>

<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:10px;text-align:center;z-index:2;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>COMPROBANTE DE INFORME DE VENTAS
</em></strong></span><BR>
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>RESULTADOS ENTRE EL $FechaIni Y EL $FechaFinal
</em></strong></span><BR><BR>

EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

///////////////////////////////////////////////////////
//////////////tabla con los datos//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Ventas por departamentos:
</em></strong></span><BR><BR>


<table border="1" cellpadding="3" cellspacing="4" align="center" >
  <tr style= "background-color:#FE642E; color: white;" > 
    <th><h3>Departamento</h3></th>
    <th><h3>Nombre</h3></th>		
    
	<th><h3>Cantidad</h3></th>
	<th><h3>Valor</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');



//$sel1=mysql_query("SELECT Referencia, SUM(TotalVenta) as Total,SUM(Descuentos) as Descuentos, SUM(Cantidad) as NumVentas FROM ventas WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
//GROUP BY Referencia",$con) or die("problemas con la consulta".mysql_error());


//$sel1=mysql_query("SELECT dpt.idDepartamentos as idDepartamento, dpt.Nombre as NombreDep, SUM(v.TotalVenta) as Total,SUM(v.Descuentos) as Descuentos, SUM(v.Cantidad) as NumVentas FROM ventas v INNER JOIN productosventa pr ON v.Referencia = pr.Referencia 
//INNER JOIN prod_departamentos dpt ON dpt.idDepartamentos = pr.Departamento
//WHERE v.Fecha >= '$FechaIni' AND v.Fecha <= '$FechaFinal' 
//GROUP BY dpt.idDepartamento",$con) or die("problemas con la consulta a join ventas ".mysql_error());

$sel1=mysql_query("SELECT dpt.idDepartamentos as idDepartamento, dpt.Nombre as NombreDep, SUM(v.TotalVenta) as Total,SUM(v.Descuentos) as Descuentos, SUM(v.Cantidad) as NumVentas FROM ventas v INNER JOIN productosventa pr ON v.Referencia = pr.Referencia 
INNER JOIN prod_departamentos dpt ON dpt.idDepartamentos = pr.Departamento
WHERE v.Fecha >= '$FechaIni' AND v.Fecha <= '$FechaFinal' 
GROUP BY dpt.idDepartamentos",$con) or die("problemas con la consulta a join ventas ".mysql_error());

if(mysql_num_rows($sel1)){
	
	$i=0;
	while($DatosVentas=mysql_fetch_array($sel1)){
		if($i==0){
			$back="#D8F0F1";
			$i=1;
		}else{
			$back="#ffffff";
			$i=0;
		}
		
		
		$Total=number_format($DatosVentas["Total"]-$DatosVentas["Descuentos"]);
		$NumVentas=number_format($DatosVentas["NumVentas"]);
		
		$idDepartamento=$DatosVentas["idDepartamento"];
		$NombreDep=$DatosVentas["NombreDep"];
		
		//$reg=mysql_query("SELECT Nombre FROM subcuentas WHERE PUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		//$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center">
 <tr style= "background-color:$back;">
  <td>$idDepartamento</td><td>$NombreDep</td>
  <td>$NumVentas</td><td>$Total</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	
}	

///////////////////////////////////////////////////////////////////////////////////////72px
////////////////////////////Totales por Usuarios
////////////////////////////////////////////////////////////////////////////////////////77

$tbl = <<<EOD

<br><br><br><br>
<span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Ventas por Usuarios:
</em></strong></span><BR><BR>

<table border="1" cellpadding="3" cellspacing="4" align="center" >
  <tr style= "background-color:#FE642E; color: white;" > 
    <th><h3>Usuario</h3></th>
    	
    
	<th><h3>Items</h3></th>
	<th><h3>Subtotal</h3></th>
	<th><h3>Impuestos</h3></th>
	<th><h3>Descuentos</h3></th>
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT Usuarios_idUsuarios, SUM(TotalVenta) as Total, SUM(Descuentos) as Descuentos , SUM(Impuestos) as IVA, SUM(Cantidad) as NumPro FROM ventas WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
GROUP BY Usuarios_idUsuarios",$con) or die("problemas con la consulta a ventas".mysql_error());

if(mysql_num_rows($sel1)){
	
	$i=0;
	while($DatosVentas=mysql_fetch_array($sel1)){
		if($i==0){
			$back="#D8F0F1";
			$i=1;
		}else{
			$back="#ffffff";
			$i=0;
		}
		
		$idUsuario=$DatosVentas["Usuarios_idUsuarios"];
		$Total=number_format($DatosVentas["Total"]-$DatosVentas["Descuentos"]);
		$Subtotal=number_format($DatosVentas["Total"]-$DatosVentas["Descuentos"]-$DatosVentas["IVA"]);
		$Impuestos=number_format($DatosVentas["IVA"]);
		$Descuentos=number_format($DatosVentas["Descuentos"]);
		$NumProductos=number_format($DatosVentas["NumPro"]);
		
		
		
		//$reg=mysql_query("SELECT Nombre FROM subcuentas WHERE PUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		//$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center">
 <tr style= "background-color:$back;">
  <td>$idUsuario</td><td>$NumProductos</td>
  <td>$Subtotal</td><td>$Impuestos</td><td>$Descuentos</td><td>$Total</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	
}	



///////////////////////////////////////////////////////////////////////////////////////72px
////////////////////////////Totales por Tipo de Venta
////////////////////////////////////////////////////////////////////////////////////////77

$tbl = <<<EOD

<br><br><br><br>
<span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Ventas por Forma de Pago:
</em></strong></span><BR><BR>

<table border="1" cellpadding="3" cellspacing="4" align="center" >
  <tr style= "background-color:#FE642E; color: white;" > 
    
	<th><h3>Forma de Pago</h3></th>
	<th><h3>Items</h3></th>
	<th><h3>Subtotal</h3></th>
	<th><h3>Impuestos</h3></th>
	<th><h3>Descuentos</h3></th>
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT TipoVenta, SUM(TotalVenta) as Total, SUM(Descuentos) as Descuentos , SUM(Impuestos) as IVA, SUM(Cantidad) as NumPro FROM ventas WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
GROUP BY TipoVenta",$con) or die("problemas con la consulta a ventas".mysql_error());

if(mysql_num_rows($sel1)){
	
	$i=0;
	while($DatosVentas=mysql_fetch_array($sel1)){
		if($i==0){
			$back="#D8F0F1";
			$i=1;
		}else{
			$back="#ffffff";
			$i=0;
		}
		
		$TipoPago=$DatosVentas["TipoVenta"];
		$Total=number_format($DatosVentas["Total"]-$DatosVentas["Descuentos"]);
		$Subtotal=number_format($DatosVentas["Total"]-$DatosVentas["Descuentos"]-$DatosVentas["IVA"]);
		$Impuestos=number_format($DatosVentas["IVA"]);
		$Descuentos=number_format($DatosVentas["Descuentos"]);
		$NumProductos=number_format($DatosVentas["NumPro"]);
		
		
		
		//$reg=mysql_query("SELECT Nombre FROM subcuentas WHERE PUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		//$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center">
 <tr style= "background-color:$back;">
  <td>$TipoPago</td><td>$NumProductos</td>
  <td>$Subtotal</td><td>$Impuestos</td><td>$Descuentos</td><td>$Total</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	
}	





///////////////////////////////////////////////////////////////////////////////////////72px
////////////////////////////Totales por dias
////////////////////////////////////////////////////////////////////////////////////////77

$tbl = <<<EOD

<br><br><br><br>
<span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Ventas Discriminadas por Fechas:
</em></strong></span><BR><BR>

<table border="1" cellpadding="3" cellspacing="4" align="center" >
  <tr style= "background-color:#FE642E; color: white;" > 
    <th><h3>Fecha</h3></th>
    	
    
	
	<th><h3>Subtotal</h3></th>
	<th><h3>Impuestos</h3></th>
	<th><h3>Descuentos</h3></th>
	<th><h3>Total</h3></th>
	<th><h3>Excluido</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT Fecha, SUM(TotalVenta) as Total, SUM(Descuentos) as Descuentos , SUM(Impuestos) as IVA FROM ventas WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
GROUP BY Fecha",$con) or die("problemas con la consulta a ventas ".mysql_error());

if(mysql_num_rows($sel1)){
	
	$i=0;
	while($DatosVentas=mysql_fetch_array($sel1)){
		if($i==0){
			$back="#D8F0F1";
			$i=1;
		}else{
			$back="#ffffff";
			$i=0;
		}
		
		$Fecha=$DatosVentas["Fecha"];
		
		$reg=mysql_query("SELECT SUM(TotalVenta) as Total from ventas WHERE Fecha='$Fecha' AND Impuestos=0 
		",$con) or die("problemas con la consulta a ventas ".mysql_error());
		$Excluidos=mysql_fetch_array($reg);
		$Excluidos=$Excluidos["Total"];
		
		$Total=number_format($DatosVentas["Total"]-$DatosVentas["Descuentos"]-$Excluidos);
		$Subtotal=number_format($DatosVentas["Total"]-$DatosVentas["Descuentos"]-$DatosVentas["IVA"]-$Excluidos);
		$Impuestos=number_format($DatosVentas["IVA"]);
		$Descuentos=number_format($DatosVentas["Descuentos"]);
		
		$Excluidos=number_format($Excluidos);
		
		
		//$reg=mysql_query("SELECT Nombre FROM subcuentas WHERE PUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		//$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center">
 <tr style= "background-color:$back;">
  <td>$Fecha</td>
  <td>$Subtotal</td>
  <td>$Impuestos</td>
  <td>$Descuentos</td>
  <td>$Total</td>
  <td>$Excluidos</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	
}	


///////////////////////////
/////////////////Totales


$sel1=mysql_query("SELECT SUM(TotalVenta) as Total, SUM(Descuentos) as Descuentos, SUM(Cantidad) as Cantidad, SUM(Impuestos) as IVA, MAX(idVentas) as MaxId, MIN(idVentas) as MinId  FROM ventas WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
",$con) or die("problemas con la consulta a ventas".mysql_error());

$Totales=mysql_fetch_array($sel1);
$Total=$Totales["Total"]-$Totales["Descuentos"];
$Impuestos=$Totales["IVA"];
$Descuentos=$Totales["Descuentos"];
$Items=$Totales["Cantidad"];
$MinId=$Totales["MinId"];
$MaxId=$Totales["MaxId"];

$Subtotal=$Total-$Impuestos;

$reg=mysql_query("SELECT SUM(TotalVenta) as Total from ventas  WHERE (Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal') AND Impuestos=0 
",$con) or die("problemas con la consulta a ventas excluidas".mysql_error());
$Excluidos=mysql_fetch_array($reg);
$Excluidos=$Excluidos["Total"];

$Subtotal=number_format($Subtotal-$Excluidos);
$Impuestos=number_format($Impuestos);
$Total=number_format($Total-$Excluidos);
$Descuentos=number_format($Descuentos);
$Excluidos=number_format($Excluidos);

$sel1=mysql_query("SELECT NumVenta FROM ventas WHERE idVentas='$MinId'",$con) or die("problemas con la consulta a ventas".mysql_error());

$ID=mysql_fetch_array($sel1);
$MinId=$ID["NumVenta"];


$sel1=mysql_query("SELECT  NumVenta FROM ventas WHERE idVentas='$MaxId'",$con) or die("problemas con la consulta a ventas".mysql_error());

$ID=mysql_fetch_array($sel1);
$MaxId=$ID["NumVenta"];


$NumFacts=$MaxId-$MinId+1;

$tbl = <<<EOD

<br><br><br><center><h2>RESUMEN DE LOS VALORES OBTENIDOS ENTRE EL $FechaIni Y EL $FechaFinal:</h2></center>
<br><h3>Valor Base:</h3> $$Subtotal
<br><h3>IVA:</h3> $$Impuestos
<br><h3>Total:</h3> $$Total
<br><h3>Excluidos:</h3> $$Excluidos
<br><h3>Factura inicial:</h3> $MinId
<br><h3>Factura Final:</h3> $MaxId
<br><h3>Total Facturas:</h3> $NumFacts 
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


//$pdf->writeHTML($tab, false, false, false, false, '');
//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>