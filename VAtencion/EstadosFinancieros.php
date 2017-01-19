<?php 
$myPage="EstadosFinancieros.php";
include_once("../sesiones/php_control.php");
$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);

if(isset($_REQUEST["BtnVerInforme"])){
    
    $FechaCorte = $obVenta->normalizar($_POST["TxtFechaCorteBalance"]);
    $CentroCostos=$obVenta->normalizar($_POST["CmbCentroCostos"]);
    $EmpresaPro=$obVenta->normalizar($_POST["CmbEmpresaPro"]);

    $obTabla->GenereEstadosFinancierosPDF($FechaCorte,$CentroCostos,$EmpresaPro,"");
}

?>