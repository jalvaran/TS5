var idComprobanteC=0;

function EnviaFormSC() {

	document.FormMesa.submit();
		
}

function EnviaForm(idForm) {
	
	document.getElementById(idForm).submit();
		
}

function EnviaFormVentasRapidas() {
	var total;
	var paga;
	var devuelta;
	
	total =  parseInt(document.getElementById("TxtGranTotalH").value);
	efectivo =  parseInt(document.getElementById("TxtPaga").value);
        tarjeta =  parseInt(document.getElementById("TxtPagaTarjeta").value);
        cheque =  parseInt(document.getElementById("TxtPagaCheque").value);
        otros =  parseInt(document.getElementById("TxtPagaOtros").value);
        
        if(document.getElementById("TxtPaga").length <= 0 ){
            efectivo=0;
        }
        if(document.getElementById("TxtPagaTarjeta").length <= 0){
            tarjeta=0;
        }
        if(document.getElementById("TxtPagaCheque").length <= 0){
            cheque=0;
        }
        if(document.getElementById("TxtPagaOtros").length <= 0){
            otros=0;
        }
	TotalPago=efectivo+tarjeta+cheque+otros;
        if(TotalPago >= total){
            
            document.getElementById('FrmGuarda').submit();
        }else{
            alert("El dinero pagado no es superior al saldo, por favor digite un dato valido");
        }
		
}



function EnviaFormDepar() {

	document.FormDepar.submit();
		
}

function EnviaFormOrden() {

	document.FormOrden.submit();
		
}

function incrementa(id) {

	document.getElementById(id).value++;
	

}

function decrementa(id) {

if(document.getElementById(id).value > 1)
	document.getElementById(id).value--;

}
function cargar(){

$("#DivConsultas").load("consultas.php?Tipo=Cronometro");

}

function refresca(seg) {
    
    setInterval("cargar()",1000);
}


function cargarMesas(){

$("#contenidoMesas").load("contMesas.php");

}

function refrescaMesas(seg) {
	setTimeout("cargarMesas()",seg);
}

function posiciona(id){ 
   
   document.getElementById(id).focus();
}

function CalculeDevuelta() {

	var total;
	var paga;
	var devuelta;
	
	total =  parseInt(document.getElementById("TxtGranTotalH").value);
	efectivo =  parseInt(document.getElementById("TxtPaga").value);
        tarjeta =  parseInt(document.getElementById("TxtPagaTarjeta").value);
        cheque =  parseInt(document.getElementById("TxtPagaCheque").value);
        otros =  parseInt(document.getElementById("TxtPagaOtros").value);
        
        if(document.getElementById("TxtPaga").length <= 0 ){
            efectivo=0;
        }
        if(document.getElementById("TxtPagaTarjeta").length <= 0){
            tarjeta=0;
        }
        if(document.getElementById("TxtPagaCheque").length <= 0){
            cheque=0;
        }
        if(document.getElementById("TxtPagaOtros").length <= 0){
            otros=0;
        }
	TotalPago=efectivo+tarjeta+cheque+otros;
       
	devuelta = TotalPago - total;
	
	document.getElementById("TxtDevuelta").value=devuelta;

}

function atajos()
{


shortcut("Ctrl+Q",function()
{
//document.getElementById("TxtPaga").focus();
document.getElementById("TxtPaga").select();
});
shortcut("Ctrl+E",function()
{
document.getElementById("TxtCodigoBarras").focus();
});


shortcut("Ctrl+S",function()
{
document.getElementById("BtnGuardar").click();
});

}

function CreaRazonSocial() {

    campo1=document.getElementById('TxtPA').value;
    campo2=document.getElementById('TxtSA').value;
    campo3=document.getElementById('TxtPN').value;
    campo4=document.getElementById('TxtON').value;
	

    Razon=campo3+" "+campo4+" "+campo1+" "+campo2;

    document.getElementById('TxtRazonSocial').value=Razon;


}

function calculetotaldias() {
	
	var Subtotal=document.getElementById("TxtSubtotalH").value;
	var IVA=document.getElementById("TxtIVAH").value;
	var Total=document.getElementById("TxtTotalH").value;
	var Dias=document.getElementById("TxtDias").value;
	var Anticipo=document.getElementById("TxtAnticipo").value;
	
	Saldo=Total*Dias-Anticipo;
	document.getElementById("TxtSubtotal").value=Subtotal*Dias;
	document.getElementById("TxtIVA").value=IVA*Dias;
	document.getElementById("TxtTotal").value=Total*Dias;
	document.getElementById("TxtSaldo").value=Saldo;

}

