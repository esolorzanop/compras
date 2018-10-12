<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TEVCOL - SISTEMA DE COMPRAS</title>
<link rel="stylesheet" type="text/css" href="../otros/stylelog.css" media="screen"/>

<style type="text/css">
	#capaVentana {
		visibility:hidden;
		padding:0px;
		z-index:3;
		position: absolute;
		top: 50%; /* Buscamos el centro horizontal (relativo) del navegador */
		left: 50%; /* Buscamos el centro vertical (relativo) del navegador */
		width: 400px; /* Definimos el ancho del objeto a centrar */
		height: 200px; /* Definimos el alto del objeto a centrar */
		margin-top: -100px; /* Restamos la mitad de la altura del objeto con un margin-top */
		margin-left: -200px; /* Restamos la mitad de la anchura del objeto con un margin-left */
		overflow:auto;
	}
	#capaFondo2 {
		visibility:hidden;
		position:absolute;
		padding:0px;
		left:0px;
		top:0px;
		right:0px;
		bottom:0px;
		background-image:url(../images/trans02.gif);
		background-repeat:repeat;
		width:100%;
		height:100%;
		z-index:2;
	}
.Estilo51 {font-size: 12px; }
</style>

<script language="JavaScript" type="text/JavaScript">
<!--
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

//-->

function pulsar(e) { 
  tecla = (document.all) ? e.keyCode :e.which;   
  if (tecla==13) 
     {
    document.form1.passwd.focus();
  }
}

function sig2(e)
{
  tecla = (document.all) ? e.keyCode :e.which;   
  if (tecla==13) 
     {
    document.form1.ingresar.onclick=validar_datos();
  }
}

function validar_datos()
{

if(document.form1.user.value=="")
{  
alert("Ingrese su Usuario"); 
document.form1.user.focus();
return;
}

if(document.form1.passwd.value=="")
{  
alert("Ingrese su Clave"); 
document.form1.passwd.focus();
return;
}

document.form1.action="../func_php/validar_usuario.php"; ///aqui va la pagina que valida los ingresos
document.form1.submit();

}

function entrar()
{
//if((document.form1.cod_login.value=="5")||(document.form1.cod_nivel.value=="2")||(document.form1.cod_nivel.value=="3"))
document.form1.action="tevcol.php";
document.form1.submit();  
}

function pantallacompleta (pagina) 
{
var opciones=("toolbar=no, location=no, directories=no, status=no, menubar=no ,scrollbars=yes, resizable=yes, fullscreen=yes"); 
window.open(pagina,"_self",opciones);
}

function cerrar() {
    var ventana = window.self;
    ventana.close();
  }

