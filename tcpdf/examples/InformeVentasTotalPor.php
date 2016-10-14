<?php

include("../../modelo/php_conexion.php");

////////////////////////////////////////////
/////////////Obtengo el rango de fechas
////////////////////////////////////////////
$VerFacturas=0;
$obVenta = new ProcesoVenta(1);
$fecha=date("Y-m-d");
$FechaIni = $obVenta->normalizar($_POST["TxtFechaIniP"]);
$FechaFinal = $obVenta->normalizar($_POST["TxtFechaFinP"]);
$Porcentaje=$obVenta->normalizar($_POST["TxtPorcentaje"])/100;

$Condicion=" ori_facturas_items WHERE ";
$Condicion2="ori_facturas WHERE ";

$CondicionFecha1=" FechaFactura >= '$FechaIni' AND FechaFactura <= '$FechaFinal' ";
$CondicionFecha2=" Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' ";
$Rango="De $FechaIni a $FechaFinal";


$CondicionItems=$Condicion.$CondicionFecha1;
$CondicionFacturas=$Condicion2.$CondicionFecha2;

$idFormatoCalidad=16;

$Documento="<strong>Informe De Ventas $Rango</strong>";
require_once('Encabezado.php');

$nombre_file=$fecha."_Reporte_Fiscal";
		   

///////////////////////////////////////////////////////
//////////////tabla con los datos de ventas//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Total de Ventas Discriminadas por Departamento:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Departamento</h3></th>
	<th><h3>Nombre</h3></th>
	<th><h3>Total Items</h3></th>
    <th><h3>SubTotal</h3></th>
	<th><h3>IVA</h3></th>
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

if(isset($_POST["BtnAplicar"])){
$sql="UPDATE ori_facturas_items SET SubtotalItem=(SubtotalItem*$Porcentaje), IVAItem=(IVAItem*$Porcentaje), TotalItem=(TotalItem*$Porcentaje) "
        . "  WHERE $CondicionFecha1";
$obVenta->Query($sql);
}

if(isset($_POST["BtnVistaPrevia"])){
$sql="SELECT Departamento as idDepartamento, ROUND(SUM(SubtotalItem)*$Porcentaje) as Subtotal, ROUND(SUM(IVAItem)*$Porcentaje) as IVA, ROUND(SUM(TotalItem)*$Porcentaje) as Total, SUM(Cantidad) as Items"
        . "  FROM $CondicionItems GROUP BY Departamento";
}else{
   $sql="SELECT Departamento as idDepartamento, SUM(SubtotalItem) as Subtotal, SUM(IVAItem) as IVA, SUM(TotalItem) as Total, SUM(Cantidad) as Items"
        . "  FROM $CondicionItems GROUP BY Departamento"; 
}


$Datos=$obVenta->Query($sql);

$Subtotal=0;
$TotalIVA=0;
$TotalVentas=0;
$TotalItems=0;
$flagQuery=0;   //para indicar si hay resultados
$i=0;

while($DatosVentas=$obVenta->FetchArray($Datos)){
        $flagQuery=1;	
        $SubtotalUser=number_format($DatosVentas["Subtotal"]);
        $IVA=number_format($DatosVentas["IVA"]);
        $Total=number_format($DatosVentas["Total"]);
        $Items=number_format($DatosVentas["Items"]);
        $DatosDepartamento=$obVenta->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosVentas["idDepartamento"]);
        $NombreDep=$DatosDepartamento["Nombre"];

        $Subtotal=$Subtotal+$DatosVentas["Subtotal"];
        $TotalIVA=$TotalIVA+$DatosVentas["IVA"];
        $TotalVentas=$TotalVentas+$DatosVentas["Total"];
        $TotalItems=$TotalItems+$DatosVentas["Items"];
        $idDepartamentos=$DatosVentas["idDepartamento"];


        $tbl = <<<EOD

<table border="1" cellpadding="2"  align="center">
 <tr>
  <td>$idDepartamentos</td>
  <td>$NombreDep</td>
  <td>$Items</td>
  <td>$SubtotalUser</td>
  <td>$IVA</td>
  <td>$Total</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

}
	
