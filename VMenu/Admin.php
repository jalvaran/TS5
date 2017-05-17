<?php
$myPage="Admin.php";
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
 
	$css->IniciaMenu("Administar"); 
	$css->MenuAlfaIni("Empresa");
		$css->SubMenuAlfa("Usuarios",2);
		$css->SubMenuAlfa("Impuestos",3);
		$css->SubMenuAlfa("Colaboradores",4);
		$css->SubMenuAlfa("Descuentos",5);
		$css->SubMenuAlfa("Finanzas",6);
		$css->SubMenuAlfa("Informes",7);
                $css->SubMenuAlfa("Hardware",8);
               
	$css->MenuAlfaFin();
	
	$css->IniciaTabs();
	
		$css->NuevaTabs(1);
			$css->SubTabs("../VAtencion/empresapro.php","_self","../images/empresa.png","Crear/Editar Empresa");
                        $css->SubTabs("../VAtencion/empresa_pro_sucursales.php","_self","../images/sucursal.png","Crear/Editar Sucursal");
                        $css->SubTabs("../VAtencion/empresapro_resoluciones_facturacion.php","_self","../images/resolucion.png","Resoluciones de Facturacion");
                        $css->SubTabs("../VAtencion/formatos_calidad.php","_self","../images/notacredito.png","Formatos de Calidad");
                        $css->SubTabs("../VAtencion/centrocosto.php","_self","../images/centrocostos.png","Crear Centro de Costos");
                        $css->SubTabs("../VAtencion/cajas.php","_self","../images/cajas.png","Crear/Editar Cajas");
                        $css->SubTabs("../VAtencion/config_tiketes_promocion.php","_self","../images/tiketes.png","Configurar Tikete de Promocion");
                        $css->SubTabs("../VAtencion/costos.php","_self","../images/costos.png","Costos operativos");
		$css->FinTabs();
		$css->NuevaTabs(2);
			$css->SubTabs("../VAtencion/usuarios.php","_self","../images/usuarios.png","Crear/Editar un Usuario");
                        $css->SubTabs("../VAtencion/usuarios_tipo.php","_self","../images/usuariostipo.png","Crear/Editar un Tipo de Usuario");
                        $css->SubTabs("../VAtencion/HabilitarUser.php","_self","../images/autorizarcajas.png","Asignar usuarios a cajas");
                        
		$css->FinTabs();
		$css->NuevaTabs(3);
			$css->SubTabs("../VAtencion/impret.php","_self","../images/impuestos.png","Crear/Editar un impuesto o una retencion");
		$css->FinTabs();
		$css->NuevaTabs(4);
			$css->SubTabs("../VAtencion/colaboradores.php","_self","../images/colaboradores.png","Crear/Editar");
		$css->FinTabs();
		$css->NuevaTabs(5);
			$css->SubTabs("../VAtencion/fechas_descuentos.php","_self","../images/descuentos.png","Crear/Editar");
		$css->FinTabs();
		$css->NuevaTabs(6);
			$css->SubTabs("../VAtencion/librodiario.php","_blank","../images/librodiario.png","Libro Diario");
			$css->SubTabs("../VAtencion/facturas.php","_blank","../images/facturas.png","Historial de Facturación");
			$css->SubTabs("../VAtencion/subcuentas.php","_blank","../images/cuentas.png","Cuentas");
			$css->SubTabs("../VAtencion/cuentasfrecuentes.php","_blank","../images/cuentasfrecuentes.png","Cuentas Frecuentes");
		$css->FinTabs();
                $css->NuevaTabs(7);
			$css->SubTabs("../VAtencion/InformeVentasAdmin.php","_self","../images/informes2.png","Crear/Editar");
		$css->FinTabs();
                $css->NuevaTabs(8);
			$css->SubTabs("../VAtencion/config_puertos.php","_blank","../images/configuracion.png","Configurar puertos comunicacion");
		$css->FinTabs();
		//$css->NuevaTabs(7);
		//	$css->SubTabs("../VAtencion/InformeAdministracion.php","_blank","../images/informes.png","Informes");
		//	$css->SubTabs("../VAtencion/HabilitarUser.php","_blank","../images/CerrarCajas.png","Habilitar Cajas");
		//$css->FinTabs();
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