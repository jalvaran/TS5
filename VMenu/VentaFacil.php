<script src="../shortcuts.js" type="text/javascript">
</script>
<script src="js/funciones.js"></script>
<?php 

session_start();

include_once("../modelo/php_conexion.php");
include_once("css_construct.php");

if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}
if ($_SESSION['tipouser']<>"administrador")
	{
	  exit("Usted No esta autorizado para ingresar a esta parte <a href='Menu.php' >Menu </a>");
	  
	}
$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	

$idPreventa="";
//////Si recibo una preventa
	if(!empty($_REQUEST['CmbPreVentaAct'])){
		
		$idPreventa=$_REQUEST['CmbPreVentaAct'];
	}

include_once("procesa.php");
	
	
?>
 
<!DOCTYPE html>
<html>
  
	<head>
	
	 <?php $css =  new CssIni("SoftConTech Ventas"); ?>
	</head>
 
	<body>
   
	 <?php 
	 $obVenta=new ProcesoVenta($idUser);
	 $myPage="VentaFacil.php";
	 $css->CabeceraIni("SoftConTech Ventas"); 
	 $DatosUsuarios=$obVenta->DevuelveValores("usuarios","idUsuarios", $idUser);
	 //if($DatosUsuarios['Role']=="FACTURA")	
	 $css->CreaBotonAgregaPreventa($myPage,$idUser);
	 if($idPreventa>1)
		$css->CreaBotonDesplegable("cant2","Crear Separado");
	 $css->CrearForm("FrmPreventaSel",$myPage,"post","_self");
	 $css->CrearSelect("CmbPreVentaAct","EnviaForm('FrmPreventaSel')");
	 $css->CrearOptionSelect('NO','Seleccione una preventa',0);
	 
	 $pa=mysql_query("SELECT * FROM vestasactivas WHERE Usuario_idUsuario='$idUser'");	
		
		while($DatosVentasActivas=mysql_fetch_array($pa)){
			$label=$DatosVentasActivas["idVestasActivas"]." ".$DatosVentasActivas["Nombre"];
			
			if($idPreventa==$DatosVentasActivas["idVestasActivas"])
				$Sel=1;
			else
				$Sel=0;
			
			$css->CrearOptionSelect($DatosVentasActivas["idVestasActivas"],$label,$Sel);
		
		}
			
	 
	 $css->CerrarSelect();
	 $css->CrearInputText("TxtBuscarCliente","text","Buscar Cliente: ","","Digite un Dato del cliente","white","","",200,30,0,0);
	 $css->CerrarForm();
	 $css->CreaBotonDesplegable("Clientes","Crear Cliente");
	 $css->CabeceraFin(); 
	 
	 
	
	 /////////////////Cuadro de dialogo de separados
	 $css->CrearCuadroDeDialogo("cant2","Crear Separado"); 
	 
	 $DatosPreventa=$obVenta->DevuelveValores("vestasactivas","idVestasActivas", $idPreventa);
	 if($DatosPreventa["Clientes_idClientes"]>1){
		 $css->CrearForm("FrmCrearSeparado",$myPage,"post","_self");
		 $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
		 $css->CrearInputText("TxtAbono","number","Abono:<br>","","Digite el Abono del cliente","black","","",200,30,0,0);
		 $css->CrearBoton("BtnCrearSeparado", "Crear Separado");
		 $css->CerrarForm();
	 }else{
		 print("No es posible crear un separado sin asignar un cliente");
	 }
	 $css->CerrarCuadroDeDialogo(); 
	  /////////////////Cuadro de dialogo de Clientes create
	 $css->CrearCuadroDeDialogo("Clientes","Crear Crear Cliente"); 
	 
		 $css->CrearForm("FrmCrearCliente",$myPage,"post","_self");
		 $css->CrearSelect("CmbTipoDocumento","Oculta()");
		 $css->CrearOptionSelect('13','Cedula',1);
		 $css->CrearOptionSelect('31','NIT',0);
		 $css->CerrarSelect();
		 $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
		 $css->CrearInputText("TxtNIT","number","","","Identificacion","black","","",200,30,0,1);
		 $css->CrearInputText("TxtPA","text","","","Primer Apellido","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtSA","text","","","Segundo Apellido","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtPN","text","","","Primer Nombre","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtON","text","","","Otros Nombres","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtRazonSocial","text","","","Razon Social","black","","",200,30,0,1);
		 $css->CrearInputText("TxtDireccion","text","","","Direccion","black","","",200,30,0,1);
		 $css->CrearInputText("TxtTelefono","text","","","Telefono","black","","",200,30,0,1);
		 $css->CrearInputText("TxtEmail","text","","","Email","black","","",200,30,0,1);
		 $css->CrearBoton("BtnCrearCliente", "Crear Cliente");
		 $css->CerrarForm();
	 
	 $css->CerrarCuadroDeDialogo(); 
	 $ruta="../VAtencion/".$myPage;
	 $UltimaFactura=$obVenta->ObtenerMAX("facturas","idFacturas", "Usuarios_idUsuarios", $idUser);
	 $UltimoAbono=$obVenta->ObtenerMAX("facturas_abonos","idFacturasAbonos", "Usuarios_idUsuarios", $idUser);
	 $css->CreaMenuBasico("Imprimir"); 
	 $css->CreaSubMenuBasico("Ultima Factura","../printer/imprimir.php?print=$UltimaFactura&ruta=$ruta"); 
	 $css->CreaSubMenuBasico("Ultima Comprobante de Abono","../tcpdf/examples/AbonosPrint.php?idFacturasAbonos=$UltimoAbono"); 
	 $css->CierraMenuBasico(); 
	 ?>
	

	

	
    <div class="container">
	<br>
	<?php	
	
	
	
	////////////////////////////////////Si se solicita buscar un cliente
	
	if(!empty($_REQUEST["TxtBuscarCliente"])){
		
		$Key=$_REQUEST["TxtBuscarCliente"];
		$pa=mysql_query("SELECT * FROM clientes	WHERE RazonSocial LIKE '%$Key%' OR Num_Identificacion = '$Key' LIMIT 10") or die(mysql_error());
		if(mysql_num_rows($pa)){
			print("<br>");
			$css->CrearTabla();
			$css->FilaTabla(18);
			$css->ColTabla("Clientes Encontrados para Asociar:",3);
			$css->CierraFilaTabla();
			
			while($DatosCliente=mysql_fetch_array($pa)){
				$css->FilaTabla(14);
				$css->ColTabla($DatosCliente['RazonSocial'],1);
				$css->ColTabla($DatosCliente['Num_Identificacion'],1);
				$css->ColTablaVar($myPage,"TxtAsociarCliente",$DatosCliente['idClientes'],$idPreventa,"Asociar Cliente");
				$css->CierraFilaTabla();
			}
			
			$css->CerrarTabla(); 
		}else{
			print("<h3>No hay resultados</h3>");
		}
		
	}
	
	
	
	?>	
	
     	  
	  <div id="Productos Agregados" class="container" >
	
		<h2 align="center">
					<?php 
					$css->CrearForm("FrmCodBarras",$myPage,"post","_self");
					$css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
					$css->CrearInputText("TxtCodigoBarras","text","","","Digite un codigo de Barras","black","","",200,30,0,0);
					$css->CrearInputText("TxtBuscarItem","text","","","Busque Un Item","black","","",300,30,0,0);
					$css->CrearBoton("BtnAgregarItem", "Agregar");
					$css->CerrarForm();
					
					if(!empty($_REQUEST["TxtBuscarItem"])){
		
					$Key=$_REQUEST["TxtBuscarItem"];
					$pa=mysql_query("SELECT * FROM productosventa WHERE Referencia LIKE '%$Key%' OR idProductosVenta = '$Key' OR Nombre LIKE '%$Key%' OR PrecioVenta = '$Key' LIMIT 20") or die(mysql_error());
					if(mysql_num_rows($pa)){
						print("<br>");
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
							$css->ColTablaVar($myPage,"TxtAgregarItemPreventa",$DatosProductos['idProductosVenta'],$idPreventa,"Agregar Item");
							$css->CierraFilaTabla();
					}
			
			$css->CerrarTabla(); 
		}else{
			print("<h3>No hay resultados</h3>");
		}
		
	}
					
					if($idPreventa=="NO" or $idPreventa==""){
						
						exit("Por favor Selecccione una Preventa");
						
					}else{
						
						/////////////////////////////////////Se muestra el Cuadro con los valores de la preventa actual
	
						$obVenta=new ProcesoVenta($idUser);
						$Subtotal=$obVenta->SumeColumna("preventa","Subtotal", "VestasActivas_idVestasActivas",$idPreventa);
						$IVA=$obVenta->SumeColumna("preventa","Impuestos", "VestasActivas_idVestasActivas",$idPreventa);
						$DatosPreventa=$obVenta->DevuelveValores("vestasactivas","idVestasActivas", $idPreventa);
						$SaldoFavor=$DatosPreventa["SaldoFavor"];
						if($SaldoFavor>0)
							$SaldoFavor=$SaldoFavor;
						else
							$SaldoFavor=0;
						
						$Total=$Subtotal+$IVA;
						$GranTotal=$Total-$SaldoFavor;
						$css->CrearForm("FrmGuarda",$myPage,"post","_self");
						$css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",150,30,0,0);
						$css->CrearInputText("TxtSaldoFavor","hidden","",$SaldoFavor,"","","","",150,30,0,0);
						$css->ColTablaInputText("TxtTotalH","hidden",$Total,"","","","","",150,30,0,0);
						$css->ColTablaInputText("TxtGranTotalH","hidden",$GranTotal,"","","","","",150,30,0,0);
						$css->CrearTabla();
						$css->FilaTabla(14);
						$css->ColTabla("Esta Venta:",3);
						$css->CierraFilaTabla();
						$css->FilaTabla(18);
						$css->ColTabla("SUBTOTAL:",1);
						$css->ColTabla(number_format($Subtotal),2);
						$css->CierraFilaTabla();
						$css->FilaTabla(18);
						$css->ColTabla("IMPUESTOS:",1);
						$css->ColTabla(number_format($IVA),2);
						$css->CierraFilaTabla();
						if($SaldoFavor>0){
							$css->FilaTabla(18);
							$css->ColTabla("SALDO A FAVOR:",1);
							$css->ColTabla(number_format($SaldoFavor),2);
							$css->CierraFilaTabla();
							
						}
						$css->FilaTabla(18);
						$css->ColTabla("TOTAL:",1);
						$css->ColTabla(number_format($Total),2);
						$css->CierraFilaTabla();
						if($SaldoFavor>0){
							$css->FilaTabla(18);
							$css->ColTabla("GRAN TOTAL:",1);
							$css->ColTabla(number_format($GranTotal),2);
							$css->CierraFilaTabla();
						}
						$css->FilaTabla(18);
						$css->ColTabla("PAGA:",1);
						$css->ColTablaInputText("TxtPaga","number","","","Paga","","onkeyup","CalculeDevuelta()",150,30,0,0);
						
						$css->CierraFilaTabla();
						
						$css->FilaTabla(18);
						$css->ColTabla("DEVOLVER:",1);
						$css->ColTablaInputText("TxtDevuelta","text","","","Devuelta","","","",150,30,1,0);
						$css->ColTablaBoton("BtnGuardar","Guardar");
						$css->CierraFilaTabla();
						
						$css->CerrarTabla(); 
						$css->CerrarForm();
						
						
						/////////////////////////////////////Se dibuja los items agregados a la preventa activa
						
						$pa=mysql_query("SELECT * FROM vestasactivas v INNER JOIN clientes c ON v.Clientes_idClientes=c.idClientes WHERE idVestasActivas='$idPreventa'") or die(mysql_error());	
						$DatosPreventa=mysql_fetch_array($pa);
						print("Productos agregados a la Preventa $idPreventa del Cliente: $DatosPreventa[RazonSocial] <br>");
						
					}
					
					?></h2>
               		<table class="table table-bordered" >
                      <tr>
                        <td>
                        	
                            <?php 
								$css->CrearTabla();
								
								
								
								$pa=mysql_query("SELECT * FROM preventa pre INNER JOIN productosventa pv ON pre.ProductosVenta_idProductosVenta=pv.idProductosVenta 
												WHERE pre.VestasActivas_idVestasActivas='$idPreventa' ORDER BY pre.idPrecotizacion DESC") or die(mysql_error());
								if(mysql_num_rows($pa)){	
									
									$css->FilaTabla(18);
									$css->ColTabla('Referencia',1);
									$css->ColTabla('Nombre',1);
									$css->ColTabla('Cantidad',1);
									$css->ColTabla('ValorUnitario',1);
									$css->ColTabla('Subtotal',1);
									$css->ColTabla('Borrar',1);
									$css->CierraFilaTabla();
									
								while($row=mysql_fetch_array($pa)){
									$css->FilaTabla(16);
									$css->ColTabla($row['Referencia'],1);
									$css->ColTabla($row['Nombre'],1);
									$css->ColTablaFormInputText("FrmEdit$row[idPrecotizacion]",$myPage,"post","self","TxtEditar","Number",$row['Cantidad'],"","","","","","150","30","","","TxtPrecotizacion",$row['idPrecotizacion'],$idPreventa);
									$css->ColTabla(number_format($row['ValorUnitario']),1);
									$css->ColTabla(number_format($row['Subtotal']),1);
									$css->ColTablaDel($myPage,"preventa","idPrecotizacion",$row['idPrecotizacion'],$idPreventa);
									//$css->CierraColTabla();
									$css->CierraFilaTabla();
									
							?>
                              
                                
                              </tr>
                           
                            	
                            <?php } }
								$pa=mysql_query("SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa'");				
								if(!$row=mysql_fetch_array($pa)){
							?>
                              <tr><div class="alert alert-success" align="center"><strong>No hay Productos agregados a esta Preventa</strong></div></tr>
							  <?php  } $css->CerrarTabla(); ?>
                           
                        </td>
                      </tr>
		

    </div>
	
      			
</div> <!-- /container -->
     

    

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
	

   
		
<a style="display:scroll; position:fixed; bottom:10px; right:10px;" href="#" title="Volver arriba"><img src="../iconos/up1_amarillo.png" /></a>

	
 
  </body>
  
  
</html>

<script language="JavaScript"> 
atajos();
posiciona('TxtCodigoBarras');
</script> 
