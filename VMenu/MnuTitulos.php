<?php
$myPage="MnuTitulos.php";
include_once("../sesiones/php_control.php");
?>
<!DOCTYPE html>
<script src="js/funciones.js"></script>
<html lang="es">
     <head>
	 <title>SoftContech</title>
     <meta charset="utf-8">
	 
	 
	 
	 <?php
	
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
 
	$css->IniciaMenu("Titulos, Rifas y concursos"); 
	$css->MenuAlfaIni("Titulos");            
               
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();
	
		$css->NuevaTabs(1);
			
                    $css->SubTabs("../VAtencion/titulos_promociones.php","_self","../images/promociones.png","Promociones");
                    $css->SubTabs("../VAtencion/listados_titulos.php","_self","../images/inventarios_titulos.png","Inventario de Titulos");
                    $css->SubTabs("../VAtencion/titulos_asignaciones.php","_self","../images/acta.png","Historial de Actas de Entrega");
                    $css->SubTabs("../VAtencion/VentasTitulos.php","_blank","../images/ventastitulos.png","Venta de Titulos");
                    $css->SubTabs("../VAtencion/titulos_ventas.php","_self","../images/historial.png","Historial de Venta de Titulos");
                    $css->SubTabs("../VAtencion/titulos_devoluciones.php","_self","../images/historial2.png","Historial de Titulos Devueltos");
                    $css->SubTabs("../VAtencion/titulos_cuentasxcobrar.php","_self","../images/cuentasxcobrar.png","Cuentas X Cobrar");
                    $css->SubTabs("../VAtencion/titulos_comisiones.php","_self","../images/comisiones.png","Comisiones");
                    $css->SubTabs("../VAtencion/titulos_traslados.php","_self","../images/traslado.png","Historial de Traslados");
                    $css->SubTabs("../VAtencion/InformeTitulos.php","_self","../images/informes.png","Informes");
                $css->FinTabs();
			
	$css->FinMenu(); 
	
	?>
    
  
 </div>

  
<!--==============================footer=================================-->
<?php 

	$css->Footer();
	
?>

</body>

</html>