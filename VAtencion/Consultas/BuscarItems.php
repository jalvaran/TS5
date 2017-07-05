<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
$myPage="VentasRapidasV2.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta($idUser);
$key=$obVenta->normalizar($_REQUEST['key']);
$myPage=$obVenta->normalizar($_REQUEST['myPage']);
$idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
$PageReturn=$myPage."?CmbPreVentaAct=$idPreventa&TxtAgregarItemPreventa=";
if($key<>""){
 $css->CrearTabla();
    $tab="productosventa";
    $Condicion=" WHERE idProductosVenta='$key' OR Nombre LIKE '%$key%' OR Referencia LIKE '%$key%' LIMIT 50";
    $consulta=$obVenta->ConsultarTabla($tab,$Condicion);
    if($obVenta->NumRows($consulta)){
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Agregar</strong>", 1);
        $css->ColTabla("<strong>ID</strong>", 1);
            $css->ColTabla("<strong>Referencia</strong>", 1);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>PrecioVenta</strong>", 1);
            $css->ColTabla("<strong>Mayorista</strong>", 1);
            $css->ColTabla("<strong>Existencias</strong>", 1);
            $css->CierraFilaTabla();
        while($DatosProducto=$obVenta->FetchArray($consulta)){
            $css->FilaTabla(16);
             print("<td>");
            $css->CrearForm2("FrmAgregaItem$DatosProducto[idProductosVenta]", $myPage, "post", "_self");
            $css->CrearInputText("CmbPreVentaAct", "hidden", "", $idPreventa, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtTablaItem", "hidden", "", $tab, "", "", "", "", "", "", 0, 0);
            $css->CrearInputText("TxtAgregarItemPreventa", "hidden", "", $DatosProducto["idProductosVenta"], "", "", "", "", "", "", 0, 0);
            
            $css->CrearInputNumber("TxtCantidad", "number", "", 1, "Cantidad", "", "", "", 100, 30, 0, 1, 0, "", "any");
            $css->CrearBotonNaranja("BtnAgregar", "Agregar");
            $css->CerrarForm();
            //$target="$PageReturn$DatosProducto[idProductosVenta]&TxtTablaItem=$tab";
            //$css->CrearLink($target, "_self", "Agregar");
            print("</td>");
            $css->ColTabla($DatosProducto["idProductosVenta"], 1);
            $css->ColTabla($DatosProducto["Referencia"], 1);
            $css->ColTabla($DatosProducto["Nombre"], 1);
            $css->ColTabla($DatosProducto["PrecioVenta"], 1);
            $css->ColTabla($DatosProducto["PrecioMayorista"], 1);
            $css->ColTabla($DatosProducto["Existencias"], 1);
           
            $css->CierraFilaTabla();
        }
    }
    
    $tab="servicios";
    $Condicion=" WHERE idProductosVenta='$key' OR Nombre LIKE '%$key%' OR Referencia LIKE '%$key%'";
    $consulta=$obVenta->ConsultarTabla($tab,$Condicion);
    if($obVenta->NumRows($consulta)){
        
        while($DatosProducto=$obVenta->FetchArray($consulta)){
            $css->FilaTabla(16);
             print("<td>");
            $target="$PageReturn$DatosProducto[idProductosVenta]&TxtTablaItem=$tab";
            $css->CrearLink($target, "_self", "Agregar");
            print("</td>");
            $css->ColTabla($DatosProducto["idProductosVenta"], 1);
            $css->ColTabla($DatosProducto["Referencia"], 1);
            $css->ColTabla($DatosProducto["Nombre"], 1);
            $css->ColTabla($DatosProducto["PrecioVenta"], 1);
            $css->ColTabla($DatosProducto["PrecioMayorista"], 1);
            //$css->ColTabla($DatosProducto["Existencias"], 1);
           
            $css->CierraFilaTabla();
        }
    }
    
    $tab="productosalquiler";
    $Condicion=" WHERE idProductosVenta='$key' OR Nombre LIKE '%$key%' OR Referencia LIKE '%$key%'";
    $consulta=$obVenta->ConsultarTabla($tab,$Condicion);
    if($obVenta->NumRows($consulta)){
        
        while($DatosProducto=$obVenta->FetchArray($consulta)){
            $css->FilaTabla(16);
             print("<td>");
            $target="$PageReturn$DatosProducto[idProductosVenta]&TxtTablaItem=$tab";
            $css->CrearLink($target, "_self", "Agregar");
            print("</td>");
            $css->ColTabla($DatosProducto["idProductosVenta"], 1);
            $css->ColTabla($DatosProducto["Referencia"], 1);
            $css->ColTabla($DatosProducto["Nombre"], 1);
            $css->ColTabla($DatosProducto["PrecioVenta"], 1);
            $css->ColTabla($DatosProducto["PrecioMayorista"], 1);
            //$css->ColTabla($DatosProducto["Existencias"], 1);
           
            $css->CierraFilaTabla();
        }
    }
    
    $css->CerrarTabla();
    
}else{
    $css->CrearNotificacionRoja("Digite un Dato", 16);
}
$css->AgregaJS(); //Agregamos javascripts
?>
    
</body>
</html>