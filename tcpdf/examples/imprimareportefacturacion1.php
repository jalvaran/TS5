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
$FechaIni = substr("$_POST[TxtFechaIniFact]", 6, 7)."-".substr("$_POST[TxtFechaIniFact]", 3, 2)."-".substr("$_POST[TxtFechaIniFact]", 0, 2);;
$FechaFinal = substr("$_POST[TxtFechaFinalFact]", 6, 7)."-".substr("$_POST[TxtFechaFinalFact]", 3, 2)."-".substr("$_POST[TxtFechaFinalFact]", 0, 2);

////////////////////////////////////////////
/////////////Me conecto a la db
////////////////////////////////////////////

$con=mysql_connect($host,$user,$pw) or die("problemas con el servidor");
mysql_select_db($db,$con) or die("la base de datos no abre");


////////////////////////////////////////////
/////////////Genero Excel con valores de los trabajos realizados por cada trabajadores
////////////////////////////////////////////  

if(isset($_POST["BtnGeneraExcelFacts"])){
	
	$Grupos=$_POST["CmbGrupos"];
	
	$sql="SELECT NomCol.Nombre as NombreCol, NomCol.Apellido as ApellidoCol, trab.TotalHorasEmpleadas as HorasEmp, trab.Descripcion as DescripcionAct,
	trab.TotalHorasPlaneadas as HorasPla, trab.TotalPausas as PausasAct, trab.ValorActividad as ValorAct, trab.ValorPausas as ValorPausasAct,
	trab.Estado as EstadoAct, trab.TipoActividad as TipoAct, ejec.FechaHoraInicio as FechaIni, ejec.FechaHoraFin as FechaFin,
	NomMaq.Nombre as Maquina
	FROM `trab_actividades` trab INNER JOIN `trab_ejecucion` ejec ON ejec.Trab_Actividades_idTrab_Actividades=trab.idTrab_Actividades
INNER JOIN `trab_asignacioncolaboradoract` col ON trab.idTrab_Actividades=col.Trab_Actividades_idTrab_Actividades
INNER JOIN `colaboradoresact` NomCol ON NomCol.idColaboradores=col.Colaboradores_idColaboradores
INNER JOIN `trab_asignacionmaquinasact` maq ON maq.Trab_Actividades_idTrab_Actividades=trab.idTrab_Actividades
INNER JOIN `maquinas` NomMaq ON NomMaq.idMaquinas=maq.Maquinas_idMaquinas

WHERE (ejec.FechaHoraFin >= '$FechaIni 00:00:00' AND ejec.FechaHoraFin <= '$FechaFinal 23:59:59')  ORDER BY col.Colaboradores_idColaboradores";
	
	
 $resultado = mysql_query ($sql, $con) or die (mysql_error ());
 $registros = mysql_num_rows ($resultado);
  
 if ($registros > 0) {
   require_once '../../Classes/PHPExcel.php';
   $objPHPExcel = new PHPExcel();
    
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.technosoluciones.com")
        ->setLastModifiedBy("www.technosoluciones.com")
        ->setTitle("Exportar tabla egresos desde base de datos")
        ->setSubject("Egresos")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("techno soluciones")
        ->setCategory("Egresos");    
 
   $i = 1;    
   
   $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'Nombre');
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$i, 'Apellido');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C'.$i, 'Descripcion');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'.$i, 'Horas Planeadas');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'.$i, 'Horas Empleadas');	
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F'.$i, 'Valor Actividad');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G'.$i, 'Pausas');
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H'.$i, 'Valor de las Pausas');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I'.$i, 'Estado');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J'.$i, 'Tipo Actividad');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K'.$i, 'Maquina');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('L'.$i, 'Fecha de Inicio');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('M'.$i, 'Fecha Finalizacion');			
			
	$i = 2;  		
   while ($registro = mysql_fetch_object ($resultado)) {
        
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $registro->NombreCol);
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$i, $registro->ApellidoCol);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C'.$i, $registro->DescripcionAct);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'.$i, $registro->HorasPla);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'.$i, $registro->HorasEmp);
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F'.$i, $registro->ValorAct);			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G'.$i, $registro->PausasAct);
			
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H'.$i, $registro->ValorPausasAct);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I'.$i, $registro->EstadoAct);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J'.$i, $registro->TipoAct);	
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K'.$i, $registro->Maquina);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('L'.$i, $registro->FechaIni);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('M'.$i, $registro->FechaFin);	

			
      $i++;
       
   }
}
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Detalles.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
mysql_close ();
}
		 
		  
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
//////////////tabla con los datos de ventas por departamentos de productos//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Ventas por departamentos productos:
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


