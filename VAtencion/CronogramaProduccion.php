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
    print("<li>");
    $css->CrearImageLink("produccion_ordenes_trabajo.php", "../images/trabajos.png", "_self", 30, 30);
    print("</li>");
    print("<li>");
    $css->CrearLink("produccion_ordenes_trabajo.php", "_self", "<strong>Ordenes de Trabajo</strong>");
    print("</li>");
    $css->CabeceraFin(); 
    //////////Variables iniciales
    /////
    /////
    $obVenta = new ProcesoVenta($idUser);
   
    if(isset($_REQUEST["TxtFechaCronograma"]) ){
        $FechaActual=$_REQUEST["TxtFechaCronograma"];
    }else{
        $FechaActual=date("Y-m-d");
    }
    $NombreDia=date("l", strtotime("$FechaActual"));
    $DiaMes=date("d", strtotime("$FechaActual"));
    $NombreMes=date("F", strtotime("$FechaActual"));
    $Anio=date("Y", strtotime("$FechaActual"));
    $Titulo=$NombreDia.", ".$DiaMes.", ".$NombreMes." ".$Anio;
    
    ///////////////Creamos el contenedor principal
    
    $css->CrearDiv("principal", "container", "center",1,1);
    $css->CrearForm2("FrmFechaCrono", $myPage, "post", "_self");      
    $css->CrearInputFecha("<h3>Seleccione la Fecha: </h3>", "TxtFechaCronograma", "$FechaActual", "100", "30", "");
    $css->CrearBotonNaranja("BtnBuscar", "Buscar");
    $css->CerrarForm();
    ///////////////Creamos el contenedor secundario
    
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    //Creamos la interfaz del Cronograma
    
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
            $Page="AgregaActividad.php";
            $Page.="?TxtFecha=$FechaActual&TxtHoraIni=$HorasCronograma[Hora]&idMaquina=$DatosMaquinas[ID]";
            print("<td>");
            $css->CrearLink($Page, "_self", "+...");
            print("</td>");
            
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