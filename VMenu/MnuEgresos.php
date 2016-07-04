<!DOCTYPE html>
<script src="js/funciones.js"></script>
<html lang="es">
     <head>
	 <title>SoftContech</title>
     <meta charset="utf-8">
	 
	 
	 
	 <?php
	 session_start();
         $TipoUser=$_SESSION["tipouser"];

        if($TipoUser=="comercial"){
   
            header("Location: Menu.php");
        }
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
 
	$css->IniciaMenu("Egresos"); 
	$css->MenuAlfaIni("Egresos");
		
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();

            $css->NuevaTabs(1);
                $css->SubTabs("../VAtencion/egresos.php","_blank","../images/historial.png","Historial Egresos");
                $css->SubTabs("../VAtencion/notascontables.php","_blank","../images/historial3.png","Historial Notas Contables");
                $css->SubTabs("../VAtencion/Egresos2.php","_blank","../images/egresos.png","Registrar Gasto");
                
                $css->SubTabs("../VAtencion/CompraMercancias.php","_blank","../images/compramercancias.png","Comprar Mercancias o Equipos");    //Uso Futuro
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