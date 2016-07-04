<?php
ob_start();
session_start();
?>
<script src="../shortcuts.js" type="text/javascript">
</script>
<script src="js/funciones.js"></script>
<?php 

include_once("../modelo/php_conexion.php");
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
include_once("procesaCoti.php");
	
	
?>
 
<!DOCTYPE html>
<html>
  
	<head>
	
	 <?php $css =  new CssIni("SoftConTech Cotizaciones"); ?>
	</head>
 
	<body align="center">
   
	 <?php 
         
	 $obVenta=new ProcesoVenta($idUser);
	 $myPage="Cotizaciones.php";
	 $css->CabeceraIni("SoftConTech Cotizaciones"); 
	 
	 $DatosUsuarios=$obVenta->DevuelveValores("usuarios","idUsuarios", $idUser);
	
	 $css->CrearForm("FrmBuscarCliente",$myPage,"post","_self");
	 $css->CrearInputText("TxtBuscarCliente","text","Buscar Cliente: ","","Digite un Dato del cliente","white","","",200,30,0,0);
	 $css->CrearBoton("BtnBuscarCliente", "Buscar");
	 $css->CerrarForm();
	 $css->CreaBotonDesplegable("DialCliente","Crear Cliente");
	 $css->CabeceraFin(); 
	 
	

	  /////////////////Cuadro de dialogo de Clientes create
	 $css->CrearCuadroDeDialogo("DialCliente","Crear Crear Cliente"); 
	 
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
		 $css->CrearBoton("BtnCrearCliente", "Crear Cliente");
		 $css->CerrarForm();
	 
	 $css->CerrarCuadroDeDialogo(); 
	 $ruta="../VAtencion/".$myPage;
	 
	 $css->CreaMenuBasico("Menu"); 
	 $css->CreaSubMenuBasico("Historial de Cotizaciones","cot_itemscotizaciones.php"); 
	 $css->CierraMenuBasico(); 
	 ?>
	

	

	
    <div class="container">
	<br>
	<?php	
	$css->CrearImageLink("../VMenu/MnuVentas.php", "../images/cotizacion.png", "_self",200,200);
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
		print("Precotizacion para el cliente $idClientes $DatosClientes[RazonSocial]<br>");
		$css->CrearForm("FrmBuscarItem",$myPage,"get","_self");
			$css->CrearInputText("TxtIdCliente","hidden","",$idClientes,"","","","",0,0,0,0);
			$css->CrearInputText("page","hidden","",1,"","","","",0,0,0,0);
			$css->CrearInputText("TxtBuscarItem","text","","","Busque Un Item","black","","",300,30,0,0);
			$css->CrearSelect("CmbBuscarDpto","EnviaForm('FrmBuscarItem')");
				 //$css->CrearOptionSelect("NO","Seleccione un departamento");				 
				 $pa=mysql_query("SELECT * FROM prod_departamentos");	
					
					while($DatosDepartamentos=mysql_fetch_array($pa)){
																	
						$css->CrearOptionSelect($DatosDepartamentos["idDepartamentos"],$DatosDepartamentos["Nombre"]);
					
					}
					
			 
			 $css->CerrarSelect();
	 
			
			
			$css->CrearBoton("BtnAgregarItem", "Busqueda");
		$css->CerrarForm();
	}
	?>	
	
     	  
	  <div id="Productos Agregados" class="container" >
	
		<h2 align="center">
					<?php 
										
					if(!empty($_REQUEST["CmbBuscarDpto"])){
						$idDepartamento=$_REQUEST["CmbBuscarDpto"];
						$DatosDepartamentos=$obVenta->DevuelveValores("prod_departamentos","idDepartamentos",$idDepartamento);
					if(!empty($_REQUEST["TxtBuscarItem"]))
						$Key=$_REQUEST["TxtBuscarItem"];
					else
						$Key=" ";
					$statement = "$DatosDepartamentos[TablaOrigen] WHERE Departamento = '$idDepartamento' AND (Referencia LIKE '%$Key%' OR idProductosVenta = '$Key' OR Nombre LIKE '%$Key%' OR PrecioVenta = '$Key')";
					
					$pa=mysql_query("SELECT * FROM $statement LIMIT $startpoint,$limit") or die(mysql_error());
					if(mysql_num_rows($pa)){
						
						//print("<br>");
						
						
						
						
						$css->CrearTabla();
						$css->FilaTabla(18);
						$css->ColTabla("Productos Encontrados:",5);
						$css->CierraFilaTabla();
						while($DatosProductos=mysql_fetch_array($pa)){
							$css->FilaTabla(14);
							$css->ColTabla($DatosProductos['idProductosVenta'],1);
							$css->ColTabla($DatosProductos['Referencia'],1);
							$css->ColTabla($DatosProductos['Nombre'],1);
							$css->ColTabla(number_format($DatosProductos['PrecioVenta']),1);
							$css->ColTablaVar($myPage,"TxtAgregarItemPreventa","$DatosProductos[idProductosVenta]&TxtTabla=$DatosDepartamentos[TablaOrigen]&TxtAsociarCliente=$idClientes","","Agregar Item");
							$css->CierraFilaTabla();
					}
			
			$css->CerrarTabla(); 
			$Ruta="TxtIdCliente=$idClientes&TxtBuscarItem=$Key&CmbBuscarDpto=$idDepartamento&";
			print(pagination($Ruta,$statement,$limit,$page));
		}else{
			$css->CrearFilaNotificacion("No hay resultados para la busqueda",16);
		}
		
	}				//////////////////////////Se dibujan los items en la precotizacion
					
				
					?></h2>
               		<table class="table table-bordered" >
                      <tr>
                        <td>
                        	
                            <?php 
							
                            if($idClientes>0){

                            $css->CrearTabla();

                            $pa=mysql_query("SELECT * FROM  precotizacion WHERE idUsuario='$idUser' ORDER BY ID DESC") or die(mysql_error());
                            if(mysql_num_rows($pa)){	

                                    $css->FilaTabla(18);
                                    $css->ColTabla('Referencia',1);
                                    $css->ColTabla('Descripcion',1);
                                    $css->ColTabla('Cantidad _ Multiplicador _ ValorUnitario',2);
                                    $css->ColTabla('Subtotal',1);
                                    $css->ColTabla('Borrar',1);
                                    $css->CierraFilaTabla();

                            while($row=mysql_fetch_array($pa)){
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
                            }

                            $css->CerrarTabla();



                            $Subtotal=$obVenta->SumeColumna("precotizacion","SubTotal", "idUsuario",$idUser);
                            $IVA=$obVenta->SumeColumna("precotizacion","IVA", "idUsuario",$idUser);

                            $Total=$Subtotal+$IVA;

                            $css->CrearForm("FrmGuarda",$myPage,"post","_self");
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

                            }else{
                                    print('<tr><div class="alert alert-success" align="center"><strong>Por favor Seleccione un Cliente</strong></div></tr>');
                            }
                    ?>


                              </tr>
                           
                            	
                            <?php 
								$pa=mysql_query("SELECT * FROM precotizacion WHERE idUsuario='$idUser'");				
								if(!$row=mysql_fetch_array($pa)){
							?>
                              <tr><div class="alert alert-success" align="center"><strong>No hay Productos agregados a esta Precotizacion</strong></div></tr>
							  <?php  } $css->CerrarTabla(); ?>
                           
                        </td>
                      </tr>
		

    </div>
	
      			
</div> <!-- /container -->
     

    

<?php 
    $css->AgregaJS();
    $css->AnchoElemento("CmbCodMunicipio_chosen", 200);
?>

   
		
<a style="display:scroll; position:fixed; bottom:10px; right:10px;" href="#" title="Volver arriba"><img src="../images/up1_amarillo.png" /></a>

	
 
  </body>
  
  
</html>

<script language="JavaScript"> 
atajos();
posiciona('TxtCodigoBarras');
</script> 
<?php
ob_end_flush();
?>