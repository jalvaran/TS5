<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once 'php_conexion.php';
class Barras extends ProcesoVenta{
    public function ImprimirCBZebraLP2814($Tabla,$idProducto,$Cantidad,$Puerto,$DatosCB){
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        if(($handle = @fopen("$Puerto", "a")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        sleep(5);
        if(!isset($DatosCB["CodigoBarras"])){
            $sql="SELECT CodigoBarras FROM prod_codbarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 1";
            $Consulta =  $this->Query($sql);
            $DatosCodigo=  $this->FetchArray($Consulta);  
            $Codigo=$DatosCodigo["CodigoBarras"]; 
        }else{
            $Codigo=$DatosCB["CodigoBarras"]; 
        }
        
        
        $idEmpresaPro=$DatosCB["EmpresaPro"];
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $fecha=date("y-m-d");
        $DatosConfigCB = $this->DevuelveValores("config_codigo_barras", "ID", 1);
        $RazonSocial=substr($DatosConfigCB["TituloEtiqueta"],0,17);
        $DatosProducto=$this->DevuelveValores($Tabla, "idProductosVenta", $idProducto);
       
        $Descripcion=substr($DatosProducto["Nombre"],0,20);
        $PrecioVenta= number_format($DatosProducto["PrecioVenta"]);
        
        $ID= $DatosProducto["idProductosVenta"];
        if($ID<1000){
          $Codigo=str_pad($ID, 4, "0", STR_PAD_LEFT);; 
        }else{
          $Codigo=$ID;
        }
        $enter='\r\n';
        
        fwrite($handle,"^XA".$enter);
        fwrite($handle,'^PQ'.$Cantidad.',1,1,Y'.$enter);
        fwrite($handle,"^FO10,10".$enter);
        fwrite($handle,"^ADN,14,15".$enter);
        fwrite($handle,'^FD'.$RazonSocial.'^FS'.$enter);
        fwrite($handle,'^FO10,35'.$enter);
        fwrite($handle,'^ADN,10,10'.$enter);
        fwrite($handle,'^FD'.$ID.' '.$Descripcion.'^FS'.$enter);
        fwrite($handle,'^FO10,65^BY2'.$enter);
        fwrite($handle,'^BCN,30,Y,N,N'.$enter);
        fwrite($handle,'^FD'.$Codigo.'^FS'.$enter);
        fwrite($handle,'^FO10,120'.$enter);
        fwrite($handle,'^ADN,36,20'.$enter);
        fwrite($handle,'^FD'.$PrecioVenta.'^FS'.$enter);
        fwrite($handle,'^XZ'.$enter);
       
        $salida = shell_exec('lpr $Puerto');
     }
           
    //Fin Clases
}