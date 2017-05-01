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
            $TotalVenta=$obVenta->Sume("preventa", "TotalVenta", " WHERE VestasActivas_idVestasActivas='$idPreventa'");
            $css->CrearTabla();
            $css->FilaTabla(16);
            $css->ColTabla("<strong>Asignar</strong>", 1);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>Cupo</strong>", 1);
            $css->ColTabla("<strong>Debe</strong>", 1);
            $css->ColTabla("<strong>Cupo Disponible</strong>", 1);
            $css->CierraFilaTabla();
            while($DatosCliente=$obVenta->FetchArray($Consulta)){  
                $css->FilaTabla(16);
                $Deuda=$obVenta->Sume("cartera", "Saldo", "WHERE idCliente='$DatosCliente[idClientes]'");
                $CupoDisponible=$DatosCliente["Cupo"]-$Deuda;
                $Aplica=$CupoDisponible-$TotalVenta;
                $Link=$myPage."?CmbPreVentaAct=$idPreventa&idClientes=$DatosCliente[idClientes]";
                if($Aplica >= 0){                    
                    print("<td>");
                    $css->CrearLink($Link, "_self", "Asignar");
                    print("</td>");
                    $css->ColTabla("<strong style='color:blue'>$DatosCliente[RazonSocial]</strong>", 1);
                    $css->ColTabla("<strong style='color:blue'>$DatosCliente[Num_Identificacion]</strong>", 1);
                    $css->ColTabla("<strong style='color:blue'>".number_format($DatosCliente["Cupo"])."</strong>", 1);
                    $css->ColTabla("<strong style='color:blue'>".number_format($Deuda)."</strong>", 1);
                    $css->ColTabla("<strong style='color:blue'>".number_format($CupoDisponible)."</strong>", 1);
                    
                }else{
                    print("<td>");
                    $css->CrearLink($Link, "_self", "Asignar");
                    print("</td>");
                    $css->ColTabla("$DatosCliente[RazonSocial]", 1);
                    $css->ColTabla("$DatosCliente[Num_Identificacion]", 1);
                    $css->ColTabla("".number_format($DatosCliente["Cupo"])."", 1);
                    $css->ColTabla("".number_format($Deuda)."", 1);
                    $css->ColTabla("".number_format($CupoDisponible)."", 1);
                }
            }
            $css->CerrarTabla();
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