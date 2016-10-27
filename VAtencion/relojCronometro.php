<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Crono</title>
    
    
    
    
        <link rel="stylesheet" href="css/cronometro.css">

    
    
    
    
  </head>

  <body>

    <div id="crono">
		<div class="reloj" id="Horas" style="display:none;">00</div>
		<div class="reloj" id="Minutos">00</div>
		<div class="reloj" id="Segundos">:00</div>
		<div class="reloj" id="Centesimas" style="display:none;">:00</div>
		<input type="button" class="boton" id="inicio" value="Start &#9658;" onclick="inicio();" style="display:none;" >
		<input type="button" class="boton" id="parar" value="Stop &#8718;" onclick="parar();" style="display:none;">
		<input type="button" class="boton" id="continuar" value="Resume &#8634;" onclick="inicio();" style="display:none;">
		<input type="button" class="boton" id="reinicio" value="Reset &#8635;" onclick="reinicio();" style="display:none;">
	</div>
    <script src='chousen/source/jquery.min.js'></script>

        <script src="js/cronometro.js"></script>
        <script src="js/funciones.js"></script>
    
    
  </body>

<?php

print("<div id='DivConsultas'>");
print("Cargando Consultas, si esto no desaparece es porque no se pudo cargar");
print("</div>");
print("<script>refresca('1000')</script>");
?>
</html>