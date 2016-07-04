<?php

include("../../modelo/php_conexion.php");
////////////////////////////////////////////
/////////////Obtengo el ID de la Factura a que se imprimirá 
////////////////////////////////////////////

$idEgresos = $_REQUEST["ImgPrintComp"];

$idFormatoCalidad=11;

$Documento="<strong>COMPROBANTE DE EGRESO No. $idEgresos</strong>";
require_once('Encabezado.php');

////////////////////////////////////////////
/////////////Obtengo datos del egresos
////////////////////////////////////////////

$obVenta=new ProcesoVenta(1);
$DatosEgreso=$obVenta->DevuelveValores("egresos","idEgresos",$idEgresos);

$nombre_file=$DatosEgreso["idEgresos"]."_Egreso_".$DatosEgreso["Beneficiario"];
$fecha=$DatosEgreso["Fecha"];
$Concepto=$DatosEgreso["Concepto"];
$Tercero=$DatosEgreso["idProveedor"];
$Usuarios_idUsuarios=$DatosEgreso["Usuario_idUsuario"];
$Valor=  number_format($DatosEgreso["Valor"]-$DatosEgreso["Retenciones"]);
require_once('Egreso_DatosTercero.php');


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

$Consulta=$obVenta->ConsultarTabla("librodiario", "WHERE Tipo_Documento_Intero='CompEgreso' AND Num_Documento_Interno='$idEgresos'");

while($DatosLibro=  mysql_fetch_array($Consulta)){
    
    if($h==0){
        $Back="#f2f2f2";
        $h=1;
    }else{
        $Back="white";
        $h=0;
    }
    
    $Debito=  number_format($DatosLibro["Debito"]);
    $Credito=  number_format($DatosLibro["Credito"]);
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
        <br><br>
<table border="1" cellpadding="2" cellspacing="0" align="left">
    <tr align="left" >
        <td style="height: 70px;" ><strong>Total:</strong> $Valor</td>
        <td style="height: 70px;" >Recibido por:</td>
        <td style="height: 70px;" >Cedula:</td>
    </tr>
    <tr align="left" >
        <td style="height: 70px;" >Preparado:</td>
        <td style="height: 70px;" >Revisado:</td>
        <td style="height: 70px;" >Contabilidad:</td>
    </tr>
   
</table>
       
  
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');

//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+


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


				
		fwrite($handle,"Comprobante de egreso Numero: ".$idEgresos."..");
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Beneficiario: $DatosEgreso[8]");
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"NIT: ".$DatosEgreso[9]);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Direccion: ".$DatosEgreso[10]);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Factura No: ".$DatosEgreso["NumFactura"]);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Valor: ".($DatosEgreso["Valor"]-$DatosEgreso["Retenciones"]));
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle,"Concepto: ".$DatosEgreso[5]);
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle, chr(27). chr(100). chr(1));
		fwrite($handle,"Aprobado por: ________________________");
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle, chr(27). chr(100). chr(1));
		fwrite($handle,"Recibe: ______________________________");
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle, chr(27). chr(100). chr(1));
		fwrite($handle,"Cedula: ______________________________");
		fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		fwrite($handle, chr(27). chr(100). chr(1));//salto de linea


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


?>