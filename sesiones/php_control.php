<?php
ob_start();
session_start();
$idUser=$_SESSION['idUser'];

include_once("../modelo/php_tablas.php");  //Clases con el contenido del manejo de las tablas
$obVenta = new ProcesoVenta($idUser);
$VectorPermisos["Page"]=$myPage;
$Permiso=$obVenta->VerificaPermisos($VectorPermisos);
$Permiso=1;
if (!isset($_SESSION['username']) or $Permiso==0){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
/* 
 * Aqui se establecen los datos de conexion a la base de datos
 */

?>