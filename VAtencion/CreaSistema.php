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
    $css->CreaBotonDesplegable("CrearSistema","Nuevo");  
    $css->CabeceraFin(); 
    
         
    if(isset($_REQUEST["TxtBusqueda"])){
        $key=$_REQUEST["TxtBusqueda"];
        $PageReturn="";
        $VectorDI["idPre"]=$idSistema;
        $obTabla->DibujeItemsBuscadosVentas2($key,$myPage,$VectorDI);

    }
    
    ///////////////Creamos el contenedor
    /////
    /////
     print("<br><br><br>");
     
    $css->CrearDiv("principal", "container", "center",1,1);
    ////Menu de historial
      
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
     /////////////////Cuadro de dialogo de Clientes create
    $css->CrearCuadroDeDialogo("CrearSistema","Crear un Sistema"); 
        $css->CrearForm2("FrmCrearSistema", $myPage, "post", "_self");
        
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Nombre</strong>", 1);
            $css->ColTabla("<strong>PrecioVenta</strong>", 1);
            $css->ColTabla("<strong>PrecioMayorista</strong>", 1);
            
            
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearTextArea("TxtNombre","","","Escriba el Nombre del Sistema","black","","",200,60,0,1);
        
        print("</td>");        
        print("<td>"); 
        $css->CrearInputNumber("TxtPrecioVenta", "number", "", "", "PrecioVenta", "", "", "", 100, 30, 0, 1, 1, "", 1);
        print("</td>");
        print("<td>");
        $css->CrearInputNumber("TxtPrecioMayor", "number", "", "", "PrecioMayorista", "", "", "", 100, 30, 0, 1, 1, "", 1);
        print("</td>");
         
        $css->FilaTabla(16);
        print("<td colspan=2>");
        $css->CrearTextArea("TxtObservaciones","","","Observaciones","black","","",320,60,0,1);
        $css->CrearUpload("foto");
        print("</td>"); 
        print("<td style='text-align:center'>");
        $css->CrearBotonConfirmado("BtnCrearSistema", "Crear");
        print("</td>");  
        $css->CierraFilaTabla();
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarCuadroDeDialogo();
    
    $css->CrearNotificacionAzul("Agregar Items al Sistema", 18);
    $css->CerrarForm();
    $css->CrearForm2("FrmSeleccionaSistema", $myPage, "post", "_self");
    
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    
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
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    
    $css->CrearForm2("FrmAgregaItemE", $myPage, "post", "_self");
    $Visible=0;
    if(!empty($idSistema)){
        $Visible=1;
    }
    $css->CrearDiv("DivDatosItemSistema", "", "center", $Visible, 1);
    $css->CrearTabla();
    $css->FilaTabla(16);
    $css->ColTabla("<strong>Sistema:</strong>", 2);
    print("<td>");
       $css->CrearInputText("idSistema", "text", "", $idSistema, "idSistema", "black", "", "", 100, 30, 1, 1);
    print("</td>");  
    $css->CierraFilaTabla();   
    $css->FilaTabla(16);
        
        $css->ColTabla("<strong>Busque un Item para Agregar</strong>", 3);
        
    $css->CierraFilaTabla();  
    $css->CerrarForm();
    $css->FilaTabla(16);
    print("<td colspan='3'>");
	        
        $VectorCuaBus["F"]=0;
        $obTabla->CrearCuadroBusqueda($myPage,"","","idSistema",$idSistema,$VectorCuaBus);
        print("</td>");
        
        $css->CierraFilaTabla();
    $css->CierraFilaTabla();
    
    
    
    $css->CerrarTabla();
    
    
    $css->CrearForm2("FrmCerrarSistema", $myPage, "post", "_self");
    $css->CrearInputText("idSistema","hidden",'',$idSistema,'',"","","",300,30,0,0);
    $css->CrearBotonConfirmado2("BtnGuardar", "Guardar",1,"");
    
    print("<br>");
    $css->CerrarForm();
    
    $css->CrearDiv("DivItems", "", "center", 1, 1);
    $Vector["Tabla"]="traslados_items";
    $Columnas=$obTabla->ColumnasInfo($Vector);
    $css->CrearTabla();
    $css->FilaTabla(12);
    
    $i=0;
    $ColNames[]="";
    $css->ColTabla("<strong>Borrar</strong>", 1);
    foreach($Columnas["Field"] as $NombresCol ){
        $css->ColTabla("<strong>$NombresCol</strong>", 1);
        $ColNames[$i]=$NombresCol;
        $i++;
    }
    
    $NumCols=$i-1;
    $css->CierraFilaTabla();
    
    $i=0;
    $sql="SELECT * FROM traslados_items WHERE idTraslado='$idComprobante'";
    $consulta=$obVenta->Query($sql);
    
    while($DatosItems=$obVenta->FetchArray($consulta)){
        
        $css->FilaTabla(12);
        $css->ColTablaDel($myPage,"traslados_items","ID",$DatosItems['ID'],$idComprobante);
        for($z=0;$z<=$NumCols;$z++){
            $NombreCol=$ColNames[$z];
            print("<td>");
            if($NombreCol=="Soporte"){
                $link=$DatosItems[$NombreCol];
                if($link<>""){
                    $css->CrearLink($link, "_blank", "Ver");
                }
            }else{
                print($DatosItems[$NombreCol]);
            }
            
            print("</td>");
            
        }
        
        $i=0;
        $css->CierraFilaTabla();
        
    }
    
    
    $css->CerrarTabla();
    $css->CerrarDiv();//Cerramos Div con los items agregados
    $css->CerrarDiv();//Cerramos Div con los datos de los preitems
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->AnchoElemento("CmbDestino_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 200);
    if(isset($_REQUEST["TxtBusqueda"])){
        print("<script>MostrarDialogo();</script>");
    }
    print("</body></html>");
    ob_end_flush();
?>