<?php

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
//$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

$css =  new CssIni("id");
$obVenta = new ProcesoVenta($idUser);
//$key=$obVenta->normalizar($_REQUEST['key']);
$myPage=$obVenta->normalizar($_REQUEST['myPage']);
$idPreventa=$obVenta->normalizar($_REQUEST['CmbPreVentaAct']);
$idClientes=$obVenta->normalizar($_REQUEST['idClientes']);

//Dibujo cuadro de totales
$DatosPersonalesCliente=$obVenta->DevuelveValores("clientes", "idClientes", $idClientes);
if($idClientes==1){
    $css->CrearNotificacionVerde("Venta para $DatosPersonalesCliente[RazonSocial]", 14);
}else{
    $css->CrearNotificacionRoja("Venta para $DatosPersonalesCliente[RazonSocial]", 14);
}
$css->CrearForm2("FrmGuarda",$myPage,"post","_self");
    $Subtotal=$obVenta->SumeColumna("preventa","Subtotal", "VestasActivas_idVestasActivas",$idPreventa);
    $IVA=$obVenta->SumeColumna("preventa","Impuestos", "VestasActivas_idVestasActivas",$idPreventa);
    $DatosPreventa=$obVenta->DevuelveValores("vestasactivas","idVestasActivas", $idPreventa);
    $SaldoFavor=$DatosPreventa["SaldoFavor"];
    $sql="SELECT SUM(Cantidad) as NumItems FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa'";
    $consulta=$obVenta->Query($sql);
    $SumaItemsPreventa=$obVenta->FetchArray($consulta);
    $sql="SELECT Devuelve FROM facturas WHERE Usuarios_idUsuarios='$idUser' ORDER BY idFacturas DESC LIMIT 1";
    $consulta=$obVenta->Query($sql);
    $DatosDevuelta=$obVenta->FetchArray($consulta);
    if($SaldoFavor>0)
            $SaldoFavor=$SaldoFavor;
    else
            $SaldoFavor=0;

    $Total=$Subtotal+$IVA;
    $GranTotal=round($Total-$SaldoFavor);
    
    $css->CrearInputText("TxtCliente","hidden","",$idClientes,"","","","",150,30,0,0);
    $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",150,30,0,0);
    $css->CrearInputText("TxtSaldoFavor","hidden","",$SaldoFavor,"","","","",150,30,0,0);
    $css->CrearInputText("TxtTotalH","hidden","",$Total,"","","","",150,30,0,0);
    $css->CrearInputText("TxtCuentaDestino","hidden","",11051001,"","","","",150,30,0,0);
    $css->CrearInputText("TxtGranTotalH","hidden","",$GranTotal,"","","","",150,30,0,0);
    $css->CrearTabla();
    $css->FilaTabla(20);
        $css->ColTabla("<strong>Ultima Devuelta : </strong>", 1);
        $css->ColTabla("<strong>$ ".number_format($DatosDevuelta["Devuelve"])."<strong>", 1); 
    $css->CierraFilaTabla();
    $css->FilaTabla(16);
        $css->ColTabla("<strong>Productos : </strong>", 1);
        $css->ColTabla("<strong>".number_format($SumaItemsPreventa["NumItems"])."<strong>", 1); 
    $css->CierraFilaTabla();
    $css->FilaTabla(14);
        $css->ColTabla("<strong>SUBTOTAL : </strong>", 1);
        $css->ColTabla("<strong> $".number_format($Subtotal)."<strong>", 1); 
    $css->CierraFilaTabla();
    $css->FilaTabla(14);
        $css->ColTabla("<strong>IMPUESTOS : </strong>", 1);
        $css->ColTabla("<strong> $".number_format($IVA)."<strong>", 1); 
    $css->CierraFilaTabla();
    $css->FilaTabla(22);
        $css->ColTabla("<strong>TOTAL : </strong>", 1);
        $css->ColTabla("<strong> $".number_format($Total)."<strong>", 1); 
    $css->CierraFilaTabla();    
    $css->FilaTabla(20);
        $css->ColTabla("<strong>Efectivo : </strong>", 1);
        print("<td>");
        $css->CrearInputNumber("TxtPaga","number","",round($Total),"Efectivo","","onkeyup","CalculeDevuelta()",150,30,0,1,"","",1);
        print("</td>");
    $css->CierraFilaTabla();  
    $Visible=0;
    $css->FilaTabla(14);
        $css->ColTabla("<strong>+ Pago: </strong>", 1);
        print("<td>");
        print("<strong>+</strong><image name='imgHidde' id='imgHidde' src='../images/hidde.png' onclick=MuestraOculta('DivOtrasOpcionesPago');>");
        $css->CrearDiv("DivOtrasOpcionesPago", "", "left", $Visible, 1);
                print("<br>");
                $css->CrearInputNumber("TxtPagaTarjeta","number","Tarjeta: <br>",0,"Tarjeta","","onkeyup","CalculeDevuelta()",150,30,0,0,0,"",1);

                $VectorSelect["Nombre"]="CmbIdTarjeta";
                $VectorSelect["Evento"]="";
                $VectorSelect["Funcion"]="";
                $VectorSelect["Required"]=0;
                $css->CrearSelect2($VectorSelect);

                    $sql="SELECT * FROM tarjetas_forma_pago";
                    $Consulta=$obVenta->Query($sql);
                    //$css->CrearOptionSelect("", "Seleccione una tarjeta" , 0);
                    while($DatosCuenta=$obVenta->FetchArray($Consulta)){

                        $css->CrearOptionSelect("$DatosCuenta[ID]", "$DatosCuenta[Tipo] / $DatosCuenta[Nombre]" , 0);
                       }
                $css->CerrarSelect();
                print("<br>");

                $css->CrearInputNumber("TxtPagaCheque","number","Cheque: <br>",0,"Cheque","","onkeyup","CalculeDevuelta()",150,30,0,0,0,"",1);
                print("<br>");
                $css->CrearInputNumber("TxtPagaOtros","number","Otros: <br>",0,"Otros","","onkeyup","CalculeDevuelta()",150,30,0,0,0,"",1);
            $css->CerrarDiv();
        print("</td>");
    $css->CierraFilaTabla();   
    $css->FilaTabla(14);
        $css->ColTabla("<strong>+ Opciones: </strong>", 1);
        print("<td>");
        print("<image name='imgHidde' id='imgHidde' src='../images/hidde.png' onclick=MuestraOculta('DivOtrasOpciones');>");
        $css->CrearDiv("DivOtrasOpciones", "", "center", $Visible, 1);

                $VarSelect["Ancho"]="200";
                $VarSelect["PlaceHolder"]="Colaborador";
                $VarSelect["Title"]="";
                $css->CrearSelectChosen("TxtidColaborador", $VarSelect);

                    $sql="SELECT Nombre, Identificacion FROM colaboradores";
                    $Consulta=$obVenta->Query($sql);
                    $css->CrearOptionSelect("", "Colaborador: " , 0);
                    while($DatosColaborador=$obVenta->FetchArray($Consulta)){

                           $css->CrearOptionSelect("$DatosColaborador[Identificacion]", " $DatosColaborador[Nombre] $DatosColaborador[Identificacion]" , 0);
                       }
                $css->CerrarSelect();
                $VarSelect["Ancho"]="200";
                $VarSelect["PlaceHolder"]="Forma de Pago";
                $VarSelect["Title"]="";
                $css->CrearSelectChosen("TxtTipoPago", $VarSelect);

                    $sql="SELECT * FROM repuestas_forma_pago";
                    $Consulta=$obVenta->Query($sql);
                    while($DatosTipoPago=$obVenta->FetchArray($Consulta)){

                           $css->CrearOptionSelect("$DatosTipoPago[DiasCartera]", " $DatosTipoPago[Etiqueta]" , 0);
                       }
                $css->CerrarSelect();

                print("<br>");
                $css->CrearTextArea("TxtObservacionesFactura","","","Observaciones Factura","black","","",200,60,0,0);

                $css->CerrarDiv();
        print("</td>");
    $css->CierraFilaTabla(); 
   
        $css->FilaTabla(14);
        print("<td>");
            $css->CrearInputText("TxtDevuelta","text","Devuelta : ",0,"Devuelta","black","","",150,50,1,0,$ToolTip='Esta es la Devuelta');
            
	print("</td>");
        print("<td>");
            
            $css->CrearBotonEvento("BtnGuardar","Guardar",1,"onclick","EnviaFormVentasRapidas()","naranja","");
	print("</td>");
        $css->CierraFilaTabla(); 
        
    $css->CerrarTabla();
    $css->CerrarForm();
$css->AgregaJS(); //Agregamos javascripts
?>