<?php

include("../../modelo/php_conexion.php");
$BaseIVA=0;
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
$sql="UPDATE ori_facturas_items SET TotalItem = ROUND((TotalItem * $Porcentaje) , -2), SubtotalItem=TotalItem/1.16, IVAItem=SubtotalItem*0.16 "
        . "  WHERE $CondicionFecha1";
$obVenta->Query($sql);

$sql="UPDATE ori_facturas_items SET SubtotalItem=TotalItem, IVAItem=0 "
        . "  WHERE $CondicionFecha1 AND Departamento=7";
$obVenta->Query($sql);

//$obVenta->ActualizaFacturasFromItems($FechaIni,$FechaFinal,1,"");
}

if(isset($_POST["BtnVistaPrevia"])){
$sql="SELECT Departamento as idDepartamento, ROUND((SUM(TotalItem)*$Porcentaje),-2) as Total, (ROUND((SUM(TotalItem)*$Porcentaje),-2)/1.16) as Subtotal, (ROUND((SUM(TotalItem)*$Porcentaje),-2)/1.16)*0.16 as IVA,  SUM(Cantidad) as Items"
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
$TotalExluidos=0;
while($DatosVentas=$obVenta->FetchArray($Datos)){
        $flagQuery=1;	
        $SubtotalUser=number_format($DatosVentas["Subtotal"]);
        $IVA=number_format($DatosVentas["IVA"]);
        $Total=number_format($DatosVentas["Total"]);
        $Items=number_format($DatosVentas["Items"]);
        $DatosDepartamento=$obVenta->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosVentas["idDepartamento"]);
        $NombreDep=$DatosDepartamento["Nombre"];
        if($NombreDep=="EXCLUIDOS"){
            $SubtotalUser=$Total;
            $TotalExluidos=$TotalExluidos+$DatosVentas["Total"];
            $IVA=0;
            $DatosVentas["Subtotal"]=$DatosVentas["Total"];
            $DatosVentas["IVA"]=0;
        }
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
$BaseIVA=$Subtotal;
$TotalVentasFinal=$TotalVentas;
$TotalIVAFinal=$TotalIVA;
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
/////////////////////////INFORMACION DE IVA////////////////////////////
////////////////////////////////////////////////////////////////////////////////

$tbl = <<<EOD


<BR><BR><span style="color:RED;font-family:'Bookman Old Style';font-size:12px;"><strong><em>Informe con los Porcentajes de IVA en ventas:
</em></strong></span><BR><BR>


<table border="1" cellspacing="2" align="center" >
  <tr> 
	
    <th><h3>  </h3></th>
    <th><h3>Valor</h3></th>
    
	
  </tr >
  
</table>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

$TotalVentasIVA16=  number_format($BaseIVA-$TotalExluidos);
$TotalExluidos=number_format($TotalExluidos);
$tbl = <<<EOD

<table border="1"  cellpadding="2" align="center">
 <tr>
  <td>Venta Excluida </td>
  <td>$TotalExluidos</td>
  
 
 </tr>
 
 <tr>
  <td>Valor IVA 16% </td>
  <td>$TotalIVA</td>
  
 
 </tr>
        
  <tr>
  <td>Base 16% </td>
  <td>$TotalVentasIVA16</td>
  
 
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
	



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

if(isset($_POST["BtnAplicar"])){
    
    $PromedioSubtotal=round($BaseIVA/$TotalFacts);
    $PromedioIVA=$PromedioSubtotal*0.16;
    $PromedioTotal=$PromedioSubtotal+$PromedioIVA;

    $sql="UPDATE ori_facturas SET Total='$PromedioTotal',Subtotal='$PromedioSubtotal', IVA='$PromedioIVA' WHERE $CondicionFecha2";
    $obVenta->Query($sql);
}
 
//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>