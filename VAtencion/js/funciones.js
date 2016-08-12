
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

$("#contenido").load("contpedidos.php");

}

function refresca(seg) {
	setTimeout("cargar()",seg);
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
document.getElementById("TxtPaga").focus();
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
	var Total;
	var TotalPago;
        
	Retefuente = document.getElementById("TxtRetefuente").value;
	ReteIVA = document.getElementById("TxtReteIVA").value;
	ReteICA = document.getElementById("TxtReteICA").value;
        Total = document.getElementById("TxtPagoH").value;
        
	TotalPago= Total - Retefuente - ReteIVA - ReteICA;
	
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