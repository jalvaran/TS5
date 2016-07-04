<?php

require_once('tcpdf_include.php');
include("conexion.php");
////////////////////////////////////////////
/////////////Verifico que haya una sesion activa
////////////////////////////////////////////
session_start();
if(!isset($_SESSION["username"]))
   header("Location: index.html");

////////////////////////////////////////////
/////////////Obtengo el ID de la Factura a que se imprimirá 
////////////////////////////////////////////

$IDFact = $_POST["ImgPrintFact"];

////////////////////////////////////////////
/////////////Me conecto a la db
////////////////////////////////////////////

$con=mysql_connect($host,$user,$pw) or die("problemas con el servidor");
mysql_select_db($db,$con) or die("la base de datos no abre");
////////////////////////////////////////////
/////////////Obtengo valores de la cotizacion
////////////////////////////////////////////
		  $sel1=mysql_query("SELECT * FROM facturas WHERE idFacturas=$IDFact",$con) or die("problemas con la consulta a facturas");
		  $DatosFactura=mysql_fetch_array($sel1);	
		  
		  $IDCoti=$DatosFactura["Cotizaciones_idCotizaciones"];
		  $frac = explode(';',$IDCoti);
          $no = count($frac)-1;
		  $SubTotal=number_format($DatosFactura["Subtotal"]);
		  $IVACoti=number_format(round($DatosFactura["IVA"]));
		  $Total=number_format(round($DatosFactura["Total"]));
		  $fecha=$DatosFactura[1];
		  $OrdenSalida=$DatosFactura["OSalida"];
		  $OrdenCompra=$DatosFactura["OCompra"];
		  $Clientes_idClientes=$DatosFactura["Clientes_idClientes"];
		  $Usuarios_idUsuarios=$DatosFactura["Usuarios_idUsuarios"];
		  $ObsevacionesFactura=$DatosFactura["ObservacionesFact"];
		  $Cotizaciones=$frac[0];
		  $sel1=mysql_query("SELECT * FROM empresapro WHERE idEmpresaPro=1",$con) or die("problemas con la consulta a Empresa Propietaria");
		  $DatosEmpresa=mysql_fetch_array($sel1);	
		  
		  /*
		  $sel1=mysql_query("SELECT SUM(Subtotal) as Subtotalcoti, SUM(IVA) as IVACoti, SUM(Total) as TotalCoti FROM cotizaciones WHERE NumCotizacion=$IDCoti",$con) or die("problemas con la consulta a cotizaciones");
		  $costos=mysql_fetch_array($sel1);	
		  $SubTotal=number_format($costos["Subtotalcoti"]);
		  $IVACoti=number_format(round($costos["IVACoti"]));
		  $Total=number_format(round($costos["TotalCoti"]));
			*/
		
		  
////////////////////////////////////////////
/////////////Obtengo datos del cliente
////////////////////////////////////////////

		  		  
		  $sel1=mysql_query("SELECT * FROM clientes WHERE idClientes=$Clientes_idClientes",$con) or die("problemas con la consulta a clientes");
		  $registros2=mysql_fetch_array($sel1);
		  $nombre=$registros2["RazonSocial"];
		  $direccion=$registros2["Direccion"];
		  $telefono=$registros2["Telefono"];
		  $email=$registros2["Email"];
		  $ciudad=$registros2["Ciudad"];
		  $contacto=$registros2["Contacto"];
		  $TelContacto=$registros2["TelContacto"];
		  $nit=$registros2["Num_Identificacion"];
		  
	////////////////////////////////////////////
/////////////Obtengo datos del Usuario creador
////////////////////////////////////////////

		  		  
		  $sel1=mysql_query("SELECT * FROM usuarios WHERE idUsuarios=$Usuarios_idUsuarios",$con) or die("problemas con la consulta a Usuarios");
		  $registros2=mysql_fetch_array($sel1);
		  $nombreUsuario=$registros2["Nombre"];
		  $ApellidoUsuario=$registros2["Apellido"];
		    
		 
			
			
			////////////////////////////////////////////////
		  
		  $nombre_file=$fecha."_".$nombre;
		   
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
$pdf->SetFont('helvetica', 'B', 7);

// add a page
$pdf->AddPage();

//$pdf->Write(0, 'Taller industrial Servi Torno tiene el agrado de cotizarle los siguientes servicios:', '', 0, 'L', true, 0, false, false, 0);

//$pdf->SetFont('helvetica', '', 6);

///////////////////////////////////////////////////////
//////////////encabezado//////////////////
////////////////////////////////////////////////////////



$tbl = <<<EOD


<hr id="Line1" style="margin:0;padding:0;position:absolute;left:0px;top:44px;width:625px;height:1px;z-index:1;">


<div id="wb_Text1" style="position:absolute;left:380px;top:71px;width:150px;height:10px;text-align:center;z-index:2;">

<span style="color:#00008B;font-family:'Bookman Old Style';font-size:16px;"><strong><em>$DatosEmpresa[RazonSocial]
</em></strong></span><BR>

<span style="color:#00008B;font-family:'Bookman Old Style';font-size:11px;"><strong><em>$DatosEmpresa[NIT]
</em></strong></span><br>

<span style="color:#00008B;font-family:'Bookman Old Style';font-size:11px;"><strong><em>$DatosEmpresa[Direccion]
</em></strong></span><br>

<span style="color:#00008B;font-family:'Bookman Old Style';font-size:11px;"><strong><em>$DatosEmpresa[Ciudad]
</em></strong></span><br>

</div>

<div id="wb_Text1" style="position:absolute;left:380px;top:71px;width:150px;height:16px;text-align:rigth;z-index:2;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:11px;"><strong><em>FACTURA DE VENTA No. $OrdenSalida
</em></strong></span></div><BR>



EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

$tbl = <<<EOD

<table border="1" cellpadding="1" cellspacing="1" align="left" style="border-left: 1px solid #000099;
		border-right: 1px solid #000099;
		border-top: 1px solid #000099;
		border-bottom: 1px solid #000099;">
 <tr nobr="true">
  <td style= "border: 1px solid #000099;" >Fecha: $fecha</td><td style= "border: 1px solid #000099;">Razón Social: $nombre</td> <td style= "border: 1px solid #000099;">NIT: $nit</td>
  
 </tr>
 <tr nobr="true">
 <td style= "border: 1px solid #000099;" >Dirección: $direccion</td><td style= "border: 1px solid #000099;">Teléfono: $telefono</td> <td style= "border: 1px solid #000099;">Forma de Pago: $DatosFactura[FormaPago]</td>
 </tr>
 </table><br>
 <hr id="Line3" style="margin:0;padding:0;position:absolute;left:0px;top:219px;width:625px;height:1px;z-index:9;"><br>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
// NON-BREAKING ROWS (nobr="true")

$tbl = <<<EOD


<table border="1"  cellpadding="1" cellspacing="1" align="center" style="border-left: 1px solid #000099;
		border-right: 1px solid #000099;
		border-top: 1px solid #000099;
		border-bottom: 1px solid #000099;">
  

 <tr nobr="true">
  <th style= "border: 1px solid #000099;" ><h3>Cantidad</h3></th><th style= "border: 1px solid #000099;" colspan="3"><h3>Descripción</h3></th>
  <th  style= "border: 1px solid #000099;"><h3>Vr. Unitario</h3></th><th style= "border: 1px solid #000099;"><h3>Vr. Total</h3></th>
 </tr>
 
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

////////////////////////////////////////////////////////

	
	
	$sql = "SELECT * FROM cotizaciones WHERE ";
	for ($i=0;$i<=$no;$i++){
		
		if($i==$no){
			$sql = $sql." NumCotizacion = '$frac[$i]'";
		}else{
			$sql = $sql." NumCotizacion = '$frac[$i]' OR";
		}
		
	}
$sel1 = mysql_query($sql,$con) or die("La consulta a nuestra base de datos es erronea.".mysql_error());		

		  if(mysql_num_rows($sel1)){
		  while($registros2=mysql_fetch_array($sel1)){
	
			
		  	
			$registros2["Total"]=number_format($registros2["Total"]);
			$registros2["Subtotal"]=number_format(round($registros2["Subtotal"]));	
			$registros2["ValorUnitario"]=number_format(round($registros2["ValorUnitario"]));	
$tbl = <<<EOD

<table border="1" cellpadding="1" cellspacing="1" align="center" style="border-left: 1px solid #000099;
		border-right: 1px solid #000099;
		border-top: 1px solid #000099;
		border-bottom: 1px solid #000099;">
 <tr nobr="true">
  <td style= "border: 1px solid #000099;" >$registros2[Cantidad]</td><td colspan="3" style= "border: 1px solid #000099;">$registros2[Descripcion]</td>
  <td style= "border: 1px solid #000099;">$$registros2[ValorUnitario]</td><td style= "border: 1px solid #000099;">$$registros2[Subtotal]</td>
 </tr>
</table>
 
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
		  
}

	
	
}
	

	
$tbl = <<<EOD
 <br>
  <br>
<table border="1" cellpadding="1" cellspacing="1" align="center" style="border-left: 1px solid #000099;
		border-right: 1px solid #000099;
		border-top: 1px solid #000099;
		border-bottom: 1px solid #000099;">
				  
<tr nobr="true">
  <th colspan="2" align="right" style="border: 1px solid #000099;" >SUB-TOTAL</th><td align="right" style= "border: 1px solid #000099;">$$SubTotal</td>
  
 </tr>
 
 <tr nobr="true">
  <td colspan="2" align="right" style= "border: 1px solid #000099;">I.V.A.</td><td align="right"  style= "border: 1px solid #000099;">$$IVACoti</td>
 </tr>
 
 <tr nobr="true">
  <td colspan="2" align="right" style= "border: 1px solid #000099;">TOTAL</td><td align="right"  style= "border: 1px solid #000099;">$$Total</td>
 </tr>


</table>

<br><br><span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>$DatosEmpresa[ResolucionDian] </em></strong></span><br>
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"></span><br><br>
<table border="1" cellpadding="1" cellspacing="1" align="center" style="border-left: 1px solid #000099;
		border-right: 1px solid #000099;
		border-top: 1px solid #000099;
		border-bottom: 1px solid #000099;">
				  
<tr nobr="true">
  <th  align="left" style="border: 1px solid #000099;" >OBSERVACIONES:<br>$ObsevacionesFactura</th>
  
 </tr>
 
 

</table>


<table border="1" cellpadding="1" cellspacing="1" align="center" style="border-left: 1px solid #000099;
		border-right: 1px solid #000099;
		border-top: 1px solid #000099;
		border-bottom: 1px solid #000099;">
				  
<tr nobr="true">
  <th  align="left" style="border: 1px solid #000099;" >FACTURACION</th><td align="left" style= "border: 1px solid #000099;">ACEPTADA<BR> ____________________<BR>C.C./NIT.:</td>
  <td align="left" style= "border: 1px solid #000099;">FECHA RECIBIDO</td>
  
 </tr>
 
 

</table>
 
 <div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:241px;height:18px;z-index:8;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:8px;">Factura Generada por SOFTCONTECH, Software Diseñado por TECHNO SOLUCIONES SAS NIT 900833180-7, 317 774 0609, info@technosoluciones.com</div></span>

EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');		

//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>