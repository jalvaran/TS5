<?php 
if(isset($_REQUEST["idDocumento"])){
    $myPage="PDF_Documentos.php";
    include_once("../sesiones/php_control.php");
    include_once("../modelo/PrintPos.php");
    include_once("clases/ClasesPDFDocumentos.php");  //Clase que genera los pdf
    
    $obVenta = new ProcesoVenta($idUser);
    $obPrint=new PrintPos($idUser);
    $obDoc = new Documento($db);
    $idDocumento=$obVenta->normalizar($_REQUEST["idDocumento"]);
    
    
    switch ($idDocumento){ //Si se recibe 1, es para generar un cobro prejuridico
        case 1: //Se va a generar un cobro prejuridico juridico
            $idCobro=$obVenta->normalizar($_REQUEST["idCobroPrejuridico"]);
            $obDoc->PDF_CobroPrejuridico($idCobro);
            
            break;
        
    }
}else{
    print("No se recibió parametro de documento");
}

?>