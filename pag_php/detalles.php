<?php
    	session_start();
////////////////////////// paginacion//////////////////////////////////
		 $pagina=0;
		 $pagina=isset($_GET["pagina"]) ? $_GET["pagina"]:NULL;
		 $registros = 12;
		 if (!$pagina) 
		 { 
          $inicio = 0; 
          $pagina = 1; 
		 }	 
			else { 
    		$inicio = ($pagina - 1) * $registros; 
			} 
			
/////////////////////////////////////////////////////////////////////
    include("../func_php/lib.php");
	$con=conectar();
	
	$cod_item=isset($_GET['cod_pedido']) ? $_GET['cod_pedido']:NULL ;
	
	$registro=isset($_GET['registro']) ? $_GET['registro']:NULL ;
	$user=$_SESSION['user'];


/////////////////////////////////////////////
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TEVCOL - SISTEMA DE COMPRAS</title>
<script language="JavaScript" type="text/JavaScript">
<!--
	if(top==self) top.location="../pag_php/tevcol.php";
   	parent.document.getElementById("headerpic").style.height="90px";	
   	parent.document.getElementById("header").style.height="90px";
	parent.document.getElementById("icentro").style.height="780px";	
 
	function enviar(){			
		document.autorizacion.action="autorizacion.php";
		document.autorizacion.submit();
								
    }
	function enviar2(pag){     	
		if(pag >= 26)
		{alert("Atención!\nDebido al volumen del resultado en su consulta, esta información será exportada directamente a un archivo de Excel");}
		//document.autorizacion.action="../func_php/imresulauto.php";
		document.autorizacion.submit();
	}
	
	function enviarr(){
		document.autorizacion.action="inautorizacion.php";
		document.autorizacion.submit();
	}

	function enviar22(pag){
       	document.autorizacion.pagina.value=pag;
		document.autorizacion.action="autorizacion.php";
		document.autorizacion.submit();
		return true;
	}	
	
	function valor(){
		value=document.getElementById('user').value;
		if (value=='0')
		{alert("Seleccione un Usuario");
		document.getElementById('user1').value="";
		}
		else{
		document.getElementById('user1').value=document.getElementById('user').value;	
		}
	}
-->
</script>
	
<link rel="stylesheet" type="text/css" href="../otros/jquery.autocomplete.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="../otros/style.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="../otros/datePicker.css"/>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	background-image: url(../images/fondo.gif);
}

.Estilo55 {
	color: #FFF;
	font-size:12px;
	font-family: Tahoma;
	font-weight: bold;	
	}
a {
	color:#FFF;
}
.Estilo56 {
	color: #FC0;
	font-size:16px;
	font-family: Tahoma;
	font-weight: bold;
}
.Estilo57 {font-size: 12px}
.Estilo58 {
	color: #333;
	font-size:11px;
	font-family: Tahoma;	
	font-weight: bold;	
}
-->
</style>
</head>

<body>
<div id="page">
<div id="content">
<div class="post" style="background-repeat:repeat; background-image:url(../images/fondo.gif)"> 
<h2 class="title">ADMINISTRACIÓN DE SOLICITUDES -  <?php echo $user ?></h2>
<br />
<form method="post" action="autorizacion.php" name="autorizacion" target="_self" id="autorizacion">
<div align="center">
<input name="principal" type="button" class="botones" id="principal" value="Ir a Pagina Principal" onclick="location.href='inicontenido.php'"/>
<input name="principal2" type="button" class="botones" id="principal2" value="REGRESAR" onclick="location.href='solicitud.php?registro=$registro[COD_LOGIN]'"/>
</div>
<br />
<?php

