<?php

/* 
 * Aqui se establecen los datos de conexion a la base de datos
 */
$host="localhost";
$user="root";
$pw="pirlo1985";
$db="puntomoda";
$con = mysql_connect($host,$user,$pw);
mysql_select_db($db,$con) or die(mysql_error());
date_default_timezone_set("America/Bogota");


?>