<?php

/* 
 * Aqui se establecen los datos de conexion a la base de datos
 */
$host="localhost";
$user="root";
$pw="pirlo1985";
$db="ts5";
$con = mysqli_connect($host,$user,$pw,$db);
//mysql_select_db($db,$con) or die(mysql_error());
date_default_timezone_set("America/Bogota");

?>