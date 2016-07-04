<?php

include("../../modelo/php_conexion.php");

////////////////////////////////////////////
/////////////Obtengo el rango de fechas
////////////////////////////////////////////

$fecha=date("Y-m-d");
$FechaIni = $_POST["TxtFechaIni"];
$FechaFinal = $_POST["TxtFechaFinal"];
$CentroCostos=$_POST["CmbCentroCostos"];
$EmpresaPro=$_POST["CmbEmpresaPro"];
$TipoReporte=$_POST["CmbTipoReporte"];

$Condicion=" WHERE ";

if($TipoReporte=="Corte"){
    $Condicion.=" Fecha <= '$FechaFinal' ";
    $Rango="Corte a $FechaFinal";
}else{
    $Condicion.=" Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' "; 
    $Rango="De $FechaIni a $FechaFinal";
}
if($CentroCostos<>"ALL"){
	$Condicion.="  AND idCentroCosto='$CentroCostos' ";
}
	
if($EmpresaPro<>"ALL"){
	$Condicion.="  AND idEmpresa='$EmpresaPro' ";
}

$idFormatoCalidad=14;

$Documento="<strong>Reporte de Movimientos $Rango</strong>";
require_once('Encabezado.php');
		  
		  $nombre_file=$fecha."_Balance_Comprobacion";
		   

///////////////////////////////////////////////////////
//////////////encabezado//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<hr id="Line1" style="margin:0;padding:0;position:absolute;left:0px;top:44px;width:625px;height:2px;z-index:1;">
<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Fecha: $fecha</span></div>

<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:10px;text-align:center;z-index:2;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>MOVIMIENTO DE CUENTAS
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

$sel1=mysql_query("SELECT CuentaPUC as Cuenta, SUM(Debito) as SumDebito, SUM(Credito) as SumCredito, NombreCuenta as NombreCuenta FROM librodiario $Condicion
GROUP BY CuentaPUC",$con) or die("problemas con la consulta 1".mysql_error());

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
		$NombreCuenta=$DatosLibro["NombreCuenta"];
		//$reg=mysql_query("SELECT Nombre FROM subcuentas WHERE PUC = '$Cuenta'")	or die("problemas con la consulta".mysql_error());
		//$DatosCuentas=mysql_fetch_array($reg);
		
		$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center">
 <tr style= "background-color:$back;">
  <td>$DatosLibro[Cuenta]</td><td>$NombreCuenta</td>
  <td>$Debitos</td><td>$Creditos</td><td>$Diferencia</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	
}	

$sel1=mysql_query("SELECT SUM(Debito) as SumDebito, SUM(Credito) as SumCredito FROM librodiario $Condicion",$con) 
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
$Condicion AND (Mayor='NO') AND  (substring(CuentaPUC,1,1) = 4) 
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

///////Inicializacion de variables

//print("el total de ingresos es: $TotalIngresos");
$UtilidadNeta=0;
$UtilidadBruta=0;
$NumberUti=0;
$TotalCostos=0;

//////////////////////////////////////

$tbl = <<<EOD

<table border="1" cellpadding="3" cellspacing="5" align="center" >
  <tr style= "background-color:#3865EC; color: white;" > 
    <th colspan=3><h3>COSTOS</h3></th>
    
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sel1=mysql_query("SELECT substring(CuentaPUC,1,4) as Cuenta, SUM(Debito) as SumDebito, SUM(Credito) as SumCredito FROM librodiario 
$Condicion AND (Mayor='NO') AND  (substring(CuentaPUC,1,1) = 6) 
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


}
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
$Condicion AND  (substring(CuentaPUC,1,1) = 5) 
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
$Condicion AND  (substring(CuentaPUC,1,1) = 1) 
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
$Condicion AND  (substring(CuentaPUC,1,1) = 2) 
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
$Condicion AND  (substring(CuentaPUC,1,1) = 3)
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