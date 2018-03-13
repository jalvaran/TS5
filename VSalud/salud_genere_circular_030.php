<?php 
$myPage="salud_genere_circular_030.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Generar Circular 030");

print("</head>");
print("<body>");
    
    
    
    $css->CabeceraIni("Generar Circular 030"); //Inicia la cabecera de la pagina
      
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    

    $css->CrearDiv("principal", "container", "center",1,1);
   // include_once 'procesadores/salud_generar_circular_030.process.php';
            
    $css->CrearNotificacionAzul("GENERAR CIRCULAR 030", 16);
    $css->CrearForm2("FrmCircular030", $myPage, "post", "_self");
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>FECHA INICIAL</strong>", 1);
            $css->ColTabla("<strong>FECHA FINAL</strong>", 1);
            $css->ColTabla("<strong>ADICIONAL</strong>", 1);
            $css->ColTabla("<strong>GENERAR</strong>", 1);
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            
            print("<td>");
                
                $css->CrearInputText("TxtFechaInicial", "date", "", date("Y-m-d"), "Fecha", "", "", "", 200, 30, 0, 1);
            
            print("</td>");
            print("<td>");
                
                $css->CrearInputText("TxtFechaFinal", "date", "", date("Y-m-d"), "Fecha", "", "", "", 200, 30, 0, 1);
            
            print("</td>");
            print("<td>");
                $css->CrearSelect("CmbAdicional", "",200);
                    $css->CrearOptionSelect("", "Seleccione un Item", 0);
                    $css->CrearOptionSelect(1, "Sin Facturas Pagadas", 0);
                    $css->CrearOptionSelect(2, "Con Facturas Pagadas", 0);
                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $Page="Consultas/salud_generar_circular_030.process.php?idFactura=";
                $css->CrearBotonEvento("BtnCrear", "Generar", 1, "onClick", "EnvieObjetoConsulta2(`$Page`,`TxtFechaInicial`,`DivMensajesCircular`,`4`);return false;", "naranja", "");
                
            print("</td>");
            
        $css->CierraFilaTabla();
        
        
    $css->CerrarTabla();
    $css->CrearDiv("DivMensajesCircular", "", "center", 1, 1);
    $css->CerrarDiv();//Cerramos contenedor de notificaciones
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    
    print("</body></html>");
    ob_end_flush();
?>