if($flagQuery==1){
$TotalItems=number_format($TotalItems);
$Subtotal=number_format($Subtotal);
$TotalIVA=number_format($TotalIVA);
$TotalVentas=number_format($TotalVentas);
$tbl = <<<EOD

<table border="1" cellspacing="2" align="center">
 <tr>
  <td align="RIGHT"><h3>SUMATORIA</h3></td>
  <td><h3>NA</h3></td>
  <td><h3>$TotalItems</h3></td>
  <td><h3>$Subtotal</h3></td>
  <td><h3>$TotalIVA</h3></td>
  <td><h3>$TotalVentas</h3></td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
        }

/*
///////////////////////////////////////////////////////
//////////////tabla con los datos de ventas//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<br><br><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Total de Ventas Discriminadas por Usuarios y Tipo de Venta:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Usuario</h3></th>
	<th><h3>TipoVenta</h3></th>
	<th><h3>Total Costos</h3></th>
    <th><h3>SubTotal</h3></th>
	<th><h3>IVA</h3></th>
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


$sql="SELECT Usuarios_idUsuarios as IdUsuarios, FormaPago as  TipoVenta, SUM(Subtotal) as Subtotal, SUM(IVA) as IVA, 
SUM(Total) as Total, SUM(TotalCostos) as TotalCostos"
        . "  FROM $CondicionFacturas GROUP BY Usuarios_idUsuarios, FormaPago";

$Datos=$obVenta->Query($sql);




$Subtotal=0;
$TotalIVA=0;
$TotalVentas=0;
$TotalCostos=0;
$flagQuery=0;
$i=0;
while($DatosVentas=$obVenta->FetchArray($Datos)){
        $flagQuery=1;
        $SubtotalUser=number_format($DatosVentas["Subtotal"]);
        $IVA=number_format($DatosVentas["IVA"]);
        $Total=number_format($DatosVentas["Total"]);
        $Costos=number_format($DatosVentas["TotalCostos"]);
        $TipoVenta=$DatosVentas["TipoVenta"];

        $Subtotal=$Subtotal+$DatosVentas["Subtotal"];
        $TotalIVA=$TotalIVA+$DatosVentas["IVA"];
        $TotalVentas=$TotalVentas+$DatosVentas["Total"];
        $TotalCostos=$TotalCostos+$DatosVentas["TotalCostos"];
        $idUser=$DatosVentas["IdUsuarios"];


        $tbl = <<<EOD

<table border="1" cellpadding="2"  align="center">
<tr>
<td>$idUser</td>
<td>$TipoVenta</td>
<td>$Costos</td>
<td>$SubtotalUser</td>
<td>$IVA</td>
<td>$Total</td>
</tr>
</table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
    }

if($flagQuery==1){
    $TotalCostos=number_format($TotalCostos);
    $Subtotal=number_format($Subtotal);
    $TotalIVA=number_format($TotalIVA);
    $TotalVentas=number_format($TotalVentas);
    $tbl = <<<EOD

<table border="1" cellspacing="2" align="center">
<tr>
<td align="RIGHT"><h3>SUMATORIA</h3></td>
<td><h3>NA</h3></td>
<td><h3>$TotalCostos</h3></td>
<td><h3>$Subtotal</h3></td>
<td><h3>$TotalIVA</h3></td>
<td><h3>$TotalVentas</h3></td>
</tr>
</table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


}

*/
////////////////////////////////////////////////////////////////////////////////
/////////////////////////FACTURAS NUMERACION////////////////////////////
////////////////////////////////////////////////////////////////////////////////

$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Informe de Numeracion Facturas:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Resolucion</h3></th>
    <th><h3>Factura Inicial</h3></th>
    <th><h3>Factura Final</h3></th>
    <th><h3>Total Clientes</h3></th>
	
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

$sql="SELECT idResolucion,MAX(NumeroFactura) as MaxFact, MIN(NumeroFactura) as MinFact FROM facturas
	WHERE $CondicionFecha2 GROUP BY idResolucion";
$sel1=$obVenta->Query($sql);


