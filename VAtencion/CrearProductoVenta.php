<?php 
$myPage="CrearProductoVenta.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);
$idDepartamento=0;
$Sub1=0;
$Sub2=0;
$Sub3=0;
$Sub4=0;
$Sub5=0;
if(isset($_REQUEST["idDepartamento"])){
    $idDepartamento=$obVenta->normalizar($_REQUEST["idDepartamento"]);
}
if(isset($_REQUEST["Sub1"])){
    $Sub1=$obVenta->normalizar($_REQUEST["Sub1"]);
}
if(isset($_REQUEST["Sub2"])){
    $Sub2=$obVenta->normalizar($_REQUEST["Sub2"]);
}
if(isset($_REQUEST["Sub3"])){
    $Sub3=$obVenta->normalizar($_REQUEST["Sub3"]);
}
if(isset($_REQUEST["Sub4"])){
    $Sub4=$obVenta->normalizar($_REQUEST["Sub4"]);
}
if(isset($_REQUEST["Sub5"])){
    $Sub5=$obVenta->normalizar($_REQUEST["Sub5"]);
}

print("<html>");
print("<head>");
$css =  new CssIni("Crear Producto");

print("</head>");
print("<body>");
    
    include_once("procesadores/CrearProducto.php");
    
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
    $css->CrearForm2("FrmSelDepartamentos", $myPage, "post", "_self");
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Departamento</strong>", 1);
            $css->ColTabla("<strong>SubGrupo1</strong>", 1);
            $css->ColTabla("<strong>SubGrupo2</strong>", 1);
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td style='text-align:center'>");
            $css->CrearSelectTable("idDepartamento", "prod_departamentos", "", "idDepartamentos", "idDepartamentos", "Nombre", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $idDepartamento,1);
            //$css->CrearSelectTable($Nombre, $tabla, $Condicion, $idItemValue, $OptionDisplay1, $OptionDisplay2, $Evento, $FuncionJS, $idSel, $Requerido)
            print("</td>");
            print("<td style='text-align:center'>");
                if($idDepartamento>0){
                    $Consulta=" WHERE idDepartamento='$idDepartamento'";
                    $css->CrearSelectTable("Sub1", "prod_sub1", "$Consulta", "idSub1", "NombreSub1", "idDepartamento", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $Sub1,0);
                }
            print("</td>");
            print("<td style='text-align:center'>");
                if($Sub1>0){
                    $Consulta=" WHERE idSub1='$Sub1'";
                    $css->CrearSelectTable("Sub2", "prod_sub2", "$Consulta", "idSub2", "NombreSub2", "idSub1", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $Sub2,0);
                }
            print("</td>");
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>SubGrupo3</strong>", 1);
            $css->ColTabla("<strong>SubGrupo4</strong>", 1);
            $css->ColTabla("<strong>SubGrupo5</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td style='text-align:center'>");
                if($Sub2>0){
                    $Consulta=" WHERE idSub2='$Sub2'";
                    $css->CrearSelectTable("Sub3", "prod_sub3", "$Consulta", "idSub3", "NombreSub3", "idSub2", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $Sub3,0);
                }
            print("</td>");
            print("<td style='text-align:center'>");
                if($Sub3>0){
                    $Consulta=" WHERE idSub3='$Sub3'";
                    $css->CrearSelectTable("Sub4", "prod_sub4", "$Consulta", "idSub4", "NombreSub4", "idSub3", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $Sub4,0);
                }
            print("</td>");
            print("<td style='text-align:center'>");
                $css->CrearSelectTable("Sub5", "prod_sub5", "", "idSub5", "NombreSub5", "", "onChange", "EnviaForm(`FrmSelDepartamentos`)", $Sub5,0);
            print("</td>");
        $css->CierraFilaTabla();
        $css->CerrarTabla();
    $css->CerrarForm();
    
    if($idDepartamento>0){
    $css->CrearForm2("FrmCrearProducto", $myPage, "post", "_self");
    $css->CrearInputText("idDepartamento", "hidden","" , $idDepartamento, "", "", "", "", "", "", "", "");
    $css->CrearInputText("Sub1", "hidden","" , $Sub1, "", "", "", "", "", "", "", "");
    $css->CrearInputText("Sub2", "hidden","" , $Sub2, "", "", "", "", "", "", "", "");
    $css->CrearInputText("Sub3", "hidden","" , $Sub3, "", "", "", "", "", "", "", "");
    $css->CrearInputText("Sub4", "hidden","" , $Sub4, "", "", "", "", "", "", "", "");
    $css->CrearInputText("Sub5", "hidden","" , $Sub5, "", "", "", "", "", "", "", "");
    //$css->CrearInputText($nombre, $type, $label, $value, $placeh, $color, $TxtEvento, $TxtFuncion, $Ancho, $Alto, $ReadOnly, $Required)
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Referencia</strong>", 1);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>Existencias</strong>", 1);
            $css->ColTabla("<strong>PrecioVenta</strong>", 1);
            $css->ColTabla("<strong>PrecioMayorista</strong>", 1);
            $css->ColTabla("<strong>CostoUnitario</strong>", 1);
            
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
            $css->CrearInputNumber("TxtPrecioMayorista", "number", "", "", "PrecioMayor", "", "", "", 100, 30, 0, 1, 0, "", "any");
            print("</td>");
            print("<td style='text-align:center'>");
            $css->CrearInputNumber("TxtCostoUnitario", "number", "", "", "CostoUnitario", "", "", "", 100, 30, 0, 1, 0, "", "any");
            print("</td>");
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<strong>IVA</strong>", 1);
        $css->ColTabla("<strong>CuentaPUC</strong>", 1);
        $css->ColTabla("<strong>Codigo Barras</strong>", 2);
        $css->ColTabla("<strong>Guardar</strong>", 2);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
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
            print("<td colspan='1' style='text-align:center'>");
            $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione la cuenta contable";
        $VarSelect["Required"]=1;
        $css->CrearSelectChosen("TxtCuentaPUC", $VarSelect);
        $sql="SELECT * FROM subcuentas WHERE PUC LIKE '41%'";
        $Consulta=$obVenta->Query($sql);
        $css->CrearOptionSelect("", "Seleccione una cuenta contable", 0);
           while($DatosCuenta=$obVenta->FetchArray($Consulta)){
               $sel=0;
               if($DatosCuenta["PUC"]=='4135'){
                   $sel=1;
               }               
               $css->CrearOptionSelect($DatosCuenta["PUC"],"$DatosCuenta[PUC] $DatosCuenta[Nombre]", $sel);
           }
        $css->CerrarSelect();
        print("</td>");
        print("<td colspan='2' style='text-align:center'>");
            $css->CrearInputText("TxtCodigoBarras", "text", "", "", "Codigo de Barras", "", "", "", 200, 30, 0, 0);
            print("</td>");
        print("<td colspan='2' style='text-align:center'>");
        $css->CrearBotonConfirmado("BtnCrearPV", "Crear Producto");
        //$css->CrearBotonImagen("", "BtnGuardar", "_self", "../images/save.png", "onclick='Confirmar()'", 50, 100, "", "", "");
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
    ob_end_flush();
?>