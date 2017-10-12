<?php 
if(isset($_REQUEST["idDocumento"])){
    $myPage="PDF_Documentos.php";
    include_once("../../modelo/php_conexion.php");
    include_once("../../modelo/PrintPos.php");
        
    $obVenta = new ProcesoVenta(1);
    $obPrint=new PrintPos(1);
    
    $idDocumento=$obVenta->normalizar($_REQUEST["idDocumento"]);
    
    switch ($idDocumento){
        case 1: //Pedido Restaurante
            $idPedido=$obVenta->normalizar($_REQUEST["idPedido"]);
            $obVenta->ImprimePedidoRestaurante($idPedido, "", 1, "");
            
            print("Se imprimió el pedido $idPedido");
            break;
        
    }
}else{
    print("No se recibió parametro de documento");
}

?>