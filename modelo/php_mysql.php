<?php
/*
 * 
 * Clase con todas las acciones requeridas para la conexion a la base de datos
 */
include_once("php_settings.php");
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
        
}
?>