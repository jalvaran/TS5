<?php 
$myPage="RegistraCompra.php";
include_once("../sesiones/php_control.php");
include_once("clases/ClasesCompras.php");
include_once("css_construct.php");

print("<html>");
print("<head>");
$css =  new CssIni("Compras");
$obVenta=new ProcesoVenta($idUser);  
$obTabla = new Tabla($db);
$idCompra=0;
$TipoMovimiento=0;
if(isset($_REQUEST["idCompra"])){
    $idCompra=$obVenta->normalizar($_REQUEST["idCompra"]);
    
}

print("</head>");
print("<body>");
    
    
    
    $css->CabeceraIni("Registrar Compra"); //Inicia la cabecera de la pagina
    $css->CreaBotonDesplegable("Proveedor","Crear Tercero");
    $css->CreaBotonDesplegable("CrearCompra","Nueva");  
    $css->CabeceraFin(); 
    
    //Creo los cuadros de dialogo
     /////////////////Cuadro de dialogo de Clientes create
$css->CrearCuadroDeDialogo("Proveedor","Crear Tercero"); 
$css->CrearForm("FrmCrearCliente",$myPage,"post","_self");
        $css->CrearSelect("CmbTipoDocumento","Oculta()");
        $css->CrearOptionSelect('13','Cedula',1);
        $css->CrearOptionSelect('31','NIT',0);
        $css->CerrarSelect();
        //$css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
        $css->CrearInputText("TxtNIT","number","","","Identificacion","black","","",200,30,0,1);
        $css->CrearInputText("TxtPA","text","","","Primer Apellido","black","onkeyup","CreaRazonSocial()",200,30,0,0);
        $css->CrearInputText("TxtSA","text","","","Segundo Apellido","black","onkeyup","CreaRazonSocial()",200,30,0,0);
        $css->CrearInputText("TxtPN","text","","","Primer Nombre","black","onkeyup","CreaRazonSocial()",200,30,0,0);
        $css->CrearInputText("TxtON","text","","","Otros Nombres","black","onkeyup","CreaRazonSocial()",200,30,0,0);
        $css->CrearInputText("TxtRazonSocial","text","","","Razon Social","black","","",200,30,0,1);
        $css->CrearInputText("TxtDireccion","text","","","Direccion","black","","",200,30,0,1);
        $css->CrearInputText("TxtTelefono","text","","","Telefono","black","","",200,30,0,1);
        $css->CrearInputText("TxtEmail","text","","","Email","black","","",200,30,0,1);
        //echo "<div style='width: 500px;display:block;position: relative;margin: 10px; height:300px;'>";
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione el municipio";
        $css->CrearSelectChosen("CmbCodMunicipio", $VarSelect);

        $sql="SELECT * FROM cod_municipios_dptos";
        $Consulta=$obVenta->Query($sql);
           while($DatosMunicipios=$obVenta->FetchArray($Consulta)){
               $Sel=0;
               if($DatosMunicipios["ID"]==1011){
                   $Sel=1;
               }
               $css->CrearOptionSelect($DatosMunicipios["ID"], $DatosMunicipios["Ciudad"], $Sel);
           }
        $css->CerrarSelect();
        echo '<br><br>';

        $css->CrearBoton("BtnCrearProveedor", "Crear Tercero");
        $css->CerrarForm();
    $css->CerrarCuadroDeDialogo(); 

    $css->CrearCuadroDeDialogo("CrearCompra","Crear una compra"); 
        $css->CrearForm2("FrmCreaCompra", $myPage, "post", "_self");
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Tercero</strong>", 1);
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputFecha("", "TxtFecha", date("Y-m-d"), 100, 30, "");
        
        print("</td>");        
         print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el tercero";
            $css->CrearSelectChosen("TxtTerceroCI", $VarSelect);

            $sql="SELECT * FROM proveedores";
            $Consulta=$obVenta->Query($sql);
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["Num_Identificacion"], "$DatosProveedores[RazonSocial] $DatosProveedores[Num_Identificacion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>"); 
       
        $css->CierraFilaTabla();
        $css->FilaTabla(16); 
       
            $css->ColTabla("<strong>CentroCosto</strong>", 1);
            
            $css->ColTabla("<strong>Crear</strong>", 1);
            
            
        $css->CierraFilaTabla();
        
         print("<td>");
        
        $css->CrearSelect("CmbCentroCosto"," Centro de Costos:<br>","black","",1);
        //$this->css->CrearOptionSelect("","Seleccionar Centro de Costos",0);

        $Consulta = $obVenta->ConsultarTabla("centrocosto","");
        while($CentroCosto=$obVenta->FetchArray($Consulta)){
                        $css->CrearOptionSelect($CentroCosto['ID'],$CentroCosto['Nombre'],0);							
        }
        $css->CerrarSelect();
         print("<br>");
        $css->CrearSelect("idSucursal"," Sucursal:<br>","black","",1);
        //$this->css->CrearOptionSelect("","Seleccionar Sucursal",0);

        $Consulta = $obVenta->ConsultarTabla("empresa_pro_sucursales","");
        while($CentroCosto=$obVenta->FetchArray($Consulta)){
                        $css->CrearOptionSelect($CentroCosto['ID'],$CentroCosto['Nombre'],0);							
        }
        $css->CerrarSelect();
        print("<br>");
        $css->CrearTextArea("TxtConcepto", "", "", "Concepto", "", "", "", 200, 60, 0, 1);
        print("</td>"); 
               
        print("<td>");
        $css->CrearSelect("TipoCompra", "");
            $css->CrearOptionSelect("FC", "FC", 1);
            $css->CrearOptionSelect("RM", "RM", 0);
        $css->CerrarSelect();
        echo"<br>";
        $css->CrearInputText("TxtNumFactura","text",'Numero de Comprobante:<br>',"","Numero de Comprobante","black","","",220,30,0,1);
        echo"<br>";
        $css->CrearUpload("foto");
        $css->CrearBotonConfirmado("BtnCrearCompra", "Crear");
        print("</td>");   
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarCuadroDeDialogo(); 
    
    //Fin Cuadros de Dialogo
    ///////////////Creamos el contenedor
        
    $css->CrearDiv("principal", "container", "center",1,1);
    include_once("procesadores/RegistraCompra.process.php");
    $css->CrearForm2("FrmSeleccionaCom", $myPage, "post", "_self");
    $css->CrearSelect("idCompra", "EnviaForm('FrmSeleccionaCom')");
        
            $css->CrearOptionSelect("","Selecciona una Compra",0);
            
            $consulta = $obVenta->ConsultarTabla("factura_compra","WHERE Estado='ABIERTA'");
            while($DatosComprobante=$obVenta->FetchArray($consulta)){
                if($idCompra==$DatosComprobante['ID']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $css->CrearOptionSelect($DatosComprobante['ID'],$DatosComprobante['ID']." ".$DatosComprobante['Concepto']." ".$DatosComprobante['NumeroFactura'],$Sel);							
            }
        $css->CerrarSelect();
    $css->CerrarForm();
     
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    if($idCompra>0){
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Buscar Producto:<strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                $Page="Consultas/BuscarItemsCompras.php?TipoItem=1&myPage=$myPage&idCompra=$idCompra&key=";
                $css->CrearInputText("TxtProducto", "text", "", "", "Buscar Producto", "", "onChange", "EnvieObjetoConsulta(`$Page`,`TxtProducto`,`DivBusquedas`);", 200, 30, 0, 1);
                print("</td>");
            $css->CierraFilaTabla();
            
            
        $css->CerrarTabla();
        
        $css->CrearBotonEvento("BtnRetenciones", "Agregar Retenciones", 1, "onclick", "MuestraOculta('DivRetenciones')", "naranja", "");
        $css->CrearBotonEvento("BtnMostrarProductos", "Ver/Ocultar Productos Agregados", 1, "onclick", "MuestraOculta('DivProductos')", "verde", "");
        $css->CrearBotonEvento("BtnMostrarProductos", "Ver/Ocultar Productos Devueltos", 1, "onclick", "MuestraOculta('DivProductosDevueltos')", "rojo", "");
     
        $css->CrearBotonEvento("BtnMostrarProductos", "Ver/Ocultar Retenciones", 1, "onclick", "MuestraOculta('DivRetencionesPracticadas')", "naranja", "");
        $css->CrearDiv("DivRetenciones", "", "center", 0, 1);
        $css->CrearTabla();
            $sql="SELECT SUM(SubtotalCompra) as Subtotal, sum(ImpuestoCompra) as IVA, SUM(TotalCompra) AS Total FROM factura_compra_items "
                    . " WHERE idFacturaCompra='$idCompra'";
            $consulta=$obVenta->Query($sql);
            $TotalesCompra=$obVenta->FetchArray($consulta);
            
            $Subtotal=$TotalesCompra["Subtotal"];
            $IVA=$TotalesCompra["IVA"];
            $Total=$TotalesCompra["Total"];
            
            $sql="SELECT SUM(SubtotalCompra) as Subtotal, sum(ImpuestoCompra) as IVA, SUM(TotalCompra) AS Total FROM factura_compra_items_devoluciones "
                    . " WHERE idFacturaCompra='$idCompra'";
            $consulta=$obVenta->Query($sql);
            $TotalesCompraDev=$obVenta->FetchArray($consulta);
            $SubtotalDev=$TotalesCompraDev["Subtotal"];
            $IVADev=$TotalesCompraDev["IVA"];
            $TotalDev=$TotalesCompraDev["Total"];
            $GranSubTotal=$Subtotal-$SubtotalDev;
            $GranIVA=$IVA-$IVADev;
            $GranTotal=$Total-$TotalDev;
            $TotalRetenciones=$obVenta->Sume("factura_compra_retenciones", "ValorRetencion", " WHERE idCompra='$idCompra'");
            
            
            $TotalAPagar=$GranTotal-$TotalRetenciones;
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Agregar Retenciones a esta Compra, Subtotal=$". number_format($TotalesCompra["Subtotal"]).", Impuestos=$". number_format($TotalesCompra["IVA"])." , Total=$". number_format($TotalesCompra["Total"])."<strong>", 4);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Retefuente:<strong>", 1);
                $css->ColTabla("<strong>ReteICA:<strong>", 1);
                $css->ColTabla("<strong>ReteIVA:<strong>", 1);
                
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                print("<td>");
                $css->CrearForm2("FrmReteFuente", $myPage, "post", "_self");
                    $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", "", 1);
                    $VarSelect["Required"]="200";
                    $VarSelect["Ancho"]="200";
                    $VarSelect["PlaceHolder"]="Seleccione la cuenta de la retencion";
                    $css->CrearSelectChosen("CmbCuentaReteFuente", $VarSelect);
                    $consulta=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC LIKE '2365%'");
                    while($DatosCuentaRete=$obVenta->FetchArray($consulta)){
                        $sel=0;
                        if($DatosCuentaRete["PUC"]=="236540"){
                            $sel=1;
                        }
                        $css->CrearOptionSelect($DatosCuentaRete["PUC"], $DatosCuentaRete["PUC"]." ".$DatosCuentaRete["Nombre"] , $sel);
                    }
                    $css->CerrarSelect();
                    $css->CrearInputNumber("TxtPorReteFuente", "text", "<br><br>Porcentaje: ", 0, "Porcentaje ReteFuente", "Black", "onkeyup", "CalculeReteFuenteCompra($GranSubTotal)", 70, 30, 0, 0, 0, 100, "any");
                    $css->CrearInputNumber("TxtReteFuenteProductos", "number", " Valor: ", 0, "ReteFuente", "Black", "onkeyup", "CalculePorcentajeReteFuenteCompra($GranSubTotal)", 100, 30, 0, 0, 1,$GranSubTotal, "any");
                    $css->CrearBotonConfirmado("BtnAgregueReteFuente", "Agregar");
                $css->CerrarForm();    
                print("</td>");
                print("<td>");
                $css->CrearForm2("FrmReteICA", $myPage, "post", "_self");
                    $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", "", 1);
                    $VarSelect["Required"]="200";
                    $VarSelect["Ancho"]="200";
                    $VarSelect["PlaceHolder"]="Seleccione la cuenta de la retencion";
                    $css->CrearSelectChosen("CmbCuentaReteICA", $VarSelect);
                    $consulta=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC LIKE '2368%'");
                    while($DatosCuentaRete=$obVenta->FetchArray($consulta)){
                        $sel=0;
                        
                        $css->CrearOptionSelect($DatosCuentaRete["PUC"], $DatosCuentaRete["PUC"]." ".$DatosCuentaRete["Nombre"] , $sel);
                    }
                    $css->CerrarSelect();
                    $css->CrearInputNumber("TxtPorReteICA", "text", "<br><br>Porcentaje: ", 0, "Porcentaje ReteFuente", "Black", "onkeyup", "CalculeReteICACompra($GranSubTotal)", 70, 30, 0, 0, 0, 100, "any");
                    $css->CrearInputNumber("TxtReteICA", "number", " Valor: ", 0, "ReteICA", "Black", "onkeyup", "CalculePorcentajeICACompra($GranSubTotal)", 100, 30, 0, 0, 1, $GranSubTotal, "any");
                    $css->CrearBotonConfirmado("BtnAgregueReteICA", "Agregar");
                $css->CerrarForm();    
                print("</td>");
                print("<td>");
                $css->CrearForm2("FrmReteIVA", $myPage, "post", "_self");
                    $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", "", 1);
                    $VarSelect["Required"]="200";
                    $VarSelect["Ancho"]="200";
                    $VarSelect["PlaceHolder"]="Seleccione la cuenta de la retencion";
                    $css->CrearSelectChosen("CmbCuentaReteIVA", $VarSelect);
                    $consulta=$obVenta->ConsultarTabla("subcuentas", "WHERE PUC LIKE '2367%'");
                    while($DatosCuentaRete=$obVenta->FetchArray($consulta)){
                        $sel=0;
                        
                        $css->CrearOptionSelect($DatosCuentaRete["PUC"], $DatosCuentaRete["PUC"]." ".$DatosCuentaRete["Nombre"] , $sel);
                    }
                    $css->CerrarSelect();
                    $css->CrearInputNumber("TxtPorReteIVA", "text", "<br><br>Porcentaje: ", 0, "Porcentaje ReteFuente", "Black", "onkeyup", "CalculeReteIVACompra($GranIVA)", 70, 30, 0, 0, 0, 100, "any");
                    $css->CrearInputNumber("TxtReteIVA", "number", " Valor: ", 0, "ReteIVA", "Black", "onkeyup", "CalculePorcentajeIVACompra($GranIVA)", 100, 30, 0, 0, 1, $GranIVA, "any");
                    $css->CrearBotonConfirmado("BtnAgregueReteIVA", "Agregar");
                $css->CerrarForm();    
                print("</td>");
                
            $css->CierraFilaTabla();
        $css->CerrarTabla();
        $css->CerrarDiv();
        $DivVisible=0;
        if($Total>0){
            $DivVisible=1;
        }
        $css->CrearDiv("DivTotales", "", "center", $DivVisible, 0);
        $css->CrearNotificacionAzul("Esta Compra:", 16);
        $css->CrearForm2("FrmGuardarCompra", $myPage, "post", "_self");
        $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", 0, 1);
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Subtotal:</strong>", 1);
                    $css->ColTabla("<strong>Impuestos:</strong>", 1);
                    $css->ColTabla("<strong>Total:</strong>", 1);
                    $css->ColTabla("<strong>Retenciones:</strong>", 1);
                    $css->ColTabla("<strong>Devoluciones:</strong>", 1);
                    $css->ColTabla("<strong>Impuestos Devueltos:</strong>", 1);
                    $css->ColTabla("<strong>Total a Pagar:</strong>", 1);
                    $css->ColTabla("<strong>Tipo Pago:</strong>", 1);
                    $css->ColTabla("<strong>Guardar</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    
                    $css->ColTabla(number_format($Subtotal), 1);
                    $css->ColTabla(number_format($IVA), 1);
                    $css->ColTabla(number_format($Total), 1);
                    $css->ColTabla(number_format($TotalRetenciones), 1);
                    $css->ColTabla(number_format($SubtotalDev), 1);
                    $css->ColTabla(number_format($IVADev), 1);
                    $css->ColTabla(number_format($TotalAPagar), 1);
                    print("<td>");
                        $css->CrearSelect("CmbTipoPago", "MuestraOculta('DivCuentaOrigen')");
                            $css->CrearOptionSelect("Contado", "Contado", 1);
                            $css->CrearOptionSelect("Credito", "Credito", 0);
                        $css->CerrarSelect();
                        $css->CrearDiv("DivCuentaOrigen", "", "left", 1, 1);
                        print("<strong>Cuenta Origen: </strong><br>");
                            $css->CrearSelect("CmbCuentaOrigen", "");
                            $consulta=$obVenta->ConsultarTabla("subcuentas", " WHERE PUC LIKE '11%'");
                            while($DatosCuenta=$obVenta->FetchArray($consulta)){
                                $sel=0;
                                if($DatosCuenta["PUC"]==1105){
                                    $sel=1;
                                }
                                $css->CrearOptionSelect($DatosCuenta["PUC"], $DatosCuenta["Nombre"]." ".$DatosCuenta["PUC"], $sel);
                            }
                            
                        $css->CerrarSelect();
                        $css->CerrarDiv();
                    print("</td>");
                    print("<td>");
                    $css->CrearBotonConfirmado("BtnGuardarCompra", "Guardar");
                    print("</td>");
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        $css->CerrarForm();
        $css->CerrarDiv();
    }
    
    $css->CrearDiv("DivBusquedas", "", "center", 1, 1);
    $css->CerrarDiv();
    //Div retenciones aplicadas
    $css->CrearDiv("DivRetencionesPracticadas", "", "center", 0, 1);
        $consulta=$obVenta->ConsultarTabla("factura_compra_retenciones", "WHERE idCompra='$idCompra'");
        if($obVenta->NumRows($consulta)){
            $css->CrearNotificacionAzul("Retenciones practicadas a esta compra", 16);
            $css->CrearTabla();
            while ($DatosRetenciones=$obVenta->FetchArray($consulta)){
                $css->FilaTabla(14);
                $css->ColTabla($DatosRetenciones["CuentaPUC"], 1);
                $css->ColTabla($DatosRetenciones["NombreCuenta"], 1);
                $css->ColTabla(number_format($DatosRetenciones["ValorRetencion"]), 1);
                $css->ColTabla($DatosRetenciones["PorcentajeRetenido"], 1);
                print("<td>");
                $link="$myPage?DelRetencion=$DatosRetenciones[ID]&idCompra=$idCompra";
                $css->CrearLink($link, "_self", "X");
                print("</td>");
                $css->CierraFilaTabla();
            }
            $css->CerrarTabla();
        }else{
            $css->CrearNotificacionAzul("No hay retenciones practicadas a esta compra", 16);
        }
        
    $css->CerrarDiv();
    //Div con los productos
    if($idCompra>1){
    $css->CrearDiv("DivProductos", "", "Center", 1, 1);
    
        $consulta=$obVenta->ConsultarTabla("factura_compra_items", "WHERE idFacturaCompra='$idCompra'");
        if($obVenta->NumRows($consulta)){
            $css->CrearNotificacionVerde("Productos agregados a esta Compra", 16);
            $css->CrearTabla();
            $css->FilaTabla(14);
               
               $css->ColTabla("<strong>idProducto</strong>", 1);
               $css->ColTabla("<strong>Referencia</strong>", 1);
               $css->ColTabla("<strong>Nombre</strong>", 1);
               $css->ColTabla("<strong>Cantidad</strong>", 1);
               $css->ColTabla("<strong>CostoUnitario</strong>", 1);
               $css->ColTabla("<strong>Subtotal</strong>", 1);
               $css->ColTabla("<strong>Impuestos</strong>", 1);
               $css->ColTabla("<strong>Total</strong>", 1);
               $css->ColTabla("<strong>% Impuestos</strong>", 1);
               $css->ColTabla("<strong>Borrar</strong>", 1);
               $css->ColTabla("<strong>Devolucion</strong>", 1);
               $css->CierraFilaTabla();
            while($DatosItems=$obVenta->FetchAssoc($consulta)){
               $css->FilaTabla(14);
               $DatosProducto=$obVenta->DevuelveValores("productosventa", "idProductosVenta", $DatosItems["idProducto"]);
               $DatosIVA=$obVenta->DevuelveValores("porcentajes_iva", "Valor", $DatosItems["Tipo_Impuesto"]);
                    $css->ColTabla($DatosItems["idProducto"], 1);
                    $css->ColTabla($DatosProducto["Referencia"], 1);
                    $css->ColTabla($DatosProducto["Nombre"], 1);
                    $css->ColTabla(number_format($DatosItems["Cantidad"]), 1);
                    $css->ColTabla(number_format($DatosItems["CostoUnitarioCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["SubtotalCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["ImpuestoCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["TotalCompra"]), 1);
                    $css->ColTabla($DatosIVA["Nombre"], 1);
                    $css->ColTablaDel($myPage, "factura_compra_items", "ID", $DatosItems["ID"], $idCompra);
                    print("<td>");
                        $TotalItemsDevueltos=$obVenta->Sume("factura_compra_items_devoluciones", "Cantidad", "WHERE idFacturaCompra='$idCompra'");
                        $MaxCantidad=$DatosItems["Cantidad"]-$TotalItemsDevueltos;
                        $css->CrearForm2("FrmDevolverItem".$DatosItems["ID"], $myPage, "post", "_self");
                            $css->CrearInputText("idCompra", "hidden", "", $idCompra, "", "", "", "", "", "", 0, 1);
                            $css->CrearInputText("idProducto", "hidden", "", $DatosItems["idProducto"], "", "", "", "", "", "", 0, 1);
                            $css->CrearInputText("idFacturaItems", "hidden", "", $DatosItems["ID"], "", "", "", "", "", "", 0, 1);
                            $css->CrearInputNumber("TxtCantidadDev", "number", "", 0, "Dev", "", "", "", 100, 30, 0, 1, 0, $MaxCantidad, "any");
                            $css->CrearBotonConfirmado("BtnDevolverItem", "Devolver");
                        $css->CerrarForm();
                    print("</td>");
               $css->CierraFilaTabla();
            }
            $css->CerrarTabla();
        }else{
            $css->CrearNotificacionNaranja("No hay productos agregados a esta Compra", 16);
        }
    $css->CerrarDiv();
    //Productos Devueltos
    
    $css->CrearDiv("DivProductosDevueltos", "", "Center", 1, 1);
    
        $consulta=$obVenta->ConsultarTabla("factura_compra_items_devoluciones", "WHERE idFacturaCompra='$idCompra'");
        if($obVenta->NumRows($consulta)){
            $css->CrearNotificacionRoja("Productos devueltos en esta Compra", 16);
            $css->CrearTabla();
            $css->FilaTabla(14);
               
               $css->ColTabla("<strong>idProducto</strong>", 1);
               $css->ColTabla("<strong>Referencia</strong>", 1);
               $css->ColTabla("<strong>Nombre</strong>", 1);
               $css->ColTabla("<strong>Cantidad</strong>", 1);
               $css->ColTabla("<strong>CostoUnitario</strong>", 1);
               $css->ColTabla("<strong>Subtotal</strong>", 1);
               $css->ColTabla("<strong>Impuestos</strong>", 1);
               $css->ColTabla("<strong>Total</strong>", 1);
               $css->ColTabla("<strong>% Impuestos</strong>", 1);
               $css->ColTabla("<strong>Borrar</strong>", 1);
               
               $css->CierraFilaTabla();
            while($DatosItems=$obVenta->FetchAssoc($consulta)){
               $css->FilaTabla(14);
               $DatosProducto=$obVenta->DevuelveValores("productosventa", "idProductosVenta", $DatosItems["idProducto"]);
               $DatosIVA=$obVenta->DevuelveValores("porcentajes_iva", "Valor", $DatosItems["Tipo_Impuesto"]);
                    $css->ColTabla($DatosItems["idProducto"], 1);
                    $css->ColTabla($DatosProducto["Referencia"], 1);
                    $css->ColTabla($DatosProducto["Nombre"], 1);
                    $css->ColTabla(number_format($DatosItems["Cantidad"]), 1);
                    $css->ColTabla(number_format($DatosItems["CostoUnitarioCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["SubtotalCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["ImpuestoCompra"]), 1);
                    $css->ColTabla(number_format($DatosItems["TotalCompra"]), 1);
                    $css->ColTabla($DatosIVA["Nombre"], 1);
                    $css->ColTablaDel($myPage, "factura_compra_items", "ID", $DatosItems["ID"], $idCompra);
                    
               $css->CierraFilaTabla();
            }
            $css->CerrarTabla();
        }else{
            $css->CrearNotificacionNaranja("No hay productos devueltos en esta Compra", 16);
        }
    $css->CerrarDiv();
    }
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->Footer();
    $css->AnchoElemento("TxtTerceroCI_chosen", 200);
    $css->AnchoElemento("CmbCodMunicipio_chosen", 200);    
    $css->AnchoElemento("CmbCuentaXPagar_chosen", 800);
    $css->AnchoElemento("CmbCuentaReteFuente_chosen", 200);
    $css->AnchoElemento("CmbCuentaReteIVA_chosen", 200);
    $css->AnchoElemento("CmbCuentaReteICA_chosen", 200);
    print("</body></html>");
?>