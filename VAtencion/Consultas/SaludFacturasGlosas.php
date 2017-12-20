<?php

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
//$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");

include_once("../css_construct.php");

if(!empty($_REQUEST["idFactura"])){
    $css =  new CssIni("id");
    $obGlosas = new ProcesoVenta($idUser);
    $idFactura=$obGlosas->normalizar($_REQUEST['idFactura']);
    $DatosFactura=$obGlosas->DevuelveValores("vista_salud_facturas_diferencias", "id_factura_generada", $idFactura);
    $NumFactura=$DatosFactura["num_factura"];
    $FechaPago="$DatosFactura[fecha_pago_factura]";
    $FechaRadicado="$DatosFactura[fecha_radicado]";
    $Dias=$obGlosas->CalculeDiferenciaFechas($FechaPago,$FechaRadicado , "");
    if($Dias["Dias"]>20){
        $css->CrearNotificacionRoja("! Esta factura tiene mas de 20 dias de radicacion, por lo tanto No aplica para Glosa !", 16);
    }
    /*
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Factura</strong>", 1);
            $css->ColTabla("<strong>FechaFactura</strong>", 1);
            $css->ColTabla("<strong>Total</strong>", 1);
            $css->ColTabla("<strong>ValorPagado</strong>", 1);
            $css->ColTabla("<strong>DiferenciaPago</strong>", 1);
            $css->ColTabla("<strong>FechaRadicado</strong>", 1);
            $css->ColTabla("<strong>FechaPago</strong>", 1);
            $css->ColTabla("<strong>Dias</strong>", 1);
                
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla($DatosFactura["num_factura"], 1);
            $css->ColTabla($DatosFactura["fecha_factura"], 1);
            $css->ColTabla($DatosFactura["valor_neto_pagar"], 1);
            $css->ColTabla($DatosFactura["valor_pagado"], 1);
            $css->ColTabla($DatosFactura["DiferenciaEnPago"], 1);
            $css->ColTabla($DatosFactura["fecha_radicado"], 1);
            $css->ColTabla($DatosFactura["fecha_pago_factura"], 1);
            $css->ColTabla($Dias["Dias"], 1);                      
        $css->CierraFilaTabla();
        
        $css->CerrarTabla();
        
     * 
     */
        $css->CrearNotificacionAzul("Items de la Factura ".$NumFactura, 14);
        $css->CrearDiv("DivItemsFactura", "", "center", 1, 1);
        
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->ColTabla("<strong>Archivo</strong>", 1);
                    $css->ColTabla("<strong>Concepto</strong>", 1);
                    $css->ColTabla("<strong>Valor</strong>", 1);
                    $css->ColTabla("<strong>Tipo y Cod Glosa</strong>", 1);
                    $css->ColTabla("<strong>Fecha Reporte</strong>", 1);
                    $css->ColTabla("<strong>Glosas</strong>", 1);
                    
                    $css->ColTabla("<strong>Observaciones</strong>", 1);
                $css->CierraFilaTabla();
                $Datos=$obGlosas->ConsultarTabla("salud_archivo_consultas", " WHERE num_factura='$NumFactura'");
                $i=0;
                while ($DatosArchivo=$obGlosas->FetchArray($Datos)) {
                    
                    $css->FilaTabla(12);
                        $css->ColTabla($DatosArchivo["nom_cargue"], 1);
                        $css->ColTabla($DatosArchivo["cod_consulta"], 1);
                        $css->ColTabla($DatosArchivo["valor_neto_pagar_consulta"], 1);
                        print("<td>");
                            $css->CrearSelect("CmbTipoGlosa", "");
                                $css->CrearOptionSelect(1, "Glosa Inicial", 0);
                                $css->CrearOptionSelect(2, "Glosa Levantada", 0);
                                $css->CrearOptionSelect(3, "Glosa Aceptada", 0);
                                $css->CrearOptionSelect(4, "Glosa X Conciliar", 0);
                            $css->CerrarSelect();   
                            print("<br>");
                            $NombreCajaText="CodigoGlosa".$i++;
                            $funcion="EscribaValor('CajaAsigna','$NombreCajaText');ClickElement('ImgBuscar');";
                            $css->CrearInputText($NombreCajaText, "text", "Click para buscar el codigo:<br>", "", "", "black", "onclick", "$funcion", 150, 30, 1, 1);
                            
                        print("</td>");
                        
                        print("<td>");
                            $css->CrearInputText("TxtFechaReporte", "date", "", date("Y-m-d"), "", "", "", "", 150, 30, 0, 1);
                        print("</td>");
                        print("<td>");
                            $css->CrearInputNumber("TxtValorGlosaEPS", "number", "Glosa EPS:<br>", "", "Valor EPS", "", "", "", 100, 30, 0, 1, 1, "", "any");
                            $css->CrearInputNumber("TxtValorGlosaAceptada", "number", "<br>Glosa Aceptada:<br>", 0, "Valor Aceptado", "", "", "", 100, 30, 0, 0, 0, "", "any");
                        
                        print("</td>");
                        
                        print("<td>");
                            $css->CrearTextArea("TxtObservaciones", "", "", "Observaciones", "", "", "", 200, 100, 0, 1);
                            print("<br>");
                            $funcion="";
                            $css->CrearBotonEvento("BtnEnviar", "Registrar", 1, "onClick", $funcion, "rojo", "");
                        print("</td>");
                    $css->CierraFilaTabla();
                }
            $css->CerrarTabla();
            
        $css->CerrarDiv();
        
        
}
$css->AgregaJS(); //Agregamos javascripts
?>