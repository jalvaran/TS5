<?php 
$myPage="CreacionConceptos.php";
include_once("../sesiones/php_control.php");

$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);
$idConcepto=0;
if(isset($_REQUEST["CmbConcepto"])){
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
}
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Creacion de Parametros Contables");

print("</head>");

print("<body>");
    
$css->CabeceraIni("Creacion de Parametros Contables"); //Inicia la cabecera de la pagin   
$css->CreaBotonDesplegable("CrearConcepto","Nuevo");
$css->CabeceraFin(); 

//Cuadros de Dialogo

 /////////////////Cuadro de dialogo de Clientes create
$css->CrearCuadroDeDialogo("CrearConcepto","Crear un Concepto"); 
    $css->CrearForm2("FrmCreaConcepto", $myPage, "post", "_self");
    $css->CrearTabla();
    $css->FilaTabla(16);
        $css->ColTabla("<strong>Nombre</strong>", 1);
        $css->ColTabla("<strong>Observaciones</strong>", 1);
        $css->ColTabla("<strong>Crear</strong>", 1);
    $css->CierraFilaTabla();
    $css->FilaTabla(16);
    print("<td>");
    
    $css->CrearInputText("TxtNombreNuevoConcepto", "text", "", "", "Nombre", "", "", "", 200, 30, 0, 1);
    
    print("</td>");        

    print("<td>");
    $css->CrearTextArea("TxtObservacionesNuevoConcepto","","","Observaciones","black","","",200,100,0,1);
    print("</td>");
    print("<td>");
    $css->CrearBotonConfirmado("BtnCrearConcepto", "Crear");
    print("</td>");   
    $css->CierraFilaTabla();
$css->CerrarTabla();
$css->CerrarForm(); 
$css->CerrarCuadroDeDialogo(); 
    
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);

//Select con la seleccion del Concepto

$css->CrearForm2("FrmSeleccionaConcepto", $myPage, "post", "_self");
    
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    
        $css->CrearSelect("CmbConcepto", "EnviaForm('FrmSeleccionaConcepto')");
        
            $css->CrearOptionSelect("","Selecciona un Concepto",0);
            
            $consulta = $obVenta->ConsultarTabla("conceptos","WHERE Completo='NO'");
            while($DatosConcepto=mysql_fetch_array($consulta)){
                if($idConcepto==$DatosConcepto['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $css->CrearOptionSelect($DatosConcepto['ID'],$DatosConcepto['ID']." ".$DatosConcepto['Nombre'],$Sel);							
            }
        $css->CerrarSelect();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();    
    
    
    include_once("procesadores/procesaCreacionConceptos.php");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////
    if($idConcepto==0){
        $css->CrearImageLink("../VMenu/MnuAjustes.php", "../images/conceptos.png", "_self",200,200);
    }
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    
    if($idConcepto>0){
        $DatosConcepto=$obVenta->DevuelveValores("conceptos", "ID", $idConcepto);
        $css->CrearNotificacionAzul("Agregue Montos al Concepto $idConcepto $DatosConcepto[Nombre]", 16);
        $css->CrearForm2("FrmAgregaMonto", $myPage, "post", "_self");
        $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Agregar un Monto</strong>", 5);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Nombre</strong>", 1);
        $css->ColTabla("<strong>Dependencia</strong>", 1);
        $css->ColTabla("<strong>Operacion</strong>", 1);
        $css->ColTabla("<strong>Valor de la dependencia</strong>", 1);
        $css->ColTabla("<strong>Agregar</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputText("TxtMonto", "text", "", "", "Nombre", "", "", "", 200, 30, 0, 1);
        print("</td>");
        print("<td>");
        $css->CrearSelect("CmbDependencia", "");
            $css->CrearOptionSelect("NO", "Sin Dependencia", 1);
            $Consulta=$obVenta->ConsultarTabla("conceptos_montos", "WHERE idConcepto='$idConcepto'");
            while($DatosMontos=$obVenta->FetchArray($Consulta)){
                $css->CrearOptionSelect($DatosMontos["ID"], $DatosMontos["NombreMonto"], 1);
            }        
            
        $css->CerrarSelect();
        print("</td>");
        print("<td>");
        $css->CrearSelect("CmbOperacion", "");
            $css->CrearOptionSelect("NO", "Sin Operacion", 1);
            $css->CrearOptionSelect("P", "Porcentaje", 0);
            $css->CrearOptionSelect("S", "Suma", 0);
            $css->CrearOptionSelect("R", "Resta", 0);
            
        $css->CerrarSelect();
        print("</td>");
        print("<td>");
        $css->CrearInputNumber("TxtValorDependencia", "number", "", 0, "Valor Depencia", "", "", "", 100, 30, 0, 0, 0, "", 1);
        print("</td>");
        print("<td>");
        $css->CrearBotonConfirmado("BtnCrearMonto", "Agregar");
        print("</td>");
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarForm();
    }
    
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>