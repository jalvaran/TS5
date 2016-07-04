

<?php 	
	session_start();
	
include_once("../modelo/php_conexion.php");

if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}
$NombreUser=$_SESSION['nombre'];

$idUser=$_SESSION['idUser'];	

	
	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysql_query("DELETE FROM atencion_pedidos WHERE idPedidos='$id'");
		header('location:pedidos.php');
	}
	
	
	if(!empty($_REQUEST['BtnPagar'])){
		$fecha=date("Y-m-d");
		$Hora=date("H:i:s");
		$idMesa=$_REQUEST['TxtidMesa'];
		$idMesero=$_REQUEST['TxtidUsuario'];
		
		$obVenta=new ProcesoVenta($idUser);
		list($NumCotizacion, $NumVenta, $NumFactura)=$obVenta->ObtengaDatosEspacio(); //Verifico si hay espacios en venta activa para empezar a vender
		
		if(!$NumCotizacion>0){
			list($NumCotizacion, $NumVenta, $NumFactura)=$obVenta->ObtengaEspacioVenta();// si no hay espacio lo crea
		}
		
		$obVenta->AdminRegVenta($fecha,$Hora,$idMesa,$idMesero,$NumCotizacion,$NumVenta,$NumFactura,1,$idUser);
		list($Subtotal,$Impuestos,$Total,$TotalCostos,$TotalComisiones,$GranTotal)=$obVenta->ObtengaTotalesVenta($NumVenta);
		

		///////////////////////////Ingresar a Facturas 
			
		$TipoVenta="Contado";
		$EmpresaPro=1;
		$idCliente=1;
		$tab="facturas";
		$NumRegistros=15;  
							
		
		$Columnas[0]="Fecha";						$Valores[0]=$fecha;
		$Columnas[1]="FormaPago";					$Valores[1]=$TipoVenta;
		$Columnas[2]="Subtotal";					$Valores[2]=$Subtotal;
		$Columnas[3]="IVA";							$Valores[3]=$Impuestos;
		$Columnas[4]="Descuentos";					$Valores[4]=0;
		$Columnas[5]="Total";						$Valores[5]=$Total;
		$Columnas[6]="SaldoFact";					$Valores[6]=$Total;
		$Columnas[7]="Cotizaciones_idCotizaciones";	$Valores[7]=$NumCotizacion;
		$Columnas[8]="EmpresaPro_idEmpresaPro";		$Valores[8]=$EmpresaPro;
		$Columnas[9]="Usuarios_idUsuarios";			$Valores[9]=$idUser;
		$Columnas[10]="Clientes_idClientes";		$Valores[10]=$idCliente;
		$Columnas[11]="OSalida";					$Valores[11]=$NumVenta;
		$Columnas[12]="TotalCostos";			    $Valores[12]=$TotalCostos;
		$Columnas[13]="idFacturas";			    	$Valores[13]=$NumFactura;
		$Columnas[14]="TotalComisiones";			$Valores[14]=$TotalComisiones;
		
		$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		///////////////////////////////////////////////////////////////////////////////////////////////////
		
		
		///se registra en el libro diario, las Variables estan inicializadas en el archivo php_conexion
		
		$obVenta->RegFactLibroDiario($NumFactura,$CuentaDestino,$CuentaIngresos,$TablaCuentaIngreso,$CuentaIVAGen, $TablaIVAGen, $CuentaCostoMercancia,$CuentaInventarios,$AjustaInventario,$RegCREE);
		$obVenta->BorraPedido($idMesa,$idMesero);
		
		$RutaRetorno="../VAtencion/pedidos.php";
		//$obVenta->ImprimeFactura($NumFactura,$COMPrinter,$PrintCuenta,$RutaRetorno);
		
			
	}
	
	
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Admin Pedidos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Software de Techno Soluciones Vista Administrador">
    <meta name="author" content="Techno Soluciones SAS">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
								   
								   
								   <script src="js/jquery.min.js"></script>
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">SoftConTech</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
                <li class="active"><a href="pedidos.php">Pedidos</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div id="contenido" class="container" >
	
		<?php include("contpedidos.php");	?>

    </div> <!-- /container -->
	<footer align ="center">
        <p>&copy; Techno Soluciones SAS 2015</p>
      </footer>
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
