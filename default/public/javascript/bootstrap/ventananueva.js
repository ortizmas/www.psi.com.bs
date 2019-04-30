var AnchoPagImpresion=500;
function imprimirPagina(tituloURLEnc, width){
var vieja;
if (document.all) {
if (typeof(PrintData)!='object') {alert('No existen datos para imprimir');return;}
} else {
try {vieja=document.getElementById('PrintData').name;}
catch(e) {alert('No existen datos para imprimir');return;}
}
var winPrint=window.open('/zona_publica/library/viaBCPImprimir.asp?TituloPag='+tituloURLEnc,'DetImprimir','top=0,left=0,width=' + width + ',height=543,scrollbars=yes,resizable=yes');
}

function cierraVentana(ventan){
	ventan.close();
}
function trim(str) {
 while (str.charAt(0) == ' ') str = str.substring(1);
 while (str.charAt(str.length - 1) == ' ') str = str.substring(0, str.length - 1);
 return str;
}

function noVacio(elm){
	return (elm.value != "" && elm.value != null);
}

function MM_OpenWin(pagina,nombre){
window.open(pagina, nombre,"width=1100, height=1000, scrollbars=1, toolbar=0, menubar=0,top=0,left=0,resizable=yes, location=1, status=1");
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
 window.open(theURL,winName,features);
}

function bNavegador() {
 if( navigator.appName ){
  if( navigator.appName == "Microsoft Internet Explorer") return 1;
  if( navigator.appName == "Netscape") return 2;
 }
 return 0;
}
function abremismaventana_Certifica(theUrl,aRuta)
{
	//cert_registerHit(23947, aRuta, "cert_Pivot");
	window.location.href=theUrl;
}

function ventananueva( aURL, aWinName, aRuta, pWidth, pHeight, cuadrante, param )
{


	window.open(aURL, aWinName, "width=1000, height=500, scrollbars=1, toolbar=0, menubar=0, resizable=yes, location=1, status=1");


}

function ventananueva( aURL, aWinName, aRuta )
{
	window.open(aURL, aWinName, "width=1000, height=500, scrollbars=1, toolbar=0, menubar=0, resizable=yes, location=1, status=1");

}


function AbreVentana(pagina,nombre){
	window.open(pagina, nombre, "width=1000, height=500, scrollbars=1, toolbar=0, menubar=0, resizable=yes, location=1, status=1");
}



bNombre = navigator.appName;
function muestra1(e)  {
var bAgent = navigator.userAgent;
if ((bNombre.indexOf("Explorer") >= 10)){
	if(eval(e+".style.display") == "none") {
		eval(e+".style.display = '';");
	} else {
		eval(e+".style.display = 'none';");
	}
	}
}

function HyperWarp(xpag){
	window.opener.location.href=xpag;
	window.close();
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	if (restore) selObj.selectedIndex=0;
}

function SeleccionarMedios(form){
	if (form.cbomedios.selectedIndex == '1') {
		MM_openBrWindow('pop_alertas_medios_email.html','email','width=500,height=192');
	} else {
		if (form.cbomedios.selectedIndex == '2')
		MM_openBrWindow('pop_alertas_medios_celular.html','celular','width=500,height=202');
	}
}

function SeleccionarEstado(form){
	if (form.cboestado.selectedIndex == '1') 
	{
		MM_openBrWindow('pop_alerta_exclusivo.html','exclusivo','scrollbars=yes,width=760,height=505');
	}
	else
	{
		if (form.cboestado.selectedIndex == '2')
		MM_openBrWindow('pop_alerta_exclusivo.html','exclusivo','scrollbars=yes,width=760,height=505');
	}
}

function fCambio(){
	if (document.frmCambio.cmbCambio.options[document.frmCambio.cmbCambio.selectedIndex].value==1)
		window.location.href="pop_valor_historico_cotizaciones_1.html";
	if (document.frmCambio.cmbCambio.options[document.frmCambio.cmbCambio.selectedIndex].value==2)
		window.location.href="pop_valor_historico_cotizaciones_1.html";
	if (document.frmCambio.cmbCambio.options[document.frmCambio.cmbCambio.selectedIndex].value==3)
		window.location.href="pop_valor_historico_cotizaciones_1.html";
	if (document.frmCambio.cmbCambio.options[document.frmCambio.cmbCambio.selectedIndex].value==4)
		window.location.href="pop_valor_historico_cotizaciones_1.html";
}

var enablepersist="on"; //Enable saving state of content structure using session cookies? (on/off)
var collapseprevious="yes"; //Collapse previously open content when opening present? (yes/no)


if (document.getElementById){
	document.write('<style type="text/css">');
	document.write('.switchcontent{display:none;}');
	document.write('</style>');
}

