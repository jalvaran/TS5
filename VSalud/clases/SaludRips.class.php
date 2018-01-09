<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Rips extends ProcesoVenta{
    //Calculamos el numero de registros
    public function CalculeRegistros($FileName,$Separador) {
        $i=0;
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        
            
            $handle = fopen($FileName, "r");
            
            while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
                
                $i++;
            }
            
            fclose($handle); 
        
        return $i;
    }
    //Rips de pagos AR
    public function InsertarRipsPagos($NombreArchivo,$Separador,$FechaCargue, $idUser, $Vector) {
        // si se recibe el archivo
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        
            
            $handle = fopen("archivos/".$NombreArchivo, "r");
            $i=0;
            $z=0;
            $tab="salud_archivo_facturacion_mov_pagados_temp";
            $sql="INSERT INTO `$tab` (`id_pagados`, `num_factura`, `fecha_pago_factura`, `num_pago`, `valor_bruto_pagar`, `valor_descuento`, `valor_iva`, `valor_retefuente`, `valor_reteiva`, `valor_reteica`, `valor_otrasretenciones`, `valor_cruces`, `valor_anticipos`, `valor_pagado`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
            
            while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
                //////Inserto los datos en la tabla  
                $i++;
                if($data[1]<>""){
                    $FechaArchivo= explode("/", $data[1]);
                    if(count($FechaArchivo)>1){
                        $FechaFactura= $FechaArchivo[2]."-".$FechaArchivo[1]."-".$FechaArchivo[0];
                    }else{
                        $FechaFactura=$data[1];
                    }

                 }else{
                    $FechaFactura="0000-00-00";
                 }
                    
                if($z==1){
                    
                    $sql.="('', '$data[0]', '$FechaFactura', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]','$NombreArchivo','$FechaCargue','$idUser'),";
                }
                $z=1;
                
                if($i==10000){
                    $sql=substr($sql, 0, -1);
                    $this->Query($sql);
                    $sql="INSERT INTO `$tab` (`id_pagados`, `num_factura`, `fecha_pago_factura`, `num_pago`, `valor_bruto_pagar`, `valor_descuento`, `valor_iva`, `valor_retefuente`, `valor_reteiva`, `valor_reteica`, `valor_otrasretenciones`, `valor_cruces`, `valor_anticipos`, `valor_pagado`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
                    $i=0;
                }
            }
            $sql=substr($sql, 0, -1);
            $this->Query($sql);
            fclose($handle); 
            $sql="";
            $this->update("salud_upload_control", "Analizado", 1, " WHERE nom_cargue='$NombreArchivo'");
        
        
    }
    
    // insertar Rips de consultas generados a tabla temporal, despues por medio de un trigger se llevará a la general
    public function InsertarRipsConsultas($NombreArchivo,$TipoNegociacion,$Separador,$FechaCargue, $idUser, $Vector) {
        // si se recibe el archivo
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        $handle = fopen("archivos/".$NombreArchivo, "r");
            $i=0;
            
            $sql="INSERT INTO `salud_archivo_consultas_temp` "
              . "(`id_consultas`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `fecha_consulta`, `num_autorizacion`, `cod_consulta`, `finalidad_consulta`, `causa_externa`, `cod_diagnostico_principal`, `cod_diagnostico_relacionado1`, `cod_diagnostico_relacionado2`, `cod_diagnostico_relacionado3`, `tipo_diagn_principal`, `valor_consulta`, `valor_cuota_moderadora`, `valor_neto_pagar_consulta`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`,`idUser`) VALUES";
            
            while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
                //////Inserto los datos en la tabla  
                    
                  $i++;  
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
                    if($i==10000){
                        $sql=substr($sql, 0, -1);
                        $this->Query($sql);
                        $sql="INSERT INTO `salud_archivo_consultas_temp` "
                            . "(`id_consultas`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `fecha_consulta`, `num_autorizacion`, `cod_consulta`, `finalidad_consulta`, `causa_externa`, `cod_diagnostico_principal`, `cod_diagnostico_relacionado1`, `cod_diagnostico_relacionado2`, `cod_diagnostico_relacionado3`, `tipo_diagn_principal`, `valor_consulta`, `valor_cuota_moderadora`, `valor_neto_pagar_consulta`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`,`idUser`) VALUES";
                        $i=0;
                    }
                
            }
            $sql=substr($sql, 0, -1);
            $this->Query($sql);
            fclose($handle); 
            $sql="";
            $this->update("salud_upload_control", "Analizado", 1, " WHERE nom_cargue='$NombreArchivo'");
                
    }
    
    // insertar Rips de consultas generados a tabla temporal, despues por medio de un trigger se llevará a la general
    public function InsertarRipsHospitalizaciones($NombreArchivo,$TipoNegociacion,$Separador,$FechaCargue, $idUser, $Vector) {
        // si se recibe el archivo
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        $handle = fopen("archivos/".$NombreArchivo, "r");
            $i=0;
            
            $sql="INSERT INTO `salud_archivo_hospitalizaciones_temp` "
              . "(`id_hospitalizacion`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `via_ingreso`, `fecha_ingreso_hospi`, `hora_ingreso`, `num_autorizacion`, `causa_externa`, `diagn_princ_ingreso`, `diagn_princ_egreso`, `diagn_relac1_egreso`, `diagn_relac2_egreso`, `diagn_relac3_egreso`, `diagn_complicacion`, `estado_salida_hospi`, `diagn_causa_muerte`, `fecha_salida_hospi`, `hora_salida_hospi`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
            
            while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
                //////Inserto los datos en la tabla  
                    $i++;
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
                    if($i==10000){
                        $sql=substr($sql, 0, -1);
                        $this->Query($sql);
                        $sql="INSERT INTO `salud_archivo_hospitalizaciones_temp` "
                        . "(`id_hospitalizacion`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `via_ingreso`, `fecha_ingreso_hospi`, `hora_ingreso`, `num_autorizacion`, `causa_externa`, `diagn_princ_ingreso`, `diagn_princ_egreso`, `diagn_relac1_egreso`, `diagn_relac2_egreso`, `diagn_relac3_egreso`, `diagn_complicacion`, `estado_salida_hospi`, `diagn_causa_muerte`, `fecha_salida_hospi`, `hora_salida_hospi`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
                    $i=0;
                    }
                
            }
            $sql=substr($sql, 0, -1);
            $this->Query($sql);
            $sql="";
            fclose($handle);
            $this->update("salud_upload_control", "Analizado", 1, " WHERE nom_cargue='$NombreArchivo'");
            
        
    }
    
       
    // insertar Rips de procedimientos generados a tabla temporal, despues por medio de un trigger se llevará a la general
    public function InsertarRipsProcedimientos($NombreArchivo,$TipoNegociacion,$Separador,$FechaCargue, $idUser, $Vector) {
        // si se recibe el archivo
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        $handle = fopen("archivos/".$NombreArchivo, "r");
            $i=0;
            
            $sql="INSERT INTO `salud_archivo_procedimientos_temp` "
              . "(`id_procedimiento`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `fecha_procedimiento`, `num_autorizacion`, `cod_procedimiento`, `ambito_reali_procedimiento`, `finalidad_procedimiento`, `personal_atiende`, `cod_diagn_princ_procedimiento`, `cod_diagn_relac_procedimiento`, `complicaciones`, `realizacion_quirurgico`, `valor_procedimiento`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
            
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
                    
                    
                    
                    $sql.="('', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$FechaConsulta', '$data[5]', '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]', '$data[13]','$data[14]','$TipoNegociacion','$NombreArchivo','$FechaCargue','$idUser'),";
                    if($i==10000){
                        $sql=substr($sql, 0, -1);
                        $this->Query($sql);
                        $sql="INSERT INTO `salud_archivo_procedimientos_temp` "
                        . "(`id_procedimiento`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `fecha_procedimiento`, `num_autorizacion`, `cod_procedimiento`, `ambito_reali_procedimiento`, `finalidad_procedimiento`, `personal_atiende`, `cod_diagn_princ_procedimiento`, `cod_diagn_relac_procedimiento`, `complicaciones`, `realizacion_quirurgico`, `valor_procedimiento`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
                        $i=0;
                    }
                    $i++;
            }
            $sql=substr($sql, 0, -1);
            $this->Query($sql);
            fclose($handle); 
            $sql="";
            $this->update("salud_upload_control", "Analizado", 1, " WHERE nom_cargue='$NombreArchivo'");
            
        
    }
    
    // insertar Rips de Otros Servicios generados a tabla temporal, despues por medio de un trigger se llevará a la general
    public function InsertarRipsOtrosServicios($NombreArchivo,$TipoNegociacion,$Separador,$FechaCargue, $idUser, $Vector) {
        // si se recibe el archivo
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        $handle = fopen("archivos/".$NombreArchivo, "r");
            $i=0;
            
            $sql="INSERT INTO `salud_archivo_otros_servicios_temp` "
              . "(`id_otro_servicios`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `num_autorizacion`, `tipo_servicio`, `cod_servicio`, `nom_servicio`, `cantidad`, `valor_unit_material`, `valor_total_material`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
            
            while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
                //////Inserto los datos en la tabla  
                    
                $sql.="('', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]','$TipoNegociacion','$NombreArchivo','$FechaCargue','$idUser'),";
                if($i==10000){
                        $sql=substr($sql, 0, -1);
                        $this->Query($sql);
                        $sql="INSERT INTO `salud_archivo_otros_servicios_temp` "
                         . "(`id_otro_servicios`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `num_autorizacion`, `tipo_servicio`, `cod_servicio`, `nom_servicio`, `cantidad`, `valor_unit_material`, `valor_total_material`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
                        $i=0;
                    }
                    $i++;
            }
            $sql=substr($sql, 0, -1);
            $this->Query($sql);
            fclose($handle); 
            $sql="";
            $this->update("salud_upload_control", "Analizado", 1, " WHERE nom_cargue='$NombreArchivo'");
        
        
    }
    
    // insertar Rips de usuarios generados a tabla temporal, despues por medio de un trigger se llevará a la general
    public function InsertarRipsUsuarios($NombreArchivo,$TipoNegociacion,$Separador,$FechaCargue, $idUser, $Vector) {
        // si se recibe el archivo
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        $handle = fopen("archivos/".$NombreArchivo, "r");
            $i=0;
            
            $sql="INSERT INTO `salud_archivo_usuarios_temp` "
              . "(`id_usuarios_salud`, `tipo_ident_usuario`, `num_ident_usuario`, `cod_ident_adm_pb`, `tipo_usuario`, `primer_ape_usuario`, `segundo_ape_usuario`, `primer_nom_usuario`, `segundo_nom_usuario`, `edad`, `unidad_medida_edad`, `sexo`, `cod_depa_residencial`, `cod_muni_residencial`, `zona_residencial`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
            
            while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
                //////Inserto los datos en la tabla  
                    
                $sql.="('', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]','$data[11]','$data[12]','$data[13]','$NombreArchivo','$FechaCargue','$idUser'),";
                if($i==10000){
                        $sql=substr($sql, 0, -1);
                        $this->Query($sql);
                        $sql="INSERT INTO `salud_archivo_usuarios_temp` "
                            . "(`id_usuarios_salud`, `tipo_ident_usuario`, `num_ident_usuario`, `cod_ident_adm_pb`, `tipo_usuario`, `primer_ape_usuario`, `segundo_ape_usuario`, `primer_nom_usuario`, `segundo_nom_usuario`, `edad`, `unidad_medida_edad`, `sexo`, `cod_depa_residencial`, `cod_muni_residencial`, `zona_residencial`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
                          $i=0;
                    }
                    $i++;
            }
            $sql=substr($sql, 0, -1);
            $this->Query($sql);
            fclose($handle); 
            $sql="";
            $this->update("salud_upload_control", "Analizado", 1, " WHERE nom_cargue='$NombreArchivo'");
        
        
    }
    
    // insertar Rips de facturas generadas a tabla temporal, despues por medio de un trigger se llevará a la general
    public function InsertarRipsFacturacionGenerada($NombreArchivo,$TipoNegociacion,$Separador,$FechaCargue, $idUser, $Vector) {
        // si se recibe el archivo
        
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        $handle = fopen("archivos/".$NombreArchivo, "r");
            $i=0;
            
            $sql="INSERT INTO `salud_rips_facturas_generadas_temp` "
              . "(`id_temp_rips_generados`, `cod_prest_servicio`, `razon_social`, `tipo_ident_prest_servicio`, `num_ident_prest_servicio`, `num_factura`, `fecha_factura`, `fecha_inicio`, `fecha_final`, `cod_enti_administradora`, `nom_enti_administradora`, `num_contrato`, `plan_beneficios`, `num_poliza`, `valor_total_pago`, `valor_comision`, `valor_descuentos`, `valor_neto_pagar`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
            
            while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
                //////Inserto los datos en la tabla  
                $i++;    
                    //Convertimos la fecha de ingreso en formato 0000-00-00
                    if($data[5]<>""){
                       $FechaArchivo= explode("/", $data[5]);
                       if(count($FechaArchivo)>1){
                           $FechaFactura= $FechaArchivo[2]."-".$FechaArchivo[1]."-".$FechaArchivo[0];
                       }else{
                           $FechaFactura=$data[5];
                       }
                       
                    }else{
                       $FechaFactura="0000-00-00";
                    }
                    
                    if($data[6]<>""){
                       $FechaArchivo= explode("/", $data[6]);
                       if(count($FechaArchivo)>1){ //Si tiene formato dd/mm/año
                           $FechaInicio= $FechaArchivo[2]."-".$FechaArchivo[1]."-".$FechaArchivo[0];
                       }else{ //Si no tiene ese formato se espera que tenga el 0000-00-00
                           $FechaInicio=$data[6];
                       }
                       
                    }else{
                       $FechaInicio="0000-00-00";
                    }
                    
                    if($data[7]<>""){
                       $FechaArchivo= explode("/", $data[7]);
                       if(count($FechaArchivo)>1){ //Si tiene formato dd/mm/año
                           $FechaFinal= $FechaArchivo[2]."-".$FechaArchivo[1]."-".$FechaArchivo[0];
                       }else{ //Si no tiene ese formato se espera que tenga el 0000-00-00
                           $FechaFinal=$data[7];
                       }
                       
                    }else{
                       $FechaFinal="0000-00-00";
                    }
                    
                    $sql.="('', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$FechaFactura', '$FechaInicio', '$FechaFinal', '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]', '$data[13]', '$data[14]', '$data[15]', '$data[16]', '$TipoNegociacion','$NombreArchivo','$FechaCargue','$idUser'),";
                    
                    if($i==10000){
                        $sql=substr($sql, 0, -1);
                        $this->Query($sql);
                        $sql="INSERT INTO `salud_rips_facturas_generadas_temp` "
                        . "(`id_temp_rips_generados`, `cod_prest_servicio`, `razon_social`, `tipo_ident_prest_servicio`, `num_ident_prest_servicio`, `num_factura`, `fecha_factura`, `fecha_inicio`, `fecha_final`, `cod_enti_administradora`, `nom_enti_administradora`, `num_contrato`, `plan_beneficios`, `num_poliza`, `valor_total_pago`, `valor_comision`, `valor_descuentos`, `valor_neto_pagar`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
                        $i=0;
                    }
                
            }
            $sql=substr($sql, 0, -1);
            $this->Query($sql);
            $sql="";
            fclose($handle); 
            $this->update("salud_upload_control", "Analizado", 1, " WHERE nom_cargue='$NombreArchivo'");
        
    }
     
    // insertar Rips de facturas generadas a tabla temporal, despues por medio de un trigger se llevará a la general
    public function InsertarRipsMedicamentos($NombreArchivo,$TipoNegociacion,$Separador,$FechaCargue, $idUser, $Vector) {
        // si se recibe el archivo
        
        if($Separador==1){
           $Separador=";"; 
        }else{
           $Separador=",";  
        }
        
                       
        $handle = fopen("archivos/".$NombreArchivo, "r");
        $i=0;

        $sql="INSERT INTO `salud_archivo_medicamentos_temp` "
              . "(`id_medicamentos`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `num_autorizacion`, `cod_medicamento`,  `tipo_medicamento`, `forma_farmaceutica`, `nom_medicamento`,`concentracion_medic`, `um_medicamento`, `num_und_medic`, `valor_unit_medic`, `valor_total_medic`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
            
       while (($data = fgetcsv($handle, 1000, $Separador)) !== FALSE) {
            $i++;
            $sql.="('', '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]', '$data[13]','$TipoNegociacion','$NombreArchivo','$FechaCargue','$idUser'),";
                
            if($i==10000){
                $sql=substr($sql, 0, -1);
                $this->Query($sql);
                $sql="INSERT INTO `salud_archivo_medicamentos_temp` "
                . "(`id_medicamentos`, `num_factura`, `cod_prest_servicio`, `tipo_ident_usuario`, `num_ident_usuario`, `num_autorizacion`, `cod_medicamento`,  `tipo_medicamento`, `forma_farmaceutica`, `nom_medicamento`,`concentracion_medic`, `um_medicamento`, `num_und_medic`, `valor_unit_medic`, `valor_total_medic`, `tipo_negociacion`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES";
                $i=0;
            }

        }
        $sql=substr($sql, 0, -1);
        $this->Query($sql);
        $sql="";
        fclose($handle); 
        $this->update("salud_upload_control", "Analizado", 1, " WHERE nom_cargue='$NombreArchivo'");
        
    }
    //Actualiza Autoincrementables
    public function AjusteAutoIncrement($tabla,$id,$Vector) {
        $Increment=$this->ObtenerMAX($tabla, $id, 1, "");
        $Increment=$Increment+1;
        $sql="ALTER TABLE $tabla AUTO_INCREMENT=$Increment";
        $this->Query($sql);
    }
    //Actualiza todos los autoincrementables de las tablas que se utilizan (Esto se debe a que en la importacion
    // el autoincremental no corresponde al ultimo registro
    public function ModifiqueAutoIncrementables($Vector) {
        $this->AjusteAutoIncrement("salud_archivo_consultas", "id_consultas", $Vector);
        $this->AjusteAutoIncrement("salud_archivo_hospitalizaciones", "id_hospitalizacion", $Vector);
        $this->AjusteAutoIncrement("salud_archivo_usuarios", "id_usuarios_salud", $Vector);
        $this->AjusteAutoIncrement("salud_archivo_medicamentos", "id_medicamentos", $Vector);
        $this->AjusteAutoIncrement("salud_archivo_procedimientos", "id_procedimiento", $Vector);
        $this->AjusteAutoIncrement("salud_archivo_otros_servicios", "id_otro_servicios", $Vector);
        $this->AjusteAutoIncrement("salud_archivo_facturacion_mov_generados", "id_fac_mov_generados", $Vector);
    }
    //Registra los nombres de los archivos subidos
    public function RegistreUpload($NombreArchivo,$Fecha,$idUser,$Vector) {
        $sql="INSERT INTO `salud_upload_control` (`id_upload_control`, `nom_cargue`, `fecha_cargue`, `idUser`) VALUES "
                . "(NULL, '$NombreArchivo', '$Fecha', '$idUser');";
        $this->Query($sql);
    }
    //Copia los registros de la tabla temporal consultas que no existan en la principal y los inserta
    public function AnaliceInsercionConsultas($Vector) {
        //Secuencia SQL que selecciona los usuarios que no estan creados de la tabla temporal y los inserta en la principal
        $sql="INSERT INTO `salud_archivo_consultas` "
                . "SELECT * FROM `salud_archivo_consultas_temp` as t1 "
                . "WHERE NOT EXISTS "
                . "(SELECT 1 FROM `salud_archivo_consultas` as t2 "
                . "WHERE t1.`nom_cargue`=t2.`nom_cargue` AND t1.`num_factura`=t2.`num_factura`); ";
        
        $this->Query($sql);
    }
    //Copia los registros de la tabla temporal consultas que no existan en la principal y los inserta
    public function AnaliceInsercionHospitalizaciones($Vector) {
        //Secuencia SQL que selecciona los usuarios que no estan creados de la tabla temporal y los inserta en la principal
        $sql="INSERT INTO `salud_archivo_hospitalizaciones` "
                . "SELECT * FROM `salud_archivo_hospitalizaciones_temp` as t1 "
                . "WHERE NOT EXISTS "
                . "(SELECT 1 FROM `salud_archivo_hospitalizaciones` as t2 "
                . "WHERE t1.`nom_cargue`=t2.`nom_cargue` AND t1.`num_factura`=t2.`num_factura`); ";
        
        $this->Query($sql);
    }
    //Copia los registros de la tabla temporal Medicamentos que no existan en la principal y los inserta
    public function AnaliceInsercionMedicamentos($Vector) {
        //Secuencia SQL que selecciona los usuarios que no estan creados de la tabla temporal y los inserta en la principal
        $sql="INSERT INTO `salud_archivo_medicamentos` "
                . "SELECT * FROM `salud_archivo_medicamentos_temp` as t1 "
                . "WHERE NOT EXISTS "
                . "(SELECT 1 FROM `salud_archivo_medicamentos` as t2 "
                . "WHERE t1.`nom_cargue`=t2.`nom_cargue` AND t1.`num_factura`=t2.`num_factura`); ";
        
        $this->Query($sql);
    }
    
    //Copia los registros de la tabla temporal Procedimientos que no existan en la principal y los inserta
    public function AnaliceInsercionProcedimientos($Vector) {
        //Secuencia SQL que selecciona los usuarios que no estan creados de la tabla temporal y los inserta en la principal
        $sql="INSERT INTO `salud_archivo_procedimientos` "
                . "SELECT * FROM `salud_archivo_procedimientos_temp` as t1 "
                . "WHERE NOT EXISTS "
                . "(SELECT 1 FROM `salud_archivo_procedimientos` as t2 "
                . "WHERE t1.`nom_cargue`=t2.`nom_cargue` AND t1.`num_factura`=t2.`num_factura`); ";
        
        $this->Query($sql);
    }
    
    //Copia los registros de la tabla temporal Otros Servicios que no existan en la principal y los inserta
    public function AnaliceInsercionOtrosServicios($Vector) {
        //Secuencia SQL que selecciona los usuarios que no estan creados de la tabla temporal y los inserta en la principal
        $sql="INSERT INTO `salud_archivo_otros_servicios` "
                . "SELECT * FROM `salud_archivo_otros_servicios_temp` as t1 "
                . "WHERE NOT EXISTS "
                . "(SELECT 1 FROM `salud_archivo_otros_servicios` as t2 "
                . "WHERE t1.`nom_cargue`=t2.`nom_cargue` AND t1.`num_factura`=t2.`num_factura`); ";
        
        $this->Query($sql);
    }
    
    //Copia los registros de la tabla temporal usuarios que no existan en la principal y los inserta
    public function AnaliceInsercionUsuarios($Vector) {
        //Secuencia SQL que selecciona los usuarios que no estan creados de la tabla temporal y los inserta en la principal
        $sql="INSERT INTO `salud_archivo_usuarios` "
                . "SELECT * FROM `salud_archivo_usuarios_temp` as t1 "
                . "WHERE NOT EXISTS "
                . "(SELECT 1 FROM `salud_archivo_usuarios` as t2 "
                . "WHERE t1.`num_ident_usuario`=t2.`num_ident_usuario` "
                . "AND t1.`primer_ape_usuario`=t2.`primer_ape_usuario` "
                . "AND t1.`segundo_ape_usuario`=t2.`segundo_ape_usuario` "
                . "AND t1.`primer_nom_usuario`=t2.`primer_nom_usuario` "
                . "AND t1.`segundo_nom_usuario`=t2.`segundo_nom_usuario`);";
        
        $this->Query($sql);
    }
    
    //Copia los registros de la tabla temporal facturas que no existan en la principal y los inserta
    public function AnaliceInsercionFacturasGeneradas($Vector) {
        //Secuencia SQL que selecciona los usuarios que no estan creados de la tabla temporal y los inserta en la principal
        $sql="INSERT INTO `salud_archivo_facturacion_mov_generados` 
            (`cod_prest_servicio`,`razon_social`,`tipo_ident_prest_servicio`,`num_ident_prest_servicio`,
            `num_factura`,`fecha_factura`,`fecha_inicio`,`fecha_final`,`cod_enti_administradora`,
            `nom_enti_administradora`,`num_contrato`,`plan_beneficios`,`num_poliza`,`valor_total_pago`,
            `valor_comision`,`valor_descuentos`,`valor_neto_pagar`,`tipo_negociacion`,`nom_cargue`,`fecha_cargue`,`idUser`)
            SELECT `cod_prest_servicio`,`razon_social`,`tipo_ident_prest_servicio`,`num_ident_prest_servicio`,`num_factura`,
            `fecha_factura`,`fecha_inicio`,`fecha_final`,`cod_enti_administradora`,`nom_enti_administradora`,`num_contrato`,
            `plan_beneficios`,`num_poliza`,`valor_total_pago`,`valor_comision`,`valor_descuentos`,`valor_neto_pagar`,
            `tipo_negociacion`,`nom_cargue`,`fecha_cargue`,`idUser` 
            FROM salud_rips_facturas_generadas_temp as t1 WHERE NOT EXISTS  
            (SELECT 1 FROM `salud_archivo_facturacion_mov_generados` as t2 
            WHERE t1.`num_factura`=t2.`num_factura`); ";
        
        $this->Query($sql);
    }
    //Copia los registros de la tabla temporal Otros Servicios que no existan en la principal y los inserta
    public function AnaliceInsercionFacturasPagadas($Vector) {
        //Secuencia SQL que selecciona los usuarios que no estan creados de la tabla temporal y los inserta en la principal
        $sql="INSERT INTO `salud_archivo_facturacion_mov_pagados` "
                . "SELECT * FROM `salud_archivo_facturacion_mov_pagados_temp` as t1 "
                . "WHERE NOT EXISTS "
                . "(SELECT 1 FROM `salud_archivo_facturacion_mov_pagados` as t2 "
                . "WHERE t1.`nom_cargue`=t2.`nom_cargue` AND t1.`num_factura`=t2.`num_factura`); ";
        
        $this->Query($sql);
        $this->AjusteAutoIncrement("salud_archivo_facturacion_mov_pagados", "id_pagados", $Vector);
    }
    //Actualiza el estado de las facturas pagas con el mismo valor
    public function EncuentreFacturasPagadas($Vector) {
        $sql="UPDATE salud_archivo_facturacion_mov_generados t1 "
                . "INNER JOIN salud_archivo_facturacion_mov_pagados t2 "
                . "SET t1.estado='PAGADA' "
                . "WHERE t1.`num_factura`=t2.`num_factura` AND "
                . "(SELECT SUM(`valor_pagado`) FROM salud_archivo_facturacion_mov_pagados "
                . "WHERE `num_factura`=t1.`num_factura`)>=t1.`valor_neto_pagar` ";
        $this->Query($sql);
    }
    //Actualiza el estado de las facturas pagas con diferencia
    public function EncuentreFacturasPagadasConDiferencia($Vector) {
        $sql="UPDATE salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 "
                . "SET t1.estado='DIFERENCIA' "
                . "WHERE t1.`num_factura`=t2.`num_factura` AND t2.`valor_pagado`<t1.`valor_neto_pagar` ";
        $this->Query($sql);
    }
    
    //Verificar archivos subidos por zip
    public function VerificarZip($NombreArchivo,$idUser,$Vector) {
        $zip = new ZipArchive;
        $Fecha=date("Y-m-d H:i:s");
        //print("Entra");
        if ($zip->open($NombreArchivo) === TRUE){
            $zip->extractTo('archivos/'); //función para extraer el ZIP, le pasamos la ruta donde queremos que nos descomprima
            for($i = 0; $i < $zip->numFiles; $i++){
                //obtenemos ruta que tendrán los documentos cuando los descomprimamos
                $nombresFichZIP['tmp_name'][$i] = 'archivos/'.$zip->getNameIndex($i);
                //obtenemos nombre del fichero
                $nombresFichZIP['name'][$i] = $zip->getNameIndex($i);
                $DatosArchivos= $this->DevuelveValores("salud_upload_control", "nom_cargue", $nombresFichZIP['name'][$i]);
                if($DatosArchivos==''){
                    $this->RegistreUpload($nombresFichZIP['name'][$i], $Fecha, $idUser, "");
                }
               
            }
            

            $zip->close();
	}
    }
    
    
   
    //Fin Clases
}