// esta funcion no permite enviar un formulario con el enter
function DeshabilitaEnter(){
    
    if(event.keyCode == 13) event.returnValue = false;
}

// esta funcion permite confirmar el envio de un formulario
function Confirmar(){
	
	if (confirm('¿Estas seguro que deseas realizar esta accion?')){ 
      this.form.submit();
      
    } 
}

// esta funcion permite confirmar el envio de un formulario
function ConfirmarFormPass(){
    alert("Esta accion requiere autorizacion");
   
}

// esta funcion permite confirmar el envio de un formulario
function ConfirmarFormNegativo(id){
    valor=parseInt(document.getElementById(id).value);
    
    if(valor<0){
       alert("Esta accion requiere autorizacion");
        
        return false;
    }else{
        this.form.submit();
    }
    
}

function ConfirmarLink(id){
	
    if (confirm('¿Estas seguro que deseas registrar este abono?')){ 
     
      document.location.href= document.getElementById(id).value;
    } 
}

// esta funcion permite mostrar u ocultar un elemento
function MuestraOculta(id){
    
    estado=document.getElementById(id).style.display;
    if(estado=="none" | estado==""){
        document.getElementById(id).style.display="block";
    }
    if(estado=="block"){
        document.getElementById(id).style.display="none";
    }
    
}

// esta funcion permite mostrar u ocultar un elemento
function Muestra(id){
        
    document.getElementById(id).style.display="block";
       
}

// esta funcion permite mostrar u ocultar un elemento
function Oculta(id){
        
    document.getElementById(id).style.display="none";
       
}


// esta funcion permite deshabilitar o habilitar un elemento
function Habilita(id,estado){
    
    document.getElementById(id).disabled=estado;
       
}

// esta funcion permite deshabilitar o habilitar un elemento
function HabilitaPrecio(id){
    
    pass = prompt("Para cambiar el precio introduzca su contraseña");
    
    if(pass=="1234"){
        document.getElementById(id).disabled=!document.getElementById(id).disabled;
    }
       
}

function CalculeTotal() {

	var Subtotal;
	var IVA;
	var Total;
	
	Subtotal = parseInt(document.getElementById("TxtSubtotal").value);
	IVA = parseInt(document.getElementById("TxtIVA").value);
	Total= parseInt(Subtotal) + parseInt(IVA);
	
	document.getElementById("TxtTotal").value=Total;

}

function CalculeTotalImpuestos() {

	var TxtSancion;
	var TxtIntereses;
	var TxtImpuesto;
	var Total;
	
	TxtSancion = parseInt(document.getElementById("TxtSancion").value);
	TxtIntereses = parseInt(document.getElementById("TxtIntereses").value);
	TxtImpuesto = parseInt(document.getElementById("TxtImpuesto").value);
	Total= parseInt(TxtSancion) + parseInt(TxtIntereses) + parseInt(TxtImpuesto);
	
	document.getElementById("TxtTotal").value=Total;

}

//Calcula el total en los egresos desde ventas rapidas

function CalculeTotalEgresosVR() {

	var Subtotal;
	var IVA;
	var Total;
	
	Subtotal = parseInt(document.getElementById("TxtSubtotalEgreso").value);
	IVA = parseInt(document.getElementById("TxtIVAEgreso").value);
	Total= parseInt(Subtotal) + parseInt(IVA);
	
	document.getElementById("TxtValorEgreso").value=Total;

}

// esta funcion permite cambiar un link
function CambiaLinkKit(idProducto,idLink,idCantidad,idkit,page){
    
    
    Cantidad=document.getElementById(idCantidad).value;
    
    Kit=document.getElementsByName(idkit)[0].value;
    
    link="procesadores/ProcesadorAgregaKits.php?Tabla=productosventa&IDProducto="+idProducto+"&TxtCantidad="+Cantidad+"&idKit="+Kit+"&Page="+page;
    
    document.getElementById(idLink).href=link;
    
}

function CambiaLinkAbono(idfecha,idLibro,idLink,idCantidad,idCuenta,page,procesador,TablaAbono){
    
    
        Cantidad=document.getElementById(idCantidad).value;
        Fecha2=document.getElementById(idfecha).value;
        Cuenta=document.getElementsByName(idCuenta)[0].value;

        link=procesador+"?TablaAbono="+TablaAbono+"&IDLibro="+idLibro+"&TxtCantidad="+Cantidad+"&idCuenta="+Cuenta+"&Page="+page+"&TxtFecha="+Fecha2;

        document.getElementById(idLink).href=link;
    
    
}

