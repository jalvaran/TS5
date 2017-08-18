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
    //Comprobante de Cierre Diario
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
     
    //Fin Clases
}