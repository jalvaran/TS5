 <!-- Main hero unit for a primary marketing message or call to action -->
      <!--<div class="hero-unit" align="center">
        	<img src="img/banner.jpg" class="img-polaroid">
      <!--</div>

      <!--<!-- Example row of columns -->
	  
	  <script src="js/funciones.js"></script>
      <div class="row">
      	
      </div>
      <div align="center">
      	<?php 
		include_once("../modelo/php_conexion.php");
		
				if(!empty($_POST['n_cant'])){
				$n_cant=$_POST['n_cant'];
				$n_codigo=$_POST['codigo'];
				$oProducto=new Consultar_Producto($n_codigo);
				mysql_query("UPDATE atencion_pedidos SET Prod_Cantidad='$n_cant' WHERE idPedidos='$n_codigo'");
				echo '<script>
					  alert("Cantidad Actualizada con Exito");
					</script>';
				/*
				echo '<div class="alert alert-success" align="center">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  <strong>Cantidad Actualizada con Exito</strong>
					</div>';
					*/
					header('location:pedidos.php');  //para que no reenvie la informacion
			}
			
		?>
      	<table class="table table-bordered">
          <tr class="info">
            <td><strong class="text-info">Articulo</strong></td>
            <td><div align="right"><strong class="text-info">Valor Unitario</strong></div></td>
            <td><center><strong class="text-info">Cantidad</strong></center></td>
            <td><div align="right"><strong class="text-info">Total</strong></div></td>
            <td><div align="center"><strong class="text-info">Del</strong></div></td>
          </tr>
          <?php 
		  	$total=0;$neto=0;
			$sql="SELECT *, pv.Nombre as PNombre, ap.Usuarios_idUsuarios as UsuarioPedido FROM atencion_pedidos ap INNER JOIN productosventa pv ON ap.Prod_Referencia=pv.Referencia
				INNER JOIN atencion_mesas am ON ap.Mesas_idMesas=am.idMesa
				INNER JOIN usuarios u ON ap.Usuarios_idUsuarios=u.idUsuarios
				INNER JOIN prod_comicalenias pc ON pv.Departamento=pc.Departamento_Comi 
				ORDER BY ap.Prioridad, ap.Mesas_idMesas";
				$i=0;
				$z=0;
				$MesaOld[0]=0;
				$MesaOld[1]=0;	
				$UsuarioPedido[0]=0;
				$UsuarioPedido[1]=0;				
		  	$pa=mysql_query($sql);
			if(mysql_num_rows($pa)){
            while($row=mysql_fetch_array($pa)){
				$MesaOld[$i]=$row["Mesas_idMesas"];
				$UsuarioPedido[$i]=$row["UsuarioPedido"];
				
					$ImageRuta=explode("/", $row['Imagen']);
					$PrecioFinal=$row['PrecioVenta']+$row['FichasModelos']+$row['ShowsModelos']+$row['Administrador'];
					$total=$PrecioFinal*$row['Prod_Cantidad'];
					$neto=$total+$neto;
					 if(($MesaOld[1]<>$MesaOld[0]) or ($UsuarioPedido[1]<>$UsuarioPedido[0])){
						
						
						if($z<>0){ 
							$MensajePaga='<tr class="info">
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td><div align="right"><strong>NETO A PAGAR</strong></div></td>
								<td><div align="right"><strong>$'.number_format($neto-$total).'</strong></div></td>
								<td><div align="center"><form name="FormPagaPedido" action="pedidos.php" method="post" target="_self">
									<input type="hidden" name="TxtidMesa" value="'.$OldMesa.'"></input>
									<input type="hidden" name="TxtidUsuario" value="'.$OldUser.'"></input>
									<input type="submit" name="BtnPagar" value="Facturar" class="btn btn-primary"></input>
									</form></div>
								</td>
							  </tr>';
							print($MensajePaga);
							$neto=$total;
						}
						
						$z++;
											 
						if($i==1)   
							$i=0;
						else
							$i=1;
						
						
		  ?>
		  
		  <tr><td colspan=5>
                	<div class="row-fluid" style="background-color: black; color:white;-webkit-border-radius: 15px 15px 15px 15px;border-radius: 15px 15px 15px 15px;-moz-border-radius: 15px 15px 15px 15px;">
                    	<div class="span4" >
                            <center><strong><?php print("En ".$row['NombreMesa']." ".$row['Nombre']." Solicita:") ; ?></strong></center><br>
                            
                        </div>
						</tr></td>
						
						<?php
						}
						?>
		  
          <tr>
            <td>
            	<div align="center">
                    <strong>  <?php print($row['PNombre']."<br>"); ?> </strong>
                         
                     <img src="imagepro/<?php echo $ImageRuta[3]; ?>" width="100" height="100" class="img-polaroid">
                </div>
            </td>
            <td><br><br><div align="right">$ <?php echo number_format($PrecioFinal); ?></div></td>
            <td><br><br>
            	<center>
                	
						<span class="badge badge-success"><?php echo $row['Prod_Cantidad']; ?></span>
                   
                </center>
            </td>
            <td><br><br><div align="right">$ <?php echo number_format($total); ?></div></td>
            <td><br><br>
	            <center>
    	        	<a href="pedidos.php?del=<?php echo $row['idPedidos']; ?>" class="btn btn-mini" title="Eliminar de la Lista">
        	        	<i class="icon-remove"></i>
            	    </a>
                </center>
            </td>
			
					
          </tr>
          
        <div id="cant<?php echo $row['idPedidos']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       	<form name="form<?php $row['idPedidos']; ?>" method="post" action="">
          	<input type="hidden" name="codigo" value="<?php echo $row['idPedidos']; ?>">
            <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	        <h3 id="myModalLabel">Actualizar Existencia</h3>
            </div>
            <div class="modal-body">
           	    <div class="row-fluid">
	                <div class="span6">
                    	<img src="imagepro/<?php echo $ImageRuta[3]; ?>" width="100" height="100" class="img-polaroid">
                    </div>
    	            <div class="span6">
                    	<strong><?php print($row['PNombre']."<br>"); ?> </strong><br>
		                <strong>Cantidad Actual: </strong><?php echo $row['Prod_Cantidad']; ?><br><br>
                        <strong>Nueva Cantidad</strong><br>
                        <input name="n_cant" value="<?php echo $row['Prod_Cantidad']; ?>" type="number" autocomplete="off" min="1">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
        	    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
            	<button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>Actualizar</strong></button>
            </div>
            </form>
        </div>
          
          <?php 
		  
		  $OldMesa=$row['Mesas_idMesas'];
		  $OldUser=$row['UsuarioPedido'];
		  
		  } 
          
		  
		$MensajePaga='<tr class="info">
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td><div align="right"><strong>NETO A PAGAR</strong></div></td>
								<td><div align="right"><strong>$'.number_format($neto).'</strong></div></td>
								<td><div align="center"><form name="FormPagaPedido" action="pedidos.php" method="post" target="_self">
									<input type="hidden" name="TxtidMesa" value="'.$OldMesa.'"></input>
									<input type="hidden" name="TxtidUsuario" value="'.$OldUser.'"></input>
									<input type="submit" name="BtnPagar" value="Facturar" class="btn btn-primary"></input>
									</form></div></td>
							  </tr>';
							print($MensajePaga);  
							}
							?>
		  
        </table>
        
		
      </div>
		
		
		
      <hr>
		
      <script>refresca(1000);</script>