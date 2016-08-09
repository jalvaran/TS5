<?php

$myTabla="paginas_bloques";
$myPage="paginas_bloques.php";
$myTitulo="Configurar Paginas De Acceso";
$MyID="ID";


/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
/*
 * Deshabilito Acciones
 * 
 */
 
$Vector["VerRegistro"]["Deshabilitado"]=1;       

$Vector["Excluir"]["Kit"]=1;
///Columnas requeridas al momento de una insercion
$Vector["Required"]["TipoUsuario"]=1;   
$Vector["Required"]["Pagina"]=1; 
$Vector["Required"]["Habilitado"]=1;

//
//
$Vector["Pagina"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Pagina"]["TablaVinculo"]="paginas";  //tabla de donde se vincula
$Vector["Pagina"]["IDTabla"]="Nombre"; //id de la tabla que se vincula
$Vector["Pagina"]["Display"]="Nombre";                    //Columna que quiero mostrar
$Vector["Pagina"]["Predeterminado"]=0;

$Vector["TipoUsuario"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["TipoUsuario"]["TablaVinculo"]="usuarios_tipo";  //tabla de donde se vincula
$Vector["TipoUsuario"]["IDTabla"]="Tipo"; //id de la tabla que se vincula
$Vector["TipoUsuario"]["Display"]="Tipo"; 
$Vector["TipoUsuario"]["Predeterminado"]=0;

$Vector["Habilitado"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Habilitado"]["TablaVinculo"]="respuestas_condicional";  //tabla de donde se vincula
$Vector["Habilitado"]["IDTabla"]="Valor"; //id de la tabla que se vincula
$Vector["Habilitado"]["Display"]="Valor";                    //Columna que quiero mostrar
$Vector["Habilitado"]["Predeterminado"]=1;

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
$Vector["Order"]=" $MyID DESC ";   //Orden
?>