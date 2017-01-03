<?php 
include_once("../modelo/php_conexion.php");
include_once("../modelo/php_tablas.php");
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta(1);
 if(isset($_REQUEST["BtnVerInforme"])){
        
        $FechaIni=$obVenta->normalizar($_REQUEST["TxtFechaIni"]);
        $FechaFin=$obVenta->normalizar($_REQUEST["TxtFechaFinal"]);
        $Respuesta=$obTabla->GenereInterfaceIngresos($FechaIni,$FechaFin,"");
        
}

?>