while($DatosNumFact=$obVenta->FetchArray($sel1)){
	$MinFact=$DatosNumFact["MinFact"];
	$MaxFact=$DatosNumFact["MaxFact"];
        $idResolucion=$DatosNumFact["idResolucion"];
	$TotalFacts=$MaxFact-$MinFact+1;
	
	
	
$tbl = <<<EOD

<table border="1"  cellpadding="2" align="center">
 <tr>
  <td>$idResolucion</td>
  <td>$MinFact</td>
  <td>$MaxFact</td>
  <td>$TotalFacts</td>
 
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}


////////////////////////////////////////////////////////////////////////////////
/////////////////////////TIPO VENTAS////////////////////////////
////////////////////////////////////////////////////////////////////////////////

$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Tipo de Ventas:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Efectivo</h3></th>
    <th><h3>Ventas al Detal</h3></th>
    <th><h3>Ventas al Por mayor</h3></th>
    
	
  </tr >
  <tr> 
    <th><h3>$TotalVentas</h3></th>
    <th><h3>$TotalVentas</h3></th>
    <th><h3>0</h3></th>
    
	
  </tr >
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');



/*
///////////////////////////////////////////////////////
//////////////tabla con los datos DE LAS DEVOLUCIONES//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Total devoluciones:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Usuario</h3></th>
	<th><h3>Total Items</h3></th>
    <th><h3>SubTotal</h3></th>
	<th><h3>IVA</h3></th>
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');



	$sel1=mysql_query("SELECT Usuarios_idUsuarios as IdUsuarios, SUM(Subtotal) as Subtotal, SUM(IVA) as IVA, SUM(Total) as Total, SUM(Cantidad) as Items FROM ventas_devoluciones
	WHERE FechaDevolucion >= '$FechaIni' AND FechaDevolucion <= '$FechaFinal' 
	GROUP BY Usuarios_idUsuarios",$con) or die("problemas con la consulta a join ventas ".mysql_error());



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
		
		$Subtotal=$Subtotal+$DatosVentas["Subtotal"];
		$TotalIVA=$TotalIVA+$DatosVentas["IVA"];
		$TotalVentas=$TotalVentas+$DatosVentas["Total"];
		$TotalItems=$TotalItems+$DatosVentas["Items"];
		$idUser=$DatosVentas["IdUsuarios"];
		
		
		$tbl = <<<EOD

<table border="1"  cellpadding="2" align="center">
 <tr>
  <td>$idUser</td>
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


///////////////////////////////////////////////////////
//////////////tabla con los datos DE Los egresos//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Total Egresos:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Usuario</h3></th>
    <th><h3>SubTotal</h3></th>
	<th><h3>IVA</h3></th>
	<th><h3>Total</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');



	$sel1=mysql_query("SELECT Usuario_idUsuario as IdUsuarios, SUM(Subtotal) as Subtotal, SUM(IVA) as IVA, SUM(Valor) as Total FROM egresos
	WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' AND Cuenta='110510' AND PagoProg<>'Programado'
	GROUP BY Usuario_idUsuario",$con) or die("problemas con la consulta a egresos ".mysql_error());



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
		
		
		$Subtotal=$Subtotal+$DatosVentas["Subtotal"];
		$TotalIVA=$TotalIVA+$DatosVentas["IVA"];
		$TotalVentas=$TotalVentas+$DatosVentas["Total"];
		
		$idUser=$DatosVentas["IdUsuarios"];
		
		
		$tbl = <<<EOD

<table border="1"  cellpadding="2" align="center">
 <tr>
  <td>$idUser</td>
  
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
  
  <td><h3>$Subtotal</h3></td>
  <td><h3>$TotalIVA</h3></td>
  <td><h3>$TotalVentas</h3></td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}


///////////////////////////////////////////////////////
//////////////tabla con los datos DE Los Abonos//////////////////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Total Abonos:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Usuario</h3></th>
	<th><h3>Total</h3></th>
    
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');



	$sel1=mysql_query("SELECT Usuarios_idUsuarios as IdUsuarios, SUM(Monto) as Subtotal FROM facturas_abonos
	WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' 
	GROUP BY Usuarios_idUsuarios",$con) or die("problemas con la consulta a join ventas ".mysql_error());



if(mysql_num_rows($sel1)){
	$Subtotal=0;
	
	
	
	while($DatosVentas=mysql_fetch_array($sel1)){
			
		$SubtotalUser=number_format($DatosVentas["Subtotal"]);
		
		
		$Subtotal=$Subtotal+$DatosVentas["Subtotal"];
		
		$idUser=$DatosVentas["IdUsuarios"];
		
		
		$tbl = <<<EOD

<table border="1"  cellpadding="2" align="center">
 <tr>
  <td>$idUser</td>
  
  <td>$SubtotalUser</td>
 
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
	
	$Subtotal=number_format($Subtotal);
	
	$tbl = <<<EOD

<table border="1" cellspacing="2" align="center">
 <tr>
  <td align="RIGHT"><h3>SUMATORIA</h3></td>
 
  <td><h3>$Subtotal</h3></td>
  
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}



////////////////////////////////////////////////////////
//////////////tabla con los datos de las entregas///////
////////////////////////////////////////////////////////


$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Entregas:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
	
    <th><h3>Usuario</h3></th>
	<th><h3>Ventas</h3></th>
    <th><h3>Abonos</h3></th>
	<th><h3>Devoluciones</h3></th>
	<th><h3>Egresos</h3></th>
	<th><h3>Entrega</h3></th>
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

$sql="SELECT Usuarios_idUsuarios as IdUsuarios, Fecha as Fecha, FormaPago as  TipoVenta, SUM(Subtotal) as Subtotal, SUM(IVA) as IVA, 
SUM(Total) as Total, SUM(TotalCostos) as TotalCostos"
        . "  FROM $CondicionFacturas GROUP BY Usuarios_idUsuarios";

$Datos=$obVenta->Query($sql);

/*

	$sel1=mysql_query("SELECT f.Fecha as Fecha,f.Usuarios_idUsuarios as IdUsuarios, f.FormaPago as  TipoVenta, SUM(c.Subtotal) as Subtotal, SUM(c.IVA) as IVA, 
SUM(c.Total) as Total,SUM(c.Descuento) as Descuentos, SUM(c.Cantidad) as Items 
FROM facturas f INNER JOIN cotizaciones c ON f.Cotizaciones_idCotizaciones=c.NumCotizacion 
INNER JOIN productosventa pr ON c.Referencia = pr.Referencia 
INNER JOIN prod_departamentos dpt ON dpt.idDepartamentos = pr.Departamento
WHERE f.Fecha >= '$FechaIni' AND f.Fecha <= '$FechaFinal' 
	GROUP BY f.Usuarios_idUsuarios",$con) or die("problemas con la consulta a join facturas ".mysql_error());






	$flagQuery=0;
	$TotalVentas=0;
	$TotalAbonos=0;
	$TotalDevoluciones=0;
	$TotalEgresos=0;
	$TotalEntrega=0;
	
	while($DatosVentas=$obVenta->FetchArray($Datos)){
		$flagQuery=1;	
		$TotalUser=number_format($DatosVentas["Total"]);
		$FechaU=$DatosVentas["Fecha"];
		$idUser=$DatosVentas["IdUsuarios"];
		$TotalVentas=$TotalVentas+$DatosVentas["Total"];
		
		//////////////////////Consulto abonos del usuario
		
		$DatosAbonos=mysql_query("SELECT SUM(Monto) as TotalAbonos FROM facturas_abonos
		WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' AND Usuarios_idUsuarios = '$idUser' ",$con) or die("problemas con la consulta a abonos en entregas ".mysql_error());
		$DatosAbonos=mysql_fetch_array($DatosAbonos);
		$TotalAbonosUser=number_format($DatosAbonos['TotalAbonos']);
		$TotalAbonos=$TotalAbonos+$DatosAbonos['TotalAbonos'];
		
		//////////////////////Consulto devoluciones del usuario
		
		$DatosDevoluciones=mysql_query("SELECT SUM(Total) as TotalDevoluciones FROM ventas_devoluciones
		WHERE FechaDevolucion >= '$FechaIni' AND FechaDevolucion <= '$FechaFinal' AND Usuarios_idUsuarios = '$idUser' ",$con) or die("problemas con la consulta a devoluciones en entregas ".mysql_error());
		$DatosDevoluciones=mysql_fetch_array($DatosDevoluciones);
		$TotalDevolucionesUser=number_format($DatosDevoluciones['TotalDevoluciones']);
		$TotalDevoluciones=$TotalDevoluciones+$DatosDevoluciones['TotalDevoluciones'];
		
		//////////////////////Consulto egresos del usuario
		
		$DatosEgresos=mysql_query("SELECT SUM(Valor) as TotalEgresos FROM egresos
		WHERE Fecha >= '$FechaIni' AND Fecha <= '$FechaFinal' AND Usuario_idUsuario = '$idUser' ",$con) or die("problemas con la consulta a egresos en entregas ".mysql_error());
		$DatosEgresos=mysql_fetch_array($DatosEgresos);
		$TotalEgresosUser=number_format($DatosEgresos['TotalEgresos']);
		$TotalEgresos=$TotalDevoluciones+$DatosEgresos['TotalEgresos'];
		
		//////////////////////Calculo Entregas
			
		$TotalEntregaUser=$DatosVentas["Total"]+$DatosAbonos['TotalAbonos']-$DatosDevoluciones['TotalDevoluciones']-$DatosEgresos['TotalEgresos'];
		
		$TotalEntrega=$TotalEntrega+$TotalEntregaUser;
		$TotalEntregaUser=number_format($TotalEntregaUser);
		
		$tbl = <<<EOD

<table border="1"  cellpadding="2" align="center">
 <tr>
  <td>$idUser</td>
  <td>$TotalUser</td>
  <td>$TotalAbonosUser</td>
  <td>$TotalDevolucionesUser</td>
  <td>$TotalEgresosUser</td>
  <td>$TotalEntregaUser</td>
 
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	}
	
if($flagQuery==1){
	$TotalVentas=number_format($TotalVentas);
	$TotalAbonos=number_format($TotalAbonos);
	$TotalDevoluciones=number_format($TotalDevoluciones);
	$TotalEgresos=number_format($TotalEgresos);
	$TotalEntrega=number_format($TotalEntrega);
	
	
	
	$tbl = <<<EOD

<table border="1" cellspacing="2" align="center">
 <tr>
  <td align="RIGHT"><h3>SUMATORIA</h3></td>
 
  <td><h3>$TotalVentas</h3></td>
  <td><h3>$TotalAbonos</h3></td>
  <td><h3>$TotalDevoluciones</h3></td>
  <td><h3>$TotalEgresos</h3></td>
  <td><h3>$TotalEntrega</h3></td>
  
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}

if($VerFacturas==1){
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
	$TotalFacts=$DatosNumFact["TotalFacts"];
	
	
	
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


////////////////////////////////////////////////////////////////////////////////
/////////////////////////BUSCAMOS FACTURAS FALTANTES////////////////////////////
////////////////////////////////////////////////////////////////////////////////

$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Informe de Numeracion Facturas Faltantes:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
    <th><h3>Rango Faltante</h3></th>
	<th><h3>Factura Faltante Inicio</h3></th>
    <th><h3>Factura Faltante Fin</h3></th>
	
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

$i=0;
$sql="SELECT (t1.idFacturas + 1) as gap_starts_at, (SELECT MIN(t3.idFacturas) -1 FROM facturas t3 WHERE t3.idFacturas > t1.idFacturas) as gap_ends_at FROM facturas t1 
 WHERE NOT EXISTS (SELECT t2.idFacturas FROM facturas t2 WHERE t2.idFacturas = t1.idFacturas + 1) HAVING gap_ends_at IS NOT NULL ";
$Res=mysql_query($sql,$con) or die("No se pudo consultar los numeros de las facturas libres ".mysql_error());


while($DatosFacturacion=mysql_fetch_array($Res)){
	$FacturaFaltanteInicio=$DatosFacturacion["gap_starts_at"];
	$FacturaFaltanteFin=$DatosFacturacion["gap_ends_at"];
	$i++;
	
$tbl = <<<EOD

<table border="1"  cellpadding="2" align="center">
 <tr>
  <td>$i</td>
  <td>$FacturaFaltanteInicio</td>
  <td>$FacturaFaltanteFin</td>
 
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	
}
} 
 */
//$pdf->writeHTML($tab, false, false, false, false, '');
//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>