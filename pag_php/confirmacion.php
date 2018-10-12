<?php
    	session_start();
		date_default_timezone_set('America/Guayaquil');	
////////////////////////// paginacion//////////////////////////////////
		 $pagina=0;
		 $pagina=isset($_GET["pagina"]) ? $_GET["pagina"]:NULL;
		 $registros = 2;
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
	$cod_user = $_SESSION['cod_user'];
	$confirma = $_SESSION['confirma'];//$aprueba=$_SESSION['aprueba'];
	$hql = NULL;
	$hqlt = NULL;
	
	if ($confirma == 1)
	{
	$condicion = "(COD_LOGIN_DIRIGIDO = $cod_user AND PE_ESTADO IN (10))"; //cotizados
	}
	
	$con = conectar();	
	$actu = isset($_REQUEST["ban"]) ? $_REQUEST["ban"]:0;
	$cod = isset($_REQUEST["cod"]) ? $_REQUEST["cod"]:0;
	$razon = isset($_REQUEST["razon"]) ? $_REQUEST["razon"]:0;
	$cod_cotiza = isset($_REQUEST["cod_login_cotiza"]) ? $_REQUEST["cod_login_cotiza"]:0;
	
	/*if($actu == 1){   // pedido autorizado y con cotizador asignado
	$hql = "UPDATE PEDIDO SET PEDIDO.PE_ESTADO = 6, PEDIDO.COD_LOGIN_AUTORIZA=$cod_user, PEDIDO.COD_LOGIN_DIRIGIDO=$cod_cotiza WHERE (PEDIDO.PE_ESTADO = 4 or PEDIDO.PE_ESTADO = 5) AND PEDIDO.COD_PEDIDO = $cod";
//	echo $hql;

	$hqlt = "INSERT INTO HISTORIAL (HI_FECHA, COD_LOGIN, LO_USERNAME, HI_CODIGO, COD_TIPO, COD_ESTADO, COD_LOGIN_2, LO_USERNAME_2) VALUES (sysdate, $cod_user, (select lo_username from login where cod_login=$cod_user),  $cod ,  2 ,  6,  $cod_cotiza, (select lo_username from login where cod_login=$cod_cotiza))"; //registro en el log	
	} */
	
	if($actu == 3){   // pedido y cotizaciones CONFIRMADO
	$hql = "UPDATE PEDIDO SET PEDIDO.PE_ESTADO = 101, COD_LOGIN_CONFIRMA = $cod_user WHERE PEDIDO.COD_PEDIDO = $cod";
	$hqlc = "update cotizacion set co_estado = 41, COD_LOGIN_CONFIRMA = $cod_user WHERE cod_pedido = $cod";
	$hqlt = "INSERT INTO HISTORIAL (HI_FECHA, COD_LOGIN, LO_USERNAME, HI_CODIGO, COD_TIPO, COD_ESTADO) VALUES (sysdate, $cod_user , (select lo_username from login where cod_login=$cod_user), $cod, 2, 101)";	
	}
	/*
	if($actu == 9){   // pdeido negado
	$hql = "UPDATE PEDIDO SET PEDIDO.PE_ESTADO = 8,PEDIDO.PE_RAZON='$razon' WHERE PEDIDO.COD_PEDIDO = $cod";
	$hqlt = "INSERT INTO HISTORIAL (HI_FECHA, COD_LOGIN, LO_USERNAME, HI_CODIGO, COD_TIPO, COD_ESTADO) VALUES (sysdate, $cod_user , (select lo_username from login where cod_login=$cod_user), $cod, 2, 8)";}	*/

	if($actu == 19){   // pdeido no CONFIRMADO
	$hql = "UPDATE PEDIDO SET PEDIDO.PE_ESTADO = 102,COD_LOGIN_CONFIRMA = $cod_user ,PEDIDO.PE_RAZON_NOCONFIRMA='$razon' WHERE PEDIDO.COD_PEDIDO = $cod";
	$hqlc = "update cotizacion set co_estado = 42, COD_LOGIN_CONFIRMA = $cod_user WHERE cod_pedido = $cod";	
	$hqlt = "INSERT INTO HISTORIAL (HI_FECHA, COD_LOGIN, LO_USERNAME, HI_CODIGO, COD_TIPO, COD_ESTADO) VALUES (sysdate, $cod_user , (select lo_username from login where cod_login=$cod_user), $cod, 2, 102)";}	

	$stid = oci_parse($con,$hql);
	oci_execute($stid, OCI_DEFAULT);
	oci_commit($con);

	$stidc = oci_parse($con, $hqlc);	
	oci_execute($stidc, OCI_DEFAULT);
	oci_commit($con);	

	$stidt = oci_parse($con, $hqlt);	
	oci_execute($stidt, OCI_DEFAULT);
	oci_commit($con);	
	
//echo $hql;
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
	document.confirmacion.action="confirmacion.php";
	document.confirmacion.submit();								
    }	
	function enviar2(pag){     	
		if(pag >= 26)
		{alert("Atención!\nDebido al volumen del resultado en su consulta, esta información será exportada directamente a un archivo de Excel");}
		//document.confirmacion.action="../func_php/imresulauto.php";
		document.confirmacion.submit();
	}	
	function enviarr(){
		document.confirmacion.action="inautorizacion.php";
		document.confirmacion.submit();
	}
	function enviar22(pag){
       	document.confirmacion.pagina.value=pag;
		document.confirmacion.action="confirmacion.php";
		document.confirmacion.submit();
		return true;
	}
