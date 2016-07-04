<?php

include("../../modelo/php_conexion.php");

////////////////////////////////////////////
/////////////Obtengo el ID del comprobante a que se imprimirá 
////////////////////////////////////////////
$idComprobante = $_REQUEST["ImgPrintIngreso"];

$idFormatoCalidad=4;

$Documento="<strong>COMPROBANTE DE INGRESO No. $idComprobante</strong>";
require_once('Encabezado.php');
////////////////////////////////////////////
/////////////Obtengo valores de la Remision
////////////////////////////////////////////
			
$obVenta=new ProcesoVenta(1);
$DatosIngreso=$obVenta->DevuelveValores("comprobantes_ingreso","ID",$idComprobante);
$fecha=$DatosIngreso["Fecha"];
$Concepto=$DatosIngreso["Concepto"];
$Clientes_idClientes=$DatosIngreso["Clientes_idClientes"];
$Usuarios_idUsuarios=$DatosIngreso["Usuarios_idUsuarios"];
$Tercero=$DatosIngreso["Tercero"];
if($Clientes_idClientes>0){
    $DatosCliente=$obVenta->DevuelveValores("clientes","idClientes",$Clientes_idClientes);
}else{
    $DatosCliente=$obVenta->DevuelveValores("proveedores","idProveedores",$Tercero);
}



$DatosEmpresaPro=$obVenta->DevuelveValores("empresapro","idEmpresaPro",1);
		  
$nombre_file="Comprobante_Ingreso_".$fecha."_".$DatosCliente["RazonSocial"];
		   

$Valor=number_format($DatosIngreso["Valor"]);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
    <tr>
        <td><strong>Ciudad:</strong> $DatosEmpresaPro[Ciudad]</td>
        <td><strong>Fecha:</strong> $DatosIngreso[Fecha]</td>
        <td><strong>No.:</strong> $idComprobante</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Recibido de:</strong> $DatosCliente[RazonSocial]</td>
        <td><strong>Valor: $</strong> $Valor</td>
    </tr>
    <tr>
        <td colspan="3"><strong>Dirección:</strong> $DatosCliente[Direccion]</td>
        
    </tr>
    <tr>
        <th colspan="3"><strong>Por concepto de:</strong> $DatosIngreso[Concepto]</th>
    </tr> 
    <tr>
        <th colspan="3"><strong>Tipo de pago:</strong> $DatosIngreso[Tipo]</th>
    </tr>
</table>
        
<br>
<hr id="Line3" style="margin:0;padding:0;position:absolute;left:0px;top:219px;width:625px;height:2px;z-index:9;">
  
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');

////////////////////////////////////////
///Dibujo movientos contables

$tbl = <<<EOD
<table border="0" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
    <tr align="center">
        <td><strong>Codigo PUC</strong></td>
        <td><strong>Cuenta</strong></td>
        <td><strong>Débitos</strong></td>
        <td><strong>Créditos</strong></td>
    </tr>
    
</table>
       
  
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');

$h=0;
$Consulta=$obVenta->ConsultarTabla("librodiario", "WHERE Tipo_Documento_Intero='ComprobanteIngreso' AND Num_Documento_Interno='$idComprobante'");

while($DatosLibro=  mysql_fetch_array($Consulta)){
    $Debito=  number_format($DatosLibro["Debito"]);
    $Credito=  number_format($DatosLibro["Credito"]);
    if($h==0){
        $Back="#f2f2f2";
        $h=1;
    }else{
        $Back="white";
        $h=0;
    }
$tbl = <<<EOD
<table border="0" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
    <tr align="left">
        <td style="border-bottom: 1px solid #ddd;background-color: $Back;">$DatosLibro[CuentaPUC]</td>
        <td style="border-bottom: 1px solid #ddd;background-color: $Back;">$DatosLibro[NombreCuenta]</td>
        <td style="border-bottom: 1px solid #ddd;background-color: $Back;">$Debito</td>
        <td style="border-bottom: 1px solid #ddd;background-color: $Back;">$Credito</td>
    </tr>
    
</table>
       
  
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
}

///////////
///////Espacio para firmas
//
//

$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="0" align="left">
    <tr align="left" >
        <td style="height: 100px;" >Recibe:</td>
        <td style="height: 100px;" >Entrega:</td>
        
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