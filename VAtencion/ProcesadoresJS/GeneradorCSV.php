<?php 
if(isset($_REQUEST["Opcion"])){
    $myPage="GeneradorCSV.php";
    include_once("../../modelo/php_conexion.php");
    
    session_start();    
    $idUser=$_SESSION['idUser'];
    $obVenta = new ProcesoVenta($idUser);
    $OuputFile="../../htdocs/sctv5/exports/tabla.csv";
    $Link='../../exports/tabla.csv';
    $Enclosed=`OPTIONALLY ENCLOSED BY '"'`;
    unlink($Link);
    $Opcion=$_REQUEST["Opcion"];
    
    switch ($Opcion){
        case 1: //Balance de comprobacion
            $Tabla=$obVenta->normalizar(base64_decode($_REQUEST["TxtT"]));
            $statement=$obVenta->normalizar(base64_decode($_REQUEST["TxtL"]));
            $Columnas=$obVenta->ShowColums($Tabla);
            $sqlColumnas="SELECT ";
            foreach($Columnas["Field"] as $Campo){
                $sqlColumnas.="'$Campo',";
            }
            $sqlColumnas=substr($sqlColumnas, 0, -1);
            $sqlColumnas.=" UNION ALL ";
            
            $sql=$sqlColumnas."SELECT * FROM $statement INTO OUTFILE '$OuputFile' FIELDS TERMINATED BY ';' LINES TERMINATED BY '\r\n';";
            $obVenta->Query($sql);
            print("Tabla $Tabla exportada exitosamente <a href='$Link'>Abrir</a>");
            break;
        
    }
}else{
    print("No se recibió parametro de opcion");
}

?>