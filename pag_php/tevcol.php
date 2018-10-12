<?php 
	session_start();
	
//	$_SESSION['user']=isset($_REQUEST["usuario"]) ? $_REQUEST["usuario"]:NULL ;
	$_SESSION['cod_user']=isset($_REQUEST["cod_login"]) ? $_REQUEST["cod_login"]:NULL ;
	$_SESSION['aprueba']=isset($_REQUEST["aprueba"]) ? $_REQUEST["aprueba"]:NULL ;
	//$_SESSION['cargo']=isset($_REQUEST["cargo"]) ? $_REQUEST["cargo"]:NULL ;
		
	$cod_user=$_SESSION['cod_user'];
	//$usuario=$_SESSION['user'];
	
//echo $_SESSION['cod_user'];
//echo $_SESSION['aprueba'];
	                                    
										include("../func_php/lib.php");
					    	  		    $con=conectar();
										$sqll="Select lo_username, lo_nombre, lo_confirma from login where cod_login='$cod_user'";
										$rst = oci_parse($con, $sqll);
            							oci_execute($rst) or die("Ocurrió un error sesion2");
										$row = oci_fetch_array($rst, OCI_ASSOC);
										$_SESSION['user']=$row['LO_USERNAME'];
										$_SESSION['lo_confirma']=$row['LO_CONFIRMA'];
   									    oci_close($con);										

if(isset($_SESSION['user']))
{	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../images/favicon.ico">
 <title>TEVCOL - SISTEMA DE COMPRAS</title>
 <link rel="stylesheet" type="text/css" href="../otros/style.css" media="screen" />
<style type="text/css">
<!--
.Estilo47 {
	color: #FFFFFF;
	font-size: 12px;
}
.Estilo48 {font-size: 11px}
-->
</style>
</head>
<body>
<div align="right" class="botones2" id="footer2">
    <a href="../func_php/salir.php" target="_self" class="Estilo47" onclick="javascript:alert('Usted ha salido de nuestro sistema.\nVuelva pronto.');"><span class="Estilo48">SALIR DEL SISTEMA</span> <img src="../images/application_exit.png" alt="Salir del Sistema" width="20" height="20" hspace="0" vspace="0" /></a></div>
<div id="wrapper">
  <div id="header">
  	<div id="headerpic"></div>
  </div>
		<div id="page">
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
<iframe name="icentro" id="icentro" style="overflow-x:hidden; overflow-y:auto;" frameborder=0 scrolling=yes align="top" src="inicontenido.php" width="800px" height="500px"></iframe>
  </div><!-- end #page -->
</div>
<div id="footer">
	<p class="botones2">&copy; 2011. All Rights Reserved. Developed by TEVCOL Cia. Ltda.</p>
</div>
<!-- end #footer -->
</body>
<?php 
}else
{
  $URL="login.php?num=6";
  header("Location: $URL");
  exit;
}
?>
</html>


