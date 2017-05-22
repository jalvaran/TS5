<?php
/* 
 * Este archivo se encarga de escuchar las peticiones para editar un registro
 */

if(!empty($_REQUEST["TipoCodigo"])){
    include_once("../../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
    include_once("../css_construct.php");
    session_start();
    $idUser=$_SESSION['idUser'];
    $obTabla = new Tabla($db);
    $obVenta = new ProcesoVenta($idUser);
    $idProducto=$obVenta->normalizar($_REQUEST["idProducto"]);
    $Cantidad=$obVenta->normalizar($_REQUEST["TxtCantidad"]);
    $Tabla="productosventa";
    $DatosCB["EmpresaPro"]=1;
    $css =  new CssIni("Print");
    $DatosPuerto=$obVenta->DevuelveValores("config_puertos", "ID", 2);
    
    if($DatosPuerto["Habilitado"]=="SI"){
        switch ($_REQUEST["TipoCodigo"]){
            case 1:
                $obVenta->ImprimirCodigoBarrasMonarch9416TM($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
                break;
            case 2:
                $obVenta->ImprimirLabelMonarch($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
                break;
            case 3:
                $obVenta->ImprimirTiketCortoMonarch($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
                break;
        }
        
        //$css->CrearNotificacionAzul("Impreso", 16);
    }
    
   $css->VentanaFlotante("Se ha impreso $Cantidad Tikets");
    
}

?>