<?php
/*
 * 
 * Clase con todas las acciones requeridas para la conexion a la base de datos
 */
include_once 'php_settings.php';
$con = mysql_connect($host,$user,$pw);
mysql_select_db($db,$con) or die(mysql_error());
date_default_timezone_set("America/Bogota");

class db_conexion{
       
   // evita la injeccion de codigo sql
    public function normalizar($string){		
        $str=str_ireplace("'", "", $string);
        $str=str_ireplace('"', "", $string);
        //$str=$string;
        $str=str_ireplace("CREATE", "ISQL", $str);
        $str=str_ireplace("DROP", "ISQL", $str);
        $str=str_ireplace("ALTER", "ISQL", $str);
        $str=str_ireplace("SELECT", "ISQL", $str);
        $str=str_ireplace("INSERT", "ISQL", $str);
        $str=str_ireplace("UPDATE", "ISQL", $str);
        $str=str_ireplace("DELETE", "ISQL", $str);
        $str=str_ireplace("REPLACE", "ISQL", $str);
        $str=str_ireplace("TRUNCATE", "ISQL", $str);
        //$str=filter_var($string, FILTER_SANITIZE_STRING);
        return($str);
    }
    
    //Funcion para Conetarse a un servidor y seleccionar una base de datos
     public function ConToServer($ip,$User,$Pass,$db,$VectorCon){
        
        $con = mysql_connect($ip,$User,$Pass);
        if(!$con){
            $Mensaje="No se pudo conectar al servidor en la ip: $ip ".  mysql_error();
            exit($Mensaje);
        }else{
            $Mensaje="Conexion satisfactoria";
            mysql_select_db($db,$con) or die("No es posible abrir la base de datos ".  mysql_error());
            return($Mensaje);
        }
            
            
    }
    
    //Funcion para Conetarse a un servidor y seleccionar una base de datos
     public function CerrarCon(){
        
         mysql_close();
        
        
     }
    ////////////////////////////////////////////////////////////////////
//////////////////////Funcion query mysql
///////////////////////////////////////////////////////////////////
public function Query($sql)
  {		
					
    $Consul=mysql_query($sql) or die("<pre>no se pudo realizar la consulta $sql en query php_conexion: " . mysql_error()."</pre>");
    return($Consul);
}
    ////////////////////////////////////////////////////////////////////
//////////////////////Funcion Obtener vaciar una tabla
///////////////////////////////////////////////////////////////////
public function VaciarTabla($tabla)
  {		
	$tabla=$this->normalizar($tabla);
	$sql="TRUNCATE `$tabla`";
	
	mysql_query($sql) or die('no se pudo vaciar la tabla $tabla: ' . mysql_error());	
		
	}

////////////////////////////////////////////////////////////////////
//////////////////////Funcion Actualizar registro en tabla
///////////////////////////////////////////////////////////////////

    public function update($tabla,$campo, $value, $condicion){
	$sql="UPDATE `$tabla` SET `$campo` = '$value' $condicion";
	mysql_query($sql) or die('no se pudo actualizar el registro en la $tabla: ' . mysql_error());
    }
    
    ////////////////////////////////////////////////////////////////////
//////////////////////Funcion consultar una tabla
///////////////////////////////////////////////////////////////////
public function ConsultarTabla($tabla,$Condicion)
  {		
    $sql="SELECT * FROM $tabla $Condicion";
    $Consul= $this->Query($sql);
    return($Consul);
}

////////////////////////////////////////////////////////////////////
//////////////////////Funcion fetcharray mysql
///////////////////////////////////////////////////////////////////
public function FetchArray($Datos){					
    $Vector=  mysql_fetch_array($Datos);
    return($Vector);
}

////////////////////////////////////////////////////////////////////
//////////////////////revisa si hay resultados tras una consulta
////////////////////////////////////////////////////////////////////
    
    public function NumRows($consulta){
	$NR=mysql_num_rows($consulta);
	return ($NR);	
		
    }
    
    //Fetch assoc
   public function FetchAssoc($Consulta) {
        $Results=mysql_fetch_assoc($Consulta);
        return ($Results);
    }
    
    /////Cuente una columna
		
