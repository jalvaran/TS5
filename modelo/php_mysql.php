<?php
include_once("php_settings.php");
/*
 * Esta clase contiene los datos necesarios para tratar y dibujar las tablas
 * 
 */
class mysql_conexion{
    private $consulta;
	private $fetch;
	private $MaxNumCoti;
	private $idUser;
	private $NumCotizacion;
	private $NombreUser;
        public  $CuentaIVAGen=2408;
        public  $TablaIVAGen="cuentas";
        public  $IDTablaIVAGen="idPUC";
        public  $RegCREE="NO";
        public  $CuentaCREE=135595;
        public  $ContraPartidaCREE=23657502;
	public  $CuentaCostoMercancia=6135;
	public  $CuentaInventarios=1435;
              
	function __construct($idUserR){
		$idUserR=$this->normalizar($idUserR);		
		$this->consulta =mysql_query("SELECT Nombre, TipoUser FROM usuarios WHERE idUsuarios='$idUserR'") or die('problemas para consultas usuarios: ' . mysql_error());
		$this->fetch = mysql_fetch_array($this->consulta);
		$this->NombreUser = $this->fetch['Nombre'];
		$this->idUser=$idUserR;
                $this->TipoUser=$this->fetch['TipoUser'];
                
                //$this->VerificaPermisos($VectorPermisos);
	}
        
        /////Suma un valor en especifico de una tabla	
		
	function SumeColumna($Tabla,$NombreColumnaSuma, $NombreColumnaFiltro,$filtro){
	
	$Tabla=$this->normalizar($Tabla);
        $NombreColumnaSuma=$this->normalizar($NombreColumnaSuma);
        $NombreColumnaFiltro=$this->normalizar($NombreColumnaFiltro);
        $filtro=$this->normalizar($filtro);
		
	$sql="SELECT SUM($NombreColumnaSuma) AS suma FROM $Tabla WHERE $NombreColumnaFiltro = '$filtro'";
	
	$reg=mysql_query($sql) or die('no se pudo obtener la suma de $NombreColumnaSuma para la tabla $Tabla en SumeColumna: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	
	return($reg["suma"]);

	}	
        
        /////Suma un valor en especifico de una tabla segun una condicion
		
	function Sume($Tabla,$NombreColumnaSuma, $Condicion){
	
	
		
	$sql="SELECT SUM($NombreColumnaSuma) AS suma FROM $Tabla $Condicion";
	
	$reg=mysql_query($sql) or die('no se pudo obtener la suma de '.$sql.' '.$NombreColumnaSuma.' para la tabla '.$Tabla.' en SumeColumna: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	
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
	
	
	mysql_query($sql) or die("no se pudo ingresar el registro en la tabla $tabla desde la funcion Insertar Registro: " . mysql_error());	
		
        }
        
        ////////////////////////////////////////////////////////////////////
        //////////////////////Funcion devuelve valores
        ///////////////////////////////////////////////////////////////////

        public function DevuelveValores($tabla,$ColumnaFiltro, $idItem){
                $tabla=$this->normalizar($tabla);
                $ColumnaFiltro=$this->normalizar($ColumnaFiltro);
                $idItem=$this->normalizar($idItem);
                $reg=mysql_query("select * from $tabla where $ColumnaFiltro = '$idItem'") or die("no se pudo consultar los valores de la tabla $tabla en DevuelveValores: " . mysql_error());
                $reg=mysql_fetch_array($reg);	
                return ($reg);
        }

               
        ////////////////////////////////////////////////////////////////////
        //////////////////////Funcion devuelve el valor de una columna
        ///////////////////////////////////////////////////////////////////

        public function ValorActual($tabla,$Columnas,$Condicion){

                $reg=mysql_query("SELECT $Columnas FROM $tabla WHERE $Condicion") or die("no se pudo consultar los valores de la tabla $tabla en ValorActual: " . mysql_error());
                $reg=mysql_fetch_array($reg);	
                return ($reg);
        }
        
        
        ///Fin
}
   
?>