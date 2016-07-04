<!DOCTYPE html>
<script src="js/funciones.js"></script>
<html lang="es">
     <head>
	 <title>SoftContech</title>
     <meta charset="utf-8">
	 
	 
	 
	 <?php
	 session_start();

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
	$myPage="MnuIngresos.php";
	$css =  new CssIni();

	$css->CabeceraIni(); 
	//$css->BlockMenuIni(); 
	$css->CabeceraFin(); 
	
 ?>
 
 
 

<!--==============================Content=================================-->

<div class="content"><div class="ic">TECHNO SOLUCIONES SAS</div>
  
    
	<?php 
 
	$css->IniciaMenu("Ingresos"); 
	$css->MenuAlfaIni("Ingresos");
		
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();

            $css->NuevaTabs(1);
                $css->SubTabs("../VAtencion/comprobantes_ingreso.php","_blank","../images/historial3.png","Historial Comprobantes Ingreso");
                $css->SubTabs("../VAtencion/RegistrarIngreso.php","_blank","../images/pago.jpg","Registrar Pago");
                $css->SubTabs("../VAtencion/ComprobantesIngreso.php","_blank","../images/ingreso.jpg","Registrar Ingreso");
                $css->SubTabs("../VAtencion/RegistrarAnticipos.php","_blank","../images/Anticipos.png","Anticipos");    //Uso Futuro
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