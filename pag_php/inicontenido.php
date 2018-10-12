<?php 
	session_start();
	$cod_user = $_SESSION['cod_user'];
	$lo_confirma = $_SESSION['lo_confirma'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TEVCOL - SISTEMA DE COMPRAS</title>
 <link rel="stylesheet" type="text/css" href="../otros/style.css" media="screen" />
<script language="JavaScript" type="text/JavaScript">
<!--
	if(top==self) top.location="../pag_php/tevcol.php";
   	parent.document.getElementById("headerpic").style.height="300px";	
   	parent.document.getElementById("header").style.height="300px";		
	parent.document.getElementById("icentro").style.height="440px";		

function abrirVentana(ventana)
	{
		if (ventana=="2")
		{
	    document.getElementById("capaFondo2").style.visibility="visible";			
		document.getElementById("capaVentana").style.visibility="visible";		
  		document.solicitud.clave.value="";	
		document.solicitud.clave.focus();
		}	
	}
	function cerrarVentana()
	{
		document.getElementById("capaFondo2").style.visibility="hidden";
		document.getElementById("capaVentana").style.visibility="hidden";
	}
 function pulsar(e) { 
  tecla = (document.all) ? e.keyCode :e.which;   
  if (tecla==13) 
     {
    document.solicitud.nclave.focus();
    document.solicitud.nclave.value="";
  }
  }
 function pulsar1(e) { 
  tecla = (document.all) ? e.keyCode :e.which;   
  if (tecla==13) 
     {
    document.solicitud.cnclave.focus();
    document.solicitud.cnclave.value="";
  }
  }
  function pulsar2(e) { 
  tecla = (document.all) ? e.keyCode :e.which;   
  if (tecla==13) 
     {
    document.solicitud.grabar1.focus();
  }
  }	
function validar_datos2()
{
if((document.solicitud.clave.value=="")||(document.solicitud.nclave.value=="")||(document.solicitud.cnclave.value==""))
		{
		  alert("Faltan datos! por favor revise que todos los datos \nesten completos");	 
		  if(document.solicitud.clave.value==""){document.solicitud.clave.focus();} 
		  else{		
		       if(document.solicitud.nclave.value==""){document.solicitud.nclave.focus();} 		
		       else { if(document.solicitud.cnclave.value==""){document.solicitud.cnclave.focus();} }
		      }
		}else{
			if (document.solicitud.nclave.value==document.solicitud.cnclave.value)		
			 {	
				if (confirm("Atención!\nSe va a proceder a cambiar su clave de acceso.\nEsta seguro de realizar esta acción\n"))
				{
				document.solicitud.action="../func_php/grcmbclave.php"
				document.solicitud.submit();			
				//alert("prueba grabacion");
				}else{
   	               document.solicitud.nclave.value="";
                   document.solicitud.cnclave.value="";				
	               document.solicitud.nclave.focus();	
					}
			 }else{
                   alert("Revise los datos.\nEl valor de su nueva clave debe ser el mismo del campo Confirmar Nueva Clave.");     
	               document.solicitud.nclave.focus();
   	               document.solicitud.nclave.value="";
                   document.solicitud.cnclave.value="";
				  }	
		}
}	
function ingresar_perso()
{
 		  if (document.solicitud.validar.value=="1")
 	     {    
		   alert("No se pudo cambiar la clave de acceso.\nPara poder cambiar la clave debe poner una clave diferente a la que usted posee en este momento");
		 }
	  if (document.solicitud.validar.value=="4")
 	     {    
		   alert("No se pudo cambiar la clave de acceso.\nSi lo desea vuelva a intentarlo");
		 }
	  if (document.solicitud.validar.value=="5")
 	     {    
		   alert("Clave cambiada con exito.\nPor favor vuelva a ingresar al sistema usando su nueva clave de acceso");
		   salirr();
		 }	 	  
  } 
  
function salirr()
{
  alert('Usted ha salido de nuestro sistema.\nVuelva pronto.');
  location.href = "../func_php/salir.php";
			}  
-->
	</script>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	background-image: url(../images/fondo.gif);
}
.Estilo45 {color: #444444}
.Estilo46 {color: #444444; font-weight: bold; }
.Estilo49 {color: #D0910B}
.Estilo53 {
	font-size: 12px;
	font-weight: bold;
}
.Estilo56 {padding-left:1px; padding-top:1px; font-family: Tahoma; color: #D0910B;}

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
		position:fixed;
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
-->
</style></head>
<body onLoad="ingresar_perso();">
<div id="page">
<div id="content">
<div class="post" style="background-repeat:repeat; background-image:url(../images/fondo.gif)">

  <h2 class="title">SISTEMA DE SOLICITUDES Y AUTORIZACIONES DE COMPRA - <?php echo $_SESSION['user']; ?></h2>

<br /><div align="center"><span class="Estilo53"><span class="Estilo56">Atenci&oacute;n:</span><span class="Estilo45"> <strong>Si es la primera vez que ingresa al sitio le recomendamos que cambie su clave de acceso</strong></span></span></div>

<blockquote>
  <ul><li><strong><a href="inicontenido.php" target="icentro">INICIO</a></strong></li></ul>
</blockquote>  

<blockquote>
  <ul><li><strong><a href="solicitud.php" target="icentro">ADMINISTRACIÓN DE SOLICITUDES</a></strong></li></ul>
</blockquote>

<?php if ($lo_confirma == 1){ ?>
<blockquote>
  <ul><li><strong><a href="confirmacion.php" target="icentro">CONFIRMACIÓN DE PEDIDOS</a></strong></li></ul>
</blockquote>
<?php } ?>
<blockquote>
  <ul><li><strong><a href="autorizacion.php" target="icentro">AUTORIZACIÓN DE PEDIDOS</a></strong></li></ul>
</blockquote>

<blockquote>
  <ul><li><strong><a href="bushisto.php" target="icentro">BUSQUEDA HISTORIAL DE ITEMS COTIZADOS</a></strong></li></ul>
</blockquote>

<blockquote>
  <ul><li><strong><a href="bushistpedi.php" target="icentro">BUSQUEDA HISTORIAL PEDIDOS AUTORIZADOS</a></strong></li></ul>
</blockquote>

<blockquote>
  <ul><li><strong><a href="javascript:abrirVentana('2')">CAMBIO DE CLAVE</a></strong></li></ul>
</blockquote>

	</div>
    </div>
</div>
	<!-- end #content -->
	<!-- end #sidebar -->
</div>

<div id="capaVentana"  style="visibility: hidden;">
<form method="post" name="solicitud" target="_self" id="solicitud">
<input name="validar" type="hidden" value="<?php echo isset($_REQUEST["num"]) ? $_REQUEST["num"]:NULL ; ?>">
    <table border="1" bordercolor="#444444"><tr><td>
  <table width="300px" border="0" align="center" cellpadding="1" cellspacing="1" background="../images/fondo.gif">
    <tbody>
      <tr>
        <td height="25" colspan="2" bgcolor="#444444">
			<div align="center" ><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>CAMBIO DE CLAVE</strong></font></div></td>
      </tr>
      <tr>
        <td height="25"><div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#444444"><strong>*Clave Actual:</strong></font></div></td>
        <td><div align="left">
          <input style="border-width:thin;border-style:1px solid;border-color:#C0C0C0;" id="clave" size="20" onFocus="this.style.border='2px solid #F1CA7F';" onBlur="this.style.border='1px solid #C0C0C0';" onKeyPress="return pulsar(event);" name="clave" type="password"/>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#444444"><strong>*Nueva Clave:</strong></font></div></td>
        <td><div align="left"><input name="codusuario2" type="hidden" id="codusuario2" value="<?php echo isset($cod_user) ? $cod_user:$_REQUEST["codusuario2"]; ?>">
          <input style="border-width:thin;border-style:1px solid;border-color:#C0C0C0;" id="nclave" size="20" onFocus="this.style.border='2px solid #F1CA7F';" onBlur="this.style.border='1px solid #C0C0C0';" onKeyPress="return pulsar1(event);" name="nclave" type="password"/>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#444444"><strong>*Confirme N. Clave:</strong></font></div></td>
        <td><div align="left">
          <input style="border-width:thin;border-style:1px solid;border-color:#C0C0C0;" id="cnclave" size="20" onFocus="this.style.border='2px solid #F1CA7F';" onBlur="this.style.border='1px solid #C0C0C0';" onKeyPress="return pulsar2(event);" name="cnclave" type="password" />
        </div></td>
      </tr>
      <tr align="middle">
        <td colspan="2">
		<div align="center">
                <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#444444"><strong>*Complete los siguientes datos</strong></font></div>
                <input name="grabar1" type="button" class="botones" id="grabar1" onClick="validar_datos2();" value="Aceptar" />
                <input name="cancelar1" type="button" class="botones" id="cancelar1" value="Cancelar" onClick="cerrarVentana();" />
              </div></td>
      </tr>
    </tbody>
  </table>
     </td></tr></table>
</form>
</div>
<div id="capaFondo2" style="visibility: hidden;"></div>
<script language="JavaScript" type="text/javascript">
	<!-- Desactiva clic derecho
	var message="";
	function clickIE() {if (document.all) {(message);return false;}}
	function clickNS(e) {if 
	(document.layers||(document.getElementById&&!document.all)) {
	if (e.which==2||e.which==3) {(message);return false;}}}
	if (document.layers) 
	{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
	else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
	document.oncontextmenu=new Function("return false")
	// Fin del script -->
	</script>

</body>
</html>
