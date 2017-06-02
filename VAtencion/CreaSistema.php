<?php 
$myPage="CreaSistema.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesSistemas.php");
include_once("css_construct.php");

$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta($idUser);
$obSistema=new Sistema($idUser);
$idSistema=0;
if(isset($_REQUEST["idSistema"])){
    $idSistema=$_REQUEST["idSistema"];
    
}	

print("<html>");
print("<head>");
$css =  new CssIni("Creacion de Sistemas");

print("</head>");
print("<body>");
    
    include_once("procesadores/CreaSistema.process.php");
    $css->CabeceraIni("Crear Sistema"); //Inicia la cabecera de la pagina
    $css->CrearImageLink("vista_sistemas.php", "../images/volver2.png", "_self", 30, 30);
   
    $css->CreaBotonDesplegable("CrearSistema","Nuevo");  
    $css->CabeceraFin(); 
   
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearCuadroDeDialogoAmplio("CrearSistema", "Crear un Sistema");
     
        $css->CrearForm2("FrmCrearSistema", $myPage, "post", "_self");
        
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>PrecioVenta</strong>", 1);
            $css->ColTabla("<strong>PrecioMayorista</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearTextArea("TxtNombre","","","Escriba el Nombre del Sistema","black","","",320,60,0,1);
        
        print("</td>");        
        print("<td>"); 
        $css->CrearInputNumber("TxtPrecioVenta", "number", "", "", "PrecioVenta", "", "", "", 200, 30, 0, 1, 1, "", 1);
        print("</td>");
        print("<td>");
        $css->CrearInputNumber("TxtPrecioMayor", "number", "", "", "PrecioMayorista", "", "", "", 200, 30, 0, 1, 1, "", 1);
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Observaciones</strong>", 1);
            $css->ColTabla("<strong>Imagen</strong>", 1);
            $css->ColTabla("<strong>CuentaPUC</strong>", 1);
        $css->CierraFilaTabla(); 
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearTextArea("TxtObservaciones","","","Observaciones","black","","",320,60,0,1);
        print("</td>");
        print("<td>");
        $css->CrearUpload("foto");
        print("</td>");
        print("<td>");
        $VarSelect["PlaceHolder"]="Seleccione la cuenta";
        $css->CrearSelectChosen("CuentaPUC", $VarSelect);
            $consulta=$obSistema->ConsultarTabla("subcuentas", "WHERE PUC LIKE '4135%' OR PUC LIKE '4235%'");
            while($DatosCuenta=$obSistema->FetchArray($consulta)){
                $sel=0;
                if($DatosCuenta=="4135"){
                    $sel=1;
                }
                $css->CrearOptionSelect($DatosCuenta["PUC"], $DatosCuenta["Nombre"]." ".$DatosCuenta["PUC"] , $sel);
                
            }
          
        $css->CerrarSelect();
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td><strong>Subgrupos:</strong>");
            $css->CrearDiv("DivDepartamentos", "", "center", 1, 1);
            $Page="Consultas/AsignaDepartamentosSistemas.php?Valida=1&key=";
            $Page2="Consultas/AsignaDepartamentosSistemas.php?Valida=5&key=";
            $css->CrearSelectTable("CmbDepartamento", "prod_departamentos", "", "idDepartamentos", "Nombre", "idDepartamentos", "onchange", "EnvieObjetoConsulta(`$Page`,`CmbDepartamento`,`DivSub1`,`0`);EnvieObjetoConsulta(`$Page2`,`CmbDepartamento`,`DivSub5`,`0`)", "idDepartamentos", 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivSub1", "", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivSub2", "", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivSub3", "", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivSub4", "", "center", 1, 1);
            $css->CerrarDiv();
            
        print("</td>");
        print("<td><strong>Subgrupo 5 y Codigo de Barras:</strong>");
            $css->CrearDiv("DivSub5", "", "center", 1, 1);
            $css->CerrarDiv();
            $css->CrearDiv("DivCodBarras", "", "center", 1, 1);
                $css->CrearInputText("TxtCodigoBarras", "text", "", "", "CodigoBarras", "", "", "", 200, 30, 0, 0);
            $css->CerrarDiv();
        print("</td>");
        print("<td>");
            $css->CrearBotonConfirmado("BtnCrearSistema", "Crear Sistema");
        print("</td>");
        $css->CierraFilaTabla();   
    
    $css->CerrarTabla();
    
    $css->CerrarForm();
    $css->CerrarCuadroDeDialogoAmplio();
       
    $css->CrearDiv("principal", "container", "center",1,1);
    ////Menu de historial
    $css->CrearNotificacionAzul("Agregar Items al Sistema", 18);  
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
     /////////////////Cuadro de dialogo de Clientes create
    
    
    
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    $css->CrearForm2("FrmSeleccionaSistema", $myPage, "post", "_self");
        $css->CrearSelect("idSistema", "EnviaForm('FrmSeleccionaSistema')");
        
            $css->CrearOptionSelect("","Selecciona un Sistema",0);
            
            $consulta = $obVenta->ConsultarTabla("sistemas","WHERE Estado='ABIERTO'");
            while($DatosSistemas=$obVenta->FetchArray($consulta)){
                if($idSistema==$DatosSistemas['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $css->CrearOptionSelect($DatosSistemas['ID'],$DatosSistemas['Nombre'],$Sel);							
            }
        $css->CerrarSelect();
    $css->CerrarForm();
    print("</td>");
    print("<td>");
    $css->CrearDiv("DivActualiza", "", "center", 1, 1);
    if($idSistema>0){
        
        $DatosSistemas=$obSistema->DevuelveValores("sistemas", "ID", $idSistema);
        $TotalSistema=$obSistema->Sume("vista_sistemas", "PrecioVenta", "WHERE idSistema='$idSistema'");
        print("<strong> Precio Sugerido para sistema $DatosSistemas[Nombre]: $TotalSistema<strong><br>");
        $css->CrearForm2("FrmEditaValorSistema", $myPage, "post", "_self");
        $css->CrearInputText("idSistema", "hidden", "", $idSistema, "", "", "", "", "", "", 1, 1);
        $css->CrearInputText("TxtTotalSistema", "hidden", "", $TotalSistema, "", "", "", "", "", "", 1, 1);
        $css->CrearInputNumber("TxtValorSistema", "number", " Precio Venta: ", $DatosSistemas["PrecioVenta"], "Valor", "black", "", "", 100, 30, 0, 1, 1, "", 1);
        $css->CrearInputNumber("TxtPrecioMayor", "number", " Precio Mayorista: ", $DatosSistemas["PrecioMayorista"], "Valor", "black", "", "", 100, 30, 0, 1, 1, "", 1);
        print("<br>"); 
        $css->ImageOcultarMostrar("ImgOculta", "Mostrar Mas Opciones: ", "DivMasOpciones", 30, 30, "");
        $css->CrearDiv("DivMasOpciones", "", "center", 0, 1);
        $css->CrearTextArea("TxtObservaciones", "", $DatosSistemas["Observaciones"], "Observaciones", "", "", "", 450, 60, 0, 1);
        $css->CrearDiv("DivUpDepartamentos", "", "center", 1, 1);
        $Page="Consultas/AsignaDepartamentosSistemas.php?Valida=1&Update=1&key=";
        $Page2="Consultas/AsignaDepartamentosSistemas.php?Valida=5&Update=1&key=";
        
        $css->CrearSelectTable("CmbDepartamentoUp", "prod_departamentos", "", "idDepartamentos", "Nombre", "idDepartamentos", "onchange", "EnvieObjetoConsulta(`$Page`,`CmbDepartamentoUp`,`DivUpSub1`,`0`);EnvieObjetoConsulta(`$Page2`,`CmbDepartamento`,`DivUpSub5`,`0`)", $DatosSistemas["Departamento"], 1);
        $css->CerrarDiv();
        $css->CrearDiv("DivUpSub1", "", "center", 1, 1);
        if($DatosSistemas["Sub1"]>0){
            $idSel=$DatosSistemas["Sub1"];
            $idDepartamento=$DatosSistemas["Departamento"];
            $idDibujo="DivUpSub2";
            $Up="Update=1&"; 
            $Condicion=" WHERE idDepartamento='$idDepartamento'";
            $Page="Consultas/AsignaDepartamentosSistemas.php?Valida=3&".$Up."key=";
            $css->CrearSelectTable("CmbSub1", "prod_sub1", $Condicion, "idSub1", "NombreSub1", "idDepartamento", "onchange", "EnvieObjetoConsulta(`$Page`,`CmbSub2`,`$idDibujo`,`0`);", $idSel, 0);

        }
        $css->CerrarDiv();
        $css->CrearDiv("DivUpSub2", "", "center", 1, 1);
        if($DatosSistemas["Sub2"]>0){
            $idDepartamento=$DatosSistemas["Sub1"];
            $idSel=$DatosSistemas["Sub2"];
            $idDibujo="DivUpSub3";
            $Up="Update=1&"; 
            $Condicion=" WHERE idSub1='$idDepartamento'";
            $Page="Consultas/AsignaDepartamentosSistemas.php?Valida=3&".$Up."key=";
            $css->CrearSelectTable("CmbSub2", "prod_sub2", $Condicion, "idSub2", "NombreSub2", "idSub1", "onchange", "EnvieObjetoConsulta(`$Page`,`CmbSub2`,`$idDibujo`,`0`);", $idSel, 0);

        }
        $css->CerrarDiv();
        $css->CrearDiv("DivUpSub3", "", "center", 1, 1);
        if($DatosSistemas["Sub3"]>0){
            $idDepartamento=$DatosSistemas["Sub2"];
            $idSel=$DatosSistemas["Sub3"];
            $idDibujo="DivUpSub4";
            $Up="Update=1&"; 
            $Condicion=" WHERE idSub2='$idDepartamento'";
            $Page="Consultas/AsignaDepartamentosSistemas.php?Valida=3&".$Up."key=";
            $css->CrearSelectTable("CmbSub3", "prod_sub3", $Condicion, "idSub3", "NombreSub3", "idSub2", "onchange", "EnvieObjetoConsulta(`$Page`,`CmbSub2`,`$idDibujo`,`0`);", $idSel, 0);

        }
        $css->CerrarDiv();
        $css->CrearDiv("DivUpSub4", "", "center", 1, 1);
        if($DatosSistemas["Sub4"]>0){
            $idDepartamento=$DatosSistemas["Sub3"];
            $idSel=$DatosSistemas["Sub4"];
            $Condicion=" WHERE idSub3='$idDepartamento'";
            $css->CrearSelectTable("CmbSub4", "prod_sub4", $Condicion, "idSub4", "NombreSub4", "idSub3", "", "", $idSel, 0);

        }
        $css->CerrarDiv();
        $css->CrearDiv("DivUpSub5", "", "center", 1, 1);
        if($DatosSistemas["Sub5"]>0){
            print("<strong>Sub5: </strong><br>");
            $idSel=$DatosSistemas["Sub5"];            
            $css->CrearSelectTable("CmbSub5", "prod_sub5", "", "idSub5", "NombreSub5", "", "", "", $idSel, 0);

        }
        $css->CerrarDiv();
        $css->CerrarDiv();
        print("<br>");
        $css->CrearBotonConfirmado("BtnEditarPrecioVenta", "Actualizar");
        
        $css->CerrarForm();
    }else{
        $css->CrearNotificacionAzul("No se ha seleccionado un sistema", 16);
    }
    $css->CerrarDiv();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    
    
    
    $Visible=0;
    if(!empty($idSistema)){
        $Visible=1;
    }
    $css->CrearDiv("DivDatosItemSistema", "", "center", $Visible, 1);
    $css->CrearTabla();
        
    $css->FilaTabla(16);
        
        $css->ColTabla("<strong>Busque un Item para Agregar</strong>", 1);
        $css->ColTabla("<strong>Busque un Servicio para Agregar</strong>", 1);
        $css->ColTabla("<strong>Guardar</strong>", 1);
    $css->CierraFilaTabla();  
    
    $css->FilaTabla(16);
    print("<td>");
    $Page="Consultas/BuscarItemsSistemas.php?TipoItem=1&myPage=$myPage&idSistema=$idSistema&key=";
    $css->CrearInputText("TxtProducto", "text", "", "", "Buscar Producto", "", "onChange", "EnvieObjetoConsulta(`$Page`,`TxtProducto`,`DivBusquedas`);", 200, 30, 0, 1);
    print("</td>");
    print("<td>");
    $Page="Consultas/BuscarItemsSistemas.php?TipoItem=2&myPage=$myPage&idSistema=$idSistema&key=";
    $css->CrearInputText("TxtServicio", "text", "", "", "Buscar Servicio", "", "onChange", "EnvieObjetoConsulta(`$Page`,`TxtServicio`,`DivBusquedas`);", 200, 30, 0, 1);
    print("</td>");
    print("<td>");
    $css->CrearForm2("FrmCerrarSistema", $myPage, "post", "_self");
        $css->CrearInputText("idSistema","hidden",'',$idSistema,'',"","","",300,30,0,0);
        $css->CrearBotonConfirmado2("BtnGuardar", "Guardar",1,"");
    $css->CerrarForm();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CrearDiv("DivBusquedas", "", "center", 1, 1);
    $css->CerrarDiv();
    
    $css->CrearDiv("DivSistemas", "", "center", 1, 1);
    $css->CrearTabla();
        $consulta=$obSistema->ConsultarTabla("sistemas_relaciones", " WHERE idSistema='$idSistema' ORDER BY ID Desc");
        if($obSistema->NumRows($consulta)){
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Tabla</strong>", 1);
                $css->ColTabla("<strong>Nombre</strong>", 1);
                $css->ColTabla("<strong>Referencia</strong>", 1);
                $css->ColTabla("<strong>Precio Unitario</strong>", 1);
                $css->ColTabla("<strong>Cantidad</strong>", 1);
                $css->ColTabla("<strong>Total</strong>", 1);
                $css->ColTabla("<strong>Borrar</strong>", 1);
            $css->CierraFilaTabla();
            while($DatosSistemas=$obSistema->FetchArray($consulta)){
                $DatosItem=$obSistema->DevuelveValores($DatosSistemas["TablaOrigen"], "Referencia", $DatosSistemas["Referencia"]);
                $css->FilaTabla(16);
                    
                    $css->ColTabla($DatosSistemas["TablaOrigen"], 1);
                    $css->ColTabla($DatosItem["Nombre"], 1);
                    $css->ColTabla($DatosItem["Referencia"], 1);
                    $css->ColTabla($DatosItem["PrecioVenta"], 1);
                    print("<td>");
                    $css->CrearForm2("FrmEditarCant".$DatosSistemas["ID"], $myPage, "post", "_self");
                    $css->CrearInputText("idSistema", "hidden", "", $idSistema, "", "", "", "", "", "", 0, 0);
                    $css->CrearInputText("idItem", "hidden", "", $DatosSistemas["ID"], "", "", "", "", "", "", 0, 0);
                    $css->CrearInputNumber("TxtCantidadEdit", "number", "", $DatosSistemas["Cantidad"], "Cantidad", "", "", "", 100, 30, 0, 1, 1, "", "any");
                    $css->CrearBotonNaranja("BtnEditarCantidad", "E");
                    $css->CerrarForm();
                    print("</td>");
                    $css->ColTabla($DatosItem["PrecioVenta"]*$DatosSistemas["Cantidad"], 1);
                    print("<td>");
                    $link=$myPage."?del=$DatosSistemas[ID]&idSistema=$idSistema";
                    $css->CrearLink($link, "_self", "X");
                    print("</td>");
                $css->CierraFilaTabla();
            }
        }else{
            $css->CrearNotificacionNaranja("No hay items en este Sistema", 16);
        }
    $css->CerrarTabla();
    $css->CerrarDiv();//Cerramos Div con los items agregados
    
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AnchoElemento("CuentaPUC_chosen", 200);
    $css->AgregaSubir();
    
    if(isset($_REQUEST["TxtBusqueda"])){
        print("<script>MostrarDialogo();</script>");
    }
    print("</body></html>");
    ob_end_flush();
?>