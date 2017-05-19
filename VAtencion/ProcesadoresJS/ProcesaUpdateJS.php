<?php
/* 
 * Este archivo se encarga de escuchar las peticiones para editar un registro
 */

if(!empty($_REQUEST["BtnEditarRegistro"])){
    include_once("../../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
    include_once("../css_construct.php");
    session_start();
    $idUser=$_SESSION['idUser'];
    $obTabla = new Tabla($db);
    $obVenta = new ProcesoVenta($idUser);
    $tab=$obVenta->normalizar($_REQUEST["TxtTabla"]);
    $IDEdit=$obVenta->normalizar($_REQUEST["TxtIDEdit"]);
    $idTabla=$obVenta->normalizar($_REQUEST["TxtIdTabla"]);
    $Edicion=$obVenta->normalizar($_REQUEST["TxtValorEdit"]);
    $NombreCol=$obVenta->normalizar($_REQUEST["TxtColumna"]);
    $css =  new CssIni($tab);
    $obVenta->ActualizaRegistro($tab, $NombreCol, $Edicion, $idTabla, $IDEdit,0);
      
    //$sql=substr($sql, 0, -1);
    
    if($tab=="facturas"){
       
        $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $IDEdit);
        
        if($_REQUEST["FormaPago"]<>"Contado"){
            $Datos["Fecha"]=$DatosFactura["Fecha"];                
            $Datos["Dias"]=$_REQUEST["FormaPago"];
            $FechaVencimiento=$obVenta->SumeDiasFecha($Datos);
            $Datos["idFactura"]=$IDEdit; 
            $Datos["FechaFactura"]=$DatosFactura["Fecha"]; 
            $Datos["FechaVencimiento"]=$FechaVencimiento;
            $Datos["idCliente"]=$DatosFactura["Clientes_idClientes"];
            $obVenta->InsertarFacturaEnCartera($Datos);///Inserto La factura en la cartera

            $sql="UPDATE `librodiario` SET `CuentaPUC`='1305',`NombreCuenta`='CLIENTES NACIONALES' WHERE `Num_Documento_Interno`='$IDEdit' AND `CuentaPUC` LIKE '11%'";
            $obVenta->Query($sql);
        }
        
        $DatosTercero=$obVenta->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
        $obVenta->ActualiceTerceroLibroDiario("FACTURA", $IDEdit, "clientes", $DatosTercero["Num_Identificacion"]);
        $obVenta->ActualiceClienteCartera($IDEdit, "clientes", $DatosTercero["Num_Identificacion"]);
    }
    
   $Fecha=date("Y-m-d H:i:s");
   $obVenta->ActualizaRegistro($tab, "Updated", $Fecha, $idTabla, $IDEdit);
   $css->VentanaFlotante("Se ha Actualizado la Columna $NombreCol de la tabla $tab con el Valor: $Edicion");
   //$css->CrearNotificacionAzul("Se ha Actualizado la Columna $NombreCol de la tabla $tab con el Valor: $Edicion",16);
     
}

?>