function getElementbyClass(classname){
ccollect=new Array();
var inc=0;
var alltags=document.all? document.all : document.getElementsByTagName("*");
for (i=0; i<alltags.length; i++)
	if (alltags[i].className==classname) ccollect[inc++]=alltags[i];
}

function contractcontent(omit){
var inc=0;
while (ccollect[inc]){
if (ccollect[inc].id!=omit) ccollect[inc].style.display="none";
inc++;
}
}

function expandcontent(cid){
if (typeof ccollect!="undefined"){
if (collapseprevious=="yes") contractcontent(cid);
document.getElementById(cid).style.display=(document.getElementById(cid).style.display!="block")? "block" : "none";
}
}

function revivecontent(){
contractcontent("omitnothing");
selectedItem=getselectedItem();
selectedComponents=selectedItem.split("|");
for (i=0; i<selectedComponents.length-1; i++)
document.getElementById(selectedComponents[i]).style.display="block"
}

function get_cookie(Name) { 
var search = Name + "=";
var returnvalue = "";
if (document.cookie.length > 0) {
offset = document.cookie.indexOf(search);
if (offset != -1) {
	offset += search.length;
	end = document.cookie.indexOf(";", offset);
	if (end == -1) end = document.cookie.length;
	returnvalue=unescape(document.cookie.substring(offset, end));
}
}
return returnvalue;
}

function getselectedItem(){
if (get_cookie(window.location.pathname) != ''){
	selectedItem=get_cookie(window.location.pathname);
	return selectedItem;
}
else
return '';
}

function saveswitchstate(){
var inc=0, selectedItem="";
ccollect=new Array();
while (ccollect[inc]){
if (ccollect[inc].style.display=="block") selectedItem+=ccollect[inc].id+"|";
inc++;
}

document.cookie=window.location.pathname+"="+selectedItem;
}

function do_onload(){
getElementbyClass("switchcontent");
if (enablepersist=="on" && typeof ccollect!="undefined")
revivecontent();
}


if (window.addEventListener)
window.addEventListener("load", do_onload, false)
else if (window.attachEvent)
window.attachEvent("onload", do_onload)
else if (document.getElementById)
window.onload=do_onload;

if (enablepersist=="on" && document.getElementById)
window.onunload=saveswitchstate

var contador=0;
function ContactanosViaBcp(zero){
  var w=640, h=480;
  var windowName = new String(contador);
  windowName = "v" + windowName;
  var web="viabcp";
  var x = bNavegador();
  if (window.screen && window.screen.availHeight) {
    h = window.screen.availHeight - 63; // 63
    if( x==2 ) h = h - 11;
    w = window.screen.availWidth - 10;
  }
  window.open("http://contactanos.viabcp.com/home.asp?origen="+web, windowName, "status=yes,resizable=yes,scrollbars=yes,top=0,left=0,width=" + w + ",height=" + h, 1);
  contador = contador + 1;
}

function valorDeCombo(objectoCombo) {
return objectoCombo.options[objectoCombo.selectedIndex].value;
}

function lanza_Certifica(objectoCombo1,ruta) {
  var valorsh=valorDeCombo(objectoCombo1);
  var indice=valorsh.indexOf('_');
  var longitud=valorsh.length;
  var letra=valorsh.substring(0,1);
  var numero=valorsh.substring(indice+1,longitud);
  //cert_registerHit(23947, ruta, "cert_Pivot");
  if(letra=='S'){
    objectoCombo1.form.paramEnlace.value=valorsh;
    objectoCombo1.form.target='_self';
    objectoCombo1.form.submit();
  }
  else if(letra=='B'){
    objectoCombo1.form.paramEnlace.value=valorsh;
    objectoCombo1.form.target='_blank';
    objectoCombo1.form.submit();
  }
  else if(letra=='P'){
    abreventanaFija('../library/incremVisitasEnlace.asp?paramEnlace='+valorsh,'popupcombo');
  }
  else return;
}

function lanza(objectoCombo1) {
  var valorsh=valorDeCombo(objectoCombo1);
  var indice=valorsh.indexOf('_');
  var longitud=valorsh.length;
  var letra=valorsh.substring(0,1);
  var numero=valorsh.substring(indice+1,longitud);
  if(letra=='S'){
    objectoCombo1.form.paramEnlace.value=valorsh;
    objectoCombo1.form.target='_self';
    objectoCombo1.form.submit();
  }
  else if(letra=='B'){
    objectoCombo1.form.paramEnlace.value=valorsh;
    objectoCombo1.form.target='_blank';
    objectoCombo1.form.submit();
  }
  else if(letra=='P'){
    abreventanaFija('../library/incremVisitasEnlace.asp?paramEnlace='+valorsh,'popupcombo');
  }
  else return;
}

