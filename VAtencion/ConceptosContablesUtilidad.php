<?php 
$myPage="ConceptosContablesUtilidad.php";
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
$css =  new CssIni("Conceptos Contables");

print("</head>");

print("<body>");
    
$css->CabeceraIni("Conceptos Contables"); //Inicia la cabecera de la pagin   

$css->CabeceraFin(); 
 
    
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
            
            $consulta = $obVenta->ConsultarTabla("conceptos","WHERE Completo='SI' AND Activo='SI'");
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
    
    
    include_once("procesadores/ProcesaConceptosContablesUtilidad.php");
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
        $css->CrearNotificacionAzul("Concepto Contable $idConcepto $DatosConcepto[Nombre], Observaciones: $DatosConcepto[Observaciones]", 16);
        $css->CrearForm2("FrmAgregaMonto", $myPage, "post", "_self");
        $css->CrearInputText("CmbConcepto", "hidden", "", $idConcepto, "", "", "", "", "", "", "", "");
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarForm();
        }else{
            $css->CrearNotificacionRoja("No hay movimientos", 16);
        }    
        
        
        
   
    
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
?>