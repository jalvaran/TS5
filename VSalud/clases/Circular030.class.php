<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Circular030 extends ProcesoVenta{
    public function CrearCircular030($FechaInicial,$FechaFinal,$Tipo,$Vector) {
        $DatosIPS=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
        $FechaCorte= str_replace("-", "", $FechaFinal);
        $NombreCircular="SAC165FIPS".$FechaCorte."NI".$DatosIPS["NIT"].".txt";
        $nombre_archivo = "../ArchivosTemporales/$NombreCircular";
        //Si existe el archivo lo borro
        if(file_exists($nombre_archivo)){
            unlink($nombre_archivo);
        }
          //Sentencia para generar la circular 030
        
        $sql="SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            (SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'I' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            '0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
            valor_neto_pagar as SaldoFactura, 'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE  t1.GeneraCircular='S' AND t1.estado='RADICADO' AND fecha_radicado>='$FechaInicial' AND fecha_radicado<='$FechaFinal'
                
            UNION
            
            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            (SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'I' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            '0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
            valor_neto_pagar as SaldoFactura, 'SI' as CobroJuridico, EstadoCobro as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE t1.GeneraCircular='S' AND t1.estado='JURIDICO' AND fecha_radicado>='$FechaInicial' AND fecha_radicado<='$FechaFinal'

            UNION

            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            (SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'A' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            '0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
            valor_neto_pagar as SaldoFactura, 'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE t1.GeneraCircular='S' AND t1.estado='RADICADO' AND fecha_radicado<'$FechaInicial'
                
            UNION
            
            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP,  
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            (SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'A' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            '0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
            valor_neto_pagar as SaldoFactura, 'SI' as CobroJuridico, EstadoCobro as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE t1.GeneraCircular='S' AND t1.estado='JURIDICO' AND fecha_radicado<'$FechaInicial'

            UNION 

            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            (SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'I' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            (SELECT SUM(valor_pagado) FROM salud_archivo_facturacion_mov_pagados WHERE salud_archivo_facturacion_mov_pagados.num_factura=t1.num_factura)   as ValorPagado,
            (SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura) as ValorGlosaAceptada,
            (SELECT IF((SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura)>0,'SI','NO')) as GlosaRespondida, 
            valor_neto_pagar as SaldoFactura, 'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE t1.GeneraCircular='S' AND t1.estado='DIFERENCIA' AND fecha_radicado>='$FechaInicial' AND fecha_radicado<='$FechaFinal'

            UNION 

            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            (SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=1) as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'A' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            (SELECT SUM(valor_pagado) FROM salud_archivo_facturacion_mov_pagados WHERE salud_archivo_facturacion_mov_pagados.num_factura=t1.num_factura)   as ValorPagado,
            (SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura) as ValorGlosaAceptada,
            (SELECT IF((SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura)>0,'SI','NO')) as GlosaRespondida, 
            valor_neto_pagar as SaldoFactura, 'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE t1.GeneraCircular='S' AND t1.estado='DIFERENCIA' AND fecha_radicado<'$FechaInicial'
             
            UNION 

            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_erp as TipoIdentificacionERP, 
            num_ident_erp as NumeroIdentificacionERP, 
            razon_social as RazonSocialIPS, 
            tipo_ident_ips as TipoIdentificacionIPS, 
            num_ident_ips as NumeroIdentificacionIPS, 
            tipo_cobro as TipoCobro,numero_factura as num_factura,'E' as IndicadorActualizacion,valor_factura as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            valor_total_pagos  as ValorPagado,
            valor_glosa_acept as ValorGlosaAceptada,
            glosa_respondida as GlosaRespondida, 
            saldo_factura as SaldoFactura, cobro_juridico as CobroJuridico, etapa_proceso as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, salud_circular030_inicial t1 
            WHERE t1.indic_act_fact='E' AND t1.fecha_radicado<'$FechaFinal'

            "
             
             ;
        $consulta=$this->Query($sql);
        if($archivo = fopen($nombre_archivo, "a")){
            $mensaje="";
            while($Datos030= $this->FetchArray($consulta)){
                
                for($i=0;$i<20;$i++){
                    if($i==8){
                        $Prefijo=preg_replace('/[0-9]/', '', $Datos030[$i]);
                        $Prefijo= str_replace("-", "", $Prefijo);
                        $NumeroFactura=intval(preg_replace('/[^0-9]+/', '', $Datos030[$i]));
                        $mensaje.=$Prefijo.",".$NumeroFactura.",";
                    }else{
                        $mensaje.=$Datos030[$i].",";
                    }
                    
                }
                $Contador=$Datos030[1];
                $mensaje=substr($mensaje, 0, -1);
                $mensaje.="\n";
            }
            $mensaje=substr($mensaje, 0, -1);
            $RegistroControl="1,NI,".$DatosIPS["NIT"].",".$DatosIPS["RazonSocial"].",$FechaInicial,$FechaFinal,$Contador";
            $RegistroControl.="\n";
            fwrite($archivo, $RegistroControl.$mensaje);
            fclose($archivo);
        }
        return($NombreCircular);
    }
    
    //Fin Clases
}