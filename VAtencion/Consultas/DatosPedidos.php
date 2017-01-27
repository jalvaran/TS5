<?php
$Valida = intval($_GET['Valida']);
session_start();
$idUser=$_SESSION["idUser"];
$myPage="Restaurante_Admin.php";
include_once("../../modelo/php_conexion.php");
include_once("../../modelo/php_tablas.php");
include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta($idUser);
$Valida=$obVenta->normalizar($_GET['Valida']);

if($Valida==1){
    
    $consulta=$obVenta->ConsultarTabla("restaurante_pedidos", " WHERE Estado='AB'");
    if($obVenta->NumRows($consulta)){
               
        while($DatosPedido=$obVenta->FetchArray($consulta)){
            $DatosMesa=$obVenta->DevuelveValores("restaurante_mesas", "ID", $DatosPedido["idMesa"]);
            $idPedido=$DatosPedido["ID"];
            $css->CrearNotificacionVerde("Orden de Pedido No: $idPedido, para $DatosMesa[Nombre]", 16);
            $css->CrearTabla();
            $css->FilaTabla(16);
            $css->ColTabla('<strong>Fecha</strong>', 1);
            $css->ColTabla('<strong>Mesa</strong>', 1);
            $css->ColTabla('<strong>Solicita</strong>', 1);
            $css->ColTabla('<strong>Descartar</strong>', 1);
            $css->ColTabla('<strong>Pedido</strong>', 1);
            $css->ColTabla('<strong>Precuenta</strong>', 1);
            $css->ColTabla('<strong>Facturar</strong>', 1);
            $css->CierraFilaTabla();
                
                $idUsuarioPedido=$DatosPedido["idUsuario"];
                
                $sql="SELECT Nombre, Apellido FROM usuarios WHERE idUsuarios='$idUsuarioPedido'";
                $DatosUsuario=$obVenta->Query($sql);
                $DatosUsuario=$obVenta->FetchArray($DatosUsuario);
                $NombreUsuario=$DatosUsuario["Nombre"]." ".$DatosUsuario["Apellido"];
                $css->FilaTabla(16);
                $css->ColTabla($DatosPedido["FechaCreacion"], 1);
                $css->ColTabla($DatosMesa["Nombre"], 1);
                $css->ColTabla($NombreUsuario, 1);
                
                print("<td style='text-align:center'>");
                $RutaImage="../images/anular.png";
                $Link=$myPage."?BtnDescartarPedido=$DatosPedido[ID]";
                $css->CrearImageLink($Link, $RutaImage, "_self", 50, 50);
                print("</td>");
                print("<td style='text-align:center'>");
                $RutaImage="../images/print.png";
                $Link=$myPage."?BtnImprimirPedido=$DatosPedido[ID]";
                $css->CrearImageLink($Link, $RutaImage, "_self", 50, 50);
                print("</td>");
                print("<td style='text-align:center'>");
                $RutaImage="../images/precuenta.png";
                $Link=$myPage."?BtnImprimirPrecuenta=$DatosPedido[ID]";
                $css->CrearImageLink($Link, $RutaImage, "_self", 50, 50);
                print("</td>");
                print("<td style='text-align:center'>");
                $RutaImage="../images/facturar2.png";
                $Link=$myPage."?BtnFacturarPedido=$DatosPedido[ID]";
                $css->CrearImageLink($Link, $RutaImage, "_self", 50, 50);
                print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                $css->ColTabla('<strong>Producto</strong>', 3);
                $css->ColTabla('<strong>Observaciones</strong>', 1);
                $css->ColTabla('<strong>Cantidad</strong>', 1);
                $css->ColTabla('<strong>Total</strong>', 1);
                $css->ColTabla('<strong>Borrar</strong>', 1);
                $css->CierraFilaTabla();
                $Datos=$obVenta->ConsultarTabla("restaurante_pedidos_items", " WHERE idPedido='$idPedido'");
                $SubTotal=0;
                $IVA=0;
                $Total=0;
                while($ItemsPedido=$obVenta->FetchArray($Datos)){
                    $SubTotal=$SubTotal+$ItemsPedido["Subtotal"];
                    $IVA=$IVA+$ItemsPedido["IVA"];
                    $Total=$Total+$ItemsPedido["Total"];
                    $css->FilaTabla(16);
                    $css->ColTabla($ItemsPedido["NombreProducto"], 3);
                    $css->ColTabla($ItemsPedido["Observaciones"], 1);
                    $css->ColTabla($ItemsPedido["Cantidad"], 1);
                    $css->ColTabla(number_format($ItemsPedido["Total"]), 1,"R");
                    $css->ColTablaDel($myPage, "restaurante_pedidos_items", "ID", $ItemsPedido["ID"], "");
                    $css->CierraFilaTabla();
                }
            
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Subtotal:</strong>", 5,"R");
                $css->ColTabla("<strong>$".number_format($SubTotal)."</strong>", 2,"R");
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>IVA:</strong>", 5,"R");
                $css->ColTabla("<strong>$".number_format($IVA)."</strong>", 2,"R");
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Total:</strong>", 5,"R");
                $css->ColTabla("<strong>$".number_format($Total)."</strong>", 2,"R");
            $css->CierraFilaTabla();
            $css->CerrarTabla();
        }
       
        
    }else{
        $css->CrearNotificacionVerde("No hay pedidos en este momento", 16);
    }
    
}else{
    $css->CrearNotificacionRoja("No se ha recibido un parametro valido", 16);
}

?>