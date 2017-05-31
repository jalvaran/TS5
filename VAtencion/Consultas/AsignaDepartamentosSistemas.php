<?php
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
$css =  new CssIni("");
$obVenta = new ProcesoVenta(1);
$Valida=$obVenta->normalizar($_REQUEST['Valida']);
if($Valida==1){
    $idDepartamento=$obVenta->normalizar($_REQUEST['key']);
    $Condicion=" WHERE idDepartamento='$idDepartamento'";
    $Page="Consultas/AsignaDepartamentosSistemas.php?Valida=2&key=";
    $css->CrearSelectTable("CmbSub1", "prod_sub1", $Condicion, "idSub1", "NombreSub1", "idDepartamento", "onchange", "EnvieObjetoConsulta(`$Page`,`CmbSub1`,`DivSub2`,`0`);", "", 0);
    
}
if($Valida==2){
    $idDepartamento=$obVenta->normalizar($_REQUEST['key']);
    $Condicion=" WHERE idSub1='$idDepartamento'";
    $Page="Consultas/AsignaDepartamentosSistemas.php?Valida=3&key=";
    $css->CrearSelectTable("CmbSub2", "prod_sub2", $Condicion, "idSub2", "NombreSub2", "idSub1", "onchange", "EnvieObjetoConsulta(`$Page`,`CmbSub2`,`DivSub3`,`0`);", "", 0);
}
if($Valida==3){
    $idDepartamento=$obVenta->normalizar($_REQUEST['key']);
    $Condicion=" WHERE idSub2='$idDepartamento'";
    $Page="Consultas/AsignaDepartamentosSistemas.php?Valida=4&key=";
    $css->CrearSelectTable("CmbSub3", "prod_sub3", $Condicion, "idSub3", "NombreSub3", "idSub2", "onchange", "EnvieObjetoConsulta(`$Page`,`CmbSub3`,`DivSub4`,`0`);", "", 0);
}
if($Valida==4){
    $idDepartamento=$obVenta->normalizar($_REQUEST['key']);
    $Condicion=" WHERE idSub3='$idDepartamento'";
    $css->CrearSelectTable("CmbSub4", "prod_sub4", $Condicion, "idSub4", "NombreSub4", "idSub3", "", "", "", 0);
}

if($Valida==5){
    
    $css->CrearSelectTable("CmbSub5", "prod_sub5", "", "idSub5", "NombreSub5", "", "", "", "", 0);
}

?>