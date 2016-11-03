<?php
$myPage="cartera.php";
include_once("../sesiones/php_control.php");

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/Cartera.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);

$statement = $obTabla->CreeFiltro($Vector);
//print($statement);
$Vector["statement"]=$statement;   //Filtro necesario para la paginacion


$obTabla->VerifiqueExport($Vector);
include_once("procesadores/procesaCartera.php");  //Clases de donde se escribirán las tablas
include_once("css_construct.php");
print("<html>");
print("<head>");

$css =  new CssIni($myTitulo);
print("</head>");
print("<body>");
//Cabecera
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina

$css->CrearForm("FrmBuscarCreditos",$myPage,"post","_self");
$css->CrearInputText("TxtBuscarCredito", "text", " ", "", "Buscar Credito", "white", "", "", 200, 30, 0, 1);
$css->CerrarForm();
$css->CabeceraFin(); 

///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);
if(!empty($_REQUEST["TxtidIngreso"])){
        $RutaPrintIngreso="../tcpdf/examples/imprimiringreso.php?ImgPrintIngreso=".$_REQUEST["TxtidIngreso"];			
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Comprobante de Ingreso Creado Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Comprobante de Ingreso No. $_REQUEST[TxtidIngreso]</a>",16);
        $css->CerrarTabla();
    }
    
$VectorCredito["HabilitaCmbCuentaDestino"]=1;
$obTabla->DibujaCredito($myPage,0,$VectorCredito);

//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
$css->CrearImageLink("../VMenu/Menu.php", "../images/cartera.png", "_self",200,200);

$PromedioDias=$obVenta->ActualiceDiasCartera();
$TotalCartera=  number_format($obVenta->Sume("cartera", "Saldo",""));

$css->CrearNotificacionAzul("Total en Cartera: $ $TotalCartera", 16);
if($PromedioDias>30){
    $css->CrearNotificacionRoja("Rotacion de Cartera: $PromedioDias", 16);
}else{
    $css->CrearNotificacionVerde("Rotacion de Cartera: $PromedioDias", 16);
}

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