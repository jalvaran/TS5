<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Rips extends ProcesoVenta{
    public function InsertarRipsPagos($Separador,$FechaCargue, $idUser, $Vector) {
        // si se recibe el archivo
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        if(!empty($_FILES['UpAR']['type'])){
            $TipoArchivo=$_FILES['UpAR']['type'];
            $NombreArchivo=$_FILES['UpAR']['name'];
            $handle = fopen($_FILES['UpAR']['tmp_name'], "r");
            $i=0;
            $tab="salud_archivo_facturacion_mov_pagados";
            $sql="INSERT INTO `salud_archivo_facturacion_mov_pagados` (`id_pagados`, `num_factura`, `fecha_pago_factura`, `num_pago`, `valor_bruto_pagar`, `valor_descuento`, `valor_iva`, `valor_retefuente`, `valor_reteiva`, `valor_reteica`, `valor_otrasretenciones`, `valor_cruces`, `valor_anticipos`, `valor_pagado`) VALUES";
            
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                //////Inserto los datos en la tabla  
                if($i==1){
                    
                    $sql.="('', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]'),";
                }
                $i=1;
            }
            $sql=substr($sql, 0, -1);
            $this->Query($sql);
            fclose($handle); 
        }
        
    }
    //Calculamos el numero de registros
    public function CalculeRegistros() {
        $i=0;
        if(!empty($_FILES['UpAR']['type'])){
            
            $handle = fopen($_FILES['UpAR']['tmp_name'], "r");
            
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                
                $i++;
            }
            
            fclose($handle); 
        }
        return $i;
    }
       
    //Fin Clases
}