<?php 
$myPage="Restaurante_Admin.php";
include_once("../sesiones/php_control.php");
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta($idUser);

include_once("css_construct.php");
print("<html>");
print("<head>");
$css =  new CssIni("Admin Restaurante");
print("</head>");
print("<body>");
   
    $css->CabeceraIni("Admin Restaurante"); //Inicia la cabecera de la pagina
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    include_once("procesadores/procesa_Restaurante_Admin.php");
    //////Creo una factura a partir de un pedido
    if(isset($_REQUEST['BtnFacturarPedido'])){
        $idPedido=$obVenta->normalizar($_REQUEST['BtnFacturarPedido']);
        $obTabla->DibujeAreaFacturacionRestaurante($idPedido,$myPage,"");
         
    }
    if(isset($_REQUEST["TxtidFactura"])){
            
        $idFactura=$_REQUEST["TxtidFactura"];
        if($idFactura<>""){
            $RutaPrint="../tcpdf/examples/imprimirFactura.php?ImgPrintFactura=".$idFactura;
            $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
            $css->CrearTabla();
            $css->CrearFilaNotificacion("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $DatosFactura[NumeroFactura]</a>",16);
            $css->CerrarTabla();
        }else{

           $css->AlertaJS("No se pudo crear la factura porque no hay resoluciones disponibles", 1, "", ""); 
        }
            
    }
    $css->DivPage("Pedidos", "Consultas/DatosPedidos.php?Valida=1", "", "DivBusqueda", "onClick", 30, 30, "");
    
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    
    $css->CrearNotificacionAzul("ADMINISTRACION", 16);
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("DivBusqueda", "", "center",1,1);
   
    $css->CerrarDiv();//Cerramos contenedor Secundario
    
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AnchoElemento("CmbCodMunicipio_chosen", 200);
    $css->AnchoElemento("CmbClientes_chosen", 200);
    $css->AnchoElemento("TxtidColaborador_chosen", 200);
    $css->AnchoElemento("TxtCliente_chosen", 200);
    $css->AnchoElemento("TxtCuentaDestino_chosen", 200);
    $css->AnchoElemento("TxtTipoPago_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 300);
    $css->AnchoElemento("CmbProveedores_chosen", 300);
    $css->AgregaSubir();
    print("<script>setInterval('BusquedaPedidos()',4000);ClickElement('Pedidos');</script>");
    if(isset($_REQUEST['BtnFacturarPedido'])){
        print("<script>document.getElementById('TxtPaga').select();</script> ");
    }
    $css->Footer();
    
    
    print("</body></html>");
?>