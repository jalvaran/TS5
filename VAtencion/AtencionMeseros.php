<?php 
$myPage="AtencionMeseros.php";
include_once("../sesiones/php_control.php");

$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);
$idMesa=0;
if(isset($_REQUEST["idMesa"])){
    $idMesa=$obVenta->normalizar($_REQUEST["idMesa"]);
}
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Atencion");
print("</head>");
print("<body>");
    
    $css->CabeceraIni("Atencion"); //Inicia la cabecera de la pagina
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    if($idMesa>0){
        $obTabla->CrearSubtotalCuentaRestaurante($idMesa,"");
    }  
    
    $css->CrearDiv("secundario", "", "center",1,1);
    $css->CrearForm2("FrmSelMesa", $myPage, "post", "_self");
    $css->CrearTabla();
    $css->FilaTabla(16);
    $css->ColTabla("<strong>Seleccione una mesa</strong>", 1);
    $css->CierraFilaTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center;'>");
    $css->CrearSelect("idMesa", "EnviaForm('FrmSelMesa')");
    $css->CrearOptionSelect("", "Seleccione una Mesa", 0);
    $consulta=$obVenta->ConsultarTabla("restaurante_mesas", "");
    
    while($DatosMesas=$obVenta->FetchArray($consulta)){
        $sel=0;
        if($idMesa==$DatosMesas["ID"]){
            $sel=1;
        }
        $css->CrearOptionSelect($DatosMesas["ID"], $DatosMesas["Nombre"], $sel);
    }
    $css->CerrarSelect();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarDiv();//Cerramos contenedor secundario
    
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>