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
}
?>