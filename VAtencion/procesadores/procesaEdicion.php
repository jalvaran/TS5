<?php
/* 
 * Este archivo se encarga de escuchar las peticiones para editar un registro
 */

if(!empty($_REQUEST["BtnEditarRegistro"])){
    include_once("../../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
    
    $obTabla = new Tabla($db);
    $obVenta = new ProcesoVenta(1);
    $stament=$_REQUEST["TxtStament"];
    $tab=$_REQUEST["TxtTablaEdit"];
    if(isset($_REQUEST["TxtTabla"])){
        $tab=$_REQUEST["TxtTabla"];  
    }
    $myPage1=explode(".",$_REQUEST["TxtMyPage"]);
    $myPage=$myPage1[0];
    $IDEdit=$_REQUEST["TxtIDEdit"];
    $Vector["Tabla"]=$tab;
    $NombresColumnas=$obTabla->Columnas($Vector);
    $sql="UPDATE $tab SET ";
    //$NumCols=Count($NombresColumnas);
    $i=1;
    foreach($NombresColumnas as $NombreCol){
        if(!empty($_FILES[$NombreCol]['name'])){
            $dir= "../../";
            if($tab=="productosventa"){
                $carpeta="ImagenesProductos/";
            }else if($tab=="empresapro"){
                $carpeta="LogosEmpresas/";
            
            }else if($tab=="egresos"){
                $carpeta="SoportesEgresos/";
            }
            opendir($dir.$carpeta);
            $Name=str_replace(' ','_',$_FILES[$NombreCol]['name']);  
            $destino=$carpeta.$Name;
            move_uploaded_file($_FILES[$NombreCol]['tmp_name'],$dir.$destino);
            $obVenta->ActualizaRegistro($tab, $NombreCol, $destino, $NombresColumnas[0], $IDEdit);
        }
        $NumCar=strlen($_REQUEST[$NombreCol]);
        if(isset($_REQUEST[$NombreCol]) && $NumCar>0){
            $Edicion=$_REQUEST[$NombreCol];
            if($NombreCol=='FormaPago' && $tab=="facturas" && $_REQUEST[$NombreCol]<>"Contado"){
                $Edicion="Credito a $_REQUEST[$NombreCol] dias";
                
            }
            
            $obVenta->ActualizaRegistro($tab, $NombreCol, $Edicion, $NombresColumnas[0], $IDEdit);
        }
       $i++;
    }
    //$sql=substr($sql, 0, -1);
    $Fecha=date("Y-m-d H:i:s");
    $obVenta->ActualizaRegistro($tab, "Updated", $Fecha, $NombresColumnas[0], $IDEdit);
    if($tab=="facturas" && $_REQUEST["FormaPago"]<>"Contado"){
       
        $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $IDEdit);
        $Datos["Fecha"]=$DatosFactura["Fecha"];                
        $Datos["Dias"]=$_REQUEST["FormaPago"];
        $FechaVencimiento=$obVenta->SumeDiasFecha($Datos);
        $Datos["idFactura"]=$IDEdit; 
        $Datos["FechaFactura"]=$DatosFactura["Fecha"]; 
        $Datos["FechaVencimiento"]=$FechaVencimiento;
        $Datos["idCliente"]=$DatosFactura["Clientes_idClientes"];
        $obVenta->InsertarFacturaEnCartera($Datos);///Inserto La factura en la cartera
        
        $sql="UPDATE `librodiario` SET `CuentaPUC`='1305',`NombreCuenta`='CLIENTES NACIONALES' WHERE `Num_Documento_Interno`='$IDEdit' AND `CuentaPUC` LIKE '11%'";
        $obVenta->Query($sql);
        
    }
    //$sql.=" Updated='$Fecha' WHERE $NombresColumnas[0] ='$IDEdit'";
    //$obVenta->Query($sql);
    
    $PageReturn=  substr($myPage, 0, 21);
    if($PageReturn=="productosventa_bodega"){
        $myPage="bodegas_externas.php?CmbBodega=$Vector[Tabla]&TxtStament=$stament";
        header("location:../$myPage");
        exit();
    }
    
    //$obVenta->ActualizaRegistro($tab, "Updated", date("Y-m-d H:i:s"), $NombresColumnas[0], $IDEdit);
    
    header("location:../$myPage.php");
}


?>
