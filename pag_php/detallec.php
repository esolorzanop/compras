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
	
	$pas=isset($_GET["pas"]) ? $_GET["pas"]:0;
	
	$cod_pedido=isset($_GET['cod_pedido']) ? $_GET['cod_pedido']:NULL ;
	$cod_item=isset($_GET['cod_cotizacion']) ? $_GET['cod_cotizacion']:NULL ;   

	$coditem ="";
	$coditem = explode("?", $cod_item);

  // echo $coditem[0];
  // echo $coditem[1];

//   var_dump($coditem);
   
	   $_SESSION['obsap'] = "";
	   $_SESSION['obsap'] = str_replace(","," ",end($coditem));  

	if ($coditem[0] == $_SESSION['obsap'])
	{$_SESSION['obsap']="";}
   
//   echo "<br><br>".$codvalue."<br>".$_SESSION['obsap'];

/////////////////////////////////////////////
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TEVCOL - SISTEMA DE COMPRAS</title>
<script language="javascript" type="text/javascript" src="../otros/jquery-1.5.1.js"></script>
<script language="javascript" type="text/javascript" src="../otros/jquery.autocomplete.pack.js"></script>
<script language="javascript" type="text/javascript" src="../otros/jquery.bgiframe.min.js"></script>
<script language="javascript" type="text/javascript" src="../otros/date.js"></script>
<script language="javascript" type="text/javascript" src="../otros/jquery.datePicker.js"></script>
<script type="text/javascript">
<!--
$(function()
{
    $('.date-pick').datePicker({clickInput:true, startDate: '21/11/2011', buttonImage: '../images/calendar.png', buttonImageOnly: true});
	$('#start-date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#end-date').dpSetStartDate(d.addDays(0).asString());
			}
		}
	);
	$('#end-date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#start-date').dpSetEndDate(d.addDays(1).asString());
			}
		}
	);
});
//-->
</script>

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
-->
	function valorap()
	{
		//alert(document.getElementById("razonap").value.split("\n"));
			var obsap = document.getElementById("razonap").value.split("\n");	
			 window.location.href = window.location.href + "?" + obsap;
					
		}

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
/*a {
	color:#FFF;
}*/
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
<h2 class="title">ADMINISTRACIÓN DE COTIZACI&Oacute;N -  <?php echo $_SESSION['user']; ?></h2>
<br />
<form method="post" action="autorizacion.php" name="autorizacion" target="_self" id="autorizacion">
<div align="center">
<input name="principal" type="button" class="botones" id="principal" value="Ir a Pagina Principal" onclick="location.href='inicontenido.php'"/>
<?php if ($pas <> 10){ ?>
<input name="principal2" type="button" class="botones" id="principal2" value="REGRESAR" onclick="location.href='pedidos.php?cod_pedido=<?php echo $cod_pedido;?>'"/>
<?php }else{ ?>
<input name="principal2" type="button" class="botones" id="principal2" value="REGRESAR" onclick="location.href='confpedidos.php?cod_pedido=<?php echo $cod_pedido;?>'"/>
<?php } ?>
</div>

<br />

<?php

//$sql1 = "SELECT PEDIDO.COD_PEDIDO,PEDIDO.PE_FECHA,PEDIDO.PE_OBSERVACIONES,PEDIDO.PE_USERCREA,PEDIDO.PE_ESTADO, pedido.PE_DIRECTAS, (SELECT LOGIN.LO_USERNAME FROM LOGIN WHERE LOGIN.COD_LOGIN = PEDIDO.COD_LOGIN_AUTORIZA) pre FROM PEDIDO WHERE COD_PEDIDO = $cod_pedido ORDER BY PE_FECHA DESC";

	$sql1 = "select cod_cotizacion, co_fecha, (SELECT PR.RAZO_SOCI_INVE_PROV FROM VIEW_PROVEEDORES PR WHERE PR.CODI_INVE_PROV = COTIZACION.CODI_INVE_PROV) AS PROVEEDOR,co_subtotal,co_observaciones,
 DECODE(COTIZACION.CO_RECOMENDADA,1,'SI','') CO_RECOMENDADA,   (SELECT LOGIN.LO_USERNAME FROM LOGIN WHERE LOGIN.COD_LOGIN = COTIZACION.COD_LOGIN_RECIBE) AS CO_RECIBE, 
    (SELECT FP_DESCRIPCION FROM FORMAPAGO WHERE FORMAPAGO.COD_FORMAPAGO = COTIZACION.COD_FORMAPAGO) AS FP_DESCRIPCION
  from cotizacion where cod_cotizacion = $cod_item";
	
//echo $sql1 ;
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
  
 // $AUTORIZA=isset($row['PRE']) ? $row['PRE']:NULL;  
  
	$CO_FECHA=$row['CO_FECHA'];
	$CO_OBSERVACIONES=$row['CO_OBSERVACIONES'];	