    public function Count($Tabla,$NombreColumna, $Condicion){
	
		
	$sql="SELECT COUNT($NombreColumna) AS Cuenta FROM $Tabla $Condicion";
	
	$reg=$this->Query($sql) or die('no se pudo obtener la cuenta de '.$NombreColumna.' para la tabla '.$Tabla.' en Count: ' . mysql_error());
	$reg=$this->FetchArray($reg);
	
	return($reg["Cuenta"]);

    }
    
    /////Suma un valor en especifico de una tabla	
		
    function SumeColumna($Tabla,$NombreColumnaSuma, $NombreColumnaFiltro,$filtro){
	
	$Tabla=$this->normalizar($Tabla);
        $NombreColumnaSuma=$this->normalizar($NombreColumnaSuma);
        $NombreColumnaFiltro=$this->normalizar($NombreColumnaFiltro);
        $filtro=$this->normalizar($filtro);
		
	$sql="SELECT SUM($NombreColumnaSuma) AS suma FROM $Tabla WHERE $NombreColumnaFiltro = '$filtro'";
	
	$reg= $this->Query($sql) or die('no se pudo obtener la suma de $NombreColumnaSuma para la tabla $Tabla en SumeColumna: ' . mysql_error());
	$reg=$this->FetchArray($reg);
	
	return($reg["suma"]);

    }	
        
        /////Suma un valor en especifico de una tabla segun una condicion
		
    function Sume($Tabla,$NombreColumnaSuma, $Condicion){
        $sql="SELECT SUM($NombreColumnaSuma) AS suma FROM $Tabla $Condicion";

        $reg=$this->Query($sql) or die('no se pudo obtener la suma de '.$sql.' '.$NombreColumnaSuma.' para la tabla '.$Tabla.' en SumeColumna: ' . mysql_error());
        $reg=$this->FetchArray($reg);

        return($reg["suma"]);

    }	
    
    //////Funcion para insertar un Registro a un tabla
	
	public function InsertarRegistro($tabla,$NumRegistros,$Columnas,$Valores){
  
  	$tabla=$this->normalizar($tabla);
        
      
	$sql="INSERT INTO $tabla (";
	$fin=$NumRegistros-1;
	for($i=0;$i<$NumRegistros;$i++){
		$col=$Columnas[$i];
		$reg=$this->normalizar($Valores[$i]);
		if($fin<>$i)
			$sql=$sql."`$col`,";
		else	
			$sql=$sql."`$col`)";
	}
	$sql=$sql."VALUES (";
	
	for($i=0;$i<$NumRegistros;$i++){
		
		$reg=$Valores[$i];
		if($fin<>$i)
			$sql=$sql."'$reg',";
		else	
			$sql=$sql."'$reg')";
	}
	
	
	$this->Query($sql) or die("no se pudo ingresar el registro en la tabla $tabla desde la funcion Insertar Registro: " . mysql_error());	
		
}

////////////////////////////////////////////////////////////////////
//////////////////////Funcion devuelve valores
///////////////////////////////////////////////////////////////////

public function DevuelveValores($tabla,$ColumnaFiltro, $idItem){
        $tabla=$this->normalizar($tabla);
        $ColumnaFiltro=$this->normalizar($ColumnaFiltro);
        $idItem=$this->normalizar($idItem);
        $reg= $this->Query("select * from $tabla where $ColumnaFiltro = '$idItem'") or die("no se pudo consultar los valores de la tabla $tabla en DevuelveValores: " . mysql_error());
        $reg=$this->FetchArray($reg);	
        return ($reg);
}

////////////////////////////////////////////////////////////////////
//////////////////////Funcion devuelve el valor de una columna
///////////////////////////////////////////////////////////////////

public function ValorActual($tabla,$Columnas,$Condicion){

        $reg=$this->Query("SELECT $Columnas FROM $tabla WHERE $Condicion") or die("no se pudo consultar los valores de la tabla $tabla en ValorActual: " . mysql_error());
        $reg=$this->FetchArray($reg);	
        return ($reg);
}

////////////////////////////////////////////////////////////////////
//////////////////////Funcion borra registro
///////////////////////////////////////////////////////////////////

public function BorraReg($Tabla,$Filtro,$idFiltro){
    $Tabla=  $this->normalizar($Tabla);
    $Filtro=  $this->normalizar($Filtro);
    $idFiltro=  $this->normalizar($idFiltro);
    $this->Query("DELETE FROM $Tabla WHERE $Filtro='$idFiltro'");
}
	////////////////////////////////////////////////////////////////////
//////////////////////Funcion Obtener Ultimo ID de una Tabla
///////////////////////////////////////////////////////////////////

public function ObtenerMAX($tabla,$campo, $filtro, $idItem)
  {	
        $tabla=$this->normalizar($tabla);
        $campo=$this->normalizar($campo);
        $filtro=$this->normalizar($filtro);
        $idItem=$this->normalizar($idItem);
	if($filtro==1){
		$sql="SELECT MAX($campo) AS MaxNum FROM `$tabla`";
	}else{
		$sql="SELECT MAX($campo) AS MaxNum FROM `$tabla` WHERE `$filtro` = '$idItem'";
	}
		
	$Reg=$this->Query($sql) or die('no se pudo actualizar el registro en la $tabla: ' . mysql_error());	
	$MN=$this->FetchArray($Reg);
	return($MN["MaxNum"]);	
	}
        