function CalculeTotalPagoIngreso() {

	var Retefuente;
	var ReteIVA;
	var ReteICA;
        var Otros;
	var Total;
	var TotalPago;
        
	Retefuente = document.getElementById("TxtRetefuente").value;
	ReteIVA = document.getElementById("TxtReteIVA").value;
	ReteICA = document.getElementById("TxtReteICA").value;
        Otros = document.getElementById("TxtOtrosDescuentos").value;
        Total = document.getElementById("TxtPagoH").value;
        
	TotalPago= Total - Retefuente - ReteIVA - ReteICA - Otros;
	
	document.getElementById("TxtPago").value = TotalPago;

}

// esta funcion permite mostrar u ocultar un elemento
function MuestreDesdeCombo(idCombo,idElement,idCarga){
    
    estado=document.getElementsByName(idCombo)[0].value;
    idComprobanteC=estado;
    if(estado==""){
        document.getElementById(idElement).style.display="none";
    }else{
        document.getElementById(idElement).style.display="block";
    }
    
}

// esta funcion permite mostrar u ocultar un elemento
function CargueIdEgreso(){
    
    document.getElementById('TxtIdCC').value=idComprobanteC;
    
}

// esta funcion permite mostrar u ocultar un elemento
function ObtengaValor(id){
    
    valor=document.getElementById(id).value;
    return valor;
}

// esta funcion permite calcular el valor y costo de un servicio, aplica solo para servitorno
function Servitorno_CalculePrecioVenta(Costos){
    
    var Cantidad;
    var TiempoMaquina;
    var Margen;
    var Maquinas;
    var CostosTotales;
    var ValorTotal;
    var CostoTotal;
    var TotalMateriales;
        
    Cantidad=document.getElementById('TxtCantidadPiezas').value;
    TotalMateriales=document.getElementById('TxtValorMateriales').value;
    if(Cantidad<=0){
        Cantidad=1;
    }
    TiempoMaquina=document.getElementById('TxtTiempoMaquinas').value;
    Margen=document.getElementById('TxtMargen').value;
    Maquinas=document.getElementById('TxtNumMaquinas').value;
    CostosTotales=Costos/Maquinas;
    
    ValorTotal=Math.round(((CostosTotales*TiempoMaquina)/Margen)/Cantidad);
    ValorTotal=parseInt(ValorTotal)+parseInt(TotalMateriales);
    CostoTotal=Math.round(((CostosTotales*TiempoMaquina))/Cantidad);
    document.getElementById("TxtPrecioVenta").value = ValorTotal;
    document.getElementById("TxtCostoUnitario").value = CostoTotal;
    
}

function MostrarDialogo() {

    document.getElementById('ShowItemsBusqueda').click();
		
}

function MostrarDialogoID(id) {

    document.getElementById(id).click();
		
}

function ClickElement(id) {

    document.getElementById(id).click();
		
}

function beep() {
   // alert("Entra");
  (new
	Audio(
	"data:audio/wav;base64,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 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU="
	)).play();
}

// esta funcion permite cambiar el max y min de una caja de texto
function CambiarMaxMin(idCaja,Min,Max){
    
    document.getElementById(idCaja).min=Min;
    document.getElementById(idCaja).max=Max;
    
}

//Funcion calcule valor con respecto a una caja de texto
function CalculeValorDependencia(idDependencia,idCambiar,Operacion,idValor) {
    	
	       
	ValorDependencia = document.getElementById(idDependencia).value;
        Valor=document.getElementById(idValor).value;
        if(Operacion=='P'){
            Resultado=(ValorDependencia*Valor)/100;
        }
        
        if(Operacion=='M'){
            Resultado=(ValorDependencia*Valor);
        }
	
	document.getElementById(idCambiar).value = Resultado;

}

//Funcion calcule la sumatoria de los montos y escribalo en una caja de texto
function CalculeSumatoria(idCambiar) {
    	
	var Total;
        var idMonto;
        Total=0;
        document.getElementById(idCambiar).value = 0;
        //Total=parseInt(document.getElementById('Monto2').value)+parseInt(document.getElementById('Monto3').value);
        
        for(i=1;i<=10000; i++){
            if(document.getElementById('Monto'+i)){
                //Total=Total+document.getElementById('Monto'+i).value;
                //alert(parseInt(document.getElementById('Monto'+i).value));
                Total=Total+parseFloat(document.getElementById('Monto'+i).value);
            }
        }
        //alert(valor);
	document.getElementById(idCambiar).value = Total;

}