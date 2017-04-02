<?php
$myPage="MnuInventarios.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");	

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
                $css->SubMenuAlfa("Bodegas",3);
                $css->SubMenuAlfa("Movimientos",4);
                $css->SubMenuAlfa("General",5);
                
	$css->MenuAlfaFin();
            
	$css->IniciaTabs();

            $css->NuevaTabs(1);
                $css->SubTabs("../VAtencion/productosventa.php","_self","../images/productosventa.png","Productos para la venta");
                $css->SubTabs("../VAtencion/productosalquiler.php","_self","../images/alquiler.png","Productos para alquilar");
                $css->SubTabs("../VAtencion/servicios.php","_self","../images/servicios.png","Servicios para la venta");
                $css->SubTabs("../VAtencion/ordenesdecompra.php","_self","../images/ordendecompra.png","Ordenes de Compra");
                $css->SubTabs("../VAtencion/kardexmercancias.php","_self","../images/kardex.png","Kardex");
                $css->SubTabs("../VAtencion/relacioncompras.php","_self","../images/compras.png","Historial de Compras");
                $css->SubTabs("../VAtencion/prod_codbarras.php","_blank","../images/codigobarras.png","Agregar o Editar codigos de barras");
                  
                $css->SubTabs("MnuTraslados.php","_self","../images/traslados.png","Traslados");
                $css->SubTabs("../VAtencion/AgregarItemsXCB.php","_blank","../images/csv.png","Agregar Productos desde CSV");
                //$css->SubTabs("../VAtencion/CompraEquipos.php","_blank","../images/activos.png","Activos");
            $css->FinTabs();
            $css->NuevaTabs(2);    
                $css->SubTabs("../VAtencion/prod_departamentos.php","_blank","../images/departamentos.png","Crear Departamentos");
                $css->SubTabs("../VAtencion/prod_sub1.php","_blank","../images/uno.png","Subgrupo 1");
                $css->SubTabs("../VAtencion/prod_sub2.php","_blank","../images/dos.png","Subgrupo 2");
                $css->SubTabs("../VAtencion/prod_sub3.php","_blank","../images/tres.png","Subgrupo 3");
                $css->SubTabs("../VAtencion/prod_sub4.php","_blank","../images/cuatro.jpg","Subgrupo 4");
                $css->SubTabs("../VAtencion/prod_sub5.php","_blank","../images/cinco.png","Subgrupo 5");
                
            $css->FinTabs();
            
            $css->NuevaTabs(3);    
                $css->SubTabs("../VAtencion/bodega.php","_blank","../images/bodega.png","Ver/Crear/Editar Bodega");  
                $css->SubTabs("../VAtencion/bodegas_externas.php","_blank","../images/externas.png","Ver Bodegas Externas");  
            $css->FinTabs();
            
            $css->NuevaTabs(4);
                $css->SubTabs("../VAtencion/prod_bajas_altas.php","_blank","../images/historial.png","Ver el historial de las bajas y altas");  
                $css->SubTabs("../VAtencion/DarBajaAlta.php","_blank","../images/baja.png","Dar de baja o alta a un producto"); 
                $css->SubTabs("../VAtencion/inventario_preparacion.php","_blank","../images/terminado.png","Preparar Conteo Fisico");
                $css->SubTabs("../VAtencion/inventarios_temporal.php","_blank","../images/pedidos.png","Tabla Temporal");
                $css->SubTabs("../VAtencion/inventario_fisico.php","_blank","../images/inventorio.png","Realizar Inventario Fisico");
            $css->FinTabs();
            $css->NuevaTabs(5);
                $css->SubTabs("../VAtencion/ActualizacionesGeneralesInventarios.php","_blank","../images/actualizar.png","Actualizaciones Generales");  
                
                
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