        ////////////////////////////////////////////////////////////////////
//////////////////////Funcion Actualizar registro en tabla
///////////////////////////////////////////////////////////////////


public function ActualizaRegistro($tabla,$campo, $value, $filtro, $idItem,$ProcesoInterno=1){	
        $Condicion=" WHERE `$filtro` = '$idItem'";
        $sql="SELECT $campo FROM $tabla $Condicion LIMIT 1";
        $c=$this->Query($sql);
        $OldData=$this->FetchArray($c);
	$tabla=$this->normalizar($tabla);
        $campo=$this->normalizar($campo);
        $value=$this->normalizar($value);
        $filtro=$this->normalizar($filtro);
        $idItem=$this->normalizar($idItem);
        if($campo<>'ISQLd' and $campo<>$value){
            $sql="UPDATE `$tabla` SET `$campo` = '$value' WHERE `$filtro` = '$idItem'";
            $this->Query($sql);	
            if($ProcesoInterno==0){
                $tab="registra_ediciones";
                $NumRegistros=8;

                $Columnas[0]="Fecha";               $Valores[0]=date("Y-m-d");
                $Columnas[1]="Hora";                $Valores[1]=date("H:i:s");
                $Columnas[2]="Tabla";               $Valores[2]=$tabla;
                $Columnas[3]="Campo";               $Valores[3]=$campo;
                $Columnas[4]="ValorAnterior";	$Valores[4]=$OldData[$campo];
                $Columnas[5]="ValorNuevo";		$Valores[5]=$value;
                $Columnas[6]="ConsultaRealizada";	$Valores[6]="$filtro = $idItem";
                $Columnas[7]="idUsuario";		$Valores[7]=$_SESSION["idUser"];

                $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            }
        }
}
 //Registre Eliminaciones
 public function RegistraEliminacion($tabla,$idTabla,$idItemEliminado,$campo,$Valor,$Observaciones,$Vector) {
    $tab="registra_eliminaciones";
    $NumRegistros=9;
    $Columnas[0]="Fecha";               $Valores[0]=date("Y-m-d");
    $Columnas[1]="Hora";                $Valores[1]=date("H:i:s");
    $Columnas[2]="TablaOrigen";         $Valores[2]=$tabla;
    $Columnas[3]="Campo";               $Valores[3]=$campo;
    $Columnas[4]="Valor";               $Valores[4]=$Valor;
    $Columnas[5]="Causal";		$Valores[5]=$Observaciones;
    $Columnas[6]="idUsuario";           $Valores[6]=$_SESSION["idUser"];
    $Columnas[7]="idTabla";		$Valores[7]=$idTabla;
    $Columnas[8]="idItemEliminado";     $Valores[8]=$idItemEliminado;
    
    $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
 }    
 
 //Last Insert ID
 public function Last_Insert_ID() {
    $id= mysql_insert_id();
    return($id);
 }
 
 /*
 *Funcion devolver todas los atributos de las columnas de una tablas
 */
    
public function ShowColums($Tabla){
    
    
    $sql="SHOW COLUMNS FROM `$Tabla`;";
    $Results=$this->Query($sql);
    $i=0;
    while($Columnas = $this->FetchArray($Results) ){
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

public function fetch_object($Consulta) {
    $Objeto=mysql_fetch_object($Consulta);
    return($Objeto);
}
//Fin Clases
}
?>