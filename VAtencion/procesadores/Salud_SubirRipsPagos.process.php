<?php

/* 
 * Este archivo procesa la carga de los rips de pagos
 */

if(!empty($_FILES['UpAR']['type'])){
   
    $obRips = new Rips($idUser);
    $Separador=$obRips->normalizar($_REQUEST["CmbSeparador"]);
    $FechaCargue=date("Y-m-d H:i:s");
    $FileName='UpAR';
    $NumRegistros=$obRips->CalculeRegistros($FileName,$Separador); // se calculan cuantos registros tiene el archivo
    
    $obRips->VaciarTabla("salud_temp_rips_pagados"); //Vacío la tabla de subida temporal
    $obRips->InsertarRipsPagos($Separador,$FechaCargue, $idUser, "");
    $css->CrearNotificacionVerde(number_format($NumRegistros)." Registros cargados correctamente",16);
   
}
?>