$sel1=mysql_query("SELECT dpt.idDepartamentos as idDepartamento, dpt.Nombre as NombreDep, SUM(c.Subtotal) as Subtotal, SUM(c.IVA) as IVA, 
SUM(c.Total) as Total,SUM(c.Descuento) as Descuentos, SUM(c.Cantidad) as NumVentas 
FROM facturas f INNER JOIN cotizaciones c ON f.Cotizaciones_idCotizaciones=c.NumCotizacion 
INNER JOIN productosventa pr ON c.Referencia = pr.Referencia 
INNER JOIN prod_departamentos dpt ON dpt.idDepartamentos = pr.Departamento
WHERE f.Fecha >= '$FechaIni' AND f.Fecha <= '$FechaFinal' 
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
		
		
		$Total=number_format($DatosVentas["Total"]);
		$NumVentas=number_format($DatosVentas["NumVentas"]);
		
		$idDepartamento=$DatosVentas["idDepartamento"];
		$NombreDep=$DatosVentas["NombreDep"];
			
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

/*
///////////////////////////////////////////////////////
//////////////tabla con los datos de ventas por servicios//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD

<BR><BR>
<span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Ventas por departamentos servicios:
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


///////////////////////////////////////////////////////
//////////////tabla con los datos de ventas por servicios//////////////////
////////////////////////////////////////////////////////



$sel1=mysql_query("SELECT dpt.idDepartamentos as idDepartamento, dpt.Nombre as NombreDep, SUM(c.Subtotal) as Subtotal, SUM(c.IVA) as IVA, 
SUM(c.Total) as Total,SUM(c.Descuento) as Descuentos, SUM(c.Cantidad) as NumVentas 
FROM facturas f INNER JOIN cotizaciones c ON f.Cotizaciones_idCotizaciones=c.NumCotizacion 
INNER JOIN servicios pr ON c.Referencia = pr.Referencia 
INNER JOIN prod_departamentos dpt ON dpt.idDepartamentos = pr.Departamento
WHERE f.Fecha >= '$FechaIni' AND f.Fecha <= '$FechaFinal' 
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
		
		
		$Total=number_format($DatosVentas["Total"]);
		$NumVentas=number_format($DatosVentas["NumVentas"]);
		
		$idDepartamento=$DatosVentas["idDepartamento"];
		$NombreDep=$DatosVentas["NombreDep"];
			
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

*/
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
	
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT f.Usuarios_idUsuarios as Usuarios, SUM(c.Subtotal) as Subtotal, SUM(c.IVA) as IVA, 
SUM(c.Total) as Total,SUM(c.Descuento) as Descuentos, SUM(c.Cantidad) as NumVentas 
FROM facturas f INNER JOIN cotizaciones c ON f.Cotizaciones_idCotizaciones=c.NumCotizacion 

WHERE f.Fecha >= '$FechaIni' AND f.Fecha <= '$FechaFinal' 
GROUP BY f.Usuarios_idUsuarios",$con) or die("problemas con la consulta a join ventas ".mysql_error());

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
		
		$idUsuario=$DatosVentas["Usuarios"];
		$Total=number_format($DatosVentas["Total"]);
		$Subtotal=number_format($DatosVentas["Subtotal"]);
		$Impuestos=number_format($DatosVentas["IVA"]);
		$Descuentos=number_format($DatosVentas["Descuentos"]);
		$NumProductos=number_format($DatosVentas["NumVentas"]);
		
		
		
		//$reg=mysql_query("SELECT Nombre FROM subcuentas WHERE PUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		//$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center">
 <tr style= "background-color:$back;">
  <td>$idUsuario</td><td>$NumProductos</td>
  <td>$Subtotal</td><td>$Impuestos</td><td>$Total</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	
}	



///////////////////////////////////////////////////////////////////////////////////////
////////////////////////////Totales por Tipo de Venta
////////////////////////////////////////////////////////////////////////////////////////

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
	
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT f.FormaPago as TipoVenta, SUM(c.Subtotal) as Subtotal, SUM(c.IVA) as IVA, 
SUM(c.Total) as Total,SUM(c.Descuento) as Descuentos, SUM(c.Cantidad) as NumVentas 
FROM facturas f INNER JOIN cotizaciones c ON f.Cotizaciones_idCotizaciones=c.NumCotizacion 

WHERE f.Fecha >= '$FechaIni' AND f.Fecha <= '$FechaFinal' 
GROUP BY f.FormaPago",$con) or die("problemas con la consulta a join ventas ".mysql_error());

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
		$Total=number_format($DatosVentas["Total"]);
		$Subtotal=number_format($DatosVentas["Subtotal"]);
		$Impuestos=number_format($DatosVentas["IVA"]);
		$Descuentos=number_format($DatosVentas["Descuentos"]);
		$NumProductos=number_format($DatosVentas["NumVentas"]);
		
		
		
		//$reg=mysql_query("SELECT Nombre FROM subcuentas WHERE PUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		//$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center">
 <tr style= "background-color:$back;">
  <td>$TipoPago</td><td>$NumProductos</td>
  <td>$Subtotal</td><td>$Impuestos</td><td>$Total</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	
}	




///////////////////////////////////////////////////////////////////////////////////////
////////////////////////////Devoluciones
////////////////////////////////////////////////////////////////////////////////////////

$tbl = <<<EOD

<br><br><br><br>
<span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Devoluciones en Ventas:
</em></strong></span><BR><BR>