</script>
<link rel="stylesheet" type="text/css" href="../otros/jquery.autocomplete.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="../otros/style.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="../otros/datePicker.css"/>
<style type="text/css">
body {
	background-color: #FFF;
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
</style>
</head>
<body>
<div id="page">
<div id="content">
<div class="post" style="background-repeat:repeat; background-image:url(../images/fondo.gif)"> 
<h2 class="title">ADMINISTRACIÓN DE PEDIDOS - <?php echo $_SESSION['user']; ?></h2>
<br />
<form method="post" name="confirmacion" target="_self" id="confirmacion" action="confirmacion.php">
<div align="center">
<input name="principal" type="button" class="botones" id="principal" value="Ir a Pagina Principal" onclick="location.href='inicontenido.php'"/>
<input name="actualizar" type="button" class="botones" id="actualizar" value="Actualizar Datos" onclick="location.href='confirmacion.php'"/>
</div><br />          
<table width="790" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<tr>
	<td height="25" colspan="9" bgcolor="#444444" ><div align="center" class="Estilo56">CONFIRMACIONES DE PEDIDOS</div></td>   
</tr>
<tr height="25">
	<td width="70px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">FECHA</div></td>
    <td width="70px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">N°PEDIDO</div></td>    
    <td width="75px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">USUARIO SOLICITA</div></td>
    <td width="80px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">USUARIO PRE-AUTORIZA</div></td>
    <td width="270px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">OBSERVACIONES</div></td>
    <td width="75px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">COMPRA DIRECTA</div></td>    
    <td width="70px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">ESTADO</div></td> 
<?php 
echo "<td width=80px bgcolor=#626262 class=date colspan=2><div align=center class=Estilo55>ACCIÓN</div></td> ";
?>
</tr>
<?php
	$sql1="SELECT (SELECT ESTADOS.ES_NOMBRE FROM ESTADOS WHERE ESTADOS.COD_TIPO = 2 AND ESTADOS.COD_ESTADO = PEDIDO.PE_ESTADO) AS ESTADO, (SELECT LOGIN.LO_USERNAME FROM LOGIN WHERE LOGIN.COD_LOGIN = PEDIDO.COD_LOGIN_DIRIGIDO) AS ASIGNADO,(SELECT LOGIN.LO_USERNAME FROM LOGIN WHERE LOGIN.COD_LOGIN = PEDIDO.COD_LOGIN_AUTORIZA) AS AUTORIZA, PEDIDO.* FROM PEDIDO  WHERE $condicion ORDER BY PE_FECHA DESC, COD_PEDIDO DESC";  
//echo $sql1 ;
	$a = oci_parse($con, $sql1);
	if (!$a) {
    $e = oci_error($con);
    print htmlentities($e['message']);
    exit;
  	}  
  	$s = oci_execute($a, OCI_DEFAULT);
  	if (!$s) {
    $e = oci_error($a);
    echo htmlentities($e['message']);
    exit;
  	}		
	echo "<form action='confirmacion.php' method='post'>";
  	while ($row = oci_fetch_array($a, OCI_ASSOC)){	 
		$AUTORIZA=isset($row['AUTORIZA']) ? $row['AUTORIZA']:"SIN AUTORIZAR";	
	echo "<tr>";
	echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".$row['PE_FECHA']."</td>";
	echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".$row['COD_PEDIDO']."</td>";
	echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".$row['PE_USERCREA']."</td>";
	echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".$AUTORIZA."</td>";		
	echo "<td bgcolor='#FFFFFF' class='Estilo58' >".$row['PE_OBSERVACIONES']."</td>";
	if ($row['PE_DIRECTAS']==1){				
		echo "<td bgcolor='#01DF01' class='Estilo58' align='center'>SI</td>";	
	}
	else
	{				
		echo "<td bgcolor='#FF0000' class='Estilo58' align='center'>NO</td>";	
	}
	echo "<td bgcolor='#FFFFFF' class='Estilo58' align='center'>".$row['ESTADO']."</td>";	
//	$row['AUTORIZAR']=isset($row['AUTORIZAR']) ? $row['AUTORIZAR']:0;
	if ($confirma==1){			
	echo "<td bgcolor='#FFFFFF'><a href='confpedidos.php?cod_pedido=$row[COD_PEDIDO]' class='submenu'><img src='../images/boton7.png' width='90' height='25' border='0' title='CONFIRMAR'/></a></td>";					
	}	
	else{			
	echo "<td bgcolor='#FFFFFF' align='center'></td>";					
	}	
	echo "</tr>";	
  }	
	echo "</form>";
  	oci_close($con);
?>			
</table>
<br />
</form>  
</div>                  				  
</div>
</div>
<script language="JavaScript" type="text/javascript">
	var message="";
	function clickIE() {if (document.all) {(message);return false;}}
	function clickNS(e) {if 
	(document.layers||(document.getElementById&&!document.all)) {
	if (e.which==2||e.which==3) {(message);return false;}}}
	if (document.layers) 
	{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
	else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
	document.oncontextmenu=new Function("return false");
</script>
</body>
</html>