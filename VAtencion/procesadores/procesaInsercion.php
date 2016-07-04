<?php
//include_once("../../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
/* 
 * Este archivo se encarga de eschuchar las peticiones para guardar un archivo
 */

/* 
 * Si se Solicita Guardar un Registro
 */
if(!empty($_REQUEST["BtnGuardarRegistro"])){
    include_once("../../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
    $obTabla = new Tabla($db);
    $obVenta = new ProcesoVenta(1);
    $tab=$_REQUEST["TxtTablaInsert"];
    $Vector["Tabla"]=$tab;
    $NombresColumnas=$obTabla->Columnas($Vector);
    
    $i=0;   
    foreach($NombresColumnas as $NombreCol){
        if(isset($_REQUEST[$NombreCol])){
           $Columnas[$i]=$NombreCol;  $Valores[$i]=$_REQUEST[$NombreCol];
           $i++;
        }
       
    }
        
    $obVenta->InsertarRegistro($tab,$i,$Columnas,$Valores);
    if($tab=="productosventa"){
        $Vector["Tabla"]="productosventa";
        $ID=$obTabla->ObtengaAutoIncrement($Vector);
        $ID=$ID-1;
        $obVenta->ActualizaRegistro("productosventa", "CodigoBarras", $ID, "idProductosVenta", $ID);
        if(empty($_REQUEST["Referencia"])){
            $obVenta->ActualizaRegistro("productosventa", "Referencia", "REF".$ID, "idProductosVenta", $ID);
        }
        
        //print("<script>alert('ID: $ID')</script>");
    }
    header("location:../$tab.php");
}
?>