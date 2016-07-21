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
        if($NombreCol=="RutaImagen"){
               $destino="";
                //echo "<script>alert ('entra a las columnas $NombreCol')</script>"; 
		if(!empty($_FILES['RutaImagen']['name'])){
                    //echo "<script>alert ('entra foto')</script>";
                        $dir= "../../"; 
			$carpeta="LogosEmpresas/";
			opendir($dir.$carpeta);
                        $Name=str_replace(' ','_',$_FILES['RutaImagen']['name']);  
			$destino=$carpeta.$Name;
			move_uploaded_file($_FILES['RutaImagen']['tmp_name'],$dir.$destino);
		}
                $Columnas[$i]=$NombreCol;  $Valores[$i]=$destino;
                $i++;
           }
        if(isset($_REQUEST[$NombreCol])){
            //echo "<script>alert ('entra a las columnas $NombreCol')</script>"; 
           
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
        
        
    }
    
    if($tab=="servicios"){
        
        
        if(empty($_REQUEST["Referencia"])){
            $Vector["Tabla"]="servicios";
            $ID=$obTabla->ObtengaAutoIncrement($Vector);
            $ID=$ID-1;
            $obVenta->ActualizaRegistro($tab, "Referencia", "REFSER".$ID, "idProductosVenta", $ID);
        }
        
        
    }
    
    if($tab=="productosalquiler"){
        
        
        if(empty($_REQUEST["Referencia"])){
            $Vector["Tabla"]="productosalquiler";
            $ID=$obTabla->ObtengaAutoIncrement($Vector);
            $ID=$ID-1;
            $obVenta->ActualizaRegistro($tab, "Referencia", "REFPQ".$ID, "idProductosVenta", $ID);
        }
        
        
    }
    
    header("location:../$tab.php");
}
?>