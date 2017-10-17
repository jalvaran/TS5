<?php
/* 
 * Aqui se establecen los datos de conexion a la base de datos
 */
$host="localhost";
$user="root";
$pw="pirlo1985";
$db="ts5";
/* Para un servidor la combinacion deberá ser $TipoPC="Server"; $TipoKardex="Caja";
 * Para una Caja la combinacion deberá ser $TipoPC="Caja"; $TipoKardex="Caja";
 * Para un ServidorCaja la combinacion deberá ser $TipoPC="Caja"; $TipoKardex="Automatico";
 */
$TipoKardex="Caja"; // Automatico Para que registre automaticamente las facturas en el kardex
$TipoPC="Server";         // Server para que al abrir el menu un timer registre las facturas en el libro diario y en el kardex
?>