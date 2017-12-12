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
    $css->CrearNotificacionVerde(number_format($NumRegistros)." Registros Consultas AC cargados correctamente",16);
   
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
    $css->CrearNotificacionAzul(number_format($NumRegistros)." Registros Hospitalizaciones AH cargados correctamente",16);
   
}

//Archivo de Medicamentos

if(!empty($_FILES['UpAM']['name'])){ 
   
    $obRips = new Rips($idUser);
    $Separador=$obRips->normalizar($_REQUEST["CmbSeparador"]);
    $TipoNegociacion=$obRips->normalizar($_REQUEST["CmbTipoNegociacion"]);
    if($TipoNegociacion==''){
        $css->CrearNotificacionRoja(" Por favor seleccione un tipo de negociacion",16);
        exit();
    }
    $FechaCargue=date("Y-m-d H:i:s");
    $FileName='UpAM';
    $NumRegistros=$obRips->CalculeRegistros($FileName,$Separador); // se calculan cuantos registros tiene el archivo
    
    $obRips->VaciarTabla("salud_archivo_medicamentos_temp"); //Vacío la tabla de subida temporal
    $obRips->InsertarRipsMedicamentos($TipoNegociacion,$Separador,$FechaCargue, $idUser, "");
    $css->CrearNotificacionVerde(number_format($NumRegistros)." Registros Medicamentos AM cargados correctamente",16);
   
}

//Archivo de Procedimientos

if(!empty($_FILES['UpAP']['name'])){ 
   
    $obRips = new Rips($idUser);
    $Separador=$obRips->normalizar($_REQUEST["CmbSeparador"]);
    $TipoNegociacion=$obRips->normalizar($_REQUEST["CmbTipoNegociacion"]);
    if($TipoNegociacion==''){
        $css->CrearNotificacionRoja(" Por favor seleccione un tipo de negociacion",16);
        exit();
    }
    $FechaCargue=date("Y-m-d H:i:s");
    $FileName='UpAP';
    $NumRegistros=$obRips->CalculeRegistros($FileName,$Separador); // se calculan cuantos registros tiene el archivo
    
    $obRips->VaciarTabla("salud_archivo_procedimientos_temp"); //Vacío la tabla de subida temporal
    $obRips->InsertarRipsProcedimientos($TipoNegociacion,$Separador,$FechaCargue, $idUser, "");
    $css->CrearNotificacionAzul(number_format($NumRegistros)." Registros Procedimientos AP cargados correctamente",16);
   
}
       
?>