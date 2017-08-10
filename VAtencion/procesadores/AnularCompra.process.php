<?php

/* 
 * Este archivo procesa la anulacion de un abono a un titulo
 */
$obCompra=new Compra($idUser);
if(!empty($_REQUEST["BtnAnular"])){

$idCompra=$obCompra->normalizar($_REQUEST["idCompra"]);
$fecha=$obCompra->normalizar($_REQUEST["TxtFechaAnulacion"]);
$ConceptoAnulacion=$obCompra->normalizar($_REQUEST["TxtConceptoAnulacion"]);

$idAnulacion=$obCompra->AnularCompra($fecha, $ConceptoAnulacion, $idCompra,$idUser);

header("location:AnularAbonoTitulo.php?TxtidComprobante=$idAnulacion");
        
}
?>