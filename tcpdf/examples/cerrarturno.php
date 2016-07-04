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

////////////////////////////////////////////
/////////////Me conecto a la db
////////////////////////////////////////////

$con=mysql_connect($host,$user,$pw) or die("problemas con el servidor");
mysql_select_db($db,$con) or die("la base de datos no abre");


////////////////////////////////////////////
/////////////Obtengo valores de la cotizacion
////////////////////////////////////////////
			
		  
	
		 
		 
		 
		// $sel1=mysql_query("SELECT SUM(Total) as TotalVentas, SUM(Descuentos) as Descuentos, SUM(IVA) as Impuestos, SUM(TotalCostos) as TotalCostos
		  // FROM facturas WHERE (OSalida >= '$idMin' AND OSalida <= '$idMax') AND Usuarios_idUsuarios = '$idUsuario' AND FormaPago = 'Contado' ",$con) or die("problemas con la consulta a la tabla facturas  .".mysql_error());
		 
		  $sel1=mysql_query("SELECT MAX(OSalida)  as MAXid, MIN(OSalida)  as MINid,  SUM(Total) as TotalVentas, SUM(Descuentos) as Descuentos, SUM(IVA) as Impuestos, SUM(TotalCostos) as TotalCostos
		   FROM facturas WHERE CerradoDiario='' AND Usuarios_idUsuarios = '$idUsuario' AND FormaPago='Contado'",$con) or die("problemas con la consulta a la tabla facturas  .".mysql_error());
		 
		 
		 $Sumas=mysql_fetch_array($sel1);	
		  $TotalVentas1= $Sumas["TotalVentas"];
		  $TotalVentas=number_format($Sumas["TotalVentas"]);
		  
		  $idMax=$Sumas["MAXid"];
		 $idMin=$Sumas["MINid"];
			
		  $TotalCostos=$Sumas["TotalCostos"];
		  $Descuentos=$Sumas["Descuentos"];
		   $Impuestos=$Sumas["Impuestos"];
		   
		   $TotalVentasC=0;
		   
		   $sel1=mysql_query("SELECT SUM(Total) as TotalVentas, SUM(Descuentos) as Descuentos, SUM(IVA) as Impuestos, SUM(TotalCostos) as TotalCostos
		   FROM facturas WHERE CerradoDiario='' AND Usuarios_idUsuarios = '$idUsuario' AND FormaPago='Credito'",$con) or die("problemas con la consulta a la tabla facturas  .".mysql_error());
		 
		  $Sumas=mysql_fetch_array($sel1);	
		  
		  $TotalVentasC=number_format($Sumas["TotalVentas"]);
		   $TotalCostos=number_format($TotalCostos+$Sumas["TotalCostos"]);
		   $Descuentos=number_format($Descuentos+$Sumas["Descuentos"]);
		   $Impuestos=number_format($Impuestos+$Sumas["Impuestos"]);
		   //print($TotalVentasC);
		   ///////////////////////////////////////
		   /////////// Para no visualizar costos
		   //////////////////////////////////77
		   
		   $TotalCostos="NA";
		   
////////////////////////////////////////trasladar saldos a la cuenta general en el cierre

//////////////////////////////////////////////////////////////////////
		///////////////////////////Realizar asientos contables en la tabla de Libro Diario
			/*		
			mysql_query("INSERT INTO librodiario (Fecha, Tipo_Documento_Intero, Num_Documento_Interno, Tercero_Razon_Social, Concepto, CuentaPUC, NombreCuenta, Debito, Credito, Neto, Mayor)
			VALUES ('$fecha','COMPROBANTE DIARIO', 'NA', 'PROPIETARIO', 'Traslado de fondos por cierre de Usuario $NombreUsuario', '110505', 'CAJA GENERAL', '$TotalVentas1','0', '$TotalVentas1','NO')",$con) or die("problemas actualizando debito de libro diario  .".mysql_error());
		 
		 mysql_query("INSERT INTO librodiario (Fecha, Tipo_Documento_Intero, Num_Documento_Interno, Tercero_Razon_Social, Concepto, CuentaPUC, NombreCuenta, Debito, Credito, Neto, Mayor)
			VALUES ('$fecha','COMPROBANTE DIARIO', 'NA', 'PROPIETARIO', 'Traslado de fondos por cierre de Usuario $NombreUsuario', '110505', 'CAJA GENERAL','0' ,'$TotalVentas1', '-$TotalVentas1','NO')",$con) or die("problemas actualizando debito de libro diario  .".mysql_error());
		 

*/
		   
		   
		if($idMax<=0){
			 $TotalVentas1=0;
			  $TotalVentas=0;
			 //$TotalVentasC=0;
		   $TotalCostos=0;
		   $Descuentos=0;
		   $Impuestos=0;
		 }
		 
		 
		 /////////////////////////////Sumamos abonos
		 
		  $sel1=mysql_query("SELECT SUM(Total) as Abonos FROM ingresos WHERE CerradoDiario = '' AND Usuarios_idUsuarios='$idUsuario' ",$con) or die("problemas con la consulta a la tabla Ventas .".mysql_error());
		 
		 
		 $Sumas=mysql_fetch_array($sel1);
		  $TotalAbonos=$Sumas["Abonos"];
		  
		  
		  
		   $sel1=mysql_query("SELECT SUM(Monto) as Abonos FROM facturas_abonos WHERE CerradoDiario = '' AND Usuarios_idUsuarios='$idUsuario' AND CuentaIngreso='110510'",$con) or die("problemas con la consulta a la tabla Ventas .".mysql_error());
		 
		 
		 $Sumas=mysql_fetch_array($sel1);
		  $TAbonos=$Sumas["Abonos"];
		  $TotalAbonos=$TotalAbonos+$TAbonos;
		  
		  /////////////////////////////Sumamos devoluciones en ventas
		  
		  $sel1=mysql_query("SELECT SUM(Total) as Devoluciones FROM ventas_devoluciones WHERE CerradoDiario = '' AND Usuarios_idUsuarios='$idUsuario' ",$con) or die("problemas con la consulta a la tabla Ventas .".mysql_error());
		 
		 
		 $Sumas=mysql_fetch_array($sel1);
		  $TotalDevoluciones1=$Sumas["Devoluciones"];
		  $TotalDevoluciones=number_format($Sumas["Devoluciones"]);
		  /////////////////////////////Sumamos egresos en ventas
		
		  //echo("$TotalVentas, $TotalCostos, $Descuentos, $Impuestos");
	   $sel1=mysql_query("SELECT SUM(Valor) as TotalEgresos FROM egresos WHERE CerradoDiario = '' AND Usuario_idUsuario='$idUsuario' AND PagoProg<>'Programado'",$con) 
	   or die("problemas con la consulta a la tabla Ventas .".mysql_error());
		 
		  $Sumas=mysql_fetch_array($sel1);	
		  $TotalEgresos1=$Sumas["TotalEgresos"];
		  $TotalEgresos=number_format($Sumas["TotalEgresos"]);
		  
		  
		  
		  		  		  
		  $nombre_file="Relacion".$fecha."_".$hora;
		  
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////777Updates///////////////////////////////////////
//////////////////////////////////////////////////////////////////777Updates///////////////////////////////////////




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

$sql = " UPDATE ventas_devoluciones SET
				CerradoDiario = 'SI',
		  		FechaCierreDiario = '$fecha',
				HoraCierreDiario='$hora',
				UsuarioCierreDiario='$NombreUsuario'
				
		WHERE CerradoDiario = '' AND Usuarios_idUsuarios='$idUsuario'";
		
$r = mysql_query($sql,$con) or die("No se actualizo la tabla ventas devoluciones .".mysql_error());	 


$sql = " UPDATE facturas_abonos SET
				CerradoDiario = 'SI',
		  		FechaCierreDiario = '$fecha',
				HoraCierreDiario='$hora'
				
				
		WHERE CerradoDiario = '' AND Usuarios_idUsuarios='$idUsuario'";
		
$r = mysql_query($sql,$con) or die("No se actualizo la tabla facturas_abonos .".mysql_error());	


$sql = " UPDATE facturas SET
				CerradoDiario = 'SI',
		  		FechaCierreDiario = '$fecha',
				HoraCierreDiario='$hora'
				
				
		WHERE CerradoDiario = '' AND Usuarios_idUsuarios='$idUsuario'";
		
$r = mysql_query($sql,$con) or die("No se actualizo la tabla facturas_abonos .".mysql_error());	


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

$SaldoCaja=$TotalVentas1-$TotalEgresos1- $TotalDevoluciones1+$TotalAbonos;
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
  <th colspan=4 style= "border: 2px solid #000099;" ><h3>Total Devoluciones</h3></th><th style= "border: 2px solid #000099;" ><h3>$TotalDevoluciones</h3></th>
  
 </tr>
 
 <tr nobr="true">
  <th colspan=4 style= "border: 2px solid #000099;" ><h3>Saldo en Caja</h3></th><th style= "border: 2px solid #000099;" ><h3>$SaldoCaja</h3></th>
  
 </tr>
 
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');



//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');


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
fwrite($handle,$ResolucionDian);
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


				
		fwrite($handle,"Venta Dia: ".$TotalVentas."..");
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Total Costos: $TotalCostos");
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Total Descuentos: ".$Descuentos);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Impuestos: ".$Impuestos);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Egresos: ".$TotalEgresos);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Venta Creditos: ".$TotalVentasC);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Total Abonos: ".$TotalAbonos);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Devoluciones: ".$TotalDevoluciones);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Saldo en Caja: ".$SaldoCaja);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Factura Inicial: ".$idMin);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Factura Final: ".$idMax);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

		


fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

$DatosUsuario=mysql_query("SELECT * FROM usuarios WHERE idUsuarios='$idUsuarios'", $con) or die('no se pudo conectar a usuarios: ' . mysql_error());
$DatosUsuario=mysql_fetch_array($DatosUsuario);	

fwrite($handle,$fecha);
fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
fwrite($handle,"*..COMPROBANTE DE INFORME DIARIO");
fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

fwrite($handle,"***Usuario:.$NombreUsuario");

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
fclose($handle); // cierra el fichero PRN
$salida = shell_exec("lpr $COMPrinter");

//============================================================+
// END OF FILE
//============================================================+
?>