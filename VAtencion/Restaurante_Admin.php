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
    $css->AgregaSubir();
    print("<script>setInterval('BusquedaPedidos()',4000);ClickElement('Pedidos');</script>");
    $css->Footer();
    
    
    print("</body></html>");
?>