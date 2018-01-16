<?php

/* 
 * Este archivo procesa la carga de los rips de pagos
 */
if(isset($_REQUEST["BtnEnviar"])){
    $obRips = new Rips($idUser);
    $Separador=$obRips->normalizar($_REQUEST["CmbSeparador"]);
    $FechaCargue=date("Y-m-d H:i:s");
    $destino="";
    if(!empty($_FILES['UpSoporte']['name'])){
        //echo "<script>alert ('entra foto')</script>";
        $Atras="../";
        $carpeta="SoportesSalud/SoportesAR/";
        opendir($Atras.$carpeta);
        $Name=str_replace(' ','_',$_FILES['UpSoporte']['name']);  
        $destino=$carpeta.$Name;
        move_uploaded_file($_FILES['UpSoporte']['tmp_name'],$Atras.$destino);
    }
    if(!empty($_FILES['UpZipPagos']['type'])){
        //if($_FILES['UpZipPagos']['type']=='application/x-zip-compressed'){
            $carpeta="archivos/";
            opendir($carpeta);
            $NombreArchivo=str_replace(' ','_',$_FILES['UpZipPagos']['name']);  
            //$destino=$carpeta.$NombreArchivo;
            //move_uploaded_file($_FILES['ArchivosZip']['tmp_name'],$destino);
            
            $obRips->VerificarZip($_FILES['UpZipPagos']['tmp_name'],$idUser, "");
        //}else{
          //  $css->CrearNotificacionRoja("Debe cargar un archivo .zip",16);
          //  goto salir;
        //}
        $consulta= $obRips->ConsultarTabla("salud_upload_control", " WHERE Analizado='0'");
        while($DatosArchivos= $obRips->FetchArray($consulta)){
            $NombreArchivo=$DatosArchivos["nom_cargue"]; 
            $Prefijo=substr($NombreArchivo, 0, 2); 
            //Si hay Archivos de Recaudo
            if($Prefijo=="AR"){
                $obRips->VaciarTabla("salud_archivo_facturacion_mov_pagados_temp"); //Vacío la tabla de subida temporal
                $obRips->InsertarRipsPagos($NombreArchivo, $Separador, $FechaCargue, $idUser,$destino, "");
                $NumRegistros=$obRips->CalculeRegistros("archivos/".$NombreArchivo,$Separador); // se calculan cuantos registros tiene el archivo
                $css->CrearNotificacionVerde(number_format($NumRegistros)." Registros del archivo $NombreArchivo cargados correctamente",16);
                
            }
        }
        $obRips->AnaliceInsercionFacturasPagadas("");
    
        $css->CrearNotificacionNaranja("Tabla de Facturas Pagadas Analizada",16);
        $obRips->EncuentreFacturasPagadasConDiferencia("");
        $css->CrearNotificacionVerde("Facturas pagadas con diferencias verificadas",16);
        $obRips->EncuentreFacturasPagadas("");
        $css->CrearNotificacionAzul("Facturas pagadas con igual valor verificadas",16);
    }
}
salir:
?>