$sql1 = "SELECT REQUISICION.RE_DIRECTAS, REQUISICION.COD_REQUISICION,REQUISICION.RE_FECHA,REQUISICION.RE_OBSERVACIONES,REQUISICION.COD_ESTADO,
(SELECT LOGIN.LO_USERNAME FROM LOGIN WHERE COD_LOGIN = REQUISICION.COD_LOGIN_CREA) AS LOGIN_CREA,
(SELECT LOGIN.COD_LOGIN  FROM LOGIN WHERE COD_LOGIN = REQUISICION.COD_LOGIN_CREA) AS COD_LOGIN_CREA 
FROM REQUISICION 
WHERE COD_REQUISICION = $cod_item";
//echo $sql1;
  $rst1 = oci_parse($con, $sql1);
  if (!$rst1) {
    $e = oci_error($con);
    print htmlentities($e['message']);
    exit;
  }

  $r = oci_execute($rst1, OCI_DEFAULT);
  if (!$r) {
    $e = oci_error($rst1);
    echo htmlentities($e['message']);
    exit;
  }
  
  $row = oci_fetch_array($rst1, OCI_ASSOC);
  
	echo "<tr> ";
	$RE_FECHA=$row['RE_FECHA'];
	echo "<tr> ";
	$COD_REQUISICION=$row['COD_REQUISICION'];
	echo "<tr> ";
	$RE_OBSERVACIONES=$row['RE_OBSERVACIONES'];
	echo "<tr> ";
	$login_crea=$row['LOGIN_CREA'];
	$cod_login_crea=$row['COD_LOGIN_CREA'];


 	 echo "<table width='600' align='center' border='0'>";
  echo "<tr>";
    echo "<td class='Estilo58'><label>CÓDIGO PEDIDO: </label></td><td><strong>".$row['COD_REQUISICION']."</strong></td>";    
    echo "<td class='Estilo58'><label>USUARIO: </label></td><td><strong>".$login_crea."</strong></td>";
  echo "</tr>";
  echo "<tr>";
    echo "<td class='Estilo58'><label>FECHA PEDIDO: </label></td><td><strong>".$RE_FECHA."</strong></td>";   
    echo"<td class='Estilo58' ><label>OBSERVACIONES: </label></td><td width='200px'><strong>".$RE_OBSERVACIONES."</strong></td>";	
  echo"</tr>";
 
echo "</table>";
	
	if($row['COD_ESTADO']==4) /// solicitud revisada
	{
	$hql="UPDATE REQUISICION SET REQUISICION.COD_ESTADO=5 WHERE REQUISICION.COD_REQUISICION=$COD_REQUISICION";
	$hqls="UPDATE DET_REQUISICION SET DET_REQUISICION.DR_ESTADO=5 WHERE DET_REQUISICION.COD_REQUISICION=$COD_REQUISICION";

    $stid = oci_parse($con, $hql);	
	oci_execute($stid, OCI_DEFAULT);
	oci_commit($con);
	
	$stids = oci_parse($con, $hqls);	
	oci_execute($stids, OCI_DEFAULT);
	oci_commit($con);
	
    oci_free_statement($stid); ////// grabo en el historial que la solicitud fue revisada
 	$hqls="INSERT INTO HISTORIAL (HI_FECHA, COD_LOGIN, LO_USERNAME, HI_CODIGO, COD_TIPO, COD_ESTADO) VALUES (sysdate, $registro, '$user', $COD_REQUISICION, 1, 5)";
    $stid = oci_parse($con, $hqls);	
	oci_execute($stid, OCI_DEFAULT);
	oci_commit($con);	
	}

?>

<table width="790" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<tr>
	<td height="25" colspan="4" bgcolor="#444444"><div align="center" class="Estilo56">DETALLE DE SOLICITUD</div>
    </td>
</tr>
<tr>
	  
    <td width="80px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">CATEGORÍA</div>
    </td>
        
	<td width="416px" height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">DESCRIPCION ÍTEM</div>
    </td>
    
    <td width="250px" height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">OBSERVACIÓN</div>
    </td>
    
	<td width="44px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">CANT.</div>
    </td>
        
</tr>

<?php
			
	$sql = "SELECT COD_DET_REQUISICION,COD_REQUISICION,COD_ITEM,DR_OBSERVACION,DR_CANTIDAD,DR_CONFIRMADOS,DR_ESTADO,DR_ORDEN,
    (SELECT CATEGORIA.CA_PREFIJO FROM CATEGORIA WHERE CATEGORIA.COD_CATEGORIA = DET_REQUISICION.COD_CATEGORIA) AS CATEGORIA, 
    (SELECT ITEM.IT_NOMBRE FROM ITEM WHERE ITEM.COD_ITEM = DET_REQUISICION.COD_ITEM) AS NOMBRE_ITEM, 
    (SELECT ES_NOMBRE FROM ESTADOS WHERE ESTADOS.COD_ESTADO = DET_REQUISICION.DR_ESTADO AND ESTADOS.COD_TIPO = 1) AS ES_NOMBRE 
