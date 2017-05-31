<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Sistema extends ProcesoVenta{
    public function CrearSistema($Nombre, $PrecioVenta, $PrecioMayorista,$Observaciones,$idUser,$Vector ) {
        
        //////Creo la compra            
        $tab="sistemas";
        $NumRegistros=7;

        $Columnas[0]="Nombre";		$Valores[0]=$Nombre;
        $Columnas[1]="idUsuario";       $Valores[1]=$idUser;
        $Columnas[2]="PrecioVenta";     $Valores[2]=$PrecioVenta;
        $Columnas[3]="PrecioMayorista";	$Valores[3]=$PrecioMayorista;
        $Columnas[4]="RutaImagen";	$Valores[4]="";
        $Columnas[5]="Observaciones";	$Valores[5]=$Observaciones;
        $Columnas[6]="Estado";          $Valores[6]="ABIERTO";
               
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        $idSistema=$this->ObtenerMAX($tab,"ID", 1,"");
        
        //Miro si se recibe un archivo
        //
        if(!empty($_FILES['foto']['name'])){
            //echo "<script>alert ('entra foto')</script>";
            $Atras="../";
            $carpeta="ImagenesProductos/";
            opendir($Atras.$carpeta);
            $Name=$idSistema."_".str_replace(' ','_',$_FILES['foto']['name']);
            $destino=$carpeta.$Name;
            move_uploaded_file($_FILES['foto']['tmp_name'],$Atras.$destino);
	}
        $this->ActualizaRegistro("sistemas", "RutaImagen", $destino, "ID", $idSistema);
        return $idSistema;
    }
    
    //Clase para agregar un item a un sistema
    public function AgregarItemSistema($TipoItem,$idSistema,$Cantidad,$idItem,$Vector) {
        //Proceso la informacion
        if($TipoItem==1){
            $TablaOrigen="productosventa";
        }else{
            $TablaOrigen="servicios";
        }
        $DatosProducto=$this->DevuelveValores($TablaOrigen, "idProductosVenta", $idItem);
        //////Agrego el registro           
        $tab="sistemas_relaciones";
        $NumRegistros=4;

        $Columnas[0]="TablaOrigen";         $Valores[0]=$TablaOrigen;
        $Columnas[1]="Referencia";          $Valores[1]=$DatosProducto["Referencia"];
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="idSistema";           $Valores[3]=$idSistema;
                            
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
       
    //Fin Clases
}