//---------------------------------------------------------------
// GetCookie - Returns the value of the specified cookie or null
//             if the cookie doesn't exist
//---------------------------------------------------------------
function GetCookie(name) {
  var result = null;
  var myCookie = " " + document.cookie + ";";
  var searchName = " " + name + "=";
  var startOfCookie = myCookie.indexOf(searchName)
  var endOfCookie;
  if (startOfCookie != -1) {
    startOfCookie += searchName.length; // skip past cookie name
    endOfCookie = myCookie.indexOf(";", startOfCookie);
    result = unescape(myCookie.substring(startOfCookie, endOfCookie));
  }
  return result;
}

//---------------------------------------------------------------
// SetCookie - Adds or replaces a cookie. Use null for parameters
//             that you don't care about
//---------------------------------------------------------------
function SetCookie(name, value, expiredays, path, domain, secure) {
  var expires = new Date();
  expires.setTime(expires.getTime() + (expiredays * 24 * 3500 * 1000));
  var expString = ((expires == null) ? "" : ("; expires=" + expires.toGMTString()));
  var pathString = ((path == null) ? "" : ("; path=" + path));
  var domainString = ((domain == null) ? "" : ("; domain=" + domain));
  var secureString = ((secure == true) ? "; secure" : "");
  document.cookie = name + "=" + escape(value) + expString + pathString + domainString + secureString;
}

var anchoDisponibleVentana = window.screen.availWidth;
var altoDisponibleVentana = window.screen.availHeight;
var winwin;

// begin - control de parametros a las funciones
function defaults(passed) {
 var pattern = /function[^(]*\(([^)]*)\)/;
 var args = passed.callee.toString().match(pattern)[1].split(/\s*,\s*/);
 var str = "", i = 1;
 for ( ; i < arguments.length; i++) {
  if (typeof passed[i-1] == "undefined") {
   str += args[i-1] + "=" + fix(arguments[i]) + ";";
  }
 }
 return str;

 function fix(x) {
  if (typeof x == "string") return "'" + x.replace(/\'/g, "\\'") + "'";
   return x;
  }
}
// end - control de parametros a las funciones

function abreventana_New(laurl, pWindowName,ruta, pWidth, pHeight, cuadrante, param) {

	window.open(laurl, pWindowName, "width=1000, height=500, scrollbars=1, toolbar=0, menubar=0, resizable=yes, location=1, status=1");

}

function abreventana(laurl, pWindowName, pWidth, pHeight, cuadrante, param) {

	window.open(laurl, pWindowName, "width="+String(pWidth)+", height="+String(pHeight)+", scrollbars=1, toolbar=0, menubar=0, resizable=yes, location=1, status=1");
}

function abreventanaFija(laurl, pWindowName) {
	window.open(laurl, pWindowName, "width=1000, height=500, scrollbars=1, toolbar=0, menubar=0, resizable=yes, location=1, status=1");
}

function abreventanaFija__Certifica(laurl, pWindowName,aRuta) {
	window.open(laurl, pWindowName, "width=1000, height=500, scrollbars=1, toolbar=0, menubar=0, resizable=yes, location=1, status=1");
}
// nueva funcion para abrir ventana maximizada
function ventananueva( pagina,nombre)
{
	window.open(pagina, nombre, "width=1000, height=500, scrollbars=1, toolbar=0, menubar=0, resizable=yes, location=1, status=1");
}

function abreventanaFijaSS(laurl, pWindowName) {
	window.open(laurl, pWindowName, "width=1000, height=500, scrollbars=1, toolbar=0, menubar=0, resizable=yes, location=1, status=1");

}

function abreventanaTasas(laurl,pWindowName){
abreventana(laurl, pWindowName, 500, 550, 1);
}

function abreventanaTarifas(laurl,pWindowName){
abreventana(laurl, pWindowName, 700, 550, 1);
}

function abreventanaCalculadoras(laurl,pWindowName){
abreventana(laurl, pWindowName, 500, 550, 1);
}

function RedirectPage(d){
document.location.href='/error.asp?des='+d;
}
function redireccionaJS(d){
document.location.href=d;
}

//Req 1000452
function PaginaInicio() 
{ 
if (bNavegador()==1)
{
	document.body.style.behavior='url(#default#homepage)';
	document.body.setHomePage(document.URL.substring(0,document.URL.indexOf('/',7)));
}
else 
{
	alert("Opción disponible solamente para Internet Explorer");
} 
}

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26609264-1']);
  _gaq.push(['_setDomainName', 'viabcp.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
//cambios para google chrome v18 en adelante.