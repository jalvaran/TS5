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
    $DatosPuerto=$obVenta->DevuelveValores("config_puertos", "ID", 2);
    if($DatosPuerto["Habilitado"]=="SI"){
        $obVenta->ImprimirCodigoBarrasMonarch9416TM($Tabla,$idProducto,$Cantidad,$DatosPuerto["Puerto"],$DatosCB);
    }
    $css =  new CssIni("Print");
    
   $css->VentanaFlotante("Se ha impreso $Cantidad Tikets");
    
}

?>