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
$idClientes="";



//////Si recibo un cliente
	if(!empty($_REQUEST['TxtIdCliente'])){
		
		$idClientes=$_REQUEST['TxtIdCliente'];
	}

	////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 8;
    	$startpoint = ($page * $limit) - $limit;
		
/////////

include_once ('funciones/function.php');
include_once("procesadores/procesaCoti.php");
	
print("<html><head>");	
$css =  new CssIni("SoftConTech Cotizaciones");
print("</head><body align='center'>");	
         
	 $obVenta=new ProcesoVenta($idUser);
         $obTabla = new Tabla($db);
	 $myPage="Cotizaciones.php";
	 $css->CabeceraIni("SoftConTech Cotizaciones"); 
	 
	 $DatosUsuarios=$obVenta->DevuelveValores("usuarios","idUsuarios", $idUser);
	
	 $css->CrearForm("FrmBuscarCliente",$myPage,"post","_self");
	 $css->CrearInputText("TxtBuscarCliente","text","Buscar Cliente: ","","Digite un Dato del cliente","white","","",200,30,0,0);
	 $css->CrearBoton("BtnBuscarCliente", "Buscar");
         $css->CreaBotonDesplegable("DialCliente","Crear Cliente");
	 $css->CerrarForm();
              
	 $css->CabeceraFin();
         //Espacio para Crear Botonos y Cuadros de dialogo
         $css->CrearDiv("principal", "container", "center", 1, 1);
         
         
         
         $Titulo="Crear Item En servicios";
         $Nombre="ImgShowMenu";
         $RutaImage="../images/pop_servicios.png";
         $javascript="";
         $VectorBim["f"]=0;
         $target="#DialCrearItemServicios";
         $css->CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,"",80,80,"fixed","left:10px;top:50",$VectorBim);
         $VectorCDC["F"]=0;
         
         $obTabla->CrearCuadroClientes("DialCliente","Crear Cliente",$myPage,$VectorCDC);
	 $VectorCDSer["servitorno"]=1;
         $obTabla->CrearCuadroCrearServicios("DialCrearItemServicios","Crear Nuevo Item Servicios",$myPage,$idClientes,$VectorCDSer); 
	 	
        
	//$css->CrearImageLink("../VMenu/MnuVentas.php", "../images/cotizacion.png", "_self",200,200);
	if(!empty($_REQUEST["TxtIdCotizacion"])){
		$RutaPrintCot="../tcpdf/examples/imprimircoti.php?ImgPrintCoti=".$_REQUEST["TxtIdCotizacion"];			
		$css->CrearTabla();
		$css->CrearFilaNotificacion("Cotizacion almacenada Correctamente <a href='$RutaPrintCot' target='_blank'>Imprimir Cotizacion No. $_REQUEST[TxtIdCotizacion]</a>",16);
		$css->CerrarTabla();
	}
	
	////////////////////////////////////Si se solicita buscar un cliente
	
	if(!empty($_REQUEST["TxtBuscarCliente"])){
		
		$Key=$_REQUEST["TxtBuscarCliente"];
		$pa=mysql_query("SELECT * FROM clientes	WHERE RazonSocial LIKE '%$Key%' OR Num_Identificacion = '$Key' LIMIT 10") or die(mysql_error());
		if(mysql_num_rows($pa)){
			print("<br>");
			$css->CrearTabla();
			$css->FilaTabla(18);
			$css->ColTabla("Clientes Encontrados para Asociar:",4);
			$css->CierraFilaTabla();
			
			while($DatosCliente=mysql_fetch_array($pa)){
				$css->FilaTabla(14);
				$css->ColTabla($DatosCliente['RazonSocial'],1);
				$css->ColTabla($DatosCliente['Num_Identificacion'],1);
				$css->ColTabla($DatosCliente['Contacto'],1);
				$css->ColTablaVar($myPage,"TxtAsociarCliente",$DatosCliente['idClientes'],"","Asociar Cliente");
				$css->CierraFilaTabla();
			}
			
			$css->CerrarTabla(); 
		}else{
			print("<h3>No hay resultados</h3>");
		}
		
	}
	if($idClientes>0){
		$DatosClientes=$obVenta->DevuelveValores("clientes","idClientes",$idClientes);
                $css->CrearNotificacionAzul("Precotizacion para el cliente $idClientes $DatosClientes[RazonSocial]<br>", 16);
		
		$css->CrearForm2("FrmBuscarItem",$myPage,"get","_self");
			$css->CrearInputText("TxtIdCliente","hidden","",$idClientes,"","","","",0,0,0,0);
			$css->CrearInputText("page","hidden","",1,"","","","",0,0,0,0);
                        
                        $VarSelect["Ancho"]="200";
                        $VarSelect["PlaceHolder"]="Busque un Producto";
                        $VarSelect["Title"]="Buscar por palabra clave";
                        $css->CrearSelectChosen("TxtAgregarItemPreventa", $VarSelect);
    
                        $sql="SELECT * FROM productosventa";
                        $Consulta=$obVenta->Query($sql);
                         $css->CrearOptionSelect("", "Seleccione un producto", 1);
                           while($DatosProducto=$obVenta->FetchArray($Consulta)){

                               $css->CrearOptionSelect("$DatosProducto[idProductosVenta];productosventa", "$DatosProducto[idProductosVenta] / $DatosProducto[Referencia] / $DatosProducto[Nombre] / $DatosProducto[Existencias]" , 0);
                           }

                        $sql="SELECT * FROM servicios";
                        $Consulta=$obVenta->Query($sql);

                           while($DatosProducto=$obVenta->FetchArray($Consulta)){

                               $css->CrearOptionSelect("$DatosProducto[idProductosVenta];servicios", "$DatosProducto[idProductosVenta] / $DatosProducto[Referencia] / $DatosProducto[Nombre] " , 0);
                           }   
                           $sql="SELECT * FROM productosalquiler";
                        $Consulta=$obVenta->Query($sql);

                           while($DatosProducto=$obVenta->FetchArray($Consulta)){

                               $css->CrearOptionSelect("$DatosProducto[idProductosVenta];productosalquiler", "$DatosProducto[idProductosVenta] / $DatosProducto[Referencia] / $DatosProducto[Nombre] " , 0);
                           }  
                        $css->CerrarSelect();
        
					
			$css->CrearBoton("BtnAgregarItem", "Agregar");
		$css->CerrarForm();
	}
        $css->CrearDiv("Productos Agregados", "container", "center", 1, 1);
	
										
        //////////////////////////Se dibujan los items en la precotizacion
					
				



                if($idClientes>0){

                $css->CrearTabla();
                $sql="SELECT * FROM  precotizacion WHERE idUsuario='$idUser' ORDER BY ID DESC";
                $pa=$obVenta->Query($sql);
                
                if($obVenta->NumRows($pa)){	

                        $css->FilaTabla(18);
                        $css->ColTabla('Referencia',1);
                        $css->ColTabla('Descripcion',1);
                        $css->ColTabla('Cantidad _ Multiplicador _ ValorUnitario',2);
                        $css->ColTabla('Subtotal',1);
                        $css->ColTabla('Borrar',1);
                        $css->CierraFilaTabla();

                while($row=$obVenta->FetchArray($pa)){
                        $css->FilaTabla(16);
                        $css->ColTabla($row['Referencia'],1);
                        $css->ColTabla($row['Descripcion'],1);
                        print("<td colspan=2>");
                        $css->CrearForm2("FrmEdit$row[ID]",$myPage,"post","_self");
                        $css->CrearInputText("TxtIdCliente","hidden","",$idClientes,"","","","",0,0,0,0);
                        $css->CrearInputText("TxtTabla","hidden","",$row["Tabla"],"","","","",0,0,0,0);
                        $css->CrearInputText("TxtPrecotizacion","hidden","",$row["ID"],"","","","",0,0,0,0);
                        $css->CrearInputNumber("TxtEditar","number","",$row["Cantidad"],"","black","","",100,30,0,1,0, "","any");
                        $css->CrearInputNumber("TxtMultiplicador","number","",$row["Multiplicador"],"","black","","",100,30,0,1,1, "","any");
                        $css->CrearInputNumber("TxtValorUnitario","number","",$row["ValorUnitario"],"","black","","",150,30,0,1,$row["PrecioCosto"], $row["ValorUnitario"]*10,"any");
                        $css->CrearBoton("BtnEditar", "E");
                        $css->CerrarForm();
                        print("</td>");
                        $css->ColTabla(number_format($row['SubTotal']),1);
                        $css->ColTablaDel($myPage,"precotizacion","ID",$row['ID'],$idClientes);
                        $css->CierraFilaTabla();


                }
                $Visible=1;
                }else{
                    $css->CrearNotificacionRoja("No hay productos agregados a esta Cotizacion", 16);
                    $Visible=0;
                }

                $css->CerrarTabla();



                $Subtotal=$obVenta->SumeColumna("precotizacion","SubTotal", "idUsuario",$idUser);
                $IVA=$obVenta->SumeColumna("precotizacion","IVA", "idUsuario",$idUser);

                $Total=$Subtotal+$IVA;
                $css->CrearDiv("DivTotales", "", "center", $Visible, 1);
                $css->CrearForm2("FrmGuarda",$myPage,"post","_self");
                $css->CrearInputText("TxtIdCliente","hidden","",$idClientes,"","","","",150,30,0,0);
                
                $css->CrearTabla();
                $css->FilaTabla(14);
                $css->ColTabla("Esta Cotizacion:",4);
                $css->CierraFilaTabla();
                $css->FilaTabla(18);
                $css->ColTabla("SUBTOTAL:",1);
                $css->ColTabla(number_format($Subtotal),3);
                $css->CierraFilaTabla();
                $css->FilaTabla(18);
                $css->ColTabla("IMPUESTOS:",1);
                $css->ColTabla(number_format($IVA),3);
                $css->CierraFilaTabla();

                $css->FilaTabla(18);
                $css->ColTabla("TOTAL:",1);
                $css->ColTabla(number_format($Total),3);
                $css->FilaTabla(18);
                print("<td colspan=4>");
                $css->CrearInputText("TxtNumOrden","text","","","Numero de Orden","black","","",150,30,0,0);

                $css->CrearInputText("TxtNumSolicitud","text","","","Numero de Solicitud","black","","",150,30,0,0);
                print("<br>");
                $css->CrearTextArea("TxtObservaciones","","","Observaciones para esta Cotizaciones","black","","",300,100,0,0);
                print("<br>");
                $css->CrearBotonConfirmado("BtnGuardar","Guardar");
                print("</td>");
                $css->CierraFilaTabla();

                $css->CerrarTabla(); 
                $css->CerrarForm();
                $css->CerrarDiv();
                }else{
                    $css->CrearNotificacionRoja("Por favor Seleccione un cliente", 18);
                }
        
$css->CerrarTabla();
$css->CerrarDiv();//Cerramos contenedor Secundario
$css->CerrarDiv();//Cerramos contenedor Principal
$css->AgregaJS();
$css->AgregaSubir();
$css->AnchoElemento("CmbCodMunicipio_chosen", 200);
$css->AnchoElemento("CmbDepartamento_chosen", 200);
$css->AnchoElemento("CmbIVA_chosen", 200);
$css->AnchoElemento("TxtCuentaPUC_chosen", 200);
$css->Footer();
print("</body></html>");

ob_end_flush();
?>