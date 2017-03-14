<?php
    $myPage="MnuEgresos.php";
   include_once("../sesiones/php_control.php");
   include_once("css_construct.php");

   $NombreUser=$_SESSION['nombre'];


    ?>
<!DOCTYPE html>
<script src="js/funciones.js"></script>
<html lang="es">
     <head>
	 <title>TS5</title>
     <meta charset="utf-8">
	 
	 
	 
	 
       
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
 
	$css->IniciaMenu("Egresos"); 
	$css->MenuAlfaIni("Egresos");
		
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();

            $css->NuevaTabs(1);
                $css->SubTabs("../VAtencion/egresos.php","_blank","../images/historial.png","Historial Egresos");
                $css->SubTabs("../VAtencion/notascontables.php","_blank","../images/historial3.png","Historial Notas Contables");
                $css->SubTabs("../VAtencion/Egresos2.php","_blank","../images/compramercancias.png","Registrar Gasto o Compra");
                $css->SubTabs("../VAtencion/compras_activas.php","_blank","../images/historial4.png","Historial de Compras Activas");
                $css->SubTabs("../VAtencion/ComprobantesEgresoLibre.php","_blank","../images/precuenta.png","Realizar un comprobante de Egreso Libre");
                //$css->SubTabs("../VAtencion/CompraMercancias.php","_blank","../images/compramercancias.png","Comprar Mercancias o Equipos");    //Uso Futuro
                //$css->SubTabs("../VAtencion/CompraEquipos.php","_blank","../images/equipos.png","Comprar Equipos");//Uso Futuro
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