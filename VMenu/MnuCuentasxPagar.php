<?php
$myPage="MnuCuentasxPagar.php";
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
 
	$css->IniciaMenu("Cuentas X Pagar"); 
	$css->MenuAlfaIni("Cuentas x Pagar");
               
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();
	
		$css->NuevaTabs(1);
			$css->SubTabs("../VAtencion/cuentasxpagar_all.php","_self","../images/historial.png","Historial de Cuentas x Pagar");
                        $css->SubTabs("../VAtencion/cuentasxpagar.php","_self","../images/cuentasxpagar.png","Pagar");
                       // $css->SubTabs("../VAtencion/vista_compras_servicios.php","_self","../images/servicios_compras.png","Historial de Compras Servicios");
                        //$css->SubTabs("../VAtencion/RegistraCompra.php","_self","../images/compras.png","Registrar una Compra");
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