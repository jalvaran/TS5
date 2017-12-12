<?php

/* 
 * Este archivo procesa la carga de los rips de pagos
 */

if(!empty($_FILES['UpAR']['type'])){
   
    $obRips = new Rips($idUser);
    $Separador=$obRips->normalizar($_REQUEST["CmbSeparador"]);
    $FechaCargue=("Y-m-d H:i:s");
    $NumRegistros=$obRips->CalculeRegistros();
    $css->CrearNotificacionRoja($NumRegistros,16);
    $obRips->InsertarRipsPagos($Separador,$FechaCargue, $idUser, "");
    
   
}
?>