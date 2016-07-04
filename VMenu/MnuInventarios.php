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
	$myPage="MnuInventarios.php";
	$css =  new CssIni();

	$css->CabeceraIni(); 
	//$css->BlockMenuIni(); 
	$css->CabeceraFin(); 
	
 ?>
 
 
 

<!--==============================Content=================================-->

<div class="content"><div class="ic">TECHNO SOLUCIONES SAS</div>
  
    
	<?php 
 
	$css->IniciaMenu("Inventarios"); 
            $css->MenuAlfaIni("Inventarios");
                $css->SubMenuAlfa("Clasificacion de Inventarios",2);	
	$css->MenuAlfaFin();
            
	$css->IniciaTabs();

            $css->NuevaTabs(1);
                $css->SubTabs("../VAtencion/productosventa.php","_blank","../images/productosventa.png","Productos para la venta");
                $css->SubTabs("../VAtencion/productosalquiler.php","_blank","../images/alquiler.png","Productos para alquilar");
                $css->SubTabs("../VAtencion/servicios.php","_blank","../images/servicios.png","Servicios para la venta");
                $css->SubTabs("../VAtencion/ordenesdecompra.php","_blank","../images/ordendecompra.png","Ordenes de Compra");
                $css->SubTabs("../VAtencion/kardexmercancias.php","_blank","../images/kardex.png","Kardex");
                //$css->SubTabs("../VAtencion/kits.php","_blank","../images/kits.png","Creacion de KITS");
                //$css->SubTabs("../VAtencion/CompraMercancias.php","_blank","../images/dardebaja.png","Dar de Baja");    
                //$css->SubTabs("../VAtencion/CompraEquipos.php","_blank","../images/codigobarras.png","Imprimir Codigos de Barra");
                //$css->SubTabs("../VAtencion/CompraEquipos.php","_blank","../images/ordenessalida.png","Ordenes de salida y entrada de activos");
                //$css->SubTabs("../VAtencion/CompraEquipos.php","_blank","../images/activos.png","Activos");
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