<?php

/* 
 * Aqui se mostrará el total de una venta Rapida
 */

/////////////////////////////////////Se muestra el Cuadro con los valores de la preventa actual
    
    //$obVenta=new ProcesoVenta($idUser);
    
    $Subtotal=$obVenta->SumeColumna("preventa","Subtotal", "VestasActivas_idVestasActivas",$idPreventa);
    $IVA=$obVenta->SumeColumna("preventa","Impuestos", "VestasActivas_idVestasActivas",$idPreventa);
    $DatosPreventa=$obVenta->DevuelveValores("vestasactivas","idVestasActivas", $idPreventa);
    $SaldoFavor=$DatosPreventa["SaldoFavor"];
    if($SaldoFavor>0)
            $SaldoFavor=$SaldoFavor;
    else
            $SaldoFavor=0;

    $Total=$Subtotal+$IVA;
    $GranTotal=round($Total-$SaldoFavor);
    $css->CrearForm2("FrmGuarda",$myPage,"post","_self");
    $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",150,30,0,0);
    $css->CrearInputText("TxtSaldoFavor","hidden","",$SaldoFavor,"","","","",150,30,0,0);
    $css->ColTablaInputText("TxtTotalH","hidden",$Total,"","","","","",150,30,0,0);
    $css->ColTablaInputText("TxtCuentaDestino","hidden",11051001,"","","","","",150,30,0,0);
    $css->ColTablaInputText("TxtGranTotalH","hidden",$GranTotal,"","","","","",150,30,0,0);
    $css->CrearTabla();
    $css->FilaTabla(14);
    $css->ColTabla("Esta Venta:",3);
    $css->CierraFilaTabla();
    $css->FilaTabla(18);
    $css->ColTabla("SUBTOTAL:",1);
    $css->ColTabla(number_format($Subtotal),2);
    $css->CierraFilaTabla();
    $css->FilaTabla(18);
    $css->ColTabla("IMPUESTOS:",1);
    $css->ColTabla(number_format($IVA),2);
    $css->CierraFilaTabla();
    if($SaldoFavor>0){
            $css->FilaTabla(18);
            $css->ColTabla("SALDO A FAVOR:",1);
            $css->ColTabla(number_format($SaldoFavor),2);
            $css->CierraFilaTabla();

    }
    $css->FilaTabla(40);
    $css->ColTabla("TOTAL:",1);
    $css->ColTabla(number_format($Total),2);
    $css->CierraFilaTabla();
    if($SaldoFavor>0){
            $css->FilaTabla(40);
            $css->ColTabla("GRAN TOTAL:",1);
            $css->ColTabla(number_format($GranTotal),2);
            $css->CierraFilaTabla();
    }
    $css->FilaTabla(18);
    $css->ColTabla("PAGA:",1);
    $Visible=0;
    print("<td>");
    //$css->ColTablaInputText("TxtPaga","number","","","Paga","","onkeyup","CalculeDevuelta()",150,30,0,0); 
    $css->CrearInputNumber("TxtPaga","number","Efectivo: <br>",$Total,"Efectivo","","onkeyup","CalculeDevuelta()",150,30,0,1,"","",1);
    print("<strong>+</strong><image name='imgHidde' id='imgHidde' src='../images/hidde.png' onclick=MuestraOculta('DivOtrasOpcionesPago');>");
    $css->CrearDiv("DivOtrasOpcionesPago", "", "left", $Visible, 1);
    //print("<br>");
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
    print("<td>");
    
    print("<strong>+ Opciones </strong><image name='imgHidde' id='imgHidde' src='../images/hidde.png' onclick=MuestraOculta('DivOtrasOpciones');>");
    $css->CrearDiv("DivOtrasOpciones", "", "center", $Visible, 1);
    $VarSelect["Ancho"]="200";
    $VarSelect["PlaceHolder"]="Busque un Cliente";
    $VarSelect["Title"]="";
    $css->CrearSelectChosen("TxtCliente", $VarSelect);
    
        $sql="SELECT * FROM clientes";
        $Consulta=$obVenta->Query($sql);
        while($DatosCliente=$obVenta->FetchArray($Consulta)){
               
               $css->CrearOptionSelect("$DatosCliente[idClientes]", "$DatosCliente[Num_Identificacion] / $DatosCliente[RazonSocial] / $DatosCliente[Telefono]" , 0);
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
    $css->CerrarDiv();
    print("</td>");
    
    $css->CierraFilaTabla();

    $css->FilaTabla(18);
    $css->ColTabla("DEVOLVER:",1);
    $css->ColTablaInputText("TxtDevuelta","text",0,"","Devuelta","","","",150,50,1,0);
    print("<td>");
    $VectorBoton["Fut"]=0;
    $css->CrearBotonEvento("BtnGuardar","Guardar",1,"onclick","EnviaFormVentasRapidas()","naranja",$VectorBoton);
    print("</td>");
    //$css->ColTablaBoton("BtnGuardar","Guardar");
    $css->CierraFilaTabla();

    $css->CerrarTabla(); 
    $css->CerrarForm();
    
    /*
     * Dibujo los items en la preventa
     */
    
    $css->CrearTabla();
								
								
    $sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ORDER BY idPrecotizacion DESC";
    $pa=$obVenta->Query($sql);
    if($obVenta->NumRows($pa)){	
        $css->CrearNotificacionVerde("Items en Esta Preventa",16);
            $css->FilaTabla(18);
            $css->ColTabla('Referencia',1);
            $css->ColTabla('Nombre',1);
            $css->ColTabla('Cantidad',1);
            $css->ColTabla('ValorUnitario',1);
            $css->ColTabla('Subtotal',1);
            $css->ColTabla('Borrar',1);
            $css->CierraFilaTabla();

    while($DatosPreventa=$obVenta->FetchArray($pa)){
            $css->FilaTabla(16);
            $DatosProducto=$obVenta->DevuelveValores($DatosPreventa["TablaItem"],"idProductosVenta",$DatosPreventa["ProductosVenta_idProductosVenta"]);
            $css->ColTabla($DatosProducto['Referencia'],1);
            $css->ColTabla($DatosProducto['Nombre'],1);
            $NameTxt="TxtEditar$DatosPreventa[idPrecotizacion]";
            $Pass=$obVenta->DevuelveValores("autorizaciones_generales","ID",1);
            $Clave=$Pass["Clave"];
            $Evento="ConfirmarFormNegativo(`$NameTxt`,`$Clave`);return false;";
            
            $css->ColTablaFormInputText("FrmEdit$DatosPreventa[idPrecotizacion]",$myPage,"post","_self",$NameTxt,"Number",$DatosPreventa['Cantidad'],"","","","onClick",$Evento,"150","30","","","TxtPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa);
            $PrecioAcordado=round($DatosPreventa['ValorAcordado']);
            $Evento="ConfirmarFormPass(`$Clave`); return false;";
            $css->ColTablaFormEditarPrecio("FrmEditPrecio$DatosPreventa[idPrecotizacion]",$myPage,"post","_self","TxtEditarPrecio$DatosPreventa[idPrecotizacion]","Number",$PrecioAcordado,"","","","onClick",$Evento,"Habilita('TxtEditarPrecio$DatosPreventa[idPrecotizacion]','0')","150","30",0,0,"TxtPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa);
            $css->ColTabla(number_format($DatosPreventa['Subtotal']),1);
            $css->ColTablaDel($myPage,"preventa","idPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa);
            //$css->CierraColTabla();
            $css->CierraFilaTabla();
    }
    }else{
      $css->CrearNotificacionRoja("No hay items en esta preventa",20);  
    }
    $css->CerrarTabla();