<?php
    	session_start();
/*		$cod_user=$_SESSION['cod_user'];
		$user=$_SESSION['user'];*/

    include("../func_php/lib.php");
	$con=conectar();
	
	$pas=isset($_GET["pas"]) ? $_GET["pas"]:0;
	
	$id_prov=isset($_REQUEST["id"]) ? $_REQUEST["id"]:0;
	$codped=isset($_REQUEST["ped"]) ? $_REQUEST["ped"]:0;
/*	$cod_item=isset($_GET['cod_pedido']) ? $_GET['cod_pedido']:NULL ;
    $cod_cotiza=isset($_GET['cod_cotiza']) ? $_GET['cod_cotiza']:NULL ;*/
	
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
	parent.document.getElementById("icentro").style.height="850px";	

	function nuevop(){     	
	document.getElementById('autorizado').value="<?php echo $valor; ?>";
		if(document.getElementById('autorizado').value=="noautorizado")
		{
			var coti=<?php echo isset($cod_cotiza) ? $cod_cotiza:0; ?>;
			alert("Atención \nEl usuario actual no tiene el nivel de aprobación suficiente para la cotización "+ coti +"\nPor favor verifique e intente de nuevo");}
	}

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

<body onload="nuevop();">
<div id="page">
<div id="content">
<div class="post" style="background-image:url(../images/fondo.gif)"> 
<h2 class="title">ADMINISTRACIÓN DE PEDIDOS -  <?php echo $_SESSION['user']; ?></h2>
<br />
<form method="post" action="autorizacion.php" name="autorizacion" target="_self" id="autorizacion">
<div align="center">
  <label for="autorizado"></label>
  <input name="autorizado" type="hidden" id="autorizado" value="" />
<input name="principal" type="button" class="botones" id="principal" value="Ir a Pagina Principal" onclick="location.href='inicontenido.php'"/>
<!--<input name="principal2" type="button" class="botones" id="principal2" value="REGRESAR" onclick="location.href='pedidos.php?cod_pedido='+<?php //echo $codped; ?>"/> -->
<?php if ($pas <> 10){ ?>
<input name="principal2" type="button" class="botones" id="principal2" value="REGRESAR" onclick="location.href='pedidos.php?cod_pedido=<?php echo $codped;?>'"/>
<?php }else{ ?>
<input name="principal2" type="button" class="botones" id="principal2" value="REGRESAR" onclick="location.href='confpedidos.php?cod_pedido=<?php echo $codped;?>'"/>
<?php } ?>
</div>

<br />
<?php
			
	$sql1 = "SELECT * FROM (
SELECT P.RAZO_SOCI_INVE_PROV PROVEEDOR, I.FECH_INVE_DOCU , I.CODI_INVE_DOCU CODIGO_DOCUMENTO, NOMB_INVE_TIPO_DOCU TIPO_DOCUMENTO,
I.IMPO_NETO_INVE_DOCU VALOR,COME_INVE_DOCU DETALLE, (select ci.ci_nombre from ATRANSVAL.ciudad ci where ci.cod_ciudad = CENT_COST_DOCU) SUCURSAL, CENT_COST_AUX_DOCU SERVICIO
FROM inter.INVE_DOCUMENTOS_DAT I, inter.INVE_PROVEEDORES_DAT P, inter.INVE_TIPOS_DOCUMENTOS_REF T
WHERE I.CODI_ADMI_EMPR_FINA=P.CODI_ADMI_EMPR_FINA
AND I.CODI_INVE_PROV=P.CODI_INVE_PROV
AND I.CODI_ADMI_EMPR_FINA=T.CODI_ADMI_EMPR_FINA
AND I.CODI_INVE_TIPO_DOCU=T.CODI_INVE_TIPO_DOCU
AND I.CODI_ADMI_ESTA IN ('P','O')
AND ASOC_INVE_TIPO_DOCU = 'P'
AND CLAS_INVE_TIPO_DOCU IN (2)
AND I.CODI_INVE_PROV = $id_prov
ORDER BY I.FECH_INVE_DOCU  DESC)
WHERE rownum between 1 and 10";
	
//echo $sql1; 	

  $rst1 = oci_parse($con, $sql1);
  if (!$rst1) {
    $e1 = oci_error($con);
    print htmlentities($e1['message']);
    exit;
  }

  $r = oci_execute($rst1, OCI_DEFAULT);
  if (!$r) {
    $e1 = oci_error($rst1);
    echo htmlentities($e1['message']);
    exit;
  }
	$estado=isset($estado) ? $estado:0;
	$cotizacion=isset($cotizacion) ? $cotizacion:0;
	
	$cont = 0;        
	
  	while ($row = oci_fetch_array($rst1, OCI_ASSOC)) {
    
	$var= number_format($row['VALOR'],2);

	if ($cont == 0)
	{
			$cont++;
	?>

<table width="790" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<tr>
	<td height="25" colspan="4" bgcolor="#444444"><div align="center" class="Estilo56">HISTORIAL DE COMPRAS POR PROVEEDOR</div>
    </td>
</tr>
<tr>
    <td width="85" bgcolor="#626262" class="date"><div align="center" class="Estilo55">PROVEEDOR: </div>
	<td height="25" colspan="3" bgcolor="#ffffff"><div align="left" class="Estilo58">&nbsp;&nbsp;<?php echo $row['PROVEEDOR']; ?></div>
    </td>
</tr>
<tr>
	  
    <td width="85" bgcolor="#626262" class="date"><div align="center" class="Estilo55">FECHA</div>
	</td>
    
    <td width="350" bgcolor="#626262" class="date"><div align="center" class="Estilo55">DETALLE</div>
    </td>
        
	<td width="80" height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">VALOR</div>
    </td>
    
    <td width="80" height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">CENTRO COSTO</div>
    </td>

<!--    <td width="80" height="25" bgcolor="#626262" class="date1"><div align="center" class="Estilo55">SERVICIO</div> 
    </td>-->
      
</tr>

<?php
	} else{	
	echo "<tr> ";
	echo "<td bgcolor='#FFFFFF' width='80px' class='Estilo58' align='center'>".$row['FECH_INVE_DOCU']."</td>";
	echo "<td bgcolor='#FFFFFF' width='350px' class='Estilo58' align='left'>".$row['DETALLE']."</td>";
	echo "<td bgcolor='#FFFFFF' width='80px' class='Estilo58' align='center'>".$var."</td>";
	echo "<td bgcolor='#FFFFFF' width='60px' class='Estilo58' align='center'>".$row['SUCURSAL']."</td>";
//	echo "<td bgcolor='#FFFFFF' width='60px' class='Estilo58' align='center'>".$row['SERVICIO']."</td>";
	echo "</tr>";
	}
  }
	$cont = 0;
	echo "</form>";
	 oci_close($con);
?>


</table>

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