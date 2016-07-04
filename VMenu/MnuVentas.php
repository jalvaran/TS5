<?php
session_start();
?>
<!DOCTYPE html>
<script src="js/funciones.js"></script>
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
	if ($_SESSION['tipouser']<>"administrador")
	{
	  exit("Usted No esta autorizado para ingresar a esta parte <a href='Menu.php' >Menu </a>");
	  
	}
	$NombreUser=$_SESSION['nombre'];
	$idUser=$_SESSION['idUser'];	
	
	 ?>
       
     </head>
     <body  class="">

<!--==============================header=================================-->

 <?php 
	$myPage="MnuVentas.php";
	$css =  new CssIni();

	$css->CabeceraIni(); 
	//$css->BlockMenuIni(); 
	$css->CabeceraFin(); 
	
 ?>
 
 
 

<!--==============================Content=================================-->

<div class="content"><div class="ic">TECHNO SOLUCIONES SAS</div>
  
    
	<?php 
 
	$css->IniciaMenu("Gestión de Ventas"); 
	$css->MenuAlfaIni("Ventas");
		
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();

		$css->NuevaTabs(1);
                    $css->SubTabs("../VAtencion/cotizacionesv5.php","_blank","../images/historial.png","Historial Cotizaciones");
                    $css->SubTabs("../VAtencion/Cotizaciones.php","_blank","../images/cotizacion.png","Cotizar");
                    $css->SubTabs("../VAtencion/VentasRapidas.php","_blank","../images/vender.png","Ventas Rapidas");
                    //$css->SubTabs("../VAtencion/subcuentas.php","_blank","../images/factura.png","Imprimir una Factura");
                    $css->SubTabs("../VAtencion/Remisiones.php","_blank","../images/remision.png","Remisiones");
                    $css->SubTabs("../VAtencion/Devoluciones.php","_blank","../images/devolucion2.png","Ajuste Remision");
                    //$css->SubTabs("../VAtencion/facturas_items.php","_blank","../images/buscar.png","Buscar Item");
                    //$css->SubTabs("../VAtencion/cuentasfrecuentes.php","_blank","../images/devolucion.png","Devoluciones en Ventas");
                    //$css->SubTabs("../VAtencion/cuentasfrecuentes.php","_blank","../images/cerrarturno.png","Cerrar Turno");
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