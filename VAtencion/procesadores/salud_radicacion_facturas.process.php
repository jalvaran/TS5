<?php 
$obVenta=new ProcesoVenta($idUser);
// si se requiere guardar y cerrar
if(isset($_REQUEST["BtnRadicar"])){
    
    $idEPS=$obVenta->normalizar($_REQUEST["CmbEPS"]);
    $FechaRadicado=$obVenta->normalizar($_REQUEST["TxtFechaRadicado"]);
    $NumeroRadicado=$obVenta->normalizar($_REQUEST["TxtNumeroRadicado"]);
    $FechaInicial=$obVenta->normalizar($_REQUEST["TxtFechaInicial"]);
    $FechaFinal=$obVenta->normalizar($_REQUEST["TxtFechaFinal"]);
    $DatosEPS=$obVenta->DevuelveValores("salud_eps", "cod_pagador_min", $idEPS);
    $Dias=$DatosEPS["dias_convenio"];
    $destino="";
    //echo "<script>alert ('entra')</script>";
    if(!empty($_FILES['Soporte']['name'])){
        //echo "<script>alert ('entra foto')</script>";
            $Atras="../";
            $carpeta="SoportesRadicados/";
            opendir($Atras.$carpeta);
            $Name=str_replace(' ','_',$_FILES['Soporte']['name']);  
            $destino=$carpeta.$Name;
            move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$destino);
    }   
    
    $sql="UPDATE salud_archivo_facturacion_mov_generados SET eps_radicacion='$idEPS', dias_pactados='$Dias',"
            . " fecha_radicado='$FechaRadicado', numero_radicado='$NumeroRadicado',Soporte='$destino',estado='RADICADO' "
            . " WHERE cod_enti_administradora='$idEPS' AND fecha_factura>='$FechaInicial' AND fecha_factura<='$FechaFinal' "
            . "AND numero_radicado=''";
    $obVenta->Query($sql);
    header("location:$myPage");
    
}
///////////////fin
?>