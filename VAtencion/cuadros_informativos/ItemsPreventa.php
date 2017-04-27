<?php
$sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ORDER BY idPrecotizacion DESC";
    $pa=$obVenta->Query($sql);
    if($obVenta->NumRows($pa)){	
        //$css->CrearNotificacionVerde("Items en Esta Preventa",16);
        $css->DivTable();
            $css->DivRowTable();
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>Referencia</strong>");
                $css->CerrarDiv();
                
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>Nombre</strong>");
                $css->CerrarDiv();
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>Cantidad</strong>");
                $css->CerrarDiv();
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>ValorUnitario</strong>");
                $css->CerrarDiv();
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>Subtotal</strong>");
                $css->CerrarDiv();
                $css->DivColTable("center",0,1,"black","100%","");
                    print("<strong>Borrar</strong>");
                $css->CerrarDiv();
            $css->CerrarDiv();//Cierro Fila
            

    while($DatosPreventa=$obVenta->FetchArray($pa)){
            $css->DivRowTable();
            $DatosProducto=$obVenta->DevuelveValores($DatosPreventa["TablaItem"],"idProductosVenta",$DatosPreventa["ProductosVenta_idProductosVenta"]);
            $css->DivColTable("left",0,1,"black","100%","");
                    print("$DatosProducto[Referencia]");
            $css->CerrarDiv();
            $css->DivColTable("left",0,1,"black","100%","");
                    print("$DatosProducto[Nombre]");
            $css->CerrarDiv();
            
            $Autorizado=!$DatosPreventa["Autorizado"];
            $NameTxt="TxtEditar$DatosPreventa[idPrecotizacion]";
            
            if($Autorizado){
                $Evento="ConfirmarFormNegativo(`$NameTxt`);return false;";
                $VectorDatosExtra["JS"]="onclick='ConfirmarFormPass(); return false;'";
            }else{
                $Evento="";
                $VectorDatosExtra["JS"]="";
            }
            $css->DivColTablaFormInputText("FrmEdit$DatosPreventa[idPrecotizacion]",$myPage,"post","_self",$NameTxt,"Number",$DatosPreventa['Cantidad'],"","","","onClick",$Evento,"150","30","","","TxtPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa);
            $PrecioAcordado=round($DatosPreventa['ValorAcordado']);
            
            $css->DivColTablaFormEditarPrecio("FrmEditPrecio$DatosPreventa[idPrecotizacion]",$myPage,"post","_self","TxtEditarPrecio$DatosPreventa[idPrecotizacion]","Number",$PrecioAcordado,"","","","","","","150","30",$Autorizado,0,"TxtPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa,"TxtPrecioMayor",$DatosProducto["PrecioMayorista"]);
            $css->DivColTable("right",0,1,"black","100%","");
                    print("<strong>".number_format($DatosPreventa['TotalVenta'])."</strong>");
            $css->CerrarDiv();
            
            $css->DivColTable("center",0,1,"black","100%","");
            $VectorDatosExtra["ID"]="LinkDel$DatosPreventa[idPrecotizacion]";
            
            $link="$myPage?del=$DatosPreventa[idPrecotizacion]&TxtTabla=preventa&TxtIdTabla=idPrecotizacion&TxtIdPre=$idPreventa";
            $css->CrearLinkID($link,"_self","X",$VectorDatosExtra);
            $css->CerrarDiv();
            
            $css->CerrarDiv();//Cierro la tabla
    }
    $css->CerrarDiv();//Cierro la tabla
    }else{
      $css->CrearNotificacionRoja("No hay items en esta preventa",20);  
    }