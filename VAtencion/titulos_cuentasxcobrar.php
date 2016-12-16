<?php
$myPage="titulos_cuentasxcobrar.php";
include_once("../sesiones/php_control.php");

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("Configuraciones/titulos_cuentasxcobrar.ini.php");  //Clases de donde se escribirán las tablas

$obTabla = new Tabla($db);

$statement = $obTabla->CreeFiltro($Vector);
//print($statement);
$Vector["statement"]=$statement;   //Filtro necesario para la paginacion


$obTabla->VerifiqueExport($Vector);

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
$css->CrearDiv("principal", "container", "center",1,1);
include_once("procesadores/procesaTitulosCuentasXCobrar.php");  //Clases de donde se escribirán las tablas
    
$css->DibujeCuadroBusqueda("BuscarCuentaXPagar","Consultas/DatosCuentaXPagar.php?key","idPromocion=7","DivBusqueda","onChange",30,100,"");
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	

$css->CrearDiv("DivBusqueda", "", "center", 1, 1);
$css->CerrarDiv();//Cerramos contenedor Principal
$css->CrearImageLink("../VMenu/Menu.php", "../images/cartera.png", "_self",200,200);

$TotalCartera=  number_format($obVenta->Sume("titulos_cuentasxcobrar", "Saldo",""));

$css->CrearNotificacionAzul("Total en Cartera: $ $TotalCartera", 16);


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