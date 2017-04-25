<?php 
$myPage="VentasRapidasV2.php";
include_once("../sesiones/php_control.php");
$NombreUser=$_SESSION['nombre'];

include_once("css_construct.php");

$ConsultaCajas=$obVenta->ConsultarTabla("cajas", "WHERE idUsuario='$idUser' AND Estado='ABIERTA'");
$DatosCaja=$obVenta->FetchArray($ConsultaCajas);

if($DatosCaja["ID"]<=0){
    
   header("location:401.php");
}   

$idPreventa="";
//////Si recibo una preventa
if(!empty($_REQUEST['CmbPreVentaAct'])){

        $idPreventa=$_REQUEST['CmbPreVentaAct'];
}

$css =  new CssIni("TS5 Ventas");
$obVenta=new ProcesoVenta($idUser);  
$css->CabeceraIni("TS5 Ventas"); 
    $css->CreaBotonAgregaPreventa($myPage,$idUser);
    $css->CreaBotonDesplegable("DialCliente","Tercero");

    $css->CrearForm("FrmPreventaSel",$myPage,"post","_self");
    $css->CrearSelect("CmbPreVentaAct","EnviaForm('FrmPreventaSel')");
    $css->CrearOptionSelect('NO','Seleccione una preventa',0);

    $pa=$obVenta->Query("SELECT * FROM vestasactivas WHERE Usuario_idUsuario='$idUser'");	

           while($DatosVentasActivas=$obVenta->FetchArray($pa)){
                   $label=$DatosVentasActivas["idVestasActivas"]." ".$DatosVentasActivas["Nombre"];

                   if($idPreventa==$DatosVentasActivas["idVestasActivas"])
                           $Sel=1;
                   else
                           $Sel=0;

                   $css->CrearOptionSelect($DatosVentasActivas["idVestasActivas"],$label,$Sel);

           }


    $css->CerrarSelect();
    $css->CerrarForm();
    if($idPreventa>=1){
        $css->CrearForm("FrmBuscarSeparados",$myPage,"post","_self");
        $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
        $css->CrearInputText("TxtBuscarSeparado", "text", " ", "", "Buscar separado", "white", "", "", 200, 30, 0, 1);
        $css->CerrarForm();
        $css->CrearForm("FrmBuscarCreditos",$myPage,"post","_self");
        $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
        $css->CrearInputText("TxtBuscarCredito", "text", " ", "", "Buscar Credito", "white", "", "", 200, 30, 0, 1);
        $css->CerrarForm();
        $css->CreaBotonDesplegable("DialSeparado","Separado");
        $css->CreaBotonDesplegable("DialEgreso","Egreso");
    }

    
$css->CabeceraFin();
$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	
$obTabla = new Tabla($db);

if(!empty($_REQUEST["TxtidFactura"])){
            
    $idFactura=$_REQUEST["TxtidFactura"];
    if($idFactura<>""){
        $RutaPrint="../tcpdf/examples/imprimirFactura.php?ImgPrintFactura=".$idFactura;
        $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $DatosFactura[NumeroFactura]</a>",16);
        $css->CerrarTabla();
    }else{

       $css->AlertaJS("No se pudo crear la factura porque no hay resoluciones disponibles", 1, "", ""); 
    }
            
}

if(!empty($_REQUEST["TxtIdEgreso"])){
    $idEgreso=$_REQUEST["TxtIdEgreso"];
    $RutaPrint="../tcpdf/examples/imprimircomp.php?ImgPrintComp=".$idEgreso;
    $css->CrearTabla();
        $css->CrearFilaNotificacion("Egreso Creado Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Egreso No. $idEgreso</a>",16);
    $css->CerrarTabla();
}

if(!empty($_REQUEST["CantidadCero"])){
    
    $css->CrearNotificacionRoja("No está permitido dejar cantidades en Cero", 18);
}

if(!empty($_REQUEST["NoAutorizado"])){
    $css->CrearNotificacionRoja("Clave Incorrecta !", 18);
}


$Visible=0;
if($idPreventa>0){
    $Visible=1;
}
$css->CrearDiv("Principal", "container", "center", $Visible, 1);
include_once("procesadores/procesaVentasRapidas.php");

//$css->DivPage("TxtTitulo", "cuadros_informativos/TotalesVentasRapidas.php?idUser=$idUser&idPreventa=$idPreventa&myPage=$myPage", "", "DivBusqueda", "onClick", 30, 30, "");
//$css->CrearDiv("DivBusqueda", "", "center",1,1);
//$css->CerrarDiv();
$sql="SELECT Autorizado FROM preventa WHERE Autorizado>=1 AND VestasActivas_idVestasActivas='$idPreventa' LIMIT 1";
$ConsultaPreventa=$obVenta->Query($sql);
$Autorizado=$obVenta->FetchArray($ConsultaPreventa); 