function ingresar_datos()
{
	resizeTo(screen.width, screen.height)
	moveTo(0, 0);
  	document.form1.user.focus();
  
 if (document.form1.validar.value=="1")
 {
 var user;
 user=document.form1.user.value;
 entrar();
 }
 
if (document.form1.validar.value=="4")
 {    
   alert("Usuario Incorrecto........");
   document.form1.user.focus();
   document.form1.user.select();
    
 }

if (document.form1.validar.value=="5")
 {
   alert("Clave Incorrecto........");
   document.form1.passwd.focus();
   document.form1.passwd.select();

 }

if (document.form1.validar.value=="6")
 {
   alert("Debe Ingresar sus datos para tener acceso al sistema........");
   document.form1.user.focus();  
 }

if (document.form1.validar.value=="9")
 {    
   alert("Usuario ya esta siendo utilizado.\nPara poder ingresar al sistema pruebe con otro nombre de usuario........");
   document.form1.user.focus();
   document.form1.user.value="";  
   document.form1.passwd.value="";   
 }
if (document.form1.validar.value=="10")
 {    
   alert("Usuario desbloqueado.\nYa puede ingresar al sistema pruebe con su nombre de usuario........");
   document.form1.user.focus();
   document.form1.user.value="";  
   document.form1.passwd.value="";   
 }
if (document.form1.validar.value=="50")
 {    
  var ventana = window.parent;
  ventana.close();
}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
	function abrirVentana(ventana)
	{
		if (ventana=="2")
		{
			document.getElementById("capaFondo2").style.visibility="visible";
		}	
		document.getElementById("capaVentana").style.visibility="visible";
		document.autorizacion.user.focus();
		document.autorizacion.user.value="";
        document.autorizacion.passwd1.value="";
	}
	function cerrarVentana()
	{
		document.getElementById("capaFondo2").style.visibility="hidden";
		document.getElementById("capaVentana").style.visibility="hidden";
		document.autorizacion.cancelar1.blur();
        document.form1.usuario.focus();
	}

  function pulsar1(e) { 
  tecla = (document.all) ? e.keyCode :e.which;   
  if (tecla==13) 
     {
    document.autorizacion.passwd1.focus();
  }
  }
  function pulsar2(e) { 
  tecla = (document.all) ? e.keyCode :e.which;   
  if (tecla==13) 
     {
    document.autorizacion.grabar1.focus();
  }
  }
-->
</script>

</head>

<body onload="ingresar_datos();MM_preloadImages('../images/loginpage_15o.png')">           
<div id="layer01_holder">
  <div id="left"></div>
  <div id="center"></div>
  <div id="right"></div>
</div>

<div id="layer02_holder">
  <div id="left"></div>
  <div id="center"></div>
  <div id="right"></div>
</div>

<div id="layer03_holder">
  <div id="left"></div>
  <div id="center">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">INGRESO AL SISTEMA<br />
        </td>
  </tr>
  <tr>
    <td><form method="post" name="form1" id="form1">
<div align="center">
	<input type="hidden" name="aprueba"  id="aprueba" value="<?php echo isset($_REQUEST["aprueba"]) ? $_REQUEST["aprueba"]:NULL ; ?>" />    
    <input type="hidden" name="cod_login"  id="cod_login" value="<?php echo isset($_REQUEST["cod_login"]) ? $_REQUEST["cod_login"]:NULL ; ?>" />
      <input type="hidden" name="validar" value="<?php echo isset($_REQUEST["num"]) ? $_REQUEST["num"]:NULL ; ?>">
      
      <label>Usuario<br />
        <input name="user" type="text" id="user" onkeypress="return pulsar(event);" style='text-align:center;' value="<?php echo isset($_REQUEST["user"]) ? $_REQUEST["user"]:NULL; ?>" />
      </label>
      <label><br />
        	 Password<br /> 
       <input name="passwd" type="password" id="passwd" style='text-align:center;' onkeypress="return sig2(event);" value="<?php echo isset($_REQUEST["passwd"]) ? $_REQUEST["passwd"]:NULL; ?>" />
      </label>
<br><br>
<img src="../images/loginpage_15.png" alt="Ingresar al sistema" name="ingresar" width="63" height="22" border="0" id="ingresar" onclick="validar_datos();" onmouseover="MM_swapImage('ingresar','','../images/loginpage_15o.png',1)" onmouseout="MM_swapImgRestore()"/></div>
    </form>    </td>
  </tr>
</table>
  </div>
  <div id="right"></div>
</div>
<div id="layer04_holder">
  <div id="left"></div>
  <div id="center">
<!--  <p>Si su usuario se encuentra bloqueado de: <a href="javascript:abrirVentana('2')">click aqui</a>.</p> -->
<!--    Si no cuenta con usuario registrado. Solicitelo a: <a mailto:"registro.firmas@tevcol.com.ec">registro.firmas@tevcol.com.ec</a>.-->
  </div>
  <div id="right"></div>
</div>
<div id="layer05_holder">
  <div align="left">Copyright &copy; 2012, TEVCOL Cia. Ltda.</div>
</div>

<div id="capaFondo2" style="visibility: hidden;"></div>
</body>
</html>