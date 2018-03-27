<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Reserva extends ProcesoVenta{
    public function CrearReserva($idEspacio,$NombreEvento,$FechaInicio,$FechaFin,$idCliente,$Telefono, $Observaciones,$idUser, $Vector) {
        
        $DatosEspacio=$this->DevuelveValores("reservas_espacios", "ID", $idEspacio);     
        $tab="reservas_eventos";
        
        $NumRegistros=9;

        $Columnas[0]="NombreEvento";	$Valores[0]=$NombreEvento;
        $Columnas[1]="FechaInicio";     $Valores[1]=$FechaInicio;
        $Columnas[2]="FechaFin";	$Valores[2]=$FechaFin;
        $Columnas[3]="idCliente";       $Valores[3]=$idCliente;
        $Columnas[4]="Telefono";        $Valores[4]=$Telefono;
        $Columnas[5]="Observaciones";   $Valores[5]=$Observaciones;
        $Columnas[6]="idUser";          $Valores[6]=$idUser;
        $Columnas[7]="idEspacio";       $Valores[7]=$idEspacio;
        $Columnas[8]="Tarifa";          $Valores[8]=$DatosEspacio["TarifaNormal"];
       
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        $idReserva=$this->ObtenerMAX($tab,"ID", 1,"");
        return $idReserva;
    }
    
    //Clase para agregar un item a un sistema
    public function FacturarReserva($idEspacio,$idReserva,$fecha,$idUser,$Vector) {
        $DatosEspacio=$this->DevuelveValores("reservas_espacios", "ID", $idEspacio);
        $DatosReserva=$this->DevuelveValores("reservas_eventos", "ID", $idReserva);
        $idPreventa=99;// se utiliza esta para no interferir en la operacion
        //Agrego el item a la preventa 99
        $this->AgregaPreventa($fecha,1,$idPreventa,$DatosEspacio['idProductoRelacionado'],"productosventa",$DatosReserva["Tarifa"]);
        
        //Registro la venta y creo la factura
        $Parametros= $this->DevuelveValores("parametros_contables", "ID", 21); // en este registro se encuentra la cuenta por defecto a utilizar en caja
        $CuentaDestino=$Parametros["CuentaPUC"];
        $DatosVentaRapida["PagaCheque"]=0;
        $DatosVentaRapida["PagaTarjeta"]=0;
        $DatosVentaRapida["idTarjeta"]=0;
        $DatosVentaRapida["PagaOtros"]=0;
        $DatosCaja=$this->DevuelveValores("cajas", "idUsuario", $idUser);
        $DatosVentaRapida["CentroCostos"]=$DatosCaja["CentroCostos"];
        $DatosVentaRapida["ResolucionDian"]=$DatosCaja["idResolucionDian"];
        $DatosVentaRapida["Observaciones"]=$DatosReserva["Observaciones"];
        $NumFactura=$this->RegistreVentaRapida($idPreventa, $DatosReserva["idCliente"], "Contado", $DatosReserva["Tarifa"], 0, $Parametros["CuentaPUC"], $DatosVentaRapida);
        $this->FacturaKardex($NumFactura,$CuentaDestino, $idUser, "");
        //print("<script>alert('Entra 2')</script>");
        $this->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
        
        return($NumFactura);
    }
       
    //Fin Clases
}