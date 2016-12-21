<?php 
$obVenta=new ProcesoVenta($idUser);

if(!empty($_REQUEST["BtnGuardar"])){
    
     $destino="";
    
    if(!empty($_FILES['foto']['name'])){
        
        $carpeta="../SoportesEgresos/";
        opendir($carpeta);
        $Name=str_replace(' ','_',$_FILES['foto']['name']);  
        $destino=$carpeta.$Name;
        move_uploaded_file($_FILES['foto']['tmp_name'],$destino);
    }
    $idConcepto=$obVenta->normalizar($_REQUEST["CmbConcepto"]);
    $Fecha=$obVenta->normalizar($_REQUEST["TxtFecha"]);
    $Tercero=$obVenta->normalizar($_REQUEST["CmbTercero"]);
    $CentroCosto=$obVenta->normalizar($_REQUEST["CmbCentroCostos"]);
    $Sede=$obVenta->normalizar($_REQUEST["CmbSede"]);
    $Observaciones=$obVenta->normalizar($_REQUEST["TxtObservacionesConcepto"]);
    $NumFactura=$obVenta->normalizar($_REQUEST["TxtNumFactura"]);
    
    $obVenta->EjecutarConceptoContable($idConcepto,$Fecha,$Tercero,$CentroCosto,$Sede, $Observaciones,$NumFactura,$destino,"");
   
    header("location:$myPage");
}


///////////////fin
?>