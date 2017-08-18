<?php 
$myPage="VentasRapidasV2.php";
include_once("../sesiones/php_control.php");
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
$idClientes=1;
//////Si recibo un cliente
if(isset($_REQUEST['idClientes'])){

        $idClientes=$_REQUEST['idClientes'];
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
        
        $Page="Consultas/BuscarSeparados.php?myPage=$myPage&CmbPreVentaAct=$idPreventa&TxtBuscarSeparado=";
        $css->CrearInputText("TxtBuscarSeparado","text","","","Buscar separado","black","onKeyUp","EnvieObjetoConsulta(`$Page`,`TxtBuscarSeparado`,`DivBusquedas`,`2`);return false;",200,30,0,0);
        
        $Page="Consultas/BuscarCreditos.php?myPage=$myPage&CmbPreVentaAct=$idPreventa&TxtBuscarCredito=";
        $css->CrearInputText("TxtBuscarCredito","text","","","Buscar Credito","black","onKeyUp","EnvieObjetoConsulta(`$Page`,`TxtBuscarCredito`,`DivBusquedas`,`2`);return false;",200,30,0,0);
       
        $css->CreaBotonDesplegable("DialSeparado","Separado");
        $css->CreaBotonDesplegable("DialEgreso","Egreso");
    }

    
$css->CabeceraFin();

if(!empty($_REQUEST["TxtidFactura"])){
            
    $idFactura=$_REQUEST["TxtidFactura"];
    if($idFactura<>""){
        $RutaPrint="PDF_Factura.php?ImgPrintFactura=".$idFactura;
        $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
        
        $css->CrearNotificacionVerde("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $DatosFactura[NumeroFactura]</a>",16);
        
    }else{

       $css->AlertaJS("No se pudo crear la factura porque no hay resoluciones disponibles", 1, "", ""); 
    }
            
}
if(!empty($_REQUEST["TxtIdEgreso"])){
    $idEgreso=$_REQUEST["TxtIdEgreso"];
    $RutaPrint="../tcpdf/examples/imprimircomp.php?ImgPrintComp=".$idEgreso;
    
        $css->CrearNotificacionVerde("Egreso Creado Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Egreso No. $idEgreso</a>",16);
    
}

if(!empty($_REQUEST["CantidadCero"])){
    
    $css->CrearNotificacionRoja("No está permitido dejar cantidades en Cero", 18);
}

if(!empty($_REQUEST["NoAutorizado"])){
    $css->CrearNotificacionRoja("Clave Incorrecta !", 18);
}
$css->CrearDiv("DivPrincipal", "container", "left", 1, 1);
include_once("procesadores/procesaVentasRapidas.php");
if($idPreventa>0){
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");

    $Page="Consultas/AgregaItemXPeso.php?CmbPreVentaAct=$idPreventa&myPage=$myPage&key=";
    $css->CrearInputText("TxtPesar","text","","","Digite el ID","black","onchange","EnvieObjetoConsulta(`$Page`,`TxtPesar`,`DivBusquedas`,`2`);return false ; document.getElementById('TxtCantidadBascula').focus();",200,30,0,0);

    print("</td>");

    print("<td style='text-align:center'>");
   
    $Page="Consultas/ItemsPreventa.php?CmbPreVentaAct=$idPreventa&myPage=$myPage&key=";
    //$Page2="Consultas/TotalesVentasRapidas.php?idClientes=$idClientes&myPage=$myPage&CmbPreVentaAct=$idPreventa&";
    $css->CrearInputText("TxtCodigoBarras","text","","","Codigo de Barras","black","onchange","EnvieObjetoConsulta(`$Page`,`TxtCodigoBarras`,`DivItemsPreventa`);return false ;",200,30,0,0);
    print("</td>");
    print("<td style='text-align:center'>");
    
    $Page="Consultas/BuscarItems.php?CmbPreVentaAct=$idPreventa&myPage=$myPage&key=";
    $css->CrearInputText("BuscarItems","text","","","Buscar Items","black","onKeyUp","EnvieObjetoConsulta(`$Page`,`BuscarItems`,`DivBusquedas`,`99`);return false ;",200,30,0,0);
    print("</td>");
    print("<td style='text-align:center'>");
    
    $Page="Consultas/ItemsPreventa.php?CmbPreVentaAct=$idPreventa&myPage=$myPage&TxtAutorizacion=";
    $css->CrearInputText("TxtAutorizacion","password","","","Autorizacion","black","onchange","EnvieObjetoConsulta(`$Page`,`TxtAutorizacion`,`DivItemsPreventa`);return false ;",100,30,0,0);
    
    print("</td>");
    print("<td style='text-align:center'>");
    $Page="Consultas/DatosCupoClientes.php?CmbPreVentaAct=$idPreventa&TxtConsultaCupo=";
    $css->CrearInputText("BuscarCupo","text","","","Buscar Clientes","black","onKeyUp","EnvieObjetoConsulta(`$Page`,`BuscarCupo`,`DivBusquedas`,`99`);return false ;",200,30,0,0);
    print("</td>");
    print("<td style='text-align:center'>");
    $css->CrearForm2("FrmCerrarTurno",$myPage,"post","_self");
    $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
    $css->CrearBotonConfirmado("BtnCerrarTurno", "Cerrar Turno");
    $css->CerrarForm();
    print("</td>");
    $css->CerrarTabla();
}

$css->CrearDiv("DivBusquedas", "", "center", 1, 1);
$css->CerrarDiv();//Cerramos contenedor Principal

        $css->CrearDiv("DivItemsPreventa", "", "center", 1, 1);
        
        $css->CerrarDiv();
    $css->CerrarDiv();
    
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
if($idPreventa>0){
    $Page="Consultas/ItemsPreventa.php?myPage=$myPage&idClientes=$idClientes&CmbPreVentaAct=";
    //$Page2="Consultas/TotalesVentasRapidas.php?idClientes=$idClientes&myPage=$myPage&CmbPreVentaAct=";
    print("<script>EnvieObjetoConsulta(`$Page`,`CmbPreVentaAct`,`DivItemsPreventa`,`2`);</script>");
}
?>