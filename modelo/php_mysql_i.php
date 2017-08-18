<?php
/*
 * 
 * Clase con todas las acciones requeridas para la conexion a la base de datos
 */
include_once("php_settings.php");
class db_conexion{
    public  $mysqli;
    public  $host="localhost";
    public  $user="root";
    public  $pw="pirlo1985";
    public  $db="ts5";
    
    // evita la injeccion de codigo sql
    public function Conectar(){
        $this->mysqli = new mysqli($this->host, $this->user, $this->pw, $this->db);
        if ($this->mysqli->connect_errno) {
            printf("Falla en la conexion: %s\n", $this->mysqli->connect_error);
            exit();
        }
    }
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
        $this->mysqli = new mysqli($ip, $User, $Pass, $db);
        if ($this->mysqli->connect_errno) {
            $Mensaje="No se pudo conectar al servidor en la ip: $ip ".$this->mysqli->connect_error;
            exit();
        }
        $Mensaje="Conexion satisfactoria";
        return($Mensaje);
                   
    }
    
    //Funcion para Conetarse a un servidor y seleccionar una base de datos
     public function CerrarCon(){
         $this->mysqli->close();
     }
    ////////////////////////////////////////////////////////////////////
//////////////////////Funcion query mysql
///////////////////////////////////////////////////////////////////
public function Query($sql)
  {	
    $this->Conectar();
    $Consul=$this->mysqli->query($sql);				
    $this->CerrarCon();
    return($Consul);
}
    ////////////////////////////////////////////////////////////////////
//////////////////////Funcion Obtener vaciar una tabla
///////////////////////////////////////////////////////////////////
public function VaciarTabla($tabla)
  {		
	$tabla=$this->normalizar($tabla);
	$sql="TRUNCATE `$tabla`";
	
	$this->Query($sql) or die('no se pudo vaciar la tabla $tabla: ' . mysql_error());	
		
	}

////////////////////////////////////////////////////////////////////
//////////////////////Funcion Actualizar registro en tabla
///////////////////////////////////////////////////////////////////

    public function update($tabla,$campo, $value, $condicion){
	$sql="UPDATE `$tabla` SET `$campo` = '$value' $condicion";
	$this->Query($sql) or die('no se pudo actualizar el registro en la $tabla: ' . mysql_error());
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
    $Vector=  $Datos->fetch_array(MYSQLI_BOTH);
    return($Vector);
}

////////////////////////////////////////////////////////////////////
//////////////////////revisa si hay resultados tras una consulta
////////////////////////////////////////////////////////////////////
    
    public function NumRows($consulta){
	
	return ($consulta->num_rows);	
		
    }
    
    //Fetch assoc
   public function FetchAssoc($Consulta) {
        $Results=$Consulta->fetch_assoc();
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
        
//Fin Clases
}
?>