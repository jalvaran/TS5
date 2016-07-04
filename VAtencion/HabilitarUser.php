<?php 
ob_start();
session_start();

include_once("../modelo/php_conexion.php");
include_once("css_construct.php");

if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}

if ($_SESSION['tipouser']=="operador")
{
  header("location:401.php");
  
}

$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	

$myPage="HabilitarUser.php";
$css =  new CssIni("Habilitar User");
$css->CabeceraIni("Asignacion de Usuarios a Cajas"); 
$css->CabeceraFin();

$css->CrearDiv("principal", "container", "Center", 1, 1);
$obVenta=new ProcesoVenta($idUser);
if(!empty($_REQUEST['ImgCerrarCajas'])){

            
            $obVenta->VaciarTabla("vestasactivas");// vaciar ventas activas
            $obVenta->VaciarTabla("preventa");// Crea otra preventa
            $css->CrearNotificacionRoja("Se han borrado todas las preventas", 16);
            
    }
    
$css->CrearTabla();
print("<td>");
$css->CrearDiv("vaciar", "", "Center", 1, 1);
$css->CrearNotificacionRoja("Click para Borrar Todas las preventas: ", 18);
$css->CrearImageLink("$myPage?ImgCerrarCajas=1", "../images/CerrarCajas.png", "_self", 200, 200);
$css->CerrarDiv();
print("</td>");
$css->CerrarTabla();

$css->CrearTabla();
    $Consulta=$obVenta->ConsultarTabla("cajas", "");
    if($obVenta->NumRows($Consulta)){
        $css->FilaTabla(16);
        $css->ColTabla("<strong>ID</strong>", 1);
        $css->ColTabla("<strong>Nombre</strong>", 1);
        $css->ColTabla("<strong>Base</strong>", 1);
        $css->ColTabla("<strong>Usuario</strong>", 1);
        $css->ColTabla("<strong>Estado</strong>", 1);
        $css->CierraFilaTabla();
        while ($DatosCajas=$obVenta->FetchArray($Consulta)){
            $css->FilaTabla(14);
                $css->ColTabla($DatosCajas["ID"], 1);
                $css->ColTabla($DatosCajas["Nombre"], 1);
                $css->ColTabla($DatosCajas["Base"], 1);
                $css->ColTabla($DatosCajas["idUsuario"], 1);
                $css->ColTabla($DatosCajas["Estado"], 1);
            $css->CierraFilaTabla();
        }
        
    }else{
        $css->CrearFilaNotificacion("No hay Cajas Creadas", 16);
    }
$css->CerrarTabla();
$css->CerrarDiv();

$css->AgregaJS();
$css->AgregaSubir();
$css->AgregaJSVentaRapida();
$css->Footer();

ob_end_flush();
?>