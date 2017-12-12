<?php

/* 
 * Este procesador sube los archivos RIPS generados por la IPS
 */

//Archivo de consultas

if(!empty($_FILES['UpAC']['name'])){ 
   
    $obRips = new Rips($idUser);
    $Separador=$obRips->normalizar($_REQUEST["CmbSeparador"]);
    $TipoNegociacion=$obRips->normalizar($_REQUEST["CmbTipoNegociacion"]);
    if($TipoNegociacion==''){
        $css->CrearNotificacionRoja(" Por favor seleccione un tipo de negociacion",16);
        exit();
    }
    $FechaCargue=date("Y-m-d H:i:s");
    $FileName='UpAC';
    $NumRegistros=$obRips->CalculeRegistros($FileName,$Separador); // se calculan cuantos registros tiene el archivo
    
    $obRips->VaciarTabla("salud_archivo_consultas_temp"); //Vacío la tabla de subida temporal
    $obRips->InsertarRipsConsultas($TipoNegociacion,$Separador,$FechaCargue, $idUser, "");
    $css->CrearNotificacionVerde(number_format($NumRegistros)." Registros AC cargados correctamente",16);
   
}

//Archivo de Hospitalizacion

if(!empty($_FILES['UpAH']['name'])){ 
   
    $obRips = new Rips($idUser);
    $Separador=$obRips->normalizar($_REQUEST["CmbSeparador"]);
    $TipoNegociacion=$obRips->normalizar($_REQUEST["CmbTipoNegociacion"]);
    if($TipoNegociacion==''){
        $css->CrearNotificacionRoja(" Por favor seleccione un tipo de negociacion",16);
        exit();
    }
    $FechaCargue=date("Y-m-d H:i:s");
    $FileName='UpAH';
    $NumRegistros=$obRips->CalculeRegistros($FileName,$Separador); // se calculan cuantos registros tiene el archivo
    
    $obRips->VaciarTabla("salud_archivo_hospitalizaciones_temp"); //Vacío la tabla de subida temporal
    $obRips->InsertarRipsHospitalizaciones($TipoNegociacion,$Separador,$FechaCargue, $idUser, "");
    $css->CrearNotificacionVerde(number_format($NumRegistros)." Registros AH cargados correctamente",16);
   
}
       
?>