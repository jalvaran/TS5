<?php 
$myPage="DarBaja.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
	
print("<html>");
print("<head>");
$css =  new CssIni("Dar de Baja un producto");

print("</head>");
print("<body>");
    
    include_once("procesadores/procesaDarDeBajaAlta.php");
    
    $css->CabeceraIni("Dar de Baja"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("../VMenu/MnuInventarios.php", "../images/baja.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    if(!empty($_REQUEST["TxtidComprobante"])){
        $RutaPrintIngreso="../tcpdf/examples/notacredito.php?idComprobante=".$_REQUEST["TxtidComprobante"];			
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Nota Credito Creada Correctamente <a href='$RutaPrintIngreso' target='_blank'>Imprimir Nota Credito No. $_REQUEST[TxtidComprobante]</a>",16);
        $css->CerrarTabla();
    }
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
   										
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    
        
        $css->CrearForm2("FrmRegistraBajaAlta", $myPage, "post", "_self");
        
        $css->CrearTabla();
        $css->CrearNotificacionRoja("Datos Para Realizar la Baja", 16);
        print("<td style='text-align:center'>");
        $css->CrearInputText("TxtFecha", "text", "Fecha de La Baja: <br>", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
        print("<br>");
        $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el producto";
            $VarSelect["Required"]=1;
            $css->CrearSelectChosen("CmbProducto", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione un producto" , 0);
            $sql="SELECT * FROM productosventa";
            $Consulta=$obVenta->Query($sql);
            $Sel=0;
               while($DatosProducto=$obVenta->FetchArray($Consulta)){
                   
                   
                   $css->CrearOptionSelect($DatosProducto["Referencia"], "$DatosProducto[Referencia] $DatosProducto[Nombre] $DatosProducto[idProductosVenta]" , $Sel);
               }
            $css->CerrarSelect();
            print("<br>");  
            print("<br>"); 
        
        $css->CrearTextArea("TxtConcepto", "", "", "Escriba el por qué se dará de baja al producto", "black", "", "", 200, 100, 0, 1);
        print("<br>");
        
        
            $css->CrearInputNumber("TxtCantidad", "number", "Cantidad:<br>", 1, "Cantidad", "black", "", "", 100, 30, 0, 1, 1, "", 1);
            print("<br>"); 
            $css->CrearBotonConfirmado("BtnBaja","Dar de Baja");	
          
        print("</td>");
        
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