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
    "M","N","O","P","Q","R","S","T","C","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP");
    public $Condicionales = array(" ","=","*",">","<",">=","<=","<>","#%");
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
            $Valor=$this->obCon->normalizar($_REQUEST[$IndexFiltro]);
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
				case 8:
                    $Filtro.=" LIKE '$Valor%'";
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
            
            $Valor=$this->obCon->normalizar($_REQUEST[$IndexFiltro]);
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
				case 8:
                    $Filtro.=" LIKE '$Valor%'";
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
            
            $Valor=$this->obCon->normalizar($_REQUEST[$IndexFiltro]);
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
				case 8:
                    $Filtro.=" LIKE '$Valor%'";
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
                    for($h=1;$h<=8;$h++){
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
                $Ruta="EditarRegistro.php?&TxtIdEdit=$DatosProducto[0]&TxtTabla=$Tabla[Tabla]&Others=".base64_encode($statement);
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
 * Verificamos si hay peticiones de exportacion
 */
    
public function GenereInformeDepartamento($Mes,$Anio,$Vector)  {
   $FechaIni=$Anio."-".$Mes."01";
   $FechaFin=$Anio."-".$Mes."31";
    require_once '../librerias/Excel/PHPExcel.php';
   $objPHPExcel = new PHPExcel();    
   $Consulta=  $this->obCon->ConsultarTabla("prod_departamentos", "");   
   $i=0;
   while($DatosDepartamentos=$this->obCon->FetchArray($Consulta)){
       $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[$i]."1",$DatosDepartamentos["Nombre"]);
       $i++;
   }
   
   
    
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.technosoluciones.com")
        ->setLastModifiedBy("www.technosoluciones.com")
        ->setTitle("Exportar Informe  desde base de datos")
        ->setSubject("Informe")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("techno soluciones")
        ->setCategory("Informe Departamentos");    
 
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Informe_Departamentos".'.xls"');
    header('Cache-Control: max-age=0');

    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    exit; 
   
      
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
        
        if(isset($VarInsert[$tbl][$NombreCol]["Excluir"]) or $NombreCol=="Updated" or $NombreCol=="Sync"){
            $excluir=1;
        }
        $TipoText="text";
        if(isset($VarInsert[$tbl][$NombreCol]["TipoText"])){
            $TipoText=$VarInsert[$tbl][$NombreCol]["TipoText"];
        }
        if(!$excluir){  //Si la columna no está excluida
           $DateBox=0;
           $lengCampo=preg_replace('/[^0-9]+/', '', $ColumnasInfo["Type"][$i]); //Determinamos la longitud del campo
           if($lengCampo<1){
               $lengCampo=45;
           }
           if($ColumnasInfo["Type"][$i]=="text"){
               $lengCampo=100;
           }
           if($ColumnasInfo["Type"][$i]=="date"){
               $DateBox=1;
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
                        if($DateBox==0){
                            $this->css->CrearInputText("$NombreCol", $TipoText, "", $Value, "$NombreCol", "black", "", "", $lengCampo."0", 30, $ReadOnly, $Required);    
                        }
                        if($DateBox==1){
                            $this->css->CrearInputFecha("", $NombreCol, date("Y-m-d"), 100, 30, "");
                        }
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

    
public function FormularioEditarRegistro($Parametros,$VarEdit,$TablaEdit)  {
    //print_r($Vector);
    $this->css=new CssIni("");
    $Tabla["Tabla"]=$TablaEdit;
    $tbl=$Tabla["Tabla"];
    $Titulo=$TablaEdit;
    $IDEdit=$VarEdit["ID"];
    $stament=$VarEdit["stament"];
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
    $this->css->CrearInputText("TxtStament", "hidden", "", $stament, "", "", "", "", "", "", "", "");
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
        if(isset($VarEdit[$tbl]["Excluir"][$NombreCol])){
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
           
           if(isset($VarEdit[$tbl]["Required"][$NombreCol])){
               $Required=1;
           }
            
            print("<td style='text-align: center'>");
            
            print($NombreCol."<br>");
            if(isset($VarEdit[$tbl][$NombreCol]["Vinculo"])){
                $Display=$VarEdit[$tbl][$NombreCol]["Display"];
                $IDTabla=$VarEdit[$tbl][$NombreCol]["IDTabla"];
                $TablaVinculo=$VarEdit[$tbl][$NombreCol]["TablaVinculo"];
                
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
    $TipoAbono=$VarCuentas["Abonos"];
    $sql="SELECT `Neto` as Saldos, `Tercero_Identificacion` as Tercero, CuentaPUC, "
            . "`NombreCuenta`,`Tipo_Documento_Intero`,`Num_Documento_Interno`,`idLibroDiario`  FROM `librodiario` "
            . "WHERE `CuentaPUC` like '2%' AND `Estado`='' AND `Neto`<0 GROUP BY `CuentaPUC`, `Tercero_Identificacion` ";
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
        $idLibro=$DatosCuentas["idLibroDiario"];
        $AbonosActuales=$this->obCon->Sume("abonos_libro", "Cantidad", "WHERE idLibroDiario='$idLibro' AND TipoAbono='$TipoAbono'");
        
        $SaldoTotal=($DatosCuentas["Saldos"]*(-1))-$AbonosActuales;
        $this->css->FilaTabla(12);
        
        echo"<td>$DatosCuentas[CuentaPUC]</td>";
        echo"<td>$DatosCuentas[NombreCuenta]</td>";
        echo"<td>$DatosCuentas[Tipo_Documento_Intero]</td>";
        echo"<td>$DatosCuentas[Num_Documento_Interno]</td>";
        echo"<td>$DatosCuentas[Tercero]</td>";
        echo"<td>$SaldoTotal</td>";
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
            $this->css->CrearInputNumber("TxtValorMateriales","number","<br>Valor de Materiales:<br>","","Valor de Materiales","black","onkeyup","Servitorno_CalculePrecioVenta('$TotalCostos')",200,30,0,1,0,"","any");
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

//Funcion para Crear un Cuadro de dialogo que permita crear un servicio nuevo

public function CrearCuadroBusqueda($myPage,$Hidden1,$ValHiden1,$Hidden2,$ValHiden2,$VectorCuaBus){
    $this->css=new CssIni("");
    $this->css->CrearForm2("FrmBuscarItem","$myPage","post","_self");
            
    $this->css->CrearInputText($Hidden1,"hidden","",$ValHiden1,"","","","",0,0,0,0);
    $this->css->CrearInputText($Hidden2,"hidden","",$ValHiden2,"","","","",0,0,0,0);

    $this->css->CrearInputText("TxtBusqueda", "text", "", "", "Buscar Item", "black", "", "", 200, 30, 0, 0);
    $this->css->CerrarForm();
}

//Funcion para Dibujar un item buscado en las tablas de ventas

public function DibujeItemsBuscadosVentas($key,$PageReturn,$Variable){
    $this->css=new CssIni("");
    
    $Titulo="Crear Item En servicios";
    $Nombre="ShowItemsBusqueda";
    $RutaImage="";
    $javascript="";
    $VectorBim["f"]=0;
    $target="#DialBusquedaItems";
    $this->css->CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,"",0,0,"fixed","left:10px;top:100",$VectorBim);
    
    $VectorDialogo["F"]=0;
    $this->css->CrearCuadroDeDialogo("DialBusquedaItems", "Resultados");
    $this->css->CrearDiv("DivBusqueda", "", "center", 1, 1);
    $this->css->CrearTabla();
    $tab="productosventa";
    $Condicion=" WHERE idProductosVenta='$key' OR Nombre LIKE '%$key%' OR Referencia LIKE '%$key%'";
    $consulta=$this->obCon->ConsultarTabla($tab,$Condicion);
    if($this->obCon->NumRows($consulta)){
        $this->css->FilaTabla(16);
        $this->css->ColTabla("<strong>Agregar</strong>", 1);
        $this->css->ColTabla("<strong>ID</strong>", 1);
            $this->css->ColTabla("<strong>Referencia</strong>", 1);
            $this->css->ColTabla("<strong>Nombre</strong>", 1);
            $this->css->ColTabla("<strong>PrecioVenta</strong>", 1);
            $this->css->ColTabla("<strong>Mayorista</strong>", 1);
            $this->css->ColTabla("<strong>Existencias</strong>", 1);
            $this->css->CierraFilaTabla();
        while($DatosProducto=$this->obCon->FetchArray($consulta)){
            $this->css->FilaTabla(16);
             print("<td>");
            $Titulo="";
            $Nombre="Agregar";
            $RutaImage="../images/add.png";
            $javascript="";
            $VectorBim["f"]=0;
            $target="$PageReturn$DatosProducto[idProductosVenta]&TxtIdCliente=$Variable&TxtTablaItem=$tab";
            $this->css->CrearLinkImagen($Titulo,$Nombre,$target,$RutaImage,"",50,50,"relative","",$VectorBim);
            print("</td>");
            $this->css->ColTabla($DatosProducto["idProductosVenta"], 1);
            $this->css->ColTabla($DatosProducto["Referencia"], 1);
            $this->css->ColTabla($DatosProducto["Nombre"], 1);
            $this->css->ColTabla($DatosProducto["PrecioVenta"], 1);
            $this->css->ColTabla($DatosProducto["PrecioMayorista"], 1);
            $this->css->ColTabla($DatosProducto["Existencias"], 1);
           
            $this->css->CierraFilaTabla();
        }
    }
    
    $tab="servicios";
    $Condicion=" WHERE idProductosVenta='$key' OR Nombre LIKE '%$key%' OR Referencia LIKE '%$key%'";
    $consulta=$this->obCon->ConsultarTabla($tab,$Condicion);
    if($this->obCon->NumRows($consulta)){
        while($DatosProducto=$this->obCon->FetchArray($consulta)){
            $this->css->FilaTabla(16);
            print("<td>Agregar");
            $Titulo="";
            $Nombre="Agregar";
            $RutaImage="../images/add.png";
            $javascript="";
            $VectorBim["f"]=0;
            $target="$PageReturn$DatosProducto[idProductosVenta]&TxtIdCliente=$Variable&TxtTablaItem=$tab";
            $this->css->CrearLinkImagen($Titulo,$Nombre,$target,$RutaImage,"",50,50,"relative","",$VectorBim);
            print("</td>");
            $this->css->ColTabla($DatosProducto["idProductosVenta"], 1);
            $this->css->ColTabla($DatosProducto["Referencia"], 1);
            $this->css->ColTabla($DatosProducto["Nombre"], 1);
            $this->css->ColTabla($DatosProducto["PrecioVenta"], 1);
            $this->css->ColTabla($DatosProducto["PrecioMayorista"], 1);
            $this->css->CierraFilaTabla();
        }
    }
    
    $tab="productosalquiler";
    $Condicion=" WHERE idProductosVenta='$key' OR Nombre LIKE '%$key%' OR Referencia LIKE '%$key%'";
    $consulta=$this->obCon->ConsultarTabla($tab,$Condicion);
    if($this->obCon->NumRows($consulta)){
        while($DatosProducto=$this->obCon->FetchArray($consulta)){
            $this->css->FilaTabla(16);
            print("<td>Agregar");
            $Titulo="";
            $Nombre="Agregar";
            $RutaImage="../images/add.png";
            $javascript="";
            $VectorBim["f"]=0;
            $target="$PageReturn$DatosProducto[idProductosVenta]&TxtIdCliente=$Variable&TxtTablaItem=$tab";
            $this->css->CrearLinkImagen($Titulo,$Nombre,$target,$RutaImage,"",50,50,"relative","",$VectorBim);
            print("</td>");
            $this->css->ColTabla($DatosProducto["idProductosVenta"], 1);
            $this->css->ColTabla($DatosProducto["Referencia"], 1);
            $this->css->ColTabla($DatosProducto["Nombre"], 1);
            $this->css->ColTabla($DatosProducto["PrecioVenta"], 1);
            $this->css->ColTabla($DatosProducto["PrecioMayorista"], 1);
            
            $this->css->CierraFilaTabla();
        }
    }
    
    $this->css->CerrarTabla();
    $this->css->CerrarDiv();
    $this->css->CerrarCuadroDeDialogo();
   
}

//Funcion para Dibujar un item buscado en las tablas de ventas

public function DibujeItemsBuscadosVentas2($key,$PageReturn,$Variable){
    $this->css=new CssIni("");
    $idPre=$Variable["idPre"];
    $Titulo="Crear Item En servicios";
    $Nombre="ShowItemsBusqueda";
    $RutaImage="";
    $javascript="";
    $VectorBim["f"]=0;
    $target="#DialBusquedaItems";
    $this->css->CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,"",0,0,"fixed","left:10px;top:100",$VectorBim);
    
    $VectorDialogo["F"]=0;
    $this->css->CrearCuadroDeDialogo("DialBusquedaItems", "Resultados");
    $this->css->CrearDiv("DivBusqueda", "", "center", 1, 1);
    $this->css->CrearTabla();
    $tab="productosventa";
    $Condicion=" WHERE idProductosVenta='$key' OR Nombre LIKE '%$key%' OR Referencia LIKE '%$key%'";
    $consulta=$this->obCon->ConsultarTabla($tab,$Condicion);
    if($this->obCon->NumRows($consulta)){
        $this->css->FilaTabla(16);
        $this->css->ColTabla("<strong>Agregar</strong>", 1);
        $this->css->ColTabla("<strong>ID</strong>", 1);
            $this->css->ColTabla("<strong>Referencia</strong>", 1);
            $this->css->ColTabla("<strong>Nombre</strong>", 1);
            $this->css->ColTabla("<strong>PrecioVenta</strong>", 1);
            $this->css->ColTabla("<strong>Mayorista</strong>", 1);
            $this->css->ColTabla("<strong>Existencias</strong>", 1);
            $this->css->CierraFilaTabla();
        while($DatosProducto=$this->obCon->FetchArray($consulta)){
            $this->css->FilaTabla(16);
            print("<td>");
            $this->css->CrearForm2("FrmAgregarItem$DatosProducto[idProductosVenta]", $PageReturn, "post", "_self");
            $this->css->CrearInputText("TxtIdItem", "hidden", "", $DatosProducto["idProductosVenta"], "", "", "", "", "", "", 0, 1);
            $this->css->CrearInputText("TxtidPre", "hidden", "", $idPre, "", "", "", "", "", "", 0, 1);
            $this->css->CrearInputText("TxtTablaItem", "hidden", "", $tab, "", "", "", "", "", "", 0, 1);
            $this->css->CrearInputNumber("TxtCantidad", "number", "", 1, "Cantidad", "", "", "", 80, 30, 0, 1, 1, "", 1);
            $this->css->CrearBotonNaranja("BtnAgregarItem", "Agregar");
            $this->css->CerrarForm();
            print("</td>");
            $this->css->ColTabla($DatosProducto["idProductosVenta"], 1);
            $this->css->ColTabla($DatosProducto["Referencia"], 1);
            $this->css->ColTabla($DatosProducto["Nombre"], 1);
            $this->css->ColTabla($DatosProducto["PrecioVenta"], 1);
            $this->css->ColTabla($DatosProducto["PrecioMayorista"], 1);
            $this->css->ColTabla($DatosProducto["Existencias"], 1);
            
            $this->css->CierraFilaTabla();
        }
    }
    
    
    
    $this->css->CerrarTabla();
    $this->css->CerrarDiv();
    $this->css->CerrarCuadroDeDialogo();
   
}

//Verifico si hay peticiones de busqueda de separados
public function DibujaSeparado($myPage,$idPreventa,$Vector) {
    $this->css=new CssIni("");
    //Dibujo una busqueda de un separado
if(!empty($_REQUEST["TxtBuscarSeparado"])){
    $key=$this->obCon->normalizar($_REQUEST["TxtBuscarSeparado"]);
    $sql="SELECT sp.ID, cl.RazonSocial, cl.Num_Identificacion, sp.Total, sp.Saldo, sp.idCliente FROM separados sp"
            . " INNER JOIN clientes cl ON sp.idCliente = cl.idClientes "
            . " WHERE (sp.Estado<>'Cerrado' AND sp.Saldo>0) AND (cl.RazonSocial LIKE '%$key%' OR cl.Num_Identificacion LIKE '%$key%') LIMIT 10";
    $Datos=$this->obCon->Query($sql);
    if($this->obCon->NumRows($Datos)){
        $this->css->CrearTabla();
        
        while($DatosSeparado=$this->obCon->FetchArray($Datos)){
            $this->css->FilaTabla(14);
            $this->css->ColTabla("<strong>Separado No. $DatosSeparado[ID]<strong>", 6);
            $this->css->CierraFilaTabla();
            $this->css->FilaTabla(14);
            print("<td>");
            $this->css->CrearForm2("FormAbonosSeparados$DatosSeparado[ID]", $myPage, "post", "_self");
            $this->css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
            $this->css->CrearInputText("TxtIdSeparado","hidden","",$DatosSeparado["ID"],"","","","",0,0,0,0);
            $this->css->CrearInputText("TxtIdClientes","hidden","",$DatosSeparado["idCliente"],"","","","",0,0,0,0);
            $this->css->CrearInputNumber("TxtAbonoSeparado$DatosSeparado[ID]", "number", "Abonar: ", $DatosSeparado["Saldo"], "Abonar", "black", "", "", 200, 30, 0, 1, 1, $DatosSeparado["Saldo"], 1);
            $this->css->CrearBotonConfirmado("BtnAbono$DatosSeparado[ID]", "Abonar");
            $this->css->CerrarForm();
            print("</td>");
            $this->css->ColTabla($DatosSeparado["ID"], 1);
            $this->css->ColTabla($DatosSeparado["RazonSocial"], 1);
            $this->css->ColTabla($DatosSeparado["Num_Identificacion"], 1);
            $this->css->ColTabla(number_format($DatosSeparado["Total"]), 1);
            $this->css->ColTabla(number_format($DatosSeparado["Saldo"]), 1);
            $this->css->CierraFilaTabla();
            
            $this->css->FilaTabla(16);
            $this->css->ColTabla("ID Separado", 1);
            $this->css->ColTabla("Referencia", 1);
            $this->css->ColTabla("Nombre", 2);
            $this->css->ColTabla("Cantidad", 1);
            $this->css->ColTabla("TotalItem", 1);
            $this->css->CierraFilaTabla();
        
            $ConsultaItems=$this->obCon->ConsultarTabla("separados_items", "WHERE idSeparado='$DatosSeparado[ID]'");
            while($DatosItemsSeparados=$this->obCon->FetchArray($ConsultaItems)){
                
                $this->css->FilaTabla(14);
                $this->css->ColTabla($DatosItemsSeparados["idSeparado"], 1);
                $this->css->ColTabla($DatosItemsSeparados["Referencia"], 1);
                $this->css->ColTabla($DatosItemsSeparados["Nombre"], 2);
                $this->css->ColTabla($DatosItemsSeparados["Cantidad"], 1);
                $this->css->ColTabla($DatosItemsSeparados["TotalItem"], 1);
                $this->css->CierraFilaTabla();
            }           
            
             
            
        }
        $this->css->CerrarTabla();
    }else{
        $this->css->CrearNotificacionRoja("No se encontraron datos", 16);
    }
}
}


//Verifico si hay peticiones de busqueda de creditos

public function DibujaCredito($myPage,$idPreventa,$Vector) {
    $this->css=new CssIni("");
    //Dibujo una busqueda de un separado
if(!empty($_REQUEST["TxtBuscarCredito"])){
    $key=$this->obCon->normalizar($_REQUEST["TxtBuscarCredito"]);
    $sql="SELECT cart.idCartera,cart.Facturas_idFacturas, cl.RazonSocial, cl.Num_Identificacion, cart.TotalFactura, cart.Saldo,cart.TotalAbonos, cl.idClientes FROM cartera cart"
            . " INNER JOIN clientes cl ON cart.idCliente = cl.idClientes "
            . " WHERE (cl.RazonSocial LIKE '%$key%' OR cl.Num_Identificacion LIKE '%$key%') LIMIT 100";
    $Datos=$this->obCon->Query($sql);
    if($this->obCon->NumRows($Datos)){
        $this->css->CrearTabla();
        
        while($DatosCredito=$this->obCon->FetchArray($Datos)){
            $DatosFactura=$this->obCon->DevuelveValores("facturas", "idFacturas", $DatosCredito["Facturas_idFacturas"]);
            $this->css->FilaTabla(14);
            $this->css->ColTabla("<strong>Factura No. ".$DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"]."<strong>", 6);
            $this->css->CierraFilaTabla();
            $this->css->FilaTabla(14);
            print("<td>");
            $this->css->CrearForm2("FormCartera$DatosCredito[idCartera]", $myPage, "post", "_self");
            $this->css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
            $this->css->CrearInputText("TxtIdFactura","hidden","",$DatosCredito["Facturas_idFacturas"],"","","","",0,0,0,0);
            $this->css->CrearInputText("TxtIdCartera","hidden","",$DatosCredito["idCartera"],"","","","",0,0,0,0);
            if(isset($Vector["HabilitaCmbCuentaDestino"])){
                $VectorCuentas["Nombre"]="CmbCuentaDestino";
                $VectorCuentas["Evento"]="";
                $VectorCuentas["Funcion"]="";
                $VectorCuentas["Required"]=1;
                print("<strong>Cuenta:</strong>");
                $this->css->CrearSelect2($VectorCuentas);
                $this->css->CrearOptionSelect("", "Seleccione una cuenta destino", 0);
                $ConsultaCuentas=$this->obCon->ConsultarTabla("CuentasFrecuentes", "WHERE ClaseCuenta='ACTIVOS'");
                while($DatosCuentaFrecuentes=$this->obCon->FetchArray($ConsultaCuentas)){
                    $this->css->CrearOptionSelect($DatosCuentaFrecuentes["CuentaPUC"], $DatosCuentaFrecuentes["Nombre"], 0);
                }
                $this->css->CerrarSelect();
                print("<br>");
            }
            
            $this->css->CrearInputNumber("TxtAbonoCredito$DatosCredito[idCartera]", "number", "Abonar: ", $DatosCredito["Saldo"], "Abonar", "black", "", "", 200, 30, 0, 1, 1, $DatosCredito["Saldo"], 1);
            $this->css->CrearBotonConfirmado("BtnAbono$DatosCredito[idCartera]", "Abonar a Credito");
            $this->css->CerrarForm();
            print("</td>");
            $this->css->ColTabla($DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"], 1);
            $this->css->ColTabla($DatosCredito["RazonSocial"], 1);
            $this->css->ColTabla($DatosCredito["Num_Identificacion"], 1);
            $this->css->ColTabla(number_format($DatosCredito["TotalFactura"]), 1);
            $this->css->ColTabla(number_format($DatosCredito["Saldo"]), 1);
            $this->css->CierraFilaTabla();
            
            $this->css->FilaTabla(16);
            $this->css->ColTabla("Factura", 1);
            $this->css->ColTabla("Referencia", 1);
            $this->css->ColTabla("Nombre", 2);
            $this->css->ColTabla("Cantidad", 1);
            $this->css->ColTabla("TotalItem", 1);
            $this->css->CierraFilaTabla();
        
            $ConsultaItems=$this->obCon->ConsultarTabla("facturas_items", "WHERE idFactura='$DatosCredito[Facturas_idFacturas]'");
            while($DatosItemsFactura=$this->obCon->FetchArray($ConsultaItems)){
                
                $this->css->FilaTabla(14);
                $this->css->ColTabla($DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"], 1);
                $this->css->ColTabla($DatosItemsFactura["Referencia"], 1);
                $this->css->ColTabla($DatosItemsFactura["Nombre"], 2);
                $this->css->ColTabla($DatosItemsFactura["Cantidad"], 1);
                $this->css->ColTabla($DatosItemsFactura["TotalItem"], 1);
                $this->css->CierraFilaTabla();
            }           
            
             
            
        }
        $this->css->CerrarTabla();
    }else{
        $this->css->CrearNotificacionRoja("No se encontraron datos", 16);
    }
}
}

//Clase para dibujar el cronograma de Produccion por horas

    public function DibujCronogramaProduccionHoras($Titulo,$FechaActual, $myPage,$idOT,$Vector) {
        //Creamos la interfaz del Cronograma
        
    $ColorLibre="#FFFFFF";
    $ColorPausaOperativa="red";
    $ColorPausaNoOperativa="orange";
    $ColorEjecucion="green";
    $ColorTerminada="black";
    $ColorNoIniciada="blue";

    $this->css=new CssIni("");
    
    $this->css->CrearTabla();
    //Agrego Titulo
    $this->css->FilaTabla(14);
    print("<td style='background-color:$ColorEjecucion'>");
    $this->css->ColTabla("En Ejecucion", 1);
    print("</td>");
    
    
    print("<td style='background-color:$ColorPausaOperativa'>");
    $this->css->ColTabla("Pausa Operativa", 1);
    print("</td>");
    print("<td style='background-color:$ColorPausaNoOperativa'>");
    $this->css->ColTabla("Pausa NO Operativa", 1);
    print("</td>");
    print("<td style='background-color:$ColorTerminada'>");
    $this->css->ColTabla("Terminada", 1);
    print("</td>");
    $this->css->CierraFilaTabla();
    $this->css->CerrarTabla();
    $this->css->CrearTabla();
    //Agrego Titulo
    $this->css->FilaTabla(18);
    $this->css->ColTabla($Titulo, 5);
    
    $this->css->CierraColTabla();
    $this->css->CierraFilaTabla();
    //Agrego Horas
    $this->css->FilaTabla(16);
    $this->css->ColTabla("Maquina", 1);
    $this->css->CierraColTabla();
    $Datos=$this->obCon->ConsultarTabla("produccion_horas_cronograma", "");
    while($HorasCronograma=$this->obCon->FetchArray($Datos)){
        $this->css->ColTabla($HorasCronograma["Hora"], 1);
        $this->css->CierraColTabla();
    }
    $this->css->CierraFilaTabla();
    //Agrego las filas con cada maquina
    
    $Datos=$this->obCon->ConsultarTabla("maquinas", "");
    
    while($DatosMaquinas=$this->obCon->FetchArray($Datos)){
        $this->css->FilaTabla(14);
        echo("<td rowspan='2'>");
        print($DatosMaquinas["Nombre"]);
        echo("</td>");
        
        
        $DatosHoras=$this->obCon->ConsultarTabla("produccion_horas_cronograma", "");
        
        while($HorasCronograma=$this->obCon->FetchArray($DatosHoras)){
            print("<td>");
            $Page=$myPage;
            $Page.="?TxtFechaCronograma=$FechaActual&TxtHoraIni=$HorasCronograma[Hora]&idMaquina=$DatosMaquinas[ID]&idOT=$idOT";
            $Color="";
            $idActividad="";
            $Condicion="WHERE Fecha_Planeada_Inicio='$FechaActual' AND (Hora_Planeada_Inicio <='$HorasCronograma[Hora]' AND Hora_Planeada_Fin >'$HorasCronograma[Hora]') AND idMaquina='$DatosMaquinas[ID]'";
            $DatosActividades=$this->obCon->ConsultarTabla("produccion_actividades", $Condicion);
                    
            $DatosActividades=$this->obCon->FetchArray($DatosActividades);
            
            if($DatosActividades["ID"]>0){
                $idActividad=$DatosActividades["ID"];
                switch ($DatosActividades["Estado"]){
                    case "NO_INICIADA":
                        $ColorBG=$ColorNoIniciada;
                        $VectorDatosExtra["Color"] = $ColorNoIniciada;
                        break;
                    case "EJECUCION":
                        $ColorBG=$ColorEjecucion;
                        $VectorDatosExtra["Color"] = $ColorEjecucion;
                        break;
                    case "PAUSA_OPERATIVA":
                        $ColorBG=$ColorPausaOperativa;
                        $VectorDatosExtra["Color"] = $ColorPausaOperativa;
                        break;
                    case "PAUSA_NO_OPERATIVA":
                        $ColorBG=$ColorPausaNoOperativa;
                        $VectorDatosExtra["Color"] = $ColorPausaNoOperativa;
                        break;
                    case "TERMINADA":
                        $ColorBG=$ColorTerminada;
                        $VectorDatosExtra["Color"] = $ColorTerminada;
                        break;
                }
                $Color="background-color: $ColorBG";
                
                $Page.="&idEdit=$idActividad";
                $VectorDatosExtra["ID"]="LinkP".$idActividad;
                $this->css->CrearLinkID($Page, "_self", "$idActividad",$VectorDatosExtra);
            }
            
            
            if($Color=="" and $idOT>0){
                $this->css->CrearLink($Page, "_self", "+...");
                
            }
            
            print("</td>");
            
            
            
        }
        $this->css->CierraFilaTabla();
        $this->css->FilaTabla(12);
        
        $DatosHoras=$this->obCon->ConsultarTabla("produccion_horas_cronograma", "");
        
        while($HorasCronograma=$this->obCon->FetchArray($DatosHoras)){
            print("<td>");
            
            $Condicion="WHERE Fecha_Inicio<='$FechaActual'  AND idMaquina='$DatosMaquinas[ID]' AND Estado<>'NO_INICIADA' limit 100";
            $ConsultaActividades=$this->obCon->ConsultarTabla("produccion_actividades", $Condicion);
            
            while($DatosActividades=$this->obCon->FetchArray($ConsultaActividades)){
            $Page=$myPage;
            $Page.="?TxtFechaCronograma=$FechaActual&TxtHoraIni=$HorasCronograma[Hora]&idMaquina=$DatosMaquinas[ID]&idOT=$idOT";
            $Color="";
            $idActividad="";
            //$DatosActividades=$this->obCon->FetchArray($DatosActividades);
            $FechaHoraCalendario=date("$FechaActual $HorasCronograma[Hora]:00");
            $FechaTerminacion=date("Y-m-d H:i:00");
            
            if($DatosActividades["Estado"]=="TERMINADA"){
                $FechaTerminacion="$DatosActividades[Fecha_Fin] $DatosActividades[Hora_Fin]";
                    
            }
            
            
            $Hora1=strtotime($HorasCronograma["Hora"]);
            $Hora2=strtotime(substr($DatosActividades["Hora_Inicio"],0,2)."00");
            if($FechaActual==$DatosActividades["Fecha_Inicio"] AND $Hora1<$Hora2){
                $FechaTerminacion="2000-01-01 00:00:00";
            }
            
            $Fecha1=strtotime($FechaHoraCalendario);
            $Fecha2=strtotime($FechaTerminacion);
            
            if($DatosActividades["ID"]>0 and $Fecha2>$Fecha1){
                $idActividad=$DatosActividades["ID"];
                switch ($DatosActividades["Estado"]){
                    case "NO_INICIADA":
                        $ColorBG=$ColorNoIniciada;
                        $VectorDatosExtra["Color"] = $ColorNoIniciada;
                        break;
                    case "EJECUCION":
                        $ColorBG=$ColorEjecucion;
                        $VectorDatosExtra["Color"] = $ColorEjecucion;
                        break;
                    case "PAUSA_OPERATIVA":
                        $ColorBG=$ColorPausaOperativa;
                        $VectorDatosExtra["Color"] = $ColorPausaOperativa;
                        break;
                    case "PAUSA_NO_OPERATIVA":
                        $ColorBG=$ColorPausaNoOperativa;
                        $VectorDatosExtra["Color"] = $ColorPausaNoOperativa;
                        break;
                    case "TERMINADA":
                        $ColorBG=$ColorTerminada;
                        $VectorDatosExtra["Color"] = $ColorTerminada;
                        break;
                }
                $Color="background-color: $ColorBG";
            $VectorDatosExtra["ID"] = "Link".$idActividad;
            
            $Page.="&idEdit=$idActividad";
            $this->css->CrearLinkID($Page, "_self", "$idActividad<br>",$VectorDatosExtra);
            }
            
           // print("<td style='$Color'>");
            
            
            
            
            }
            print("</td>");
        }
        
        $this->css->CierraFilaTabla();
    }
    
    
    $this->css->CerrarTabla();
   
    }

    ///Arme una tabla con los datos de ventas por rangos
    
    public function ArmeTablaVentaRangos($Titulo,$CondicionItems,$Vector) {
             
        $sql="SELECT MAX(`TotalItem`) as Mayor, MIN(`TotalItem`) as Menor, SUM(`Cantidad`) as TotalItems FROM `facturas_items` WHERE `TotalItem`>1 $CondicionItems";
        
        $Consulta=$this->obCon->Query($sql);
        $Datos=$this->obCon->FetchArray($Consulta);
        $Mayor=$Datos["Mayor"];
        
        if($Mayor>1){
        
        $Menor=$Datos["Menor"];
        $TotalItems=$Datos["TotalItems"];
        
        $Rango=$Mayor-$Menor;
        $NoIntervalos=4;
        $Amplitud=$Rango/$NoIntervalos;
        
        $Intervalo[1]["LimiteInferior"]=$Menor;
        $Intervalo[1]["LimiteSuperior"]=$Menor+$Amplitud;
        $Intervalo[1]["Media"]=($Intervalo[1]["LimiteInferior"]+$Intervalo[1]["LimiteSuperior"])/2;
        $LimiteInferior=$Intervalo[1]["LimiteInferior"];
        $LimiteSuperior=$Intervalo[1]["LimiteSuperior"];
        $sql="SELECT SUM(`Cantidad`) as Items FROM `facturas_items` WHERE `TotalItem`>='$LimiteInferior' AND `TotalItem`<='$LimiteSuperior' $CondicionItems";
        $Consulta=$this->obCon->Query($sql);
        $Datos=$this->obCon->FetchArray($Consulta);
        $Intervalo[1]["FrecuenciaABS"]=$Datos["Items"];
        $Intervalo[1]["FrecuenciaAcumulada"]=$Intervalo[1]["FrecuenciaABS"];
        if($TotalItems>0){
            $Intervalo[1]["FrecuenciaABSPorcentual"]=$Intervalo[1]["FrecuenciaABS"]/$TotalItems*100;
        }else{
            $Intervalo[1]["FrecuenciaABSPorcentual"]=0;
        }
        
        $Intervalo[1]["FrecuenciaAcumuladaPorcentual"]=$Intervalo[1]["FrecuenciaABSPorcentual"];
        
        for($i=2;$i<=$NoIntervalos;$i++){
            $Intervalo[$i]["LimiteInferior"]=$Intervalo[$i-1]["LimiteSuperior"];
            $Intervalo[$i]["LimiteSuperior"]=$Intervalo[$i]["LimiteInferior"]+$Amplitud;
            $Intervalo[$i]["Media"]=($Intervalo[$i]["LimiteInferior"]+$Intervalo[$i]["LimiteSuperior"])/2;
            $LimiteInferior=$Intervalo[$i]["LimiteInferior"];
            $LimiteSuperior=$Intervalo[$i]["LimiteSuperior"];
            $sql="SELECT SUM(`Cantidad`) as Items FROM `facturas_items` WHERE `TotalItem`>='$LimiteInferior' AND `TotalItem`<='$LimiteSuperior' $CondicionItems";
            $Consulta=$this->obCon->Query($sql);
            $Datos=$this->obCon->FetchArray($Consulta);
            $Intervalo[$i]["FrecuenciaABS"]=$Datos["Items"];
            $Intervalo[$i]["FrecuenciaAcumulada"]=$Intervalo[$i-1]["FrecuenciaAcumulada"]+$Intervalo[$i]["FrecuenciaABS"];
            $Intervalo[$i]["FrecuenciaABSPorcentual"]=$Intervalo[$i]["FrecuenciaABS"]/$TotalItems*100;
            $Intervalo[$i]["FrecuenciaAcumuladaPorcentual"]=$Intervalo[$i-1]["FrecuenciaAcumuladaPorcentual"]+$Intervalo[$i]["FrecuenciaABSPorcentual"];
        }
        
        
        //$sql="SELECT SUM(`Cantidad`) as Items FROM `facturas_items` WHERE `TotalItem`>1 AND $CondicionItems";
        $tbl ='  


        <span style="color:RED;font-family:Bookman Old Style;font-size:12px;"><strong><em>'.$Titulo.':
        </em></strong></span><BR><BR>


        <table cellspacing="1" cellpadding="2" border="1"  align="center" >
          <tr> 
            <th><h3>MAYOR</h3></th>
                <th><h3>MINIMO</h3></th>
                <th><h3>RANGO</h3></th>
            <th><h3>INTERVALOS</h3></th>
                <th><h3>AMPLITUD</h3></th>

          </tr >
          <tr> 
            <td>'.number_format($Mayor).'</td>
            <td>'.number_format($Menor).'</td>
            <td>'.number_format($Rango).'</td>
            <td>'.number_format($NoIntervalos).'</td>
            <td>'.number_format($Amplitud).'</td>

          </tr >
        </table>
        <br><br>
        <table cellspacing="1" cellpadding="2" border="0" align="center" >
          <tr> 
            <th><h3>No.</h3></th>
            <th><h3>LIM INF</h3></th>
            <th><h3>LIM SUP</h3></th>
            <th><h3>MEDIA</h3></th>
            <th><h3>fabs</h3></th>
            <th><h3>Frec</h3></th>
            <th><h3>fabs %</h3></th>
            <th><h3>Frec %</h3></th>
          </tr >

        ';
        $h=0;
        for($i=1;$i<=$NoIntervalos;$i++){
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            }
            $tbl.='<tr align="center" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"> 
            <td >'.number_format($i).'</td>
            <td>'.number_format($Intervalo[$i]["LimiteInferior"]).'</td>
            <td>'.number_format($Intervalo[$i]["LimiteSuperior"]).'</td>
            <td>'.number_format($Intervalo[$i]["Media"]).'</td>
            <td>'.number_format($Intervalo[$i]["FrecuenciaABS"]).'</td>
            <td>'.number_format($Intervalo[$i]["FrecuenciaAcumulada"]).'</td>
            <td>'.round($Intervalo[$i]["FrecuenciaABSPorcentual"],2).'%</td>
            <td>'.round($Intervalo[$i]["FrecuenciaAcumuladaPorcentual"],2).'%</td>
          </tr >';
        }

        $tbl.="</table><br><br><br><br>";
        }else{
           $tbl=""; 
        }
        
    return($tbl);
}
   
///Arme una tabla con el balance de comprobacion 2016-11-18  JAAV
    
    public function ArmeTablaBalanceComprobacion($Titulo,$Condicion,$Condicion2,$Vector) {
             
        
        
        $tbl='<table cellspacing="1" cellpadding="2" border="1"  align="center" >
          <tr> 
            <th><h3>CUENTA</h3></th>
            <th><h3>NOMBRE</h3></th>
            <th><h3>SALDO ANTERIOR</h3></th>
            <th><h3>DEBITO</h3></th>
            <th><h3>CREDITO</h3></th>
            <th><h3>NUEVO SALDO</h3></th>

          </tr >
          </table>
        ';
        
        //Guardo en un Vector los resultados de la consulta por Clase
        
        
        $sql="SELECT SUBSTRING(`CuentaPUC`,1,1) AS Clase ,sum(`Debito`) as Debitos, sum(`Credito`) as Creditos, sum(`Neto`) as Neto, (SELECT SUM(`Neto`) as SaldoTotal FROM `librodiario` $Condicion2  SUBSTRING(`CuentaPUC`,1,1)=Clase) AS Total FROM `librodiario` $Condicion GROUP BY SUBSTRING(`CuentaPUC`,1,1)";
        $Consulta=$this->obCon->Query($sql);
        $i=0;
        $TotalDebitos=0;
        $TotalCreditos=0;
        $Total=0;
        while($ClaseCuenta=$this->obCon->FetchArray($Consulta)){
            $TotalDebitos=$TotalDebitos+$ClaseCuenta["Debitos"];
            $TotalCreditos=$TotalCreditos+$ClaseCuenta["Creditos"];
            $Total=$Total+$ClaseCuenta["Total"];
            $i++;
            $Clase=$ClaseCuenta["Clase"];
            $NoClasesCuentas[$i]=$ClaseCuenta["Clase"];
            $DatosCuenta=  $this->obCon->DevuelveValores("clasecuenta", "PUC", $Clase);
            $Balance["ClaseCuenta"][$Clase]["Nombre"]=$DatosCuenta["Clase"];
            $Balance["ClaseCuenta"][$Clase]["Clases"]=$ClaseCuenta["Clase"];
            $Balance["ClaseCuenta"][$Clase]["Debitos"]=$ClaseCuenta["Debitos"];
            $Balance["ClaseCuenta"][$Clase]["Creditos"]=$ClaseCuenta["Creditos"];
            $Balance["ClaseCuenta"][$Clase]["NuevoSaldo"]=$ClaseCuenta["Debitos"]-$ClaseCuenta["Creditos"]+$ClaseCuenta["Total"];
            $Balance["ClaseCuenta"][$Clase]["SaldoAnterior"]=$ClaseCuenta["Total"];
        }
        $Diferencia=$TotalDebitos-$TotalCreditos;
        //Guardo en un Vector los resultados de la consulta por Grupo
        
        $sql="SELECT SUBSTRING(`CuentaPUC`,1,2) AS Grupo ,sum(`Debito`) as Debitos, sum(`Credito`) as Creditos,(SELECT SUM(`Neto`) as SaldoTotal FROM `librodiario` $Condicion2  SUBSTRING(`CuentaPUC`,1,2)=Grupo) AS Total FROM `librodiario` $Condicion GROUP BY SUBSTRING(`CuentaPUC`,1,2)";
        $Consulta=$this->obCon->Query($sql);
        $i=0;
        
        while($ClaseCuentaGrupo=$this->obCon->FetchArray($Consulta)){
            $i++;
            $Grupo=$ClaseCuentaGrupo["Grupo"];
            $NoGrupos[$i]=$ClaseCuentaGrupo["Grupo"];
            $DatosCuenta=  $this->obCon->DevuelveValores("gupocuentas", "PUC", $Grupo);
            $Balance["GrupoCuenta"][$Grupo]["Nombre"]=$DatosCuenta["Nombre"];
            $Balance["GrupoCuenta"][$Grupo]["Grupos"]=$ClaseCuentaGrupo["Grupo"];
            $Balance["GrupoCuenta"][$Grupo]["Debitos"]=$ClaseCuentaGrupo["Debitos"];
            $Balance["GrupoCuenta"][$Grupo]["Creditos"]=$ClaseCuentaGrupo["Creditos"];
            $Balance["GrupoCuenta"][$Grupo]["NuevoSaldo"]=$ClaseCuentaGrupo["Debitos"]-$ClaseCuentaGrupo["Creditos"]+$ClaseCuentaGrupo["Total"];
            $Balance["GrupoCuenta"][$Grupo]["SaldoAnterior"]=$ClaseCuentaGrupo["Total"];
        }
        
        //Guardo en un Vector los resultados de la consulta por Cuenta
        
        $sql="SELECT SUBSTRING(`CuentaPUC`,1,4) AS Cuenta ,sum(`Debito`) as Debitos, sum(`Credito`) as Creditos,(SELECT SUM(`Neto`) as SaldoTotal FROM `librodiario` $Condicion2  SUBSTRING(`CuentaPUC`,1,4)=Cuenta) as Total FROM `librodiario` $Condicion GROUP BY SUBSTRING(`CuentaPUC`,1,4)";
        $Consulta=$this->obCon->Query($sql);
        $i=0;
        
        while($ClaseCuentaCuenta=$this->obCon->FetchArray($Consulta)){
            $i++;
            $Cuenta=$ClaseCuentaCuenta["Cuenta"];
            $NoCuentas[$i]=$ClaseCuentaCuenta["Cuenta"];
            $DatosCuenta=  $this->obCon->DevuelveValores("cuentas", "idPUC", $Cuenta);
            $Balance["Cuenta"][$Cuenta]["Nombre"]=$DatosCuenta["Nombre"];
            $Balance["Cuenta"][$Cuenta]["Cuentas"]=$ClaseCuentaCuenta["Cuenta"];
            $Balance["Cuenta"][$Cuenta]["Debitos"]=$ClaseCuentaCuenta["Debitos"];
            $Balance["Cuenta"][$Cuenta]["Creditos"]=$ClaseCuentaCuenta["Creditos"];
            $Balance["Cuenta"][$Cuenta]["NuevoSaldo"]=$ClaseCuentaCuenta["Debitos"]-$ClaseCuentaCuenta["Creditos"]+$ClaseCuentaCuenta["Total"];
            $Balance["Cuenta"][$Cuenta]["SaldoAnterior"]=$ClaseCuentaCuenta["Total"];
        }
        
        //Guardo en un Vector los resultados de la consulta por SubCuenta
        
        $sql="SELECT `CuentaPUC` AS Subcuenta , sum(`Debito`) as Debitos, sum(`Credito`) as Creditos, sum(`Neto`) as NuevoSaldo,(SELECT SUM(`Neto`) as SaldoTotal FROM `librodiario` $Condicion2  `CuentaPUC` = Subcuenta) as Total FROM `librodiario` $Condicion AND LENGTH(`CuentaPUC`)>=5 GROUP BY `CuentaPUC` ";
        $Consulta=$this->obCon->Query($sql);
        $i=0;
        
        while($ClaseCuentaSub=$this->obCon->FetchArray($Consulta)){
            $i++;
            $SubCuenta=$ClaseCuentaSub["Subcuenta"];
            $NoSubCuentas[$i]=$ClaseCuentaSub["Subcuenta"];
            $sql="SELECT Nombre FROM subcuentas WHERE PUC='$SubCuenta' LIMIT 1";
            $Datos=  $this->obCon->Query($sql);
            $DatosCuenta=$this->obCon->FetchArray($Datos);
            //$DatosCuenta=  $this->obCon->DevuelveValores("subcuentas", "PUC", `$SubCuenta`);
            $Balance["SubCuenta"][$SubCuenta]["Nombre"]=$DatosCuenta["Nombre"];
            $Balance["SubCuenta"][$SubCuenta]["Subcuenta"]=$ClaseCuentaSub["Subcuenta"];
            $Balance["SubCuenta"][$SubCuenta]["Debitos"]=$ClaseCuentaSub["Debitos"];
            $Balance["SubCuenta"][$SubCuenta]["Creditos"]=$ClaseCuentaSub["Creditos"];
            $Balance["SubCuenta"][$SubCuenta]["NuevoSaldo"]=$ClaseCuentaSub["Debitos"]-$ClaseCuentaSub["Creditos"]+$ClaseCuentaSub["Total"];
            $Balance["SubCuenta"][$SubCuenta]["SaldoAnterior"]=$ClaseCuentaSub["Total"];
        }
        
        $h=0;
        $tbl.='<table cellspacing="1" cellpadding="2" border="0"  align="center" >';
        if(isset($NoClasesCuentas)){
            foreach($NoClasesCuentas as $ClasesCuentas){
                if($Balance["ClaseCuenta"][$ClasesCuentas]["Creditos"]>0 or $Balance["ClaseCuenta"][$ClasesCuentas]["Debitos"]>0){
                    if($h==0){
                    $Back="#f2f2f2";
                        $h=1;
                    }else{
                        $Back="white";
                        $h=0;
                    }
                    $tbl.='<tr align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"> 
                    <td align="left"><strong><h1>'.$Balance["ClaseCuenta"][$ClasesCuentas]["Clases"].'</h1></strong></td>
                    <td align="center"><strong><h1>'.$Balance["ClaseCuenta"][$ClasesCuentas]["Nombre"].'</h1></strong></td>    
                    <td><strong><h1>'.number_format($Balance["ClaseCuenta"][$ClasesCuentas]["SaldoAnterior"]).'</h1></strong></td>  
                    <td><strong><h1>'.number_format($Balance["ClaseCuenta"][$ClasesCuentas]["Debitos"]).'</h1></strong></td>
                    <td><strong><h1>'.number_format($Balance["ClaseCuenta"][$ClasesCuentas]["Creditos"]).'</h1></strong></td>
                    <td><strong><h1>'.number_format($Balance["ClaseCuenta"][$ClasesCuentas]["NuevoSaldo"]).'</h1></strong></td>

                    </tr >';


                
               //Consulto los valores dentro del Grupo
                        
               foreach($NoGrupos as $GruposCuentas){
                   if(substr($Balance["GrupoCuenta"][$GruposCuentas]["Grupos"], 0, 1)==$Balance["ClaseCuenta"][$ClasesCuentas]["Clases"]){
                       if($h==0){
                            $Back="#f2f2f2";
                            $h=1;
                        }else{
                            $Back="white";
                            $h=0;
                        }
                        $tbl.='<tr align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"> 
                        <td align="left"><h2>'.$Balance["GrupoCuenta"][$GruposCuentas]["Grupos"].'</h2></td>
                        <td align="center"><strong>'.$Balance["GrupoCuenta"][$GruposCuentas]["Nombre"].'</strong></td>
                        <td><h2>'.number_format($Balance["GrupoCuenta"][$GruposCuentas]["SaldoAnterior"]).'</h2></td>
                        <td><h2>'.number_format($Balance["GrupoCuenta"][$GruposCuentas]["Debitos"]).'</h2></td>
                        <td><h2>'.number_format($Balance["GrupoCuenta"][$GruposCuentas]["Creditos"]).'</h2></td>
                        <td><h2>'.number_format($Balance["GrupoCuenta"][$GruposCuentas]["NuevoSaldo"]).'</h2></td>

                        </tr >';
                   
                   
                   //Consulto los valores dentro de la Cuenta
                   
                   foreach($NoCuentas as $Cuentas){
                    if(substr($Balance["Cuenta"][$Cuentas]["Cuentas"], 0, 2)==$Balance["GrupoCuenta"][$GruposCuentas]["Grupos"]){
                        if($h==0){
                             $Back="#f2f2f2";
                             $h=1;
                         }else{
                             $Back="white";
                             $h=0;
                         }
                         $tbl.='<tr align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"> 
                         <td align="left"><h3>'.$Balance["Cuenta"][$Cuentas]["Cuentas"].'</h3></td>
                         <td align="center"><strong>'.$Balance["Cuenta"][$Cuentas]["Nombre"].'</strong></td>
                         <td><h3>'.number_format($Balance["Cuenta"][$Cuentas]["SaldoAnterior"]).'</h3></td> 
                         <td><h3>'.number_format($Balance["Cuenta"][$Cuentas]["Debitos"]).'</h3></td>
                         <td><h3>'.number_format($Balance["Cuenta"][$Cuentas]["Creditos"]).'</h3></td>
                         <td><h3>'.number_format($Balance["Cuenta"][$Cuentas]["NuevoSaldo"]).'</h3></td>

                         </tr >';
                         
                         //Consulto los valores dentro de la Cuenta
                   
                   foreach($NoSubCuentas as $SubCuentas){
                    if(substr($Balance["SubCuenta"][$SubCuentas]["Subcuenta"], 0, 4)==$Balance["Cuenta"][$Cuentas]["Cuentas"]){
                        if($h==0){
                             $Back="#f2f2f2";
                             $h=1;
                         }else{
                             $Back="white";
                             $h=0;
                         }
                         $tbl.='<tr align="rigth" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';"> 
                         <td align="left">'.$Balance["SubCuenta"][$SubCuentas]["Subcuenta"].'</td>
                         <td align="center"><strong>'.$Balance["SubCuenta"][$SubCuentas]["Nombre"].'</strong></td>
                         <td>'.number_format($Balance["SubCuenta"][$SubCuentas]["SaldoAnterior"]).'</td>
                         <td>'.number_format($Balance["SubCuenta"][$SubCuentas]["Debitos"]).'</td>
                         <td>'.number_format($Balance["SubCuenta"][$SubCuentas]["Creditos"]).'</td>
                         <td>'.number_format($Balance["SubCuenta"][$SubCuentas]["NuevoSaldo"]).'</td>

                         </tr >';
                    }
                   }
                         
                    }
                   }
                   }
               } 
            }
            }
        }
        $tbl.="</table>";
        $tbl.='<table cellspacing="1" cellpadding="2" border="1"  align="center" >
          <tr> 
            <th colspan="3"><h3>TOTALES:</h3></th>
            
            <th align="rigth"><h3>'.number_format($TotalDebitos).'</h3></th>
            <th align="rigth"><h3>'.number_format($TotalCreditos).'</h3></th>
            <th align="rigth"><h3>'.number_format($Diferencia).'</h3></th>

          </tr >
          </table>
        ';
    return($tbl);
}
   

// FIN Clases	
}

?>