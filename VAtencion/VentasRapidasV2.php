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
    $Page="Consultas/ItemsPreventa.php?myPage=$myPage&CmbPreVentaAct=";
    $Page2="Consultas/TotalesVentasRapidas.php?idClientes=$idClientes&myPage=$myPage&CmbPreVentaAct=";
    $css->CrearSelect("CmbPreVentaAct","EnvieObjetoConsulta(`$Page`,`CmbPreVentaAct`,`DivProductos`,`2`);EnvieObjetoConsulta(`$Page2`,`CmbPreVentaAct`,`DivTotales`,`2`);return false ;");
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
$css->CrearDiv("DivPrincipal", "container", "left", 1, 1);
include_once("procesadores/procesaVentasRapidas.php");
    $css->DivGrid("DivTotales", "", "left", 1, 1, 1, 90, 25,5,"transparent");
    
    $css->CerrarDiv();
        $css->DivGrid("DivProductos", "", "center", 1, 1, 2, 90, 70,5,"transparent");
    
        $css->CerrarDiv();
    $css->CerrarDiv();
    
$css->CerrarDiv();


$css->AgregaSubir();
$css->AgregaJS(); //Agregamos javascripts
$css->Footer();
?>