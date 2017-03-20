<?php 
$myPage="CrearProductoVenta.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
	
print("<html>");
print("<head>");
$css =  new CssIni("Crear Producto");

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaAnularComprobanteIngreso.php");
    
    $css->CabeceraIni("Crear Producto para la Venta"); //Inicia la cabecera de la pagina
       
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
       
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    $css->CrearNotificacionAzul("Crear un Producto para la Venta", 16);
    $css->CrearForm2("FrmCrearProducto", $myPage, "post", "_self");
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Referencia</strong>", 1);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>Existencias</strong>", 1);
            $css->ColTabla("<strong>PrecioVenta</strong>", 1);
            $css->ColTabla("<strong>CostoUnitario</strong>", 1);
            $css->ColTabla("<strong>IVA</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td style='text-align:center'>");
            $css->CrearInputText("TxtReferencia", "text", "", "", "Referencia", "", "", "", 100, 30, 0, 0);
            print("</td>");
            print("<td style='text-align:center'>");
            $css->CrearInputText("TxtNombre", "text", "", "", "Nombre", "", "", "", 300, 30, 0, 1);
            print("</td>");
            print("<td style='text-align:center'>");
            $css->CrearInputNumber("TxtExistencias", "number", "", 0, "Existencias", "", "", "", 100, 30, 0, 1, 0, "", "any");
            print("</td>");
            print("<td style='text-align:center'>");
            $css->CrearInputNumber("TxtPrecioVenta", "number", "", "", "PrecioVenta", "", "", "", 100, 30, 0, 1, 0, "", "any");
            print("</td>");
            print("<td style='text-align:center'>");
            $css->CrearInputNumber("TxtCostoUnitario", "number", "", "", "CostoUnitario", "", "", "", 100, 30, 0, 1, 0, "", "any");
            print("</td>");
            print("<td style='text-align:center'>");
            $DatosEmpresa=$obVenta->DevuelveValores("empresapro", "idEmpresaPro", 1);
            $IVADefecto=0;
            if($DatosEmpresa["Regimen"]=="COMUN"){
                $IVADefecto=0.19;
            }
            $css->CrearSelect("CmbIVA", "");
            $consulta=$obVenta->ConsultarTabla("porcentajes_iva", "");
            $css->CrearOptionSelect("", "Seleccione un IVA", 0);
            while($DatosIVA=$obVenta->FetchArray($consulta)){
                $sel=0;
                if($DatosIVA["Valor"]==$IVADefecto){
                    $sel=1;
                }
                $css->CrearOptionSelect($DatosIVA["Valor"], $DatosIVA["Nombre"], $sel);
            }
            $css->CerrarSelect();
            print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Departamento</strong>", 1);
            $css->ColTabla("<strong>SubGrupo1</strong>", 1);
            $css->ColTabla("<strong>SubGrupo2</strong>", 1);
            $css->ColTabla("<strong>SubGrupo3</strong>", 1);
            $css->ColTabla("<strong>SubGrupo4</strong>", 1);
            $css->ColTabla("<strong>SubGrupo5</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td style='text-align:center'>");
            $pageConsulta="Consultas/DatosDepartamentos.php?Valida=2";
            $css->DibujeSelectBuscador("CmbDepartamento", $pageConsulta, "", "DivSub1", "onChange", 30, 100, "prod_departamentos", "", "idDepartamentos", "idDepartamentos", "Nombre", "");
            print("</td>");
            print("<td style='text-align:center'>");
                $css->CrearDiv("DivSub1", "", "center", 1, 1);
                $css->CerrarDiv();//Cerramos contenedor Principal
            print("</td>");
            print("<td style='text-align:center'>");
                $css->CrearDiv("DivSub2", "", "center", 1, 1);
                $css->CerrarDiv();//Cerramos contenedor Principal
            print("</td>");
            print("<td style='text-align:center'>");
                $css->CrearDiv("DivSub3", "", "center", 1, 1);
                $css->CerrarDiv();//Cerramos contenedor Principal
            print("</td>");
            print("<td style='text-align:center'>");
                $css->CrearDiv("DivSub4", "", "center", 1, 1);
                $css->CerrarDiv();//Cerramos contenedor Principal
            print("</td>");
            print("<td style='text-align:center'>");
                $css->CrearDiv("DivSub5", "", "center", 1, 1);
                $css->CerrarDiv();//Cerramos contenedor Principal
            print("</td>");
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>