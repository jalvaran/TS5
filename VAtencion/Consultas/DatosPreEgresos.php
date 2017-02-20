<?php

//$myPage="DatosPreEgresos.php";
//include_once("../../modelo/php_conexion.php");
//include_once("../css_construct.php");

$css =  new CssIni("");
$obVenta = new ProcesoVenta($idUser);
$sql="SELECT ep.ID as idPre, cp.ID, ep.Abono, cp.DocumentoReferencia,cp.Subtotal,cp.IVA,cp.Total,cp.Saldo,cp.Abonos,cp.idProveedor,cp.RazonSocial FROM egresos_pre ep "
        . " INNER JOIN cuentasxpagar cp ON ep.idCuentaXPagar=cp.ID AND ep.idUsuario='$idUser'";
$Consulta=$obVenta->Query($sql);
if($obVenta->NumRows($Consulta)){
    $css->CrearNotificacionAzul("Pre Egreso", 16);
    $css->CrearTabla();

    $css->FilaTabla(16);
    $css->ColTabla('<strong>Cuenta X Pagar</strong>', 1);
    $css->ColTabla('<strong>Abono</strong>', 1);
    $css->ColTabla('<strong>Documento Referencia</strong>', 1);
    $css->ColTabla('<strong>Subtotal</strong>', 1);
    $css->ColTabla('<strong>IVA</strong>', 1);
    $css->ColTabla('<strong>Total</strong>', 1);
    $css->ColTabla('<strong>Abonos</strong>', 1);
    $css->ColTabla('<strong>Saldo</strong>', 1);
    $css->ColTabla('<strong>Tercero</strong>', 1);
    $css->ColTabla('<strong>Eliminar</strong>', 1);
    $css->CierraFilaTabla();

    while($DatosPreEgreso=$obVenta->FetchArray($Consulta)){
        $css->FilaTabla(16);
        $css->ColTabla($DatosPreEgreso['ID'], 1);
        print("<td>");
        $css->CrearForm2("FrmEditarMonto".$DatosPreEgreso["ID"], $myPage, "post", "_self");
        $css->CrearInputText("idPre", "hidden", "", $DatosPreEgreso["idPre"], "", "", "", "", "", "", 0, 0);
        $css->CrearInputNumber("TxtAbonoEdit", "Number", "", $DatosPreEgreso['Abono'], "Abono", "", "", "", 100, 30, 0, 1, 1, $DatosPreEgreso['Saldo'], 1);
        $css->CrearBoton("BtnEditar", "E");
        $css->CerrarForm();
        print("</td>");
       
        $css->ColTabla($DatosPreEgreso['DocumentoReferencia'], 1);
        $css->ColTabla($DatosPreEgreso['Subtotal'], 1);
        $css->ColTabla($DatosPreEgreso['IVA'], 1);
        $css->ColTabla($DatosPreEgreso['Total'], 1);
        $css->ColTabla($DatosPreEgreso['Abonos'], 1);
        $css->ColTabla($DatosPreEgreso['Saldo'], 1);
        $css->ColTabla($DatosPreEgreso['RazonSocial']." ".$DatosPreEgreso['idProveedor'], 1);
        $css->ColTablaDel($myPage, "egresos_pre", "ID", $DatosPreEgreso["idPre"], "");
        $css->CierraFilaTabla();
    }
    $css->CerrarTabla();

}
?>