<table border="1" cellpadding="3" cellspacing="4" align="center" >
  <tr style= "background-color:#FE642E; color: white;" > 
    
	<th><h3>Usuario</h3></th>
	<th><h3>Items</h3></th>
	<th><h3>Subtotal</h3></th>
	<th><h3>Impuestos</h3></th>
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT SUM(Subtotal) as Subtotal, SUM(IVA) as IVA, 
SUM(Total) as Total, SUM(Cantidad) as Cantidad, Usuarios_idUsuarios
FROM ventas_devoluciones

WHERE FechaDevolucion >= '$FechaIni' AND FechaDevolucion <= '$FechaFinal' 
GROUP BY Usuarios_idUsuarios",$con) or die("problemas con la consulta a ventas_devoluciones ".mysql_error());

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
		
		$User=$DatosVentas["Usuarios_idUsuarios"];
		$Total=number_format($DatosVentas["Total"]);
		$Subtotal=number_format($DatosVentas["Subtotal"]);
		$Impuestos=number_format($DatosVentas["IVA"]);
		
		$NumProductos=number_format($DatosVentas["Cantidad"]);
		
		
		
		//$reg=mysql_query("SELECT Nombre FROM subcuentas WHERE PUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		//$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center">
 <tr style= "background-color:$back;">
  <td>$User</td>
  <td>$NumProductos</td>
  <td>$Subtotal</td>
  <td>$Impuestos</td>
  <td>$Total</td>
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
	
	<th><h3>Total</h3></th>
	<th><h3>Costos</h3></th>
	<th><h3>Util. Bruta</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT f.Fecha as Fecha, SUM(c.Subtotal) as Subtotal, SUM(c.IVA) as IVA, 
SUM(c.Total) as Total,SUM(c.Descuento) as Descuentos, SUM(c.Cantidad) as NumVentas, SUM(c.SubtotalCosto) as Costos 
FROM facturas f INNER JOIN cotizaciones c ON f.Cotizaciones_idCotizaciones=c.NumCotizacion 

WHERE f.Fecha >= '$FechaIni' AND f.Fecha <= '$FechaFinal' 
GROUP BY f.Fecha",$con) or die("problemas con la consulta a join ventas ".mysql_error());

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
		$Total=number_format($DatosVentas["Total"]);
		$Subtotal=number_format($DatosVentas["Subtotal"]);
		$Impuestos=number_format($DatosVentas["IVA"]);
		$Descuentos=number_format($DatosVentas["Descuentos"]);
		$Costos=number_format($DatosVentas["Costos"]);
		$UtBruta=number_format($DatosVentas["Subtotal"]-$DatosVentas["Costos"]);
		
		
		
		
		//$reg=mysql_query("SELECT Nombre FROM subcuentas WHERE PUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		//$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center">
 <tr style= "background-color:$back;">
  <td>$Fecha</td>
  <td>$Subtotal</td>
  <td>$Impuestos</td>
  
  <td>$Total</td>
  <td>$Costos</td>
  <td>$UtBruta</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	
}	


///////////////////////////
/////////////////Totales


$sel1=mysql_query("SELECT MAX(idFacturas) as MaxId, MIN(idFacturas) as MinId , SUM(c.Subtotal) as Subtotal, SUM(c.IVA) as IVA, 
SUM(c.Total) as Total,SUM(c.Descuento) as Descuentos, SUM(c.Cantidad) as NumVentas, SUM(c.SubtotalCosto) as Costos 
FROM facturas f INNER JOIN cotizaciones c ON f.Cotizaciones_idCotizaciones=c.NumCotizacion 

WHERE f.Fecha >= '$FechaIni' AND f.Fecha <= '$FechaFinal' ",$con) or die("problemas con la consulta a join ventas ".mysql_error());

$Totales=mysql_fetch_array($sel1);
$Subtotal=number_format($Totales["Subtotal"]);
$Impuestos=number_format($Totales["IVA"]);
$Descuentos=number_format($Totales["Descuentos"]);
$Total=number_format($Totales["Total"]);
$Items=number_format($Totales["NumVentas"]);
$Costos=number_format($Totales["Costos"]);
$UtBruta=number_format($Totales["Subtotal"]-$Totales["Costos"]);
$MinId=$Totales["MinId"];
$MaxId=$Totales["MaxId"];


$NumFacts=$MaxId-$MinId+1;

$tbl = <<<EOD
<table border="1" cellpadding="3" cellspacing="5" align="center">
 <tr style= "background-color:RED;color:white">
  <td><h3>TOTALES</h3></td>
  <td><h3>$Subtotal</h3></td>
  <td><h3>$Impuestos</h3></td>
  <td><h3>$Total</h3></td>
  <td><h3>$Costos</h3></td>
  <td><h3>$UtBruta</h3></td>
 </tr>
 
 <tr style= "background-color:#EFFBF2;color:black;">
  <td>FACTURAS INICIO:</td>
  <td> $MinId</td>
  <td>FIN:</td><td> $MaxId</td>
  <td>TOTAL</td><td>$NumFacts</td>
 </tr>
 
 
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


//$pdf->writeHTML($tab, false, false, false, false, '');
//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>