FROM DET_REQUISICION
WHERE COD_REQUISICION=$cod_item 
ORDER BY DR_ORDEN ASC";
	//echo $sql;
  $rst = oci_parse($con, $sql);
  if (!$rst) {
    $e = oci_error($con);
    print htmlentities($e['message']);
    exit;
  }

  $r = oci_execute($rst, OCI_DEFAULT);
  if (!$r) {
    $e = oci_error($rst);
    echo htmlentities($e['message']);
    exit;
  }
       
  	while ($row = oci_fetch_array($rst, OCI_ASSOC)) {
    
	echo "<tr> ";
	echo "<td bgcolor='#FFFFFF' width='80px' align='center' class='Estilo58'>".$row['CATEGORIA']."</td>";
	echo "<td bgcolor='#FFFFFF' width='416px' class='Estilo58'>".$row['NOMBRE_ITEM']."</td>";
	echo "<td bgcolor='#FFFFFF' width='250px' class='Estilo58'>".$row['DR_OBSERVACION']."</td>";
	echo "<td bgcolor='#FFFFFF' width='44px' align='center' class='Estilo58'>".$row['DR_CANTIDAD']."</td>";			
	
	$COD_REQUISICION=$row['COD_REQUISICION'];		
		
  }
  
 //echo $COD_REQUISICION;
  
 //oci_close($con);
	
?>

<br />
			
<tr>

    <td width="110" height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">Usuario Tramita:</div>
    </td>
    <td colspan="3" bgcolor="#FFFFFF">

<?php 	

	$cons="select cod_login,lo_nombre from login where lo_tramita=1 order by lo_nombre asc";
 	$rstcl = oci_parse($con, $cons);
	oci_execute($rstcl)or die("Ocurri&oacute; un error ");	
					
	echo "<select name='user' id='user' onchange='valor();' class='Estilo58'>";
	echo "<option value='0' class='date'>SELECCIONE: </option>";
	while ($registro = oci_fetch_array($rstcl, OCI_ASSOC)){
	echo "<option value='".$registro['COD_LOGIN']."'>".$registro['LO_NOMBRE']."</option>";
	
	}
	
	echo "</select>";
	
	echo "<input name='user1' id='user1' type='hidden'><input name='user2' id='user2' type='hidden' value=$cod_login_crea></td>";
					
?>

    </td>
</tr>
<tr>
  <td height="25" bgcolor="#626262" class="date1" ><div align="center" class="Estilo55">Raz&oacute;n Negar</div></td>
  <td bgcolor="#FFFFFF" ><input name="razon" type="text" id="razon" size="50" class="Estilo58"/></td><td colspan="2" bgcolor="#FFFFFF" ><div align="center" style="vertical-align:middle"> <a href="javascript:;" onclick="javaScript:envia_pagnega(this);"><img  src='../images/boton5.png' title='NEGAR' /></a></div></td>  
</tr>
 
<tr>

	<td height="25" colspan="4" bgcolor="#FFFFFF" class="date1 Estilo55">
    	<div align="center">

<?php //       echo "<input name='autorizar' id='autorizar' type='submit' value='AUTORIZAR' onclick='location.href=autorizacion.php?ban=1&cod=$COD_PEDIDO'>"; ////NO vale con input y boton submit ?>

    <a href="javascript:;" onclick="javaScript:envia_pag(this);"><img  src='../images/boton1.png' width='101' height='25' border='0' title='PREAUTORIZAR'/></a>
<script language="JavaScript" type="text/javascript">
			function envia_pag(obj){
			var ban=1;
			var cod=<?php echo $COD_REQUISICION;?>;
			var cod_login_crea= document.getElementById("user2").value;
			var cod_login_recibe= document.getElementById("user1").value;
			var url = "solicitud.php?ban="+ ban + "&cod="+ cod +"&cod_login_crea="+ cod_login_crea +"&cod_login_recibe="+ cod_login_recibe;
			if (document.getElementById("user").value==0)
			{ alert("Para poder preautorizar el pedido debe escojer el usuario que tramita");}
			   else{obj.href=url;}
			}
			function envia_pagnega(obj){
			var ban=6;
			var cod=<?php echo $COD_REQUISICION;?>;
			var razon= document.getElementById("razon").value;
			var url = "solicitud.php?ban="+ ban + "&cod="+ cod +"&razon="+ razon;
			if (document.getElementById("razon").value=="")
			{ alert("Para poder negar la solicitud debe indicar la razon para negar");}
			   else{obj.href=url;}
			}
		</script>


		</div>       		
    </td>
    
</tr>

</table>
<br />

<div align="center"><br /></div>
</form>
</div>                  				  
</div>
</div>
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