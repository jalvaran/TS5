<?php 
$myPage="VentasTitulos.php";
include_once("../sesiones/php_control.php");

include_once("css_construct.php");

$css =  new CssIni("TS5 Venta de Titulos");
$obVenta =  new ProcesoVenta($idUser);  
$css->CabeceraIni("TS5 Venta de Titulos"); 
    
$css->CreaBotonDesplegable("DialCliente","Tercero");

$css->CabeceraFin();

$obTabla = new Tabla($db);


include_once("procesadores/procesaVentasTitulos.php");
include_once 'cuadros_dialogo/CrearTercero.php';

$css->CrearDiv("Principal", "container", "center", 1, 1);

?>
<script>
function CargueValoresAdicionalesTitulo() {
    var Promocion;
    str=document.getElementById("TxtTitulo").value;
    Promocion=document.getElementsByName("CmbPromocion")[0].value;
   
    if (str == "") {
        document.getElementById("DivInfoTitulo").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("DivInfoTitulo").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","Consultas/DatosTitulos.php?Titulo="+str+"&idPromocion="+Promocion,true);
        xmlhttp.send();
    }
}
</script>
<?php 

//////Espacio para verificar si un titulo ya esta vendido       

//$obTabla->DibujeVerificacionTitulo($myPage, "");

$obTabla->DibujeAreaVentasTitulos($myPage, "");


$css->CrearDiv("DivInfoTitulo", "", "center", 1, 1);
$css->CrearNotificacionAzul("Datos del Titulo", 16);
$css->CerrarDiv();
$css->CerrarDiv();
$css->AgregaJS(); //Agregamos javascripts
$css->AnchoElemento("CmbCodMunicipio_chosen", 200);

$css->AgregaSubir();
$css->Footer();

ob_end_flush();
?>