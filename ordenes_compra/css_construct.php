<style type="text/css">
			
        * {
                margin:0px;
                padding:0px;
        }

        #MenuBasico {
                margin:0px;
                width:auto;
                font-family:Arial, Helvetica, sans-serif;
        }

        ul, ol {
                list-style:none;
        }

        .nav > li {
                float:left;
        }

        .nav li a {
                background-color:#000;
                color:#fff;
                text-decoration:none;
                padding:10px 12px;
                display:block;
        }

        .nav li a:hover {
                background-color:#434343;
        }

        .nav li ul {
                display:none;
                position:absolute;
                min-width:140px;
        }

        .nav li:hover > ul {
                display:block;
        }

        .nav li ul li {
                position:relative;
        }

        .nav li ul li ul {
                right:-140px;
                top:0px;
        }
        
</style>

<link rel="stylesheet" href="css/cronometro.css">
<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>

<?php
	

//////////////////////////////////////////////////////////////////////////
////////////Clase para iniciar css ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

class CssIni{
	private $Titulo;
	
	
	function __construct($Titulo){
		
		print("
		<meta charset='utf-8'>
		<title>$Titulo</title>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<meta name='description' content='Software de Techno Soluciones'>
		<meta name='author' content='Techno Soluciones SAS'>

		<!-- Le styles -->
		<link href='css/bootstrap.css' rel='stylesheet'>
		<link href='css/pagination.css' rel='stylesheet' type='text/css' />
		<link href='css/B_blue.css' rel='stylesheet' type='text/css' />
		<style type='text/css'>
		  body {
			padding-top: 60px;
			padding-bottom: 40px;
		  }
		</style>
		<link href='css/bootstrap-responsive.css' rel='stylesheet'>
                
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src='../assets/js/html5shiv.js'></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		
		<link rel='apple-touch-icon-precomposed' sizes='144x144' href='ico/apple-touch-icon-144-precomposed.png'>
		<link rel='apple-touch-icon-precomposed' sizes='114x114' href='ico/apple-touch-icon-114-precomposed.png'>
		<link rel='apple-touch-icon-precomposed' sizes='72x72' href='ico/apple-touch-icon-72-precomposed.png'>
                <link rel='apple-touch-icon-precomposed' href='ico/apple-touch-icon-57-precomposed.png'>
                                           <link rel='shortcut icon' href='../images/technoIco.ico'>
		<link rel='stylesheet' href='chousen/docsupport/style.css'>
                <link rel='stylesheet' href='chousen/docsupport/prism.css'>
                <link rel='stylesheet' href='chousen/source/chosen.css'>
                <link rel='stylesheet' href='css/calendar.css'>   
                <link rel='stylesheet' type='text/css' href='css/bootstrap.min.css' />
                <link rel='stylesheet' type='text/css' href='css/DateTimePicker.css' />
		");
		print('<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>	
		<script type="text/javascript" src="js/DateTimePicker.js"></script>
                <script src="../plugins/ckeditor/ckeditor.js"></script>
                <script src="../plugins/ckeditor/js/sample.js"></script>
');
	}
	
	/////////////////////Inicio una cabecera
	
	function CabeceraIni($Title){
		
		print('
			 <div class="navbar navbar-inverse navbar-fixed-top" >
			  <div class="navbar-inner">
				<div class="container">
				  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="brand" href="../VMenu/Menu.php">'.$Title.'</a>
				  <div class="nav-collapse collapse">
					<ul class="nav">
					<li>
					
		');
	}
	
	/////////////////////Cierro la Cabecera de la pagina
	
	function CabeceraFin(){
		
		print('
				</li>
				</ul>
				  </div><!--/.nav-collapse -->
				</div>
			  </div>
			</div>
		
		');
	}
	
	
	/////Crea botones con despliegue
		
	function CreaBotonDesplegable($NombreBoton,$TituloBoton)
  {
	
		
	print('<li><a href="#'.$NombreBoton.'" role="button" class="btn" data-toggle="modal" title="'.$TituloBoton.'">
			<span class="badge badge-success">'.$TituloBoton.'</span></a></li>');

	}	
	
	function CreaBotonAgregaPreventa($Page,$idUser)
  {
		
	print('	<a class="brand" href="'.$Page.'?BtnAgregarPreventa='.$idUser.'">+ Preventa</a>');

	}	
	
	
	/////////////////////Crea un Formulario
	
	function CrearForm($nombre,$action,$method,$target){
		print('<li><form name= "'.$nombre.'" action="'.$action.'" id="'.$nombre.'" method="'.$method.'" target="'.$target.'"></li>');
		
	}
        /////////////////////Crea un Formulario
	
	function CrearForm2($nombre,$action,$method,$target){
            print('<form name= "'.$nombre.'" action="'.$action.'" id="'.$nombre.'" method="'.$method.'" target="'.$target.'" enctype="multipart/form-data">');
		
	}
	
	/////////////////////Crea un Formulario
	
	function CrearFormularioEvento($nombre,$action,$method,$target,$evento){
		print('<form name= "'.$nombre.'" action="'.$action.'" id="'.$nombre.'" method="'.$method.'" target="'.$target.'" '.$evento.'" enctype="multipart/form-data">');
		
	}
	
	
	/////////////////////Cierra un Formulario
	
	function CerrarForm(){
		print('</li></form>');
		
	}
	
	
	/////////////////////Crea un Select
	
	function CrearSelect($nombre,$evento){
		print('<select id="'.$nombre.'" required name="'.$nombre.'" onchange="'.$evento.'" >');
		
	}
        
        /////////////////////Crea un Select con requerimiento
	
	function CrearSelect2($Vector){
            $nombre=$Vector["Nombre"];
            $evento=$Vector["Evento"];
            $funcion=$Vector["Funcion"];
            if($Vector["Required"]==1){
                $R="required";
            }else{
                $R="";
            }
            print("<select id='$nombre' $R name='$nombre' $evento='$funcion'>");
		
	}
        
        /////////////////////Crea un Select personalizado
	
	function CrearSelectPers($Vector){
            $nombre=$Vector["Nombre"];
            $Evento=$Vector["Evento"];
            $Ancho=$Vector["Ancho"];
            $Alto=$Vector["Alto"];
            print('<select name="'.$nombre.'" '.$Evento.' style="width:'.$Ancho.'px; height:'.$Alto.'px;" >');
		
	}
	
	/////////////////////Cierra un Select
	
	function CerrarSelect(){
		print('</select>');
		
	}
	
	
	/////////////////////Crea un Option Select
	
	function CrearOptionSelect($value,$label,$selected){
		
		if($selected==1)
			print('<option value='.$value.' selected>'.$label.'</option>');
		else
			print('<option value='.$value.'>'.$label.'</option>');
		
	}
        
        /////////////////////Crea un Option Select
	
	function CrearOptionSelect2($value,$label,$javascript,$selected){
		
		if($selected==1)
			print('<option value='.$value.'  selected '.$javascript.'>'.$label.'</option>');
		else
			print('<option value='.$value.' '.$javascript.'>'.$label.' </option>');
		
	}
	
	
	/////////////////////Crea un Cuadro de texto input
	
	function CrearInputText($nombre,$type,$label,$value,$placeh,$color,$TxtEvento,$TxtFuncion,$Ancho,$Alto,$ReadOnly,$Required){
		
            if($nombre=="TxtDevuelta"){
                    $TFont="2em";
                }else {
                    $TFont="1em";
                }
                
		if($ReadOnly==1)
			$ReadOnly="readonly";
		else
			$ReadOnly="";
		
		if($Required==1)
			$Required="required";
		else
			$Required="";
		$JavaScript=$TxtEvento.' = '.$TxtFuncion;
                
                print('<strong style="color:'.$color.'">'.$label.'<input name="'.$nombre.'" value="'.$value.'" type="'.$type.'" id="'.$nombre.'" placeholder="'.$placeh.'" '.$JavaScript.' 
                '.$ReadOnly.' '.$Required.' autocomplete="off" style="width: '.$Ancho.'px;height: '.$Alto.'px; font-size: '.$TFont.'"></strong>');

	}
	
	/////////////////////Crea un text area
	
	function CrearTextArea($nombre,$label,$value,$placeh,$color,$TxtEvento,$TxtFuncion,$Ancho,$Alto,$ReadOnly,$Required){
		
		if($ReadOnly==1)
			$ReadOnly="readonly";
		else
			$ReadOnly="";
		
		if($Required==1){
			print("<strong style= 'color:$color'>$label<textarea name='$nombre' id='$nombre' placeholder='$placeh' $TxtEvento = '$TxtFuncion'" 
			." $ReadOnly autocomplete='off' style='width: ".$Ancho."px; height: ".$Alto."px;' required>".$value."</textarea></strong>");
                }else{
			print("<strong style= 'color:$color'>$label<textarea name='$nombre' id='$nombre' placeholder='$placeh' $TxtEvento = '$TxtFuncion'" 
			." $ReadOnly autocomplete='off' style='width: ".$Ancho."px; height: ".$Alto."px;' >".$value."</textarea></strong>");
                }
			
		
	}
	
	/////////////////////Crea un Cuadro de texto input
	
	function CrearInputNumber($nombre,$type,$label,$value,$placeh,$color,$TxtEvento,$TxtFuncion,$Ancho,$Alto,$ReadOnly,$Required,$Min,$Max,$Step){
		
		if($ReadOnly==1)
			$ReadOnly="readonly";
		else
			$ReadOnly="";
		
		if($Required==1)
			$Required="required";
		else
			$Required="";
		
			print('<strong style="color:'.$color.'">'.$label.'<input name="'.$nombre.'" value="'.$value.'" type="'.$type.'" id="'.$nombre.'" placeholder="'.$placeh.'" '.$TxtEvento.' = "'.$TxtFuncion.'" 
			'.$ReadOnly.' '.$Required.' min="'.$Min.'"   max="'.$Max.'" step="'.$Step.'" autocomplete="off" style="width: '.$Ancho.'px;height: '.$Alto.'px;"></strong>');
		
	}
	
	/////////////////////Crea un Boton Submit
	
	function CrearBoton($nombre,$value){
		print('<input type="submit" id="'.$nombre.'"  name="'.$nombre.'" value="'.$value.'" class="btn btn-info"></input>');
		
	}
        
       
        
        /////////////////////Crea un Boton Submit
	
	function CrearBotonReset($nombre,$value){
		print('<input type="reset" id="'.$nombre.'"  name="'.$nombre.'" value="'.$value.'" class="btn btn-warning">');
		
	}
	
	/////////////////////Crea un Cuadro de Dialogo
	
	function CrearCuadroDeDialogo($id,$title){
		
		print(' <div id="'.$id.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
       
          	
            <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
    	        <h3 id="myModalLabel">'.$title.'</h3>
            </div>
            <div class="modal-body">
           	    <div class="row-fluid">
	               
    	            <div class="span6">
                    	
						
                   
            
        ');
		
	}
        
        /////////////////////Crea un Cuadro de Dialogo
	
	function CrearCuadroDeDialogo2($id,$title,$visible,$VectorDialogo){
            if($visible==1){
                $visible=true;
            }else{
                $visible=false;
            }
		print('<div id="'.$id.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" >
       
          	
            <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="'.$visible.'">×</button>
    	        <h3 id="myModalLabel">'.$title.'</h3>
            </div>
            <div class="modal-body">
           	    <div class="row-fluid">
	               
    	            <div class="span6">
                    	
						
                   
            
        ');
		
	}
	
        /////////////////////Crea un Cuadro de Dialogo
	
	function CrearCuadroDeDialogoAmplio($id,$title){
		
		print(' <div id="'.$id.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style=" width: 95%;left:23%;">
       
          	
            <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
    	        <h3 id="myModalLabel">'.$title.'</h3>
            </div>
            <div class="modal-body">
           	                       	
		
        ');
		
	}
        
        /////////////////////Cierra un Cuadro de Dialogo
	
	function CerrarCuadroDeDialogoAmplio(){
		print(' </div></div>');
        }
	/////////////////////Cierra un Cuadro de Dialogo
	
	function CerrarCuadroDeDialogo(){
		print(' </div>
                </div>
            </div>
            
            <div class="modal-footer">
        	    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
            	
            </div></div>');
		
	}
	
	
	/////////////////////Crear una Tabla
	
	function CrearTabla(){
		print('<table class="table table-bordered table table-hover" >');
		
	}
	
	/////////////////////Crear una fila para una tabla
	
	function FilaTabla($FontSize){
		print('<tr style="font-size:'.$FontSize.'px">');
		
	}
	
	function CierraFilaTabla(){
		print('</tr>');
		
	}
	
	/////////////////////Crear una columna para una tabla
	
	function ColTabla($Contenido,$ColSpan,$align="L"){
            if($align=="L"){
              $align="left";  
            }
            if($align=="R"){
              $align="right";  
            }
            if($align=="C"){
              $align="center";  
            }
            print('<td colspan="'.$ColSpan.' " style="text-align:'.$align.'"   >'.$Contenido.'</td>');
		
	}
	
	function CierraColTabla(){
		print('</td>');
		
	}
	/////////////////////Cierra una tabla
	
	function CerrarTabla(){
		print('</table>');
		
	}
	
	/////////////////////Crear una columna para una tabla
	
	function ColTablaDel($Page,$tabla,$IdTabla,$ValueDel,$idPre){
           
		print('<td align="center">
                  	<a href="'.$Page.'?del='.$ValueDel.'&TxtTabla='.$tabla.'&TxtIdTabla='.$IdTabla.'&TxtIdPre='.$idPre.'" title="Eliminar de la Lista" >
               		<i class="icon-remove">X</i>
                                    </a>
                                </td>');
		
	}
	
	/////////////////////Crear una columna para enviar una variable por URL
	
	function ColTablaVar($Page,$Variable,$Value,$idPre,$Title){
		print('<td><a href="'.$Page.'?'.$Variable.'='.$Value.'&TxtIdPre='.$idPre.'" title="'.$Title.'">'.$Title.'</a></td>');
                               
		
	}
	
	/////////////////////Crear una columna con un formulario
	
	function ColTablaFormInputText($FormName,$Action,$Method,$Target,$TxtName,$TxtType,$TxtValue,$TxtLabel,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtAncho,$TxtAlto,$ReadOnly,$Required,$TxtHide,$ValueHide,$idPreventa){
			
		print('<td>');
		$this->CrearForm2($FormName,$Action,$Method,$Target);
		$this->CrearInputText($TxtHide,"hidden","",$ValueHide,"","","","","","","","");
		$this->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
                $this->CrearInputNumber($TxtName, $TxtType, $TxtLabel, $TxtValue, $TxtPlaceh, $TxtColor, "", "", $TxtAncho, $TxtAlto, $ReadOnly, $Required, "", "", "any");
		//$this->CrearInputText($TxtName,$TxtType,$TxtLabel,$TxtValue,$TxtPlaceh,$TxtColor,"","",$TxtAncho,$TxtAlto,$ReadOnly,$Required);
		
                print("<input type='submit' id='BtnCantidad$TxtName' name='BtnEditarCantidad' value='E' style='width: 30px;height: 30px;' $TxtEvento='$TxtFuncion' >");
		$this->CerrarForm();
		print('</td>');
                               
		
	}
        
        /////////////////////Crear una columna con un formulario
	
	function DivColTablaFormInputText($FormName,$Action,$Method,$Target,$TxtName,$TxtType,$TxtValue,$TxtLabel,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtAncho,$TxtAlto,$ReadOnly,$Required,$TxtHide,$ValueHide,$idPreventa){
			
		$this->DivColTable("left", 0, 1, "black", "100%", "");
		$this->CrearForm2($FormName,$Action,$Method,$Target);
		$this->CrearInputText($TxtHide,"hidden","",$ValueHide,"","","","","","","","");
		$this->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
                $this->CrearInputNumber($TxtName, $TxtType, $TxtLabel, $TxtValue, $TxtPlaceh, $TxtColor, "", "", $TxtAncho, $TxtAlto, $ReadOnly, $Required, "", "", "any");
		//$this->CrearInputText($TxtName,$TxtType,$TxtLabel,$TxtValue,$TxtPlaceh,$TxtColor,"","",$TxtAncho,$TxtAlto,$ReadOnly,$Required);
		
                print("<input type='submit' id='BtnCantidad$TxtName' name='BtnEditarCantidad' value='E' style='width: 30px;height: 30px;' $TxtEvento='$TxtFuncion' >");
		$this->CerrarForm();
		print('</div>');
                               
		
	}
        
        /////////////////////Crear una columna con un formulario
	
	function ColTablaFormEditarPrecio($FormName,$Action,$Method,$Target,$TxtName,$TxtType,$TxtValue,$TxtLabel,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtFuncion2,$TxtAncho,$TxtAlto,$ReadOnly,$Required,$TxtHide,$ValueHide,$idPreventa,$TxtPrecioMayor,$ValueMayor){
				
		print('<td>');
                 //print("<script>alert('Vector $ReadOnly')</script>");
		$this->CrearForm2($FormName,$Action,$Method,$Target);
		$this->CrearInputText($TxtHide,"hidden","",$ValueHide,"","","","","","","","");
                $this->CrearInputText($TxtPrecioMayor,"hidden","",$ValueMayor,"","","","","","","","");
		$this->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
                //$this->CrearInputNumber($TxtName, $TxtType, $TxtLabel, $TxtValue, $TxtPlaceh, $TxtColor, "", "", $TxtAncho, $TxtAlto, $ReadOnly, $Required, "", "", "any")
		$this->CrearInputText($TxtName,$TxtType,$TxtLabel,$TxtValue,$TxtPlaceh,$TxtColor,"","",$TxtAncho,$TxtAlto,$ReadOnly,$Required);
                
		//print("<input type='submit' id='BtnEditar$TxtName' name='BtnEditar' value='E' style='width: 30px;height: 30px;' onClick='$TxtFuncion'>");
		$vector["Enable"]=$ReadOnly;
                $vector["Color"]="Azul";
                $this->CrearBotonPersonalizado("BtnEditar", "E",$vector);
                $vector["Color"]="Verde";
                $this->CrearBotonPersonalizado("BtnMayorista", "M",$vector);
                $this->CerrarForm();
		print('</td>');
                               
		
	}
        
        /////////////////////Crear una columna con un formulario
	
	function DivColTablaFormEditarPrecio($FormName,$Action,$Method,$Target,$TxtName,$TxtType,$TxtValue,$TxtLabel,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtFuncion2,$TxtAncho,$TxtAlto,$ReadOnly,$Required,$TxtHide,$ValueHide,$idPreventa,$TxtPrecioMayor,$ValueMayor){
				
		$this->DivColTable("left", 0, 1, "black", "100%", "");
                 //print("<script>alert('Vector $ReadOnly')</script>");
		$this->CrearForm2($FormName,$Action,$Method,$Target);
		$this->CrearInputText($TxtHide,"hidden","",$ValueHide,"","","","","","","","");
                $this->CrearInputText($TxtPrecioMayor,"hidden","",$ValueMayor,"","","","","","","","");
		$this->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
                //$this->CrearInputNumber($TxtName, $TxtType, $TxtLabel, $TxtValue, $TxtPlaceh, $TxtColor, "", "", $TxtAncho, $TxtAlto, $ReadOnly, $Required, "", "", "any")
		$this->CrearInputText($TxtName,$TxtType,$TxtLabel,$TxtValue,$TxtPlaceh,$TxtColor,"","",$TxtAncho,$TxtAlto,$ReadOnly,$Required);
                
		//print("<input type='submit' id='BtnEditar$TxtName' name='BtnEditar' value='E' style='width: 30px;height: 30px;' onClick='$TxtFuncion'>");
		$vector["Enable"]=$ReadOnly;
                $vector["Color"]="Azul";
                $this->CrearBotonPersonalizado("BtnEditar", "E",$vector);
                $vector["Color"]="Verde";
                $this->CrearBotonPersonalizado("BtnMayorista", "M",$vector);
                $this->CerrarForm();
		print('</div>');
                               
		
	}
	
	
	/////////////////////Crear una columna con un formulario
	
	function ColTablaInputText($TxtName,$TxtType,$TxtValue,$TxtLabel,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtAncho,$TxtAlto,$ReadOnly,$Required){
		print('<td>');
		
		$this->CrearInputText($TxtName,$TxtType,$TxtLabel,$TxtValue,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtAncho,$TxtAlto,$ReadOnly,$Required);
		
		print('</td>');
                               
		
	}
        
        /////////////////////Crear una columna con un formulario
	
	function DivColTablaInputText($TxtName,$TxtType,$TxtValue,$TxtLabel,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtAncho,$TxtAlto,$ReadOnly,$Required){
		
		$this->DivColTable("left", 0, 1, "black", "100%", "");
		$this->CrearInputText($TxtName,$TxtType,$TxtLabel,$TxtValue,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtAncho,$TxtAlto,$ReadOnly,$Required);
		
		print('</div>');
                               
		
	}
	
	/////////////////////Crear una columna con un formulario
	
	function ColTablaBoton($nombre,$value){
		print('<td>');
		
		$this->CrearBoton($nombre,$value);
		
		print('</td>');
                               
		
	}
	
	
	function CreaMenuBasico($Title){
		print('<div id="MenuBasico">
			<ul class="nav">
				
				<li><a href="">'.$Title.'</a>
					<ul>
						
						
						
					
				
	');
		
		                              
		
	}
	
	function CreaSubMenuBasico($Title,$Link){
		print('<li><a href="'.$Link.'" target="_blank">'.$Title.'</a></li>');
	}
	
	function CierraMenuBasico(){
		print('</ul></li></ul></div>');
	}
	
	function CrearImageLink($page,$imagerute,$target,$Alto,$Ancho){
		print('<a href="'.$page.'" target="'.$target.'"><img src="'.$imagerute.'" style="height:'.$Alto.'px; width:'.$Ancho.'px"></a>');
	}
        function CrearImage($Nombre,$imagerute,$Alterno,$Alto,$Ancho){
		print('<img id="'.$Nombre.'"  nombre="'.$Nombre.'"  src="'.$imagerute.'" onerror="this.src=`'.$Alterno.'`;" style="height:'.$Alto.'px; width:'.$Ancho.'px">');
	}
	function CrearLink($link,$target,$Titulo){
		print('<a href="'.$link.'" target="'.$target.'" >'.$Titulo.'</a>');
	}
        function CrearLinkID($link,$target,$Titulo,$VectorDatosExtra){
            $ID=$VectorDatosExtra["ID"];
            if(isset($VectorDatosExtra["JS"])){
                $JS=$VectorDatosExtra["JS"];
            }else{
                $JS="";
            }
            $ColorLink="blue";
            if(isset($VectorDatosExtra["Color"])){
                $ColorLink=$VectorDatosExtra["Color"];
            }
            print('<a id="'.$ID.'" href="'.$link.'" target="'.$target.'" '.$JS.' style="color:'.$ColorLink.'">'.$Titulo.'</a>');
	}
	
	/////////////////////Crear una fila para una tabla
	function CrearFilaNotificacion($Mensaje,$FontSize){
		print('<tr><div class="alert alert-success" align="center" style="font-size:'.$FontSize.'px"><strong>'.$Mensaje.'</strong></div></tr>');
		
	}
        
        /////////////////////Crear una fila para una tabla
	function CrearNotificacionVerde($Mensaje,$FontSize){
		print('<div class="alert alert-success" align="center" style="font-size:'.$FontSize.'px"><strong>'.$Mensaje.'</strong></div>');
		
	}
        
        /////////////////////Crear una fila para una tabla
	function CrearNotificacionAzul($Mensaje,$FontSize){
		print('<div class="alert alert-info" align="center" style="font-size:'.$FontSize.'px"><strong>'.$Mensaje.'</strong></div>');
		
	}
        
        /////////////////////Crear una fila para una tabla
	function CrearNotificacionNaranja($Mensaje,$FontSize){
		print('<div class="alert alert-warning" align="center" style="font-size:'.$FontSize.'px"><strong>'.$Mensaje.'</strong></div>');
		
	}
        
        /////////////////////Crear una fila para una tabla
	function CrearNotificacionRoja($Mensaje,$FontSize){
		print('<div class="alert alert-danger" align="center" style="font-size:'.$FontSize.'px"><strong>'.$Mensaje.'</strong></div>');
		
	}
	
	/////////////////////Crea un Boton Submit con evento
	
	function CrearBotonConfirmado($nombre,$value){
		print('<input type="submit" id="'.$nombre.'"  name="'.$nombre.'" value="'.$value.'" onclick="Confirmar(); return false" class="btn btn-danger">');
		
	}
        
        /////////////////////Crea un Boton Submit con evento
	
	function CrearBotonEvento($nombre,$value,$enabled,$evento,$funcion,$Color,$VectorBoton){
            
            switch ($Color){
                case "verde":
                    $Clase="btn btn-success";
                    break;
                case "naranja":
                    $Clase="btn btn-warning";
                    break;
                case "rojo":
                    $Clase="btn btn-danger";
                    break;
                case "blanco":
                    $Clase="btn-default";
                    break;
                case "azul":
                    $Clase="btn-primary";
                    break;
                case "azulclaro":
                    $Clase="btn-info";
                    break;
            }
            if($enabled==1){
                print('<input type="submit" id="'.$nombre.'"  name="'.$nombre.'" value="'.$value.'" '.$evento.'="'.$funcion.' ; return false" class="'.$Clase.'">');
            }else{
                print('<input type="submit" id="'.$nombre.'" disabled="true" name="'.$nombre.'" value="'.$value.'" '.$evento.'="'.$funcion.' ; return false" class="'.$Clase.'">');  
            }
		
		
	}
        
        /////////////////////Crea un Boton Submit con evento
	
	function CrearBotonConfirmado2($nombre,$value,$enabled,$VectorBoton){
            if($enabled==1){
                print('<input type="submit" id="'.$nombre.'"  name="'.$nombre.'" value="'.$value.'" onclick="Confirmar(); return false" class="btn btn-danger">');
            }else{
                print('<input type="submit" id="'.$nombre.'"  name="'.$nombre.'" value="'.$value.'" disabled="true" onclick="Confirmar(); return false" class="btn btn-danger">');
            }
		
		
	}
        
        /////////////////////Crea un Boton Editar Green
	
	function CrearBotonVerde($nombre,$value){
		print('<input type="submit" id="'.$nombre.'"  name="'.$nombre.'" value="'.$value.'" class="btn btn-success">');
		
	}
        
        /////////////////////Crea un Boton Editar Green
	
	function CrearBotonPersonalizado($nombre,$value,$vector){
           $Color=$vector["Color"];
           if($Color=="Azul"){
               $Class='class="btn btn-primary"';
               
           }
           if($Color=="Verde"){
               $Class='class="btn btn-success"';
           }
           if($Color=="Rojo"){
               $Class='class=" btn btn-danger" ';
           }
            if($vector["Enable"]==1){
                
                $enable='disabled="false"';
            }else if($vector["Enable"]==0){
                $enable='';
                
            }
            
            print('<input type="submit" id="'.$nombre.'" '.$enable.' name="'.$nombre.'" value="'.$value.'" '.$Class.'>');
		
	}
        
        /////////////////////Crea un Boton Naranja
	
	function CrearBotonNaranja($nombre,$value){
		print('<input type="submit" id="'.$nombre.'"  name="'.$nombre.'" value="'.$value.'" class="btn btn-warning">');
		
	}
        
        /////////////////////Agrega los javascripts
	
	function AgregaJS(){
            
            print('<script src="js/jquery.js"></script>
            <script src="js/bootstrap-transition.js"></script>
            <script src="js/beeper.js"></script>
            <script src="js/bootstrap-alert.js"></script>
            <script src="js/bootstrap-modal.js"></script>
            <script src="js/bootstrap-dropdown.js"></script>
            <script src="js/bootstrap-scrollspy.js"></script>
            <script src="js/bootstrap-tab.js"></script>
            <script src="js/bootstrap-tooltip.js"></script>
            <script src="js/bootstrap-popover.js"></script>
            <script src="js/bootstrap-button.js"></script>
            <script src="js/bootstrap-collapse.js"></script>
            <script src="js/bootstrap-carousel.js"></script>
            <script src="js/bootstrap-typeahead.js"></script>
            <script src="js/funciones.js"></script>
            <script src="js/shortcuts.js"></script>
            <script src="chousen/source/jquery.min.js" type="text/javascript"></script>
            <script src="chousen/source/chosen.jquery.js" type="text/javascript"></script>
            <script src="chousen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
            <script src="js/calendar.js"></script>
            <script src="js/cronometro.js"></script>
            
             ');
            
            ?>

            <script type="text/javascript">
            var config = {
              '.chosen-select'           : {},
              '.chosen-select-deselect'  : {allow_single_deselect:true},
              '.chosen-select-no-single' : {disable_search_threshold:10},
              '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
              '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
          </script>
          
		<?php
	}
        
        /////////////////////Agrega el boton para subir
	
	function AgregaSubir(){
            print('<a style="display:scroll; position:fixed; bottom:10px; right:10px;" href="#" title="Volver arriba"><img src="../images/up1_amarillo.png" /></a>');
		
	}
        
        /////////////////////Crear un DIV
	
	function CrearDiv($ID, $Class, $Alineacion,$Visible, $Habilitado){
            if($Visible==1)
                $V="block";
            else
                $V="none";
            
            if($Habilitado==1) ///pensado a futuro, aun no esta en uso
                $H="true";
            else
                $H="false";
            print("<div id='$ID' class='$Class' align='$Alineacion' style='display:$V;' >");
		
	}
        
        /////////////////////Crear un DIV
	
	function CrearDiv2($ID, $Class, $Alineacion,$Visible, $Habilitado, $Ancho, $Alto,$top,$left,$posicion,$Vector){
            if($Visible==1)
                $V="block";
            else if($Visible==2)
                $V="scroll";
            else{
                $V="none";
            }
            if($Habilitado==1) ///pensado a futuro, aun no esta en uso
                $H="true";
            else
                $H="false";
                        
            print(' <div id="'.$ID.'" class="'.$Class.'" align="'.$Alineacion.'" style="display:'.$V.';width: '.$Ancho.';height:'.$Alto.';top:'.$top.';margin-left:'.$left.';position:'.$posicion.'" > ');
		
	}
        
        /////////////////////Crear un DIV
	
	function CerrarDiv(){
            print("</div>");
		
	}
        
        /////////////////////Crear una Alerta
	
	function AlertaJS($Mensaje,$Tipo,$Formatos,$Iconos){
            if($Tipo==1){
                $Alerta="alert";
            }
            if($Tipo==2){
                $Alerta="confirm";
            }
            if($Tipo==3){
                $Alerta="prompt";
            }
            print("<script>$Alerta('$Mensaje');</script>");
		
	}
        
        

////////////////////////////Crear Footer	
		
function Footer(){
		
		print('<footer>    
  <div style="text-align: center">
    <div>
       <a href="../VMenu/Menu.php" class="f_logo"><img src="../images/header-logo.png" alt=""></a>
      <div class="copy">
      &copy; 2016 | <a href="#">Privacy Policy</a> <br> Software  designed by <a href="http://technosoluciones.com.co/" rel="nofollow" target="_blank">Techno Soluciones SAS</a>
      </div>
    </div>
  </div>
</footer>
		');
	}
        
     
/////////////////////Crear una Chosen
	
	function CrearSelectChosen($Nombre, $VarSelect){
           $Ancho=$VarSelect["Ancho"];
           $PlaceHolder=$VarSelect["PlaceHolder"];
           if(isset($VarSelect["Required"])){
               $Required="required=1";
           }else{
               $Required="";
           }
           if(isset($VarSelect["Title"])){
                print("<strong>$VarSelect[Title]</strong><br>");
           }
           echo '<select id="'.$Nombre.'" data-placeholder="'.$PlaceHolder.'" class="chosen-select"  tabindex="2" name="'.$Nombre.'" '.$Required.' style="width:200px;">';
           
       	
	}   
        
        /////////////////////Asignar ancho a un elemento por id
	
	function AnchoElemento($id, $Ancho){
             
          echo'<script>document.getElementById("'.$id.'").style.width = "'.$Ancho.'px";</script>';
    
	} 
        
        
        /////////////////////Crear un upload
	
	function CrearUpload($Nombre){
             
          print('<input type="file" name="'.$Nombre.'" id="'.$Nombre.'"></input>');
    
	} 
        
        /////////////////////Crear un frame
	
	function frame($name,$page,$border,$alto,$ancho,$VectorFrame){
             
          print("<iframe name='$name' id='$name' src='$page' frameborder=$border style='height: ".$alto."%; width:".$ancho."%'></iframe>"); 
    
	} 
        
        /////////////////////Agrega JavaScrips exclusivos de venta Rapida
	
	function AgregaJSVentaRapida(){
             
          print("<script>atajos();posiciona('TxtCodigoBarras');</script> "); 
    
	} 
        
        /////////////////////Crear una imagen con una funcion javascrip
	
	function CrearBotonImagen($Titulo,$Nombre,$target,$RutaImage,$javascript,$Alto,$Ancho,$posicion,$margenes,$VectorBim){
             
          //print("<a href='$target' title='$Titulo'><image name='$Nombre' id='$Nombre' src='$RutaImage' $javascript style='display:scroll; position:".$posicion."; right:10px; height:".$Alto."px; width: ".$Ancho."px;'></a>");
          
          print('<a href="'.$target.'" role="button"  data-toggle="modal" title="'.$Titulo.'" style="display:scroll; position:'.$posicion.'; '.$margenes.'; height:'.$Alto.'px; width: '.$Ancho.'px;">
			<image src='.$RutaImage.' name='.$Nombre.' id='.$Nombre.' src='.$RutaImage.' '.$javascript.' ></a>');
	} 
        
        /////////////////////Crear una imagen con una funcion javascrip
	
	function CrearLinkImagen($Titulo,$Nombre,$target,$RutaImage,$javascript,$Alto,$Ancho,$MasStilos,$margenes,$VectorBim){
             
          //print("<a href='$target' title='$Titulo'><image name='$Nombre' id='$Nombre' src='$RutaImage' $javascript style='display:scroll; position:".$posicion."; right:10px; height:".$Alto."px; width: ".$Ancho."px;'></a>");
          
          print('<a href="'.$target.'" role="button"  data-toggle="modal" title="'.$Titulo.'" style="display:scroll; height:'.$Alto.'px; width: '.$Ancho.'px;'.$MasStilos.'">
			<image src='.$RutaImage.' name='.$Nombre.' id='.$Nombre.' src='.$RutaImage.' '.$javascript.' ></a>');
	} 
        
        /////////////////////Crear una imagen con una funcion javascrip
	
	function CrearInputFecha($Titulo,$Nombre,$Value,$Ancho,$Alto,$VectorFe){
            //include_once '../modelo/php_conexion.php';
            $obVenta=new ProcesoVenta(1);
            $DatosFechaCierre=$obVenta->DevuelveValores("cierres_contables", "ID", 1);
            $FechaCierre=$DatosFechaCierre["Fecha"];
          print("<div onmouseout=ValidarFecha('$FechaCierre','$Nombre');>");
          print("<strong>$Titulo </strong> <input type='text' size='12' name='$Nombre' id='$Nombre' value='$Value' autocomplete='off' style='width: ".$Ancho."px;height: ".$Alto."px; font-size: 1em' onchange=ValidarFecha('$FechaCierre','$Nombre');>");
          print("</div>");
          print('<script type="text/javascript">
                
                        new JsDatePick({
                                useMode:2,
                                target:"'.$Nombre.'",
                                dateFormat:"%Y-%m-%d"

                        });
                
        </script>');
	} 
        
        /////////////////////Crear una imagen con una funcion javascrip
	
	function DibujeCronometro($Ancho){
                    
          print('<div id="crono" style="width: '.$Ancho.'%;">
		<div class="reloj" id="Horas" style="display:none;">00</div>
		<div class="reloj" id="Minutos">00</div>
		<div class="reloj" id="Segundos">:00</div>
		<div class="reloj" id="Centesimas" style="display:none;">:00</div>
		
	</div>');
	} 
        
        /////////////////////Crear una imagen con una funcion javascrip
	
	function DibujeControlCronometro($Ancho){
                    
          print('<div id="crono" style="width: '.$Ancho.'%;">
		
		<input type="button" class="boton" id="inicio" value="Start &#9658;" onclick="inicio();">
		<input type="button" class="boton" id="parar" value="Stop &#8718;" onclick="parar();" disabled>
		<input type="button" class="boton" id="continuar" value="Resume &#8634;" onclick="inicio();" disabled>
		<input type="button" class="boton" id="reinicio" value="Reset &#8635;" onclick="reinicio();" disabled>
	</div>');
	} 
        
        /////////////////////Dibujar un boton de busqueda
	
	function BotonBuscar($Alto,$Ancho,$Vector){
                    
          print('<button type="submit" class="btn btn-info" > <img src="../images/busqueda.png" class="img-rounded" alt="Cinque Terre" width="'.$Ancho.'" height="'.$Alto.'"></button>');
	} 
        
        /////////////////////Dibujar un cuadro de busqueda
	
	function DibujeCuadroBusqueda($Nombre,$pageConsulta,$OtrasVariables,$DivTarget,$Evento,$Alto,$Ancho,$Vector){
            
                            
            ?>
            <script>
            function Busqueda<?php echo"$Nombre"?>() {
                
                str=document.getElementById("<?php echo"$Nombre"?>").value;
                document.getElementById("<?php echo"$Nombre"?>").value="";
                <?php
                if(isset($Vector["Variable"][0])){
                    $idObjeto=$Vector["Variable"][0];
                    print("$idObjeto=document.getElementById('$idObjeto').value;");
                    //print("$idObjeto=document.getElementById('$idObjeto').value;");
                    $OtrasVariables.='"+'.$idObjeto.'+"';
                    //$VariableJS='"+document.getElementById(`'.$idObjeto.'`).value';
                }
                ?>
                if (str == "") {
                    document.getElementById("<?php echo"$DivTarget"?>").innerHTML = "";
                    return;
                } else {
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("<?php echo"$DivTarget"?>").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET","<?php echo"$pageConsulta"?>="+str+"&<?php print($OtrasVariables);?>",true);
                    xmlhttp.send();
                }
            }
            </script>
            <?php 
            $TipoText="text";
            if($Nombre=="TxtAutorizacion"){
                $TipoText="password";
            }
            $this->CrearInputText($Nombre, $TipoText, "", "", "Buscar", "Black", $Evento, "Busqueda".$Nombre."()", $Ancho, $Alto, 0, 0);
            
            $this->BotonBuscar(20, 20, "");
            
            
	} 
        
/////////////////////Dibujar un icono que muestra y oculta un div
	
	function CrearBotonOcultaDiv($Titulo,$Div,$Ancho,$Alto,$Enable,$Vector){
          if($Enable==0){
                $e='';
                
            }else{
                $e='disabled="false"';
                
            }          
          print("<button type='submit' $e class='btn btn-default' onclick=MuestraOculta('$Div');>$Titulo <image width='$Ancho' height='$Alto' name='imgHidde' id='imgHidde' src='../images/hidde.png' ></button>");
	}    
        
        /////////////////////Dibujar un cuadro de busqueda
	
	function DivPage($Nombre,$pageConsulta,$OtrasVariables,$DivTarget,$Evento,$Alto,$Ancho,$Vector){
            
                            
            ?>
            <script>
            function Busqueda<?php echo"$Nombre"?>() {
                
                str=document.getElementById("<?php echo"$Nombre"?>").value;
                <?php
                if(isset($Vector["Variable"][0])){
                    $idObjeto=$Vector["Variable"][0];
                    print("$idObjeto=document.getElementById('$idObjeto').value;");
                    //print("$idObjeto=document.getElementById('$idObjeto').value;");
                    $OtrasVariables.='"+'.$idObjeto.'+"';
                    //$VariableJS='"+document.getElementById(`'.$idObjeto.'`).value';
                }
                ?>
                if (str == "") {
                    document.getElementById("<?php echo"$DivTarget"?>").innerHTML = "";
                    return;
                } else {
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("<?php echo"$DivTarget"?>").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET","<?php echo"$pageConsulta"?>",true);                    
                    xmlhttp.send();
                    
                }
                
            }
            
            </script>
            <?php 
            $this->CrearBotonEvento($Nombre, "Cargar", 1, $Evento, "Busqueda".$Nombre."()", "verde", "");
            $this->CrearInputText($Nombre, "hidden", "", "", "", "Black", "", "", "", "", 0, 0);
            
            //$this->BotonBuscar(20, 20, "");
                 
	} 
        public function CrearTextAreaEnriquecida($nombre,$label,$value,$placeh,$color,$TxtEvento,$TxtFuncion,$Ancho,$Alto,$ReadOnly,$Required,$Vector) {
            if($ReadOnly==1)
			$ReadOnly="readonly";
		else
			$ReadOnly="";
		
		if($Required==1){
			print("<strong style= 'color:$color'>$label<textarea name='$nombre' id='editor' placeholder='$placeh' $TxtEvento = '$TxtFuncion'" 
			." $ReadOnly autocomplete='off' style='width: ".$Ancho."px; height: ".$Alto."px;' required>".$value."</textarea></strong>");
                }else{
			print("<strong style= 'color:$color'>$label<textarea name='$nombre' id='editor' placeholder='$placeh' $TxtEvento = '$TxtFuncion'" 
			." $ReadOnly autocomplete='off' style='width: ".$Ancho."px; height: ".$Alto."px;' >".$value."</textarea></strong>");
                }
        }
        //Iniciamos el texto enriquecido
        public function IniTextoEnriquecido() {
            print("<script>
                initSample();
                </script>");
        }
        
        
        //Select de envio a div
         /////////////////////Dibujar un cuadro de busqueda
	
	function DibujeSelectBuscador($Nombre,$pageConsulta,$OtrasVariables,$DivTarget,$Evento,$Alto,$Ancho,$tabla,$Condicion,$idItemValue,$OptionDisplay1,$OptionDisplay2,$Vector){
            $obVenta=new ProcesoVenta(1);
                            
            ?>
            <script>
            function Busqueda<?php echo"$Nombre"?>() {
                
                str=document.getElementById("<?php echo"$Nombre"?>").value;
                <?php
                if(isset($Vector["Variable"][0])){
                    $idObjeto=$Vector["Variable"][0];
                    print("$idObjeto=document.getElementById('$idObjeto').value;");
                    //print("$idObjeto=document.getElementById('$idObjeto').value;");
                    $OtrasVariables.='"+'.$idObjeto.'+"';
                    //$VariableJS='"+document.getElementById(`'.$idObjeto.'`).value';
                }
                ?>
                if (str == "") {
                    document.getElementById("<?php echo"$DivTarget"?>").innerHTML = "";
                    return;
                } else {
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("<?php echo"$DivTarget"?>").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET","<?php echo"$pageConsulta"?>&idSel="+str+"&<?php print($OtrasVariables);?>",true);
                    xmlhttp.send();
                }
            }
            </script>
            <?php 
            $this->CrearSelect($Nombre, "Busqueda".$Nombre."()");
            $this->CrearOptionSelect("", "Seleccione un Item", 0);
            $consulta=$obVenta->ConsultarTabla($tabla, $Condicion);
            while ($DatosConsulta=$obVenta->FetchAssoc($consulta)){
                $this->CrearOptionSelect($DatosConsulta[$idItemValue], "$DatosConsulta[$OptionDisplay1] $DatosConsulta[$OptionDisplay2]", 0);
            }
            $this->CerrarSelect();
            //$this->CrearInputText($Nombre, "text", "", "", "Buscar", "Black", $Evento, "Busqueda".$Nombre."()", $Ancho, $Alto, 0, 0);
            
            //$this->BotonBuscar(20, 20, "");
            
            
	} 
        
        public function CrearSelectTable($Nombre,$tabla,$Condicion,$idItemValue,$OptionDisplay1,$OptionDisplay2,$Evento,$FuncionJS,$idSel,$Requerido) {
            $obVenta=new ProcesoVenta(1);
            $nombre=$Vector["Nombre"]=$Nombre;
            $evento=$Vector["Evento"]=$Evento;
            $funcion=$Vector["Funcion"]=$FuncionJS;
            $Vector["Required"]=$Requerido;
            $this->CrearSelect2($Vector);
            $this->CrearOptionSelect("", "Seleccione un Item", 0);
            $consulta=$obVenta->ConsultarTabla($tabla, $Condicion);
            while ($DatosConsulta=$obVenta->FetchAssoc($consulta)){
                $Sel=0;
                if($DatosConsulta[$idItemValue]==$idSel){
                  $Sel=1;  
                }
                $this->CrearOptionSelect($DatosConsulta[$idItemValue], "$DatosConsulta[$OptionDisplay1] $DatosConsulta[$OptionDisplay2]", $Sel);
            }
            $this->CerrarSelect();
        }
        
        //Crear una tabla con un div
        public function DivTable() {
            print("<div style='display:table;'>");
        }
        //Crear una tabla con un div
        public function DivRowTable() {
            print("<div style='display:table-row; '>");
        }
        //Crear una tabla con un div
        public function DivColTable($Align,$Border,$BorderWith,$ColorFont,$FontSize,$Vector) {
            if($Border==1){
                $Border="border-style: solid;border-width:$BorderWith";
            }else{
                $Border="";
            }
            print("<div style='display:table-cell; text-align:$Align;$Border;font-size:$FontSize;color:$ColorFont'>");
        }
        //////////////////////////////////FIN
}
	
	

?>