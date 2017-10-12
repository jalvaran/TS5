<?php
/* 
 * Este archivo se encarga de escuchar las peticiones de diferentes acciones
 */
include_once("../../modelo/php_conexion.php");  //Clases de donde se escribirán las tablas
include_once("../../modelo/PrintPos.php");      //Imprime documentos en la impresora pos
include_once("../css_construct.php");
session_start();
$idUser=$_SESSION['idUser'];

if(isset($_REQUEST["idAccion"])){
       
    $obVenta = new ProcesoVenta($idUser);
    $obPrint=new PrintPos($idUser);
    
    $idAccion=$obVenta->normalizar($_REQUEST["idAccion"]);
    
    switch ($idAccion){
        case 1: //Descarta un Pedido de Restaurante
            $idPedido=$obVenta->normalizar($_REQUEST["idPedido"]);
            $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservaciones"]);
            $obVenta->ActualizaRegistro("restaurante_pedidos", "Estado", "DEPE", "ID", $idPedido);
            $obVenta->ActualizaRegistro("restaurante_pedidos", "Observaciones", $Observaciones, "ID", $idPedido);
            $obVenta->ActualizaRegistro("restaurante_pedidos_items", "Estado", "DEPE", "idPedido", $idPedido);
            Print("Pedido $idPedido descartado");
            break;
        case 2: //Descarta un Pedido de Domicilio
            $idPedido=$obVenta->normalizar($_REQUEST["idPedido"]);
            $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservaciones"]);
            $obVenta->ActualizaRegistro("restaurante_pedidos", "Estado", "DEDO", "ID", $idPedido);
            $obVenta->ActualizaRegistro("restaurante_pedidos", "Observaciones", $Observaciones, "ID", $idPedido);
            $obVenta->ActualizaRegistro("restaurante_pedidos_items", "Estado", "DEDO", "idPedido", $idPedido);
            Print("Pedido $idPedido descartado");
            break;
        
    }
}else{
    print("No se recibió parametro de documento");
}
?>