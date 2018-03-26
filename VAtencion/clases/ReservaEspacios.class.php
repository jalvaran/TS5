<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Reserva extends ProcesoVenta{
    public function CrearReserva($idEspacio,$NombreEvento,$FechaInicio,$FechaFin,$idCliente,$Telefono, $Observaciones,$idUser, $Vector) {
        
        //////Creo la compra            
        $tab="reservas_eventos";
        
        $NumRegistros=8;

        $Columnas[0]="NombreEvento";	$Valores[0]=$NombreEvento;
        $Columnas[1]="FechaInicio";     $Valores[1]=$FechaInicio;
        $Columnas[2]="FechaFin";	$Valores[2]=$FechaFin;
        $Columnas[3]="idCliente";       $Valores[3]=$idCliente;
        $Columnas[4]="Telefono";        $Valores[4]=$Telefono;
        $Columnas[5]="Observaciones";   $Valores[5]=$Observaciones;
        $Columnas[6]="idUser";          $Valores[6]=$idUser;
        $Columnas[7]="idEspacio";       $Valores[7]=$idEspacio;
       
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        $idReserva=$this->ObtenerMAX($tab,"ID", 1,"");
        return $idReserva;
    }
    
    //Clase para agregar un item a un sistema
    public function AgregarItemSistema($TipoItem,$idSistema,$Cantidad,$ValorUnitario,$idItem,$Vector) {
        //Proceso la informacion
        if($TipoItem==1){
            $TablaOrigen="productosventa";
        }else{
            $TablaOrigen="servicios";
        }
        $DatosProducto=$this->DevuelveValores($TablaOrigen, "idProductosVenta", $idItem);
        //////Agrego el registro           
        $tab="sistemas_relaciones";
        $NumRegistros=5;

        $Columnas[0]="TablaOrigen";         $Valores[0]=$TablaOrigen;
        $Columnas[1]="Referencia";          $Valores[1]=$DatosProducto["Referencia"];
        $Columnas[2]="Cantidad";            $Valores[2]=$Cantidad;
        $Columnas[3]="idSistema";           $Valores[3]=$idSistema;
        $Columnas[4]="ValorUnitario";       $Valores[4]=$ValorUnitario;
                            
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
       
    //Fin Clases
}