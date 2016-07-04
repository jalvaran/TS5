 <!-- Main hero unit for a primary marketing message or call to action -->
      <!--<div class="hero-unit" align="center">
        	<img src="img/banner.jpg" class="img-polaroid">
      <!--</div>

      <!--<!-- Example row of columns -->
	  
	  <script src="js/funciones.js"></script>
      <div class="row">
      	
      </div>
  
<h2 align="center">
					<?php 
					error_reporting(0);
					session_start();
					
					$idUser=$_SESSION['idUser'];
					include_once("../modelo/php_conexion.php");
					
					?></h2>
               		<table class="table table-bordered" >
                      <tr>
                        <td>
                        	<table class="table table-bordered table table-hover" >
                            <?php 
								$neto=0;$tneto=0;
								$pa=mysql_query("SELECT * FROM atencion_pedidos ap INNER JOIN productosventa pv ON ap.Prod_Referencia=pv.Referencia
												INNER JOIN prod_comicalenias pc ON pv.Departamento=pc.Departamento_Comi
												WHERE Usuarios_idUsuarios='$idUser' AND Mesas_idMesas = '$_SESSION[idMesaActiva]'") 
								or die(mysql_error());				
								while($row=mysql_fetch_array($pa)){
									//$oProducto=new Consultar_Producto($row['Prod_Referencia']);
									$neto=$row['Prod_Cantidad']*($row['PrecioVenta']+$row['FichasModelos']+$row['ShowsModelos']+$row['Administrador']);
									$tneto=$tneto+$neto;
									
							?>
                              <tr style="font-size:14px">
                                <td><?php echo $row['Nombre']; ?></td>
                                <td><?php echo $row['Prod_Cantidad']; ?></td>
                                <td>$ <?php echo number_format($neto); ?></td>
                                <td>
                                	<a href="index.php?del=<?php echo $row['Prod_Referencia']; ?>" title="Eliminar de la Lista">
                                		<i class="icon-remove"></i>
                                    </a>
                                </td>
                              </tr>
                            <?php }
							?>
                            	<td colspan="4" style="font-size:20px;color:red"><div align="right">$<?php echo number_format($tneto); ?></div></td>
                            <?php 
								$pa=mysql_query("SELECT * FROM atencion_pedidos WHERE Usuarios_idUsuarios='$idUser' AND Mesas_idMesas = '$_SESSION[idMesaActiva]'");				
								if(!$row=mysql_fetch_array($pa)){
							?>
                              <tr><div class="alert alert-success" align="center"><strong>No hay Productos Agregados</strong></div></tr>
							  <?php } ?>
                            </table>
                        </td>
                      </tr>
					 
                    
					
<script>refrescaMesas(1000);</script>
 </table>