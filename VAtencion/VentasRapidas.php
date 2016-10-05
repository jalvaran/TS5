<?php 
$myPage="VentasRapidas.php";
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

  
$myPage="VentasRapidas.php";
$css =  new CssIni("TS5 Ventas");
  
$css->CabeceraIni("TS5 Ventas"); 
    $css->CreaBotonAgregaPreventa($myPage,$idUser);
    $css->CreaBotonDesplegable("DialCliente","Tercero");

    $css->CrearForm("FrmPreventaSel",$myPage,"post","_self");
    $css->CrearSelect("CmbPreVentaAct","EnviaForm('FrmPreventaSel')");
    $css->CrearOptionSelect('NO','Seleccione una preventa',0);

    $pa=mysql_query("SELECT * FROM vestasactivas WHERE Usuario_idUsuario='$idUser'");	

           while($DatosVentasActivas=mysql_fetch_array($pa)){
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
        $css->CrearInputText("TxtBuscarSeparado", "text", " Buscar Separado ", "", "Buscar separado", "white", "", "", 200, 30, 0, 1);
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
include_once("procesadores/procesaVentasRapidas.php");

$Visible=0;
if($idPreventa>0){
    $Visible=1;
}
$css->CrearDiv("Principal", "container", "center", $Visible, 1);

//////Espacio para dibujar busquedas

//Dibujo una busqueda de un separado
if(!empty($_REQUEST["TxtBuscarSeparado"])){
    $key=$obVenta->normalizar($_REQUEST["TxtBuscarSeparado"]);
    $sql="SELECT sp.ID, cl.RazonSocial, cl.Num_Identificacion, sp.Total, sp.Saldo, sp.idCliente FROM separados sp"
            . " INNER JOIN clientes cl ON sp.idCliente = cl.idClientes "
            . " WHERE (sp.Estado<>'Cerrado' AND sp.Saldo>0) AND (cl.RazonSocial LIKE '%$key%' OR cl.Num_Identificacion LIKE '%$key%') LIMIT 10";
    $Datos=$obVenta->Query($sql);
    if($obVenta->NumRows($Datos)){
        $css->CrearTabla();
        
        while($DatosSeparado=$obVenta->FetchArray($Datos)){
            $css->FilaTabla(14);
            $css->ColTabla("<strong>Separado No. $DatosSeparado[ID]<strong>", 6);
            $css->CierraFilaTabla();
            $css->FilaTabla(14);
            print("<td>");
            $css->CrearForm2("FormAbonosSeparados$DatosSeparado[ID]", $myPage, "post", "_self");
            $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
            $css->CrearInputText("TxtIdSeparado","hidden","",$DatosSeparado["ID"],"","","","",0,0,0,0);
            $css->CrearInputText("TxtIdClientes","hidden","",$DatosSeparado["idCliente"],"","","","",0,0,0,0);
            $css->CrearInputNumber("TxtAbonoSeparado$DatosSeparado[ID]", "number", "Abonar: ", $DatosSeparado["Saldo"], "Abonar", "black", "", "", 200, 30, 0, 1, 1, $DatosSeparado["Saldo"], 1);
            $css->CrearBotonConfirmado("BtnAbono$DatosSeparado[ID]", "Abonar");
            $css->CerrarForm();
            print("</td>");
            $css->ColTabla($DatosSeparado["ID"], 1);
            $css->ColTabla($DatosSeparado["RazonSocial"], 1);
            $css->ColTabla($DatosSeparado["Num_Identificacion"], 1);
            $css->ColTabla(number_format($DatosSeparado["Total"]), 1);
            $css->ColTabla(number_format($DatosSeparado["Saldo"]), 1);
            $css->CierraFilaTabla();
            
            $css->FilaTabla(16);
            $css->ColTabla("ID Separado", 1);
            $css->ColTabla("Referencia", 1);
            $css->ColTabla("Nombre", 2);
            $css->ColTabla("Cantidad", 1);
            $css->ColTabla("TotalItem", 1);
            $css->CierraFilaTabla();
        
            $ConsultaItems=$obVenta->ConsultarTabla("separados_items", "WHERE idSeparado='$DatosSeparado[ID]'");
            while($DatosItemsSeparados=$obVenta->FetchArray($ConsultaItems)){
                
                $css->FilaTabla(14);
                $css->ColTabla($DatosItemsSeparados["idSeparado"], 1);
                $css->ColTabla($DatosItemsSeparados["Referencia"], 1);
                $css->ColTabla($DatosItemsSeparados["Nombre"], 2);
                $css->ColTabla($DatosItemsSeparados["Cantidad"], 1);
                $css->ColTabla($DatosItemsSeparados["TotalItem"], 1);
                $css->CierraFilaTabla();
            }           
            
             
            
        }
        $css->CerrarTabla();
    }else{
        $css->CrearNotificacionRoja("No se encontraron datos", 16);
    }
}

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

include_once 'cuadros_informativos/TotalesVentasRapidas.php';
include_once 'CuadroDialogoCrearCliente.php';
$css->CerrarDiv();
$css->AgregaJS(); //Agregamos javascripts
$css->AnchoElemento("CmbCodMunicipio_chosen", 200);
$css->AnchoElemento("CmbClientes_chosen", 200);
$css->AnchoElemento("TxtCliente_chosen", 200);
$css->AnchoElemento("TxtCuentaDestino_chosen", 200);
$css->AnchoElemento("TxtTipoPago_chosen", 200);
$css->AnchoElemento("CmbCuentaDestino_chosen", 300);
$css->AnchoElemento("CmbProveedores_chosen", 300);
$css->AgregaSubir();
$css->AgregaJSVentaRapida();
$css->Footer();
if(isset($_REQUEST["TxtBusqueda"])){
    print("<script>MostrarDialogo();</script>");
}
ob_end_flush();
?>