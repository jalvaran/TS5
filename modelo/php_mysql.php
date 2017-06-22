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
}
?>