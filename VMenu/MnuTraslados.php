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
	$myPage="MnuTraslados.php";
	$css =  new CssIni();

	$css->CabeceraIni(); 
	//$css->BlockMenuIni(); 
	$css->CabeceraFin(); 
	
 ?>
 
 
 

<!--==============================Content=================================-->

<div class="content"><div class="ic">TECHNO SOLUCIONES SAS</div>
  
    
	<?php 
 
	$css->IniciaMenu("Traslados"); 
            $css->MenuAlfaIni("Menu");
                $css->SubMenuAlfa("Seguimiento",2);	
	$css->MenuAlfaFin();
            
	$css->IniciaTabs();

            $css->NuevaTabs(1);
                $css->SubTabs("../VAtencion/traslados_mercancia.php","_blank","../images/historial.png","Historial");
                $css->SubTabs("../VAtencion/CreaTraslado.php","_blank","../images/nuevo.png","Nuevo");
                $css->SubTabs("../VAtencion/SubirTraslado.php","_blank","../images/upload.png","Subir Traslados");
                $css->SubTabs("../VAtencion/DescargarTraslados.php","_blank","../images/descargar.png","Descargar Traslados");
            $css->FinTabs();
            $css->NuevaTabs(2);    
                $css->SubTabs("../VAtencion/prod_departamentos.php","_blank","../images/departamentos.png","Crear Departamentos");
                //$css->SubTabs("../VAtencion/prod_departamentos.php","_blank","../images/uno.png","Subgrupo 1");
                //$css->SubTabs("../VAtencion/prod_departamentos.php","_blank","../images/dos.png","Subgrupo 2");
                //$css->SubTabs("../VAtencion/prod_departamentos.php","_blank","../images/tres.png","Subgrupo 3");
                //$css->SubTabs("../VAtencion/prod_departamentos.php","_blank","../images/cuatro.jpg","Subgrupo 4");
                //$css->SubTabs("../VAtencion/prod_departamentos.php","_blank","../images/cinco.png","Subgrupo 5");
                
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