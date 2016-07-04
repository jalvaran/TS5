<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
     <head>
	 <title>SoftContech</title>
     <meta charset="utf-8">
	 <?php
	 

	include_once("../modelo/php_conexion.php");
	include_once("css_construct.php");

	if (!isset($_SESSION['username']))
	{
	  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
	  
	}

	$NombreUser=$_SESSION['nombre'];
	$idUser=$_SESSION['idUser'];	
	
	 ?>
       
     </head>
     <body  class="">

<!--==============================header=================================-->

 <?php 
 
	$css =  new CssIni();

	$css->CabeceraIni(); 
	//$css->BlockMenuIni(); 
	$css->CabeceraFin(); 
	
 ?>
 
 
 

<!--==============================Content=================================-->

<div class="content"><div class="ic">TECHNO SOLUCIONES SAS</div>
  
    
	<?php 
 
	$css->IniciaMenu("Bienvenido $NombreUser que deseas hacer?"); 
	$css->MenuAlfaIni("Menu");
	//$css->SubMenuAlfa("Otro",2);
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();
		$css->NuevaTabs(1);
			$css->SubTabs("Admin.php","_blank","../images/admin.png","Administrar");
			$css->SubTabs("MnuVentas.php","_blank","../images/ventas.png","Ventas");
			$css->SubTabs("MnuFacturacion.php","_blank","../images/facturar.png","Facturación");
			$css->SubTabs("../VAtencion/cartera.php","_blank","../images/cartera.png","Cartera");
			$css->SubTabs("MnuIngresos.php","_blank","../images/ingresos.png","Ingresos");
			$css->SubTabs("MnuEgresos.php","_blank","../images/egresos.png","Egresos");
                        $css->SubTabs("../VAtencion/CreaComprobanteCont.php","_blank","../images/egresoitems.png","Comprobantes Contables");
			$css->SubTabs("../VAtencion/clientes.php","_blank","../images/clientes.png","Clientes");
			$css->SubTabs("../VAtencion/proveedores.php","_blank","../images/proveedores.png","Proveedores");
			//$css->SubTabs("../VAtencion/CuentasXCobrar.php","_blank","../images/cuentasxcobrar.png","Cuentas Por Cobrar");
                        $css->SubTabs("../VAtencion/CuentasXPagar.php","_blank","../images/cuentasxpagar.png","Cuentas Por Pagar");
			$css->SubTabs("MnuInventarios.php","_blank","../images/inventarios.png","Inventarios");
                        $css->SubTabs("../VAtencion/ordenesdetrabajo.php","_blank","../images/ordentrabajo.png","Ordenes de servicio");
			$css->SubTabs("MnuInformes.php","_blank","../images/informes.png","Informes");
			$css->SubTabs("../destruir.php","_self","../images/salir.png","Salir");
			
	
	$css->FinTabs();
	$css->FinMenu(); 	
	?>
    
  
 </div>

<!--==============================footer=================================-->
<?php 

	$css->Footer();
	
?>

       <script>
      $(document).ready(function(){ 
         $(".bt-menu-trigger").toggle( 
          function(){
            $('.bt-menu').addClass('bt-menu-open'); 
          }, 
          function(){
            $('.bt-menu').removeClass('bt-menu-open'); 
          } 
        ); 
      }) 
    </script>
</body>

</html>