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
            $this->Footer($handle);
            
       }     
       
       fclose($handle); // cierra el fichero PRN
       $salida = shell_exec('lpr $COMPrinter');
    }
     
    //Fin Clases
}