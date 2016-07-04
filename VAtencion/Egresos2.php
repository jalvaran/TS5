<?php
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
if ($_SESSION['tipouser']<>"administrador")
	{
	  exit("Usted No esta autorizado para ingresar a esta parte <a href='Menu.php' >Menu </a>");
	  
	}
$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	
$fecha=date("Y-m-d");
$TipoEgresos="";
//////Si recibo una preventa
	if(!empty($_REQUEST['TxtIdPre'])){
		
		$TipoEgresos=$_REQUEST['TxtIdPre'];
	}

include_once("procesaEgresos.php");
	
	
?>
 
<!DOCTYPE html>
<html>
  
	<head>
	
	 <?php $css =  new CssIni("SoftConTech Egresos"); ?>
	</head>
 
	<body>
   
	 <?php 
	 $obVenta=new ProcesoVenta($idUser);
	 $myPage="Egresos2.php";
	 $css->CabeceraIni("SoftConTech Egresos"); 
	 $DatosUsuarios=$obVenta->DevuelveValores("usuarios","idUsuarios", $idUser);
	 
	 $css->CreaBotonDesplegable("Proveedor","Crear Proveedor");
	 $css->CabeceraFin(); 
	 
	  /////////////////Cuadro de dialogo de Clientes create
	 $css->CrearCuadroDeDialogo("Proveedor","Crear Proveedor"); 
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
                                  
		 $css->CrearBoton("BtnCrearProveedor", "Crear Proveedor");
		 $css->CerrarForm();
		 
	 
	 $css->CerrarCuadroDeDialogo(); 
	 
	 ?>
	

	

	
    <div class="container">
	
	
	
     	  
	  <div id="TipoEgresos" class="container" >
	
		<h2 align="center">
			<?php 
                                               
				if(!empty($RutaPrintComp)){
					
					$css->CrearTabla();
					$css->CrearFilaNotificacion("Egreso registrado Correctamente <a href='$RutaPrintComp' target='_blank'>Imprimir Comprobante</a>",16);
					$css->CerrarTabla();
				}
				////////Creo el la tabla para seleccionar un proveedor
				$css->CrearForm("FrmBuscarProveedor",$myPage,"post","_self");
				$css->CrearInputText("TxtIdPre","hidden","",$TipoEgresos,"","","","",150,30,0,0);
				$css->CrearInputText("TxtBuscarProveedor","text",'','',"Buscar Un Proveedor","black","","",300,30,0,1);
				$css->CrearBoton("BtnBuscarProveedor","Buscar");
				$css->CerrarForm();
					
				if(empty($_REQUEST["TxtAsociarProveedor"])){
						$css->CrearTabla();
						$css->CrearFilaNotificacion("No se ha seleccionado un Proveedor",16);
						$css->CerrarTabla(); 		
					}else{
						////////Creo el formulario para seleccionar el tipo de egreso
				
						$css->CrearForm("FrmAsignaEgreso",$myPage,"post","_self");
						$css->CrearInputText("TxtAsociarProveedor","hidden","",$_REQUEST["TxtAsociarProveedor"],"","","","",150,30,0,0);
						$css->CrearTabla();
						$css->FilaTabla(16);
						
						

						$css->ColTabla("Seleccione el tipo de egreso:",2);	
						print("<td>");
                                                $css->CrearSelect("TxtIdPre", "EnviaForm('FrmAsignaEgreso')");
						//$css->CrearSelect("TxtIdPre","","black","EnviaForm('FrmAsignaEgreso')",1);
							$css->CrearOptionSelect("","Seleccione el tipo de egreso",0);
							$Consulta = $obVenta->ConsultarTabla("egresos_tipo","WHERE Visible='1'");
							while($DatosTiposEgresos=mysql_fetch_array($Consulta)){
								if($DatosTiposEgresos['id']==$TipoEgresos)
									$Sel=1;
								else
									$Sel=0;
								$css->CrearOptionSelect($DatosTiposEgresos['id'],$DatosTiposEgresos['Nombre'],$Sel);							
							}
							$css->CerrarSelect();
						$css->CrearBoton("BtnSelEgreso","Seleccionar");
						
						print("</td>");
						$css->CierraFilaTabla();
						$css->CerrarTabla(); 
						$css->CerrarForm();	
								
				
				if($TipoEgresos<>""){
															
					$DatosProveedor = $obVenta->DevuelveValores("proveedores","idProveedores", $_REQUEST['TxtAsociarProveedor']);
					$css->CrearForm2("FrmDatosEgreso",$myPage,"post","_self");
                                        
					$css->CrearInputText("TxtTipoEgreso","hidden","",$TipoEgresos,"","","","",150,30,0,0);
					$css->CrearInputText("CmbProveedor","hidden","",$_REQUEST['TxtAsociarProveedor'],"","","","",150,30,0,0);
					$css->CrearTabla();
					$css->FilaTabla(16);
					$css->ColTabla("Seleccione los datos basicos para grabar este egreso a nombre del proveedor: $DatosProveedor[RazonSocial]",6);						
					$css->CierraFilaTabla();
					$css->FilaTabla(14);
						
					
					print("<td>");
					$css->CrearInputText("TxtFecha","text",'Fecha:<br>',$fecha,"Fecha Factura","black","","",150,30,0,1);
					print("</td>");
					print("<td>");
					$css->CrearSelect("CmbCuentaOrigen"," Cuenta Origen:<br>","black","",1);
					$css->CrearOptionSelect("","Seleccionar Cuenta Origen",0);
					$DatosCuentaOrigen = $obVenta->ConsultarTabla("cuentasfrecuentes","WHERE ClaseCuenta = 'ACTIVOS'");
					while($CuentaOrigen=mysql_fetch_array($DatosCuentaOrigen)){
							$css->CrearOptionSelect($CuentaOrigen['CuentaPUC'],$CuentaOrigen['Nombre'],0);							
					}
					$css->CerrarSelect();
					print("</td>");
					print("<td>");
					$css->CrearSelect("CmbCuentaDestino"," Cuenta Destino:<br>","black","",1);
					$css->CrearOptionSelect("","Seleccionar Cuenta Destino",0);
					$Egreso = $obVenta->DevuelveValores("egresos_tipo","id",$TipoEgresos);
					if($TipoEgresos==3){
						$Consulta = $obVenta->ConsultarTabla("cuentas","WHERE GupoCuentas_PUC = 24");
						$idTabla="idPUC";
					}else{
						$Consulta = $obVenta->ConsultarTabla("subcuentas","WHERE Cuentas_idPUC = '$Egreso[Cuentas_idCuentas]'");
						$idTabla="PUC";
					}
					while($CuentaDestino=mysql_fetch_array($Consulta)){
							
							$css->CrearOptionSelect($CuentaDestino["$idTabla"],$CuentaDestino['Nombre'],0);							
					}
					$css->CerrarSelect();
					print("</td>");
					
					///////Dibujo opciones de los centro de costo y forma de pago
					$css->FilaTabla(14);
					print("<td>");
					
					$css->CrearSelect("CmbCentroCosto"," Centro de Costos:<br>","black","",1);
					$css->CrearOptionSelect("","Seleccionar Centro de Costos",0);
										
					$Consulta = $obVenta->ConsultarTabla("centrocosto","");
					while($CentroCosto=mysql_fetch_array($Consulta)){
							$css->CrearOptionSelect($CentroCosto['ID'],$CentroCosto['Nombre'],0);							
					}
					$css->CerrarSelect();
					
					print("</td>");
					///////Dibujo opciones forma de pago
					print("<td>");
					
					$css->CrearSelect("TipoPago"," Tipo de Pago:<br>","black","",1);
					$css->CrearOptionSelect("Contado","Contado",0);		
					$css->CrearOptionSelect("Programado","Programado",0);		
						
					$css->CerrarSelect();
					
					print("</td>");
					
					///// Text Fecha Programada
					print("<td>");
					$css->CrearInputText("TxtFechaProgram","text",'Fecha Programada:<br>',$fecha,"Fecha Factura","black","","",150,30,0,1);
					print("</td>");
					
					$css->CierraFilaTabla();
					
					///////Dibujo Tipos de Cajas de acuerdo al egreso
					$css->FilaTabla(14);
					print("<td>");
					$css->CrearTextArea("TxtConcepto","Concepto del Egreso:<br>","","Escriba el motivo del Egreso","black","","",300,100,0,1);
					print("</td>");
					
					if($TipoEgresos==1){
						
						print("<td>");
						$css->CrearInputText("TxtNumFactura","text",'Numero de Comprobante:<br>',"","Numero de Comprobante","black","","",300,30,0,1);
                                                echo"<br>";
                                                $css->CrearUpload("foto");
                                                //print('<input type="file" name="foto" id="foto"></input>');
						print("</td>");
						print("<td>");
						$css->CrearInputText("TxtTotal","number",'Total:<br>',"","Total","black","","",150,30,0,1);
						print("<br>");
                                                print("Aplicar retenciones?<br>");
                                                $css->CrearSelect("CmbRetenciones", "MuestraOculta('DivRetenciones')");
                                                    $css->CrearOptionSelect("NO", "NO", 0);
                                                    $css->CrearOptionSelect("SI", "SI", 0);
                                                $css->CerrarSelect();
                                                print("<br>");
					
					}
					
					if($TipoEgresos==3){
						
						print("<td>");
						$css->CrearInputText("TxtNumFactura","text",'Numero de Formulario:<br>',"","Numero de Formulario","black","","",300,30,0,1);
                                                echo"<br>";
                                                $css->CrearUpload("foto");
						print("</td>");
						print("<td>");
						$css->CrearInputText("TxtSancion","number",'Sanciones: <br>',"0","Sanciones","black","onkeyup","CalculeTotalImpuestos()",150,30,0,1);
						print("<br>");
						$css->CrearInputText("TxtIntereses","number",'Intereses: <br>',"0","Intereses","black","onkeyup","CalculeTotalImpuestos()",150,30,0,1);
						print("<br>");
						$css->CrearInputText("TxtImpuesto","number",'Impuesto: <br>',"0","Sanciones","black","onkeyup","CalculeTotalImpuestos()",150,30,0,1);
						print("<br>");
						$css->CrearInputText("TxtTotal","number",'Total: <br>',"0","Sanciones","black","","",150,30,1,1);
						print("<br>");
												
					
					}
					
					if($TipoEgresos>3 or $TipoEgresos==2){
						
						print("<td>");
						$css->CrearInputText("TxtNumFactura","text",'Numero de Factura:<br>',"","Numero de Comprobante","black","","",300,30,0,1);
                                                //echo"<br>";
                                                $css->CrearUpload("foto");
						print("</td>");
						print("<td>");
						$css->CrearInputText("TxtSubtotal","number",'Subtotal: <br>',"","SubTotal","black","onkeyup","CalculeTotal()",150,30,0,1);
						print("<br>");
						$css->CrearInputText("TxtIVA","number",'IVA:<br>',"0","IVA","IVA","onkeyup","CalculeTotal()",150,30,0,1);
						$css->CrearSelect("CmbIVADes","","black","",1);
						$css->CrearOptionSelect(2408,"Descontable",1);		
						$css->CrearOptionSelect(521570,"No Descontable",0);		
						$css->CerrarSelect();
						print("<br>");
						$css->CrearInputText("TxtTotal","number",'Total:<br>',"","Total","black","","",150,30,1,1);
						print("<br>");
						
						print("Aplicar retenciones?<br>");
                                                $css->CrearSelect("CmbRetenciones", "MuestraOculta('DivRetenciones')");
                                                    $css->CrearOptionSelect("NO", "NO", 0);
                                                    $css->CrearOptionSelect("SI", "SI", 0);
                                                $css->CerrarSelect();
                                                print("<br>");
					}
					
					$css->CrearDiv("DivRetenciones", "container", "left", 0, 1);
                                            $css->CrearInputNumber("TxtRetefuente", "number", "Retefuente:<br>", 0, "", "black", "", "", 150, 30, 0, 1, 0, "", "any");
                                             print("<br>");
                                            $css->CrearInputNumber("TxtReteICA", "number", "Rete-ICA:<br>", 0, "", "black", "", "", 150, 30, 0, 1, 0, "", "any");
                                             print("<br>");
                                            $css->CrearInputNumber("TxtReteIVA", "number", "ReteIVA:<br>", 0, "", "black", "", "", 150, 30, 0, 1, 0, "", "any");
                                             print("<br>");
                                        $css->CerrarDiv();
					
					$css->CrearBotonConfirmado("BtnGuardarEgreso","Guardar");	
						print("</td>");
					
					$css->CierraFilaTabla();
					
					//$css->CierraFilaTabla();
					$css->CerrarTabla(); 
					$css->CerrarForm();
					
				}else{
				
					$css->CrearTabla();
					$css->CrearFilaNotificacion("No se ha seleccionado un tipo de egreso",16);
					$css->CerrarTabla(); 		
					}	
				
}
				////////////////////////////////////Si se solicita buscar un cliente
	
	if(!empty($_REQUEST["TxtBuscarProveedor"])){
		
		$Key=$_REQUEST["TxtBuscarProveedor"];
		$pa=mysql_query("SELECT * FROM proveedores WHERE RazonSocial LIKE '%$Key%' OR Num_Identificacion LIKE '%$Key%' LIMIT 10") or die(mysql_error());
		if(mysql_num_rows($pa)){
			print("<br>");
			$css->CrearTabla();
			$css->FilaTabla(18);
			$css->ColTabla("Proveedores Encontrados para Asociar:",3);
			$css->CierraFilaTabla();
			
			while($DatosCliente=mysql_fetch_array($pa)){
				$css->FilaTabla(14);
				$css->ColTabla($DatosCliente['RazonSocial'],1);
				$css->ColTabla($DatosCliente['Num_Identificacion'],1);
				$css->ColTablaVar($myPage,"TxtAsociarProveedor",$DatosCliente['idProveedores'],$TipoEgresos,"Asociar Proveedor");
				$css->CierraFilaTabla();
			}
			
			$css->CerrarTabla(); 
		}else{
			print("<h3>No hay resultados</h3>");
		}
		
	}
			?>
                    		
</div> <!-- /container -->
     

    
<?php 
$css->AgregaJS();
$css->AnchoElemento("CmbCodMunicipio_chosen", 200);
?>

<a style="display:scroll; position:fixed; bottom:10px; right:10px;" href="#" title="Volver arriba"><img src="../images/up1_amarillo.png" /></a>

	
 
  </body>
  
  
</html>

