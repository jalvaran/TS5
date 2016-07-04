<?php

/* 
 * Aqui se establecen los datos de conexion a la base de datos
 */

$con = mysql_connect("localhost","root","pirlo1985");
mysql_select_db("softcontech_v5",$con) or die(mysql_error());
date_default_timezone_set("America/Bogota");
$db="softcontech_v5";

?>