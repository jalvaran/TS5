<?php 

//print("<script>alert('entra');</script>");		
if(!empty($_REQUEST["BtnGuardarIngreso"])){
    //print("<script>alert('entra');</script>");
    $obVenta=new ProcesoVenta($idUser);
    
    $fecha=$_REQUEST["TxtFecha"];
    $CuentaDestino=$_REQUEST["CmbCuentaDestino"];
    $idProveedor=$_REQUEST["TxtTercero"];
    $Total=$_REQUEST["TxtTotal"];
    $CentroCosto=$_REQUEST["CmbCentroCostos"];
    $Concepto=$_REQUEST["TxtConcepto"];   
    $VectorIngreso["Fut"]="";        
    $idIngreso=$obVenta->RegistreIngreso($fecha, $CuentaDestino, $idProveedor, $Total, $CentroCosto, $Concepto, $idUser, $VectorIngreso);
   
    header("location:ComprobantesIngreso.php?TxtidIngreso=$idIngreso");
}

///////////////fin
?>