<?php 
if(isset($_REQUEST["Opcion"])){
    $myPage="GeneradorCSV.php";
    include_once("../../modelo/php_conexion.php");
    
    session_start();    
    $idUser=$_SESSION['idUser'];
    $obVenta = new ProcesoVenta($idUser);
    $DatosRuta=$obVenta->DevuelveValores("configuracion_general", "ID", 1);
    $OuputFile=$DatosRuta["Valor"];
    $Link1=substr($OuputFile, -17);
    $Link="../../".$Link1;
    //print($Link);
    $a='"';
    $Enclosed=" ENCLOSED BY '$a' ";
    $Opcion=$_REQUEST["Opcion"];
    
    switch ($Opcion){
        case 1: //Balance de comprobacion
            
            unlink($Link);
            $Tabla=$obVenta->normalizar(base64_decode($_REQUEST["TxtT"]));
            $statement=$obVenta->normalizar(base64_decode($_REQUEST["TxtL"]));
            $Columnas=$obVenta->ShowColums($Tabla);
            $sqlColumnas="SELECT ";
            foreach($Columnas["Field"] as $Campo){
                $sqlColumnas.="'$Campo',";
            }
            $sqlColumnas=substr($sqlColumnas, 0, -1);
            $sqlColumnas.=" UNION ALL ";
            $Indice=$Columnas["Field"][0];
            $sql=$sqlColumnas."SELECT * FROM $statement ORDER BY $Indice DESC INTO OUTFILE '$OuputFile' FIELDS TERMINATED BY ';' $Enclosed LINES TERMINATED BY '\r\n';";
            $obVenta->Query($sql);
            print("Tabla $Tabla exportada exitosamente <a href='$Link'>Abrir</a>");
            break;
        case 2:   //Resumen de facturacion agrupado por referencia en un periodo de tiempo
            unlink($Link);
            $FechaIni=$obVenta->normalizar($_REQUEST["TxtFechaIni"]);
            $FechaFin=$obVenta->normalizar($_REQUEST["TxtFechaFin"]);
            $sql="SELECT 'ID', 'FECHA', 'REFERENCIA','NOMBRE', 'DEPARTAMENTO', 'SUB1', 'SUB2','SUB3', 'SUB4','SUB5', 'CANTIDAD','TOTAL VENTA','COSTOS' UNION ALL ";
            $sql.="SELECT ID,`FechaFactura`, `Referencia`,`Nombre`,`Departamento`,`SubGrupo1`,`SubGrupo2`,"
                . "`SubGrupo3`,`SubGrupo4`,`SubGrupo5`,SUM(`Cantidad`) as Cantidad,round(SUM(`TotalItem`),2) as TotalVenta,"
                . "round(SUM(`SubtotalCosto`),2) as Costo FROM `facturas_items` "
                . "WHERE `FechaFactura`>='$FechaIni' AND `FechaFactura`<='$FechaFin' "
                . "GROUP BY `Referencia`,`FechaFactura` "
                . " INTO OUTFILE '$OuputFile' FIELDS TERMINATED BY ';' $Enclosed LINES TERMINATED BY '\r\n';";
            $obVenta->Query($sql);
            print("Resumen de Facturacion Generado exitosamente <a href='$Link'>Abrir</a>");
            break;
        }
}else{
    print("No se recibió parametro de opcion");
}

?>