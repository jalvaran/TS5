<?php
print("<meta http-equiv='refresh' content='60' />");
include_once("../modelo/php_conexion.php");
$obVenta = new ProcesoVenta(1);
$TipoConsulta=$obVenta->normalizar($_REQUEST["Tipo"]);
if($_REQUEST["Tipo"]=="Cronometro"){
    $DatosCrono=$obVenta->DevuelveValores("crono_controles", "ID", 1);
    if($DatosCrono["Estado"]=="PLAY"){
        print("<script>ClickElement('inicio')</script>");
        
    }
    if($DatosCrono["Estado"]=="STOP"){
        print("<script>ClickElement('parar')</script>");
        
    }
    if($DatosCrono["Estado"]=="REINICIO"){
        print("<script>ClickElement('reinicio')</script>");
        
    }
}

?>