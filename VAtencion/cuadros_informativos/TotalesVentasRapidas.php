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
    $css->CrearForm2("FrmGuarda",$myPage,"post","_self");
    $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",150,30,0,0);
    $css->CrearInputText("TxtSaldoFavor","hidden","",$SaldoFavor,"","","","",150,30,0,0);
    $css->CrearInputText("TxtTotalH","hidden","",$Total,"","","","",150,30,0,0);
    $css->CrearInputText("TxtCuentaDestino","hidden","",11051001,"","","","",150,30,0,0);
    $css->CrearInputText("TxtGranTotalH","hidden","",$GranTotal,"","","","",150,30,0,0);
    $css->DivTable(); 
        $css->DivRowTable();
            $css->DivColTable("left",0,1,"black","150%","");
                print("<strong>Ultima Devuelta : </strong>");
            $css->CerrarDiv();
            $css->DivColTable("right",0,1,"black","150%","");
                print("<strong>".number_format($DatosDevuelta["Devuelve"])."<strong>");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
       
        $css->DivRowTable();
            $css->DivColTable("left",0,1,"black","120%","");
                print("<strong>Cantidad de Productos : </strong>");
            $css->CerrarDiv();
            $css->DivColTable("right",0,1,"black","120%","");
                print("<strong>".number_format($SumaItemsPreventa["NumItems"])."</strong> <br> ");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
    $css->CerrarDiv();//Cierro tabla
    print("<br>");
    $css->DivTable(); 
        
        $css->DivRowTable();
            $css->DivColTable("left",0,1,"black","100%","");
                print("<strong>SUBTOTAL : </strong>");
            $css->CerrarDiv();
            $css->DivColTable("right",0,1,"black","100%","");
                print("<strong>".number_format($Subtotal)."</strong> ");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        
        $css->DivRowTable();
            $css->DivColTable("left",0,1,"black","100%","");
                print("<strong>IMPUESTOS : </strong>");
            $css->CerrarDiv();
            $css->DivColTable("right",0,1,"black","100%","");
                print("<strong>".number_format($IVA)."</strong> ");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        $css->DivRowTable();
            
            $css->DivColTable("center",0,1,"gray","10%","");
                print("_");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        $css->DivRowTable();
            $css->DivColTable("left",0,1,"blue","200%","");
                print("<strong>TOTAL : </strong>");
            $css->CerrarDiv();
            $css->DivColTable("right",0,1,"blue","180%","");
                print("<strong>".number_format($Total)."</strong>");
            $css->CerrarDiv();
            
        $css->CerrarDiv();//Cierro Fila
        $css->DivRowTable();
            
            $css->DivColTable("center",0,1,"gray","100%","");
                print("__");
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        $Visible=0;
        $css->DivRowTable();
            
            $css->DivColTable("center",0,1,"black","100%","");
                $css->CrearInputNumber("TxtPaga","number","Efectivo:",round($Total),"Efectivo","","onkeyup","CalculeDevuelta()",150,30,0,1,"","",1);
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
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        
        $css->DivRowTable();            
            $css->DivColTable("left",0,1,"black","100%","");
                print("<strong>+ Opciones </strong><image name='imgHidde' id='imgHidde' src='../images/hidde.png' onclick=MuestraOculta('DivOtrasOpciones');>");
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

                print("<br>");
                $css->CrearTextArea("TxtObservacionesFactura","","","Observaciones Factura","black","","",200,60,0,0);

                $css->CerrarDiv();
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        
        $css->DivRowTable();
            
            $css->DivColTablaInputText("TxtDevuelta","text",0,"<strong>Devolver: <strong>","Devuelta","","","",150,50,1,0);
            
        $css->CerrarDiv();//Cierro Fila
        
        $css->DivRowTable();
            
            
            $css->DivColTable("left",0,1,"blue","180%","");
                $VectorBoton["Fut"]=0;
                $css->CrearBotonEvento("BtnGuardar","Guardar",1,"onclick","EnviaFormVentasRapidas()","naranja",$VectorBoton);
            $css->CerrarDiv();
        $css->CerrarDiv();//Cierro Fila
        
    $css->CerrarDiv();//Cierro tabla
    
    $css->CerrarForm();