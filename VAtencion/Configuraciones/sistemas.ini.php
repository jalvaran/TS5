<?php
$obVenta = new ProcesoVenta($idUser);
$DatosEmpresa=$obVenta->DevuelveValores("empresapro", "idEmpresaPro", 1);
$myTabla="sistemas";
$idTabla="ID";
$myPage="sistemas.php";
$myTitulo="Sistemas";

/*
 * Opciones en Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
$Vector["VerRegistro"]["Deshabilitado"]=1;                      
//$Vector["EditarRegistro"]["Deshabilitado"]=1; 

/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
$Vector["MyPage"]=$myPage;            //pagina
///Columnas excluidas

//Link para la accion ver
$Ruta="../tcpdf/examples/imprimirOT.php?idOT=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="ID";

$Vector["Excluir"]["Estado"]=1;
$Vector["Excluir"]["Hora"]=1;
$Vector["Excluir"]["idUsuarioCreador"]=1;
$Vector["Required"]["TipoOrden"]=1;

//Nueva Accion
$Ruta="AgregaItemsOT.php?idOT=";
$Vector["NuevaAccionLink"][0]="AsociarCoti";
$Vector["NuevaAccion"]["AsociarCoti"]["Titulo"]="Agregar Actividades";
$Vector["NuevaAccion"]["AsociarCoti"]["Link"]=$Ruta;
$Vector["NuevaAccion"]["AsociarCoti"]["ColumnaLink"]="ID";
$Vector["NuevaAccion"]["AsociarCoti"]["Target"]="_self";

/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */
$Vector["Required"]["Departamento"]=1;   
$Vector["Required"]["Nombre"]=1; 
$Vector["Required"]["PrecioVenta"]=1;
$Vector["Required"]["CostoUnitario"]=1;
$Vector["Required"]["IVA"]=1;
$Vector["Required"]["CuentaPUC"]=1;                  //Columna que quiero mostrar


$Vector["IVA"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["IVA"]["TablaVinculo"]="porcentajes_iva";  //tabla de donde se vincula
$Vector["IVA"]["IDTabla"]="Valor"; //id de la tabla que se vincula
$Vector["IVA"]["Display"]="Nombre"; 
$Vector["IVA"]["Predeterminado"]=0;

$Vector["Departamento"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Departamento"]["TablaVinculo"]="prod_departamentos";  //tabla de donde se vincula
$Vector["Departamento"]["IDTabla"]="idDepartamentos"; //id de la tabla que se vincula
$Vector["Departamento"]["Display"]="Nombre";                    //Columna que quiero mostrar
$Vector["Departamento"]["Predeterminado"]="N";

$Vector["Sub1"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub1"]["TablaVinculo"]="prod_sub1";  //tabla de donde se vincula
$Vector["Sub1"]["IDTabla"]="idSub1"; //id de la tabla que se vincula
$Vector["Sub1"]["Display"]="NombreSub1";                    //Columna que quiero mostrar

$Vector["Sub2"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub2"]["TablaVinculo"]="prod_sub2";  //tabla de donde se vincula
$Vector["Sub2"]["IDTabla"]="idSub2"; //id de la tabla que se vincula
$Vector["Sub2"]["Display"]="NombreSub2";                    //Columna que quiero mostrar

$Vector["Sub3"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub3"]["TablaVinculo"]="prod_sub3";  //tabla de donde se vincula
$Vector["Sub3"]["IDTabla"]="idSub3"; //id de la tabla que se vincula
$Vector["Sub3"]["Display"]="NombreSub3";                    //Columna que quiero mostrar

$Vector["Sub4"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub4"]["TablaVinculo"]="prod_sub4";  //tabla de donde se vincula
$Vector["Sub4"]["IDTabla"]="idSub4"; //id de la tabla que se vincula
$Vector["Sub4"]["Display"]="NombreSub4";                    //Columna que quiero mostrar
//
$Vector["Sub5"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub5"]["TablaVinculo"]="prod_sub5";  //tabla de donde se vincula
$Vector["Sub5"]["IDTabla"]="idSub5"; //id de la tabla que se vincula
$Vector["Sub5"]["Display"]="NombreSub5";                    //Columna que quiero mostrar
///Filtros y orden
if($DatosEmpresa["Regimen"]=="COMUN"){
    $Vector["IVA"]["Predeterminado"]='0.19';
}else{
    $Vector["IVA"]["Predeterminado"]='0';
}
///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>