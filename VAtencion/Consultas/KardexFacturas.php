<?php
 session_start();
$idUser=$_SESSION['idUser'];
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("");

$Autorizado=$_REQUEST['Autorizado'];
function Kardex($idUser){
   
    $obVenta = new ProcesoVenta($idUser);
    
    $Consulta=$obVenta->ConsultarTabla("facturas_kardex", "WHERE Kardex='NO' and idUsuario='$idUser'");
    while ($DatosFactura=$obVenta->FetchArray($Consulta)){
        $obVenta->DescargueFacturaInventarios($DatosFactura["idFacturas"],"");
        print("Factura $DatosFactura[idFacturas] descargada de inventarios <br>");
        $obVenta->BorraReg("facturas_kardex", "idFacturas", $DatosFactura["idFacturas"]);
    }
    
     
}
if($Autorizado<>""){
    
    register_shutdown_function(Kardex($idUser));
    
}else{
    $css->CrearNotificacionRoja("Sin Datos de la Cartera", 16);
}


?> 