/*echo "<tr> ";
	echo "<tr> ";
	//$COD_COTIZACION=$row['COD_COTIZACION'];
	echo "<tr> ";
	echo "<tr> ";
	$PE_USERCREA=$row['PE_USERCREA'];*/

  echo "<table width='650px' bgcolor='#FFFFFF' align='center' border='0'>";
  echo "<tr>";
    echo "<td class='Estilo58' width=25%><label>CÓDIGO COTIZACIÓN: </label></td><td width=25%><strong>".$row['COD_COTIZACION']."</strong></td>";    
    echo "<td class='Estilo58' width=25%><label>FECHA COTIZACIÓN: </label></td><td width=25%><strong>".$CO_FECHA."</strong></td>";   
  echo "</tr>";

  echo "<tr>";
    echo "<td class='Estilo58'><label>PROVEEDOR: </label></td><td colspan='3'><strong>".$row['PROVEEDOR']."</strong></td>";	
  echo "</tr>";

  echo "<tr>";
    echo "<td class='Estilo58'><label>SUB-TOTAL COTIZACIÓN: </label></td><td><strong>".number_format($row['CO_SUBTOTAL'],2)."</strong></td>";
    echo "<td class='Estilo58'><label>FORMA DE PAGO: </label></td><td><strong>".$row['FP_DESCRIPCION']."</strong></td>";	
  echo "</tr>";
  
  echo "<tr>";
    echo "<td class='Estilo58'><label>USUARIO RECIBE: </label></td><td><strong>".$row['CO_RECIBE']."</strong></td>";	
    echo "<td class='Estilo58'><label>COTIZACIÓN RECOMENDADA: </label></td><td><strong>".$row['CO_RECOMENDADA']."</strong></td>";	
  echo"</tr>"; 
  
  echo "<tr>";
    echo"<td class='Estilo58' colspan=4><label>OBSERVACIONES COTIZACIÓN </label></td>";	
  echo"</tr>"; 
  
  echo "<tr>";
    echo"<td colspan=4><strong>".$CO_OBSERVACIONES."</strong></td>";	
  echo"</tr>"; 
  
echo "</table>";

?>

<table width="790" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">       
<tr>
	<td height="25" colspan="8" bgcolor="#444444"><div align="center" class="Estilo56">DETALLE DE LA COTIZACIÓN</div>
    </td>
</tr>
<tr>
	  
    <td width="220px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">NOMBRE CATEGORIA</div>
    </td>
        
	<td width="346px" height="25" bgcolor="#626262" class="date"><div align="center" class="Estilo55">DESCRIPCION ÍTEM</div>
    </td>
    
	<td width="54px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">Cantidad Solicitada</div>
    </td>
    
    <td width="54px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">Cantidad Cotizada</div>
    </td>
    
    <td width="52px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">V. UNIT</div>
    </td>
    
    <td width="64px" bgcolor="#626262" class="date"><div align="center" class="Estilo55">V. TOTAL</div>
    </td>
  
</tr>

<?php
			
	$sql = "SELECT DC_ESTADO,COD_CATEGORIA, (SELECT CATEGORIA.CA_NOMBRE FROM CATEGORIA WHERE CATEGORIA.COD_CATEGORIA = DET_COTIZACION.COD_CATEGORIA) AS CA_NOMBRE,COD_ITEM, (SELECT ITEM.IT_NOMBRE FROM ITEM WHERE ITEM.COD_ITEM = DET_COTIZACION.COD_ITEM) AS IT_NOMBRE,DC_OBSERVACION,DC_CANTIDAD,DC_CANTCOTIZADA,DC_VUNITARIO,DC_TIENE_IVA,DC_VTOTAL,COD_PEDIDO,COD_DET_PEDIDO,COD_DET_COTIZACION FROM DET_COTIZACION WHERE COD_COTIZACION =$coditem[0] ORDER BY COD_DET_COTIZACION ASC";
	
//	echo $sql;
	
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
			
    $var = number_format($row['DC_VUNITARIO'],2);
	$a = number_format($row['DC_CANTCOTIZADA']*$row['DC_VUNITARIO'],2);
//	$a = number_format($row['DC_CANTCOTIZADA']*$var,2);
	
	echo "<tr> ";
	echo "<td bgcolor='#FFFFFF' width='220px' class='Estilo58' align='center'>".$row['CA_NOMBRE']."</td>";
	echo "<td bgcolor='#FFFFFF' width='346px' class='Estilo58' align='center'><a href=\"bus_hisp.php?cod_item=".$row['COD_ITEM']."\" target=\"_blank\" onclick=\"window.open(this.href,this.target,'width=800,height=650');return false;\">".$row['IT_NOMBRE']."</a></td>";
	echo "<td bgcolor='#FFFFFF' width='54px' align='center' class='Estilo58'>".$row['DC_CANTIDAD']."</td>";
	echo "<td bgcolor='#FFFFFF' width='54px' align='center' class='Estilo58'>".$row['DC_CANTCOTIZADA']."</td>";
	echo "<td bgcolor='#FFFFFF' width='52px' class='Estilo58' align='right'>".$var."</td>";
	echo "<td bgcolor='#FFFFFF' width='64px' class='Estilo58' align='right'>".$a."</td>";
	
	$COD_CATEGORIA=$row['COD_CATEGORIA'];	
		
  }
 //echo 	$COD_CATEGORIA; 
 oci_close($con);
	
?>

<br />			
<?php if ($pas <> 10){ ?>	
<tr>
 <td height="25" bgcolor="#626262" class="date1" colspan="1"><div align="center" class="Estilo55">Observación de aprobación</div></td> 
  <td bgcolor="#FFFFFF" colspan="7"><textarea name="razonap" cols="50" rows="3" id="razonap" onblur="valorap();" ><?php echo $_SESSION['obsap']; ?></textarea></td>
   </tr>
<?php } ?>   
   <tr>
	<td height="25" colspan="8" bgcolor="#FFFFFF" class="date1 Estilo55">
<br />
    	<div align="center">
<?php   
if ($pas <> 10){ 
echo "<a href='pedidos.php?ban=2&cod_pedido=$cod_pedido&cod_cotiza=$coditem[0]' class='submenu'><img src='../images/boton.png' width='101' height='25' border='0' title='AUTORIZAR'/></a>";
}


?>
</div>
<br />
<div  class='Estilo58' align="center">
* Para ver un historial de variación de precios, por favor haga click en el nombre de ítem desplegado en la columna DESCRIPCIÓN ÍTEM
</div>       		
    </td>
</tr>
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