<?php 
$myPage="GraficosVentasXDepartamentos.php";
include_once("../sesiones/php_control.php");
include_once("css_construct.php");
$obVenta = new ProcesoVenta($idUser);

$FechaInicial=date("Y-m-d");
$FechaFinal=date("Y-m-d");
if(isset($_REQUEST["TxtFechaFin"])){
    $FechaInicial=$obVenta->normalizar($_REQUEST["TxtFechaIni"]);
    $FechaFinal=$obVenta->normalizar($_REQUEST["TxtFechaFin"]);
}

//print("$FechaInicial $FechaFinal");
$sql="SELECT `Departamento`,SUM(`Total`) AS Total FROM `vista_resumen_ventas_departamentos` "
        . "WHERE `FechaFactura`>='$FechaInicial' AND `FechaFactura`<='$FechaFinal' GROUP BY `Departamento`";
$consulta=$obVenta->Query($sql);
$i=0;
while($DatosVentas=$obVenta->FetchArray($consulta)){
    $Departamento=$DatosVentas["Departamento"];
    $DatosDepartamento=$obVenta->DevuelveValores("prod_departamentos", "idDepartamentos", $Departamento);
    
    $NombresColumnas[$i]=$DatosDepartamento["Nombre"];
    $ValoresColumnas[$i]=$DatosVentas["Total"];
    $i++;
}


print("<html>");
print("<head>");

?>

		
		
<?php        
    $css =  new CssIni("Ventas x Departamentos");  
    print("</head>");
    print("<body>");
    
    //Cabecera
    $css->CabeceraIni("Ventas x Departamentos"); //Inicia la cabecera de la pagina
    $css->CabeceraFin(); 
    
        $css->CrearDiv("DivFormulario", "container", "center", 1, 1);
            $css->CrearForm2("FrmVentas", $myPage, "post", "_self");
                $css->CrearTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Ventas X Departamentos</strong>", 3);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
                        $css->ColTabla("<strong>Fecha Final</strong>", 1);
                        $css->ColTabla("<strong>Ejecutar</strong>", 1);
                    $css->CierraFilaTabla();
                    $css->FilaTabla(16);
                        print("<td>");
                            $css->CrearInputFecha("", "TxtFechaIni", $FechaInicial, 150, 30, "");
                        print("</td>");
                        print("<td>");
                            $css->CrearInputFecha("", "TxtFechaFin", $FechaFinal, 150, 30, "");
                        print("</td>");
                        print("<td>");
                        //$Page="GraficosVentasXDepartamentos.query.php";
                        //$funcion="EnvieObjetoConsulta2(`$Page`,`TxtFechaFin`,`DivGraficos`,`4`);";
                        //$css->CrearBotonEvento("BtnEnviar", "Mostrar", 1, "onclick", $funcion, "naranja", "");
                        $css->CrearBotonNaranja("BtnEnviar", "Mostrar");
                        print("</td>");
                    $css->CierraFilaTabla();
                $css->CerrarTabla();
            $css->CerrarForm();
        $css->CerrarDiv();
   
    //Div para los graficos
    $css->CrearDiv("DivGraficos", "container", "center",1,1);
        
    $css->CerrarDiv();
    $css->CrearDiv("DivGraficos2", "container", "center",1,1);
        
    $css->CerrarDiv();
    
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaJSGraficos();
    $css->AgregaSubir(); 
    
    $Titulo="Ventas X Departamentos desde $FechaInicial hasta $FechaFinal";
    $Subtitulo="TS5";
    if(isset($NombresColumnas)){
        $css->CreeGraficoBarrasSimple($Titulo, $Subtitulo, "Departamentos","Pesos ($)",$NombresColumnas, $ValoresColumnas, "DivGraficos", "");
    
    }else{
       $css->CrearDiv("DivNotificaciones", "container", "left", 1, 1);
            $css->CrearNotificacionRoja("No hay datos en este rango de tiempo", 16);
       $css->CerrarDiv();
    }
        
   
    $css->Footer();
    ////Fin HTML  
    print("</body></html>");
?> 
      