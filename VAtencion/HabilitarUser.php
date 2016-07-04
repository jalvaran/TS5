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

if ($_SESSION['tipouser']=="operador")
{
  exit("Usted no tiene permisos para habilitar Usuarios");
  
}

$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	

if(!empty($_REQUEST['TxtHabilitarUser'])){
		$idItem=$_REQUEST['TxtIdPre'];
		$obVenta=new ProcesoVenta($idItem);
		$obVenta->ActualizaRegistro("usuarios","Role", $_REQUEST['TxtHabilitarUser'], "idUsuarios", $idItem);
		if($_REQUEST['TxtHabilitarUser']=="FACTURA"){ 
			
			$obVenta->AsignarEspacioDisponible($idItem);
		}else{
			$obVenta->BorraReg("vestasactivas","Usuario_idUsuario",$idItem);
			
			
		}
		
		
	header("location:HabilitarUser.php");
	}
	
	if(!empty($_REQUEST['ImgCerrarCajas'])){
		
		$obVenta=new ProcesoVenta($idUser);
		$obVenta->VaciarTabla("vestasactivas");// Crea otra preventa
		$obVenta->InicializarPreventas();
		header("location:HabilitarUser.php");
	}
?>
 
<!DOCTYPE html>
<html>
  
	<head>
	
	 <?php $css =  new CssIni("Habilitar Usuarios"); ?>
	</head>
 
	<body>
   
	 <?php 
	 $myPage="HabilitarUser.php";
	 $css->CabeceraIni("SoftConTech Habilitar Usuarios"); 
	 $css->CabeceraFin(); 
	 
	 $obVenta=new ProcesoVenta($idUser);
	  
	  
	 ?>
	

	

	
    <div class="container">
	<br>
	
	
     	  
	  <div id="Usuarios" class="container" >
	
		<h2 align="center">
					<?php 
					
						
						/////////////////////////////////////Se dibuja los usuarios
						
					print("Cerrar Cajas");							
					$imagerute="../images/CerrarCajas.png";
					$Ruta=$myPage."?ImgCerrarCajas=1";			
					$css->CrearImageLink($Ruta,$imagerute,"_self",200,200);
					
					?></h2>
               		<table class="table table-bordered" >
                      <tr>
                        <td>
                        	
                            <?php 
								
								$css->CrearTabla();
								
								$pa=mysql_query("SELECT * FROM usuarios ORDER BY idUsuarios DESC") or die(mysql_error());
								if(mysql_num_rows($pa)){	
									
									$css->FilaTabla(18);
									$css->ColTabla('ID',1);
									$css->ColTabla('Nombres',1);
									$css->ColTabla('Apellidos',1);
									$css->ColTabla('Habilitar/Deshabilitar',1);
									
									$css->CierraFilaTabla();
									
								while($row=mysql_fetch_array($pa)){
									$css->FilaTabla(14);
									$css->ColTabla($row['idUsuarios'],1);
									$css->ColTabla($row['Nombre'],1);
									$css->ColTabla($row['Apellido'],1);
									if($row['Role']<>"FACTURA"){
										$Variable="TxtHabilitarUser";
										$Value="FACTURA";
										$Title="Habilitar";
									}else{
										
										$Variable="TxtHabilitarUser";
										$Value="N";
										$Title="Deshabilitar";
									}
									$idPre=$row['idUsuarios'];
									$css->ColTablaVar($myPage,$Variable,$Value,$idPre,$Title);
									
									$css->CierraFilaTabla();
									
							?>
                              
                                
                              </tr>
                           
                            	
                            <?php } } $css->CerrarTabla();
								
							?>
                              
							 
                           
                        </td>
                      </tr>
		</table>
		
		<?php 
								
			$css->CrearTabla();
			$css->FilaTabla(18);
			$css->ColTabla('PREVENTAS ABIERTAS',7);
			$css->CierraFilaTabla();
			$pa=mysql_query("SELECT * FROM vestasactivas") or die(mysql_error());
			if(mysql_num_rows($pa)){	
							
				$css->FilaTabla(18);
				$css->ColTabla('ID',1);
				$css->ColTabla('Nombre',1);
				$css->ColTabla('Usuario',1);
				$css->ColTabla('Num Factura',1);
				$css->ColTabla('Num Venta',1);
				$css->ColTabla('Num Cotizacion',1);
				$css->ColTabla('Saldo a Favor',1);
				$css->CierraFilaTabla();
				
			while($row=mysql_fetch_array($pa)){
				$css->FilaTabla(14);
				$css->ColTabla($row['idVestasActivas'],1);
				$css->ColTabla($row['Nombre'],1);
				$css->ColTabla($row['Usuario_idUsuario'],1);
			    $css->ColTabla($row['NumFactura'],1);
				$css->ColTabla($row['NumVenta'],1);	
				$css->ColTabla($row['NumCotizacion'],1);
				$css->ColTabla($row['SaldoFavor'],1);					
				$css->CierraFilaTabla();
				
				
			}
			}
			$css->CerrarTabla();
			?>

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
