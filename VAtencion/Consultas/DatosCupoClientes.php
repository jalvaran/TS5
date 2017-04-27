<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
$myPage="VentasRapidasV2.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta($idUser);
    $idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
    $key=$obVenta->normalizar($_REQUEST['TxtConsultaCupo']);
    if(strlen($key)>3){
        $sql="SELECT idClientes,Num_Identificacion, RazonSocial, Cupo FROM clientes WHERE Num_Identificacion='$key' or RazonSocial LIKE '%$key%'";
        $Consulta=$obVenta->Query($sql);
        if($obVenta->NumRows($Consulta)){
            while($DatosCliente=$obVenta->FetchArray($Consulta)){                
                $Deuda=$obVenta->Sume("cartera", "Saldo", "WHERE idCliente='$DatosCliente[idClientes]'");
                $CupoDisponible=$DatosCliente["Cupo"]-$Deuda;
                if($CupoDisponible > 100){
                    $css->CrearNotificacionVerde("El Cliente $DatosCliente[RazonSocial] $DatosCliente[Num_Identificacion] cuenta con un cupo de $".number_format($DatosCliente["Cupo"]).", Debe $".number_format($Deuda).", Tiene un cupo disponible de: ".number_format($CupoDisponible), 18);
                }else{
                    $css->CrearNotificacionRoja("El Cliente $DatosCliente[RazonSocial] $DatosCliente[Num_Identificacion] cuenta con un cupo de $".number_format($DatosCliente["Cupo"]).", Debe $".number_format($Deuda).", Tiene un cupo disponible de: ".number_format($CupoDisponible).", No tiene Acceso a mas creditos", 18);
                }
            }
        }else{
            $css->CrearNotificacionNaranja("No se encontraron datos", 18);
        }
    }else{
        $css->CrearNotificacionNaranja("Debes introducir al menos 4 caracteres", 18);
    }
    
$css->AgregaJS(); //Agregamos javascripts
?>
    
</body>
</html>