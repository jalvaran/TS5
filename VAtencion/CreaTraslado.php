<?php 
ob_start();
session_start();
include_once("../modelo/php_tablas.php");
include_once("css_construct.php");
if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}
$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];
$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);
$idComprobante=0;
$ImprimeCC=0;
if(isset($_REQUEST["CmbTrasladoID"])){
    $idComprobante=$_REQUEST["CmbTrasladoID"];
    
}

if(isset($_REQUEST["ImprimeCC"])){
    $ImprimeCC=$_REQUEST["ImprimeCC"];
    $idComprobante=0;
}
	

print("<html>");
print("<head>");
$css =  new CssIni("Traslados de Mercancia");

print("</head>");
print("<body>");
    
    include_once("procesadores/ProcesaCreaTraslado.php");
    $myPage="CreaTraslado.php";
    $css->CabeceraIni("Crear Traslado"); //Inicia la cabecera de la pagina
    $css->CreaBotonDesplegable("CrearTraslado","Nuevo");  
    $css->CabeceraFin(); 
    
    
    ///////////////Creamos el contenedor
    /////
    /////
     print("<br><br><br>");
     
    $css->CrearDiv("principal", "container", "center",1,1);
    ////Menu de historial
    
    
         
         
    if($ImprimeCC>0){
        $RutaPrintCot="../tcpdf/examples/comprobantecontable.php?idComprobante=$ImprimeCC";			
       
        $css->CrearNotificacionNaranja("Comprobante Creado, <a href='$RutaPrintCot' target='_blank'>Imprimir Comprobante No. $ImprimeCC</a>",16);
        
    }
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
     /////////////////Cuadro de dialogo de Clientes create
    $css->CrearCuadroDeDialogo("CrearTraslado","Crear un Traslado"); 
        $css->CrearForm2("FrmCreaPreTraslado", $myPage, "post", "_self");
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha y Hora</strong>", 1);
            
            $css->ColTabla("<strong>Destino</strong>", 1);
            $css->ColTabla("<strong>Descripcion</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputText("TxtFecha", "date", "", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
        $css->CrearInputText("TxtHora", "text", "", date("H:i:s"), "Hora", "black", "", "", 100, 30, 0, 1);
        print("</td>");        
        print("<td>"); 
        $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el destino";
            $css->CrearSelectChosen("CmbDestino", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione un destino" , 0);
            $sql="SELECT * FROM empresa_pro_sucursales WHERE Visible='SI'";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosSucursales=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosSucursales["ID"], "$DatosSucursales[Nombre] $DatosSucursales[Ciudad] $DatosSucursales[Direccion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>");
        print("<td>");
        $css->CrearTextArea("TxtDescripcion","","","Escriba la descripcion del traslado","black","","",100,100,0,1);
        print("</td>");
        print("<td>");
        $css->CrearBotonConfirmado("BtnCrearTraslado", "Crear");
        print("</td>");   
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarCuadroDeDialogo();
    
    $css->CrearNotificacionAzul("Agregar Items al Traslado", 18);
    $css->CerrarForm();
    $css->CrearForm2("FrmSeleccionaTraslado", $myPage, "post", "_self");
    
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    
        $css->CrearSelect("CmbTrasladoID", "EnviaForm('FrmSeleccionaTraslado')");
        
            $css->CrearOptionSelect("","Selecciona un Traslado",0);
            
            $consulta = $obVenta->ConsultarTabla("traslados_mercancia","WHERE Estado='EN DESARROLLO'");
            while($DatosTraslado=mysql_fetch_array($consulta)){
                if($idComprobante==$DatosTraslado['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $css->CrearOptionSelect($DatosTraslado['ID'],$DatosTraslado['Descripcion'],$Sel);							
            }
        $css->CerrarSelect();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    
    $css->CrearForm2("FrmAgregaItemE", $myPage, "post", "_self");
    $Visible=0;
    if($idComprobante>0){
        $Visible=1;
    }
    $css->CrearDiv("DivDatosItemEgreso", "", "center", $Visible, 1);
    $css->CrearTabla();
    $css->FilaTabla(16);
    $css->ColTabla("<strong>Comprobante:</strong>", 1);
    print("<td>");
       $css->CrearInputText("TxtIdCC", "text", "", $idComprobante, "idEgreso", "black", "", "", 100, 30, 1, 1);
    print("</td>");  
    $css->CierraFilaTabla();   
    $css->FilaTabla(16);
        
        $css->ColTabla("<strong>Centro de Costo</strong>", 1);
        $css->ColTabla("<strong>Tercero</strong>", 1);
        $css->ColTabla("<strong>Cuenta Destino</strong>", 1);
        
    $css->CierraFilaTabla();    
    $css->FilaTabla(16);
        
        
        print("<td>");
					
            $css->CrearSelect("CmbCentroCosto"," Centro de Costos:<br>","black","",1);
            $css->CrearOptionSelect("","Seleccionar Centro de Costos",0);

            $Consulta = $obVenta->ConsultarTabla("centrocosto","");
            while($CentroCosto=mysql_fetch_array($Consulta)){
                            $css->CrearOptionSelect($CentroCosto['ID'],$CentroCosto['Nombre'],0);							
            }
            $css->CerrarSelect();

        print("</td>");
        print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el tercero";
            $css->CrearSelectChosen("CmbTerceroItem", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione un tercero" , 0);
            $sql="SELECT * FROM proveedores";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["Num_Identificacion"], "$DatosProveedores[RazonSocial] $DatosProveedores[Num_Identificacion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>");
        print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione la cuenta destino";
            $css->CrearSelectChosen("CmbCuentaDestino", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione la cuenta destino" , 0);
            
            //Solo para cuando el PUC no está todo en subcuentas
            $sql="SELECT * FROM cuentas";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   $NombreCuenta=str_replace(" ","_",$DatosProveedores['Nombre']);
                   $css->CrearOptionSelect($DatosProveedores['idPUC'].';'.$NombreCuenta, "$DatosProveedores[idPUC] $DatosProveedores[Nombre]" , $Sel);
               }
            
            //En subcuentas se debera cargar todo el PUC
            $sql="SELECT * FROM subcuentas";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   $NombreCuenta=str_replace(" ","_",$DatosProveedores['Nombre']);
                   $css->CrearOptionSelect($DatosProveedores['PUC'].';'.$NombreCuenta, "$DatosProveedores[PUC] $DatosProveedores[Nombre]" , $Sel);
               }
            
            $css->CerrarSelect();
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputNumber("TxtValorItem", "number", "<strong>Valor:</strong><br>", "", "Valor", "black", "", "", 220, 30, 0, 1, 1, "", 1);
        print("<br>");
       
        $css->CrearSelect("CmbDebitoCredito", "");
            $css->CrearOptionSelect("D", "Debito", 1);
            $css->CrearOptionSelect("C", "Credito", 0);
        $css->CerrarSelect();
        print("</td>");
    
       
        print("<td>");
        $css->CrearTextArea("TxtConceptoEgreso","<strong>Concepto:</strong><br>","","Escriba el Concepto","black","","",300,100,0,1);
        print("</td>");
        print("<td>");
        $css->CrearInputText("TxtNumFactura","text",'Numero del Documento soporte:<br>',"","Numero del documento","black","","",300,30,0,1);
        echo"<br>";
        $css->CrearUpload("foto");
        echo"<br>";
        echo"<br>";
        
        $css->CrearBotonVerde("BtnAgregarItemMov", "Agregar Concepto");
        print("</td>");
        
    $css->CierraFilaTabla();
    
    
    
    $css->CerrarTabla();
    $css->CerrarForm();
    $sql="SELECT SUM(Debito) as Debito, SUM(Credito) as Credito FROM comprobantes_contabilidad_items WHERE idComprobante='$idComprobante'";
    $consulta=$obVenta->Query($sql);
    $DatosSumas=$obVenta->FetchArray($consulta);    
    $Debitos=$DatosSumas["Debito"];
    $Credito=$DatosSumas["Credito"];
    $Neto=$Debitos-$Credito;
    if($Neto<>0){
        $css->CrearNotificacionRoja("Debitos = $Debitos, Creditos = $Credito, existe una diferencia de $Neto, no podrá guardar hasta que no sean iguales", 14);
        $H=0;
        
    }else{
        $css->CrearNotificacionVerde("Debitos = $Debitos, Creditos = $Credito, Pulse el boton si desea cerrar el comprobante", 14);
        $H=1;
    }
    $css->CrearForm2("FrmCerrarCompC", $myPage, "post", "_self");
    $css->CrearInputText("TxtIdComprobanteContable","hidden",'',$idComprobante,'',"","","",300,30,0,0);
    $css->CrearBotonConfirmado2("BtnGuardarMovimiento", "Guardar y Cerrar Comprobante",$H,"");
    
    print("<br><br><br>");
    $css->CerrarForm();
    ////Se dibujan los items del movimiento
    $css->CrearSelect("CmbMostrarItems", "MuestraOculta('DivItems')");
        $css->CrearOptionSelect("SI", "Mostrar Movimientos", 0);
        $css->CrearOptionSelect("NO", "Ocultar Movimientos", 0);
    $css->CerrarSelect();
    $css->CrearDiv("DivItems", "", "center", 1, 1);
    $Vector["Tabla"]="comprobantes_contabilidad_items";
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
    $sql="SELECT * FROM comprobantes_contabilidad_items WHERE idComprobante='$idComprobante'";
    $consulta=$obVenta->Query($sql);
    
    while($DatosItems=$obVenta->FetchArray($consulta)){
        
        $css->FilaTabla(12);
        $css->ColTablaDel($myPage,"comprobantes_contabilidad_items","ID",$DatosItems['ID'],$idComprobante);
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
    print("</body></html>");
    ob_end_flush();
?>