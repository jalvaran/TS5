<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once 'php_conexion.php';
class PrintPos extends ProcesoVenta{
    public function EncabezadoComprobantesPos($handle,$Fecha, $idEmpresa){
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresa);
        $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
        $Telefono=$DatosEmpresa["Telefono"];
        fwrite($handle,chr(27). chr(64));//REINICIO
        //fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        $this->SeparadorHorizontal($handle,"*", 37);
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$NIT);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Direccion);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
    }
    
    public function Footer($handle){
        
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRO

        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

        fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle,"***Comprobante impreso por TS5***");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"Techno Soluciones SAS, 3177740609");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"www.technosoluciones.com.co");
        //fwrite($handle,"=================================");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle, chr(27). chr(100). chr(1));
        fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
        
    }
    //Comprobante fiscal de Cierre Diario
    public function ImprimeComprobanteInformeDiario($COMPrinter,$FechaInicial,$FechaFinal) {
        $COMPrinter= $this->COMPrinter;    
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
        
        $Condicion=" WHERE Fecha BETWEEN  '$FechaInicial' AND '$FechaFinal'";
            
       $sql="SELECT * FROM cajas_aperturas_cierres $Condicion";
       $Consulta=$this->Query($sql);
       
       while($DatosCierre=$this->FetchArray($Consulta)){
            $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $DatosCierre["Usuario"]);
            $idUsuario=$DatosCierre["Usuario"];
            $this->EncabezadoComprobantesPos($handle, $DatosCierre["Fecha"], 1);
            fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
            $this->SeparadorHorizontal($handle,"*", 37);

            /////////////////////////////Datos del Cierre

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
            fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
            fwrite($handle,"FECHA: $DatosCierre[Fecha]          HORA: $DatosCierre[Hora]");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"COMPROBANTE DE INFORME DIARIO: $DatosCierre[ID]");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            $idCierre=$DatosCierre["ID"];
            $sql="SELECT idResolucion,MIN(NumeroFactura) AS MinFact, MAX(NumeroFactura) AS MaxFact FROM facturas WHERE CerradoDiario='$idCierre'";
            $Datos=$this->Query($sql);
            $DatosFacturas=$this->FetchArray($Datos);
            $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $DatosFacturas["idResolucion"]);
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"RESOLUCION DIAN: ".$DatosResolucion["NumResolucion"]." DEL ".$DatosResolucion["Fecha"]);
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"HABILITA DESDE: ".$DatosResolucion["Prefijo"]." ".$DatosResolucion["Desde"]." HASTA ".$DatosResolucion["Prefijo"]." ".$DatosResolucion["Hasta"]);
            $this->SeparadorHorizontal($handle, "_", 37);
            fwrite($handle,"Fact. Inicial: ".$DatosFacturas["MinFact"]);
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"Fact. Final:   ".$DatosFacturas["MaxFact"]);
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"Numero Facts:  ".($DatosFacturas["MaxFact"]-$DatosFacturas["MinFact"]+1));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
            fwrite($handle,"VENTAS DISCRIMINADAS POR DEPARTAMENTO:");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            
            $CondicionItems=" ori_facturas_items WHERE FechaFactura BETWEEN '$FechaInicial' AND '$FechaFinal' AND idUsuarios='$idUsuario'";
            $sql="SELECT Departamento as idDepartamento, `PorcentajeIVA`,sum(`TotalItem`) as Total, sum(`IVAItem`) as IVA, sum(`SubtotalItem`) as Subtotal, SUM(Cantidad) as Items"
            . "  FROM $CondicionItems GROUP BY `Departamento`,`PorcentajeIVA`";
            
            $ConsultaItems= $this->Query($sql);
            $GranSubtotal=0;
            $GranIVA=0;
            $GranTotal=0;
            
            while($DatosVentas= $this->FetchArray($ConsultaItems)){
                if(round($DatosVentas["Total"],-2)>0){
                    $this->SeparadorHorizontal($handle, "_", 37);
                    $TipoIva=$DatosVentas["PorcentajeIVA"];
                    $PIVA= str_replace("%", "", $TipoIva);
                    $PIVA=$PIVA/100;
                    $Total=round($DatosVentas["Total"],-2);
                    $Subtotal=$Total/(1+$PIVA);
                    $IVA=$Total-$Subtotal;
                    $GranSubtotal=$GranSubtotal+$Subtotal;
                    $GranIVA=$GranIVA+$IVA;
                    $GranTotal=$GranTotal+$Total;
                    $DatosDepartamentos=$this->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosVentas["idDepartamento"]);
                    fwrite($handle,$DatosDepartamentos["Nombre"]." ".$DatosVentas["PorcentajeIVA"]);
                    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                    fwrite($handle,"BASE:             ".number_format($Subtotal));
                    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                    fwrite($handle,"IVA:              ".number_format($IVA));
                    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                    fwrite($handle,"TOTAL:            ".number_format($Total));
                    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                }
            }
            $this->SeparadorHorizontal($handle, "_", 37);
            $this->SeparadorHorizontal($handle, "_", 37);
            $sql="SELECT SUM(ValorOtrosImpuestos) AS Impoconsumo FROM facturas_items WHERE idCierre='$idCierre'";
            $ConsultaOtros= $this->Query($sql);
            $DatosOtrosImpuestos=$this->FetchArray($ConsultaOtros);
            fwrite($handle,"       TOTALES          ");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"BASE:             ".number_format($GranSubtotal));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"IVA:              ".number_format($GranIVA));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"IMPOCONSUMO:      ".number_format($DatosOtrosImpuestos["Impoconsumo"]));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            $GranTotal=$GranTotal+$DatosOtrosImpuestos["Impoconsumo"];
            fwrite($handle,"TOTAL:            ".number_format($GranTotal));
            
            $sql="SELECT SUM(Tarjetas) AS Tarjetas FROM facturas WHERE 	CerradoDiario='$idCierre'";
            $ConsultaTarjetas= $this->Query($sql);
            $DatosTarjetas=$this->FetchArray($ConsultaTarjetas);
            $this->SeparadorHorizontal($handle, "_", 37);
            fwrite($handle,"       FORMAS DE PAGO          ");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"EFECTIVO:            ".number_format($GranTotal-$DatosTarjetas["Tarjetas"]));
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,"TARJETAS:            ".number_format($DatosTarjetas["Tarjetas"]));
                          
            $this->Footer($handle);
            
       }     
       
       fclose($handle); // cierra el fichero PRN
       $salida = shell_exec('lpr $COMPrinter');
    }
    
    //Imprime Factura
    
    /*
     * Imprime una factura pos
     */
    public function ImprimeFacturaPOS($idFactura,$COMPrinter,$Copias){
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $idFactura);
       $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $DatosFactura["EmpresaPro_idEmpresaPro"]);
       $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $DatosFactura["idResolucion"]);
       $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $DatosFactura["Usuarios_idUsuarios"]);
       $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
        $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
        $Regimen=$DatosEmpresa["Regimen"];
        $ResolucionDian1="RES DIAN: $DatosResolucion[NumResolucion] del $DatosResolucion[Fecha]";
        $ResolucionDian2="FACTURA AUT. $DatosResolucion[Prefijo] - $DatosResolucion[Desde] HASTA $DatosResolucion[Prefijo] - $DatosResolucion[Hasta]";
        $ResolucionDian3="Autoriza impresion en:  $DatosResolucion[Factura]";
        $Telefono=$DatosEmpresa["Telefono"];

        $impuesto=$DatosFactura["IVA"];
        $Descuento=$DatosFactura["Descuentos"];
        $TotalVenta=$DatosFactura["Total"];
        $Subtotal=$DatosFactura["Subtotal"];
        $TotalFinal=$DatosFactura["Total"];
        

        $Fecha=$DatosFactura["Fecha"];
        $Hora=$DatosFactura["Hora"];
        $NumFact=$DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"];
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        $InfoRegimen="REGIMEN SIMPLIFICADO";
        if($Regimen<>"SIMPLIFICADO"){
            $InfoRegimen="IVA REGIMEN COMUN";
        }
        fwrite($handle,"NIT: ".$NIT." ".$InfoRegimen);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		if($Regimen<>"SIMPLIFICADO"){
        fwrite($handle,$ResolucionDian1);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$ResolucionDian2);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$ResolucionDian3);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
		}
        fwrite($handle,$Direccion." ".$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        
        fwrite($handle,"TEL: ".$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"Cliente: $DatosCliente[RazonSocial]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"NIT: $DatosCliente[Num_Identificacion]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha      HORA: $Hora");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"FACTURA DE VENTA No $NumFact");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"TIPO DE FACTURA: $DatosFactura[FormaPago]");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

        /////////////////////////////ITEMS VENDIDOS

        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

        $sql = "SELECT * FROM facturas_items WHERE idFactura='$idFactura'";
	
        $consulta=$this->Query($sql);
		$i=0;						
	while($DatosVenta=$this->FetchArray($consulta)){
		$i++;
            $ProcentajeIVA=$DatosVenta["PorcentajeIVA"];
            $Base[$i]=$DatosVenta["PorcentajeIVA"];
                        
            if(!isset($SubtotalP[$ProcentajeIVA])){
                $SubtotalP[$ProcentajeIVA]=0;
            }
            if(!isset($SubtotalP[$ProcentajeIVA])){
                $ImpuestosP[$ProcentajeIVA]=0;
            }
            $SubtotalP[$ProcentajeIVA]=$Subtotal[$ProcentajeIVA]+$DatosVenta["SubtotalItem"];
            $ImpuestosP[$ProcentajeIVA]=$ImpuestosP[$ProcentajeIVA]+$DatosVenta["IVAItem"];
            $SubTotalITem=$DatosVenta["TotalItem"];
            //$SubTotalITem=$TotalVenta-$Impuestos;


            fwrite($handle,str_pad($DatosVenta["Cantidad"],4," ",STR_PAD_RIGHT));

            fwrite($handle,str_pad(substr($DatosVenta["Referencia"]." ".$DatosVenta["Nombre"],0,20),20," ",STR_PAD_BOTH)."   ");

            fwrite($handle,str_pad("$".number_format($SubTotalITem),10," ",STR_PAD_LEFT));

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
}




    /////////////////////////////TOTALES

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
    if($Regimen<>"SIMPLIFICADO"){
        $sql="SELECT sum(SubtotalItem) as Subtotal, sum(ValorOtrosImpuestos) as OtrosImpuestos,sum(IVAItem) as IVA,sum(TotalItem) as TotalItem, PorcentajeIVA FROM facturas_items WHERE idFactura = '$idFactura' GROUP BY PorcentajeIVA";
	$Consulta=$this->Query($sql);
	while($DatosTotales=$this->FetchArray($Consulta)){
            $TotalVenta=$DatosTotales["Subtotal"]+$DatosTotales["IVA"]+$DatosTotales["OtrosImpuestos"];
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                fwrite($handle,"Base $DatosTotales[PorcentajeIVA]         ".str_pad("$".number_format($DatosTotales["Subtotal"],2),20," ",STR_PAD_LEFT));
                fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                fwrite($handle,"Impuesto $DatosTotales[PorcentajeIVA]     ".str_pad("$".number_format($DatosTotales["IVA"],2),20," ",STR_PAD_LEFT));
                if($DatosTotales["OtrosImpuestos"]>0){
                    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
                    fwrite($handle,"Impoconsumo      ".str_pad("$".number_format($DatosTotales["OtrosImpuestos"]),20," ",STR_PAD_LEFT));
                  
                }
           
        }

        //fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        //fwrite($handle,"SUBTOTAL         ".str_pad("$".number_format($Subtotal),20," ",STR_PAD_LEFT));

        //fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        //fwrite($handle,"IVA              ".str_pad("$".number_format($impuesto),20," ",STR_PAD_LEFT));
    }
    $Total=$this->Sume("facturas_items", "TotalItem", " WHERE idFactura='$idFactura'");
    $Bolsa=$this->Sume("facturas_items", "ValorOtrosImpuestos", " WHERE idFactura='$idFactura'");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL A PAGAR    ".str_pad("$".number_format($Total+$Bolsa),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    /////////////////////////////Forma de PAGO

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

    fwrite($handle,"Formas de Pago");
    if($DatosFactura["Efectivo"]>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"       Efectivo ----> $".str_pad(number_format($DatosFactura["Efectivo"]),10," ",STR_PAD_LEFT));
    }
    if($DatosFactura["Tarjetas"]>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"       Tarjetas ----> $".str_pad(number_format($DatosFactura["Tarjetas"]),10," ",STR_PAD_LEFT));
    }
    if($DatosFactura["Cheques"]>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"       Cheques  ----> $".str_pad(number_format($DatosFactura["Cheques"]),10," ",STR_PAD_LEFT));
    }
    if($DatosFactura["Otros"]>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"       Otros    ----> $".str_pad(number_format($DatosFactura["Otros"]),10," ",STR_PAD_LEFT));
    }
    if($DatosFactura["Devuelve"]>0){
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"       Cambio   ----> $".str_pad(number_format($DatosFactura["Devuelve"]),10," ",STR_PAD_LEFT));
    }
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //Se mira si hay observaciones
    if($DatosFactura["ObservacionesFact"]<>""){
        /////////////////////////////Forma de PAGO

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

    fwrite($handle,"Observaciones:");
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,$DatosFactura["ObservacionesFact"]);

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    }
    
    //Termina observaciones
    
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
    fwrite($handle,"***GRACIAS POR SU COMPRA***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
    //fwrite($handle, chr(27). chr(100). chr(0));
    //fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle,"***Factura impresa por TS5***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"Software disenado por Techno Soluciones SAS, 3177740609, www.technosoluciones.com.co");
    //fwrite($handle,"=================================");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
    
    /*
     * Imprime una cotizacion pos
     */
    public function ImprimeCotizacionPOS($idCotizacion,$COMPrinter,$Copias){
        $COMPrinter= $this->COMPrinter;
        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
        $DatosCotizacion= $this->DevuelveValores("cotizacionesv5", "ID", $idCotizacion);
        $idEmpresa=1;
        $this->EncabezadoComprobantesPos($handle, $DatosCotizacion["Fecha"], $idEmpresa);
        
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"COTIZACION No $idCotizacion");
        $this->SeparadorHorizontal($handle, "*", 37);

        /////////////////////////////ITEMS COTIZADOS

        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        $this->SeparadorHorizontal($handle, "_", 37);
        $sql = "SELECT * FROM cot_itemscotizaciones WHERE NumCotizacion='$idCotizacion'";
	
        $consulta=$this->Query($sql);
	$GranSubtotal=0;
        $GranIVA=0;
        $GranTotal=0;
	while($DatosItems=$this->FetchArray($consulta)){
            $GranSubtotal=$GranSubtotal+$DatosItems["Subtotal"];
            $GranIVA=$GranIVA+$DatosItems["IVA"];
            $GranTotal=$GranTotal+$DatosItems["Total"];
            fwrite($handle,str_pad($DatosItems["Cantidad"],4," ",STR_PAD_RIGHT));
            fwrite($handle,str_pad(substr($DatosItems["Referencia"]." ".$DatosItems["Descripcion"],0,20),20," ",STR_PAD_BOTH)."   ");
            fwrite($handle,str_pad("$".number_format($DatosItems["Total"]),10," ",STR_PAD_LEFT));
            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        }

        /////////////////////////////TOTALES

        $this->SeparadorHorizontal($handle, "_", 37);
        
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"SUBTOTAL    ".str_pad("$".number_format($GranSubtotal),20," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"IVA         ".str_pad("$".number_format($GranIVA),20," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"TOTAL       ".str_pad("$".number_format($GranTotal),20," ",STR_PAD_LEFT));
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        if($DatosCotizacion["Observaciones"]<>''){
            $this->SeparadorHorizontal($handle, "_", 37);
            fwrite($handle,"Observaciones:");
            fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
            fwrite($handle,$DatosCotizacion["Observaciones"]);
        }    
        $this->Footer($handle);
        fclose($handle); // cierra el fichero PRN
        $salida = shell_exec('lpr $COMPrinter');
    
    }
     
    //Fin Clases
}