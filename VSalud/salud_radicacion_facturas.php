<?php
$myPage="salud_radicacion_facturas.php";
include_once("../sesiones/php_control.php");

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/salud_radicacion_facturas.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);

$statement = $obTabla->CreeFiltro($Vector);
//print($statement);
$Vector["statement"]=$statement;   //Filtro necesario para la paginacion


$obTabla->VerifiqueExport($Vector);
include_once("procesadores/salud_radicacion_facturas.process.php");  //Clases de donde se escribirán las tablas
include_once("css_construct.php");
print("<html>");
print("<head>");

$css =  new CssIni($myTitulo);
print("</head>");
print("<body>");
//Cabecera
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina

     
$css->CabeceraFin(); 

///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("DivPrincipal", "container", "center", 1, 1);
$css->DivNotificacionesJS();
$obTabla->FormularioRangoFechas($myPage,$statement, "");
$statement=$obTabla->FiltroRangoFechas("fecha_factura", $statement, "");
$Vector["statement"]=$statement;   //Filtro necesario para la paginacion
$css->CrearDiv("DivBusquedas", "", "center", 1, 1);
$css->CerrarDiv();

$css->CrearDiv("DivRadicacion", "", "center", 1, 1);
    $css->CrearForm2("FrmRadicacion", $myPage, "post", "_self");
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>RADICAR FACTURAS</strong>", 6);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>EPS</strong>", 1);
                $css->ColTabla("<strong>Fecha de Radicado</strong>", 1);
                $css->ColTabla("<strong>Numero de Radicado</strong>", 1);
                $css->ColTabla("<strong>Soporte</strong>", 1);
                $css->ColTabla("<strong>Fecha Inicial de Facturas</strong>", 1);
                $css->ColTabla("<strong>Fecha Final de Facturas</strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                    $VarSelect["Ancho"]="200";
                    $VarSelect["PlaceHolder"]="Busque una EPS";
                    $VarSelect["Required"]=1;
                    $css->CrearSelectChosen("CmbEPS", $VarSelect);
                    
                    $sql="SELECT * FROM salud_eps";
                    $Consulta=$obVenta->Query($sql);
                    while($DatosEPS=$obVenta->FetchArray($Consulta)){

                           $css->CrearOptionSelect("$DatosEPS[cod_pagador_min]", "$DatosEPS[cod_pagador_min] /$DatosEPS[nombre_completo] / $DatosEPS[nit] / dias convenio: $DatosEPS[dias_convenio]" , 0);
                       }
                    
                    $css->CerrarSelect();
    
                print("</td>");
                print("<td>");
                    $css->CrearInputText("TxtFechaRadicado", "date", "", date("Y-m-d"), "Fecha Radicado", "", "", "", 150, 30, 0, 1);
                print("</td>");
                print("<td>");
                    $css->CrearInputText("TxtNumeroRadicado", "text", "", "", "Numero de Radicado", "", "", "", 150, 30, 0, 1);
                print("</td>");
                print("<td>");
                    $css->CrearUpload("Soporte");
                print("</td>");
                print("<td>");
                    $css->CrearInputText("TxtFechaInicial", "date", "", date("Y-m-d"), "Fecha Inicial", "", "", "", 150, 30, 0, 1);
                print("</td>");
                print("<td>");
                    $css->CrearInputText("TxtFechaFinal", "date", "", date("Y-m-d"), "Fecha Final", "", "", "", 150, 30, 0, 1);
                print("</td>");
                
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td colspan=6 style='text-align:center'>");
                    $css->CrearBotonConfirmado("BtnRadicar", "Radicar");
                print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
    $css->CerrarForm();
$css->CerrarDiv();
////Paginacion
////
$Ruta="";
print("<div style='height: 50px;'>");   //Dentro de un DIV para no hacerlo tan grande
print(pagination($Ruta,$statement,$limit,$page));
print("</div>");
////
///Dibujo la tabla
////
///

$obTabla->DibujeTabla($Vector);
$css->CerrarDiv();//Cerramos contenedor Principal
$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");

ob_end_flush();
?>