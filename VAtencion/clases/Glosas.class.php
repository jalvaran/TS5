<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Glosas extends ProcesoVenta{
    public function RegistreGlosa($TipoGlosa,$CodigoGlosa,$FechaReporte,$ValorEPS,$ValorAceptado,$Observaciones,$TablaOrigen,$idArchivo,$NumFactura,$idEps,$idUser,$Vector) {
        //Miro si se recibe un archivo
        //
        if(!empty($_FILES['Soporte']['name'])){
            //echo "<script>alert ('entra foto')</script>";
            $Atras="../";
            $carpeta="SoportesSalud/SoportesGlosas/";
            opendir($Atras.$carpeta);
            $Name=$idArchivo."_".str_replace(' ','_',$_FILES['Soporte']['name']);
            $destino=$carpeta.$Name;
            move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$destino);
	}
        
        if($TablaOrigen=="salud_archivo_consultas"){
        $Prefijo="AC";
        }
        if($TablaOrigen=="salud_archivo_procedimientos"){
            $Prefijo="AP";
        }
        if($TablaOrigen=="salud_archivo_medicamentos"){
            $Prefijo="AM";
        }
        if($TablaOrigen=="salud_archivo_otros_servicios"){
            $Prefijo="AT";
        }
    
        //////Creo la compra            
        $tab="salud_registro_glosas";
        $NumRegistros=12;

        $Columnas[0]="num_factura";		$Valores[0]=$NumFactura;
        $Columnas[1]="PrefijoArchivo";          $Valores[1]=$Prefijo;
        $Columnas[2]="idArchivo";               $Valores[2]=$idArchivo;
        $Columnas[3]="TipoGlosa";		$Valores[3]=$TipoGlosa;
        $Columnas[4]="CodigoGlosa";             $Valores[4]=$CodigoGlosa;
        $Columnas[5]="FechaReporte";            $Valores[5]=$FechaReporte;
        $Columnas[6]="GlosaEPS";                $Valores[6]=$ValorEPS;
        $Columnas[7]="GlosaAceptada";           $Valores[7]=$ValorAceptado;
        $Columnas[8]="Soporte";                 $Valores[8]=$destino;
        $Columnas[9]="Observaciones";           $Valores[9]=$Observaciones;
        $Columnas[10]="idUser";                 $Valores[10]=$idUser;
        $Columnas[11]="TablaOrigen";            $Valores[11]=$TablaOrigen;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
    }
    
    //Fin Clases
}