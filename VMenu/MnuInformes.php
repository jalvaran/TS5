<?php
$myPage="MnuInformes.php";
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
 
	$css->IniciaMenu("Informes"); 
	$css->MenuAlfaIni("Financieros");
		$css->SubMenuAlfa("Reporte de Ventas",2);
		$css->SubMenuAlfa("Otros",3);
		
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();
	
		$css->NuevaTabs(1);
			$css->SubTabs("../VAtencion/BalanceComprobacion.php","_blank","../images/resultados.png","Balance General y Estado de Resultados");
                        //$css->SubTabs("../VAtencion/BalanceGeneral.php","_blank","../images/resultados.png","Balance General y Estado de Resultados");
		$css->FinTabs();
		$css->NuevaTabs(2);
			$css->SubTabs("../VAtencion/InformeVentas.php","_blank","../images/infventas.png","Informe de Ventas");
		$css->FinTabs();
		$css->NuevaTabs(3);
			$css->SubTabs("../VAtencion/OtrosInformes.php","_blank","../images/otrosinformes.png","Otros Informes");
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