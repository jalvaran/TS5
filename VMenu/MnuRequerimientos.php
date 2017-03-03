<?php
$myPage="MnuRequerimientos.php";
include_once("../sesiones/php_control.php");
?>
<!DOCTYPE html>
<script src="js/funciones.js"></script>
<html lang="es">
     <head>
	 <title>TS5</title>
     <meta charset="utf-8">
	 
	 
	 
	 <?php
	

	
	include_once("css_construct.php");

	$NombreUser=$_SESSION['nombre'];
	
	
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
 
	$css->IniciaMenu("Gestion de Requerimientos"); 
	$css->MenuAlfaIni("Requerimientos");
            //$css->SubMenuAlfa("Configuracion",2);
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();

            $css->NuevaTabs(1);
                $css->SubTabs("../VAtencion/requerimientos_proyectos.php","_blank","../images/proyectos.png","Proyectos");
                //$css->SubTabs("../VAtencion/AtencionDomicilios.php","_blank","../images/atencion_domicilios.png","Atencion Domicilios");
                //$css->SubTabs("../VAtencion/Restaurante_Admin.php","_blank","../images/pedidos.png","Pedidos");
                
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

<?php
ob_end_flush();
?>