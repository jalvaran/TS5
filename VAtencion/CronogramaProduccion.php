<?php 
$myPage="CronogramaProduccion.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");

$ColorLibre="#FFFFFF";
$ColorPausaOperativa="#E2A9F3";
$ColorPausaNoOperativa="#F6CED8";
$ColorEjecucion="#A9F5BC";
$ColorTerminada="#A9F5F2";
$ColorNoIniciada="#F2F2F2";
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
     print("<li>");
    $css->CrearLink("produccion_actividades.php", "_blank", "<strong>Historial de Actividades</strong>");
    print("</li>");
    print("<li>");
    $css->CrearLink("Ejecutar_Actividades.php", "_self", "<strong>Ejecutar Actividad</strong>");
    print("</li>");
    $css->CabeceraFin(); 
    //////////Variables iniciales
    /////
    /////
    $obVenta = new ProcesoVenta($idUser);
   
    $Titulo="Crear Actividad";
    $Nombre="ImgCrearActividad";
    $RutaImage="../images/pop_servicios.png";
    $javascript="";
    $VectorBim["f"]=0;
    $target="#DialCrearActividad";
    $css->CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,"",1,1,"fixed","left:10px;top:50",$VectorBim);
    
    $Titulo="Editar Actividad";
    $Nombre="ImgEditarActividad";
    $RutaImage="../images/pop_servicios.png";
    $javascript="";
    $VectorBim["f"]=0;
    $target="#DialEditarActividad";
    $css->CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,"",1,1,"fixed","left:10px;top:60",$VectorBim);
    
    $VectorCDC["F"]=0;
    $idEdit=0;
    if(isset($_REQUEST["TxtFechaCronograma"]) ){
        $FechaActual=$_REQUEST["TxtFechaCronograma"];
    }else{
        $FechaActual=date("Y-m-d");
    }
    if(isset($_REQUEST["idEdit"])){
        $idEdit=$_REQUEST["idEdit"];
    }
    $idOT=0;
    $idMaquina=0;
    if(isset($_REQUEST["idOT"]) ){
        $idOT=$_REQUEST["idOT"];
    }
    if(isset($_REQUEST["idMaquina"]) ){
        $idMaquina=$_REQUEST["idMaquina"];
    }
    $NombreDia=date("l", strtotime("$FechaActual"));
    $DiaMes=date("d", strtotime("$FechaActual"));
    $NombreMes=date("F", strtotime("$FechaActual"));
    $Anio=date("Y", strtotime("$FechaActual"));
    $Titulo=$NombreDia.", ".$DiaMes.", ".$NombreMes." ".$Anio;
    
    
    //Creamos El dialogo para crear y editar  una actividad
    if($idMaquina>0){
    /////////////////Cuadro de dialogo de creacion de actividades
        $FechaInicioPlaneado=$_REQUEST["TxtFecha"];
        $HoraInicioPlaneado=$_REQUEST["TxtHoraIni"];
        
        $DatosMaquina=$obVenta->DevuelveValores("maquinas", "ID", $idMaquina);
        $DatosOT=$obVenta->DevuelveValores("produccion_ordenes_trabajo", "ID", $idOT);
	$css->CrearCuadroDeDialogo("DialCrearActividad","Crear Actividad para la OT $idOT Descripcion: $DatosOT[Descripcion], Maquina: $DatosMaquina[Nombre]"); 
	 
        $css->CrearForm2("FrmCrearActividad",$myPage,"post","_self");
        $css->CrearInputText("idOT","hidden","",$idOT,"","","","",0,0,0,0);
        $css->CrearInputText("idMaquina","hidden","",$idMaquina,"","","","",0,0,0,0);
        
        $css->CrearInputText("TxtFechaInicioP","text","Fecha Inicio Planeado:<br>",$FechaInicioPlaneado,"FechaInicio","black","","",200,30,1,1);
        
        $css->CrearInputText("TxtHoraInicioP","text","<br>Hora Inicio Planeado:<br>",$HoraInicioPlaneado,"HoraInicio","black","","",200,30,1,1);
        
        $css->CrearInputText("TxtFechaFinP","date","<br>Fecha Fin Planeado:<br>",$FechaInicioPlaneado,"Fecha Fin","black","","",200,30,1,0);
        print("<strong><br>Hora Fin Planeada:<br></strong>");
        $css->CrearSelect("CmbHoraFinP", "");
            $HoraLimite=$obVenta->DevuelveValores("produccion_horas_cronograma", "Hora", $HoraInicioPlaneado);
            $idLimit=$HoraLimite[ID]-1;
            $Datos=$obVenta->ConsultarTabla("produccion_horas_cronograma", "LIMIT $idLimit,24");
            $Paro=0;
            while($DatosHorasCrono=$obVenta->FetchArray($Datos)){
                $selected=0;
                $DatosCrono=$obVenta->ConsultarTabla("produccion_actividades", " WHERE Fecha_Inicio='$FechaInicioPlaneado' AND Hora_Inicio='$DatosHorasCrono[Hora]' AND idMaquina='$idMaquina'");
                $DatosCrono=$obVenta->FetchArray($DatosCrono);
                if($DatosCrono["ID"]>0){
                    $Paro=1;
                }
                if($DatosHorasCrono["Hora"]==$HoraInicioPlaneado+1){
                    $selected=1;
                }
                if($Paro==0){
                    $css->CrearOptionSelect($DatosHorasCrono["Hora"], $DatosHorasCrono["Hora"], $selected);
                }
            }
        $css->CerrarSelect();
        $css->CrearTextArea("TxtDescripcion", "", "", "Descripcion", "Black", "", "", 200, 60, 0, 1);
        $css->CrearTextArea("TxtObservaciones", "", "", "Observaciones", "Black", "", "", 200, 60, 0, 0);
        echo '<br>';
        $css->CrearBotonConfirmado("BtnCrearActividad", "Crear Actividad");
        $css->CerrarForm();
	 
	 $css->CerrarCuadroDeDialogo(); 
         
         //////////////////////////////////
         //Cuadro de dialogo para editar la actividad
         ///////////////////////////////
         
        $DatosActividad=$obVenta->DevuelveValores("produccion_actividades", "ID", $idEdit);
        $DatosColaborador=$obVenta->DevuelveValores("usuarios", "identificacion", $DatosActividad['idColaborador']);
	$css->CrearCuadroDeDialogo("DialEditarActividad","Ver o Editar Actividad $idEdit Descripcion: $DatosActividad[Descripcion], Maquina: $DatosMaquina[Nombre]"); 
	 
        $css->CrearForm2("FrmEditarActividad",$myPage,"post","_self");
        $css->CrearInputText("idAct","hidden","",$idEdit,"","","","",0,0,0,0);
                
        $css->CrearInputText("TxtFechaInicioP","text","Fecha Inicio Planeado:<br>",$DatosActividad['Fecha_Planeada_Inicio'],"FechaInicio","black","","",200,30,0,1);
        
        //$css->CrearInputText("TxtHoraInicioP","text","<br>Hora Inicio Planeado:<br>",$DatosActividad['Hora_Planeada_Inicio'],"HoraInicio","black","","",200,30,0,1);
        echo '<br><strong>Hora Inicio Planeado:</strong><br>';
        $css->CrearSelect("TxtHoraInicioP", "");
            
            $Datos=$obVenta->ConsultarTabla("produccion_horas_cronograma", "");
            $Paro=0;
            while($DatosHorasCrono=$obVenta->FetchArray($Datos)){
                $selected=0;
                //$DatosCrono=$obVenta->ConsultarTabla("produccion_actividades", " WHERE Fecha_Inicio='$FechaInicioPlaneado' AND Hora_Inicio='$DatosHorasCrono[Hora]' AND idMaquina='$idMaquina'");
                //$DatosCrono=$obVenta->FetchArray($DatosCrono);
                
                if($DatosHorasCrono["Hora"].":00"==$DatosActividad['Hora_Planeada_Inicio']){
                    $selected=1;
                }
                if($Paro==0){
                    $css->CrearOptionSelect($DatosHorasCrono["Hora"], $DatosHorasCrono["Hora"], $selected);
                }
            }
        $css->CerrarSelect();
        
        //$css->CrearInputText("TxtFechaFinP","date","<br>Fecha Fin Planeado:<br>",$DatosActividad['Fecha_Planeada_Fin'],"Fecha Fin","black","","",200,30,0,1);
        //$css->CrearInputText("TxtHoraFinP","date","<br>Hora Fin Planeado:<br>",$DatosActividad['Hora_Planeada_Fin'],"Hora Fin","black","","",200,30,0,1);
        echo '<br><strong>Hora Fin Planeado:</strong><br>';
        $css->CrearSelect("TxtHoraFinP", "");
            
            $Datos=$obVenta->ConsultarTabla("produccion_horas_cronograma", "");
            $Paro=0;
            while($DatosHorasCrono=$obVenta->FetchArray($Datos)){
                $selected=0;
                //$DatosCrono=$obVenta->ConsultarTabla("produccion_actividades", " WHERE Fecha_Inicio='$FechaInicioPlaneado' AND Hora_Inicio='$DatosHorasCrono[Hora]' AND idMaquina='$idMaquina'");
                //$DatosCrono=$obVenta->FetchArray($DatosCrono);
                
                if($DatosHorasCrono["Hora"].":00"==$DatosActividad['Hora_Planeada_Fin']){
                    $selected=1;
                }
                if($Paro==0){
                    $css->CrearOptionSelect($DatosHorasCrono["Hora"], $DatosHorasCrono["Hora"], $selected);
                }
            }
        $css->CerrarSelect();
        
        $css->CrearTextArea("TxtDescripcion", "", "$DatosActividad[Descripcion]", "Descripcion", "Black", "", "", 200, 60, 0, 1);
        $css->CrearTextArea("TxtObservaciones", "", "$DatosActividad[Observaciones]", "Observaciones", "Black", "", "", 200, 60, 0, 0);
        echo '<br><strong>Colaborador:</strong><br>';
        $css->CrearSelect("CmbColaborador", "");
            $sql="SELECT Identificacion, Nombre, Apellido FROM usuarios";
            $Datos=$obVenta->Query($sql);
            $css->CrearOptionSelect("NO", "Sin Asignar" , 0);
            while($DatosUsuario=$obVenta->FetchArray($Datos)){
                $selected=0;
                
                if($DatosUsuario["Identificacion"]==$DatosActividad["idColaborador"]){
                    $selected=1;
                }
               
                    $css->CrearOptionSelect($DatosUsuario["Identificacion"], $DatosUsuario["Identificacion"]." ".$DatosUsuario["Nombre"]." ".$DatosUsuario["Apellido"] , $selected);
                
            }
        $css->CerrarSelect();
        echo '<br>';
        
        $css->CrearBotonConfirmado("BtnEditarActividad", "Editar Actividad");
        $css->CerrarForm();
	 
	 $css->CerrarCuadroDeDialogo(); 
    }
    ///////////////Creamos el contenedor principal
    
    $css->CrearDiv("principal", "container", "center",1,1);
    
    if($idOT<1){
        $css->CrearNotificacionRoja("Debes Seleccionar una Orden de trabajo para agregar Actividades", 16);
    }
    
    $css->CrearForm2("FrmFechaCrono", $myPage, "post", "_self");    
    $css->CrearInputText("idOT", "hidden", "", $idOT, "", "", "", "", "", "", 0, 0);
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
        $css->FilaTabla(14);
        echo("<td rowspan='2'>");
        print($DatosMaquinas["Nombre"]);
        echo("</td>");
        
        
        $DatosHoras=$obVenta->ConsultarTabla("produccion_horas_cronograma", "");
        
        while($HorasCronograma=$obVenta->FetchArray($DatosHoras)){
            $Page=$myPage;
            $Page.="?TxtFecha=$FechaActual&TxtHoraIni=$HorasCronograma[Hora]&idMaquina=$DatosMaquinas[ID]&idOT=$idOT";
            $Color="";
            $idActividad="";
            $Condicion="WHERE Fecha_Planeada_Inicio='$FechaActual' AND (Hora_Planeada_Inicio <='$HorasCronograma[Hora]' AND Hora_Planeada_Fin >'$HorasCronograma[Hora]') AND idMaquina='$DatosMaquinas[ID]'";
            $DatosActividades=$obVenta->ConsultarTabla("produccion_actividades", $Condicion);
                    
            $DatosActividades=$obVenta->FetchArray($DatosActividades);
            
            if($DatosActividades["ID"]>0){
                $idActividad=$DatosActividades["ID"];
                switch ($DatosActividades["Estado"]){
                    case "NO_INICIADA":
                        $ColorBG=$ColorNoIniciada;
                        break;
                    case "EJECUCION":
                        $ColorBG=$ColorEjecucion;
                        break;
                    case "PAUSA_OPERATIVA":
                        $ColorBG=$ColorPausaOperativa;
                        break;
                    case "PAUSA_NO_OPERATIVA":
                        $ColorBG=$ColorPausaNoOperativa;
                        break;
                    case "TERMINADA":
                        $ColorBG=$ColorTerminada;
                        break;
                }
                $Color="background-color: $ColorBG";
            }
            
            print("<td style='$Color'>");
            if($Color=="" and $idOT>0){
                $css->CrearLink($Page, "_self", "+...");
                
            }
            $Page.="&idEdit=$idActividad";
            $css->CrearLink($Page, "_self", "$idActividad");
            print("</td>");
            
            
            
        }
        $css->CierraFilaTabla();
        $css->FilaTabla(12);
        
        $DatosHoras=$obVenta->ConsultarTabla("produccion_horas_cronograma", "");
        
        while($HorasCronograma=$obVenta->FetchArray($DatosHoras)){
            $Page=$myPage;
            $Page.="?TxtFecha=$FechaActual&TxtHoraIni=$HorasCronograma[Hora]&idMaquina=$DatosMaquinas[ID]&idOT=$idOT";
            $Color="";
            $idActividad="";
            $Condicion="WHERE Fecha_Inicio='$FechaActual' AND (SUBSTRING(Hora_Inicio,1,2) <= SUBSTRING('$HorasCronograma[Hora]',1,2) AND Hora_Fin >'$HorasCronograma[Hora]') AND idMaquina='$DatosMaquinas[ID]' AND Estado<>'NO_INICIADA'";
            $DatosActividades=$obVenta->ConsultarTabla("produccion_actividades", $Condicion);
                    
            $DatosActividades=$obVenta->FetchArray($DatosActividades);
            
            if($DatosActividades["ID"]>0){
                $idActividad=$DatosActividades["ID"];
                switch ($DatosActividades["Estado"]){
                    case "NO_INICIADA":
                        $ColorBG=$ColorNoIniciada;
                        break;
                    case "EJECUCION":
                        $ColorBG=$ColorEjecucion;
                        break;
                    case "PAUSA_OPERATIVA":
                        $ColorBG=$ColorPausaOperativa;
                        break;
                    case "PAUSA_NO_OPERATIVA":
                        $ColorBG=$ColorPausaNoOperativa;
                        break;
                    case "TERMINADA":
                        $ColorBG=$ColorTerminada;
                        break;
                }
                $Color="background-color: $ColorBG";
            }
            
            print("<td style='$Color'>");
            
            $Page.="&idEdit=$idActividad";
            $css->CrearLink($Page, "_self", "$idActividad");
            print("</td>");
        }
        
        $css->CierraFilaTabla();
    }
    
    
    $css->CerrarTabla();
   
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    if(isset($_REQUEST["idMaquina"]) and $idEdit==0){
        print("<script>MostrarDialogoID('ImgCrearActividad');</script>");
    }
    if($idEdit>0){
        print("<script>MostrarDialogoID('ImgEditarActividad');</script>");
    }
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>