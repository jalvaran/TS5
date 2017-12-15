<?php

/* 
 * Este archivo procesa la carga de los rips de pagos
 */

if(!empty($_FILES['UpAR']['type'])){
   
    $obRips = new Rips($idUser);
    $Separador=$obRips->normalizar($_REQUEST["CmbSeparador"]);
    $FechaCargue=date("Y-m-d H:i:s");
    $NombreArchivo=$obRips->normalizar($_FILES['UpAR']['name']);
    $DatosUploads=$obRips->DevuelveValores("salud_upload_control", "nom_cargue", $NombreArchivo);
    if($DatosUploads["nom_cargue"]==$NombreArchivo){
        $css->CrearNotificacionRoja("El archivo $NombreArchivo ya fue cargado el $DatosUploads[fecha_cargue] por el Usuario: $DatosUploads[idUser]",16);
    
    }else{
        $FileName='UpAR';    
        $NumRegistros=$obRips->CalculeRegistros($FileName,$Separador); // se calculan cuantos registros tiene el archivo
        $obRips->VaciarTabla("salud_archivo_facturacion_mov_pagados_temp"); //Vacío la tabla de subida temporal
        $obRips->InsertarRipsPagos($Separador,$FechaCargue, $idUser, "");
        $css->CrearNotificacionVerde(number_format($NumRegistros)." Registros cargados correctamente",16);
    }
    
    $obRips->AnaliceInsercionFacturasPagadas("");
    
    $css->CrearNotificacionNaranja("Tabla de Facturas Pagadas Analizada",16);
}
?>