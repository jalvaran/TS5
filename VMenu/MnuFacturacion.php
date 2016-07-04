<?php
ob_start();
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
	
	$NombreUser=$_SESSION['nombre'];
	$idUser=$_SESSION['idUser'];	
	
	 ?>
       
     </head>
     <body  class="">

<!--==============================header=================================-->

 <?php 
	$myPage="MnuFacturacion.php";
	$css =  new CssIni();

	$css->CabeceraIni(); 
	//$css->BlockMenuIni(); 
	$css->CabeceraFin(); 
	
 ?>
 
 
 

<!--==============================Content=================================-->

<div class="content"><div class="ic">TECHNO SOLUCIONES SAS</div>
  
    
	<?php 
 
	$css->IniciaMenu("Gestión de Facturación"); 
	$css->MenuAlfaIni("Facturación");
		
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();

            $css->NuevaTabs(1);
                $css->SubTabs("../VAtencion/facturas.php","_blank","../images/factura.png","Historial de Facturas");
                $css->SubTabs("../VAtencion/notascredito.php","_blank","../images/historial3.png","Historial de Notas Credito");
                $css->SubTabs("../VAtencion/FactCoti.php","_blank","../images/cotizacion.png","Facturar desde Cotización");
                //$css->SubTabs("../VAtencion/FactRemi.php","_blank","../images/Remision.png","Facturar desde Remisión");    //Uso Futuro
                //$css->SubTabs("../VAtencion/FactDevo.php","_blank","../images/devolucion.png","Facturar desde Devolución");//Uso Futuro
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