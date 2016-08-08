<?php 
ob_start();
session_start();
include_once("../modelo/php_tablas.php");
include_once("css_construct.php");
if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}
$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];
$obVenta = new ProcesoVenta($idUser);
$obTabla = new Tabla($db);
$sql="";
$myPage="backups.php";


print("<html>");
print("<head>");
$css =  new CssIni("Realizar Backup en la Nube");

print("</head>");
print("<body>");
    
    if(isset($_REQUEST["LkSubir"])){
    $FechaSinc=date("Y-m-d H:i:s");
    $VectorTraslado["LocalHost"]=$host;
    $VectorTraslado["User"]=$user;
    $VectorTraslado["PW"]=$pw;
    $VectorTraslado["DB"]=$db;
    $VectorTraslado["AutoIncrement"]=0;
    $VectorT["F"]="";
    $Datos=$obVenta->MostrarTablas($db, $VectorT);
    set_time_limit(300);
    /*
    while($TablasBackup=$obVenta->FetchArray($Datos)){
        $Mensaje="";
        $VectorTraslado["Tabla"]=$TablasBackup[0];
        if($VectorTraslado["Tabla"]<>"productosventa_bodega_%"){
            $Mensaje=$obVenta->CrearBackup(2,$VectorTraslado);
        }
        if($Mensaje<>"SA"){
            
            $css->CrearNotificacionNaranja($Mensaje, 16);
        }        
    }
     * 
     
    $Mensaje="No se encontraron mas datos para sincronizar";
     * 
     */
    $VectorTraslado["Tabla"]="bodega";
    $Mensaje=$obVenta->CrearBackup(2,$VectorTraslado);
    $css->CrearNotificacionVerde($Mensaje, 16);
//header("location:$myPage");
}	
    
    $css->CabeceraIni("Realizar Backup en la Nube"); //Inicia la cabecera de la pagina
   
    $css->CabeceraFin(); 
    
    
    ///////////////Creamos el contenedor
    /////
    /////
     
     
    $css->CrearDiv("principal", "container", "center",1,1);
    $DatosServer=$obVenta->DevuelveValores("servidores", "ID", 1);
    $VectorCon["Fut"]=0;  //$DatosServer["IP"]
    
    $Mensaje=$obVenta->ConToServer($DatosServer["IP"], $DatosServer["Usuario"], $DatosServer["Password"], $DatosServer["DataBase"], $VectorCon);
    $css->CrearNotificacionAzul($Mensaje, 16);
    //$css->CrearNotificacionAzul($sql, 16);
    print("<strong>Click para Realizar el procedimiento</strong><br>");
    $css->CrearImageLink($myPage."?LkSubir=1", "../images/backup.png", "_self", 200, 200);
    $obVenta->ConToServer($host,$user,$pw,$db,$VectorCon);
    $css->CrearDiv("Secundario", "container", "center",1,1);
    $css->Creartabla();
    $css->CrearNotificacionVerde("TABLAS DISPONIBLES PARA REALIZAR BACKUP", 16);
    $VectorT["F"]="";
    $consulta=$obVenta->MostrarTablas($db, $VectorT);
    if($obVenta->NumRows($consulta)){
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Num</strong>", 1);
        $css->ColTabla("<strong>Tabla</strong>", 1);
        
        $css->CierraFilaTabla();
        $i=0;
        while($DatosTablas=$obVenta->FetchArray($consulta)){
            $i++;
            $css->FilaTabla(16);
            $css->ColTabla($i, 1);
            $css->ColTabla($DatosTablas[0], 1);
            
            $css->CierraFilaTabla();
        }
    }else{
        $css->CrearFilaNotificacion("No hay Datos pendientes por subir", 16);
    }   
    
    $css->CerrarTabla();
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->AnchoElemento("CmbDestino_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 200);
    print("</body></html>");
    ob_end_flush();
?>