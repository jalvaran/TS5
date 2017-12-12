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
            $tab="salud_temp_rips_pagados";
            $sql="INSERT INTO `salud_temp_rips_pagados` (`id_temp_rips_pagados`, `num_factura`, `fecha_pago_factura`, `num_pago`, `valor_bruto_pagar`, `valor_descuento`, `valor_iva`, `valor_retefuente`, `valor_reteiva`, `valor_reteica`, `valor_otrasretenciones`, `valor_cruces`, `valor_anticipos`, `valor_pagado`, `idUser`) VALUES";
            
            while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
                //////Inserto los datos en la tabla  
                if($i==1){
                    
                    $sql.="('', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]','$idUser'),";
                }
                $i=1;
            }
            $sql=substr($sql, 0, -1);
            $this->Query($sql);
            fclose($handle); 
            $sql="";
        }
        
    }
    //Calculamos el numero de registros
    public function CalculeRegistros($FileName,$Separador) {
        $i=0;
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        if(!empty($_FILES[$FileName]['type'])){
            
            $handle = fopen($_FILES[$FileName]['tmp_name'], "r");
            
            while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
                
                $i++;
            }
            
            fclose($handle); 
        }
        return $i;
    }
    // insertar Rips de consultas generados a tabla temporal, despues por medio de un trigger se llevará a la general
    public function InsertarRipsConsultas($TipoNegociacion,$Separador,$FechaCargue, $idUser, $Vector) {
        // si se recibe el archivo
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        if(!empty($_FILES['UpAC']['type'])){
            $TipoArchivo=$_FILES['UpAC']['type'];
            $NombreArchivo=$_FILES['UpAC']['name'];
            $handle = fopen($_FILES['UpAC']['tmp_name'], "r");
            $i=0;
            
            $sql="INSERT INTO `salud_archivo_consultas_temp` "
              . "(`id_consultas`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `fecha_consulta`, `num_autorizacion`, `cod_consulta`, `finalidad_consulta`, `causa_externa`, `cod_diagnostico_principal`, `cod_diagnostico_relacionado1`, `cod_diagnostico_relacionado2`, `cod_diagnostico_relacionado3`, `tipo_diagn_principal`, `valor_consulta`, `valor_cuota_moderadora`, `valor_neto_pagar_consulta`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`,`idUser`) VALUES";
            
            while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
                //////Inserto los datos en la tabla  
                    
                    
                    if($data[4]<>""){
                       $FechaArchivo= explode("/", $data[4]);
                       if(count($FechaArchivo)>1){
                           $FechaConsulta= $FechaArchivo[2]."-".$FechaArchivo[1]."-".$FechaArchivo[0];
                       }else{
                           $FechaConsulta=$data[4];
                       }
                       
                    }else{
                       $FechaConsulta="0000-00-00";
                    }
                    
                    
                    
                    $sql.="('', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$FechaConsulta', '$data[5]', '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]', '$data[13]', '$data[14]', '$data[15]', '$data[16]','$TipoNegociacion','$NombreArchivo','$FechaCargue','$idUser'),";
                
                
            }
            $sql=substr($sql, 0, -1);
            $this->Query($sql);
            fclose($handle); 
            $sql="";
        }
        
    }
    
    // insertar Rips de consultas generados a tabla temporal, despues por medio de un trigger se llevará a la general
    public function InsertarRipsHospitalizaciones($TipoNegociacion,$Separador,$FechaCargue, $idUser, $Vector) {
        // si se recibe el archivo
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        if(!empty($_FILES['UpAH']['type'])){
            $TipoArchivo=$_FILES['UpAH']['type'];
            $NombreArchivo=$_FILES['UpAH']['name'];
            $handle = fopen($_FILES['UpAH']['tmp_name'], "r");
            $i=0;
            
            $sql="INSERT INTO `salud_archivo_hospitalizaciones_temp` "
              . "(`id_hospitalizacion`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `via_ingreso`, `fecha_ingreso_hospi`, `hora_ingreso`, `num_autorizacion`, `causa_externa`, `diagn_princ_ingreso`, `diagn_princ_egreso`, `diagn_relac1_egreso`, `diagn_relac2_egreso`, `diagn_relac3_egreso`, `diagn_complicacion`, `estado_salida_hospi`, `diagn_causa_muerte`, `fecha_salida_hospi`, `hora_salida_hospi`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
            
            while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
                //////Inserto los datos en la tabla  
                    
                    //Convertimos la fecha de ingreso en formato 0000-00-00
                    if($data[5]<>""){
                       $FechaArchivo= explode("/", $data[5]);
                       if(count($FechaArchivo)>1){
                           $FechaIngreso= $FechaArchivo[2]."-".$FechaArchivo[1]."-".$FechaArchivo[0];
                       }else{
                           $FechaIngreso=$data[5];
                       }
                       
                    }else{
                       $FechaIngreso="0000-00-00";
                    }
                    
                    if($data[17]<>""){
                       $FechaArchivo= explode("/", $data[17]);
                       if(count($FechaArchivo)>1){ //Si tiene formato dd/mm/año
                           $FechaSalida= $FechaArchivo[2]."-".$FechaArchivo[1]."-".$FechaArchivo[0];
                       }else{ //Si no tiene ese formato se espera que tenga el 0000-00-00
                           $FechaSalida=$data[17];
                       }
                       
                    }else{
                       $FechaSalida="0000-00-00";
                    }
                    
                    
                    
                    $sql.="('', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$FechaIngreso', '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]', '$data[13]', '$data[14]', '$data[15]', '$data[16]','$FechaSalida', '$data[18]','$TipoNegociacion','$NombreArchivo','$FechaCargue','$idUser'),";
                
                
            }
            $sql=substr($sql, 0, -1);
            $this->Query($sql);
            $sql="";
            fclose($handle); 
        }
        
    }
    //Fin Clases
}