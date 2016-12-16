<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php

$myPage="DatosCuentaXPagar.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta(1);
$key=$obVenta->normalizar($_GET['key']);
if($key<>""){
    
    

    $css->CrearNotificacionAzul("Datos del Titulo", 16);
    
    $Resultados=$obVenta->ConsultarTabla("titulos_cuentasxcobrar"," WHERE (idTercero = '$key'  OR Mayor = '$key' OR RazonSocial LIKE '%$key%') AND Saldo>0 LIMIT 100");
    if($obVenta->NumRows($Resultados)>0){
        $css->CrearTabla();    
        $css->FilaTabla(16);
        $css->ColTabla('<strong>RazonSocial</strong>', 1);
        $css->ColTabla('<strong>Identificacion</strong>', 1);
        $css->ColTabla('<strong>Direccion</strong>', 1);
        $css->ColTabla('<strong>TotalAbonos</strong>', 1);
        $css->ColTabla('<strong>Saldo</strong>', 1);
        $css->ColTabla('<strong>UltimoPago</strong>', 1);
        $css->ColTabla('<strong>Mayor</strong>', 1);
        $css->CierraFilaTabla();
        
        while($DatosCuentasXPagar=$obVenta->FetchArray($Resultados)){


        $css->FilaTabla(16);
        $css->ColTabla($DatosCuentasXPagar['RazonSocial'], 1);
        $css->ColTabla($DatosCuentasXPagar['idTercero'], 1);
        $css->ColTabla($DatosCuentasXPagar['Direccion'], 1);
        $css->ColTabla($DatosCuentasXPagar['TotalAbonos'], 1);
        $css->ColTabla($DatosCuentasXPagar['Saldo'], 1);
        $css->ColTabla($DatosCuentasXPagar['UltimoPago'], 1);
        $css->ColTabla($DatosCuentasXPagar['Mayor'], 1);

        $css->CierraFilaTabla();

        }
        $css->CerrarTabla(); 
    }else{
       $css->CrearNotificacionRoja("Sin Resultados", 16); 
    }
    
}else{
    $css->CrearNotificacionRoja("Digite un Dato", 16);
}

?>
</body>
</html>