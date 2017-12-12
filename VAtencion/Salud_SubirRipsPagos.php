<?php 
$myPage="Salud_SubirRipsPagos.php";
include_once("../sesiones/php_control.php");
include_once("clases/SaludRips.class.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
$obRips = new Rips($idUser);
//////Si recibo un cliente

	
print("<html>");
print("<head>");
$css =  new CssIni("Subir Rips");

print("</head>");
print("<body>");
    
    
    
    $css->CabeceraIni("Subir RIPS de Pagos"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    include_once("procesadores/Salud_SubirRipsPagos.process.php");
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    $css->CrearNotificacionRoja("Suba los Archivos de Relacion de Pagos", 16);
    $css->CrearForm2("FrmRipsPagos", $myPage, "post", "_self");
    $css->CrearSelect("CmbSeparador", "");
        $css->CrearOptionSelect("", "Selecciones el Separador de los archivos", 0);
        $css->CrearOptionSelect(1, "punto y coma (;)", 1);
        $css->CrearOptionSelect(2, "Coma (,)", 0);
    $css->CerrarSelect();
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Pagos (AR)</strong>", 1);
                
            $css->CierraFilaTabla();
            
            
            $css->FilaTabla(16);
                
                print("<td>");
                    $css->CrearUpload("UpAR");
                    $css->CrearDiv("DivAR", "", "left", 1, 1);
                $css->CerrarDiv();
                print("</td>");
                
                
            $css->CierraFilaTabla();
            
        $css->CerrarTabla();
    $css->CrearBotonEvento("BtnEnviar", "Enviar y Analizar", 1, "OnClick", "ValidaRIPSPagos()", "naranja", "");    
    $css->CerrarForm();   
    
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>