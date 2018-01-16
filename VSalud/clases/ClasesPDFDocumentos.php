<?php
/* 
 * Clase donde se realizaran la generacion de informes.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../modelo/php_tablas.php';
class Documento extends Tabla{
    
    //Comprobante de ingreso
    
     public function PDF_CobroPrejuridico($idCobro) {
        $DatosCobro= $this->obCon->DevuelveValores("salud_cobros_prejuridicos", "ID", $idCobro);
        if($DatosCobro["TipoCobro"]==1){
            $idFormato=27;
        }else{
            $idFormato=28;
        }
        
        $fecha=date("Y-m-d");
        $DatosFormatos= $this->obCon->DevuelveValores("formatos_calidad", "ID", $idFormato);
        
        $Documento="$DatosFormatos[Nombre] No. $idCobro";
        
        $this->PDF_Ini("CobroPrejuridico", 8, "");
        
        $DatosUsuarios= $this->obCon->DevuelveValores("usuarios", "idUsuarios", $DatosCobro["idUser"]);
            
        $this->PDF_Encabezado($fecha,1, $idFormato, "",$Documento);
        $this->PDF->SetMargins(20, PDF_MARGIN_TOP, 20);
        $this->PDF->SetFont('helvetica', '', 8);
        $html="<br><br><br><br>";
        $html.="<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Se&ntilde;or</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>(a)</span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=background-color:yellow><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>CAPRECOM EPS REGIONAL (CAUCA)</span></span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=background-color:yellow><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>DIRECCI&Oacute;N</span></span></span></strong><span style=font-size:10.0pt><span style=background-color:yellow><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>:</span></span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>REF</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>:&nbsp;&nbsp;&nbsp;CLIENTE CON ALTURA&nbsp;DE MORA&nbsp;DE&nbsp;1 A 29 D&Iacute;AS DE ATRASO</span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>FACTURA(S) No</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>:&nbsp;<span style=background-color:yellow>XXXXXXXXXXXXXXXXXX</span></span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Fundamento Legal</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>: </span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>C&oacute;digo de Comercio</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>: Arts. 864, 850, 851, 852, 853 y 884</span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>C&oacute;digo Civil</span></span></strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>: Arts. 1602, 1603, 1604, 1608 n&uacute;m. 1&ordm; y 2&ordm;, 1609, 1610 n&uacute;m. 3&ordm;, 1615, 1616, 1617 y 2232.</span></span></span></span></p>

<p style=text-align:justify><span style=font-family:Arial,Helvetica,sans-serif>Conocedores de lo importante que representa para usted, su imagen crediticia y de lo que conlleva a un mejoramiento continuo en cuanto a las relaciones comerciales se refiere, nuestra Instituci&oacute;n lo invita a presentarse a la Central de Cartera ubicado en la Direcci&oacute;n: Carrera 4 N&deg; 0-93 Edificio Panorama-Popay&aacute;n Cauca, para dar cumplimiento oportuno a su compromiso comercial que se encuentra vencido por valor de: ($000.000.000) m&aacute;s intereses por mora; la cual se dar&aacute; aplicaci&oacute;n de car&aacute;cter supletorio con fundamento en las normas Comercial y Civil. En caso contrario le invitamos a comunicarse al tel&eacute;fono 3146873552, para que reporte dentro del mes su respectiva fecha de pago, o en su defecto a las siguiente ruta electr&oacute;nica: carteraguapi2016@gmail.com incumplimiento de la obligaci&oacute;n de pagar por la prestaci&oacute;n del servicio de la Empresa Social del Estado HOSPITAL GUAPI puede acarrear la imposici&oacute;n de la sanci&oacute;n prevista en la ley, consistente en el pago, a cargo de la entidad CAPRECOM EPS, de un inter&eacute;s de mora, recordando que no hay raz&oacute;n alguna que haga inconstitucional la aplicaci&oacute;n de dicha sanci&oacute;n pues se trata de una consecuencia que deviene del incumplimiento de la obligaci&oacute;n de pagar una suma de dinero.</span></p>

<p style=text-align:justify><span style=font-family:Arial,Helvetica,sans-serif>La Sentencia C-389 de 2002, proferida por la Honorable Corte Constitucional en aparte jurisprudencial se desprende que el cobro de intereses de mora es facultativo y no obligatorio. En efecto, el legislador utiliz&oacute; el verbo podr&aacute;n, dejando a la empresa prestataria del servicio la facultad de cobrarlos, rebajarlos o exonerarlos o hacer convenios con los deudores.</span></p>

<p style=text-align:justify><span style=font-family:Arial,Helvetica,sans-serif>De otra parte, le informo que la Empresa Social del Estado HOSPITAL GUAPI, se encuentra vinculada al programa de Centrales de Riesgo DATACREDITO y CIFIN, reportando el comportamiento de pago de la obligaci&oacute;n en menci&oacute;n.</span></p>

<p style=text-align:justify>&nbsp;</p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:9.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Anexo lo enunciado en (&hellip;&hellip;.) folios, (<span style=background-color:lime>copia de facturas</span>)</span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Si&nbsp;ya&nbsp;cancelo&nbsp;por&nbsp;favor&nbsp;haga&nbsp;caso&nbsp;omiso&nbsp;a&nbsp;esta&nbsp;comunicaci&oacute;n, sin otro en particular&nbsp;</span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Cordialmente,</span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify>&nbsp;</p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>JOHN DIRLEY MORALES</span></span></strong></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Jefe de Cartera </span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm; text-align:justify><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><span style=font-size:10.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Empresa Social del Estado HOSPITAL GUAPI</span></span></span></span></p>

<p style=margin-left:0cm; margin-right:0cm>&nbsp;</p>

<p style=margin-left:0cm; margin-right:0cm><span style=font-size:11pt><span style=font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;><strong><span style=font-size:5.0pt><span style=font-family:&quot;Arial&quot;,&quot;sans-serif&quot;>Transcribi&oacute;/elaboro: D. Mostacilla Zapata- Jur&iacute;dico</span></span></strong></span></span></p>

<p>&nbsp;</p>";
        $this->PDF_Write("<br>".$html);
        
        
        $this->PDF_Output("CobroPrejuridico_$idCobro");
    }
    
   //Fin Clases
}
    