<?php 
$myPage="ReservaEspacios.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);

print("<html>");
print("<head>");
$css =  new CssIni("Reserva de Espacios");

print("</head>");
print("<body>");
    
      
    $css->CabeceraIni("Reserva de Espacios"); //Inicia la cabecera de la pagina
        $css->CreaBotonDesplegable("DialCliente","Crear Cliente");
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
        $css->DialTercero("DialCliente","Crear Cliente",$myPage,"");
        include_once 'procesadores/ReservaEspacios.process.php';
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Espacio</strong>", 1);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Cliente</strong>", 1);
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td>");
                $Page="Consultas/ReservaEspacios.query.php";
                $FuncionJS="EnvieObjetoConsulta2(`$Page`,`CmbEspacio`,`DivAgenda`,`6`);return false;";
                $css->CrearSelectTable("CmbEspacio", "reservas_espacios", "", "ID", "Nombre", "", "OnChange", $FuncionJS, "", 1);
                  
            print("</td>");
            print("<td>");
                
                //$FuncionJS="EnvieObjetoConsulta2(`$Page`,`CmbEspacio`,`DivAgenda`,`6`);return false;";
                $css->CrearInputText("TxtFecha", "date", "", date("Y-m-d"), "Fecha", "", "OnChange", $FuncionJS, 200, 30, 0, 1);
            print("</td>");
            print("<td>");
                $css->CrearTableChosen("CmbTercero", "clientes", "ORDER BY RazonSocial ASC", "RazonSocial", "Num_Identificacion", "Telefono", "idClientes", 400, 1, "Seleccione un Cliente", "");
               
            print("</td>");
            
        $css->CierraFilaTabla();
    $css->CerrarTabla(); 
    //print("<div id='DivAgenda' background-image:url('../images/cancha.jpg');>");
    $css->CrearDiv("DivAgenda", "container", "center",1,1);
   										
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AnchoElemento("CmbCodMunicipio_chosen", 200);
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>