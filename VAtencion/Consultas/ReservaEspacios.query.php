<?php
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/ReservaEspacios.class.php");
$DiaSemana=array('','Lunes', 'Martes', 'Miercoles','Jueves','Viernes','Sabado','Domingo');
session_start();
$idUser=$_SESSION['idUser'];
$css =  new CssIni("");

$obReserva = new Reserva($idUser);
$idEspacio=$obReserva->normalizar($_REQUEST["idEspacio"]);
$Fecha=$obReserva->normalizar($_REQUEST["TxtFecha"]);
$SelFecha=strtotime($Fecha);
$NumDia=date("N",$SelFecha);
$DatosEspacio=$obReserva->DevuelveValores("reservas_espacios", "ID", $idEspacio);
$css->CrearNotificacionAzul("Cronograma en $DatosEspacio[Nombre] para el dia $DiaSemana[$NumDia] $Fecha", 16);
if(isset($_REQUEST["Hora"]) and isset($_REQUEST["idCliente"])){
    
    $Hora=$obReserva->normalizar($_REQUEST["Hora"]);
    $idCliente=$obReserva->normalizar($_REQUEST["idCliente"]);
    
    if($idCliente>0){
        $DatosCliente=$obReserva->DevuelveValores("clientes", "idClientes", $idCliente);
        $FechaInicio=$Fecha." ".$Hora;
        $HoraFinal=$Hora+1;
        if($Hora=="23:00"){
            $HoraFinal="23:59:00";
        }
        $FechaFin=$Fecha." ".($HoraFinal);
        $idReserva=$obReserva->CrearReserva($idEspacio,$DatosCliente["RazonSocial"], $FechaInicio, $FechaFin, $idCliente, $DatosCliente["Telefono"], "", $idUser, "");
        $css->CrearNotificacionVerde("Se ha asignado el Cliente $idCliente el $DiaSemana[$NumDia] a las $Hora", 16);
    }else{
        $css->CrearNotificacionRoja("Por favor Selecciona un Cliente",16);
    }
    
}
if(isset($_REQUEST["TxtA"])){
    $idEvento=$obReserva->normalizar($_REQUEST["idEvento"]);
    $Observaciones=$obReserva->normalizar($_REQUEST["TxtObservaciones"]);
    if($Observaciones<>''){
        $obReserva->ActualizaRegistro("reservas_eventos", "Observaciones", $Observaciones, "ID", $idEvento);
        if($_REQUEST["TxtA"]==1){
            $css->VentanaFlotante("Se han actualizado las observaciones del evento $idEvento con: $Observaciones");
            //$css->CrearNotificacionVerde("Se han actualizado las observaciones del evento $idEvento con: $Observaciones",16);
        }
        if($_REQUEST["TxtA"]==2){
            $obReserva->ActualizaRegistro("reservas_eventos", "Estado", "AN", "ID", $idEvento);
            $css->VentanaFlotante("Se ha descartado el evento $idEvento por $Observaciones");
        }
    }else{
        $css->CrearNotificacionRoja("Debe escribir observaciones para descartar este evento",16);
    }
    
    
}
$css->CrearTabla();
    $css->FilaTabla(16);
        $css->ColTabla("<strong>Hora</strong>", 1);
        $css->ColTabla("<strong>Accion</strong>", 1);
        $css->ColTabla("<strong>Cliente</strong>", 1);
        $css->ColTabla("<strong>Telefono</strong>", 1);
        $css->ColTabla("<strong>Observaciones</strong>", 1);
        $css->ColTabla("<strong>Valor</strong>", 1);
        $css->ColTabla("<strong>Facturar</strong>", 1);
    $css->CierraFilaTabla();
    
    for($i=$DatosEspacio["HoraInicial"];$i<=$DatosEspacio["HoraFinal"];$i++){
        $Hora=str_pad($i, 2, "0", STR_PAD_LEFT).":00";
        $FechaBusqueda=$Fecha." ".$Hora.":00";
        $DatosReservas=$obReserva->ValorActual("reservas_eventos", "*", "FechaInicio='$FechaBusqueda' AND idEspacio='$idEspacio' AND Estado<>'AN'");
        
        $css->FilaTabla(16);
            
            $css->ColTabla($Hora, 1);
            print("<td>");
                if($DatosReservas["ID"]>0){
                    $Page="Consultas/ReservaEspacios.query.php?idEspacio=$idEspacio&TxtFecha=$Fecha&idEvento=$DatosReservas[ID]&TxtA=2&TxtObservaciones=";
                    $Javascript="onClick=EnvieObjetoConsulta2(`$Page`,`TxtObservaciones$i`,`DivAgenda`,`99`);return false;";
                    $css->CrearImage("ImgDescartar$i", "../images/delete.png", "Descartar", 30, 30, $Javascript);                   
                }else{
                    $Page="Consultas/ReservaEspacios.query.php?idEspacio=$idEspacio&TxtFecha=$Fecha&Hora=$Hora&idCliente=";
                    $Javascript="onClick=EnvieObjetoConsulta2(`$Page`,`CmbTercero`,`DivAgenda`,`99`);return false;";

                    $css->CrearImage("ImgAgregar$i", "../images/agregar2.png", "Agregar", 30, 30, $Javascript);
                }
                
            print("</td>");
            
            print("<td>");
                if($DatosReservas["ID"]>0){
                    
                    $DatosClienteReserva=$obReserva->DevuelveValores("clientes", "idClientes",$DatosReservas["idCliente"] );
                     print($DatosClienteReserva["RazonSocial"]);
                }else{
                    
                }
            print("</td>");
            print("<td>");
                if($DatosReservas["ID"]>0){
                    print($DatosClienteReserva["Telefono"]);
                }
            print("</td>");
            print("<td>");
                if($DatosReservas["ID"]>0){
                    $Page="Consultas/ReservaEspacios.query.php?idEspacio=$idEspacio&TxtFecha=$Fecha&idEvento=$DatosReservas[ID]&TxtA=1&TxtObservaciones=";
                    $Javascript="EnvieObjetoConsulta2(`$Page`,`TxtObservaciones$i`,`DivAgenda`,`99`);return false;";
                    $css->CrearTextArea("TxtObservaciones$i", "", $DatosReservas["Observaciones"], "Observaciones", "", "OnChange", $Javascript, 200, 60, 0, 1);
                }
            print("</td>");
            print("<td>");
                if($DatosReservas["ID"]>0){
                    
                }
            print("</td>");
            print("<td>");
                if($DatosReservas["ID"]>0){
                    
                }
            print("</td>");
        $css->CierraFilaTabla();
    }
$css->CerrarTabla();

?>