if($Autorizado>=1){
    
    $e=0;
}else{
    $e=1;
}
$css->CrearBotonOcultaDiv("Opciones: ", "DivDescuentos", 20, 20,$e, "");
$css->CrearDiv("DivDescuentos", "container", "center", 0, 1);
$css->CrearTabla();
$css->FilaTabla(16);
$css->ColTabla("<strong>DESCUENTO GENERAL POR PORCENTAJE</strong>", 1);
//$css->ColTabla("<strong>DESCUENTO GENERAL AL POR MAYOR</strong>", 1);
$css->CierraFilaTabla();
$css->FilaTabla(16);
print("<td style='text-align:center;'>");
$css->CrearForm2("FrmAutorizacionDescuento", $myPage, "post", "_self");
$css->CrearInputText("TxtidPreventa", "hidden", "", $idPreventa, "", "", "", "", "", "", "", "");
$css->CrearInputNumber("TxtDescuento", "number", "", "", "Descuento", "", "", "", 100,30, 0, 1, 1, 30, 1);
print("<br>");
$css->CrearBotonConfirmado("BtnDescuentoGeneral", "Descuento %");

$css->CerrarForm();
print("</td>");
/*
print("<td style='text-align:center;'>");
$css->CrearForm2("FrmDescuentoPorMayor", $myPage, "post", "_self");
$css->CrearInputText("TxtidPreventa", "hidden", "", $idPreventa, "", "", "", "", "", "", "", "");
$css->CrearBotonConfirmado("BtnDescuentoMayorGeneral", "Descuento Mayorista");

$css->CerrarForm();
print("</td>");
*/
 
$css->CierraFilaTabla();
$css->CerrarTabla();
$css->CerrarDiv();
//////Espacio para dibujar busquedas
//Verifico si hay peticiones para buscar separados
$obTabla->DibujaSeparado($myPage,$idPreventa,"");

//Verifico si hay peticiones para buscar creditos
$obTabla->DibujaCredito($myPage,$idPreventa,"");

if(isset($_REQUEST["TxtBusqueda"]) and !empty($_REQUEST["TxtBusqueda"])){
    $key=$_REQUEST["TxtBusqueda"];
    
    $PageReturn=$myPage."?CmbPreVentaAct=$idPreventa&TxtAgregarItemPreventa=";

    $obTabla->DibujeItemsBuscadosVentas($key,$PageReturn,"");

}
            
$css->CrearForm2("FrmCodBarras",$myPage,"post","_self");
$css->CrearTabla();
$css->FilaTabla(16);
print("<td style='text-align:center'>");

$css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
$css->CrearInputText("TxtCodigoBarras","text","Buscar por codigo de Barras:<br>","","Digite un codigo de Barras","black","","",200,30,0,0);

print("</td>");
print("<td style='text-align:center'>");
$VectorCuaBus["F"]=0;
$obTabla->CrearCuadroBusqueda($myPage,"CmbPreVentaAct",$idPreventa,"","",$VectorCuaBus);
$css->CrearBoton("BtnAgregarItem", "Buscar");
print("</td>");
print("<td>");
$css->CrearInputText("TxtAutorizacion", "password", "", "", "Autorizaciones", "", "", "", 200, 30, 0, 0);
print("</td>");
print("<td>");

print("<strong>Cerrar Turno:<br></strong>");

$css->CrearBotonConfirmado("BtnCerrarTurno", "Cerrar Turno");
print("</td>");
$css->CerrarTabla();
$css->CerrarForm();

/*
 * Visualizamos Totales y opciones de pago
 */
$css->CrearTabla();
$css->FilaTabla(16);
print("<td>");
$css->CrearDiv("DivTotales", "", "center", 1, 1);
include_once 'cuadros_informativos/TotalesVentasRapidas.php';
$css->CerrarDiv();
print("</td>");
print("<td>");
$css->CrearDiv("DivItemsPreventa", "", "center", 1, 1);
include_once 'cuadros_informativos/ItemsPreventa.php';
$css->CerrarDiv();
print("</td>");
$css->CierraFilaTabla();
$css->CerrarTabla();

include_once 'CuadroDialogoCrearCliente.php';
$css->CerrarDiv();
$css->AgregaJS(); //Agregamos javascripts
$css->AnchoElemento("CmbCodMunicipio_chosen", 200);
$css->AnchoElemento("CmbClientes_chosen", 200);
$css->AnchoElemento("TxtidColaborador_chosen", 200);
$css->AnchoElemento("TxtCliente_chosen", 200);
$css->AnchoElemento("TxtCuentaDestino_chosen", 200);
$css->AnchoElemento("TxtTipoPago_chosen", 200);
$css->AnchoElemento("CmbCuentaDestino_chosen", 300);
$css->AnchoElemento("CmbProveedores_chosen", 300);
$css->AgregaSubir();
$css->AgregaJSVentaRapida();
//print("<script>setInterval('BusquedaTxtTitulo()',500)</script>");
//$css->Footer();
if(isset($_REQUEST["TxtBusqueda"])){
    print("<script>MostrarDialogo();</script>");
}
ob_end_flush();
?>