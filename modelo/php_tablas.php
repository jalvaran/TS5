<?php

include_once("php_conexion.php");

/*
 * Esta clase contiene los datos necesarios para tratar y dibujar las tablas
 * 
 */

class Tabla{
    public $DataBase;
    public $obCon;
    public $css;
    /*
     * Se utilizará para seleccionar las columnas de la exportacion a excel
     */
    public $Campos = array("A","B","C","D","E","F","G","H","I","J","K","L",
    "M","N","O","P","Q","R","S","T","C","V","W","X","Y","Z","AA","AB");
    public $Condicionales = array(" ","=","*",">","<",">=","<=","<>");
    function __construct($db){
        $this->DataBase=$db;
        $this->obCon=new ProcesoVenta(1);
        //$this->css=new CssIni("");
    }
   
    
/*
 *Funcion devolver los nombres de las columnas de una tabla
 */
    
public function Columnas($Vector){
    
    $Tabla=$Vector["Tabla"];
    $sql="SHOW COLUMNS FROM `$this->DataBase`.`$Tabla`;";
    $Results=$this->obCon->Query($sql);
    $i=0;
    while($Columnas = $this->obCon->FetchArray($Results) ){
        $Nombres[$i]=$Columnas["Field"];
        $i++;
        
    }
    return($Nombres);
}
   
/*
 *Funcion devolver todas los atributos de las columnas de una tablas
 */
    
public function ColumnasInfo($Vector){
    
    $Tabla=$Vector["Tabla"];
    $sql="SHOW COLUMNS FROM `$this->DataBase`.`$Tabla`;";
    $Results=$this->obCon->Query($sql);
    $i=0;
    while($Columnas = $this->obCon->FetchArray($Results) ){
        $Nombres["Field"][$i]=$Columnas["Field"];
        $Nombres["Type"][$i]=$Columnas["Type"];
        $Nombres["Null"][$i]=$Columnas["Null"];
        $Nombres["Key"][$i]=$Columnas["Key"];
        $Nombres["Default"][$i]=$Columnas["Default"];
        $Nombres["Extra"][$i]=$Columnas["Extra"];
        $i++;
        
    }
    return($Nombres);
}


/*
 *Funcion devolver el ultimo autoincremento
 */
    
public function ObtengaAutoIncrement($Vector){
    
    $Tabla=$Vector["Tabla"];
    $sql="SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA='$this->DataBase' and TABLE_NAME='$Tabla'";
    $Results=$this->obCon->Query($sql);
    $Results=$this->obCon->FetchArray($Results);
    return($Results["AUTO_INCREMENT"]);
}


/*
 *Funcion devolver un ID Unico
 */
    
public function ObtengaID(){
    
    $ID=date("YmdHis").microtime(false);
    return($ID);
}

/*
 * Funcion arme filtros
 */
    
public function CreeFiltro($Vector){
       
    $Columnas=$this->Columnas($Vector);
    $Tabla=$Vector["Tabla"];
    $Filtro=" $Tabla";
    $z=0;
    
    $NumCols=count($Columnas);
    foreach($Columnas as $NombreCol){
        $IndexFiltro="Filtro_".$NombreCol;  //Campo que trae el valor del filtro a aplicar
        $IndexCondicion="Cond_".$NombreCol; // Condicional para aplicacion del filtro
        $IndexTablaVinculo="TablaVinculo_".$NombreCol; // Si hay campos vinculados se encontra la tabla vinculada aqui 
        $IndexIDTabla="IDTabla_".$NombreCol;           // Id de la tabla vinculada
        $IndexDisplay="Display_".$NombreCol;           // Campo que se quiere ver
        if(!empty($_REQUEST[$IndexFiltro])){
            $Valor=$_REQUEST[$IndexFiltro];
            if(!empty($_REQUEST[$IndexTablaVinculo])){
                $sql="SELECT $_REQUEST[$IndexIDTabla] FROM $_REQUEST[$IndexTablaVinculo] "
                        . "WHERE $_REQUEST[$IndexDisplay] = '$Valor'";
                $DatosVinculados=$this->obCon->Query($sql);
                $DatosVinculados=$this->obCon->FetchArray($DatosVinculados);
                //print($sql);
                $Valor=$DatosVinculados[$_REQUEST[$IndexIDTabla]];
            }
            
            if($z==0){
                $Filtro.=" WHERE ";
                $z=1;
            }
            $Filtro.=$NombreCol;
            switch ($_REQUEST[$IndexCondicion]){
                case 1:
                    $Filtro.="='$Valor'";
                    break;
                case 2:
                    $Filtro.=" LIKE '%$Valor%'";
                    break;
                case 3:
                    $Filtro.=">'$Valor'";
                    break;
                case 4:
                    $Filtro.="<'$Valor'";
                    break;
                case 5:
                    $Filtro.=">='$Valor'";
                    break;
                case 6:
                    $Filtro.="<='$Valor'";
                    break;
                case 7:
                    $Filtro.="<>'$Valor'";
                    break;
            }
            $And=" AND ";
            
            
            $Filtro.=$And;
           
        }
       
    }
    if($z>0){
        $Filtro=substr($Filtro, 0, -4);
    }
    return($Filtro);
}

/*
 * Funcion arme filtros
 */
    
public function CreeFiltroCuentas($Vector){
       
    $Columnas=$this->Columnas($Vector);
    $Tabla=$Vector["Tabla"];
    $Filtro=" $Tabla WHERE (`CuentaPUC` like '2205%' or `CuentaPUC` like '2380%' or `CuentaPUC` like '21%') AND Estado ='' AND Neto < 0 ";
    $z=0;
    
    $NumCols=count($Columnas);
    foreach($Columnas as $NombreCol){
        $IndexFiltro="Filtro_".$NombreCol;  //Campo que trae el valor del filtro a aplicar
        $IndexCondicion="Cond_".$NombreCol; // Condicional para aplicacion del filtro
        $IndexTablaVinculo="TablaVinculo_".$NombreCol; // Si hay campos vinculados se encontra la tabla vinculada aqui 
        $IndexIDTabla="IDTabla_".$NombreCol;           // Id de la tabla vinculada
        $IndexDisplay="Display_".$NombreCol;           // Campo que se quiere ver
        if(!empty($_REQUEST[$IndexFiltro])){
            $Valor=$_REQUEST[$IndexFiltro];
            if(!empty($_REQUEST[$IndexTablaVinculo])){
                $sql="SELECT $_REQUEST[$IndexIDTabla] FROM $_REQUEST[$IndexTablaVinculo] "
                        . "WHERE $_REQUEST[$IndexDisplay] = '$Valor'";
                $DatosVinculados=$this->obCon->Query($sql);
                $DatosVinculados=$this->obCon->FetchArray($DatosVinculados);
                //print($sql);
                $Valor=$DatosVinculados[$_REQUEST[$IndexIDTabla]];
            }
            
            if($z==0){
                $Filtro.=" AND ";
                $z=1;
            }
            $Filtro.=$NombreCol;
            switch ($_REQUEST[$IndexCondicion]){
                case 1:
                    $Filtro.="='$Valor'";
                    break;
                case 2:
                    $Filtro.=" LIKE '%$Valor%'";
                    break;
                case 3:
                    $Filtro.=">'$Valor'";
                    break;
                case 4:
                    $Filtro.="<'$Valor'";
                    break;
                case 5:
                    $Filtro.=">='$Valor'";
                    break;
                case 6:
                    $Filtro.="<='$Valor'";
                    break;
                case 7:
                    $Filtro.="<>'$Valor'";
                    break;
            }
            $And=" AND ";
            
            
            $Filtro.=$And;
           
        }
       
    }
    
    if($z>0){
        $Filtro=substr($Filtro, 0, -4);
    }
    
    //$Filtro.=" GROUP BY `CuentaPUC`, `Tercero_Identificacion`";
    return($Filtro);
}

/*
 * Cuentas por cobrar
 * 
 */
public function CreeFiltroCobros($Vector){
       
    $Columnas=$this->Columnas($Vector);
    $Tabla=$Vector["Tabla"];
    $Filtro=" $Tabla WHERE `CuentaPUC` like '1305%' AND Estado ='' AND Neto > 0";
    $z=0;
    
    $NumCols=count($Columnas);
    foreach($Columnas as $NombreCol){
        $IndexFiltro="Filtro_".$NombreCol;  //Campo que trae el valor del filtro a aplicar
        $IndexCondicion="Cond_".$NombreCol; // Condicional para aplicacion del filtro
        $IndexTablaVinculo="TablaVinculo_".$NombreCol; // Si hay campos vinculados se encontra la tabla vinculada aqui 
        $IndexIDTabla="IDTabla_".$NombreCol;           // Id de la tabla vinculada
        $IndexDisplay="Display_".$NombreCol;           // Campo que se quiere ver
        if(!empty($_REQUEST[$IndexFiltro])){
            $Valor=$_REQUEST[$IndexFiltro];
            if(!empty($_REQUEST[$IndexTablaVinculo])){
                $sql="SELECT $_REQUEST[$IndexIDTabla] FROM $_REQUEST[$IndexTablaVinculo] "
                        . "WHERE $_REQUEST[$IndexDisplay] = '$Valor'";
                $DatosVinculados=$this->obCon->Query($sql);
                $DatosVinculados=$this->obCon->FetchArray($DatosVinculados);
                //print($sql);
                $Valor=$DatosVinculados[$_REQUEST[$IndexIDTabla]];
            }
            
            if($z==0){
                $Filtro.=" AND ";
                $z=1;
            }
            $Filtro.=$NombreCol;
            switch ($_REQUEST[$IndexCondicion]){
                case 1:
                    $Filtro.="='$Valor'";
                    break;
                case 2:
                    $Filtro.=" LIKE '%$Valor%'";
                    break;
                case 3:
                    $Filtro.=">'$Valor'";
                    break;
                case 4:
                    $Filtro.="<'$Valor'";
                    break;
                case 5:
                    $Filtro.=">='$Valor'";
                    break;
                case 6:
                    $Filtro.="<='$Valor'";
                    break;
                case 7:
                    $Filtro.="<>'$Valor'";
                    break;
            }
            $And=" AND ";
            
            
            $Filtro.=$And;
           
        }
       
    }
    
    if($z>0){
        $Filtro=substr($Filtro, 0, -4);
    }
    
    //$Filtro.=" GROUP BY `CuentaPUC`, `Tercero_Identificacion`";
    return($Filtro);
}
/*
 * 
 * Funcion para crear una tabla con los datos de una tabla
 * 
 */
  
public function DibujeTabla($Vector){
    //print_r($Vector);
    $this->css=new CssIni("");
    $Tabla["Tabla"]=$Vector["Tabla"];
    $tbl=$Tabla["Tabla"];
    $Titulo=$Vector["Titulo"];
    $VerDesde=$Vector["VerDesde"];
    $Limit=$Vector["Limit"];
    $Order=$Vector["Order"];
    $statement=$Vector["statement"];
    
    $Columnas=$this->Columnas($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    
    $myPage="$Tabla[Tabla]".".php";
    if(isset($Vector["MyPage"])){
        $myPage=$Vector["MyPage"];
    }
    $NumCols=count($Columnas);
    $Compacto= urlencode(json_encode($Vector));
    //$Compacto=urlencode($Compacto);
    if(!isset($Vector["NuevoRegistro"]["Deshabilitado"])){
        $this->css->CrearFormularioEvento("FrmAgregar", "InsertarRegistro.php", "post", "_self", "");
        $this->css->CrearInputText("TxtParametros", "hidden", "", $Compacto, "", "", "", "", "", "", "", "");
        $this->css->CrearBotonNaranja("BtnAgregar", "Agregar Nuevo Registro");
        $this->css->CerrarForm();
    }
    $this->css->CrearFormularioEvento("FrmFiltros", $myPage, "post", "_self", "");
    $this->css->CrearInputText("TxtSql", "hidden", "", $statement, "", "", "", "", "", "", "", "");
    $ColFiltro=$NumCols-1;
    $this->css->CrearTabla();
    $this->css->FilaTabla(18);
    print("<td ><strong>$Titulo </strong>");
    print("</td>");
    print("<td style='text-align: left' colspan=$ColFiltro>");
    $this->css->CrearLink("","_self","Limpiar ");
    $this->css->CrearBotonVerde("BtnFiltrar", "Filtrar");
    
    $this->css->CrearBoton("BtnExportarExcel", "Exportar a Excel");
    print("</td>");
    $this->css->CierraFilaTabla();
    
        $this->css->FilaTabla(14);
        $i=0;
        $this->css->ColTabla("<strong>Acciones</strong>","");
        if(isset($Vector["ProductosVenta"])){
           $this->css->ColTabla("<strong>Imprimir</strong>","");

        }
        if(isset($Vector["Abonos"])){
            $this->css->ColTabla("<strong>Abonar</strong>","");
        }
        foreach($Columnas as $NombreCol){
            if(isset($Vector[$NombreCol]["Link"])){
                $Colink[$i]=1;
            }
            if(!isset($Vector["Excluir"][$NombreCol])){
                
                print("<td><strong>$NombreCol</strong><br>");
                $Ancho=strlen($NombreCol)."0";
                if($Ancho<50){
                    $Ancho=50;
                }
                $DatosSel["Nombre"]="Cond_".$NombreCol;
                $DatosSel["Evento"]="";
                $DatosSel["Ancho"]=50;
                $DatosSel["Alto"]=30;
                $this->css->CrearSelectPers($DatosSel);
                    $IndexCondicion="Cond_".$NombreCol; // Condicional para aplicacion del filtro
                    $Activo=0;
                    for($h=1;$h<=7;$h++){
                        if(isset($_REQUEST[$IndexCondicion])){
                            if($_REQUEST[$IndexCondicion]==$h){
                               $Activo=1; 
                            }else{
                               $Activo=0; 
                            }
                              
                        }
                        
                       $this->css->CrearOptionSelect($h, $this->Condicionales[$h], $Activo);
                    }
                $this->css->CerrarSelect();
                $ValorFiltro="";
                if(!empty($_REQUEST["Filtro_".$NombreCol])){
                    $ValorFiltro=$_REQUEST["Filtro_".$NombreCol];
                }
                print("<br>");
                $this->css->CrearInputText("Filtro_".$NombreCol, "Text", "", $ValorFiltro, "Filtrar", "black", "", "", $Ancho, 30, 0, 0);
                
                print("</td>");
                $VisualizarRegistro[$i]=1;
            }
            if(isset($Vector[$NombreCol]["Vinculo"])){
                $VinculoRegistro[$i]["Vinculado"]=1;
                $VinculoRegistro[$i]["TablaVinculo"]=$Vector[$NombreCol]["TablaVinculo"];
                $VinculoRegistro[$i]["IDTabla"]=$Vector[$NombreCol]["IDTabla"];  
                $VinculoRegistro[$i]["Display"]=$Vector[$NombreCol]["Display"];
                $this->css->CrearInputText("TablaVinculo_".$NombreCol, "hidden", "", $Vector[$NombreCol]["TablaVinculo"], "", "black", "", "", $Ancho, 30, 0, 0);
                $this->css->CrearInputText("IDTabla_".$NombreCol, "hidden", "", $Vector[$NombreCol]["IDTabla"], "", "black", "", "", $Ancho, 30, 0, 0);
                $this->css->CrearInputText("Display_".$NombreCol, "hidden", "", $Vector[$NombreCol]["Display"], "", "black", "", "", $Ancho, 30, 0, 0);
            }
            
            if(isset($Vector[$NombreCol]["NewLink"]) ){
                $NewLink[$i]["Link"]=$Vector[$NombreCol]["NewLink"];
                $NewLink[$i]["Titulo"]=$Vector[$NombreCol]["NewLinkTitle"];  
            }
                
            if(isset($Vector["NewText"][$NombreCol]) ){
               $NewText[$i]["NewText"]=$Vector["NewText"][$NombreCol];
            }
            $i++;
            
        }
        
        $this->css->CierraFilaTabla();
        $this->css->CerrarForm();
        $this->css->CrearForm2("FrmItemsTabla", $myPage, "post", "_self");
        if(isset($Vector["idComprobante"])){
        $this->css->CrearInputText("idComprobante", "hidden", "", $Vector["idComprobante"], "", "", "", "", "", "", 0, 0);
        }
        $sql="SELECT * FROM $statement ORDER BY $Order LIMIT $VerDesde,$Limit ";
        $Consulta=  $this->obCon->Query($sql);
        $Parametros=urlencode(json_encode($Vector));
        while($DatosProducto=$this->obCon->FetchArray($Consulta)){
            $this->css->FilaTabla(12);
            print("<td>");
            if(!isset($Vector["VerRegistro"]["Deshabilitado"])){
                
                $Ruta="";
                if(isset($Vector["VerRegistro"]["Link"]) and isset($Vector["VerRegistro"]["ColumnaLink"])){
                    $Ruta=$Vector["VerRegistro"]["Link"];
                    $ColumnaLink=$Vector["VerRegistro"]["ColumnaLink"];
                    $Ruta.=$DatosProducto[$ColumnaLink];
                }
                
                
                
                $this->css->CrearLink($Ruta,"_blank", "Ver // ");
            }
            if(!isset($Vector["EditarRegistro"]["Deshabilitado"])){
                $Ruta="EditarRegistro.php?&TxtIdEdit=$DatosProducto[0]&TxtParametros=$Parametros";
                $this->css->CrearLink($Ruta, "_self", "Editar // ");
            }
            /*
             * Espacio para nuevas acciones
             */
            if(isset($Vector["NuevaAccion"])){
                //$NumAcciones=count($Vector["NuevaAccion"]["Titulo"]);
                foreach($Vector["NuevaAccionLink"] as $NuevaAccion){
                    $TituloLink=$Vector["NuevaAccion"][$NuevaAccion]["Titulo"];
                    if($NuevaAccion=="ChkID"){
                        echo "$TituloLink: <input type='checkbox' name='ChkID[]' value=$DatosProducto[0]></input><br><br>";
                        echo "<input type='submit' name='BtnEnviarChk' value='Agregar' class='btn btn-danger'></input>";
                    }else{
                    $Target=$Vector["NuevaAccion"][$NuevaAccion]["Target"];
                    $Ruta=$Vector["NuevaAccion"][$NuevaAccion]["Link"];
                    $ColumnaLink=$Vector["NuevaAccion"][$NuevaAccion]["ColumnaLink"];
                    $Ruta.=$DatosProducto[$ColumnaLink];
                    $this->css->CrearLink($Ruta,$Target, " // $TituloLink // ");
                    }
                }
                
                
            }
            
            print("</td>");
            
            if(isset($Vector["Abonos"])){
                print("<td>");
                $idLibro=$DatosProducto[0];
                $TipoAbono=$Vector["Abonos"];
                $AbonosActuales=$this->obCon->Sume("abonos_libro", "Cantidad", "WHERE idLibroDiario='$idLibro' AND TipoAbono='$TipoAbono'");
                
                $Procesador=$Vector["Procesador"];
                $TablaAbono=$Vector["TablaAbono"];
                if($TipoAbono=="CuentasXCobrar"){
                    $Factor=1;
                }
                if($TipoAbono=="CuentasXPagar"){
                    $Factor="-1";
                }
                $Saldo=$DatosProducto["Neto"]*$Factor;
                $Saldo=$Saldo-$AbonosActuales;
                print("Saldo: $".number_format($Saldo)."<br>");
                $idFecha="TxtFecha".$DatosProducto[0];
                $idCantidad="TxtAbono".$DatosProducto[0];
                $idLink="LinkAbono".$DatosProducto[0];
                $idSelect="CmbAbono".$DatosProducto[0];
                $Page=$Vector["MyPage"];
                $this->css->CrearInputText($idFecha, "text", "Fecha: ", date("Y-m-d"), "Fecha", "black", "onchange", "CambiaLinkAbono('$idFecha',$idLibro','$idLink','$idCantidad','$idSelect','$Page','$Page','$TablaAbono')", 100, 30, 0, 0);
                print("<br>");
                $this->css->CrearInputNumber($idCantidad, "number", "Abono:", 0, "Cantidad", "black", "onchange", "CambiaLinkAbono('$idFecha','$idLibro','$idLink','$idCantidad','$idSelect','$Page','$Page','$TablaAbono')", 100, 30, 0, 0, "", $Saldo, "any");
                
                $this->css->CrearSelect($idSelect, "CambiaLinkAbono('$idFecha','$idLibro','$idLink','$idCantidad','$idSelect','$Page','$Page','$TablaAbono')");
                    $ConsultaCuentasFrecuentes=$this->obCon->ConsultarTabla("cuentasfrecuentes", "");
                    //$this->css->CrearOptionSelect(0, "Cuenta ingreso", 1);
                    while($DatosCuenta=  $this->obCon->FetchArray($ConsultaCuentasFrecuentes)){
                        $this->css->CrearOptionSelect($DatosCuenta["CuentaPUC"], $DatosCuenta["Nombre"], 0);
                    }
                $this->css->CerrarSelect();
                
                $VectorDatosExtra["ID"]=$idLink;
                $VectorDatosExtra["JS"]=' onclick="ConfirmarLink('.$idLink.');return false" ';
                //$this->css->CrearLinkID($Procesador, "_self", "Abonar",$VectorDatosExtra);
                $this->css->CrearBotonConfirmado("BtnAbonar", $DatosProducto[0]);
                print("</td>");
                
            }
            
            if(isset($Vector["ProductosVenta"])){
                print("<td>");
                $idProducto=$DatosProducto[0];
                
                $this->css->CrearInputNumber("TxtCantidadCodigos$idProducto", "number", "Cantidad:", 1, "Cantidad", "black", "", "", 100, 30, 0, 0, 1, 1000, 1);
                print("<br>");
                $this->css->CrearBoton("BtnImprimirBarCode", $idProducto);
                print("</td>");
                
            }
            
            for($i=0;$i<$NumCols;$i++){
                
                
                if(isset($VisualizarRegistro[$i])){
                    
                    if(!isset($VinculoRegistro[$i]["Vinculado"])){
                        print("<td>");
                        if(isset($Colink[$i])){
                            
                            $this->css->CrearLink($DatosProducto[$i], "_blank", $DatosProducto[$i]);
                        }else{
                            if(isset($NewLink[$i]["Link"])){
                                $Page=$Vector["Kit"]["Page"];
                                
                                $idProducto=$DatosProducto[0];
                                $idLink="LinkCol".$DatosProducto[0];
                                $idCantidad="TxtCantidad".$DatosProducto[0];
                                $idSelect="CmbKit".$DatosProducto[0];
                                $this->css->CrearSelect($idSelect, "CambiaLinkKit('$idProducto','$idLink','$idCantidad','$idSelect','$Page')");
                                    $ConsultaKits=$this->obCon->ConsultarTabla("kits", "");
                                    $this->css->CrearOptionSelect(0, "Seleccione un kit", 1);
                                    while($DatosKits=  $this->obCon->FetchArray($ConsultaKits)){
                                        $this->css->CrearOptionSelect($DatosKits["ID"], $DatosKits["Nombre"], 0);
                                    }
                                $this->css->CerrarSelect();
                                $this->css->CrearInputNumber($idCantidad, "number", "", 0, "Cantidad", "black", "onchange", "CambiaLinkKit('$idProducto','$idLink','$idCantidad','$idSelect','$Page')", 100, 30, 0, 0, 0, "", "any");
                                $VectorDatosExtra["ID"]=$idLink;
                                $this->css->CrearLinkID($NewLink[$i]["Link"], "_self", $NewLink[$i]["Titulo"],$VectorDatosExtra);
                            }else{
                                print("$DatosProducto[$i]"); 
                            }
                        }
                        print("</td>");
                       
                    }else{
                        $TablaVinculo=$VinculoRegistro[$i]["TablaVinculo"];
                        $ColDisplay=$VinculoRegistro[$i]["Display"];
                        $idTablaVinculo=$VinculoRegistro[$i]["IDTabla"];
                        $ID=$DatosProducto[$i];
                        //print("datos: $TablaVinculo $ColDisplay $idTablaVinculo $ID");                    
                        $sql1="SELECT $ColDisplay FROM $TablaVinculo WHERE $idTablaVinculo='$ID'";
                        $Consul=$this->obCon->Query($sql1);
                        $DatosVinculo=$this->obCon->FetchArray($Consul);
                        
                        print("<td>");
                        if(isset($Colink[$i])){
                            
                            $this->css->CrearLink($DatosVinculo[$ColDisplay], "_blank", $DatosVinculo[$ColDisplay]);
                        }else{
                            
                            print("$DatosVinculo[$ColDisplay]");
                            
                        }
                        print("</td>");
                        
                    }
                }
            }
            print("</tr>");
        }
        $this->css->CierraFilaTabla();
    $this->css->CerrarForm();
    $this->css->CerrarTabla();
    
    
    //return($sql);
}
 
/*
 * Verificamos si hay peticiones de exportacion
 */
    
public function VerifiqueExport($Vector)  {
    
    if(isset($_REQUEST["BtnExportarExcel"])){
       $statement=$_REQUEST["TxtSql"];
    require_once '../librerias/Excel/PHPExcel.php';
   $objPHPExcel = new PHPExcel();    
        
   $Tabla["Tabla"]=$Vector["Tabla"];
    $tbl=$Tabla["Tabla"];
    $Titulo=$Vector["Titulo"];
    $VerDesde=$Vector["VerDesde"];
    $Limit=$Vector["Limit"];
    $Order=$Vector["Order"];
    
    $tbl=$Vector["Tabla"];
    $Columnas=$this->Columnas($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
   
    $i=0;
 $a=0;
 foreach($Columnas as $NombreCol){ 
     if(!isset($Vector["Excluir"][$NombreCol])){
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[$a]."1",$NombreCol);
        $VisualizarRegistro[$i]=1;
        $a++;	
     }
     if(isset($Vector[$NombreCol]["Vinculo"])){
                $VinculoRegistro[$i]["Vinculado"]=1;
                $VinculoRegistro[$i]["TablaVinculo"]=$Vector[$NombreCol]["TablaVinculo"];
                $VinculoRegistro[$i]["IDTabla"]=$Vector[$NombreCol]["IDTabla"];  
                $VinculoRegistro[$i]["Display"]=$Vector[$NombreCol]["Display"];
     }
     $i++;
 }
    
    
   $IndexFiltro="Filtro_".$NombreCol;  //Campo que trae el valor del filtro a aplicar
    $IndexCondicion="Cond_".$NombreCol; // Condicional para aplicacion del filtro
    $IndexTablaVinculo="TablaVinculo_".$NombreCol; // Si hay campos vinculados se encontra la tabla vinculada aqui 
    $IndexIDTabla="IDTabla_".$NombreCol;           // Id de la tabla vinculada
    $IndexDisplay="Display_".$NombreCol;           // Campo que se quiere ver
        
   
    
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.technosoluciones.com")
        ->setLastModifiedBy("www.technosoluciones.com")
        ->setTitle("Exportar $tbl  desde base de datos")
        ->setSubject("$tbl")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("techno soluciones")
        ->setCategory("$tbl");    
 $NumCols=count($Columnas);
 
 
 $i=0;
 $a=0;
 $c=2;
 $sql="SELECT * FROM $statement ";
        $Consulta=  $this->obCon->Query($sql);
        while($DatosTabla=mysql_fetch_object($Consulta)){
            foreach($Columnas as $NombreCol){
                if(isset($VisualizarRegistro[$i])){
                    if(!isset($VinculoRegistro[$i]["Vinculado"])){
                        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($this->Campos[$a].$c,$DatosTabla->$NombreCol);
                    }else{
                        $TablaVinculo=$VinculoRegistro[$i]["TablaVinculo"];
                        $ColDisplay=$VinculoRegistro[$i]["Display"];
                        $idTablaVinculo=$VinculoRegistro[$i]["IDTabla"];
                        $ID=$DatosTabla->$NombreCol;
                        //print("datos: $TablaVinculo $ColDisplay $idTablaVinculo $ID");                    
                        $sql1="SELECT $ColDisplay  FROM $TablaVinculo WHERE $idTablaVinculo ='$ID'";
                        $Consul=$this->obCon->Query($sql1);
                        $DatosVinculo=  mysql_fetch_array($Consul);
                        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($this->Campos[$a].$c,$DatosVinculo[$ColDisplay]);
                    }
                    $a++;
                    
                }
                
                $i++;
                if($i==$NumCols){
                    $i=0;
                    $c++;
                    $a=0;
                }
            }
        }
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$tbl.'.xls"');
    header('Cache-Control: max-age=0');

    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    exit; 
   
    }    
}

/*
 * 
 * Funcion para crear un formulario para crear un nuevo registro en una tabla
 * 
 */

    
public function FormularioInsertRegistro($Parametros,$VarInsert)  {
    //print_r($Vector);
    $this->css=new CssIni("");
    $Tabla["Tabla"]=$Parametros->Tabla;
    $tbl=$Tabla["Tabla"];
    $Titulo=$Parametros->Titulo;
    
    $Columnas=$this->Columnas($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    $ColumnasInfo=$this->ColumnasInfo($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    
    $myPage="$Tabla[Tabla]".".php";
    $NumCols=count($Columnas);
    
    $this->css->CrearFormularioEvento("FrmGuardarRegistro", "procesadores/procesaInsercion.php", "post", "_self", "");
    $this->css->CrearInputText("TxtTablaInsert", "hidden", "", $tbl, "", "", "", "", "", "", "", "");
    $this->css->CrearTabla();
    $this->css->FilaTabla(18);
    print("<td style='text-align: center'><strong>$Titulo</strong>");
    print("</td>");
    $this->css->CierraFilaTabla();
    
    
    $i=0;
        
    foreach($Columnas as $NombreCol){
        $this->css->FilaTabla(14);
        $excluir=0;
        
        if(isset($VarInsert[$tbl][$NombreCol]["Excluir"])){
            $excluir=1;
        }
        $TipoText="text";
        if(isset($VarInsert[$tbl][$NombreCol]["TipoText"])){
            $TipoText=$VarInsert[$tbl][$NombreCol]["TipoText"];
        }
        if(!$excluir){  //Si la columna no está excluida
           $lengCampo=preg_replace('/[^0-9]+/', '', $ColumnasInfo["Type"][$i]); //Determinamos la longitud del campo
           if($lengCampo<1){
               $lengCampo=45;
           }
           if($ColumnasInfo["Type"][$i]=="text"){
               $lengCampo=100;
           }
           $Value=$ColumnasInfo["Default"][$i];
           $Required=0;
           $ReadOnly=0;
           if($ColumnasInfo["Key"][$i]=="PRI"){ //Verificamos si la llave es primaria
                
                $Required=1;
                if(!$ColumnasInfo["Extra"][$i]=="auto_increment"){ //Verificamos si tiene auto increment
                   $Value = $this->ObtengaID(); //Obtiene un timestamp para crear un id unico
                }else{
                   $ReadOnly=1; 
                }
           }else{
                $ReadOnly=0;
           }
           
           if(isset($VarInsert[$tbl][$NombreCol]["Required"])){
               $Required=1;
           }
            
            print("<td style='text-align: center'>");
            
            print($NombreCol."<br>");
            if(property_exists($Parametros,$NombreCol)){
                $Display=$Parametros->$NombreCol->Display;
                $IDTabla=$Parametros->$NombreCol->IDTabla;
                $TablaVinculo=$Parametros->$NombreCol->TablaVinculo;
                if($Display<>"CodigoBarras"){
                    $sql="SELECT * FROM $TablaVinculo";
                    //print($sql);
                    $Consulta=$this->obCon->Query($sql);
                    $VectorSel["Nombre"]="$NombreCol";
                    $VectorSel["Evento"]="";
                    $VectorSel["Funcion"]="";
                    $VectorSel["Required"]=$Required;
                    $VarSelect["Ancho"]=100;
                    $VarSelect["PlaceHolder"]="Seleccione una opcion";
                    //$this->css->CrearSelect2($VectorSel);
                    $this->css->CrearSelectChosen($NombreCol, $VarSelect);
                    $this->css->CrearOptionSelect("", "Seleccione Una Opcion", 0);
                    while($Opciones=$this->obCon->FetchArray($Consulta)){
                        $pre=0;
                        if($Parametros->$NombreCol->Predeterminado==$Opciones[$IDTabla]){
                            $pre=1;
                        }
                        $this->css->CrearOptionSelect($Opciones[$IDTabla], $Opciones[$IDTabla]." - ".$Opciones[$Display]." - ".$Opciones[2], $pre);              
                    }
                    $this->css->CerrarSelect(); 
                }else{
                  
                    $this->css->CrearInputText("$NombreCol", $TipoText, "", "", "$NombreCol", "black", "", "", $lengCampo."0", 30, 1, $Required);
                              
                }
            }else{
                if($lengCampo<100){
                    if($NombreCol=="RutaImagen"){
                        $this->css->CrearUpload($NombreCol);
                    }else{
                        $this->css->CrearInputText("$NombreCol", $TipoText, "", $Value, "$NombreCol", "black", "", "", $lengCampo."0", 30, $ReadOnly, $Required);    
                    }
                }else{
                    if($NombreCol=="RutaImagen"){
                        $this->css->CrearUpload($NombreCol);
                    }else{    
                        $this->css->CrearTextArea("$NombreCol", "", $Value, "", "$NombreCol", "black", "", "","100",$lengCampo."0", $ReadOnly, 1);
                    }
                    
                }
            }
                print("<td></tr>");    

        }

        $i++;
    }
    $this->css->FilaTabla(18);
    print("<td style='text-align: center'>");
    $this->css->CrearBotonConfirmado("BtnGuardarRegistro", "Guardar Registro"); 
    print("</td>");
    $this->css->CierraFilaTabla();
    $this->css->CerrarTabla();
    $this->css->CerrarForm();    
    //return($sql);
}

/*
 * 
 * Funcion para crear un formulario de edicion de un registro
 * 
 */

    
public function FormularioEditarRegistro($Parametros,$VarEdit)  {
    //print_r($Vector);
    $this->css=new CssIni("");
    $Tabla["Tabla"]=$Parametros->Tabla;
    $tbl=$Tabla["Tabla"];
    $Titulo=$Parametros->Titulo;
    $IDEdit=$VarEdit["ID"];
    
    $Columnas=$this->Columnas($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    $ColumnasInfo=$this->ColumnasInfo($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    
    $myPage="$Tabla[Tabla]".".php";
    if(isset($VarEdit[$tbl]["MyPage"])){
        $myPage=$VarEdit[$tbl]["MyPage"];
    }
    $NumCols=count($Columnas);
    
    $this->css->CrearFormularioEvento("FrmGuardarRegistro", "procesadores/procesaEdicion.php", "post", "_self", "");
    $this->css->CrearInputText("TxtTablaEdit", "hidden", "", $tbl, "", "", "", "", "", "", "", "");
    $this->css->CrearInputText("TxtIDEdit", "hidden", "", $IDEdit, "", "", "", "", "", "", "", "");
    $this->css->CrearInputText("TxtMyPage", "hidden", "", $myPage, "", "", "", "", "", "", "", "");
    $this->css->CrearTabla();
    $this->css->FilaTabla(18);
    print("<td style='text-align: center'><strong>$Titulo</strong>");
    print("</td>");
    $this->css->CierraFilaTabla();
    
    
    $i=0;
       
    foreach($Columnas as $NombreCol){
        $this->css->FilaTabla(14);
        $excluir=0;
        $TipoText="text";
        if(isset($VarEdit[$tbl][$NombreCol]["TipoText"])){
            $TipoText=$VarEdit[$tbl][$NombreCol]["TipoText"];
        }
        if(isset($VarEdit[$tbl][$NombreCol]["Excluir"])){
            $excluir=1;
        }
        if(!$excluir){  //Si la columna no está excluida
           $lengCampo=preg_replace('/[^0-9]+/', '', $ColumnasInfo["Type"][$i]); //Determinamos la longitud del campo
           if($lengCampo<1){
               $lengCampo=45;
           }
           if($ColumnasInfo["Type"][$i]=="text"){
               $lengCampo=100;
           }
           $ColID=$Columnas[0];
           $Condicion=" $ColID='$IDEdit'";
           $SelColumnas=$NombreCol;
           $DatosRegistro =  $this->obCon->ValorActual($tbl, $SelColumnas, $Condicion);
           $Value=$DatosRegistro[$NombreCol];
           $Required=0;
           $ReadOnly=0;
           if($ColumnasInfo["Key"][$i]=="PRI"){ //Verificamos si la llave es primaria
                $Required=1;
                if($ColumnasInfo["Extra"][$i]=="auto_increment"){ 
                    $ReadOnly=1;
                }
                    
           }else{
                $ReadOnly=0;
           }
           
           if(isset($VarEdit[$tbl][$NombreCol]["Required"])){
               $Required=1;
           }
            
            print("<td style='text-align: center'>");
            
            print($NombreCol."<br>");
            if(property_exists($Parametros,$NombreCol)){
                $Display=$Parametros->$NombreCol->Display;
                $IDTabla=$Parametros->$NombreCol->IDTabla;
                $TablaVinculo=$Parametros->$NombreCol->TablaVinculo;
                
                $sql="SELECT * FROM $TablaVinculo";

                $Consulta=$this->obCon->Query($sql);
                $VectorSel["Nombre"]="$NombreCol";
                $VectorSel["Evento"]="";
                $VectorSel["Funcion"]="";
                $VectorSel["Required"]=$Required;
                $this->css->CrearSelect2($VectorSel);
                $this->css->CrearOptionSelect("", "Seleccione Una Opcion", 0);
                while($Opciones=$this->obCon->FetchArray($Consulta)){
                    $pre=0;
                    if($Value==$Opciones[$IDTabla]){
                        $pre=1;
                    }
                    $this->css->CrearOptionSelect($Opciones[$IDTabla], $Opciones[$IDTabla]."-".$Opciones[$Display]."-".$Opciones[2], $pre);              
                }
                $this->css->CerrarSelect(); 
                
            }else{
                if($lengCampo<100){

                    $this->css->CrearInputText("$NombreCol", $TipoText, "", $Value, "$NombreCol", "black", "", "", $lengCampo."0", 30, $ReadOnly, $Required);
                }else{
                    $this->css->CrearTextArea("$NombreCol", "", $Value, "", "$NombreCol", "black", "", "","100",$lengCampo."0", $ReadOnly, 1);
                }
            }
                print("<td></tr>");    

        }

        $i++;
    }
    $this->css->FilaTabla(18);
    print("<td style='text-align: center'>");
    $this->css->CrearBotonConfirmado("BtnEditarRegistro", "Editar Registro"); 
    print("</td>");
    $this->css->CierraFilaTabla();
    $this->css->CerrarTabla();
    $this->css->CerrarForm();    
    //return($sql);
}

/*
 * 
 * Funcion para dibujar las cuentas por pagar
 * 
 */

    
public function DibujaCuentasXPagar($VarCuentas)  {
    $this->css=new CssIni("");
    
    $sql="SELECT (sum(`Debito`)-sum(`Credito`)) as Saldos, `Tercero_Identificacion` as Tercero, CuentaPUC, "
            . "`NombreCuenta`,`Tipo_Documento_Intero`,`Num_Documento_Interno`,`idLibroDiario`  FROM `librodiario` "
            . "WHERE `CuentaPUC` like '2%' GROUP BY `CuentaPUC`, `Tercero_Identificacion` ";
    $Datos=$this->obCon->Query($sql);
    
    $this->css->CrearTabla();
    $this->css->FilaTabla(14);
    echo "<td><strong>CUENTA</strong></td>";
    echo "<td><strong>NOMBRE</strong></td>";
    echo "<td><strong>DOCUMENTO</strong></td>"; 
    echo "<td><strong>NUMERO</strong></td>";
    echo "<td><strong>TERCERO</strong></td>";
    echo "<td><strong>SALDO</strong></td>";
    echo "<td><strong>AGREGAR</strong></td>";
    
    while($DatosCuentas=$this->obCon->FetchArray($Datos)){
        $this->css->FilaTabla(12);
        echo"<td>$DatosCuentas[CuentaPUC]</td>";
        echo"<td>$DatosCuentas[NombreCuenta]</td>";
        echo"<td>$DatosCuentas[Tipo_Documento_Intero]</td>";
        echo"<td>$DatosCuentas[Num_Documento_Interno]</td>";
        echo"<td>$DatosCuentas[Tercero]</td>";
        echo"<td>$DatosCuentas[Saldos]</td>";
        echo"<td>$DatosCuentas[idLibroDiario]</td>";
    }
    
    $this->css->CerrarTabla();
}

///Esta funcion permite dibujar un cuadro de dialogo para crear un cliente

public function CrearCuadroClientes ($id,$titulo,$myPage,$VectorCDC){
        $this->css=new CssIni("");
    /////////////////Cuadro de dialogo de Clientes create
	$this->css->CrearCuadroDeDialogo($id,$titulo); 
	 
        $this->css->CrearForm("FrmCrearCliente",$myPage,"post","_self");
        $this->css->CrearSelect("CmbTipoDocumento","Oculta()");
        $this->css->CrearOptionSelect('13','Cedula',1);
        $this->css->CrearOptionSelect('31','NIT',0);
        $this->css->CerrarSelect();
        //$css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
        $this->css->CrearInputText("TxtNIT","number","","","Identificacion","black","","",200,30,0,1);
        $this->css->CrearInputText("TxtPA","text","","","Primer Apellido","black","onkeyup","CreaRazonSocial()",200,30,0,0);
        $this->css->CrearInputText("TxtSA","text","","","Segundo Apellido","black","onkeyup","CreaRazonSocial()",200,30,0,0);
        $this->css->CrearInputText("TxtPN","text","","","Primer Nombre","black","onkeyup","CreaRazonSocial()",200,30,0,0);
        $this->css->CrearInputText("TxtON","text","","","Otros Nombres","black","onkeyup","CreaRazonSocial()",200,30,0,0);
        $this->css->CrearInputText("TxtRazonSocial","text","","","Razon Social","black","","",200,30,0,1);
        $this->css->CrearInputText("TxtDireccion","text","","","Direccion","black","","",200,30,0,1);
        $this->css->CrearInputText("TxtTelefono","text","","","Telefono","black","","",200,30,0,1);

        $this->css->CrearInputText("TxtEmail","text","","","Email","black","","",200,30,0,1);

        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione el municipio";
        $this->css->CrearSelectChosen("CmbCodMunicipio", $VarSelect);

        $sql="SELECT * FROM cod_municipios_dptos";
        $Consulta=$this->obCon->Query($sql);
           while($DatosMunicipios=$this->obCon->FetchArray($Consulta)){
               $Sel=0;
               if($DatosMunicipios["ID"]==1011){
                   $Sel=1;
               }
               $this->css->CrearOptionSelect($DatosMunicipios["ID"], $DatosMunicipios["Ciudad"], $Sel);
           }
        $this->css->CerrarSelect();
        echo '<br><br>';
        $this->css->CrearBoton("BtnCrearCliente", "Crear Cliente");
        $this->css->CerrarForm();

	$this->css->CerrarCuadroDeDialogo(); 
}

//Funcion para Crear un Cuadro de dialogo que permita crear un servicio nuevo

public function CrearCuadroCrearServicios($id,$titulo,$myPage,$idClientes,$VectorCDSer){
        $this->css=new CssIni("");
        $DatosTabla=$this->obCon->DevuelveValores("tablas_ventas", "NombreTabla", "servicios");
    /////////////////Cuadro de dialogo de Clientes create
	$this->css->CrearCuadroDeDialogo($id,$titulo); 
	 
        $this->css->CrearForm2("FrmCrearItemServicio",$myPage,"post","_self");
        $this->css->CrearInputText("TxtIdCliente","hidden","",$idClientes,"Precio Venta","black","","",200,30,0,1);
        if(isset($VectorCDSer["servitorno"])){
            $this->css->CrearInputText("TxtServitorno","hidden","",$VectorCDSer["servitorno"],"Precio Venta","black","","",200,30,0,1);
        }
        
        $this->css->CrearTextArea("TxtNombre", "", "", "Descripcion", "", "", "", 200, 100, 0, 1);
        
        echo '<br>';
        
        if(isset($VectorCDSer["servitorno"])){
            $TotalCostos=$this->obCon->Sume("costos", "ValorCosto", "");
            $TotalCostos=$TotalCostos/192;
            $this->css->CrearInputNumber("TxtCantidadPiezas","number","Cantidad de piezas:<br>",1,"Piezas","black","onkeyup","Servitorno_CalculePrecioVenta('$TotalCostos')",200,30,0,1,1,"",1);
            $this->css->CrearInputNumber("TxtNumMaquinas","number","Maquinas:<br>",3,"Maquinas","black","onkeyup","Servitorno_CalculePrecioVenta('$TotalCostos')",200,30,0,1,1,"",1);
            $this->css->CrearInputNumber("TxtMargen","number","Margen:<br>","0.58825","Margen","black","onkeyup","Servitorno_CalculePrecioVenta('$TotalCostos')",200,30,0,1,0,"","any");
            $this->css->CrearInputNumber("TxtTiempoMaquinas","number","Tiempo Maquina:<br>",1,"Tiempo en Maquina","black","onkeyup","Servitorno_CalculePrecioVenta('$TotalCostos')",200,30,0,1,0,"","any");
            
        }
        print("</br>");
        
        $this->css->CrearInputNumber("TxtPrecioVenta","number","PrecioVenta:<br>","","Precio Venta","black","","",200,30,0,1,1,"","");
        print("</br>");
        $this->css->CrearInputNumber("TxtCostoUnitario","number","CostoUnitario:<br>","","Costo Unitario","black","","",200,30,0,1,1,"","");
        print("</br>");
        //$this->css->CrearInputText("TxtCuentaPUC","number","","","Cuenta Contable","black","","",200,30,0,1);
        
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione el Departamento";
        $VarSelect["Required"]=1;
        $this->css->CrearSelectChosen("CmbDepartamento", $VarSelect);

        $sql="SELECT * FROM prod_departamentos";
        $Consulta=$this->obCon->Query($sql);
        $this->css->CrearOptionSelect("", "Seleccione un Departamento", 0);
           while($DatosDepartamentos=$this->obCon->FetchArray($Consulta)){
                              
               $this->css->CrearOptionSelect($DatosDepartamentos["idDepartamentos"], $DatosDepartamentos["Nombre"], 0);
           }
        $this->css->CerrarSelect();
        print("</br></br>");
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione la cuenta contable";
        $VarSelect["Required"]=1;
        $this->css->CrearSelectChosen("TxtCuentaPUC", $VarSelect);

        $sql="SELECT * FROM subcuentas WHERE PUC LIKE '41%'";
        $Consulta=$this->obCon->Query($sql);
        $this->css->CrearOptionSelect("", "Seleccione una cuenta contable", 0);
           while($DatosCuenta=$this->obCon->FetchArray($Consulta)){
               $sel=0;
               if($DatosTabla["CuentaPUCDefecto"]==$DatosCuenta["PUC"]){
                   $sel=1;
               }               
               $this->css->CrearOptionSelect($DatosCuenta["PUC"],"$DatosCuenta[PUC] $DatosCuenta[Nombre]", $sel);
           }
        $this->css->CerrarSelect();
        echo '<br>';
        print("</br>");
        $DatosEmpresa=$this->obCon->DevuelveValores("empresapro", "idEmpresaPro",1 );
        $IVA="";
        if($DatosEmpresa["Regimen"]=="COMUN"){
            $IVA=0.16;
        }else if($DatosEmpresa["Regimen"]=="SIMPLIFICADO"){
            $IVA=0;
        }
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione el IVA";
        $VarSelect["Required"]=1;
        $this->css->CrearSelectChosen("CmbIVA", $VarSelect);

        $sql="SELECT * FROM porcentajes_iva";
        $Consulta=$this->obCon->Query($sql);
        $this->css->CrearOptionSelect("", "Seleccione el IVA", 0);
           while($DatosIVA=$this->obCon->FetchArray($Consulta)){
               $sel=0;
               if($IVA==$DatosIVA["Valor"]){
                   $sel=1;
               }               
               $this->css->CrearOptionSelect($DatosIVA["Valor"], $DatosIVA["Nombre"], $sel);
           }
        $this->css->CerrarSelect();
               
        $this->css->CrearBoton("BtnCrearServicios", "Crear Servicio");
        $this->css->CerrarForm();

	$this->css->CerrarCuadroDeDialogo(); 
}

// FIN Clases	
}

?>