<?php 
$myPage="Salud_SubirRips.php";
include_once("../sesiones/php_control.php");
include_once("clases/SaludRips.class.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
$obRips = new Rips($idUser);
//////Si recibo un cliente

	
print("<html>");
print("<head>");
$css =  new CssIni("Archivos Internos");

print("</head>");
print("<body>");
       
    $css->CabeceraIni("Subir RIPS"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    include_once("procesadores/Salud_SubirRips.process.php");
    print("<br>");
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    $css->CrearNotificacionAzul("Suba los archivos", 16);
        $css->CrearForm2("FrmArchivosZip", $myPage, "post", "_self");
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>SUBIR RIPS EN .ZIP</strong>", 4);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Separador</strong>", 1);
                $css->ColTabla("<strong>Tipo de Negociacion</strong>", 1);
                $css->ColTabla("<strong>ZIP</strong>", 1);
                $css->ColTabla("<strong>Enviar</strong>", 1);
            $css->CierraFilaTabla();   
            $css->FilaTabla(16);
                print("<td>");
                    $css->CrearSelect("CmbSeparador", "",200);
                    $css->CrearOptionSelect("", "Selecciones el Separador de los archivos", 0);
                    $css->CrearOptionSelect(1, "punto y coma (;)", 0);
                    $css->CrearOptionSelect(2, "Coma (,)", 1);
                $css->CerrarSelect();
                print("</td>");
                print("<td>");
                    $css->CrearSelect("CmbTipoNegociacion", "",200);
                    $css->CrearOptionSelect("", "Tipo de Negociacion", 0);
                    $css->CrearOptionSelect("evento", "Evento", 0);
                    $css->CrearOptionSelect("capita", "Capita", 0);
                $css->CerrarSelect();
                print("</td>");
                print("<td>");
                    $css->CrearUpload("ArchivosZip");
                print("</td>");
                print("<td>");
                    $css->CrearBotonNaranja("BtnSubirZip", "Subir");
                print("</td>");
                
               
            $css->CierraFilaTabla();   
            $css->CerrarTabla();
        $css->CerrarForm();
        /*
    $css->CrearForm2("FrmArchivos", $myPage, "post", "_self");
    $css->CrearInputText("AnaliceArchivos", "hidden", "", 1, "", "", "", "", "", "", 0, 0);
    $css->CrearSelect("CmbTipoNegociacion", "");
        $css->CrearOptionSelect("", "Tipo de Negociacion", 0);
        $css->CrearOptionSelect("evento", "Evento", 0);
        $css->CrearOptionSelect("capita", "Capita", 0);
    $css->CerrarSelect();
    print("<br>");
    $css->CrearSelect("CmbSeparador", "");
        $css->CrearOptionSelect("", "Selecciones el Separador de los archivos", 0);
        $css->CrearOptionSelect(1, "punto y coma (;)", 0);
        $css->CrearOptionSelect(2, "Coma (,)", 1);
    $css->CerrarSelect();
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Consultas (AC)</strong>", 1);
                $css->ColTabla("<strong>Hospitalizacion (AH)</strong>", 1);
                $css->ColTabla("<strong>Medicamentos (AM)</strong>", 1);
                $css->ColTabla("<strong>Procedimientos (AP)</strong>", 1);
            $css->CierraFilaTabla();
            
            $css->FilaTabla(16);
                print("<td>");
                    $css->CrearUpload("UpAC");
                $css->CrearDiv("DivAC", "", "center", 1, 1);
                $css->CerrarDiv();
                print("</td>");
                print("<td>");
                    $css->CrearUpload("UpAH");
                    $css->CrearDiv("DivAH", "", "center", 1, 1);
                $css->CerrarDiv();
                print("</td>");
                print("<td>");
                    $css->CrearUpload("UpAM");
                    $css->CrearDiv("DivAM", "", "center", 1, 1);
                $css->CerrarDiv();
                print("</td>");
                print("<td>");
                    $css->CrearUpload("UpAP");
                    $css->CrearDiv("DivAP", "", "center", 1, 1);
                $css->CerrarDiv();
                print("</td>");
            $css->CierraFilaTabla();
                
            $css->FilaTabla(16);
            
                $css->ColTabla("<strong>Otros Servicios(AT)</strong>", 1);
                $css->ColTabla("<strong>Usuarios (US)</strong>", 1);
                $css->ColTabla("<strong>Facturas (AF)</strong>", 1);
                $css->ColTabla("<strong>Errores (AD)</strong>", 1);
                
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                    $css->CrearUpload("UpAT");
                    $css->CrearDiv("DivAT", "", "center", 1, 1);
                $css->CerrarDiv();
                print("</td>");
                print("<td>");
                    $css->CrearUpload("UpUS");
                    $css->CrearDiv("DivUS", "", "center", 1, 1);
                $css->CerrarDiv();
                print("</td>");
                print("<td>");
                    $css->CrearUpload("UpAF");
                    $css->CrearDiv("DivAF", "", "center", 1, 1);
                $css->CerrarDiv();
                print("</td>");
                print("<td>");
                    $css->CrearUpload("UpAD");
                    $css->CrearDiv("DivAD", "", "center", 1, 1);
                $css->CerrarDiv();
                print("</td>");
                
                
            $css->CierraFilaTabla();
            
        $css->CerrarTabla();
    $css->CrearBotonEvento("BtnEnviar", "Enviar y Analizar", 1, "OnClick", "ValidarUploads()", "naranja", "");    
    $css->CerrarForm();   
    
         * 
         */
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>