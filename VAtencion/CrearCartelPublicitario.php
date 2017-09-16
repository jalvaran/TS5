<script>
function allowDrop(ev) {
    ev.preventDefault();
    
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
    
}

function drop(ev,idDiv) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var idProducto=document.getElementById(data).id;
    //alert(idProducto+' '+idDiv);
    ev.target.appendChild(document.getElementById(data));
    Page="Consultas/ActualizaCartel.php?idDiv="+idDiv+"&idProducto="+idProducto+"&key=";
    idTarget="DivNotificaciones";
    EnvieObjetoConsulta(Page,"DivNotificaciones",idTarget);
}
</script>
<?php 
$myPage="CrearCartelPublicitario.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
	
print("<html>");
print("<head>");
$css =  new CssIni("Cartel Publicitario");

print("</head>");
print("<body>");
    
    
    
    $css->CabeceraIni("Cartel Publicitario"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("DivNotificaciones", "container", "center",1,1);
    
    $css->CerrarDiv();
    $css->CrearDiv("DivPro", "", "center",1,1);
        $css->DivGrid("DivCartel", "", "left", 1, 1, 1, 100, 70, 1, "gray");
            $css->CrearNotificacionAzul("Arrastre los productos a cada espacio", 14);
            $css->CrearTabla();
                
                $css->FilaTabla(14);
                    print("<td colspan=4>");
                    print("<div id='Esp1' ondrop='drop(event,`Esp1`)' ondragover='allowDrop(event)' style='height:100px;text-align:center '></div>");
                    
                    $css->CerrarDiv();
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    for($i=2;$i<=17;$i++){
                        print("<td>");
                            print("<div id='Esp$i' ondrop='drop(event,`Esp$i`)' ondragover='allowDrop(event)' style=' height:100px;text-align:center '></div>");

                            $css->CerrarDiv();
                        print("</td>");
                        if($i==5 or $i==9 or $i==13){
                            $css->CierraFilaTabla();
                            $css->FilaTabla(14);
                        }
                    }
                    
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        $css->CerrarDiv();
        $css->DivGrid("DivProductos", "", "rigth", 1, 1, 1, 100, 28, 1, "gray");
        print('<img id="1" src="../images/alquiler.png" draggable="true" ondragstart="drag(event)" width="100" height="20">');
        print('<img id="2" src="../images/ajustes.png" draggable="true" ondragstart="drag(event)" width="100" height="20">');
        print('<img id="3" src="../images/salir.png" draggable="true" ondragstart="drag(event)" width="100" height="20">');
        print('<img id="4" src="../images/restaurante.png" draggable="true" ondragstart="drag(event)" width="100" height="20">');
                         
        $css->CerrarDiv();
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>