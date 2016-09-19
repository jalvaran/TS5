<?php 
$myPage="CronogramaProduccion.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
	
print("<html>");
print("<head>");
$css =  new CssIni("Cronograma Ordenes de Trabajo");

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaCronogramaProduccion.php");
    
    $css->CabeceraIni("Cronograma Ordenes de Trabajo"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    $obVenta = new ProcesoVenta($idUser);
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor principal
    
    $css->CrearDiv("principal", "container", "center",1,1);
   
    ///////////////Creamos el contenedor secundario
    
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    //Creamos la interfaz del Cronograma
    $FechaActual=date("Y-m-d");
    $NombreDia=date("l");
    $DiaMes=date("d");
    $NombreMes=date("F");
    $Anio=date("Y");
    $Titulo=$NombreDia.", ".$DiaMes.", ".$NombreMes." ".$Anio;
    $css->CrearTabla();
    //Agrego Titulo
    $css->FilaTabla(18);
    $css->ColTabla($Titulo, 10);
    $css->CierraColTabla();
    $css->CierraFilaTabla();
    //Agrego Horas
    $css->FilaTabla(16);
    $css->ColTabla("Maquina", 1);
    $css->CierraColTabla();
    $Datos=$obVenta->ConsultarTabla("produccion_horas_cronograma", "");
    while($HorasCronograma=$obVenta->FetchArray($Datos)){
        $css->ColTabla($HorasCronograma["Hora"], 1);
        $css->CierraColTabla();
    }
    $css->CierraFilaTabla();
    //Agrego las filas con cada maquina
    
    $Datos=$obVenta->ConsultarTabla("maquinas", "");
    while($DatosMaquinas=$obVenta->FetchArray($Datos)){
        $css->FilaTabla(16);
        $css->ColTabla($DatosMaquinas["Nombre"], 1);
        $css->CierraColTabla();
        
        $DatosHoras=$obVenta->ConsultarTabla("produccion_horas_cronograma", "");
        while($HorasCronograma=$obVenta->FetchArray($DatosHoras)){
            $css->ColTabla(" (+) ", 1);
            $css->CierraColTabla();
        }
        
        $css->CierraFilaTabla();
    }
    
    
    $css->CerrarTabla();
   
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>