<?php 
if(isset($_REQUEST["idDocumento"])){
    $myPage="GeneradorExcel.php";
    include_once("../../modelo/php_conexion.php");
    include_once("../../modelo/php_tablas.php");
    include_once("../clases/ClasesDocumentosExcel.php");
    session_start();    
    $idUser=$_SESSION['idUser'];
    $obVenta = new ProcesoVenta($idUser);
    $obExcel=new TS5_Excel($db);
    $idDocumento=$obVenta->normalizar($_REQUEST["idDocumento"]);
    
    switch ($idDocumento){
        case 1: //Balance de comprobacion
            $FechaInicial=$obVenta->normalizar($_REQUEST["TxtFechaIniBC"]);
            $FechaFinal=$obVenta->normalizar($_REQUEST["TxtFechaFinalBC"]);
            $FechaCorte=$obVenta->normalizar($_REQUEST["TxtFechaCorteBC"]);
            $TipoReporte=$obVenta->normalizar($_REQUEST["CmbTipoReporteBC"]);
            $idEmpresa=$obVenta->normalizar($_REQUEST["CmbEmpresaProBC"]);
            $CentroCosto=$obVenta->normalizar($_REQUEST["CmbCentroCostosBC"]);
            $obExcel->GenerarBalanceComprobacionExcel($TipoReporte,$FechaInicial,$FechaFinal,$FechaCorte,$idEmpresa,$CentroCosto,"");
            
            break;
        
    }
}else{
    print("No se recibió parametro de documento");
}

?>