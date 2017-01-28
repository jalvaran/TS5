<?php 
$myPage="Restaurante_Admin.php";
include_once("../sesiones/php_control.php");
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta($idUser);
$ConsultaCajas=$obVenta->ConsultarTabla("cajas", "WHERE idUsuario='$idUser' AND Estado='ABIERTA'");
$DatosCaja=$obVenta->FetchArray($ConsultaCajas);

if($DatosCaja["ID"]<=0){
    
   header("location:401.php");
}   
include_once("css_construct.php");
print("<html>");
print("<head>");
$css =  new CssIni("Admin Restaurante");
print("</head>");
print("<body>");
   
    $css->CabeceraIni("Admin Restaurante"); //Inicia la cabecera de la pagina
        $css->CreaBotonDesplegable("DialCliente","Tercero");
        $css->CreaBotonDesplegable("DialEgreso","Egreso");
        $css->CreaBotonDesplegable("DialDomicilio","Nuevo Domicilio");
    $css->CabeceraFin(); 
    ///////////////Creamos el Dialogo de toma de domicilios
    /////
    /////
    $css->CrearCuadroDeDialogo("DialDomicilio", "Crear un Domicilo");
        $css->CrearForm2("FrmCreaDomicilio", $myPage, "post", "_self");
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Busque un Cliente";
        $VarSelect["Title"]="";
        $css->CrearSelectChosen("TxtClienteDomicilio", $VarSelect);
    
        $sql="SELECT * FROM clientes";
        $Consulta=$obVenta->Query($sql);
        while($DatosCliente=$obVenta->FetchArray($Consulta)){
               
               $css->CrearOptionSelect("$DatosCliente[Num_Identificacion]", "$DatosCliente[Telefono] / $DatosCliente[RazonSocial] / $DatosCliente[Direccion] / $DatosCliente[Num_Identificacion]" , 0);
           }
           
    $css->CerrarSelect();
    print("<br><br>");
    $css->CrearInputText("TxtDireccionEnvio", "text", "", "", "Direccion de envio", "", "", "", 500, 30, 0, 0);
    print("<br>");
    $css->CrearInputText("TxtTelefonoContacto", "text", "", "", "Telefono de Contacto", "", "", "", 500, 30, 0, 0);
    print("<br>");
    $css->CrearBoton("BtnCrearDomicilio", "Crear");
        $css->CerrarForm();
    $css->CerrarCuadroDeDialogo();
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    
    $obTabla->DialVerDomicilios("");
    $idPreventa=1;
    include_once 'CuadroDialogoCrearCliente.php';
    include_once("procesadores/procesa_Restaurante_Admin.php");
    //////Creo una factura a partir de un pedido
    if(isset($_REQUEST['BtnFacturarPedido'])){
        $idPedido=$obVenta->normalizar($_REQUEST['BtnFacturarPedido']);
        $obTabla->DibujeAreaFacturacionRestaurante($idPedido,$myPage,"");
         
    }
    //////Creo una factura a partir de un pedido
    if(isset($_REQUEST['BtnFacturarDomicilio'])){
        $idPedido=$obVenta->normalizar($_REQUEST['BtnFacturarDomicilio']);
        $VectorDomicilio["Domicilio"]=1;
        $obTabla->DibujeAreaFacturacionRestaurante($idPedido,$myPage,$VectorDomicilio);
         
    }
    if(!empty($_REQUEST["TxtIdEgreso"])){
        $idEgreso=$obVenta->normalizar($_REQUEST["TxtIdEgreso"]);
        $RutaPrint="../tcpdf/examples/imprimircomp.php?ImgPrintComp=".$idEgreso;
        $css->CrearTabla();
            $css->CrearFilaNotificacion("Egreso Creado Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Egreso No. $idEgreso</a>",16);
        $css->CerrarTabla();
    }
    if(isset($_REQUEST["TxtidFactura"])){
            
        $idFactura=$_REQUEST["TxtidFactura"];
        if($idFactura<>""){
            $RutaPrint="../tcpdf/examples/imprimirFactura.php?ImgPrintFactura=".$idFactura;
            $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
            $css->CrearTabla();
            $css->CrearFilaNotificacion("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $DatosFactura[NumeroFactura]</a>",16);
            $css->CerrarTabla();
        }else{

           $css->AlertaJS("No se pudo crear la factura porque no hay resoluciones disponibles", 1, "", ""); 
        }
            
    }
    $css->DivPage("Pedidos", "Consultas/DatosPedidos.php?Valida=1", "", "DivBusqueda", "onClick", 30, 30, "");
    
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    
    $css->CrearNotificacionAzul("ADMINISTRACION", 16);
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("DivBusqueda", "", "center",1,1);
   
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->DivPage("Domicilios", "Consultas/DatosDomicilios.php?Valida=1", "", "DivDomicilios", "onClick", 1, 1, "");
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AnchoElemento("CmbCodMunicipio_chosen", 200);
    $css->AnchoElemento("CmbClientes_chosen", 200);
    $css->AnchoElemento("TxtidColaborador_chosen", 200);
    $css->AnchoElemento("TxtCliente_chosen", 200);
    $css->AnchoElemento("TxtClienteDomicilio_chosen", 500);
    $css->AnchoElemento("TxtCuentaDestino_chosen", 200);
    $css->AnchoElemento("TxtTipoPago_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 300);
    $css->AnchoElemento("CmbProveedores_chosen", 300);
    $css->AgregaSubir();
    print("<script>setInterval('BusquedaPedidos()',4000);ClickElement('Pedidos');</script>");
    print("<script>setInterval('BusquedaDomicilios()',4000);ClickElement('Domicilios');</script>");
    if(isset($_REQUEST['BtnFacturarPedido'])or isset($_REQUEST['BtnFacturarDomicilio'])){
        print("<script>document.getElementById('TxtPaga').select();</script> ");
    }
    $css->Footer();
    
    
    print("</body></html>");
?>