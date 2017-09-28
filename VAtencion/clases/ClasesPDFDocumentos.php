<?php
/* 
 * Clase donde se realizaran la generacion de informes.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../modelo/php_tablas.php';
class Documento extends Tabla{
    
    public function PDF_Egreso($idEgreso) {
        $idFormato=11;
        $DatosEgreso=$this->obCon->DevuelveValores("egresos","idEgresos",$idEgreso);
        $fecha=$DatosEgreso["Fecha"];
        
        $Tercero=$DatosEgreso["NIT"];
        $idUsuario=$DatosEgreso["Usuario_idUsuario"];
        
        $DatosUsuario=$this->obCon->ValorActual("usuarios", " Nombre , Apellido ", " idUsuarios='$idUsuario'");
        $Valor=  $DatosEgreso["Valor"]-$DatosEgreso["Retenciones"];
        $DatosTercero=$this->obCon->DevuelveValores("proveedores","Num_Identificacion",$Tercero);
        if($DatosTercero["Num_Identificacion"]==''){
            $DatosTercero=$this->obCon->DevuelveValores("clientes","Num_Identificacion",$Tercero);
        }
        $DatosFormatos= $this->obCon->DevuelveValores("formatos_calidad", "ID", $idFormato);
        
        $Documento="$DatosFormatos[Nombre] $idEgreso";
        
        $this->PDF_Ini("Egreso", 8, "");
        $DatosEgreso= $this->obCon->DevuelveValores("egresos", "idEgresos", $idEgreso);
        $this->PDF_Encabezado($fecha,1, $idFormato, "",$Documento);
        $this->Datos_Tercero_Egresos($fecha, $DatosEgreso, $DatosTercero, $DatosUsuario, "");
        
        $html= $this->HTML_Movimiento_Contable("CompEgreso",$idEgreso,"");
        $this->PDF_Write("<br><br><br><br><br><br><br><br><br>".$html);
        $html= $this->HTML_Movimiento_Firmas_Egresos($Valor);
        $this->PDF_Write("<br><br>".$html);
        $this->PDF_Output("Egreso_$idEgreso");
    }
    //HTML Firmas Egresos
    public function HTML_Movimiento_Firmas_Egresos($Valor) {
        $html = ' 
            <table border="1" cellpadding="2" cellspacing="0" align="left">
            <tr align="left" >
                <td style="height: 70px;" ><strong>Total:</strong> '.number_format($Valor).'</td>
                <td style="height: 70px;" >Recibido por:</td>
                <td style="height: 70px;" >Cedula:</td>
            </tr>
            <tr align="left" >
                <td style="height: 70px;" >Preparado:</td>
                <td style="height: 70px;" >Revisado:</td>
                <td style="height: 70px;" >Contabilidad:</td>
            </tr>

        </table>

        ';
        return($html);
    }
    //HTML Movimientos Contables
    public function HTML_Movimiento_Contable($TipoDocumento,$NumDocumento,$Vector) {
        $Consulta=$this->obCon->ConsultarTabla("librodiario", "WHERE Tipo_Documento_Intero='$TipoDocumento' AND Num_Documento_Interno='$NumDocumento'");
        $html = '   
            <table border="0" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
                <tr align="center">
                    <td><strong>Tercero</strong></td>
                    <td><strong>Documento</strong></td>
                    <td><strong>Cuenta PUC</strong></td>
                    <td><strong>Nombre Cuenta</strong></td>
                    <td><strong>Débitos</strong></td>
                    <td><strong>Créditos</strong></td>
                </tr>

            
        ';
        $h=0;
        $Debitos=0;
        $Creditos=0;
        while($DatosLibro=$this->obCon->FetchArray($Consulta)){
            $Debitos=$Debitos+$DatosLibro["Debito"];
            $Creditos=$Creditos+$DatosLibro["Credito"];
            if($h==0){
                $Back="#f2f2f2";
                $h=1;
            }else{
                $Back="white";
                $h=0;
            } 
            $html.= '  
            
                <tr align="left">
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$DatosLibro["Tercero_Identificacion"].'</td>
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$DatosLibro["Num_Documento_Externo"].'</td>
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$DatosLibro["CuentaPUC"].'</td>
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.$DatosLibro["NombreCuenta"].'</td>
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($DatosLibro["Debito"]).'</td>
                    <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($DatosLibro["Credito"]).'</td>
                </tr>

            
            ';

        }
        $Back='#F7F8E0';
        $html.='<tr > '
                . '<td align="rigth" colspan="4" style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">Totales:</td>'
                . '<td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($Debitos).'</td>
                   <td style="border-bottom: 1px solid #ddd;background-color: '.$Back.';">'.number_format($Creditos).'</td>'
                . '</tr>';
        $html.='</table>';
        return($html);
    }
    //HTML Datos Tercero Egresos
    public function Datos_Tercero_Egresos($fecha,$DatosEgreso,$DatosTercero,$DatosUsuario,$Vector) {
        $html ='       
            <table cellpadding="1" border="1">
                <tr>
                    <td><strong>Tercero:</strong></td>
                    <td colspan="3">'.$DatosTercero["RazonSocial"].'</td>

                </tr>
                <tr>
                    <td><strong>NIT:</strong></td>
                    <td colspan="3">'.$DatosTercero["Num_Identificacion"].' - '.$DatosTercero["DV"].'</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Dirección:</strong></td>
                    <td><strong>Ciudad:</strong></td>
                    <td><strong>Telefono:</strong></td>
                </tr>
                <tr>
                    <td colspan="2">'.$DatosTercero["Direccion"].'</td>
                    <td>'.$DatosTercero["Ciudad"].'</td>
                    <td>'.$DatosTercero["Telefono"].'</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Fecha: </strong></td>
                    <td colspan="2">'.$fecha.'</td>
                </tr>

            </table>       
        ';
        $this->PDF->MultiCell(90, 25, $html, 0, 'L', 1, 0, '', '', true,0, true, true, 10, 'M');
        $html = '        
            <table cellpadding="1" border="1">
                <tr>
                    <td colspan="3"><strong>Concepto:</strong></td>


                </tr>
                <tr>
                    <td colspan="3" height="36">'.$DatosEgreso["Concepto"].' </td>

                </tr>
                <tr>
                    <td colspan="3"><strong>Creado Por:</strong> '.$DatosUsuario["Nombre"].' '.$DatosUsuario["Apellido"].' </td>

                </tr>


            </table>       
        ';

    $this->PDF->MultiCell(90, 25, $html, 0, 'L', 1, 0, '', '', true,0, true, true, 10, 'M');
    }
    
   //Fin Clases
}
    