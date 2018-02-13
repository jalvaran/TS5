<?php
/* 
 * Clase donde se realizaran la generacion de informes.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../modelo/php_tablas.php';
class TS5_Excel extends Tabla{
    
    // Clase para generar excel de un balance de comprobacion
    
    public function GenerarBalanceComprobacionExcel($TipoReporte,$FechaInicial,$FechaFinal,$FechaCorte,$idEmpresa,$CentroCosto,$Vector) {
        require_once '../librerias/Excel/PHPExcel.php';
        $Condicion=" WHERE ";
        $Condicion2=" WHERE ";
        if($TipoReporte=="Corte"){
            $Condicion.=" Fecha <= '$FechaCorte' ";
            $Condicion2.=" Fecha > '5000-01-01' AND  ";
            $Rango="Corte a $FechaCorte";
        }else{
            $Condicion.=" Fecha >= '$FechaInicial' AND Fecha <= '$FechaFinal' "; 
            $Condicion2.= " Fecha < '$FechaInicial' AND ";
            $Rango="De $FechaInicial a $FechaFinal";
        }
        if($CentroCosto<>"ALL"){
                $Condicion.="  AND idCentroCosto='$CentroCosto' ";
                $Condicion2.="  AND idCentroCosto='$CentroCosto' AND ";
        }
        if($idEmpresa<>"ALL"){
                $Condicion.="  AND idEmpresa='$idEmpresa' ";
                $Condicion2.="  AND idEmpresa='$idEmpresa' AND ";
        }
        $objPHPExcel = new PHPExcel();  
        
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#');
        $objPHPExcel->getActiveSheet()->getStyle('C:F')->getNumberFormat()->setFormatCode('#,##0');
        $objPHPExcel->getActiveSheet()->getStyle("A:F")->getFont()->setSize(10);
        
        $f=1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[1].$f,"BALANCE DE COMPROBACION $Rango")
                        
            ;
        $f=2;
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[0].$f,"CUENTA")
            ->setCellValue($this->Campos[1].$f,"NOMBRE")
            ->setCellValue($this->Campos[2].$f,"SALDO ANTERIOR")
            ->setCellValue($this->Campos[3].$f,"DEBITO")
            ->setCellValue($this->Campos[4].$f,"CREDITO")
            ->setCellValue($this->Campos[5].$f,"NUEVO SALDO")
            
            ;
            
   $sql="SELECT SUBSTRING(`CuentaPUC`,1,1) AS Clase ,sum(`Debito`) as Debitos, sum(`Credito`) as Creditos, sum(`Neto`) as Neto, (SELECT SUM(`Neto`) as SaldoTotal FROM `librodiario` $Condicion2  SUBSTRING(`CuentaPUC`,1,1)=Clase) AS Total FROM `librodiario` $Condicion GROUP BY SUBSTRING(`CuentaPUC`,1,1)";
        $Consulta=$this->obCon->Query($sql);
        $i=0;
        $DebitosGeneral=0;
        $CreditosGeneral=0;
        $TotalDebitos=0;
        $TotalCreditos=0;
        $Total=0;
        while($ClaseCuenta=$this->obCon->FetchArray($Consulta)){
            $DebitosGeneral=$DebitosGeneral+$ClaseCuenta["Debitos"];
            $CreditosGeneral=$CreditosGeneral+$ClaseCuenta["Creditos"];
            $TotalDebitos=$TotalDebitos+$ClaseCuenta["Debitos"];
            $TotalCreditos=$TotalCreditos+$ClaseCuenta["Creditos"];
            $Total=$Total+$ClaseCuenta["Total"];
            $i++;
            $Clase=$ClaseCuenta["Clase"];
            $NoClasesCuentas[$i]=$ClaseCuenta["Clase"];
            $DatosCuenta=  $this->obCon->DevuelveValores("clasecuenta", "PUC", $Clase);
            $Balance["ClaseCuenta"][$Clase]["Nombre"]=$DatosCuenta["Clase"];
            $Balance["ClaseCuenta"][$Clase]["Clases"]=$ClaseCuenta["Clase"];
            $Balance["ClaseCuenta"][$Clase]["Debitos"]=$ClaseCuenta["Debitos"];
            $Balance["ClaseCuenta"][$Clase]["Creditos"]=$ClaseCuenta["Creditos"];
            $Balance["ClaseCuenta"][$Clase]["NuevoSaldo"]=$ClaseCuenta["Debitos"]-$ClaseCuenta["Creditos"]+$ClaseCuenta["Total"];
            $Balance["ClaseCuenta"][$Clase]["SaldoAnterior"]=$ClaseCuenta["Total"];
        }
        $Diferencia=$TotalDebitos-$TotalCreditos;
        //Guardo en un Vector los resultados de la consulta por Grupo
        
        $sql="SELECT SUBSTRING(`CuentaPUC`,1,2) AS Grupo ,sum(`Debito`) as Debitos, sum(`Credito`) as Creditos,(SELECT SUM(`Neto`) as SaldoTotal FROM `librodiario` $Condicion2  SUBSTRING(`CuentaPUC`,1,2)=Grupo) AS Total FROM `librodiario` $Condicion GROUP BY SUBSTRING(`CuentaPUC`,1,2)";
        $Consulta=$this->obCon->Query($sql);
        $i=0;
        
        while($ClaseCuentaGrupo=$this->obCon->FetchArray($Consulta)){
            $i++;
            $Grupo=$ClaseCuentaGrupo["Grupo"];
            $NoGrupos[$i]=$ClaseCuentaGrupo["Grupo"];
            $DatosCuenta=  $this->obCon->DevuelveValores("gupocuentas", "PUC", $Grupo);
            $Balance["GrupoCuenta"][$Grupo]["Nombre"]=$DatosCuenta["Nombre"];
            $Balance["GrupoCuenta"][$Grupo]["Grupos"]=$ClaseCuentaGrupo["Grupo"];
            $Balance["GrupoCuenta"][$Grupo]["Debitos"]=$ClaseCuentaGrupo["Debitos"];
            $Balance["GrupoCuenta"][$Grupo]["Creditos"]=$ClaseCuentaGrupo["Creditos"];
            $Balance["GrupoCuenta"][$Grupo]["NuevoSaldo"]=$ClaseCuentaGrupo["Debitos"]-$ClaseCuentaGrupo["Creditos"]+$ClaseCuentaGrupo["Total"];
            $Balance["GrupoCuenta"][$Grupo]["SaldoAnterior"]=$ClaseCuentaGrupo["Total"];
        }
        
        //Guardo en un Vector los resultados de la consulta por Cuenta
        
        $sql="SELECT SUBSTRING(`CuentaPUC`,1,4) AS Cuenta ,sum(`Debito`) as Debitos, sum(`Credito`) as Creditos,(SELECT SUM(`Neto`) as SaldoTotal FROM `librodiario` $Condicion2  SUBSTRING(`CuentaPUC`,1,4)=Cuenta) as Total FROM `librodiario` $Condicion GROUP BY SUBSTRING(`CuentaPUC`,1,4)";
        $Consulta=$this->obCon->Query($sql);
        $i=0;
        
        while($ClaseCuentaCuenta=$this->obCon->FetchArray($Consulta)){
            $i++;
            $Cuenta=$ClaseCuentaCuenta["Cuenta"];
            $NoCuentas[$i]=$ClaseCuentaCuenta["Cuenta"];
            $DatosCuenta=  $this->obCon->DevuelveValores("cuentas", "idPUC", $Cuenta);
            $Balance["Cuenta"][$Cuenta]["Nombre"]=$DatosCuenta["Nombre"];
            $Balance["Cuenta"][$Cuenta]["Cuentas"]=$ClaseCuentaCuenta["Cuenta"];
            $Balance["Cuenta"][$Cuenta]["Debitos"]=$ClaseCuentaCuenta["Debitos"];
            $Balance["Cuenta"][$Cuenta]["Creditos"]=$ClaseCuentaCuenta["Creditos"];
            $Balance["Cuenta"][$Cuenta]["NuevoSaldo"]=$ClaseCuentaCuenta["Debitos"]-$ClaseCuentaCuenta["Creditos"]+$ClaseCuentaCuenta["Total"];
            $Balance["Cuenta"][$Cuenta]["SaldoAnterior"]=$ClaseCuentaCuenta["Total"];
        }
        
        //Guardo en un Vector los resultados de la consulta por SubCuenta
        
        $sql="SELECT `CuentaPUC` AS Subcuenta , sum(`Debito`) as Debitos, sum(`Credito`) as Creditos, sum(`Neto`) as NuevoSaldo,(SELECT SUM(`Neto`) as SaldoTotal FROM `librodiario` $Condicion2  `CuentaPUC` = Subcuenta) as Total FROM `librodiario` $Condicion AND LENGTH(`CuentaPUC`)>=5 GROUP BY `CuentaPUC` ";
        $Consulta=$this->obCon->Query($sql);
        $i=0;
        
        while($ClaseCuentaSub=$this->obCon->FetchArray($Consulta)){
            $i++;
            $SubCuenta=$ClaseCuentaSub["Subcuenta"];
            $NoSubCuentas[$i]=$ClaseCuentaSub["Subcuenta"];
            $sql="SELECT NombreCuenta FROM librodiario WHERE CuentaPUC='$SubCuenta' LIMIT 1";
            $Datos=  $this->obCon->Query($sql);
            $DatosCuenta=$this->obCon->FetchArray($Datos);
            //$DatosCuenta=  $this->obCon->DevuelveValores("subcuentas", "PUC", `$SubCuenta`);
            $Balance["SubCuenta"][$SubCuenta]["Nombre"]=$DatosCuenta["NombreCuenta"];
            $Balance["SubCuenta"][$SubCuenta]["Subcuenta"]=$ClaseCuentaSub["Subcuenta"];
            $Balance["SubCuenta"][$SubCuenta]["Debitos"]=$ClaseCuentaSub["Debitos"];
            $Balance["SubCuenta"][$SubCuenta]["Creditos"]=$ClaseCuentaSub["Creditos"];
            $Balance["SubCuenta"][$SubCuenta]["NuevoSaldo"]=$ClaseCuentaSub["Debitos"]-$ClaseCuentaSub["Creditos"]+$ClaseCuentaSub["Total"];
            $Balance["SubCuenta"][$SubCuenta]["SaldoAnterior"]=$ClaseCuentaSub["Total"];
        }
        $f=3;
        foreach ($NoClasesCuentas as $Clase){
            if($Balance["ClaseCuenta"][$Clase]["Debitos"]<>0 OR $Balance["ClaseCuenta"][$Clase]["Creditos"]<>0 OR $Balance["ClaseCuenta"][$Clase]["NuevoSaldo"]<>0 ){
            //Se digitan las clases
            $objPHPExcel->getActiveSheet()->getStyle("A$f:F$f")->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB('00fadbd8');    
            $objPHPExcel->getActiveSheet()->getStyle("A$f:F$f")->getFont()->setSize(16);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($this->Campos[0].$f,$Clase)
                ->setCellValue($this->Campos[1].$f,$Balance["ClaseCuenta"][$Clase]["Nombre"])
                ->setCellValue($this->Campos[2].$f,$Balance["ClaseCuenta"][$Clase]["SaldoAnterior"])
                ->setCellValue($this->Campos[3].$f,$Balance["ClaseCuenta"][$Clase]["Debitos"])
                ->setCellValue($this->Campos[4].$f,$Balance["ClaseCuenta"][$Clase]["Creditos"])
                ->setCellValue($this->Campos[5].$f,$Balance["ClaseCuenta"][$Clase]["NuevoSaldo"])
                ;
            
           foreach($NoGrupos as $GruposCuentas){
               
                   if(substr($Balance["GrupoCuenta"][$GruposCuentas]["Grupos"], 0, 1)==$Clase){
                       
                       $f++;
                       $objPHPExcel->getActiveSheet()->getStyle("A$f:F$f")->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB('00E6E6E6');    
                       $objPHPExcel->getActiveSheet()->getStyle("A$f:F$f")->getFont()->setSize(12);
                        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($this->Campos[0].$f,$GruposCuentas)
                    ->setCellValue($this->Campos[1].$f,$Balance["GrupoCuenta"][$GruposCuentas]["Nombre"])
                    ->setCellValue($this->Campos[2].$f,$Balance["GrupoCuenta"][$GruposCuentas]["SaldoAnterior"])
                    ->setCellValue($this->Campos[3].$f,$Balance["GrupoCuenta"][$GruposCuentas]["Debitos"])
                    ->setCellValue($this->Campos[4].$f,$Balance["GrupoCuenta"][$GruposCuentas]["Creditos"])
                    ->setCellValue($this->Campos[5].$f,$Balance["GrupoCuenta"][$GruposCuentas]["NuevoSaldo"])
                    ;                      
                   
                   //Consulto los valores dentro de la Cuenta
                   
                   foreach($NoCuentas as $Cuentas){
                       
                    if(substr($Balance["Cuenta"][$Cuentas]["Cuentas"], 0, 2)==$GruposCuentas){
                        $f++;
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($this->Campos[0].$f,$Cuentas)
                            ->setCellValue($this->Campos[1].$f,$Balance["Cuenta"][$Cuentas]["Nombre"])
                            ->setCellValue($this->Campos[2].$f,$Balance["Cuenta"][$Cuentas]["SaldoAnterior"])
                            ->setCellValue($this->Campos[3].$f,$Balance["Cuenta"][$Cuentas]["Debitos"])
                            ->setCellValue($this->Campos[4].$f,$Balance["Cuenta"][$Cuentas]["Creditos"])
                            ->setCellValue($this->Campos[5].$f,$Balance["Cuenta"][$Cuentas]["NuevoSaldo"])
                            ;    
                         //Consulto los valores dentro de la Cuenta
                   
                   foreach($NoSubCuentas as $SubCuentas){
                       
                    if(substr($Balance["SubCuenta"][$SubCuentas]["Subcuenta"], 0, 4)==$Cuentas){
                        $f++;
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($this->Campos[0].$f,$Balance["SubCuenta"][$SubCuentas]["Subcuenta"])
                            ->setCellValue($this->Campos[1].$f,$Balance["SubCuenta"][$SubCuentas]["Nombre"])
                            ->setCellValue($this->Campos[2].$f,$Balance["SubCuenta"][$SubCuentas]["SaldoAnterior"])
                            ->setCellValue($this->Campos[3].$f,$Balance["SubCuenta"][$SubCuentas]["Debitos"])
                            ->setCellValue($this->Campos[4].$f,$Balance["SubCuenta"][$SubCuentas]["Creditos"])
                            ->setCellValue($this->Campos[5].$f,$Balance["SubCuenta"][$SubCuentas]["NuevoSaldo"])
                            ;  
                    }
                  }
                         
                 }
                }
              }
             }
             $f++; //Salto de linea para clase cuenta
            } 
            
        }
    
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[2].$f,"Totales")
            ->setCellValue($this->Campos[3].$f,$DebitosGeneral)
            ->setCellValue($this->Campos[4].$f,$CreditosGeneral)
            ->setCellValue($this->Campos[5].$f,"Diferencia")
            ->setCellValue($this->Campos[6].$f,$DebitosGeneral-$CreditosGeneral);
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.technosoluciones.com.co")
        ->setLastModifiedBy("www.technosoluciones.com.co")
        ->setTitle("Balance Comprobacion")
        ->setSubject("Informe")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("techno soluciones sas")
        ->setCategory("Balance Comprobacion");    
 
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Balance_Comprobacion".'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    exit; 
   
    }
    
    //resumen de ventas y comisiones en excel
    // Clase para generar excel de un balance de comprobacion
    
    public function InformeComisionesXVentas($Tipo,$idCierre,$FechaInicial,$FechaFinal,$Vector) {
        
        require_once '../../librerias/Excel/PHPExcel.php';
        $objPHPExcel = new PHPExcel();  
        
        $objPHPExcel->getActiveSheet()->getStyle('B:F')->getNumberFormat()->setFormatCode('#');
        
        $objPHPExcel->getActiveSheet()->getStyle("A:F")->getFont()->setSize(10);
        
        $f=1;
        $Rango="DE $FechaInicial A $FechaFinal";
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[1].$f,"INFORME DE COMISIONES $Rango")
                        
            ;
        $f=2;
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[0].$f,"PRODUCTO")
            ->setCellValue($this->Campos[1].$f,"CANTIDAD")
            ->setCellValue($this->Campos[2].$f,"VALOR TOTAL")
            ->setCellValue($this->Campos[3].$f,"COMISION 1")
            ->setCellValue($this->Campos[4].$f,"COMISION 2")
            ->setCellValue($this->Campos[5].$f,"COMISION 3")            
            ;
        $sql="SELECT `idCierre` as Cierre,`Referencia`,SUM(`Cantidad`) AS CantidadTotal, "
                . "round(SUM( `TotalItem`+`ValorOtrosImpuestos`)) AS ValorTotal, "
                . "(SUM(`Cantidad`)*(SELECT ValorComision1 FROM productosventa WHERE productosventa.Referencia=`facturas_items`.`Referencia`) ) AS Comision1, "
                . "(SUM(`Cantidad`)*(SELECT ValorComision2 FROM productosventa WHERE productosventa.Referencia=`facturas_items`.`Referencia`)) AS Comision2, "
                . "(SUM(`Cantidad`)*(SELECT ValorComision3 FROM productosventa WHERE productosventa.Referencia=`facturas_items`.`Referencia`) ) AS Comision3"
                . " FROM `facturas_items`WHERE idCierre='$idCierre' GROUP BY `Referencia` ";
        
        $Consulta=$this->obCon->Query($sql);
        $f=3;
        $TotalCantidad=0;
        $TotalValor=0;
        $TotalComision1=0;
        $TotalComision2=0;
        $TotalComision3=0;
        while($DatosComisiones= $this->obCon->FetchArray($Consulta)){
            $TotalCantidad=$TotalCantidad+$DatosComisiones["CantidadTotal"];
            $TotalValor=$TotalValor+$DatosComisiones["ValorTotal"];
            $TotalComision1=$TotalComision1+$DatosComisiones["Comision1"];
            $TotalComision2=$TotalComision2+$DatosComisiones["Comision2"];
            $TotalComision3=$TotalComision3+$DatosComisiones["Comision3"];
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[0].$f,$DatosComisiones["Referencia"])
            ->setCellValue($this->Campos[1].$f,$DatosComisiones["CantidadTotal"])
            ->setCellValue($this->Campos[2].$f,$DatosComisiones["ValorTotal"])
            ->setCellValue($this->Campos[3].$f,$DatosComisiones["Comision1"])
            ->setCellValue($this->Campos[4].$f,$DatosComisiones["Comision2"])
            ->setCellValue($this->Campos[5].$f,$DatosComisiones["Comision3"])            
            ;
            $f++;
        }
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[0].$f,"TOTALES")
            ->setCellValue($this->Campos[1].$f,$TotalCantidad)
            ->setCellValue($this->Campos[2].$f,$TotalValor)
            ->setCellValue($this->Campos[3].$f,$TotalComision1)
            ->setCellValue($this->Campos[4].$f,$TotalComision2)
            ->setCellValue($this->Campos[5].$f,$TotalComision3)            
            ;
        //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.technosoluciones.com.co")
        ->setLastModifiedBy("www.technosoluciones.com.co")
        ->setTitle("Informe de Comisiones")
        ->setSubject("Informe")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("techno soluciones sas")
        ->setCategory("Informes Ventas");    
 
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Informe_Comisiones".'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    exit; 
        
    }
   //Fin Clases
}
    